<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="{{ auth()->user()?->prefersDarkTheme() ? 'dark' : '' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }} - Reset Password</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .spinner {
            animation: spin 1s linear infinite;
        }
        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
    </style>
</head>
<body class="font-sans text-gray-900 antialiased">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-900">
        <div>
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </div>

        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
            <div class="mb-4 text-sm text-gray-600 dark:text-gray-400 text-center">
                {{ __('Forgot your password? Enter your email address and we\'ll send you a verification code to reset it.') }}
            </div>

            <!-- Step 1: Email Input -->
            <div id="emailStep">
                <form id="emailForm">
                    @csrf
                    <div>
                        <x-label for="email" value="{{ __('Email') }}" />
                        <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                        <div id="emailError" class="text-red-600 text-sm mt-2 hidden"></div>
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <button type="submit" id="sendCodeBtn" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                            <i id="sendLoadingIcon" class="fas fa-spinner fa-spin hidden mr-2"></i>
                            <span id="sendBtnText">{{ __('Send Reset Code') }}</span>
                        </button>
                    </div>
                </form>
            </div>

            <!-- Step 2: Code Verification & Password Reset -->
            <div id="resetStep" class="hidden">
                <div class="mb-4 text-sm text-green-600 dark:text-green-400 text-center">
                    <i class="fas fa-check-circle mr-1"></i>
                    Reset code sent to your email address!
                </div>

                <form id="resetForm">
                    @csrf
                    <div class="mb-4">
                        <x-label for="reset_code" value="{{ __('Verification Code') }}" />
                        <x-input id="reset_code" class="block mt-1 w-full text-center font-mono" type="text" name="reset_code" placeholder="Enter 6-digit code" maxlength="6" required />
                        <div id="codeError" class="text-red-600 text-sm mt-2 hidden"></div>
                    </div>

                    <div class="mb-4">
                        <x-label for="new_password" value="{{ __('New Password') }}" />
                        <x-input id="new_password" class="block mt-1 w-full" type="password" name="new_password" required autocomplete="new-password" />
                    </div>

                    <div class="mb-4">
                        <x-label for="new_password_confirmation" value="{{ __('Confirm Password') }}" />
                        <x-input id="new_password_confirmation" class="block mt-1 w-full" type="password" name="new_password_confirmation" required autocomplete="new-password" />
                        <div id="passwordError" class="text-red-600 text-sm mt-2 hidden"></div>
                    </div>

                    <div class="flex items-center justify-between mt-4">
                        <button type="button" id="backBtn" class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 underline">
                            {{ __('← Back to Email') }}
                        </button>
                        
                        <button type="submit" id="resetPasswordBtn" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                            <i id="resetLoadingIcon" class="fas fa-spinner fa-spin hidden mr-2"></i>
                            <span id="resetBtnText">{{ __('Reset Password') }}</span>
                        </button>
                    </div>
                </form>
            </div>

            <div class="flex items-center justify-center mt-4">
                <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                    {{ __('Back to Login') }}
                </a>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const emailStep = document.getElementById('emailStep');
            const resetStep = document.getElementById('resetStep');
            const emailForm = document.getElementById('emailForm');
            const resetForm = document.getElementById('resetForm');
            const backBtn = document.getElementById('backBtn');

            // Send reset code
            emailForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const email = document.getElementById('email').value;
                if (!email) {
                    showError('emailError', 'Please enter your email address');
                    return;
                }

                // Show loading
                document.getElementById('sendLoadingIcon').classList.remove('hidden');
                document.getElementById('sendBtnText').textContent = 'Sending...';
                document.getElementById('sendCodeBtn').disabled = true;

                fetch('{{ route("password.send-reset-code") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ email: email })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        emailStep.classList.add('hidden');
                        resetStep.classList.remove('hidden');
                    } else {
                        showError('emailError', data.message || 'Error sending reset code');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showError('emailError', 'Error sending reset code');
                })
                .finally(() => {
                    // Hide loading
                    document.getElementById('sendLoadingIcon').classList.add('hidden');
                    document.getElementById('sendBtnText').textContent = 'Send Reset Code';
                    document.getElementById('sendCodeBtn').disabled = false;
                });
            });

            // Reset password
            resetForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const code = document.getElementById('reset_code').value;
                const password = document.getElementById('new_password').value;
                const passwordConfirmation = document.getElementById('new_password_confirmation').value;

                if (!code || code.length !== 6) {
                    showError('codeError', 'Please enter a valid 6-digit code');
                    return;
                }

                if (password !== passwordConfirmation) {
                    showError('passwordError', 'Passwords do not match');
                    return;
                }

                // Show loading
                document.getElementById('resetLoadingIcon').classList.remove('hidden');
                document.getElementById('resetBtnText').textContent = 'Resetting...';
                document.getElementById('resetPasswordBtn').disabled = true;

                fetch('{{ route("password.reset-with-code") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        email: document.getElementById('email').value,
                        code: code,
                        password: password,
                        password_confirmation: passwordConfirmation
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Password reset successfully! You can now login with your new password.');
                        window.location.href = '{{ route("login") }}';
                    } else {
                        showError('codeError', data.message || 'Error resetting password');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showError('codeError', 'Error resetting password');
                })
                .finally(() => {
                    // Hide loading
                    document.getElementById('resetLoadingIcon').classList.add('hidden');
                    document.getElementById('resetBtnText').textContent = 'Reset Password';
                    document.getElementById('resetPasswordBtn').disabled = false;
                });
            });

            // Back button
            backBtn.addEventListener('click', function() {
                resetStep.classList.add('hidden');
                emailStep.classList.remove('hidden');
                clearErrors();
            });

            function showError(elementId, message) {
                const errorDiv = document.getElementById(elementId);
                errorDiv.textContent = message;
                errorDiv.classList.remove('hidden');
            }

            function clearErrors() {
                document.querySelectorAll('[id$="Error"]').forEach(el => {
                    el.classList.add('hidden');
                });
            }
        });
    </script>
</body>
</html>