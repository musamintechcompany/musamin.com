<x-guest1-layout>
    <div class="flex items-center justify-center min-h-screen p-4 transition-colors duration-200 bg-gray-50 dark:bg-gray-900">
        <div class="w-full max-w-sm overflow-hidden transition-all duration-200 transform -translate-y-5 bg-white shadow-lg dark:bg-gray-800 rounded-xl sm:translate-y-0 sm:hover:scale-105">
            <div class="p-5 text-center sm:p-6">
                <h2 class="mb-2 text-xl font-bold text-gray-900 sm:text-2xl dark:text-white">Affiliate Network</h2>
                <p class="mb-4 text-sm text-gray-600 dark:text-gray-300 sm:text-base">Join thousands promoting top digital products.</p>

                <div class="mb-4 text-2xl font-bold text-gray-900 sm:text-3xl dark:text-white">
                    $2<span class="text-sm font-normal text-gray-500 sm:text-base dark:text-gray-400">/year</span>
                </div>

                <div class="p-3 mb-5 border rounded-lg bg-amber-50 dark:bg-amber-900/20 border-amber-200 dark:border-amber-700 sm:p-4">
                    <div class="flex items-center justify-center mb-3">
                        <svg class="w-5 h-5 mr-2 sm:w-6 sm:h-6 text-amber-500" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        <span class="text-base font-semibold text-gray-900 sm:text-lg dark:text-white">Coin Conversion</span>
                    </div>
                    <div class="flex justify-between mb-2 text-sm sm:text-base">
                        <span class="text-gray-600 dark:text-gray-300">USD Amount:</span>
                        <span class="font-medium text-gray-900 dark:text-white">$2.00</span>
                    </div>
                    <div class="flex justify-between mb-3 text-sm sm:text-base">
                        <span class="text-gray-600 dark:text-gray-300">Exchange Rate:</span>
                        <span class="font-medium text-gray-900 dark:text-white">1 USD = 100 coins</span>
                    </div>
                    <div class="flex justify-between pt-3 text-sm border-t border-amber-200 dark:border-amber-700 sm:text-base">
                        <span class="font-semibold text-gray-900 dark:text-white">Total Cost:</span>
                        <span class="text-lg font-bold text-amber-600 dark:text-amber-400">200 coins/year</span>
                    </div>
                </div>

                <button id="joinButton" class="w-full px-4 py-3 mb-4 text-base font-semibold text-white transition-opacity duration-200 rounded-lg bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 hover:opacity-90 sm:text-lg">
                    Join Now for 200 coins
                </button>

                <p class="text-xs text-gray-500 sm:text-sm dark:text-gray-400">
                    <svg class="inline w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
                    </svg>
                    Secure yearly subscription
                </p>
            </div>
        </div>
    </div>

    <!-- Confirmation Modal -->
    <div id="confirmationModal" class="fixed inset-0 z-50 flex items-center justify-center transition-opacity duration-300 bg-black bg-opacity-50 opacity-0 pointer-events-none backdrop-blur-sm">
        <div class="w-full max-w-xs p-6 mx-4 transition-all duration-300 transform scale-95 bg-white rounded-lg shadow-xl dark:bg-gray-800">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Confirm Payment</h3>
                <button id="closeModal" class="text-gray-500 hover:text-gray-700 dark:hover:text-gray-300">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <p class="mb-6 text-gray-700 dark:text-gray-300">You're about to be debited 200 coins from your Spending Wallet.</p>
            <div class="flex space-x-4">
                <button id="cancelButton" class="flex-1 px-4 py-2 text-gray-800 transition-colors duration-200 bg-gray-200 rounded-md dark:bg-gray-700 dark:text-white hover:bg-gray-300 dark:hover:bg-gray-600">
                    Cancel
                </button>
                <button id="proceedButton" class="flex-1 px-4 py-2 text-white transition-opacity duration-200 rounded-md bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 hover:opacity-90">
                    Proceed
                </button>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Theme system using local storage
            function initializeTheme() {
                const savedTheme = localStorage.getItem('theme');
                const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                
                if (savedTheme) {
                    applyTheme(savedTheme);
                } else if (prefersDark) {
                    applyTheme('dark');
                } else {
                    applyTheme('light');
                }
            }

            function applyTheme(theme) {
                const html = document.documentElement;
                html.classList.remove('light', 'dark');
                html.classList.add(theme);
                localStorage.setItem('theme', theme);
            }

            initializeTheme();

            // Modal functionality
            const joinButton = document.getElementById('joinButton');
            const confirmationModal = document.getElementById('confirmationModal');
            const closeModal = document.getElementById('closeModal');
            const cancelButton = document.getElementById('cancelButton');
            const proceedButton = document.getElementById('proceedButton');

            function openModal() {
                confirmationModal.classList.remove('opacity-0', 'pointer-events-none');
                confirmationModal.classList.add('opacity-100', 'pointer-events-auto');
                confirmationModal.querySelector('.transform').classList.remove('scale-95');
                confirmationModal.querySelector('.transform').classList.add('scale-100');
                document.body.style.overflow = 'hidden';
            }

            function closeModalFunc() {
                confirmationModal.classList.remove('opacity-100', 'pointer-events-auto');
                confirmationModal.classList.add('opacity-0', 'pointer-events-none');
                confirmationModal.querySelector('.transform').classList.remove('scale-100');
                confirmationModal.querySelector('.transform').classList.add('scale-95');
                document.body.style.overflow = '';
            }

            joinButton.addEventListener('click', openModal);
            closeModal.addEventListener('click', closeModalFunc);
            cancelButton.addEventListener('click', closeModalFunc);

            proceedButton.addEventListener('click', function() {
                closeModalFunc();
                alert('Payment successful! 200 coins have been deducted from your Spending Wallet.');
            });

            confirmationModal.addEventListener('click', function(e) {
                if (e.target === confirmationModal) {
                    closeModalFunc();
                }
            });

            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && !confirmationModal.classList.contains('opacity-0')) {
                    closeModalFunc();
                }
            });
        });
    </script>
</x-guest1-layout>