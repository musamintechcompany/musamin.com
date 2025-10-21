<x-app-layout>
    <div class="py-12 bg-gray-100 dark:bg-gray-900">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Header Section -->
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center">
                    <button onclick="window.history.back()" class="mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-500 dark:text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </button>
                    <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200">Security & Phone</h2>
                </div>
            </div>

            <!-- Phone Verification Section -->
            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg mb-6">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Phone Verification</h3>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Phone Number</label>
                            <div class="flex items-center space-x-3">
                                <input type="tel" id="phoneNumber" value="{{ auth()->user()->phone ?? 'Not set' }}" 
                                       class="flex-1 px-3 py-2 border border-gray-300 rounded-md bg-gray-100 dark:bg-gray-700 dark:border-gray-500 dark:text-white" readonly>
                                
                                @if(auth()->user()->hasVerifiedPhone())
                                    <span class="px-3 py-2 bg-green-100 text-green-800 text-sm rounded-md">
                                        <i class="fas fa-check-circle mr-1"></i>
                                        Verified
                                    </span>
                                @else
                                    <span class="px-3 py-2 bg-yellow-100 text-yellow-800 text-sm rounded-md">
                                        <i class="fas fa-exclamation-triangle mr-1"></i>
                                        Unverified
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Verification Code Section -->
                        <div id="verificationSection" class="hidden">
                            <div class="p-4 bg-blue-50 dark:bg-blue-900 border border-blue-200 dark:border-blue-700 rounded-md">
                                <p class="text-sm text-blue-800 dark:text-blue-200 mb-3">
                                    📱 Verification code sent to your phone number
                                </p>
                                <div class="flex space-x-3">
                                    <input type="text" id="verificationCode" placeholder="Enter 6-digit code" 
                                           class="flex-1 px-3 py-2 text-center font-mono border border-blue-300 dark:border-blue-600 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-blue-800 dark:text-white" 
                                           maxlength="6">
                                    <button id="confirmCodeBtn" class="px-4 py-2 bg-green-600 text-white text-sm rounded hover:bg-green-700 transition-colors">
                                        <i id="confirmCodeIcon" class="fas fa-check mr-1"></i>
                                        <span id="confirmCodeText">Confirm</span>
                                    </button>
                                </div>
                                <div id="codeError" class="text-red-600 dark:text-red-400 text-sm mt-2 hidden"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Two-Factor Authentication Section -->
            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg mb-6">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Two-Factor Authentication</h3>
                    
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Add an extra layer of security to your account</p>
                            @if(auth()->user()->two_factor_confirmed_at)
                                <span class="inline-flex items-center px-2 py-1 text-xs bg-green-100 text-green-800 rounded-full mt-2">
                                    <i class="fas fa-shield-alt mr-1"></i>
                                    Enabled
                                </span>
                            @else
                                <span class="inline-flex items-center px-2 py-1 text-xs bg-gray-100 text-gray-800 rounded-full mt-2">
                                    <i class="fas fa-shield-alt mr-1"></i>
                                    Not Enabled
                                </span>
                            @endif
                        </div>
                        @if(auth()->user()->two_factor_confirmed_at)
                            <span class="px-3 py-2 bg-green-100 text-green-800 text-sm rounded-md">
                                <i class="fas fa-check-circle text-green-600"></i>
                            </span>
                        @else
                            <button onclick="window.location.href='{{ route('profile.show') }}#two-factor'" class="px-4 py-2 bg-indigo-600 text-white text-sm rounded-md hover:bg-indigo-700 transition-colors">
                                Enable
                            </button>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Password Section -->
            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Password</h3>
                    
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Ensure your account is using a long, random password</p>
                        </div>
                        <button onclick="window.location.href='{{ route('profile.show') }}#password'" class="px-4 py-2 bg-indigo-600 text-white text-sm rounded-md hover:bg-indigo-700 transition-colors">
                            Change Password
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const verifyPhoneBtn = document.getElementById('verifyPhoneBtn');
            const verificationSection = document.getElementById('verificationSection');
            const confirmCodeBtn = document.getElementById('confirmCodeBtn');
            const phoneInput = document.getElementById('phoneNumber');
            const codeInput = document.getElementById('verificationCode');
            const codeError = document.getElementById('codeError');

            if (verifyPhoneBtn) {
                verifyPhoneBtn.addEventListener('click', function() {
                    const phone = phoneInput.value.trim();
                    if (!phone) {
                        alert('Please enter a phone number');
                        return;
                    }

                    // Show loading
                    document.getElementById('verifyPhoneIcon').className = 'fas fa-spinner fa-spin mr-1';
                    document.getElementById('verifyPhoneText').textContent = 'Sending...';
                    verifyPhoneBtn.disabled = true;

                    // Send verification code
                    fetch('{{ route("user.update-phone") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ phone: phone })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            verificationSection.classList.remove('hidden');
                            codeError.classList.add('hidden');
                        } else {
                            alert(data.message || 'Failed to send verification code');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Something went wrong. Please try again.');
                    })
                    .finally(() => {
                        // Reset button
                        document.getElementById('verifyPhoneIcon').className = 'fas fa-mobile-alt mr-1';
                        document.getElementById('verifyPhoneText').textContent = 'Verify';
                        verifyPhoneBtn.disabled = false;
                    });
                });
            }

            if (confirmCodeBtn) {
                confirmCodeBtn.addEventListener('click', function() {
                    const code = codeInput.value.trim();
                    if (!code || code.length !== 6) {
                        codeError.textContent = 'Please enter a valid 6-digit code';
                        codeError.classList.remove('hidden');
                        return;
                    }

                    // Show loading
                    document.getElementById('confirmCodeIcon').className = 'fas fa-spinner fa-spin mr-1';
                    document.getElementById('confirmCodeText').textContent = 'Verifying...';
                    confirmCodeBtn.disabled = true;

                    // Verify code
                    fetch('{{ route("user.verify-phone") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ code: code })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Phone verified successfully!');
                            location.reload();
                        } else {
                            codeError.textContent = data.message || 'Invalid verification code';
                            codeError.classList.remove('hidden');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        codeError.textContent = 'Something went wrong. Please try again.';
                        codeError.classList.remove('hidden');
                    })
                    .finally(() => {
                        // Reset button
                        document.getElementById('confirmCodeIcon').className = 'fas fa-check mr-1';
                        document.getElementById('confirmCodeText').textContent = 'Confirm';
                        confirmCodeBtn.disabled = false;
                    });
                });
            }
        });
    </script>
</x-app-layout>