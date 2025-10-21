<x-admin-layout title="Edit Asset">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Edit Asset</h1>
                    <p class="text-gray-600 dark:text-gray-400">Update asset information</p>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('admin.assets.view', $asset) }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">
                        <i class="fas fa-eye mr-2"></i>View Asset
                    </a>
                    <a href="{{ route('admin.assets.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg">
                        <i class="fas fa-arrow-left mr-2"></i>Back to Assets
                    </a>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <form method="POST" action="{{ route('admin.assets.update', $asset) }}" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Basic Info -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Asset Title *</label>
                        <input type="text" name="title" value="{{ old('title', $asset->title) }}" required
                               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        @error('title')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Asset Type *</label>
                        <select name="asset_type" required
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            <option value="">Select Type</option>
                            @foreach($assetTypes as $key => $label)
                                <option value="{{ $key }}" {{ old('asset_type', $asset->asset_type) == $key ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('asset_type')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                </div>

                <!-- Owner & Category -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Owner *</label>
                        <select name="user_id" required
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            <option value="">Select Owner</option>
                            @foreach($affiliateUsers as $user)
                                <option value="{{ $user->id }}" {{ old('user_id', $asset->user_id) == $user->id ? 'selected' : '' }}>{{ $user->name }} ({{ $user->email }})</option>
                            @endforeach
                        </select>
                        @error('user_id')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Category *</label>
                        <select name="category_id" required
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $asset->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                </div>

                <!-- Description -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Short Description *</label>
                    <textarea name="short_description" rows="3" required
                              class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">{{ old('short_description', $asset->short_description) }}</textarea>
                    @error('short_description')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Full Details *</label>
                    <textarea name="details" rows="6" required
                              class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">{{ old('details', $asset->details) }}</textarea>
                    @error('details')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <!-- Pricing -->
                <div class="border-t pt-6">
                    <h3 class="text-lg font-semibold mb-4">Pricing Options</h3>
                    
                    <div class="mb-4">
                        <label class="flex items-center">
                            <input type="checkbox" name="is_buyable" value="1" {{ old('is_buyable', $asset->is_buyable) ? 'checked' : '' }} class="mr-2">
                            <span class="text-sm font-medium">Available for Purchase</span>
                        </label>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Buy Price ($)</label>
                            <input type="number" name="buy_price" value="{{ old('buy_price', $asset->buy_price) }}" step="0.01" min="0"
                                   class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            @error('buy_price')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Slashed Buy Price ($)</label>
                            <input type="number" name="slashed_buy_price" value="{{ old('slashed_buy_price', $asset->slashed_buy_price) }}" step="0.01" min="0"
                                   class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            @error('slashed_buy_price')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </div>

                <!-- Status & Settings -->
                <div class="border-t pt-6">
                    <h3 class="text-lg font-semibold mb-4">Status & Settings</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Marketplace Status</label>
                            <select name="marketplace_status" required
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                <option value="live" {{ old('marketplace_status', $asset->marketplace_status) == 'live' ? 'selected' : '' }}>Live</option>
                                <option value="removed" {{ old('marketplace_status', $asset->marketplace_status) == 'removed' ? 'selected' : '' }}>Removed</option>
                                <option value="suspended" {{ old('marketplace_status', $asset->marketplace_status) == 'suspended' ? 'selected' : '' }}>Suspended</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="space-y-4">
                        <label class="flex items-center">
                            <input type="checkbox" name="system_managed" value="1" {{ old('system_managed', $asset->system_managed) ? 'checked' : '' }} class="mr-2">
                            <span class="text-sm font-medium">System Managed (50% revenue share vs 30%)</span>
                        </label>
                        
                        <label class="flex items-center">
                            <input type="checkbox" name="is_public" value="1" {{ old('is_public', $asset->is_public) ? 'checked' : '' }} class="mr-2">
                            <span class="text-sm font-medium">Public (visible in marketplace)</span>
                        </label>
                        
                        <label class="flex items-center">
                            <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $asset->is_featured) ? 'checked' : '' }} class="mr-2">
                            <span class="text-sm font-medium">Featured</span>
                        </label>
                    </div>
                </div>

                <!-- Submit -->
                <div class="flex justify-end space-x-3 pt-6 border-t">
                    <a href="{{ route('admin.assets.view', $asset) }}" class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-4 py-2 rounded-lg">
                        Cancel
                    </a>
                    <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-lg">
                        <i class="fas fa-save mr-2"></i>Update Asset
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>