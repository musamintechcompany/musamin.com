<!-- Coin Transfer Modal Component -->
<div x-data="coinTransferModal()" 
     @open-coin-transfer-modal.window="openModal()"
     x-show="isOpen" 
     x-cloak
     class="fixed inset-0 z-[9999] overflow-y-auto">
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
                ])>Transfer Coins</h3>
                <button @click="closeModal()" @class([
                    'rounded-md p-2 hover:bg-gray-100 focus:outline-none',
                    'text-gray-400 hover:text-gray-500' => auth()->user()->theme === 'light',
                    'text-gray-500 hover:text-gray-400 hover:bg-gray-700' => auth()->user()->theme === 'dark'
                ])>
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <!-- Transfer Type Tabs -->
            <div class="flex mb-6 space-x-1 rounded-lg bg-gray-100 dark:bg-gray-700 p-1">
                <button @click="transferType = 'internal'" 
                        :class="transferType === 'internal' ? 'bg-white dark:bg-gray-600 text-gray-900 dark:text-white shadow' : 'text-gray-500 dark:text-gray-400'"
                        class="flex-1 py-2 px-3 text-sm font-medium rounded-md transition-colors">
                    Internal Transfer
                </button>
                <button @click="transferType = 'external'" 
                        :class="transferType === 'external' ? 'bg-white dark:bg-gray-600 text-gray-900 dark:text-white shadow' : 'text-gray-500 dark:text-gray-400'"
                        class="flex-1 py-2 px-3 text-sm font-medium rounded-md transition-colors">
                    Send to User
                </button>
            </div>

            <!-- Internal Transfer Form -->
            <div x-show="transferType === 'internal'">
                <div class="mb-4">
                    <label @class([
                        'block text-sm font-medium mb-2',
                        'text-gray-700' => auth()->user()->theme === 'light',
                        'text-gray-300' => auth()->user()->theme === 'dark'
                    ])>Amount (coins)</label>
                    <input x-model="amount" 
                           @input="calculateFees()"
                           type="number" 
                           min="1" 
                           placeholder="Enter amount"
                           @class([
                               'w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500',
                               'border-gray-300 bg-white text-gray-900' => auth()->user()->theme === 'light',
                               'border-gray-600 bg-gray-700 text-white' => auth()->user()->theme === 'dark'
                           ])>
                </div>
                
                <div x-show="amount > 0" class="mb-4 p-3 rounded-lg bg-gray-50 dark:bg-gray-700">
                    <div class="flex justify-between text-sm">
                        <span>Transfer Amount:</span>
                        <span x-text="amount + ' coins = ($' + (amount * 0.01).toFixed(2) + ')'"></span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span>Fee (2%):</span>
                        <span x-text="internalFee + ' coins = ($' + (internalFee * 0.01).toFixed(2) + ')'"></span>
                    </div>
                    <div class="flex justify-between text-sm font-bold border-t pt-2 mt-2">
                        <span>Total Deduction:</span>
                        <span x-text="(parseInt(amount) + parseInt(internalFee)) + ' coins = ($' + ((parseInt(amount) + parseInt(internalFee)) * 0.01).toFixed(2) + ')'"></span>
                    </div>
                </div>
                
                <button @click="showInternalConfirmation()" 
                        :disabled="!amount || amount <= 0 || isLoading"
                        class="w-full py-2 px-4 bg-purple-600 text-white rounded-md hover:bg-purple-700 disabled:opacity-50 disabled:cursor-not-allowed">
                    <span x-show="!isLoading">Transfer to Spending Wallet</span>
                    <span x-show="isLoading">Processing...</span>
                </button>
            </div>

            <!-- External Transfer Form -->
            <div x-show="transferType === 'external'">
                <div class="mb-4">
                    <label @class([
                        'block text-sm font-medium mb-2',
                        'text-gray-700' => auth()->user()->theme === 'light',
                        'text-gray-300' => auth()->user()->theme === 'dark'
                    ])>From Wallet</label>
                    <select x-model="fromWallet" @class([
                        'w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500',
                        'border-gray-300 bg-white text-gray-900' => auth()->user()->theme === 'light',
                        'border-gray-600 bg-gray-700 text-white' => auth()->user()->theme === 'dark'
                    ])>
                        <option value="earned">Earned Wallet ({{ number_format(auth()->user()->earned_coins) }} coins)</option>
                        <option value="spending">Spending Wallet ({{ number_format(auth()->user()->spendable_coins) }} coins)</option>
                    </select>
                </div>
                
                <div class="mb-4">
                    <label @class([
                        'block text-sm font-medium mb-2',
                        'text-gray-700' => auth()->user()->theme === 'light',
                        'text-gray-300' => auth()->user()->theme === 'dark'
                    ])>Recipient Wallet ID</label>
                    <input x-model="walletId" 
                           @input="validateWalletId()"
                           type="text" 
                           placeholder="ENXXXXXXXXX or SPXXXXXXXXX"
                           @class([
                               'w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500',
                               'border-gray-300 bg-white text-gray-900' => auth()->user()->theme === 'light',
                               'border-gray-600 bg-gray-700 text-white' => auth()->user()->theme === 'dark'
                           ])>
                    <div x-show="walletValidation.message" 
                         :class="walletValidation.valid ? 'text-green-600' : 'text-red-600'"
                         class="text-sm mt-1" 
                         x-text="walletValidation.message"></div>
                    <div x-show="transferError" class="text-sm mt-1 text-red-600" x-text="transferError"></div>
                </div>
                
                <div class="mb-4">
                    <label @class([
                        'block text-sm font-medium mb-2',
                        'text-gray-700' => auth()->user()->theme === 'light',
                        'text-gray-300' => auth()->user()->theme === 'dark'
                    ])>Amount (coins)</label>
                    <input x-model="amount" 
                           @input="calculateFees()"
                           type="number" 
                           min="1" 
                           placeholder="Enter amount"
                           @class([
                               'w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500',
                               'border-gray-300 bg-white text-gray-900' => auth()->user()->theme === 'light',
                               'border-gray-600 bg-gray-700 text-white' => auth()->user()->theme === 'dark'
                           ])>
                </div>
                
                <div class="mb-4">
                    <label @class([
                        'block text-sm font-medium mb-2',
                        'text-gray-700' => auth()->user()->theme === 'light',
                        'text-gray-300' => auth()->user()->theme === 'dark'
                    ])>Description (Optional)</label>
                    <input x-model="description" 
                           type="text" 
                           placeholder="Reason for sending (e.g., Payment for services)"
                           @class([
                               'w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500',
                               'border-gray-300 bg-white text-gray-900' => auth()->user()->theme === 'light',
                               'border-gray-600 bg-gray-700 text-white' => auth()->user()->theme === 'dark'
                           ])>
                </div>
                
                <div x-show="amount > 0" class="mb-4 p-3 rounded-lg bg-gray-50 dark:bg-gray-700">
                    <div class="flex justify-between text-sm">
                        <span>Transfer Amount:</span>
                        <span x-text="amount + ' coins = ($' + (amount * 0.01).toFixed(2) + ')'"></span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span>Fee (5%):</span>
                        <span x-text="externalFee + ' coins = ($' + (externalFee * 0.01).toFixed(2) + ')'"></span>
                    </div>
                    <div class="flex justify-between text-sm font-bold border-t pt-2 mt-2">
                        <span>Total Deduction:</span>
                        <span x-text="(parseInt(amount) + parseInt(externalFee)) + ' coins = ($' + ((parseInt(amount) + parseInt(externalFee)) * 0.01).toFixed(2) + ')'"></span>
                    </div>
                </div>
                
                <button @click="showExternalConfirmation()" 
                        :disabled="!amount || amount <= 0 || !walletValidation.valid || isLoading"
                        class="w-full py-2 px-4 bg-purple-600 text-white rounded-md hover:bg-purple-700 disabled:opacity-50 disabled:cursor-not-allowed">
                    <span x-show="!isLoading">Send Coins</span>
                    <span x-show="isLoading">Processing...</span>
                </button>
            </div>

            <!-- Available Balance -->
            <div class="mt-4 p-3 rounded-lg bg-blue-50 dark:bg-blue-900/20">
                <div class="text-sm text-blue-800 dark:text-blue-200">
                    <i class="fas fa-info-circle mr-1"></i>
                    <span x-show="transferType === 'internal'">Available in Earned Wallet: <strong>{{ number_format(auth()->user()->earned_coins) }} coins</strong></span>
                    <span x-show="transferType === 'external'">
                        <span x-show="fromWallet === 'earned'">Available in Earned Wallet: <strong>{{ number_format(auth()->user()->earned_coins) }} coins</strong></span>
                        <span x-show="fromWallet === 'spending'">Available in Spending Wallet: <strong>{{ number_format(auth()->user()->spendable_coins) }} coins</strong></span>
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('coinTransferModal', () => ({
        isOpen: false,
        transferType: 'internal',
        amount: '',
        walletId: '',
        fromWallet: 'earned',
        internalFee: 0,
        externalFee: 0,
        isLoading: false,
        walletValidation: { valid: false, message: '', wallet_type: null },
        transferError: '',
        description: '',

        openModal() {
            this.isOpen = true;
            this.resetForm();
        },

        closeModal() {
            this.isOpen = false;
            this.resetForm();
        },

        resetForm() {
            this.amount = '';
            this.walletId = '';
            this.fromWallet = 'earned';
            this.internalFee = 0;
            this.externalFee = 0;
            this.walletValidation = { valid: false, message: '', wallet_type: null };
            this.transferError = '';
            this.description = '';
            this.transferType = 'internal';
        },

        calculateFees() {
            if (!this.amount || this.amount <= 0) {
                this.internalFee = 0;
                this.externalFee = 0;
                return;
            }

            fetch(`/coin-transfers/fees?amount=${this.amount}`)
                .then(response => response.json())
                .then(data => {
                    this.internalFee = data.internal_fee;
                    this.externalFee = data.external_fee;
                })
                .catch(error => console.error('Error:', error));
        },

        validateWalletId() {
            if (!this.walletId) {
                this.walletValidation = { valid: false, message: '', wallet_type: null };
                this.transferError = '';
                return;
            }

            fetch(`/coin-transfers/validate-wallet?wallet_id=${this.walletId}`)
                .then(response => response.json())
                .then(data => {
                    this.walletValidation = data;
                    
                    // Check for invalid transfer combinations
                    if (data.valid && this.fromWallet === 'spending' && data.wallet_type === 'earned') {
                        this.transferError = 'Cannot transfer from spending wallet to earned wallet';
                        this.walletValidation.valid = false;
                    } else {
                        this.transferError = '';
                    }
                })
                .catch(error => {
                    this.walletValidation = { valid: false, message: 'Error validating wallet', wallet_type: null };
                    this.transferError = '';
                });
        },

        submitInternalTransfer() {
            if (!this.amount || this.amount <= 0) return;

            this.isLoading = true;
            
            fetch('/coin-transfers/internal', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ amount: parseInt(this.amount) })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update balances in real-time
                    document.querySelectorAll('[data-balance-type="earned"]').forEach(el => {
                        el.textContent = new Intl.NumberFormat().format(data.new_earned_balance);
                    });
                    document.querySelectorAll('[data-balance-type="spendable"]').forEach(el => {
                        el.textContent = new Intl.NumberFormat().format(data.new_spending_balance);
                    });
                    
                    this.closeModal();
                    if (window.showNotification) {
                        window.showNotification('Coin Transfer Successful', data.message, 'success');
                    }
                } else {
                    if (window.showNotification) {
                        window.showNotification('Coin Transfer Failed', data.message, 'error');
                    } else {
                        alert(data.message);
                    }
                }
            })
            .catch(error => {
                alert('Transfer failed. Please try again.');
            })
            .finally(() => {
                this.isLoading = false;
            });
        },

        showInternalConfirmation() {
            if (!this.amount || this.amount <= 0) return;
            
            const totalDeduction = parseInt(this.amount) + parseInt(this.internalFee);
            const message = `Confirm transfer of ${this.amount} coins = ($${(this.amount * 0.01).toFixed(2)}) to your spending wallet?\n\nFee: ${this.internalFee} coins = ($${(this.internalFee * 0.01).toFixed(2)})\nTotal deduction: ${totalDeduction} coins = ($${(totalDeduction * 0.01).toFixed(2)})`;
            
            if (confirm(message)) {
                this.submitInternalTransfer();
            }
        },
        
        showExternalConfirmation() {
            if (!this.amount || this.amount <= 0 || !this.walletValidation.valid) return;
            
            const totalDeduction = parseInt(this.amount) + parseInt(this.externalFee);
            const walletType = this.walletValidation.wallet_type || 'wallet';
            const message = `Confirm transfer of ${this.amount} coins = ($${(this.amount * 0.01).toFixed(2)}) to ${this.walletValidation.user_name}'s ${walletType} wallet?\n\nFee: ${this.externalFee} coins = ($${(this.externalFee * 0.01).toFixed(2)})\nTotal deduction: ${totalDeduction} coins = ($${(totalDeduction * 0.01).toFixed(2)})`;
            
            if (confirm(message)) {
                this.submitExternalTransfer();
            }
        },

        submitExternalTransfer() {
            if (!this.amount || this.amount <= 0 || !this.walletValidation.valid) return;

            this.isLoading = true;
            
            fetch('/coin-transfers/external', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ 
                    amount: parseInt(this.amount),
                    wallet_id: this.walletId,
                    from_wallet: this.fromWallet
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update balance in real-time based on from_wallet
                    if (data.from_wallet === 'earned') {
                        document.querySelectorAll('[data-balance-type="earned"]').forEach(el => {
                            el.textContent = new Intl.NumberFormat().format(data.new_balance);
                        });
                    } else {
                        document.querySelectorAll('[data-balance-type="spendable"]').forEach(el => {
                            el.textContent = new Intl.NumberFormat().format(data.new_balance);
                        });
                    }
                    
                    this.closeModal();
                    if (window.showNotification) {
                        window.showNotification('Coin Transfer Successful', data.message, 'success');
                    }
                } else {
                    if (window.showNotification) {
                        window.showNotification('Coin Transfer Failed', data.message, 'error');
                    } else {
                        alert(data.message);
                    }
                }
            })
            .catch(error => {
                alert('Transfer failed. Please try again.');
            })
            .finally(() => {
                this.isLoading = false;
            });
        }
    }));
});
</script>
@endpush