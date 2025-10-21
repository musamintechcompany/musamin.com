<!-- Live Chat Floating Button -->
<div class="fixed right-5 bottom-24 z-[99999]" id="chatButtonContainer">
    <button id="chatButton" class="w-14 h-14 rounded-full bg-blue-500 hover:bg-blue-600 text-white shadow-lg flex items-center justify-center transition-all duration-200">
        <i class="fas fa-comments text-xl"></i>
    </button>
</div>

<!-- Chat Container -->
<div id="chatContainer" class="fixed right-5 bottom-20 w-96 h-[500px] bg-white rounded-lg shadow-xl z-[99999] opacity-0 transform translate-y-5 scale-95 transition-all duration-300 pointer-events-none">
    <!-- Chat Header -->
    <div class="p-4 bg-blue-500 text-white rounded-t-lg flex items-center justify-between">
        <div class="flex items-center">
            <div class="w-10 h-10 rounded-full overflow-hidden mr-3 border-2 border-white border-opacity-30">
                <img src="https://images.unsplash.com/photo-1614680376573-df3480f0c6ff?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=400&q=80" alt="Support Agent" id="agentAvatar" class="w-full h-full object-cover">
            </div>
            <div>
                <div class="font-semibold" id="agentName">ChatBot</div>
                <div class="flex items-center text-xs">
                    <div class="w-2 h-2 bg-green-400 rounded-full mr-2"></div>
                    <span id="statusText">Online</span>
                </div>
            </div>
        </div>
        <div class="flex items-center">
            <button class="w-8 h-8 rounded-full hover:bg-white hover:bg-opacity-10 flex items-center justify-center mr-2" id="menuToggle">
                <i class="fas fa-ellipsis-v"></i>
            </button>
            <button class="w-8 h-8 rounded-full hover:bg-white hover:bg-opacity-10 flex items-center justify-center" id="closeModal">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>

    <!-- Chat Messages -->
    <div class="flex-1 p-4 overflow-y-auto bg-gray-50" id="chatMessages" style="height: 380px;">
        <!-- Messages will be added here dynamically -->
    </div>

    <!-- Chat Input -->
    <div class="p-4 border-t bg-white rounded-b-lg flex items-center">
        <label for="fileInput" class="w-10 h-10 rounded-full hover:bg-gray-100 flex items-center justify-center cursor-pointer text-gray-500 hover:text-blue-500 mr-2">
            <i class="fas fa-paperclip"></i>
        </label>
        <input type="file" id="fileInput" class="hidden" accept="image/*,video/*,.pdf,.doc,.docx">
        <input type="text" placeholder="Type your message here..." id="messageInput" class="flex-1 px-3 py-2 border border-gray-300 rounded-full focus:outline-none focus:border-blue-500 mr-2">
        <button class="w-10 h-10 bg-blue-500 text-white rounded-full hover:bg-blue-600 flex items-center justify-center" id="sendBtn">
            <i class="fas fa-paper-plane"></i>
        </button>
    </div>

    <!-- Menu Items -->
    <div id="menuItems" class="absolute top-16 right-4 bg-white rounded-lg shadow-lg w-40 z-10 hidden">
        <div class="p-3 hover:bg-gray-50 cursor-pointer flex items-center" id="endChat">
            <i class="fas fa-times-circle text-blue-500 mr-3"></i>
            <span class="text-sm">End Chat</span>
        </div>
    </div>

    <!-- Rating Popup -->
    <div id="ratingPopup" class="absolute inset-0 bg-black bg-opacity-70 rounded-lg hidden">
        <div class="bg-white rounded-lg p-6 w-72 text-center absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
            <h3 class="text-lg font-semibold text-blue-500 mb-4">Rate Your Experience</h3>
            <p class="text-gray-600 mb-4">How would you rate your chat session?</p>
            <div class="flex justify-center mb-4" id="ratingStars">
                <span class="rating-star text-2xl text-gray-300 cursor-pointer mx-1 hover:text-yellow-400" data-value="1">★</span>
                <span class="rating-star text-2xl text-gray-300 cursor-pointer mx-1 hover:text-yellow-400" data-value="2">★</span>
                <span class="rating-star text-2xl text-gray-300 cursor-pointer mx-1 hover:text-yellow-400" data-value="3">★</span>
                <span class="rating-star text-2xl text-gray-300 cursor-pointer mx-1 hover:text-yellow-400" data-value="4">★</span>
                <span class="rating-star text-2xl text-gray-300 cursor-pointer mx-1 hover:text-yellow-400" data-value="5">★</span>
            </div>
            <textarea placeholder="Share your feedback (optional)" class="w-full p-3 border border-gray-300 rounded-lg mb-4 resize-none" rows="3"></textarea>
            <div class="flex gap-2">
                <button class="flex-1 px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300" id="cancelRating">Cancel</button>
                <button class="flex-1 px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600" id="submitRating">Submit</button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // DOM Elements
    const chatButton = document.getElementById('chatButton');
    const chatButtonContainer = document.getElementById('chatButtonContainer');
    const chatContainer = document.getElementById('chatContainer');
    const chatMessages = document.getElementById('chatMessages');
    const messageInput = document.getElementById('messageInput');
    const sendBtn = document.getElementById('sendBtn');
    const fileInput = document.getElementById('fileInput');
    const menuToggle = document.getElementById('menuToggle');
    const menuItems = document.getElementById('menuItems');
    const endChat = document.getElementById('endChat');
    const ratingPopup = document.getElementById('ratingPopup');
    const cancelRating = document.getElementById('cancelRating');
    const submitRating = document.getElementById('submitRating');
    const ratingStars = document.querySelectorAll('.rating-star');
    const agentAvatar = document.getElementById('agentAvatar');
    const agentName = document.getElementById('agentName');
    const statusText = document.getElementById('statusText');
    const closeModal = document.getElementById('closeModal');

    // State variables
    let selectedFile = null;
    let selectedRating = 0;
    let isChatWithAgent = false;
    let chatState = 'bot';

    // Initial bot messages
    const botMessages = [
        "Hello! I'm your virtual assistant. How can I help you today?",
        "I can answer common questions or connect you with a live agent.",
        "What would you like assistance with today?"
    ];

    // Quick reply options
    const quickReplies = [
        "Account issues",
        "Billing questions",
        "Technical support",
        "Connect me to an agent"
    ];

    // Initialize chat
    function initChat() {
        chatMessages.innerHTML = '';
        setTimeout(() => addMessage(botMessages[0], true, false, null, 'bot'), 500);
        setTimeout(() => addMessage(botMessages[1], true, false, null, 'bot'), 1500);
        setTimeout(() => addMessage(botMessages[2], true, false, null, 'bot'), 2500);
        setTimeout(() => addQuickReplies(quickReplies), 3500);

        chatState = 'bot';
        isChatWithAgent = false;
        agentAvatar.src = "https://images.unsplash.com/photo-1614680376573-df3480f0c6ff?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=400&q=80";
        agentName.textContent = "ChatBot";
        statusText.textContent = "Online";
    }

    // Toggle chat container
    chatButton.addEventListener('click', () => {
        chatContainer.classList.remove('opacity-0', 'translate-y-5', 'scale-95', 'pointer-events-none');
        chatContainer.classList.add('opacity-100', 'translate-y-0', 'scale-100', 'pointer-events-auto');
        chatButtonContainer.classList.add('hidden');
        if (chatMessages.children.length === 0) {
            initChat();
        }
    });

    // Close chat
    function closeChat() {
        chatContainer.classList.add('opacity-0', 'translate-y-5', 'scale-95', 'pointer-events-none');
        chatContainer.classList.remove('opacity-100', 'translate-y-0', 'scale-100', 'pointer-events-auto');
        chatButtonContainer.classList.remove('hidden');
        menuItems.classList.add('hidden');
    }

    closeModal.addEventListener('click', closeChat);

    // Function to add a new message
    function addMessage(content, isReceived, isFile = false, fileType = null, sender = 'user') {
        const messageDiv = document.createElement('div');

        if (content === 'agent_joined') {
            messageDiv.classList.add('text-center', 'my-2');
            messageDiv.innerHTML = `<div class="bg-gray-200 text-gray-600 text-xs py-1 px-3 rounded-full inline-block italic">Sarah Johnson joined the chat</div>`;
            chatMessages.appendChild(messageDiv);
            scrollToBottom();
            return;
        }

        messageDiv.classList.add('mb-4');

        const now = new Date();
        const timeString = now.getHours() + ':' + String(now.getMinutes()).padStart(2, '0');

        let messageHTML = '';

        if (isReceived) {
            messageHTML = `
                <div class="flex items-start space-x-2">
                    <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-robot text-white text-xs"></i>
                    </div>
                    <div>
                        <div class="bg-white p-3 rounded-lg shadow-sm max-w-xs">
                            <p class="text-sm text-gray-800 break-words"></p>
                        </div>
                        <div class="text-xs text-gray-500 mt-1 ml-2">${timeString}</div>
                    </div>
                </div>
            `;
        } else {
            messageHTML = `
                <div class="flex items-start space-x-2 justify-end">
                    <div>
                        <div class="bg-blue-500 text-white p-3 rounded-lg shadow-sm max-w-xs">
                            <p class="text-sm break-words"></p>
                        </div>
                        <div class="text-xs text-gray-500 mt-1 mr-2 text-right">${timeString}</div>
                    </div>
                    <div class="w-8 h-8 bg-gray-400 rounded-full flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-user text-white text-xs"></i>
                    </div>
                </div>
            `;
        }

        messageDiv.innerHTML = messageHTML;
        // Set text content safely to prevent XSS
        const textElement = messageDiv.querySelector('p');
        if (textElement) {
            textElement.textContent = content;
        }
        chatMessages.appendChild(messageDiv);
        scrollToBottom();

        if (!isReceived && chatState === 'bot') {
            setTimeout(() => generateBotResponse(content), 1000);
        }

        if (!isReceived && chatState === 'agent') {
            setTimeout(() => {
                showTypingIndicator();
                setTimeout(() => {
                    addMessage("Thank you for your message. I'll help you with that.", true, false, null, 'agent');
                }, 2000);
            }, 1000);
        }
    }

    // Function to add quick reply buttons
    function addQuickReplies(replies) {
        const quickReplyDiv = document.createElement('div');
        quickReplyDiv.classList.add('flex', 'flex-wrap', 'gap-2', 'mt-2', 'mb-4');

        replies.forEach(reply => {
            const button = document.createElement('button');
            button.classList.add('bg-gray-200', 'hover:bg-gray-300', 'text-gray-700', 'px-3', 'py-1', 'rounded-full', 'text-sm', 'transition-colors');
            button.textContent = reply;
            button.addEventListener('click', () => {
                handleQuickReply(reply);
                quickReplyDiv.remove();
            });
            quickReplyDiv.appendChild(button);
        });

        chatMessages.appendChild(quickReplyDiv);
        scrollToBottom();
    }

    // Handle quick reply selection
    function handleQuickReply(reply) {
        addMessage(reply, false);

        if (reply === "Connect me to an agent") {
            connectToAgent();
        } else {
            setTimeout(() => {
                addMessage(`I can help with ${reply.toLowerCase()}. What specific issue are you experiencing?`, true, false, null, 'bot');
                setTimeout(() => addQuickReplies(["I need more help", "Connect me to an agent"]), 500);
            }, 1000);
        }
    }

    // Connect to a live agent
    function connectToAgent() {
        chatState = 'agent';
        isChatWithAgent = true;

        setTimeout(() => {
            addMessage('agent_joined');
            agentAvatar.src = "https://images.unsplash.com/photo-1560250097-0b93528c311a?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=400&q=80";
            agentName.textContent = "Sarah Johnson";

            setTimeout(() => {
                addMessage("Hello! I'm Sarah, a customer support agent. How can I assist you today?", true, false, null, 'agent');
            }, 1000);
        }, 1500);
    }

    // Generate bot response
    function generateBotResponse(userMessage) {
        const lowerMessage = userMessage.toLowerCase();
        let response = "";

        if (lowerMessage.includes("account")) {
            response = "For account issues, please make sure you're using the correct login credentials. Would you like to reset your password?";
        } else if (lowerMessage.includes("billing") || lowerMessage.includes("payment")) {
            response = "For billing questions, I can check your account status. Could you provide your account email?";
        } else if (lowerMessage.includes("technical") || lowerMessage.includes("error")) {
            response = "For technical support, please describe the issue you're experiencing in more detail.";
        } else {
            response = "I'm not sure I understand. Could you please provide more details?";
        }

        showTypingIndicator();
        setTimeout(() => {
            addMessage(response, true, false, null, 'bot');
            setTimeout(() => addQuickReplies(["Yes, reset my password", "No, that's not it", "Connect me to an agent"]), 500);
        }, 2000);
    }

    // Show typing indicator
    function showTypingIndicator() {
        const indicator = document.createElement('div');
        indicator.classList.add('flex', 'items-center', 'space-x-2', 'mb-4', 'typing-indicator');
        indicator.innerHTML = `
            <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center">
                <i class="fas fa-robot text-white text-xs"></i>
            </div>
            <div class="bg-white p-3 rounded-lg shadow-sm">
                <p class="text-sm text-gray-500 italic">${chatState === 'bot' ? 'ChatBot' : 'Sarah'} is typing...</p>
            </div>
        `;
        chatMessages.appendChild(indicator);
        scrollToBottom();

        // Store reference to remove specific indicator
        setTimeout(() => {
            if (indicator.parentNode) {
                indicator.remove();
            }
        }, 2000);
    }

    // Scroll to bottom of chat
    function scrollToBottom() {
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }

    // Send message
    function sendMessage() {
        if (messageInput.value.trim() !== '' || selectedFile) {
            if (selectedFile) {
                addMessage(selectedFile.name, false, true, selectedFile.type);
                selectedFile = null;
            }

            if (messageInput.value.trim() !== '') {
                addMessage(messageInput.value, false);
            }

            messageInput.value = '';
        }
    }

    sendBtn.addEventListener('click', sendMessage);
    messageInput.addEventListener('keypress', (e) => {
        if (e.key === 'Enter') {
            sendMessage();
        }
    });

    // File input
    fileInput.addEventListener('change', (e) => {
        if (e.target.files.length > 0) {
            selectedFile = e.target.files[0];
            addMessage(selectedFile.name, false, true, selectedFile.type);
        }
    });

    // Menu toggle
    menuToggle.addEventListener('click', (e) => {
        e.stopPropagation();
        menuItems.classList.toggle('hidden');
    });

    // Close menu when clicking outside
    document.addEventListener('click', () => {
        menuItems.classList.add('hidden');
    });

    // End chat
    endChat.addEventListener('click', () => {
        menuItems.classList.add('hidden');
        ratingPopup.classList.remove('hidden');
    });

    // Rating functionality
    cancelRating.addEventListener('click', () => {
        ratingPopup.classList.add('hidden');
    });

    submitRating.addEventListener('click', () => {
        ratingPopup.classList.add('hidden');
        addMessage("You ended the chat session. Thank you for your feedback!", false);
        setTimeout(() => {
            closeChat();
            setTimeout(initChat, 300);
        }, 2000);
    });

    // Rating stars
    ratingStars.forEach(star => {
        star.addEventListener('click', () => {
            const value = parseInt(star.getAttribute('data-value'));
            selectedRating = value;

            ratingStars.forEach(s => {
                const starValue = parseInt(s.getAttribute('data-value'));
                if (starValue <= value) {
                    s.classList.remove('text-gray-300');
                    s.classList.add('text-yellow-400');
                } else {
                    s.classList.add('text-gray-300');
                    s.classList.remove('text-yellow-400');
                }
            });
        });
    });
});
</script>
