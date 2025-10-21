<div class="admin-mobile-bottom-nav md:hidden">
    <style>
        .admin-mobile-bottom-nav {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            background: white;
            box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.1);
        }

        .dark .admin-mobile-bottom-nav {
            background-color: #1f2937;
            box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.3);
        }

        @media (min-width: 768px) {
            .admin-mobile-bottom-nav {
                display: none;
            }
        }

        /* Add padding to main content to avoid overlap */
        main {
            padding-bottom: 4rem;
        }

        @media (min-width: 768px) {
            main {
                padding-bottom: 0;
            }
        }
    </style>

    <div class="flex justify-around p-3">
        <a href="{{ route('admin.dashboard') }}" class="flex flex-col items-center text-gray-500 dark:text-gray-400" id="admin-nav-dashboard">
            <i class="text-lg fas fa-tachometer-alt"></i>
            <span class="mt-1 text-xs">Dashboard</span>
        </a>
        <a href="{{ route('admin.users.index') }}" class="flex flex-col items-center text-gray-500 dark:text-gray-400" id="admin-nav-users">
            <i class="text-lg fas fa-users"></i>
            <span class="mt-1 text-xs">Users</span>
        </a>
        <a href="{{ route('admin.coin-packages.index') }}" class="flex flex-col items-center text-gray-500 dark:text-gray-400" id="admin-nav-packages">
            <i class="text-lg fas fa-coins"></i>
            <span class="mt-1 text-xs">Packages</span>
        </a>
        <a href="{{ route('admin.coin-transactions.pending') }}" class="flex flex-col items-center text-gray-500 dark:text-gray-400" id="admin-nav-transactions">
            <i class="text-lg fas fa-exchange-alt"></i>
            <span class="mt-1 text-xs">Transactions</span>
        </a>
    </div>

    <script>
        // Set active nav item for admin
        function setActiveAdminNavItem() {
            const navItems = document.querySelectorAll('.admin-mobile-bottom-nav a');
            const currentPath = window.location.pathname;

            navItems.forEach(item => {
                item.classList.remove('text-blue-600');
                item.classList.add('text-gray-500', 'dark:text-gray-400');

                if (item.getAttribute('href') === currentPath) {
                    item.classList.remove('text-gray-500', 'dark:text-gray-400');
                    item.classList.add('text-blue-600');
                }
            });
        }

        // Initialize on load
        document.addEventListener('DOMContentLoaded', setActiveAdminNavItem);

        // Add click handlers
        document.querySelectorAll('.admin-mobile-bottom-nav a').forEach(item => {
            item.addEventListener('click', function() {
                document.querySelectorAll('.admin-mobile-bottom-nav a').forEach(i => {
                    i.classList.remove('text-blue-600');
                    i.classList.add('text-gray-500', 'dark:text-gray-400');
                });
                this.classList.remove('text-gray-500', 'dark:text-gray-400');
                this.classList.add('text-blue-600');
            });
        });
    </script>
</div>
