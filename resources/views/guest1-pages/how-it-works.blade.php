<x-guest1-layout>
    <x-slot name="title">{{ config('app.name') }} | How It Works Page</x-slot>

    <!-- How It Works Section -->
    <section class="min-h-screen py-16 bg-gray-50">
        <div class="container px-4 mx-auto max-w-7xl">
            <h2 class="mb-4 text-3xl font-bold text-center text-gray-800 md:text-4xl">How It Works</h2>
            <p class="mb-12 text-lg text-center text-gray-600">Get your perfect website in just a few simple steps</p>

            <div class="grid grid-cols-1 gap-8 md:grid-cols-3">
                <!-- Step 1 -->
                <div class="p-6 text-center bg-white rounded-lg shadow-md">
                    <div class="inline-flex items-center justify-center w-16 h-16 mb-6 text-purple-600 bg-purple-100 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <h3 class="mb-4 text-2xl font-bold text-gray-800">1. Browse Listings</h3>
                    <p class="text-gray-600">Explore our marketplace of premium websites. Filter by category, price, and other criteria to find your perfect match. Our detailed listings include traffic data, revenue information, and screenshots.</p>
                </div>

                <!-- Step 2 -->
                <div class="p-6 text-center bg-white rounded-lg shadow-md">
                    <div class="inline-flex items-center justify-center w-16 h-16 mb-6 text-purple-600 bg-purple-100 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z" />
                        </svg>
                    </div>
                    <h3 class="mb-4 text-2xl font-bold text-gray-800">2. Purchase or Rent</h3>
                    <p class="text-gray-600">Choose between buying outright or renting with flexible terms. Use our coin system for seamless transactions. We handle all the paperwork and legal aspects of the transfer.</p>
                </div>

                <!-- Step 3 -->
                <div class="p-6 text-center bg-white rounded-lg shadow-md">
                    <div class="inline-flex items-center justify-center w-16 h-16 mb-6 text-purple-600 bg-purple-100 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <h3 class="mb-4 text-2xl font-bold text-gray-800">3. Launch & Grow</h3>
                    <p class="text-gray-600">Get instant access to your new website. Our team will help with the transfer process so you can start growing immediately. We provide onboarding support to ensure your success.</p>
                </div>
            </div>

            <div class="mt-16 text-center">
                <div class="max-w-4xl mx-auto">
                    <div class="p-8 bg-white rounded-lg shadow-md">
                        <h3 class="mb-6 text-2xl font-bold text-gray-800 md:text-3xl">Why Choose Our Platform?</h3>
                        <ul class="space-y-4 text-left">
                            <li class="flex items-start">
                                <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0 w-6 h-6 mt-1 mr-3 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                <span class="text-gray-700">Verified website statistics and analytics</span>
                            </li>
                            <li class="flex items-start">
                                <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0 w-6 h-6 mt-1 mr-3 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                <span class="text-gray-700">Secure payment processing with coin system</span>
                            </li>
                            <li class="flex items-start">
                                <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0 w-6 h-6 mt-1 mr-3 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                <span class="text-gray-700">14-day money back guarantee on purchases</span>
                            </li>
                            <li class="flex items-start">
                                <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0 w-6 h-6 mt-1 mr-3 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                <span class="text-gray-700">Dedicated transfer support team</span>
                            </li>
                            <li class="flex items-start">
                                <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0 w-6 h-6 mt-1 mr-3 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                <span class="text-gray-700">Ongoing maintenance options available</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Coin Packs Section -->
    <section class="py-16 bg-white">
        <div class="container px-4 mx-auto max-w-7xl">
            <h2 class="mb-4 text-3xl font-bold text-center text-gray-800 md:text-4xl">Coin Packs</h2>
            <p class="mb-12 text-lg text-center text-gray-600">Purchase coins to access premium websites</p>

            <div class="grid grid-cols-1 gap-8 md:grid-cols-3">
                <!-- Basic Coin Pack -->
                <div class="flex flex-col overflow-hidden bg-white border border-gray-200 rounded-lg shadow-lg">
                    <div class="px-6 py-4 text-center bg-purple-600">
                        <h3 class="text-xl font-bold text-white">Basic Pack</h3>
                    </div>
                    <div class="flex flex-col flex-grow p-6">
                        <h4 class="my-4 text-xl font-semibold text-center text-gray-800">100 Coins</h4>
                        <ul class="flex-grow mb-8 space-y-3">
                            <li class="flex items-start">
                                <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0 w-5 h-5 mt-1 mr-3 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                <span class="text-gray-700">Access to basic websites</span>
                            </li>
                            <li class="flex items-start">
                                <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0 w-5 h-5 mt-1 mr-3 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                <span class="text-gray-700">Browse all listings</span>
                            </li>
                            <li class="flex items-start">
                                <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0 w-5 h-5 mt-1 mr-3 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                <span class="text-gray-700">Standard support</span>
                            </li>
                        </ul>
                        <div class="mt-auto text-center">
                            <div class="mb-4 text-2xl font-bold text-purple-600">$19.99</div>
                            <a href="#" class="inline-block px-6 py-3 font-medium text-white bg-purple-600 rounded-lg hover:bg-purple-700">Purchase Now</a>
                        </div>
                    </div>
                </div>

                <!-- Pro Coin Pack -->
                <div class="flex flex-col overflow-hidden bg-white border-2 border-purple-500 rounded-lg shadow-lg">
                    <div class="px-6 py-4 text-center bg-white">
                        <h3 class="text-xl font-bold text-purple-600">Pro Pack</h3>
                    </div>
                    <div class="flex flex-col flex-grow p-6">
                        <h4 class="my-4 text-xl font-semibold text-center text-gray-800">250 Coins</h4>
                        <ul class="flex-grow mb-8 space-y-3">
                            <li class="flex items-start">
                                <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0 w-5 h-5 mt-1 mr-3 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                <span class="text-gray-700">Access to premium websites</span>
                            </li>
                            <li class="flex items-start">
                                <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0 w-5 h-5 mt-1 mr-3 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                <span class="text-gray-700">Early access to new listings</span>
                            </li>
                            <li class="flex items-start">
                                <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0 w-5 h-5 mt-1 mr-3 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                <span class="text-gray-700">Priority support</span>
                            </li>
                            <li class="flex items-start">
                                <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0 w-5 h-5 mt-1 mr-3 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                <span class="text-gray-700">10% bonus coins</span>
                            </li>
                        </ul>
                        <div class="mt-auto text-center">
                            <div class="mb-4 text-2xl font-bold text-purple-600">$44.99</div>
                            <a href="#" class="inline-block px-6 py-3 font-medium text-white bg-purple-600 rounded-lg hover:bg-purple-700">Purchase Now</a>
                        </div>
                    </div>
                </div>

                <!-- Enterprise Coin Pack -->
                <div class="flex flex-col overflow-hidden bg-white border border-gray-200 rounded-lg shadow-lg">
                    <div class="px-6 py-4 text-center bg-gray-800">
                        <h3 class="text-xl font-bold text-white">Enterprise Pack</h3>
                    </div>
                    <div class="flex flex-col flex-grow p-6">
                        <h4 class="my-4 text-xl font-semibold text-center text-gray-800">500 Coins</h4>
                        <ul class="flex-grow mb-8 space-y-3">
                            <li class="flex items-start">
                                <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0 w-5 h-5 mt-1 mr-3 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                <span class="text-gray-700">Access to all websites</span>
                            </li>
                            <li class="flex items-start">
                                <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0 w-5 h-5 mt-1 mr-3 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                <span class="text-gray-700">VIP early access</span>
                            </li>
                            <li class="flex items-start">
                                <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0 w-5 h-5 mt-1 mr-3 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                <span class="text-gray-700">24/7 dedicated support</span>
                            </li>
                            <li class="flex items-start">
                                <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0 w-5 h-5 mt-1 mr-3 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                <span class="text-gray-700">25% bonus coins</span>
                            </li>
                            <li class="flex items-start">
                                <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0 w-5 h-5 mt-1 mr-3 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                <span class="text-gray-700">Free website migration</span>
                            </li>
                        </ul>
                        <div class="mt-auto text-center">
                            <div class="mb-4 text-2xl font-bold text-purple-600">$79.99</div>
                            <a href="#" class="inline-block px-6 py-3 font-medium text-white bg-gray-800 rounded-lg hover:bg-gray-900">Purchase Now</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-guest1-layout>
