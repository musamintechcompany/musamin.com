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
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        @livewireStyles
        @stack('styles')

        <!-- Immediate Theme Application -->
        <script>
            @auth
                @if(auth()->user()->theme === 'dark')
                    document.documentElement.classList.add('dark');
                @else
                    document.documentElement.classList.remove('dark');
                @endif
            @endauth
        </script>
    </head>
    <body class="font-sans antialiased">
        {{-- <x-welcome-note /> --}}
        <x-banner />
        {{-- <x-preloader /> --}}

        {{-- AFFILIATE LAYOUT STRUCTURE --}}
        <div class="flex min-h-screen bg-gray-100 dark:bg-gray-900">
            <!-- Affiliate Sidebar -->
            @include('components.affiliate.sidebar')

            {{-- CONTENT WRAPPER --}}
            <div class="flex flex-col flex-1 w-full min-h-screen transition-all duration-300 ease-in-out md:ml-[70px] md:[.sidebar:not(.collapsed)_~_&]:ml-[250px]">
                <!-- Affiliate Navigation Menu -->
                @include('components.affiliate.nav-menu')

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

        <!-- Affiliate Mobile Bottom Nav -->
        @include('components.affiliate.bottom-nav')

        <!-- Chat Modal -->
        @auth
            <x-chat-modal />
        @endauth

        @stack('modals')
        @livewireScripts

        <!-- Theme Synchronization Script -->
        <script>
            // Handle guests and general theme persistence
            @guest
                const savedTheme = localStorage.getItem('theme');
                const systemPrefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                if (savedTheme === 'dark' || (!savedTheme && systemPrefersDark)) {
                    document.documentElement.classList.add('dark');
                } else {
                    document.documentElement.classList.remove('dark');
                }
            @endguest

            // Always sync localStorage with the current theme
            localStorage.setItem('theme', document.documentElement.classList.contains('dark') ? 'dark' : 'light');

            // Listen for the theme change event from any component
            Livewire && Livewire.on('themeChanged', (theme) => {
                if (theme === 'dark') {
                    document.documentElement.classList.add('dark');
                } else {
                    document.documentElement.classList.remove('dark');
                }
                localStorage.setItem('theme', theme);
            });
        </script>
        @stack('scripts')
    </body>
</html>
