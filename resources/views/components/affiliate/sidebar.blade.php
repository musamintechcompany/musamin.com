<aside id="sidebar" class="sidebar collapsed">
    <style>
        .sidebar::-webkit-scrollbar { display: none; }
        .sidebar { -ms-overflow-style: none; scrollbar-width: none; }
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
        body.sidebar-open { overflow: hidden; }
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
        .sidebar.collapsed .app-brand { justify-content: center; padding: 1rem 0; }
        .app-logo { height: 32px; width: 32px; object-fit: contain; }
        .app-name {
            font-size: 1.1rem;
            font-weight: 600;
            white-space: nowrap;
            transition: opacity 0.3s ease;
            color: #111827;
        }
        .sidebar.collapsed .app-name { opacity: 0; width: 0; }
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
        .sidebar.collapsed .nav-item { justify-content: center; padding: 0.75rem 0; }
        .nav-item:hover { background-color: rgba(0, 0, 0, 0.05); }
        .nav-item.home.active { background-color: rgba(59, 130, 246, 0.1); color: #3B82F6; }
        .nav-item.stores.active { background-color: rgba(16, 185, 129, 0.1); color: #10B981; }
        .nav-item.listings.active { background-color: rgba(245, 158, 11, 0.1); color: #F59E0B; }
        .nav-item.code.active { background-color: rgba(6, 182, 212, 0.1); color: #06B6D4; }
        .nav-item.settings.active { background-color: rgba(107, 114, 128, 0.1); color: #6B7280; }
        .nav-item.support.active { background-color: rgba(20, 184, 166, 0.1); color: #14B8A6; }
        .nav-item.orders.active { background-color: rgba(139, 92, 246, 0.1); color: #8B5CF6; }
        .nav-item.earnings.active { background-color: rgba(16, 185, 129, 0.1); color: #10B981; }
        .nav-icon.home { color: #3B82F6; }
        .nav-icon.stores { color: #10B981; }
        .nav-icon.listings { color: #F59E0B; }
        .nav-icon.code { color: #06B6D4; }
        .nav-icon.settings { color: #6B7280; }
        .nav-icon.support { color: #14B8A6; }
        .nav-icon.orders { color: #8B5CF6; }
        .nav-icon.earnings { color: #10B981; }
        .nav-icon {
            font-size: 1.1rem;
            min-width: 24px;
            text-align: center;
            margin-right: 12px;
        }
        .sidebar.collapsed .nav-icon { margin-right: 0; }
        .nav-text {
            transition: opacity 0.3s ease;
            white-space: nowrap;
        }
        .sidebar.collapsed .nav-text { opacity: 0; width: 0; }
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
        }
        .sidebar.collapsed .affiliate-promo {
            padding: 0.5rem 0;
            min-height: auto;
            border-top: 1px solid #e5e7eb;
        }
        
        .sidebar.collapsed .dashboard-btn {
            width: auto;
            padding: 0.75rem 0;
            background: none;
            box-shadow: none;
            justify-content: center;
        }
        
        .sidebar.collapsed .dashboard-btn:hover {
            transform: none;
            box-shadow: none;
            background-color: rgba(0, 0, 0, 0.05);
        }
        
        .sidebar.collapsed .dashboard-btn .btn-text {
            display: none;
        }
        
        .sidebar.collapsed .dashboard-btn i {
            margin: 0;
            font-size: 1.1rem;
            color: #6366F1;
        }
        .dashboard-btn {
            background: linear-gradient(135deg, #6366F1 0%, #8B5CF6 50%, #D946EF 100%);
            color: white;
            border: none;
            padding: 0.5rem;
            border-radius: 0.375rem;
            font-size: 0.85rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            width: 100%;
            text-align: center;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            text-decoration: none;
        }
        .dashboard-btn:hover {
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
            background: linear-gradient(135deg, #3B82F6 0%, #2563EB 100%);
        }
        .user-tooltip.home::before {
            border-right-color: #3B82F6;
        }

        .user-tooltip.stores {
            background: linear-gradient(135deg, #10B981 0%, #059669 100%);
        }
        .user-tooltip.stores::before {
            border-right-color: #10B981;
        }

        .user-tooltip.listings {
            background: linear-gradient(135deg, #F59E0B 0%, #D97706 100%);
        }
        .user-tooltip.listings::before {
            border-right-color: #F59E0B;
        }

        .user-tooltip.earnings {
            background: linear-gradient(135deg, #10B981 0%, #059669 100%);
        }
        .user-tooltip.orders {
            background: linear-gradient(135deg, #8B5CF6 0%, #7C3AED 100%);
        }
        .user-tooltip.orders::before {
            border-right-color: #8B5CF6;
        }

        .user-tooltip.earnings::before {
            border-right-color: #10B981;
        }

        .user-tooltip.code {
            background: linear-gradient(135deg, #06B6D4 0%, #0891B2 100%);
        }
        .user-tooltip.code::before {
            border-right-color: #06B6D4;
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

        @media (max-width: 767px) {
            .user-tooltip {
                display: none;
            }
        }
        .dark .sidebar { background-color: #1f2937; }
        .dark .app-brand, .dark .affiliate-promo { background-color: #1f2937; border-top-color: #374151; }
        .dark .app-name { color: white; }
        .dark .nav-item { color: #9ca3af; }
        .dark .nav-item:hover { background-color: rgba(255, 255, 255, 0.05); }
    </style>

    <div class="sidebar-content">
        <div class="app-brand">
            <div class="text-2xl font-bold text-green-600 dark:text-green-400">
                <i class="fas fa-handshake"></i>
            </div>
            <span class="app-name">Affiliate Panel</span>
        </div>

        <div class="nav-content">
            <a href="{{ route('affiliate.dashboard') }}" class="nav-item home {{ request()->routeIs('affiliate.dashboard') ? 'active' : '' }}" data-tooltip="Dashboard">
                <i class="nav-icon fas fa-chart-line home"></i>
                <span class="nav-text">Dashboard</span>
            </a>
            <a href="{{ route('affiliate.store.index') }}" class="nav-item stores {{ request()->routeIs('affiliate.store.*') ? 'active' : '' }}" data-tooltip="Store Management">
                <i class="nav-icon fas fa-store-alt stores"></i>
                <span class="nav-text">Store Management</span>
            </a>
            <a href="{{ route('affiliate.assets.index') }}" class="nav-item listings {{ request()->routeIs('affiliate.assets.*') ? 'active' : '' }}" data-tooltip="Asset Manager">
                <i class="nav-icon fas fa-list listings"></i>
                <span class="nav-text">Asset Manager</span>
            </a>
            <a href="{{ route('affiliate.orders.index') }}" class="nav-item orders {{ request()->routeIs('affiliate.orders.*') ? 'active' : '' }}" data-tooltip="Orders">
                <i class="nav-icon fas fa-shopping-bag orders"></i>
                <span class="nav-text">Orders</span>
            </a>
            <a href="{{ route('affiliate.earnings.index') }}" class="nav-item earnings {{ request()->routeIs('affiliate.earnings.*') ? 'active' : '' }}" data-tooltip="Earnings">
                <i class="nav-icon fas fa-money-bill-wave earnings"></i>
                <span class="nav-text">Earnings</span>
            </a>

            <div class="pt-2 mt-2 border-t border-gray-200 dark:border-gray-700">
                <a href="{{ route('affiliate.my-code.index') }}" class="nav-item code {{ request()->routeIs('affiliate.my-code.*') ? 'active' : '' }}" data-tooltip="My Code">
                    <i class="nav-icon fas fa-code code"></i>
                    <span class="nav-text">My Code</span>
                </a>
            </div>
        </div>

        <div class="affiliate-promo">
            <a href="{{ route('dashboard') }}" class="dashboard-btn" data-tooltip="Main Dashboard">
                <i class="fas fa-exchange-alt"></i>
                <span class="btn-text">Main Dashboard</span>
            </a>
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

        // User Tooltip functionality
        const userTooltip = document.createElement('div');
        userTooltip.className = 'user-tooltip';
        document.body.appendChild(userTooltip);

        const userNavItems = document.querySelectorAll('.nav-item[data-tooltip]');
        
        // Add dashboard button to tooltip items
        const dashboardButton = document.querySelector('.dashboard-btn[data-tooltip]');
        const allTooltipItems = dashboardButton ? [...userNavItems, dashboardButton] : userNavItems;
        
        allTooltipItems.forEach(item => {
            item.addEventListener('mouseenter', function(e) {
                if (sidebar.classList.contains('collapsed') && window.innerWidth >= 768) {
                    const rect = this.getBoundingClientRect();
                    const tooltipText = this.getAttribute('data-tooltip');
                    
                    // Get the color class from the nav item
                    const colorClass = this.classList.contains('home') ? 'home' :
                                     this.classList.contains('stores') ? 'stores' :
                                     this.classList.contains('listings') ? 'listings' :
                                     this.classList.contains('orders') ? 'orders' :
                                     this.classList.contains('earnings') ? 'earnings' :
                                     this.classList.contains('code') ? 'code' :
                                     this.classList.contains('settings') ? 'settings' :
                                     this.classList.contains('support') ? 'support' : 'home';
                    
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
