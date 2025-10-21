<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Access Forbidden - {{ config('app.name', 'Laravel') }}</title>
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css'])
</head>
<body class="font-sans antialiased bg-gray-100 dark:bg-gray-900">
    <div class="min-h-screen flex items-center justify-center px-4">
        <div class="max-w-md w-full text-center">
            <div class="mb-8">
                <h1 class="text-9xl font-bold text-yellow-300 dark:text-yellow-600">403</h1>
                <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200 mb-4">Access Forbidden</h2>
                <p class="text-gray-600 dark:text-gray-400 mb-8">
                    You don't have permission to access this resource.
                </p>
            </div>
            
            <div class="space-y-4">
                <a href="{{ url('/') }}" 
                   class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors">
                    <i class="fas fa-home mr-2"></i>
                    Go Home
                </a>
                
                <div class="flex justify-center space-x-4 text-sm">
                    <button onclick="history.back()" 
                            class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                        <i class="fas fa-arrow-left mr-1"></i>
                        Go Back
                    </button>
                </div>
            </div>
        </div>
    </div>
</body>
</html>