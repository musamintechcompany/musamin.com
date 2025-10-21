<div class="mobile-bottom-nav md:hidden">
    <style>
        .mobile-bottom-nav {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            background: white;
            box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.1);
        }

        .dark .mobile-bottom-nav {
            background-color: #1f2937;
            box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.3);
        }

        @media (min-width: 768px) {
            .mobile-bottom-nav {
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
        <a href="{{ route('affiliate.dashboard') }}" class="flex flex-col items-center text-gray-500 dark:text-gray-400" id="nav-dashboard">
            <i class="text-lg fas fa-chart-line"></i>
            <span class="mt-1 text-xs">Dashboard</span>
        </a>
        <a href="{{ route('stores') }}" class="flex flex-col items-center text-gray-500 dark:text-gray-400" id="nav-store">
            <i class="text-lg fas fa-store"></i>
            <span class="mt-1 text-xs">My Store</span>
        </a>
        <a href="{{ route('affiliate.earnings.index') }}" class="flex flex-col items-center text-gray-500 dark:text-gray-400" id="nav-earnings">
            <i class="text-lg fas fa-money-bill-wave"></i>
            <span class="mt-1 text-xs">Earnings</span>
        </a>
        <a href="{{ route('profile.show') }}" class="flex flex-col items-center text-gray-500 dark:text-gray-400" id="nav-profile">
            <i class="text-lg fas fa-user"></i>
            <span class="mt-1 text-xs">Profile</span>
        </a>
    </div>

    <script>
        // Set active nav item
        function setActiveNavItem() {
            const navItems = document.querySelectorAll('.mobile-bottom-nav a');
            const currentPath = window.location.pathname;

            navItems.forEach(item => {
                item.classList.remove('text-blue-500');
                item.classList.add('text-gray-500', 'dark:text-gray-400');

                if (item.getAttribute('href') === currentPath) {
                    item.classList.remove('text-gray-500', 'dark:text-gray-400');
                    item.classList.add('text-blue-500');
                }
            });
        }

        // Initialize on load
        document.addEventListener('DOMContentLoaded', setActiveNavItem);

        // Add click handlers
        document.querySelectorAll('.mobile-bottom-nav a').forEach(item => {
            item.addEventListener('click', function() {
                document.querySelectorAll('.mobile-bottom-nav a').forEach(i => {
                    i.classList.remove('text-blue-500');
                    i.classList.add('text-gray-500', 'dark:text-gray-400');
                });
                this.classList.remove('text-gray-500', 'dark:text-gray-400');
                this.classList.add('text-blue-500');
            });
        });
    </script>
</div>
