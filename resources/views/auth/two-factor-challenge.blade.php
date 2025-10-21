<x-guest-layout>
    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="w-full max-w-sm space-y-4" x-data="{ recovery: false }">
            <!-- Authentication Card Logo -->
            <div class="flex justify-center">
                <x-authentication-card-logo />
            </div>

            <form method="POST" action="{{ route('two-factor.login') }}" class="space-y-4">
                @csrf

                <!-- Title -->
                <h2 class="text-2xl font-bold text-center text-gray-800 dark:text-white">
                    Two-Factor Authentication<br>
                    <span class="text-sm font-normal text-gray-600 dark:text-gray-400" x-show="! recovery">
                        Enter the code from your authenticator app
                    </span>
                    <span class="text-sm font-normal text-gray-600 dark:text-gray-400" x-cloak x-show="recovery">
                        Enter one of your recovery codes
                    </span>
                </h2>

                <!-- Authentication Code -->
                <div x-show="! recovery">
                    <label for="code" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Authentication Code</label>
                    <input type="text" name="code" id="code" inputmode="numeric" x-ref="code" autofocus autocomplete="one-time-code"
                           class="w-full px-3 py-2 mt-1 text-center font-mono border rounded-md focus:outline-none focus:ring-2 focus:ring-primary-600 dark:bg-gray-800 dark:border-gray-700 dark:text-white" 
                           placeholder="000000" maxlength="6" />
                    @error('code') <span class="text-sm text-red-500 dark:text-red-400">{{ $message }}</span> @enderror
                </div>

                <!-- Recovery Code -->
                <div x-cloak x-show="recovery">
                    <label for="recovery_code" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Recovery Code</label>
                    <input type="text" name="recovery_code" id="recovery_code" x-ref="recovery_code" autocomplete="one-time-code"
                           class="w-full px-3 py-2 mt-1 text-center font-mono border rounded-md focus:outline-none focus:ring-2 focus:ring-primary-600 dark:bg-gray-800 dark:border-gray-700 dark:text-white" 
                           placeholder="Enter recovery code" />
                    @error('recovery_code') <span class="text-sm text-red-500 dark:text-red-400">{{ $message }}</span> @enderror
                </div>

                <!-- Toggle Recovery -->
                <div class="text-center">
                    <button type="button" class="text-sm text-primary-600 hover:underline dark:text-primary-400"
                            x-show="! recovery"
                            x-on:click="recovery = true; $nextTick(() => { $refs.recovery_code.focus() })">
                        {{ __('Use a recovery code instead') }}
                    </button>

                    <button type="button" class="text-sm text-primary-600 hover:underline dark:text-primary-400"
                            x-cloak x-show="recovery"
                            x-on:click="recovery = false; $nextTick(() => { $refs.code.focus() })">
                        {{ __('Use authentication code instead') }}
                    </button>
                </div>

                <!-- Submit Button -->
                <button type="submit" id="verifyBtn"
                        class="flex items-center justify-center w-full px-4 py-2 text-white transition rounded-md bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-600 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                    <svg id="verifySpinner" class="hidden w-5 h-5 mr-2 text-white spinner" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                    </svg>
                    <span id="verifyBtnText">{{ __('Verify & Login') }}</span>
                </button>

                <!-- Back to Login -->
                <div class="text-center">
                    <a href="{{ route('login') }}" class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 underline">
                        {{ __('← Back to Login') }}
                    </a>
                </div>
            </form>
        </div>
    </div>

    <style>
        .spinner {
            animation: spin 1s linear infinite;
        }
        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            const verifyBtn = document.getElementById('verifyBtn');
            const spinner = document.getElementById('verifySpinner');
            const btnText = document.getElementById('verifyBtnText');

            if (form && verifyBtn) {
                form.addEventListener('submit', function() {
                    spinner.classList.remove('hidden');
                    btnText.textContent = 'Verifying...';
                    verifyBtn.disabled = true;
                });
            }
        });
    </script>
</x-guest-layout>
