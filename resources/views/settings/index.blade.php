<x-app-layout>
    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700">
                    <h2 class="mb-6 text-2xl font-semibold text-gray-800 dark:text-gray-200">Settings</h2>

                    <div class="space-y-4">
                        <!-- Today's Rate -->
                        <div class="flex items-center justify-between p-4 rounded-lg cursor-pointer bg-gray-50 dark:bg-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600" onclick="window.location.href='{{ route('settings.rates') }}'">
                            <div class="flex items-center">
                                <span class="text-lg font-medium text-gray-900 dark:text-gray-100">Today's Rate</span>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-500 dark:text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                        </div>

                        <!-- My Account Settings -->
                        <div class="flex items-center justify-between p-4 rounded-lg cursor-pointer bg-gray-50 dark:bg-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600" onclick="window.location.href='{{ route('settings.account') }}'">
                            <div class="flex items-center">
                                <span class="text-lg font-medium text-gray-900 dark:text-gray-100">My Account Settings</span>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-500 dark:text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                        </div>

                        <!-- Phone Verification -->
                        <div class="flex items-center justify-between p-4 rounded-lg cursor-pointer bg-gray-50 dark:bg-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600" onclick="window.location.href='{{ route('settings.security') }}'">
                            <div class="flex items-center">
                                <span class="text-lg font-medium text-gray-900 dark:text-gray-100">Security & Phone</span>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-500 dark:text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                        </div>

                        <!-- Appearance -->
                        <div class="flex items-center justify-between p-4 rounded-lg cursor-pointer bg-gray-50 dark:bg-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600" onclick="window.location.href='{{ route('settings.appearance') }}'">
                            <div class="flex items-center">
                                <span class="text-lg font-medium text-gray-900 dark:text-gray-100">Appearance</span>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-500 dark:text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                        </div>

                        <!-- Referrals -->
                        <div class="flex items-center justify-between p-4 rounded-lg cursor-pointer bg-gray-50 dark:bg-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600" onclick="showComingSoon()">
                            <div class="flex items-center">
                                <span class="text-lg font-medium text-gray-900 dark:text-gray-100">Referrals</span>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-500 dark:text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                        </div>



                        <!-- Logout -->
                        <div class="flex items-center justify-between p-4 rounded-lg cursor-pointer bg-gray-50 dark:bg-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600" onclick="showLogoutConfirmation()">
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2 text-gray-500 dark:text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M3 3a1 1 0 00-1 1v12a1 1 0 102 0V4a1 1 0 00-1-1zm10.293 9.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L14.586 9H7a1 1 0 100 2h7.586l-1.293 1.293z" clip-rule="evenodd" />
                                </svg>
                                <span class="text-lg font-medium text-gray-900 dark:text-gray-100">Logout</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Coming Soon Modal -->
    <div id="comingSoonModal" class="fixed inset-0 hidden items-center justify-center p-4 bg-black bg-opacity-50" style="z-index: 9999999;">
        <div class="w-full max-w-md p-6 overflow-hidden text-left align-middle transition-all transform bg-white rounded-lg shadow-xl dark:bg-gray-800">
            <h3 class="mb-4 text-lg font-medium text-gray-900 dark:text-gray-100">Coming Soon</h3>
            <p class="mb-6 text-gray-600 dark:text-gray-300">This feature is coming soon.</p>
            <div class="flex justify-end">
                <button onclick="hideComingSoon()"
                    class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    OK
                </button>
            </div>
        </div>
    </div>

    <!-- Logout Confirmation Modal -->
    <div id="logoutModal" class="fixed inset-0 hidden items-center justify-center p-4 bg-black bg-opacity-50" style="z-index: 9999999;">
        <div class="w-full max-w-md p-6 overflow-hidden text-center align-middle transition-all transform bg-white rounded-lg shadow-xl dark:bg-gray-800">
            <h3 class="mb-4 text-lg font-medium text-center text-gray-900 dark:text-gray-100">Confirm Logout</h3>
            <p class="mb-6 text-center text-gray-600 dark:text-gray-300">Are you sure you want to logout from {{ config('app.name') }}?</p>
            <div class="flex justify-between space-x-4">
                <button onclick="hideLogoutConfirmation()"
                    class="flex-1 px-6 py-3 text-sm font-medium text-gray-700 bg-gray-100 rounded-md dark:text-gray-300 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Not Yet
                </button>
                <form method="POST" action="{{ route('logout') }}" class="flex-1">
                    @csrf
                    <button type="submit"
                        class="w-full px-6 py-3 text-sm font-medium text-white bg-red-600 rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Modal functions
        function showComingSoon() {
            document.getElementById('comingSoonModal').classList.remove('hidden');
            document.getElementById('comingSoonModal').classList.add('flex');
        }

        function hideComingSoon() {
            document.getElementById('comingSoonModal').classList.add('hidden');
            document.getElementById('comingSoonModal').classList.remove('flex');
        }

        function showLogoutConfirmation() {
            document.getElementById('logoutModal').classList.remove('hidden');
            document.getElementById('logoutModal').classList.add('flex');
        }

        function hideLogoutConfirmation() {
            document.getElementById('logoutModal').classList.add('hidden');
            document.getElementById('logoutModal').classList.remove('flex');
        }
    </script>
</x-app-layout>
