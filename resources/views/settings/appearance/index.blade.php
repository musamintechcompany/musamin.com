<x-app-layout>
    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700">
                    <h2 class="mb-6 text-2xl font-semibold text-gray-800 dark:text-gray-200">Appearance</h2>

                    <div class="space-y-4">
                        <!-- Light Theme Option -->
                        <div id="lightOption" onclick="selectTheme('light')" 
                             class="flex items-center justify-between p-4 rounded-lg cursor-pointer border-2 bg-gray-50 dark:bg-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600">
                            <div class="flex items-center">
                                <span class="text-lg font-medium text-gray-900 dark:text-gray-100">Light</span>
                            </div>
                            <div id="lightCheck" class="w-5 h-5 rounded-full border-2 border-gray-400"></div>
                        </div>

                        <!-- Dark Theme Option -->
                        <div id="darkOption" onclick="selectTheme('dark')" 
                             class="flex items-center justify-between p-4 rounded-lg cursor-pointer border-2 bg-gray-50 dark:bg-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600">
                            <div class="flex items-center">
                                <span class="text-lg font-medium text-gray-900 dark:text-gray-100">Dark</span>
                            </div>
                            <div id="darkCheck" class="w-5 h-5 rounded-full border-2 border-gray-400"></div>
                        </div>

                        <!-- Save Changes Button -->
                        <div class="pt-4">
                            <button id="saveButton" onclick="saveTheme()" 
                                    class="w-full px-4 py-3 text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <i id="saveLoadingIcon" class="fas fa-spinner fa-spin hidden mr-2"></i>
                                <span id="saveBtnText">Save Changes</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let selectedTheme = '{{ auth()->user()->theme }}';
        
        function selectTheme(theme) {
            selectedTheme = theme;
            
            // Update visual selection
            updateSelection();
            
            // Apply theme immediately for preview
            if (theme === 'dark') {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        }
        
        function updateSelection() {
            const lightCheck = document.getElementById('lightCheck');
            const darkCheck = document.getElementById('darkCheck');
            const lightOption = document.getElementById('lightOption');
            const darkOption = document.getElementById('darkOption');
            
            // Reset all
            lightCheck.classList.remove('bg-blue-600', 'border-blue-600');
            darkCheck.classList.remove('bg-blue-600', 'border-blue-600');
            lightOption.classList.remove('border-blue-500');
            darkOption.classList.remove('border-blue-500');
            
            // Apply selection
            if (selectedTheme === 'light') {
                lightCheck.classList.add('bg-blue-600', 'border-blue-600');
                lightOption.classList.add('border-blue-500');
            } else {
                darkCheck.classList.add('bg-blue-600', 'border-blue-600');
                darkOption.classList.add('border-blue-500');
            }
        }
        
        function saveTheme() {
            const saveButton = document.getElementById('saveButton');
            const loadingIcon = document.getElementById('saveLoadingIcon');
            const btnText = document.getElementById('saveBtnText');
            
            // Show loading state
            loadingIcon.classList.remove('hidden');
            btnText.textContent = 'Saving...';
            saveButton.disabled = true;
            
            fetch('{{ route("user.theme.update") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ theme: selectedTheme })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    btnText.textContent = 'Saved!';
                    localStorage.setItem('theme', selectedTheme);
                    setTimeout(() => {
                        location.reload();
                    }, 1000);
                } else {
                    btnText.textContent = 'Error';
                    setTimeout(() => {
                        btnText.textContent = 'Save Changes';
                        saveButton.disabled = false;
                    }, 2000);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                btnText.textContent = 'Error';
                setTimeout(() => {
                    btnText.textContent = 'Save Changes';
                    saveButton.disabled = false;
                }, 2000);
            })
            .finally(() => {
                loadingIcon.classList.add('hidden');
            });
        }
        
        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            updateSelection();
        });
    </script>
</x-app-layout>