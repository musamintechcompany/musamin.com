<x-admin-layout title="Profile">
<div class="p-4 lg:p-6">
    <div class="space-y-4 overflow-hidden">
        <div class="flex flex-col sm:flex-row lg:justify-between lg:items-center gap-4">
            <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold text-gray-900">Profile</h1>
        </div>

        <div class="flex flex-col lg:flex-row gap-6 max-w-4xl">
            <!-- Admin Details -->
            <div class="flex-1">
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-3">Admin Details</h3>
                    
                    <div class="space-y-4">
                        <div class="flex items-center justify-between border-b border-gray-100 dark:border-gray-700 pb-2">
                            <span class="text-sm font-semibold text-gray-600 dark:text-gray-400">Name:</span>
                            <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $admin->name }}</span>
                        </div>

                        <div class="flex items-center justify-between border-b border-gray-100 dark:border-gray-700 pb-2">
                            <span class="text-sm font-semibold text-gray-600 dark:text-gray-400">Email:</span>
                            <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $admin->email }}</span>
                        </div>

                        <div class="flex items-center justify-between border-b border-gray-100 dark:border-gray-700 pb-2">
                            <span class="text-sm font-semibold text-gray-600 dark:text-gray-400">Status:</span>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ $admin->is_active ? 'bg-green-100 text-green-700 border border-green-200' : 'bg-red-100 text-red-700 border border-red-200' }}">
                                {{ $admin->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </div>

                        <div class="flex items-center justify-between">
                            <span class="text-sm font-semibold text-gray-600 dark:text-gray-400">Joined:</span>
                            <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $admin->created_at->format('M d, Y') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Theme Settings -->
            <div class="w-full lg:w-80">
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-3">Appearance</h3>
                    
                    <!-- Theme Section -->
                    <div class="mb-4">
                        <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Theme</h4>
                        <div class="flex gap-4">
                            <div>
                                <label class="flex items-center cursor-pointer">
                                    <input type="radio" name="theme" value="light" id="lightRadio"
                                           {{ ($admin->theme ?? 'light') === 'light' ? 'checked' : '' }}
                                           onchange="updateTheme()"
                                           class="rounded border-gray-300 text-yellow-500 focus:ring-yellow-500 mr-2">
                                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Light</span>
                                </label>
                            </div>
                            <div>
                                <label class="flex items-center cursor-pointer">
                                    <input type="radio" name="theme" value="dark" id="darkRadio"
                                           {{ ($admin->theme ?? 'light') === 'dark' ? 'checked' : '' }}
                                           onchange="updateTheme()"
                                           class="rounded border-gray-300 text-gray-800 focus:ring-gray-500 mr-2">
                                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Dark</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Save Changes Button -->
                    <div>
                        <button id="saveButton" onclick="saveTheme()" 
                                class="px-4 py-2 text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 flex items-center">
                            <span id="saveText">Save Changes</span>
                            <svg id="saveSpinner" class="animate-spin ml-2 h-4 w-4 text-white hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    let selectedTheme = '{{ $admin->theme ?? "light" }}';
    
    function updateTheme() {
        // Get selected theme
        const themeRadios = document.querySelectorAll('input[name="theme"]');
        
        themeRadios.forEach(radio => {
            if (radio.checked) selectedTheme = radio.value;
        });
        
        // Apply theme immediately for preview
        applyThemePreview(selectedTheme);
    }
    
    function applyThemePreview(theme) {
        if (theme === 'dark') {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    }
    
    function saveTheme() {
        // Show spinner
        document.getElementById('saveText').textContent = 'Saving...';
        document.getElementById('saveSpinner').classList.remove('hidden');
        document.getElementById('saveButton').disabled = true;
        
        fetch('{{ route("admin.profile.theme.update") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ 
                theme: selectedTheme
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                localStorage.setItem('admin-theme', selectedTheme);
                location.reload();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            // Hide spinner on error
            document.getElementById('saveText').textContent = 'Save Changes';
            document.getElementById('saveSpinner').classList.add('hidden');
            document.getElementById('saveButton').disabled = false;
        });
    }
</script>
</x-admin-layout>