<x-app-layout>
    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700">
                    <div class="sticky top-0 flex items-center py-2 mb-6 bg-white dark:bg-gray-800">
                        <button onclick="window.history.back()" class="mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-500 dark:text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                            </svg>
                        </button>
                        <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200">My Account Settings</h2>
                    </div>

                    @php
                        $settings = \App\Models\Setting::first();
                    @endphp
                    
                    <div class="space-y-4">
                        <div class="flex items-center justify-between p-4 transition-colors duration-200 rounded-lg cursor-pointer bg-gray-50 dark:bg-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600" onclick="window.location.href='{{ route('profile.show') }}'">
                            <div class="flex items-center">
                                <span class="text-lg font-medium text-gray-900 dark:text-gray-100">Profile Settings</span>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-500 dark:text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                        </div>

                        @if ($settings && $settings->kyc_enabled)
                            <div class="flex items-center justify-between p-4 transition-colors duration-200 rounded-lg cursor-pointer bg-gray-50 dark:bg-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600" onclick="window.location.href='{{ route('settings.kyc') }}'">
                                <div class="flex items-center">
                                    <span class="text-lg font-medium text-gray-900 dark:text-gray-100">Update KYC</span>
                                </div>
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-500 dark:text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        @endif

                        <div class="flex items-center justify-between p-4 transition-colors duration-200 rounded-lg cursor-pointer bg-gray-50 dark:bg-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600" onclick="window.location.href='{{ route('settings.withdrawal-bank') }}'">
                            <div class="flex items-center">
                                <span class="text-lg font-medium text-gray-900 dark:text-gray-100">Withdrawal Bank</span>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-500 dark:text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Initialize theme from database on page load
        document.addEventListener('DOMContentLoaded', function() {
            // Get theme from database (injected via Blade)
            const dbTheme = "{{ auth()->user()->theme }}";

            // Apply the theme if it exists
            if (dbTheme) {
                applyTheme(dbTheme);
                localStorage.setItem('theme', dbTheme);
            }
        });

        function applyTheme(theme) {
            const html = document.documentElement;
            html.classList.remove('light', 'dark');
            html.classList.add(theme);
        }

        function showComingSoon() {
            alert('We are working on this feature, please check back later');
        }
    </script>
    @endpush
</x-app-layout>
