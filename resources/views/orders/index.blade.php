<x-app-layout>
    <div class="container p-2 sm:p-4 mx-auto max-w-6xl">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between p-4 sm:p-6 border-b border-gray-200 dark:border-gray-700">
                <h1 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white mb-2 sm:mb-0">My Orders</h1>
                <span class="text-sm text-gray-500 dark:text-gray-400">{{ $orders->total() }} orders</span>
            </div>
            
            <div class="border-b border-gray-200 dark:border-gray-700">
                <nav class="flex space-x-2 sm:space-x-8 px-4 sm:px-6 overflow-x-auto">
                    <a href="{{ route('orders.index', ['status' => 'all']) }}" 
                       class="py-3 sm:py-4 px-1 border-b-2 font-medium text-xs sm:text-sm whitespace-nowrap {{ $status === 'all' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                        All @if($counts['all'] > 0)<span class="ml-1 text-xs">({{ $counts['all'] }})</span>@endif
                    </a>
                    <a href="{{ route('orders.index', ['status' => 'active']) }}" 
                       class="py-3 sm:py-4 px-1 border-b-2 font-medium text-xs sm:text-sm whitespace-nowrap {{ $status === 'active' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                        Active @if($counts['active'] > 0)<span class="ml-1 text-xs">({{ $counts['active'] }})</span>@endif
                    </a>
                    <a href="{{ route('orders.index', ['status' => 'completed']) }}" 
                       class="py-3 sm:py-4 px-1 border-b-2 font-medium text-xs sm:text-sm whitespace-nowrap {{ $status === 'completed' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                        Completed @if($counts['completed'] > 0)<span class="ml-1 text-xs">({{ $counts['completed'] }})</span>@endif
                    </a>
                    <a href="{{ route('orders.index', ['status' => 'cancelled']) }}" 
                       class="py-3 sm:py-4 px-1 border-b-2 font-medium text-xs sm:text-sm whitespace-nowrap {{ $status === 'cancelled' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                        Cancelled @if($counts['cancelled'] > 0)<span class="ml-1 text-xs">({{ $counts['cancelled'] }})</span>@endif
                    </a>
                </nav>
            </div>
            
            @if($orders->count() > 0)
                <div class="divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($orders as $order)
                        <div class="p-4 sm:p-6 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-3 space-y-2 sm:space-y-0">
                                <div class="flex flex-col sm:flex-row sm:items-center space-y-2 sm:space-y-0 sm:space-x-4">
                                    <h3 class="font-semibold text-gray-900 dark:text-white text-sm sm:text-base">{{ $order->order_number }}</h3>
                                    <div class="flex items-center space-x-2">
                                        @php
                                            $items = collect($order->order_data['items'] ?? []);
                                            $digitalItems = $items->filter(fn($item) => ($item['product_snapshot']['type'] ?? 'physical') === 'digital');
                                            $physicalItems = $items->filter(fn($item) => ($item['product_snapshot']['type'] ?? 'physical') === 'physical');
                                            
                                            $isDigitalOnly = $physicalItems->isEmpty() && $digitalItems->isNotEmpty();
                                            $isMixed = $digitalItems->isNotEmpty() && $physicalItems->isNotEmpty();
                                            
                                            // Count products by status
                                            $statusCounts = [];
                                            foreach($items as $item) {
                                                if ($item['product_snapshot']['type'] === 'digital') {
                                                    $productStatus = 'completed';
                                                } else {
                                                    $productStatus = $item['buyer_status'] ?? 'pending';
                                                }
                                                $statusCounts[$productStatus] = ($statusCounts[$productStatus] ?? 0) + 1;
                                            }
                                        @endphp
                                        <span class="px-2 py-1 text-xs rounded-full {{ 
                                            $order->status === 'completed' ? 'bg-green-100 text-green-800' : 
                                            ($order->status === 'cancelled' ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800') 
                                        }}">
                                            {{ ucfirst($order->status) }}@if($isDigitalOnly) (Digital)@elseif($isMixed) (Mixed)@endif
                                        </span>
                                        <span class="text-xs sm:text-sm text-gray-500 dark:text-gray-400">{{ $order->type_display }}</span>
                                    </div>
                                </div>
                                <div class="text-left sm:text-right">
                                    <p class="font-semibold text-gray-900 dark:text-white text-sm sm:text-base">${{ number_format($order->total_amount, 2) }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ number_format($order->total_coins_used) }} coins</p>
                                </div>
                            </div>
                            
                            <!-- Product Status Dots -->
                            @if(count($statusCounts) > 0)
                                <div class="flex items-center space-x-2 mb-2">
                                    @foreach($statusCounts as $status => $count)
                                        @php
                                            $dotColors = [
                                                'pending' => 'bg-yellow-500',
                                                'confirmed' => 'bg-blue-500', 
                                                'processing' => 'bg-purple-500',
                                                'shipped' => 'bg-indigo-500',
                                                'delivered' => 'bg-green-500',
                                                'completed' => 'bg-gray-500',
                                                'cancelled' => 'bg-red-500'
                                            ];
                                            $dotColor = $dotColors[$status] ?? 'bg-gray-400';
                                        @endphp
                                        <div class="flex items-center space-x-1">
                                            <div class="w-3 h-3 {{ $dotColor }} rounded-full flex items-center justify-center">
                                                <span class="text-white text-[8px] font-bold">{{ $count }}</span>
                                            </div>
                                            <span class="text-xs text-gray-500 dark:text-gray-400">{{ ucfirst($status) }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                            
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between space-y-2 sm:space-y-0">
                                <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400">
                                    {{ $order->created_at->format('M j, Y g:i A') }}
                                </p>
                                <a href="{{ route('orders.view', $order) }}" class="text-blue-600 hover:text-blue-800 text-xs sm:text-sm font-medium">
                                    View Details
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <div class="p-6 border-t border-gray-200 dark:border-gray-700">
                    {{ $orders->links() }}
                </div>
            @else
                <div class="text-center py-16">
                    <i class="fas fa-shopping-bag text-4xl text-gray-400 mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">No orders yet</h3>
                    <p class="text-gray-500 dark:text-gray-400 mb-6">Start shopping to see your orders here</p>
                    <a href="{{ route('stores') }}" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        Browse Stores
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>