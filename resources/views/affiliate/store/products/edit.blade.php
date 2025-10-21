<x-affiliate-layout>
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-4">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-4 flex items-center justify-between">
                <div>
                    <h1 class="text-xl font-bold text-gray-900 dark:text-white">Edit Product</h1>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Update product information</p>
                </div>
                <a href="{{ route('affiliate.store.index') }}" 
                   class="inline-flex items-center px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Back to Store
                </a>
            </div>

            <form id="editProductForm" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                    <!-- Left Column -->
                    <div class="lg:col-span-2 space-y-3">
                        <!-- Basic Information -->
                        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
                            <div class="px-3 py-2 border-b border-gray-200 dark:border-gray-700">
                                <h3 class="text-sm font-semibold text-gray-900 dark:text-white">Basic Information</h3>
                            </div>
                            <div class="p-3 space-y-3">
                                <div>
                                    <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Product Name *</label>
                                    <input type="text" name="name" value="{{ $product->name }}" required
                                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-colors">
                                </div>
                                
                                <div class="grid grid-cols-2 gap-3">
                                    <div>
                                        <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Price ($) *</label>
                                        <input type="number" name="price" value="{{ $product->price }}" step="0.01" min="0" required
                                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-colors">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">List Price ($)</label>
                                        <input type="number" name="list_price" value="{{ $product->list_price }}" step="0.01" min="0" placeholder="Original price"
                                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-colors">
                                    </div>
                                </div>
                                
                                <div>
                                    <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Description</label>
                                    <textarea name="description" rows="2" placeholder="Describe your product..."
                                              class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-colors resize-none">{{ $product->description }}</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Product Details -->
                        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
                            <div class="px-3 py-2 border-b border-gray-200 dark:border-gray-700">
                                <h3 class="text-sm font-semibold text-gray-900 dark:text-white">Product Details</h3>
                            </div>
                            <div class="p-3 space-y-3">
                                <div class="grid grid-cols-2 gap-3">
                                    <div>
                                        <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Product Type *</label>
                                        <select name="type" required
                                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-colors">
                                            <option value="digital" {{ $product->type === 'digital' ? 'selected' : '' }}>Digital Product</option>
                                            <option value="physical" {{ $product->type === 'physical' ? 'selected' : '' }}>Physical Product</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Category</label>
                                        <select name="category"
                                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-colors">
                                            <option value="">Select Category</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div>
                                    <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Tags</label>
                                    <input type="text" name="tags" value="{{ $product->tags ? '#' . implode(' #', $product->tags) : '' }}" placeholder="#gaming #electronics #wireless"
                                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-colors">
                                </div>
                                
                                <div id="stockField" class="{{ $product->type === 'physical' ? '' : 'hidden' }}">
                                    <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Stock Quantity</label>
                                    <input type="number" name="stock_quantity" value="{{ $product->stock_quantity }}" min="0"
                                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-colors">
                                </div>
                                
                                <div class="flex items-center justify-between">
                                    <label class="text-xs font-medium text-gray-700 dark:text-gray-300">Status</label>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" name="is_active" {{ $product->is_active ? 'checked' : '' }} class="sr-only peer">
                                        <div class="w-9 h-5 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                                        <span class="ml-2 text-xs text-gray-900 dark:text-white">Active</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Specifications -->
                        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
                            <div class="px-3 py-2 border-b border-gray-200 dark:border-gray-700">
                                <h3 class="text-sm font-semibold text-gray-900 dark:text-white">Specifications</h3>
                            </div>
                            <div class="p-3">
                                <div id="specificationsContainer" class="space-y-2">
                                    @if($product->specifications && count($product->specifications) > 0)
                                        @foreach($product->specifications as $key => $value)
                                        <div class="specification-row grid grid-cols-2 gap-2">
                                            <input type="text" name="spec_keys[]" value="{{ $key }}" placeholder="e.g., Brand"
                                                   class="px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-colors">
                                            <div class="flex gap-2">
                                                <input type="text" name="spec_values[]" value="{{ $value }}" placeholder="e.g., Apple"
                                                       class="flex-1 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-colors">
                                                <button type="button" onclick="removeSpecification(this)"
                                                        class="px-2 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 transition-colors">
                                                    <i class="fas fa-times text-xs"></i>
                                                </button>
                                            </div>
                                        </div>
                                        @endforeach
                                    @else
                                        <div class="specification-row grid grid-cols-2 gap-2">
                                            <input type="text" name="spec_keys[]" placeholder="e.g., Brand"
                                                   class="px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-colors">
                                            <div class="flex gap-2">
                                                <input type="text" name="spec_values[]" placeholder="e.g., Apple"
                                                       class="flex-1 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-colors">
                                                <button type="button" onclick="removeSpecification(this)"
                                                        class="px-2 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 transition-colors">
                                                    <i class="fas fa-times text-xs"></i>
                                                </button>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <button type="button" onclick="addSpecification()"
                                        class="mt-2 inline-flex items-center px-2 py-1 border border-gray-300 dark:border-gray-600 rounded-md text-xs font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors">
                                    <i class="fas fa-plus mr-1"></i>
                                    Add Specification
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="space-y-3">
                        <!-- Media Upload -->
                        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
                            <div class="px-3 py-2 border-b border-gray-200 dark:border-gray-700">
                                <h3 class="text-sm font-semibold text-gray-900 dark:text-white">Media</h3>
                            </div>
                            <div class="p-3 space-y-3">
                                @if($product->images && count($product->images) > 0)
                                <div>
                                    <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-2">Current Images</label>
                                    <div class="grid grid-cols-2 gap-2 mb-3">
                                        @foreach($product->images as $image)
                                        <div class="relative group">
                                            <img src="{{ $image }}" class="w-full h-16 object-cover rounded border border-gray-200 dark:border-gray-600">
                                            <div class="absolute inset-0 bg-black bg-opacity-50 rounded opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                                <span class="text-white text-xs">Current</span>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                @endif
                                
                                <div>
                                    <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-2">Update Images</label>
                                    <div class="border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg p-3 text-center hover:border-blue-400 transition-colors">
                                        <input type="file" name="images[]" id="productImages" multiple accept="image/*" class="hidden">
                                        <label for="productImages" class="cursor-pointer">
                                            <i class="fas fa-cloud-upload-alt text-2xl text-gray-400 mb-1"></i>
                                            <p class="text-xs text-gray-600 dark:text-gray-400">Click to upload new images</p>
                                            <p class="text-xs text-gray-500 mt-1">Leave empty to keep current</p>
                                        </label>
                                    </div>
                                    <div id="imagePreview" class="mt-2 grid grid-cols-2 gap-2"></div>
                                </div>
                                
                                <div id="digitalFileField" class="{{ $product->type === 'digital' ? '' : 'hidden' }}">
                                    <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-2">Update Digital File</label>
                                    @if($product->file_path)
                                    <div class="mb-2 p-2 bg-blue-50 dark:bg-blue-900/20 rounded border border-blue-200 dark:border-blue-800">
                                        <div class="flex items-center">
                                            <i class="fas fa-file text-blue-500 mr-2"></i>
                                            <div>
                                                <p class="text-xs font-medium text-blue-900 dark:text-blue-100">{{ basename($product->file_path) }}</p>
                                                <p class="text-xs text-blue-600 dark:text-blue-300">Upload new to replace</p>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                    <div class="border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg p-3 text-center hover:border-blue-400 transition-colors">
                                        <input type="file" name="digital_file" id="digitalFile" class="hidden">
                                        <label for="digitalFile" class="cursor-pointer">
                                            <i class="fas fa-file-upload text-2xl text-gray-400 mb-1"></i>
                                            <p class="text-xs text-gray-600 dark:text-gray-400">Click to upload new file</p>
                                            <p class="text-xs text-gray-500 mt-1">Leave empty to keep current</p>
                                        </label>
                                    </div>
                                    <div id="digitalFilePreview" class="mt-2"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-3">
                            <div class="space-y-2">
                                <a href="{{ route('affiliate.store.index') }}"
                                   class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors font-medium text-center text-sm block">
                                    Cancel
                                </a>
                                <button type="submit"
                                        class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium text-sm">
                                    <i class="fas fa-save mr-2"></i>
                                    Update Product
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const typeSelect = document.querySelector('select[name="type"]');
            const stockField = document.getElementById('stockField');
            const digitalFileField = document.getElementById('digitalFileField');
            const categorySelect = document.querySelector('select[name="category"]');
            const productImages = document.getElementById('productImages');
            const imagePreview = document.getElementById('imagePreview');
            const digitalFile = document.getElementById('digitalFile');
            const digitalFilePreview = document.getElementById('digitalFilePreview');
            const form = document.getElementById('editProductForm');

            loadCategories();

            typeSelect.onchange = function() {
                if (this.value === 'physical') {
                    stockField.classList.remove('hidden');
                    digitalFileField.classList.add('hidden');
                } else {
                    stockField.classList.add('hidden');
                    digitalFileField.classList.remove('hidden');
                }
            };

            productImages.onchange = function(e) {
                const files = Array.from(e.target.files);
                imagePreview.innerHTML = '';
                
                files.forEach((file, index) => {
                    if (file.type.startsWith('image/')) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            const div = document.createElement('div');
                            div.className = 'relative group';
                            div.innerHTML = `
                                <img src="${e.target.result}" class="w-full h-16 object-cover rounded border">
                                <button type="button" onclick="removeImage(${index})" class="absolute -top-1 -right-1 bg-red-500 text-white rounded-full w-4 h-4 flex items-center justify-center text-xs hover:bg-red-600">×</button>
                            `;
                            imagePreview.appendChild(div);
                        };
                        reader.readAsDataURL(file);
                    }
                });
            };

            digitalFile.onchange = function(e) {
                const file = e.target.files[0];
                digitalFilePreview.innerHTML = '';
                
                if (file) {
                    const div = document.createElement('div');
                    div.className = 'flex items-center p-2 bg-gray-50 dark:bg-gray-700 rounded border';
                    div.innerHTML = `
                        <i class="fas fa-file text-blue-500 mr-2"></i>
                        <div class="flex-1">
                            <p class="text-xs font-medium text-gray-900 dark:text-white">${file.name}</p>
                            <p class="text-xs text-gray-500">${(file.size / 1024 / 1024).toFixed(2)} MB</p>
                        </div>
                    `;
                    digitalFilePreview.appendChild(div);
                }
            };

            form.onsubmit = async function(e) {
                e.preventDefault();
                
                const formData = new FormData(this);
                const submitBtn = this.querySelector('button[type="submit"]');
                
                formData.set('is_active', document.querySelector('input[name="is_active"]').checked ? '1' : '0');
                
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Updating...';
                
                try {
                    const response = await fetch('{{ route("affiliate.store.products.update", $product->id) }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: formData
                    });
                    
                    const result = await response.json();
                    
                    if (result.success) {
                        window.location.href = '{{ route("affiliate.store.index") }}';
                    } else {
                        alert('Error: ' + result.message);
                    }
                } catch (error) {
                    console.error('Error:', error);
                    alert('An error occurred while updating the product.');
                } finally {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = '<i class="fas fa-save mr-2"></i>Update Product';
                }
            };

            window.removeImage = function(index) {
                const input = document.getElementById('productImages');
                const dt = new DataTransfer();
                const files = Array.from(input.files);
                
                files.forEach((file, i) => {
                    if (i !== index) dt.items.add(file);
                });
                
                input.files = dt.files;
                input.dispatchEvent(new Event('change'));
            };

            window.addSpecification = function() {
                const container = document.getElementById('specificationsContainer');
                const div = document.createElement('div');
                div.className = 'specification-row grid grid-cols-2 gap-2';
                div.innerHTML = `
                    <input type="text" name="spec_keys[]" placeholder="e.g., Color"
                           class="px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-colors">
                    <div class="flex gap-2">
                        <input type="text" name="spec_values[]" placeholder="e.g., Black"
                               class="flex-1 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white transition-colors">
                        <button type="button" onclick="removeSpecification(this)"
                                class="px-2 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 transition-colors">
                            <i class="fas fa-times text-xs"></i>
                        </button>
                    </div>
                `;
                container.appendChild(div);
            };

            window.removeSpecification = function(button) {
                const container = document.getElementById('specificationsContainer');
                if (container.children.length > 1) {
                    button.closest('.specification-row').remove();
                }
            };
            
            async function loadCategories() {
                try {
                    const response = await fetch('{{ route("affiliate.store.categories.api") }}', {
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json'
                        }
                    });
                    
                    const result = await response.json();
                    
                    if (result.success && categorySelect) {
                        if (result.categories.length === 0) {
                            categorySelect.innerHTML = '<option value="">No categories created yet</option>';
                            categorySelect.disabled = true;
                        } else {
                            categorySelect.innerHTML = '<option value="">Select Category</option>' + 
                                result.categories.map(category => 
                                    `<option value="${category.name}" ${
                                        category.name === '{{ $product->category }}' ? 'selected' : ''
                                    }>${category.name}</option>`
                                ).join('');
                            categorySelect.disabled = false;
                        }
                    }
                } catch (error) {
                    console.error('Error loading categories:', error);
                }
            }
        });
    </script>
    @endpush
</x-affiliate-layout>