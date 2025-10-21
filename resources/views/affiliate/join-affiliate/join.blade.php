<x-app-layout>
    <div class="py-6 sm:py-12 bg-white dark:bg-gray-900">
        <div class="max-w-6xl px-4 mx-auto sm:px-6 lg:px-8">
                    {{-- Header Section --}}
                    <div class="mb-6 text-center sm:mb-8">
                        <h1 class="mb-3 text-2xl font-bold text-gray-900 sm:mb-4 sm:text-3xl dark:text-white">
                            Become an Affiliate Partner
                        </h1>
                        <p class="text-base text-gray-600 sm:text-lg dark:text-gray-400">
                            Unlock exclusive benefits and start earning with our affiliate program
                        </p>
                    </div>

                    {{-- Benefits Grid --}}
                    <div class="grid grid-cols-1 gap-4 mb-6 sm:grid-cols-2 lg:grid-cols-3 sm:gap-6 sm:mb-8">
                        <div class="p-4 text-center rounded-lg sm:p-6 bg-gradient-to-br from-blue-50 to-indigo-100 dark:from-blue-900 dark:to-indigo-900">
                            <div class="flex items-center justify-center w-12 h-12 mx-auto mb-3 bg-blue-500 rounded-full sm:w-16 sm:h-16 sm:mb-4">
                                <i class="text-lg text-white sm:text-2xl fas fa-percentage"></i>
                            </div>
                            <h3 class="mb-2 text-lg font-semibold text-gray-900 sm:text-xl dark:text-white">High Commission</h3>
                            <p class="text-sm text-gray-600 sm:text-base dark:text-gray-400">Earn up to 30% commission on every successful referral</p>
                        </div>

                        <div class="p-4 text-center rounded-lg sm:p-6 bg-gradient-to-br from-green-50 to-emerald-100 dark:from-green-900 dark:to-emerald-900">
                            <div class="flex items-center justify-center w-12 h-12 mx-auto mb-3 bg-green-500 rounded-full sm:w-16 sm:h-16 sm:mb-4">
                                <i class="text-lg text-white sm:text-2xl fas fa-store"></i>
                            </div>
                            <h3 class="mb-2 text-lg font-semibold text-gray-900 sm:text-xl dark:text-white">Create Your Store</h3>
                            <p class="text-sm text-gray-600 sm:text-base dark:text-gray-400">Build your own public store visible to all platform users</p>
                        </div>

                        <div class="p-4 text-center rounded-lg sm:p-6 bg-gradient-to-br from-purple-50 to-violet-100 dark:from-purple-900 dark:to-violet-900">
                            <div class="flex items-center justify-center w-12 h-12 mx-auto mb-3 bg-purple-500 rounded-full sm:w-16 sm:h-16 sm:mb-4">
                                <i class="text-lg text-white sm:text-2xl fas fa-box"></i>
                            </div>
                            <h3 class="mb-2 text-lg font-semibold text-gray-900 sm:text-xl dark:text-white">Marketplace Assets</h3>
                            <p class="text-sm text-gray-600 sm:text-base dark:text-gray-400">Add assets to our marketplace with free promotional ads</p>
                        </div>

                        <div class="p-4 text-center rounded-lg sm:p-6 bg-gradient-to-br from-yellow-50 to-orange-100 dark:from-yellow-900 dark:to-orange-900">
                            <div class="flex items-center justify-center w-12 h-12 mx-auto mb-3 bg-yellow-500 rounded-full sm:w-16 sm:h-16 sm:mb-4">
                                <i class="text-lg text-white sm:text-2xl fas fa-bullhorn"></i>
                            </div>
                            <h3 class="mb-2 text-lg font-semibold text-gray-900 sm:text-xl dark:text-white">Free Advertising</h3>
                            <p class="text-sm text-gray-600 sm:text-base dark:text-gray-400">We promote your assets across multiple platforms for free</p>
                        </div>

                        <div class="p-4 text-center rounded-lg sm:p-6 bg-gradient-to-br from-pink-50 to-rose-100 dark:from-pink-900 dark:to-rose-900">
                            <div class="flex items-center justify-center w-12 h-12 mx-auto mb-3 bg-pink-500 rounded-full sm:w-16 sm:h-16 sm:mb-4">
                                <i class="text-lg text-white sm:text-2xl fas fa-chart-line"></i>
                            </div>
                            <h3 class="mb-2 text-lg font-semibold text-gray-900 sm:text-xl dark:text-white">Real-time Analytics</h3>
                            <p class="text-sm text-gray-600 sm:text-base dark:text-gray-400">Monitor your performance with detailed analytics dashboard</p>
                        </div>

                        <div class="p-4 text-center rounded-lg sm:p-6 bg-gradient-to-br from-teal-50 to-cyan-100 dark:from-teal-900 dark:to-cyan-900">
                            <div class="flex items-center justify-center w-12 h-12 mx-auto mb-3 bg-teal-500 rounded-full sm:w-16 sm:h-16 sm:mb-4">
                                <i class="text-lg text-white sm:text-2xl fas fa-users"></i>
                            </div>
                            <h3 class="mb-2 text-lg font-semibold text-gray-900 sm:text-xl dark:text-white">Global Visibility</h3>
                            <p class="text-sm text-gray-600 sm:text-base dark:text-gray-400">Your store becomes public to all users, increasing customer reach</p>
                        </div>
                    </div>

                    {{-- Join Button Section --}}
                    <div class="text-center">
                        @if(auth()->user()->isAffiliate())
                            {{-- Go to Dashboard Button --}}
                            <a href="{{ route('affiliate.dashboard') }}" class="inline-flex items-center px-4 py-2 text-sm font-semibold text-white transition duration-150 ease-in-out border border-transparent rounded-lg sm:px-6 sm:py-3 sm:text-base bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                                <i class="mr-2 fas fa-tachometer-alt"></i>
                                Go to Affiliate Dashboard
                            </a>
                        @elseif(auth()->user()->affiliate && auth()->user()->affiliate->isExpired())
                            {{-- Renew Membership Button --}}
                            <button id="joinAffiliateBtn" class="inline-flex items-center px-4 py-2 text-sm font-semibold text-white transition duration-150 ease-in-out border border-transparent rounded-lg sm:px-6 sm:py-3 sm:text-base bg-gradient-to-r from-orange-500 to-red-600 hover:from-orange-600 hover:to-red-700 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2">
                                <i class="mr-2 fas fa-sync-alt"></i>
                                Renew Membership
                            </button>
                        @else
                            {{-- Join Affiliate Button - Opens Modal --}}
                            <button id="joinAffiliateBtn" class="inline-flex items-center px-4 py-2 text-sm font-semibold text-white transition duration-150 ease-in-out border border-transparent rounded-lg sm:px-6 sm:py-3 sm:text-base bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-600 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                <i class="mr-2 fas fa-rocket"></i>
                                Join Now
                            </button>
                        @endif

                        <p class="mt-3 text-xs text-gray-500 sm:mt-4 sm:text-sm dark:text-gray-400">
                            @if(auth()->user()->isAffiliate())
                                Welcome back! Manage your affiliate account from the dashboard.
                            @elseif(auth()->user()->affiliate && auth()->user()->affiliate->isExpired())
                                Your membership has expired. Renew to regain access to all affiliate benefits.
                            @else
                                By joining, you agree to our <a href="#" class="text-indigo-600 hover:text-indigo-500">terms</a> and <a href="#" class="text-indigo-600 hover:text-indigo-500">conditions</a>
                            @endif
                        </p>
                    </div>

            {{-- Include Payment Modal --}}
            @include('affiliate.join-affiliate.modals.join-modal')
        </div>
    </div>
</x-app-layout>
