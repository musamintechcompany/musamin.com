<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\User;
use App\Models\Conversation;
use App\Notifications\NewFollowerNotification;
use Illuminate\Support\Facades\Log;

class FollowController extends Controller
{
    /**
     * Follow a user
     */
    public function follow(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'user_id' => 'required|exists:users,id'
            ]);

            $user = auth()->user();
            $targetUserId = $request->user_id;

            if ($user->id === $targetUserId) {
                return response()->json([
                    'success' => false,
                    'message' => 'You cannot follow yourself'
                ]);
            }

            // Check if already following
            if (!$user->isFollowing($targetUserId)) {
                // Follow the user
                $user->follow($targetUserId);
                Log::info('User ' . $user->id . ' followed user ' . $targetUserId);
                
                // Send notification to the person being followed
                $targetUser = User::find($targetUserId);
                if ($targetUser) {
                    try {
                        Log::info('Sending follow notification from ' . $user->name . ' to ' . $targetUser->name);
                        $targetUser->notify(new NewFollowerNotification($user));
                        Log::info('Follow notification sent successfully to database');
                        
                        // Send email if user is offline
                        if (!$targetUser->last_seen_at || $targetUser->last_seen_at < now()->subMinutes(5)) {
                            Log::info('Target user is offline, queuing email notification');
                            \Mail::to($targetUser->email)
                                ->later(now()->addSeconds(20), new \App\Mail\NewFollowerMail($user, $targetUser));
                        } else {
                            Log::info('Target user is online, skipping email notification');
                        }
                    } catch (\Exception $e) {
                        Log::error('Notification error: ' . $e->getMessage() . ' | Line: ' . $e->getLine());
                    }
                } else {
                    Log::error('Target user not found: ' . $targetUserId);
                }
                
                // Create conversation
                try {
                    Conversation::findOrCreateBetween($user->id, $targetUserId);
                } catch (\Exception $e) {
                    Log::error('Conversation error: ' . $e->getMessage());
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'User followed successfully',
                'is_following' => true
            ]);
        } catch (\Exception $e) {
            Log::error('Follow error: ' . $e->getMessage() . ' Line: ' . $e->getLine() . ' File: ' . $e->getFile());
            return response()->json([
                'success' => false,
                'message' => 'Failed to follow user: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Unfollow a user
     */
    public function unfollow(Request $request): JsonResponse
    {
        $request->validate([
            'user_id' => 'required|exists:users,id'
        ]);

        $user = auth()->user();
        $targetUserId = $request->user_id;

        $user->unfollow($targetUserId);

        return response()->json([
            'success' => true,
            'message' => 'User unfollowed successfully',
            'is_following' => false
        ]);
    }

    /**
     * Check follow status
     */
    public function status(Request $request): JsonResponse
    {
        // Support both single user and batch checking
        if ($request->has('user_id')) {
            $request->validate([
                'user_id' => 'required|exists:users,id'
            ]);

            $user = auth()->user();
            $isFollowing = $user->isFollowing($request->user_id);

            return response()->json([
                'success' => true,
                'is_following' => $isFollowing
            ]);
        }
        
        if ($request->has('user_ids')) {
            $request->validate([
                'user_ids' => 'required|array',
                'user_ids.*' => 'exists:users,id'
            ]);

            $user = auth()->user();
            $followingStatus = [];
            
            foreach ($request->user_ids as $userId) {
                $followingStatus[$userId] = $user->isFollowing($userId);
            }

            return response()->json([
                'success' => true,
                'following_status' => $followingStatus
            ]);
        }
        
        return response()->json([
            'success' => false,
            'message' => 'user_id or user_ids required'
        ], 400);
    }

    /**
     * Batch check follow status (POST method)
     */
    public function batchStatus(Request $request): JsonResponse
    {
        return $this->status($request);
    }
}