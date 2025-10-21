<aside id="adminSidebar" class="sidebar collapsed">
    <style>
        .sidebar::-webkit-scrollbar {
            display: none;
        }

        .sidebar {
            -ms-overflow-style: none;
            scrollbar-width: none;
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
            width: 18rem;
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

        .nav-item.dashboard.active {
            background-color: rgba(99, 102, 241, 0.1);
            color: #6366F1;
        }
        .nav-item.users.active {
            background-color: rgba(34, 197, 94, 0.1);
            color: #22C55E;
        }
        .nav-item.admins.active {
            background-color: rgba(239, 68, 68, 0.1);
            color: #EF4444;
        }
        .nav-item.roles.active {
            background-color: rgba(168, 85, 247, 0.1);
            color: #A855F7;
        }
        .nav-item.packages.active {
            background-color: rgba(234, 179, 8, 0.1);
            color: #EAB308;
        }
        .nav-item.transactions.active {
            background-color: rgba(59, 130, 246, 0.1);
            color: #3B82F6;
        }
        .nav-item.settings.active {
            background-color: rgba(107, 114, 128, 0.1);
            color: #6B7280;
        }
        .nav-item.jobs.active {
            background-color: rgba(79, 70, 229, 0.1);
            color: #4F46E5;
        }

        .nav-icon.dashboard { color: #6366F1; }
        .nav-icon.users { color: #22C55E; }
        .nav-icon.admins { color: #EF4444; }
        .nav-icon.roles { color: #A855F7; }
        .nav-icon.packages { color: #EAB308; }
        .nav-icon.transactions { color: #3B82F6; }
        .nav-icon.settings { color: #6B7280; }
        .nav-icon.jobs { color: #4F46E5; }

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

        .admin-promo {
            padding: 1rem;
            background: white;
            border-top: 1px solid #e5e7eb;
            min-height: 72px;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.75rem;
            position: sticky;
            bottom: 0;
            z-index: 10;
        }

        .sidebar.collapsed .admin-promo {
            padding: 0.5rem;
        }

        .sidebar.collapsed .admin-promo .flex {
            justify-content: center;
        }

        .sidebar.collapsed .admin-promo .flex > div:last-child {
            display: none;
        }

        .admin-text {
            font-size: 0.85rem;
            text-align: center;
            line-height: 1.4;
            font-weight: 600;
            color: #374151;
        }

        .sidebar.collapsed .admin-text {
            display: none;
        }

        .sidebar.collapsed .search-container {
            display: none;
        }

        .logout-button {
            background: linear-gradient(135deg, #EF4444 0%, #DC2626 100%);
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

        .logout-button:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        .sidebar.collapsed .logout-button {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .sidebar.collapsed .nav-item {
            position: relative;
        }

        .admin-tooltip {
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

        .admin-tooltip.show {
            opacity: 1;
            transform: translateX(0);
        }

        .admin-tooltip::before {
            content: '';
            position: absolute;
            left: -6px;
            top: 50%;
            transform: translateY(-50%);
            border: 6px solid transparent;
        }

        .admin-tooltip.dashboard {
            background: linear-gradient(135deg, #6366F1 0%, #4F46E5 100%);
        }
        .admin-tooltip.dashboard::before {
            border-right-color: #6366F1;
        }

        .admin-tooltip.users {
            background: linear-gradient(135deg, #22C55E 0%, #16A34A 100%);
        }
        .admin-tooltip.users::before {
            border-right-color: #22C55E;
        }

        .admin-tooltip.admins {
            background: linear-gradient(135deg, #EF4444 0%, #DC2626 100%);
        }
        .admin-tooltip.admins::before {
            border-right-color: #EF4444;
        }

        .admin-tooltip.roles {
            background: linear-gradient(135deg, #A855F7 0%, #9333EA 100%);
        }
        .admin-tooltip.roles::before {
            border-right-color: #A855F7;
        }

        .admin-tooltip.packages {
            background: linear-gradient(135deg, #EAB308 0%, #CA8A04 100%);
        }
        .admin-tooltip.packages::before {
            border-right-color: #EAB308;
        }

        .admin-tooltip.transactions {
            background: linear-gradient(135deg, #3B82F6 0%, #2563EB 100%);
        }
        .admin-tooltip.transactions::before {
            border-right-color: #3B82F6;
        }

        .admin-tooltip.settings {
            background: linear-gradient(135deg, #6B7280 0%, #4B5563 100%);
        }
        .admin-tooltip.settings::before {
            border-right-color: #6B7280;
        }

        .admin-tooltip.jobs {
            background: linear-gradient(135deg, #4F46E5 0%, #3730A3 100%);
        }
        .admin-tooltip.jobs::before {
            border-right-color: #4F46E5;
        }

        .dark .sidebar {
            background-color: #1f2937;
        }

        .dark .app-brand,
        .dark .admin-promo {
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

        .dark .admin-text {
            color: #9ca3af;
        }

        .settings-group {
            position: relative;
        }

        .group-toggle {
            width: 100%;
            background: none;
            border: none;
            text-align: left;
            cursor: pointer;
        }

        .group-arrow {
            transition: transform 0.3s ease;
        }

        .sidebar.collapsed .group-arrow {
            display: none;
        }

        .group-items {
            display: none;
        }

        .group-items.show {
            display: block;
        }

        .group-items.show ~ .group-toggle .group-arrow,
        .group-toggle.expanded .group-arrow {
            transform: rotate(90deg);
        }

        .group-toggle.active {
            background-color: rgba(107, 114, 128, 0.05);
            color: #6B7280;
        }

        .dark .group-toggle.active {
            background-color: rgba(107, 114, 128, 0.1);
            color: #9ca3af;
        }
    </style>

    <div class="sidebar-content">
        <div class="app-brand">
            <div class="text-2xl font-bold text-primary-600 dark:text-primary-400">
                <i class="fas fa-shield-alt"></i>
            </div>
            <span class="app-name">Admin Portal</span>
        </div>

        <div class="nav-content">
            <div class="search-container mb-4">
                <input type="text" id="sidebarSearch" placeholder="Search menu..." 
                       class="w-full px-3 py-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
            </div>
            <a href="{{ route('admin.dashboard') }}" class="nav-item dashboard {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" data-tooltip="Dashboard">
                <i class="nav-icon fas fa-tachometer-alt dashboard"></i>
                <span class="nav-text">Dashboard</span>
            </a>
            @if(auth('admin')->user()->can('view-users'))
            <a href="{{ route('admin.users.index') }}" class="nav-item users {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" data-tooltip="Users">
                <i class="nav-icon fas fa-users users"></i>
                <span class="nav-text">Users</span>
            </a>
            @endif
            <a href="{{ route('admin.kyc.index') }}" class="nav-item users {{ request()->routeIs('admin.kyc.*') ? 'active' : '' }}" data-tooltip="KYC Management">
                <i class="nav-icon fas fa-id-card users"></i>
                <span class="nav-text">KYC Management</span>
            </a>

            @if(auth('admin')->user()->can('view-admins'))
            <a href="{{ route('admin.admins.index') }}" class="nav-item admins {{ request()->routeIs('admin.admins.*') ? 'active' : '' }}" data-tooltip="Admins">
                <i class="nav-icon fas fa-user-shield admins"></i>
                <span class="nav-text">Admins</span>
            </a>
            @endif
            @if(auth('admin')->user()->can('view-permissions'))
            <a href="{{ route('admin.permissions.index') }}" class="nav-item roles {{ request()->routeIs('admin.permissions.*') ? 'active' : '' }}" data-tooltip="Permissions">
                <i class="nav-icon fas fa-key roles"></i>
                <span class="nav-text">Permissions</span>
            </a>
            @endif
            @if(auth('admin')->user()->can('view-roles'))
            <a href="{{ route('admin.roles.index') }}" class="nav-item roles {{ request()->routeIs('admin.roles.*') ? 'active' : '' }}" data-tooltip="Roles">
                <i class="nav-icon fas fa-user-tag roles"></i>
                <span class="nav-text">Roles</span>
            </a>
            @endif

            <div class="pt-2 mt-2 border-t border-gray-200 dark:border-gray-700">
                <a href="{{ route('admin.assets.index') }}" class="nav-item packages {{ request()->routeIs('admin.assets.*') ? 'active' : '' }}" data-tooltip="Digital Assets">
                    <i class="nav-icon fas fa-box packages"></i>
                    <span class="nav-text">Digital Assets</span>
                </a>
                <a href="{{ route('admin.categories.index') }}" class="nav-item packages {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}" data-tooltip="Categories">
                    <i class="nav-icon fas fa-folder packages"></i>
                    <span class="nav-text">Categories</span>
                </a>
                <a href="{{ route('admin.subcategories.index') }}" class="nav-item packages {{ request()->routeIs('admin.subcategories.*') ? 'active' : '' }}" data-tooltip="Subcategories">
                    <i class="nav-icon fas fa-folder-open packages"></i>
                    <span class="nav-text">Subcategories</span>
                </a>
                <a href="{{ route('admin.tags.index') }}" class="nav-item packages {{ request()->routeIs('admin.tags.*') ? 'active' : '' }}" data-tooltip="Tags">
                    <i class="nav-icon fas fa-tags packages"></i>
                    <span class="nav-text">Tags</span>
                </a>
                <a href="{{ route('admin.reviews.index') }}" class="nav-item packages {{ request()->routeIs('admin.reviews.*') ? 'active' : '' }}" data-tooltip="Reviews">
                    <i class="nav-icon fas fa-star packages"></i>
                    <span class="nav-text">Reviews</span>
                </a>

                <a href="{{ route('admin.asset-media.index') }}" class="nav-item packages {{ request()->routeIs('admin.asset-media.*') ? 'active' : '' }}" data-tooltip="Asset Media">
                    <i class="nav-icon fas fa-images packages"></i>
                    <span class="nav-text">Asset Media</span>
                </a>
                <a href="{{ route('admin.asset-favorites.index') }}" class="nav-item packages {{ request()->routeIs('admin.asset-favorites.*') ? 'active' : '' }}" data-tooltip="Asset Favorites">
                    <i class="nav-icon fas fa-heart packages"></i>
                    <span class="nav-text">Asset Favorites</span>
                </a>
            </div>

            <div class="pt-2 mt-2 border-t border-gray-200 dark:border-gray-700">
                <a href="{{ route('admin.affiliates.index') }}" class="nav-item users {{ request()->routeIs('admin.affiliates.*') ? 'active' : '' }}" data-tooltip="Affiliates">
                    <i class="nav-icon fas fa-handshake users"></i>
                    <span class="nav-text">Affiliates</span>
                </a>
                <a href="{{ route('admin.stores.index') }}" class="nav-item transactions {{ request()->routeIs('admin.stores.*') ? 'active' : '' }}" data-tooltip="Stores">
                    <i class="nav-icon fas fa-store transactions"></i>
                    <span class="nav-text">Stores</span>
                </a>
                <a href="{{ route('admin.ideas.index') }}" class="nav-item transactions {{ request()->routeIs('admin.ideas.*') ? 'active' : '' }}" data-tooltip="Ideas">
                    <i class="nav-icon fas fa-lightbulb transactions"></i>
                    <span class="nav-text">Ideas</span>
                </a>
                <a href="{{ route('admin.reserved.index') }}" class="nav-item transactions {{ request()->routeIs('admin.reserved.*') ? 'active' : '' }}" data-tooltip="Reserved">
                    <i class="nav-icon fas fa-lock transactions"></i>
                    <span class="nav-text">Reserved</span>
                </a>
                @if(auth('admin')->user()->can('view-revenue'))
                <a href="{{ route('admin.revenue.index') }}" class="nav-item transactions {{ request()->routeIs('admin.revenue.*') ? 'active' : '' }}" data-tooltip="Revenue">
                    <i class="nav-icon fas fa-chart-line transactions"></i>
                    <span class="nav-text">Revenue</span>
                </a>
                @endif
                @if(auth('admin')->user()->can('view-system-wallet'))
                <a href="{{ route('admin.system-wallet.index') }}" class="nav-item transactions {{ request()->routeIs('admin.system-wallet.*') ? 'active' : '' }}" data-tooltip="System Wallet">
                    <i class="nav-icon fas fa-university transactions"></i>
                    <span class="nav-text">System Wallet</span>
                </a>
                @endif
                @if(auth('admin')->user()->can('view-platform-wallet'))
                <a href="{{ route('admin.platform-wallet.index') }}" class="nav-item transactions {{ request()->routeIs('admin.platform-wallet.*') ? 'active' : '' }}" data-tooltip="Platform Wallet">
                    <i class="nav-icon fas fa-coins transactions"></i>
                    <span class="nav-text">Platform Wallet</span>
                </a>
                @endif
            </div>

            <div class="pt-2 mt-2 border-t border-gray-200 dark:border-gray-700">
                <a href="{{ route('admin.countries.index') }}" class="nav-item settings {{ request()->routeIs('admin.countries.*') ? 'active' : '' }}" data-tooltip="Countries">
                    <i class="nav-icon fas fa-globe settings"></i>
                    <span class="nav-text">Countries</span>
                </a>
                <a href="{{ route('admin.states.index') }}" class="nav-item settings {{ request()->routeIs('admin.states.*') ? 'active' : '' }}" data-tooltip="States">
                    <i class="nav-icon fas fa-map-marker-alt settings"></i>
                    <span class="nav-text">States</span>
                </a>
                <a href="{{ route('admin.currencies.index') }}" class="nav-item settings {{ request()->routeIs('admin.currencies.*') ? 'active' : '' }}" data-tooltip="Currencies">
                    <i class="nav-icon fas fa-coins settings"></i>
                    <span class="nav-text">Currencies</span>
                </a>
                <a href="{{ route('admin.newsletter-subscriptions.index') }}" class="nav-item settings {{ request()->routeIs('admin.newsletter-subscriptions.*') ? 'active' : '' }}" data-tooltip="Newsletter">
                    <i class="nav-icon fas fa-envelope settings"></i>
                    <span class="nav-text">Newsletter</span>
                </a>
                <a href="{{ route('admin.verification-badges.index') }}" class="nav-item settings {{ request()->routeIs('admin.verification-badges.*') ? 'active' : '' }}" data-tooltip="Verification Badges">
                    <i class="nav-icon fas fa-certificate settings"></i>
                    <span class="nav-text">Verification Badges</span>
                </a>
                <a href="{{ route('admin.follows.index') }}" class="nav-item settings {{ request()->routeIs('admin.follows.*') ? 'active' : '' }}" data-tooltip="Follows">
                    <i class="nav-icon fas fa-users settings"></i>
                    <span class="nav-text">Follows</span>
                </a>
            </div>

            <div class="pt-2 mt-2 border-t border-gray-200 dark:border-gray-700">
                <a href="{{ route('admin.coin-packages.index') }}" class="nav-item packages {{ request()->routeIs('admin.coin-packages.*') ? 'active' : '' }}" data-tooltip="Coin Packages">
                    <i class="nav-icon fas fa-coins packages"></i>
                    <span class="nav-text">Coin Packages</span>
                </a>
                <a href="{{ route('admin.coin-manager.index') }}" class="nav-item packages {{ request()->routeIs('admin.coin-manager.*') ? 'active' : '' }}" data-tooltip="Coin Manager">
                    <i class="nav-icon fas fa-wallet packages"></i>
                    <span class="nav-text">Coin Manager</span>
                </a>
                <a href="{{ route('admin.coin-transactions.pending') }}" class="nav-item transactions {{ request()->routeIs('admin.coin-transactions.pending') ? 'active' : '' }}" data-tooltip="Pending Transactions">
                    <i class="nav-icon fas fa-clock transactions"></i>
                    <span class="nav-text">Pending Transactions</span>
                </a>
                <a href="{{ route('admin.coin-transactions.history') }}" class="nav-item transactions {{ request()->routeIs('admin.coin-transactions.history') ? 'active' : '' }}" data-tooltip="Transaction History">
                    <i class="nav-icon fas fa-history transactions"></i>
                    <span class="nav-text">Transaction History</span>
                </a>
                <a href="{{ route('admin.payment-methods.index') }}" class="nav-item settings {{ request()->routeIs('admin.payment-methods.*') ? 'active' : '' }}" data-tooltip="Payment Methods">
                    <i class="nav-icon fas fa-credit-card settings"></i>
                    <span class="nav-text">Payment Methods</span>
                </a>
                <a href="{{ route('admin.withdrawals.index') }}" class="nav-item transactions {{ request()->routeIs('admin.withdrawals.*') ? 'active' : '' }}" data-tooltip="Withdrawals">
                    <i class="nav-icon fas fa-money-bill-wave transactions"></i>
                    <span class="nav-text">Withdrawals</span>
                </a>
            </div>

            <div class="pt-2 mt-2 border-t border-gray-200 dark:border-gray-700">
                <div class="settings-group">
                    <button class="nav-item settings group-toggle {{ request()->routeIs('admin.settings.*') || request()->routeIs('admin.welcomes.*') ? 'active' : '' }}" data-tooltip="Settings Management">
                        <i class="nav-icon fas fa-cogs settings"></i>
                        <span class="nav-text">Settings MGT</span>
                        <i class="fas fa-chevron-right ml-auto text-xs group-arrow"></i>
                    </button>
                    <div class="group-items">
                        <a href="{{ route('admin.settings.general') }}" class="nav-item settings {{ request()->routeIs('admin.settings.general') ? 'active' : '' }}" data-tooltip="General Settings">
                            <i class="nav-icon fas fa-cog settings"></i>
                            <span class="nav-text">General Settings</span>
                        </a>
                        <a href="{{ route('admin.settings.sms') }}" class="nav-item settings {{ request()->routeIs('admin.settings.sms') ? 'active' : '' }}" data-tooltip="SMS Settings">
                            <i class="nav-icon fas fa-sms settings"></i>
                            <span class="nav-text">SMS Settings</span>
                        </a>
                        <a href="{{ route('admin.settings.finance') }}" class="nav-item settings {{ request()->routeIs('admin.settings.finance') ? 'active' : '' }}" data-tooltip="Financial Settings">
                            <i class="nav-icon fas fa-dollar-sign settings"></i>
                            <span class="nav-text">Financial Settings</span>
                        </a>
                        <a href="{{ route('admin.welcomes.index') }}" class="nav-item settings {{ request()->routeIs('admin.welcomes.*') ? 'active' : '' }}" data-tooltip="Welcome Messages">
                            <i class="nav-icon fas fa-comments settings"></i>
                            <span class="nav-text">Welcome Messages</span>
                        </a>

                    </div>
                </div>
            </div>

            <div class="pt-2 mt-2 border-t border-gray-200 dark:border-gray-700">
                <a href="{{ route('admin.jobs.index') }}" class="nav-item jobs {{ request()->routeIs('admin.jobs.index') ? 'active' : '' }}" data-tooltip="Active Jobs">
                    <i class="nav-icon fas fa-tasks jobs"></i>
                    <span class="nav-text">Active Jobs</span>
                </a>
                <a href="{{ route('admin.jobs.batches') }}" class="nav-item jobs {{ request()->routeIs('admin.jobs.batches') ? 'active' : '' }}" data-tooltip="Job Batches">
                    <i class="nav-icon fas fa-layer-group jobs"></i>
                    <span class="nav-text">Job Batches</span>
                </a>
                <a href="{{ route('admin.jobs.failed') }}" class="nav-item jobs {{ request()->routeIs('admin.jobs.failed') ? 'active' : '' }}" data-tooltip="Failed Jobs">
                    <i class="nav-icon fas fa-exclamation-triangle jobs"></i>
                    <span class="nav-text">Failed Jobs</span>
                </a>
            </div>
        </div>

        <div class="admin-promo">
            <div class="flex items-center gap-3 w-full">
                <img class="w-10 h-10 rounded-full flex-shrink-0" src="https://ui-avatars.com/api/?name={{ urlencode(auth('admin')->user()->name) }}&background=6366f1&color=fff" alt="{{ auth('admin')->user()->name }}">
                <div class="flex-1 min-w-0">
                    <div class="text-sm font-semibold text-gray-900 dark:text-white truncate">{{ auth('admin')->user()->name }}</div>
                    <div class="text-xs text-gray-500 dark:text-gray-400 truncate">{{ auth('admin')->user()->email }}</div>
                </div>
            </div>
        </div>
    </div>
</aside>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const sidebar = document.getElementById('adminSidebar');
        const toggleButton = document.getElementById('adminSidebarToggle');
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

        // Tooltip functionality
        const tooltip = document.createElement('div');
        tooltip.className = 'admin-tooltip';
        document.body.appendChild(tooltip);

        const navItems = document.querySelectorAll('.nav-item[data-tooltip]');

        navItems.forEach(item => {
            item.addEventListener('mouseenter', function(e) {
                if (sidebar.classList.contains('collapsed') && window.innerWidth >= 768) {
                    const rect = this.getBoundingClientRect();
                    const tooltipText = this.getAttribute('data-tooltip');

                    // Get the color class from the nav item
                    const colorClass = this.classList.contains('dashboard') ? 'dashboard' :
                                     this.classList.contains('users') ? 'users' :
                                     this.classList.contains('admins') ? 'admins' :
                                     this.classList.contains('roles') ? 'roles' :
                                     this.classList.contains('packages') ? 'packages' :
                                     this.classList.contains('transactions') ? 'transactions' :
                                     this.classList.contains('settings') ? 'settings' :
                                     this.classList.contains('jobs') ? 'jobs' : 'dashboard';

                    // Clear previous classes and add new color class
                    tooltip.className = 'admin-tooltip ' + colorClass;
                    tooltip.textContent = tooltipText;
                    tooltip.style.left = (rect.right + 12) + 'px';
                    tooltip.style.top = (rect.top + rect.height / 2 - tooltip.offsetHeight / 2) + 'px';
                    tooltip.classList.add('show');
                }
            });

            item.addEventListener('mouseleave', function() {
                tooltip.classList.remove('show');
            });
        });

        // Settings group functionality
        const groupToggle = document.querySelector('.group-toggle');
        const groupItems = document.querySelector('.group-items');

        if (groupToggle && groupItems) {
            // Auto-expand if any child is active
            if (groupToggle.classList.contains('active')) {
                groupItems.classList.add('show');
                groupToggle.classList.add('expanded');
            }

            groupToggle.addEventListener('click', function(e) {
                e.preventDefault();
                groupItems.classList.toggle('show');
                groupToggle.classList.toggle('expanded');
            });
        }

        // Search functionality - added separately to avoid conflicts
        const searchInput = document.getElementById('sidebarSearch');
        if (searchInput) {
            searchInput.addEventListener('input', function() {
                const query = this.value.toLowerCase();
                const allNavItems = document.querySelectorAll('.nav-item, .settings-group');
                
                allNavItems.forEach(item => {
                    const text = item.textContent.toLowerCase();
                    const isGroup = item.classList.contains('settings-group');
                    
                    if (query === '') {
                        item.style.display = '';
                        if (isGroup) {
                            const groupItems = item.querySelector('.group-items');
                            if (groupItems) groupItems.style.display = '';
                        }
                    } else if (text.includes(query)) {
                        item.style.display = '';
                        if (isGroup) {
                            const groupItems = item.querySelector('.group-items');
                            if (groupItems) {
                                groupItems.classList.add('show');
                                groupItems.style.display = '';
                            }
                        }
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
        }

    });
</script>
