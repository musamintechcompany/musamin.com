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
                    <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200">Withdrawal Details</h2>
                </div>
                <button onclick="showAddAccountModal()" class="inline-flex items-center px-4 py-2 text-white transition duration-200 bg-indigo-600 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <i class="mr-2 fas fa-plus"></i>
                    Add Account
                </button>
            </div>

            <!-- Accounts List -->
            <div id="accountsList" class="space-y-4">
                <!-- Accounts will be loaded here -->
            </div>

            <!-- Empty State -->
            <div id="emptyState" class="py-8 text-center" style="display: none;">
                <div class="flex items-center justify-center w-16 h-16 mx-auto mb-4 bg-gray-200 rounded-full dark:bg-gray-700">
                    <i class="text-2xl text-gray-400 fas fa-university"></i>
                </div>
                <h3 class="mb-2 text-lg font-medium text-gray-900 dark:text-gray-100">No Payment Methods Added</h3>
                <p class="mb-4 text-gray-600 dark:text-gray-300">Add your payment methods for withdrawals</p>
                <button onclick="showAddAccountModal()" class="inline-flex items-center px-4 py-2 text-white transition duration-200 bg-indigo-600 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <i class="mr-2 fas fa-plus"></i>
                    Add Account
                </button>
            </div>
        </div>
    </div>

    <!-- Add Account Modal -->
    <div id="addAccountModal" class="fixed inset-0 items-center justify-center hidden p-4 bg-black bg-opacity-50" style="z-index: 9999999;">
        <div class="w-full max-w-md bg-white rounded-lg shadow-xl dark:bg-gray-800">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Add Payment Method</h3>
                    <button onclick="hideAddAccountModal()" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                
                <!-- Step 1: Payment Method Name -->
                <div id="step1" class="space-y-4">
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Payment Method Name</label>
                        <input type="text" id="paymentMethodName" placeholder="e.g., Chase Bank, PayPal, Wise" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-600 dark:border-gray-500 dark:text-white">
                    </div>
                    <div class="flex justify-end pt-4">
                        <button onclick="goToStep2()" class="px-4 py-2 text-white bg-indigo-600 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            Next
                        </button>
                    </div>
                </div>

                <!-- Step 2: Payment Method Details -->
                <div id="step2" class="space-y-4" style="display: none;">
                    <div class="mb-4">
                        <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300">Adding details for: <span id="selectedMethodName" class="text-indigo-600"></span></h4>
                    </div>
                    
                    <div id="credentialFields" class="space-y-3">
                        <!-- Dynamic fields will be added here -->
                    </div>
                    
                    <button type="button" onclick="addCredentialField()" class="inline-flex items-center px-3 py-2 text-sm text-indigo-600 border border-indigo-600 rounded-md hover:bg-indigo-50 dark:hover:bg-indigo-900">
                        <i class="mr-2 fas fa-plus"></i>
                        Add Field
                    </button>
                    
                    <div class="flex justify-between pt-4">
                        <button onclick="goToStep1()" class="px-4 py-2 text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200 dark:text-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600">
                            Back
                        </button>
                        <button onclick="saveAccount()" class="px-4 py-2 text-white bg-indigo-600 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500" id="saveButton">
                            <i id="saveIcon" class="mr-2 fas fa-save"></i>
                            <span id="saveText">Save Account</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Toast Notification -->
    <div id="toast" class="fixed top-4 right-4 z-50 hidden">
        <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-lg p-4 min-w-80">
            <div class="flex items-center">
                <div id="toast-icon" class="flex-shrink-0 mr-3"></div>
                <div class="flex-1">
                    <p id="toast-message" class="text-sm font-medium text-gray-900 dark:text-gray-100"></p>
                </div>
                <button onclick="hideToast()" class="ml-3 text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    </div>

    <script>
        let credentialIndex = 0;
        let accounts = @json(auth()->user()->withdrawalDetails->map(function($detail) {
            return [
                'method_name' => $detail->method_name,
                'credentials' => $detail->credentials
            ];
        }) ?? []);

        document.addEventListener('DOMContentLoaded', function() {
            loadAccounts();
        });

        function loadAccounts() {
            const container = document.getElementById('accountsList');
            const emptyState = document.getElementById('emptyState');
            
            if (!accounts || accounts.length === 0) {
                emptyState.style.display = 'block';
                return;
            }
            
            emptyState.style.display = 'none';
            
            const accountsHtml = accounts.map((account, index) => `
                <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                    <div class="cursor-pointer px-4 py-5 sm:p-6 border-b border-gray-200 dark:border-gray-700" onclick="toggleAccount(${index})">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <i class="mr-3 text-indigo-600 fas fa-university"></i>
                                <div>
                                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">${account.method_name}</h3>
                                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">${account.credentials.length} credential(s) saved</p>
                                </div>
                            </div>
                            <i id="account-${index}-arrow" class="fas fa-chevron-right text-gray-400 transition-transform duration-200"></i>
                        </div>
                    </div>
                    <div id="account-${index}-content" class="hidden px-4 py-5 sm:p-6">
                        <div class="space-y-3">
                            ${account.credentials.map(cred => `
                                <div class="flex justify-between py-2 border-b border-gray-200 dark:border-gray-600">
                                    <span class="font-medium text-gray-700 dark:text-gray-300">${cred.name}:</span>
                                    <span class="text-gray-900 dark:text-gray-100">${cred.value}</span>
                                </div>
                            `).join('')}
                        </div>
                        <div class="flex justify-end space-x-3 mt-4 pt-4 border-t border-gray-200 dark:border-gray-600">
                            <button onclick="editAccount(${index})" class="px-4 py-2 text-indigo-600 bg-indigo-50 rounded-md hover:bg-indigo-100 dark:bg-indigo-900 dark:hover:bg-indigo-800">
                                <i class="mr-2 fas fa-edit"></i>
                                Edit
                            </button>
                            <button onclick="deleteAccount(${index})" class="px-4 py-2 text-red-600 bg-red-50 rounded-md hover:bg-red-100 dark:bg-red-900 dark:hover:bg-red-800">
                                <i class="mr-2 fas fa-trash"></i>
                                Delete
                            </button>
                        </div>
                    </div>
                </div>
            `).join('');
            
            container.innerHTML = accountsHtml;
        }

        function showAddAccountModal() {
            document.getElementById('addAccountModal').classList.remove('hidden');
            document.getElementById('addAccountModal').classList.add('flex');
            goToStep1();
        }

        function hideAddAccountModal() {
            document.getElementById('addAccountModal').classList.add('hidden');
            document.getElementById('addAccountModal').classList.remove('flex');
            document.getElementById('paymentMethodName').value = '';
            document.getElementById('credentialFields').innerHTML = '';
            credentialIndex = 0;
            editingIndex = -1;
            
            // Reset modal title and button text
            document.querySelector('#addAccountModal h3').textContent = 'Add Payment Method';
            document.getElementById('saveText').textContent = 'Save Account';
            document.getElementById('saveIcon').className = 'mr-2 fas fa-save';
        }

        function goToStep1() {
            document.getElementById('step1').style.display = 'block';
            document.getElementById('step2').style.display = 'none';
        }

        function goToStep2() {
            const methodName = document.getElementById('paymentMethodName').value.trim();
            if (!methodName) {
                alert('Please enter a payment method name');
                return;
            }
            
            document.getElementById('selectedMethodName').textContent = methodName;
            document.getElementById('step1').style.display = 'none';
            document.getElementById('step2').style.display = 'block';
            
            // Add one field by default
            if (document.getElementById('credentialFields').children.length === 0) {
                addCredentialField();
            }
        }

        function addCredentialField(name = '', value = '') {
            const container = document.getElementById('credentialFields');
            const fieldHtml = `
                <div class="flex items-center space-x-3 credential-row" data-index="${credentialIndex}">
                    <div class="flex-1">
                        <input type="text" placeholder="Field name (e.g., Account Number)" value="${name}" class="credential-name w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-600 dark:border-gray-500 dark:text-white">
                    </div>
                    <div class="flex-1">
                        <input type="text" placeholder="Value" value="${value}" class="credential-value w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-600 dark:border-gray-500 dark:text-white">
                    </div>
                    <button type="button" onclick="removeCredentialField(${credentialIndex})" class="p-2 text-red-600 hover:text-red-800">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', fieldHtml);
            credentialIndex++;
        }

        function removeCredentialField(index) {
            const fieldRow = document.querySelector(`[data-index="${index}"]`);
            if (fieldRow) {
                fieldRow.remove();
            }
        }

        function saveAccount() {
            const methodName = document.getElementById('paymentMethodName').value.trim();
            const credentialRows = document.querySelectorAll('.credential-row');
            
            if (!methodName) {
                alert('Please enter a payment method name');
                return;
            }
            
            const credentials = [];
            credentialRows.forEach(row => {
                const name = row.querySelector('.credential-name').value.trim();
                const value = row.querySelector('.credential-value').value.trim();
                if (name && value) {
                    credentials.push({ name, value });
                }
            });
            
            if (credentials.length === 0) {
                alert('Please add at least one credential');
                return;
            }
            
            // Show loading state
            const saveButton = document.getElementById('saveButton');
            const saveIcon = document.getElementById('saveIcon');
            const saveText = document.getElementById('saveText');
            
            saveButton.disabled = true;
            saveIcon.className = 'mr-2 fas fa-spinner fa-spin';
            saveText.textContent = editingIndex >= 0 ? 'Updating...' : 'Saving...';
            
            const accountData = {
                method_name: methodName,
                credentials: credentials
            };
            
            if (editingIndex >= 0) {
                // Update existing account
                accounts[editingIndex] = accountData;
            } else {
                // Add new account
                accounts.push(accountData);
            }
            
            // Save to server
            fetch('{{ route("settings.withdrawal-bank.update") }}', {
                method: 'POST',
                body: JSON.stringify({ details: accounts }),
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    hideAddAccountModal();
                    loadAccounts();
                    showToast(editingIndex >= 0 ? 'Credentials updated successfully!' : 'Payment method added successfully!', 'success');
                } else {
                    showToast(data.message || (editingIndex >= 0 ? 'Error updating credentials' : 'Error adding payment method'), 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('Something went wrong. Please try again.', 'error');
            })
            .finally(() => {
                // Reset button state
                saveButton.disabled = false;
                saveIcon.className = 'mr-2 fas fa-save';
                saveText.textContent = editingIndex >= 0 ? 'Update Account' : 'Save Account';
            });
        }

        function toggleAccount(index) {
            const content = document.getElementById(`account-${index}-content`);
            const arrow = document.getElementById(`account-${index}-arrow`);
            
            if (content.classList.contains('hidden')) {
                content.classList.remove('hidden');
                arrow.classList.add('rotate-90');
            } else {
                content.classList.add('hidden');
                arrow.classList.remove('rotate-90');
            }
        }

        let editingIndex = -1;

        function editAccount(index) {
            editingIndex = index;
            const account = accounts[index];
            
            // Populate the modal with existing data
            document.getElementById('paymentMethodName').value = account.method_name;
            document.getElementById('selectedMethodName').textContent = account.method_name;
            
            // Clear existing credential fields
            document.getElementById('credentialFields').innerHTML = '';
            credentialIndex = 0;
            
            // Add existing credentials to the modal
            account.credentials.forEach(cred => {
                addCredentialField(cred.name, cred.value);
            });
            
            // Change modal title and button text
            document.querySelector('#addAccountModal h3').textContent = 'Edit Payment Method';
            document.getElementById('saveText').textContent = 'Update Account';
            
            // Show modal and go to step 2
            showAddAccountModal();
            goToStep2();
        }

        function deleteAccount(index) {
            const account = accounts[index];
            showDeleteConfirmation(account.method_name, () => {
                accounts.splice(index, 1);
                
                // Save to server
                fetch('{{ route("settings.withdrawal-bank.update") }}', {
                    method: 'POST',
                    body: JSON.stringify({ details: accounts }),
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        loadAccounts();
                        showToast('Payment method deleted successfully!', 'success');
                    } else {
                        showToast(data.message || 'Error deleting payment method', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showToast('Something went wrong. Please try again.', 'error');
                });
            });
        }

        function showToast(message, type = 'success') {
            const toast = document.getElementById('toast');
            const icon = document.getElementById('toast-icon');
            const messageEl = document.getElementById('toast-message');
            
            messageEl.textContent = message;
            
            if (type === 'success') {
                icon.innerHTML = '<i class="fas fa-check-circle text-green-500"></i>';
            } else {
                icon.innerHTML = '<i class="fas fa-exclamation-circle text-red-500"></i>';
            }
            
            toast.classList.remove('hidden');
            
            // Auto hide after 4 seconds
            setTimeout(() => {
                hideToast();
            }, 4000);
        }

        function hideToast() {
            document.getElementById('toast').classList.add('hidden');
        }

        function showDeleteConfirmation(methodName, onConfirm) {
            const confirmed = confirm(`Are you sure you want to delete "${methodName}"?\n\nThis action cannot be undone.`);
            if (confirmed) {
                onConfirm();
            }
        }
    </script>
</x-app-layout>