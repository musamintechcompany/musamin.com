<x-marketplace-layout>
    <!-- Filters & Products -->
    <div class="container mx-auto px-4 py-8">
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Sidebar Filters -->
            <div class="lg:w-1/6">
                <h3 class="font-semibold text-lg mb-4">Filters</h3>
                
                <!-- Categories -->
                <div class="mb-6">
                    <h4 class="font-medium mb-2">Categories</h4>
                    <div class="space-y-2">
                        <label class="flex items-center">
                            <input type="checkbox" class="mr-2"> Productivity
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" class="mr-2"> Design
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" class="mr-2"> Development
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" class="mr-2"> Security
                        </label>
                    </div>
                </div>

                <!-- Price Range -->
                <div class="mb-6">
                    <h4 class="font-medium mb-2">Price Range</h4>
                    <div class="flex gap-2">
                        <input type="number" placeholder="Min" class="w-full px-3 py-2 border rounded">
                        <input type="number" placeholder="Max" class="w-full px-3 py-2 border rounded">
                    </div>
                </div>

                <!-- Rating -->
                <div class="mb-6">
                    <h4 class="font-medium mb-2">Rating</h4>
                    <div class="space-y-2">
                        <label class="flex items-center">
                            <input type="checkbox" class="mr-2"> ⭐⭐⭐⭐⭐ & up
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" class="mr-2"> ⭐⭐⭐⭐ & up
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" class="mr-2"> ⭐⭐⭐ & up
                        </label>
                    </div>
                </div>
            </div>

            <!-- Software Grid -->
            <div class="lg:w-5/6">
                <!-- Sort & View Options -->
                <div class="flex justify-between items-center mb-6">
                    <p class="text-gray-600">Showing 1-12 of 89 software</p>
                    <select class="px-4 py-2 border rounded">
                        <option>Sort by: Featured</option>
                        <option>Price: Low to High</option>
                        <option>Price: High to Low</option>
                        <option>Newest First</option>
                        <option>Best Rating</option>
                    </select>
                </div>

                <!-- Software Grid -->
                <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-4">
                    <!-- Sample Software Cards -->
                    @for($i = 1; $i <= 12; $i++)
                    <div class="hover:opacity-80 transition-opacity">
                        <div class="aspect-square bg-gray-200 rounded flex items-center justify-center mb-3">
                            <span class="text-gray-500">Software Icon</span>
                        </div>
                        <h3 class="font-semibold mb-2">Software {{ $i }}</h3>
                        <p class="text-gray-600 text-sm mb-2">Professional software solution...</p>
                        <div class="flex items-center mb-2">
                            <span class="text-yellow-400">⭐⭐⭐⭐⭐</span>
                            <span class="text-gray-500 text-sm ml-1">({{ rand(50, 1000) }})</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <div class="flex flex-col">
                                <span class="text-sm text-gray-400 line-through">${{ rand(99, 299) }}.99</span>
                                <span class="text-xl font-bold text-blue-600">${{ rand(29, 199) }}.99</span>
                            </div>
                            <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-sm">Buy Now</button>
                        </div>
                    </div>
                    @endfor
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