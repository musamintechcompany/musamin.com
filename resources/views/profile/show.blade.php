<x-app-layout>

    <div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8 space-y-6">
            @php
                $settings = \App\Models\Setting::first();
            @endphp
            
            @if ($settings->profile_information_required ?? true)
                <!-- Profile Information Section -->
                <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                    <div class="cursor-pointer px-4 py-5 sm:p-6 border-b border-gray-200 dark:border-gray-700" onclick="toggleSection('profile-info')">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Profile Information</h3>
                                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Update your account's profile information and email address.</p>
                            </div>
                            <i id="profile-info-arrow" class="fas fa-chevron-right text-gray-400 transition-transform duration-200"></i>
                        </div>
                    </div>
                    <div id="profile-info-content" class="hidden px-4 py-5 sm:p-6">
                        @include('profile.update-profile-information-form')
                    </div>
                </div>
            @endif

            @if ($settings->password_change_required ?? true)
                <!-- Password Section -->
                <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                    <div class="cursor-pointer px-4 py-5 sm:p-6 border-b border-gray-200 dark:border-gray-700" onclick="toggleSection('password')">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Update Password</h3>
                                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Ensure your account is using a long, random password to stay secure.</p>
                            </div>
                            <i id="password-arrow" class="fas fa-chevron-right text-gray-400 transition-transform duration-200"></i>
                        </div>
                    </div>
                    <div id="password-content" class="hidden px-4 py-5 sm:p-6">
                        @include('profile.update-password-form')
                    </div>
                </div>
            @endif

            @if ($settings->two_factor_auth_required ?? true)
                <!-- Two Factor Authentication Section -->
                <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                    <div class="cursor-pointer px-4 py-5 sm:p-6 border-b border-gray-200 dark:border-gray-700" onclick="toggleSection('two-factor')">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Two Factor Authentication</h3>
                                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Add additional security to your account using two factor authentication.</p>
                            </div>
                            <i id="two-factor-arrow" class="fas fa-chevron-right text-gray-400 transition-transform duration-200"></i>
                        </div>
                    </div>
                    <div id="two-factor-content" class="hidden px-4 py-5 sm:p-6">
                        @include('profile.two-factor-authentication-form')
                    </div>
                </div>
            @endif

            @if ($settings->browser_sessions_required ?? true)
                <!-- Browser Sessions Section -->
                <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                    <div class="cursor-pointer px-4 py-5 sm:p-6 border-b border-gray-200 dark:border-gray-700" onclick="toggleSection('browser-sessions')">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Browser Sessions</h3>
                                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Manage and log out your active sessions on other browsers and devices.</p>
                            </div>
                            <i id="browser-sessions-arrow" class="fas fa-chevron-right text-gray-400 transition-transform duration-200"></i>
                        </div>
                    </div>
                    <div id="browser-sessions-content" class="hidden px-4 py-5 sm:p-6">
                        @include('profile.logout-other-browser-sessions-form')
                    </div>
                </div>
            @endif

            @if ($settings && $settings->account_deletion_required)
                <!-- Delete Account Section -->
                <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                    <div class="cursor-pointer px-4 py-5 sm:p-6 border-b border-gray-200 dark:border-gray-700" onclick="toggleSection('delete-account')">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Delete Account</h3>
                                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Permanently delete your account.</p>
                            </div>
                            <i id="delete-account-arrow" class="fas fa-chevron-right text-gray-400 transition-transform duration-200"></i>
                        </div>
                    </div>
                    <div id="delete-account-content" class="hidden px-4 py-5 sm:p-6">
                        @include('profile.delete-user-form')
                    </div>
                </div>
            @endif
        </div>
    </div>

    <script>
    function toggleSection(sectionId) {
        const content = document.getElementById(sectionId + '-content');
        const arrow = document.getElementById(sectionId + '-arrow');
        
        if (content.classList.contains('hidden')) {
            content.classList.remove('hidden');
            arrow.classList.add('rotate-90');
        } else {
            content.classList.add('hidden');
            arrow.classList.remove('rotate-90');
        }
    }
    </script>
</x-app-layout>
