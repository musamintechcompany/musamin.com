<x-admin-layout title="General Settings">
<div class="p-4 lg:p-6">
    <div class="space-y-4 overflow-hidden">
        <div class="flex flex-col sm:flex-row lg:justify-between lg:items-center gap-4">
            <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold text-gray-900 dark:text-white">General Settings</h1>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
            <form method="POST" action="{{ route('admin.settings.general.update') }}" class="p-6 space-y-6">
                @csrf
                @method('PUT')
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Application Name</label>
                    <input type="text" name="app_name" value="{{ old('app_name', $settings->app_name) }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" 
                           required>
                    @error('app_name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-between">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Require Email Verification</label>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Users must verify email during registration</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="hidden" name="email_verification_required" value="0">
                        <input type="checkbox" name="email_verification_required" value="1" 
                               {{ old('email_verification_required', $settings->email_verification_required) ? 'checked' : '' }}
                               class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                    </label>
                </div>

                <div class="flex items-center justify-between">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Enable SMS Notifications</label>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Allow SMS functionality across the platform</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="hidden" name="sms_enabled" value="0">
                        <input type="checkbox" name="sms_enabled" value="1" 
                               {{ old('sms_enabled', $settings->sms_enabled) ? 'checked' : '' }}
                               class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                    </label>
                </div>

                <div class="flex items-center justify-between">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Hide Admin Registration</label>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Prevent new admin registrations</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="hidden" name="hide_admin_registration" value="0">
                        <input type="checkbox" name="hide_admin_registration" value="1" 
                               {{ old('hide_admin_registration', $settings->hide_admin_registration) ? 'checked' : '' }}
                               class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                    </label>
                </div>

                <div class="flex items-center justify-between">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Terms & Privacy Required</label>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Require users to accept terms and privacy policy</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="hidden" name="terms_privacy_required" value="0">
                        <input type="checkbox" name="terms_privacy_required" value="1" 
                               {{ old('terms_privacy_required', $settings->terms_privacy_required ?? true) ? 'checked' : '' }}
                               class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                    </label>
                </div>

                <div class="flex items-center justify-between">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Enable KYC Verification</label>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Require users to complete KYC verification</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="hidden" name="kyc_enabled" value="0">
                        <input type="checkbox" name="kyc_enabled" value="1" 
                               {{ old('kyc_enabled', $settings->kyc_enabled) ? 'checked' : '' }}
                               class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                    </label>
                </div>

                <div class="border-t pt-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Support System Controls</h3>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">WhatsApp Support</label>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Enable WhatsApp support functionality</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="hidden" name="whatsapp_enabled" value="0">
                                <input type="checkbox" name="whatsapp_enabled" value="1" 
                                       {{ old('whatsapp_enabled', $settings->whatsapp_enabled) ? 'checked' : '' }}
                                       class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                            </label>
                        </div>

                        <div class="flex items-center justify-between">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Live Chat Support</label>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Enable live chat support functionality</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="hidden" name="live_chat_support_enabled" value="0">
                                <input type="checkbox" name="live_chat_support_enabled" value="1" 
                                       {{ old('live_chat_support_enabled', $settings->live_chat_support_enabled) ? 'checked' : '' }}
                                       class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                            </label>
                        </div>

                        <div class="flex items-center justify-between">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Request Callback</label>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Enable request callback functionality</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="hidden" name="request_callback_enabled" value="0">
                                <input type="checkbox" name="request_callback_enabled" value="1" 
                                       {{ old('request_callback_enabled', $settings->request_callback_enabled) ? 'checked' : '' }}
                                       class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                            </label>
                        </div>

                        <div class="flex items-center justify-between">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">FAQ System</label>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Enable FAQ functionality</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="hidden" name="faq_enabled" value="0">
                                <input type="checkbox" name="faq_enabled" value="1" 
                                       {{ old('faq_enabled', $settings->faq_enabled) ? 'checked' : '' }}
                                       class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                            </label>
                        </div>

                        <div class="flex items-center justify-between">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Help Center</label>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Enable help center functionality</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="hidden" name="help_center_enabled" value="0">
                                <input type="checkbox" name="help_center_enabled" value="1" 
                                       {{ old('help_center_enabled', $settings->help_center_enabled) ? 'checked' : '' }}
                                       class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                            </label>
                        </div>
                    </div>
                </div>


                
                <div class="border-t pt-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Profile Section Controls</h3>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Profile Information</label>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Allow users to edit profile information</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="hidden" name="profile_information_required" value="0">
                                <input type="checkbox" name="profile_information_required" value="1" 
                                       {{ old('profile_information_required', $settings->profile_information_required) ? 'checked' : '' }}
                                       class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                            </label>
                        </div>

                        <div class="flex items-center justify-between">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Password Change</label>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Allow users to change their password</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="hidden" name="password_change_required" value="0">
                                <input type="checkbox" name="password_change_required" value="1" 
                                       {{ old('password_change_required', $settings->password_change_required) ? 'checked' : '' }}
                                       class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                            </label>
                        </div>

                        <div class="flex items-center justify-between">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Browser Sessions</label>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Allow users to view browser sessions</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="hidden" name="browser_sessions_required" value="0">
                                <input type="checkbox" name="browser_sessions_required" value="1" 
                                       {{ old('browser_sessions_required', $settings->browser_sessions_required) ? 'checked' : '' }}
                                       class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                            </label>
                        </div>

                        <div class="flex items-center justify-between">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Two Factor Authentication</label>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Allow users to setup 2FA</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="hidden" name="two_factor_auth_required" value="0">
                                <input type="checkbox" name="two_factor_auth_required" value="1" 
                                       {{ old('two_factor_auth_required', $settings->two_factor_auth_required) ? 'checked' : '' }}
                                       class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                            </label>
                        </div>

                        <div class="flex items-center justify-between">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Account Deletion</label>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Allow users to delete their account</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="hidden" name="account_deletion_required" value="0">
                                <input type="checkbox" name="account_deletion_required" value="1" 
                                       {{ old('account_deletion_required', $settings->account_deletion_required) ? 'checked' : '' }}
                                       class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end">
                    <button type="submit" 
                            class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                        <i class="fas fa-save mr-2"></i>
                        Update Settings
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Reset toggles to database values on page load
    const toggles = {
        email_verification_required: {{ ($settings->email_verification_required ?? false) ? 'true' : 'false' }},
        sms_enabled: {{ ($settings->sms_enabled ?? false) ? 'true' : 'false' }},
        hide_admin_registration: {{ ($settings->hide_admin_registration ?? false) ? 'true' : 'false' }},
        terms_privacy_required: {{ ($settings->terms_privacy_required ?? true) ? 'true' : 'false' }},
        kyc_enabled: {{ ($settings->kyc_enabled ?? true) ? 'true' : 'false' }},
        profile_information_required: {{ ($settings->profile_information_required ?? false) ? 'true' : 'false' }},
        password_change_required: {{ ($settings->password_change_required ?? false) ? 'true' : 'false' }},
        browser_sessions_required: {{ ($settings->browser_sessions_required ?? false) ? 'true' : 'false' }},
        two_factor_auth_required: {{ ($settings->two_factor_auth_required ?? false) ? 'true' : 'false' }},
        account_deletion_required: {{ ($settings->account_deletion_required ?? false) ? 'true' : 'false' }},
        whatsapp_enabled: {{ ($settings->whatsapp_enabled ?? false) ? 'true' : 'false' }},
        live_chat_support_enabled: {{ ($settings->live_chat_support_enabled ?? false) ? 'true' : 'false' }},
        request_callback_enabled: {{ ($settings->request_callback_enabled ?? false) ? 'true' : 'false' }},
        faq_enabled: {{ ($settings->faq_enabled ?? false) ? 'true' : 'false' }},
        help_center_enabled: {{ ($settings->help_center_enabled ?? false) ? 'true' : 'false' }}
    };
    
    Object.entries(toggles).forEach(([name, value]) => {
        const checkbox = document.querySelector(`input[name="${name}"][type="checkbox"]`);
        if (checkbox) {
            checkbox.checked = value;
        }
    });
});
</script>

</x-admin-layout>