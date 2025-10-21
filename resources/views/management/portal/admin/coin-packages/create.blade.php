<x-admin-layout title="Create Coin Package">
<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Create Coin Package</h1>
        <a href="{{ route('admin.coin-packages.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg">
            <i class="fas fa-arrow-left mr-2"></i>Back
        </a>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <form action="{{ route('admin.coin-packages.store') }}" method="POST">
            @csrf

            <!-- Package Information Section -->
            <div class="mb-8 pb-6 border-b border-gray-200">
                <h2 class="text-lg font-medium text-gray-900 mb-4">Package Information</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="pack_name" class="block text-sm font-medium text-gray-700 mb-2">Package Name</label>
                        <input type="text" name="pack_name" id="pack_name" value="{{ old('pack_name') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                               required placeholder="E.g., Starter, Pro">
                        <p class="text-xs text-gray-500 mt-1">Package name for internal reference</p>
                        @error('pack_name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="badge_color" class="block text-sm font-medium text-gray-700 mb-2">Badge Color</label>
                        <div class="flex items-center">
                            <input type="color" name="badge_color" id="badge_color" value="{{ old('badge_color', '#3b82f6') }}"
                                   class="w-10 h-10 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 mr-3">
                            <input type="text" name="badge_color_hex" id="badge_color_hex" value="{{ old('badge_color', '#3b82f6') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                   placeholder="#3b82f6">
                        </div>
                        <p class="text-xs text-gray-500 mt-1">Color for the package name badge</p>
                        @error('badge_color')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Pricing & Coins Section -->
            <div class="mb-8 pb-6 border-b border-gray-200">
                <h2 class="text-lg font-medium text-gray-900 mb-4">Pricing & Coins</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label for="coins" class="block text-sm font-medium text-gray-700 mb-2">Base Coin Amount</label>
                        <input type="number" name="coins" id="coins" value="{{ old('coins') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                               required min="1" placeholder="E.g., 500">
                        <p class="text-xs text-gray-500 mt-1">The core number of coins included</p>
                        @error('coins')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="bonus_coins" class="block text-sm font-medium text-gray-700 mb-2">Bonus Coins</label>
                        <input type="number" name="bonus_coins" id="bonus_coins" value="{{ old('bonus_coins', 0) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                               min="0" placeholder="E.g., 50">
                        <p class="text-xs text-gray-500 mt-1">Extra coins as promotional incentive</p>
                        @error('bonus_coins')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="price" class="block text-sm font-medium text-gray-700 mb-2">Purchase Price (USD)</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-500">$</span>
                            </div>
                            <input type="number" name="price" id="price" value="{{ old('price') }}"
                                   class="w-full pl-7 pr-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                   required min="0" step="0.01" placeholder="E.g., 9.99">
                        </div>
                        <p class="text-xs text-gray-500 mt-1">Customer price in US dollars</p>
                        @error('price')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Package Settings Section -->
            <div class="mb-8 pb-6 border-b border-gray-200">
                <h2 class="text-lg font-medium text-gray-900 mb-4">Package Settings</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="flex items-center">
                            <input type="checkbox" name="is_active" id="is_active" value="1"
                                   {{ old('is_active', true) ? 'checked' : '' }}
                                   class="rounded border-gray-300 text-blue-600 focus:ring-blue-500 mr-2">
                            <span class="text-sm font-medium text-gray-700">Package Active?</span>
                        </label>
                        <p class="text-xs text-gray-500 mt-1 ml-6">Enable/disable package availability</p>
                        @error('is_active')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="sort_order" class="block text-sm font-medium text-gray-700 mb-2">Sorting Order</label>
                        <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', 0) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                               min="0" placeholder="E.g., 1">
                        <p class="text-xs text-gray-500 mt-1">Lower numbers show first in listings</p>
                        @error('sort_order')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Package Features Section -->
            <div class="mb-8">
                <h2 class="text-lg font-medium text-gray-900 mb-4">Package Features</h2>
                <div x-data="{ features: {{ json_encode(old('features', ['', ''])) }} }">
                    <template x-for="(feature, index) in features" :key="index">
                        <div class="flex items-center mb-3">
                            <input type="text" x-model="features[index]"
                                   :name="'features[' + index + ']'"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                   placeholder="E.g., 24/7 priority support">
                            <button type="button" @click="features.splice(index, 1)" class="ml-2 text-red-500 hover:text-red-700" x-show="features.length > 1">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </template>
                    <button type="button" @click="features.push('')" class="mt-2 text-sm text-blue-600 hover:text-blue-800">
                        <i class="fas fa-plus mr-1"></i> Add Another Feature
                    </button>
                    <p class="text-xs text-gray-500 mt-2">List all benefits included in this package</p>
                    @error('features')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    @error('features.*')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex justify-end space-x-3 mt-6">
                <a href="{{ route('admin.coin-packages.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg">
                    Cancel
                </a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                    Create Package
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Sync color picker and hex input
    document.addEventListener('DOMContentLoaded', function() {
        const colorPicker = document.getElementById('badge_color');
        const hexInput = document.getElementById('badge_color_hex');

        if (colorPicker && hexInput) {
            colorPicker.addEventListener('input', function() {
                hexInput.value = this.value;
            });

            hexInput.addEventListener('input', function() {
                // Validate hex color format
                if (/^#([0-9A-F]{3}){1,2}$/i.test(this.value)) {
                    colorPicker.value = this.value;
                }
            });
        }
    });
</script>
</x-admin-layout>