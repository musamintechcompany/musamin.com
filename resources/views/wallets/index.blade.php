<x-app-layout>
    <div @class([
        'container p-4 mx-auto',
        'bg-gray-50' => auth()->user()->theme === 'light',
        'bg-gray-900' => auth()->user()->theme === 'dark'
    ])>
        <!-- Mobile View - Slider -->
        <div class="block md:hidden">
            <div x-data="mobileCarousel()" class="relative overflow-hidden">
                <!-- Slides Container -->
                <div class="flex transition-transform duration-300"
                     x-ref="slider"
                     :style="`transform: translateX(-${activeSlide * 100}%)`"
                     @mousedown="startDrag($event)"
                     @mousemove="handleDrag($event)"
                     @mouseup="endDrag($event)"
                     @mouseleave="endDrag($event)"
                     @touchstart.passive="startDrag($event)"
                     @touchmove.passive="handleDrag($event)"
                     @touchend.passive="endDrag($event)">

                    <!-- Spendable Coins Card -->
                    <div class="flex-shrink-0 w-full p-1">
                        <div class="h-full p-4 rounded-xl bg-gradient-to-br from-blue-500 to-blue-600">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center justify-between mb-2">
                                        <h3 class="text-lg font-semibold text-white">SPENDABLE</h3>
                                        <i class="text-2xl text-white fas fa-wallet opacity-90"></i>
                                    </div>

                                    <p class="text-3xl font-bold text-white my-2 flex items-center">
                                        <i class="mr-2 text-2xl text-yellow-300 fas fa-coins"></i>
                                        <span data-balance-type="spendable" class="inline-block min-w-[3rem]">
                                            {{ number_format(auth()->user()->spendable_coins ?? 0) }}
                                        </span>
                                    </p>

                                    <div class="flex items-center justify-between mt-3">
                                        <button class="wallet-id"
                                                x-data="{ copied: false }"
                                                @click="
                                                    copied = copyToClipboard('{{ auth()->user()->spending_wallet_id }}');
                                                    setTimeout(() => copied = false, 2000);
                                                "
                                                aria-label="Copy wallet ID"
                                                tabindex="0">
                                            <span x-show="!copied">{{ auth()->user()->spending_wallet_id ?? 'Not available' }}</span>
                                            <span x-show="copied" class="copy-feedback">Copied!</span>
                                            <i x-show="!copied" class="ml-1 fas fa-copy text-xs"></i>
                                        </button>
                                        <span class="text-sm font-medium text-white">
                                            ≈ ${{ number_format((auth()->user()->spendable_coins ?? 0) * 0.01, 2) }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Earned Coins Card -->
                    <div class="flex-shrink-0 w-full p-1">
                        <div class="h-full p-4 rounded-xl bg-gradient-to-br from-green-500 to-green-600">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center justify-between mb-2">
                                        <h3 class="text-lg font-semibold text-white">EARNED</h3>
                                        <i class="text-2xl text-white fas fa-trophy opacity-90"></i>
                                    </div>

                                    <p class="text-3xl font-bold text-white my-2 flex items-center">
                                        <i class="mr-2 text-2xl text-yellow-300 fas fa-coins"></i>
                                        <span data-balance-type="earned" class="inline-block min-w-[3rem]">
                                            {{ number_format(auth()->user()->earned_coins ?? 0) }}
                                        </span>
                                    </p>

                                    <div class="flex items-center justify-between mt-3">
                                        <button class="wallet-id"
                                                x-data="{ copied: false }"
                                                @click="
                                                    copied = copyToClipboard('{{ auth()->user()->earned_wallet_id }}');
                                                    setTimeout(() => copied = false, 2000);
                                                "
                                                aria-label="Copy wallet ID"
                                                tabindex="0">
                                            <span x-show="!copied">{{ auth()->user()->earned_wallet_id ?? 'Not available' }}</span>
                                            <span x-show="copied" class="copy-feedback">Copied!</span>
                                            <i x-show="!copied" class="ml-1 fas fa-copy text-xs"></i>
                                        </button>
                                        <span class="text-sm font-medium text-white">
                                            ≈ ${{ number_format((auth()->user()->earned_coins ?? 0) * 0.01, 2) }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pending Earned Coins Card -->
                    <div class="flex-shrink-0 w-full p-1">
                        <div class="h-full p-4 rounded-xl bg-gradient-to-br from-orange-500 to-orange-600">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center justify-between mb-2">
                                        <h3 class="text-lg font-semibold text-white">PENDING</h3>
                                        <i class="text-2xl text-white fas fa-clock opacity-90"></i>
                                    </div>

                                    <p class="text-3xl font-bold text-white my-2 flex items-center">
                                        <i class="mr-2 text-2xl text-yellow-300 fas fa-coins"></i>
                                        <span data-balance-type="pending_earned" class="inline-block min-w-[3rem]">
                                            {{ number_format(auth()->user()->pending_earned_coins ?? 0) }}
                                        </span>
                                    </p>

                                    <div class="flex items-center justify-between mt-3">
                                        <span class="text-sm text-white opacity-75">On hold until completion</span>
                                        <span class="text-sm font-medium text-white">
                                            ≈ ${{ number_format((auth()->user()->pending_earned_coins ?? 0) * 0.01, 2) }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Slide Indicators -->
                <div class="flex justify-center mt-3 space-x-2">
                    <button @click="goToSlide(0)"
                            class="w-2 h-2 transition-all rounded-full"
                            :class="activeSlide === 0 ? 'bg-blue-500 w-4' : 'bg-gray-300 dark:bg-gray-600'"
                            aria-label="Go to spendable coins">
                    </button>
                    <button @click="goToSlide(1)"
                            class="w-2 h-2 transition-all rounded-full"
                            :class="activeSlide === 1 ? 'bg-green-500 w-4' : 'bg-gray-300 dark:bg-gray-600'"
                            aria-label="Go to earned coins">
                    </button>
                    <button @click="goToSlide(2)"
                            class="w-2 h-2 transition-all rounded-full"
                            :class="activeSlide === 2 ? 'bg-orange-500 w-4' : 'bg-gray-300 dark:bg-gray-600'"
                            aria-label="Go to pending coins">
                    </button>
                </div>
            </div>

            <!-- Action Buttons (Mobile - Below wallets) -->
            <div class="mt-4 space-y-3">
                <button onclick="window.dispatchEvent(new CustomEvent('open-coin-transfer-modal'))" @class([
                    'w-full px-6 py-3 text-sm font-medium text-white rounded-lg focus:outline-none focus:ring-2 transition-colors',
                    'bg-purple-600 border border-purple-500 hover:bg-purple-700 focus:ring-purple-500' => auth()->user()->theme === 'light',
                    'bg-purple-700 border border-purple-600 hover:bg-purple-800 focus:ring-purple-400' => auth()->user()->theme === 'dark'
                ])>
                    <i class="mr-2 fas fa-exchange-alt"></i>
                    Transfer Coins
                </button>
                @if(auth()->user()->kyc_status === 'approved')
                    <button onclick="window.dispatchEvent(new CustomEvent('open-withdrawal-modal'))" @class([
                        'w-full px-6 py-3 text-sm font-medium text-white rounded-lg focus:outline-none focus:ring-2 transition-colors',
                        'bg-green-600 border border-green-500 hover:bg-green-700 focus:ring-green-500' => auth()->user()->theme === 'light',
                        'bg-green-700 border border-green-600 hover:bg-green-800 focus:ring-green-400' => auth()->user()->theme === 'dark'
                    ])>
                        <i class="mr-2 fas fa-money-bill-wave"></i>
                        Withdraw Coins
                    </button>
                @else
                    <div class="w-full">
                        <button disabled @class([
                            'w-full px-6 py-3 text-sm font-medium rounded-lg cursor-not-allowed opacity-50',
                            'bg-gray-400 text-gray-600' => auth()->user()->theme === 'light',
                            'bg-gray-600 text-gray-400' => auth()->user()->theme === 'dark'
                        ])>
                            <i class="mr-2 fas fa-lock"></i>
                            Withdraw Coins
                        </button>
                        <p @class([
                            'text-xs mt-2 text-center',
                            'text-orange-600' => auth()->user()->theme === 'light',
                            'text-orange-400' => auth()->user()->theme === 'dark'
                        ])>
                            <i class="fas fa-exclamation-triangle mr-1"></i>
                            Complete KYC verification to withdraw. 
                            <a href="{{ route('settings.kyc') }}" class="underline hover:no-underline">Submit KYC</a>
                        </p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Desktop View - Grid -->
        <div class="hidden grid-cols-1 gap-4 md:grid md:grid-cols-3">
            <!-- Spendable Coins Card -->
            <div class="p-4 rounded-xl bg-gradient-to-br from-blue-500 to-blue-600">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="text-lg font-semibold text-white">SPENDABLE</h3>
                            <i class="text-2xl text-white fas fa-wallet opacity-90"></i>
                        </div>

                        <p class="text-3xl font-bold text-white my-2 flex items-center">
                            <i class="mr-2 text-2xl text-yellow-300 fas fa-coins"></i>
                            <span data-balance-type="spendable" class="inline-block min-w-[3rem]">
                                {{ number_format(auth()->user()->spendable_coins ?? 0) }}
                            </span>
                        </p>

                        <div class="flex items-center justify-between mt-3">
                            <button class="wallet-id"
                                    x-data="{ copied: false }"
                                    @click="
                                        copied = copyToClipboard('{{ auth()->user()->spending_wallet_id }}');
                                        setTimeout(() => copied = false, 2000);
                                    "
                                    aria-label="Copy wallet ID"
                                    tabindex="0">
                                <span x-show="!copied">{{ auth()->user()->spending_wallet_id ?? 'Not available' }}</span>
                                <span x-show="copied" class="copy-feedback">Copied!</span>
                                <i x-show="!copied" class="ml-1 fas fa-copy text-xs"></i>
                            </button>
                            <span class="text-sm font-medium text-white">
                                ≈ ${{ number_format((auth()->user()->spendable_coins ?? 0) * 0.01, 2) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Earned Coins Card -->
            <div class="p-4 rounded-xl bg-gradient-to-br from-green-500 to-green-600">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="text-lg font-semibold text-white">EARNED</h3>
                            <i class="text-2xl text-white fas fa-trophy opacity-90"></i>
                        </div>

                        <p class="text-3xl font-bold text-white my-2 flex items-center">
                            <i class="mr-2 text-2xl text-yellow-300 fas fa-coins"></i>
                            <span data-balance-type="earned" class="inline-block min-w-[3rem]">
                                {{ number_format(auth()->user()->earned_coins ?? 0) }}
                            </span>
                        </p>

                        <div class="flex items-center justify-between mt-3">
                            <button class="wallet-id"
                                    x-data="{ copied: false }"
                                    @click="
                                        copied = copyToClipboard('{{ auth()->user()->earned_wallet_id }}');
                                        setTimeout(() => copied = false, 2000);
                                    "
                                    aria-label="Copy wallet ID"
                                    tabindex="0">
                                <span x-show="!copied">{{ auth()->user()->earned_wallet_id ?? 'Not available' }}</span>
                                <span x-show="copied" class="copy-feedback">Copied!</span>
                                <i x-show="!copied" class="ml-1 fas fa-copy text-xs"></i>
                            </button>
                            <span class="text-sm font-medium text-white">
                                ≈ ${{ number_format((auth()->user()->earned_coins ?? 0) * 0.01, 2) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pending Earned Coins Card -->
            <div class="p-4 rounded-xl bg-gradient-to-br from-orange-500 to-orange-600">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="text-lg font-semibold text-white">PENDING</h3>
                            <i class="text-2xl text-white fas fa-clock opacity-90"></i>
                        </div>

                        <p class="text-3xl font-bold text-white my-2 flex items-center">
                            <i class="mr-2 text-2xl text-yellow-300 fas fa-coins"></i>
                            <span data-balance-type="pending_earned" class="inline-block min-w-[3rem]">
                                {{ number_format(auth()->user()->pending_earned_coins ?? 0) }}
                            </span>
                        </p>

                        <div class="flex items-center justify-between mt-3">
                            <span class="text-sm text-white opacity-75">On hold until completion</span>
                            <span class="text-sm font-medium text-white">
                                ≈ ${{ number_format((auth()->user()->pending_earned_coins ?? 0) * 0.01, 2) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons (Desktop - Below wallets) -->
        <div class="hidden md:block mt-4 space-y-3">
            <button onclick="window.dispatchEvent(new CustomEvent('open-coin-transfer-modal'))" @class([
                'w-full px-6 py-3 text-sm font-medium text-white rounded-lg focus:outline-none focus:ring-2 transition-colors',
                'bg-purple-600 border border-purple-500 hover:bg-purple-700 focus:ring-purple-500' => auth()->user()->theme === 'light',
                'bg-purple-700 border border-purple-600 hover:bg-purple-800 focus:ring-purple-400' => auth()->user()->theme === 'dark'
            ])>
                <i class="mr-2 fas fa-exchange-alt"></i>
                Transfer Coins
            </button>
            @if(auth()->user()->kyc_status === 'approved')
                <button onclick="window.dispatchEvent(new CustomEvent('open-withdrawal-modal'))" @class([
                    'w-full px-6 py-3 text-sm font-medium text-white rounded-lg focus:outline-none focus:ring-2 transition-colors',
                    'bg-green-600 border border-green-500 hover:bg-green-700 focus:ring-green-500' => auth()->user()->theme === 'light',
                    'bg-green-700 border border-green-600 hover:bg-green-800 focus:ring-green-400' => auth()->user()->theme === 'dark'
                ])>
                    <i class="mr-2 fas fa-money-bill-wave"></i>
                    Withdraw Coins
                </button>
            @else
                <div class="w-full">
                    <button disabled @class([
                        'w-full px-6 py-3 text-sm font-medium rounded-lg cursor-not-allowed opacity-50',
                        'bg-gray-400 text-gray-600' => auth()->user()->theme === 'light',
                        'bg-gray-600 text-gray-400' => auth()->user()->theme === 'dark'
                    ])>
                        <i class="mr-2 fas fa-lock"></i>
                        Withdraw Coins
                    </button>
                    <p @class([
                        'text-xs mt-2 text-center',
                        'text-orange-600' => auth()->user()->theme === 'light',
                        'text-orange-400' => auth()->user()->theme === 'dark'
                    ])>
                        <i class="fas fa-exclamation-triangle mr-1"></i>
                        Complete KYC verification to withdraw. 
                        <a href="{{ route('settings.kyc') }}" class="underline hover:no-underline">Submit KYC</a>
                    </p>
                </div>
            @endif
        </div>

        <!-- Coin Activities Section -->
        <div @class([
            'mt-6 p-6 rounded-xl shadow-sm',
            'bg-white border border-gray-200' => auth()->user()->theme === 'light',
            'bg-gray-800 border border-gray-700' => auth()->user()->theme === 'dark'
        ])>
            <div class="mb-6">
                <h2 @class([
                    'text-xl font-semibold',
                    'text-gray-900' => auth()->user()->theme === 'light',
                    'text-gray-200' => auth()->user()->theme === 'dark'
                ])>Recent Coin Activities</h2>
            </div>

            @php
                $coinActivities = auth()->user()->notifications()
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
                    ->take(6)
                    ->get();
            @endphp

            <div class="space-y-3">
                @forelse($coinActivities as $activity)
                    @php
                        $data = $activity->data;
                        $type = $data['type'] ?? 'unknown';
                        
                        // Use consistent exchange-alt icon for all coin activities
                        $iconConfig = [
                            'icon' => 'fas fa-exchange-alt',
                            'color' => 'bg-purple-500',
                            'message' => match($type) {
                                'internal_transfer' => 'Internal Transfer',
                                'external_transfer_sent' => 'Sent',
                                'external_transfer_received' => 'Received',
                                'withdrawal_submitted' => 'Withdrawal',
                                'withdrawal_declined' => 'Withdrawal Declined',
                                'purchase' => 'Purchase',
                                'sale' => 'Sale',
                                'coin_package_purchase' => 'Coin Package',
                                'coin_purchase' => 'Coin Purchase',
                                'affiliate_join' => 'Affiliate Fee',
                                'affiliate_renewal' => 'Affiliate Renewal',
                                default => 'Activity'
                            }
                        ];
                        
                        // Determine if amount is positive or negative
                        $amount = $data['amount'] ?? 0;
                        $isPositive = in_array($type, ['external_transfer_received', 'sale', 'coin_package_purchase', 'coin_purchase', 'withdrawal_declined']);
                    @endphp
                    
                    <div @class([
                        'flex items-center justify-between p-4 rounded-lg transition-colors cursor-pointer gap-2',
                        'bg-gray-100 hover:bg-gray-200' => auth()->user()->theme === 'light',
                        'bg-gray-700 hover:bg-gray-600' => auth()->user()->theme === 'dark'
                    ]) onclick="openActivityModal({{ json_encode(array_merge($data, ['id' => $activity->id, 'created_at' => $activity->created_at->toISOString()])) }})">
                        <div class="flex items-center space-x-3 flex-1 min-w-0">
                            <div class="flex items-center justify-center w-10 h-10 rounded-full {{ $iconConfig['color'] }} flex-shrink-0">
                                <i class="{{ $iconConfig['icon'] }} text-white"></i>
                            </div>
                            <div class="min-w-0 flex-1">
                                <p @class([
                                    'font-medium truncate',
                                    'text-gray-900' => auth()->user()->theme === 'light',
                                    'text-white' => auth()->user()->theme === 'dark'
                                ])>{{ $iconConfig['message'] }}</p>
                                <p @class([
                                    'text-sm',
                                    'text-gray-500' => auth()->user()->theme === 'light',
                                    'text-gray-400' => auth()->user()->theme === 'dark'
                                ])>{{ $activity->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                        @if($amount > 0)
                            <div class="flex-shrink-0">
                                <span @class([
                                    'px-2 py-1 text-xs sm:text-sm font-bold rounded-full whitespace-nowrap',
                                    $isPositive ? 'text-green-600 bg-green-100' : 'text-red-600 bg-red-100' => auth()->user()->theme === 'light',
                                    $isPositive ? 'text-green-400 bg-green-900 bg-opacity-30' : 'text-red-400 bg-red-900 bg-opacity-30' => auth()->user()->theme === 'dark'
                                ])>
                                    {{ $isPositive ? '+' : '-' }}{{ number_format($amount) }}
                                </span>
                            </div>
                        @endif
                    </div>
                @empty
                    <div class="text-center py-8">
                        <div class="flex items-center justify-center w-16 h-16 mx-auto mb-4 bg-gray-100 rounded-full dark:bg-gray-700">
                            <i class="text-2xl text-gray-400 fas fa-coins"></i>
                        </div>
                        <h3 @class([
                            'mb-2 text-lg font-medium',
                            'text-gray-900' => auth()->user()->theme === 'light',
                            'text-gray-100' => auth()->user()->theme === 'dark'
                        ])>No Coin Activities Yet</h3>
                        <p @class([
                            'text-gray-600' => auth()->user()->theme === 'light',
                            'text-gray-300' => auth()->user()->theme === 'dark'
                        ])>Your coin transactions will appear here</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col mt-6 space-y-3 md:flex-row md:justify-between md:space-y-0 md:gap-4">
            <button onclick="window.location.href='{{ route('notifications.index') }}?tab=coins'" @class([
                'w-full px-6 py-3 text-sm font-medium rounded-lg border focus:outline-none focus:ring-2 transition-colors',
                'text-blue-600 border-blue-500 hover:bg-blue-50 focus:ring-blue-200' => auth()->user()->theme === 'light',
                'text-blue-400 border-blue-400 hover:bg-blue-900 hover:bg-opacity-20 focus:ring-blue-800' => auth()->user()->theme === 'dark'
            ])>
                <i class="mr-2 fas fa-eye"></i>
                View All
            </button>
            <button onclick="window.location.reload()" @class([
                'w-full px-6 py-3 text-sm font-medium rounded-lg border focus:outline-none focus:ring-2 transition-colors',
                'text-gray-600 border-gray-500 hover:bg-gray-50 focus:ring-gray-200' => auth()->user()->theme === 'light',
                'text-gray-400 border-gray-400 hover:bg-gray-700 hover:bg-opacity-20 focus:ring-gray-800' => auth()->user()->theme === 'dark'
            ])>
                <i class="mr-2 fas fa-sync-alt"></i>
                Refresh
            </button>
        </div>

        <!-- Include Modal Components -->
        @include('components.modals.coin-transfer-modal')
        @include('components.modals.withdrawal-modal')
        @include('components.modals.coin-activity-modal')
    </div>

    @push('styles')
    <style>
        /* Wallet ID Styles */
        .wallet-id {
            font-size: 0.875rem;
            background: rgba(255, 255, 255, 0.15);
            padding: 6px 12px;
            border-radius: 20px;
            display: inline-flex;
            align-items: center;
            cursor: pointer;
            transition: all 0.2s ease;
            font-family: 'Courier New', monospace;
            color: white;
            border: none;
            outline: none;
            backdrop-filter: blur(2px);
        }

        .wallet-id:hover {
            background: rgba(255, 255, 255, 0.25);
            transform: translateY(-1px);
        }

        .wallet-id:active {
            transform: translateY(0);
        }

        .copy-feedback {
            font-size: 0.875rem;
            background: transparent !important;
            padding: 0 !important;
        }

        /* Animation for copy feedback */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(2px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .copy-feedback {
            animation: fadeIn 0.2s ease-out;
        }

        /* Alpine.js cloak */
        [x-cloak] {
            display: none !important;
        }

        /* Withdrawal success animation */
        @keyframes bounce {
            0%, 20%, 53%, 80%, 100% {
                transform: translate3d(0,0,0);
            }
            40%, 43% {
                transform: translate3d(0, -30px, 0);
            }
            70% {
                transform: translate3d(0, -15px, 0);
            }
            90% {
                transform: translate3d(0, -4px, 0);
            }
        }
    </style>
    @endpush

    @push('scripts')
    <script>
        document.addEventListener('alpine:init', () => {
            // Global copy method
            window.copyToClipboard = function(text) {
                if (text) {
                    navigator.clipboard.writeText(text);
                    return true;
                }
                return false;
            };
            
            // Listen for transfer notifications
            if (window.Echo) {
                window.Echo.private(`user.{{ auth()->id() }}`)
                    .listen('CoinTransferSent', (e) => {
                        showNotification(e.title, e.message, 'success');
                        // Update balance display
                        setTimeout(() => {
                            document.querySelector('[x-data*="mobileCarousel"]').__x.$data.fetchBalances();
                        }, 1000);
                    })
                    .listen('CoinTransferReceived', (e) => {
                        showNotification(e.title, e.message, 'success');
                        // Update balance display
                        setTimeout(() => {
                            document.querySelector('[x-data*="mobileCarousel"]').__x.$data.fetchBalances();
                        }, 1000);
                    });
            }
            
            // Notification display function
            window.showNotification = function(title, message, type = 'info') {
                // Create notification element
                const notification = document.createElement('div');
                notification.className = `fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg max-w-sm transform transition-all duration-300 translate-x-full`;
                
                const colors = {
                    success: '#10b981',
                    error: '#ef4444',
                    info: '#3b82f6'
                };
                
                const icons = {
                    success: 'fa-check-circle',
                    error: 'fa-exclamation-circle',
                    info: 'fa-info-circle'
                };
                
                notification.style.backgroundColor = colors[type] || colors.info;
                notification.style.color = 'white';
                
                notification.innerHTML = `
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <i class="fas ${icons[type] || icons.info} text-lg"></i>
                        </div>
                        <div class="ml-3 flex-1">
                            <p class="font-semibold text-sm">${title}</p>
                            <p class="text-sm opacity-90">${message}</p>
                        </div>
                        <button onclick="this.parentElement.parentElement.remove()" class="ml-2 text-white hover:text-gray-200">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                `;
                
                document.body.appendChild(notification);
                
                // Animate in
                setTimeout(() => {
                    notification.classList.remove('translate-x-full');
                }, 100);
                
                // Auto remove after 5 seconds
                setTimeout(() => {
                    notification.classList.add('translate-x-full');
                    setTimeout(() => notification.remove(), 300);
                }, 5000);
            };

            Alpine.data('mobileCarousel', () => ({
                activeSlide: 0,
                startX: 0,
                currentX: 0,
                isDragging: false,
                sliderWidth: 0,

                init() {
                    this.$nextTick(() => {
                        this.sliderWidth = this.$refs.slider.offsetWidth / 3;
                    });

                    // Auto-refresh balances
                    this.fetchBalances();
                    setInterval(() => this.fetchBalances(), 30000);
                },

                startDrag(e) {
                    this.isDragging = true;
                    this.startX = e.type === 'touchstart' ? e.touches[0].clientX : e.clientX;
                    this.$refs.slider.style.transition = 'none';
                },

                handleDrag(e) {
                    if (!this.isDragging) return;

                    this.currentX = e.type === 'touchmove' ? e.touches[0].clientX : e.clientX;
                    const diff = this.startX - this.currentX;
                    const maxDrag = this.sliderWidth * 0.5;

                    // Apply resistance at boundaries
                    let dragOffset = 0;
                    if ((this.activeSlide === 0 && diff < 0) ||
                        (this.activeSlide === 2 && diff > 0)) {
                        dragOffset = diff * 0.3; // Add resistance
                    } else {
                        dragOffset = diff;
                    }

                    this.$refs.slider.style.transform = `translateX(calc(-${this.activeSlide * 100}% - ${dragOffset}px))`;
                },

                endDrag(e) {
                    if (!this.isDragging) return;
                    this.isDragging = false;
                    this.$refs.slider.style.transition = 'transform 0.3s ease';

                    const endX = e.type === 'touchend' ? e.changedTouches[0].clientX : e.clientX;
                    const diff = this.startX - endX;
                    const threshold = 50;

                    if (diff > threshold) {
                        this.next();
                    } else if (diff < -threshold) {
                        this.prev();
                    } else {
                        this.$refs.slider.style.transform = `translateX(-${this.activeSlide * 100}%)`;
                    }
                },

                next() {
                    this.activeSlide = Math.min(this.activeSlide + 1, 2);
                },

                prev() {
                    this.activeSlide = Math.max(this.activeSlide - 1, 0);
                },

                goToSlide(index) {
                    this.activeSlide = index;
                },

                fetchBalances() {
                    fetch('/user/coin-balance')
                        .then(response => response.json())
                        .then(data => {
                            document.querySelectorAll('[data-balance-type]').forEach(el => {
                                const type = el.getAttribute('data-balance-type');
                                if (data[`${type}_coins`] !== undefined) {
                                    el.textContent = new Intl.NumberFormat().format(data[`${type}_coins`]);

                                    // Update dollar conversion
                                    const dollarValue = (parseInt(data[`${type}_coins`]) || 0) * 0.01;
                                    const dollarElement = el.closest('.flex-1').querySelector('.text-sm.font-medium.text-white');
                                    if (dollarElement) {
                                        dollarElement.textContent = `≈ $${dollarValue.toFixed(2)}`;
                                    }
                                }
                            });
                        })
                        .catch(error => console.error('Error:', error));
                }
            }));


        });
        
        // Global function to open activity modal
        window.openActivityModal = function(activityData) {
            window.dispatchEvent(new CustomEvent('open-coin-activity-modal', { detail: activityData }));
        };
    </script>
    @endpush
</x-app-layout>
