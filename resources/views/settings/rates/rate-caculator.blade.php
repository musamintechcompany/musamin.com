<x-app-layout>
    <div class="py-12 bg-white dark:bg-gray-900">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700">
                    <div class="sticky top-0 flex items-center py-2 mb-6 bg-white dark:bg-gray-800">
                        <button onclick="window.history.back()" class="mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-500 dark:text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                            </svg>
                        </button>
                        <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200">Rate Calculator</h2>
                    </div>

                    <!-- Current Rates -->
                    <div class="grid grid-cols-1 gap-6 mb-8 md:grid-cols-2">
                        <div class="p-6 rounded-lg bg-gradient-to-br from-blue-50 to-indigo-100 dark:from-blue-900 dark:to-indigo-900">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">USD to Coins</h3>
                                    <p class="text-3xl font-bold text-blue-600 dark:text-blue-400">1 USD = 100 Coins</p>
                                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">Standard rate for purchases</p>
                                </div>
                                <div class="flex items-center justify-center w-16 h-16 bg-blue-100 rounded-full dark:bg-blue-800">
                                    <i class="text-2xl text-blue-600 fas fa-coins dark:text-blue-400"></i>
                                </div>
                            </div>
                        </div>

                        <div class="p-6 rounded-lg bg-gradient-to-br from-green-50 to-emerald-100 dark:from-green-900 dark:to-emerald-900">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Coins to USD</h3>
                                    <p class="text-3xl font-bold text-green-600 dark:text-green-400">100 Coins = 0.95 USD</p>
                                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">Withdrawal rate (5% fee)</p>
                                </div>
                                <div class="flex items-center justify-center w-16 h-16 bg-green-100 rounded-full dark:bg-green-800">
                                    <i class="text-2xl text-green-600 fas fa-dollar-sign dark:text-green-400"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Rate Calculator -->
                    <div class="p-6 mb-8 rounded-lg bg-gray-50 dark:bg-gray-700">
                        <h3 class="mb-4 text-lg font-semibold text-gray-900 dark:text-white">Rate Calculator</h3>
                        
                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">USD Amount</label>
                                <input type="number" id="usdAmount" placeholder="Enter USD amount" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:text-white">
                                <p class="mt-1 text-sm text-gray-600 dark:text-gray-300">Coins: <span id="coinsResult">0</span></p>
                            </div>
                            
                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Coins Amount</label>
                                <input type="number" id="coinsAmount" placeholder="Enter coins amount" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:text-white">
                                <p class="mt-1 text-sm text-gray-600 dark:text-gray-300">USD (after fees): <span id="usdResult">0.00</span></p>
                            </div>
                        </div>
                    </div>

                    <!-- Important Notes -->
                    <div class="p-4 mt-6 border border-yellow-200 rounded-lg bg-yellow-50 dark:bg-yellow-900 dark:border-yellow-700">
                        <div class="flex">
                            <i class="mt-1 mr-3 text-yellow-600 fas fa-info-circle dark:text-yellow-400"></i>
                            <div>
                                <h4 class="font-medium text-yellow-800 dark:text-yellow-200">Important Notes</h4>
                                <div class="mt-2 space-y-1 text-sm text-yellow-700 dark:text-yellow-300">
                                    <p><strong>Withdrawal Fee:</strong> 
                                        @if(($settings->withdrawal_fee_type ?? 'percent') === 'fixed')
                                            {{ number_format($settings->withdrawal_fee ?? 0) }} coins (fixed)
                                        @else
                                            {{ $settings->withdrawal_fee ?? 0 }}%
                                        @endif
                                    </p>
                                    <p><strong>Minimum Withdrawal:</strong> {{ number_format($settings->minimum_withdrawal_amount ?? 1000) }} coins</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const usdInput = document.getElementById('usdAmount');
            const coinsInput = document.getElementById('coinsAmount');
            const coinsResult = document.getElementById('coinsResult');
            const usdResult = document.getElementById('usdResult');

            const coinsRate = {{ $settings->usd_to_coins_rate ?? 100 }};
            const withdrawalFee = {{ $settings->withdrawal_fee ?? 0 }};
            const feeType = '{{ $settings->withdrawal_fee_type ?? "percent" }}';
            
            usdInput.addEventListener('input', function() {
                const usd = parseFloat(this.value) || 0;
                const coins = usd * coinsRate;
                coinsResult.textContent = coins.toLocaleString();
                
                // Clear the other input to avoid confusion
                coinsInput.value = '';
                usdResult.textContent = '0.00';
            });

            coinsInput.addEventListener('input', function() {
                const coins = parseFloat(this.value) || 0;
                let netCoins;
                
                if (feeType === 'fixed') {
                    netCoins = coins - withdrawalFee;
                } else {
                    netCoins = coins - (coins * withdrawalFee / 100);
                }
                
                const usd = netCoins / coinsRate;
                usdResult.textContent = Math.max(0, usd).toFixed(2);
                
                // Clear the other input to avoid confusion
                usdInput.value = '';
                coinsResult.textContent = '0';
            });
        });
    </script>
    @endpush
</x-app-layout>