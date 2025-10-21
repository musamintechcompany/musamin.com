<x-app-layout>

    <div class="py-4 sm:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Notification Tabs -->
            <div class="mb-6">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                    <div class="flex space-x-1 bg-gray-100 dark:bg-gray-700 p-1 rounded-lg">
                        <button onclick="switchTab('all')" id="allTab" class="px-4 py-2 text-sm font-medium rounded-md transition-colors tab-button">
                            All Notifications
                        </button>
                        <button onclick="switchTab('coins')" id="coinsTab" class="px-4 py-2 text-sm font-medium rounded-md transition-colors tab-button">
                            <i class="fas fa-coins mr-1"></i>
                            Coin Activities
                        </button>
                    </div>
                    <div class="flex flex-col sm:flex-row gap-2 w-full sm:w-auto">
                        <button id="markAllReadBtn" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-sm">
                            Mark All as Read
                        </button>
                    </div>
                </div>
            </div>

            <!-- All Notifications Tab -->
            <div id="allNotifications" class="tab-content">
                @if($notifications && $notifications->count() > 0)
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
                                            <button onclick="markAsRead('{{ $notification->id }}')" class="text-xs text-blue-600 dark:text-blue-400 hover:underline mt-2">
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

            <!-- Coin Activities Tab -->
            <div id="coinActivities" class="tab-content hidden">
                @php
                    $coinNotifications = auth()->user()->notifications()
                        ->whereIn('type', [
                            'App\\Notifications\\CoinTransferNotification',
                            'App\\Notifications\\WithdrawalNotification',
                            'App\\Notifications\\WithdrawalRejectedNotification',
                            'App\\Notifications\\PurchaseNotification',
                            'App\\Notifications\\SaleNotification',
                            'App\\Notifications\\CoinPackageNotification',
                            'App\\Notifications\\CoinPurchaseNotification',
                            'App\\Notifications\\AffiliateFeeNotification'
                        ])
                        ->latest()
                        ->paginate(15);
                @endphp
                
                @if($coinNotifications && $coinNotifications->count() > 0)
                    <div class="space-y-4 scrollbar-thin">
                        @foreach($coinNotifications as $notification)
                            @php
                                $data = $notification->data;
                                $type = $data['type'] ?? 'unknown';
                                
                                // Use consistent exchange-alt icon for all coin activities
                                $iconConfig = [
                                    'icon' => 'exchange-alt',
                                    'color' => 'text-purple-500'
                                ];
                                
                                $amount = $data['amount'] ?? 0;
                                $isPositive = in_array($type, ['external_transfer_received', 'sale', 'coin_package_purchase', 'coin_purchase', 'withdrawal_declined']);
                            @endphp
                            
                            <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-3 sm:p-4 {{ $notification->read_at ? 'bg-gray-50 dark:bg-gray-700' : 'bg-white dark:bg-gray-800' }} break-words notification-item cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors" data-id="{{ $notification->id }}" onclick="openActivityModal({{ json_encode(array_merge($data, ['id' => $notification->id, 'created_at' => $notification->created_at->toISOString()])) }})">
                                <div class="flex items-start justify-between gap-2">
                                    <div class="flex items-start flex-1 min-w-0">
                                        <div class="flex-shrink-0">
                                            <i class="fas fa-{{ $iconConfig['icon'] }} {{ $iconConfig['color'] }} text-xl"></i>
                                        </div>
                                        <div class="ml-3 sm:ml-4 flex-1 min-w-0">
                                            <p class="text-sm font-medium text-gray-900 dark:text-white truncate sm:whitespace-normal">
                                                <span class="sm:hidden">{{ Str::limit($data['message'] ?? 'Coin Activity', 25) }}</span>
                                                <span class="hidden sm:inline">{{ $data['message'] ?? 'Coin Activity' }}</span>
                                            </p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                                {{ $notification->created_at->diffForHumans() }}
                                            </p>
                                            @if(!$notification->read_at)
                                                <button onclick="event.stopPropagation(); markAsRead('{{ $notification->id }}')" class="text-xs text-blue-600 dark:text-blue-400 hover:underline mt-2">
                                                    Mark as read
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                    @if($amount > 0)
                                        <div class="flex-shrink-0">
                                            <span class="px-2 py-1 text-xs sm:text-sm font-bold rounded-full whitespace-nowrap {{ $isPositive ? 'text-green-600 bg-green-100 dark:text-green-400 dark:bg-green-900 dark:bg-opacity-30' : 'text-red-600 bg-red-100 dark:text-red-400 dark:bg-red-900 dark:bg-opacity-30' }}">
                                                {{ $isPositive ? '+' : '-' }}{{ number_format($amount) }}
                                            </span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-6 overflow-x-auto">
                        {{ $coinNotifications->appends(['tab' => 'coins'])->links() }}
                    </div>
                @else
                    <div class="text-center py-12">
                        <i class="fas fa-coins text-4xl text-gray-400 mb-4"></i>
                        <p class="text-gray-500 dark:text-gray-400 mb-2">No coin activities yet</p>
                        <p class="text-sm text-gray-400">Your transfers, purchases, and withdrawals will appear here</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Include Modal Components -->
    @include('components.modals.coin-activity-modal')

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
        
        .tab-button {
            transition: all 0.2s ease;
        }
    </style>

    @push('scripts')
    <script>
        let currentTab = 'all';
        
        document.addEventListener('DOMContentLoaded', function() {
            // Check URL for tab parameter
            const urlParams = new URLSearchParams(window.location.search);
            const tabParam = urlParams.get('tab');
            if (tabParam === 'coins') {
                switchTab('coins');
            } else {
                switchTab('all');
            }
            
            // Listen for real-time notifications
            if (typeof Echo !== 'undefined') {
                Echo.private(`App.Models.User.{{ auth()->id() }}`)
                    .notification((notification) => {
                        console.log('📨 New notification on page:', notification);
                        // Reload page to show new notification
                        setTimeout(() => location.reload(), 1000);
                    });
            }
        });
        
        function switchTab(tab) {
            currentTab = tab;
            
            // Update tab buttons
            document.querySelectorAll('.tab-button').forEach(btn => {
                btn.classList.remove('bg-white', 'dark:bg-gray-600', 'text-gray-900', 'dark:text-white', 'shadow');
                btn.classList.add('text-gray-500', 'dark:text-gray-400');
            });
            
            document.getElementById(tab + 'Tab').classList.remove('text-gray-500', 'dark:text-gray-400');
            document.getElementById(tab + 'Tab').classList.add('bg-white', 'dark:bg-gray-600', 'text-gray-900', 'dark:text-white', 'shadow');
            
            // Update content
            document.querySelectorAll('.tab-content').forEach(content => {
                content.classList.add('hidden');
            });
            
            if (tab === 'all') {
                document.getElementById('allNotifications').classList.remove('hidden');
            } else {
                document.getElementById('coinActivities').classList.remove('hidden');
            }
            
            // Update URL without reload
            const url = new URL(window.location);
            if (tab === 'coins') {
                url.searchParams.set('tab', 'coins');
            } else {
                url.searchParams.delete('tab');
            }
            window.history.replaceState({}, '', url);
        }

        document.getElementById('markAllReadBtn').addEventListener('click', function() {
            // Instant UI update
            const notifications = document.querySelectorAll('.notification-item');
            notifications.forEach(notification => {
                notification.classList.remove('bg-white', 'dark:bg-gray-800');
                notification.classList.add('bg-gray-50', 'dark:bg-gray-700');
                const markButton = notification.querySelector('button[onclick*="markAsRead"]');
                if (markButton) markButton.remove();
            });
            
            // Background API call
            fetch('/notifications/mark-all-read', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json'
                }
            }).catch(() => {
                location.reload();
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
            fetch(`/notifications/${notificationId}/read`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            }).catch(() => {
                if (notificationElement) {
                    notificationElement.classList.remove('bg-gray-50', 'dark:bg-gray-700');
                    notificationElement.classList.add('bg-white', 'dark:bg-gray-800');
                }
            });
        }
        
        // Global function to open activity modal
        window.openActivityModal = function(activityData) {
            window.dispatchEvent(new CustomEvent('open-coin-activity-modal', { detail: activityData }));
        };
    </script>
    @endpush
</x-app-layout>