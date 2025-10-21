<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', ($store->name ?? 'Store') . ' - ' . config('app.name', 'Laravel'))</title>
        
        @stack('meta')

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Styles -->
        @livewireStyles

        <!-- Theme Detection Script -->
        @auth
            <script>
                try {
                    @if(auth()->user()->prefersDarkTheme())
                        document.documentElement.classList.add('dark');
                    @endif
                } catch (e) {
                    console.warn('Theme initialization failed:', e);
                }
            </script>
        @else
            <script>
                try {
                    if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
                        document.documentElement.classList.add('dark');
                    }
                } catch (e) {
                    console.warn('Theme detection failed:', e);
                }
            </script>
        @endauth
    </head>
    <body class="overflow-x-hidden font-sans antialiased text-gray-900 transition-colors duration-200 bg-gray-50 dark:text-gray-100 dark:bg-gray-900">

        <!-- Store Navigation -->
        <nav class="bg-white border-b border-gray-200 shadow-sm dark:bg-gray-800 dark:border-gray-700">
            <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16">
                    <!-- Logo & Store Name -->
                    <div class="flex items-center flex-1 min-w-0">
                        <a href="{{ route('home') }}" class="text-lg font-bold text-gray-900 truncate sm:text-xl dark:text-white">
                            {{ config('app.name') }}
                        </a>
                        <span class="hidden mx-1 text-gray-400 sm:mx-2 sm:inline">/</span>
                        <span class="hidden text-sm text-gray-600 truncate sm:text-base dark:text-gray-400 sm:inline">
                            {{ $store->name ?? 'Store' }}
                        </span>
                    </div>

                    <!-- Desktop Menu -->
                    <div class="items-center hidden space-x-4 md:flex">
                        <button onclick="openCartPanel()" class="relative p-2 text-gray-600 rounded-full dark:text-gray-400 hover:text-gray-900 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                            <i class="fas fa-shopping-cart"></i>
                            <span class="absolute flex items-center justify-center w-5 h-5 text-xs text-white bg-red-500 rounded-full -top-1 -right-1" style="display: none" id="cartBadge">0</span>
                        </button>
                        @auth
                            <a href="{{ route('dashboard') }}" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white whitespace-nowrap">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white whitespace-nowrap">
                                Login
                            </a>
                            <a href="{{ route('register') }}" class="px-4 py-2 text-sm text-white bg-blue-600 rounded-lg hover:bg-blue-700 whitespace-nowrap">
                                Sign Up
                            </a>
                        @endauth
                    </div>

                    <!-- Mobile Cart & Menu -->
                    <div class="flex items-center space-x-2 md:hidden">
                        <button onclick="openCartPanel()" class="relative p-2 text-gray-600 rounded-md dark:text-gray-400 hover:text-gray-900 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                            <i class="text-lg fas fa-shopping-cart"></i>
                            <span class="absolute flex items-center justify-center w-5 h-5 text-xs text-white bg-red-500 rounded-full -top-1 -right-1" style="display: none" id="mobileCartBadge">0</span>
                        </button>
                        <button id="mobileMenuBtn" class="p-2 text-gray-600 rounded-md dark:text-gray-400 hover:text-gray-900 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                            <i class="text-lg fas fa-bars"></i>
                        </button>
                    </div>
                </div>


            </div>
        </nav>

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>

        <!-- Cart Slide-out Panel -->
        <div id="cartPanel" class="fixed inset-y-0 right-0 z-50 transition-transform duration-300 ease-in-out transform translate-x-full bg-white shadow-xl w-80 dark:bg-gray-800">
            <div class="flex flex-col h-full">
                <div class="flex items-center justify-between p-4 border-b border-gray-200 dark:border-gray-700">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Shopping Cart</h2>
                    <button onclick="closeCartPanel()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                        <i class="text-xl fas fa-times"></i>
                    </button>
                </div>

                <div id="cartPanelItems" class="flex-1 p-4 overflow-y-auto">
                    <!-- Cart items will be populated here -->
                </div>

                <div id="cartPanelSummary" class="hidden p-4 border-t border-gray-200 dark:border-gray-700">
                    <div class="mb-4 space-y-2">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600 dark:text-gray-400">Subtotal:</span>
                            <span id="panelSubtotal" class="font-medium text-gray-900 dark:text-white">$0.00</span>
                        </div>
                        <div class="flex justify-between pt-2 text-lg font-semibold border-t border-gray-200 dark:border-gray-600">
                            <span class="text-gray-900 dark:text-white">Total:</span>
                            <span id="panelTotal" class="text-gray-900 dark:text-white">$0.00</span>
                        </div>
                        @auth
                            <div class="text-center">
                                <span id="panelCoins" class="text-xs text-gray-500 dark:text-gray-400">0 coins</span>
                            </div>
                        @endauth
                    </div>
                    <div class="space-y-2">
                        <button onclick="proceedToCheckout()" class="w-full px-4 py-2 font-medium text-white transition-colors bg-blue-600 rounded-lg hover:bg-blue-700">
                            Checkout Now
                        </button>
                        @auth
                            <a href="{{ route('cart.index') }}" class="block w-full px-4 py-2 font-medium text-center text-gray-700 transition-colors border border-gray-300 rounded-lg dark:border-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">
                                View Full Cart
                            </a>
                        @else
                            <button onclick="clearAllCart()" class="w-full px-4 py-2 font-medium text-gray-700 transition-colors border border-gray-300 rounded-lg dark:border-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">
                                Clear All Cart
                            </button>
                        @endauth
                    </div>
                </div>

                <div id="cartPanelEmpty" class="flex items-center justify-center flex-1 p-4">
                    <div class="text-center">
                        <i class="mb-4 text-4xl text-gray-400 fas fa-shopping-cart"></i>
                        <h3 class="mb-2 text-lg font-medium text-gray-900 dark:text-white">Your cart is empty</h3>
                        <p class="text-gray-500 dark:text-gray-400">Add some items to get started</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Cart Panel Overlay -->
        <div id="cartPanelOverlay" class="fixed inset-0 z-40 hidden bg-black bg-opacity-50" onclick="closeCartPanel()"></div>

        <!-- Mobile Menu Sidebar -->
        <div id="mobileMenuSidebar" class="fixed inset-y-0 left-0 z-50 transition-transform duration-300 ease-in-out transform -translate-x-full bg-white shadow-xl w-80 dark:bg-gray-800">
            <div class="flex flex-col h-full">
                <div class="flex items-center justify-between p-4 border-b border-gray-200 dark:border-gray-700">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Menu</h2>
                    <button onclick="closeMobileMenu()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                        <i class="text-xl fas fa-times"></i>
                    </button>
                </div>

                <div class="flex-1 p-4 overflow-y-auto">
                    <div class="space-y-3">
                        <!-- Store Name -->
                        <div class="px-2 pb-2 mb-4 text-sm text-gray-600 border-b border-gray-200 dark:text-gray-400 dark:border-gray-700">
                            Store: {{ $store->name ?? 'Store' }}
                        </div>

                        <a href="{{ route('cart.index') }}" class="flex items-center px-3 py-3 text-gray-600 rounded-lg dark:text-gray-400 hover:text-gray-900 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                            <i class="w-5 mr-3 fas fa-shopping-cart"></i>
                            <span>Cart</span>
                            <span class="px-2 py-1 ml-auto text-xs text-white bg-red-500 rounded-full" style="display: none" id="sidebarCartBadge">0</span>
                        </a>

                        @auth
                            <a href="{{ route('dashboard') }}" class="flex items-center px-3 py-3 text-gray-600 rounded-lg dark:text-gray-400 hover:text-gray-900 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                                <i class="w-5 mr-3 fas fa-tachometer-alt"></i>
                                <span>Dashboard</span>
                            </a>
                            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="flex items-center px-3 py-3 text-red-600 rounded-lg dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20">
                                <i class="w-5 mr-3 fas fa-sign-out-alt"></i>
                                <span>Logout</span>
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                                @csrf
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="flex items-center px-3 py-3 text-gray-600 rounded-lg dark:text-gray-400 hover:text-gray-900 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                                <i class="w-5 mr-3 fas fa-sign-in-alt"></i>
                                <span>Login</span>
                            </a>
                            <a href="{{ route('register') }}" class="flex items-center px-3 py-3 text-white bg-blue-600 rounded-lg hover:bg-blue-700">
                                <i class="w-5 mr-3 fas fa-user-plus"></i>
                                <span>Sign Up</span>
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>

        <!-- Mobile Menu Overlay -->
        <div id="mobileMenuOverlay" class="fixed inset-0 z-40 hidden bg-black bg-opacity-50" onclick="closeMobileMenu()"></div>

        <!-- Chat Modal -->
        @auth
            <x-chat-modal />
        @endauth

        @livewireScripts
        @stack('scripts')

        <!-- Mobile Menu Script -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const mobileMenuBtn = document.getElementById('mobileMenuBtn');

                if (mobileMenuBtn) {
                    mobileMenuBtn.addEventListener('click', function() {
                        openMobileMenu();
                    });
                }

                // Load cart count on page load
                loadCartCount();

                // Sync guest cart to database if user is authenticated
                @auth
                    syncGuestCart();
                @endauth

                // Add event listeners for add to cart buttons
                document.addEventListener('click', function(e) {
                    const btn = e.target.classList.contains('add-to-cart-btn')
                        ? e.target
                        : e.target.closest('.add-to-cart-btn');

                    if (!btn) return;

                    e.preventDefault();
                    e.stopPropagation();

                    const productData = {
                        product_id: btn.dataset.productId,
                        name: btn.dataset.productName,
                        price: btn.dataset.productPrice,
                        store_name: btn.dataset.storeName,
                        image: btn.dataset.productImage,
                        type: btn.dataset.productType
                    };

                    addToCart(productData.product_id, productData.name, productData.price, productData.store_name, productData.image, productData.type);
                });
            });

            function loadCartCount() {
                const cacheKey = 'cart_count';
                const cacheExpiryKey = 'cart_count_expiry';
                const now = Date.now();
                const cacheExpiry = parseInt(sessionStorage.getItem(cacheExpiryKey) || '0', 10);

                if (sessionStorage.getItem(cacheKey) && cacheExpiry > now) {
                    updateCartBadge(parseInt(sessionStorage.getItem(cacheKey), 10));
                } else {
                    fetch('/cart/count')
                        .then(response => response.json())
                        .then(data => {
                            updateCartBadge(data.count);
                            sessionStorage.setItem(cacheKey, data.count);
                            // Cache for 60 seconds
                            sessionStorage.setItem(cacheExpiryKey, (now + 60000).toString());
                        })
                        .catch(() => updateCartBadge(0));
                }
            }

            // Cache DOM elements for better performance
            const cartBadges = {
                desktop: document.getElementById('cartBadge'),
                mobile: document.getElementById('mobileCartBadge')
            };

            const cartElements = {
                panel: document.getElementById('cartPanel'),
                overlay: document.getElementById('cartPanelOverlay')
            };

            function updateCartBadge(count) {
                const displayText = count > 99 ? '99+' : count;
                const shouldShow = count > 0;

                Object.values(cartBadges).forEach(badge => {
                    if (badge) {
                        badge.textContent = displayText;
                        badge.style.display = shouldShow ? 'flex' : 'none';
                    }
                });
            }

            function addToCart(productId, name, price, storeName, image, type) {
                // Optimistic UI update - update immediately
                const cart = JSON.parse(sessionStorage.getItem('cart') || '{}');
                let newCount = 0;
                
                if (cart[productId]) {
                    cart[productId].quantity = (cart[productId].quantity || 1) + 1;
                } else {
                    cart[productId] = {
                        id: productId,
                        name: name,
                        price: price,
                        store_name: storeName,
                        image: image,
                        type: type,
                        quantity: 1
                    };
                }
                sessionStorage.setItem('cart', JSON.stringify(cart));
                
                // Count unique items for badge (not quantities)
                newCount = Object.keys(cart).length;
                updateCartBadge(newCount);
                animateCartCount();
                refreshCartPanel();
                showCartNotification('Item added to cart');

                const cartData = {
                    product_id: productId,
                    name: name,
                    price: price,
                    store_name: storeName,
                    image: image,
                    type: type
                };

                // Send to server in background
                fetch('/cart/add', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: new URLSearchParams(cartData)
                })
                .then(response => response.json())
                .then(data => {
                    if (!data.success) {
                        // Revert optimistic update on error
                        const cart = JSON.parse(sessionStorage.getItem('cart') || '{}');
                        if (cart[productId]) {
                            if (cart[productId].quantity > 1) {
                                cart[productId].quantity--;
                            } else {
                                delete cart[productId];
                            }
                            sessionStorage.setItem('cart', JSON.stringify(cart));
                            const revertCount = Object.values(cart).reduce((sum, item) => sum + (item.quantity || 1), 0);
                            updateCartBadge(revertCount);
                            refreshCartPanel();
                        }
                        showCartNotification(data.message || 'Error adding item to cart', 'error');
                    }
                })
                .catch(() => {
                    // Revert optimistic update on network error
                    const cart = JSON.parse(sessionStorage.getItem('cart') || '{}');
                    if (cart[productId]) {
                        if (cart[productId].quantity > 1) {
                            cart[productId].quantity--;
                        } else {
                            delete cart[productId];
                        }
                        sessionStorage.setItem('cart', JSON.stringify(cart));
                        const revertCount = Object.values(cart).reduce((sum, item) => sum + (item.quantity || 1), 0);
                        updateCartBadge(revertCount);
                        refreshCartPanel();
                    }
                    showCartNotification('Network error. Please try again.', 'error');
                });
            }

            function animateCartCount() {
                Object.values(cartBadges).forEach(badge => {
                    if (badge && badge.style.display !== 'none') {
                        badge.style.transform = 'scale(1.3)';
                        badge.style.transition = 'transform 0.2s ease';
                        setTimeout(() => badge.style.transform = 'scale(1)', 200);
                    }
                });
            }

            function openCartPanel() {
                // Load cart from server and sync with sessionStorage
                fetch('/cart')
                    .then(response => response.json())
                    .then(data => {
                        if (data.success && data.items) {
                            const cart = {};
                            data.items.forEach(item => {
                                cart[item.id] = item;
                            });
                            sessionStorage.setItem('cart', JSON.stringify(cart));
                        }
                        refreshCartPanel();
                    })
                    .catch(() => refreshCartPanel());

                cartElements.panel.classList.remove('translate-x-full');
                cartElements.overlay.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            }

            function closeCartPanel() {
                cartElements.panel.classList.add('translate-x-full');
                cartElements.overlay.classList.add('hidden');
                document.body.style.overflow = 'auto';
            }

            function refreshCartPanel() {
                const cart = JSON.parse(sessionStorage.getItem('cart') || '{}');
                const cartItems = Object.values(cart);
                const itemsContainer = document.getElementById('cartPanelItems');
                const summaryContainer = document.getElementById('cartPanelSummary');
                const emptyContainer = document.getElementById('cartPanelEmpty');

                if (cartItems.length === 0) {
                    itemsContainer.innerHTML = '';
                    summaryContainer.classList.add('hidden');
                    emptyContainer.classList.remove('hidden');
                    return;
                }

                emptyContainer.classList.add('hidden');
                summaryContainer.classList.remove('hidden');

                itemsContainer.innerHTML = cartItems.map(item => `
                    <div class="flex items-center p-3 mb-4 space-x-3 rounded-lg bg-gray-50 dark:bg-gray-700">
                        <div class="flex items-center justify-center flex-shrink-0 w-12 h-12 bg-gray-200 rounded-lg dark:bg-gray-600">
                            ${item.image && item.image !== 'null' ?
                                `<img src="${item.image}" alt="${item.name}" class="object-cover w-full h-full rounded-lg">` :
                                `<i class="text-gray-400 fas fa-box"></i>`
                            }
                        </div>
                        <div class="flex-1 min-w-0">
                            <h4 class="text-sm font-medium text-gray-900 truncate dark:text-white">${item.name}</h4>
                            <p class="text-xs text-gray-500 dark:text-gray-400">by ${item.store_name}</p>
                            <p class="text-sm font-medium text-blue-600 dark:text-blue-400">$${parseFloat(item.price).toFixed(2)}</p>
                            <div class="flex items-center mt-2 space-x-1">
                                <button onclick="updatePanelQuantity('${item.id}', ${item.quantity - 1})" class="flex items-center justify-center w-5 h-5 text-gray-700 bg-gray-200 rounded dark:bg-gray-600 dark:text-gray-300 hover:bg-gray-300 dark:hover:bg-gray-500" ${item.quantity <= 1 ? 'disabled' : ''}>
                                    <i class="fas fa-minus" style="font-size: 7px;"></i>
                                </button>
                                <span class="px-1.5 py-0.5 bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white rounded text-xs font-medium min-w-[20px] text-center">${item.quantity}</span>
                                <button onclick="updatePanelQuantity('${item.id}', ${item.quantity + 1})" class="flex items-center justify-center w-5 h-5 text-gray-700 bg-gray-200 rounded dark:bg-gray-600 dark:text-gray-300 hover:bg-gray-300 dark:hover:bg-gray-500">
                                    <i class="fas fa-plus" style="font-size: 7px;"></i>
                                </button>
                            </div>
                        </div>
                        <button onclick="removeFromCartPanel('${item.id}')" class="p-1 text-red-500 hover:text-red-700">
                            <i class="text-sm fas fa-trash"></i>
                        </button>
                    </div>
                `).join('');

                const subtotal = cartItems.reduce((sum, item) => sum + (parseFloat(item.price) * (item.quantity || 1)), 0);
                const total = subtotal;

                document.getElementById('panelSubtotal').textContent = `$${subtotal.toFixed(2)}`;
                document.getElementById('panelTotal').textContent = `$${total.toFixed(2)}`;

                @auth
                    const coinsEquivalent = Math.ceil(total * 100);
                    const coinsElement = document.getElementById('panelCoins');
                    if (coinsElement) {
                        coinsElement.textContent = `${coinsEquivalent} coins`;
                    }
                @endauth
            }

            function updatePanelQuantity(productId, newQuantity) {
                if (newQuantity < 1) return;

                // Optimistic UI update - update immediately
                const cart = JSON.parse(sessionStorage.getItem('cart') || '{}');
                const oldQuantity = cart[productId] ? cart[productId].quantity : 0;
                
                if (cart[productId]) {
                    cart[productId].quantity = newQuantity;
                    sessionStorage.setItem('cart', JSON.stringify(cart));
                    refreshCartPanel();
                }

                // Send to server in background
                fetch('/cart/update-quantity', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ product_id: productId, quantity: newQuantity })
                })
                .then(response => response.json())
                .then(data => {
                    if (!data.success) {
                        // Revert optimistic update on error
                        const cart = JSON.parse(sessionStorage.getItem('cart') || '{}');
                        if (cart[productId]) {
                            cart[productId].quantity = oldQuantity;
                            sessionStorage.setItem('cart', JSON.stringify(cart));
                            refreshCartPanel();
                        }
                        showCartNotification('Error updating quantity', 'error');
                    }
                })
                .catch(() => {
                    // Revert optimistic update on network error
                    const cart = JSON.parse(sessionStorage.getItem('cart') || '{}');
                    if (cart[productId]) {
                        cart[productId].quantity = oldQuantity;
                        sessionStorage.setItem('cart', JSON.stringify(cart));
                        refreshCartPanel();
                    }
                    showCartNotification('Error updating quantity', 'error');
                });
            }

            function removeFromCartPanel(productId) {
                // Optimistic UI update - remove immediately
                const cart = JSON.parse(sessionStorage.getItem('cart') || '{}');
                const removedItem = cart[productId];
                delete cart[productId];
                sessionStorage.setItem('cart', JSON.stringify(cart));
                
                // Count unique items for badge
                const newCount = Object.keys(cart).length;
                updateCartBadge(newCount);
                refreshCartPanel();
                showCartNotification('Item removed from cart');

                // Send to server in background
                fetch('/cart/remove', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ product_id: productId })
                })
                .then(response => response.json())
                .then(data => {
                    if (!data.success) {
                        // Revert optimistic update on error
                        const cart = JSON.parse(sessionStorage.getItem('cart') || '{}');
                        if (removedItem) {
                            cart[productId] = removedItem;
                            sessionStorage.setItem('cart', JSON.stringify(cart));
                            const revertCount = Object.keys(cart).length;
                            updateCartBadge(revertCount);
                            refreshCartPanel();
                        }
                        showCartNotification('Error removing item', 'error');
                    }
                })
                .catch(() => {
                    // Revert optimistic update on network error
                    const cart = JSON.parse(sessionStorage.getItem('cart') || '{}');
                    if (removedItem) {
                        cart[productId] = removedItem;
                        sessionStorage.setItem('cart', JSON.stringify(cart));
                        const revertCount = Object.keys(cart).length;
                        updateCartBadge(revertCount);
                        refreshCartPanel();
                    }
                    showCartNotification('Error removing item', 'error');
                });
            }

            function proceedToCheckout() {
                const cart = JSON.parse(sessionStorage.getItem('cart') || '{}');
                if (Object.keys(cart).length === 0) {
                    showCartNotification('Your cart is empty!', 'error');
                    return;
                }
                @auth
                    window.location.href = '{{ route('cart.index') }}';
                @else
                    showLoginPopup();
                @endauth
            }

            function clearAllCart() {
                showClearCartPopup();
            }

            function showClearCartPopup() {
                const popup = document.createElement('div');
                popup.className = 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center';
                popup.style.zIndex = '9999999';
                popup.innerHTML = `
                    <div class="max-w-sm p-6 mx-4 bg-white rounded-lg shadow-xl dark:bg-gray-800">
                        <h3 class="mb-4 text-lg font-semibold text-gray-900 dark:text-white">Clear Cart</h3>
                        <p class="mb-6 text-gray-600 dark:text-gray-400">Are you sure you want to clear all items from your cart?</p>
                        <div class="flex gap-3">
                            <button onclick="this.closest('.fixed').remove()" class="flex-1 px-4 py-2 text-gray-700 border border-gray-300 rounded-lg dark:border-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">
                                Cancel
                            </button>
                            <button onclick="confirmClearCart(this)" class="flex-1 px-4 py-2 text-white bg-red-600 rounded-lg hover:bg-red-700">
                                Clear Cart
                            </button>
                        </div>
                    </div>
                `;
                popup.onclick = (e) => { if (e.target === popup) popup.remove(); };
                document.body.appendChild(popup);
            }

            function confirmClearCart(button) {
                fetch('/cart/clear', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        sessionStorage.removeItem('cart');
                        updateCartBadge(0);
                        refreshCartPanel();
                        showCartNotification('Cart cleared successfully');
                    }
                })
                .catch(() => showCartNotification('Error clearing cart', 'error'));
                button.closest('.fixed').remove();
            }

            function showLoginPopup() {
                const popup = document.createElement('div');
                popup.className = 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center';
                popup.style.zIndex = '9999999';
                popup.innerHTML = `
                    <div class="max-w-sm p-6 mx-4 bg-white rounded-lg shadow-xl dark:bg-gray-800">
                        <h3 class="mb-4 text-lg font-semibold text-gray-900 dark:text-white">Login Required</h3>
                        <p class="mb-6 text-gray-600 dark:text-gray-400">For you to check out you need to be logged in as a user</p>
                        <button onclick="proceedToLogin(this)" class="w-full px-4 py-2 text-white bg-blue-600 rounded-lg hover:bg-blue-700">
                            Okay Continue
                        </button>
                    </div>
                `;
                popup.onclick = (e) => { if (e.target === popup) popup.remove(); };
                document.body.appendChild(popup);
            }

            function proceedToLogin(button) {
                window.location.href = '/login?redirect=' + encodeURIComponent('{{ route('cart.index') }}');
                button.closest('.fixed').remove();
            }

            function syncGuestCart() {
                const guestCart = JSON.parse(sessionStorage.getItem('cart') || '{}');
                if (Object.keys(guestCart).length > 0) {
                    fetch('/cart/sync', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    })
                    .then(response => {
                        if (!response.ok) throw new Error('Network response was not ok');
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            sessionStorage.removeItem('cart');
                            updateCartBadge(data.cart_count);
                        } else {
                            console.warn('Cart sync failed:', data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Cart sync error:', error);
                        loadCartCount(); // Fallback to loading count
                    });
                } else {
                    loadCartCount();
                }
            }

            function openMobileMenu() {
                document.getElementById('mobileMenuSidebar').classList.remove('-translate-x-full');
                document.getElementById('mobileMenuOverlay').classList.remove('hidden');
                document.body.style.overflow = 'hidden';
                updateMobileMenuCartBadge();
            }

            function closeMobileMenu() {
                document.getElementById('mobileMenuSidebar').classList.add('-translate-x-full');
                document.getElementById('mobileMenuOverlay').classList.add('hidden');
                document.body.style.overflow = 'auto';
            }

            function updateMobileMenuCartBadge() {
                fetch('/cart/count')
                    .then(response => response.json())
                    .then(data => {
                        const badge = document.getElementById('sidebarCartBadge');
                        if (badge) {
                            if (data.count > 0) {
                                badge.textContent = data.count > 99 ? '99+' : data.count;
                                badge.style.display = 'inline-block';
                            } else {
                                badge.style.display = 'none';
                            }
                        }
                    })
                    .catch(() => {});
            }

            function showCartNotification(message, type = 'success') {
                const notification = document.createElement('div');
                notification.className = `fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg ${
                    type === 'success' ? 'bg-green-500' : 'bg-red-500'
                } text-white max-w-sm`;
                notification.innerHTML = `
                    <div class="flex items-center">
                        <i class="fas fa-${type === 'success' ? 'check' : 'exclamation-triangle'} mr-2"></i>
                        <span>${message}</span>
                        <button onclick="this.parentElement.parentElement.remove()" class="ml-2 text-white hover:text-gray-200">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                `;
                document.body.appendChild(notification);
                setTimeout(() => notification.remove(), 3000);
            }

            // Chat function wrapper
            function openChat(userId, userName, userAvatar, contextType, contextName) {
                const context = contextType === 'store' ? `Store: ${contextName}` : 
                              contextType === 'product' ? `Product: ${contextName}` : contextName;
                
                if (typeof openChatModal === 'function') {
                    openChatModal(userId, userName, userAvatar, context);
                } else {
                    console.error('Chat modal not loaded');
                }
            }
        </script>
    </body>
</html>
