<x-guest-layout>
    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="w-full max-w-sm space-y-4">
            <!-- Authentication Card Logo -->
            <div class="flex justify-center">
                <x-authentication-card-logo />
            </div>

            <!-- Title -->
            <h2 class="text-2xl font-bold text-center text-gray-800 dark:text-white">
                Email Verification<br>
                <span class="text-sm font-normal text-gray-600 dark:text-gray-400">Enter the 6-digit code sent to your email</span>
            </h2>

            @if (session('status') == 'verification-link-sent')
                <div id="successAlert" class="p-3 text-sm text-green-600 bg-green-100 rounded dark:text-green-400 dark:bg-green-900">
                    A new verification code has been sent to your email address.
                </div>
            @endif

            <!-- Error Toast -->
            <div id="errorToast" class="fixed z-50 hidden w-11/12 max-w-md py-2 text-sm text-center text-white transform -translate-x-1/2 bg-red-500 rounded shadow-lg top-4 left-1/2 dark:bg-red-700"></div>

            <!-- Verification Code Form -->
            <form method="POST" action="{{ route('verification.verify-code') }}" id="verificationForm" class="space-y-4">
                @csrf

                <!-- Main Input Field (switches between email and code) -->
                <div>
                    <label for="mainInput" id="inputLabel" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Verification Code</label>
                    <input type="text" name="code" id="mainInput" maxlength="6" required autofocus
                           class="w-full px-3 py-2 mt-1 text-center text-2xl tracking-widest border rounded-md focus:outline-none focus:ring-2 focus:ring-primary-600 dark:bg-gray-800 dark:border-gray-700 dark:text-white"
                           placeholder="000000" value="{{ old('code') }}" />
                    @error('code') <span class="text-sm text-red-500 dark:text-red-400">{{ $message }}</span> @enderror
                    <div id="inputError" class="text-sm text-red-500 dark:text-red-400 mt-1 hidden"></div>
                </div>

                <!-- Submit Button -->
                <button type="submit" id="mainBtn"
                        class="flex items-center justify-center w-full px-4 py-2 text-white transition rounded-md bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-600 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                    <svg id="spinner" class="hidden w-5 h-5 mr-2 text-white spinner" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                    </svg>
                    <span id="buttonText">Verify Email</span>
                </button>
            </form>

            <!-- Resend Code Section -->
            <div class="flex items-center justify-between">
                <form method="POST" action="{{ route('verification.send') }}" class="inline">
                    @csrf
                    <button type="submit" id="resendBtn" class="text-sm text-primary-600 hover:underline dark:text-primary-400 disabled:opacity-50 disabled:cursor-not-allowed">
                        Resend Verification Code
                    </button>
                </form>

                <span id="countdown" class="text-sm font-mono text-gray-500 dark:text-gray-400">01:30</span>
            </div>




        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const successAlert = document.getElementById('successAlert');
            const countdownEl = document.getElementById('countdown');
            const resendBtn = document.getElementById('resendBtn');
            let countdown = 90; // 1 minute 30 seconds
            let timer;

            // Auto-hide success alert after 2 seconds
            if (successAlert) {
                setTimeout(function() {
                    successAlert.style.display = 'none';
                }, 2000);
            }

            // Check localStorage for existing countdown
            function checkExistingCountdown() {
                const savedEndTime = localStorage.getItem('verificationCountdownEnd');
                if (savedEndTime) {
                    const endTime = parseInt(savedEndTime);
                    const now = Date.now();
                    const remaining = Math.floor((endTime - now) / 1000);
                    
                    if (remaining > 0) {
                        countdown = remaining;
                        resendBtn.disabled = true;
                        startCountdown(false);
                        return true;
                    } else {
                        localStorage.removeItem('verificationCountdownEnd');
                    }
                }
                return false;
            }

            // Start countdown timer
            function startCountdown(saveToStorage = true) {
                clearInterval(timer);
                
                if (saveToStorage) {
                    const endTime = Date.now() + (countdown * 1000);
                    localStorage.setItem('verificationCountdownEnd', endTime.toString());
                }
                
                updateCountdownDisplay();

                timer = setInterval(() => {
                    countdown--;
                    updateCountdownDisplay();

                    if (countdown <= 0) {
                        clearInterval(timer);
                        resendBtn.disabled = false;
                        countdownEl.textContent = 'Expired';
                        countdownEl.classList.add('text-red-500', 'dark:text-red-400');
                        countdownEl.classList.remove('text-gray-500', 'dark:text-gray-400');
                        localStorage.removeItem('verificationCountdownEnd');
                    }
                }, 1000);
            }

            // Always check for existing countdown first, if none exists start initial countdown
            if (!checkExistingCountdown()) {
                // Start initial countdown and save to localStorage
                countdown = 90;
                startCountdown(true);
            }

            // Update countdown display
            function updateCountdownDisplay() {
                const minutes = Math.floor(countdown / 60);
                const seconds = countdown % 60;
                countdownEl.textContent = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;

                // Change color to red when 1 minute or less
                if (countdown <= 60) {
                    countdownEl.classList.remove('text-gray-500', 'dark:text-gray-400');
                    countdownEl.classList.add('text-red-500', 'dark:text-red-400');
                } else {
                    countdownEl.classList.remove('text-red-500', 'dark:text-red-400');
                    countdownEl.classList.add('text-gray-500', 'dark:text-gray-400');
                }
            }

            // Form elements
            const mainInput = document.getElementById('mainInput');
            const inputError = document.getElementById('inputError');
            const spinner = document.getElementById('spinner');
            const buttonText = document.getElementById('buttonText');

            // Handle main form submission
            const verificationForm = document.getElementById('verificationForm');
            if (verificationForm) {
                verificationForm.addEventListener('submit', function(e) {
                    const code = mainInput.value.trim();
                    
                    if (!code) {
                        e.preventDefault();
                        showInputError('Please enter a verification code');
                        return;
                    }
                    
                    if (code.length !== 6) {
                        e.preventDefault();
                        showInputError('Please enter a 6-digit verification code');
                        return;
                    }
                    
                    // Show loading state but allow form to submit
                    showLoading('Verifying...');
                });
            }


            function showLoading(text) {
                spinner.classList.remove('hidden');
                buttonText.textContent = text;
                mainBtn.disabled = true;
            }

            function hideLoading() {
                spinner.classList.add('hidden');
                buttonText.textContent = 'Verify Email';
                mainBtn.disabled = false;
            }

            function showInputError(message) {
                inputError.textContent = message;
                inputError.classList.remove('hidden');
            }

            // Handle resend button click
            if (resendBtn) {
                resendBtn.addEventListener('click', function(e) {
                    e.preventDefault();

                    // Submit the form to send verification code
                    const resendForm = resendBtn.closest('form');
                    const formData = new FormData(resendForm);

                    fetch(resendForm.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        // Show success message
                        showSuccessMessage('A new verification code has been sent to your email address.');
                        // Restart countdown and disable button
                        countdown = 90;
                        resendBtn.disabled = true;
                        startCountdown(true);
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        // Still restart countdown and disable button even if there's an error
                        countdown = 90;
                        resendBtn.disabled = true;
                        startCountdown(true);
                    });
                });
            }



            // Function to show success message
            function showSuccessMessage(message) {
                // Create or update success alert
                let successAlert = document.getElementById('successAlert');
                if (!successAlert) {
                    successAlert = document.createElement('div');
                    successAlert.id = 'successAlert';
                    successAlert.className = 'p-4 text-sm text-green-700 bg-green-100 border border-green-200 rounded-md dark:text-green-400 dark:bg-green-900 dark:border-green-700 mb-4';
                    // Insert after the title
                    const title = document.querySelector('h2');
                    title.parentNode.insertBefore(successAlert, title.nextSibling);
                }

                successAlert.innerHTML = `<div class="flex items-start"><i class="fas fa-check-circle mr-2 mt-0.5"></i><span>${message}</span></div>`;
                successAlert.style.display = 'block';

                // Hide after 8 seconds
                setTimeout(function() {
                    successAlert.style.display = 'none';
                }, 8000);
            }


        });
    </script>
</x-guest-layout>
