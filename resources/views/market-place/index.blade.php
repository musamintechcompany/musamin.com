<x-marketplace-layout>
    @include('market-place.partials.nav')

    <!-- Products -->
    <div class="container mx-auto px-4 py-4 mt-8 sm:mt-12">
        <div class="flex flex-col lg:flex-row gap-8">
            @include('market-place.partials.categories')

            <!-- Products Grid -->
            <div class="lg:w-5/6">
    

                <!-- Products Grid -->
                <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-4">
                    @php
                        $searchTerm = request('search');
                        $products = collect([
                            'Laptop Computer', 'Wireless Headphones', 'Smart Watch', 'Gaming Mouse',
                            'Bluetooth Speaker', 'Phone Case', 'Tablet Stand', 'USB Cable',
                            'Power Bank', 'Keyboard', 'Monitor', 'Camera'
                        ]);
                        
                        if ($searchTerm) {
                            $products = $products->filter(function($product) use ($searchTerm) {
                                return stripos($product, $searchTerm) !== false;
                            });
                        }
                        
                        $products = $products->take(12);
                    @endphp
                    
                    @if($products->count() > 0)
                        @foreach($products as $i => $productName)
                        <!-- Mobile Layout: Image Left, Details Right -->
                        <div class="md:hidden border rounded-lg p-3">
                            <div class="flex gap-3 items-stretch">
                                <!-- Product Image - Left -->
                                <div class="w-32 bg-gray-200 rounded flex items-center justify-center flex-shrink-0">
                                    <span class="text-gray-500 text-xs">IMG</span>
                                </div>
                                
                                <!-- Product Details - Right -->
                                <div class="flex-1">
                                    <h3 class="font-semibold text-sm mb-1">{{ $productName }}</h3>
                                    <p class="text-gray-600 text-xs mb-2">High quality {{ strtolower($productName) }} for everyday use...</p>
                                    <div class="flex items-center mb-1">
                                        <span class="text-yellow-400 text-xs">⭐⭐⭐⭐⭐</span>
                                        <span class="text-gray-500 text-xs ml-1">({{ rand(10, 500) }})</span>
                                    </div>
                                    <div class="flex items-center gap-2 mb-2">
                                        <span class="text-xs text-gray-400 line-through">${{ rand(250, 400) }}.99</span>
                                        <span class="text-lg font-bold text-blue-600">${{ rand(10, 200) }}.99</span>
                                    </div>
                                    <!-- Add to Cart Button - Below Details -->
                                    <button class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded text-sm">Add to Cart</button>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Desktop Layout: Original Grid -->
                        <div class="hidden md:block hover:opacity-80 transition-opacity">
                            <div class="aspect-square bg-gray-200 rounded flex items-center justify-center mb-3">
                                <span class="text-gray-500">Product Image</span>
                            </div>
                            <h3 class="font-semibold mb-2">{{ $productName }}</h3>
                            <p class="text-gray-600 text-sm mb-2">High quality {{ strtolower($productName) }} for everyday use...</p>
                            <div class="flex items-center mb-2">
                                <span class="text-yellow-400">⭐⭐⭐⭐⭐</span>
                                <span class="text-gray-500 text-sm ml-1">({{ rand(10, 500) }})</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <div class="flex flex-col">
                                    <span class="text-sm text-gray-400 line-through">${{ rand(250, 400) }}.99</span>
                                    <span class="text-xl font-bold text-blue-600">${{ rand(10, 200) }}.99</span>
                                </div>
                                <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-sm">Add to Cart</button>
                            </div>
                        </div>
                        @endforeach
                    @else
                        <div class="col-span-full text-center py-8">
                            <p class="text-gray-500">No products found for "{{ $searchTerm }}"</p>
                        </div>
                    @endif
                </div>

                <!-- Pagination -->
                <div class="flex justify-center mt-8">
                    <nav class="flex space-x-2">
                        <button class="px-3 py-2 border rounded hover:bg-gray-50">Previous</button>
                        <button class="px-3 py-2 bg-blue-600 text-white rounded">1</button>
                        <button class="px-3 py-2 border rounded hover:bg-gray-50">2</button>
                        <button class="px-3 py-2 border rounded hover:bg-gray-50">3</button>
                        <button class="px-3 py-2 border rounded hover:bg-gray-50">Next</button>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</x-marketplace-layout>
