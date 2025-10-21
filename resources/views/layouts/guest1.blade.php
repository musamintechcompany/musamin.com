<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Dynamic SEO -->
    <title>{{ $title ?? config('app.name', 'Laravel') }}</title>
    <meta name="description" content="{{ $metaDescription ?? 'Buy or rent premium ready-to-use websites instantly at ' . config('app.name', 'Laravel') }}">
    <meta name="keywords" content="{{ $metaKeywords ?? 'website marketplace, buy websites, rent websites, online business, digital assets' }}">

    <!-- OpenGraph -->
    <meta property="og:title" content="{{ $title ?? config('app.name', 'Laravel') }}">
    <meta property="og:description" content="{{ $metaDescription ?? 'Discover premium ready-made websites for sale or rent.' }}">
    <meta property="og:image" content="{{ $metaImage ?? 'https://musamin.com/company/logo/logo.png' }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $title ?? config('app.name', 'Laravel') }}">
    <meta name="twitter:description" content="{{ $metaDescription ?? 'Buy or rent websites instantly.' }}">
    <meta name="twitter:image" content="{{ $metaImage ?? 'https://musamin.com/company/logo/logo.png' }}">

    <!-- Favicon -->
    <link rel="icon" href="https://musamin.com/company/logo/logo.png" type="image/x-icon">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Tailwind / App -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    @stack('styles')

    <style>
        /* Nav underline animation */
        .nav-link {
            position: relative;
            padding-bottom: 4px;
            transition: color 0.3s;
        }
        .nav-link::after {
            content: '';
            position: absolute;
            width: 0%;
            height: 2px;
            bottom: 0;
            left: 0;
            background-color: #9333EA; /* Tailwind blue-500 */
            transition: width 0.3s ease-in-out;
        }
        .nav-link:hover::after,
        .nav-link.active::after {
            width: 100%;
        }
    </style>
</head>
<body class="font-sans antialiased text-gray-900 bg-white">
    {{-- <x-preloader /> --}}

    <!-- Navigation -->
    @include('guest1-pages.guest1-nav')

    <!-- Main Content -->
    <main class="min-h-screen">
        {{ $slot }}
    </main>

    <!-- Footer -->
    @include('guest1-pages.footer')

    @livewireScripts
    @stack('scripts')

    <script>
        // Mobile nav toggle
        document.addEventListener('DOMContentLoaded', () => {
            const toggleBtn = document.querySelector('#mobile-menu-toggle');
            const menu = document.querySelector('#mobile-menu');

            if (toggleBtn && menu) {
                toggleBtn.addEventListener('click', () => {
                    menu.classList.toggle('hidden');
                });
            }
        });
    </script>
</body>
</html>
