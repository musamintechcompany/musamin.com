<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use App\Events\MessageSent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ChatController extends Controller
{
    public function getConversationData($conversationId)
    {
        $user = Auth::user();
        
        $conversation = Conversation::with(['userOne', 'userTwo'])
            ->where('id', $conversationId)
            ->where(function ($query) use ($user) {
                $query->where('user_one_id', $user->id)
                      ->orWhere('user_two_id', $user->id);
            })
            ->first();

        if (!$conversation) {
            return response()->json(['success' => false, 'message' => 'Conversation not found'], 404);
        }

        // Get the other user - the one who is NOT the current user
        if ($conversation->user_one_id === $user->id) {
            $otherUser = User::where('id', $conversation->user_two_id)->first();
        } else {
            $otherUser = User::where('id', $conversation->user_one_id)->first();
        }
        $isOnline = $otherUser->last_seen_at && $otherUser->last_seen_at->diffInMinutes(now()) < 5;
        
        return response()->json([
            'success' => true,
            'otherUser' => [
                'id' => $otherUser->id,
                'name' => $otherUser->name,
                'profile_photo_url' => $otherUser->profile_photo_url,
                'is_online' => $isOnline,
                'last_seen' => $otherUser->last_seen_at ? $otherUser->last_seen_at->diffForHumans() : 'Never'
            ]
        ]);
    }

    public function index(Request $request, $conversationId = null)
    {
        $user = Auth::user();
        
        // Get all conversations for the user
        $conversations = Conversation::where('user_one_id', $user->id)
            ->orWhere('user_two_id', $user->id)
            ->orderBy('last_message_at', 'desc')
            ->get();

        // Add unread count and latest message for each conversation
        $conversations->each(function ($conversation) use ($user, $conversationId) {
            // Get the most recent message
            $latestMessage = Message::where('conversation_id', $conversation->id)
                ->orderBy('created_at', 'desc')
                ->first();
            
            // Format message based on type
            if ($latestMessage) {
                if ($latestMessage->type === 'image') {
                    $latestMessage->display_message = '📷 Photo';
                } elseif ($latestMessage->type === 'video') {
                    $latestMessage->display_message = '🎥 Video';
                } elseif ($latestMessage->type === 'voice') {
                    $latestMessage->display_message = '🎤 Voice message';
                } elseif ($latestMessage->type === 'file') {
                    $latestMessage->display_message = '📎 File';
                } else {
                    $latestMessage->display_message = $latestMessage->message;
                }
            }
            
            $conversation->latestMessage = $latestMessage;
            
            // Get actual unread message count (not just 1)
            $unreadCount = Message::where('conversation_id', $conversation->id)
                ->where('sender_id', '!=', $user->id)
                ->whereNull('read_at')
                ->count();
            
            // Don't show count if user is currently viewing this conversation
            if (isset($conversationId) && $conversation->id === $conversationId) {
                $unreadCount = 0;
            }
            
            $conversation->unread_count = $unreadCount;
        });

        // Get users for starting new conversations
        $users = User::where('id', '!=', $user->id)
            ->select('id', 'name', 'profile_photo_path')
            ->limit(50)
            ->get();

        if ($conversationId) {
            $conversation = Conversation::with(['userOne', 'userTwo'])
                ->where('id', $conversationId)
                ->where(function ($query) use ($user) {
                    $query->where('user_one_id', $user->id)
                          ->orWhere('user_two_id', $user->id);
                })
                ->first();

            if (!$conversation) {
                return redirect()->route('inbox.index');
            }

            // Get fresh conversation data directly from database
            $freshConversation = \DB::table('conversations')->where('id', $conversationId)->first();
            
            // Determine other user ID
            $otherUserId = ($freshConversation->user_one_id === $user->id) 
                ? $freshConversation->user_two_id 
                : $freshConversation->user_one_id;
            
            // Get fresh user data
            $otherUser = User::whereId($otherUserId)->first();
            
            if (!$otherUser) {
                return redirect()->route('inbox.index');
            }
            

            
            // Check if current user has blocked the other user
            $hasBlocked = $user->hasBlocked($otherUser->id);
            
            // Check if current user is blocked by the other user
            $isBlockedBy = $user->isBlockedBy($otherUser->id);
            
            // Mark messages as read and broadcast read status
            $unreadMessages = Message::where('conversation_id', $conversationId)
                ->where('sender_id', '!=', $user->id)
                ->whereNull('read_at')
                ->get();
                
            if ($unreadMessages->count() > 0) {
                Message::where('conversation_id', $conversationId)
                    ->where('sender_id', '!=', $user->id)
                    ->whereNull('read_at')
                    ->update(['read_at' => now()]);
                    
                // Broadcast read status to sender
                $otherUserId = $conversation->user_one_id === $user->id ? $conversation->user_two_id : $conversation->user_one_id;
                
                broadcast(new MessageSent(
                    $conversationId,
                    $user->id,
                    $otherUserId,
                    [
                        'type' => 'messages_read',
                        'conversation_id' => $conversationId,
                        'reader_id' => $user->id,
                        'message_ids' => $unreadMessages->pluck('id')->toArray()
                    ]
                ));
            }

            $messages = Message::where('conversation_id', $conversationId)
                ->with('sender')
                ->orderBy('created_at', 'asc')
                ->get();

            return response()
                ->view('inbox.index', compact('conversations', 'users', 'conversation', 'otherUser', 'messages', 'hasBlocked', 'isBlockedBy'))
                ->header('Cache-Control', 'no-cache, no-store, must-revalidate, max-age=0')
                ->header('Pragma', 'no-cache')
                ->header('Expires', 'Thu, 01 Jan 1970 00:00:00 GMT')
                ->header('Last-Modified', gmdate('D, d M Y H:i:s') . ' GMT')
                ->header('ETag', md5(time() . $conversationId));
        }

        return response()
            ->view('inbox.index', compact('conversations', 'users'))
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate, max-age=0')
            ->header('Pragma', 'no-cache')
            ->header('Expires', 'Thu, 01 Jan 1970 00:00:00 GMT')
            ->header('Last-Modified', gmdate('D, d M Y H:i:s') . ' GMT')
            ->header('ETag', md5(time() . 'inbox'));
    }

    public function sendMessage(Request $request, $conversationId)
    {
        $request->validate([
            'message' => 'nullable|string|max:1000',
            'file' => 'nullable|file|max:10240', // 10MB max
            'type' => 'nullable|in:text,image,video,file,voice'
        ]);

        $user = Auth::user();
        
        $conversation = Conversation::where('id', $conversationId)
            ->where(function ($query) use ($user) {
                $query->where('user_one_id', $user->id)
                      ->orWhere('user_two_id', $user->id);
            })
            ->first();

        if (!$conversation) {
            return response()->json(['success' => false, 'message' => 'Conversation not found'], 404);
        }

        $messageData = [
            'conversation_id' => $conversationId,
            'sender_id' => $user->id,
            'message' => $request->message,
            'type' => $request->type ?? 'text'
        ];

        // Create message first for instant broadcast
        $message = Message::create($messageData);
        
        // Get recipient user
        $recipientId = $conversation->user_one_id === $user->id ? $conversation->user_two_id : $conversation->user_one_id;
        $recipient = \App\Models\User::find($recipientId);
        
        // Handle file upload after message creation
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('chat-files', $fileName, 'public');
            
            // Update message with file data
            $message->update([
                'file_path' => $filePath,
                'file_name' => $file->getClientOriginalName(),
                'file_size' => $file->getSize(),
                'mime_type' => $file->getMimeType(),
                'type' => $request->type ?: ($file->getMimeType() === 'audio/wav' ? 'voice' : 'file')
            ]);
        }
        
        // Broadcast the message
        $broadcastData = [
            'id' => $message->id,
            'conversation_id' => $message->conversation_id,
            'sender_id' => $message->sender_id,
            'message' => e($message->message),
            'type' => $message->type,
            'file_path' => $message->file_path,
            'file_name' => $message->file_name,
            'file_url' => $message->getFileUrl(),
            'created_at' => $message->created_at->format('c'),
            'sender' => [
                'id' => $user->id,
                'name' => e($user->name)
            ]
        ];
        
        broadcast(new MessageSent(
            $conversation->id,
            $conversation->user_one_id,
            $conversation->user_two_id,
            $broadcastData
        ));
        
        // Send email if recipient is offline (last seen > 1 minute ago)
        if ($recipient && (!$recipient->last_seen_at || $recipient->last_seen_at < now()->subMinutes(1))) {
            \Log::info('Sending email to offline user: ' . $recipient->email . ', last seen: ' . $recipient->last_seen_at);
            \Mail::to($recipient->email)->send(new \App\Mail\NewMessageMail($message, $user, $recipient));
            \Log::info('Email sent successfully to: ' . $recipient->email);
        } else {
            \Log::info('User is online or recently active, no email sent. Last seen: ' . ($recipient->last_seen_at ?? 'never'));
        }
        
        \Log::info('Message broadcast completed');

        return response()->json([
            'success' => true,
            'message' => [
                'id' => $message->id,
                'message' => $message->message,
                'sender_id' => $message->sender_id,
                'conversation_id' => $message->conversation_id,
                'created_at' => $message->created_at->toISOString()
            ]
        ]);
    }



    public function startChat(Request $request)
    {
        $request->validate([
            'user_id' => 'required|uuid|exists:users,id'
        ]);

        $user = Auth::user();
        $otherUserId = $request->user_id;

        if ($user->id === $otherUserId) {
            return response()->json(['success' => false, 'message' => 'Cannot start conversation with yourself']);
        }

        try {
            $conversation = Conversation::findOrCreateBetween($user->id, $otherUserId);
            
            return response()->json([
                'success' => true,
                'redirect_url' => route('inbox.index', $conversation->id)
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to start conversation']);
        }
    }

    public function blockUser(Request $request)
    {
        $request->validate([
            'user_id' => 'required|uuid|exists:users,id'
        ]);

        $user = Auth::user();
        $user->blockUser($request->user_id);

        return response()->json(['success' => true, 'message' => 'User blocked successfully']);
    }

    public function unblockUser(Request $request)
    {
        $request->validate([
            'user_id' => 'required|uuid|exists:users,id'
        ]);

        $user = Auth::user();
        $user->unblockUser($request->user_id);

        return response()->json(['success' => true, 'message' => 'User unblocked successfully']);
    }

    public function checkBlockStatus(Request $request)
    {
        $request->validate([
            'user_id' => 'required|uuid|exists:users,id'
        ]);

        $user = Auth::user();
        $isBlocked = $user->hasBlocked($request->user_id);

        return response()->json(['success' => true, 'is_blocked' => $isBlocked]);
    }

public function deleteConversation($conversationId)
    {
        $user = Auth::user();
        
        $conversation = Conversation::where('id', $conversationId)
            ->where(function ($query) use ($user) {
                $query->where('user_one_id', $user->id)
                      ->orWhere('user_two_id', $user->id);
            })
            ->first();

        if (!$conversation) {
            return response()->json(['success' => false, 'message' => 'Conversation not found'], 404);
        }

        // Delete all messages in the conversation
        Message::where('conversation_id', $conversationId)->delete();
        
        // Delete the conversation
        $conversation->delete();

        return response()->json(['success' => true, 'message' => 'Conversation deleted successfully']);
    }

    public function getUnreadCount()
    {
        $user = Auth::user();
        
        $count = Message::whereIn('conversation_id', function($query) use ($user) {
            $query->select('id')
                  ->from('conversations')
                  ->where('user_one_id', $user->id)
                  ->orWhere('user_two_id', $user->id);
        })
        ->where('sender_id', '!=', $user->id)
        ->whereNull('read_at')
        ->count();
        
        return response()->json(['count' => $count]);
    }

    public function getConversationsApi()
    {
        $user = Auth::user();
        
        $conversations = Conversation::where('user_one_id', $user->id)
            ->orWhere('user_two_id', $user->id)
            ->orderBy('last_message_at', 'desc')
            ->get();

        $conversationsData = $conversations->map(function ($conversation) use ($user) {
            // Get the other user
            $otherUserId = $conversation->user_one_id === $user->id ? $conversation->user_two_id : $conversation->user_one_id;
            $otherUser = User::find($otherUserId);
            
            // Get the most recent message
            $latestMessage = Message::where('conversation_id', $conversation->id)
                ->orderBy('created_at', 'desc')
                ->first();
            
            // Get unread count
            $unreadCount = Message::where('conversation_id', $conversation->id)
                ->where('sender_id', '!=', $user->id)
                ->whereNull('read_at')
                ->count();
            
            // Format last message based on type
            $lastMessageText = '';
            if ($latestMessage) {
                if ($latestMessage->type === 'image') {
                    $lastMessageText = '📷 Photo';
                } elseif ($latestMessage->type === 'video') {
                    $lastMessageText = '🎥 Video';
                } elseif ($latestMessage->type === 'voice') {
                    $lastMessageText = '🎤 Voice message';
                } elseif ($latestMessage->type === 'file') {
                    $lastMessageText = '📎 File';
                } else {
                    $lastMessageText = $latestMessage->message;
                }
            }
            
            return [
                'id' => $conversation->id,
                'user_id' => $otherUser->id,
                'user_name' => $otherUser->name,
                'user_avatar' => $otherUser->profile_photo_url,
                'last_message' => $lastMessageText,
                'last_message_at' => $conversation->last_message_at,
                'unread_count' => $unreadCount
            ];
        });

        return response()->json(['conversations' => $conversationsData]);
    }

    public function getMessagesApi($conversationId)
    {
        $user = Auth::user();
        
        $conversation = Conversation::where('id', $conversationId)
            ->where(function ($query) use ($user) {
                $query->where('user_one_id', $user->id)
                      ->orWhere('user_two_id', $user->id);
            })
            ->first();

        if (!$conversation) {
            return response()->json(['error' => 'Conversation not found'], 404);
        }

        $messages = Message::where('conversation_id', $conversationId)
            ->with('sender')
            ->orderBy('created_at', 'asc')
            ->get();

        $messagesData = $messages->map(function ($message) use ($user) {
            return [
                'id' => $message->id,
                'message' => $message->message,
                'type' => $message->type,
                'file_url' => $message->getFileUrl(),
                'file_name' => $message->file_name,
                'sender_id' => $message->sender_id,
                'is_own' => $message->sender_id === $user->id,
                'created_at' => $message->created_at->toISOString(),
                'sender_name' => $message->sender->name
            ];
        });

        return response()->json(['messages' => $messagesData]);
    }

    public function markAsRead($conversationId)
    {
        $user = Auth::user();
        
        $conversation = Conversation::where('id', $conversationId)
            ->where(function ($query) use ($user) {
                $query->where('user_one_id', $user->id)
                      ->orWhere('user_two_id', $user->id);
            })
            ->first();

        if (!$conversation) {
            return response()->json(['error' => 'Conversation not found'], 404);
        }

        // Mark messages as read
        Message::where('conversation_id', $conversationId)
            ->where('sender_id', '!=', $user->id)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return response()->json(['success' => true]);
    }
}