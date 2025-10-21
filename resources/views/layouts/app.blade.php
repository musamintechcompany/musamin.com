<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        <!-- Scripts & Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
        @stack('styles')
        
        <!-- Echo/Reverb for real-time messaging -->
        <script>
            window.Laravel = {
                csrfToken: '{{ csrf_token() }}',
                userId: {{ auth()->check() ? auth()->id() : 'null' }}
            };
        </script>

        <!-- Immediate Theme Application -->
        @auth
            @if(auth()->user()->prefersDarkTheme())
                <script>
                    document.documentElement.classList.add('dark');
                </script>
            @endif
        @endauth
    </head>
    <body class="font-sans antialiased">
        {{-- <x-welcome-note /> --}}
        <x-banner />
        {{-- <x-preloader /> --}}

        {{-- OLD LAYOUT STRUCTURE WITH SIDEBAR --}}
        <div class="flex min-h-screen bg-gray-100 dark:bg-gray-900">
            <!-- Your Custom Sidebar -->
            @include('components.layout.sidebar')

            {{-- CONTENT WRAPPER - All CSS converted to Tailwind classes here --}}
            <div class="flex flex-col flex-1 w-full min-h-screen transition-all duration-300 ease-in-out md:ml-[70px] md:[.sidebar:not(.collapsed)_~_&]:ml-[250px]">
                <!-- Your Custom Top Navigation Menu -->
                @include('components.layout.navigation-menu')

                <!-- Page Heading -->
                @if (isset($header))
                    <header class="bg-white shadow dark:bg-gray-800">
                        <div class="px-4 py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
                            {{ $header }}
                        </div>
                    </header>
                @endif

                <!-- Page Content -->
                <main>
                    {{ $slot }}
                </main>
            </div>
        </div>

        <!-- Your Mobile Bottom Nav -->
        @include('components.layout.bottom-nav')
        
        <!-- Chat Modal -->
        @auth
            <x-chat-modal />
        @endauth

        @stack('modals')
        @livewireScripts

        <!-- Theme Synchronization Script -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                try {
                    @guest
                        try {
                            const savedTheme = localStorage.getItem('theme');
                            let systemPrefersDark = false;
                            try {
                                systemPrefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
                            } catch (mediaError) {
                                console.warn('Media query failed:', mediaError);
                            }
                            if (savedTheme === 'dark' || (!savedTheme && systemPrefersDark)) {
                                document.documentElement.classList.add('dark');
                            } else {
                                document.documentElement.classList.remove('dark');
                            }
                        } catch (e) {
                            console.warn('Guest theme handling failed:', e);
                        }
                    @endguest

                    try {
                        localStorage.setItem('theme', document.documentElement.classList.contains('dark') ? 'dark' : 'light');
                    } catch (e) {
                        console.warn('LocalStorage access failed:', e);
                    }

                    if (typeof Livewire !== 'undefined') {
                        Livewire.on('themeChanged', (theme) => {
                            try {
                                if (theme === 'dark') {
                                    document.documentElement.classList.add('dark');
                                } else {
                                    document.documentElement.classList.remove('dark');
                                }
                                localStorage.setItem('theme', theme);
                            } catch (e) {
                                console.warn('Theme change failed:', e);
                            }
                        });
                    }
                } catch (e) {
                    console.warn('Theme synchronization failed:', e);
                }

                // Cart synchronization for authenticated users
                @auth
                    syncGuestCart();
                    loadUnreadMessageCount();
                @endauth
            });

            @auth
            function syncGuestCart() {
                const guestCart = sessionStorage.getItem('cart');
                if (guestCart && guestCart !== '{}') {
                    fetch('/cart/sync', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({
                            cart_data: guestCart
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            sessionStorage.removeItem('cart');
                            console.log('Guest cart synced successfully');
                        }
                    })
                    .catch(error => {
                        console.error('Cart sync error:', error);
                    });
                }
            }

            function loadUnreadMessageCount() {
                fetch('/inbox/unread/count')
                    .then(response => response.json())
                    .then(data => {
                        updateInboxBadge(data.count);
                    })
                    .catch(error => {
                        console.error('Error loading unread count:', error);
                    });
            }

            function updateInboxBadge(count) {
                const badges = [
                    document.getElementById('inboxBadge'),
                    document.getElementById('mobileInboxBadge')
                ];
                
                badges.forEach(badge => {
                    if (badge) {
                        if (count > 0) {
                            badge.textContent = count > 9 ? '9+' : count;
                            badge.style.display = 'flex';
                        } else {
                            badge.style.display = 'none';
                        }
                    }
                });
            }
            @endauth
        </script>
        @stack('scripts')
    </body>
</html>
