<x-app-layout>
    <div class="container p-4 mx-auto max-w-4xl">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm min-h-[70vh]">
            <div class="flex items-center justify-between p-4 border-b border-gray-200 dark:border-gray-700">
                <h1 class="text-xl font-semibold text-gray-900 dark:text-white">Shopping Cart</h1>
                <i class="fas fa-shopping-cart text-gray-500 dark:text-gray-400"></i>
            </div>
            
            <div id="cartItems" class="divide-y divide-gray-200 dark:divide-gray-700">
                <!-- Cart items will be populated by JavaScript -->
            </div>
            
            <div id="cartEmpty" class="text-center py-16 hidden">
                <i class="fas fa-shopping-cart text-4xl text-gray-400 mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">Your cart is empty</h3>
                <p class="text-gray-500 dark:text-gray-400">Add some items to get started</p>
            </div>
            
            @auth
            <!-- Address Section -->
            <div id="addressSection" class="border-t border-gray-200 dark:border-gray-700 p-4 bg-gray-50 dark:bg-gray-700 hidden">
                <div class="mb-4">
                    <h3 class="font-medium text-gray-900 dark:text-white mb-3">Delivery Address</h3>
                    <div class="mb-3">
                        <p class="text-xs text-blue-600 dark:text-blue-400 mb-1">
                            <i class="fas fa-info-circle mr-1"></i>
                            Physical products detected - delivery address required
                        </p>
                        <p id="addressInstruction" class="text-xs text-gray-500 dark:text-gray-400">
                            Click + to add your delivery address
                        </p>
                    </div>
                    
                    <div class="flex gap-3 mb-4 flex-wrap" id="addressBoxes">
                        <div onclick="showDeliveryAddressModal()" class="w-24 h-16 border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg flex items-center justify-center cursor-pointer hover:border-blue-500 dark:hover:border-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-colors">
                            <i class="fas fa-plus text-gray-400 text-xl"></i>
                        </div>
                    </div>
                </div>
                
                <!-- Shipping Cost -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Shipping Cost (USD)
                    </label>
                    <input type="number" id="shippingCost" step="0.01" min="0" value="0" 
                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                </div>
            </div>
            @endauth
            
            <div id="cartSummary" class="border-t border-gray-200 dark:border-gray-700 p-4 bg-gray-50 dark:bg-gray-700 hidden">
                <div class="space-y-2 mb-4">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600 dark:text-gray-400">Subtotal:</span>
                        <span id="cartSubtotal" class="font-medium text-gray-900 dark:text-white">$0.00</span>
                    </div>
                    @auth
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600 dark:text-gray-400">Shipping:</span>
                        <span id="cartShipping" class="font-medium text-gray-900 dark:text-white">$0.00</span>
                    </div>
                    @endauth
                    <div class="flex justify-between text-lg font-semibold border-t border-gray-200 dark:border-gray-600 pt-2">
                        <span class="text-gray-900 dark:text-white">Total:</span>
                        <span id="cartTotal" class="text-gray-900 dark:text-white">$0.00</span>
                    </div>
                    @auth
                        <div class="text-center">
                            <span id="cartCoins" class="text-xs text-gray-500 dark:text-gray-400">0 coins</span>
                        </div>
                    @endauth
                </div>
                
                <div class="flex gap-3">
                    <button onclick="clearCart()" class="flex-1 bg-gray-200 dark:bg-gray-600 text-gray-800 dark:text-gray-200 py-2 px-4 rounded-lg font-medium hover:bg-gray-300 dark:hover:bg-gray-500 transition-colors">
                        Clear Cart
                    </button>
                    <button onclick="proceedToCheckout()" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-lg font-medium transition-colors">
                        Checkout
                    </button>
                </div>
            </div>
        </div>
    </div>

    @auth
        <x-modals.delivery-address-modal />
    @endauth

    @push('scripts')
    <script>
        let cartItems = [];

        function loadCart() {
            @auth
                // For authenticated users, get cart from server
                fetch('/cart', {
                    headers: {
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        cartItems = data.items;
                        renderCart();
                        updateCartBadge(cartItems.length);
                    }
                });
            @else
                // For guests, use session storage
                const sessionCart = JSON.parse(sessionStorage.getItem('cart') || '{}');
                cartItems = Object.values(sessionCart);
                renderCart();
                updateCartBadge(cartItems.length);
            @endauth
        }

        function renderCart() {
            const cartItemsContainer = document.getElementById('cartItems');
            const cartEmpty = document.getElementById('cartEmpty');
            const cartSummary = document.getElementById('cartSummary');
            
            if (cartItems.length === 0) {
                cartItemsContainer.innerHTML = '';
                cartEmpty.classList.remove('hidden');
                cartSummary.classList.add('hidden');
                @auth
                    document.getElementById('addressSection').classList.add('hidden');
                @endauth
                return;
            }
            
            cartEmpty.classList.add('hidden');
            cartSummary.classList.remove('hidden');
            @auth
                // Show address section only if there are physical products
                const hasPhysicalProducts = cartItems.some(item => item.type === 'physical');
                if (hasPhysicalProducts) {
                    document.getElementById('addressSection').classList.remove('hidden');
                } else {
                    document.getElementById('addressSection').classList.add('hidden');
                }
            @endauth
            
            cartItemsContainer.innerHTML = cartItems.map(item => `
                <div class="p-4 flex items-center space-x-4">
                    <div class="w-16 h-16 bg-gray-200 dark:bg-gray-600 rounded-lg flex items-center justify-center">
                        ${item.image ? 
                            `<img src="${item.image}" alt="${item.name}" class="w-full h-full object-cover rounded-lg">` :
                            `<i class="fas fa-box text-gray-400 text-xl"></i>`
                        }
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="font-medium text-gray-900 dark:text-white truncate">${item.name}</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">by ${item.store_name}</p>
                        <p class="text-sm font-medium text-blue-600 dark:text-blue-400">$${parseFloat(item.price).toFixed(2)}</p>
                        <div class="flex items-center mt-2 space-x-1">
                            <button onclick="updateQuantity('${item.id}', ${item.quantity - 1})" class="w-6 h-6 flex items-center justify-center bg-gray-200 dark:bg-gray-600 text-gray-700 dark:text-gray-300 rounded hover:bg-gray-300 dark:hover:bg-gray-500" ${item.quantity <= 1 ? 'disabled' : ''}>
                                <i class="fas fa-minus" style="font-size: 8px;"></i>
                            </button>
                            <span class="px-2 py-1 bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white rounded text-xs font-medium min-w-[24px] text-center">${item.quantity}</span>
                            <button onclick="updateQuantity('${item.id}', ${item.quantity + 1})" class="w-6 h-6 flex items-center justify-center bg-gray-200 dark:bg-gray-600 text-gray-700 dark:text-gray-300 rounded hover:bg-gray-300 dark:hover:bg-gray-500">
                                <i class="fas fa-plus" style="font-size: 8px;"></i>
                            </button>
                        </div>
                    </div>
                    <button onclick="removeFromCart('${item.id}')" class="text-red-500 hover:text-red-700 p-2">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            `).join('');
            
            updateTotals();
        }

        function updateTotals() {
            const subtotal = cartItems.reduce((sum, item) => sum + (parseFloat(item.price) * item.quantity), 0);
            @auth
                const shippingCost = parseFloat(document.getElementById('shippingCost')?.value || 0);
                const total = subtotal + shippingCost;
                
                document.getElementById('cartShipping').textContent = `$${shippingCost.toFixed(2)}`;
            @else
                const total = subtotal;
            @endauth
            
            document.getElementById('cartSubtotal').textContent = `$${subtotal.toFixed(2)}`;
            document.getElementById('cartTotal').textContent = `$${total.toFixed(2)}`;
            
            @auth
                const coinsEquivalent = Math.ceil(total * 100); // Assuming 1 USD = 100 coins
                document.getElementById('cartCoins').textContent = `${coinsEquivalent} coins`;
            @endauth
        }
        
        @auth
        // Update totals when shipping cost changes
        document.addEventListener('DOMContentLoaded', function() {
            const shippingInput = document.getElementById('shippingCost');
            if (shippingInput) {
                shippingInput.addEventListener('input', updateTotals);
            }
        });
        @endauth

        function updateQuantity(productId, newQuantity) {
            if (newQuantity < 1) return;
            
            // Optimistic UI update - update immediately
            const item = cartItems.find(item => item.id == productId);
            const oldQuantity = item ? item.quantity : 0;
            
            if (item) {
                item.quantity = newQuantity;
                renderCart();
                
                // Update session storage for guests
                @guest
                    const sessionCart = JSON.parse(sessionStorage.getItem('cart') || '{}');
                    if (sessionCart[productId]) {
                        sessionCart[productId].quantity = newQuantity;
                        sessionStorage.setItem('cart', JSON.stringify(sessionCart));
                    }
                @endguest
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
                    if (item) {
                        item.quantity = oldQuantity;
                        renderCart();
                        
                        @guest
                            const sessionCart = JSON.parse(sessionStorage.getItem('cart') || '{}');
                            if (sessionCart[productId]) {
                                sessionCart[productId].quantity = oldQuantity;
                                sessionStorage.setItem('cart', JSON.stringify(sessionCart));
                            }
                        @endguest
                    }
                }
            })
            .catch(() => {
                // Revert optimistic update on network error
                if (item) {
                    item.quantity = oldQuantity;
                    renderCart();
                    
                    @guest
                        const sessionCart = JSON.parse(sessionStorage.getItem('cart') || '{}');
                        if (sessionCart[productId]) {
                            sessionCart[productId].quantity = oldQuantity;
                            sessionStorage.setItem('cart', JSON.stringify(sessionCart));
                        }
                    @endguest
                }
            });
        }

        function removeFromCart(productId) {
            // Optimistic UI update - remove immediately
            const removedItem = cartItems.find(item => item.id == productId);
            cartItems = cartItems.filter(item => item.id != productId);
            renderCart();
            
            // Update session storage for guests
            @guest
                const sessionCart = JSON.parse(sessionStorage.getItem('cart') || '{}');
                delete sessionCart[productId];
                sessionStorage.setItem('cart', JSON.stringify(sessionCart));
            @endguest
            
            updateCartBadge(cartItems.length);
            
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
                    if (removedItem) {
                        cartItems.push(removedItem);
                        renderCart();
                        
                        @guest
                            const sessionCart = JSON.parse(sessionStorage.getItem('cart') || '{}');
                            sessionCart[productId] = removedItem;
                            sessionStorage.setItem('cart', JSON.stringify(sessionCart));
                        @endguest
                        
                        updateCartBadge(cartItems.length);
                    }
                }
            })
            .catch(() => {
                // Revert optimistic update on network error
                if (removedItem) {
                    cartItems.push(removedItem);
                    renderCart();
                    
                    @guest
                        const sessionCart = JSON.parse(sessionStorage.getItem('cart') || '{}');
                        sessionCart[productId] = removedItem;
                        sessionStorage.setItem('cart', JSON.stringify(sessionCart));
                    @endguest
                    
                    updateCartBadge(cartItems.length);
                }
            });
        }

        function clearCart() {
            showClearCartPopup();
        }
        
        function showClearCartPopup() {
            const popup = document.createElement('div');
            popup.className = 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center';
            popup.style.zIndex = '9999999';
            popup.innerHTML = `
                <div class="bg-white dark:bg-gray-800 rounded-lg p-6 max-w-sm mx-4 shadow-xl">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Clear Cart</h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-6">Are you sure you want to clear all items from your cart?</p>
                    <div class="flex gap-3">
                        <button onclick="this.closest('.fixed').remove()" class="flex-1 px-4 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700">
                            Cancel
                        </button>
                        <button onclick="confirmClearCart(this)" class="flex-1 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
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
                    loadCart();
                }
            });
            button.closest('.fixed').remove();
        }

        function proceedToCheckout() {
            if (cartItems.length === 0) {
                alert('Your cart is empty!');
                return;
            }
            @auth
                // Check if there are physical products that need delivery address
                const hasPhysicalProducts = cartItems.some(item => item.type === 'physical');
                if (hasPhysicalProducts) {
                    if (!selectedAddressId) {
                        alert('Please select a delivery address for physical products.');
                        return;
                    }
                }
                
                proceedWithCheckout();
        }
        
        function proceedWithCheckout() {
            const hasPhysicalProducts = cartItems.some(item => item.type === 'physical');
            const subtotal = cartItems.reduce((sum, item) => sum + (parseFloat(item.price) * item.quantity), 0);
            const shippingCost = hasPhysicalProducts ? parseFloat(document.getElementById('shippingCost')?.value || 0) : 0;
            const total = subtotal + shippingCost;
            const coinsNeeded = Math.ceil(total * 100);
            
            // Check user's coin balance
            fetch('/user/coin-balance')
                .then(response => response.json())
                .then(data => {
                    if (data.balance >= coinsNeeded) {
                        showCheckoutModal();
                    } else {
                        showInsufficientCoinsPopup(data.balance, coinsNeeded);
                    }
                })
                .catch(() => {
                    alert('Error checking coin balance. Please try again.');
                });
            @else
                window.location.href = '/login?redirect=' + encodeURIComponent('{{ route('cart.index') }}');
            @endauth
        }
        
        @auth
        function showInsufficientCoinsPopup(currentBalance, coinsNeeded) {
            const shortfall = coinsNeeded - currentBalance;
            const popup = document.createElement('div');
            popup.className = 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50';
            popup.innerHTML = `
                <div class="bg-white dark:bg-gray-800 rounded-lg p-6 max-w-sm mx-4 shadow-xl">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Insufficient Balance</h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-4">You don't have enough coins in your spendable wallet to complete this purchase.</p>
                    <div class="mb-4 space-y-2">
                        <div class="bg-gray-50 dark:bg-gray-700 p-3 rounded-lg">
                            <p class="text-sm text-gray-500 dark:text-gray-400">Spendable Balance: <span class="font-medium text-gray-900 dark:text-white">${currentBalance.toLocaleString()} coins</span></p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Required: <span class="font-medium text-red-600">${coinsNeeded.toLocaleString()} coins</span></p>
                            <p class="text-sm text-red-600 font-medium">Shortfall: ${shortfall.toLocaleString()} coins</p>
                        </div>
                    </div>
                    <div class="flex gap-3">
                        <button onclick="this.closest('.fixed').remove()" class="flex-1 px-4 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700">
                            Cancel
                        </button>
                        <a href="{{ route('coin-packages.index') }}" class="flex-1 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-center">
                            Buy Coins
                        </a>
                    </div>
                </div>
            `;
            popup.onclick = (e) => { if (e.target === popup) popup.remove(); };
            document.body.appendChild(popup);
        }
        @endauth

        function updateCartBadge(count) {
            const cartBadge = document.getElementById('cartBadge');
            if (cartBadge) {
                if (count > 0) {
                    cartBadge.textContent = count > 99 ? '99+' : count;
                    cartBadge.style.display = 'flex';
                } else {
                    cartBadge.style.display = 'none';
                }
            }
        }
        
        let selectedAddressId = null;
        
        function updateAddressDisplay() {
            fetch('/delivery-details')
                .then(response => response.json())
                .then(data => {
                    const container = document.getElementById('addressBoxes');
                    const instruction = document.getElementById('addressInstruction');
                    
                    if (data.success && data.addresses.length > 0 && container) {
                        // Update instruction for existing addresses
                        instruction.textContent = 'Select an existing address or click + to add a new one';
                        
                        // Clear existing addresses (keep only the plus button)
                        const plusButton = container.querySelector('.fa-plus').closest('div');
                        container.innerHTML = '';
                        
                        // Add address boxes
                        data.addresses.forEach((addr, index) => {
                            const isSelected = selectedAddressId === addr.id || (selectedAddressId === null && addr.is_default);
                            if (isSelected && selectedAddressId === null) selectedAddressId = addr.id;
                            
                            const addressBox = document.createElement('div');
                            addressBox.className = `relative w-24 h-16 border-2 rounded-lg p-2 cursor-pointer transition-colors flex flex-col justify-center ${
                                isSelected 
                                    ? 'border-blue-500 bg-blue-50 dark:bg-blue-900/20' 
                                    : 'border-gray-300 dark:border-gray-600 hover:border-blue-400 hover:bg-gray-50 dark:hover:bg-gray-700'
                            }`;
                            addressBox.innerHTML = `
                                <button onclick="deleteAddress('${addr.id}'); event.stopPropagation();" class="absolute -top-1 -right-1 w-4 h-4 bg-red-500 text-white rounded-full text-xs flex items-center justify-center hover:bg-red-600">
                                    ×
                                </button>
                                <div onclick="viewAddressDetails('${addr.id}')" class="w-full h-full flex flex-col justify-between">
                                    <div class="flex-1 flex flex-col justify-center">
                                        <p class="text-gray-800 dark:text-gray-200 font-medium text-xs truncate">${addr.details.name}</p>
                                        <p class="text-gray-600 dark:text-gray-400 text-xs truncate">${addr.details.city}</p>
                                    </div>
                                    <button onclick="${isSelected ? 'unselectAddress()' : `selectAddress('${addr.id}')`}; event.stopPropagation();" class="w-full text-xs py-1 rounded ${
                                        isSelected 
                                            ? 'bg-blue-600 text-white hover:bg-red-500' 
                                            : 'bg-gray-200 dark:bg-gray-600 text-gray-700 dark:text-gray-300 hover:bg-blue-500 hover:text-white'
                                    }">
                                        ${isSelected ? 'Unselect' : 'Select'}
                                    </button>
                                </div>
                            `;
                            container.appendChild(addressBox);
                        });
                        
                        // Add plus button at the end
                        container.appendChild(plusButton);
                    } else {
                        // Update instruction for no addresses
                        instruction.textContent = 'Click + to add your delivery address';
                    }
                });
        }
        
        function selectAddress(addressId) {
            selectedAddressId = addressId;
            updateAddressDisplay(); // Refresh to show selection
        }
        
        function unselectAddress() {
            selectedAddressId = null;
            updateAddressDisplay(); // Refresh to show unselection
        }
        
        function editAddress(addressId) {
            // Load address data into modal for editing
            fetch(`/delivery-details/${addressId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const addr = data.address;
                        // Pre-fill the form with existing data
                        document.getElementById('addressLabel').value = addr.label;
                        document.getElementById('deliveryName').value = addr.details.name;
                        document.getElementById('deliveryEmail').value = addr.details.email;
                        document.getElementById('deliveryPhone').value = addr.details.phone || '';
                        document.getElementById('deliveryAddress').value = addr.details.address;
                        document.getElementById('deliveryCity').value = addr.details.city;
                        document.getElementById('deliveryState').value = addr.details.state;
                        document.getElementById('deliveryCountry').value = addr.details.country;
                        document.getElementById('deliveryPostal').value = addr.details.postal_code || '';
                        document.getElementById('deliveryNotes').value = addr.details.notes || '';
                        
                        // Show the modal
                        showDeliveryAddressModal();
                    }
                });
        }
        
        function viewAddressDetails(addressId) {
            fetch(`/delivery-details/${addressId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const addr = data.address;
                        const modal = document.createElement('div');
                        modal.className = 'fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center';
                        modal.innerHTML = `
                            <div class="bg-white dark:bg-gray-800 rounded-lg p-6 max-w-md mx-4 shadow-xl">
                                <div class="flex items-center justify-between mb-4">
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">${addr.label}</h3>
                                    ${addr.is_default ? '<span class="text-xs bg-green-100 text-green-800 px-2 py-1 rounded-full">Default</span>' : ''}
                                </div>
                                <div class="space-y-3 text-sm text-gray-600 dark:text-gray-300">
                                    <div class="border-b border-gray-200 dark:border-gray-700 pb-2">
                                        <p class="font-medium text-gray-900 dark:text-white">${addr.details.name}</p>
                                        <p>${addr.details.email}</p>
                                        ${addr.details.phone ? `<p>${addr.details.phone}</p>` : ''}
                                    </div>
                                    <div class="border-b border-gray-200 dark:border-gray-700 pb-2">
                                        <p class="font-medium text-gray-900 dark:text-white mb-1">Delivery Address:</p>
                                        <p>${addr.details.address}</p>
                                        <p>${addr.details.city}, ${addr.details.state}</p>
                                        <p>${addr.details.country}${addr.details.postal_code ? ` - ${addr.details.postal_code}` : ''}</p>
                                    </div>
                                    ${addr.details.notes ? `
                                        <div>
                                            <p class="font-medium text-gray-900 dark:text-white mb-1">Special Instructions:</p>
                                            <p class="text-xs bg-gray-50 dark:bg-gray-700 p-2 rounded">${addr.details.notes}</p>
                                        </div>
                                    ` : ''}
                                </div>
                                <div class="flex gap-3 mt-6">
                                    <button onclick="this.closest('.fixed').remove()" class="flex-1 px-4 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700">
                                        Close
                                    </button>
                                    <button onclick="editAddress('${addr.id}'); this.closest('.fixed').remove();" class="flex-1 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                                        Edit
                                    </button>
                                </div>
                            </div>
                        `;
                        modal.onclick = (e) => { if (e.target === modal) modal.remove(); };
                        document.body.appendChild(modal);
                    }
                });
        }
        
        function deleteAddress(addressId) {
            if (confirm('Are you sure you want to delete this address?')) {
                fetch(`/delivery-details/${addressId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        if (selectedAddressId === addressId) {
                            selectedAddressId = null;
                        }
                        updateAddressDisplay();
                    } else {
                        alert('Error deleting address');
                    }
                })
                .catch(() => {
                    alert('Error deleting address');
                });
            }
        }


        
        function showCheckoutModal() {
            const subtotal = cartItems.reduce((sum, item) => sum + (parseFloat(item.price) * item.quantity), 0);
            const shippingCost = parseFloat(document.getElementById('shippingCost').value || 0);
            const total = subtotal + shippingCost;
            const coinsNeeded = Math.ceil(total * 100);
            
            const modal = document.createElement('div');
            modal.className = 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-[9999]';
            modal.innerHTML = `
                <div class="bg-white dark:bg-gray-800 rounded-lg p-6 max-w-md mx-4 shadow-xl">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Confirm Order</h3>
                    <div class="space-y-2 mb-4">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600 dark:text-gray-400">Subtotal:</span>
                            <span class="font-medium text-gray-900 dark:text-white">$${subtotal.toFixed(2)}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600 dark:text-gray-400">Shipping:</span>
                            <span class="font-medium text-gray-900 dark:text-white">$${shippingCost.toFixed(2)}</span>
                        </div>
                        <div class="flex justify-between text-lg font-semibold border-t border-gray-200 dark:border-gray-600 pt-2">
                            <span class="text-gray-900 dark:text-white">Total:</span>
                            <span class="text-gray-900 dark:text-white">$${total.toFixed(2)} (${coinsNeeded} coins)</span>
                        </div>
                    </div>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-6">Your order will be processed and sellers will be notified.</p>
                    <div class="flex gap-3">
                        <button onclick="this.closest('.fixed').remove()" class="flex-1 px-4 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700">
                            Cancel
                        </button>
                        <button onclick="confirmCheckout(this)" class="flex-1 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                            Place Order
                        </button>
                    </div>
                </div>
            `;
            modal.onclick = (e) => { if (e.target === modal) modal.remove(); };
            document.body.appendChild(modal);
        }
        
        function confirmCheckout(button) {
            button.disabled = true;
            button.textContent = 'Processing...';
            
            // Get delivery address from database
            fetch('/delivery-details')
                .then(response => response.json())
                .then(addressResponse => {
                    let addressData;
                    if (addressResponse.success && addressResponse.addresses.length > 0 && selectedAddressId) {
                        const selectedAddr = addressResponse.addresses.find(addr => addr.id === selectedAddressId);
                        if (selectedAddr) {
                            addressData = selectedAddr.details;
                        } else {
                            alert('Selected address not found. Please select a valid address.');
                            return;
                        }
                    } else {
                        // Check if we have physical products
                        const hasPhysicalProducts = cartItems.some(item => item.type === 'physical');
                        if (hasPhysicalProducts) {
                            addressData = {
                                name: '{{ auth()->user()->name }}',
                                email: '{{ auth()->user()->email }}',
                                phone: '',
                                address: '{{ auth()->user()->address ?? "" }}',
                                city: '',
                                state: '{{ auth()->user()->state ?? "" }}',
                                country: '{{ auth()->user()->country ?? "" }}',
                                postal_code: '',
                                notes: ''
                            };
                        } else {
                            addressData = {
                                name: '',
                                email: '',
                                phone: '',
                                address: '',
                                city: '',
                                state: '',
                                country: '',
                                postal_code: '',
                                notes: ''
                            };
                        }
                    }
            
                    const checkoutData = {
                        shipping_cost: parseFloat(document.getElementById('shippingCost').value || 0),
                        delivery_name: addressData.name || '',
                        delivery_email: addressData.email || '',
                        delivery_phone: addressData.phone || '',
                        delivery_address: addressData.address || '',
                        delivery_city: addressData.city || '',
                        delivery_state: addressData.state || '',
                        delivery_country: addressData.country || '',
                        delivery_postal_code: addressData.postal_code || '',
                        notes: addressData.notes || ''
                    };
                    
                    fetch('/cart/checkout', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify(checkoutData)
                    })
                    .then(response => {
                        console.log('Checkout response status:', response.status);
                        if (!response.ok) {
                            throw new Error(`HTTP ${response.status}: ${response.statusText}`);
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log('Checkout response data:', data);
                        if (data.success) {
                            button.closest('.fixed').remove();
                            showSuccessModal(data.orders);
                            loadCart();
                        } else {
                            alert('Error: ' + data.message);
                            button.disabled = false;
                            button.textContent = 'Place Order';
                        }
                    })
                    .catch(error => {
                        console.error('Checkout error:', error);
                        alert('Checkout failed: ' + (error.message || 'Please try again.'));
                        button.disabled = false;
                        button.textContent = 'Place Order';
                    });
                });
        }
        
        function showSuccessModal(orderNumbers) {
            const modal = document.createElement('div');
            modal.className = 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-[9999]';
            modal.innerHTML = `
                <div class="bg-white dark:bg-gray-800 rounded-lg p-6 max-w-md mx-4 shadow-xl">
                    <div class="text-center mb-6">
                        <div class="w-16 h-16 bg-green-100 dark:bg-green-900 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-check text-2xl text-green-600 dark:text-green-400"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Order Placed Successfully!</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Your order has been confirmed and sellers have been notified.</p>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 mb-6">
                        <p class="text-sm font-medium text-gray-900 dark:text-white mb-2">Order Number${orderNumbers.length > 1 ? 's' : ''}:</p>
                        ${orderNumbers.map(orderNum => `
                            <div class="flex items-center justify-between bg-white dark:bg-gray-800 rounded px-3 py-2 mb-2 last:mb-0">
                                <span class="font-mono text-sm text-gray-900 dark:text-white">#${orderNum}</span>
                                <button onclick="copyToClipboard('${orderNum}')" class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 text-xs">
                                    <i class="fas fa-copy"></i> Copy
                                </button>
                            </div>
                        `).join('')}
                    </div>
                    <div class="flex gap-3">
                        <button onclick="this.closest('.fixed').remove()" class="flex-1 px-4 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700">
                            Continue Shopping
                        </button>
                        <a href="/orders" class="flex-1 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-center">
                            View Orders
                        </a>
                    </div>
                </div>
            `;
            modal.onclick = (e) => { if (e.target === modal) modal.remove(); };
            document.body.appendChild(modal);
        }
        
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(() => {
                // Show brief feedback
                const event = new CustomEvent('show-toast', {
                    detail: { message: 'Order number copied!', type: 'success' }
                });
                window.dispatchEvent(event);
            }).catch(() => {
                // Fallback for older browsers
                const textArea = document.createElement('textarea');
                textArea.value = text;
                document.body.appendChild(textArea);
                textArea.select();
                document.execCommand('copy');
                document.body.removeChild(textArea);
            });
        }
        
        document.addEventListener('DOMContentLoaded', function() {
            loadCart();
            updateAddressDisplay();
        });
    </script>
    @endpush
</x-app-layout>