<x-guest1-layout>
    <x-slot name="title">{{ config('app.name') }} - Market</x-slot>

    <x-slot name="meta">
        <meta name="description" content="Your one-stop shop for all your needs. Quality products at affordable prices.">
        <meta name="keywords" content="online shopping, deals, kitchen, gaming, fashion, home">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <style>
            .hero-slider {
                transition: background-image 0.5s ease-in-out;
            }
            .scrollbar-hide {
                -ms-overflow-style: none;
                scrollbar-width: none;
            }
            .scrollbar-hide::-webkit-scrollbar {
                display: none;
            }
            .product-name-price {
                display: flex;
                justify-content: space-between;
                align-items: center;
                width: 100%;
            }
        </style>
    </x-slot>

    <div class="bg-white">
        <!-- HERO SECTION -->
        <div class="relative w-full h-[400px] bg-gray-900 text-white flex items-center justify-center overflow-hidden hero-slider">
            <img src="https://images.unsplash.com/photo-1556909114-f6e7ad7d3136?ixlib=rb-4.0.3&auto=format&fit=crop&w=1600&q=80" 
                 class="absolute inset-0 w-full h-full object-cover opacity-80" alt="Hero">
            <div class="relative z-10 text-center">
                <h1 id="hero-title" class="text-4xl font-bold">Digital Marketplace for Everything</h1>
                <p id="hero-subtitle" class="mt-2 text-lg">Buy, rent, or sell websites, apps, and digital products</p>
                <button class="mt-6 bg-orange-500 hover:bg-orange-600 text-white font-bold py-2 px-6 rounded-lg">Explore Now</button>
            </div>
            <button class="absolute left-4 text-5xl text-white hover:text-gray-300 transition" id="prevBtn">&#8249;</button>
            <button class="absolute right-4 text-5xl text-white hover:text-gray-300 transition" id="nextBtn">&#8250;</button>
        </div>

        <!-- CATEGORY GRID (4 Columns) -->
        <div class="max-w-7xl mx-auto p-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mt-6">
            
            <!-- Kitchen Deals -->
            <div class="bg-white border p-4 flex flex-col">
                <h2 class="font-bold text-lg mb-3">Kitchen Deals</h2>
                <div class="grid grid-cols-2 gap-2 flex-grow">
                    <div class="text-center">
                        <img src="https://images.unsplash.com/photo-1570222094114-d054a817e56b?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" 
                             class="w-full h-20 object-cover rounded-lg" alt="Blender">
                        <p class="text-xs mt-1">Blender $25</p>
                    </div>
                    <div class="text-center">
                        <img src="https://images.unsplash.com/photo-1594736797933-d0f14818176e?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" 
                             class="w-full h-20 object-cover rounded-lg" alt="Kettle">
                        <p class="text-xs mt-1">Kettle $18</p>
                    </div>
                    <div class="text-center">
                        <img src="https://images.unsplash.com/photo-1556909114-f6e7ad7d3136?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" 
                             class="w-full h-20 object-cover rounded-lg" alt="Pots">
                        <p class="text-xs mt-1">Pots $35</p>
                    </div>
                    <div class="text-center">
                        <img src="https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" 
                             class="w-full h-20 object-cover rounded-lg" alt="Coffee Maker">
                        <p class="text-xs mt-1">Coffee Maker $45</p>
                    </div>
                </div>
                <a href="#" class="text-sm text-blue-600 hover:underline mt-4 block text-center">See all</a>
            </div>

            <!-- Gaming -->
            <div class="bg-white border p-4 flex flex-col">
                <h2 class="font-bold text-lg mb-3">Shop Gaming</h2>
                <div class="grid grid-cols-2 gap-2 flex-grow">
                    <div class="text-center">
                        <img src="https://images.unsplash.com/photo-1598550476439-6847785b6b3e?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" 
                             class="w-full h-20 object-cover rounded-lg" alt="Controller">
                        <p class="text-xs mt-1">Controller $45</p>
                    </div>
                    <div class="text-center">
                        <img src="https://images.unsplash.com/photo-1599669454699-248893623440?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" 
                             class="w-full h-20 object-cover rounded-lg" alt="Headset">
                        <p class="text-xs mt-1">Headset $35</p>
                    </div>
                    <div class="text-center">
                        <img src="https://images.unsplash.com/photo-1542751371-adc38448a05e?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" 
                             class="w-full h-20 object-cover rounded-lg" alt="Gaming Mouse">
                        <p class="text-xs mt-1">Gaming Mouse $25</p>
                    </div>
                    <div class="text-center">
                        <img src="https://images.unsplash.com/photo-1527814050087-3793815479db?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" 
                             class="w-full h-20 object-cover rounded-lg" alt="Keyboard">
                        <p class="text-xs mt-1">Keyboard $55</p>
                    </div>
                </div>
                <a href="#" class="text-sm text-blue-600 hover:underline mt-4 block text-center">See all</a>
            </div>

            <!-- Fashion -->
            <div class="bg-white border p-4 flex flex-col">
                <h2 class="font-bold text-lg mb-3">Shop Fashion</h2>
                <div class="grid grid-cols-2 gap-2 flex-grow">
                    <div class="text-center">
                        <img src="https://images.unsplash.com/photo-1595777457583-95e059d581b8?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" 
                             class="w-full h-20 object-cover rounded-lg" alt="Dresses">
                        <p class="text-xs mt-1">Dresses $30</p>
                    </div>
                    <div class="text-center">
                        <img src="https://images.unsplash.com/photo-1549298916-b41d501d3772?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" 
                             class="w-full h-20 object-cover rounded-lg" alt="Shoes">
                        <p class="text-xs mt-1">Shoes $50</p>
                    </div>
                    <div class="text-center">
                        <img src="https://images.unsplash.com/photo-1434389677669-e08b4cac3105?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" 
                             class="w-full h-20 object-cover rounded-lg" alt="Bags">
                        <p class="text-xs mt-1">Bags $40</p>
                    </div>
                    <div class="text-center">
                        <img src="https://images.unsplash.com/photo-1583743089695-4b816a340f82?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" 
                             class="w-full h-20 object-cover rounded-lg" alt="Jackets">
                        <p class="text-xs mt-1">Jackets $65</p>
                    </div>
                </div>
                <a href="#" class="text-sm text-blue-600 hover:underline mt-4 block text-center">See all</a>
            </div>

            <!-- Home Refresh -->
            <div class="bg-white border p-4 flex flex-col">
                <h2 class="font-bold text-lg mb-3">Refresh Your Space</h2>
                <div class="grid grid-cols-2 gap-2 flex-grow">
                    <div class="text-center">
                        <img src="https://images.unsplash.com/photo-1555041469-a586c61ea9bc?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" 
                             class="w-full h-20 object-cover rounded-lg" alt="Furniture">
                        <p class="text-xs mt-1">Furniture $120</p>
                    </div>
                    <div class="text-center">
                        <img src="https://images.unsplash.com/photo-1586023492125-27b2c045efd7?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" 
                             class="w-full h-20 object-cover rounded-lg" alt="Storage">
                        <p class="text-xs mt-1">Storage $25</p>
                    </div>
                    <div class="text-center">
                        <img src="https://images.unsplash.com/photo-1578662996442-48f60103fc96?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" 
                             class="w-full h-20 object-cover rounded-lg" alt="Lighting">
                        <p class="text-xs mt-1">Lighting $35</p>
                    </div>
                    <div class="text-center">
                        <img src="https://images.unsplash.com/photo-1562003389-902303a5d0a5?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" 
                             class="w-full h-20 object-cover rounded-lg" alt="Curtains">
                        <p class="text-xs mt-1">Curtains $28</p>
                    </div>
                </div>
                <a href="#" class="text-sm text-blue-600 hover:underline mt-4 block text-center">See all</a>
            </div>
        </div>

        <!-- SECOND CATEGORY GRID (4 More Columns) -->
        <div class="max-w-7xl mx-auto p-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            
            <!-- Electronics -->
            <div class="bg-white border p-4 flex flex-col">
                <h2 class="font-bold text-lg mb-3">Electronics</h2>
                <div class="grid grid-cols-2 gap-2 flex-grow">
                    <div class="text-center">
                        <img src="https://images.unsplash.com/photo-1512499617640-c74ae3a79d37?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" 
                             class="w-full h-20 object-cover rounded-lg" alt="Smartphone">
                        <p class="text-xs mt-1">Smartphone $299</p>
                    </div>
                    <div class="text-center">
                        <img src="https://images.unsplash.com/photo-1496181133206-80ce9b88a853?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" 
                             class="w-full h-20 object-cover rounded-lg" alt="Laptop">
                        <p class="text-xs mt-1">Laptop $599</p>
                    </div>
                    <div class="text-center">
                        <img src="https://images.unsplash.com/photo-1572569511254-d8f925fe2cbb?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" 
                             class="w-full h-20 object-cover rounded-lg" alt="Tablet">
                        <p class="text-xs mt-1">Tablet $199</p>
                    </div>
                    <div class="text-center">
                        <img src="https://images.unsplash.com/photo-1484704849700-f032a568e944?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" 
                             class="w-full h-20 object-cover rounded-lg" alt="Camera">
                        <p class="text-xs mt-1">Camera $399</p>
                    </div>
                </div>
                <a href="#" class="text-sm text-blue-600 hover:underline mt-4 block text-center">See all</a>
            </div>

            <!-- Sports & Fitness -->
            <div class="bg-white border p-4 flex flex-col">
                <h2 class="font-bold text-lg mb-3">Sports & Fitness</h2>
                <div class="grid grid-cols-2 gap-2 flex-grow">
                    <div class="text-center">
                        <img src="https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" 
                             class="w-full h-20 object-cover rounded-lg" alt="Dumbbells">
                        <p class="text-xs mt-1">Dumbbells $65</p>
                    </div>
                    <div class="text-center">
                        <img src="https://images.unsplash.com/photo-1544367567-0f2fcb009e0b?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" 
                             class="w-full h-20 object-cover rounded-lg" alt="Yoga Mat">
                        <p class="text-xs mt-1">Yoga Mat $28</p>
                    </div>
                    <div class="text-center">
                        <img src="https://images.unsplash.com/photo-1517963879433-6ad2b056d712?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" 
                             class="w-full h-20 object-cover rounded-lg" alt="Running Shoes">
                        <p class="text-xs mt-1">Running Shoes $85</p>
                    </div>
                    <div class="text-center">
                        <img src="https://images.unsplash.com/photo-1538805060514-97d9cc17730c?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" 
                             class="w-full h-20 object-cover rounded-lg" alt="Resistance Bands">
                        <p class="text-xs mt-1">Resistance Bands $15</p>
                    </div>
                </div>
                <a href="#" class="text-sm text-blue-600 hover:underline mt-4 block text-center">See all</a>
            </div>

            <!-- Books & Media -->
            <div class="bg-white border p-4 flex flex-col">
                <h2 class="font-bold text-lg mb-3">Books & Media</h2>
                <div class="grid grid-cols-2 gap-2 flex-grow">
                    <div class="text-center">
                        <img src="https://images.unsplash.com/photo-1544947950-fa07a98d237f?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" 
                             class="w-full h-20 object-cover rounded-lg" alt="Books">
                        <p class="text-xs mt-1">Books $15</p>
                    </div>
                    <div class="text-center">
                        <img src="https://images.unsplash.com/photo-1493225457124-a3eb161ffa5f?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" 
                             class="w-full h-20 object-cover rounded-lg" alt="Vinyl Records">
                        <p class="text-xs mt-1">Vinyl Records $22</p>
                    </div>
                    <div class="text-center">
                        <img src="https://images.unsplash.com/photo-1611532736597-de2d4265fba3?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" 
                             class="w-full h-20 object-cover rounded-lg" alt="Audiobooks">
                        <p class="text-xs mt-1">Audiobooks $12</p>
                    </div>
                    <div class="text-center">
                        <img src="https://images.unsplash.com/photo-1489599735734-79b4fc8c4c8d?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" 
                             class="w-full h-20 object-cover rounded-lg" alt="Magazines">
                        <p class="text-xs mt-1">Magazines $8</p>
                    </div>
                </div>
                <a href="#" class="text-sm text-blue-600 hover:underline mt-4 block text-center">See all</a>
            </div>

            <!-- Beauty & Personal Care -->
            <div class="bg-white border p-4 flex flex-col">
                <h2 class="font-bold text-lg mb-3">Beauty & Care</h2>
                <div class="grid grid-cols-2 gap-2 flex-grow">
                    <div class="text-center">
                        <img src="https://images.unsplash.com/photo-1596462502278-27bfdc403348?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" 
                             class="w-full h-20 object-cover rounded-lg" alt="Skincare">
                        <p class="text-xs mt-1">Skincare $35</p>
                    </div>
                    <div class="text-center">
                        <img src="https://images.unsplash.com/photo-1522335789203-aabd1fc54bc9?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" 
                             class="w-full h-20 object-cover rounded-lg" alt="Makeup">
                        <p class="text-xs mt-1">Makeup $42</p>
                    </div>
                    <div class="text-center">
                        <img src="https://images.unsplash.com/photo-1571781926291-c477ebfd024b?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" 
                             class="w-full h-20 object-cover rounded-lg" alt="Perfume">
                        <p class="text-xs mt-1">Perfume $55</p>
                    </div>
                    <div class="text-center">
                        <img src="https://images.unsplash.com/photo-1503342217505-b0a15ec3261c?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" 
                             class="w-full h-20 object-cover rounded-lg" alt="Hair Care">
                        <p class="text-xs mt-1">Hair Care $28</p>
                    </div>
                </div>
                <a href="#" class="text-sm text-blue-600 hover:underline mt-4 block text-center">See all</a>
            </div>
        </div>

        <!-- Top Categories Section -->
        <div class="max-w-7xl mx-auto mt-8 p-6 bg-white rounded-lg">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold">Top categories in Kitchen appliances</h2>
                <a href="#" class="text-blue-600 hover:underline">Explore all products in Kitchen</a>
            </div>
            <div class="flex space-x-4 overflow-x-auto pb-4 scrollbar-hide">
                <div class="min-w-[200px] text-center p-4 hover:bg-gray-100 rounded-lg transition">
                    <img src="https://images.unsplash.com/photo-1570222094114-d054a817e56b?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" 
                         class="w-full h-40 object-cover rounded-lg mb-2" alt="Cooker">
                    <p class="font-medium">Cooker</p>
                </div>
                <div class="min-w-[200px] text-center p-4 hover:bg-gray-100 rounded-lg transition">
                    <img src="https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" 
                         class="w-full h-40 object-cover rounded-lg mb-2" alt="Coffee Maker">
                    <p class="font-medium">Coffee</p>
                </div>
                <div class="min-w-[200px] text-center p-4 hover:bg-gray-100 rounded-lg transition">
                    <img src="https://images.unsplash.com/photo-1556909114-f6e7ad7d3136?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" 
                         class="w-full h-40 object-cover rounded-lg mb-2" alt="Pots & Pans">
                    <p class="font-medium">Pots & Pans</p>
                </div>
                <div class="min-w-[200px] text-center p-4 hover:bg-gray-100 rounded-lg transition">
                    <img src="https://images.unsplash.com/photo-1594736797933-d0f14818176e?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" 
                         class="w-full h-40 object-cover rounded-lg mb-2" alt="Kettles">
                    <p class="font-medium">Kettles</p>
                </div>
                <div class="min-w-[200px] text-center p-4 hover:bg-gray-100 rounded-lg transition">
                    <img src="https://images.unsplash.com/photo-1556909114-f6e7ad7d3136?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" 
                         class="w-full h-40 object-cover rounded-lg mb-2" alt="Mixers">
                    <p class="font-medium">Mixers</p>
                </div>
                <div class="min-w-[200px] text-center p-4 hover:bg-gray-100 rounded-lg transition">
                    <img src="https://images.unsplash.com/photo-1571781926291-c477ebfd024b?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" 
                         class="w-full h-40 object-cover rounded-lg mb-2" alt="Toasters">
                    <p class="font-medium">Toasters</p>
                </div>
                <div class="min-w-[200px] text-center p-4 hover:bg-gray-100 rounded-lg transition">
                    <img src="https://images.unsplash.com/photo-1578662996442-48f60103fc96?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" 
                         class="w-full h-40 object-cover rounded-lg mb-2" alt="Microwaves">
                    <p class="font-medium">Microwaves</p>
                </div>
            </div>
        </div>

        <!-- THIRD CATEGORY GRID (4 More Columns) -->
        <div class="max-w-7xl mx-auto p-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            
            <!-- Automotive -->
            <div class="bg-white border p-4 flex flex-col">
                <h2 class="font-bold text-lg mb-3">Automotive</h2>
                <div class="grid grid-cols-2 gap-2 flex-grow">
                    <div class="text-center">
                        <img src="https://images.unsplash.com/photo-1449965408869-eaa3f722e40d?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" 
                             class="w-full h-20 object-cover rounded-lg" alt="Car Accessories">
                        <p class="text-xs mt-1">Car Accessories $45</p>
                    </div>
                    <div class="text-center">
                        <img src="https://images.unsplash.com/photo-1558618666-fcd25c85cd64?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" 
                             class="w-full h-20 object-cover rounded-lg" alt="Tires">
                        <p class="text-xs mt-1">Tires $120</p>
                    </div>
                    <div class="text-center">
                        <img src="https://images.unsplash.com/photo-1486262715619-67b85e0b08d3?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" 
                             class="w-full h-20 object-cover rounded-lg" alt="Car Tools">
                        <p class="text-xs mt-1">Car Tools $35</p>
                    </div>
                    <div class="text-center">
                        <img src="https://images.unsplash.com/photo-1503376780353-7e6692767b70?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" 
                             class="w-full h-20 object-cover rounded-lg" alt="Car Care">
                        <p class="text-xs mt-1">Car Care $25</p>
                    </div>
                </div>
                <a href="#" class="text-sm text-blue-600 hover:underline mt-4 block text-center">See all</a>
            </div>

            <!-- Pet Supplies -->
            <div class="bg-white border p-4 flex flex-col">
                <h2 class="font-bold text-lg mb-3">Pet Supplies</h2>
                <div class="grid grid-cols-2 gap-2 flex-grow">
                    <div class="text-center">
                        <img src="https://images.unsplash.com/photo-1601758228041-f3b2795255f1?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" 
                             class="w-full h-20 object-cover rounded-lg" alt="Dog Food">
                        <p class="text-xs mt-1">Dog Food $30</p>
                    </div>
                    <div class="text-center">
                        <img src="https://images.unsplash.com/photo-1583337130417-3346a1be7dee?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" 
                             class="w-full h-20 object-cover rounded-lg" alt="Pet Toys">
                        <p class="text-xs mt-1">Pet Toys $15</p>
                    </div>
                    <div class="text-center">
                        <img src="https://images.unsplash.com/photo-1548199973-03cce0bbc87b?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" 
                             class="w-full h-20 object-cover rounded-lg" alt="Pet Beds">
                        <p class="text-xs mt-1">Pet Beds $45</p>
                    </div>
                    <div class="text-center">
                        <img src="https://images.unsplash.com/photo-1587300003388-59208cc962cb?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" 
                             class="w-full h-20 object-cover rounded-lg" alt="Pet Collars">
                        <p class="text-xs mt-1">Pet Collars $18</p>
                    </div>
                </div>
                <a href="#" class="text-sm text-blue-600 hover:underline mt-4 block text-center">See all</a>
            </div>

            <!-- Garden & Outdoor -->
            <div class="bg-white border p-4 flex flex-col">
                <h2 class="font-bold text-lg mb-3">Garden & Outdoor</h2>
                <div class="grid grid-cols-2 gap-2 flex-grow">
                    <div class="text-center">
                        <img src="https://images.unsplash.com/photo-1416879595882-3373a0480b5b?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" 
                             class="w-full h-20 object-cover rounded-lg" alt="Garden Tools">
                        <p class="text-xs mt-1">Garden Tools $55</p>
                    </div>
                    <div class="text-center">
                        <img src="https://images.unsplash.com/photo-1585320806297-9794b3e4eeae?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" 
                             class="w-full h-20 object-cover rounded-lg" alt="Plants">
                        <p class="text-xs mt-1">Plants $22</p>
                    </div>
                    <div class="text-center">
                        <img src="https://images.unsplash.com/photo-1558618666-fcd25c85cd64?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" 
                             class="w-full h-20 object-cover rounded-lg" alt="Outdoor Furniture">
                        <p class="text-xs mt-1">Outdoor Furniture $180</p>
                    </div>
                    <div class="text-center">
                        <img src="https://images.unsplash.com/photo-1574263867128-a3d5c1b1deaa?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" 
                             class="w-full h-20 object-cover rounded-lg" alt="BBQ Grills">
                        <p class="text-xs mt-1">BBQ Grills $250</p>
                    </div>
                </div>
                <a href="#" class="text-sm text-blue-600 hover:underline mt-4 block text-center">See all</a>
            </div>

            <!-- Office Supplies -->
            <div class="bg-white border p-4 flex flex-col">
                <h2 class="font-bold text-lg mb-3">Office Supplies</h2>
                <div class="grid grid-cols-2 gap-2 flex-grow">
                    <div class="text-center">
                        <img src="https://images.unsplash.com/photo-1586281380349-632531db7ed4?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" 
                             class="w-full h-20 object-cover rounded-lg" alt="Office Chair">
                        <p class="text-xs mt-1">Office Chair $150</p>
                    </div>
                    <div class="text-center">
                        <img src="https://images.unsplash.com/photo-1434030216411-0b793f4b4173?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" 
                             class="w-full h-20 object-cover rounded-lg" alt="Stationery">
                        <p class="text-xs mt-1">Stationery $12</p>
                    </div>
                    <div class="text-center">
                        <img src="https://images.unsplash.com/photo-1541746972996-4e0b0f93e586?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" 
                             class="w-full h-20 object-cover rounded-lg" alt="Desk Organizer">
                        <p class="text-xs mt-1">Desk Organizer $28</p>
                    </div>
                    <div class="text-center">
                        <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" 
                             class="w-full h-20 object-cover rounded-lg" alt="Printer">
                        <p class="text-xs mt-1">Printer $85</p>
                    </div>
                </div>
                <a href="#" class="text-sm text-blue-600 hover:underline mt-4 block text-center">See all</a>
            </div>
        </div>

        <!-- HORIZONTAL SCROLL SECTION -->
        <div class="max-w-7xl mx-auto mt-8 p-6 bg-white rounded-lg">
            <h2 class="text-xl font-bold mb-4">Fashion trends you like</h2>
            <div class="flex space-x-4 overflow-x-auto pb-4 scrollbar-hide">
                <div class="min-w-[200px] rounded-lg p-3 text-center">
                    <img src="https://images.unsplash.com/photo-1595777457583-95e059d581b8?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" 
                         class="w-full h-40 object-cover rounded-lg" alt="Summer Dresses">
                    <p class="text-sm font-medium mt-2">Summer Dresses $25</p>
                </div>
                <div class="min-w-[200px] rounded-lg p-3 text-center">
                    <img src="https://images.unsplash.com/photo-1543163521-1bf539c55dd2?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" 
                         class="w-full h-40 object-cover rounded-lg" alt="Ankle Boots">
                    <p class="text-sm font-medium mt-2">Ankle Boots $35</p>
                </div>
                <div class="min-w-[200px] rounded-lg p-3 text-center">
                    <img src="https://images.unsplash.com/photo-1591047139829-d91aecb6caea?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" 
                         class="w-full h-40 object-cover rounded-lg" alt="Denim Jackets">
                    <p class="text-sm font-medium mt-2">Denim Jackets $45</p>
                </div>
                <div class="min-w-[200px] rounded-lg p-3 text-center">
                    <img src="https://images.unsplash.com/photo-1506629905607-e48b0e67d879?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" 
                         class="w-full h-40 object-cover rounded-lg" alt="Joggers">
                    <p class="text-sm font-medium mt-2">Joggers $25</p>
                </div>
                <div class="min-w-[200px] rounded-lg p-3 text-center">
                    <img src="https://images.unsplash.com/photo-1515562141207-7a88fb7ce338?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" 
                         class="w-full h-40 object-cover rounded-lg" alt="Jewelry">
                    <p class="text-sm font-medium mt-2">Jewelry $55</p>
                </div>
                <div class="min-w-[200px] rounded-lg p-3 text-center">
                    <img src="https://images.unsplash.com/photo-1441986300917-64674bd600d8?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" 
                         class="w-full h-40 object-cover rounded-lg" alt="Sunglasses">
                    <p class="text-sm font-medium mt-2">Sunglasses $35</p>
                </div>
                <div class="min-w-[200px] rounded-lg p-3 text-center">
                    <img src="https://images.unsplash.com/photo-1553062407-98eeb64c6a62?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" 
                         class="w-full h-40 object-cover rounded-lg" alt="Handbags">
                    <p class="text-sm font-medium mt-2">Handbags $75</p>
                </div>
                <div class="min-w-[200px] rounded-lg p-3 text-center">
                    <img src="https://images.unsplash.com/photo-1560472354-b33ff0c44a43?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" 
                         class="w-full h-40 object-cover rounded-lg" alt="Watches">
                    <p class="text-sm font-medium mt-2">Watches $120</p>
                </div>
                <div class="min-w-[200px] rounded-lg p-3 text-center">
                    <img src="https://images.unsplash.com/photo-1542291026-7eec264c27ff?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" 
                         class="w-full h-40 object-cover rounded-lg" alt="Sneakers">
                    <p class="text-sm font-medium mt-2">Sneakers $95</p>
                </div>
                <div class="min-w-[200px] rounded-lg p-3 text-center">
                    <img src="https://images.unsplash.com/photo-1578587018452-892bacefd3f2?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" 
                         class="w-full h-40 object-cover rounded-lg" alt="Scarves">
                    <p class="text-sm font-medium mt-2">Scarves $28</p>
                </div>
            </div>
        </div>

        <!-- FOURTH CATEGORY GRID (4 More Columns) -->
        <div class="max-w-7xl mx-auto p-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            
            <!-- Baby & Kids -->
            <div class="bg-white border p-4 flex flex-col">
                <h2 class="font-bold text-lg mb-3">Baby & Kids</h2>
                <div class="grid grid-cols-2 gap-2 flex-grow">
                    <div class="text-center">
                        <img src="https://images.unsplash.com/photo-1544367567-0f2fcb009e0b?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" 
                             class="w-full h-20 object-cover rounded-lg" alt="Baby Clothes">
                        <p class="text-xs mt-1">Baby Clothes $25</p>
                    </div>
                    <div class="text-center">
                        <img src="https://images.unsplash.com/photo-1558618666-fcd25c85cd64?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" 
                             class="w-full h-20 object-cover rounded-lg" alt="Toys">
                        <p class="text-xs mt-1">Toys $18</p>
                    </div>
                    <div class="text-center">
                        <img src="https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" 
                             class="w-full h-20 object-cover rounded-lg" alt="Baby Gear">
                        <p class="text-xs mt-1">Baby Gear $65</p>
                    </div>
                    <div class="text-center">
                        <img src="https://images.unsplash.com/photo-1434030216411-0b793f4b4173?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" 
                             class="w-full h-20 object-cover rounded-lg" alt="School Supplies">
                        <p class="text-xs mt-1">School Supplies $15</p>
                    </div>
                </div>
                <a href="#" class="text-sm text-blue-600 hover:underline mt-4 block text-center">See all</a>
            </div>

            <!-- Health & Wellness -->
            <div class="bg-white border p-4 flex flex-col">
                <h2 class="font-bold text-lg mb-3">Health & Wellness</h2>
                <div class="grid grid-cols-2 gap-2 flex-grow">
                    <div class="text-center">
                        <img src="https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" 
                             class="w-full h-20 object-cover rounded-lg" alt="Vitamins">
                        <p class="text-xs mt-1">Vitamins $35</p>
                    </div>
                    <div class="text-center">
                        <img src="https://images.unsplash.com/photo-1544367567-0f2fcb009e0b?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" 
                             class="w-full h-20 object-cover rounded-lg" alt="Fitness Equipment">
                        <p class="text-xs mt-1">Fitness Equipment $85</p>
                    </div>
                    <div class="text-center">
                        <img src="https://images.unsplash.com/photo-1596462502278-27bfdc403348?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" 
                             class="w-full h-20 object-cover rounded-lg" alt="Personal Care">
                        <p class="text-xs mt-1">Personal Care $28</p>
                    </div>
                    <div class="text-center">
                        <img src="https://images.unsplash.com/photo-1505740420928-5e560c06d30e?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" 
                             class="w-full h-20 object-cover rounded-lg" alt="Medical Supplies">
                        <p class="text-xs mt-1">Medical Supplies $45</p>
                    </div>
                </div>
                <a href="#" class="text-sm text-blue-600 hover:underline mt-4 block text-center">See all</a>
            </div>

            <!-- Food & Grocery -->
            <div class="bg-white border p-4 flex flex-col">
                <h2 class="font-bold text-lg mb-3">Food & Grocery</h2>
                <div class="grid grid-cols-2 gap-2 flex-grow">
                    <div class="text-center">
                        <img src="https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" 
                             class="w-full h-20 object-cover rounded-lg" alt="Snacks">
                        <p class="text-xs mt-1">Snacks $12</p>
                    </div>
                    <div class="text-center">
                        <img src="https://images.unsplash.com/photo-1570222094114-d054a817e56b?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" 
                             class="w-full h-20 object-cover rounded-lg" alt="Beverages">
                        <p class="text-xs mt-1">Beverages $8</p>
                    </div>
                    <div class="text-center">
                        <img src="https://images.unsplash.com/photo-1556909114-f6e7ad7d3136?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" 
                             class="w-full h-20 object-cover rounded-lg" alt="Organic Foods">
                        <p class="text-xs mt-1">Organic Foods $22</p>
                    </div>
                    <div class="text-center">
                        <img src="https://images.unsplash.com/photo-1594736797933-d0f14818176e?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" 
                             class="w-full h-20 object-cover rounded-lg" alt="Frozen Foods">
                        <p class="text-xs mt-1">Frozen Foods $15</p>
                    </div>
                </div>
                <a href="#" class="text-sm text-blue-600 hover:underline mt-4 block text-center">See all</a>
            </div>

            <!-- Tools & Hardware -->
            <div class="bg-white border p-4 flex flex-col">
                <h2 class="font-bold text-lg mb-3">Tools & Hardware</h2>
                <div class="grid grid-cols-2 gap-2 flex-grow">
                    <div class="text-center">
                        <img src="https://images.unsplash.com/photo-1578662996442-48f60103fc96?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" 
                             class="w-full h-20 object-cover rounded-lg" alt="Power Tools">
                        <p class="text-xs mt-1">Power Tools $95</p>
                    </div>
                    <div class="text-center">
                        <img src="https://images.unsplash.com/photo-1486262715619-67b85e0b08d3?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" 
                             class="w-full h-20 object-cover rounded-lg" alt="Hand Tools">
                        <p class="text-xs mt-1">Hand Tools $38</p>
                    </div>
                    <div class="text-center">
                        <img src="https://images.unsplash.com/photo-1562003389-902303a5d0a5?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" 
                             class="w-full h-20 object-cover rounded-lg" alt="Hardware">
                        <p class="text-xs mt-1">Hardware $25</p>
                    </div>
                    <div class="text-center">
                        <img src="https://images.unsplash.com/photo-1416879595882-3373a0480b5b?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" 
                             class="w-full h-20 object-cover rounded-lg" alt="Safety Gear">
                        <p class="text-xs mt-1">Safety Gear $42</p>
                    </div>
                </div>
                <a href="#" class="text-sm text-blue-600 hover:underline mt-4 block text-center">See all</a>
            </div>
        </div>

        <!-- Home Updates Section -->
        <div class="max-w-7xl mx-auto mt-8 p-6 bg-white rounded-lg">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold">Easy updates for elevated spaces</h2>
                <a href="#" class="text-blue-600 hover:underline">Shop home products</a>
            </div>
            <div class="flex space-x-4 overflow-x-auto pb-4 scrollbar-hide">
                <div class="min-w-[200px] text-center p-4 hover:bg-gray-100 rounded-lg transition">
                    <img src="https://images.unsplash.com/photo-1555041469-a586c61ea9bc?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" 
                         class="w-full h-40 object-cover rounded-lg mb-2" alt="Furniture">
                    <p class="font-medium">Furniture</p>
                </div>
                <div class="min-w-[200px] text-center p-4 hover:bg-gray-100 rounded-lg transition">
                    <img src="https://images.unsplash.com/photo-1586023492125-27b2c045efd7?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" 
                         class="w-full h-40 object-cover rounded-lg mb-2" alt="Decor">
                    <p class="font-medium">Decor</p>
                </div>
                <div class="min-w-[200px] text-center p-4 hover:bg-gray-100 rounded-lg transition">
                    <img src="https://images.unsplash.com/photo-1578662996442-48f60103fc96?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" 
                         class="w-full h-40 object-cover rounded-lg mb-2" alt="Hardware">
                    <p class="font-medium">Hardware</p>
                </div>
                <div class="min-w-[200px] text-center p-4 hover:bg-gray-100 rounded-lg transition">
                    <img src="https://images.unsplash.com/photo-1562003389-902303a5d0a5?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" 
                         class="w-full h-40 object-cover rounded-lg mb-2" alt="Paint">
                    <p class="font-medium">Paint</p>
                </div>
                <div class="min-w-[200px] text-center p-4 hover:bg-gray-100 rounded-lg transition">
                    <img src="https://images.unsplash.com/photo-1416879595882-3373a0480b5b?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" 
                         class="w-full h-40 object-cover rounded-lg mb-2" alt="Flooring">
                    <p class="font-medium">Flooring</p>
                </div>
                <div class="min-w-[200px] text-center p-4 hover:bg-gray-100 rounded-lg transition">
                    <img src="https://images.unsplash.com/photo-1571781926291-c477ebfd024b?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" 
                         class="w-full h-40 object-cover rounded-lg mb-2" alt="Lighting">
                    <p class="font-medium">Lighting</p>
                </div>
                <div class="min-w-[200px] text-center p-4 hover:bg-gray-100 rounded-lg transition">
                    <img src="https://images.unsplash.com/photo-1585320806297-9794b3e4eeae?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" 
                         class="w-full h-40 object-cover rounded-lg mb-2" alt="Textiles">
                    <p class="font-medium">Textiles</p>
                </div>
            </div>
        </div>

        <!-- Popular Items Section -->
        <div class="max-w-7xl mx-auto mt-8 p-6 bg-white rounded-lg">
            <h2 class="text-xl font-bold mb-4">Popular items this season</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-gray-50 rounded-lg p-4 hover:shadow-md transition">
                    <img src="https://images.unsplash.com/photo-1544947950-fa07a98d237f?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" 
                         class="w-full h-48 object-cover rounded-lg mb-3" alt="Book">
                    <h3 class="font-bold text-lg">Sapiens: A Brief History</h3>
                    <p class="text-gray-600 mt-1">Yuval Noah Harari</p>
                    <div class="flex justify-between items-center mt-3">
                        <span class="font-bold text-gray-800">$18.99</span>
                        <button class="bg-orange-500 hover:bg-orange-600 text-white py-1 px-3 rounded-lg text-sm">Add to Cart</button>
                    </div>
                </div>
                <div class="bg-gray-50 rounded-lg p-4 hover:shadow-md transition">
                    <img src="https://images.unsplash.com/photo-1505740420928-5e560c06d30e?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" 
                         class="w-full h-48 object-cover rounded-lg mb-3" alt="Headphones">
                    <h3 class="font-bold text-lg">Wireless Headphones</h3>
                    <p class="text-gray-600 mt-1">Noise Cancelling</p>
                    <div class="flex justify-between items-center mt-3">
                        <span class="font-bold text-gray-800">$89.99</span>
                        <button class="bg-orange-500 hover:bg-orange-600 text-white py-1 px-3 rounded-lg text-sm">Add to Cart</button>
                    </div>
                </div>
                <div class="bg-gray-50 rounded-lg p-4 hover:shadow-md transition">
                    <img src="https://images.unsplash.com/photo-1575311373937-040b8e1fd5b6?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" 
                         class="w-full h-48 object-cover rounded-lg mb-3" alt="Fitness Tracker">
                    <h3 class="font-bold text-lg">Fitness Tracker</h3>
                    <p class="text-gray-600 mt-1">Smart Watch</p>
                    <div class="flex justify-between items-center mt-3">
                        <span class="font-bold text-gray-800">$49.99</span>
                        <button class="bg-orange-500 hover:bg-orange-600 text-white py-1 px-3 rounded-lg text-sm">Add to Cart</button>
                    </div>
                </div>
                <div class="bg-gray-50 rounded-lg p-4 hover:shadow-md transition">
                    <img src="https://images.unsplash.com/photo-1571914001156-9c1d6c9247b8?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" 
                         class="w-full h-48 object-cover rounded-lg mb-3" alt="Outdoor Play Set">
                    <h3 class="font-bold text-lg">Outdoor Play Set</h3>
                    <p class="text-gray-600 mt-1">For Kids & Family</p>
                    <div class="flex justify-between items-center mt-3">
                        <span class="font-bold text-gray-800">$129.99</span>
                        <button class="bg-orange-500 hover:bg-orange-600 text-white py-1 px-3 rounded-lg text-sm">Add to Cart</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-slot name="scripts">
        <script>
            // Hero Slider Functionality
            document.addEventListener('DOMContentLoaded', function() {
                const hero = document.querySelector('.hero-slider');
                const prevBtn = document.getElementById('prevBtn');
                const nextBtn = document.getElementById('nextBtn');
                
                // Hero content data
                const heroData = [
                    {
                        image: 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?ixlib=rb-4.0.3&auto=format&fit=crop&w=1600&q=80',
                        title: 'Digital Marketplace for Everything',
                        subtitle: 'Buy, rent, or sell websites, apps, and digital products'
                    },
                    {
                        image: 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?ixlib=rb-4.0.3&auto=format&fit=crop&w=1600&q=80',
                        title: 'Ready-Made Websites & Apps',
                        subtitle: 'Launch your business instantly with premium digital assets'
                    },
                    {
                        image: 'https://images.unsplash.com/photo-1563013544-824ae1b704d3?ixlib=rb-4.0.3&auto=format&fit=crop&w=1600&q=80',
                        title: 'Software Solutions Marketplace',
                        subtitle: 'Discover tools and software to power your business'
                    }
                ];
                
                let currentBg = 0;
                
                // Function to change hero content
                function changeHeroContent(direction) {
                    if (direction === 'next') {
                        currentBg = (currentBg + 1) % heroData.length;
                    } else {
                        currentBg = (currentBg - 1 + heroData.length) % heroData.length;
                    }
                    
                    const currentData = heroData[currentBg];
                    hero.querySelector('img').src = currentData.image;
                    document.getElementById('hero-title').textContent = currentData.title;
                    document.getElementById('hero-subtitle').textContent = currentData.subtitle;
                }
                
                // Event listeners for arrows
                prevBtn.addEventListener('click', function() {
                    changeHeroContent('prev');
                });
                
                nextBtn.addEventListener('click', function() {
                    changeHeroContent('next');
                });
                
                // Auto change hero content every 5 seconds
                setInterval(function() {
                    changeHeroContent('next');
                }, 5000);
            });
        </script>
    </x-slot>
</x-guest1-layout>
