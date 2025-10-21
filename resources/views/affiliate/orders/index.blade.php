<x-affiliate-layout>
    <div class="p-4 sm:p-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-4 sm:mb-6">
            <h1 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white mb-2 sm:mb-0">Orders</h1>
            <div class="text-sm text-gray-500 dark:text-gray-400">
                {{ $orders->total() }} orders
            </div>
        </div>
        
        <div class="mb-4 sm:mb-6">
            <nav class="flex space-x-2 sm:space-x-8 overflow-x-auto">
                <a href="{{ route('affiliate.orders.index', ['status' => 'all']) }}" 
                   class="py-2 px-1 border-b-2 font-medium text-xs sm:text-sm whitespace-nowrap {{ $status === 'all' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                    All @if($counts['all'] > 0)<span class="ml-1 text-xs">({{ $counts['all'] }})</span>@endif
                </a>
                <a href="{{ route('affiliate.orders.index', ['status' => 'active']) }}" 
                   class="py-2 px-1 border-b-2 font-medium text-xs sm:text-sm whitespace-nowrap {{ $status === 'active' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                    Active @if($counts['active'] > 0)<span class="ml-1 text-xs">({{ $counts['active'] }})</span>@endif
                </a>
                <a href="{{ route('affiliate.orders.index', ['status' => 'completed']) }}" 
                   class="py-2 px-1 border-b-2 font-medium text-xs sm:text-sm whitespace-nowrap {{ $status === 'completed' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                    Completed @if($counts['completed'] > 0)<span class="ml-1 text-xs">({{ $counts['completed'] }})</span>@endif
                </a>
                <a href="{{ route('affiliate.orders.index', ['status' => 'cancelled']) }}" 
                   class="py-2 px-1 border-b-2 font-medium text-xs sm:text-sm whitespace-nowrap {{ $status === 'cancelled' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                    Cancelled @if($counts['cancelled'] > 0)<span class="ml-1 text-xs">({{ $counts['cancelled'] }})</span>@endif
                </a>
            </nav>
        </div>

        @if($orders->count() > 0)
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Order</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Customer</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Items</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Total</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach($orders as $order)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $order->order_number }}</div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">${{ number_format($order->total_amount, 2) }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $order->user->name }}</div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">{{ $order->user->email }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900 dark:text-white">
                                            @foreach($order->order_data['items'] ?? [] as $item)
                                                <div class="mb-1">
                                                    {{ $item['product_snapshot']['name'] ?? 'Unknown Product' }} (x{{ $item['quantity'] }})
                                                </div>
                                            @endforeach
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900 dark:text-white">${{ number_format($order->total_amount, 2) }}</div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">{{ $order->total_coins_used }} coins</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                            $items = collect($order->order_data['items'] ?? []);
                                            $digitalItems = $items->filter(fn($item) => ($item['product_snapshot']['type'] ?? 'physical') === 'digital');
                                            $physicalItems = $items->filter(fn($item) => ($item['product_snapshot']['type'] ?? 'physical') === 'physical');
                                            
                                            $isDigitalOnly = $physicalItems->isEmpty() && $digitalItems->isNotEmpty();
                                            $isMixed = $digitalItems->isNotEmpty() && $physicalItems->isNotEmpty();
                                        @endphp
                                        
                                        <span class="text-sm rounded-full px-3 py-1 font-medium
                                            @if($order->status === 'pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                                            @elseif($order->status === 'confirmed') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200
                                            @elseif($order->status === 'processing') bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200
                                            @elseif($order->status === 'shipped') bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-200
                                            @elseif($order->status === 'delivered') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                            @elseif($order->status === 'completed') bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200
                                            @endif">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        {{ $order->created_at->format('M j, Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="{{ route('affiliate.orders.view', $order->id) }}" 
                                           class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">
                                            View Details
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                    {{ $orders->links() }}
                </div>
            </div>
        @else
            <div class="text-center py-12">
                <i class="fas fa-shopping-bag text-4xl text-gray-400 mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">No orders yet</h3>
                <p class="text-gray-500 dark:text-gray-400">Orders from your store will appear here.</p>
            </div>
        @endif
    </div>

    @push('scripts')
    <script>
        function updateOrderStatus(orderId, status) {
            fetch(`/affiliate-orders/${orderId}/update-status`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ status: status })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showToast('Order status updated successfully!', 'success');
                    
                    if (status === 'completed') {
                        showToast('Coins transferred to your earned balance!', 'info');
                    }
                } else {
                    showToast('Failed to update order status: ' + data.message, 'error');
                }
            })
            .catch(error => {
                showToast('Error updating order status', 'error');
            });
        }

        function viewOrderDetails(orderId) {
            alert('Order details modal - to be implemented');
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
    </script>
    @endpush
</x-affiliate-layout>