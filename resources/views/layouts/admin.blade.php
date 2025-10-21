<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $title ?? 'Admin Panel' }} - {{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        <!-- Scripts & Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        

        @livewireStyles
        {{ $styles ?? '' }}
        @stack('styles')

        <!-- Theme Application -->
        <script>
            @auth('admin')
                // Apply admin theme on page load
                const theme = '{{ auth("admin")->user()->theme ?? "light" }}';
                
                if (theme === 'dark') {
                    document.documentElement.classList.add('dark');
                }
            @endauth
        </script>
        

    </head>
    <body class="font-sans antialiased overflow-x-hidden">
        @if($showNavigation ?? true)
            <div class="flex min-h-screen bg-gray-100 dark:bg-gray-900 overflow-x-hidden">
                <!-- Admin Sidebar -->
                @include('components.management.portal.admin.sidebar')

                <!-- Content Wrapper -->
                <div class="flex flex-col flex-1 w-full min-h-screen transition-all duration-300 ease-in-out md:ml-[70px] md:[.sidebar:not(.collapsed)_~_&]:ml-[250px] overflow-x-hidden">
                    <!-- Admin Top Navigation Menu -->
                    @include('components.management.portal.admin.navigation-menu')

                    <!-- Page Heading -->
                    @isset($header)
                        <header class="bg-white shadow dark:bg-gray-800">
                            <div class="px-4 py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
                                {{ $header }}
                            </div>
                        </header>
                    @endisset

                    <!-- Page Content -->
                    <main class="overflow-x-hidden">
                        {{ $slot }}
                    </main>
                </div>
            </div>

            <!-- Admin Mobile Bottom Nav -->
            @include('components.management.portal.admin.bottom-nav')
        @else
            <main>
                {{ $slot }}
            </main>
        @endif

        @stack('modals')
        @livewireScripts

        <!-- Theme Functions -->
        <script>
            function getCurrentTheme() {
                return document.documentElement.classList.contains('dark') ? 'dark' : 'light';
            }
            
            function applyTheme(theme) {
                if (theme === 'dark') {
                    document.documentElement.classList.add('dark');
                } else {
                    document.documentElement.classList.remove('dark');
                }
            }
            
            // Sync with localStorage
            localStorage.setItem('admin-theme', getCurrentTheme());

            // Listen for theme changes
            document.addEventListener('adminThemeChanged', function(event) {
                applyTheme(event.detail.theme);
                localStorage.setItem('admin-theme', event.detail.theme);
            });
        </script>
        
        <!-- Broadcasting & Notifications -->
        <script>
            // Admin Notifications System
            window.adminNotifications = {
                sound: new Audio('/sounds/notification.mp3'),
                
                init() {
                    this.sound.volume = 1.0;
                    this.sound.preload = 'auto';
                    this.setupEcho();
                    this.loadUnreadCount();
                },
                
                setupEcho() {
                    if (typeof window.Echo !== 'undefined') {
                        // Listen for admin notifications
                        window.Echo.private('admin.{{ auth("admin")->id() }}')
                            .notification((notification) => {
                                this.handleNotification(notification);
                            });
                    }
                },
                
                handleNotification(notification) {
                    // Play sound
                    this.playSound();
                    
                    // Show toast notification
                    this.showToast(notification);
                    
                    // Update notification count
                    this.updateNotificationCount();
                },
                
                playSound() {
                    try {
                        this.sound.volume = 1.0;
                        this.sound.currentTime = 0;
                        this.sound.play().catch(e => console.log('Sound play failed:', e));
                    } catch (e) {
                        console.log('Sound error:', e);
                    }
                },
                
                showToast(notification) {
                    // Create toast element
                    const toast = document.createElement('div');
                    toast.className = 'fixed top-4 right-4 bg-blue-600 text-white px-6 py-4 rounded-lg shadow-lg z-50 max-w-sm';
                    toast.innerHTML = `
                        <div class="flex items-start">
                            <i class="fas fa-${notification.icon || 'bell'} mr-3 mt-1"></i>
                            <div>
                                <div class="font-semibold">${notification.type || 'Notification'}</div>
                                <div class="text-sm opacity-90">${notification.message}</div>
                            </div>
                        </div>
                    `;
                    
                    document.body.appendChild(toast);
                    
                    // Auto remove after 5 seconds
                    setTimeout(() => {
                        if (toast.parentNode) {
                            toast.parentNode.removeChild(toast);
                        }
                    }, 5000);
                    
                    // Click to remove
                    toast.addEventListener('click', () => {
                        if (toast.parentNode) {
                            toast.parentNode.removeChild(toast);
                        }
                    });
                },
                
                updateNotificationCount() {
                    fetch('/management/portal/admin/notifications/unread')
                        .then(response => response.json())
                        .then(data => {
                            const badge = document.getElementById('adminNotificationBadge');
                            if (badge) {
                                badge.textContent = data.count > 99 ? '99+' : data.count;
                                badge.style.display = data.count > 0 ? 'flex' : 'none';
                            }
                        })
                        .catch(e => console.log('Failed to update notification count:', e));
                },
                
                loadUnreadCount() {
                    this.updateNotificationCount();
                }
            };
            
            // Initialize when DOM is ready
            document.addEventListener('DOMContentLoaded', function() {
                window.adminNotifications.init();
                
                // Add test sound button (remove in production)
                if (window.location.search.includes('test-sound')) {
                    const testBtn = document.createElement('button');
                    testBtn.innerHTML = '🔊 Test Sound';
                    testBtn.className = 'fixed bottom-4 right-4 bg-red-500 text-white px-4 py-2 rounded z-50';
                    testBtn.onclick = () => {
                        window.adminNotifications.playSound();
                        window.adminNotifications.showToast({
                            type: 'Test Notification',
                            message: 'This is a test notification with sound',
                            icon: 'bell'
                        });
                    };
                    document.body.appendChild(testBtn);
                }
            });
        </script>
        
        @stack('scripts')
    </body>
</html>
