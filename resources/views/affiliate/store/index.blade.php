<x-affiliate-layout>
    <div class="py-6">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <!-- Check if user has a store -->
            @if(!$store)
            <div id="noStoreSection" class="text-center py-12">
                <div class="bg-white rounded-lg shadow-sm p-8 dark:bg-gray-800">
                    <div class="mx-auto w-24 h-24 bg-indigo-100 rounded-full flex items-center justify-center mb-6">
                        <i class="fas fa-store text-3xl text-indigo-600"></i>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Create Your Store</h2>
                    <p class="text-gray-600 dark:text-gray-400 mb-8 max-w-md mx-auto">
                        Set up your own digital marketplace store to showcase and sell your assets to customers worldwide.
                    </p>
                    <button id="createStoreBtn" class="px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors">
                        <i class="fas fa-plus mr-2"></i>Create My Store
                    </button>
                </div>
            </div>
            
            <!-- Create Store Modal -->
            <div id="createStoreModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
                <div class="flex items-center justify-center min-h-screen p-4">
                    <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full dark:bg-gray-800 max-h-[90vh] overflow-hidden flex flex-col">
                        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Create Your Store</h3>
                        </div>
                        
                        <form id="createStoreForm" class="p-6 space-y-6 overflow-y-auto flex-1" style="scrollbar-width: thin;">
                            @csrf
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Store Name</label>
                                <input type="text" name="name" class="w-full px-3 py-2 border border-gray-300 rounded-md dark:border-gray-600 dark:bg-gray-700 text-gray-900 dark:text-white" placeholder="Enter your store name" required>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Store Handle</label>
                                <div class="relative">
                                    <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500 dark:text-gray-400 pointer-events-none">@</span>
                                    <input type="text" name="handle" class="w-full pl-8 pr-10 py-2 border border-gray-300 rounded-md dark:border-gray-600 dark:bg-gray-700 text-gray-900 dark:text-white bg-gray-50 dark:bg-gray-600" placeholder="your-store-handle" pattern="[a-zA-Z0-9]+" title="Only letters and numbers allowed" readonly>
                                    <button type="button" id="editHandleBtn" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </div>
                                <p class="text-xs text-gray-500 mt-1">Only letters and numbers allowed. This will be your store's unique identifier.</p>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Store Description</label>
                                <textarea name="description" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-md dark:border-gray-600 dark:bg-gray-700 text-gray-900 dark:text-white" placeholder="Describe what your store offers..."></textarea>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Store URL Preview</label>
                                <div class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-50 dark:border-gray-600 dark:bg-gray-600 text-gray-500">
                                    <span id="urlPreview">{{ config('app.url') }}/@your-store-handle</span>
                                </div>
                            </div>
                            
                            <div class="flex justify-end space-x-4 pt-4 border-t border-gray-200 dark:border-gray-700 mt-6">
                                <button type="button" id="cancelStoreBtn" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">Cancel</button>
                                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Create Store</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            @else
            <!-- Store Dashboard -->
            <div id="storeSection">
                <!-- Store Header -->
                <div class="bg-white rounded-lg shadow-sm p-4 sm:p-6 mb-6 dark:bg-gray-800">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div class="flex items-center space-x-3 sm:space-x-4 min-w-0 flex-1">
                            <div class="w-12 h-12 sm:w-16 sm:h-16 bg-indigo-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-store text-lg sm:text-2xl text-indigo-600"></i>
                            </div>
                            <div class="min-w-0 flex-1">
                                <h1 class="text-lg sm:text-xl lg:text-2xl font-bold text-gray-900 dark:text-white truncate">{{ $store->name }}</h1>
                                <div class="text-xs sm:text-sm text-gray-600 dark:text-gray-400">
                                    <span class="block sm:inline">Store URL:</span>
                                    <span id="storeUrl" class="block sm:inline break-all text-xs cursor-pointer hover:text-indigo-600 transition-colors" onclick="copyStoreUrl()" title="Click to copy URL">{{ config('app.url') }}/{{ $store->handle }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="flex gap-2 w-full sm:w-auto">
                            <a href="{{ config('app.url') }}/{{ $store->handle }}" target="_blank" class="flex-1 sm:flex-none px-3 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 dark:border-gray-600 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 text-center text-xs sm:text-sm">
                                <i class="fas fa-eye mr-1"></i><span class="hidden xs:inline">Preview </span>Store
                            </a>
                            <a href="{{ route('affiliate.store.settings') }}" class="flex-1 sm:flex-none px-3 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 text-center text-xs sm:text-sm">
                                <i class="fas fa-cog mr-1"></i>Settings
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Store Stats -->
                <div class="grid grid-cols-1 gap-6 mb-6 md:grid-cols-3">
                    <x-widgets.affiliate.store.store-visits />
                    <x-widgets.affiliate.store.total-sales />
                    <x-widgets.affiliate.store.active-products />
                </div>

                <!-- Store Management -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Categories Section -->
                    <div class="lg:col-span-1">
                        <div class="bg-white rounded-lg shadow-sm dark:bg-gray-800 p-6">
                            <div class="flex items-center justify-between mb-6">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Categories</h3>
                                <button id="addCategoryBtn" class="px-3 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 text-sm">
                                    <i class="fas fa-plus mr-1"></i>Add
                                </button>
                            </div>
                            
                            @if($store->categories->count() > 0)
                                <div class="space-y-3">
                                    @foreach($store->categories->take(5) as $category)
                                    <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                        <div class="flex-1">
                                            <h4 class="font-medium text-gray-900 dark:text-white text-sm">{{ $category->name }}</h4>
                                            @if($category->description)
                                            <p class="text-xs text-gray-500 mt-1">{{ Str::limit($category->description, 50) }}</p>
                                            @endif
                                            <p class="text-xs text-gray-400 mt-1">{{ $category->products()->count() }} products</p>
                                        </div>
                                        <button onclick="deleteCategory('{{ $category->id }}', '{{ $category->name }}')" class="text-red-500 hover:text-red-700 ml-2">
                                            <i class="fas fa-trash text-xs"></i>
                                        </button>
                                    </div>
                                    @endforeach
                                </div>
                                
                                @if($store->categories->count() > 5)
                                <div class="mt-4">
                                    <a href="{{ route('affiliate.store.categories.index') }}" class="w-full px-3 py-2 text-indigo-600 hover:text-indigo-800 text-sm font-medium border border-indigo-300 rounded-md hover:bg-indigo-50 dark:hover:bg-indigo-900 transition-colors block text-center">
                                        View All Categories
                                    </a>
                                </div>
                                @endif
                            @else
                                <div class="text-center py-8">
                                    <div class="w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-4">
                                        <i class="fas fa-tags text-2xl text-gray-400"></i>
                                    </div>
                                    <p class="text-gray-500 text-sm mb-4">No categories yet</p>
                                    <button onclick="document.getElementById('addCategoryBtn').click()" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium">
                                        Create your first category
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Products Section -->
                    <div class="lg:col-span-2">
                        <div class="bg-white rounded-lg shadow-sm dark:bg-gray-800 p-6">
                            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Products</h3>
                                <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto">
                                    <div class="relative flex-1 sm:flex-none">
                                        <input type="text" id="productSearch" placeholder="Search products..." class="w-full sm:w-64 px-4 py-2 pl-10 border border-gray-300 rounded-md dark:border-gray-600 dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                        <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                    </div>
                                    <a href="{{ route('affiliate.store.products.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 text-center">
                                        <i class="fas fa-plus mr-2"></i>Add Product
                                    </a>
                                </div>
                            </div>
                            
                            @if($store->products->count() > 0)
                                <div class="grid grid-cols-1 gap-4" id="productsGrid">
                                    @foreach($store->products as $product)
                                    <div class="product-card bg-gray-50 dark:bg-gray-700 rounded-lg p-4 hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors">
                                        <div class="flex items-center">
                                            <div class="w-16 h-16 bg-gray-200 dark:bg-gray-600 rounded-lg overflow-hidden flex-shrink-0">
                                                @if($product->images && count($product->images) > 0)
                                                    <img src="{{ $product->images[0] }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                                                @else
                                                    <div class="w-full h-full flex items-center justify-center">
                                                        <i class="fas fa-image text-xl text-gray-400"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="ml-4 flex-1 min-w-0">
                                                <div class="flex items-center justify-between mb-1">
                                                    <h4 class="font-medium text-gray-900 dark:text-white text-sm truncate">{{ $product->name }}</h4>
                                                    <span class="px-2 py-1 text-xs rounded-full ml-2 {{ $product->type === 'digital' ? 'bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200' : 'bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200' }}">{{ $product->type }}</span>
                                                </div>
                                                <p class="text-sm text-gray-600 dark:text-gray-400 mb-1 line-clamp-1">{{ $product->description ?: 'No description' }}</p>
                                                @if($product->category)
                                                <p class="text-xs text-gray-500 mb-1"><i class="fas fa-tag mr-1"></i>{{ $product->category }}</p>
                                                @endif
                                                <div class="flex items-center justify-between">
                                                    <div>
                                                        <span class="font-bold text-gray-900 dark:text-white">${{ number_format($product->price, 2) }}</span>
                                                        @if($product->list_price)
                                                        <span class="text-xs text-gray-400 line-through ml-2">${{ number_format($product->list_price, 2) }}</span>
                                                        @endif
                                                        @if($product->type === 'physical' && $product->stock_quantity !== null)
                                                        <span class="text-xs text-gray-500 ml-2">{{ $product->stock_quantity }} in stock</span>
                                                        @endif
                                                    </div>
                                                    <div class="flex space-x-2">
                                                        <a href="{{ route('affiliate.store.products.edit', $product->id) }}" class="text-indigo-600 hover:text-indigo-800 text-sm">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <button onclick="showDeleteModal('{{ $product->id }}', '{{ $product->name }}')" class="text-red-600 hover:text-red-800 text-sm">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-12">
                                    <div class="w-24 h-24 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-4">
                                        <i class="fas fa-box-open text-3xl text-gray-400"></i>
                                    </div>
                                    <h4 class="text-lg font-medium text-gray-900 dark:text-white mb-2">No products yet</h4>
                                    <p class="text-gray-600 dark:text-gray-400 mb-6">Start by adding your first product to your store.</p>
                                    <a href="{{ route('affiliate.store.products.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                                        <i class="fas fa-plus mr-2"></i>Add Your First Product
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Delete Product Modal -->
            <div id="deleteProductModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
                <div class="flex items-center justify-center min-h-screen p-4">
                    <div class="bg-white rounded-lg shadow-xl max-w-md w-full dark:bg-gray-800">
                        <div class="p-6">
                            <div class="flex items-center mb-4">
                                <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center mr-4">
                                    <i class="fas fa-trash text-red-600 text-xl"></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Delete Product</h3>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">This action cannot be undone</p>
                                </div>
                            </div>
                            
                            <p class="text-gray-700 dark:text-gray-300 mb-6">Are you sure you want to delete "<span id="deleteProductName" class="font-medium"></span>"? This will permanently remove the product from your store.</p>
                            
                            <div class="flex justify-end space-x-4">
                                <button type="button" id="cancelDeleteBtn" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">Cancel</button>
                                <button type="button" id="confirmDeleteBtn" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">Delete Product</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Delete Category Modal -->
            <div id="deleteCategoryModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
                <div class="flex items-center justify-center min-h-screen p-4">
                    <div class="bg-white rounded-lg shadow-xl max-w-md w-full dark:bg-gray-800">
                        <div class="p-6">
                            <div class="flex items-center mb-4">
                                <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center mr-4">
                                    <i class="fas fa-trash text-red-600 text-xl"></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Delete Category</h3>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">This action cannot be undone</p>
                                </div>
                            </div>
                            
                            <p class="text-gray-700 dark:text-gray-300 mb-6">Are you sure you want to delete "<span id="deleteCategoryName" class="font-medium"></span>"? This will permanently remove the category from your store.</p>
                            
                            <div class="flex justify-end space-x-4">
                                <button type="button" id="cancelCategoryDeleteBtn" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">Cancel</button>
                                <button type="button" id="confirmCategoryDeleteBtn" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">Delete Category</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Add Category Modal -->
            <div id="addCategoryModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
                <div class="flex items-center justify-center min-h-screen p-4">
                    <div class="bg-white rounded-lg shadow-xl max-w-md w-full dark:bg-gray-800">
                        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Add New Category</h3>
                        </div>
                        
                        <form id="categoryForm" method="POST" action="{{ route('affiliate.store.categories.store') }}" class="p-6 space-y-4">
                            @csrf
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Category Name</label>
                                <input type="text" name="name" class="w-full px-3 py-2 border border-gray-300 rounded-md dark:border-gray-600 dark:bg-gray-700 text-gray-900 dark:text-white" required>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Description</label>
                                <textarea name="description" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md dark:border-gray-600 dark:bg-gray-700 text-gray-900 dark:text-white"></textarea>
                            </div>
                            
                            <div class="flex justify-end space-x-4">
                                <button type="button" id="cancelCategoryBtn" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">Cancel</button>
                                <button type="submit" id="categorySubmitBtn" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Add Category</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Add Product Modal -->
            <div id="addProductModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
                <div class="flex items-center justify-center min-h-screen p-4">
                    <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full dark:bg-gray-800 max-h-[90vh] overflow-y-auto">
                        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Add New Product</h3>
                        </div>
                        
                        <form id="addProductForm" class="p-6 space-y-6" enctype="multipart/form-data">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Product Name</label>
                                    <input type="text" name="name" class="w-full px-3 py-2 border border-gray-300 rounded-md dark:border-gray-600 dark:bg-gray-700 text-gray-900 dark:text-white" required>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Price ($)</label>
                                    <input type="number" name="price" step="0.01" min="0" class="w-full px-3 py-2 border border-gray-300 rounded-md dark:border-gray-600 dark:bg-gray-700 text-gray-900 dark:text-white" required>
                                </div>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Description</label>
                                <textarea name="description" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-md dark:border-gray-600 dark:bg-gray-700 text-gray-900 dark:text-white"></textarea>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Product Type</label>
                                <select name="type" class="w-full px-3 py-2 border border-gray-300 rounded-md dark:border-gray-600 dark:bg-gray-700 text-gray-900 dark:text-white" required>
                                    <option value="digital">Digital Product</option>
                                    <option value="physical">Physical Product</option>
                                </select>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Tags</label>
                                <input type="text" name="tags" placeholder="Enter tags separated by commas (e.g., web, template, modern)" class="w-full px-3 py-2 border border-gray-300 rounded-md dark:border-gray-600 dark:bg-gray-700 text-gray-900 dark:text-white">
                                <p class="text-xs text-gray-500 mt-1">Separate multiple tags with commas</p>
                            </div>
                            
                            <div id="stockField" class="hidden">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Stock Quantity</label>
                                <input type="number" name="stock_quantity" min="0" class="w-full px-3 py-2 border border-gray-300 rounded-md dark:border-gray-600 dark:bg-gray-700 text-gray-900 dark:text-white">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Product Status</label>
                                <div class="flex items-center">
                                    <input type="checkbox" name="is_active" id="is_active" checked class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                    <label for="is_active" class="ml-2 block text-sm text-gray-900 dark:text-white">Active (visible to customers)</label>
                                </div>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Product Images (up to 10)</label>
                                <input type="file" name="images[]" id="productImages" multiple accept="image/*" max="10" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                                <div id="imagePreview" class="mt-3 grid grid-cols-2 md:grid-cols-3 gap-3"></div>
                            </div>
                            
                            <div id="digitalFileField">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Digital File (for digital products)</label>
                                <input type="file" name="digital_file" id="digitalFile" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                                <div id="digitalFilePreview" class="mt-3"></div>
                            </div>
                            
                            <div class="flex justify-end space-x-4">
                                <button type="button" id="cancelProductBtn" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">Cancel</button>
                                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Add Product</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>



    @push('styles')
<style>
    /* Thin scrollbar for modal */
    #createStoreModal form::-webkit-scrollbar {
        width: 3px;
    }
    
    #createStoreModal form::-webkit-scrollbar-track {
        background: transparent;
    }
    
    #createStoreModal form::-webkit-scrollbar-thumb {
        background-color: rgba(107, 114, 128, 0.6);
        border-radius: 2px;
    }
    
    .dark #createStoreModal form::-webkit-scrollbar-thumb {
        background-color: rgba(55, 65, 81, 0.8);
    }
    
    #createStoreModal form::-webkit-scrollbar-thumb:hover {
        background-color: rgba(107, 114, 128, 0.9);
    }
</style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Store creation modal
            const createStoreBtn = document.getElementById('createStoreBtn');
            const createStoreModal = document.getElementById('createStoreModal');
            const cancelStoreBtn = document.getElementById('cancelStoreBtn');
            const nameInput = document.querySelector('#createStoreModal input[name="name"]');
            const handleInput = document.querySelector('#createStoreModal input[name="handle"]');
            const editHandleBtn = document.getElementById('editHandleBtn');
            const urlPreview = document.getElementById('urlPreview');

            if (createStoreBtn) {
                createStoreBtn.onclick = () => createStoreModal?.classList.remove('hidden');
            }

            if (cancelStoreBtn) {
                cancelStoreBtn.onclick = () => createStoreModal?.classList.add('hidden');
            }

            if (createStoreModal) {
                createStoreModal.onclick = (e) => {
                    if (e.target === createStoreModal) createStoreModal.classList.add('hidden');
                };
            }

            let isHandleManuallyEdited = false;

            // Auto-generate handle from name
            if (nameInput && handleInput) {
                nameInput.oninput = function() {
                    if (!isHandleManuallyEdited) {
                        const handle = this.value.toLowerCase().replace(/[^a-z0-9]/g, '').substring(0, 20);
                        handleInput.value = handle;
                        updateUrlPreview(handle);
                    }
                };
            }

            // Edit handle functionality
            if (editHandleBtn && handleInput) {
                editHandleBtn.onclick = function() {
                    if (handleInput.hasAttribute('readonly')) {
                        handleInput.removeAttribute('readonly');
                        handleInput.classList.remove('bg-gray-50', 'dark:bg-gray-600');
                        handleInput.focus();
                        this.innerHTML = '<i class="fas fa-check"></i>';
                        isHandleManuallyEdited = true;
                    } else {
                        handleInput.setAttribute('readonly', true);
                        handleInput.classList.add('bg-gray-50', 'dark:bg-gray-600');
                        this.innerHTML = '<i class="fas fa-edit"></i>';
                        updateUrlPreview(handleInput.value);
                    }
                };
            }

            // Handle input changes for URL preview
            if (handleInput) {
                handleInput.oninput = function() {
                    updateUrlPreview(this.value);
                };
            }

            function updateUrlPreview(handle) {
                if (urlPreview) {
                    const cleanHandle = handle.replace(/[^a-zA-Z0-9]/g, '');
                    urlPreview.textContent = cleanHandle ? `{{ config('app.url') }}/@${cleanHandle}` : '{{ config('app.url') }}/@your-store-handle';
                }
            }

            // Category modal
            const addCategoryBtn = document.getElementById('addCategoryBtn');
            const addCategoryModal = document.getElementById('addCategoryModal');
            const cancelCategoryBtn = document.getElementById('cancelCategoryBtn');

            if (addCategoryBtn) {
                addCategoryBtn.onclick = () => addCategoryModal?.classList.remove('hidden');
            }

            if (cancelCategoryBtn) {
                cancelCategoryBtn.onclick = () => addCategoryModal?.classList.add('hidden');
            }

            if (addCategoryModal) {
                addCategoryModal.onclick = (e) => {
                    if (e.target === addCategoryModal) addCategoryModal.classList.add('hidden');
                };
            }

            // Handle category form submission
            const categoryForm = document.getElementById('categoryForm');
            if (categoryForm) {
                categoryForm.onsubmit = function(e) {
                    const submitBtn = document.getElementById('categorySubmitBtn');
                    const originalText = submitBtn.innerHTML;
                    
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Creating...';
                    
                    // Let form submit normally, but restore button on page reload
                };
            }

            // Product search
            const productSearch = document.getElementById('productSearch');
            if (productSearch) {
                productSearch.oninput = function() {
                    const searchTerm = this.value.toLowerCase().trim();
                    const productCards = document.querySelectorAll('.product-card');
                    
                    productCards.forEach(card => {
                        const productName = card.querySelector('h4').textContent.toLowerCase();
                        const productDesc = card.querySelector('p').textContent.toLowerCase();
                        
                        if (searchTerm === '' || productName.includes(searchTerm) || productDesc.includes(searchTerm)) {
                            card.style.display = 'block';
                        } else {
                            card.style.display = 'none';
                        }
                    });
                };
            }

            // Delete product modal
            const deleteModal = document.getElementById('deleteProductModal');
            const cancelDeleteBtn = document.getElementById('cancelDeleteBtn');
            
            if (cancelDeleteBtn) {
                cancelDeleteBtn.onclick = () => deleteModal?.classList.add('hidden');
            }
            
            if (deleteModal) {
                deleteModal.onclick = (e) => {
                    if (e.target === deleteModal) deleteModal.classList.add('hidden');
                };
            }

            // Delete category modal
            const deleteCategoryModal = document.getElementById('deleteCategoryModal');
            const cancelCategoryDeleteBtn = document.getElementById('cancelCategoryDeleteBtn');
            
            if (cancelCategoryDeleteBtn) {
                cancelCategoryDeleteBtn.onclick = () => deleteCategoryModal?.classList.add('hidden');
            }
            
            if (deleteCategoryModal) {
                deleteCategoryModal.onclick = (e) => {
                    if (e.target === deleteCategoryModal) deleteCategoryModal.classList.add('hidden');
                };
            }

            // Copy store URL
            window.copyStoreUrl = function() {
                const storeUrl = document.getElementById('storeUrl');
                const url = storeUrl.textContent.trim();
                
                navigator.clipboard.writeText(url).then(() => {
                    const originalText = storeUrl.textContent;
                    storeUrl.textContent = 'Copied!';
                    storeUrl.classList.add('text-green-600');
                    
                    setTimeout(() => {
                        storeUrl.textContent = originalText;
                        storeUrl.classList.remove('text-green-600');
                    }, 1500);
                });
            };

            // Show delete modal
            window.showDeleteModal = function(productId, productName) {
                const modal = document.getElementById('deleteProductModal');
                const productNameSpan = document.getElementById('deleteProductName');
                const confirmBtn = document.getElementById('confirmDeleteBtn');
                
                productNameSpan.textContent = productName;
                modal.classList.remove('hidden');
                
                confirmBtn.onclick = function() {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = `/store/products/${productId}`;
                    form.innerHTML = `
                        @csrf
                        @method('DELETE')
                    `;
                    document.body.appendChild(form);
                    form.submit();
                };
            };

            // Delete category function
            window.deleteCategory = function(categoryId, categoryName) {
                const modal = document.getElementById('deleteCategoryModal');
                const categoryNameSpan = document.getElementById('deleteCategoryName');
                const confirmBtn = document.getElementById('confirmCategoryDeleteBtn');
                
                categoryNameSpan.textContent = categoryName;
                modal.classList.remove('hidden');
                
                confirmBtn.onclick = function() {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = `{{ route('affiliate.store.categories.index') }}/${categoryId}`;
                    form.innerHTML = `
                        @csrf
                        @method('DELETE')
                    `;
                    document.body.appendChild(form);
                    form.submit();
                };
            };

            // Handle store creation form submission
            const createStoreForm = document.getElementById('createStoreForm');
            if (createStoreForm) {
                createStoreForm.onsubmit = function(e) {
                    e.preventDefault();
                    
                    const formData = new FormData(this);
                    const submitBtn = this.querySelector('button[type="submit"]');
                    const originalText = submitBtn.textContent;
                    
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Creating...';
                    
                    fetch('{{ route('affiliate.store.create') }}', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            window.location.reload();
                        } else {
                            alert(data.message || 'Failed to create store');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred while creating the store');
                    })
                    .finally(() => {
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = originalText;
                    });
                };
            }
        });
    </script>
    @endpush
</x-affiliate-layout>