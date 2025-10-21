<aside id="sidebar" class="sidebar collapsed">
    <style>
        .sidebar::-webkit-scrollbar {
            display: none;
        }

        .sidebar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1200;
            width: 250px;
            height: 100vh;
            background: white;
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
            overflow-y: auto;
            overflow-x: hidden;
            transform: translateX(-100%);
        }

        .sidebar.active {
            transform: translateX(0);
            width: 17rem;
        }

        @media (min-width: 768px) {
            .sidebar {
                transform: translateX(0);
                width: 70px;
            }
            .sidebar:not(.collapsed) {
                width: 250px;
            }
            .sidebar.active {
                width: auto;
            }
        }

        .sidebar.collapsed {
            width: 70px;
        }

        body.sidebar-open {
            overflow: hidden;
        }

        body.sidebar-open::after {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.7);
            z-index: 1100;
            pointer-events: auto;
        }

        @keyframes pulse {
            0% { box-shadow: 0 0 0 0 rgba(99, 102, 241, 0.2); }
            70% { box-shadow: 0 0 0 6px rgba(99, 102, 241, 0); }
            100% { box-shadow: 0 0 0 0 rgba(99, 102, 241, 0); }
        }
        .nav-item.active {
            animation: pulse 2s infinite;
            position: relative;
            z-index: 1;
        }

        .app-brand {
            display: flex;
            align-items: center;
            padding: 1rem 1rem 1rem 1.5rem;
            position: sticky;
            top: 0;
            background: white;
            z-index: 10;
            gap: 10px;
            height: 60px;
            box-sizing: border-box;
        }

        .sidebar.collapsed .app-brand {
            justify-content: center;
            padding: 1rem 0;
            gap: 0;
        }

        .app-logo {
            height: 32px;
            width: 32px;
            object-fit: contain;
            margin: 0 auto;
        }

        .sidebar:not(.collapsed) .app-logo {
            margin: 0;
        }

        .app-name {
            font-size: 1.1rem;
            font-weight: 600;
            white-space: nowrap;
            transition: opacity 0.3s ease;
            color: #111827;
        }

        .sidebar.collapsed .app-name {
            opacity: 0;
            width: 0;
        }

        .nav-content {
            flex: 1;
            padding: 0.5rem 1rem 1rem;
            display: flex;
            flex-direction: column;
        }

        .nav-item {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            margin-bottom: 0.25rem;
            transition: all 0.3s ease;
            color: #4b5563;
            text-decoration: none;
            font-size: 0.95rem;
        }

        .sidebar.collapsed .nav-item {
            justify-content: center;
            padding: 0.75rem 0;
        }

        .nav-item:hover {
            background-color: rgba(0, 0, 0, 0.05);
        }

        .nav-item.home.active {
            background-color: rgba(239, 68, 68, 0.1);
            color: #EF4444;
        }
        .nav-item.marketplace.active {
            background-color: rgba(59, 130, 246, 0.1);
            color: #3B82F6;
        }
        .nav-item.stores.active {
            background-color: rgba(16, 185, 129, 0.1);
            color: #10B981;
        }
        .nav-item.assets.active {
            background-color: rgba(245, 158, 11, 0.1);
            color: #F59E0B;
        }
        .nav-item.wallet.active {
            background-color: rgba(139, 92, 246, 0.1);
            color: #8B5CF6;
        }
        .nav-item.coins.active {
            background-color: rgba(234, 179, 8, 0.1);
            color: #EAB308;
        }
        .nav-item.ideas.active {
            background-color: rgba(236, 72, 153, 0.1);
            color: #EC4899;
        }
        .nav-item.settings.active {
            background-color: rgba(107, 114, 128, 0.1);
            color: #6B7280;
        }
        .nav-item.support.active {
            background-color: rgba(20, 184, 166, 0.1);
            color: #14B8A6;
        }
        .nav-item.inbox.active {
            background-color: rgba(168, 85, 247, 0.1);
            color: #A855F7;
        }
        .nav-item.orders.active {
            background-color: rgba(34, 197, 94, 0.1);
            color: #22C55E;
        }

        .nav-icon.home {
            color: #EF4444;
        }
        .nav-icon.marketplace {
            color: #3B82F6;
        }
        .nav-icon.stores {
            color: #10B981;
        }
        .nav-icon.assets {
            color: #F59E0B;
        }
        .nav-icon.wallet {
            color: #8B5CF6;
        }
        .nav-icon.coins {
            color: #EAB308;
        }
        .nav-icon.ideas {
            color: #EC4899;
        }
        .nav-icon.settings {
            color: #6B7280;
        }
        .nav-icon.support {
            color: #14B8A6;
        }
        .nav-icon.inbox {
            color: #A855F7;
        }
        .nav-icon.orders {
            color: #22C55E;
        }

        .nav-icon {
            font-size: 1.1rem;
            min-width: 24px;
            text-align: center;
            margin-right: 12px;
        }

        .sidebar.collapsed .nav-icon {
            margin-right: 0;
        }

        .nav-text {
            transition: opacity 0.3s ease;
            white-space: nowrap;
        }

        .sidebar.collapsed .nav-text {
            opacity: 0;
            width: 0;
        }

        .affiliate-promo {
            padding: 1rem;
            position: sticky;
            bottom: 0;
            background: white;
            border-top: 1px solid #e5e7eb;
            min-height: 72px;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.75rem;
        }

        .sidebar.collapsed .affiliate-promo {
            padding: 0.5rem 0;
            min-height: auto;
            border-top: 1px solid #e5e7eb;
        }
        
        .sidebar.collapsed .affiliate-text {
            display: none;
        }
        
        .sidebar.collapsed .join-button {
            width: auto;
            padding: 0.75rem 0;
            background: none;
            box-shadow: none;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        
        .sidebar.collapsed .join-button:hover {
            transform: none;
            box-shadow: none;
            background-color: rgba(0, 0, 0, 0.05);
        }
        
        .sidebar.collapsed .join-button .btn-text {
            display: none;
        }
        
        .sidebar.collapsed .join-button i {
            margin: 0;
            font-size: 1.1rem;
            color: #6366F1;
        }

        .affiliate-text {
            font-size: 0.85rem;
            text-align: center;
            line-height: 1.4;
            font-weight: 600;
            background: linear-gradient(90deg, #FF4D4D, #F9CB28, #FF4D4D);
            background-size: 200% auto;
            color: transparent;
            -webkit-background-clip: text;
            background-clip: text;
            animation: shine 2s linear infinite;
        }

        @keyframes shine {
            0% {
                background-position: 0% center;
            }
            100% {
                background-position: 200% center;
            }
        }

        .join-button {
            background: linear-gradient(135deg, #6366F1 0%, #8B5CF6 50%, #D946EF 100%);
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            font-size: 0.85rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            width: 100%;
            text-align: center;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        }

        .join-button:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        .sidebar.collapsed .nav-item {
            position: relative;
        }

        .user-tooltip {
            position: fixed;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            font-size: 0.875rem;
            font-weight: 600;
            white-space: nowrap;
            z-index: 9999;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            opacity: 0;
            transform: translateX(-10px);
            transition: all 0.2s ease-out;
            pointer-events: none;
        }

        .user-tooltip.show {
            opacity: 1;
            transform: translateX(0);
        }

        .user-tooltip::before {
            content: '';
            position: absolute;
            left: -6px;
            top: 50%;
            transform: translateY(-50%);
            border: 6px solid transparent;
        }

        .user-tooltip.home {
            background: linear-gradient(135deg, #EF4444 0%, #DC2626 100%);
        }
        .user-tooltip.home::before {
            border-right-color: #EF4444;
        }

        .user-tooltip.marketplace {
            background: linear-gradient(135deg, #3B82F6 0%, #2563EB 100%);
        }
        .user-tooltip.marketplace::before {
            border-right-color: #3B82F6;
        }

        .user-tooltip.stores {
            background: linear-gradient(135deg, #10B981 0%, #059669 100%);
        }
        .user-tooltip.stores::before {
            border-right-color: #10B981;
        }

        .user-tooltip.assets {
            background: linear-gradient(135deg, #F59E0B 0%, #D97706 100%);
        }
        .user-tooltip.assets::before {
            border-right-color: #F59E0B;
        }

        .user-tooltip.wallet {
            background: linear-gradient(135deg, #8B5CF6 0%, #7C3AED 100%);
        }
        .user-tooltip.wallet::before {
            border-right-color: #8B5CF6;
        }

        .user-tooltip.coins {
            background: linear-gradient(135deg, #EAB308 0%, #CA8A04 100%);
        }
        .user-tooltip.coins::before {
            border-right-color: #EAB308;
        }

        .user-tooltip.ideas {
            background: linear-gradient(135deg, #EC4899 0%, #DB2777 100%);
        }
        .user-tooltip.ideas::before {
            border-right-color: #EC4899;
        }

        .user-tooltip.settings {
            background: linear-gradient(135deg, #6B7280 0%, #4B5563 100%);
        }
        .user-tooltip.settings::before {
            border-right-color: #6B7280;
        }

        .user-tooltip.support {
            background: linear-gradient(135deg, #14B8A6 0%, #0D9488 100%);
        }
        .user-tooltip.support::before {
            border-right-color: #14B8A6;
        }

        .user-tooltip.inbox {
            background: linear-gradient(135deg, #A855F7 0%, #9333EA 100%);
        }
        .user-tooltip.inbox::before {
            border-right-color: #A855F7;
        }

        .user-tooltip.orders {
            background: linear-gradient(135deg, #22C55E 0%, #16A34A 100%);
        }
        .user-tooltip.orders::before {
            border-right-color: #22C55E;
        }

        @media (max-width: 767px) {
            .user-tooltip {
                display: none;
            }
        }

        .dark .sidebar {
            background-color: #1f2937;
        }

        .dark .app-brand,
        .dark .affiliate-promo {
            background-color: #1f2937;
            border-top-color: #374151;
        }

        .dark .app-name {
            color: white;
        }

        .dark .nav-item {
            color: #9ca3af;
        }

        .dark .nav-item:hover {
            background-color: rgba(255, 255, 255, 0.05);
        }

        .dark .affiliate-text {
            color: #9ca3af;
        }
    </style>

    <div class="sidebar-content">
        <div class="app-brand">
            <img src="{{ asset('storage/logos/short-light-mood-logo.jpg') }}" alt="Logo" class="app-logo block dark:hidden">
            <img src="{{ asset('storage/logos/short-dark-mood-logo.jpg') }}" alt="Logo" class="app-logo hidden dark:block">
            <span class="app-name">{{ config('app.name', 'Laravel') }}</span>
        </div>

        <div class="nav-content">
            <a href="{{ route('dashboard') }}" class="nav-item home {{ request()->routeIs('dashboard') ? 'active' : '' }}" data-tooltip="Dashboard">
                <i class="nav-icon fas fa-tachometer-alt home"></i>
                <span class="nav-text">Dashboard</span>
            </a>
            <a href="{{ route('market-place.index') }}" class="nav-item marketplace {{ request()->routeIs('marketplace') ? 'active' : '' }}" data-tooltip="Marketplace">
                <i class="nav-icon fas fa-store marketplace"></i>
                <span class="nav-text">Marketplace</span>
            </a>
            <a href="{{ route('stores') }}" class="nav-item stores {{ request()->routeIs('stores') ? 'active' : '' }}" data-tooltip="Stores">
                <i class="nav-icon fas fa-store-alt stores"></i>
                <span class="nav-text">Stores</span>
            </a>

            <a href="{{ route('wallet') }}" class="nav-item wallet {{ request()->routeIs('wallet') ? 'active' : '' }}" data-tooltip="Wallet">
                <i class="nav-icon fas fa-wallet wallet"></i>
                <span class="nav-text">Wallet</span>
            </a>
            <a href="{{ route('inbox.index') }}" class="nav-item inbox {{ request()->routeIs('inbox.*') ? 'active' : '' }}" data-tooltip="Inbox">
                <div class="relative">
                    <i class="nav-icon fas fa-inbox inbox"></i>
                    <span id="inboxBadge" class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-4 h-4 flex items-center justify-center" style="display: none;">0</span>
                </div>
                <span class="nav-text">Inbox</span>
            </a>
            <a href="{{ route('coin-packages.index') }}" class="nav-item coins {{ request()->routeIs('coin-packages.*') ? 'active' : '' }}" data-tooltip="Buy Coins">
                <i class="nav-icon fas fa-coins coins"></i>
                <span class="nav-text">Buy Coins</span>
            </a>
            <a href="{{ route('orders.index') }}" class="nav-item orders {{ request()->routeIs('orders.*') ? 'active' : '' }}" data-tooltip="My Orders">
                <i class="nav-icon fas fa-shopping-bag orders"></i>
                <span class="nav-text">My Orders</span>
            </a>

            <div class="pt-2 mt-2 border-t border-gray-200 dark:border-gray-700">
                <a href="{{ route('ideas.index') }}" class="nav-item ideas {{ request()->routeIs('ideas.index') ? 'active' : '' }}" data-tooltip="My Ideas">
                    <i class="nav-icon fas fa-lightbulb ideas"></i>
                    <span class="nav-text">My Ideas</span>
                </a>
                <a href="{{ route('settings') }}" class="nav-item settings {{ request()->routeIs('settings') ? 'active' : '' }}" data-tooltip="Settings">
                    <i class="nav-icon fas fa-cog settings"></i>
                    <span class="nav-text">Settings</span>
                </a>
                <a href="{{ route('support.index') }}" class="nav-item support {{ request()->routeIs('support') ? 'active' : '' }}" data-tooltip="Support">
                    <i class="nav-icon fas fa-question-circle support"></i>
                    <span class="nav-text">Support</span>
                </a>
            </div>
        </div>

        <div class="affiliate-promo">
            @if(auth()->check() && auth()->user()->isAffiliate())
                {{-- Show Switch to Affiliate Panel for Active Affiliated Users --}}
                <div class="affiliate-text">
                    Switch to earning mode
                </div>
                <a href="{{ route('affiliate.dashboard') }}" class="join-button" data-tooltip="Affiliate Panel">
                    <i class="fas fa-exchange-alt mr-2"></i>
                    <span class="btn-text">Affiliate Panel</span>
                </a>
            @elseif(auth()->check() && auth()->user()->affiliate && auth()->user()->affiliate->isExpired())
                {{-- Show Renew Affiliate for Expired Affiliated Users --}}
                <div class="affiliate-text">
                    Membership expired
                </div>
                <a href="{{ route('affiliate.join') }}" class="join-button" data-tooltip="Renew Affiliate">
                    <i class="fas fa-sync-alt mr-2"></i>
                    <span class="btn-text">Renew Affiliate</span>
                </a>
            @else
                {{-- Show Join Affiliate for Non-Affiliated Users --}}
                <div class="affiliate-text">
                    Want to start earning?
                </div>
                <a href="{{ route('affiliate.join') }}" class="join-button" data-tooltip="Join Affiliate">
                    <i class="fas fa-user-plus mr-2"></i>
                    <span class="btn-text">Join Affiliate</span>
                </a>
            @endif
        </div>
    </div>
</aside>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const sidebar = document.getElementById('sidebar');
        const toggleButton = document.getElementById('sidebarToggle');
        const body = document.body;

        if (window.innerWidth >= 768) {
            sidebar.classList.add('collapsed');
        } else {
            sidebar.classList.remove('collapsed', 'active');
        }

        function toggleSidebar() {
            if (window.innerWidth >= 768) {
                sidebar.classList.toggle('collapsed');
            } else {
                sidebar.classList.toggle('active');
                body.classList.toggle('sidebar-open');
            }
        }

        if (toggleButton) {
            toggleButton.addEventListener('click', toggleSidebar);
        }

        document.addEventListener('click', function(event) {
            const isClickInsideSidebar = sidebar.contains(event.target);
            const isClickOnToggleButton = toggleButton && toggleButton.contains(event.target);

            if (!isClickInsideSidebar && !isClickOnToggleButton && window.innerWidth < 768) {
                sidebar.classList.remove('active');
                body.classList.remove('sidebar-open');
            }
        });

        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape' && window.innerWidth < 768) {
                sidebar.classList.remove('active');
                body.classList.remove('sidebar-open');
            }
        });

        window.addEventListener('resize', function() {
            if (window.innerWidth >= 768) {
                sidebar.classList.remove('active');
                body.classList.remove('sidebar-open');
            } else {
                sidebar.classList.remove('active', 'collapsed');
                body.classList.remove('sidebar-open');
            }
        });

        // Load inbox count on page load
        loadInboxCount();
        
        // Update inbox count every 30 seconds
        setInterval(loadInboxCount, 30000);
        
        function loadInboxCount() {
            fetch('/inbox/unread/count')
                .then(response => response.json())
                .then(data => updateInboxBadge(data.count))
                .catch(() => updateInboxBadge(0));
        }
        
        function updateInboxBadge(count) {
            const inboxBadge = document.getElementById('inboxBadge');
            if (inboxBadge) {
                if (count > 0) {
                    inboxBadge.textContent = count > 99 ? '99+' : count;
                    inboxBadge.style.display = 'flex';
                } else {
                    inboxBadge.style.display = 'none';
                }
            }
        }
        
        // Make functions global for navigation to access
        window.updateInboxBadge = updateInboxBadge;
        window.loadInboxCount = loadInboxCount;

        // User Tooltip functionality
        const userTooltip = document.createElement('div');
        userTooltip.className = 'user-tooltip';
        document.body.appendChild(userTooltip);

        const userNavItems = document.querySelectorAll('.nav-item[data-tooltip]');
        
        // Add affiliate buttons to tooltip items
        const affiliateButtons = document.querySelectorAll('.join-button[data-tooltip]');
        const allTooltipItems = [...userNavItems, ...affiliateButtons];
        
        allTooltipItems.forEach(item => {
            item.addEventListener('mouseenter', function(e) {
                if (sidebar.classList.contains('collapsed') && window.innerWidth >= 768) {
                    const rect = this.getBoundingClientRect();
                    const tooltipText = this.getAttribute('data-tooltip');
                    
                    // Get the color class from the nav item
                    const colorClass = this.classList.contains('home') ? 'home' :
                                     this.classList.contains('marketplace') ? 'marketplace' :
                                     this.classList.contains('stores') ? 'stores' :
                                     this.classList.contains('assets') ? 'assets' :
                                     this.classList.contains('wallet') ? 'wallet' :
                                     this.classList.contains('coins') ? 'coins' :
                                     this.classList.contains('orders') ? 'orders' :
                                     this.classList.contains('ideas') ? 'ideas' :
                                     this.classList.contains('settings') ? 'settings' :
                                     this.classList.contains('support') ? 'support' :
                                     this.classList.contains('inbox') ? 'inbox' : 'home';
                    
                    // Clear previous classes and add new color class
                    userTooltip.className = 'user-tooltip ' + colorClass;
                    userTooltip.textContent = tooltipText;
                    userTooltip.style.left = (rect.right + 12) + 'px';
                    userTooltip.style.top = (rect.top + rect.height / 2 - userTooltip.offsetHeight / 2) + 'px';
                    userTooltip.classList.add('show');
                }
            });

            item.addEventListener('mouseleave', function() {
                userTooltip.classList.remove('show');
            });
        });
    });
</script>
