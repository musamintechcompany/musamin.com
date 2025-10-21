<x-marketplace-layout>
    <div class="container mx-auto px-4 py-8">
        <!-- Breadcrumb -->
        <nav class="mb-6">
            <a href="/softwares" class="text-blue-600 hover:underline">Software</a>
            <span class="mx-2">/</span>
            <span class="text-gray-600">Software Details</span>
        </nav>

        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Software Images & Screenshots -->
            <div class="lg:w-1/2">
                <div class="aspect-video bg-gray-200 rounded mb-4 flex items-center justify-center">
                    <span class="text-gray-500">Software Screenshot</span>
                </div>
                <div class="grid grid-cols-4 gap-2">
                    @for($i = 1; $i <= 4; $i++)
                    <div class="aspect-video bg-gray-200 rounded flex items-center justify-center cursor-pointer hover:opacity-80">
                        <span class="text-xs text-gray-500">{{ $i }}</span>
                    </div>
                    @endfor
                </div>
            </div>

            <!-- Software Info -->
            <div class="lg:w-1/2">
                <h1 class="text-3xl font-bold mb-4">Professional Software Suite</h1>
                
                <!-- Rating -->
                <div class="flex items-center mb-4">
                    <span class="text-yellow-400 text-lg">⭐⭐⭐⭐⭐</span>
                    <span class="text-gray-600 ml-2">(1,245 reviews)</span>
                </div>

                <!-- Price -->
                <div class="mb-6">
                    <span class="text-2xl text-gray-400 line-through">$199.99</span>
                    <span class="text-4xl font-bold text-blue-600 ml-2">$99.99</span>
                    <span class="bg-red-100 text-red-600 px-2 py-1 rounded text-sm ml-2">50% OFF</span>
                </div>

                <!-- Description -->
                <div class="mb-6">
                    <h3 class="font-semibold mb-2">Description</h3>
                    <p class="text-gray-600">A comprehensive software solution designed for professionals. Includes advanced features, regular updates, and premium support to boost your productivity.</p>
                </div>

                <!-- License & Purchase -->
                <div class="flex items-center gap-4 mb-6">
                    <select class="border rounded px-3 py-2">
                        <option>Single License</option>
                        <option>Team License (5 users)</option>
                        <option>Enterprise License</option>
                    </select>
                    <button class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded font-semibold">Buy Now</button>
                    <button class="border border-gray-300 hover:bg-gray-50 px-4 py-3 rounded">♡</button>
                </div>

                <!-- Software Details -->
                <div class="border-t pt-6">
                    <h3 class="font-semibold mb-4">Software Details</h3>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Version:</span>
                            <span>2024.1.0</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Platform:</span>
                            <span>Windows, Mac, Linux</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">File Size:</span>
                            <span>125 MB</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">License:</span>
                            <span>Commercial</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Support:</span>
                            <span class="text-green-600">24/7 Premium</span>
                        </div>
                    </div>
                </div>

                <!-- System Requirements -->
                <div class="border-t pt-6 mt-6">
                    <h3 class="font-semibold mb-4">System Requirements</h3>
                    <div class="space-y-2 text-sm">
                        <div><strong>OS:</strong> Windows 10+, macOS 10.15+, Ubuntu 18.04+</div>
                        <div><strong>RAM:</strong> 4GB minimum, 8GB recommended</div>
                        <div><strong>Storage:</strong> 500MB available space</div>
                        <div><strong>Network:</strong> Internet connection required</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Reviews Section -->
        <div class="mt-12">
            <h2 class="text-2xl font-bold mb-6">User Reviews</h2>
            <div class="space-y-4">
                @for($i = 1; $i <= 3; $i++)
                <div class="border-b pb-4">
                    <div class="flex items-center mb-2">
                        <span class="font-semibold">Developer {{ $i }}</span>
                        <span class="text-yellow-400 ml-2">⭐⭐⭐⭐⭐</span>
                        <span class="text-gray-500 text-sm ml-2">1 week ago</span>
                    </div>
                    <p class="text-gray-600">Excellent software! Very intuitive interface and powerful features. Great value for money and excellent customer support.</p>
                </div>
                @endfor
            </div>
        </div>
    </div>
</x-marketplace-layout>