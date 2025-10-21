<div class="grid grid-cols-6 gap-6">
                <div class="col-span-6 sm:col-span-4">
                    <x-label for="current_password" value="{{ __('Current Password') }}" />
                    <x-input id="current_password" type="password" class="mt-1 block w-full" autocomplete="current-password" />
                </div>

                <div class="col-span-6 sm:col-span-4">
                    <x-label for="password" value="{{ __('New Password') }}" />
                    <x-input id="password" type="password" class="mt-1 block w-full" autocomplete="new-password" />
                </div>

                <div class="col-span-6 sm:col-span-4">
                    <x-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                    <x-input id="password_confirmation" type="password" class="mt-1 block w-full" autocomplete="new-password" />
                </div>

                <div class="col-span-6">
                    <div id="passwordMessage" class="text-sm hidden"></div>
                </div>

        <!-- Verification Code Modal -->
        <div id="passwordVerificationModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
            <div class="bg-white dark:bg-gray-800 rounded-lg p-6 max-w-md w-full mx-4">
                <div class="text-center">
                    <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 dark:bg-blue-900 mb-4">
                        <i class="fas fa-shield-alt text-blue-600 dark:text-blue-400 text-xl"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">Security Verification</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">A verification code has been sent to your email. Please enter it below to confirm the password change.</p>
                    
                    <div class="mb-4">
                        <input type="text" id="passwordVerificationCode" placeholder="Enter 6-digit code" 
                               class="w-full px-4 py-3 text-center text-lg font-mono border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white" 
                               maxlength="6">
                        <div id="passwordCodeError" class="text-red-500 text-sm mt-2 hidden"></div>
                    </div>
                    
                    <div class="flex gap-3 justify-center">
                        <button id="cancelPasswordChange" class="px-4 py-2 bg-gray-300 dark:bg-gray-600 text-gray-700 dark:text-gray-300 rounded hover:bg-gray-400 dark:hover:bg-gray-500 transition-colors">
                            Cancel
                        </button>
                        <button id="verifyPasswordCode" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition-colors">
                            <i id="verifyLoadingIcon" class="fas fa-spinner fa-spin hidden mr-2"></i>
                            <span id="verifyBtnText">Verify & Change Password</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>


    <div class="col-span-6 flex justify-end">
        <button type="button" id="changePasswordBtn" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
            <i id="passwordLoadingIcon" class="fas fa-spinner fa-spin hidden mr-2"></i>
            <span id="passwordBtnText">{{ __('Change Password') }}</span>
        </button>
    </div>
</div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const changePasswordBtn = document.getElementById('changePasswordBtn');
            const modal = document.getElementById('passwordVerificationModal');
            const cancelBtn = document.getElementById('cancelPasswordChange');
            const verifyBtn = document.getElementById('verifyPasswordCode');
            const codeInput = document.getElementById('passwordVerificationCode');
            const errorDiv = document.getElementById('passwordCodeError');

            // Password message function
            function showPasswordMessage(message, type) {
                const messageDiv = document.getElementById('passwordMessage');
                messageDiv.textContent = message;
                messageDiv.className = `text-sm ${type === 'success' ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400'}`;
                messageDiv.classList.remove('hidden');
                
                // Auto hide after 3 seconds
                setTimeout(() => {
                    messageDiv.classList.add('hidden');
                }, 3000);
            }

            changePasswordBtn.addEventListener('click', function() {
                const currentPassword = document.getElementById('current_password').value;
                const newPassword = document.getElementById('password').value;
                const confirmPassword = document.getElementById('password_confirmation').value;

                if (!currentPassword || !newPassword || !confirmPassword) {
                    showPasswordMessage('Please fill in all password fields', 'error');
                    return;
                }

                if (newPassword !== confirmPassword) {
                    showPasswordMessage('New passwords do not match', 'error');
                    return;
                }

                // Show loading
                document.getElementById('passwordLoadingIcon').classList.remove('hidden');
                document.getElementById('passwordBtnText').textContent = 'Processing...';
                changePasswordBtn.disabled = true;

                // Send code or change password
                fetch('{{ route("password.send-code") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        current_password: currentPassword,
                        password: newPassword,
                        password_confirmation: confirmPassword
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        if (data.verification_required) {
                            // Show verification modal
                            modal.classList.remove('hidden');
                            modal.classList.add('flex');
                        } else {
                            // Password changed directly
                            showPasswordMessage('Password changed successfully!', 'success');
                            // Clear form
                            document.getElementById('current_password').value = '';
                            document.getElementById('password').value = '';
                            document.getElementById('password_confirmation').value = '';
                        }
                    } else {
                        showPasswordMessage(data.message || 'Error changing password', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showPasswordMessage('Error changing password', 'error');
                })
                .finally(() => {
                    // Hide loading
                    document.getElementById('passwordLoadingIcon').classList.add('hidden');
                    document.getElementById('passwordBtnText').textContent = 'Change Password';
                    changePasswordBtn.disabled = false;
                });
            });

            cancelBtn.addEventListener('click', function() {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                codeInput.value = '';
                errorDiv.classList.add('hidden');
            });

            verifyBtn.addEventListener('click', function() {
                const code = codeInput.value;
                if (!code || code.length !== 6) {
                    errorDiv.textContent = 'Please enter a valid 6-digit code';
                    errorDiv.classList.remove('hidden');
                    return;
                }

                // Show loading
                document.getElementById('verifyLoadingIcon').classList.remove('hidden');
                document.getElementById('verifyBtnText').textContent = 'Verifying...';
                verifyBtn.disabled = true;

                fetch('{{ route("password.verify-change") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        verification_code: code
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        modal.classList.add('hidden');
                        modal.classList.remove('flex');
                        showPasswordMessage('Password changed successfully!', 'success');
                        // Clear form
                        document.getElementById('current_password').value = '';
                        document.getElementById('password').value = '';
                        document.getElementById('password_confirmation').value = '';
                        codeInput.value = '';
                    } else {
                        errorDiv.textContent = data.message;
                        errorDiv.classList.remove('hidden');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    errorDiv.textContent = 'Error verifying code';
                    errorDiv.classList.remove('hidden');
                })
                .finally(() => {
                    // Hide loading
                    document.getElementById('verifyLoadingIcon').classList.add('hidden');
                    document.getElementById('verifyBtnText').textContent = 'Verify & Change Password';
                    verifyBtn.disabled = false;
                });
            });
        });
    </script>

