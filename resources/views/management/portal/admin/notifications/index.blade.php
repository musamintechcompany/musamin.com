<x-admin-layout>
    <div class="py-4 sm:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">All Notifications</h3>
                <div class="flex flex-col sm:flex-row gap-2 w-full sm:w-auto">
                    <button id="markAllReadBtn" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-sm">
                        Mark All as Read
                    </button>
                    @if(auth('admin')->user()->can('clear-notifications') || !auth('admin')->user()->roles()->exists())
                        <button onclick="showClearModal()" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded text-sm">
                            Clear All
                        </button>
                    @endif
                </div>
            </div>

            <div id="notificationsContainer">
                @if($notifications->count() > 0)
                    <div class="space-y-4 scrollbar-thin" id="notificationsList">
                        @foreach($notifications as $notification)
                            <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-3 sm:p-4 {{ $notification->read_at ? 'bg-gray-50 dark:bg-gray-700' : 'bg-white dark:bg-gray-800' }} break-words notification-item" data-id="{{ $notification->id }}">
                                <div class="flex items-start">
                                    <div class="flex-shrink-0">
                                        @php
                                            $data = $notification->data;
                                            $iconClass = match($data['color'] ?? 'gray') {
                                                'green' => 'text-green-500',
                                                'blue' => 'text-blue-500',
                                                'yellow' => 'text-yellow-500',
                                                'red' => 'text-red-500',
                                                'purple' => 'text-purple-500',
                                                default => 'text-gray-500'
                                            };
                                        @endphp
                                        <i class="fas fa-{{ $data['icon'] ?? 'bell' }} {{ $iconClass }} text-xl"></i>
                                    </div>
                                    <div class="ml-3 sm:ml-4 flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-900 dark:text-white">
                                            {!! $data['message'] ?? 'Notification' !!}
                                        </p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                            {{ $notification->created_at->diffForHumans() }}
                                        </p>
                                        @if(!$notification->read_at)
                                            <button onclick="markAsRead('{{ $notification->id }}')" class="text-xs text-blue-600 dark:text-blue-400 hover:underline mt-2">
                                                Mark as read
                                            </button>
                                        @endif
                                    </div>
                                    @if(isset($data['action_url']) && $data['action_url'])
                                        @php
                                            $showViewButton = true;
                                            // Check if this is a user-related notification that requires view-users permission
                                            if (str_contains($notification->type, 'UserRegistered') || str_contains($notification->type, 'UserJoined')) {
                                                $showViewButton = auth('admin')->user()->can('view-users') || !auth('admin')->user()->roles()->exists();
                                            }
                                        @endphp
                                        @if($showViewButton)
                                            <div class="ml-3 sm:ml-4 mt-2 sm:mt-0">
                                                <a href="{{ $data['action_url'] }}" class="text-blue-600 dark:text-blue-400 hover:underline text-sm whitespace-nowrap">
                                                    View
                                                </a>
                                            </div>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12" id="emptyState">
                        <i class="fas fa-bell-slash text-4xl text-gray-400 mb-4"></i>
                        <p class="text-gray-500 dark:text-gray-400">No notifications found</p>
                    </div>
                @endif
            </div>

            @if($notifications->count() > 0)
                <div class="mt-6 overflow-x-auto">
                    {{ $notifications->links() }}
                </div>
            @endif
        </div>
    </div>

    <style>
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
    </style>

    @push('scripts')
    <script>
        let notificationCount = {{ $notifications->where('read_at', null)->count() }};
        
        // Real-time notifications using Reverb
        window.Echo.private('admin.{{ auth("admin")->id() }}')
            .notification((notification) => {
                addNotificationToPage(notification);
                notificationCount++;
                updatePageTitle();
            });

        function addNotificationToPage(notification) {
            const container = document.getElementById('notificationsContainer');
            const emptyState = document.getElementById('emptyState');
            
            if (emptyState) {
                emptyState.remove();
            }
            
            let notificationsList = document.getElementById('notificationsList');
            if (!notificationsList) {
                notificationsList = document.createElement('div');
                notificationsList.className = 'space-y-4 scrollbar-thin';
                notificationsList.id = 'notificationsList';
                container.appendChild(notificationsList);
            }
            
            const iconClass = {
                'green': 'text-green-500',
                'blue': 'text-blue-500', 
                'yellow': 'text-yellow-500',
                'red': 'text-red-500',
                'purple': 'text-purple-500'
            }[notification.color] || 'text-gray-500';
            
            // Check if view button should be shown based on notification type
            const isUserNotification = notification.type === 'user_registered' || notification.type === 'user_joined';
            const showViewButton = notification.action_url && (!isUserNotification || {{ auth('admin')->user()->can('view-users') || !auth('admin')->user()->roles()->exists() ? 'true' : 'false' }});
            
            const notificationHtml = `
                <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-3 sm:p-4 bg-white dark:bg-gray-800 break-words notification-item animate-pulse" data-id="${notification.id}">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <i class="fas fa-${notification.icon || 'bell'} ${iconClass} text-xl"></i>
                        </div>
                        <div class="ml-3 sm:ml-4 flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 dark:text-white">
                                ${notification.message || 'Notification'}
                            </p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                Just now
                            </p>
                            <button onclick="markAsRead('${notification.id}')" class="text-xs text-blue-600 dark:text-blue-400 hover:underline mt-2">
                                Mark as read
                            </button>
                        </div>
                        ${showViewButton ? `
                            <div class="ml-3 sm:ml-4 mt-2 sm:mt-0">
                                <a href="${notification.action_url}" class="text-blue-600 dark:text-blue-400 hover:underline text-sm whitespace-nowrap">
                                    View
                                </a>
                            </div>
                        ` : ''}
                    </div>
                </div>
            `;
            
            notificationsList.insertAdjacentHTML('afterbegin', notificationHtml);
            
            // Remove animation after 3 seconds
            setTimeout(() => {
                const newNotification = document.querySelector(`[data-id="${notification.id}"]`);
                if (newNotification) {
                    newNotification.classList.remove('animate-pulse');
                }
            }, 3000);
        }
        
        function updatePageTitle() {
            const originalTitle = 'All Notifications - {{ config("app.name") }}';
            if (notificationCount > 0) {
                document.title = `(${notificationCount}) ${originalTitle}`;
            } else {
                document.title = originalTitle;
            }
        }

        document.getElementById('markAllReadBtn').addEventListener('click', function() {
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
                    const notifications = document.querySelectorAll('.notification-item');
                    notifications.forEach(notification => {
                        notification.classList.remove('bg-white', 'dark:bg-gray-800');
                        notification.classList.add('bg-gray-50', 'dark:bg-gray-700');
                        const markButton = notification.querySelector('button[onclick*="markAsRead"]');
                        if (markButton) markButton.remove();
                    });
                    
                    notificationCount = 0;
                    updatePageTitle();
                    console.log('All notifications marked as read in database');
                } else {
                    throw new Error('Failed to mark all as read');
                }
            }).catch((error) => {
                console.error('Error marking all as read:', error);
                // Revert on error
                location.reload();
            });
        });

        function showClearModal() {
            const modal = document.createElement('div');
            modal.className = 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50';
            modal.innerHTML = `
                <div class="bg-white dark:bg-gray-800 rounded-lg p-6 max-w-md mx-4 shadow-xl">
                    <div class="flex items-center mb-4">
                        <i class="fas fa-exclamation-triangle text-red-500 text-2xl mr-3"></i>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Clear All Notifications</h3>
                    </div>
                    <p class="text-gray-600 dark:text-gray-300 mb-6">
                        Are you sure you want to permanently delete all notifications? This action cannot be undone.
                    </p>
                    <div class="flex justify-between gap-3">
                        <button onclick="closeModal()" class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400 transition-colors">
                            Cancel
                        </button>
                        <button onclick="confirmClear()" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600 transition-colors">
                            Yes, Clear It
                        </button>
                    </div>
                </div>
            `;
            
            document.body.appendChild(modal);
            
            window.closeModal = function() {
                modal.remove();
            };
            
            window.confirmClear = function() {
                modal.remove();
                clearAllNotifications();
            };
            
            modal.addEventListener('click', (e) => {
                if (e.target === modal) {
                    modal.remove();
                }
            });
        }
        
        function clearAllNotifications() {
            fetch('/management/portal/admin/notifications/clear-all', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json'
                }
            }).then(response => {
                if (response.ok) {
                    location.reload();
                } else {
                    alert('Error clearing notifications. Please try again.');
                }
            }).catch(() => {
                alert('Error clearing notifications. Please try again.');
            });
        }

        function markAsRead(notificationId) {
            // Instant UI update
            const notificationElement = document.querySelector(`[data-id="${notificationId}"]`);
            if (notificationElement) {
                notificationElement.classList.remove('bg-white', 'dark:bg-gray-800');
                notificationElement.classList.add('bg-gray-50', 'dark:bg-gray-700');
                const markButton = notificationElement.querySelector('button[onclick*="markAsRead"]');
                if (markButton) {
                    markButton.style.opacity = '0';
                    setTimeout(() => markButton.remove(), 200);
                }
                
                // Update count and title
                if (notificationCount > 0) {
                    notificationCount--;
                    updatePageTitle();
                }
            }
            
            // Background API call
            fetch(`/management/portal/admin/notifications/${notificationId}/read`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            }).catch(() => {
                // Revert on error
                if (notificationElement) {
                    notificationElement.classList.remove('bg-gray-50', 'dark:bg-gray-700');
                    notificationElement.classList.add('bg-white', 'dark:bg-gray-800');
                    if (markButton) {
                        markButton.style.opacity = '1';
                    }
                    notificationCount++;
                    updatePageTitle();
                }
            });
        }
        
        // Initialize page title
        updatePageTitle();
    </script>
    @endpush
</x-admin-layout>