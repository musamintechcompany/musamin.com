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
        <a href="{{ route('dashboard') }}" class="flex flex-col items-center text-gray-500 dark:text-gray-400" id="nav-home">
            <i class="text-lg fas fa-home"></i>
            <span class="mt-1 text-xs">Home</span>
        </a>
        <a href="#" class="flex flex-col items-center text-gray-500 dark:text-gray-400" id="nav-market">
            <i class="text-lg fas fa-store"></i>
            <span class="mt-1 text-xs">Market</span>
        </a>
        <a href="{{ route('inbox.index') }}" class="flex flex-col items-center {{ request()->routeIs('inbox.*') ? 'text-blue-500' : 'text-gray-500 dark:text-gray-400' }}" id="nav-inbox">
            <div class="relative">
                <i class="text-lg fas fa-inbox"></i>
                <span id="mobileInboxBadge" class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-4 h-4 flex items-center justify-center" style="display: none;">0</span>
            </div>
            <span class="mt-1 text-xs">Inbox</span>
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

                if (item.getAttribute('href') === currentPath || 
                    (item.id === 'nav-inbox' && currentPath.startsWith('/inbox'))) {
                    item.classList.remove('text-gray-500', 'dark:text-gray-400');
                    item.classList.add('text-blue-500');
                }
            });
        }

        // Initialize on load
        document.addEventListener('DOMContentLoaded', function() {
            setActiveNavItem();
            loadMobileInboxCount();
            
            // Update mobile inbox count every 30 seconds
            setInterval(loadMobileInboxCount, 30000);
        });
        
        function loadMobileInboxCount() {
            fetch('/inbox/unread/count')
                .then(response => response.json())
                .then(data => updateMobileInboxBadge(data.count))
                .catch(() => updateMobileInboxBadge(0));
        }
        
        function updateMobileInboxBadge(count) {
            const mobileInboxBadge = document.getElementById('mobileInboxBadge');
            if (mobileInboxBadge) {
                if (count > 0) {
                    mobileInboxBadge.textContent = count > 99 ? '99+' : count;
                    mobileInboxBadge.style.display = 'flex';
                } else {
                    mobileInboxBadge.style.display = 'none';
                }
            }
        }
        
        // Make function global for navigation to access
        window.updateMobileInboxBadge = updateMobileInboxBadge;

        // Add click handlers
        document.querySelectorAll('.mobile-bottom-nav a').forEach(item => {
            item.addEventListener('click', function() {
                document.querySelectorAll('.mobile-bottom-nav a').forEach(i => {
                    i.classList.remove('text-primary');
                    i.classList.add('text-gray-500', 'dark:text-gray-400');
                });
                this.classList.remove('text-gray-500', 'dark:text-gray-400');
                this.classList.add('text-primary');
            });
        });
    </script>
</div>
