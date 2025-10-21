<x-admin-layout title="Add Payment Method">
<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Add Payment Method</h1>
        <a href="{{ route('admin.payment-methods.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg">
            <i class="fas fa-arrow-left mr-2"></i>Back
        </a>
    </div>

    <form action="{{ route('admin.payment-methods.store') }}" method="POST">
        @csrf
        
        <!-- Basic Information -->
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Basic Information</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="type" class="block text-sm font-medium text-gray-700 mb-2">Payment Type</label>
                    <select name="type" id="type" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        <option value="">Select Type</option>
                        <option value="manual" {{ old('type') == 'manual' ? 'selected' : '' }}>Manual Payment</option>
                        <option value="automatic" {{ old('type') == 'automatic' ? 'selected' : '' }}>Automatic Payment</option>
                    </select>
                    @error('type') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="category" class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                    <select name="category" id="category" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        <option value="">Select Category</option>
                        <option value="crypto" {{ old('category') == 'crypto' ? 'selected' : '' }}>Crypto Credentials</option>
                        <option value="bank" {{ old('category') == 'bank' ? 'selected' : '' }}>Bank Credentials</option>
                    </select>
                    @error('category') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Method Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    @error('name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="code" class="block text-sm font-medium text-gray-700 mb-2">Code</label>
                    <input type="text" name="code" id="code" value="{{ old('code') }}" placeholder="E.g: BTC, NGN, ETH" maxlength="10" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    @error('code') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="md:col-span-2">
                    <label for="icon" class="block text-sm font-medium text-gray-700 mb-2">Icon Class</label>
                    <input type="text" name="icon" id="icon" value="{{ old('icon') }}" placeholder="e.g. fab fa-bitcoin" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    <p class="text-sm text-gray-500 mt-1">Enter Font Awesome icon class</p>
                    @error('icon') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        <!-- Configuration -->
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Configuration</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="usd_rate" class="block text-sm font-medium text-gray-700 mb-2">USD Rate</label>
                    <div class="relative">
                        <span class="absolute left-3 top-2 text-gray-500">1 USD =</span>
                        <input type="number" name="usd_rate" id="usd_rate" value="{{ old('usd_rate') }}" step="0.00000001" min="0" class="w-full pl-16 pr-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    </div>
                    @error('usd_rate') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div id="currency_symbol_field" style="display: none;">
                    <label for="currency_symbol" class="block text-sm font-medium text-gray-700 mb-2">Currency Symbol</label>
                    <input type="text" name="currency_symbol" id="currency_symbol" value="{{ old('currency_symbol') }}" maxlength="5" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('currency_symbol') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div id="countdown_field" style="display: none;">
                    <label for="countdown_time" class="block text-sm font-medium text-gray-700 mb-2">Countdown Time</label>
                    <div class="relative">
                        <input type="number" name="countdown_time" id="countdown_time" value="{{ old('countdown_time', 180) }}" min="30" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <span class="absolute right-3 top-2 text-gray-500">seconds</span>
                    </div>
                    @error('countdown_time') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="sort_order" class="block text-sm font-medium text-gray-700 mb-2">Sort Order</label>
                    <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', 0) }}" min="0" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('sort_order') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="mt-4 space-y-3">
                <div class="flex items-center">
                    <input type="checkbox" name="has_fee" id="has_fee" value="1" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" {{ old('has_fee', true) ? 'checked' : '' }}>
                    <label for="has_fee" class="ml-2 text-sm text-gray-700">Apply Fees</label>
                </div>
                <div class="flex items-center">
                    <input type="checkbox" name="is_active" id="is_active" value="1" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" {{ old('is_active', true) ? 'checked' : '' }}>
                    <label for="is_active" class="ml-2 text-sm text-gray-700">Active</label>
                </div>
            </div>
        </div>

        <!-- Crypto Credentials -->
        <div id="crypto_section" class="bg-white rounded-lg shadow p-6 mb-6" style="display: none;">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Crypto Wallets</h2>
            <div id="crypto_wallets">
                <div class="crypto-wallet border border-gray-200 rounded-lg p-4 mb-4">
                    <div class="flex justify-between items-center mb-3">
                        <h3 class="font-medium text-gray-900">Wallet #1</h3>
                        <button type="button" class="remove-wallet text-red-600 hover:text-red-800" style="display: none;">Remove</button>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Wallet Address</label>
                            <input type="text" name="crypto_wallets[0][address]" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Admin Notes</label>
                            <textarea name="crypto_wallets[0][comment]" rows="2" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                        </div>
                        <div>
                            <div class="flex items-center">
                                <input type="checkbox" name="crypto_wallets[0][active]" value="1" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" checked>
                                <label class="ml-2 text-sm text-gray-700">Active</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <button type="button" id="add_crypto_wallet" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm">
                <i class="fas fa-plus mr-2"></i>Add Wallet
            </button>
        </div>

        <!-- Bank Credentials -->
        <div id="bank_section" class="bg-white rounded-lg shadow p-6 mb-6" style="display: none;">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Bank Accounts</h2>
            <div id="bank_groups">
                <div class="bank-group border border-gray-200 rounded-lg p-4 mb-4">
                    <div class="flex justify-between items-center mb-3">
                        <h3 class="font-medium text-gray-900">Bank Account #1</h3>
                        <button type="button" class="remove-bank text-red-600 hover:text-red-800" style="display: none;">Remove</button>
                    </div>
                    <div class="bank-details mb-4">
                        <div class="bank-detail grid grid-cols-1 md:grid-cols-2 gap-4 mb-3 relative">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Title</label>
                                <input type="text" name="bank_groups[0][details][0][title]" placeholder="E.g: Bank Name" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Value</label>
                                <div class="relative">
                                    <input type="text" name="bank_groups[0][details][0][value]" class="w-full px-3 py-2 pr-10 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <button type="button" class="remove-detail absolute right-2 top-2 text-red-600 hover:text-red-800 text-sm" title="Remove this detail" style="display: none;">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="add-bank-detail bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-sm mb-3">
                        <i class="fas fa-plus mr-1"></i>Add Detail
                    </button>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Admin Notes</label>
                        <textarea name="bank_groups[0][comment]" rows="2" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                    </div>
                    <div class="mt-3">
                        <div class="flex items-center">
                            <input type="checkbox" name="bank_groups[0][active]" value="1" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" checked>
                            <label class="ml-2 text-sm text-gray-700">Active</label>
                        </div>
                    </div>
                </div>
            </div>
            <button type="button" id="add_bank_group" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm">
                <i class="fas fa-plus mr-2"></i>Add Bank Account
            </button>
        </div>

        <div class="flex justify-end space-x-3">
            <a href="{{ route('admin.payment-methods.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg">
                Cancel
            </a>
            <button type="submit" id="submitBtn" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                <span id="submitText">Create Payment Method</span>
                <span id="submitSpinner" class="hidden ml-2">...</span>
            </button>
        </div>
    </form>
</div>

<script>
let cryptoWalletCount = 1;
let bankGroupCount = 1;

// Show/hide fields based on selections
document.getElementById('type').addEventListener('change', function() {
    const countdownField = document.getElementById('countdown_field');
    if (this.value === 'manual') {
        countdownField.style.display = 'block';
        document.getElementById('countdown_time').setAttribute('required', 'required');
    } else {
        countdownField.style.display = 'none';
        document.getElementById('countdown_time').removeAttribute('required');
    }
});

document.getElementById('category').addEventListener('change', function() {
    const cryptoSection = document.getElementById('crypto_section');
    const bankSection = document.getElementById('bank_section');
    const currencyField = document.getElementById('currency_symbol_field');
    
    // Remove required from all credential fields first
    document.querySelectorAll('#crypto_section input, #bank_section input').forEach(input => {
        input.removeAttribute('required');
    });
    
    if (this.value === 'crypto') {
        cryptoSection.style.display = 'block';
        bankSection.style.display = 'none';
        currencyField.style.display = 'none';
        // Add required to crypto fields
        document.querySelectorAll('#crypto_section input[name*="[address]"]').forEach(input => {
            input.setAttribute('required', 'required');
        });
    } else if (this.value === 'bank') {
        cryptoSection.style.display = 'none';
        bankSection.style.display = 'block';
        currencyField.style.display = 'block';
        // Add required to bank fields
        document.querySelectorAll('#bank_section input[name*="[title]"], #bank_section input[name*="[value]"]').forEach(input => {
            input.setAttribute('required', 'required');
        });
    } else {
        cryptoSection.style.display = 'none';
        bankSection.style.display = 'none';
        currencyField.style.display = 'none';
    }
});

// Add crypto wallet
document.getElementById('add_crypto_wallet').addEventListener('click', function() {
    const container = document.getElementById('crypto_wallets');
    const walletHtml = `
        <div class="crypto-wallet border border-gray-200 rounded-lg p-4 mb-4">
            <div class="flex justify-between items-center mb-3">
                <h3 class="font-medium text-gray-900">Wallet #${cryptoWalletCount + 1}</h3>
                <button type="button" class="remove-wallet text-red-600 hover:text-red-800">Remove</button>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Wallet Address</label>
                    <input type="text" name="crypto_wallets[${cryptoWalletCount}][address]" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Admin Notes</label>
                    <textarea name="crypto_wallets[${cryptoWalletCount}][comment]" rows="2" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                </div>
                <div>
                    <div class="flex items-center">
                        <input type="checkbox" name="crypto_wallets[${cryptoWalletCount}][active]" value="1" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" checked>
                        <label class="ml-2 text-sm text-gray-700">Active</label>
                    </div>
                </div>
            </div>
        </div>
    `;
    container.insertAdjacentHTML('beforeend', walletHtml);
    cryptoWalletCount++;
    updateRemoveButtons();
});

// Add bank group
document.getElementById('add_bank_group').addEventListener('click', function() {
    const container = document.getElementById('bank_groups');
    const groupHtml = `
        <div class="bank-group border border-gray-200 rounded-lg p-4 mb-4">
            <div class="flex justify-between items-center mb-3">
                <h3 class="font-medium text-gray-900">Bank Account #${bankGroupCount + 1}</h3>
                <button type="button" class="remove-bank text-red-600 hover:text-red-800">Remove</button>
            </div>
            <div class="bank-details mb-4">
                <div class="bank-detail grid grid-cols-1 md:grid-cols-2 gap-4 mb-3">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Title</label>
                        <input type="text" name="bank_groups[${bankGroupCount}][details][0][title]" placeholder="E.g: Bank Name" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Value</label>
                        <input type="text" name="bank_groups[${bankGroupCount}][details][0][value]" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    </div>
                </div>
            </div>
            <button type="button" class="add-bank-detail bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-sm mb-3">
                <i class="fas fa-plus mr-1"></i>Add Detail
            </button>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Admin Notes</label>
                <textarea name="bank_groups[${bankGroupCount}][comment]" rows="2" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
            </div>
            <div class="mt-3">
                <div class="flex items-center">
                    <input type="checkbox" name="bank_groups[${bankGroupCount}][active]" value="1" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" checked>
                    <label class="ml-2 text-sm text-gray-700">Active</label>
                </div>
            </div>
        </div>
    `;
    container.insertAdjacentHTML('beforeend', groupHtml);
    bankGroupCount++;
    updateRemoveButtons();
});

// Remove handlers
document.addEventListener('click', function(e) {
    if (e.target.classList.contains('remove-wallet')) {
        e.target.closest('.crypto-wallet').remove();
        updateRemoveButtons();
    }
    if (e.target.classList.contains('remove-bank')) {
        e.target.closest('.bank-group').remove();
        updateRemoveButtons();
    }
    if (e.target.classList.contains('add-bank-detail')) {
        const bankGroup = e.target.closest('.bank-group');
        const bankDetails = bankGroup.querySelector('.bank-details');
        const groupIndex = Array.from(document.querySelectorAll('.bank-group')).indexOf(bankGroup);
        const detailIndex = bankDetails.querySelectorAll('.bank-detail').length;
        
        const detailHtml = `
            <div class="bank-detail grid grid-cols-1 md:grid-cols-2 gap-4 mb-3 relative">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Title</label>
                    <input type="text" name="bank_groups[${groupIndex}][details][${detailIndex}][title]" placeholder="E.g: Account Number" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Value</label>
                    <div class="relative">
                        <input type="text" name="bank_groups[${groupIndex}][details][${detailIndex}][value]" class="w-full px-3 py-2 pr-10 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        <button type="button" class="remove-detail absolute right-2 top-2 text-red-600 hover:text-red-800 text-sm" title="Remove this detail">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            </div>
        `;
        bankDetails.insertAdjacentHTML('beforeend', detailHtml);
        
        // Update remove buttons visibility
        updateDetailRemoveButtons(bankGroup);
    }
    
    if (e.target.classList.contains('remove-detail') || e.target.parentElement.classList.contains('remove-detail')) {
        const detailElement = e.target.closest('.bank-detail');
        const bankGroup = e.target.closest('.bank-group');
        detailElement.remove();
        updateDetailRemoveButtons(bankGroup);
        
        // Re-index the remaining details
        reindexBankDetails(bankGroup);
    }
});

function updateRemoveButtons() {
    const wallets = document.querySelectorAll('.crypto-wallet');
    const banks = document.querySelectorAll('.bank-group');
    
    wallets.forEach((wallet, index) => {
        const removeBtn = wallet.querySelector('.remove-wallet');
        if (wallets.length > 1) {
            removeBtn.style.display = 'block';
        } else {
            removeBtn.style.display = 'none';
        }
    });
    
    banks.forEach((bank, index) => {
        const removeBtn = bank.querySelector('.remove-bank');
        if (banks.length > 1) {
            removeBtn.style.display = 'block';
        } else {
            removeBtn.style.display = 'none';
        }
        
        // Update detail remove buttons for each bank group
        updateDetailRemoveButtons(bank);
    });
}

function updateDetailRemoveButtons(bankGroup) {
    const details = bankGroup.querySelectorAll('.bank-detail');
    details.forEach((detail, index) => {
        const removeBtn = detail.querySelector('.remove-detail');
        if (details.length > 1) {
            removeBtn.style.display = 'block';
        } else {
            removeBtn.style.display = 'none';
        }
    });
}

function reindexBankDetails(bankGroup) {
    const groupIndex = Array.from(document.querySelectorAll('.bank-group')).indexOf(bankGroup);
    const details = bankGroup.querySelectorAll('.bank-detail');
    
    details.forEach((detail, detailIndex) => {
        const titleInput = detail.querySelector('input[name*="[title]"]');
        const valueInput = detail.querySelector('input[name*="[value]"]');
        
        if (titleInput) {
            titleInput.name = `bank_groups[${groupIndex}][details][${detailIndex}][title]`;
        }
        if (valueInput) {
            valueInput.name = `bank_groups[${groupIndex}][details][${detailIndex}][value]`;
        }
    });
}

// Simple form submission handler
document.querySelector('form').addEventListener('submit', function(e) {
    const submitBtn = document.getElementById('submitBtn');
    const submitText = document.getElementById('submitText');
    const submitSpinner = document.getElementById('submitSpinner');
    
    // Show loading state
    submitBtn.disabled = true;
    submitText.textContent = 'Creating...';
    submitSpinner.classList.remove('hidden');
});
</script>
</x-admin-layout>