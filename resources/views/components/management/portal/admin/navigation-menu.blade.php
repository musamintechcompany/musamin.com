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
        .scrollbar-thin {
            scrollbar-width: thin;
        }
        .scrollbar-thin::-webkit-scrollbar {
            width: 4px;
        }
        .scrollbar-thin::-webkit-scrollbar-track {
            background: transparent;
        }
        .scrollbar-thin::-webkit-scrollbar-thumb {
            background-color: rgba(156, 163, 175, 0.5);
            border-radius: 2px;
        }
        .scrollbar-thin::-webkit-scrollbar-thumb:hover {
            background-color: rgba(156, 163, 175, 0.8);
        }
        .notification-shake {
            animation: shake 0.5s ease-in-out infinite;
        }
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-2px) rotate(-2deg); }
            75% { transform: translateX(2px) rotate(2deg); }
        }
    </style>

    <div class="flex items-center justify-between p-4">
        <div class="flex items-center gap-4">
            <button id="adminSidebarToggle" class="p-2 text-gray-600 transition-colors rounded dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700" onclick="toggleAdminSidebar()">
                <i class="text-xl fas fa-bars"></i>
            </button>
            <div class="hidden md:flex items-center text-sm text-gray-600 dark:text-gray-400">
                <span class="text-gray-900 dark:text-white font-medium">Your Portal</span>
                <i class="fas fa-chevron-right mx-2 text-xs"></i>
                <span class="text-gray-900 dark:text-white font-semibold">
                    @php
                        $routeName = request()->route()->getName();
                        $currentPage = match($routeName) {
                            'admin.dashboard' => 'Dashboard',
                            'admin.users.index' => 'Users Management',
                            'admin.users.create' => 'Create User',
                            'admin.users.edit' => 'Edit User',
                            'admin.users.show' => 'View User',
                            'admin.coin-packages.index' => 'Coin Packages',
                            'admin.coin-packages.create' => 'Create Package',
                            'admin.coin-packages.edit' => 'Edit Package',
                            'admin.coin-packages.show' => 'View Package',
                            'admin.coin-transactions.pending' => 'Pending Transactions',
                            'admin.coin-transactions.history' => 'Transaction History',
                            'admin.coin-transactions.show' => 'Transaction Details',
                            'admin.payment-methods.index' => 'Payment Methods',
                            'admin.payment-methods.create' => 'Create Payment Method',
                            'admin.payment-methods.edit' => 'Edit Payment Method',
                            'admin.jobs.index' => 'Active Jobs',
                            'admin.jobs.batches' => 'Job Batches',
                            'admin.jobs.failed' => 'Failed Jobs',
                            default => 'Admin Panel'
                        };
                    @endphp
                    {{ $currentPage }}
                </span>
            </div>
        </div>
        <div class="flex items-center gap-4">
            @php
                $hasNotificationPermission = auth('admin')->user()->hasAnyPermission([
                    'receive-user-registered-notifications',
                    'receive-affiliate-notifications', 
                    'receive-coin-transaction-notifications',
                    'receive-kyc-notifications',
                    'receive-idea-notifications',
                    'receive-order-notifications',
                    'receive-system-notifications'
                ]) || !auth('admin')->user()->roles()->exists();
            @endphp
            
            @if($hasNotificationPermission)
            <div class="relative">
                <button id="adminNotificationButton" class="relative p-2 text-gray-600 transition-colors rounded-full dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                    <i id="notificationBellIcon" class="fas fa-bell"></i>
                    <span id="adminNotificationBadge" class="notification-badge" style="display: none">
                        0
                    </span>
                </button>
                <div id="adminNotificationDropdown" class="absolute right-0 z-50 hidden mt-2 bg-white border border-gray-200 rounded-md shadow-lg w-80 max-w-[calc(100vw-2rem)] dark:bg-gray-800 dark:border-gray-700">
                    <div class="p-3 border-b border-gray-200 dark:border-gray-700">
                        <div class="flex items-center justify-between">
                            <h3 class="font-medium text-gray-900 dark:text-white text-sm">Portal Notifications</h3>
                            <button id="adminMarkAllRead" class="text-xs text-blue-600 dark:text-blue-400 hover:underline whitespace-nowrap">Mark all read</button>
                        </div>
                    </div>
                    <div id="adminNotificationList" class="overflow-y-auto max-h-96 scrollbar-thin">
                        <div class="p-4 text-center text-gray-500 dark:text-gray-400">
                            <i class="fas fa-bell-slash text-2xl mb-2"></i>
                            <p class="text-sm">No notifications</p>
                        </div>
                    </div>
                    <div class="p-2 text-center border-t border-gray-200 dark:border-gray-700">
                        <a href="{{ route('admin.notifications.index') }}" class="text-sm text-blue-600 dark:text-blue-400 hover:underline">View all</a>
                    </div>
                </div>
            </div>
            @endif
            <div class="relative">
                <button id="adminProfileButton" class="flex items-center p-1 transition-colors rounded-full hover:bg-gray-100 dark:hover:bg-gray-700">
                    <img class="w-8 h-8 transition-all rounded-full hover:ring-2 hover:ring-blue-500" src="https://ui-avatars.com/api/?name={{ urlencode(auth('admin')->user()->name) }}&background=6366f1&color=fff" alt="{{ auth('admin')->user()->name }}">
                </button>
                <div id="adminProfileDropdown" class="absolute right-0 z-50 hidden w-48 mt-2 bg-white border border-gray-200 rounded-md shadow-lg dark:bg-gray-800 dark:border-gray-700">
                    <a href="{{ route('admin.profile.index') }}" class="flex items-center w-full gap-2 px-4 py-2 text-sm text-left text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                        <i class="fas fa-user"></i>
                        Profile
                    </a>
                    <form method="POST" action="{{ route('admin.logout') }}">
                        @csrf
                        <button type="submit" class="flex items-center w-full gap-2 px-4 py-2 text-sm text-left text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                            <i class="fas fa-sign-out-alt"></i>
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const notificationButton = document.getElementById('adminNotificationButton');
            const notificationDropdown = document.getElementById('adminNotificationDropdown');
            const notificationBadge = document.getElementById('adminNotificationBadge');
            const notificationList = document.getElementById('adminNotificationList');
            const markAllRead = document.getElementById('adminMarkAllRead');
            const profileButton = document.getElementById('adminProfileButton');
            const profileDropdown = document.getElementById('adminProfileDropdown');
            const notificationSound = new Audio('/sounds/notification.mp3');

            // Load initial notifications
            loadAdminNotifications();

            // Listen for real-time notifications immediately
            if (window.Echo) {
                window.Echo.channel('admin-notifications')
                    .listen('.Illuminate\\Notifications\\Events\\BroadcastNotificationCreated', (e) => {
                        console.log('Admin notification received:', e);
                        playNotificationSound();
                        // Update count immediately
                        const currentCount = parseInt(notificationBadge.textContent) || 0;
                        updateNotificationBadge(currentCount + 1);
                        // Reload notifications to show the new one
                        loadAdminNotifications();
                    });
            }

            notificationButton.addEventListener('click', function() {
                notificationDropdown.classList.toggle('hidden');
                profileDropdown.classList.add('hidden');
                if (!notificationDropdown.classList.contains('hidden')) {
                    loadAdminNotifications();
                }
            });

            profileButton.addEventListener('click', function() {
                profileDropdown.classList.toggle('hidden');
                notificationDropdown.classList.add('hidden');
            });

            markAllRead.addEventListener('click', function() {
                // Background API call FIRST (synchronous approach)
                fetch('/management/portal/admin/notifications/mark-all-read', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Content-Type': 'application/json'
                    }
                }).then(response => {
                    if (response.ok) {
                        // Update UI after successful database update
                        updateNotificationBadge(0);
                        notificationList.innerHTML = `
                            <div class="p-4 text-center text-gray-500 dark:text-gray-400">
                                <i class="fas fa-bell-slash text-2xl mb-2"></i>
                                <p class="text-sm">No notifications</p>
                            </div>`;
                        console.log('All notifications marked as read in database');
                    } else {
                        throw new Error('Failed to mark all as read');
                    }
                }).catch((error) => {
                    console.error('Error marking all as read:', error);
                    // Revert on error
                    loadAdminNotifications();
                });
            });

            document.addEventListener('click', function(event) {
                if (!notificationButton.contains(event.target) && !notificationDropdown.contains(event.target)) {
                    notificationDropdown.classList.add('hidden');
                }
                if (!profileButton.contains(event.target) && !profileDropdown.contains(event.target)) {
                    profileDropdown.classList.add('hidden');
                }
            });

            function loadAdminNotifications() {
                fetch('/management/portal/admin/notifications/unread')
                    .then(response => response.json())
                    .then(data => {
                        updateNotificationBadge(data.count);
                        renderNotifications(data.notifications);
                    })
                    .catch(error => {
                        console.error('Error loading notifications:', error);
                    });
            }
            
            // Refresh notifications every 30 seconds as fallback
            setInterval(loadAdminNotifications, 30000);

            function updateNotificationBadge(count) {
                const bellIcon = document.getElementById('notificationBellIcon');
                if (count > 0) {
                    notificationBadge.textContent = count > 99 ? '99+' : count;
                    notificationBadge.style.display = 'flex';
                    // Add shake animation
                    if (bellIcon) {
                        bellIcon.classList.add('notification-shake');
                    }
                } else {
                    notificationBadge.style.display = 'none';
                    // Remove shake animation
                    if (bellIcon) {
                        bellIcon.classList.remove('notification-shake');
                    }
                }
            }

            function renderNotifications(notifications) {
                if (!notifications || notifications.length === 0) {
                    notificationList.innerHTML = `
                        <div class="p-4 text-center text-gray-500 dark:text-gray-400">
                            <i class="fas fa-bell-slash text-2xl mb-2"></i>
                            <p>No notifications</p>
                        </div>`;
                    return;
                }

                notificationList.innerHTML = notifications.map(notification => {
                    const data = notification.data || {};
                    const iconClass = getIconClass(data.icon || 'bell', data.color || 'gray');
                    const message = data.message || 'New notification';
                    const actionUrl = data.action_url || '#';
                    
                    return `
                        <div class="p-3 border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 cursor-pointer" onclick="markAsRead('${notification.id}', '${actionUrl}')">
                            <div class="flex items-start">
                                <div class="flex-shrink-0 pt-0.5">
                                    <i class="${iconClass} text-sm"></i>
                                </div>
                                <div class="ml-3 flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 dark:text-white break-words">${message}</p>
                                    <p class="text-xs text-gray-400">${formatDate(notification.created_at)}</p>
                                </div>
                            </div>
                        </div>`;
                }).join('');
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
                try {
                    const date = new Date(dateString);
                    const now = new Date();
                    const diffInMinutes = Math.floor((now - date) / (1000 * 60));
                    
                    if (diffInMinutes < 1) return 'Just now';
                    if (diffInMinutes < 60) return `${diffInMinutes}m ago`;
                    if (diffInMinutes < 1440) return `${Math.floor(diffInMinutes / 60)}h ago`;
                    return `${Math.floor(diffInMinutes / 1440)}d ago`;
                } catch (e) {
                    return 'Recently';
                }
            }

            function markAsRead(notificationId, actionUrl) {
                // Instant UI update
                const currentCount = parseInt(notificationBadge.textContent) || 0;
                if (currentCount > 0) {
                    updateNotificationBadge(currentCount - 1);
                }
                
                // Remove notification from dropdown instantly
                const notificationElement = document.querySelector(`[onclick*="${notificationId}"]`);
                if (notificationElement) {
                    notificationElement.style.opacity = '0.5';
                    notificationElement.style.pointerEvents = 'none';
                }
                
                // Background API call
                fetch(`/management/portal/admin/notifications/${notificationId}/read`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                }).then(() => {
                    if (actionUrl && actionUrl !== '#') {
                        window.location.href = actionUrl;
                    }
                }).catch(() => {
                    // Revert on error
                    if (notificationElement) {
                        notificationElement.style.opacity = '1';
                        notificationElement.style.pointerEvents = 'auto';
                    }
                    updateNotificationBadge(currentCount);
                });
            }

            function playNotificationSound() {
                notificationSound.volume = 0.3;
                notificationSound.play().catch(e => {
                    console.log('Sound play failed (browser autoplay policy):', e);
                    // Try to enable sound on next user interaction
                    document.addEventListener('click', function enableSound() {
                        notificationSound.play().catch(() => {});
                        document.removeEventListener('click', enableSound);
                    }, { once: true });
                });
            }
            
            // Test sound function (call this manually to test)
            window.testNotificationSound = function() {
                playNotificationSound();
                console.log('Test sound played');
            };
            
            // Enable sound on first click
            window.enableSoundOnFirstClick = function() {
                notificationSound.play().catch(() => {});
            };


        });
    </script>
    @endpush
</header>
