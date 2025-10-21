<x-affiliate-layout>
    <div class="py-6">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Create New Asset</h1>
                    <p class="text-gray-600 dark:text-gray-400">Add a new digital asset to the marketplace</p>
                </div>
                <a href="{{ route('affiliate.assets.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i>Back to Assets
                </a>
            </div>

            <!-- Form -->
            <div class="bg-white rounded-lg shadow-sm dark:bg-gray-800">
                <form action="{{ route('affiliate.assets.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
                    @csrf
                    
                    <!-- Basic Info -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Asset Title *</label>
                            <input type="text" name="title" value="{{ old('title') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md dark:border-gray-600 dark:bg-gray-700 text-gray-900 dark:text-white" required>
                            @error('title')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Asset Type *</label>
                            <select name="asset_type" class="w-full px-3 py-2 border border-gray-300 rounded-md dark:border-gray-600 dark:bg-gray-700 text-gray-900 dark:text-white" required>
                                <option value="">Select Type</option>
                                @foreach($assetTypes as $key => $label)
                                    <option value="{{ $key }}" {{ old('asset_type') == $key ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                            @error('asset_type')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <!-- Category & Subcategory -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Category *</label>
                            <select name="category_id" id="category_id" class="w-full px-3 py-2 border border-gray-300 rounded-md dark:border-gray-600 dark:bg-gray-700 text-gray-900 dark:text-white" required>
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Subcategory</label>
                            <select name="subcategory_id" id="subcategory_id" class="w-full px-3 py-2 border border-gray-300 rounded-md dark:border-gray-600 dark:bg-gray-700 text-gray-900 dark:text-white">
                                <option value="">Select Subcategory</option>
                            </select>
                            <input type="text" name="new_subcategory" id="new_subcategory" placeholder="Or create new subcategory" class="w-full px-3 py-2 border border-gray-300 rounded-md dark:border-gray-600 dark:bg-gray-700 text-gray-900 dark:text-white mt-2" style="display: none;">
                            @error('subcategory_id')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <!-- Description -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Short Description *</label>
                        <textarea name="short_description" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md dark:border-gray-600 dark:bg-gray-700 text-gray-900 dark:text-white" required>{{ old('short_description') }}</textarea>
                        @error('short_description')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Full Details *</label>
                        <textarea name="details" rows="6" class="w-full px-3 py-2 border border-gray-300 rounded-md dark:border-gray-600 dark:bg-gray-700 text-gray-900 dark:text-white" required>{{ old('details') }}</textarea>
                        @error('details')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                    </div>

                    <!-- Pricing -->
                    <div class="border-t pt-6">
                        <h3 class="text-lg font-semibold mb-4">Pricing Options</h3>
                        
                        <!-- Buy Options -->
                        <div class="mb-4">
                            <label class="flex items-center">
                                <input type="checkbox" name="is_buyable" value="1" {{ old('is_buyable') ? 'checked' : 'checked' }} class="mr-2">
                                <span class="text-sm font-medium">Available for Purchase</span>
                            </label>
                        </div>
                        
                        <div id="buy_options" class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Buy Price ($)</label>
                                <input type="number" name="buy_price" value="{{ old('buy_price') }}" step="0.01" min="0" class="w-full px-3 py-2 border border-gray-300 rounded-md dark:border-gray-600 dark:bg-gray-700 text-gray-900 dark:text-white">
                                @error('buy_price')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Slashed Buy Price ($)</label>
                                <input type="number" name="slashed_buy_price" value="{{ old('slashed_buy_price') }}" step="0.01" min="0" class="w-full px-3 py-2 border border-gray-300 rounded-md dark:border-gray-600 dark:bg-gray-700 text-gray-900 dark:text-white">
                                @error('slashed_buy_price')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <!-- Rent Options -->
                        <div class="mb-4">
                            <label class="flex items-center">
                                <input type="checkbox" name="is_rentable" value="1" {{ old('is_rentable') ? 'checked' : '' }} class="mr-2">
                                <span class="text-sm font-medium">Available for Rental</span>
                            </label>
                        </div>
                        
                        <div id="rent_options" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6" style="display: none;">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Daily ($)</label>
                                <input type="number" name="daily_rent_price" value="{{ old('daily_rent_price') }}" step="0.01" min="0" class="w-full px-3 py-2 border border-gray-300 rounded-md dark:border-gray-600 dark:bg-gray-700 text-gray-900 dark:text-white">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Weekly ($)</label>
                                <input type="number" name="weekly_rent_price" value="{{ old('weekly_rent_price') }}" step="0.01" min="0" class="w-full px-3 py-2 border border-gray-300 rounded-md dark:border-gray-600 dark:bg-gray-700 text-gray-900 dark:text-white">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Monthly ($)</label>
                                <input type="number" name="monthly_rent_price" value="{{ old('monthly_rent_price') }}" step="0.01" min="0" class="w-full px-3 py-2 border border-gray-300 rounded-md dark:border-gray-600 dark:bg-gray-700 text-gray-900 dark:text-white">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Yearly ($)</label>
                                <input type="number" name="yearly_rent_price" value="{{ old('yearly_rent_price') }}" step="0.01" min="0" class="w-full px-3 py-2 border border-gray-300 rounded-md dark:border-gray-600 dark:bg-gray-700 text-gray-900 dark:text-white">
                            </div>
                        </div>
                    </div>

                    <!-- Developer Info -->
                    <div class="border-t pt-6">
                        <h3 class="text-lg font-semibold mb-4">Developer Information</h3>
                        
                        <div class="mb-4">
                            <label class="flex items-center">
                                <input type="checkbox" name="is_team_work" value="1" {{ old('is_team_work') ? 'checked' : '' }} class="mr-2">
                                <span class="text-sm font-medium">Built by Team</span>
                            </label>
                        </div>
                        
                        <div id="team_developers" style="display: none;">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Developer Names</label>
                            <div id="developer_names_container">
                                <input type="text" name="developer_names[]" placeholder="Developer name" class="w-full px-3 py-2 border border-gray-300 rounded-md dark:border-gray-600 dark:bg-gray-700 text-gray-900 dark:text-white mb-2">
                            </div>
                            <button type="button" id="add_developer" class="text-blue-600 hover:text-blue-800 text-sm">+ Add Another Developer</button>
                        </div>
                    </div>

                    <!-- Files & Media -->
                    <div class="border-t pt-6">
                        <h3 class="text-lg font-semibold mb-4">Files & Media</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Asset File (ZIP)</label>
                                <input type="file" name="asset_file" accept=".zip" class="w-full px-3 py-2 border border-gray-300 rounded-md dark:border-gray-600 dark:bg-gray-700">
                                @error('asset_file')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">README File</label>
                                <input type="file" name="readme_file" accept=".txt,.md" class="w-full px-3 py-2 border border-gray-300 rounded-md dark:border-gray-600 dark:bg-gray-700">
                                @error('readme_file')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <div class="mt-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Media Files (Images/Videos)</label>
                            <input type="file" name="media_files[]" multiple accept="image/*,video/*" class="w-full px-3 py-2 border border-gray-300 rounded-md dark:border-gray-600 dark:bg-gray-700">
                            @error('media_files')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                        </div>

                        <div class="mt-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Live Preview URL</label>
                            <input type="url" name="live_preview_url" value="{{ old('live_preview_url') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md dark:border-gray-600 dark:bg-gray-700 text-gray-900 dark:text-white">
                            @error('live_preview_url')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <!-- Additional Info -->
                    <div class="border-t pt-6">
                        <h3 class="text-lg font-semibold mb-4">Additional Information</h3>
                        
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Tags (comma separated)</label>
                            <input type="text" name="tags" value="{{ old('tags') }}" placeholder="e.g. responsive, modern, ecommerce" class="w-full px-3 py-2 border border-gray-300 rounded-md dark:border-gray-600 dark:bg-gray-700 text-gray-900 dark:text-white">
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Features</label>
                            <div id="features_container">
                                <input type="text" name="features[]" placeholder="Feature description" class="w-full px-3 py-2 border border-gray-300 rounded-md dark:border-gray-600 dark:bg-gray-700 text-gray-900 dark:text-white mb-2">
                            </div>
                            <button type="button" id="add_feature" class="text-blue-600 hover:text-blue-800 text-sm">+ Add Feature</button>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Requirements</label>
                            <div id="requirements_container">
                                <input type="text" name="requirements[]" placeholder="System requirement" class="w-full px-3 py-2 border border-gray-300 rounded-md dark:border-gray-600 dark:bg-gray-700 text-gray-900 dark:text-white mb-2">
                            </div>
                            <button type="button" id="add_requirement" class="text-blue-600 hover:text-blue-800 text-sm">+ Add Requirement</button>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">License Information</label>
                            <textarea name="license_info" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-md dark:border-gray-600 dark:bg-gray-700 text-gray-900 dark:text-white">{{ old('license_info') }}</textarea>
                        </div>
                    </div>

                    <!-- Settings -->
                    <div class="border-t pt-6">
                        <h3 class="text-lg font-semibold mb-4">Asset Settings</h3>
                        
                        <div class="space-y-4">
                            <label class="flex items-center">
                                <input type="checkbox" name="system_managed" value="1" {{ old('system_managed', true) ? 'checked' : '' }} class="mr-2">
                                <span class="text-sm font-medium">System Managed (50% revenue share vs 30%)</span>
                            </label>
                            
                            <label class="flex items-center">
                                <input type="checkbox" name="is_public" value="1" {{ old('is_public', true) ? 'checked' : '' }} class="mr-2">
                                <span class="text-sm font-medium">Public (visible in marketplace)</span>
                            </label>
                            
                            <label class="flex items-center">
                                <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }} class="mr-2">
                                <span class="text-sm font-medium">Featured (50 coins for 30 days)</span>
                            </label>
                        </div>
                    </div>

                    <!-- Submit -->
                    <div class="flex justify-end space-x-4 pt-6 border-t">
                        <a href="{{ route('affiliate.assets.index') }}" class="px-6 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">Cancel</a>
                        <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Create Asset</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Dynamic form functionality
        document.addEventListener('DOMContentLoaded', function() {
            // Rental options toggle
            const rentableCheckbox = document.querySelector('input[name="is_rentable"]');
            const rentOptions = document.getElementById('rent_options');
            
            rentableCheckbox.addEventListener('change', function() {
                rentOptions.style.display = this.checked ? 'grid' : 'none';
            });

            // Team work toggle
            const teamWorkCheckbox = document.querySelector('input[name="is_team_work"]');
            const teamDevelopers = document.getElementById('team_developers');
            
            teamWorkCheckbox.addEventListener('change', function() {
                teamDevelopers.style.display = this.checked ? 'block' : 'none';
            });

            // Add developer
            document.getElementById('add_developer').addEventListener('click', function() {
                const container = document.getElementById('developer_names_container');
                const input = document.createElement('input');
                input.type = 'text';
                input.name = 'developer_names[]';
                input.placeholder = 'Developer name';
                input.className = 'w-full px-3 py-2 border border-gray-300 rounded-md dark:border-gray-600 dark:bg-gray-700 text-gray-900 dark:text-white mb-2';
                container.appendChild(input);
            });

            // Add feature
            document.getElementById('add_feature').addEventListener('click', function() {
                const container = document.getElementById('features_container');
                const input = document.createElement('input');
                input.type = 'text';
                input.name = 'features[]';
                input.placeholder = 'Feature description';
                input.className = 'w-full px-3 py-2 border border-gray-300 rounded-md dark:border-gray-600 dark:bg-gray-700 text-gray-900 dark:text-white mb-2';
                container.appendChild(input);
            });

            // Add requirement
            document.getElementById('add_requirement').addEventListener('click', function() {
                const container = document.getElementById('requirements_container');
                const input = document.createElement('input');
                input.type = 'text';
                input.name = 'requirements[]';
                input.placeholder = 'System requirement';
                input.className = 'w-full px-3 py-2 border border-gray-300 rounded-md dark:border-gray-600 dark:bg-gray-700 text-gray-900 dark:text-white mb-2';
                container.appendChild(input);
            });

            // Category change - load subcategories
            document.getElementById('category_id').addEventListener('change', function() {
                const categoryId = this.value;
                const subcategorySelect = document.getElementById('subcategory_id');
                const newSubcategoryInput = document.getElementById('new_subcategory');
                
                if (categoryId) {
                    fetch(`/affiliate/assets/categories/${categoryId}/subcategories`)
                        .then(response => response.json())
                        .then(data => {
                            subcategorySelect.innerHTML = '<option value="">Select Subcategory</option>';
                            data.subcategories.forEach(sub => {
                                subcategorySelect.innerHTML += `<option value="${sub.id}">${sub.name}</option>`;
                            });
                            subcategorySelect.innerHTML += '<option value="other">Other (Create New)</option>';
                        });
                } else {
                    subcategorySelect.innerHTML = '<option value="">Select Subcategory</option>';
                }
            });

            // Subcategory change - show/hide new input
            document.getElementById('subcategory_id').addEventListener('change', function() {
                const newSubcategoryInput = document.getElementById('new_subcategory');
                newSubcategoryInput.style.display = this.value === 'other' ? 'block' : 'none';
            });
        });
    </script>
    @endpush
</x-affiliate-layout>