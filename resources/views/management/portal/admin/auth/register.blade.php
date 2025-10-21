<x-guest-layout>
    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="w-full max-w-sm space-y-4">
            <!-- Admin Logo -->
            <div class="flex justify-center">
                <div class="text-4xl font-bold text-gray-800 dark:text-white">
                    <i class="fas fa-user-shield text-primary-600"></i>
                    <span class="ml-2">Admin</span>
                </div>
            </div>

            <form method="POST" action="{{ route('admin.register.post') }}" id="adminRegisterForm" class="space-y-4">
                @csrf

                <!-- Error Toast -->
                <div id="errorToast" class="fixed z-50 hidden w-11/12 max-w-md py-2 text-sm text-center text-white transform -translate-x-1/2 bg-red-500 rounded shadow-lg top-4 left-1/2 dark:bg-red-700"></div>

                <!-- Title -->
                <h2 class="text-2xl font-bold text-center text-gray-800 dark:text-white">
                    Create Admin Account<br>
                    <span class="text-sm font-normal text-gray-600 dark:text-gray-400">Register a new admin for the portal</span>
                </h2>

                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Full Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}"
                           class="w-full px-3 py-2 mt-1 border rounded-md focus:outline-none focus:ring-2 focus:ring-primary-600 dark:bg-gray-800 dark:border-gray-700 dark:text-white" />
                    <span id="nameError" class="hidden text-sm text-red-500 dark:text-red-400">Please enter your full name</span>
                    @error('name') <span class="text-sm text-red-500 dark:text-red-400">{{ $message }}</span> @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Admin Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}"
                           class="w-full px-3 py-2 mt-1 border rounded-md focus:outline-none focus:ring-2 focus:ring-primary-600 dark:bg-gray-800 dark:border-gray-700 dark:text-white" />
                    <span id="emailError" class="hidden text-sm text-red-500 dark:text-red-400">Please enter a valid email</span>
                    <span id="emailExistsError" class="hidden text-sm text-red-500 dark:text-red-400">This email is already registered</span>
                    @error('email') <span class="text-sm text-red-500 dark:text-red-400">{{ $message }}</span> @enderror
                </div>

                <!-- Password -->
                <div class="relative">
                    <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Password</label>
                    <input type="password" name="password" id="password" minlength="8"
                           class="w-full px-3 py-2 pr-10 mt-1 border rounded-md focus:outline-none focus:ring-2 focus:ring-primary-600 dark:bg-gray-800 dark:border-gray-700 dark:text-white" />
                    <div class="absolute cursor-pointer top-9 right-3" onclick="window.togglePasswordVisibility('password')">
                        <svg id="passwordEye" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-gray-500 dark:text-gray-400">
                            <path id="passwordEyeOpen" stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                            <path id="passwordEyePupil" stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path id="passwordEyeClosed" stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" class="hidden" />
                        </svg>
                    </div>
                    <div id="passwordStrength" class="w-full h-1 mt-2 bg-gray-200 rounded dark:bg-gray-700">
                        <div class="h-full transition-all duration-300 bg-red-500 rounded" style="width: 0%"></div>
                    </div>
                    <span id="strengthText" class="text-sm mt-1"></span>
                    <span id="passwordError" class="hidden text-sm text-red-500 dark:text-red-400">Password must be at least 8 characters</span>
                </div>

                <!-- Confirm Password -->
                <div class="relative">
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Confirm Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation"
                           class="w-full px-3 py-2 pr-10 mt-1 border rounded-md focus:outline-none focus:ring-2 focus:ring-primary-600 dark:bg-gray-800 dark:border-gray-700 dark:text-white" />
                    <div class="absolute cursor-pointer top-9 right-3" onclick="window.togglePasswordVisibility('password_confirmation')">
                        <svg id="confirmPasswordEye" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-gray-500 dark:text-gray-400">
                            <path id="confirmPasswordEyeOpen" stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                            <path id="confirmPasswordEyePupil" stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path id="confirmPasswordEyeClosed" stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" class="hidden" />
                        </svg>
                    </div>
                    <span id="password_confirmationError" class="hidden text-sm text-red-500 dark:text-red-400">Passwords do not match</span>
                </div>

                <!-- Submit Button -->
                <button type="submit" id="registerBtn"
                        class="flex items-center justify-center w-full px-4 py-2 text-white transition rounded-md bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-600 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                    <svg id="spinner" class="hidden w-5 h-5 mr-2 text-white spinner" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                    </svg>
                    <span id="buttonText">Create Admin Account</span>
                </button>

                <!-- Already Registered -->
                <p class="mt-4 text-sm text-center text-gray-600 dark:text-gray-400">
                    Already have an admin account?
                    <a href="{{ route('admin.login') }}" class="text-primary-600 hover:underline dark:text-primary-400">Login</a>
                </p>
            </form>
        </div>
    </div>
</x-guest-layout>