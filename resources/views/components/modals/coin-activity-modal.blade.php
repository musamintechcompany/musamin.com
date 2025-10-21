<!-- Coin Activity Details Modal -->
<div x-data="coinActivityModal()" 
     @open-coin-activity-modal.window="openModal($event.detail)"
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
                 'inline-block w-full max-w-lg p-6 my-8 overflow-hidden text-left align-middle transition-all transform rounded-2xl shadow-xl',
                 'bg-white' => auth()->user()->theme === 'light',
                 'bg-gray-800' => auth()->user()->theme === 'dark'
             ])>
            
            <div class="flex items-center justify-between mb-6">
                <h3 @class([
                    'text-lg font-medium leading-6',
                    'text-gray-900' => auth()->user()->theme === 'light',
                    'text-white' => auth()->user()->theme === 'dark'
                ])>
                    <i class="fas fa-coins mr-2 text-yellow-500"></i>
                    Coin Activity Details
                </h3>
                <button @click="closeModal()" @class([
                    'rounded-md p-2 hover:bg-gray-100 focus:outline-none',
                    'text-gray-400 hover:text-gray-500' => auth()->user()->theme === 'light',
                    'text-gray-500 hover:text-gray-400 hover:bg-gray-700' => auth()->user()->theme === 'dark'
                ])>
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <!-- Activity Details -->
            <div class="space-y-4">
                <!-- Activity Type & Amount -->
                <div @class([
                    'p-4 rounded-lg border-l-4',
                    'bg-gray-50 border-gray-400' => auth()->user()->theme === 'light',
                    'bg-gray-700 border-gray-500' => auth()->user()->theme === 'dark'
                ]) :class="getActivityColor()">
                    <div class="flex items-center justify-between mb-2">
                        <h4 @class([
                            'font-semibold text-lg',
                            'text-gray-900' => auth()->user()->theme === 'light',
                            'text-white' => auth()->user()->theme === 'dark'
                        ]) x-text="activity.message || 'Coin Activity'"></h4>
                        <span class="text-2xl font-bold" :class="getAmountColor()" x-text="getAmountDisplay()"></span>
                    </div>
                    <p @class([
                        'text-sm',
                        'text-gray-600' => auth()->user()->theme === 'light',
                        'text-gray-300' => auth()->user()->theme === 'dark'
                    ]) x-text="getFormattedDate()"></p>
                </div>

                <!-- Transaction Details -->
                <div @class([
                    'p-4 rounded-lg',
                    'bg-gray-50' => auth()->user()->theme === 'light',
                    'bg-gray-700' => auth()->user()->theme === 'dark'
                ])>
                    <h5 @class([
                        'font-medium mb-3',
                        'text-gray-900' => auth()->user()->theme === 'light',
                        'text-white' => auth()->user()->theme === 'dark'
                    ])>Transaction Details</h5>
                    
                    <div class="space-y-2 text-sm">
                        <!-- Withdrawal Status -->
                        <div class="flex justify-between" x-show="activity.status && (activity.type === 'withdrawal_submitted' || activity.type === 'withdrawal_declined')">
                            <span>Status:</span>
                            <span class="px-2 py-1 rounded text-xs font-medium" :class="getStatusColor()" x-text="getStatusText()"></span>
                        </div>
                        
                        <!-- Withdrawal Amount (for declined withdrawals) -->
                        <div class="flex justify-between" x-show="activity.withdrawal_amount && activity.type === 'withdrawal_declined'">
                            <span>Withdrawal Amount:</span>
                            <span x-text="activity.withdrawal_amount + ' coins = ($' + (activity.withdrawal_amount * 0.01).toFixed(2) + ')'"></span>
                        </div>
                        
                        <!-- Fee Amount (for declined withdrawals with fee) -->
                        <div class="flex justify-between" x-show="activity.fee_amount && activity.fee_amount > 0 && activity.type === 'withdrawal_declined'">
                            <span>Fee Refunded:</span>
                            <span x-text="activity.fee_amount + ' coins = ($' + (activity.fee_amount * 0.01).toFixed(2) + ')'"></span>
                        </div>
                        
                        <!-- Total Amount -->
                        <div class="flex justify-between" x-show="activity.amount">
                            <span x-text="activity.type === 'withdrawal_declined' ? 'Total Refunded:' : 'Amount:'"></span>
                            <span x-text="activity.amount + ' coins = ($' + (activity.amount * 0.01).toFixed(2) + ')'"></span>
                        </div>
                        
                        <!-- Decline Reason -->
                        <div class="flex justify-between" x-show="activity.decline_reason && activity.type === 'withdrawal_declined'">
                            <span>Reason:</span>
                            <span class="text-right max-w-xs" x-text="activity.decline_reason"></span>
                        </div>
                        
                        <div class="flex justify-between" x-show="activity.fee && activity.type !== 'withdrawal_declined'">
                            <span>Fee:</span>
                            <span x-text="activity.fee + ' coins = ($' + (activity.fee * 0.01).toFixed(2) + ')'"></span>
                        </div>
                        
                        <div class="flex justify-between" x-show="activity.from_wallet">
                            <span>From Wallet:</span>
                            <span x-text="(activity.from_wallet || '').charAt(0).toUpperCase() + (activity.from_wallet || '').slice(1) + ' Wallet'"></span>
                        </div>
                        
                        <div class="flex justify-between" x-show="activity.to_wallet">
                            <span>To Wallet:</span>
                            <span x-text="(activity.to_wallet || '').charAt(0).toUpperCase() + (activity.to_wallet || '').slice(1) + ' Wallet'"></span>
                        </div>
                        
                        <div class="flex justify-between" x-show="activity.recipient_name">
                            <span>Recipient:</span>
                            <span x-text="activity.recipient_name"></span>
                        </div>
                        
                        <div class="flex justify-between" x-show="activity.sender_name">
                            <span>Sender:</span>
                            <span x-text="activity.sender_name"></span>
                        </div>
                        
                        <div class="flex justify-between" x-show="activity.recipient_wallet">
                            <span>Recipient Wallet ID:</span>
                            <span class="font-mono text-xs" x-text="activity.recipient_wallet"></span>
                        </div>
                        
                        <div class="flex justify-between" x-show="activity.sender_wallet">
                            <span>Sender Wallet ID:</span>
                            <span class="font-mono text-xs" x-text="activity.sender_wallet"></span>
                        </div>
                    </div>
                </div>

                <!-- Activity ID -->
                <div @class([
                    'p-3 rounded-lg text-center',
                    'bg-blue-50' => auth()->user()->theme === 'light',
                    'bg-blue-900/20' => auth()->user()->theme === 'dark'
                ])>
                    <p @class([
                        'text-xs',
                        'text-blue-600' => auth()->user()->theme === 'light',
                        'text-blue-400' => auth()->user()->theme === 'dark'
                    ])>
                        Activity ID: <span class="font-mono" x-text="activity.id"></span>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('coinActivityModal', () => ({
        isOpen: false,
        activity: {},

        openModal(activityData) {
            this.activity = activityData;
            this.isOpen = true;
        },

        closeModal() {
            this.isOpen = false;
            this.activity = {};
        },

        getActivityColor() {
            const type = this.activity.type;
            if (type?.includes('transfer_received') || type?.includes('sale') || type?.includes('coin_package') || type?.includes('withdrawal_declined')) {
                return 'border-green-500 bg-green-50 dark:bg-green-900/20';
            }
            return 'border-red-500 bg-red-50 dark:bg-red-900/20';
        },

        getAmountColor() {
            const type = this.activity.type;
            if (type?.includes('transfer_received') || type?.includes('sale') || type?.includes('coin_package') || type?.includes('withdrawal_declined')) {
                return 'text-green-600 dark:text-green-400';
            }
            return 'text-red-600 dark:text-red-400';
        },

        getAmountDisplay() {
            if (!this.activity.amount) return '';
            const isPositive = this.activity.type?.includes('transfer_received') || 
                              this.activity.type?.includes('sale') || 
                              this.activity.type?.includes('coin_package') ||
                              this.activity.type?.includes('withdrawal_declined');
            const sign = isPositive ? '+' : '-';
            return `${sign}${this.activity.amount} coins`;
        },

        getStatusColor() {
            const status = this.activity.status;
            if (status === 'approved') return 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400';
            if (status === 'declined') return 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400';
            return 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400';
        },

        getStatusText() {
            const status = this.activity.status;
            if (status === 'approved') return 'Approved';
            if (status === 'rejected') return 'Rejected';
            return 'Pending';
        },

        getFormattedDate() {
            if (!this.activity.created_at) return '';
            return new Date(this.activity.created_at).toLocaleString();
        }
    }));
});
</script>
@endpush