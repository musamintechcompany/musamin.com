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

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/css/auth/register.css', 'resources/js/auth/register.js', 'resources/css/auth/login.css','resources/js/auth/login.js', 'resources/js/app.js'])

        <!-- Styles -->
        @livewireStyles
        
        <!-- Theme Detection Script -->
        <script>
            // Apply theme immediately to prevent flash
            @auth
                @if(auth()->user()->theme === 'dark')
                    document.documentElement.classList.add('dark');
                @else
                    document.documentElement.classList.remove('dark');
                @endif
            @else
                // For guests, use system preference
                const systemPrefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                if (systemPrefersDark) {
                    document.documentElement.classList.add('dark');
                } else {
                    document.documentElement.classList.remove('dark');
                }
            @endauth
        </script>
    </head>
    <body class="font-sans antialiased text-gray-900 bg-white dark:text-gray-100 dark:bg-gray-900 transition-colors duration-200">

        
        {{ $slot }}

        @livewireScripts
        

    </body>
</html>
