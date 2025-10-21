<x-marketplace-layout>
    @include('market-place.partials.nav')
    
    <div class="container mx-auto px-4 py-8">
        <!-- Breadcrumb -->
        <nav class="mb-6">
            <a href="/marketplace" class="text-blue-600 hover:underline">Marketplace</a>
            <span class="mx-2">/</span>
            <span class="text-gray-600">Product Details</span>
        </nav>

        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Product Images -->
            <div class="lg:w-1/2">
                <div class="aspect-square bg-gray-200 rounded mb-4 flex items-center justify-center">
                    <span class="text-gray-500">Main Product Image</span>
                </div>
                <div class="grid grid-cols-4 gap-2">
                    @for($i = 1; $i <= 4; $i++)
                    <div class="aspect-square bg-gray-200 rounded flex items-center justify-center cursor-pointer hover:opacity-80">
                        <span class="text-xs text-gray-500">{{ $i }}</span>
                    </div>
                    @endfor
                </div>
            </div>

            <!-- Product Info -->
            <div class="lg:w-1/2">
                <h1 class="text-3xl font-bold mb-4">Sample Product Name</h1>
                
                <!-- Rating -->
                <div class="flex items-center mb-4">
                    <span class="text-yellow-400 text-lg">⭐⭐⭐⭐⭐</span>
                    <span class="text-gray-600 ml-2">(245 reviews)</span>
                </div>

                <!-- Price -->
                <div class="mb-6">
                    <span class="text-2xl text-gray-400 line-through">$299.99</span>
                    <span class="text-4xl font-bold text-blue-600 ml-2">$199.99</span>
                    <span class="bg-red-100 text-red-600 px-2 py-1 rounded text-sm ml-2">33% OFF</span>
                </div>

                <!-- Description -->
                <div class="mb-6">
                    <h3 class="font-semibold mb-2">Description</h3>
                    <p class="text-gray-600">This is a detailed description of the product. It includes all the important features and specifications that customers need to know before making a purchase decision.</p>
                </div>

                <!-- Quantity & Add to Cart -->
                <div class="flex items-center gap-4 mb-6">
                    <div class="flex items-center border rounded">
                        <button class="px-3 py-2 hover:bg-gray-100">-</button>
                        <input type="number" value="1" class="w-16 text-center border-0 focus:ring-0">
                        <button class="px-3 py-2 hover:bg-gray-100">+</button>
                    </div>
                    <button class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded font-semibold">Add to Cart</button>
                    <button class="border border-gray-300 hover:bg-gray-50 px-4 py-3 rounded">♡</button>
                </div>

                <!-- Product Details -->
                <div class="border-t pt-6">
                    <h3 class="font-semibold mb-4">Product Details</h3>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Brand:</span>
                            <span>Sample Brand</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Category:</span>
                            <span>Electronics</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">SKU:</span>
                            <span>SP-001</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Availability:</span>
                            <span class="text-green-600">In Stock</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Reviews Section -->
        <div class="mt-12">
            <h2 class="text-2xl font-bold mb-6">Customer Reviews</h2>
            <div class="space-y-4">
                @for($i = 1; $i <= 3; $i++)
                <div class="border-b pb-4">
                    <div class="flex items-center mb-2">
                        <span class="font-semibold">Customer {{ $i }}</span>
                        <span class="text-yellow-400 ml-2">⭐⭐⭐⭐⭐</span>
                        <span class="text-gray-500 text-sm ml-2">2 days ago</span>
                    </div>
                    <p class="text-gray-600">Great product! Exactly as described and fast shipping. Highly recommend to others.</p>
                </div>
                @endfor
            </div>
        </div>
    </div>
</x-marketplace-layout>