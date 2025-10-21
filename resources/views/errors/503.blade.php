<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Service Unavailable - {{ config('app.name', 'Laravel') }}</title>
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css'])
</head>
<body class="font-sans antialiased bg-gray-100 dark:bg-gray-900">
    <div class="min-h-screen flex items-center justify-center px-4">
        <div class="max-w-md w-full text-center">
            <div class="mb-8">
                <h1 class="text-9xl font-bold text-purple-300 dark:text-purple-600">503</h1>
                <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200 mb-4">Service Unavailable</h2>
                <p class="text-gray-600 dark:text-gray-400 mb-8">
                    We're temporarily down for maintenance. Please check back soon.
                </p>
            </div>
            
            <div class="space-y-4">
                <button onclick="location.reload()" 
                        class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors">
                    <i class="fas fa-refresh mr-2"></i>
                    Try Again
                </button>
                
                <div class="text-sm text-gray-500 dark:text-gray-400">
                    <p>Expected maintenance time: 30 minutes</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>