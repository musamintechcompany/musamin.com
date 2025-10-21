<div>
    @php
        $user = Auth::user();
        $enabled = $user->two_factor_confirmed_at !== null;
        $showingConfirmation = session('2fa_showing_confirmation', false) || ($user->two_factor_secret && !$enabled);
        $showingQrCode = session('2fa_showing_qr', false) || ($user->two_factor_secret && !$enabled);
        $showingRecoveryCodes = session('2fa_showing_recovery', false);
    @endphp
    
    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">
        @if ($enabled)
            @if ($showingConfirmation)
                {{ __('Finish enabling two factor authentication.') }}
            @else
                {{ __('You have enabled two factor authentication.') }}
            @endif
        @else
            {{ __('You have not enabled two factor authentication.') }}
        @endif
    </h3>

    <div class="mt-3 max-w-xl text-sm text-gray-600 dark:text-gray-400">
        <p>
            {{ __('When two factor authentication is enabled, you will be prompted for a secure, random token during authentication. You may retrieve this token from your phone\'s Google Authenticator application.') }}
        </p>
    </div>

    @if ($enabled)
        @if ($showingQrCode)
            <div class="mt-4 max-w-xl text-sm text-gray-600 dark:text-gray-400">
                <p class="font-semibold">
                    @if ($showingConfirmation)
                        {{ __('To finish enabling two factor authentication, scan the following QR code using your phone\'s authenticator application or enter the setup key and provide the generated OTP code.') }}
                    @else
                        {{ __('Two factor authentication is now enabled. Scan the following QR code using your phone\'s authenticator application or enter the setup key.') }}
                    @endif
                </p>
            </div>

            @if ($user->two_factor_secret)
                @php
                    $google2fa = new \PragmaRX\Google2FAQRCode\Google2FA();
                    $secretKey = decrypt($user->two_factor_secret);
                    $qrCodeUrl = $google2fa->getQRCodeUrl(
                        config('app.name'),
                        $user->email,
                        $secretKey
                    );
                @endphp
                
                <div class="mt-4 p-2 inline-block bg-white">
                    <img src="{{ $qrCodeUrl }}" alt="QR Code" class="mx-auto" />
                </div>

                <div class="mt-4 max-w-xl text-sm text-gray-600 dark:text-gray-400">
                    <p class="font-semibold">
                        {{ __('Setup Key') }}: {{ $secretKey }}
                    </p>
                </div>

                @if ($showingConfirmation)
                    <div class="mt-4">
                        <x-label for="code" value="{{ __('Code') }}" />
                        <x-input id="code" type="text" name="code" class="block mt-1 w-1/2" inputmode="numeric" autofocus autocomplete="one-time-code" />
                        <x-input-error for="code" class="mt-2" />
                        
                        <div class="mt-4">
                            <x-button type="button" id="confirmSetupBtn">
                                {{ __('Confirm Setup') }}
                            </x-button>
                        </div>
                    </div>
                @endif
            @endif
        @endif

        @if ($showingRecoveryCodes && $user->two_factor_recovery_codes)
            <div class="mt-4 max-w-xl text-sm text-gray-600 dark:text-gray-400">
                <p class="font-semibold">
                    {{ __('Store these recovery codes in a secure password manager. They can be used to recover access to your account if your two factor authentication device is lost.') }}
                </p>
            </div>

            <div class="grid gap-1 max-w-xl mt-4 px-4 py-4 font-mono text-sm bg-gray-100 dark:bg-gray-900 dark:text-gray-100 rounded-lg">
                @foreach (json_decode(decrypt($user->two_factor_recovery_codes), true) as $code)
                    <div>{{ $code }}</div>
                @endforeach
            </div>
        @endif
    @endif

    <div class="mt-5">
        @if (!$enabled)
            <x-button type="button" id="enableTwoFactorBtn">
                {{ __('Enable') }}
            </x-button>
        @else
            <x-secondary-button class="me-3" id="showRecoveryCodesBtn">
                {{ __('Show Recovery Codes') }}
            </x-secondary-button>
            
            <x-secondary-button class="me-3" id="regenerateCodesBtn">
                {{ __('Regenerate Recovery Codes') }}
            </x-secondary-button>
            
            <x-danger-button id="disableTwoFactorBtn">
                {{ __('Disable') }}
            </x-danger-button>
        @endif
    </div>

    <!-- Confirmation Modal -->
    <div id="confirmModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white dark:bg-gray-800 rounded-lg p-6 max-w-md w-full mx-4">
            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4" id="modalTitle">Confirm Action</h3>
            <p class="text-sm text-gray-600 dark:text-gray-400 mb-4" id="modalMessage">Please enter your password to confirm.</p>
            
            <div id="passwordSection" class="mb-4">
                <x-input type="password" id="confirmPassword" placeholder="Password" class="w-full" />
            </div>
            
            <div id="codeSection" class="mb-4 hidden">
                <x-input type="text" id="confirmCode" placeholder="Enter 6-digit code" class="w-full" maxlength="6" />
            </div>
            
            <div class="flex justify-end space-x-3">
                <x-secondary-button id="cancelBtn">Cancel</x-secondary-button>
                <x-button id="confirmBtn">Confirm</x-button>
            </div>
        </div>
    </div>

    <!-- Recovery Codes Modal -->
    <div id="recoveryModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white dark:bg-gray-800 rounded-lg p-6 max-w-md w-full mx-4">
            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Recovery Codes</h3>
            <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">Store these codes safely. They can be used to recover access if you lose your authenticator device.</p>
            
            <div id="recoveryCodesList" class="bg-gray-100 dark:bg-gray-700 p-4 rounded font-mono text-sm mb-4"></div>
            
            <div class="flex justify-end">
                <x-button id="closeRecoveryBtn">Close</x-button>
            </div>
        </div>
    </div>
</div>

<script>
// Function to show QR setup
function showQRSetup(secretKey, qrUrl) {
    const container = document.querySelector('.mt-5').parentElement;
    container.innerHTML = `
        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            Finish enabling two factor authentication.
        </h3>
        <div class="mt-3 max-w-xl text-sm text-gray-600 dark:text-gray-400">
            <p>Scan the QR code using your phone's authenticator application or enter the setup key and provide the generated OTP code.</p>
        </div>
        <div class="mt-4 p-2 inline-block bg-white">
            ${qrUrl}
        </div>
        <div class="mt-4 max-w-xl text-sm text-gray-600 dark:text-gray-400">
            <p class="font-semibold">Setup Key: ${secretKey}</p>
        </div>
        <div class="mt-4">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Code</label>
            <input id="setupCode" type="text" class="mt-1 block w-1/2 rounded-md border-gray-300 shadow-sm" maxlength="6" placeholder="Enter 6-digit code" />
        </div>
        <div class="mt-5">
            <button id="confirmSetupBtn" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                Confirm Setup
            </button>
        </div>
    `;
    
    // Bind confirm button
    document.getElementById('confirmSetupBtn').addEventListener('click', function() {
        const code = document.getElementById('setupCode').value;
        if (!code || code.length !== 6) {
            alert('Please enter a 6-digit code');
            return;
        }
        
        fetch('{{ route("two-factor.confirm") }}', {
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
                alert('Two-factor authentication enabled successfully!');
                showRecoveryCodes(data.recovery_codes);
                setTimeout(() => location.reload(), 2000);
            } else {
                alert(data.message);
            }
        });
    });
}

// Bind enable button immediately
function bindEnableButton() {
    const enableBtn = document.getElementById('enableTwoFactorBtn');
    if (enableBtn && !enableBtn.hasAttribute('data-bound')) {
        enableBtn.setAttribute('data-bound', 'true');
        enableBtn.addEventListener('click', function(e) {
            e.preventDefault();
            console.log('Enable button clicked');
            
            enableBtn.disabled = true;
            enableBtn.textContent = 'Enabling...';
            
            fetch('{{ route("two-factor.enable") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => {
                console.log('Response status:', response.status);
                if (!response.ok) {
                    throw new Error('HTTP ' + response.status);
                }
                return response.json();
            })
            .then(data => {
                console.log('Response data:', data);
                if (data.success) {
                    showQRSetup(data.secret_key, data.qr_code_url);
                } else {
                    alert(data.message || 'Error enabling 2FA');
                    enableBtn.disabled = false;
                    enableBtn.textContent = 'Enable';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error enabling 2FA: ' + error.message);
                enableBtn.disabled = false;
                enableBtn.textContent = 'Enable';
            });
        });
    }
}

// Try binding immediately and on DOM ready
bindEnableButton();

document.addEventListener('DOMContentLoaded', function() {
    bindEnableButton();
    
    const showCodesBtn = document.getElementById('showRecoveryCodesBtn');
    const regenerateBtn = document.getElementById('regenerateCodesBtn');
    const disableBtn = document.getElementById('disableTwoFactorBtn');
    const confirmModal = document.getElementById('confirmModal');
    const recoveryModal = document.getElementById('recoveryModal');
    const cancelBtn = document.getElementById('cancelBtn');
    const confirmBtn = document.getElementById('confirmBtn');
    const closeRecoveryBtn = document.getElementById('closeRecoveryBtn');
    
    let currentAction = null;
    
    // Show recovery codes
    if (showCodesBtn) {
        showCodesBtn.addEventListener('click', function() {
            fetch('{{ route("two-factor.recovery-codes") }}')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showRecoveryCodes(data.recovery_codes);
                } else {
                    alert(data.message);
                }
            });
        });
    }
    
    // Regenerate codes
    if (regenerateBtn) {
        regenerateBtn.addEventListener('click', function() {
            if (confirm('Are you sure you want to regenerate recovery codes? Old codes will no longer work.')) {
                fetch('{{ route("two-factor.recovery-codes.regenerate") }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showRecoveryCodes(data.recovery_codes);
                    } else {
                        alert(data.message);
                    }
                });
            }
        });
    }
    
    // Disable 2FA
    if (disableBtn) {
        disableBtn.addEventListener('click', function() {
            showConfirmModal('Disable Two-Factor Authentication', 'Enter your password to disable 2FA', 'disable');
        });
    }
    
    // Modal functions
    function showConfirmModal(title, message, action) {
        document.getElementById('modalTitle').textContent = title;
        document.getElementById('modalMessage').textContent = message;
        currentAction = action;
        confirmModal.classList.remove('hidden');
        confirmModal.classList.add('flex');
    }
    
    function hideConfirmModal() {
        confirmModal.classList.add('hidden');
        confirmModal.classList.remove('flex');
        document.getElementById('confirmPassword').value = '';
        document.getElementById('confirmCode').value = '';
    }
    
    function showRecoveryCodes(codes) {
        const codesList = document.getElementById('recoveryCodesList');
        codesList.innerHTML = codes.map(code => `<div>${code}</div>`).join('');
        recoveryModal.classList.remove('hidden');
        recoveryModal.classList.add('flex');
    }
    

    
    // Event listeners
    cancelBtn.addEventListener('click', hideConfirmModal);
    closeRecoveryBtn.addEventListener('click', function() {
        recoveryModal.classList.add('hidden');
        recoveryModal.classList.remove('flex');
    });
    
    confirmBtn.addEventListener('click', function() {
        const password = document.getElementById('confirmPassword').value;
        
        if (currentAction === 'disable') {
            fetch('{{ route("two-factor.disable") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ password: password })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    location.reload();
                } else {
                    alert(data.message);
                }
                hideConfirmModal();
            });
        }
    });
    
    // Setup confirmation
    const confirmSetupBtn = document.getElementById('confirmSetupBtn');
    if (confirmSetupBtn) {
        confirmSetupBtn.addEventListener('click', function() {
            const code = document.getElementById('code').value;
            
            if (!code || code.length !== 6) {
                alert('Please enter a 6-digit code');
                return;
            }
            
            fetch('{{ route("two-factor.confirm") }}', {
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
                    alert('Two-factor authentication enabled successfully!');
                    showRecoveryCodes(data.recovery_codes);
                    setTimeout(() => location.reload(), 2000);
                } else {
                    alert(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error confirming setup');
            });
        });
    }

});
</script>
