<x-affiliate-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Notifications') }}
        </h2>
    </x-slot>

    <div class="py-4 sm:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">Affiliate Notifications</h3>
                <div class="flex flex-col sm:flex-row gap-2 w-full sm:w-auto">
                    <button id="markAllReadBtn" class="bg-purple-500 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded text-sm">
                        Mark All as Read
                    </button>
                </div>
            </div>

            @if($notifications->count() > 0)
                <div class="space-y-4 scrollbar-thin">
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
                                        {{ $data['message'] ?? 'Notification' }}
                                    </p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                        {{ $notification->created_at->diffForHumans() }}
                                    </p>
                                    @if(!$notification->read_at)
                                        <button onclick="markAsRead('{{ $notification->id }}')" class="text-xs text-purple-600 dark:text-purple-400 hover:underline mt-2">
                                            Mark as read
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-6 overflow-x-auto">
                    {{ $notifications->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <i class="fas fa-bell-slash text-4xl text-gray-400 mb-4"></i>
                    <p class="text-gray-500 dark:text-gray-400">No notifications found</p>
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
        document.getElementById('markAllReadBtn').addEventListener('click', function() {
            const button = this;
            button.disabled = true;
            button.textContent = 'Marking...';
            
            // Database update FIRST
            fetch('/affiliate-notifications/mark-all-read', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json'
                }
            }).then(response => {
                if (!response.ok) {
                    throw new Error('Failed to mark all as read');
                }
                // Update UI after successful database update
                const notifications = document.querySelectorAll('.notification-item');
                notifications.forEach(notification => {
                    notification.classList.remove('bg-white', 'dark:bg-gray-800');
                    notification.classList.add('bg-gray-50', 'dark:bg-gray-700');
                    const markButton = notification.querySelector('button[onclick*="markAsRead"]');
                    if (markButton) markButton.remove();
                });
                
                button.textContent = 'Mark All as Read';
                button.disabled = false;
            }).catch((error) => {
                console.error('Error marking all as read:', error);
                button.textContent = 'Mark All as Read';
                button.disabled = false;
                alert('Failed to mark notifications as read. Please try again.');
            });
        });

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
            }
            
            // Background API call
            fetch(`/affiliate-notifications/${notificationId}/read`, {
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
                }
            });
        }
    </script>
    @endpush
</x-affiliate-layout>