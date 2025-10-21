<x-affiliate-layout>
    <div class="py-4 sm:py-6">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
                <h1 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white">Store Settings</h1>
                <a href="{{ route('affiliate.store.index') }}" class="px-3 py-2 sm:px-4 border border-gray-300 rounded-lg hover:bg-gray-50 dark:border-gray-600 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 text-center text-sm">
                    <i class="fas fa-arrow-left mr-1 sm:mr-2"></i>Back to Store
                </a>
            </div>

            <!-- Settings Tabs -->
            <div class="bg-white rounded-lg shadow-sm dark:bg-gray-800">
                <div class="border-b border-gray-200 dark:border-gray-700">
                    <nav class="flex space-x-2 sm:space-x-4 lg:space-x-8 px-2 sm:px-4 lg:px-6 overflow-x-auto scrollbar-hide">
                        <button class="py-3 sm:py-4 px-1 border-b-2 border-indigo-500 font-medium text-xs sm:text-sm text-indigo-600 tab-btn active whitespace-nowrap" data-tab="general">
                            <span class="hidden sm:inline">General </span>Settings
                        </button>
                        <button class="py-3 sm:py-4 px-1 border-b-2 border-transparent font-medium text-xs sm:text-sm text-gray-500 hover:text-gray-700 tab-btn whitespace-nowrap" data-tab="appearance">
                            Appearance
                        </button>
                        <button class="py-3 sm:py-4 px-1 border-b-2 border-transparent font-medium text-xs sm:text-sm text-gray-500 hover:text-gray-700 tab-btn whitespace-nowrap" data-tab="payment">
                            <span class="hidden sm:inline">Payment </span>Settings
                        </button>
                        <button class="py-3 sm:py-4 px-1 border-b-2 border-transparent font-medium text-xs sm:text-sm text-gray-500 hover:text-gray-700 tab-btn whitespace-nowrap" data-tab="urls">
                            URLs
                        </button>
                        <button class="py-3 sm:py-4 px-1 border-b-2 border-transparent font-medium text-xs sm:text-sm text-gray-500 hover:text-gray-700 tab-btn whitespace-nowrap" data-tab="shipping">
                            Shipping
                        </button>
                    </nav>
                </div>

                <div class="p-3 sm:p-4 lg:p-6">
                    <!-- General Settings -->
                    <div id="general" class="tab-content">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">General Store Settings</h3>
                        <form id="generalSettingsForm" class="space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Store Name</label>
                                    <input type="text" name="name" value="{{ $store->name }}" class="w-full px-3 py-2 border border-gray-300 rounded-md dark:border-gray-600 dark:bg-gray-700 text-gray-900 dark:text-white" required>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Store Handle</label>
                                    <div class="relative">
                                        <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500 dark:text-gray-400 pointer-events-none">@</span>
                                        <input type="text" name="handle" value="{{ ltrim($store->handle, '@') }}" class="w-full pl-8 pr-10 py-2 border border-gray-300 rounded-md dark:border-gray-600 dark:bg-gray-700 text-gray-900 dark:text-white bg-gray-50 dark:bg-gray-600" pattern="[a-zA-Z0-9]+" title="Only letters and numbers allowed" readonly>
                                        <button type="button" id="editHandleBtn" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-1">Your store URL: {{ config('app.url') }}/{{ $store->handle }}</p>
                                </div>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Store Email</label>
                                <input type="email" name="email" value="{{ $store->email ?? '' }}" class="w-full px-3 py-2 border border-gray-300 rounded-md dark:border-gray-600 dark:bg-gray-700 text-gray-900 dark:text-white">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Store Description</label>
                                <textarea name="description" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-md dark:border-gray-600 dark:bg-gray-700 text-gray-900 dark:text-white">{{ $store->description }}</textarea>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Store Status</label>
                                <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-md dark:border-gray-600 dark:bg-gray-700 text-gray-900 dark:text-white">
                                    <option value="active" {{ $store->is_active ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ !$store->is_active ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>
                            
                            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                                Save General Settings
                            </button>
                        </form>
                    </div>

                    <!-- Appearance Settings -->
                    <div id="appearance" class="tab-content hidden">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Store Appearance</h3>
                        <form id="appearanceForm" class="space-y-6" enctype="multipart/form-data">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Store Logo</label>
                                <div class="flex items-center space-x-4">
                                    <div class="w-16 h-16 bg-gray-200 rounded-lg flex items-center justify-center overflow-hidden">
                                        @if($store->logo)
                                            <img src="{{ $store->logo }}" alt="Logo" class="w-full h-full object-cover">
                                        @else
                                            <i class="fas fa-image text-gray-400"></i>
                                        @endif
                                    </div>
                                    <input type="file" name="logo" accept="image/*" class="hidden" id="logoInput">
                                    <button type="button" onclick="document.getElementById('logoInput').click()" class="px-4 py-2 border border-gray-300 rounded-md hover:bg-gray-50">Upload Logo</button>
                                </div>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Store Banner</label>
                                <div class="w-full h-32 bg-gray-200 rounded-lg flex items-center justify-center overflow-hidden">
                                    @if($store->banner)
                                        <img src="{{ $store->banner }}" alt="Banner" class="w-full h-full object-cover">
                                    @else
                                        <input type="file" name="banner" accept="image/*" class="hidden" id="bannerInput">
                                        <button type="button" onclick="document.getElementById('bannerInput').click()" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                                            <i class="fas fa-upload mr-2"></i>Upload Banner
                                        </button>
                                    @endif
                                </div>
                                @if($store->banner)
                                    <input type="file" name="banner" accept="image/*" class="mt-2 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                                @endif
                            </div>
                            
                            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                                Save Appearance
                            </button>
                        </form>
                    </div>

                    <!-- Payment Settings -->
                    <div id="payment" class="tab-content hidden">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Payment Settings</h3>
                        <div class="space-y-6">
                            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                                <div class="flex">
                                    <i class="fas fa-info-circle text-yellow-400 mr-3 mt-1"></i>
                                    <div>
                                        <h4 class="text-sm font-medium text-yellow-800">Payment Integration</h4>
                                        <p class="text-sm text-yellow-700 mt-1">Payment settings will be configured through the main platform. All transactions are processed securely through our integrated payment system.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- URLs Settings -->
                    <div id="urls" class="tab-content hidden">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Store URLs</h3>
                        <form id="urlsForm" class="space-y-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Store URLs</label>
                                <p class="text-sm text-gray-500 mb-4">Add URLs where your store can be found (social media, other platforms, etc.)</p>
                                
                                <div id="urlRepeater" class="space-y-3">
                                    <!-- URL items will be added here -->
                                </div>
                                
                                <button type="button" id="addUrlBtn" class="mt-3 px-4 py-2 border border-gray-300 rounded-md hover:bg-gray-50 text-sm">
                                    <i class="fas fa-plus mr-2"></i>Add URL
                                </button>
                            </div>
                            
                            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                                Save URLs
                            </button>
                        </form>
                    </div>

                    <!-- Shipping Settings -->
                    <div id="shipping" class="tab-content hidden">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Shipping Settings</h3>
                        <form id="shippingForm" class="space-y-6">
                            <div>
                                <label class="flex items-center">
                                    <input type="checkbox" name="offers_shipping" {{ ($store->shipping_settings['offers_shipping'] ?? false) ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Offer physical product shipping</span>
                                </label>
                            </div>
                            
                            <div id="shippingOptions" class="space-y-4 {{ ($store->shipping_settings['offers_shipping'] ?? false) ? '' : 'hidden' }}">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Default Shipping Cost</label>
                                    <input type="number" name="default_shipping_cost" step="0.01" min="0" value="{{ $store->shipping_settings['default_cost'] ?? '' }}" class="w-full px-3 py-2 border border-gray-300 rounded-md dark:border-gray-600 dark:bg-gray-700 text-gray-900 dark:text-white">
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Free Shipping Threshold</label>
                                    <input type="number" name="free_shipping_threshold" step="0.01" min="0" value="{{ $store->shipping_settings['free_threshold'] ?? '' }}" class="w-full px-3 py-2 border border-gray-300 rounded-md dark:border-gray-600 dark:bg-gray-700 text-gray-900 dark:text-white">
                                    <p class="text-xs text-gray-500 mt-1">Orders above this amount get free shipping</p>
                                </div>
                            </div>
                            
                            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                                Save Shipping Settings
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Tab functionality
        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.onclick = function(e) {
                e.preventDefault();
                const tabId = this.dataset.tab;
                
                // Update active tab button
                document.querySelectorAll('.tab-btn').forEach(b => {
                    b.classList.remove('border-indigo-500', 'text-indigo-600');
                    b.classList.add('border-transparent', 'text-gray-500');
                });
                this.classList.remove('border-transparent', 'text-gray-500');
                this.classList.add('border-indigo-500', 'text-indigo-600');
                
                // Update active tab content
                document.querySelectorAll('.tab-content').forEach(content => {
                    content.classList.add('hidden');
                });
                document.getElementById(tabId).classList.remove('hidden');
            };
        });

        // Shipping checkbox toggle
        document.querySelector('input[name="offers_shipping"]').onchange = function() {
            const shippingOptions = document.getElementById('shippingOptions');
            if (this.checked) {
                shippingOptions.classList.remove('hidden');
            } else {
                shippingOptions.classList.add('hidden');
            }
        };

        // URL Repeater functionality
        let urlCounter = 0;
        const urlRepeater = document.getElementById('urlRepeater');
        const addUrlBtn = document.getElementById('addUrlBtn');

        function addUrlField(label = '', url = '') {
            const urlItem = document.createElement('div');
            urlItem.className = 'flex gap-3 items-end';
            urlItem.innerHTML = `
                <div class="flex-1">
                    <input type="text" name="url_labels[]" placeholder="Label (e.g., Facebook, Instagram)" value="${label}" class="w-full px-3 py-2 border border-gray-300 rounded-md dark:border-gray-600 dark:bg-gray-700 text-gray-900 dark:text-white text-sm">
                </div>
                <div class="flex-1">
                    <input type="url" name="urls[]" placeholder="https://example.com" value="${url}" class="w-full px-3 py-2 border border-gray-300 rounded-md dark:border-gray-600 dark:bg-gray-700 text-gray-900 dark:text-white text-sm">
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="px-3 py-2 text-red-600 hover:text-red-800 text-sm">
                    <i class="fas fa-trash"></i>
                </button>
            `;
            urlRepeater.appendChild(urlItem);
            urlCounter++;
        }

        addUrlBtn.onclick = () => addUrlField();

        // Initialize with one empty field
        addUrlField();
        
        // Handle edit functionality
        const handleInput = document.querySelector('input[name="handle"]');
        const editHandleBtn = document.getElementById('editHandleBtn');
        
        if (editHandleBtn && handleInput) {
            function enableEdit() {
                handleInput.readOnly = false;
                handleInput.classList.remove('bg-gray-50', 'dark:bg-gray-600');
                handleInput.classList.add('bg-white', 'dark:bg-gray-700');
                handleInput.focus();
                editHandleBtn.innerHTML = '<i class="fas fa-check text-green-500"></i>';
                editHandleBtn.onclick = saveEdit;
            }
            
            function saveEdit() {
                handleInput.readOnly = true;
                handleInput.classList.remove('bg-white', 'dark:bg-gray-700');
                handleInput.classList.add('bg-gray-50', 'dark:bg-gray-600');
                handleInput.blur();
                editHandleBtn.innerHTML = '<i class="fas fa-edit"></i>';
                editHandleBtn.onclick = enableEdit;
            }
            
            editHandleBtn.onclick = enableEdit;
            
            // Handle input validation
            handleInput.oninput = function() {
                this.value = this.value.replace(/[^a-zA-Z0-9]/g, '');
            };
        }
        
        // Shipping form submission
        document.getElementById('shippingForm').onsubmit = async function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const submitBtn = this.querySelector('button[type="submit"]');
            
            submitBtn.disabled = true;
            submitBtn.textContent = 'Saving...';
            
            try {
                const response = await fetch('{{ route("affiliate.store.shipping-settings") }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: formData
                });
                
                const result = await response.json();
                
                if (result.success) {
                    alert('Shipping settings saved successfully!');
                } else {
                    alert('Error: ' + result.message);
                }
            } catch (error) {
                console.error('Error:', error);
                alert('An error occurred while saving shipping settings.');
            } finally {
                submitBtn.disabled = false;
                submitBtn.textContent = 'Save Shipping Settings';
            }
        };
    </script>
    @endpush
</x-affiliate-layout>