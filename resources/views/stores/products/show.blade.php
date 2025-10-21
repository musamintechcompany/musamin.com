@extends('layouts.store')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900">
    <!-- Breadcrumb -->
    <div class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3">
            <nav class="flex text-sm">
                <a href="{{ route('store.show', $store->handle) }}" class="text-blue-600 hover:text-blue-800">{{ $store->name }}</a>
                <span class="mx-2 text-gray-500">/</span>
                <span class="text-gray-900 dark:text-white">{{ $product->name }}</span>
            </nav>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12">
            <!-- Product Images -->
            <div class="space-y-4">
                <div class="relative aspect-square bg-gray-200 dark:bg-gray-700 rounded-lg overflow-hidden cursor-pointer" onclick="openImageViewer()">
                    @if($product->images && count($product->images) > 0)
                        <img id="mainImage" src="{{ $product->images[0] }}" alt="{{ $product->name }}" class="w-full h-full object-contain">
                    @else
                        <div class="w-full h-full flex items-center justify-center">
                            <i class="fas fa-image text-6xl text-gray-400"></i>
                        </div>
                    @endif
                    @if($product->list_price && $product->list_price > $product->price)
                        @php
                            $discount = round((($product->list_price - $product->price) / $product->list_price) * 100);
                        @endphp
                        <span class="absolute top-4 left-4 bg-red-500 text-white px-3 py-2 text-sm font-bold rounded-lg shadow-lg">
                            {{ $discount }}% OFF
                        </span>
                    @endif
                    <div class="absolute inset-0 bg-black bg-opacity-0 hover:bg-opacity-10 transition-all duration-200 flex items-center justify-center">
                        <i class="fas fa-expand text-white opacity-0 hover:opacity-100 transition-opacity duration-200 text-2xl"></i>
                    </div>
                </div>
                
                @if($product->images && count($product->images) > 1)
                    <div class="overflow-x-auto" style="scrollbar-width: none; -ms-overflow-style: none;">
                        <div class="flex gap-2 pb-2" style="min-width: max-content;">
                            @foreach($product->images as $index => $image)
                                <button onclick="changeMainImage('{{ $image }}')" class="flex-shrink-0 w-20 h-20 bg-gray-200 dark:bg-gray-700 rounded-lg overflow-hidden border-2 border-transparent hover:border-blue-500 transition-colors">
                                    <img src="{{ $image }}" alt="Product image {{ $index + 1 }}" class="w-full h-full object-contain">
                                </button>
                            @endforeach
                        </div>
                        <style>
                            .overflow-x-auto::-webkit-scrollbar {
                                display: none;
                            }
                        </style>
                    </div>
                @endif
            </div>

            <!-- Product Info -->
            <div class="space-y-6">
                <div>
                    <div class="flex items-center gap-3 mb-2">
                        <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white">{{ $product->name }}</h1>
                        @if($product->type === 'digital')
                            <span class="px-3 py-1 bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 text-sm rounded-full">Digital</span>
                        @else
                            <span class="px-3 py-1 bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 text-sm rounded-full">Physical</span>
                        @endif
                    </div>
                    
                    @if($product->category)
                        <p class="text-gray-600 dark:text-gray-400 mb-4">{{ $product->category }}</p>
                    @endif
                    
                    <div class="mb-4">
                        @if($product->list_price && $product->list_price > $product->price)
                            <div class="flex items-center space-x-3">
                                <span class="text-2xl text-gray-500 dark:text-gray-400 line-through">${{ number_format($product->list_price, 2) }}</span>
                                <span class="text-3xl font-bold text-gray-900 dark:text-white">${{ number_format($product->price, 2) }}</span>
                            </div>
                        @else
                            <div class="text-3xl font-bold text-gray-900 dark:text-white">
                                ${{ number_format($product->price, 2) }}
                            </div>
                        @endif
                    </div>
                </div>

                @if($product->description)
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Description</h3>
                        <p class="text-gray-700 dark:text-gray-300 leading-relaxed">{{ $product->description }}</p>
                    </div>
                @endif

                <!-- Stock Status -->
                @if($product->type === 'physical')
                    <div class="flex items-center gap-2">
                        @if($product->isInStock())
                            <i class="fas fa-check-circle text-green-500"></i>
                            <span class="text-green-600 dark:text-green-400 font-medium">
                                {{ $product->stock_quantity }} in stock
                            </span>
                        @else
                            <i class="fas fa-times-circle text-red-500"></i>
                            <span class="text-red-600 dark:text-red-400 font-medium">Out of stock</span>
                        @endif
                    </div>
                @else
                    <div class="flex items-center gap-2">
                        <i class="fas fa-download text-blue-500"></i>
                        <span class="text-blue-600 dark:text-blue-400 font-medium">Instant download</span>
                    </div>
                @endif

                <!-- Specifications -->
                @if($product->specifications)
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">Specifications</h3>
                        <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-4">
                            @foreach($product->specifications as $key => $value)
                                <div class="flex justify-between py-2 border-b border-gray-200 dark:border-gray-700 last:border-b-0">
                                    <span class="font-medium text-gray-700 dark:text-gray-300">{{ ucfirst($key) }}:</span>
                                    <span class="text-gray-900 dark:text-white">{{ $value }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Tags -->
                @if($product->tags && count($product->tags) > 0)
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Tags</h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach($product->tags as $tag)
                                <span class="px-3 py-1 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 text-sm rounded-full">{{ $tag }}</span>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Add to Cart / Buy Now -->
                <div class="space-y-4">
                    @if($product->isInStock())
                        @if($product->type === 'physical')
                            <div class="flex items-center gap-4">
                                <div class="flex items-center border border-gray-300 dark:border-gray-600 rounded-lg">
                                    <button onclick="decreaseQuantity()" class="px-3 py-2 text-gray-600 hover:text-gray-800">-</button>
                                    <input type="number" id="quantity" value="1" min="1" max="{{ $product->stock_quantity }}" class="w-16 text-center border-0 bg-transparent">
                                    <button onclick="increaseQuantity()" class="px-3 py-2 text-gray-600 hover:text-gray-800">+</button>
                                </div>
                                <button class="add-to-cart-btn flex-1 bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold transition-colors" 
                                        data-product-id="{{ $product->id }}" 
                                        data-product-name="{{ $product->name }}" 
                                        data-product-price="{{ $product->price }}" 
                                        data-store-name="{{ $store->name }}" 
                                        data-product-image="{{ $product->main_image }}" 
                                        data-product-type="{{ $product->type }}">
                                    Add to Cart
                                </button>
                            </div>
                        @else
                            <button class="add-to-cart-btn w-full bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold transition-colors" 
                                    data-product-id="{{ $product->id }}" 
                                    data-product-name="{{ $product->name }}" 
                                    data-product-price="{{ $product->price }}" 
                                    data-store-name="{{ $store->name }}" 
                                    data-product-image="{{ $product->main_image }}" 
                                    data-product-type="{{ $product->type }}">
                                Add to Cart
                            </button>
                        @endif
                        
                        <div class="grid grid-cols-1 gap-3">
                            @auth
                                @if(auth()->id() !== $store->user->id)
                                    <button onclick="openChat('{{ $store->user->id }}', '{{ $store->user->name }}', '{{ $store->user->avatar ?? '' }}', 'product', '{{ $product->name }}')" class="w-full bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg font-semibold transition-colors">
                                        <i class="fas fa-comment mr-2"></i>Contact Seller
                                    </button>
                                @endif
                            @endauth
                            <button onclick="shareProduct()" class="w-full border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 px-6 py-3 rounded-lg font-semibold hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                                <i class="fas fa-share mr-2"></i>Share Product
                            </button>
                        </div>
                    @else
                        <div class="space-y-3">
                            <button disabled class="w-full bg-gray-400 text-white px-6 py-3 rounded-lg font-semibold cursor-not-allowed">
                                Out of Stock
                            </button>
                            @auth
                                @if(auth()->id() !== $store->user->id)
                                    <button onclick="openChat('{{ $store->user->id }}', '{{ $store->user->name }}', '{{ $store->user->avatar ?? '' }}', 'product', '{{ $product->name }}')" class="w-full bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg font-semibold transition-colors">
                                        <i class="fas fa-comment mr-2"></i>Contact Seller
                                    </button>
                                @endif
                            @endauth
                        </div>
                    @endif
                </div>


            </div>
        </div>

        <!-- Related Products -->
        @if($relatedProducts->count() > 0)
            <div class="mt-16">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-8">More from this store</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($relatedProducts as $relatedProduct)
                        <a href="{{ route('store.product.show', [$store->handle, $relatedProduct->id]) }}" class="group">
                            <div class="aspect-square bg-gray-200 dark:bg-gray-700 rounded-lg overflow-hidden mb-3">
                                @if($relatedProduct->main_image)
                                    <img src="{{ $relatedProduct->main_image }}" alt="{{ $relatedProduct->name }}" class="w-full h-full object-contain group-hover:scale-105 transition-transform duration-300">
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <i class="fas fa-image text-3xl text-gray-400"></i>
                                    </div>
                                @endif
                            </div>
                            <h3 class="font-medium text-gray-900 dark:text-white text-sm line-clamp-2 mb-1">{{ $relatedProduct->name }}</h3>
                            <p class="text-lg font-bold text-gray-900 dark:text-white">${{ number_format($relatedProduct->price, 2) }}</p>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
    const productImages = @json($product->images ?? []);
    let currentImageIndex = 0;
    
    function changeMainImage(imageSrc) {
        document.getElementById('mainImage').src = imageSrc;
        currentImageIndex = productImages.indexOf(imageSrc);
    }
    
    function openImageViewer() {
        if (productImages.length === 0) return;
        
        const viewer = document.createElement('div');
        viewer.id = 'imageViewer';
        viewer.className = 'fixed inset-0 bg-black bg-opacity-95 z-50 flex items-center justify-center';
        viewer.innerHTML = `
            <div class="relative w-full h-full flex items-center justify-center">
                <button onclick="closeImageViewer()" class="absolute top-4 right-4 text-white text-3xl hover:text-gray-300 z-10">
                    <i class="fas fa-times"></i>
                </button>
                
                <button onclick="previousImage()" class="absolute left-4 text-white text-4xl hover:text-gray-300 z-10 ${productImages.length <= 1 ? 'hidden' : ''}">
                    <i class="fas fa-chevron-left"></i>
                </button>
                
                <div class="w-full h-full flex items-center justify-center px-16">
                    <img id="viewerImage" src="${productImages[currentImageIndex]}" class="max-w-full max-h-full object-contain">
                </div>
                
                <button onclick="nextImage()" class="absolute right-4 text-white text-4xl hover:text-gray-300 z-10 ${productImages.length <= 1 ? 'hidden' : ''}">
                    <i class="fas fa-chevron-right"></i>
                </button>
                
                <div id="imageCounter" class="absolute bottom-4 left-1/2 transform -translate-x-1/2 text-white text-sm bg-black bg-opacity-50 px-3 py-1 rounded ${productImages.length <= 1 ? 'hidden' : ''}">
                    ${currentImageIndex + 1} / ${productImages.length}
                </div>
                
                <div id="endMessage" class="absolute bottom-16 left-1/2 transform -translate-x-1/2 text-white text-sm bg-red-500 px-4 py-2 rounded opacity-0 transition-opacity duration-300">
                    You've reached the end
                </div>
            </div>
        `;
        
        // Touch/swipe support
        let startX = 0;
        viewer.addEventListener('touchstart', (e) => {
            startX = e.touches[0].clientX;
        });
        
        viewer.addEventListener('touchend', (e) => {
            const endX = e.changedTouches[0].clientX;
            const diff = startX - endX;
            
            if (Math.abs(diff) > 50) {
                if (diff > 0) nextImage();
                else previousImage();
            }
        });
        
        // Keyboard support
        viewer.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') closeImageViewer();
            else if (e.key === 'ArrowLeft') previousImage();
            else if (e.key === 'ArrowRight') nextImage();
        });
        
        viewer.tabIndex = 0;
        document.body.appendChild(viewer);
        viewer.focus();
        document.body.style.overflow = 'hidden';
    }
    
    function closeImageViewer() {
        const viewer = document.getElementById('imageViewer');
        if (viewer) {
            viewer.remove();
            document.body.style.overflow = 'auto';
        }
    }
    
    function nextImage() {
        if (currentImageIndex < productImages.length - 1) {
            currentImageIndex++;
            updateViewerImage();
        } else {
            showEndMessage();
        }
    }
    
    function previousImage() {
        if (currentImageIndex > 0) {
            currentImageIndex--;
            updateViewerImage();
        } else {
            showEndMessage();
        }
    }
    
    function updateViewerImage() {
        const viewerImage = document.getElementById('viewerImage');
        const counter = document.getElementById('imageCounter');
        
        if (viewerImage) {
            viewerImage.src = productImages[currentImageIndex];
        }
        
        if (counter) {
            counter.textContent = `${currentImageIndex + 1} / ${productImages.length}`;
        }
    }
    
    function showEndMessage() {
        const message = document.getElementById('endMessage');
        if (message) {
            message.style.opacity = '1';
            setTimeout(() => {
                message.style.opacity = '0';
            }, 1500);
        }
    }

    function increaseQuantity() {
        const input = document.getElementById('quantity');
        const max = parseInt(input.getAttribute('max'));
        const current = parseInt(input.value);
        if (current < max) {
            input.value = current + 1;
        }
    }

    function decreaseQuantity() {
        const input = document.getElementById('quantity');
        const current = parseInt(input.value);
        if (current > 1) {
            input.value = current - 1;
        }
    }

    function shareProduct() {
        const productUrl = window.location.href;
        const productTitle = '{{ $product->name }}';
        const productDescription = '{{ Str::limit($product->description ?? "Check out this amazing product", 100) }}';
        const shareText = `${productTitle} - ${productDescription}`;
        
        if (navigator.share) {
            navigator.share({
                title: productTitle,
                text: shareText,
                url: productUrl
            }).catch(console.error);
        } else {
            showShareModal(productUrl, productTitle, shareText);
        }
    }

    function showShareModal(url, title, text) {
        const existingModal = document.getElementById('shareModal');
        if (existingModal) existingModal.remove();
        
        const whatsappUrl = `https://wa.me/?text=${encodeURIComponent(text + ' ' + url)}`;
        const twitterUrl = `https://twitter.com/intent/tweet?text=${encodeURIComponent(text)}&url=${encodeURIComponent(url)}`;
        const facebookUrl = `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(url)}`;
        const telegramUrl = `https://t.me/share/url?url=${encodeURIComponent(url)}&text=${encodeURIComponent(text)}`;
        
        const modal = document.createElement('div');
        modal.id = 'shareModal';
        modal.className = 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50';
        modal.innerHTML = `
            <div class="bg-white dark:bg-gray-800 rounded-lg p-6 max-w-sm mx-4 shadow-xl">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Share Product</h3>
                    <button onclick="closeShareModal()" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="grid grid-cols-2 gap-3 mb-4">
                    <a href="${whatsappUrl}" target="_blank" class="flex items-center justify-center p-3 bg-green-500 hover:bg-green-600 text-white rounded-lg">
                        <i class="fab fa-whatsapp mr-2"></i>WhatsApp
                    </a>
                    <a href="${facebookUrl}" target="_blank" class="flex items-center justify-center p-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg">
                        <i class="fab fa-facebook mr-2"></i>Facebook
                    </a>
                    <a href="${twitterUrl}" target="_blank" class="flex items-center justify-center p-3 bg-blue-400 hover:bg-blue-500 text-white rounded-lg">
                        <i class="fab fa-twitter mr-2"></i>Twitter
                    </a>
                    <a href="${telegramUrl}" target="_blank" class="flex items-center justify-center p-3 bg-blue-500 hover:bg-blue-600 text-white rounded-lg">
                        <i class="fab fa-telegram mr-2"></i>Telegram
                    </a>
                    <button onclick="copyProductLink('${url}')" class="col-span-2 flex items-center justify-center p-3 bg-gray-600 hover:bg-gray-700 text-white rounded-lg">
                        <i class="fas fa-copy mr-2"></i>Copy Link
                    </button>
                </div>
                <button onclick="closeShareModal()" class="w-full px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-300">
                    Close
                </button>
            </div>
        `;
        
        modal.onclick = (e) => { if (e.target === modal) closeShareModal(); };
        document.body.appendChild(modal);
    }

    function copyProductLink(url) {
        navigator.clipboard.writeText(url).then(() => {
            showNotification('Product link copied to clipboard!', 'success');
            closeShareModal();
        }).catch(() => {
            showNotification('Failed to copy link', 'error');
        });
    }

    function closeShareModal() {
        const modal = document.getElementById('shareModal');
        if (modal) modal.remove();
    }
    
    // Close image viewer when clicking outside
    document.addEventListener('click', (e) => {
        const viewer = document.getElementById('imageViewer');
        if (viewer && e.target === viewer) {
            closeImageViewer();
        }
    });

    function showNotification(message, type = 'success') {
        const notification = document.createElement('div');
        notification.className = `fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg ${
            type === 'success' ? 'bg-green-500' : 'bg-red-500'
        } text-white max-w-sm`;
        notification.innerHTML = `
            <div class="flex items-center">
                <i class="fas fa-${type === 'success' ? 'check' : 'exclamation-triangle'} mr-2"></i>
                <span>${message}</span>
            </div>
        `;
        document.body.appendChild(notification);
        setTimeout(() => notification.remove(), 3000);
    }


</script>
@endpush
@endsection