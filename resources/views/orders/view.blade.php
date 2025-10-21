<x-app-layout>
    <div class="container p-2 sm:p-4 mx-auto max-w-6xl">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-3 sm:p-6">
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start mb-4 sm:mb-6 space-y-3 sm:space-y-0">
                <div>
                    <h1 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white">Order No: {{ $order->order_number }}</h1>
                    <p class="text-gray-600 dark:text-gray-400">{{ $order->type_display }}</p>
                </div>
                <div class="text-left sm:text-right">
                    <div class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white">${{ number_format($order->total_amount, 2) }}</div>
                    <div class="text-sm text-gray-600 dark:text-gray-400">{{ $order->total_coins_used }} coins used</div>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6 mb-4 sm:mb-6">
                <div>
                    <h3 class="font-semibold text-gray-900 dark:text-white mb-2">Order Status</h3>
                    @php
                        $items = collect($order->order_data['items'] ?? []);
                        $digitalItems = $items->filter(fn($item) => ($item['product_snapshot']['type'] ?? 'physical') === 'digital');
                        $physicalItems = $items->filter(fn($item) => ($item['product_snapshot']['type'] ?? 'physical') === 'physical');
                        
                        $isDigitalOnly = $physicalItems->isEmpty() && $digitalItems->isNotEmpty();
                        $isMixed = $digitalItems->isNotEmpty() && $physicalItems->isNotEmpty();
                    @endphp
                    <span class="px-3 py-1 rounded-full text-sm font-medium
                        @if($order->status === 'pending') bg-yellow-100 text-yellow-800
                        @elseif($order->status === 'confirmed') bg-blue-100 text-blue-800
                        @elseif($order->status === 'processing') bg-purple-100 text-purple-800
                        @elseif($order->status === 'shipped') bg-indigo-100 text-indigo-800
                        @elseif($order->status === 'delivered') bg-green-100 text-green-800
                        @elseif($order->status === 'completed') bg-gray-100 text-gray-800
                        @endif">
                        {{ ucfirst($order->status) }}@if($isDigitalOnly) (Digital)@elseif($isMixed) (Mixed)@endif
                    </span>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-900 dark:text-white mb-2">Order Date</h3>
                    <p class="text-gray-600 dark:text-gray-400">{{ $order->created_at->format('M j, Y g:i A') }}</p>
                </div>
            </div>

            @if($order->isStoreOrder() && isset($order->order_data['items']))
                <div class="mb-4 sm:mb-6">
                    <h3 class="font-semibold text-gray-900 dark:text-white mb-3 sm:mb-4">Items</h3>
                    <div class="overflow-x-auto">
                        <table class="w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-2 sm:px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider min-w-[150px]">Product</th>
                                    <th class="px-2 sm:px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider min-w-[80px]">Type</th>
                                    <th class="px-2 sm:px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider min-w-[90px]">Status</th>
                                    <th class="px-2 sm:px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider min-w-[60px]">Qty</th>
                                    <th class="px-2 sm:px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider min-w-[80px]">Price</th>
                                    <th class="px-2 sm:px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider min-w-[80px]">Total</th>
                                    <th class="px-2 sm:px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider min-w-[100px]">ID</th>
                                    <th class="px-2 sm:px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider min-w-[100px]">Action</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($order->order_data['items'] as $item)
                                    <tr>
                                        <td class="px-2 sm:px-4 py-4">
                                            <div class="flex items-center">
                                                @if(isset($item['product_snapshot']['images'][0]))
                                                    <img src="{{ $item['product_snapshot']['images'][0] }}" alt="{{ $item['product_snapshot']['name'] }}" class="w-8 h-8 sm:w-10 sm:h-10 object-cover rounded mr-2 sm:mr-3 flex-shrink-0">
                                                @endif
                                                <div class="min-w-0">
                                                    <div class="text-xs sm:text-sm font-medium text-gray-900 dark:text-white truncate">{{ $item['product_snapshot']['name'] }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-2 sm:px-4 py-4">
                                            @if(isset($item['product_snapshot']['type']))
                                                @if($item['product_snapshot']['type'] === 'digital')
                                                    <span class="px-1 sm:px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs">
                                                        Digital
                                                    </span>
                                                @else
                                                    <span class="px-1 sm:px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">
                                                        Physical
                                                    </span>
                                                @endif
                                            @endif
                                        </td>
                                        <td class="px-2 sm:px-4 py-4">
                                            @php
                                                // Get actual product status from database
                                                if ($item['product_snapshot']['type'] === 'digital') {
                                                    $productStatus = 'completed'; // Digital products auto-complete
                                                } else {
                                                    $productStatus = $item['buyer_status'] ?? 'pending';
                                                }
                                            @endphp
                                            <span class="px-1 sm:px-2 py-1 rounded-full text-xs
                                                @if($productStatus === 'pending') bg-yellow-100 text-yellow-800
                                                @elseif($productStatus === 'confirmed') bg-blue-100 text-blue-800
                                                @elseif($productStatus === 'processing') bg-purple-100 text-purple-800
                                                @elseif($productStatus === 'shipped') bg-indigo-100 text-indigo-800
                                                @elseif($productStatus === 'delivered') bg-green-100 text-green-800
                                                @elseif($productStatus === 'completed') bg-gray-100 text-gray-800
                                                @elseif($productStatus === 'cancelled') bg-red-100 text-red-800
                                                @endif">
                                                {{ ucfirst($productStatus) }}
                                            </span>
                                        </td>
                                        <td class="px-2 sm:px-4 py-4 text-xs sm:text-sm text-gray-900 dark:text-white">{{ $item['quantity'] }}</td>
                                        <td class="px-2 sm:px-4 py-4 text-xs sm:text-sm text-gray-900 dark:text-white">${{ number_format($item['unit_price'], 2) }}</td>
                                        <td class="px-2 sm:px-4 py-4 text-xs sm:text-sm font-medium text-gray-900 dark:text-white">${{ number_format($item['total_price'], 2) }}</td>
                                        <td class="px-2 sm:px-4 py-4">
                                            <button onclick="copyToClipboard('{{ $item['product_id'] ?? 'N/A' }}')"
                                                    class="text-xs text-blue-600 hover:text-blue-800 font-mono cursor-pointer hover:bg-blue-50 px-1 sm:px-2 py-1 rounded flex items-center space-x-1"
                                                    title="Click to copy full ID">
                                                <span class="truncate max-w-[60px] sm:max-w-none">{{ Str::limit($item['product_id'] ?? 'N/A', 6) }}</span>
                                                <i class="fas fa-copy text-xs flex-shrink-0"></i>
                                            </button>
                                        </td>
                                        <td class="px-2 sm:px-4 py-4">
                                            <div class="flex items-center">
                                                @if(isset($item['product_snapshot']['type']) && $item['product_snapshot']['type'] === 'digital')
                                                    <button onclick="downloadDigitalFiles('{{ $order->id }}', '{{ $loop->index }}')"
                                                            class="px-2 sm:px-3 py-1 bg-green-600 text-white text-xs rounded hover:bg-green-700 flex items-center space-x-1">
                                                        <i class="fas fa-download text-xs"></i>
                                                        <span class="hidden sm:inline">Download</span>
                                                    </button>
                                                @else
                                                    @php
                                                        $productStatus = $item['buyer_status'] ?? 'pending';
                                                    @endphp
                                                    <button onclick="openProductActionModal('{{ $loop->index }}', '{{ addslashes($item['product_snapshot']['name']) }}', '{{ $productStatus }}')" 
                                                            class="px-2 sm:px-3 py-1 text-xs rounded border-2 border-blue-500 text-blue-600 hover:bg-blue-50 flex items-center space-x-1">
                                                        <i class="fas fa-hand-pointer text-xs"></i>
                                                        <span class="hidden sm:inline">Action</span>
                                                    </button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
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
            
            @if($isDigitalOnly)
                <!-- Digital Delivery Information -->
                <div class="mb-4 sm:mb-6">
                    <h3 class="font-semibold text-gray-900 dark:text-white mb-3 sm:mb-4">Digital Delivery</h3>
                    <div class="bg-gray-50 dark:bg-gray-700 p-3 sm:p-4 rounded-lg">
                        <div class="flex items-start space-x-3">
                            <i class="fas fa-envelope text-gray-600 dark:text-gray-400 mt-1"></i>
                            <div>
                                <p class="font-medium text-gray-900 dark:text-white text-sm sm:text-base mb-2">Download Links Sent</p>
                                <p class="text-gray-600 dark:text-gray-400 text-sm mb-2">
                                    A confirmation email with download links has been sent to your email.
                                </p>
                                <p class="text-gray-600 dark:text-gray-400 text-sm">
                                    You can also download your digital files directly from this page using the download buttons in the items table above.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            @elseif(isset($order->order_data['delivery_snapshot']) && $hasPhysicalProducts)
                <!-- Physical Delivery Information -->
                <div class="mb-4 sm:mb-6">
                    <h3 class="font-semibold text-gray-900 dark:text-white mb-3 sm:mb-4">Delivery Information</h3>
                    <div class="bg-gray-50 dark:bg-gray-700 p-3 sm:p-4 rounded-lg">
                        <p class="font-medium text-sm sm:text-base">{{ $order->order_data['delivery_snapshot']['name'] }}</p>
                        <p class="text-sm sm:text-base break-words">{{ $order->order_data['delivery_snapshot']['address'] }}</p>
                        <p class="text-sm sm:text-base">{{ $order->order_data['delivery_snapshot']['city'] }}, {{ $order->order_data['delivery_snapshot']['state'] }}</p>
                        <p class="text-sm sm:text-base">{{ $order->order_data['delivery_snapshot']['country'] }}</p>
                        @if($order->order_data['delivery_snapshot']['phone'])
                            <p class="text-sm sm:text-base">Phone: {{ $order->order_data['delivery_snapshot']['phone'] }}</p>
                        @endif
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
                <!-- Mixed Order Information -->
                <div class="mb-6 p-4 bg-red-50 dark:bg-red-900/20 rounded-lg border border-red-200 dark:border-red-800">
                    <h3 class="font-semibold text-red-900 dark:text-red-100 mb-2 flex items-center">
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        Important: Mixed Order Rules (Physical + Digital Products)
                    </h3>
                    <div class="text-sm text-red-800 dark:text-red-200 space-y-2">
                        <div class="font-semibold text-red-900 dark:text-red-100">📦 Physical Products Rules:</div>
                        <p>• <strong>Cancellation:</strong> You can cancel physical items until seller ships them <em>(prevents shipping costs and logistics issues)</em></p>
                        <p>• <strong>No Cancel After Shipping:</strong> Once marked "Shipped", cancellation is blocked <em>(prevents fraud and protects seller from losses)</em></p>
                        <p>• <strong>Confirm Receipt:</strong> You must confirm when physical items arrive to release payment <em>(ensures you received your items before seller gets paid)</em></p>
                        <p>• <strong>Payment Hold:</strong> Your coins are held securely until you confirm receipt <em>(protects you from non-delivery)</em></p>
                        
                        <div class="font-semibold text-red-900 dark:text-red-100 mt-3">💾 Digital Products Rules:</div>
                        <p>• <strong>Instant Access:</strong> Digital items are available for download immediately <em>(no shipping needed)</em></p>
                        <p>• <strong>Auto Payment:</strong> Payment for digital items is released instantly to seller <em>(prevents download fraud)</em></p>
                        <p>• <strong>No Cancellation:</strong> Digital items cannot be cancelled once purchased <em>(prevents abuse after downloading)</em></p>
                    </div>
                </div>
            @elseif($hasPhysicalProducts)
                <!-- Physical Only Information -->
                <div class="mb-6 p-4 bg-red-50 dark:bg-red-900/20 rounded-lg border border-red-200 dark:border-red-800">
                    <h3 class="font-semibold text-red-900 dark:text-red-100 mb-2 flex items-center">
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        Important: Physical Products Order Rules
                    </h3>
                    <div class="text-sm text-red-800 dark:text-red-200 space-y-1">
                        <p>• <strong>Cancellation:</strong> You can cancel items until seller ships them <em>(prevents shipping costs and logistics issues)</em></p>
                        <p>• <strong>No Cancel After Shipping:</strong> Once marked "Shipped", cancellation is blocked <em>(prevents fraud and protects seller from losses)</em></p>
                        <p>• <strong>Confirm Receipt:</strong> Mark items as received to release payment to seller <em>(ensures you received your items before seller gets paid)</em></p>
                        <p>• <strong>Payment Hold:</strong> Your coins are held securely until you confirm receipt <em>(protects you from non-delivery)</em></p>
                    </div>
                </div>
            @elseif($isDigitalOnly)
                <!-- Digital Only Information -->
                <div class="mb-6 p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-200 dark:border-blue-800">
                    <h3 class="font-semibold text-blue-900 dark:text-blue-100 mb-2 flex items-center">
                        Digital Products Order Rules
                    </h3>
                    <div class="text-sm text-blue-800 dark:text-blue-200 space-y-1">
                        <p>• <strong>Instant Access:</strong> All digital products are available for download immediately <em>(no shipping needed)</em></p>
                        <p>• <strong>Auto Payment:</strong> Payment is automatically released to seller upon purchase <em>(prevents download fraud)</em></p>
                        <p>• <strong>No Cancellation:</strong> Digital items cannot be cancelled once purchased <em>(prevents abuse after downloading)</em></p>
                        <p>• <strong>Downloads:</strong> Use the download buttons below to access your digital files <em>(save files to your device)</em></p>
                    </div>
                </div>
            @endif
            
            @if($hasPhysicalProducts && $order->status !== 'cancelled')
                <!-- Bulk Action Button -->
                <div class="mb-6 flex justify-center">
                    <button onclick="openBulkActionModal()" 
                            class="px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 flex items-center space-x-2 font-medium">
                        <i class="fas fa-tasks"></i>
                        <span>Take Action (All Items)</span>
                    </button>
                </div>
            @endif
            
            @if($order->isStoreOrder() && isset($order->order_data['store_id']))
                @php
                    $store = \App\Models\Store::find($order->order_data['store_id']);
                    $hasPhysicalProducts = collect($order->order_data['items'] ?? [])->contains(function($item) {
                        return ($item['product_snapshot']['type'] ?? 'physical') === 'physical';
                    });
                @endphp
                @if($store && $store->user)
                    <div class="flex justify-center sm:justify-end">
                        <button onclick="openChatModal('{{ $store->user->id }}', '{{ $store->user->name }}', '{{ $store->user->profile_photo_url }}', 'Order #{{ $order->order_number }}', '{{ $order->id }}')" 
                                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 flex items-center space-x-2">
                            <i class="fas fa-comment"></i>
                            <span>Contact Seller</span>
                        </button>
                    </div>
                @endif
            @endif
        </div>
    </div>

    <!-- Bulk Action Modal -->
    <div id="bulkActionModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-[9999]">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Take Action on All Physical Items</h3>
                    <div class="space-y-3">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Select Action:</label>
                        <select id="bulkActionSelect" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Choose an action...</option>
                            <option value="cancel">Cancel All Items</option>
                            <option value="complete">Confirm & Complete All Items</option>
                        </select>
                    </div>
                    <div class="flex justify-end space-x-3 mt-6">
                        <button onclick="closeBulkActionModal()" class="px-4 py-2 text-gray-600 border rounded-lg hover:bg-gray-50">Cancel</button>
                        <button onclick="updateBulkAction()" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Update</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Product Action Modal -->
    <div id="productActionModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-[9999]">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Take Action on <span id="productName"></span></h3>
                    <div class="space-y-3">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Select Action:</label>
                        <select id="productActionSelect" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Choose an action...</option>
                            <option value="cancel">Cancel Item</option>
                            <option value="complete">Confirm & Complete Item</option>
                        </select>
                    </div>
                    <div class="flex justify-end space-x-3 mt-6">
                        <button onclick="closeProductActionModal()" class="px-4 py-2 text-gray-600 border rounded-lg hover:bg-gray-50">Cancel</button>
                        <button onclick="updateProductAction()" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Update</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        let currentProductIndex = null;

        function openBulkActionModal() {
            document.getElementById('bulkActionModal').classList.remove('hidden');
        }

        function closeBulkActionModal() {
            document.getElementById('bulkActionModal').classList.add('hidden');
            document.getElementById('bulkActionSelect').value = '';
        }

        function openProductActionModal(index, productName, currentStatus) {
            currentProductIndex = index;
            document.getElementById('productName').textContent = productName;
            document.getElementById('productActionModal').classList.remove('hidden');
        }

        function closeProductActionModal() {
            document.getElementById('productActionModal').classList.add('hidden');
            document.getElementById('productActionSelect').value = '';
            currentProductIndex = null;
        }

        function updateBulkAction() {
            const selectedAction = document.getElementById('bulkActionSelect').value;
            if (!selectedAction) {
                showToast('Please select an action', 'error');
                return;
            }

            fetch(`/orders/{{ $order->id }}/bulk-action`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ action: selectedAction })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showToast('Bulk action completed successfully!', 'success');
                    setTimeout(() => window.location.reload(), 1000);
                } else {
                    showToast(data.message || 'Failed to update items', 'error');
                }
            })
            .catch(error => {
                showToast('Error updating items', 'error');
            });

            closeBulkActionModal();
        }

        function updateProductAction() {
            const selectedAction = document.getElementById('productActionSelect').value;
            if (!selectedAction || currentProductIndex === null) {
                showToast('Please select an action', 'error');
                return;
            }

            fetch(`/orders/{{ $order->id }}/product-action`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ 
                    product_index: currentProductIndex,
                    action: selectedAction 
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showToast('Product action completed successfully!', 'success');
                    setTimeout(() => window.location.reload(), 1000);
                } else {
                    showToast(data.message || 'Failed to update product', 'error');
                }
            })
            .catch(error => {
                showToast('Error updating product', 'error');
            });

            closeProductActionModal();
        }

        function downloadDigitalFiles(orderId, itemIndex) {
            // Show loading state
            const button = event.target.closest('button');
            const originalText = button.innerHTML;
            button.innerHTML = '<i class="fas fa-spinner fa-spin text-xs"></i><span>Downloading...</span>';
            button.disabled = true;
            
            // Create a temporary link to trigger download
            const link = document.createElement('a');
            link.href = `/orders/${orderId}/download/${itemIndex}`;
            link.download = '';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
            
            // Reset button after a short delay
            setTimeout(() => {
                button.innerHTML = originalText;
                button.disabled = false;
            }, 2000);
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
        
        function showToast(message, type) {
            const toast = document.createElement('div');
            const bgColor = type === 'success' ? 'bg-green-500' : 'bg-red-500';
            toast.className = `fixed top-4 right-4 ${bgColor} text-white px-4 py-2 rounded-lg z-50`;
            toast.textContent = message;
            document.body.appendChild(toast);
            
            setTimeout(() => {
                toast.remove();
            }, 2000);
        }
    </script>
    @endpush
</x-app-layout>