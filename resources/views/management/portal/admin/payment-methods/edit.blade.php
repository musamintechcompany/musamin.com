<x-admin-layout title="Edit Payment Method">
<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Edit Payment Method</h1>
        <a href="{{ route('admin.payment-methods.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg">
            <i class="fas fa-arrow-left mr-2"></i>Back
        </a>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <form action="{{ route('admin.payment-methods.update', $paymentMethod) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Method Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $paymentMethod->name) }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                           required>
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="type" class="block text-sm font-medium text-gray-700 mb-2">Type</label>
                    <select name="type" id="type" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                            required>
                        <option value="">Select Type</option>
                        <option value="Credit Card" {{ old('type', $paymentMethod->type) == 'Credit Card' ? 'selected' : '' }}>Credit Card</option>
                        <option value="Debit Card" {{ old('type', $paymentMethod->type) == 'Debit Card' ? 'selected' : '' }}>Debit Card</option>
                        <option value="PayPal" {{ old('type', $paymentMethod->type) == 'PayPal' ? 'selected' : '' }}>PayPal</option>
                        <option value="Bank Transfer" {{ old('type', $paymentMethod->type) == 'Bank Transfer' ? 'selected' : '' }}>Bank Transfer</option>
                        <option value="Cryptocurrency" {{ old('type', $paymentMethod->type) == 'Cryptocurrency' ? 'selected' : '' }}>Cryptocurrency</option>
                        <option value="Other" {{ old('type', $paymentMethod->type) == 'Other' ? 'selected' : '' }}>Other</option>
                    </select>
                    @error('type')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="sort_order" class="block text-sm font-medium text-gray-700 mb-2">Sort Order</label>
                    <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', $paymentMethod->sort_order) }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('sort_order')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-6">
                <label for="details" class="block text-sm font-medium text-gray-700 mb-2">Details (JSON)</label>
                <textarea name="details" id="details" rows="4" 
                          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                          placeholder='{"account_number": "123456789", "routing_number": "987654321"}'>{{ old('details', $paymentMethod->details ? json_encode($paymentMethod->details, JSON_PRETTY_PRINT) : '') }}</textarea>
                <p class="text-sm text-gray-500 mt-1">Enter payment method details in JSON format</p>
                @error('details')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mt-6">
                <div class="flex items-center">
                    <input type="checkbox" name="is_active" id="is_active" value="1" 
                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                           {{ old('is_active', $paymentMethod->is_active) ? 'checked' : '' }}>
                    <label for="is_active" class="ml-2 text-sm text-gray-700">
                        Active
                    </label>
                </div>
                @error('is_active')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end space-x-3 mt-6">
                <a href="{{ route('admin.payment-methods.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg">
                    Cancel
                </a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                    Update Method
                </button>
            </div>
        </form>
    </div>
</div>
</x-admin-layout>