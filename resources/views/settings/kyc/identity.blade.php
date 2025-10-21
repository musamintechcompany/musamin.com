<x-app-layout>

    <div class="py-12 bg-white dark:bg-gray-900">
        <div class="mx-auto max-w-4xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700">
                    <div class="sticky top-0 flex items-center py-2 mb-6 bg-white dark:bg-gray-800">
                        <button onclick="window.history.back()" class="mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-500 dark:text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                            </svg>
                        </button>
                        <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200">KYC Verification</h2>
                    </div>

                    <!-- Step Progress Indicator -->
                    <div class="mb-8">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div id="step1-indicator" class="flex items-center justify-center w-8 h-8 bg-blue-600 text-white rounded-full text-sm font-medium">
                                    1
                                </div>
                                <div class="w-16 h-1 bg-gray-300 dark:bg-gray-600 mx-2">
                                    <div id="progress1" class="h-full bg-blue-600 transition-all duration-300" style="width: 0%"></div>
                                </div>
                            </div>
                            <div class="flex items-center">
                                <div id="step2-indicator" class="flex items-center justify-center w-8 h-8 bg-gray-300 dark:bg-gray-600 text-gray-600 dark:text-gray-400 rounded-full text-sm font-medium">
                                    2
                                </div>
                                <div class="w-16 h-1 bg-gray-300 dark:bg-gray-600 mx-2">
                                    <div id="progress2" class="h-full bg-blue-600 transition-all duration-300" style="width: 0%"></div>
                                </div>
                            </div>
                            <div class="flex items-center">
                                <div id="step3-indicator" class="flex items-center justify-center w-8 h-8 bg-gray-300 dark:bg-gray-600 text-gray-600 dark:text-gray-400 rounded-full text-sm font-medium">
                                    3
                                </div>
                                <div class="w-16 h-1 bg-gray-300 dark:bg-gray-600 mx-2">
                                    <div id="progress3" class="h-full bg-blue-600 transition-all duration-300" style="width: 0%"></div>
                                </div>
                            </div>
                            <div class="flex items-center">
                                <div id="step4-indicator" class="flex items-center justify-center w-8 h-8 bg-gray-300 dark:bg-gray-600 text-gray-600 dark:text-gray-400 rounded-full text-sm font-medium">
                                    4
                                </div>
                            </div>
                        </div>
                        <div class="flex justify-between mt-2 text-sm text-gray-600 dark:text-gray-400">
                            <span>Personal Info</span>
                            <span>Address</span>
                            <span>Proof of Address</span>
                            <span>ID Verification</span>
                        </div>
                    </div>

                    <form id="kycForm" class="space-y-6">
                        @csrf

                        <!-- Step 1: Personal Information -->
                        <div id="step1" class="step-content bg-gray-50 dark:bg-gray-700 p-6 rounded-lg">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Step 1: Personal Information</h3>

                            <!-- Important Note -->
                            <div class="mb-6 p-4 bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg">
                                <div class="flex">
                                    <i class="fas fa-exclamation-triangle text-yellow-400 mt-0.5 mr-3"></i>
                                    <div>
                                        <h4 class="text-sm font-medium text-yellow-800 dark:text-yellow-200">Important Notice</h4>
                                        <p class="mt-1 text-sm text-yellow-700 dark:text-yellow-300">
                                            Please ensure these are your true credentials. If you need to change anything, go to
                                            <a href="{{ route('profile.show') }}" class="font-medium underline hover:no-underline">Profile Information</a>
                                            to update it immediately before proceeding. These credentials cannot be changed once your KYC is approved.
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">First Name</label>
                                    <input type="text" name="first_name" value="{{ explode(' ', $user->name)[0] ?? '' }}" readonly class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-100 dark:bg-gray-600 dark:border-gray-500 dark:text-white cursor-not-allowed">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Last Name</label>
                                    <input type="text" name="last_name" value="{{ explode(' ', $user->name)[1] ?? '' }}" readonly class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-100 dark:bg-gray-600 dark:border-gray-500 dark:text-white cursor-not-allowed">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Date of Birth</label>
                                    <input type="date" name="date_of_birth" value="{{ $user->date_of_birth ? \Carbon\Carbon::parse($user->date_of_birth)->format('Y-m-d') : '' }}" readonly class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-100 dark:bg-gray-600 dark:border-gray-500 dark:text-white cursor-not-allowed">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Phone Number</label>
                                    <input type="tel" name="phone" value="{{ $user->phone }}" readonly class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-100 dark:bg-gray-600 dark:border-gray-500 dark:text-white cursor-not-allowed">
                                </div>
                            </div>
                        </div>

                        <!-- Step 2: Address Information -->
                        <div id="step2" class="step-content bg-gray-50 dark:bg-gray-700 p-6 rounded-lg hidden">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Step 2: Address Information</h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Street Address</label>
                                    <input type="text" name="street_address" value="{{ $user->address }}" required maxlength="100" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-600 dark:border-gray-500 dark:text-white">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">City</label>
                                    <input type="text" name="city" value="{{ $user->city }}" required maxlength="50" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-600 dark:border-gray-500 dark:text-white">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">State/Province</label>
                                    <input type="text" name="state" value="{{ $user->state }}" required maxlength="50" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-600 dark:border-gray-500 dark:text-white">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Postal Code</label>
                                    <input type="text" name="postal_code" value="{{ $user->postal_code }}" required maxlength="10" pattern="[A-Za-z0-9\s-]{3,10}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-600 dark:border-gray-500 dark:text-white">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Country</label>
                                    <input type="text" name="country" value="{{ $user->country }}" required maxlength="50" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-600 dark:border-gray-500 dark:text-white">
                                </div>
                            </div>

                            <div class="mt-4">
                                <button type="button" id="saveAddressBtn" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 transition duration-200">
                                    <i class="fas fa-save mr-2"></i>
                                    Save Address
                                </button>
                            </div>
                        </div>

                        <!-- Step 3: Proof of Address -->
                        <div id="step3" class="step-content bg-gray-50 dark:bg-gray-700 p-6 rounded-lg hidden">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Step 3: Proof of Address</h3>

                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Utility Bill Type</label>
                                    <select name="utility_type" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-600 dark:border-gray-500 dark:text-white">
                                        <option value="">Select Utility Type</option>
                                        <option value="electricity">Electricity Bill</option>
                                        <option value="water">Water Bill</option>
                                        <option value="gas">Gas Bill</option>
                                        <option value="internet">Internet/Cable Bill</option>
                                        <option value="phone">Phone Bill</option>
                                        <option value="bank_statement">Bank Statement</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Upload Utility Bill</label>
                                    <input type="file" name="utility_bill" accept="image/*,.pdf" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-600 dark:border-gray-500 dark:text-white">
                                    <p class="text-sm text-gray-500 mt-1">Upload a recent utility bill (not older than 3 months) - JPG, PNG, PDF - Max 5MB</p>
                                </div>
                            </div>
                        </div>

                        <!-- Step 4: ID Verification -->
                        <div id="step4" class="step-content bg-gray-50 dark:bg-gray-700 p-6 rounded-lg hidden">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Step 4: ID Verification</h3>

                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">ID Type</label>
                                    <select name="id_type" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-600 dark:border-gray-500 dark:text-white">
                                        <option value="">Select ID Type</option>
                                        <option value="passport">Passport</option>
                                        <option value="drivers_license">Driver's License</option>
                                        <option value="national_id">National ID Card</option>
                                        <option value="voter_id">Voter ID</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">ID Number</label>
                                    <input type="text" name="id_number" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-600 dark:border-gray-500 dark:text-white">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Upload ID Document</label>
                                    <input type="file" name="id_document" accept="image/*,.pdf" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-600 dark:border-gray-500 dark:text-white">
                                    <p class="text-sm text-gray-500 mt-1">Upload a clear photo or scan of your ID - JPG, PNG, PDF - Max 5MB</p>
                                </div>

                            </div>
                        </div>

                        <!-- Navigation Buttons -->
                        <div class="flex justify-between">
                            <button type="button" id="prevBtn" class="px-6 py-3 bg-gray-600 text-white rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 transition duration-200 hidden">
                                <i class="fas fa-arrow-left mr-2"></i>
                                Previous
                            </button>
                            <button type="button" id="nextBtn" class="px-6 py-3 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-200">
                                Next
                                <i class="fas fa-arrow-right ml-2"></i>
                            </button>
                            <button type="submit" id="submitBtn" class="px-6 py-3 bg-gray-400 text-white rounded-md cursor-not-allowed transition duration-200 hidden" disabled>
                                <i class="fas fa-video mr-2"></i>
                                Start Recording
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let currentStep = 1;
            const totalSteps = 4;

            const form = document.getElementById('kycForm');
            const nextBtn = document.getElementById('nextBtn');
            const prevBtn = document.getElementById('prevBtn');
            const submitBtn = document.getElementById('submitBtn');

            function validateStep1() {
                const firstName = document.querySelector('input[name="first_name"]').value.trim();
                const lastName = document.querySelector('input[name="last_name"]').value.trim();
                const dateOfBirth = document.querySelector('input[name="date_of_birth"]').value.trim();
                const phone = document.querySelector('input[name="phone"]').value.trim();

                return firstName && lastName && dateOfBirth && phone;
            }

            function validateStep2() {
                const streetAddress = document.querySelector('input[name="street_address"]').value.trim();
                const city = document.querySelector('input[name="city"]').value.trim();
                const state = document.querySelector('input[name="state"]').value.trim();
                const postalCode = document.querySelector('input[name="postal_code"]').value.trim();
                const country = document.querySelector('input[name="country"]').value.trim();

                // Check if all fields are filled AND address has been saved
                const allFieldsFilled = streetAddress && city && state && postalCode && country;
                const addressSaved = localStorage.getItem('kyc_address_saved') === 'true';
                
                return allFieldsFilled && addressSaved;
            }

            function validateStep3() {
                const utilityType = document.querySelector('select[name="utility_type"]').value;
                const utilityBill = document.querySelector('input[name="utility_bill"]').files.length > 0;

                return utilityType && utilityBill;
            }

            function validateStep4() {
                const idType = document.querySelector('select[name="id_type"]')?.value || '';
                const idNumber = document.querySelector('input[name="id_number"]')?.value.trim() || '';
                const idDocument = document.querySelector('input[name="id_document"]')?.files.length > 0;

                // For enabling Start Recording button: only check form fields
                if (!window.recordedVideoBlob) {
                    return idType && idNumber && idDocument;
                }
                
                // For final submission: check form fields + video
                return idType && idNumber && idDocument && window.recordedVideoBlob;
            }

            function updateNextButton() {
                let isValid = false;
                
                if (currentStep === 1) {
                    isValid = validateStep1();
                } else if (currentStep === 2) {
                    isValid = validateStep2();
                } else if (currentStep === 3) {
                    isValid = validateStep3();
                } else if (currentStep === 4) {
                    isValid = validateStep4();
                    updateSubmitButton(isValid);
                }
                
                if (currentStep < totalSteps) {
                    nextBtn.disabled = !isValid;
                    nextBtn.classList.toggle('opacity-50', !isValid);
                    nextBtn.classList.toggle('cursor-not-allowed', !isValid);
                }
            }
            
            function updateSubmitButton(isValid) {
                const submitBtn = document.getElementById('submitBtn');
                
                if (!submitBtn) return;
                
                if (isValid && !window.recordedVideoBlob) {
                    // Enable Start Recording button
                    submitBtn.disabled = false;
                    submitBtn.className = 'px-6 py-3 bg-red-600 text-white rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 transition duration-200';
                } else if (!isValid) {
                    // Disable button when fields not filled
                    submitBtn.disabled = true;
                    submitBtn.className = 'px-6 py-3 bg-gray-400 text-white rounded-md cursor-not-allowed transition duration-200';
                }
            }

            function showStep(step) {
                
                // Hide all steps
                document.querySelectorAll('.step-content').forEach(el => el.classList.add('hidden'));

                // Show current step
                document.getElementById(`step${step}`).classList.remove('hidden');

                // Update step indicators
                for (let i = 1; i <= totalSteps; i++) {
                    const indicator = document.getElementById(`step${i}-indicator`);
                    if (i < step) {
                        indicator.className = 'flex items-center justify-center w-8 h-8 bg-green-600 text-white rounded-full text-sm font-medium';
                        indicator.innerHTML = '<i class="fas fa-check"></i>';
                    } else if (i === step) {
                        indicator.className = 'flex items-center justify-center w-8 h-8 bg-blue-600 text-white rounded-full text-sm font-medium';
                        indicator.textContent = i;
                    } else {
                        indicator.className = 'flex items-center justify-center w-8 h-8 bg-gray-300 dark:bg-gray-600 text-gray-600 dark:text-gray-400 rounded-full text-sm font-medium';
                        indicator.textContent = i;
                    }
                }

                // Update progress bars
                for (let i = 1; i < totalSteps; i++) {
                    const progress = document.getElementById(`progress${i}`);
                    if (i < step) {
                        progress.style.width = '100%';
                    } else {
                        progress.style.width = '0%';
                    }
                }

                // Update button visibility
                prevBtn.classList.toggle('hidden', step === 1);
                nextBtn.classList.toggle('hidden', step === totalSteps);
                submitBtn.classList.toggle('hidden', step !== totalSteps);

                // Update next button state
                updateNextButton();
            }

            nextBtn.addEventListener('click', function() {
                if (nextBtn.disabled) return;

                if (currentStep < totalSteps) {
                    currentStep++;
                    showStep(currentStep);
                }
            });

            prevBtn.addEventListener('click', function() {
                if (currentStep > 1) {
                    currentStep--;
                    showStep(currentStep);
                }
            });

            // Handle submit button click directly
            document.getElementById('submitBtn').addEventListener('click', function(e) {
                e.preventDefault();
                
                // Only proceed if button is not disabled
                if (this.disabled) {
                    return;
                }
                
                // Check if video is recorded (submit mode) or need to record (instruction mode)
                if (window.recordedVideoBlob) {
                    // Submit KYC application
                    submitKycForm();
                } else {
                    // Show video recording instructions
                    showVideoInstructionModal();
                }
            });
            
            // Also handle form submit as backup
            form.addEventListener('submit', function(e) {
                e.preventDefault();
            });

            function showVideoInstructionModal() {
                const modal = document.createElement('div');
                modal.className = 'fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center';
                modal.style.zIndex = '100000';
                modal.innerHTML = `
                    <div class="bg-white dark:bg-gray-800 rounded-lg p-6 max-w-md w-full mx-4">
                        <div class="text-center mb-6">
                            <div class="mb-4">
                                <img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png" alt="Video Selfie" class="w-16 h-16 mx-auto mb-2">
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Video Selfie Required</h3>
                            <p class="text-gray-600 dark:text-gray-300 text-sm mb-4">We need to verify your identity with a live video selfie</p>
                        </div>
                        
                        <div class="space-y-4 mb-6">
                            <div class="flex items-start space-x-3">
                                <img src="https://cdn-icons-png.flaticon.com/512/3135/3135789.png" alt="Hold ID" class="w-8 h-8 mt-1">
                                <div>
                                    <h4 class="font-medium text-gray-900 dark:text-white">Hold Your ID Document</h4>
                                    <p class="text-sm text-gray-600 dark:text-gray-300">Hold your ID document next to your face clearly visible</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start space-x-3">
                                <img src="https://cdn-icons-png.flaticon.com/512/3135/3135823.png" alt="Good Lighting" class="w-8 h-8 mt-1">
                                <div>
                                    <h4 class="font-medium text-gray-900 dark:text-white">Ensure Good Lighting</h4>
                                    <p class="text-sm text-gray-600 dark:text-gray-300">Make sure your face and ID are clearly visible</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start space-x-3">
                                <img src="https://cdn-icons-png.flaticon.com/512/3135/3135768.png" alt="Speak Clearly" class="w-8 h-8 mt-1">
                                <div>
                                    <h4 class="font-medium text-gray-900 dark:text-white">Say Your Name & Today's Date</h4>
                                    <p class="text-sm text-gray-600 dark:text-gray-300">State your full name and today's date: ${new Date().toLocaleDateString()}</p>
                                </div>
                            </div>
                            

                        </div>
                        
                        <div class="flex space-x-3">
                            <button id="cancelBtn" class="flex-1 px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition duration-200">
                                Cancel
                            </button>
                            <button id="continueBtn" class="flex-1 px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition duration-200">
                                Continue
                            </button>
                        </div>
                    </div>
                `;
                document.body.appendChild(modal);
                
                // Add event listeners
                document.getElementById('continueBtn').addEventListener('click', function() {
                    const button = this;
                    const originalText = button.innerHTML;
                    
                    // Show loading state
                    button.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Opening Camera...';
                    button.disabled = true;
                    
                    // Start video recording with error handling
                    startVideoRecording().catch(error => {
                        // Reset button on error
                        button.innerHTML = originalText;
                        button.disabled = false;
                    });
                });
                
                document.getElementById('cancelBtn').addEventListener('click', function() {
                    modal.remove();
                });
            }

            async function startVideoRecording() {
                try {
                    // Check if getUserMedia is supported
                    if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
                        throw new Error('Camera access not supported in this browser');
                    }
                    
                    const stream = await navigator.mediaDevices.getUserMedia({ 
                        video: { 
                            width: { ideal: 640 }, 
                            height: { ideal: 480 },
                            facingMode: 'user'
                        }, 
                        audio: {
                            echoCancellation: true,
                            noiseSuppression: true,
                            autoGainControl: true
                        }
                    });
                    
                    // Close instruction modal after successful camera access
                    const instructionModal = document.querySelector('.fixed.inset-0');
                    if (instructionModal) {
                        instructionModal.remove();
                    }
                    
                    // Create video recording modal
                    const videoModal = document.createElement('div');
                    videoModal.className = 'fixed inset-0 bg-black bg-opacity-90 flex items-center justify-center';
                    videoModal.style.zIndex = '100001';
                    videoModal.innerHTML = `
                        <div class="bg-white dark:bg-gray-800 rounded-lg p-6 max-w-lg w-full mx-4">
                            <h3 class="text-xl font-semibold text-center mb-4 text-gray-900 dark:text-white">Record Your Video Selfie</h3>
                            <div class="relative">
                                <video id="videoPreview" autoplay muted playsinline class="w-full h-64 bg-black rounded-lg mb-4"></video>
                                <div id="instructionOverlay" class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-50 rounded-lg mb-4 hidden">
                                    <div class="text-center text-white">
                                        <div id="instructionIcon" class="mb-2"><i class="fas fa-id-card text-2xl"></i></div>
                                        <div id="instructionText" class="text-lg font-semibold">Hold your ID document close to your face</div>
                                        <div id="countdownDisplay" class="text-sm mt-2">Recording: <span id="recordingTimer">30</span>s</div>
                                    </div>
                                </div>
                            </div>
                            <p class="text-center text-sm text-gray-600 dark:text-gray-300 mb-4">
                                Say your full name and today's date: <strong>${new Date().toLocaleDateString()}</strong>
                            </p>
                            <div class="flex space-x-3">
                                <button id="cancelRecordBtn" class="flex-1 px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
                                    Cancel
                                </button>
                                <button id="recordBtn" class="flex-1 px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                                    Start Recording
                                </button>
                            </div>
                        </div>
                    `;
                    
                    document.body.appendChild(videoModal);
                    
                    // Attach video stream
                    const videoElement = document.getElementById('videoPreview');
                    videoElement.srcObject = stream;
                    
                    // Add event listeners for video modal buttons
                    document.getElementById('recordBtn').addEventListener('click', toggleRecording);
                    document.getElementById('cancelRecordBtn').addEventListener('click', stopRecording);
                    
                    window.currentStream = stream;
                    window.mediaRecorder = null;
                    window.recordedChunks = [];
                    
                } catch (error) {
                    let errorMessage = 'Camera access failed. ';
                    
                    if (error.name === 'NotAllowedError') {
                        errorMessage += 'Please allow camera access and try again.';
                    } else if (error.name === 'NotFoundError') {
                        errorMessage += 'No camera found on this device.';
                    } else if (error.name === 'NotSupportedError') {
                        errorMessage += 'Camera not supported in this browser.';
                    } else if (error.name === 'TimeoutError') {
                        errorMessage += 'Camera took too long to start. Please try again.';
                    } else {
                        errorMessage += error.message || 'Unknown error occurred.';
                    }
                    
                    alert(errorMessage);
                    throw error; // Re-throw to trigger button reset
                }
            }
            
            function toggleRecording() {
                const recordBtn = document.getElementById('recordBtn');
                
                if (!window.mediaRecorder || window.mediaRecorder.state === 'inactive') {
                    // Start recording
                    window.recordedChunks = [];
                    const options = {
                        mimeType: 'video/webm;codecs=vp9,opus'
                    };
                    
                    // Fallback if VP9/Opus not supported
                    if (!MediaRecorder.isTypeSupported(options.mimeType)) {
                        options.mimeType = 'video/webm;codecs=vp8,vorbis';
                    }
                    
                    // Final fallback
                    if (!MediaRecorder.isTypeSupported(options.mimeType)) {
                        options.mimeType = 'video/webm';
                    }
                    
                    window.mediaRecorder = new MediaRecorder(window.currentStream, options);
                    window.recordingTimeLeft = 30;
                    
                    window.mediaRecorder.ondataavailable = function(event) {
                        if (event.data.size > 0) {
                            window.recordedChunks.push(event.data);
                        }
                    };
                    
                    window.mediaRecorder.onstop = function() {
                        const mimeType = window.mediaRecorder.mimeType || 'video/webm';
                        const blob = new Blob(window.recordedChunks, { type: mimeType });
                        console.log('Video recorded with audio:', blob, 'MIME type:', mimeType);
                        window.recordedVideoBlob = blob;
                        document.getElementById('instructionOverlay').classList.add('hidden');
                        stopRecording();
                        showRecordedVideo();
                    };
                    
                    window.mediaRecorder.start();
                    recordBtn.textContent = 'Recording...';
                    recordBtn.disabled = true;
                    recordBtn.className = 'flex-1 px-4 py-2 bg-gray-500 text-white rounded-md cursor-not-allowed';
                    
                    // Show instruction overlay
                    document.getElementById('instructionOverlay').classList.remove('hidden');
                    
                    // Start face turn instructions and countdown
                    startRecordingInstructions();
                    
                } else {
                    // Stop recording manually
                    window.mediaRecorder.stop();
                    if (window.recordingInterval) clearInterval(window.recordingInterval);
                    if (window.instructionInterval) clearInterval(window.instructionInterval);
                }
            }
            
            function startRecordingInstructions() {
                const instructions = [
                    { icon: '<i class="fas fa-id-card text-2xl"></i>', text: 'Hold your ID document close to your face' },
                    { icon: '<i class="fas fa-microphone text-2xl"></i>', text: 'Say "I am {{ $user->name }}"' },
                    { icon: '<i class="fas fa-arrow-left text-2xl"></i>', text: 'Turn your head left slowly' },
                    { icon: '<i class="fas fa-arrow-right text-2xl"></i>', text: 'Turn your head right slowly' },
                    { icon: '<i class="fas fa-camera text-2xl"></i>', text: 'Bring camera closer and look straight' }
                ];
                
                let currentInstruction = 0;
                
                // Update instruction every 6 seconds
                window.instructionInterval = setInterval(() => {
                    if (currentInstruction < instructions.length) {
                        document.getElementById('instructionIcon').innerHTML = instructions[currentInstruction].icon;
                        document.getElementById('instructionText').textContent = instructions[currentInstruction].text;
                        currentInstruction++;
                    }
                }, 6000);
                
                // Countdown timer
                window.recordingInterval = setInterval(() => {
                    window.recordingTimeLeft--;
                    document.getElementById('recordingTimer').textContent = window.recordingTimeLeft;
                    
                    if (window.recordingTimeLeft <= 0) {
                        // Auto-stop recording after 30 seconds
                        if (window.mediaRecorder && window.mediaRecorder.state === 'recording') {
                            window.mediaRecorder.stop();
                        }
                        clearInterval(window.recordingInterval);
                        clearInterval(window.instructionInterval);
                    }
                }, 1000);
            }
            
            function stopRecording() {
                if (window.currentStream) {
                    window.currentStream.getTracks().forEach(track => track.stop());
                }
                if (window.mediaRecorder && window.mediaRecorder.state !== 'inactive') {
                    window.mediaRecorder.stop();
                }
                const videoModal = document.querySelector('.fixed.inset-0');
                if (videoModal) {
                    videoModal.remove();
                }
            }
            
            function showRecordedVideo() {
                // Create video preview in Step 4
                const step4 = document.getElementById('step4');
                const existingPreview = document.getElementById('videoPreviewSection');
                
                if (existingPreview) {
                    existingPreview.remove();
                }
                
                const videoPreviewSection = document.createElement('div');
                videoPreviewSection.id = 'videoPreviewSection';
                videoPreviewSection.className = 'mt-6 p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg';
                videoPreviewSection.innerHTML = `
                    <h4 class="text-lg font-medium text-green-800 dark:text-green-200 mb-3">
                        <i class="fas fa-check-circle mr-2"></i>Video Recorded Successfully
                    </h4>
                    <video id="recordedVideoPreview" controls class="w-full max-w-md mx-auto h-48 bg-black rounded-lg mb-3"></video>
                    <p class="text-sm text-green-700 dark:text-green-300 text-center">
                        Review your video above. If you're satisfied, click Submit to complete your KYC application.
                    </p>
                `;
                
                // Insert before the navigation buttons
                const navigationButtons = step4.querySelector('.flex.justify-between');
                step4.insertBefore(videoPreviewSection, navigationButtons);
                
                // Set the recorded video source with audio enabled
                const videoElement = document.getElementById('recordedVideoPreview');
                videoElement.src = URL.createObjectURL(window.recordedVideoBlob);
                videoElement.muted = false; // Ensure audio is not muted
                videoElement.volume = 1.0;  // Set full volume
                
                // Change the submit button text and enable it
                const submitBtn = document.getElementById('submitBtn');
                submitBtn.innerHTML = '<i class="fas fa-paper-plane mr-2"></i>Submit KYC Application';
                submitBtn.className = 'px-6 py-3 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 transition duration-200';
                
                // Update step validation to include video
                updateNextButton();
            }
            
            function showSuccessModal() {
                const successModal = document.createElement('div');
                successModal.className = 'fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center';
                successModal.style.zIndex = '100000';
                successModal.innerHTML = `
                    <div class="bg-white dark:bg-gray-800 rounded-lg p-8 max-w-md w-full mx-4 text-center">
                        <div class="mb-6">
                            <div class="w-16 h-16 bg-green-100 dark:bg-green-900 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-check text-3xl text-green-600 dark:text-green-400"></i>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">KYC Submitted Successfully!</h3>
                            <p class="text-gray-600 dark:text-gray-300 mb-4">
                                Your identity verification documents have been submitted and are now under review.
                            </p>
                            <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4 mb-6">
                                <div class="flex items-center justify-center mb-2">
                                    <i class="fas fa-clock text-blue-600 dark:text-blue-400 mr-2"></i>
                                    <span class="font-semibold text-blue-800 dark:text-blue-200">Review Timeline</span>
                                </div>
                                <p class="text-sm text-blue-700 dark:text-blue-300">
                                    Our verification team will review your submission within <strong>2-3 business days</strong>. You will be notified via email once the review is completed.
                                </p>
                            </div>
                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                Redirecting in <span id="redirectCountdown" class="font-semibold text-indigo-600 dark:text-indigo-400">3</span> seconds...
                            </div>
                        </div>
                    </div>
                `;
                
                document.body.appendChild(successModal);
                
                // Auto-redirect countdown
                let countdown = 3;
                const countdownElement = document.getElementById('redirectCountdown');
                
                const countdownInterval = setInterval(() => {
                    countdown--;
                    countdownElement.textContent = countdown;
                    
                    if (countdown <= 0) {
                        clearInterval(countdownInterval);
                        redirectToKycIndex();
                    }
                }, 1000);
                
                // Prevent modal from closing by clicking outside
                successModal.addEventListener('click', function(e) {
                    e.stopPropagation();
                });
            }
            
            function redirectToKycIndex() {
                window.location.href = '{{ route("settings.kyc") }}';
            }

            function submitKycForm() {
                const originalText = submitBtn.innerHTML;

                // Show loading state
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Submitting...';
                submitBtn.disabled = true;

                const formData = new FormData();
                
                // Add CSRF token
                formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);
                
                // Add all form fields manually
                formData.append('first_name', document.querySelector('input[name="first_name"]').value);
                formData.append('last_name', document.querySelector('input[name="last_name"]').value);
                formData.append('date_of_birth', document.querySelector('input[name="date_of_birth"]').value);
                formData.append('phone', document.querySelector('input[name="phone"]').value);
                formData.append('street_address', document.querySelector('input[name="street_address"]').value);
                formData.append('city', document.querySelector('input[name="city"]').value);
                formData.append('state', document.querySelector('input[name="state"]').value);
                formData.append('postal_code', document.querySelector('input[name="postal_code"]').value);
                formData.append('country', document.querySelector('input[name="country"]').value);
                formData.append('utility_type', document.querySelector('select[name="utility_type"]').value);
                formData.append('id_type', document.querySelector('select[name="id_type"]').value);
                formData.append('id_number', document.querySelector('input[name="id_number"]').value);
                
                // Add file uploads
                const utilityBill = document.querySelector('input[name="utility_bill"]').files[0];
                const idDocument = document.querySelector('input[name="id_document"]').files[0];
                
                if (utilityBill) formData.append('utility_bill', utilityBill);
                if (idDocument) formData.append('id_document', idDocument);
                
                // Add the recorded video
                if (window.recordedVideoBlob) {
                    formData.append('selfie_video', window.recordedVideoBlob, 'selfie_video.webm');
                }

                fetch('{{ route("settings.kyc.store") }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Clear step tracking and address saved flag on successful submission
                        localStorage.removeItem('kyc_current_step');
                        localStorage.removeItem('kyc_address_saved');
                        showSuccessModal();
                    } else {
                        alert('Error: ' + (data.message || 'Something went wrong'));
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while submitting your KYC application. Please try again.');
                })
                .finally(() => {
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                });
            }

            // Initialize with step 1
            showStep(currentStep);

            // Save Address Button Handler
            document.getElementById('saveAddressBtn').addEventListener('click', function() {
                const button = this;
                const originalText = button.innerHTML;
                
                // Show loading state
                button.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Saving...';
                button.disabled = true;
                
                const addressData = {
                    country: document.querySelector('input[name="country"]').value,
                    state: document.querySelector('input[name="state"]').value,
                    city: document.querySelector('input[name="city"]').value,
                    postal_code: document.querySelector('input[name="postal_code"]').value,
                    address: document.querySelector('input[name="street_address"]').value
                };
                
                fetch('{{ route("user.update-address") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(addressData)
                })
                .then(response => response.ok ? response.json() : Promise.reject('Network response was not ok'))
                .then(data => {
                    if (data.success) {
                        // Mark address as saved
                        localStorage.setItem('kyc_address_saved', 'true');
                        
                        // Show success message
                        const successDiv = document.createElement('div');
                        successDiv.className = 'mt-2 p-2 bg-green-100 border border-green-400 text-green-700 rounded text-sm';
                        successDiv.innerHTML = '<i class="fas fa-check mr-2"></i>Address saved successfully!';
                        button.parentNode.appendChild(successDiv);
                        
                        // Update next button state
                        updateNextButton();
                        
                        // Remove success message after 3 seconds
                        setTimeout(() => {
                            successDiv.remove();
                        }, 3000);
                    } else {
                        throw new Error(data.message || 'Failed to save address');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error: ' + (error.message || 'An error occurred while saving the address.'));
                })
                .finally(() => {
                    button.innerHTML = originalText;
                    button.disabled = false;
                });
            });

            // Monitor all step fields for validation
            const allFields = document.querySelectorAll('#kycForm input, #kycForm select');
            allFields.forEach(field => {
                field.addEventListener('input', function() {
                    // Clear address saved flag when address fields change
                    if (field.name === 'street_address' || field.name === 'city' || field.name === 'state' || field.name === 'postal_code' || field.name === 'country') {
                        localStorage.removeItem('kyc_address_saved');
                    }
                    updateNextButton();
                });
                field.addEventListener('change', function() {
                    // Clear address saved flag when address fields change
                    if (field.name === 'street_address' || field.name === 'city' || field.name === 'state' || field.name === 'postal_code' || field.name === 'country') {
                        localStorage.removeItem('kyc_address_saved');
                    }
                    updateNextButton();
                });
            });
            
            // Special monitoring for Step 4 file upload
            const idDocumentInput = document.querySelector('input[name="id_document"]');
            if (idDocumentInput) {
                idDocumentInput.addEventListener('change', function() {
                    if (currentStep === 4) {
                        updateNextButton();
                    }
                });
            }
            
            // Force update submit button when on step 4
            function forceUpdateStep4Button() {
                if (currentStep === 4) {
                    const isValid = validateStep4();
                    updateSubmitButton(isValid);
                }
            }
            
            // Call force update when showing step 4
            const originalShowStep = showStep;
            showStep = function(step) {
                originalShowStep(step);
                if (step === 4) {
                    setTimeout(forceUpdateStep4Button, 100);
                }
            };
        });
    </script>
    @endpush
</x-app-layout>
