<x-affiliate-layout>
    <div class="p-6">
        <div class="mb-6">
            <a href="{{ route('affiliate.orders.index') }}" class="text-blue-600 hover:text-blue-800">← Back to Orders</a>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <div class="flex justify-between items-start mb-6">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Order No: {{ $order->order_number }}</h1>
                    <p class="text-gray-600 dark:text-gray-400">Store Order</p>
                </div>
                <div class="text-right">
                    <div class="text-2xl font-bold text-gray-900 dark:text-white">${{ number_format($order->total_amount, 2) }}</div>
                    <div class="text-sm text-gray-600 dark:text-gray-400">{{ $order->total_coins_used }} coins</div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div>
                    <h3 class="font-semibold text-gray-900 dark:text-white mb-2">Customer</h3>
                    <p class="text-gray-600 dark:text-gray-400">{{ $order->user->name }}</p>
                    <p class="text-gray-600 dark:text-gray-400">{{ $order->user->email }}</p>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-900 dark:text-white mb-2">Order Status</h3>
                    @php
                        $items = collect($order->order_data['items'] ?? []);
                        $digitalItems = $items->filter(fn($item) => ($item['product_snapshot']['type'] ?? 'physical') === 'digital');
                        $physicalItems = $items->filter(fn($item) => ($item['product_snapshot']['type'] ?? 'physical') === 'physical');
                        
                        $isDigitalOnly = $physicalItems->isEmpty() && $digitalItems->isNotEmpty();
                        $isMixed = $digitalItems->isNotEmpty() && $physicalItems->isNotEmpty();
                    @endphp
                    
                    @if($isDigitalOnly)
                        <span class="px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                            Completed (Digital)
                        </span>
                    @else
                        <button onclick="openOrderStatusModal()" 
                                class="px-3 py-1 rounded-full text-sm font-medium border-2 border-blue-500 text-blue-600 hover:bg-blue-50
                                @if($order->status === 'pending') bg-yellow-100 text-yellow-800 border-yellow-500
                                @elseif($order->status === 'confirmed') bg-blue-100 text-blue-800 border-blue-500
                                @elseif($order->status === 'processing') bg-purple-100 text-purple-800 border-purple-500
                                @elseif($order->status === 'shipped') bg-indigo-100 text-indigo-800 border-indigo-500
                                @elseif($order->status === 'delivered') bg-green-100 text-green-800 border-green-500
                                @elseif($order->status === 'completed') bg-gray-100 text-gray-800 border-gray-500
                                @endif">
                            {{ ucfirst($order->status) }} <i class="fas fa-edit ml-1"></i>
                        </button>
                        @if($isMixed)
                            <span class="ml-2 text-xs text-gray-500">(Mixed Order)</span>
                        @endif
                    @endif
                </div>
                <div>
                    <h3 class="font-semibold text-gray-900 dark:text-white mb-2">Order Date</h3>
                    <p class="text-gray-600 dark:text-gray-400">{{ $order->created_at->format('M j, Y g:i A') }}</p>
                </div>
            </div>

            @if(isset($order->order_data['items']))
                <div class="mb-6">
                    <h3 class="font-semibold text-gray-900 dark:text-white mb-4">Items</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Product</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Type</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Quantity</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Unit Price</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Total</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Product ID</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Action</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($order->order_data['items'] as $item)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                @if(isset($item['product_snapshot']['images'][0]))
                                                    <img src="{{ $item['product_snapshot']['images'][0] }}" alt="{{ $item['product_snapshot']['name'] }}" class="w-12 h-12 object-cover rounded mr-4">
                                                @endif
                                                <div>
                                                    <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $item['product_snapshot']['name'] }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if(isset($item['product_snapshot']['type']))
                                                @if($item['product_snapshot']['type'] === 'digital')
                                                    <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs">
                                                        Digital
                                                    </span>
                                                @else
                                                    <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">
                                                        Physical
                                                    </span>
                                                @endif
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if(isset($item['product_snapshot']['type']) && $item['product_snapshot']['type'] === 'digital')
                                                <span class="px-2 py-1 bg-gray-100 text-gray-800 rounded-full text-xs">
                                                    Completed
                                                </span>
                                            @else
                                                @php
                                                    $productStatus = $item['seller_status'] ?? $order->status;
                                                @endphp
                                                <span class="px-2 py-1 rounded-full text-xs
                                                @if($productStatus === 'pending') bg-yellow-100 text-yellow-800
                                                @elseif($productStatus === 'confirmed') bg-blue-100 text-blue-800
                                                @elseif($productStatus === 'processing') bg-purple-100 text-purple-800
                                                @elseif($productStatus === 'shipped') bg-indigo-100 text-indigo-800
                                                @elseif($productStatus === 'delivered') bg-green-100 text-green-800
                                                @elseif($productStatus === 'completed') bg-gray-100 text-gray-800
                                                @endif">
                                                    {{ ucfirst($productStatus) }}
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">{{ $item['quantity'] }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">${{ number_format($item['unit_price'], 2) }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">${{ number_format($item['total_price'], 2) }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <button onclick="copyToClipboard('{{ $item['product_id'] ?? 'N/A' }}')"
                                                    class="text-xs text-blue-600 hover:text-blue-800 font-mono cursor-pointer hover:bg-blue-50 px-2 py-1 rounded flex items-center space-x-1"
                                                    title="Click to copy full ID">
                                                <span>{{ Str::limit($item['product_id'] ?? 'N/A', 8) }}</span>
                                                <i class="fas fa-copy text-xs"></i>
                                            </button>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if(isset($item['product_snapshot']['type']) && $item['product_snapshot']['type'] === 'digital')
                                                <span class="text-xs text-gray-500">No action needed</span>
                                            @else
                                                @php
                                                    $productStatus = $item['seller_status'] ?? $order->status;
                                                @endphp
                                                <button onclick="openProductStatusModal('{{ $loop->index }}', '{{ addslashes($item['product_snapshot']['name']) }}', '{{ $productStatus }}')" 
                                                        class="px-3 py-1 bg-blue-600 text-white text-xs rounded hover:bg-blue-700 flex items-center space-x-1">
                                                    <i class="fas fa-edit text-xs"></i>
                                                    <span>Update Status</span>
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

            @if(isset($order->order_data['delivery_snapshot']))
                <div class="mb-6">
                    <h3 class="font-semibold text-gray-900 dark:text-white mb-4">Delivery Information</h3>
                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                        <p class="font-medium">{{ $order->order_data['delivery_snapshot']['name'] }}</p>
                        <p>{{ $order->order_data['delivery_snapshot']['address'] }}</p>
                        <p>{{ $order->order_data['delivery_snapshot']['city'] }}, {{ $order->order_data['delivery_snapshot']['state'] }}</p>
                        <p>{{ $order->order_data['delivery_snapshot']['country'] }}</p>
                    </div>
                </div>
            @endif
            
            @php
                $items = collect($order->order_data['items'] ?? []);
                $hasPhysicalProducts = $items->contains(function($item) {
                    return ($item['product_snapshot']['type'] ?? 'physical') === 'physical';
                });
                $hasDigitalProducts = $items->contains(function($item) {
                    return ($item['product_snapshot']['type'] ?? 'physical') === 'digital';
                });
                $isDigitalOnly = !$hasPhysicalProducts && $hasDigitalProducts;
            @endphp
            
            @if($hasPhysicalProducts && $hasDigitalProducts)
                <!-- Mixed Order Seller Information -->
                <div class="mb-6 p-4 bg-red-50 dark:bg-red-900/20 rounded-lg border border-red-200 dark:border-red-800">
                    <h3 class="font-semibold text-red-900 dark:text-red-100 mb-2 flex items-center">
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        Important: Mixed Order Management (Physical + Digital Products)
                    </h3>
                    <div class="text-sm text-red-800 dark:text-red-200 space-y-2">
                        <div class="font-semibold text-red-900 dark:text-red-100">📦 Physical Products Management:</div>
                        <p>• <strong>Status Updates:</strong> Progress items: Pending → Confirmed → Processing → Shipped → Delivered <em>(keeps buyer informed and builds trust)</em></p>
                        <p>• <strong>Payment Hold:</strong> Payment is held until buyer confirms receipt <em>(ensures delivery before payment release)</em></p>
                        <p>• <strong>Shipping Protection:</strong> Once marked "Shipped", buyer cannot cancel <em>(protects you from shipping losses)</em></p>
                        <p>• <strong>Communication:</strong> Keep buyers updated on shipping progress <em>(reduces disputes and chargebacks)</em></p>
                        
                        <div class="font-semibold text-red-900 dark:text-red-100 mt-3">💾 Digital Products Management:</div>
                        <p>• <strong>Auto-Delivered:</strong> Digital items were delivered instantly to buyer <em>(no action needed from you)</em></p>
                        <p>• <strong>Payment Received:</strong> Payment for digital items already transferred to your account <em>(instant revenue)</em></p>
                        <p>• <strong>Support Only:</strong> Only contact buyer if they have download issues <em>(maintain good customer service)</em></p>
                    </div>
                </div>
            @elseif($hasPhysicalProducts)
                <!-- Physical Only Seller Information -->
                <div class="mb-6 p-4 bg-red-50 dark:bg-red-900/20 rounded-lg border border-red-200 dark:border-red-800">
                    <h3 class="font-semibold text-red-900 dark:text-red-100 mb-2 flex items-center">
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        Important: Physical Products Management
                    </h3>
                    <div class="text-sm text-red-800 dark:text-red-200 space-y-1">
                        <p>• <strong>Status Updates:</strong> Progress items: Pending → Confirmed → Processing → Shipped → Delivered <em>(keeps buyer informed and builds trust)</em></p>
                        <p>• <strong>Payment Hold:</strong> Payment is held until buyer confirms receipt <em>(ensures delivery before payment release)</em></p>
                        <p>• <strong>Shipping Protection:</strong> Once marked "Shipped", buyer cannot cancel <em>(protects you from shipping losses)</em></p>
                        <p>• <strong>Communication:</strong> Keep buyers updated on shipping progress <em>(reduces disputes and chargebacks)</em></p>
                    </div>
                </div>
            @elseif($isDigitalOnly)
                <!-- Digital Only Seller Information -->
                <div class="mb-6 p-4 bg-green-50 dark:bg-green-900/20 rounded-lg border border-green-200 dark:border-green-800">
                    <h3 class="font-semibold text-green-900 dark:text-green-100 mb-2 flex items-center">
                        Digital Products Order - Completed
                    </h3>
                    <div class="text-sm text-green-800 dark:text-green-200 space-y-1">
                        <p>• <strong>Auto-Delivered:</strong> Digital products were delivered instantly to buyer <em>(no shipping needed)</em></p>
                        <p>• <strong>Payment Received:</strong> Payment automatically transferred to your account <em>(instant revenue)</em></p>
                        <p>• <strong>No Action Required:</strong> Digital orders are fully automated <em>(saves you time and effort)</em></p>
                        <p>• <strong>Customer Support:</strong> Only contact buyer if they have download issues <em>(maintain good customer service)</em></p>
                    </div>
                </div>
            @endif
            
            <div class="flex justify-end">
                <button onclick="openChatModal('{{ $order->user->id }}', '{{ $order->user->name }}', '{{ $order->user->profile_photo_url }}', 'Order #{{ $order->order_number }}', '{{ $order->id }}')" 
                        class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 flex items-center space-x-2">
                    <i class="fas fa-comment"></i>
                    <span>Message Buyer</span>
                </button>
            </div>
        </div>
    </div>
    
    <!-- Order Status Modal -->
    <div id="orderStatusModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-[9999]">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Update Order Status</h3>
                    <div class="space-y-3">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Select Status:</label>
                        <select id="orderStatusSelect" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Choose a status...</option>
                            <option value="pending">Pending</option>
                            <option value="confirmed">Confirmed</option>
                            <option value="processing">Processing</option>
                            <option value="shipped">Shipped</option>
                            <option value="delivered">Delivered</option>
                        </select>
                    </div>
                    <div class="flex justify-end space-x-3 mt-6">
                        <button onclick="closeOrderStatusModal()" class="px-4 py-2 text-gray-600 border rounded-lg hover:bg-gray-50">Cancel</button>
                        <button onclick="updateOrderStatus()" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Update</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Product Status Modal -->
    <div id="productStatusModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-[9999]">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Update Status for <span id="productStatusName"></span></h3>
                    <div class="space-y-3">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Select Status:</label>
                        <select id="productStatusSelect" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Choose a status...</option>
                            <option value="pending">Pending</option>
                            <option value="confirmed">Confirmed</option>
                            <option value="processing">Processing</option>
                            <option value="shipped">Shipped</option>
                            <option value="delivered">Delivered</option>
                        </select>
                    </div>
                    <div class="flex justify-end space-x-3 mt-6">
                        <button onclick="closeProductStatusModal()" class="px-4 py-2 text-gray-600 border rounded-lg hover:bg-gray-50">Cancel</button>
                        <button onclick="updateProductStatus()" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Update</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        let currentProductIndex = null;

        function openOrderStatusModal() {
            document.getElementById('orderStatusSelect').value = '{{ $order->status }}';
            document.getElementById('orderStatusModal').classList.remove('hidden');
        }

        function closeOrderStatusModal() {
            document.getElementById('orderStatusModal').classList.add('hidden');
            document.getElementById('orderStatusSelect').value = '';
        }

        function openProductStatusModal(index, productName, currentStatus) {
            currentProductIndex = index;
            document.getElementById('productStatusName').textContent = productName;
            document.getElementById('productStatusSelect').value = currentStatus;
            document.getElementById('productStatusModal').classList.remove('hidden');
        }

        function closeProductStatusModal() {
            document.getElementById('productStatusModal').classList.add('hidden');
            document.getElementById('productStatusSelect').value = '';
            currentProductIndex = null;
        }

        function updateOrderStatus() {
            const selectedStatus = document.getElementById('orderStatusSelect').value;
            if (!selectedStatus) {
                showToast('Please select a status', 'error');
                return;
            }

            fetch(`/affiliate-orders/{{ $order->id }}/update-status`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ status: selectedStatus })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showToast('Order status updated successfully!', 'success');
                    setTimeout(() => window.location.reload(), 1000);
                } else {
                    showToast('Failed to update order status: ' + data.message, 'error');
                }
            })
            .catch(error => {
                showToast('Error updating order status', 'error');
            });

            closeOrderStatusModal();
        }

        function updateProductStatus() {
            const selectedStatus = document.getElementById('productStatusSelect').value;
            if (!selectedStatus || currentProductIndex === null) {
                showToast('Please select a status', 'error');
                return;
            }

            fetch(`/affiliate-orders/{{ $order->id }}/update-product-status`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ 
                    product_index: currentProductIndex,
                    status: selectedStatus 
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showToast('Product status updated successfully!', 'success');
                    setTimeout(() => window.location.reload(), 1000);
                } else {
                    showToast('Failed to update product status: ' + data.message, 'error');
                }
            })
            .catch(error => {
                showToast('Error updating product status', 'error');
            });

            closeProductStatusModal();
        }

        function showToast(message, type = 'info') {
            const toast = document.createElement('div');
            toast.className = `fixed top-4 right-4 px-4 py-2 rounded-lg text-white z-50 ${
                type === 'success' ? 'bg-green-500' : 
                type === 'error' ? 'bg-red-500' : 'bg-blue-500'
            }`;
            toast.textContent = message;
            document.body.appendChild(toast);
            
            setTimeout(() => {
                toast.remove();
            }, 3000);
        }

        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(function() {
                showToast('Product ID copied to clipboard!', 'success');
            }).catch(function() {
                const textArea = document.createElement('textarea');
                textArea.value = text;
                document.body.appendChild(textArea);
                textArea.select();
                document.execCommand('copy');
                document.body.removeChild(textArea);
                showToast('Product ID copied to clipboard!', 'success');
            });
        }
    </script>
    @endpush
</x-affiliate-layout>