<!-- Chat Modal Component -->
<div id="chatModal" class="fixed inset-0 z-[9999] hidden">
    <!-- Backdrop -->
    <div class="fixed inset-0 bg-black bg-opacity-50" onclick="closeChatModal()"></div>
    
    <!-- Modal -->
    <div class="fixed inset-2 sm:inset-6 md:inset-8 lg:inset-12 xl:inset-16 bg-white dark:bg-gray-800 rounded-lg shadow-xl flex flex-col sm:flex-row max-w-6xl min-h-[90vh] sm:min-h-[85vh] mx-auto my-auto overflow-hidden">
        <!-- Mobile Conversations List -->
        <div id="mobileConversationsContainer" class="sm:hidden flex flex-col h-full">
            <div class="p-3 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
                <h2 class="font-semibold text-gray-900 dark:text-white text-sm">Conversations</h2>
                <button onclick="closeChatModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times text-lg"></i>
                </button>
            </div>
            <div id="mobileConversationsList" class="flex-1 overflow-y-auto">
                <!-- Mobile conversations will be loaded here -->
            </div>
        </div>
        
        <!-- Desktop Conversations Sidebar -->
        <div class="hidden sm:flex w-80 border-r border-gray-200 dark:border-gray-700 flex-col">
            <!-- Sidebar Header -->
            <div class="p-3 sm:p-4 border-b border-gray-200 dark:border-gray-700">
                <h2 class="font-semibold text-gray-900 dark:text-white text-sm sm:text-base">Conversations</h2>
            </div>
            
            <!-- Conversations List -->
            <div id="conversationsList" class="flex-1 overflow-y-auto">
                <!-- Conversations will be loaded here -->
            </div>
        </div>
        
        <!-- Chat Area -->
        <div id="chatAreaContainer" class="flex-1 flex flex-col min-h-0">
            <!-- Chat Header -->
            <div id="chatHeader" class="hidden flex items-center justify-between p-3 sm:p-4 border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center space-x-2 sm:space-x-3 min-w-0">
                    <!-- Mobile Back Button -->
                    <button onclick="showMobileConversations()" class="sm:hidden text-gray-500 hover:text-gray-700 mr-2">
                        <i class="fas fa-arrow-left"></i>
                    </button>
                    
                    <div class="w-8 h-8 rounded-full flex-shrink-0 overflow-hidden bg-gray-200 dark:bg-gray-600">
                        <img id="chatUserAvatar" src="" alt="" class="w-full h-full object-cover" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex'">
                        <div id="chatUserInitial" class="w-full h-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white font-bold text-xs sm:text-sm" style="display: none;"></div>
                    </div>
                    <div class="min-w-0">
                        <h3 id="chatUserName" class="font-medium text-gray-900 dark:text-white text-sm sm:text-base truncate"></h3>
                        <p id="chatContext" class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 truncate"></p>
                    </div>
                </div>
                <button onclick="closeChatModal()" class="text-gray-400 hover:text-gray-600 flex-shrink-0">
                    <i class="fas fa-times text-lg sm:text-xl"></i>
                </button>
            </div>
            
            <!-- Messages -->
            <div id="chatMessages" class="flex-1 overflow-y-auto p-3 sm:p-4 space-y-2 sm:space-y-3 min-h-0">
                <!-- Messages will be loaded here -->
            </div>
            
            <!-- Input -->
            <div id="chatInputArea" class="hidden p-3 sm:p-4 border-t border-gray-200 dark:border-gray-700">
                <div class="flex items-end space-x-2">
                    <!-- Attachment Button -->
                    <div class="relative">
                        <button type="button" onclick="toggleChatAttachMenu()" class="p-2 text-gray-500 hover:text-gray-700">
                            <i class="fas fa-paperclip"></i>
                        </button>
                        <div id="chatAttachMenu" class="hidden absolute bottom-12 left-0 bg-white border border-gray-200 rounded-lg shadow-lg z-10 min-w-32">
                            <button type="button" onclick="selectChatFile('image')" class="block w-full text-left px-3 py-2 text-sm hover:bg-gray-50">
                                <i class="fas fa-image mr-2 text-blue-500"></i>Photo
                            </button>
                            <button type="button" onclick="selectChatFile('video')" class="block w-full text-left px-3 py-2 text-sm hover:bg-gray-50">
                                <i class="fas fa-video mr-2 text-green-500"></i>Video
                            </button>
                            <button type="button" onclick="selectChatFile('file')" class="block w-full text-left px-3 py-2 text-sm hover:bg-gray-50">
                                <i class="fas fa-file mr-2 text-gray-500"></i>File
                            </button>
                        </div>
                    </div>
                    
                    <!-- Emoji Button -->
                    <button type="button" onclick="toggleChatEmojiPicker()" class="p-2 text-gray-500 hover:text-gray-700">
                        <i class="fas fa-smile"></i>
                    </button>
                    
                    <!-- Chat Input -->
                    <input type="text" id="chatInput" placeholder="Type a message..." 
                           class="flex-1 px-3 py-2 sm:px-4 sm:py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm sm:text-base">
                    
                    <!-- Voice Preview (replaces input when recording) -->
                    <div id="chatVoicePreview" class="hidden flex-1 px-3 py-2 sm:px-4 sm:py-3 border border-gray-300 rounded-lg bg-blue-50">
                        <div class="flex items-center space-x-2">
                            <button onclick="playPreviewVoice(chatPreviewAudio.src, this)" class="text-blue-500 hover:text-blue-600">
                                <i class="fas fa-play"></i>
                            </button>
                            <div class="flex-1 bg-gray-300 rounded-full h-1">
                                <div class="bg-blue-500 h-1 rounded-full" style="width: 0%"></div>
                            </div>
                            <span class="text-xs text-gray-500">Voice message</span>
                            <button onclick="clearChatFile()" class="text-red-500 hover:text-red-700">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    
                    <!-- Voice/Send Button -->
                    <button type="button" id="chatVoiceButton" onclick="toggleChatVoiceRecording()" class="p-2 text-gray-500 hover:text-gray-700">
                        <i class="fas fa-microphone"></i>
                    </button>
                    <button onclick="sendChatMessage()" id="chatSendButton" class="hidden px-4 py-2 sm:px-6 sm:py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 flex-shrink-0">
                        <i class="fas fa-paper-plane text-sm sm:text-base"></i>
                    </button>
                </div>
                
                <!-- File Preview (for images only) -->
                <div id="chatFilePreview" class="hidden mt-2 p-2 bg-gray-50 rounded-lg">
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">Selected file</span>
                        <button onclick="clearChatFile()" class="text-red-500 hover:text-red-700">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div id="chatPreviewContent"></div>
                </div>
                
                <!-- Emoji Picker -->
                <div id="chatEmojiPicker" class="hidden absolute bottom-16 right-0 bg-white border border-gray-200 rounded-lg shadow-lg w-80 max-h-64 overflow-hidden z-20">
                    <!-- Category Tabs -->
                    <div class="flex border-b border-gray-200 bg-gray-50">
                        <button type="button" onclick="showChatEmojiSection('popular')" class="chat-emoji-category-btn px-2 py-2 text-lg hover:bg-gray-100 bg-blue-100" data-category="popular">
                            ⭐
                        </button>
                        <button type="button" onclick="showChatEmojiCategory('smileys')" class="chat-emoji-category-btn px-2 py-2 text-lg hover:bg-gray-100" data-category="smileys">
                            😀
                        </button>
                        <button type="button" onclick="showChatEmojiCategory('people')" class="chat-emoji-category-btn px-2 py-2 text-lg hover:bg-gray-100" data-category="people">
                            👋
                        </button>
                        <button type="button" onclick="showChatEmojiCategory('animals')" class="chat-emoji-category-btn px-2 py-2 text-lg hover:bg-gray-100" data-category="animals">
                            🐶
                        </button>
                        <button type="button" onclick="showChatEmojiCategory('food')" class="chat-emoji-category-btn px-2 py-2 text-lg hover:bg-gray-100" data-category="food">
                            🍎
                        </button>
                        <button type="button" onclick="showChatEmojiCategory('activities')" class="chat-emoji-category-btn px-2 py-2 text-lg hover:bg-gray-100" data-category="activities">
                            ⚽
                        </button>
                        <button type="button" onclick="showChatEmojiCategory('travel')" class="chat-emoji-category-btn px-2 py-2 text-lg hover:bg-gray-100" data-category="travel">
                            🚗
                        </button>
                        <button type="button" onclick="showChatEmojiCategory('objects')" class="chat-emoji-category-btn px-2 py-2 text-lg hover:bg-gray-100" data-category="objects">
                            📱
                        </button>
                        <button type="button" onclick="showChatEmojiCategory('symbols')" class="chat-emoji-category-btn px-2 py-2 text-lg hover:bg-gray-100" data-category="symbols">
                            ❤️
                        </button>
                        <button type="button" onclick="showChatEmojiCategory('flags')" class="chat-emoji-category-btn px-2 py-2 text-lg hover:bg-gray-100" data-category="flags">
                            🏁
                        </button>
                    </div>
                    
                    <!-- Search Bar -->
                    <div class="p-2 border-b border-gray-200">
                        <input type="text" id="chatEmojiSearch" placeholder="Search emojis..." class="w-full px-2 py-1 text-xs border border-gray-300 rounded focus:outline-none focus:ring-1 focus:ring-blue-500">
                    </div>
                    
                    <!-- Emoji Grid -->
                    <div class="p-2 overflow-y-auto max-h-40">
                        <!-- Popular Emojis (Default) -->
                        <div id="chat-popular-emojis" class="chat-emoji-section">
                            <div class="grid grid-cols-8 gap-1" id="chatPopularGrid">
                                <!-- Will be loaded via JS -->
                            </div>
                        </div>
                        
                        <!-- Category Emojis -->
                        <div id="chat-category-smileys" class="chat-emoji-category hidden">
                            <div class="grid grid-cols-8 gap-1">
                                <button type="button" onclick="addChatEmoji('😀')" class="p-1 hover:bg-gray-100 rounded text-lg">😀</button>
                                <button type="button" onclick="addChatEmoji('😃')" class="p-1 hover:bg-gray-100 rounded text-lg">😃</button>
                                <button type="button" onclick="addChatEmoji('😄')" class="p-1 hover:bg-gray-100 rounded text-lg">😄</button>
                                <button type="button" onclick="addChatEmoji('😁')" class="p-1 hover:bg-gray-100 rounded text-lg">😁</button>
                                <button type="button" onclick="addChatEmoji('😆')" class="p-1 hover:bg-gray-100 rounded text-lg">😆</button>
                                <button type="button" onclick="addChatEmoji('😅')" class="p-1 hover:bg-gray-100 rounded text-lg">😅</button>
                                <button type="button" onclick="addChatEmoji('😂')" class="p-1 hover:bg-gray-100 rounded text-lg">😂</button>
                                <button type="button" onclick="addChatEmoji('🤣')" class="p-1 hover:bg-gray-100 rounded text-lg">🤣</button>
                            </div>
                        </div>
                        
                        <div id="chat-category-animals" class="chat-emoji-category hidden">
                            <div class="grid grid-cols-8 gap-1">
                                <button type="button" onclick="addChatEmoji('🐶')" class="p-1 hover:bg-gray-100 rounded text-lg">🐶</button>
                                <button type="button" onclick="addChatEmoji('🐱')" class="p-1 hover:bg-gray-100 rounded text-lg">🐱</button>
                                <button type="button" onclick="addChatEmoji('🐭')" class="p-1 hover:bg-gray-100 rounded text-lg">🐭</button>
                                <button type="button" onclick="addChatEmoji('🐹')" class="p-1 hover:bg-gray-100 rounded text-lg">🐹</button>
                                <button type="button" onclick="addChatEmoji('🐰')" class="p-1 hover:bg-gray-100 rounded text-lg">🐰</button>
                                <button type="button" onclick="addChatEmoji('🦊')" class="p-1 hover:bg-gray-100 rounded text-lg">🦊</button>
                                <button type="button" onclick="addChatEmoji('🐻')" class="p-1 hover:bg-gray-100 rounded text-lg">🐻</button>
                                <button type="button" onclick="addChatEmoji('🐼')" class="p-1 hover:bg-gray-100 rounded text-lg">🐼</button>
                            </div>
                        </div>
                        
                        <div id="chat-category-food" class="chat-emoji-category hidden">
                            <div class="grid grid-cols-8 gap-1">
                                <button type="button" onclick="addChatEmoji('🍎')" class="p-1 hover:bg-gray-100 rounded text-lg">🍎</button>
                                <button type="button" onclick="addChatEmoji('🍊')" class="p-1 hover:bg-gray-100 rounded text-lg">🍊</button>
                                <button type="button" onclick="addChatEmoji('🍋')" class="p-1 hover:bg-gray-100 rounded text-lg">🍋</button>
                                <button type="button" onclick="addChatEmoji('🍌')" class="p-1 hover:bg-gray-100 rounded text-lg">🍌</button>
                                <button type="button" onclick="addChatEmoji('🍉')" class="p-1 hover:bg-gray-100 rounded text-lg">🍉</button>
                                <button type="button" onclick="addChatEmoji('🍇')" class="p-1 hover:bg-gray-100 rounded text-lg">🍇</button>
                                <button type="button" onclick="addChatEmoji('🍓')" class="p-1 hover:bg-gray-100 rounded text-lg">🍓</button>
                                <button type="button" onclick="addChatEmoji('🍈')" class="p-1 hover:bg-gray-100 rounded text-lg">🍈</button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Hidden File Input -->
                <input type="file" id="chatFileInput" class="hidden" accept="*/*">
            </div>
        </div>
    </div>
</div>

<!-- Media Viewer Modal -->
<div id="mediaViewer" class="fixed inset-0 z-[10000] hidden bg-black bg-opacity-90 flex items-center justify-center">
    <div class="relative max-w-full max-h-full p-4">
        <button onclick="closeMediaViewer()" class="absolute top-2 right-2 text-white text-2xl z-10 bg-black bg-opacity-50 rounded-full w-10 h-10 flex items-center justify-center hover:bg-opacity-70">
            <i class="fas fa-times"></i>
        </button>
        <div id="mediaContent" class="max-w-full max-h-full overflow-hidden rounded-lg">
            <!-- Media content will be loaded here -->
        </div>
    </div>
</div>

<!-- Floating Chat Icon -->
<div id="floatingChatIcon" class="fixed bottom-20 right-6 z-[9998] cursor-move group">
    <button onclick="openFloatingChat()" class="w-10 h-10 bg-blue-600 hover:bg-blue-700 text-white rounded-full shadow-lg flex items-center justify-center transition-all duration-200 hover:scale-110">
        <i class="fas fa-comments text-sm"></i>
    </button>
    <!-- Close X (appears on hover) -->
    <button onclick="hideFloatingChatIcon()" class="hidden group-hover:flex absolute -top-1 -left-1 w-4 h-4 bg-red-500 hover:bg-red-600 text-white rounded-full items-center justify-center text-xs">
        <i class="fas fa-times" style="font-size: 8px;"></i>
    </button>
    <!-- Notification Badge -->
    <div id="chatNotificationBadge" class="hidden absolute -top-1 -right-1 w-4 h-4 bg-red-500 text-white text-xs rounded-full flex items-center justify-center font-bold">
        0
    </div>
</div>

<script>
let currentChatData = null;
let chatSelectedFile = null;
let chatMediaRecorder = null;
let chatAudioChunks = [];
let chatPreviewAudio = null;

function openChatModal(userId, userName, userAvatar, context = null, orderId = null, productId = null) {
    currentChatData = {
        userId: userId,
        userName: userName,
        userAvatar: userAvatar,
        context: context,
        orderId: orderId,
        productId: productId
    };
    
    document.getElementById('chatUserName').textContent = userName;
    updateChatAvatar(userAvatar, userName);
    document.getElementById('chatContext').textContent = context || '';
    document.getElementById('chatModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
    
    // Load conversations list and current conversation
    loadConversationsList();
    loadChatConversation();
}

function closeChatModal() {
    document.getElementById('chatModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
}

function loadConversationsList() {
    fetch('/api/conversations', {
        headers: {
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.conversations) {
            renderConversationsList(data.conversations);
            updateFloatingChatBadge(data.conversations);
        } else {
            document.getElementById('conversationsList').innerHTML = '<div class="p-4 text-center text-gray-500 text-sm">No conversations yet</div>';
            updateFloatingChatBadge([]);
        }
    })
    .catch(error => {
        console.error('Error loading conversations:', error);
        document.getElementById('conversationsList').innerHTML = '<div class="p-4 text-center text-gray-500 text-sm">Failed to load conversations</div>';
        updateFloatingChatBadge([]);
    });
}

function renderConversationsList(conversations) {
    const desktopContainer = document.getElementById('conversationsList');
    const mobileContainer = document.getElementById('mobileConversationsList');
    
    if (conversations.length === 0) {
        if (desktopContainer) desktopContainer.innerHTML = '<div class="p-4 text-center text-gray-500 text-sm">No conversations yet</div>';
        if (mobileContainer) mobileContainer.innerHTML = '<div class="p-4 text-center text-gray-500 text-sm">No conversations yet</div>';
        return;
    }
    
    // Desktop conversations (vertical list)
    if (desktopContainer) {
        desktopContainer.innerHTML = conversations.map(conv => {
            const isActive = currentChatData && currentChatData.userId === conv.user_id;
            return `
                <div class="p-3 border-b border-gray-100 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 cursor-pointer ${isActive ? 'bg-blue-50 dark:bg-blue-900/20' : ''}" 
                     onclick="selectDesktopConversation('${conv.user_id}', '${conv.user_name}', '${conv.user_avatar}', '${conv.id}')">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 rounded-full flex-shrink-0 overflow-hidden bg-gray-200 dark:bg-gray-600">
                            ${conv.user_avatar ? 
                                `<img src="${conv.user_avatar}" alt="" class="w-full h-full object-cover">` :
                                `<div class="w-full h-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white font-bold text-sm">${conv.user_name.charAt(0).toUpperCase()}</div>`
                            }
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between">
                                <h4 class="font-medium text-gray-900 dark:text-white text-sm truncate">${conv.user_name}</h4>
                                ${conv.unread_count > 0 ? `<span class="bg-blue-600 text-white text-xs rounded-full px-2 py-1 min-w-[20px] text-center">${conv.unread_count}</span>` : ''}
                            </div>
                            <p class="text-xs text-gray-500 dark:text-gray-400 truncate">${conv.last_message || 'Start a conversation...'}</p>
                        </div>
                    </div>
                </div>
            `;
        }).join('');
    }
    
    // Mobile conversations (vertical list - same as desktop)
    if (mobileContainer) {
        mobileContainer.innerHTML = conversations.map(conv => {
            const isActive = currentChatData && currentChatData.userId === conv.user_id;
            return `
                <div class="p-3 border-b border-gray-100 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 cursor-pointer ${isActive ? 'bg-blue-50 dark:bg-blue-900/20' : ''}" 
                     onclick="selectMobileConversation('${conv.user_id}', '${conv.user_name}', '${conv.user_avatar}', '${conv.id}')">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 rounded-full flex-shrink-0 overflow-hidden bg-gray-200 dark:bg-gray-600">
                            ${conv.user_avatar ? 
                                `<img src="${conv.user_avatar}" alt="" class="w-full h-full object-cover">` :
                                `<div class="w-full h-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white font-bold text-sm">${conv.user_name.charAt(0).toUpperCase()}</div>`
                            }
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between">
                                <h4 class="font-medium text-gray-900 dark:text-white text-sm truncate">${conv.user_name}</h4>
                                ${conv.unread_count > 0 ? `<span class="bg-blue-600 text-white text-xs rounded-full px-2 py-1 min-w-[20px] text-center">${conv.unread_count}</span>` : ''}
                            </div>
                            <p class="text-xs text-gray-500 dark:text-gray-400 truncate">${conv.last_message || 'Start a conversation...'}</p>
                        </div>
                    </div>
                </div>
            `;
        }).join('');
    }
}

function selectConversation(userId, userName, userAvatar, conversationId = null) {
    currentChatData = {
        userId: userId,
        userName: userName,
        userAvatar: userAvatar,
        conversationId: conversationId
    };
    
    // Show UI immediately
    document.getElementById('chatUserName').textContent = userName;
    updateChatAvatar(userAvatar, userName);
    document.getElementById('chatContext').textContent = '';
    document.getElementById('chatHeader').classList.remove('hidden');
    document.getElementById('chatInputArea').classList.remove('hidden');
    
    // Show loading state
    document.getElementById('chatMessages').innerHTML = '<div class="text-center text-gray-500 text-sm py-8">Loading messages...</div>';
    
    // Load messages in background
    loadChatConversation();
    loadConversationsList();
}

function selectMobileConversation(userId, userName, userAvatar, conversationId = null) {
    selectConversation(userId, userName, userAvatar, conversationId);
    showMobileChat();
}

function selectDesktopConversation(userId, userName, userAvatar, conversationId = null) {
    selectConversation(userId, userName, userAvatar, conversationId);
    // Ensure chat area is visible on desktop
    const chatArea = document.getElementById('chatAreaContainer');
    if (chatArea) {
        chatArea.classList.remove('hidden');
    }
}

function showMobileConversations() {
    // Show conversations, hide chat on mobile
    const conversationsContainer = document.getElementById('mobileConversationsContainer');
    const chatArea = document.getElementById('chatAreaContainer');
    
    if (conversationsContainer && chatArea) {
        conversationsContainer.classList.remove('hidden');
        chatArea.classList.add('hidden');
    }
}

function showMobileChat() {
    // Hide conversations, show chat on mobile
    const conversationsContainer = document.getElementById('mobileConversationsContainer');
    const chatArea = document.getElementById('chatAreaContainer');
    
    if (conversationsContainer && chatArea) {
        conversationsContainer.classList.add('hidden');
        chatArea.classList.remove('hidden');
    }
}

function updateChatAvatar(avatarUrl, userName) {
    const avatarImg = document.getElementById('chatUserAvatar');
    const avatarInitial = document.getElementById('chatUserInitial');
    
    if (avatarUrl && avatarUrl !== 'null' && avatarUrl !== '') {
        avatarImg.src = avatarUrl;
        avatarImg.style.display = 'block';
        avatarInitial.style.display = 'none';
    } else {
        avatarImg.style.display = 'none';
        avatarInitial.style.display = 'flex';
        avatarInitial.textContent = userName ? userName.charAt(0).toUpperCase() : '?';
    }
}

function loadChatConversation() {
    if (!currentChatData || !currentChatData.userId) {
        document.getElementById('chatMessages').innerHTML = '<div class="text-center text-gray-500 text-sm py-8">Select a conversation to start chatting</div>';
        return;
    }
    
    // If we have a conversation ID, load messages from database
    if (currentChatData.conversationId) {
        loadMessagesFromDatabase(currentChatData.conversationId);
    } else {
        // Try to find existing conversation
        findExistingConversation();
    }
}

function findExistingConversation() {
    fetch('/inbox/start-chat', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: new URLSearchParams({
            user_id: currentChatData.userId
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success && data.redirect_url) {
            // Extract conversation ID from redirect URL like /inbox?uuid-here
            const url = new URL(data.redirect_url, window.location.origin);
            const conversationId = url.search.substring(1); // Remove the '?' from query string
            currentChatData.conversationId = conversationId;
            loadMessagesFromDatabase(conversationId);
        } else {
            document.getElementById('chatMessages').innerHTML = '<div class="text-center text-gray-500 text-sm py-8">Start a conversation...</div>';
        }
    })
    .catch(error => {
        console.error('Error finding conversation:', error);
        document.getElementById('chatMessages').innerHTML = '<div class="text-center text-gray-500 text-sm py-8">Start a conversation...</div>';
    });
}

function loadMessagesFromDatabase(conversationId) {
    fetch(`/api/conversations/${conversationId}/messages`, {
        headers: {
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.messages) {
            renderMessagesFromDatabase(data.messages);
            // Mark conversation as read
            markConversationAsRead(conversationId);
        } else {
            document.getElementById('chatMessages').innerHTML = '<div class="text-center text-gray-500 text-sm py-8">Start a conversation...</div>';
        }
    })
    .catch(error => {
        console.error('Error loading messages:', error);
        document.getElementById('chatMessages').innerHTML = '<div class="text-center text-gray-500 text-sm py-8">Failed to load messages</div>';
    });
}

function renderMessagesFromDatabase(messages) {
    const container = document.getElementById('chatMessages');
    
    if (messages.length === 0) {
        container.innerHTML = '<div class="text-center text-gray-500 text-sm py-8">Start a conversation...</div>';
        return;
    }
    
    container.innerHTML = '';
    
    messages.forEach(msg => {
        const timeStr = new Date(msg.created_at).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
        
        const messageDiv = document.createElement('div');
        messageDiv.className = `flex ${msg.is_own ? 'justify-end' : 'justify-start'} mb-3`;
        
        const messageWrapper = document.createElement('div');
        messageWrapper.className = 'max-w-xs';
        
        const messageContent = document.createElement('div');
        messageContent.className = `px-3 py-2 rounded-lg text-sm ${
            msg.is_own 
                ? 'bg-blue-600 text-white' 
                : 'bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white'
        }`;
        
        if (msg.type === 'image' && msg.file_url) {
            const img = document.createElement('img');
            img.src = msg.file_url;
            img.className = 'w-32 h-24 object-cover rounded cursor-pointer';
            img.onclick = () => openMediaViewer(msg.file_url, 'image');
            messageContent.appendChild(img);
        } else if (msg.type === 'voice' && msg.file_url) {
            const voiceContainer = document.createElement('div');
            voiceContainer.className = 'flex items-center space-x-2';
            
            const playButton = document.createElement('button');
            playButton.onclick = () => playVoiceMessage(msg.file_url, playButton);
            playButton.className = 'text-blue-500 hover:text-blue-600';
            playButton.innerHTML = '<i class="fas fa-play"></i>';
            
            const progressContainer = document.createElement('div');
            progressContainer.className = 'flex-1 bg-gray-300 rounded-full h-1';
            
            const progressBar = document.createElement('div');
            progressBar.className = 'bg-blue-500 h-1 rounded-full';
            progressBar.style.width = '0%';
            
            progressContainer.appendChild(progressBar);
            voiceContainer.appendChild(playButton);
            voiceContainer.appendChild(progressContainer);
            messageContent.appendChild(voiceContainer);
        } else if (msg.type === 'file' && msg.file_url) {
            messageContent.innerHTML = `<i class="fas fa-file mr-2"></i>${msg.file_name || 'File'}`;
        } else {
            messageContent.textContent = decodeHtmlEntities(msg.message || '');
        }
        
        const timeDiv = document.createElement('div');
        timeDiv.className = `text-xs text-gray-500 mt-1 ${msg.is_own ? 'text-right' : 'text-left'}`;
        timeDiv.textContent = timeStr;
        
        messageWrapper.appendChild(messageContent);
        messageWrapper.appendChild(timeDiv);
        messageDiv.appendChild(messageWrapper);
        container.appendChild(messageDiv);
    });
    
    container.scrollTop = container.scrollHeight;
}

function sendChatMessage() {
    const input = document.getElementById('chatInput');
    const message = input.value.trim();
    
    if ((!message && !chatSelectedFile) || !currentChatData) return;
    
    // Add message to UI immediately
    if (message) {
        addMessageToUI(message, true);
    }
    if (chatSelectedFile) {
        addFileMessageToUI(chatSelectedFile, true);
    }
    
    // Clear inputs
    input.value = '';
    const fileToSend = chatSelectedFile;
    clearChatFile();
    updateChatSendButton();
    
    // Send to server
    if (message) {
        sendMessageToServer(message);
    }
    if (fileToSend) {
        sendFileToServer(fileToSend);
    }
}

function addMessageToUI(message, isOwn) {
    const container = document.getElementById('chatMessages');
    
    // Clear placeholder if exists
    if (container.innerHTML.includes('Start a conversation') || container.innerHTML.includes('Select a conversation')) {
        container.innerHTML = '';
    }
    
    const messageDiv = document.createElement('div');
    messageDiv.className = `flex ${isOwn ? 'justify-end' : 'justify-start'} mb-3`;
    
    const timeStr = new Date().toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
    
    // Create elements to avoid HTML encoding issues
    const messageWrapper = document.createElement('div');
    messageWrapper.className = 'max-w-xs';
    
    const messageContent = document.createElement('div');
    messageContent.className = `px-3 py-2 rounded-lg text-sm ${
        isOwn 
            ? 'bg-blue-600 text-white' 
            : 'bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white'
    }`;
    messageContent.textContent = message; // Use textContent to avoid HTML encoding
    
    const timeDiv = document.createElement('div');
    timeDiv.className = `text-xs text-gray-500 mt-1 ${isOwn ? 'text-right' : 'text-left'}`;
    timeDiv.textContent = timeStr;
    
    messageWrapper.appendChild(messageContent);
    messageWrapper.appendChild(timeDiv);
    messageDiv.appendChild(messageWrapper);
    
    container.appendChild(messageDiv);
    container.scrollTop = container.scrollHeight;
}

function sendMessageToServer(message) {
    // First create/find conversation, then send message
    fetch('/inbox/start-chat', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: new URLSearchParams({
            user_id: currentChatData.userId
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success && data.redirect_url) {
            // Extract conversation ID from redirect URL like /inbox?uuid-here
            const url = new URL(data.redirect_url, window.location.origin);
            const conversationId = url.search.substring(1); // Remove the '?' from query string
            currentChatData.conversationId = conversationId;
            
            // Now send the actual message
            return fetch(`/inbox/${conversationId}/messages`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: new URLSearchParams({
                    message: message
                })
            });
        } else {
            throw new Error('Failed to create conversation');
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            console.log('Message sent and saved to database');
            // Refresh conversations list to show updated last message
            loadConversationsList();
        } else {
            console.error('Failed to send message:', data.message || 'Unknown error');
        }
    })
    .catch(error => {
        console.error('Error sending message:', error);
    });
}

function addMessageToChat(message, isOwn = false, isRealTime = true, timestamp = null) {
    if (!currentChatData) return;
    
    // Add message to UI
    addMessageToUI(message, isOwn);
    
    // Update conversations list
    loadConversationsList();
}

// Handle Enter key in chat input and setup real-time listeners
document.addEventListener('DOMContentLoaded', function() {
    // Make floating chat icon draggable
    makeChatIconDraggable();
    
    const chatInput = document.getElementById('chatInput');
    if (chatInput) {
        chatInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                sendChatMessage();
            }
        });
        
        chatInput.addEventListener('input', updateChatSendButton);
    }
    
    const fileInput = document.getElementById('chatFileInput');
    if (fileInput) {
        fileInput.addEventListener('change', handleChatFileSelect);
    }
    
    document.addEventListener('click', function(e) {
        if (!e.target.closest('[onclick="toggleChatAttachMenu()"]') && !e.target.closest('#chatAttachMenu')) {
            const menu = document.getElementById('chatAttachMenu');
            if (menu) menu.classList.add('hidden');
        }
        
        if (!e.target.closest('[onclick="toggleChatEmojiPicker()"]') && !e.target.closest('#chatEmojiPicker')) {
            const picker = document.getElementById('chatEmojiPicker');
            if (picker) picker.classList.add('hidden');
        }
    });
    
    // Setup real-time message listeners
    setupChatEchoListeners();
    
    // Load popular emojis for chat modal
    loadChatPopularEmojis();
    
    // Load conversations to update badge
    loadConversationsList();
});

function setupChatEchoListeners() {
    @auth
    const currentUserId = '{{ auth()->id() }}';
    if (typeof Echo !== 'undefined') {
        Echo.private(`App.Models.User.${currentUserId}`)
            .listen('MessageSent', (e) => {
                // Only handle if not own message and chat modal is open
                if (e.message.sender_id !== currentUserId && !document.getElementById('chatModal').classList.contains('hidden')) {
                    // If message is from current chat user, add to chat
                    if (currentChatData && e.message.sender_id == currentChatData.userId) {
                        // Decode HTML entities from server
                        const decodedMessage = decodeHtmlEntities(e.message.message);
                        addMessageToChat(decodedMessage, false, true, e.message.created_at);
                    }
                }
            });
    }
    @endauth
}

// Helper function to decode HTML entities
function decodeHtmlEntities(text) {
    const textarea = document.createElement('textarea');
    textarea.innerHTML = text;
    return textarea.value;
}

// Floating chat functions
function openFloatingChat() {
    loadConversationsList();
    showChatPlaceholder();
    document.getElementById('chatModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function hideFloatingChatIcon() {
    document.getElementById('floatingChatIcon').style.display = 'none';
    localStorage.setItem('chatIconHidden', 'true');
}

function updateFloatingChatBadge(conversations) {
    const badge = document.getElementById('chatNotificationBadge');
    const chatIcon = document.getElementById('floatingChatIcon');
    
    // Calculate total unread count
    let totalUnread = 0;
    conversations.forEach(conv => {
        totalUnread += conv.unread_count || 0;
    });
    
    if (totalUnread > 0) {
        // Show badge with count
        badge.textContent = totalUnread > 99 ? '99+' : totalUnread;
        badge.classList.remove('hidden');
        
        // Show chat icon even if previously hidden
        chatIcon.style.display = 'block';
        localStorage.removeItem('chatIconHidden');
    } else {
        // Hide badge
        badge.classList.add('hidden');
    }
}

function showChatPlaceholder() {
    // Hide chat header and input area
    document.getElementById('chatHeader').classList.add('hidden');
    document.getElementById('chatInputArea').classList.add('hidden');
    
    // On mobile, show conversations list instead of chat area
    showMobileConversations();
    
    const messagesContainer = document.getElementById('chatMessages');
    messagesContainer.innerHTML = `
        <div class="flex items-center justify-center h-full">
            <div class="text-center">
                <i class="fas fa-comments text-4xl text-gray-400 mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">Select a conversation</h3>
                <p class="text-gray-500 dark:text-gray-400">Choose a conversation to start messaging</p>
            </div>
        </div>
    `;
}

// File upload functions
function toggleChatAttachMenu() {
    const menu = document.getElementById('chatAttachMenu');
    menu.classList.toggle('hidden');
}

function selectChatFile(type) {
    const fileInput = document.getElementById('chatFileInput');
    
    if (type === 'image') {
        fileInput.accept = 'image/*';
    } else if (type === 'video') {
        fileInput.accept = 'video/*';
    } else if (type === 'file') {
        fileInput.accept = '*/*';
    }
    
    fileInput.click();
    document.getElementById('chatAttachMenu').classList.add('hidden');
}

function handleChatFileSelect(e) {
    const file = e.target.files[0];
    if (!file) return;
    
    chatSelectedFile = file;
    showChatFilePreview(file);
    updateChatSendButton();
}

function showChatFilePreview(file) {
    if (file.type.startsWith('image/')) {
        const preview = document.getElementById('chatFilePreview');
        const content = document.getElementById('chatPreviewContent');
        
        const img = document.createElement('img');
        img.src = URL.createObjectURL(file);
        img.className = 'w-16 h-16 object-cover rounded mt-1';
        content.innerHTML = '';
        content.appendChild(img);
        
        preview.classList.remove('hidden');
    } else if (file.type.startsWith('audio/')) {
        // For voice messages, show preview in place of input
        const chatInput = document.getElementById('chatInput');
        const voicePreview = document.getElementById('chatVoicePreview');
        
        chatInput.classList.add('hidden');
        voicePreview.classList.remove('hidden');
        
        // Store audio URL for playback
        chatPreviewAudio = new Audio(URL.createObjectURL(file));
    } else {
        const preview = document.getElementById('chatFilePreview');
        const content = document.getElementById('chatPreviewContent');
        
        content.innerHTML = `<div class="flex items-center mt-1"><i class="fas fa-file mr-2"></i><span class="text-sm">${file.name}</span></div>`;
        preview.classList.remove('hidden');
    }
}

function clearChatFile() {
    chatSelectedFile = null;
    chatPreviewAudio = null;
    
    // Hide all previews and show input
    document.getElementById('chatFilePreview').classList.add('hidden');
    document.getElementById('chatVoicePreview').classList.add('hidden');
    document.getElementById('chatInput').classList.remove('hidden');
    document.getElementById('chatFileInput').value = '';
    
    updateChatSendButton();
}

function updateChatSendButton() {
    const input = document.getElementById('chatInput');
    const sendBtn = document.getElementById('chatSendButton');
    const voiceBtn = document.getElementById('chatVoiceButton');
    
    const hasText = input && input.value.trim().length > 0;
    const hasFile = chatSelectedFile !== null;
    
    if (hasText || hasFile) {
        sendBtn.classList.remove('hidden');
        voiceBtn.classList.add('hidden');
    } else {
        sendBtn.classList.add('hidden');
        voiceBtn.classList.remove('hidden');
    }
}

function addFileMessageToUI(file, isOwn) {
    const container = document.getElementById('chatMessages');
    
    if (container.innerHTML.includes('Start a conversation') || container.innerHTML.includes('Select a conversation')) {
        container.innerHTML = '';
    }
    
    const messageDiv = document.createElement('div');
    messageDiv.className = `flex ${isOwn ? 'justify-end' : 'justify-start'} mb-3`;
    
    const timeStr = new Date().toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
    
    const messageWrapper = document.createElement('div');
    messageWrapper.className = 'max-w-xs';
    
    const messageContent = document.createElement('div');
    messageContent.className = `px-3 py-2 rounded-lg text-sm ${
        isOwn 
            ? 'bg-blue-600 text-white' 
            : 'bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white'
    }`;
    
    if (file.type.startsWith('image/')) {
        const img = document.createElement('img');
        img.src = URL.createObjectURL(file);
        img.className = 'w-32 h-24 object-cover rounded';
        messageContent.appendChild(img);
    } else if (file.type.startsWith('audio/')) {
        const audioUrl = URL.createObjectURL(file);
        messageContent.innerHTML = `
            <div class="flex items-center space-x-2">
                <button onclick="playVoiceMessage('${audioUrl}', this)" class="text-blue-500 hover:text-blue-600">
                    <i class="fas fa-play"></i>
                </button>
                <div class="flex-1 bg-gray-300 rounded-full h-1">
                    <div class="bg-blue-500 h-1 rounded-full" style="width: 0%"></div>
                </div>
            </div>
        `;
    } else {
        messageContent.innerHTML = `<i class="fas fa-file mr-2"></i>${file.name}`;
    }
    
    const timeDiv = document.createElement('div');
    timeDiv.className = `text-xs text-gray-500 mt-1 ${isOwn ? 'text-right' : 'text-left'}`;
    timeDiv.textContent = timeStr;
    
    messageWrapper.appendChild(messageContent);
    messageWrapper.appendChild(timeDiv);
    messageDiv.appendChild(messageWrapper);
    
    container.appendChild(messageDiv);
    container.scrollTop = container.scrollHeight;
}

function sendFileToServer(file) {
    fetch('/inbox/start-chat', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: new URLSearchParams({
            user_id: currentChatData.userId
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success && data.redirect_url) {
            const url = new URL(data.redirect_url, window.location.origin);
            const conversationId = url.search.substring(1);
            currentChatData.conversationId = conversationId;
            
            const formData = new FormData();
            formData.append('file', file);
            formData.append('type', getFileType(file));
            
            return fetch(`/inbox/${conversationId}/messages`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: formData
            });
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            loadConversationsList();
        }
    })
    .catch(error => console.error('Error sending file:', error));
}

function getFileType(file) {
    if (file.type.startsWith('image/')) return 'image';
    if (file.type.startsWith('audio/')) return 'voice';
    return 'file';
}

function startChatVoiceRecording() {
    navigator.mediaDevices.getUserMedia({ audio: true })
        .then(stream => {
            chatMediaRecorder = new MediaRecorder(stream);
            chatAudioChunks = [];
            
            chatMediaRecorder.ondataavailable = event => {
                chatAudioChunks.push(event.data);
            };
            
            chatMediaRecorder.onstop = () => {
                const audioBlob = new Blob(chatAudioChunks, { type: 'audio/wav' });
                chatSelectedFile = new File([audioBlob], 'voice-message.wav', { type: 'audio/wav' });
                
                showChatFilePreview(chatSelectedFile);
                updateChatSendButton();
                stream.getTracks().forEach(track => track.stop());
            };
            
            chatMediaRecorder.start();
            
            const voiceBtn = document.getElementById('chatVoiceButton');
            voiceBtn.innerHTML = '<i class="fas fa-stop text-red-500"></i>';
        })
        .catch(err => {
            console.error('Error accessing microphone:', err);
            alert('Could not access microphone');
        });
}

function toggleChatVoiceRecording() {
    if (chatMediaRecorder && chatMediaRecorder.state === 'recording') {
        chatMediaRecorder.stop();
        const voiceBtn = document.getElementById('chatVoiceButton');
        voiceBtn.innerHTML = '<i class="fas fa-microphone"></i>';
    } else {
        startChatVoiceRecording();
    }
}

function toggleChatEmojiPicker() {
    const picker = document.getElementById('chatEmojiPicker');
    picker.classList.toggle('hidden');
}

function addChatEmoji(emoji) {
    const input = document.getElementById('chatInput');
    input.value += emoji;
    input.focus();
    updateChatSendButton();
}

function showChatEmojiSection(section) {
    document.querySelectorAll('.chat-emoji-category, .chat-emoji-section').forEach(el => {
        el.classList.add('hidden');
    });
    
    if (section === 'popular') {
        document.getElementById('chat-popular-emojis').classList.remove('hidden');
    }
    
    document.querySelectorAll('.chat-emoji-category-btn').forEach(btn => {
        btn.classList.remove('bg-blue-100');
    });
    document.querySelector('[data-category="popular"]').classList.add('bg-blue-100');
}

function showChatEmojiCategory(categoryKey) {
    document.querySelectorAll('.chat-emoji-category, .chat-emoji-section').forEach(el => {
        el.classList.add('hidden');
    });
    
    // Load category emojis from config
    loadChatEmojiCategory(categoryKey);
    
    document.querySelectorAll('.chat-emoji-category-btn').forEach(btn => {
        btn.classList.remove('bg-blue-100');
    });
    document.querySelector('[data-category="' + categoryKey + '"]').classList.add('bg-blue-100');
}

function loadChatPopularEmojis() {
    fetch('/api/emojis/popular')
        .then(response => response.json())
        .then(data => {
            const grid = document.getElementById('chatPopularGrid');
            grid.innerHTML = '';
            data.emojis.forEach(emoji => {
                const btn = document.createElement('button');
                btn.type = 'button';
                btn.onclick = () => addChatEmoji(emoji);
                btn.className = 'p-1 hover:bg-gray-100 rounded text-lg';
                btn.textContent = emoji;
                grid.appendChild(btn);
            });
        })
        .catch(error => console.error('Error loading popular emojis:', error));
}

function loadChatEmojiCategory(categoryKey) {
    // Remove existing category container if it exists
    const existingContainer = document.getElementById('chat-category-' + categoryKey);
    if (existingContainer) {
        existingContainer.remove();
    }
    
    // Create new category container
    const categoryContainer = document.createElement('div');
    categoryContainer.id = 'chat-category-' + categoryKey;
    categoryContainer.className = 'chat-emoji-category';
    
    const grid = document.createElement('div');
    grid.className = 'grid grid-cols-8 gap-1';
    
    // Load emojis from config (using the same categories as inbox)
    const emojiCategories = {
        'smileys': ['😀', '😃', '😄', '😁', '😆', '😅', '🤣', '😂', '🙂', '🙃', '😉', '😊', '😇', '🥰', '😍', '🤩', '😘', '😗', '☺️', '😚', '😙', '🥲', '😋', '😛', '😜', '🤪', '😝', '🤑', '🤗', '🤭', '🤫', '🤔'],
        'people': ['👋', '🤚', '🖐️', '✋', '🖖', '👌', '🤌', '🤏', '✌️', '🤞', '🤟', '🤘', '🤙', '👈', '👉', '👆', '🖕', '👇', '☝️', '👍', '👎', '👊', '✊', '🤛', '🤜', '👏', '🙌', '👐', '🤲', '🤝', '🙏'],
        'animals': ['🐶', '🐱', '🐭', '🐹', '🐰', '🦊', '🐻', '🐼', '🐨', '🐯', '🦁', '🐮', '🐷', '🐽', '🐸', '🐵', '🙈', '🙉', '🙊', '🐒', '🐔', '🐧', '🐦', '🐤', '🐣', '🐥', '🦆', '🦅', '🦉', '🦇', '🐺', '🐗'],
        'food': ['🍎', '🍐', '🍊', '🍋', '🍌', '🍉', '🍇', '🍓', '🫐', '🍈', '🍒', '🍑', '🥭', '🍍', '🥥', '🥝', '🍅', '🍆', '🥑', '🥦', '🥬', '🥒', '🌶️', '🫑', '🌽', '🥕', '🫒', '🧄', '🧅', '🥔', '🍠', '🥐'],
        'activities': ['⚽', '🏀', '🏈', '⚾', '🥎', '🎾', '🏐', '🏉', '🥏', '🎱', '🪀', '🏓', '🏸', '🏒', '🏑', '🥍', '🏏', '🪃', '🥅', '⛳', '🪁', '🏹', '🎣', '🤿', '🥊', '🥋', '🎽', '🛹', '🛼', '🛷', '⛸️', '🥌'],
        'travel': ['🚗', '🚕', '🚙', '🚌', '🚎', '🏎️', '🚓', '🚑', '🚒', '🚐', '🛻', '🚚', '🚛', '🚜', '🏍️', '🛵', '🚲', '🛴', '🛹', '🛼', '🚁', '🛸', '✈️', '🛩️', '🪂', '💺', '🚀', '🛰️', '🚉', '🚊', '🚝', '🚞'],
        'objects': ['📱', '📲', '💻', '⌨️', '🖥️', '🖨️', '🖱️', '🖲️', '🕹️', '🗜️', '💽', '💾', '💿', '📀', '📼', '📷', '📸', '📹', '🎥', '📽️', '🎞️', '📞', '☎️', '📟', '📠', '📺', '📻', '🎙️', '🎚️', '🎛️', '🧭', '⏱️'],
        'symbols': ['❤️', '🧡', '💛', '💚', '💙', '💜', '🖤', '🤍', '🤎', '💔', '❣️', '💕', '💞', '💓', '💗', '💖', '💘', '💝', '💟', '☮️', '✝️', '☪️', '🕉️', '☸️', '✡️', '🔯', '🕎', '☯️', '☦️', '🛐', '⛎', '♈'],
        'flags': ['🏁', '🚩', '🎌', '🏴', '🏳️', '🏳️🌈', '🏳️⚧️', '🏴☠️', '🇦🇫', '🇦🇽', '🇦🇱', '🇩🇿', '🇦🇸', '🇦🇩', '🇦🇴', '🇦🇮', '🇦🇶', '🇦🇬', '🇦🇷', '🇦🇲', '🇦🇼', '🇦🇺', '🇦🇹', '🇦🇿', '🇧🇸', '🇧🇭', '🇧🇩', '🇧🇧', '🇧🇾', '🇧🇪', '🇧🇿', '🇧🇯']
    };
    
    const emojis = emojiCategories[categoryKey] || [];
    emojis.forEach(emoji => {
        const btn = document.createElement('button');
        btn.type = 'button';
        btn.onclick = () => addChatEmoji(emoji);
        btn.className = 'p-1 hover:bg-gray-100 rounded text-lg';
        btn.textContent = emoji;
        grid.appendChild(btn);
    });
    
    categoryContainer.appendChild(grid);
    document.querySelector('#chatEmojiPicker .p-2.overflow-y-auto').appendChild(categoryContainer);
    
    // Show the category
    categoryContainer.classList.remove('hidden');
}

let currentVoiceAudio = null;

function playPreviewVoice(audioUrl, button) {
    if (currentVoiceAudio) {
        currentVoiceAudio.pause();
        currentVoiceAudio.currentTime = 0;
        document.querySelectorAll('.voice-play-btn').forEach(btn => {
            btn.innerHTML = '<i class="fas fa-play"></i>';
        });
    }
    
    const icon = button.querySelector('i');
    const progressBar = button.parentElement.querySelector('.bg-blue-500');
    
    if (icon.classList.contains('fa-play')) {
        currentVoiceAudio = new Audio(audioUrl);
        icon.classList.remove('fa-play');
        icon.classList.add('fa-pause');
        button.classList.add('voice-play-btn');
        
        currentVoiceAudio.addEventListener('timeupdate', () => {
            const progress = (currentVoiceAudio.currentTime / currentVoiceAudio.duration) * 100;
            progressBar.style.width = progress + '%';
        });
        
        currentVoiceAudio.addEventListener('ended', () => {
            icon.classList.remove('fa-pause');
            icon.classList.add('fa-play');
            progressBar.style.width = '0%';
            button.classList.remove('voice-play-btn');
            currentVoiceAudio = null;
        });
        
        currentVoiceAudio.play();
    } else {
        if (currentVoiceAudio) {
            currentVoiceAudio.pause();
            icon.classList.remove('fa-pause');
            icon.classList.add('fa-play');
            button.classList.remove('voice-play-btn');
            currentVoiceAudio = null;
        }
    }
}

function playVoiceMessage(audioUrl, button) {
    playPreviewVoice(audioUrl, button);
}

// Media viewer functions
function openMediaViewer(url, type) {
    const viewer = document.getElementById('mediaViewer');
    const content = document.getElementById('mediaContent');
    
    if (type === 'image') {
        content.innerHTML = `<img src="${url}" class="max-w-full max-h-full object-contain" alt="Image">`;
    } else if (type === 'video') {
        content.innerHTML = `<video src="${url}" class="max-w-full max-h-full" controls autoplay></video>`;
    }
    
    viewer.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeMediaViewer() {
    const viewer = document.getElementById('mediaViewer');
    const content = document.getElementById('mediaContent');
    
    viewer.classList.add('hidden');
    content.innerHTML = '';
    document.body.style.overflow = 'auto';
}

// Mark conversation as read
function markConversationAsRead(conversationId) {
    fetch(`/inbox/${conversationId}/mark-read`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(() => {
        // Refresh conversations list to remove unread count
        loadConversationsList();
    })
    .catch(error => console.error('Error marking as read:', error));
}

// Make floating chat icon draggable
function makeChatIconDraggable() {
    const chatIcon = document.getElementById('floatingChatIcon');
    let isDragging = false;
    let startX, startY, initialX, initialY;
    
    // Check if icon should be hidden
    if (localStorage.getItem('chatIconHidden') === 'true') {
        chatIcon.style.display = 'none';
        return;
    }
    
    // Restore saved position
    const savedPosition = localStorage.getItem('chatIconPosition');
    if (savedPosition) {
        const { x, y } = JSON.parse(savedPosition);
        chatIcon.style.left = x + 'px';
        chatIcon.style.top = y + 'px';
        chatIcon.style.right = 'auto';
        chatIcon.style.bottom = 'auto';
    }
    
    chatIcon.addEventListener('mousedown', startDrag);
    chatIcon.addEventListener('touchstart', startDrag);
    
    function startDrag(e) {
        isDragging = true;
        
        if (e.type === 'mousedown') {
            startX = e.clientX;
            startY = e.clientY;
        } else {
            startX = e.touches[0].clientX;
            startY = e.touches[0].clientY;
        }
        
        const rect = chatIcon.getBoundingClientRect();
        initialX = rect.left;
        initialY = rect.top;
        
        document.addEventListener('mousemove', drag);
        document.addEventListener('touchmove', drag);
        document.addEventListener('mouseup', stopDrag);
        document.addEventListener('touchend', stopDrag);
        
        e.preventDefault();
    }
    
    function drag(e) {
        if (!isDragging) return;
        
        let currentX, currentY;
        if (e.type === 'mousemove') {
            currentX = e.clientX;
            currentY = e.clientY;
        } else {
            currentX = e.touches[0].clientX;
            currentY = e.touches[0].clientY;
        }
        
        const deltaX = currentX - startX;
        const deltaY = currentY - startY;
        
        const newX = initialX + deltaX;
        const newY = initialY + deltaY;
        
        // Keep within screen bounds
        const maxX = window.innerWidth - chatIcon.offsetWidth;
        const maxY = window.innerHeight - chatIcon.offsetHeight;
        
        const boundedX = Math.max(0, Math.min(newX, maxX));
        const boundedY = Math.max(0, Math.min(newY, maxY));
        
        chatIcon.style.left = boundedX + 'px';
        chatIcon.style.top = boundedY + 'px';
        chatIcon.style.right = 'auto';
        chatIcon.style.bottom = 'auto';
        
        // Save position to localStorage
        localStorage.setItem('chatIconPosition', JSON.stringify({ x: boundedX, y: boundedY }));
    }
    
    function stopDrag() {
        isDragging = false;
        document.removeEventListener('mousemove', drag);
        document.removeEventListener('touchmove', drag);
        document.removeEventListener('mouseup', stopDrag);
        document.removeEventListener('touchend', stopDrag);
    }
}
</script>