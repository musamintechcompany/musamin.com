<div>
    <div class="grid grid-cols-6 gap-6">
        @csrf
        @method('PUT')
        
        <!-- Profile Photo -->
        @if (true)
            <div x-data="{photoName: null, photoPreview: null}" class="col-span-6 sm:col-span-4">
                <!-- Profile Photo File Input -->
                <input type="file" id="photo" class="hidden" name="photo"
                            x-ref="photo"
                            x-on:change="
                                    photoName = $refs.photo.files[0].name;
                                    const reader = new FileReader();
                                    reader.onload = (e) => {
                                        photoPreview = e.target.result;
                                    };
                                    reader.readAsDataURL($refs.photo.files[0]);
                            " />

                <x-label for="photo" value="{{ __('Photo') }}" />

                <!-- Current Profile Photo -->
                <div class="mt-2" x-show="! photoPreview">
                    <img src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" class="rounded-full size-20 object-cover">
                </div>

                <!-- New Profile Photo Preview -->
                <div class="mt-2" x-show="photoPreview" style="display: none;">
                    <span class="block rounded-full size-20 bg-cover bg-no-repeat bg-center"
                          x-bind:style="'background-image: url(\'' + photoPreview + '\');'">
                    </span>
                </div>

                <div class="mt-2 flex gap-2">
                    <x-secondary-button type="button" x-on:click.prevent="$refs.photo.click()">
                        {{ __('Select A New Photo') }}
                    </x-secondary-button>

                    @if (Auth::user()->profile_photo_path)
                        <x-secondary-button type="button" onclick="removePhoto()">
                            {{ __('Remove Photo') }}
                        </x-secondary-button>
                    @endif
                    
                    <!-- Save Photo Button -->
                    <x-button type="button" x-show="photoPreview" style="display: none;" onclick="savePhoto()">
                        {{ __('Save Photo') }}
                    </x-button>
                </div>

                <x-input-error for="photo" class="mt-2" />
            </div>
        @endif

        <!-- Name -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="name" value="{{ __('Name') }}" />
            <div class="relative">
                <x-input id="name" name="name" type="text" class="mt-1 block w-full pr-16" value="{{ Auth::user()->name }}" required autocomplete="name" readonly />
                @if(Auth::user()->kyc_status === 'approved')
                    <span class="absolute right-2 top-1/2 transform -translate-y-1/2 px-2 py-1 bg-gray-500 text-white text-xs rounded">
                        <i class="fas fa-lock mr-1"></i>
                        Sealed
                    </span>
                @else
                    <button type="button" id="editNameBtn" class="absolute right-2 top-1/2 transform -translate-y-1/2 px-2 py-1 bg-purple-600 text-white text-xs rounded hover:bg-purple-700 transition-colors">
                        <i id="nameLoadingIcon" class="fas fa-spinner fa-spin hidden mr-1"></i>
                        <span id="nameBtnText">Edit</span>
                    </button>
                @endif
            </div>
            <div id="nameMessage" class="mt-2 text-sm hidden"></div>
            <x-input-error for="name" class="mt-2" />
        </div>

        <!-- Username -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="username" value="{{ __('Username') }}" />
            <div class="relative">
                <x-input id="username" type="text" class="mt-1 block w-full pr-16" value="{{ Auth::user()->username }}" readonly />
                <button type="button" id="editUsernameBtn" class="absolute right-2 top-1/2 transform -translate-y-1/2 px-2 py-1 bg-purple-600 text-white text-xs rounded hover:bg-purple-700 transition-colors">
                    <i id="usernameLoadingIcon" class="fas fa-spinner fa-spin hidden mr-1"></i>
                    <span id="usernameBtnText">Edit</span>
                </button>
            </div>
            <div id="usernameMessage" class="mt-2 text-sm hidden"></div>
            <x-input-error for="username" class="mt-2" />
        </div>

        <!-- Date of Birth -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="date_of_birth" value="{{ __('Date of Birth') }}" />
            <div class="relative">
                <x-input id="date_of_birth" name="date_of_birth" type="date" class="mt-1 block w-full pr-16" value="{{ Auth::user()->date_of_birth ? \Carbon\Carbon::parse(Auth::user()->date_of_birth)->format('Y-m-d') : '' }}" readonly />
                @if(Auth::user()->kyc_status === 'approved')
                    <span class="absolute right-2 top-1/2 transform -translate-y-1/2 px-2 py-1 bg-gray-500 text-white text-xs rounded">
                        <i class="fas fa-lock mr-1"></i>
                        Sealed
                    </span>
                @else
                    <button type="button" id="editDateOfBirthBtn" class="absolute right-2 top-1/2 transform -translate-y-1/2 px-2 py-1 bg-purple-600 text-white text-xs rounded hover:bg-purple-700 transition-colors">
                        <i id="dateOfBirthLoadingIcon" class="fas fa-spinner fa-spin hidden mr-1"></i>
                        <span id="dateOfBirthBtnText">Edit</span>
                    </button>
                @endif
            </div>
            <div id="dateOfBirthMessage" class="mt-2 text-sm hidden"></div>
            <x-input-error for="date_of_birth" class="mt-2" />
        </div>



        <!-- Currency Preference -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="currency_id" value="{{ __('Preferred Currency') }}" />
            <div class="relative">
                <select id="currency_id" name="currency_id" class="mt-1 block w-full pr-16 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" disabled>
                    <option value="">Select Currency</option>
                    <option value="USD" {{ Auth::user()->currency_id === 'USD' ? 'selected' : '' }}>USD - US Dollar</option>
                    <option value="EUR" {{ Auth::user()->currency_id === 'EUR' ? 'selected' : '' }}>EUR - Euro</option>
                    <option value="GBP" {{ Auth::user()->currency_id === 'GBP' ? 'selected' : '' }}>GBP - British Pound</option>
                    <option value="NGN" {{ Auth::user()->currency_id === 'NGN' ? 'selected' : '' }}>NGN - Nigerian Naira</option>
                    <option value="CAD" {{ Auth::user()->currency_id === 'CAD' ? 'selected' : '' }}>CAD - Canadian Dollar</option>
                    <option value="AUD" {{ Auth::user()->currency_id === 'AUD' ? 'selected' : '' }}>AUD - Australian Dollar</option>
                </select>
                <button type="button" id="editCurrencyBtn" class="absolute right-2 top-1/2 transform -translate-y-1/2 px-2 py-1 bg-purple-600 text-white text-xs rounded hover:bg-purple-700 transition-colors">
                    <i id="currencyLoadingIcon" class="fas fa-spinner fa-spin hidden mr-1"></i>
                    <span id="currencyBtnText">Edit</span>
                </button>
            </div>
            <div id="currencyMessage" class="mt-2 text-sm hidden"></div>
            <x-input-error for="currency_id" class="mt-2" />
        </div>

        <!-- Phone -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="phone" value="{{ __('Phone Number') }}" />
            <div class="relative">
                <x-input id="phone" name="phone" type="tel" class="mt-1 block w-full pr-16" value="{{ Auth::user()->phone }}" autocomplete="tel" readonly />
                <button type="button" id="editPhoneBtn" class="absolute right-2 top-1/2 transform -translate-y-1/2 px-2 py-1 bg-purple-600 text-white text-xs rounded hover:bg-purple-700 transition-colors">
                    <i id="phoneLoadingIcon" class="fas fa-spinner fa-spin hidden mr-1"></i>
                    <span id="phoneBtnText">Edit</span>
                </button>
            </div>
            <div id="phoneMessage" class="mt-2 text-sm hidden"></div>
            <x-input-error for="phone" class="mt-2" />

            <!-- Phone Verification Section -->
            <div id="phoneVerificationSection" class="mt-3 hidden">
                <div class="p-3 bg-blue-50 dark:bg-blue-900 border border-blue-200 dark:border-blue-700 rounded-md">
                    <p class="text-sm text-blue-800 dark:text-blue-200 mb-2">
                        📱 Verification code sent to your phone number
                    </p>
                    <div class="flex gap-2">
                        <input type="text" id="phoneVerificationCode" placeholder="Enter 6-digit code" 
                               class="flex-1 px-3 py-2 text-center font-mono border border-blue-300 dark:border-blue-600 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-blue-800 dark:text-white" 
                               maxlength="6">
                        <button type="button" id="verifyPhoneBtn" class="px-4 py-2 bg-purple-600 text-white text-sm rounded hover:bg-purple-700 transition-colors">
                            <i id="phoneVerifyLoadingIcon" class="fas fa-spinner fa-spin hidden mr-1"></i>
                            <span id="phoneVerifyBtnText">Verify</span>
                        </button>
                    </div>
                    <div id="phoneCodeError" class="text-red-600 dark:text-red-400 text-sm mt-2 hidden"></div>
                </div>
            </div>
        </div>

        <!-- Email -->
        <div class="col-span-6 sm:col-span-4">
            <x-label for="email" value="{{ __('Email') }}" />
            <div class="relative">
                <x-input id="email" name="email" type="email" class="mt-1 block w-full pr-20" value="{{ Auth::user()->email }}" required autocomplete="username" readonly />
                <button type="button" id="editEmailBtn" class="absolute right-2 top-1/2 transform -translate-y-1/2 px-2 py-1 bg-purple-600 text-white text-xs rounded hover:bg-purple-700 transition-colors">
                    <i id="emailLoadingIcon" class="fas fa-spinner fa-spin hidden mr-1"></i>
                    <span id="emailBtnText">Edit</span>
                </button>
            </div>
            <x-input-error for="email" class="mt-2" />

            <!-- Email Verification Section -->
            <div id="emailMessage" class="mt-2 text-sm hidden"></div>
            <div id="emailVerificationSection" class="mt-3 hidden">
                <div class="p-3 bg-blue-50 dark:bg-blue-900 border border-blue-200 dark:border-blue-700 rounded-md">
                    <p class="text-sm text-blue-800 dark:text-blue-200 mb-2" id="verificationMessage">
                        📧 Step 1: Verification code sent to your current email address
                    </p>
                    <div class="flex gap-2">
                        <input type="text" id="emailVerificationCode" placeholder="Enter 6-digit code" 
                               class="flex-1 px-3 py-2 text-center font-mono border border-blue-300 dark:border-blue-600 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-blue-800 dark:text-white" 
                               maxlength="6">
                        <button type="button" id="verifyEmailBtn" class="px-4 py-2 bg-purple-600 text-white text-sm rounded hover:bg-purple-700 transition-colors">
                            <i id="emailVerifyLoadingIcon" class="fas fa-spinner fa-spin hidden mr-1"></i>
                            <span id="emailVerifyBtnText">Verify</span>
                        </button>
                    </div>
                    <div id="emailCodeError" class="text-red-600 dark:text-red-400 text-sm mt-2 hidden"></div>
                </div>
            </div>



            @if (!Auth::user()->hasVerifiedEmail())
                <p class="text-sm mt-2 text-yellow-600 dark:text-yellow-400">
                    {{ __('Your email address is unverified. Click on the Edit button to change it.') }}
                </p>
            @endif
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Message functions
        function showUsernameMessage(message, type) {
            const messageDiv = document.getElementById('usernameMessage');
            messageDiv.textContent = message;
            messageDiv.className = `mt-2 text-sm ${type === 'success' ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400'}`;
            messageDiv.classList.remove('hidden');
            
            // Auto hide after 3 seconds
            setTimeout(() => {
                messageDiv.classList.add('hidden');
            }, 3000);
        }

        function showNameMessage(message, type) {
            const messageDiv = document.getElementById('nameMessage');
            messageDiv.textContent = message;
            messageDiv.className = `mt-2 text-sm ${type === 'success' ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400'}`;
            messageDiv.classList.remove('hidden');
            
            // Auto hide after 3 seconds
            setTimeout(() => {
                messageDiv.classList.add('hidden');
            }, 3000);
        }

        function showEmailMessage(message, type) {
            const messageDiv = document.getElementById('emailMessage');
            messageDiv.textContent = message;
            messageDiv.className = `mt-2 text-sm ${type === 'success' ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400'}`;
            messageDiv.classList.remove('hidden');
            
            // Auto hide after 3 seconds
            setTimeout(() => {
                messageDiv.classList.add('hidden');
            }, 3000);
        }

        // Name field functionality
        const editNameBtn = document.getElementById('editNameBtn');
        const nameInput = document.getElementById('name');
        let isEditingName = false;
        let originalName = nameInput.value;

        if (editNameBtn) {
            editNameBtn.addEventListener('click', function() {
            if (!isEditingName) {
                // Enable editing
                nameInput.removeAttribute('readonly');
                nameInput.focus();
                document.getElementById('nameBtnText').textContent = 'Save';
                isEditingName = true;
            } else {
                // Save changes
                const newName = nameInput.value.trim();
                if (!newName) {
                    showNameMessage('Please enter a valid name', 'error');
                    return;
                }
                
                // Validate name format
                const nameRegex = /^[a-zA-Z0-9\s\'-\.]+$/;
                if (!nameRegex.test(newName)) {
                    showNameMessage('Name can only contain letters, numbers, spaces, apostrophes, hyphens, and dots', 'error');
                    return;
                }
                
                if (newName.length < 2) {
                    showNameMessage('Name must be at least 2 characters long', 'error');
                    return;
                }
                
                if (newName === originalName) {
                    // No changes made
                    nameInput.setAttribute('readonly', true);
                    document.getElementById('nameBtnText').textContent = 'Edit';
                    isEditingName = false;
                    return;
                }

                // Show loading
                document.getElementById('nameLoadingIcon').classList.remove('hidden');
                document.getElementById('nameBtnText').textContent = 'Saving...';
                editNameBtn.disabled = true;

                fetch('{{ route("name.update") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        name: newName
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        nameInput.setAttribute('readonly', true);
                        document.getElementById('nameBtnText').textContent = 'Edit';
                        isEditingName = false;
                        originalName = newName;
                        showNameMessage('Name updated successfully!', 'success');
                    } else {
                        showNameMessage(data.message || 'Error updating name', 'error');
                        nameInput.value = originalName;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showNameMessage('Error updating name', 'error');
                    nameInput.value = originalName;
                })
                .finally(() => {
                    // Hide loading
                    document.getElementById('nameLoadingIcon').classList.add('hidden');
                    document.getElementById('nameBtnText').textContent = 'Edit';
                    editNameBtn.disabled = false;
                    nameInput.setAttribute('readonly', true);
                    isEditingName = false;
                });
            }
            });
        }

        // Username field functionality
        const editUsernameBtn = document.getElementById('editUsernameBtn');
        const usernameInput = document.getElementById('username');
        let isEditingUsername = false;
        let originalUsername = usernameInput.value;

        editUsernameBtn.addEventListener('click', function() {
            if (!isEditingUsername) {
                // Enable editing
                usernameInput.removeAttribute('readonly');
                usernameInput.focus();
                document.getElementById('usernameBtnText').textContent = 'Save';
                isEditingUsername = true;
            } else {
                // Save changes
                let newUsername = usernameInput.value.trim();
                if (!newUsername) {
                    showUsernameMessage('Please enter a valid username', 'error');
                    return;
                }
                
                // Add @ if not present
                if (!newUsername.startsWith('@')) {
                    newUsername = '@' + newUsername;
                    usernameInput.value = newUsername;
                }
                
                if (newUsername === originalUsername) {
                    // No changes made
                    usernameInput.setAttribute('readonly', true);
                    document.getElementById('usernameBtnText').textContent = 'Edit';
                    isEditingUsername = false;
                    return;
                }

                // Show loading
                document.getElementById('usernameLoadingIcon').classList.remove('hidden');
                document.getElementById('usernameBtnText').textContent = 'Saving...';
                editUsernameBtn.disabled = true;

                fetch('{{ route("username.update") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        username: newUsername
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        usernameInput.setAttribute('readonly', true);
                        document.getElementById('usernameBtnText').textContent = 'Edit';
                        isEditingUsername = false;
                        originalUsername = newUsername;
                        showUsernameMessage('Username updated successfully!', 'success');
                    } else {
                        showUsernameMessage(data.message || 'Error updating username', 'error');
                        usernameInput.value = originalUsername;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showUsernameMessage('Error updating username', 'error');
                    usernameInput.value = originalUsername;
                })
                .finally(() => {
                    // Hide loading
                    document.getElementById('usernameLoadingIcon').classList.add('hidden');
                    document.getElementById('usernameBtnText').textContent = 'Edit';
                    editUsernameBtn.disabled = false;
                    usernameInput.setAttribute('readonly', true);
                    isEditingUsername = false;
                });
            }
        });

        // Email field functionality
        const editEmailBtn = document.getElementById('editEmailBtn');
        const emailInput = document.getElementById('email');
        const verificationSection = document.getElementById('emailVerificationSection');
        const verifyBtn = document.getElementById('verifyEmailBtn');
        const codeInput = document.getElementById('emailVerificationCode');
        const errorDiv = document.getElementById('emailCodeError');
        let isEditingEmail = false;
        let originalEmail = emailInput.value;

        editEmailBtn.addEventListener('click', function() {
            if (!isEditingEmail) {
                // Enable editing
                emailInput.removeAttribute('readonly');
                emailInput.focus();
                document.getElementById('emailBtnText').textContent = 'Save';
                isEditingEmail = true;
            } else {
                // Save changes
                const newEmail = emailInput.value;
                if (!newEmail || !newEmail.includes('@')) {
                    alert('Please enter a valid email address');
                    return;
                }
                
                if (newEmail === originalEmail) {
                    // No changes made
                    emailInput.setAttribute('readonly', true);
                    document.getElementById('emailBtnText').textContent = 'Edit';
                    isEditingEmail = false;
                    return;
                }

                // Show loading
                document.getElementById('emailLoadingIcon').classList.remove('hidden');
                document.getElementById('emailBtnText').textContent = 'Saving...';
                editEmailBtn.disabled = true;

                fetch('{{ route("email.change") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        email: newEmail
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        if (data.verification_required) {
                            // Show verification section
                            verificationSection.classList.remove('hidden');
                        } else {
                            // Email updated directly
                            showEmailMessage('Email updated successfully!', 'success');
                            location.reload(); // Refresh to show new email
                        }
                        emailInput.setAttribute('readonly', true);
                        document.getElementById('emailBtnText').textContent = 'Edit';
                        isEditingEmail = false;
                        originalEmail = newEmail;
                    } else {
                        showEmailMessage(data.message || 'Error updating email', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showEmailMessage('Error updating email', 'error');
                })
                .finally(() => {
                    // Hide loading
                    document.getElementById('emailLoadingIcon').classList.add('hidden');
                    editEmailBtn.disabled = false;
                });
            }
        });

        verifyBtn.addEventListener('click', function() {
            const code = codeInput.value;
            if (!code || code.length !== 6) {
                errorDiv.textContent = 'Please enter a valid 6-digit code';
                errorDiv.classList.remove('hidden');
                return;
            }

            // Show loading
            document.getElementById('emailVerifyLoadingIcon').classList.remove('hidden');
            document.getElementById('emailVerifyBtnText').textContent = 'Verifying...';
            verifyBtn.disabled = true;

            fetch('{{ route("email.verify-change") }}', {
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
                    if (data.step === 'new_email_verification') {
                        // Step 1 complete, now verify new email
                        codeInput.value = '';
                        errorDiv.classList.add('hidden');
                        document.getElementById('verificationMessage').textContent = '📧 Step 2: Verification code sent to your new email address';
                        showEmailMessage('Step 1 complete! Check your new email for the next code.', 'success');
                    } else if (data.step === 'completed') {
                        // Both steps complete
                        verificationSection.classList.add('hidden');
                        codeInput.value = '';
                        showEmailMessage('Email changed successfully!', 'success');
                        setTimeout(() => {
                            location.reload();
                        }, 1500);
                    }
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
                document.getElementById('emailVerifyLoadingIcon').classList.add('hidden');
                document.getElementById('emailVerifyBtnText').textContent = 'Verify';
                verifyBtn.disabled = false;
            });
        });

        // Currency field functionality
        const editCurrencyBtn = document.getElementById('editCurrencyBtn');
        const currencySelect = document.getElementById('currency_id');
        let isEditingCurrency = false;
        let originalCurrency = currencySelect.value;

        editCurrencyBtn.addEventListener('click', function() {
            if (!isEditingCurrency) {
                currencySelect.removeAttribute('disabled');
                currencySelect.focus();
                document.getElementById('currencyBtnText').textContent = 'Save';
                isEditingCurrency = true;
            } else {
                const newCurrency = currencySelect.value;
                
                if (newCurrency === originalCurrency) {
                    currencySelect.setAttribute('disabled', true);
                    document.getElementById('currencyBtnText').textContent = 'Edit';
                    isEditingCurrency = false;
                    return;
                }

                document.getElementById('currencyLoadingIcon').classList.remove('hidden');
                document.getElementById('currencyBtnText').textContent = 'Saving...';
                editCurrencyBtn.disabled = true;

                fetch('{{ route("user.update-currency") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ currency_id: newCurrency })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        currencySelect.setAttribute('disabled', true);
                        document.getElementById('currencyBtnText').textContent = 'Edit';
                        isEditingCurrency = false;
                        originalCurrency = newCurrency;
                        showCurrencyMessage('Currency updated successfully!', 'success');
                    } else {
                        showCurrencyMessage(data.message || 'Error updating currency', 'error');
                        currencySelect.value = originalCurrency;
                    }
                })
                .catch(error => {
                    showCurrencyMessage('Error updating currency', 'error');
                    currencySelect.value = originalCurrency;
                })
                .finally(() => {
                    document.getElementById('currencyLoadingIcon').classList.add('hidden');
                    document.getElementById('currencyBtnText').textContent = 'Edit';
                    editCurrencyBtn.disabled = false;
                    currencySelect.setAttribute('disabled', true);
                    isEditingCurrency = false;
                });
            }
        });

        // Phone field functionality
        const editPhoneBtn = document.getElementById('editPhoneBtn');
        const phoneInput = document.getElementById('phone');
        const phoneVerificationSection = document.getElementById('phoneVerificationSection');
        const verifyPhoneBtn = document.getElementById('verifyPhoneBtn');
        const phoneCodeInput = document.getElementById('phoneVerificationCode');
        const phoneCodeError = document.getElementById('phoneCodeError');
        let isEditingPhone = false;
        let originalPhone = phoneInput.value;
        let pendingPhone = '';

        editPhoneBtn.addEventListener('click', function() {
            if (!isEditingPhone) {
                phoneInput.removeAttribute('readonly');
                phoneInput.focus();
                document.getElementById('phoneBtnText').textContent = 'Save';
                isEditingPhone = true;
            } else {
                const newPhone = phoneInput.value.trim();
                
                if (newPhone === originalPhone) {
                    phoneInput.setAttribute('readonly', true);
                    document.getElementById('phoneBtnText').textContent = 'Edit';
                    isEditingPhone = false;
                    return;
                }

                document.getElementById('phoneLoadingIcon').classList.remove('hidden');
                document.getElementById('phoneBtnText').textContent = 'Saving...';
                editPhoneBtn.disabled = true;

                fetch('{{ route("user.update-phone") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ phone: newPhone })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        if (data.verification_required) {
                            // SMS enabled - show verification section
                            pendingPhone = newPhone;
                            phoneVerificationSection.classList.remove('hidden');
                            phoneInput.setAttribute('readonly', true);
                            document.getElementById('phoneBtnText').textContent = 'Edit';
                            isEditingPhone = false;
                            showPhoneMessage('Verification code sent to your phone!', 'success');
                        } else {
                            // SMS disabled - phone saved directly
                            phoneInput.setAttribute('readonly', true);
                            document.getElementById('phoneBtnText').textContent = 'Edit';
                            isEditingPhone = false;
                            originalPhone = newPhone;
                            showPhoneMessage('Phone updated successfully!', 'success');
                        }
                    } else {
                        showPhoneMessage(data.message || 'Error updating phone', 'error');
                        phoneInput.value = originalPhone;
                    }
                })
                .catch(error => {
                    showPhoneMessage('Error updating phone', 'error');
                    phoneInput.value = originalPhone;
                })
                .finally(() => {
                    document.getElementById('phoneLoadingIcon').classList.add('hidden');
                    document.getElementById('phoneBtnText').textContent = 'Edit';
                    editPhoneBtn.disabled = false;
                    phoneInput.setAttribute('readonly', true);
                    isEditingPhone = false;
                });
            }
        });

        // Phone verification functionality
        if (verifyPhoneBtn) {
            verifyPhoneBtn.addEventListener('click', function() {
                const code = phoneCodeInput.value.trim();
                if (!code || code.length !== 6) {
                    phoneCodeError.textContent = 'Please enter a valid 6-digit code';
                    phoneCodeError.classList.remove('hidden');
                    return;
                }

                document.getElementById('phoneVerifyLoadingIcon').classList.remove('hidden');
                document.getElementById('phoneVerifyBtnText').textContent = 'Verifying...';
                verifyPhoneBtn.disabled = true;

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
                        phoneVerificationSection.classList.add('hidden');
                        phoneCodeInput.value = '';
                        phoneCodeError.classList.add('hidden');
                        originalPhone = pendingPhone;
                        showPhoneMessage('Phone verified and updated successfully!', 'success');
                    } else {
                        phoneCodeError.textContent = data.message || 'Invalid verification code';
                        phoneCodeError.classList.remove('hidden');
                    }
                })
                .catch(error => {
                    phoneCodeError.textContent = 'Error verifying code';
                    phoneCodeError.classList.remove('hidden');
                })
                .finally(() => {
                    document.getElementById('phoneVerifyLoadingIcon').classList.add('hidden');
                    document.getElementById('phoneVerifyBtnText').textContent = 'Verify';
                    verifyPhoneBtn.disabled = false;
                });
            });
        }

        function showCurrencyMessage(message, type) {
            const messageDiv = document.getElementById('currencyMessage');
            messageDiv.textContent = message;
            messageDiv.className = `mt-2 text-sm ${type === 'success' ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400'}`;
            messageDiv.classList.remove('hidden');
            setTimeout(() => messageDiv.classList.add('hidden'), 3000);
        }

        function showPhoneMessage(message, type) {
            const messageDiv = document.getElementById('phoneMessage');
            messageDiv.textContent = message;
            messageDiv.className = `mt-2 text-sm ${type === 'success' ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400'}`;
            messageDiv.classList.remove('hidden');
            setTimeout(() => messageDiv.classList.add('hidden'), 3000);
        }

        function showDateOfBirthMessage(message, type) {
            const messageDiv = document.getElementById('dateOfBirthMessage');
            messageDiv.textContent = message;
            messageDiv.className = `mt-2 text-sm ${type === 'success' ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400'}`;
            messageDiv.classList.remove('hidden');
            setTimeout(() => messageDiv.classList.add('hidden'), 3000);
        }

        // Date of Birth field functionality
        const editDateOfBirthBtn = document.getElementById('editDateOfBirthBtn');
        const dateOfBirthInput = document.getElementById('date_of_birth');
        let isEditingDateOfBirth = false;
        let originalDateOfBirth = dateOfBirthInput.value;

        if (editDateOfBirthBtn) {
            editDateOfBirthBtn.addEventListener('click', function() {
            if (!isEditingDateOfBirth) {
                dateOfBirthInput.removeAttribute('readonly');
                dateOfBirthInput.focus();
                document.getElementById('dateOfBirthBtnText').textContent = 'Save';
                isEditingDateOfBirth = true;
            } else {
                const newDateOfBirth = dateOfBirthInput.value;
                
                if (newDateOfBirth === originalDateOfBirth) {
                    dateOfBirthInput.setAttribute('readonly', true);
                    document.getElementById('dateOfBirthBtnText').textContent = 'Edit';
                    isEditingDateOfBirth = false;
                    return;
                }

                document.getElementById('dateOfBirthLoadingIcon').classList.remove('hidden');
                document.getElementById('dateOfBirthBtnText').textContent = 'Saving...';
                editDateOfBirthBtn.disabled = true;

                fetch('{{ route("user.update-date-of-birth") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ date_of_birth: newDateOfBirth })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        dateOfBirthInput.setAttribute('readonly', true);
                        document.getElementById('dateOfBirthBtnText').textContent = 'Edit';
                        isEditingDateOfBirth = false;
                        originalDateOfBirth = newDateOfBirth;
                        showDateOfBirthMessage('Date of birth updated successfully!', 'success');
                    } else {
                        showDateOfBirthMessage(data.message || 'Error updating date of birth', 'error');
                        dateOfBirthInput.value = originalDateOfBirth;
                    }
                })
                .catch(error => {
                    showDateOfBirthMessage('Error updating date of birth', 'error');
                    dateOfBirthInput.value = originalDateOfBirth;
                })
                .finally(() => {
                    document.getElementById('dateOfBirthLoadingIcon').classList.add('hidden');
                    document.getElementById('dateOfBirthBtnText').textContent = 'Edit';
                    editDateOfBirthBtn.disabled = false;
                    dateOfBirthInput.setAttribute('readonly', true);
                    isEditingDateOfBirth = false;
                });
            }
            });
        }
    });
    
    // Photo upload function
    function savePhoto() {
        const photoInput = document.getElementById('photo');
        const file = photoInput.files[0];
        
        if (!file) {
            alert('Please select a photo first');
            return;
        }
        
        const formData = new FormData();
        formData.append('photo', file);
        formData.append('_token', '{{ csrf_token() }}');
        
        fetch('{{ route("user.profile-photo.update") }}', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Profile photo updated successfully!');
                location.reload();
            } else {
                alert(data.message || 'Error uploading photo');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error uploading photo');
        });
    }
    
    // Photo removal function
    function removePhoto() {
        if (!confirm('Are you sure you want to remove your profile photo?')) {
            return;
        }
        
        fetch('{{ route("user.profile-photo.remove") }}', {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Profile photo removed successfully!');
                location.reload();
            } else {
                alert(data.message || 'Error removing photo');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error removing photo');
        });
    }
</script>
