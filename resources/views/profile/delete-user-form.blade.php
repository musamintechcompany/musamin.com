<div>
        <div class="max-w-xl text-sm text-gray-600 dark:text-gray-400">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </div>

        <div class="mt-5">
            <x-danger-button type="button" id="deleteAccountBtn">
                {{ __('Delete Account') }}
            </x-danger-button>
        </div>

        <!-- Delete Account Confirmation Modal -->
        <div id="deleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden items-center justify-center z-50">
            <div class="bg-white dark:bg-gray-800 rounded-lg p-6 max-w-md w-full mx-4">
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Delete Account</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">Are you sure you want to delete your account? This action cannot be undone. Please enter your password to confirm.</p>
                
                <div class="mb-4">
                    <x-input type="password" id="deletePassword" placeholder="Password" class="w-full" />
                </div>
                
                <div class="flex justify-end space-x-3">
                    <x-secondary-button id="cancelDeleteBtn">Cancel</x-secondary-button>
                    <x-danger-button id="confirmDeleteBtn">Delete Account</x-danger-button>
                </div>
            </div>
        </div>

        <script>
        document.addEventListener('DOMContentLoaded', function() {
            const deleteBtn = document.getElementById('deleteAccountBtn');
            const modal = document.getElementById('deleteModal');
            const cancelBtn = document.getElementById('cancelDeleteBtn');
            const confirmBtn = document.getElementById('confirmDeleteBtn');
            const passwordInput = document.getElementById('deletePassword');
            
            deleteBtn.addEventListener('click', function() {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
                passwordInput.focus();
            });
            
            cancelBtn.addEventListener('click', function() {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                passwordInput.value = '';
            });
            
            confirmBtn.addEventListener('click', function() {
                const password = passwordInput.value;
                if (!password) {
                    alert('Please enter your password');
                    return;
                }
                
                if (!confirm('This will permanently delete your account. Are you absolutely sure?')) {
                    return;
                }
                
                confirmBtn.disabled = true;
                confirmBtn.textContent = 'Deleting...';
                
                fetch('{{ route("delete-account") }}', {
                    method: 'DELETE',
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
                        window.location.href = '/';
                    } else {
                        alert(data.message);
                        confirmBtn.disabled = false;
                        confirmBtn.textContent = 'Delete Account';
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error deleting account');
                    confirmBtn.disabled = false;
                    confirmBtn.textContent = 'Delete Account';
                });
            });
        });
        </script>
</div>
