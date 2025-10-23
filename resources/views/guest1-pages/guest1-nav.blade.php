@php
    $navLinks = [
        ['label' => 'Home', 'route' => 'home'],
        ['label' => 'Marketplace', 'route' => 'market-place.index'],
        ['label' => 'How It Works', 'route' => 'how-it-works'],
        ['label' => 'Testimonials', 'route' => 'testimonials'],
        ['label' => 'Contact Us', 'route' => 'contact'],
        ['label' => 'Affiliate Network', 'route' => 'affiliate'],
    ];
@endphp

<div id="navbar-container" class="w-full transition-transform duration-300">
    <nav class="w-full bg-gray-900 border-b border-gray-800 shadow-lg">
        <div class="container px-2 py-1 mx-auto max-w-7xl sm:px-4 sm:py-1.5">
            <!-- Desktop Layout -->
            <div class="hidden sm:flex items-center">
                <!-- Mobile Hamburger -->
                <button id="mobile-menu-toggle-desktop" class="mr-2 p-1 rounded hover:bg-gray-800 focus:outline-none transition-all duration-200 sm:mr-3 sm:p-1.5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="text-white w-5 h-5 sm:w-6 sm:h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>

            <!-- Logo -->
            <a href="{{ url('/') }}" class="flex items-center mr-4 text-sm font-bold text-white hover:text-gray-200 transition-colors duration-200 no-underline">
                <div class="w-6 h-6 mr-1 bg-gradient-to-br from-white to-gray-200 rounded flex items-center justify-center">
                    <svg class="w-3 h-3 text-gray-900" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
                    </svg>
                </div>
                <span class="hidden sm:block">{{ config('app.name') }}</span>
            </a>

            <!-- Search Bar -->
            <div class="flex-1 max-w-4xl mx-6">
                <div class="flex relative">
                    <div class="relative">
                        <button id="category-dropdown" class="px-2 py-1 text-xs bg-white border border-gray-300 rounded-l hover:bg-gray-100 focus:outline-none flex items-center">
                            All
                            <svg class="w-2 h-2 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div id="category-menu" class="absolute top-full left-0 mt-1 w-48 bg-white border border-gray-300 rounded-md shadow-lg z-10 hidden">
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">All Categories</a>
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">E-commerce</a>
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Blogs</a>
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">SaaS</a>
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Portfolios</a>
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Mobile Apps</a>
                        </div>
                    </div>
                    <input type="text" placeholder="Search products..." class="flex-1 px-2 py-1 text-xs border-t border-b border-gray-300 focus:ring-1 focus:ring-orange-500 focus:border-orange-500">
                    <button class="px-2 py-1 text-white bg-orange-500 rounded-r hover:bg-orange-600">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Right side -->
            <div class="flex items-center ml-2 space-x-2">
                <!-- Language Selector -->
                <div class="relative">
                    <button id="language-dropdown" class="flex items-center space-x-1 px-2 py-1 text-white hover:text-gray-200 hover:bg-gray-800 rounded transition-all duration-200">
                        <span class="text-sm">🇺🇸</span>
                        <span class="text-xs font-medium hidden sm:block">EN</span>
                        <svg class="w-2 h-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div id="language-menu" class="absolute top-full right-0 mt-1 w-32 bg-white border border-gray-300 rounded shadow-lg z-10 hidden">
                        <a href="#" class="flex items-center space-x-2 px-3 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            <span>🇺🇸</span>
                            <span>English</span>
                        </a>
                        <a href="#" class="flex items-center space-x-2 px-3 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            <span>🇪🇸</span>
                            <span>Español</span>
                        </a>
                        <a href="#" class="flex items-center space-x-2 px-3 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            <span>🇫🇷</span>
                            <span>Français</span>
                        </a>
                    </div>
                </div>

                <!-- User/Register/Dashboard -->
                @auth
                    <a href="{{ route('dashboard') }}" class="flex items-center space-x-1 px-2 py-1 text-white hover:text-gray-200 hover:bg-gray-800 rounded transition-all duration-200 group no-underline">
                        <div class="w-5 h-5 bg-gradient-to-br from-white to-gray-200 rounded-full flex items-center justify-center group-hover:from-gray-100 group-hover:to-gray-300 transition-all duration-200">
                            <svg class="w-3 h-3 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <span class="text-xs font-medium hidden lg:block">Dashboard</span>
                    </a>
                @else
                    <a href="{{ route('register') }}" class="flex items-center space-x-1 px-2 py-1 text-white hover:text-gray-200 hover:bg-gray-800 rounded transition-all duration-200 group no-underline">
                        <div class="w-5 h-5 bg-gradient-to-br from-white to-gray-200 rounded-full flex items-center justify-center group-hover:from-gray-100 group-hover:to-gray-300 transition-all duration-200">
                            <svg class="w-3 h-3 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <span class="text-xs font-medium hidden lg:block">Register</span>
                    </a>
                @endauth

                <!-- Mobile Login/Dashboard -->
                <div class="flex items-center md:hidden">
                    @auth
                        <a href="{{ route('dashboard') }}" class="px-2 py-1 text-xs font-medium text-white bg-gray-800 border border-gray-600 rounded hover:bg-gray-700 transition-all duration-200">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="px-2 py-1 text-xs font-medium text-white bg-gray-800 border border-gray-600 rounded hover:bg-gray-700 transition-all duration-200">Login</a>
                    @endauth
                </div>

                <!-- Cart Icon -->
                <button class="relative p-1.5 text-white hover:text-gray-200 hover:bg-gray-800 rounded transition-all duration-200 group">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5"></path>
                    </svg>
                </button>

                <!-- Heart Icon -->
                <button class="p-1.5 text-white hover:text-gray-200 hover:bg-gray-800 rounded transition-all duration-200 group">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                </button>
            </div>
            
            </div>

            <!-- Mobile Layout -->
            <div class="flex sm:hidden flex-col space-y-2">
                <!-- Top Row: Hamburger, Logo, User, Cart -->
                <div class="flex items-center justify-between w-full">
                    <!-- Mobile Hamburger -->
                    <button id="mobile-menu-toggle-top" class="p-1 rounded hover:bg-gray-800 focus:outline-none transition-all duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="text-white w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>

                    <!-- Mobile Logo -->
                    <a href="{{ url('/') }}" class="flex items-center text-sm font-bold text-white hover:text-gray-200 transition-colors duration-200 no-underline">
                        <div class="w-5 h-5 mr-1 bg-gradient-to-br from-white to-gray-200 rounded flex items-center justify-center">
                            <svg class="w-3 h-3 text-gray-900" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
                            </svg>
                        </div>
                        <span>{{ config('app.name') }}</span>
                    </a>

                    <div class="flex items-center space-x-2">
                        <!-- Mobile User/Login/Dashboard -->
                        @auth
                            <a href="{{ route('dashboard') }}" class="flex items-center px-2 py-1 text-white hover:text-gray-200 hover:bg-gray-800 rounded transition-all duration-200 group no-underline">
                                <div class="w-4 h-4 bg-gradient-to-br from-white to-gray-200 rounded-full flex items-center justify-center group-hover:from-gray-100 group-hover:to-gray-300 transition-all duration-200">
                                    <svg class="w-2 h-2 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                                <span class="text-xs ml-1">Dashboard</span>
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="flex items-center px-2 py-1 text-white hover:text-gray-200 hover:bg-gray-800 rounded transition-all duration-200 group no-underline">
                                <div class="w-4 h-4 bg-gradient-to-br from-white to-gray-200 rounded-full flex items-center justify-center group-hover:from-gray-100 group-hover:to-gray-300 transition-all duration-200">
                                    <svg class="w-2 h-2 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                                <span class="text-xs ml-1">Login</span>
                            </a>
                        @endauth

                        <!-- Mobile Cart -->
                        <button class="p-1 text-white hover:text-gray-200 hover:bg-gray-800 rounded transition-all duration-200 group">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5"></path>
                            </svg>
                        </button>

                        <!-- Mobile Heart -->
                        <button class="p-1 text-white hover:text-gray-200 hover:bg-gray-800 rounded transition-all duration-200 group">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Bottom Row: Search Bar -->
                <div class="w-full">
                    <div class="flex relative">
                        <div class="relative">
                            <button id="category-dropdown-mobile" class="px-2 py-1.5 text-xs bg-white border border-gray-300 rounded-l hover:bg-gray-100 focus:outline-none flex items-center">
                                <span>≡</span>
                                <svg class="w-2 h-2 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                        </div>
                        <input type="text" placeholder="Search..." class="flex-1 px-2 py-1.5 text-xs border-t border-b border-gray-300 focus:ring-1 focus:ring-orange-500 focus:border-orange-500">
                        <button class="px-2 py-1.5 text-white bg-orange-500 rounded-r hover:bg-orange-600">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </nav>


</div>

<!-- Mobile Sidebar Menu -->
<div id="mobile-menu-overlay" class="fixed inset-0 z-40 hidden transition-opacity bg-black bg-opacity-50" onclick="closeSidebar()"></div>

<div id="mobile-sidebar" class="fixed inset-y-0 left-0 z-50 w-64 transition-transform duration-300 ease-in-out transform -translate-x-full bg-white shadow-lg">
    <div class="flex items-center justify-between px-6 py-4 border-b">
        <span class="text-lg font-bold text-gray-900">{{ config('app.name') }}</span>
        <button id="mobile-menu-close" class="focus:outline-none" onclick="closeSidebar()">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <div class="px-6 py-4 space-y-4">
        <div class="grid grid-cols-2 gap-3 mb-4">
            @auth
                <a href="{{ route('dashboard') }}" class="col-span-2 px-4 py-2 text-sm font-medium text-center text-white transition-colors duration-200 bg-gray-900 rounded-lg hover:bg-gray-800" onclick="closeSidebar()">Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="px-4 py-2 text-sm font-medium text-center text-gray-900 transition-colors duration-200 border border-gray-900 rounded-lg hover:bg-gray-50" onclick="closeSidebar()">Login</a>
                <a href="{{ route('register') }}" class="px-4 py-2 text-sm font-medium text-center text-white transition-colors duration-200 bg-gray-900 rounded-lg hover:bg-gray-800" onclick="closeSidebar()">Register</a>
            @endauth
        </div>

        <div class="pt-4 border-t border-gray-200">
            @foreach ($navLinks as $link)
                <a href="{{ route($link['route']) }}"
                   class="block py-2 nav-link {{ request()->routeIs($link['route']) ? 'active text-orange-500 font-semibold' : 'text-gray-700 hover:text-orange-500' }} transition-colors duration-200"
                   onclick="closeSidebar()">
                    {{ $link['label'] }}
                </a>
            @endforeach
        </div>
    </div>
</div>

<!-- Scroll + Mobile Script -->
<script>
    const toggleMobile = document.getElementById('mobile-menu-toggle-top');
    const toggleDesktop = document.getElementById('mobile-menu-toggle-desktop');
    const closeBtn = document.getElementById('mobile-menu-close');
    const overlay = document.getElementById('mobile-menu-overlay');
    const sidebar = document.getElementById('mobile-sidebar');

    let lastScrollTop = 0;
    const navbarContainer = document.getElementById('navbar-container');
    
    // Function to open sidebar
    function openSidebar() {
        overlay.classList.remove('hidden');
        setTimeout(() => overlay.classList.add('opacity-100'), 10);
        sidebar.classList.remove('-translate-x-full');
        sidebar.classList.add('translate-x-0');
        document.body.style.overflow = 'hidden';
    }

    // Open sidebar for mobile
    if (toggleMobile) {
        toggleMobile.addEventListener('click', openSidebar);
    }

    // Open sidebar for desktop
    if (toggleDesktop) {
        toggleDesktop.addEventListener('click', openSidebar);
    }

    // Close sidebar
    function closeSidebar() {
        overlay.classList.add('hidden');
        overlay.classList.remove('opacity-100');
        sidebar.classList.add('-translate-x-full');
        sidebar.classList.remove('translate-x-0');
        document.body.style.overflow = 'auto';
    }

    closeBtn.addEventListener('click', closeSidebar);
    overlay.addEventListener('click', closeSidebar);

    // Close sidebar when clicking outside
    document.addEventListener('click', (event) => {
        const isClickInsideSidebar = sidebar.contains(event.target);
        const isClickOnMobileToggle = toggleMobile && toggleMobile.contains(event.target);
        const isClickOnDesktopToggle = toggleDesktop && toggleDesktop.contains(event.target);
        const isSidebarOpen = !sidebar.classList.contains('-translate-x-full');

        if (!isClickInsideSidebar && !isClickOnMobileToggle && !isClickOnDesktopToggle && isSidebarOpen) {
            closeSidebar();
        }
    });

    // Close sidebar on escape key
    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') {
            closeSidebar();
        }
    });

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

    // Language dropdown functionality
    const languageDropdown = document.getElementById('language-dropdown');
    const languageMenu = document.getElementById('language-menu');
    
    if (languageDropdown && languageMenu) {
        languageDropdown.addEventListener('click', () => {
            languageMenu.classList.toggle('hidden');
        });
        
        // Close dropdown when clicking outside
        document.addEventListener('click', (event) => {
            if (!languageDropdown.contains(event.target) && !languageMenu.contains(event.target)) {
                languageMenu.classList.add('hidden');
            }
        });
    }
</script>