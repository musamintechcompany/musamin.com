<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <title>{{ config('app.name', 'Laravel') }} - Inbox</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @auth
        @if(auth()->user()->prefersDarkTheme())
            <script>document.documentElement.classList.add('dark');</script>
        @endif
    @endauth
</head>
<body class="font-sans antialiased">
    <div class="flex min-h-screen bg-gray-100 dark:bg-gray-900">
        @include('components.layout.sidebar')
        
        <div class="flex flex-col flex-1 w-full min-h-screen transition-all duration-300 ease-in-out md:ml-[70px] md:[.sidebar:not(.collapsed)_~_&]:ml-[250px]">
            <div class="flex h-screen bg-gray-50 dark:bg-gray-900">
        <!-- Conversations Sidebar -->
        <div class="w-full md:w-1/3 lg:w-1/4 bg-white dark:bg-gray-800 border-r border-gray-200 dark:border-gray-700 flex flex-col {{ isset($conversation) ? 'hidden md:flex' : 'flex' }}" id="sidebar">
            <div class="p-4 border-b border-gray-200 dark:border-gray-700">
                <div id="inboxHeader" class="flex items-center justify-between">
                    <button onclick="handleInboxHeaderButton()" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300">
                        <i class="fas fa-bars md:fas fa-home"></i>
                    </button>
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Inbox</h2>
                    <div class="flex items-center space-x-4">
                        <button onclick="toggleNewChat()" class="text-blue-500 hover:text-blue-600">
                            <i class="fas fa-plus"></i>
                        </button>
                        <button onclick="toggleInboxSearch()" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
                <div id="inboxSearchBar" class="hidden">
                    <div class="flex items-center space-x-2">
                        <input type="text" id="inboxSearch" placeholder="Search conversations..." class="flex-1 px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white">
                        <button onclick="toggleInboxSearch()" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <div id="newChatSearchBar" class="hidden">
                    <div class="flex items-center space-x-2">
                        <input type="text" id="newChatSearch" placeholder="Search users to chat with..." class="flex-1 px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white">
                        <button onclick="toggleNewChat()" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            </div>
            <!-- User List for New Conversations -->
            <div id="userList" class="hidden flex-1 overflow-y-auto">
                @foreach($users as $user)
                    <div class="user-item p-3 border-b border-gray-100 dark:border-gray-600" data-user-id="{{ $user->id }}">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3 cursor-pointer hover:opacity-75" onclick="startChatWithUser('{{ $user->id }}')">
                                <div class="w-8 h-8 rounded-full flex items-center justify-center overflow-hidden">
                                    @if($user->profile_photo_path)
                                        <img src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full bg-gray-300 dark:bg-gray-600 flex items-center justify-center text-gray-600 dark:text-gray-400 font-medium text-xs">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                    @endif
                                </div>
                                <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $user->name }}</span>
                            </div>
                            <button onclick="toggleFollow('{{ $user->id }}', this)" class="follow-btn px-2 py-1 text-xs rounded border border-blue-500 text-blue-500 hover:bg-blue-500 hover:text-white" data-user-id="{{ $user->id }}">
                                Follow
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <div id="conversationsList" class="flex-1 overflow-y-auto">
                @forelse($conversations as $conv)
                    @php
                        $unreadCount = $conv->unread_count ?? 0;
                        // Force fresh user data - don't use relationships
                        $otherUserId = auth()->id() === $conv->user_one_id ? $conv->user_two_id : $conv->user_one_id;
                        $otherUser = \App\Models\User::find($otherUserId);
                        $isActive = isset($conversation) && $conv->id === $conversation->id;
                        // Don't show unread count if user is currently in this conversation
                        if ($isActive) $unreadCount = 0;
                    @endphp
                    <div class="conversation-item block p-4 hover:bg-gray-50 dark:hover:bg-gray-700 cursor-pointer {{ $isActive ? 'bg-gray-100 dark:bg-gray-700' : '' }}" data-conversation-id="{{ $conv->id }}" id="conv-{{ $conv->id }}" oncontextmenu="showConversationMenu(event, '{{ $conv->id }}', '{{ $otherUser->id }}', {{ json_encode($otherUser->name) }})" ontouchstart="startLongPress(event, '{{ $conv->id }}', '{{ $otherUser->id }}', {{ json_encode($otherUser->name) }})" ontouchend="endLongPress()">
                        <div class="flex items-center space-x-3">
                            <div class="relative">
                                <div class="w-10 h-10 rounded-full flex items-center justify-center overflow-hidden">
                                    @if($otherUser->profile_photo_path)
                                        <img src="{{ $otherUser->profile_photo_url }}" alt="{{ $otherUser->name }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full bg-gray-300 dark:bg-gray-600 flex items-center justify-center text-gray-600 dark:text-gray-400 font-medium text-sm">
                                            {{ strtoupper(substr($otherUser->name, 0, 1)) }}
                                        </div>
                                    @endif
                                </div>
                                @php
                                    $isOnline = $otherUser->last_seen_at && $otherUser->last_seen_at->diffInMinutes(now()) < 5;
                                @endphp
                                @if($isOnline)
                                    <div class="absolute -bottom-1 -right-1 w-3 h-3 bg-green-500 border-2 border-white dark:border-gray-800 rounded-full"></div>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center justify-between">
                                    <h3 class="font-medium text-gray-900 dark:text-white truncate text-sm">{{ $otherUser->name }}</h3>
                                    <div class="flex items-center space-x-2">
                                        @if($unreadCount > 0)
                                            <div class="bg-blue-500 text-white text-xs rounded-full w-4 h-4 flex items-center justify-center">
                                                {{ $unreadCount > 9 ? '9+' : $unreadCount }}
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                @if($conv->latestMessage)
                                    <p class="text-xs text-gray-600 dark:text-gray-300 truncate">{{ $conv->latestMessage->display_message ?? $conv->latestMessage->message }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-12">
                        <i class="fas fa-inbox text-4xl text-gray-400 mb-4"></i>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">No conversations yet</h3>
                        <p class="text-gray-500 dark:text-gray-400">Start shopping to chat with sellers!</p>
                    </div>
                @endforelse
            </div>
            
            <!-- Conversation Context Menu -->
            <div id="conversationMenu" class="hidden absolute bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg shadow-lg z-50 min-w-32">
                <button onclick="reportUserFromMenu()" class="block w-full text-left px-3 py-2 text-sm text-orange-600 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <i class="fas fa-flag mr-2"></i>Report
                </button>
                <button onclick="deleteConversationFromMenu()" class="block w-full text-left px-3 py-2 text-sm text-red-600 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <i class="fas fa-trash mr-2"></i>Delete
                </button>
            </div>
        </div>

        <!-- Chat Area -->
        @if(isset($conversation))
        <div class="flex-1 flex flex-col {{ isset($conversation) ? 'flex' : 'hidden md:flex' }}" id="chatArea">
            <!-- Chat Header -->
            <div class="chat-header bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 px-4 py-3">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <button onclick="toggleSidebar()" class="md:hidden text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center overflow-hidden">
                                @if($otherUser->profile_photo_path)
                                    <img src="{{ $otherUser->profile_photo_url }}" alt="{{ $otherUser->name }}" class="chat-header-image w-full h-full object-cover">
                                @else
                                    <div class="chat-header-avatar w-full h-full bg-gray-300 dark:bg-gray-600 flex items-center justify-center text-gray-600 dark:text-gray-400 font-medium">
                                        {{ strtoupper(substr($otherUser->name, 0, 1)) }}
                                    </div>
                                @endif
                            </div>
                            <div>
                                <h2 class="chat-header-name font-semibold text-gray-900 dark:text-white">{{ $otherUser->name }}</h2>
                                @if($hasBlocked)
                                    <p class="chat-header-status text-xs text-red-500">Blocked</p>
                                @elseif($isBlockedBy)
                                    <p class="chat-header-status text-xs text-red-500">You are blocked</p>
                                @else
                                    @if(!$isBlockedBy)
                                        @php
                                            $isOnline = $otherUser->last_seen_at && $otherUser->last_seen_at->diffInMinutes(now()) < 5;
                                        @endphp
                                        <p class="chat-header-status text-xs {{ $isOnline ? 'text-green-500' : 'text-gray-500' }}">
                                            {{ $isOnline ? 'Online' : 'Last seen ' . $otherUser->last_seen_at?->diffForHumans() ?? 'Never' }}
                                        </p>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                    

                </div>
            </div>

            <!-- Messages Container -->
            <div id="messagesContainer" class="flex-1 overflow-y-auto p-4 space-y-4 bg-white dark:bg-gray-800">

                @forelse($messages as $message)
                        @php
                            $isOwn = $message->sender_id === auth()->id();
                            $messageClasses = $isOwn ? 'bg-blue-500 text-white' : 'bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-white';
                        @endphp
                        <div class="flex {{ $isOwn ? 'justify-end' : 'justify-start' }}" data-message-id="{{ $message->id }}">
                            <div class="max-w-xs lg:max-w-md px-4 py-2 rounded-lg {{ $messageClasses }} break-words">
                                @if($message->isImage())
                                    <div class="mb-2">
                                        <img src="{{ $message->getFileUrl() }}" alt="Image" 
                                             class="w-32 h-24 object-cover rounded cursor-pointer border-2 border-gray-300 dark:border-gray-600" 
                                             onclick="openImageModal('{{ $message->getFileUrl() }}')">
                                    </div>
                                @elseif($message->isVideo())
                                    <div class="mb-2 relative">
                                        <video class="w-48 h-32 object-cover rounded border-2 border-gray-300 dark:border-gray-600 cursor-pointer" 
                                               onclick="openVideoModal('{{ $message->getFileUrl() }}')">
                                            <source src="{{ $message->getFileUrl() }}" type="{{ $message->mime_type }}">
                                        </video>
                                        <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                                            <i class="fas fa-play text-white text-xl"></i>
                                        </div>
                                    </div>
                                @elseif($message->type === 'voice')
                                    <div class="flex items-center space-x-2 mb-2 p-2 bg-gray-100 dark:bg-gray-600 rounded">
                                        <button onclick="playVoice('{{ $message->getFileUrl() }}', this)" class="text-blue-500 hover:text-blue-600">
                                            <i class="fas fa-play"></i>
                                        </button>
                                        <div class="flex-1">
                                            <div class="w-full bg-gray-300 dark:bg-gray-500 rounded-full h-1">
                                                <div class="bg-blue-500 h-1 rounded-full" style="width: 0%"></div>
                                            </div>
                                        </div>
                                    </div>
                                @elseif($message->isFile())
                                    <div class="flex items-center space-x-2 mb-2 p-2 bg-gray-100 dark:bg-gray-600 rounded">
                                        <i class="fas fa-file text-blue-500"></i>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-medium truncate">{{ $message->file_name }}</p>
                                            <p class="text-xs opacity-75">{{ number_format($message->file_size / 1024, 1) }} KB</p>
                                        </div>
                                        <a href="{{ $message->getFileUrl() }}" download="{{ $message->file_name }}" class="text-blue-500 hover:text-blue-600">
                                            <i class="fas fa-download"></i>
                                        </a>
                                    </div>
                                @endif
                                
                                @if($message->message)
                                    <p class="text-sm break-words whitespace-pre-wrap">{{ $message->message }}</p>
                                @endif
                                <div class="flex items-center justify-between mt-1">
                                    <p class="text-xs opacity-75 message-time" data-time="{{ $message->created_at->toISOString() }}">{{ $message->created_at->diffForHumans() }}</p>
                                    @if($isOwn)
                                        <span class="text-xs opacity-60 message-status">
                                            @if($message->read_at)
                                                <i class="fas fa-check-double text-green-400"></i>
                                            @else
                                                <i class="fas fa-check text-green-400"></i>
                                            @endif
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                    @empty
                        <div class="text-center py-8">
                            <i class="fas fa-comments text-4xl text-gray-400 mb-4"></i>
                            <p class="text-gray-500 dark:text-gray-400">No messages yet. Start the conversation!</p>
                        </div>
                    @endforelse
            </div>

            <!-- Message Input -->
            <div class="bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 p-4">
                    <form id="messageForm" enctype="multipart/form-data" onsubmit="return false;">
                        <div class="flex items-end space-x-2">
                            <!-- Attachment Button -->
                            <div class="relative">
                                <button type="button" onclick="toggleAttachMenu()" class="p-2 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300">
                                    <i class="fas fa-paperclip text-lg"></i>
                                </button>
                                <div id="attachMenu" class="hidden absolute bottom-12 left-0 bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg shadow-lg z-10 min-w-40">
                                    <button type="button" onclick="selectFile('image')" class="block w-full text-left px-3 py-2 text-sm hover:bg-gray-50 dark:hover:bg-gray-600">
                                        <i class="fas fa-image mr-2 text-blue-500"></i>Photo
                                    </button>
                                    <button type="button" onclick="selectFile('video')" class="block w-full text-left px-3 py-2 text-sm hover:bg-gray-50 dark:hover:bg-gray-600">
                                        <i class="fas fa-video mr-2 text-green-500"></i>Video
                                    </button>
                                    <button type="button" onclick="selectFile('file')" class="block w-full text-left px-3 py-2 text-sm hover:bg-gray-50 dark:hover:bg-gray-600">
                                        <i class="fas fa-file mr-2 text-gray-500"></i>File
                                    </button>
                                </div>
                            </div>
                            
                            <!-- Emoji Button -->
                            <button type="button" onclick="toggleEmojiPicker()" class="p-2 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300">
                                <i class="fas fa-smile text-lg"></i>
                            </button>
                            
                            <!-- Message Input -->
                            <div class="flex-1 relative">
                                <textarea id="messageInput" placeholder="Type your message..." rows="1"
                                       class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white resize-none overflow-y-auto h-12 transition-all duration-200 [&::-webkit-scrollbar]:hidden"
                                       style="scrollbar-width: none; -ms-overflow-style: none;"></textarea>
                                
                                <!-- File Preview -->
                                <div id="filePreview" class="hidden absolute bottom-12 left-0 bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg p-2 shadow-lg max-w-xs max-h-32 overflow-y-auto">
                                    <div class="flex items-center justify-between mb-1">
                                        <span class="text-xs font-medium text-gray-900 dark:text-white">Selected Files</span>
                                        <button type="button" onclick="clearFiles()" class="text-red-500 hover:text-red-700 text-xs">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                    <div id="previewContainer"></div>
                                </div>
                                
                                <!-- Voice Preview Inside Textarea -->
                                <div id="voicePreview" class="hidden absolute top-2 left-4 right-4 bg-blue-100 dark:bg-blue-900 rounded-lg p-2">
                                    <div class="flex items-center space-x-2">
                                        <button id="playVoicePreview" class="text-blue-600 hover:text-blue-700">
                                            <i class="fas fa-play text-xs"></i>
                                        </button>
                                        <div class="flex-1">
                                            <div class="w-full bg-blue-300 dark:bg-blue-700 rounded-full h-1">
                                                <div id="voiceProgress" class="bg-blue-600 h-1 rounded-full" style="width: 0%"></div>
                                            </div>
                                        </div>
                                        <button type="button" onclick="clearVoice()" class="text-red-500 hover:text-red-600 text-xs">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                                
                                <!-- Emoji Picker -->
                                <div id="emojiPicker" class="hidden absolute bottom-12 right-0 bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg shadow-lg w-80 max-h-64 overflow-hidden">
                                    <!-- Category Tabs -->
                                    <div class="flex border-b border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-800">
                                        <button type="button" onclick="showEmojiSection('popular')" class="emoji-category-btn px-2 py-2 text-lg hover:bg-gray-100 dark:hover:bg-gray-600 bg-blue-100 dark:bg-blue-900" data-category="popular">
                                            ⭐
                                        </button>
                                        @foreach(config('emojis.categories') as $key => $category)
                                        <button type="button" onclick="showEmojiCategory('{{ $key }}')" class="emoji-category-btn px-2 py-2 text-lg hover:bg-gray-100 dark:hover:bg-gray-600" data-category="{{ $key }}">
                                            {{ $category['icon'] }}
                                        </button>
                                        @endforeach
                                    </div>
                                    
                                    <!-- Search Bar -->
                                    <div class="p-2 border-b border-gray-200 dark:border-gray-600">
                                        <input type="text" id="emojiSearch" placeholder="Search emojis..." class="w-full px-2 py-1 text-xs border border-gray-300 dark:border-gray-600 rounded focus:outline-none focus:ring-1 focus:ring-blue-500 dark:bg-gray-700 dark:text-white">
                                    </div>
                                    
                                    <!-- Emoji Grid -->
                                    <div class="p-2 overflow-y-auto max-h-40">
                                        <!-- Popular Emojis (Default) -->
                                        <div id="popular-emojis" class="emoji-section">
                                            <div class="grid grid-cols-8 gap-1" id="popularGrid">
                                                <!-- Will be loaded via JS -->
                                            </div>
                                        </div>
                                        
                                        <!-- Category Emojis -->
                                        @foreach(config('emojis.categories') as $key => $category)
                                        <div id="category-{{ $key }}" class="emoji-category hidden">
                                            <div class="grid grid-cols-8 gap-1">
                                                @foreach($category['emojis'] as $emoji)
                                                <button type="button" onclick="addEmoji('{{ $emoji }}')" class="p-1 hover:bg-gray-100 dark:hover:bg-gray-600 rounded text-lg">
                                                    {{ $emoji }}
                                                </button>
                                                @endforeach
                                            </div>
                                        </div>
                                        @endforeach
                                        
                                        <!-- Search Results -->
                                        <div id="search-results" class="emoji-section hidden">
                                            <div class="grid grid-cols-8 gap-1" id="searchGrid">
                                                <!-- Search results will be loaded here -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Voice/Send Button -->
                            <button type="button" id="voiceButton" class="p-2 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300">
                                <i class="fas fa-microphone text-lg"></i>
                            </button>
                            <button type="submit" id="sendButton" class="hidden p-2 text-gray-500 hover:text-blue-500 focus:outline-none">
                                <i class="fas fa-paper-plane text-lg"></i>
                            </button>
                        </div>
                    </form>
                    
                    <!-- Hidden File Input -->
                    <input type="file" id="fileInput" class="hidden" accept="*/*" multiple>
            </div>
        </div>
        @else
        <div class="hidden md:flex flex-1 items-center justify-center bg-white dark:bg-gray-800">
            <div class="text-center">
                <i class="fas fa-comments text-6xl text-gray-400 mb-4"></i>
                <h3 class="text-xl font-medium text-gray-900 dark:text-white mb-2">Select a conversation</h3>
                <p class="text-gray-500 dark:text-gray-400">Choose a conversation to start messaging</p>
            </div>
        </div>
        @endif
    </div>

    @vite(['resources/js/echo.js'])
    <script>
        let currentConversation = null;
        
        document.addEventListener('DOMContentLoaded', function() {
            const conversationItems = document.querySelectorAll('.conversation-item');
            const sidebar = document.getElementById('sidebar');
            const chatArea = document.getElementById('chatArea');
            
            // Clear any cached conversation data on page load
            if (window.performance && window.performance.navigation.type === window.performance.navigation.TYPE_BACK_FORWARD) {
                // Page was loaded from cache (back/forward button), force reload
                window.location.reload(true);
                return;
            }
            
            if (typeof Echo !== 'undefined') {
                try {
                    Echo.private('App.Models.User.{{ auth()->id() }}')
                        .listen('MessageSent', (e) => {
                            updateConversationPreview(e.message.conversation_id, e.message.message);
                        });
                } catch (error) {
                    console.error('Failed to setup Echo listener:', error);
                }
            }
            
            conversationItems.forEach(item => {
                item.addEventListener('click', function() {
                    const conversationId = this.dataset.conversationId;
                    
                    // Clear any existing active states
                    conversationItems.forEach(i => {
                        i.classList.remove('bg-gray-100', 'dark:bg-gray-700');
                    });
                    this.classList.add('bg-gray-100', 'dark:bg-gray-700');
                    
                    loadConversation(conversationId);
                    
                    if (window.innerWidth < 768) {
                        sidebar.classList.add('hidden');
                        chatArea.classList.remove('hidden');
                        chatArea.classList.add('flex');
                    }
                });
            });
        });
        
        function loadConversation(conversationId) {
            window.location.href = `/inbox/${conversationId}`;
        }
        
        function updateChatHeader(otherUser) {
            // Update chat header with correct user info
            const headerName = document.querySelector('.chat-header-name');
            const headerImage = document.querySelector('.chat-header-image');
            const headerAvatar = document.querySelector('.chat-header-avatar');
            const headerStatus = document.querySelector('.chat-header-status');
            
            if (headerName) headerName.textContent = otherUser.name;
            
            if (headerImage && otherUser.profile_photo_url) {
                headerImage.src = otherUser.profile_photo_url;
                headerImage.alt = otherUser.name;
            }
            
            if (headerAvatar && !otherUser.profile_photo_url) {
                headerAvatar.textContent = otherUser.name.charAt(0).toUpperCase();
            }
            
            if (headerStatus) {
                headerStatus.textContent = otherUser.is_online ? 'Online' : otherUser.last_seen;
                headerStatus.className = `chat-header-status text-xs ${otherUser.is_online ? 'text-green-500' : 'text-gray-500'}`;
            }
        }
        
        // Chat sound notification
        function playMessageSound() {
            try {
                const audio = new Audio('/sounds/chat.mp3');
                audio.volume = 0.5;
                audio.play().catch(e => console.log('Audio play failed:', e));
            } catch (error) {
                console.log('Sound notification failed:', error);
            }
        }
        
        // Push notification
        function showPushNotification(senderName, message) {
            if ('Notification' in window && Notification.permission === 'granted') {
                new Notification(`New message from ${senderName}`, {
                    body: message,
                    icon: '/favicon.ico',
                    tag: 'chat-message'
                });
            }
        }
        
        // Request notification permission
        if ('Notification' in window && Notification.permission === 'default') {
            Notification.requestPermission();
        }
        
        // Global variables and functions
        let selectedFiles = [];
        let selectedVoice = null;
        let mediaRecorder = null;
        let audioChunks = [];
        let previewAudio = null;
        const messageInput = document.getElementById('messageInput');
        const sendButton = document.getElementById('sendButton');
        
        // Send button state function (global)
        function updateSendButton() {
            if (messageInput && sendButton) {
                const hasText = messageInput.value.trim().length > 0;
                const hasFiles = selectedFiles.length > 0;
                const hasVoice = selectedVoice !== null;
                const voiceButton = document.getElementById('voiceButton');
                
                if (hasText || hasFiles || hasVoice) {
                    // Show send button, hide voice button
                    sendButton.classList.remove('hidden');
                    voiceButton.classList.add('hidden');
                    sendButton.disabled = false;
                    sendButton.classList.remove('opacity-50');
                } else {
                    // Show voice button, hide send button
                    sendButton.classList.add('hidden');
                    voiceButton.classList.remove('hidden');
                }
            }
        }
        
        @if(isset($conversation))
        const conversationId = '{{ $conversation->id }}';
        const container = document.getElementById('messagesContainer');
        
        if (messageInput && sendButton) {
            function sendMessage() {
                const message = messageInput.value.trim();
                const hasFiles = selectedFiles.length > 0;
                const hasVoice = selectedVoice !== null;
                
                if (!message && !hasFiles && !hasVoice) return;
                
                const csrfToken = document.querySelector('meta[name="csrf-token"]');
                if (!csrfToken) {
                    console.error('CSRF token not found');
                    return;
                }
                
                // Clear immediately for instant feedback
                const messageText = message;
                const filesToSend = [...selectedFiles];
                const voiceToSend = selectedVoice;
                
                messageInput.value = '';
                clearFiles();
                clearVoice();
                updateSendButton();
                
                // Send text message if exists
                if (messageText) {
                    const tempMessage = {
                        id: 'temp-text-' + Date.now(),
                        message: messageText,
                        type: 'text',
                        sender_id: '{{ auth()->id() }}'
                    };
                    addMessageToChat(tempMessage, true);
                    
                    const formData = new FormData();
                    formData.append('message', messageText);
                    
                    fetch(`/inbox/${conversationId}/messages`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken.content,
                            'Accept': 'application/json'
                        },
                        body: formData
                    }).catch(error => console.error('Error sending text:', error));
                }
                
                // Send each file separately
                filesToSend.forEach((file, index) => {
                    const tempMessage = {
                        id: 'temp-file-' + Date.now() + '-' + index,
                        message: '',
                        type: getFileType(file),
                        file_url: URL.createObjectURL(file),
                        file_name: file.name,
                        file_size: file.size,
                        sender_id: '{{ auth()->id() }}'
                    };
                    addMessageToChat(tempMessage, true);
                    
                    const formData = new FormData();
                    formData.append('file', file);
                    formData.append('type', getFileType(file));
                    
                    fetch(`/inbox/${conversationId}/messages`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken.content,
                            'Accept': 'application/json'
                        },
                        body: formData
                    }).catch(error => console.error('Error sending file:', error));
                });
                
                // Send voice message
                if (voiceToSend) {
                    const tempMessage = {
                        id: 'temp-voice-' + Date.now(),
                        message: '',
                        type: 'voice',
                        file_url: URL.createObjectURL(voiceToSend),
                        file_name: 'voice-message.wav',
                        file_size: voiceToSend.size,
                        sender_id: '{{ auth()->id() }}'
                    };
                    addMessageToChat(tempMessage, true);
                    
                    const formData = new FormData();
                    formData.append('file', voiceToSend);
                    formData.append('type', 'voice');
                    
                    fetch(`/inbox/${conversationId}/messages`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken.content,
                            'Accept': 'application/json'
                        },
                        body: formData
                    }).catch(error => console.error('Error sending voice:', error));
                }
            }
            
            messageInput.addEventListener('input', updateSendButton);
            
            sendButton.addEventListener('click', function(e) {
                e.preventDefault();
                sendMessage();
            });
            
            messageInput.addEventListener('keydown', function(e) {
                if (e.key === 'Enter' && !e.shiftKey) {
                    e.preventDefault();
                    sendMessage();
                }
            });
            
            // Initial button state - show voice, hide send
            updateSendButton();
            
            if (container) {
                container.scrollTop = container.scrollHeight;
            }
        }
        @endif
        
        // Wait for Echo to be available and setup listeners
        function setupEchoListeners() {
            if (typeof Echo !== 'undefined') {
                console.log('✅ Echo is available, setting up listeners...');
                
                try {
                    // Listen on user channel for all messages
                    Echo.private('App.Models.User.{{ auth()->id() }}')
                        .listen('MessageSent', (e) => {
                            console.log('📨 Message received via Echo:', e);
                            
                            const isCurrentConversation = @if(isset($conversation)) '{{ $conversation->id }}' === e.message.conversation_id @else false @endif;
                            

                            
                            // Handle read status
                            if (e.message.type === 'messages_read') {
                                if (isCurrentConversation && e.message.reader_id !== '{{ auth()->id() }}') {
                                    updateMessageReadStatus(e.message.message_ids);
                                }
                                return;
                            }
                            
                            const isOwnMessage = e.message.sender_id === '{{ auth()->id() }}';
                            
                            if (!isOwnMessage) {
                                // Play sound for all incoming messages
                                playMessageSound();
                                
                                // Show push notification if not on current conversation
                                if (!isCurrentConversation || document.hidden) {
                                    showPushNotification(e.message.sender.name, e.message.message);
                                }
                                
                                // Add to chat if on current conversation
                                if (isCurrentConversation) {
                                    addMessageToChat(e.message, false);
                                }
                                
                                // Update conversation preview
                                updateConversationPreview(e.message.conversation_id, e.message.message);
                            }
                            // Don't add own messages via Echo - they're already added instantly
                        })
                        .error((error) => {
                            console.error('❌ Echo channel error:', error);
                        });
                        
                    console.log('✅ Echo listener setup complete');
                } catch (error) {
                    console.error('❌ Failed to setup Echo listener:', error);
                }
            } else {
                console.log('⏳ Echo not ready, retrying in 100ms...');
                setTimeout(setupEchoListeners, 100);
            }
        }
        
        // Start trying to setup Echo listeners
        setupEchoListeners();
        
        function addMessageToChat(message, isOwn) {
            const container = document.getElementById('messagesContainer');
            if (!container) return;
            
            const messageDiv = document.createElement('div');
            messageDiv.className = 'flex ' + (isOwn ? 'justify-end' : 'justify-start');
            
            const messageContent = document.createElement('div');
            messageContent.className = 'max-w-xs lg:max-w-md px-4 py-2 rounded-lg break-words ' + (isOwn ? 'bg-blue-500 text-white' : 'bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-white');
            
            let content = '';
            
            // Handle media
            if (message.type === 'image') {
                content += `<div class="mb-2"><img src="${message.file_url}" alt="Image" class="w-32 h-24 object-cover rounded cursor-pointer border-2 border-gray-300 dark:border-gray-600" onclick="openImageModal('${message.file_url}')"></div>`;
            } else if (message.type === 'video') {
                content += `<div class="mb-2 relative"><video class="w-48 h-32 object-cover rounded border-2 border-gray-300 dark:border-gray-600 cursor-pointer" onclick="openVideoModal('${message.file_url}')"><source src="${message.file_url}"></video><div class="absolute inset-0 flex items-center justify-center pointer-events-none"><i class="fas fa-play text-white text-xl"></i></div></div>`;
            } else if (message.type === 'voice') {
                content += `<div class="flex items-center space-x-2 mb-2 p-2 bg-gray-100 dark:bg-gray-600 rounded"><button onclick="playVoice('${message.file_url}', this)" class="text-blue-500 hover:text-blue-600"><i class="fas fa-play"></i></button><div class="flex-1"><div class="w-full bg-gray-300 dark:bg-gray-500 rounded-full h-1"><div class="bg-blue-500 h-1 rounded-full" style="width: 0%"></div></div></div></div>`;
            } else if (message.type === 'file') {
                const fileSize = message.file_size ? (message.file_size / 1024).toFixed(1) + ' KB' : 'Unknown size';
                content += `<div class="flex items-center space-x-2 mb-2 p-2 bg-gray-100 dark:bg-gray-600 rounded"><i class="fas fa-file text-blue-500"></i><div class="flex-1 min-w-0"><p class="text-sm font-medium truncate">${message.file_name}</p><p class="text-xs opacity-75">${fileSize}</p></div><a href="${message.file_url}" download class="text-blue-500 hover:text-blue-600"><i class="fas fa-download"></i></a></div>`;
            }
            
            // Handle text
            if (message.message) {
                content += `<p class="text-sm break-words whitespace-pre-wrap">${message.message}</p>`;
            }
            
            content += `<div class="flex items-center justify-between mt-1">`;
            content += `<p class="text-xs opacity-75 message-time" data-time="${new Date().toISOString()}">Just now</p>`;
            if (isOwn) {
                content += `<span class="text-xs opacity-60 message-status"><i class="fas fa-check text-green-400"></i></span>`;
            }
            content += `</div>`;
            
            messageContent.innerHTML = content;
            messageDiv.setAttribute('data-message-id', message.id);
            messageDiv.appendChild(messageContent);
            

            
            container.appendChild(messageDiv);
            container.scrollTop = container.scrollHeight;
        }
        
        // Update message times every minute
        setInterval(updateMessageTimes, 60000);
        
        function updateMessageTimes() {
            document.querySelectorAll('.message-time').forEach(element => {
                const timeStr = element.getAttribute('data-time');
                if (timeStr) {
                    const messageTime = new Date(timeStr);
                    const now = new Date();
                    const diffMs = now - messageTime;
                    const diffMins = Math.floor(diffMs / 60000);
                    const diffHours = Math.floor(diffMs / 3600000);
                    const diffDays = Math.floor(diffMs / 86400000);
                    
                    if (diffMins < 1) {
                        element.textContent = 'Just now';
                    } else if (diffMins < 60) {
                        element.textContent = `${diffMins} minute${diffMins > 1 ? 's' : ''} ago`;
                    } else if (diffHours < 24) {
                        element.textContent = `${diffHours} hour${diffHours > 1 ? 's' : ''} ago`;
                    } else if (diffDays === 1) {
                        element.textContent = `Yesterday ${messageTime.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})}`;
                    } else if (diffDays < 7) {
                        element.textContent = `${diffDays} day${diffDays > 1 ? 's' : ''} ago`;
                    } else {
                        element.textContent = messageTime.toLocaleDateString() + ' ' + messageTime.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
                    }
                }
            });
        }
        
        // Initial update
        updateMessageTimes();
        
        function updateMessageReadStatus(messageIds) {
            messageIds.forEach(messageId => {
                const messageElements = document.querySelectorAll(`[data-message-id="${messageId}"]`);
                messageElements.forEach(element => {
                    const statusElement = element.querySelector('.message-status i');
                    if (statusElement) {
                        statusElement.className = 'fas fa-check-double text-green-400';
                    }
                });
            });
        }
        
        function openImageModal(imageUrl) {
            const modal = document.createElement('div');
            modal.className = 'fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-50';
            modal.onclick = () => modal.remove();
            
            const img = document.createElement('img');
            img.src = imageUrl;
            img.className = 'max-w-full max-h-full object-contain';
            img.onclick = (e) => e.stopPropagation();
            
            const closeBtn = document.createElement('button');
            closeBtn.innerHTML = '<i class="fas fa-times"></i>';
            closeBtn.className = 'absolute top-4 right-4 text-white text-2xl hover:text-gray-300';
            closeBtn.onclick = () => modal.remove();
            
            const downloadBtn = document.createElement('a');
            downloadBtn.href = imageUrl;
            downloadBtn.download = '';
            downloadBtn.innerHTML = '<i class="fas fa-download"></i>';
            downloadBtn.className = 'absolute top-4 right-16 text-white text-2xl hover:text-gray-300';
            downloadBtn.onclick = (e) => e.stopPropagation();
            
            modal.appendChild(img);
            modal.appendChild(closeBtn);
            modal.appendChild(downloadBtn);
            document.body.appendChild(modal);
        }
        
        function openVideoModal(videoUrl) {
            const modal = document.createElement('div');
            modal.className = 'fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-50';
            modal.onclick = () => modal.remove();
            
            const video = document.createElement('video');
            video.src = videoUrl;
            video.className = 'max-w-full max-h-full object-contain';
            video.controls = true;
            video.autoplay = true;
            video.onclick = (e) => e.stopPropagation();
            
            const closeBtn = document.createElement('button');
            closeBtn.innerHTML = '<i class="fas fa-times"></i>';
            closeBtn.className = 'absolute top-4 right-4 text-white text-2xl hover:text-gray-300';
            closeBtn.onclick = () => modal.remove();
            
            modal.appendChild(video);
            modal.appendChild(closeBtn);
            document.body.appendChild(modal);
        }
        
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const chatArea = document.getElementById('chatArea');
            
            if (window.innerWidth < 768 && sidebar && chatArea) {
                sidebar.classList.remove('hidden');
                sidebar.classList.add('flex');
                chatArea.classList.add('hidden');
                chatArea.classList.remove('flex');
                
                // Navigate back to inbox list
                window.location.href = '/inbox';
            }
        }
        
        function toggleNewChat() {
            const header = document.getElementById('inboxHeader');
            const searchBar = document.getElementById('newChatSearchBar');
            const searchInput = document.getElementById('newChatSearch');
            const conversationsList = document.getElementById('conversationsList');
            const userList = document.getElementById('userList');
            
            header.classList.toggle('hidden');
            searchBar.classList.toggle('hidden');
            conversationsList.classList.toggle('hidden');
            userList.classList.toggle('hidden');
            
            if (!searchBar.classList.contains('hidden')) {
                searchInput.focus();
            } else {
                searchInput.value = '';
                filterUsers('');
            }
        }
        
        function toggleInboxSearch() {
            const header = document.getElementById('inboxHeader');
            const searchBar = document.getElementById('inboxSearchBar');
            const searchInput = document.getElementById('inboxSearch');
            
            header.classList.toggle('hidden');
            searchBar.classList.toggle('hidden');
            
            if (!searchBar.classList.contains('hidden')) {
                searchInput.focus();
            } else {
                searchInput.value = '';
                filterConversations('');
            }
        }
        
        function filterConversations(searchTerm) {
            const conversations = document.querySelectorAll('.conversation-item');
            
            conversations.forEach(item => {
                const userName = item.querySelector('h3').textContent.toLowerCase();
                const messagePreview = item.querySelector('.text-xs.text-gray-600');
                const messageText = messagePreview ? messagePreview.textContent.toLowerCase() : '';
                
                if (userName.includes(searchTerm.toLowerCase()) || messageText.includes(searchTerm.toLowerCase())) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        }
        
        // Search functionality
        document.addEventListener('DOMContentLoaded', function() {
            const inboxSearchInput = document.getElementById('inboxSearch');
            if (inboxSearchInput) {
                inboxSearchInput.addEventListener('input', function(e) {
                    filterConversations(e.target.value);
                });
            }
            
            const newChatSearchInput = document.getElementById('newChatSearch');
            if (newChatSearchInput) {
                newChatSearchInput.addEventListener('input', function(e) {
                    filterUsers(e.target.value);
                });
            }
        });
        
        function filterUsers(searchTerm) {
            const userItems = document.querySelectorAll('.user-item');
            
            userItems.forEach(item => {
                const userName = item.querySelector('span').textContent.toLowerCase();
                if (userName.includes(searchTerm.toLowerCase())) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        }
        
        // Start new conversation
        function startChatWithUser(userId) {
            fetch('/inbox/start-chat', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ user_id: userId })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.href = data.redirect_url;
                } else {
                    alert(data.message);
                }
            })
            .catch(error => {
                console.error('Error starting chat:', error);
            });
        }
        
        // Follow/Unfollow functionality
        function toggleFollow(userId, button) {
            const isFollowing = button.textContent.trim() === 'Following' || button.textContent.trim() === 'Unfollow';
            const action = isFollowing ? 'unfollow' : 'follow';
            const newFollowState = !isFollowing;
            
            // Optimistic UI update - change immediately
            updateFollowButton(button, newFollowState);
            updateAllFollowButtons(userId, newFollowState);
            
            // Send to server in background
            const csrfToken = document.querySelector('meta[name="csrf-token"]');
            if (!csrfToken) {
                console.error('CSRF token not found');
                updateFollowButton(button, isFollowing);
                updateAllFollowButtons(userId, isFollowing);
                return;
            }
            
            fetch(`/${action}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken.content,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ user_id: userId })
            })
            .then(response => response.json())
            .then(data => {
                if (!data.success) {
                    // Revert optimistic update on error
                    updateFollowButton(button, isFollowing);
                    updateAllFollowButtons(userId, isFollowing);
                }
            })
            .catch(error => {
                console.error('Error toggling follow:', error);
                // Revert optimistic update on network error
                updateFollowButton(button, isFollowing);
                updateAllFollowButtons(userId, isFollowing);
            });
        }
        
        function updateFollowButton(button, isFollowing) {
            if (isFollowing) {
                button.textContent = 'Following';
                button.classList.remove('text-blue-500', 'border-blue-500', 'hover:bg-blue-500');
                button.classList.add('text-gray-600', 'border-gray-600', 'hover:bg-red-600', 'hover:text-white');
                
                // Add hover effect to show "Unfollow"
                button.onmouseenter = () => {
                    button.textContent = 'Unfollow';
                    button.classList.remove('text-gray-600', 'border-gray-600');
                    button.classList.add('text-red-600', 'border-red-600');
                };
                button.onmouseleave = () => {
                    button.textContent = 'Following';
                    button.classList.remove('text-red-600', 'border-red-600');
                    button.classList.add('text-gray-600', 'border-gray-600');
                };
            } else {
                button.textContent = 'Follow';
                button.classList.remove('text-gray-600', 'border-gray-600', 'hover:bg-red-600', 'text-red-600', 'border-red-600');
                button.classList.add('text-blue-500', 'border-blue-500', 'hover:bg-blue-500');
                button.onmouseenter = null;
                button.onmouseleave = null;
            }
        }
        
        function updateAllFollowButtons(userId, isFollowing) {
            // Update all follow buttons for this user across the page
            document.querySelectorAll(`[data-user-id="${userId}"]`).forEach(btn => {
                if (btn.classList.contains('follow-btn')) {
                    updateFollowButton(btn, isFollowing);
                }
            });
        }
        
        // Load follow status for all users on page load (only on initial load)
        document.addEventListener('DOMContentLoaded', function() {
            // Only load initial status if page is freshly loaded (not from back button)
            if (performance.navigation.type === performance.navigation.TYPE_NAVIGATE) {
                const followButtons = document.querySelectorAll('.follow-btn');
                const userIds = [...new Set(Array.from(followButtons).map(btn => btn.dataset.userId))];
                
                if (userIds.length > 0) {
                    fetch('/follow-status', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({ user_ids: userIds })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Object.entries(data.following_status).forEach(([userId, isFollowing]) => {
                                updateAllFollowButtons(userId, isFollowing);
                            });
                        }
                    })
                    .catch(error => console.error('Error loading follow status:', error));
                }
            }
        });
        

        

        
        // Long press functionality
        let longPressTimer;
        let currentMenuData = {};
        
        function startLongPress(event, conversationId, userId, userName) {
            longPressTimer = setTimeout(() => {
                showConversationMenu(event, conversationId, userId, userName);
            }, 500); // 500ms long press
        }
        
        function endLongPress() {
            clearTimeout(longPressTimer);
        }
        
        function showConversationMenu(event, conversationId, userId, userName) {
            event.preventDefault();
            event.stopPropagation();
            
            currentMenuData = { conversationId, userId, userName };
            
            const menu = document.getElementById('conversationMenu');
            const rect = event.target.closest('.conversation-item').getBoundingClientRect();
            const menuWidth = 120;
            const menuHeight = 120;
            
            menu.classList.remove('hidden');
            
            // Calculate best position
            let left = rect.right - menuWidth;
            let top = rect.top;
            
            // Check if menu goes off right edge
            if (left + menuWidth > window.innerWidth) {
                left = rect.left - menuWidth; // Show on left side
            }
            
            // Check if menu goes off left edge
            if (left < 0) {
                left = rect.left; // Align with conversation start
            }
            
            // Check if menu goes off bottom edge
            if (top + menuHeight > window.innerHeight) {
                top = rect.bottom - menuHeight; // Show above
            }
            
            // Check if menu goes off top edge
            if (top < 0) {
                top = rect.bottom; // Show below
            }
            
            menu.style.left = left + 'px';
            menu.style.top = top + 'px';
        }
        

        
        function reportUserFromMenu() {
            alert(`Report functionality for ${currentMenuData.userName} - To be implemented`);
            hideConversationMenu();
        }
        
        function deleteConversationFromMenu() {
            if (!confirm('Are you sure you want to delete this conversation? This action cannot be undone.')) return;
            
            fetch(`/inbox/${currentMenuData.conversationId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.href = '/inbox';
                } else {
                    alert(data.message);
                }
            })
            .catch(error => {
                console.error('Error deleting conversation:', error);
                alert('Failed to delete conversation');
            });
            
            hideConversationMenu();
        }
        
        function hideConversationMenu() {
            document.getElementById('conversationMenu').classList.add('hidden');
        }
        
        // Close menus when clicking outside
        document.addEventListener('click', function(e) {
            if (!e.target.closest('#conversationMenu')) {
                hideConversationMenu();
            }
        });
        
        function updateConversationPreview(conversationId, message) {
            const convElement = document.getElementById('conv-' + conversationId);
            if (convElement) {
                const messagePreview = convElement.querySelector('.text-xs.text-gray-600');
                if (messagePreview) {
                    messagePreview.textContent = message;
                }
            }
        }
        
        function handleInboxHeaderButton() {
            if (window.innerWidth >= 768) {
                // Desktop: toggle sidebar
                toggleSidebarFromInbox();
            } else {
                // Mobile: go to dashboard
                window.location.href = '/dashboard';
            }
        }
        
        function toggleSidebarFromInbox() {
            // Get the main sidebar element (not the inbox sidebar)
            const mainSidebar = document.querySelector('.sidebar');
            const body = document.body;
            
            if (!mainSidebar) {
                console.error('Main sidebar not found');
                return;
            }
            
            if (window.innerWidth >= 768) {
                mainSidebar.classList.toggle('collapsed');
            } else {
                mainSidebar.classList.toggle('active');
                body.classList.toggle('sidebar-open');
            }
        }
        
        // Update icon based on screen size
        function updateInboxHeaderIcon() {
            const icon = document.querySelector('#inboxHeader button i');
            if (icon) {
                if (window.innerWidth >= 768) {
                    icon.className = 'fas fa-bars';
                } else {
                    icon.className = 'fas fa-home';
                }
            }
        }
        
        // Update icon on load and resize
        document.addEventListener('DOMContentLoaded', updateInboxHeaderIcon);
        window.addEventListener('resize', updateInboxHeaderIcon);
        

        
        // Media functionality
        
        function toggleAttachMenu() {
            const menu = document.getElementById('attachMenu');
            menu.classList.toggle('hidden');
        }
        
        function toggleEmojiPicker() {
            const picker = document.getElementById('emojiPicker');
            picker.classList.toggle('hidden');
        }
        
        function selectFile(type) {
            const fileInput = document.getElementById('fileInput');
            
            switch(type) {
                case 'image':
                    fileInput.accept = 'image/*';
                    break;
                case 'video':
                    fileInput.accept = 'video/*';
                    break;
                case 'file':
                    fileInput.accept = '*/*';
                    break;
            }
            
            fileInput.click();
            document.getElementById('attachMenu').classList.add('hidden');
        }
        
        function addEmoji(emoji) {
            const messageInput = document.getElementById('messageInput');
            messageInput.value += emoji;
            messageInput.focus();
            updateSendButton();
            // Don't close emoji picker - let it stay open
        }
        
        function clearFiles() {
            selectedFiles = [];
            document.getElementById('filePreview').classList.add('hidden');
            document.getElementById('fileInput').value = '';
            updateSendButton();
        }
        
        function removeFile(index) {
            selectedFiles.splice(index, 1);
            showFilePreview();
            updateSendButton();
        }
        
        function clearVoice() {
            selectedVoice = null;
            const voiceButton = document.getElementById('voiceButton');
            const voicePreview = document.getElementById('voicePreview');
            if (voiceButton) {
                voiceButton.innerHTML = '<i class="fas fa-microphone text-lg"></i>';
                voiceButton.classList.remove('text-red-500');
                voiceButton.classList.add('text-gray-500');
            }
            if (voicePreview) {
                voicePreview.classList.add('hidden');
            }
            if (previewAudio) {
                previewAudio.pause();
                previewAudio = null;
            }
            updateSendButton();
        }
        
        // Voice recording functionality
        document.getElementById('voiceButton')?.addEventListener('click', function() {
            if (mediaRecorder && mediaRecorder.state === 'recording') {
                stopRecording();
            } else {
                startRecording();
            }
        });
        
        function startRecording() {
            navigator.mediaDevices.getUserMedia({ audio: true })
                .then(stream => {
                    mediaRecorder = new MediaRecorder(stream);
                    audioChunks = [];
                    
                    mediaRecorder.ondataavailable = event => {
                        audioChunks.push(event.data);
                    };
                    
                    mediaRecorder.onstop = () => {
                        const audioBlob = new Blob(audioChunks, { type: 'audio/wav' });
                        selectedVoice = new File([audioBlob], 'voice-message.wav', { type: 'audio/wav' });
                        
                        // Show voice preview
                        const voicePreview = document.getElementById('voicePreview');
                        voicePreview.classList.remove('hidden');
                        
                        // Create preview audio
                        const audioUrl = URL.createObjectURL(audioBlob);
                        previewAudio = new Audio(audioUrl);
                        
                        updateSendButton();
                        stream.getTracks().forEach(track => track.stop());
                    };
                    
                    mediaRecorder.start();
                    
                    // Update button appearance
                    const voiceButton = document.getElementById('voiceButton');
                    voiceButton.innerHTML = '<i class="fas fa-stop text-lg"></i>';
                    voiceButton.classList.remove('text-gray-500');
                    voiceButton.classList.add('text-red-500');
                })
                .catch(err => {
                    console.error('Error accessing microphone:', err);
                    alert('Could not access microphone');
                });
        }
        
        function stopRecording() {
            if (mediaRecorder && mediaRecorder.state === 'recording') {
                mediaRecorder.stop();
                
                // Reset button appearance
                const voiceButton = document.getElementById('voiceButton');
                voiceButton.innerHTML = '<i class="fas fa-microphone text-lg"></i>';
                voiceButton.classList.remove('text-red-500');
                voiceButton.classList.add('text-gray-500');
            }
        }
        
        // Voice preview playback
        document.addEventListener('DOMContentLoaded', function() {
            const playButton = document.getElementById('playVoicePreview');
            if (playButton) {
                playButton.addEventListener('click', function() {
                    if (!previewAudio) return;
                    
                    const icon = this.querySelector('i');
                    const progressBar = document.getElementById('voiceProgress');
                    
                    if (icon.classList.contains('fa-play')) {
                        // Start playing
                        icon.classList.remove('fa-play');
                        icon.classList.add('fa-pause');
                        
                        previewAudio.addEventListener('timeupdate', () => {
                            const progress = (previewAudio.currentTime / previewAudio.duration) * 100;
                            progressBar.style.width = progress + '%';
                        });
                        
                        previewAudio.addEventListener('ended', () => {
                            icon.classList.remove('fa-pause');
                            icon.classList.add('fa-play');
                            progressBar.style.width = '0%';
                        });
                        
                        previewAudio.play();
                    } else {
                        // Pause playing
                        previewAudio.pause();
                        icon.classList.remove('fa-pause');
                        icon.classList.add('fa-play');
                    }
                });
            }
        });
        
        // Voice playback functionality
        let currentAudio = null;
        
        function playVoice(audioUrl, button) {
            // Stop any currently playing audio
            if (currentAudio) {
                currentAudio.pause();
                currentAudio.currentTime = 0;
                // Reset all play buttons
                document.querySelectorAll('.voice-play-btn').forEach(btn => {
                    btn.innerHTML = '<i class="fas fa-play"></i>';
                });
            }
            
            const icon = button.querySelector('i');
            const progressBar = button.parentElement.querySelector('.bg-blue-500');
            
            if (icon.classList.contains('fa-play')) {
                // Start playing
                currentAudio = new Audio(audioUrl);
                icon.classList.remove('fa-play');
                icon.classList.add('fa-pause');
                button.classList.add('voice-play-btn');
                
                currentAudio.addEventListener('timeupdate', () => {
                    const progress = (currentAudio.currentTime / currentAudio.duration) * 100;
                    progressBar.style.width = progress + '%';
                });
                
                currentAudio.addEventListener('ended', () => {
                    icon.classList.remove('fa-pause');
                    icon.classList.add('fa-play');
                    progressBar.style.width = '0%';
                    button.classList.remove('voice-play-btn');
                    currentAudio = null;
                });
                
                currentAudio.play().catch(e => {
                    console.error('Audio play failed:', e);
                    icon.classList.remove('fa-pause');
                    icon.classList.add('fa-play');
                    button.classList.remove('voice-play-btn');
                });
            } else {
                // Pause playing
                if (currentAudio) {
                    currentAudio.pause();
                    icon.classList.remove('fa-pause');
                    icon.classList.add('fa-play');
                    button.classList.remove('voice-play-btn');
                    currentAudio = null;
                }
            }
        }
        
        function formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
        }
        
        function showFilePreview() {
            const preview = document.getElementById('filePreview');
            const container = document.getElementById('previewContainer');
            
            if (selectedFiles.length === 0) {
                preview.classList.add('hidden');
                return;
            }
            
            container.innerHTML = '';
            
            selectedFiles.forEach((file, index) => {
                const fileDiv = document.createElement('div');
                fileDiv.className = 'flex items-center space-x-2 mb-1 p-1 bg-gray-50 dark:bg-gray-600 rounded';
                
                let preview = '';
                if (file.type.startsWith('image/')) {
                    preview = `<i class="fas fa-image text-blue-500 text-xs"></i>`;
                } else if (file.type.startsWith('video/')) {
                    preview = `<i class="fas fa-video text-green-500 text-xs"></i>`;
                } else {
                    preview = `<i class="fas fa-file text-gray-500 text-xs"></i>`;
                }
                
                fileDiv.innerHTML = `
                    ${preview}
                    <span class="text-xs truncate flex-1">${file.name}</span>
                    <button onclick="removeFile(${index})" class="text-red-500 hover:text-red-700 text-xs">
                        <i class="fas fa-times"></i>
                    </button>
                `;
                
                container.appendChild(fileDiv);
            });
            
            preview.classList.remove('hidden');
        }
        
        // File input handler
        document.getElementById('fileInput').addEventListener('change', function(e) {
            const files = Array.from(e.target.files);
            if (files.length === 0) return;
            
            selectedFiles = files;
            showFilePreview();
            updateSendButton();
        });
        
        // Close menus when clicking outside
        document.addEventListener('click', function(e) {
            if (!e.target.closest('[onclick="toggleAttachMenu()"]') && !e.target.closest('#attachMenu')) {
                const attachMenu = document.getElementById('attachMenu');
                if (attachMenu) attachMenu.classList.add('hidden');
            }
            
            if (!e.target.closest('[onclick="toggleEmojiPicker()"]') && !e.target.closest('#emojiPicker')) {
                const emojiPicker = document.getElementById('emojiPicker');
                if (emojiPicker) emojiPicker.classList.add('hidden');
            }
        });
        
        // Load popular emojis on init
        document.addEventListener('DOMContentLoaded', function() {
            loadPopularEmojis();
            setupEmojiSearch();
        });
        
        function loadPopularEmojis() {
            fetch('/api/emojis/popular')
                .then(response => response.json())
                .then(data => {
                    const grid = document.getElementById('popularGrid');
                    grid.innerHTML = '';
                    data.emojis.forEach(emoji => {
                        const btn = document.createElement('button');
                        btn.type = 'button';
                        btn.onclick = () => addEmoji(emoji);
                        btn.className = 'p-1 hover:bg-gray-100 dark:hover:bg-gray-600 rounded text-lg';
                        btn.textContent = emoji;
                        grid.appendChild(btn);
                    });
                })
                .catch(error => console.error('Error loading popular emojis:', error));
        }
        
        function setupEmojiSearch() {
            const searchInput = document.getElementById('emojiSearch');
            let searchTimeout;
            
            searchInput.addEventListener('input', function() {
                clearTimeout(searchTimeout);
                const query = this.value.trim();
                
                if (query === '') {
                    showEmojiSection('popular');
                    return;
                }
                
                searchTimeout = setTimeout(() => {
                    searchEmojis(query);
                }, 300);
            });
        }
        
        function searchEmojis(query) {
            fetch(`/api/emojis/search?q=${encodeURIComponent(query)}`)
                .then(response => response.json())
                .then(data => {
                    const grid = document.getElementById('searchGrid');
                    grid.innerHTML = '';
                    data.emojis.forEach(emoji => {
                        const btn = document.createElement('button');
                        btn.type = 'button';
                        btn.onclick = () => addEmoji(emoji);
                        btn.className = 'p-1 hover:bg-gray-100 dark:hover:bg-gray-600 rounded text-lg';
                        btn.textContent = emoji;
                        grid.appendChild(btn);
                    });
                    showEmojiSection('search');
                })
                .catch(error => console.error('Error searching emojis:', error));
        }
        
        function showEmojiSection(section) {
            // Hide all sections
            document.querySelectorAll('.emoji-category, .emoji-section').forEach(el => {
                el.classList.add('hidden');
            });
            
            // Show selected section
            if (section === 'popular') {
                document.getElementById('popular-emojis').classList.remove('hidden');
            } else if (section === 'search') {
                document.getElementById('search-results').classList.remove('hidden');
            }
        }
        
        // Emoji category switching
        function getFileType(file) {
            if (file.type.startsWith('image/')) return 'image';
            if (file.type.startsWith('video/')) return 'video';
            return 'file';
        }
        
        function showEmojiCategory(categoryKey) {
            // Clear search
            document.getElementById('emojiSearch').value = '';
            
            // Hide all sections
            document.querySelectorAll('.emoji-category, .emoji-section').forEach(el => {
                el.classList.add('hidden');
            });
            
            // Show selected category
            document.getElementById('category-' + categoryKey).classList.remove('hidden');
            
            // Update active tab
            document.querySelectorAll('.emoji-category-btn').forEach(btn => {
                btn.classList.remove('bg-blue-100', 'dark:bg-blue-900');
            });
            document.querySelector('[data-category="' + categoryKey + '"]').classList.add('bg-blue-100', 'dark:bg-blue-900');
        }
    </script>
            </div>
        </div>
    </div>
</body>
</html>