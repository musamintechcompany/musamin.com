{{-- Affiliate Payment Modal Component --}}
<div id="affiliatePaymentModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center p-4" style="z-index: 9999999;">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-sm w-full transform transition-all">
        <div class="p-4 sm:p-6">
            {{-- Modal Header --}}
            <div class="text-center mb-4">
                @if(auth()->user()->affiliate && auth()->user()->affiliate->isExpired())
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Renew Your Affiliate Membership</h3>
                @else
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Join Affiliate Program</h3>
                @endif
            </div>

            {{-- Payment Card --}}
            <div class="bg-gradient-to-br from-indigo-50 to-purple-50 dark:from-indigo-900 dark:to-purple-900 rounded-lg p-3 sm:p-4 mb-4">
                <div class="text-center">
                    <h4 class="text-lg sm:text-xl font-bold text-gray-900 dark:text-white mb-2">Affiliate Membership</h4>
                    @if(auth()->user()->affiliate && auth()->user()->affiliate->isExpired())
                        <p class="text-black dark:text-white text-xs sm:text-sm mb-3 sm:mb-4">Renew your membership and continue earning</p>
                    @else
                        <p class="text-black dark:text-white text-xs sm:text-sm mb-3 sm:mb-4">Join our affiliate program and start earning</p>
                    @endif

                    {{-- Plan Selection Toggle --}}
                    @php
                        $settings = \App\Models\Setting::getSettings();
                        $monthlyFee = $settings->affiliate_monthly_fee ?? 3;
                        $yearlyFee = $settings->affiliate_yearly_fee ?? 22;
                        $exchangeRate = $settings->usd_to_coins_rate ?? 100;
                    @endphp
                    
                    <div class="mb-4">
                        <div class="flex items-center justify-center mb-3">
                            <span id="monthlyLabel" class="text-sm font-medium text-gray-900 dark:text-white mr-3">Monthly</span>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" id="planToggle" class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 dark:peer-focus:ring-indigo-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-indigo-600"></div>
                            </label>
                            <span id="yearlyLabel" class="text-sm font-medium text-gray-500 dark:text-gray-400 ml-3">Yearly</span>
                        </div>
                        
                        {{-- Savings Badge --}}
                        <div id="savingsBadge" class="hidden bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 text-xs font-medium px-2 py-1 rounded-full inline-block mb-2">
                            💰 Save ${{ number_format(($monthlyFee * 12) - $yearlyFee, 0) }}/year!
                        </div>
                    </div>

                    {{-- Price Display --}}
                    <div class="text-2xl sm:text-3xl font-bold text-indigo-600 dark:text-indigo-400 mb-3 sm:mb-4">
                        $<span id="priceAmount">{{ number_format($monthlyFee, 2) }}</span><span id="pricePeriod" class="text-sm sm:text-lg font-normal text-gray-500">/month</span>
                    </div>

                    {{-- Coin Breakdown --}}
                    <div class="bg-yellow-50 dark:bg-yellow-900 border border-yellow-200 dark:border-yellow-700 rounded-lg p-2 sm:p-3 mb-3 sm:mb-4">
                        <div class="flex items-center justify-center mb-2">
                            <i class="fas fa-coins text-yellow-500 mr-2 text-sm"></i>
                            <span class="font-semibold text-black dark:text-white text-sm">Payment Breakdown</span>
                        </div>
                        <div class="space-y-1 text-xs sm:text-sm">
                            <div class="flex justify-between">
                                <span class="text-black dark:text-white">Membership Fee:</span>
                                <span id="feeAmount" class="font-medium text-black dark:text-white">${{ number_format($monthlyFee, 2) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-black dark:text-white">Exchange Rate:</span>
                                <span class="font-medium text-black dark:text-white">1 USD = {{ number_format($exchangeRate) }} Coins</span>
                            </div>
                            <div class="border-t border-yellow-200 dark:border-yellow-700 pt-1 mt-2">
                                <div class="flex justify-between font-semibold">
                                    <span class="text-black dark:text-white">Total Cost:</span>
                                    <span id="totalCoins" class="text-yellow-600 dark:text-yellow-400">{{ number_format($monthlyFee * $exchangeRate) }} coins<span id="coinsPeriod">/month</span></span>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="flex gap-2">
                <button id="closeAffiliateModal" class="flex-1 px-4 py-2 text-sm bg-gray-500 text-white rounded-md hover:bg-gray-600 transition">
                    Cancel
                </button>
                <button id="confirmAffiliatePayment" class="flex-1 px-4 py-2 text-sm bg-gradient-to-r from-indigo-500 to-purple-600 text-white rounded-md hover:opacity-90 transition">
                    @if(auth()->user()->affiliate && auth()->user()->affiliate->isExpired())
                        <i class="mr-2 fas fa-sync-alt"></i>
                        Renew Now
                    @else
                        <i class="mr-2 fas fa-rocket"></i>
                        Join Now
                    @endif
                </button>
            </div>

            {{-- Security Notice --}}
            <div class="mt-3 sm:mt-4 text-center">
                <p class="text-xs text-gray-500 dark:text-gray-400">
                    <i class="fas fa-shield-alt mr-1"></i>
                    Secure payment • 1-year membership
                </p>
            </div>
        </div>
    </div>
</div>

{{-- Success Modal --}}
<div id="affiliateSuccessModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center p-4" style="z-index: 9999999;">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-sm w-full transform transition-all">
        <div class="p-4 sm:p-6 text-center">
            <div class="w-12 h-12 sm:w-16 sm:h-16 bg-green-100 dark:bg-green-900 rounded-full flex items-center justify-center mx-auto mb-3 sm:mb-4">
                <i class="fas fa-check text-green-600 dark:text-green-400 text-lg sm:text-2xl"></i>
            </div>
            @if(auth()->user()->affiliate && auth()->user()->affiliate->renewed_count > 0)
                <h3 class="text-lg sm:text-xl font-semibold text-gray-900 dark:text-white mb-2">Membership Renewed Successfully!</h3>
                <p class="text-gray-600 dark:text-gray-300 mb-4 sm:mb-6 text-sm sm:text-base">
                    Great! Your affiliate membership has been renewed. Continue earning commissions for another year!
                </p>
            @else
                <h3 class="text-lg sm:text-xl font-semibold text-gray-900 dark:text-white mb-2">Welcome to Affiliate Program!</h3>
                <p class="text-gray-600 dark:text-gray-300 mb-4 sm:mb-6 text-sm sm:text-base">
                    Congratulations! You've successfully joined our affiliate program. Start earning commissions today!
                </p>
            @endif
            <button id="goToAffiliateDashboard" class="w-full px-4 py-2 text-sm sm:text-base bg-gradient-to-r from-indigo-500 to-purple-600 text-white rounded-md hover:opacity-90 transition">
                <i class="fas fa-chart-line mr-2"></i>
                Go to Affiliate Dashboard
            </button>
        </div>
    </div>
</div>

{{-- Declined Modal --}}
<div id="affiliateDeclinedModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center p-4" style="z-index: 9999999;">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-sm w-full transform transition-all">
        <div class="p-4 sm:p-6 text-center">
            <div class="w-12 h-12 sm:w-16 sm:h-16 bg-red-100 dark:bg-red-900 rounded-full flex items-center justify-center mx-auto mb-3 sm:mb-4">
                <i class="fas fa-times text-red-600 dark:text-red-400 text-lg sm:text-2xl"></i>
            </div>
            @if(auth()->user()->affiliate && auth()->user()->affiliate->isExpired())
                <h3 class="text-lg sm:text-xl font-semibold text-gray-900 dark:text-white mb-2">Renewal Failed</h3>
                <p class="text-black dark:text-white mb-2 text-sm sm:text-base">
                    Insufficient balance to renew your affiliate membership.
                </p>
            @else
                <h3 class="text-lg sm:text-xl font-semibold text-gray-900 dark:text-white mb-2">Insufficient Balance</h3>
                <p class="text-black dark:text-white mb-2 text-sm sm:text-base">
                    Please purchase more coins to join the affiliate program.
                </p>
            @endif
            <p class="text-xs sm:text-sm text-black dark:text-white mb-4 sm:mb-6">
                Your Balance: <span class="font-semibold text-black dark:text-white">{{ auth()->user()->spendable_coins }} Coins</span>
            </p>
            <button id="goToBuyCoins" class="w-full px-4 py-2 text-sm sm:text-base bg-gradient-to-r from-red-500 to-pink-600 text-white rounded-md hover:opacity-90 transition">
                <i class="fas fa-coins mr-2"></i>
                Buy Coins
            </button>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Modal Elements
    const paymentModal = document.getElementById('affiliatePaymentModal');
    const successModal = document.getElementById('affiliateSuccessModal');
    const declinedModal = document.getElementById('affiliateDeclinedModal');
    const joinBtn = document.getElementById('joinAffiliateBtn');
    const closeBtn = document.getElementById('closeAffiliateModal');
    const confirmBtn = document.getElementById('confirmAffiliatePayment');
    const dashboardBtn = document.getElementById('goToAffiliateDashboard');
    const buyCoinsBtn = document.getElementById('goToBuyCoins');
    
    // Plan Toggle Elements
    const planToggle = document.getElementById('planToggle');
    const monthlyLabel = document.getElementById('monthlyLabel');
    const yearlyLabel = document.getElementById('yearlyLabel');
    const priceAmount = document.getElementById('priceAmount');
    const pricePeriod = document.getElementById('pricePeriod');
    const feeAmount = document.getElementById('feeAmount');
    const totalCoins = document.getElementById('totalCoins');
    const coinsPeriod = document.getElementById('coinsPeriod');
    const savingsBadge = document.getElementById('savingsBadge');
    
    // Plan pricing
    const monthlyFee = {{ $monthlyFee }};
    const yearlyFee = {{ $yearlyFee }};
    const exchangeRate = {{ $exchangeRate }};

    // Update Pricing Display
    function updatePricing() {
        const isYearly = planToggle.checked;
        
        if (isYearly) {
            // Yearly selected
            priceAmount.textContent = yearlyFee.toFixed(2);
            pricePeriod.textContent = '/year';
            feeAmount.textContent = '$' + yearlyFee.toFixed(2);
            totalCoins.innerHTML = (yearlyFee * exchangeRate).toLocaleString() + ' coins<span id="coinsPeriod">/year</span>';
            
            // Update labels
            monthlyLabel.classList.remove('text-gray-900', 'dark:text-white');
            monthlyLabel.classList.add('text-gray-500', 'dark:text-gray-400');
            yearlyLabel.classList.remove('text-gray-500', 'dark:text-gray-400');
            yearlyLabel.classList.add('text-gray-900', 'dark:text-white');
            
            // Show savings badge
            savingsBadge.classList.remove('hidden');
        } else {
            // Monthly selected
            priceAmount.textContent = monthlyFee.toFixed(2);
            pricePeriod.textContent = '/month';
            feeAmount.textContent = '$' + monthlyFee.toFixed(2);
            totalCoins.innerHTML = (monthlyFee * exchangeRate).toLocaleString() + ' coins<span id="coinsPeriod">/month</span>';
            
            // Update labels
            yearlyLabel.classList.remove('text-gray-900', 'dark:text-white');
            yearlyLabel.classList.add('text-gray-500', 'dark:text-gray-400');
            monthlyLabel.classList.remove('text-gray-500', 'dark:text-gray-400');
            monthlyLabel.classList.add('text-gray-900', 'dark:text-white');
            
            // Hide savings badge
            savingsBadge.classList.add('hidden');
        }
    }
    
    // Plan Toggle Event Listener
    if (planToggle) {
        planToggle.addEventListener('change', updatePricing);
    }

    // Show Payment Modal Function
    function showAffiliatePaymentModal() {
        if (paymentModal) {
            paymentModal.classList.remove('hidden');
            paymentModal.classList.add('flex');
            document.body.style.overflow = 'hidden';
        }
    }

    // Join Button Event Listener
    if (joinBtn) {
        joinBtn.addEventListener('click', function(e) {
            e.preventDefault();
            showAffiliatePaymentModal();
        });
    }

    // Close Button Event Listener
    if (closeBtn) {
        closeBtn.addEventListener('click', hideAllModals);
    }

    // Hide All Modals Function
    function hideAllModals() {
        [paymentModal, successModal, declinedModal].forEach(modal => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        });
        document.body.style.overflow = '';
    }

    // Show Success Modal Function
    function showSuccessModal() {
        hideAllModals();
        successModal.classList.remove('hidden');
        successModal.classList.add('flex');
    }

    // Show Declined Modal Function
    function showDeclinedModal() {
        hideAllModals();
        declinedModal.classList.remove('hidden');
        declinedModal.classList.add('flex');
    }

    // Event Listeners (removed close and cancel button listeners)

    // Confirm Payment Handler
    confirmBtn.addEventListener('click', function() {
        // Show loading state
        confirmBtn.innerHTML = '<i class="mr-2 fas fa-spinner fa-spin"></i>Processing...';
        confirmBtn.disabled = true;
        
        const userBalance = {{ auth()->user()->spendable_coins }};
        const planToggle = document.getElementById('planToggle');
        const isYearly = planToggle.checked;
        const monthlyFee = {{ $monthlyFee }};
        const yearlyFee = {{ $yearlyFee }};
        const exchangeRate = {{ $exchangeRate }};
        const selectedFee = isYearly ? yearlyFee : monthlyFee;
        const requiredAmount = selectedFee * exchangeRate;
        const planType = isYearly ? 'yearly' : 'monthly';

        if (userBalance < requiredAmount) {
            showDeclinedModal();
            // Reset button text based on user status
            @if(auth()->user()->affiliate && auth()->user()->affiliate->isExpired())
                confirmBtn.innerHTML = '<i class="mr-2 fas fa-sync-alt"></i>Renew Now';
            @else
                confirmBtn.innerHTML = '<i class="mr-2 fas fa-rocket"></i>Join Now';
            @endif
            confirmBtn.disabled = false;
            return;
        }

        // Process payment via AJAX
        fetch('{{ route("affiliate.join.post") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                amount: requiredAmount,
                plan_type: planType,
                fee: selectedFee
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showSuccessModal();
            } else {
                showDeclinedModal();
            }
            // Reset button text based on user status
            @if(auth()->user()->affiliate && auth()->user()->affiliate->isExpired())
                confirmBtn.innerHTML = '<i class="mr-2 fas fa-sync-alt"></i>Renew Now';
            @else
                confirmBtn.innerHTML = '<i class="mr-2 fas fa-rocket"></i>Join Now';
            @endif
            confirmBtn.disabled = false;
        })
        .catch(error => {
            console.error('Error:', error);
            showDeclinedModal();
            // Reset button text based on user status
            @if(auth()->user()->affiliate && auth()->user()->affiliate->isExpired())
                confirmBtn.innerHTML = '<i class="mr-2 fas fa-sync-alt"></i>Renew Now';
            @else
                confirmBtn.innerHTML = '<i class="mr-2 fas fa-rocket"></i>Join Now';
            @endif
            confirmBtn.disabled = false;
        });
    });

    // Go to Dashboard Handler
    dashboardBtn.addEventListener('click', function() {
        window.location.href = '{{ route("affiliate.dashboard") }}';
    });

    // Go to Buy Coins Handler
    buyCoinsBtn.addEventListener('click', function() {
        window.location.href = '{{ route("coin-packages.index") }}';
    });

    // Close modals when clicking outside
    [paymentModal, declinedModal].forEach(modal => {
        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                hideAllModals();
            }
        });
    });

    // Success modal - close immediately then refresh page when clicking outside
    successModal.addEventListener('click', function(e) {
        if (e.target === successModal) {
            hideAllModals();
            setTimeout(() => {
                location.reload();
            }, 100);
        }
    });

    // Close modals with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            hideAllModals();
        }
    });
});
</script>
