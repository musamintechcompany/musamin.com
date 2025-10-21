<!-- Withdrawal Modal Component -->
<div x-data="withdrawalModal()" 
     @open-withdrawal-modal.window="openModal()"
     x-show="isOpen" 
     x-cloak
     class="fixed inset-0 z-50 overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div x-show="isOpen" 
             x-transition:enter="ease-out duration-300" 
             x-transition:enter-start="opacity-0" 
             x-transition:enter-end="opacity-100" 
             x-transition:leave="ease-in duration-200" 
             x-transition:leave-start="opacity-100" 
             x-transition:leave-end="opacity-0" 
             class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75"></div>

        <div x-show="isOpen" 
             x-transition:enter="ease-out duration-300" 
             x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" 
             x-transition:leave="ease-in duration-200" 
             x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" 
             x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
             @class([
                 'inline-block w-full max-w-md p-6 my-8 overflow-hidden text-left align-middle transition-all transform rounded-2xl shadow-xl',
                 'bg-white' => auth()->user()->theme === 'light',
                 'bg-gray-800' => auth()->user()->theme === 'dark'
             ])>
            
            <div class="flex items-center justify-between mb-6">
                <h3 @class([
                    'text-lg font-medium leading-6',
                    'text-gray-900' => auth()->user()->theme === 'light',
                    'text-white' => auth()->user()->theme === 'dark'
                ])>
                    <i class="fas fa-money-bill-wave mr-2 text-green-500"></i>
                    Withdraw Coins
                </h3>
                <button @click="closeModal()" @class([
                    'rounded-md p-2 hover:bg-gray-100 focus:outline-none',
                    'text-gray-400 hover:text-gray-500' => auth()->user()->theme === 'light',
                    'text-gray-500 hover:text-gray-400 hover:bg-gray-700' => auth()->user()->theme === 'dark'
                ])>
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <!-- Account Status Check -->
            @if(auth()->user()->isOnHold())
                <div class="p-4 rounded-lg bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-triangle text-red-500 mr-3"></i>
                        <div>
                            <h4 class="font-medium text-red-800 dark:text-red-200">Account On Hold</h4>
                            <p class="text-sm text-red-700 dark:text-red-300 mt-1">
                                Sorry, you can't make a withdrawal as your account is on hold. Please contact customer care for support.
                            </p>
                            <a href="{{ route('support.index') }}" class="inline-flex items-center mt-2 text-sm text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-200">
                                <i class="fas fa-headset mr-1"></i>
                                Contact Support
                            </a>
                        </div>
                    </div>
                </div>
            @else
                <!-- Withdrawal Form -->
                <div class="space-y-4">
                    <!-- Bank Account Selection -->
                    <div>
                        <label @class([
                            'block text-sm font-medium mb-2',
                            'text-gray-700' => auth()->user()->theme === 'light',
                            'text-gray-300' => auth()->user()->theme === 'dark'
                        ])>Select Bank Account</label>
                        <div x-show="bankAccounts.length > 0">
                            <select x-model="selectedBankId" 
                                    @change="validateForm()"
                                    @class([
                                        'w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-green-500',
                                        'border-gray-300 bg-white text-gray-900' => auth()->user()->theme === 'light',
                                        'border-gray-600 bg-gray-700 text-white' => auth()->user()->theme === 'dark'
                                    ])>
                                <option value="">Choose bank account...</option>
                                <template x-for="account in bankAccounts" :key="account.id">
                                    <option :value="account.id" x-text="`${account.method_name} - ${getAccountSummary(account)}`"></option>
                                </template>
                            </select>
                        </div>
                        
                        <!-- No Bank Accounts Message -->
                        <div x-show="bankAccounts.length === 0" class="mt-2">
                            <p class="text-sm text-orange-600 dark:text-orange-400">
                                <i class="fas fa-exclamation-triangle mr-1"></i>
                                No bank accounts found. 
                                <a href="{{ route('settings.withdrawal-bank') }}" class="underline hover:no-underline">Add one here</a>
                            </p>
                        </div>
                        
                        <!-- Add New Account Link -->
                        <div x-show="bankAccounts.length > 0" class="mt-2">
                            <a href="{{ route('settings.withdrawal-bank') }}" class="text-sm text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-200">
                                <i class="fas fa-plus mr-1"></i>
                                Add new account details
                            </a>
                        </div>
                    </div>

                <!-- Amount Input -->
                <div>
                    <label @class([
                        'block text-sm font-medium mb-2',
                        'text-gray-700' => auth()->user()->theme === 'light',
                        'text-gray-300' => auth()->user()->theme === 'dark'
                    ])>Withdrawal Amount (coins)</label>
                    <input x-model="amount" 
                           @input="calculateFees()"
                           type="number" 
                           :min="minWithdrawal" 
                           :placeholder="`Enter amount (min ${minWithdrawal.toLocaleString()} coins)`"
                           @class([
                               'w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-green-500',
                               'border-gray-300 bg-white text-gray-900' => auth()->user()->theme === 'light',
                               'border-gray-600 bg-gray-700 text-white' => auth()->user()->theme === 'dark'
                           ])>
                    <div x-show="amount > 0 && amount < minWithdrawal" class="mt-1">
                        <p class="text-sm text-red-600 dark:text-red-400">
                            Minimum withdrawal is <span x-text="minWithdrawal.toLocaleString()"></span> coins ($<span x-text="(minWithdrawal / coinsToUsdRate).toFixed(2)"></span>)
                        </p>
                    </div>
                </div>

                <!-- Fee Breakdown -->
                <div x-show="amount >= minWithdrawal" class="p-4 rounded-lg bg-gray-50 dark:bg-gray-700">
                    <h4 class="font-medium mb-3 text-gray-900 dark:text-white">Withdrawal Summary</h4>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span>Withdrawal Amount:</span>
                            <span x-text="amount + ' coins'"></span>
                        </div>
                        <div class="flex justify-between">
                            <span x-text="feeLabel"></span>
                            <span x-text="fee + ' coins'"></span>
                        </div>
                        <div class="flex justify-between font-bold border-t pt-2 mt-2 text-green-600 dark:text-green-400">
                            <span>You'll Receive:</span>
                            <span x-text="netAmount + ' coins ($' + (netAmount / coinsToUsdRate).toFixed(2) + ')'"></span>
                        </div>
                    </div>
                </div>

                    <!-- Submit Button -->
                    <button @click="submitWithdrawal()" 
                            :disabled="!canSubmit || isLoading"
                            class="w-full py-3 px-4 bg-green-600 text-white rounded-md hover:bg-green-700 disabled:opacity-50 disabled:cursor-not-allowed font-medium">
                        <span x-show="!isLoading">
                            <i class="fas fa-paper-plane mr-2"></i>
                            Submit Withdrawal Request
                        </span>
                        <span x-show="isLoading">
                            <i class="fas fa-spinner fa-spin mr-2"></i>
                            Processing...
                        </span>
                    </button>

                    <!-- Available Balance -->
                    <div class="p-3 rounded-lg bg-blue-50 dark:bg-blue-900/20">
                        <div class="text-sm text-blue-800 dark:text-blue-200">
                            <i class="fas fa-info-circle mr-1"></i>
                            Available for Withdrawal: <strong>{{ number_format(auth()->user()->earned_coins) }} coins</strong>
                            <br>
                            <span class="text-xs opacity-75">Only earned coins can be withdrawn</span>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Success Modal -->
<div x-data="{ showSuccess: false }" 
     @withdrawal-success.window="showSuccess = true; setTimeout(() => showSuccess = false, 8000)"
     x-show="showSuccess" 
     x-cloak
     class="fixed inset-0 z-60 overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div x-show="showSuccess" 
             x-transition:enter="ease-out duration-300" 
             x-transition:enter-start="opacity-0" 
             x-transition:enter-end="opacity-100" 
             class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75"></div>

        <div x-show="showSuccess" 
             x-transition:enter="ease-out duration-300" 
             x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" 
             class="inline-block w-full max-w-md p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-white rounded-2xl shadow-xl dark:bg-gray-800">
            
            <div class="text-center">
                <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-green-100 dark:bg-green-900/30 mb-4">
                    <i class="fas fa-check text-2xl text-green-600 dark:text-green-400"></i>
                </div>
                
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">
                    Withdrawal Submitted! 🎉
                </h3>
                
                <div class="text-sm text-gray-600 dark:text-gray-300 space-y-2">
                    <p>Your withdrawal request has been submitted successfully!</p>
                    <div class="p-3 bg-green-50 dark:bg-green-900/20 rounded-lg">
                        <p class="font-medium text-green-800 dark:text-green-200">
                            💰 Your request is being reviewed by our team
                        </p>
                        <p class="text-green-700 dark:text-green-300 mt-1">
                            You will receive your funds within 1-3 business days once approved. Thank you for your patience!
                        </p>
                    </div>
                </div>
                
                <button @click="showSuccess = false" 
                        class="mt-4 w-full py-2 px-4 bg-green-600 text-white rounded-md hover:bg-green-700">
                    Got it, thanks!
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('withdrawalModal', () => ({
        isOpen: false,
        amount: '',
        selectedBankId: '',
        fee: 0,
        netAmount: 0,
        minWithdrawal: 1000,
        coinsToUsdRate: 100,
        feeType: 'percent',
        feeValue: 0,
        feeLabel: 'Processing Fee:',
        isLoading: false,
        bankAccounts: [],
        canSubmit: false,

        init() {
            this.loadBankAccounts();
        },

        openModal() {
            this.isOpen = true;
            this.resetForm();
            this.loadBankAccounts();
        },

        closeModal() {
            this.isOpen = false;
            this.resetForm();
        },

        resetForm() {
            this.amount = '';
            this.selectedBankId = '';
            this.fee = 0;
            this.netAmount = 0;
            this.canSubmit = false;
        },

        loadBankAccounts() {
            fetch('/withdrawals/bank-accounts')
                .then(response => response.json())
                .then(data => {
                    this.bankAccounts = data.accounts || [];
                    this.validateForm();
                })
                .catch(error => {
                    console.error('Error loading bank accounts:', error);
                    this.bankAccounts = [];
                });
        },

        getAccountSummary(account) {
            if (!account.credentials || account.credentials.length === 0) {
                return 'No details';
            }
            // Show first credential value (usually account number) with masking
            const firstCred = account.credentials[0];
            if (firstCred.value && firstCred.value.length > 4) {
                return `****${firstCred.value.slice(-4)}`;
            }
            return firstCred.value || 'No details';
        },

        calculateFees() {
            if (!this.amount || this.amount <= 0) {
                this.fee = 0;
                this.netAmount = 0;
                this.validateForm();
                return;
            }

            fetch(`/withdrawals/fees?amount=${this.amount}`)
                .then(response => response.json())
                .then(data => {
                    this.fee = data.fee;
                    this.netAmount = data.net_amount;
                    this.minWithdrawal = data.min_withdrawal;
                    this.coinsToUsdRate = data.coins_to_usd_rate;
                    this.feeType = data.fee_type;
                    this.feeValue = data.fee_value;
                    
                    // Update fee label based on type
                    if (data.fee_type === 'fixed') {
                        this.feeLabel = `Processing Fee (Fixed ${data.fee_value} coins):`;
                    } else {
                        this.feeLabel = `Processing Fee (${data.fee_value}%):`;
                    }
                    
                    this.validateForm();
                })
                .catch(error => console.error('Error:', error));
        },

        validateForm() {
            this.canSubmit = this.amount >= this.minWithdrawal && 
                           this.selectedBankId && 
                           this.bankAccounts.length > 0;
        },

        submitWithdrawal() {
            if (!this.canSubmit) return;

            this.isLoading = true;
            
            fetch('/withdrawals/submit', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ 
                    amount: parseInt(this.amount),
                    bank_account_id: this.selectedBankId
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update earned balance in real-time
                    document.querySelectorAll('[data-balance-type="earned"]').forEach(el => {
                        el.textContent = new Intl.NumberFormat().format(data.new_earned_balance);
                    });
                    
                    this.closeModal();
                    window.dispatchEvent(new CustomEvent('withdrawal-success', { detail: data.details }));
                } else {
                    alert(data.message);
                }
            })
            .catch(error => {
                alert('Withdrawal request failed. Please try again.');
            })
            .finally(() => {
                this.isLoading = false;
            });
        }
    }));
});
</script>
@endpush