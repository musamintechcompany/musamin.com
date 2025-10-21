<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Page Expired - {{ config('app.name', 'Laravel') }}</title>
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css'])
</head>
<body class="font-sans antialiased bg-gray-100 dark:bg-gray-900">
    <div class="min-h-screen flex items-center justify-center px-4">
        <div class="max-w-md w-full text-center">
            <div class="mb-8">
                <h1 class="text-9xl font-bold text-orange-300 dark:text-orange-600">419</h1>
                <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200 mb-4">Page Expired</h2>
                <p class="text-gray-600 dark:text-gray-400 mb-8">
                    Your session has expired. Please refresh the page and try again.
                </p>
            </div>
            
            <div class="space-y-4">
                <button onclick="location.reload()" 
                        class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors">
                    <i class="fas fa-refresh mr-2"></i>
                    Refresh Page
                </button>
                
                <div class="flex justify-center space-x-4 text-sm">
                    <a href="{{ url('/') }}" 
                       class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                        <i class="fas fa-home mr-1"></i>
                        Go Home
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>