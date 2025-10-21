<header class="bg-white shadow-sm dark:bg-gray-800">
    <style>
        .header-shadow {
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .dark .header-shadow {
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }
        .notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background-color: #ef4444;
            color: white;
            border-radius: 9999px;
            height: 20px;
            width: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.75rem;
            font-weight: 600;
        }
    </style>

    <div class="flex items-center justify-between p-4">
        <div class="flex items-center gap-4">
            <button id="sidebarToggle" class="text-gray-600 dark:text-gray-300">
                <i class="text-xl fas fa-bars"></i>
            </button>
        </div>
        <div class="flex items-center gap-4">

            <a href="{{ route('cart.index') }}" class="relative p-2 text-gray-600 rounded-full dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                <i class="fas fa-shopping-cart"></i>
                <span class="notification-badge" style="display: none" id="cartBadge">
                    0
                </span>
            </a>
            <a href="{{ route('notifications.index') }}" class="relative p-2 text-gray-600 rounded-full dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                <i class="fas fa-bell"></i>
                <span id="notificationBadge" class="notification-badge" style="display: none">
                    0
                </span>
            </a>
            @auth
                <a href="{{ route('profile.details') }}" class="flex text-sm transition border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 hover:border-blue-500">
                    <img class="w-10 h-10 rounded-full" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                </a>
            @endauth
        </div>
    </div>



    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const notificationBadge = document.getElementById('notificationBadge');
            let notificationSound;
            try {
                notificationSound = new Audio('/sounds/notification.mp3');
            } catch (error) {
                console.log('Notification sound file not found');
            }

            // Load initial notifications, cart count, and inbox count
            loadNotifications();
            loadCartCount();
            loadInboxCount();
            
            // Update inbox count every 30 seconds
            setInterval(loadInboxCount, 30000);
            
            // Sync guest cart to database if user is authenticated
            syncGuestCart();

            // Setup Echo listeners when available
            function setupEchoListeners() {
                if (typeof Echo !== 'undefined') {
                    console.log('✅ Setting up Echo listeners');
                    Echo.private(`App.Models.User.{{ auth()->id() }}`)
                        .notification((notification) => {
                            console.log('📨 Notification received:', notification);
                            playNotificationSound();
                            showToast(notification);
                            loadNotifications();
                        })
                        .listen('MessageSent', (e) => {
                            console.log('📨 Message received globally:', e);
                            // Only handle if not own message
                            if (e.message.sender_id !== '{{ auth()->id() }}') {
                                // Always update inbox count
                                loadInboxCount();
                                
                                // Only show sound/toast if not on inbox page
                                if (!window.location.pathname.startsWith('/inbox')) {
                                    playMessageSound();
                                    showMessageToast(e.message);
                                }
                            }
                        })
                        .error((error) => {
                            console.error('❌ Echo channel error:', error);
                        });
                } else {
                    console.log('⏳ Echo not ready, retrying...');
                    setTimeout(setupEchoListeners, 100);
                }
            }
            setupEchoListeners();



            function loadNotifications() {
                fetch('/notifications/unread')
                    .then(response => response.json())
                    .then(data => {
                        updateNotificationBadge(data.count);
                    });
            }

            function updateNotificationBadge(count) {
                if (count > 0) {
                    notificationBadge.textContent = count > 99 ? '99+' : count;
                    notificationBadge.style.display = 'flex';
                } else {
                    notificationBadge.style.display = 'none';
                }
            }



            function getIconClass(icon, color) {
                const colorClass = {
                    'green': 'text-green-500',
                    'blue': 'text-blue-500',
                    'yellow': 'text-yellow-500',
                    'red': 'text-red-500',
                    'purple': 'text-purple-500'
                }[color] || 'text-gray-500';
                return `fas fa-${icon} ${colorClass}`;
            }

            function formatDate(dateString) {
                return new Date(dateString).toLocaleString();
            }



            function playNotificationSound() {
                try {
                    if (notificationSound) {
                        notificationSound.play().catch(() => {
                            console.log('Notification sound failed to play');
                        });
                    }
                } catch (error) {
                    console.log('Notification sound not available');
                }
            }

            function loadCartCount() {
                fetch('/cart/count')
                    .then(response => response.json())
                    .then(data => updateCartBadge(data.count))
                    .catch(() => updateCartBadge(0));
            }
            
            function updateCartBadge(count) {
                const cartBadge = document.getElementById('cartBadge');
                if (cartBadge) {
                    if (count > 0) {
                        cartBadge.textContent = count > 99 ? '99+' : count;
                        cartBadge.style.display = 'flex';
                    } else {
                        cartBadge.style.display = 'none';
                    }
                }
            }
            
            function showToast(notification) {
                const data = notification.data || notification;
                const toast = document.createElement('div');
                toast.className = 'fixed top-4 right-4 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-lg p-4 z-50 max-w-sm';
                toast.innerHTML = `
                    <div class="flex items-start">
                        <i class="fas fa-${data.icon || 'bell'} ${getIconClass(data.icon, data.color)} mr-3 mt-1"></i>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-900 dark:text-white">${data.message || 'New notification'}</p>
                        </div>
                        <button onclick="this.parentElement.parentElement.remove()" class="ml-2 text-gray-400 hover:text-gray-600">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>`;
                document.body.appendChild(toast);
                setTimeout(() => toast.remove(), 5000);
            }
            
            function syncGuestCart() {
                const guestCart = JSON.parse(sessionStorage.getItem('cart') || '{}');
                if (Object.keys(guestCart).length > 0) {
                    fetch('/cart/sync', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            sessionStorage.removeItem('cart');
                            updateCartBadge(data.cart_count);
                        }
                    })
                    .catch(() => {});
                } else {
                    loadCartCount();
                }
            }
            
            function playMessageSound() {
                try {
                    const messageSound = new Audio('/sounds/chat.mp3');
                    messageSound.volume = 0.5;
                    messageSound.play().catch(e => console.log('Message sound failed:', e));
                } catch (error) {
                    console.log('Message sound not available');
                }
            }
            
            function showMessageToast(message) {
                const toast = document.createElement('div');
                toast.className = 'fixed top-4 right-4 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-lg p-4 z-50 max-w-sm';
                toast.innerHTML = `
                    <div class="flex items-start">
                        <i class="fas fa-envelope text-purple-500 mr-3 mt-1"></i>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-900 dark:text-white">New message from ${message.sender.name}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">${message.message || 'Sent a file'}</p>
                        </div>
                        <button onclick="this.parentElement.parentElement.remove()" class="ml-2 text-gray-400 hover:text-gray-600">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>`;
                document.body.appendChild(toast);
                setTimeout(() => toast.remove(), 5000);
                
                // Show browser push notification
                if ('Notification' in window && Notification.permission === 'granted') {
                    new Notification(`New message from ${message.sender.name}`, {
                        body: message.message || 'Sent a file',
                        icon: '/favicon.ico',
                        tag: 'chat-message'
                    });
                }
            }
            
            function loadInboxCount() {
                fetch('/inbox/unread/count')
                    .then(response => response.json())
                    .then(data => {
                        // Update sidebar badge
                        if (window.updateInboxBadge) {
                            window.updateInboxBadge(data.count);
                        }
                        // Update mobile bottom nav badge
                        if (window.updateMobileInboxBadge) {
                            window.updateMobileInboxBadge(data.count);
                        }
                    })
                    .catch(() => {
                        if (window.updateInboxBadge) {
                            window.updateInboxBadge(0);
                        }
                        if (window.updateMobileInboxBadge) {
                            window.updateMobileInboxBadge(0);
                        }
                    });
            }
            
            // Request notification permission
            if ('Notification' in window && Notification.permission === 'default') {
                Notification.requestPermission();
            }
        });
    </script>
    @endpush
</header>