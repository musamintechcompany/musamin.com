<!-- Marketplace Navigation -->
<nav id="marketplace-nav" class="bg-black border-b border-gray-700 fixed top-0 left-0 right-0 z-50 transition-transform duration-300">
    <div class="container mx-auto px-4">
        <!-- Desktop Layout -->
        <div class="hidden sm:flex items-center justify-between h-12">
            <!-- Hamburger Menu & Logo -->
            <div class="flex items-center space-x-3">
                <!-- Hamburger Menu -->
                <button class="p-2 text-white hover:text-blue-400 hover:bg-gray-800 rounded">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
                
                <!-- Logo & Brand -->
                <a href="{{ route('home') }}" class="flex items-center">
                    <img src="{{ asset('storage/logos/dark-mood-logo.jpg') }}" alt="Marketplace Logo" class="h-8">
                </a>
                
                <!-- Location -->
                <div class="flex items-center text-white text-sm">
                    <i class="fas fa-map-marker-alt mr-1"></i>
                    <span id="location-text">Loading...</span>
                </div>
            </div>

            <!-- Search Bar -->
            <div class="flex-1 max-w-4xl mx-6">
                <form action="{{ route('market-place.index') }}" method="GET" class="flex">
                    <!-- All Button with Dropdown -->
                    <div class="relative">
                        <button type="button" id="category-dropdown" class="px-3 py-1.5 bg-gray-700 border border-gray-600 rounded-l text-sm text-white hover:bg-gray-600 flex items-center">
                            All
                            <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div id="category-menu" class="absolute top-full left-0 mt-1 w-48 bg-gray-800 border border-gray-600 rounded shadow-lg z-10 hidden">
                            <a href="#" class="block px-4 py-2 text-sm text-white hover:bg-gray-700">All Categories</a>
                            <a href="#" class="block px-4 py-2 text-sm text-white hover:bg-gray-700">Electronics</a>
                            <a href="#" class="block px-4 py-2 text-sm text-white hover:bg-gray-700">Fashion</a>
                            <a href="#" class="block px-4 py-2 text-sm text-white hover:bg-gray-700">Home & Garden</a>
                            <a href="#" class="block px-4 py-2 text-sm text-white hover:bg-gray-700">Sports</a>
                            <a href="#" class="block px-4 py-2 text-sm text-white hover:bg-gray-700">Books</a>
                        </div>
                    </div>
                    
                    <!-- Search Input -->
                    <div class="relative flex-1">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search products..." class="w-full px-3 py-1.5 border border-gray-600 rounded-r text-sm bg-gray-700 text-white placeholder-gray-400 focus:ring-1 focus:ring-blue-500 focus:border-blue-500">
                        <button type="submit" class="absolute right-2 top-1 p-1 text-gray-400 hover:text-gray-300">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </button>
                    </div>
                </form>
            </div>

            <!-- Right Side Icons -->
            <div class="flex items-center space-x-4">
                <!-- Language Flags -->
                <div class="flex items-center space-x-2">
                    <button class="text-white hover:text-blue-400 text-lg">🇺🇸</button>
                    <button class="text-white hover:text-blue-400 text-lg">🇪🇸</button>
                    <button class="text-white hover:text-blue-400 text-lg">🇫🇷</button>
                    <button class="text-white hover:text-blue-400 text-lg">🇩🇪</button>
                </div>
                
                <!-- Cart Icon -->
                <button class="p-2 text-white hover:text-blue-400">
                    <i class="fas fa-shopping-cart"></i>
                </button>

                <!-- User Menu -->
                @auth
                    <a href="{{ route('dashboard') }}" class="text-white hover:text-blue-400 font-medium">Dashboard</a>
                @else
                    <span class="text-white font-medium">Login</span>
                @endauth
            </div>
        </div>
        
        <!-- Mobile Layout -->
        <div class="flex sm:hidden flex-col space-y-2 py-2">
            <!-- Top Row: Hamburger, Logo, Language, Cart, User -->
            <div class="flex items-center justify-between w-full">
                <!-- Mobile Hamburger -->
                <button class="p-1 text-white hover:text-blue-400 hover:bg-gray-800 rounded">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>

                <!-- Mobile Logo & Location -->
                <div class="flex items-center space-x-2">
                    <a href="{{ route('home') }}" class="flex items-center">
                        <img src="{{ asset('storage/logos/dark-mood-logo.jpg') }}" alt="Marketplace Logo" class="h-6">
                    </a>
                    <div class="flex items-center text-white text-xs">
                        <i class="fas fa-map-marker-alt mr-1"></i>
                        <span id="mobile-location-text">Loading...</span>
                    </div>
                </div>

                <div class="flex items-center space-x-2">
                    <!-- Mobile Language Flags -->
                    <div class="flex items-center space-x-1">
                        <button class="text-white hover:text-blue-400">🇺🇸</button>
                        <button class="text-white hover:text-blue-400">🇪🇸</button>
                        <button class="text-white hover:text-blue-400">🇫🇷</button>
                        <button class="text-white hover:text-blue-400">🇩🇪</button>
                    </div>
                    
                    <!-- Mobile Cart -->
                    <button class="p-1 text-white hover:text-blue-400">
                        <i class="fas fa-shopping-cart"></i>
                    </button>

                    <!-- Mobile User -->
                    @auth
                        <a href="{{ route('dashboard') }}" class="text-xs text-white hover:text-blue-400 font-medium">Dashboard</a>
                    @else
                        <span class="text-xs text-white font-medium">Login</span>
                    @endauth
                </div>
            </div>

            <!-- Bottom Row: Search Bar -->
            <div class="w-full">
                <form action="{{ route('market-place.index') }}" method="GET" class="flex">
                    <!-- Mobile All Button -->
                    <div class="relative">
                        <button type="button" id="category-dropdown-mobile" class="px-2 py-1.5 bg-gray-700 border border-gray-600 rounded-l text-xs text-white hover:bg-gray-600 flex items-center">
                            All
                            <svg class="w-2 h-2 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                    </div>
                    
                    <!-- Mobile Search Input -->
                    <div class="relative flex-1">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search..." class="w-full px-2 py-1.5 border border-gray-300 rounded-r text-xs focus:ring-1 focus:ring-blue-500 focus:border-blue-500">
                        <button type="submit" class="absolute right-1 top-1 p-0.5 text-gray-400 hover:text-gray-600">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</nav>

<script>
// Category dropdown functionality
const categoryDropdown = document.getElementById('category-dropdown');
const categoryMenu = document.getElementById('category-menu');

if (categoryDropdown && categoryMenu) {
    categoryDropdown.addEventListener('click', () => {
        categoryMenu.classList.toggle('hidden');
    });
    
    // Close dropdown when clicking outside
    document.addEventListener('click', (event) => {
        if (!categoryDropdown.contains(event.target) && !categoryMenu.contains(event.target)) {
            categoryMenu.classList.add('hidden');
        }
    });
}
</script>

<script>
// Scroll-based nav show/hide functionality
let lastScrollTop = 0;
const nav = document.getElementById('marketplace-nav');

window.addEventListener('scroll', function() {
    const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
    
    if (scrollTop > lastScrollTop && scrollTop > 100) {
        // Scrolling down - hide nav
        nav.style.transform = 'translateY(-100%)';
    } else {
        // Scrolling up - show nav
        nav.style.transform = 'translateY(0)';
    }
    
    lastScrollTop = scrollTop;
});
</script>

<script>
// Server-side location detection
document.addEventListener('DOMContentLoaded', function() {
    const locationText = document.getElementById('location-text');
    const mobileLocationText = document.getElementById('mobile-location-text');
    
    fetch('/api/location')
        .then(response => response.json())
        .then(data => {
            const city = data.city || 'Unknown';
            const country = data.country || 'XX';
            const locationString = `${city}, ${country}`;
            const mobileLocationString = `${city.substring(0, 8)}, ${country}`;
            
            if (locationText) locationText.textContent = locationString;
            if (mobileLocationText) mobileLocationText.textContent = mobileLocationString;
        })
        .catch(() => {
            if (locationText) locationText.textContent = 'Location unavailable';
            if (mobileLocationText) mobileLocationText.textContent = 'Unavailable';
        });
});
</script>