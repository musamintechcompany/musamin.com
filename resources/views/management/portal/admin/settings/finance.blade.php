<x-admin-layout title="Financial Settings">
<div class="p-4 lg:p-6">
    <div class="space-y-4 overflow-hidden">
        <div class="flex flex-col sm:flex-row lg:justify-between lg:items-center gap-4">
            <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold text-gray-900 dark:text-white">Financial Settings</h1>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
            <form method="POST" action="{{ route('admin.settings.finance.update') }}" class="p-6 space-y-6">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">Purchase Fee</h3>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Fee Type</label>
                            <select name="purchase_fee_type" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" 
                                    required>
                                <option value="percentage" {{ old('purchase_fee_type', $settings->purchase_fee_type) == 'percentage' ? 'selected' : '' }}>Percentage</option>
                                <option value="fixed" {{ old('purchase_fee_type', $settings->purchase_fee_type) == 'fixed' ? 'selected' : '' }}>Fixed Amount</option>
                            </select>
                            @error('purchase_fee_type')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Fee Amount</label>
                            <input type="number" step="0.01" min="0" name="purchase_fee" 
                                   value="{{ old('purchase_fee', $settings->purchase_fee) }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" 
                                   required>
                            @error('purchase_fee')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="space-y-4">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">Withdrawal Fee</h3>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Fee Type</label>
                            <select name="withdrawal_fee_type" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" 
                                    required>
                                <option value="percent" {{ old('withdrawal_fee_type', $settings->withdrawal_fee_type) == 'percent' ? 'selected' : '' }}>Percentage</option>
                                <option value="fixed" {{ old('withdrawal_fee_type', $settings->withdrawal_fee_type) == 'fixed' ? 'selected' : '' }}>Fixed Amount</option>
                            </select>
                            @error('withdrawal_fee_type')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Fee Amount</label>
                            <input type="number" step="0.01" min="0" name="withdrawal_fee" 
                                   value="{{ old('withdrawal_fee', $settings->withdrawal_fee) }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" 
                                   required>
                            @error('withdrawal_fee')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="border-t pt-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Exchange & Program Settings</h3>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">USD to Coins Rate</label>
                            <input type="number" name="usd_to_coins_rate" value="{{ old('usd_to_coins_rate', $settings->usd_to_coins_rate) }}" 
                                   step="0.01" min="0"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" 
                                   required>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">How many coins equal 1 USD</p>
                            @error('usd_to_coins_rate')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Affiliate Monthly Fee (USD)</label>
                            <input type="number" name="affiliate_monthly_fee" value="{{ old('affiliate_monthly_fee', $settings->affiliate_monthly_fee) }}" 
                                   step="0.01" min="0"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" 
                                   required>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Monthly affiliate program fee in USD</p>
                            @error('affiliate_monthly_fee')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Affiliate Yearly Fee (USD)</label>
                            <input type="number" name="affiliate_yearly_fee" value="{{ old('affiliate_yearly_fee', $settings->affiliate_yearly_fee) }}" 
                                   step="0.01" min="0"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" 
                                   required>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Yearly affiliate program fee in USD</p>
                            @error('affiliate_yearly_fee')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Minimum Withdrawal Amount</label>
                            <input type="number" name="minimum_withdrawal_amount" value="{{ old('minimum_withdrawal_amount', $settings->minimum_withdrawal_amount) }}" 
                                   step="0.01" min="0"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" 
                                   required>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Minimum coins required for withdrawal</p>
                            @error('minimum_withdrawal_amount')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="flex justify-end">
                    <button type="submit" 
                            class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                        <i class="fas fa-save mr-2"></i>
                        Update Financial Settings
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
</x-admin-layout>