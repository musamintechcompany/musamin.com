<x-store-layout>
<div class="min-h-screen bg-gray-50 dark:bg-gray-900">
    <!-- Store Banner -->
    @if($store->banner)
        <div class="h-14 sm:h-32 bg-cover bg-center" style="background-image: url('{{ $store->banner }}')"></div>
    @else
        <div class="h-14 sm:h-32 bg-gradient-to-r from-blue-500 to-purple-600"></div>
    @endif

    <!-- Store Header -->
    <div class="bg-white dark:bg-gray-800 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 sm:py-8">
            <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between space-y-4 sm:space-y-0">
                <div class="flex items-start space-x-4 flex-1">
                    @if($store->logo)
                        <img src="{{ $store->logo }}" alt="{{ $store->name }}" class="w-16 h-16 sm:w-20 sm:h-20 rounded-full object-cover flex-shrink-0">
                    @else
                        <div class="w-16 h-16 sm:w-20 sm:h-20 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center flex-shrink-0">
                            <span class="text-xl sm:text-2xl font-bold text-white">{{ substr($store->name, 0, 1) }}</span>
                        </div>
                    @endif
                    
                    <div class="flex-1 min-w-0">
                        <h1 class="text-xl sm:text-3xl font-bold text-gray-900 dark:text-white">{{ $store->name }}</h1>
                        @if($store->description)
                            <div class="mt-1">
                                <div class="flex items-baseline flex-nowrap text-gray-600 dark:text-gray-400 text-sm sm:text-base">
                                    <span class="sm:hidden truncate">{{ Str::limit($store->description, 25, '') }}</span>
                                    <span class="hidden sm:inline truncate">{{ Str::limit($store->description, 80, '') }}</span>
                                    @if(strlen($store->description) > 25)
                                        <button onclick="showStoreDetails()" class="text-blue-600 dark:text-blue-400 text-sm hover:underline whitespace-nowrap flex-shrink-0 ml-1">...more</button>
                                    @endif
                                </div>
                            </div>
                        @endif
                        
                        <!-- Store Links -->
                        @if($store->social_links && count($store->social_links) > 0)
                        <div class="mt-2">
                            <div class="flex items-baseline flex-nowrap text-blue-600 dark:text-blue-400 text-sm">
                                @php $firstLink = array_values($store->social_links)[0]; @endphp
                                <span class="sm:hidden truncate">{{ Str::limit($firstLink, 15, '') }}</span>
                                <span class="hidden sm:inline">{{ $firstLink }}</span>
                                @if(count($store->social_links) > 1)
                                <button onclick="showStoreDetails()" class="text-blue-600 dark:text-blue-400 text-sm hover:underline whitespace-nowrap flex-shrink-0 ml-1">...see more</button>
                                @endif
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                
                <!-- Desktop Action Buttons -->
                <div class="hidden sm:block flex-shrink-0 ml-6 space-y-2">
                    <button id="followBtn" onclick="toggleFollow()" class="follow-btn bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium transition-colors text-base w-full" data-user-id="{{ $store->user->id }}">
                        <span class="follow-text">Follow</span>
                    </button>
                    @auth
                        @if(auth()->id() !== $store->user->id)
                            <button onclick="openChat('{{ $store->user->id }}', '{{ $store->user->name }}', '{{ $store->user->avatar ?? '' }}', 'store', '{{ $store->name }}')" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg font-medium transition-colors text-base w-full">
                                <i class="fas fa-comment mr-2"></i>Contact Seller
                            </button>
                        @endif
                    @endauth
                </div>
                
                <!-- Mobile Action Buttons -->
                <div class="sm:hidden space-y-2">
                    <button id="followBtnMobile" onclick="toggleFollow()" class="follow-btn bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors text-sm w-full" data-user-id="{{ $store->user->id }}">
                        <span class="follow-text">Follow</span>
                    </button>
                    @auth
                        @if(auth()->id() !== $store->user->id)
                            <button onclick="openChat('{{ $store->user->id }}', '{{ $store->user->name }}', '{{ $store->user->avatar ?? '' }}', 'store', '{{ $store->name }}')" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-medium transition-colors text-sm w-full">
                                <i class="fas fa-comment mr-2"></i>Contact Seller
                            </button>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
    </div>

    <!-- Store Details Modal -->
    <div id="storeDetailsModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 overflow-hidden">
        <div class="flex items-center justify-center min-h-screen p-2 sm:p-4">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-4xl w-full max-h-[90vh] sm:max-h-[85vh] overflow-hidden flex flex-col">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700 flex-shrink-0">
                    <div class="flex items-center justify-between">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">About This Store</h3>
                        <button onclick="closeStoreDetails()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                            <i class="fas fa-times text-xl"></i>
                        </button>
                    </div>
                </div>
                
                <div class="p-6 space-y-6 overflow-y-auto flex-1">
                    <div class="flex items-center space-x-4">
                        @if($store->logo)
                            <img src="{{ $store->logo }}" alt="{{ $store->name }}" class="w-20 h-20 rounded-full object-cover">
                        @else
                            <div class="w-20 h-20 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center">
                                <span class="text-2xl font-bold text-white">{{ substr($store->name, 0, 1) }}</span>
                            </div>
                        @endif
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $store->name }}</h2>
                            <p class="text-gray-600 dark:text-gray-400">{{ number_format($store->visits_count) }} visits</p>
                        </div>
                    </div>
                    
                    @if($store->description)
                        <div>
                            <h4 class="font-semibold text-gray-900 dark:text-white mb-3 text-lg">Description</h4>
                            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-3 sm:p-4">
                                <p class="text-gray-700 dark:text-gray-300 leading-relaxed whitespace-pre-wrap break-words text-sm sm:text-base">{{ $store->description }}</p>
                            </div>
                        </div>
                    @endif
                    
                    <!-- Store Links -->
                    @if($store->social_links && count($store->social_links) > 0)
                    <div>
                        <h4 class="font-semibold text-gray-900 dark:text-white mb-3 text-lg">Store Links</h4>
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-3 sm:p-4 space-y-3">
                            @foreach($store->social_links as $label => $url)
                            <a href="{{ $url }}" target="_blank" class="flex items-center text-blue-600 dark:text-blue-400 hover:underline group">
                                <i class="fas fa-link mr-2 sm:mr-3 text-base sm:text-lg flex-shrink-0"></i>
                                <div class="flex flex-col">
                                    <span class="text-xs text-gray-500 dark:text-gray-400">{{ $label }}</span>
                                    <span class="break-words group-hover:text-blue-700 dark:group-hover:text-blue-300 text-sm sm:text-base">{{ $url }}</span>
                                </div>
                            </a>
                            @endforeach
                        </div>
                    </div>
                    @endif
                    
                    <!-- Store Info -->
                    <div>
                        <h4 class="font-semibold text-gray-900 dark:text-white mb-3 text-lg">Store Information</h4>
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-3 sm:p-4">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
                                @if($store->category)
                                    <div>
                                        <h5 class="font-medium text-gray-900 dark:text-white mb-1">Category</h5>
                                        <p class="text-gray-600 dark:text-gray-400">{{ $store->category }}</p>
                                    </div>
                                @endif
                                
                                <div>
                                    <h5 class="font-medium text-gray-900 dark:text-white mb-1">Products</h5>
                                    <p class="text-gray-600 dark:text-gray-400">{{ $store->products->count() }} items</p>
                                </div>
                                
                                <div>
                                    <h5 class="font-medium text-gray-900 dark:text-white mb-1">Member Since</h5>
                                    <p class="text-gray-600 dark:text-gray-400">{{ $store->created_at->format('F Y') }}</p>
                                </div>
                                
                                <div>
                                    <h5 class="font-medium text-gray-900 dark:text-white mb-1">Total Visits</h5>
                                    <p class="text-gray-600 dark:text-gray-400">{{ number_format($store->visits_count) }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Navigation Tabs -->
    <div class="sticky top-0 z-10 bg-gray-50 dark:bg-gray-900 border-b border-gray-200 dark:border-gray-700 mb-4 sm:mb-6 mt-4">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div id="navigationTabs" class="flex items-center">
                <button onclick="toggleSearch()" class="p-2 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300 flex-shrink-0 z-10">
                    <i class="fas fa-search text-lg"></i>
                </button>
                <nav class="flex space-x-6 overflow-x-auto scrollbar-hide ml-2" style="scrollbar-width: none; -ms-overflow-style: none;">
                    <button onclick="filterProducts('all')" class="tab-filter active text-blue-600 dark:text-blue-400 whitespace-nowrap py-2 px-3 border-b-2 border-blue-500 font-medium text-sm">
                        All Products
                    </button>
                    <button onclick="filterProducts('digital')" class="tab-filter text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 whitespace-nowrap py-2 px-3 border-b-2 border-transparent font-medium text-sm">
                        Digital
                    </button>
                    <button onclick="filterProducts('physical')" class="tab-filter text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 whitespace-nowrap py-2 px-3 border-b-2 border-transparent font-medium text-sm">
                        Physical
                    </button>
                </nav>
            </div>
            
            <!-- Search Bar -->
            <div id="searchBar" class="hidden py-4">
                <div class="flex items-center space-x-4">
                    <div class="relative flex-1 max-w-md">
                        <input type="text" id="productSearch" placeholder="Search products, categories, tags..." class="w-full pl-10 pr-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                    </div>
                    <button onclick="closeSearch()" class="px-4 py-2 text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Products Grid -->
        @if($store->products && $store->products->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($store->products->where('is_active', true) as $product)
                    <a href="{{ route('store.product.show', [$store->handle, $product->id]) }}" class="group cursor-pointer block" data-product data-product-name="{{ $product->name }}" data-product-type="{{ $product->type }}" data-product-category="{{ $product->category }}" data-product-description="{{ $product->description }}" data-product-tags="{{ $product->tags ? implode(' ', $product->tags) : '' }}">
                        <div class="relative">
                            <div class="aspect-[4/3] bg-gray-200 dark:bg-gray-700 rounded-lg overflow-hidden mb-3">
                                @if($product->images && count($product->images) > 0)
                                    <img src="{{ $product->images[0] }}" alt="{{ $product->name }}" class="w-full h-full object-contain group-hover:scale-105 transition-transform duration-300">
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <i class="fas fa-image text-4xl text-gray-400"></i>
                                    </div>
                                @endif
                            </div>
                            @if($product->list_price && $product->list_price > $product->price)
                                @php
                                    $discount = round((($product->list_price - $product->price) / $product->list_price) * 100);
                                @endphp
                                <span class="absolute top-2 left-2 bg-red-500 text-white px-2 py-1 text-xs font-bold rounded-md">
                                    {{ $discount }}% OFF
                                </span>
                            @endif

                        </div>
                        
                        <div class="space-y-2">
                            <div class="flex items-start justify-between gap-2">
                                <h3 class="font-medium text-gray-900 dark:text-white text-sm sm:text-base line-clamp-2 flex-1">{{ $product->name }}</h3>

                            </div>
                            
                            @if($product->description)
                                <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400 line-clamp-2">{{ $product->description }}</p>
                            @endif
                            
                            @if($product->category)
                                <p class="text-xs text-gray-500 dark:text-gray-400">{{ $product->category }}</p>
                            @endif
                            
                            <div class="flex items-center justify-between pt-2">
                                <div class="flex items-center space-x-2">
                                    @if($product->list_price && $product->list_price > $product->price)
                                        <span class="text-sm text-gray-500 dark:text-gray-400 line-through">${{ number_format($product->list_price, 2) }}</span>
                                    @endif
                                    <span class="text-lg font-bold text-gray-900 dark:text-white">${{ number_format($product->price, 2) }}</span>
                                </div>
                                @if($product->is_active)
                                    <button class="add-to-cart-btn bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded-lg text-sm font-medium transition-colors" 
                                            data-product-id="{{ $product->id }}" 
                                            data-product-name="{{ $product->name }}" 
                                            data-product-price="{{ $product->price }}" 
                                            data-store-name="{{ $store->name }}" 
                                            data-product-image="{{ $product->images && count($product->images) > 0 ? $product->images[0] : '' }}" 
                                            data-product-type="{{ $product->type }}">
                                        Add to Cart
                                    </button>
                                @else
                                    <span class="text-sm text-red-600 dark:text-red-400 font-medium">Out of Stock</span>
                                @endif
                            </div>
                            

                        </div>
                    </a>
                @endforeach
            </div>
        @else
            <!-- Empty Store State -->
            <div class="text-center py-16">
                <div class="w-24 h-24 bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-store-slash text-3xl text-gray-400"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">Store inventory coming soon</h3>
                <p class="text-gray-600 dark:text-gray-400 max-w-md mx-auto">This store is currently setting up their product catalog. Please check back later for exciting new items!</p>
            </div>
        @endif
    </div>
</div>

</x-store-layout>

@push('styles')
<style>
    .scrollbar-hide::-webkit-scrollbar {
        display: none;
    }
    .scrollbar-hide {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
    
    /* Custom scrollbar for modal */
    #storeDetailsModal .overflow-y-auto::-webkit-scrollbar {
        width: 3px;
    }
    
    #storeDetailsModal .overflow-y-auto::-webkit-scrollbar-track {
        background: transparent;
    }
    
    #storeDetailsModal .overflow-y-auto::-webkit-scrollbar-thumb {
        background-color: rgba(107, 114, 128, 0.6);
        border-radius: 2px;
    }
    
    .dark #storeDetailsModal .overflow-y-auto::-webkit-scrollbar-thumb {
        background-color: rgba(55, 65, 81, 0.8);
    }
    
    #storeDetailsModal .overflow-y-auto::-webkit-scrollbar-thumb:hover {
        background-color: rgba(107, 114, 128, 0.9);
    }
    
    .dark #storeDetailsModal .overflow-y-auto::-webkit-scrollbar-thumb:hover {
        background-color: rgba(55, 65, 81, 1);
    }
    
    /* Hide horizontal scrollbar for thumbnails */
    .scrollbar-hide::-webkit-scrollbar {
        display: none;
    }
    .scrollbar-hide {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('productSearch');
        let allProducts = [];
        let currentFilter = 'all';
        
        // Initialize products array
        function initializeProducts() {
            const productElements = document.querySelectorAll('[data-product]');
            allProducts = Array.from(productElements).map(el => ({
                element: el,
                name: el.dataset.productName.toLowerCase(),
                type: el.dataset.productType,
                category: el.dataset.productCategory ? el.dataset.productCategory.toLowerCase() : '',
                description: el.dataset.productDescription ? el.dataset.productDescription.toLowerCase() : '',
                tags: el.dataset.productTags ? el.dataset.productTags.toLowerCase() : ''
            }));
        }
        
        // Search functionality
        if (searchInput) {
            searchInput.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                filterAndSearch(currentFilter, searchTerm);
            });
        }
        
        // Filter products by type
        window.filterProducts = function(type) {
            currentFilter = type;
            const searchTerm = searchInput ? searchInput.value.toLowerCase() : '';
            
            // Update active tab
            document.querySelectorAll('.tab-filter').forEach(tab => {
                tab.classList.remove('border-blue-500', 'text-blue-600', 'dark:text-blue-400', 'active');
                tab.classList.add('border-transparent', 'text-gray-500', 'dark:text-gray-400');
            });
            event.target.classList.remove('border-transparent', 'text-gray-500', 'dark:text-gray-400');
            event.target.classList.add('border-blue-500', 'text-blue-600', 'dark:text-blue-400', 'active');
            
            filterAndSearch(type, searchTerm);
        };
        
        // Combined filter and search function
        function filterAndSearch(type, searchTerm) {
            allProducts.forEach(product => {
                let show = true;
                
                // Filter by type
                if (type !== 'all' && product.type !== type) {
                    show = false;
                }
                
                // Filter by search term
                if (searchTerm && show) {
                    const matchesSearch = 
                        product.name.includes(searchTerm) ||
                        product.category.includes(searchTerm) ||
                        product.description.includes(searchTerm) ||
                        product.tags.includes(searchTerm);
                    
                    if (!matchesSearch) {
                        show = false;
                    }
                }
                
                // Show/hide product
                if (show) {
                    product.element.style.display = 'block';
                } else {
                    product.element.style.display = 'none';
                }
            });
            
            // Check if any products are visible
            const visibleProducts = allProducts.filter(p => p.element.style.display !== 'none');
            const emptyState = document.getElementById('emptyState');
            const productsGrid = document.querySelector('.grid');
            
            if (visibleProducts.length === 0 && (searchTerm || type !== 'all')) {
                if (!emptyState) {
                    const emptyDiv = document.createElement('div');
                    emptyDiv.id = 'emptyState';
                    emptyDiv.className = 'col-span-full text-center py-16';
                    
                    let message = '';
                    if (searchTerm) {
                        message = `
                            <div class="w-24 h-24 bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center mx-auto mb-6">
                                <i class="fas fa-search text-3xl text-gray-400"></i>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">No products match your search</h3>
                            <p class="text-gray-600 dark:text-gray-400 max-w-md mx-auto">We couldn't find any products related to "<span class="font-medium">${searchTerm}</span>". Try different keywords or browse our categories.</p>
                        `;
                    } else if (type === 'digital') {
                        message = `
                            <div class="w-24 h-24 bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center mx-auto mb-6">
                                <i class="fas fa-download text-3xl text-gray-400"></i>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">No digital products available</h3>
                            <p class="text-gray-600 dark:text-gray-400 max-w-md mx-auto">This store doesn't have any digital products available. Explore physical products instead.</p>
                        `;
                    } else if (type === 'physical') {
                        message = `
                            <div class="w-24 h-24 bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center mx-auto mb-6">
                                <i class="fas fa-box text-3xl text-gray-400"></i>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">No physical products available</h3>
                            <p class="text-gray-600 dark:text-gray-400 max-w-md mx-auto">This store doesn't have any physical products available. Explore digital products instead.</p>
                        `;
                    }
                    
                    emptyDiv.innerHTML = message;
                    productsGrid.appendChild(emptyDiv);
                }
            } else if (emptyState) {
                emptyState.remove();
            }
        }
        
        // Initialize on page load
        initializeProducts();
    });
    
    // Search toggle functions
    function toggleSearch() {
        const searchBar = document.getElementById('searchBar');
        const navigationTabs = document.getElementById('navigationTabs');
        const searchInput = document.getElementById('productSearch');
        
        if (searchBar.classList.contains('hidden')) {
            searchBar.classList.remove('hidden');
            navigationTabs.classList.add('hidden');
            searchInput.focus();
        } else {
            searchBar.classList.add('hidden');
            navigationTabs.classList.remove('hidden');
            searchInput.value = '';
            // Reset search
            const event = new Event('input');
            searchInput.dispatchEvent(event);
        }
    }
    
    function closeSearch() {
        const searchBar = document.getElementById('searchBar');
        const navigationTabs = document.getElementById('navigationTabs');
        const searchInput = document.getElementById('productSearch');
        
        searchBar.classList.add('hidden');
        navigationTabs.classList.remove('hidden');
        searchInput.value = '';
        // Reset search
        const event = new Event('input');
        searchInput.dispatchEvent(event);
    }
    
    // Store details modal functions
    function showStoreDetails() {
        const modal = document.getElementById('storeDetailsModal');
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }
    
    function closeStoreDetails() {
        const modal = document.getElementById('storeDetailsModal');
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto';
    }
    
    // Close modal when clicking outside
    document.addEventListener('click', function(e) {
        const modal = document.getElementById('storeDetailsModal');
        if (e.target === modal) {
            closeStoreDetails();
        }
    });
    
    // Close with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeStoreDetails();
        }
    });
    

    
    // Follow functionality
    let isFollowing = false;
    
    async function toggleFollow() {
        const userId = document.querySelector('.follow-btn').dataset.userId;
        const action = isFollowing ? 'unfollow' : 'follow';
        const oldFollowState = isFollowing;
        
        // Optimistic UI update - change immediately
        isFollowing = !isFollowing;
        updateFollowButtons();
        
        // Send to server in background
        try {
            const response = await fetch(`/${action}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ user_id: userId })
            });
            
            const result = await response.json();
            
            if (!result.success) {
                // Revert optimistic update on error
                isFollowing = oldFollowState;
                updateFollowButtons();
            }
        } catch (error) {
            console.error('Follow error:', error);
            // Revert optimistic update on network error
            isFollowing = oldFollowState;
            updateFollowButtons();
        }
    }
    
    function updateFollowButtons() {
        const buttons = document.querySelectorAll('.follow-btn');
        buttons.forEach(btn => {
            const text = btn.querySelector('.follow-text');
            if (isFollowing) {
                btn.classList.remove('bg-blue-600', 'hover:bg-blue-700');
                btn.classList.add('bg-gray-600', 'hover:bg-gray-700');
                text.textContent = 'Following';
                
                // Add hover effect to show "Unfollow"
                btn.onmouseenter = () => {
                    text.textContent = 'Unfollow';
                    btn.classList.remove('bg-gray-600', 'hover:bg-gray-700');
                    btn.classList.add('bg-red-600', 'hover:bg-red-700');
                };
                btn.onmouseleave = () => {
                    text.textContent = 'Following';
                    btn.classList.remove('bg-red-600', 'hover:bg-red-700');
                    btn.classList.add('bg-gray-600', 'hover:bg-gray-700');
                };
            } else {
                btn.classList.remove('bg-gray-600', 'hover:bg-gray-700', 'bg-red-600', 'hover:bg-red-700');
                btn.classList.add('bg-blue-600', 'hover:bg-blue-700');
                text.textContent = 'Follow';
                btn.onmouseenter = null;
                btn.onmouseleave = null;
            }
        });
    }
    
    // Check follow status on page load (only on fresh page loads)
    @auth
    document.addEventListener('DOMContentLoaded', async function() {
        const followBtn = document.querySelector('.follow-btn');
        if (!followBtn) return;
        
        const userId = followBtn.dataset.userId;
        
        // Don't show follow button if it's the current user's own store
        if (userId === '{{ auth()->id() }}') {
            document.querySelectorAll('.follow-btn').forEach(btn => {
                btn.style.display = 'none';
            });
            return;
        }
        
        // Only load initial status if page is freshly loaded (not from back button)
        if (performance.navigation.type === performance.navigation.TYPE_NAVIGATE) {
            try {
                const response = await fetch('/follow-status', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ user_ids: [userId] })
                });
                const result = await response.json();
                if (result.success && result.following_status[userId] !== undefined) {
                    isFollowing = result.following_status[userId];
                    updateFollowButtons();
                }
            } catch (error) {
                console.error('Follow status error:', error);
            }
        }
    });
    @endauth
</script>
@endpush