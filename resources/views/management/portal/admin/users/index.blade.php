<x-admin-layout title="Users">
<div class="p-4 lg:p-6">
    <div class="space-y-4 overflow-hidden">
        <div class="flex flex-col sm:flex-row lg:justify-between lg:items-center gap-4">
            <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold text-gray-900">Users</h1>
            @if(auth('admin')->user()->can('create-users'))
            <a href="{{ route('admin.users.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 lg:px-6 lg:py-3 rounded-lg text-center transition-colors">
                <i class="fas fa-plus mr-2"></i>Create User
            </a>
            @endif
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <!-- User Stats Widgets -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <x-widgets.admin.users.total-users />
            <x-widgets.admin.users.active-users />
            <x-widgets.admin.users.new-users />
            <x-widgets.admin.users.total-affiliated-users />
        </div>

        <!-- Search and Controls -->
        <div class="flex items-center gap-4 mb-4">
        <!-- Search -->
        <div class="flex-1 min-w-0 max-w-md">
            <input type="text" id="searchInput" placeholder="Search by name, email, or ID..." class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm" value="{{ request('search') }}">
        </div>
        
        <!-- Filter Icon -->
        <div class="relative">
            <button id="filterButton" class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition-colors">
                <i class="fas fa-filter"></i>
            </button>
            <div id="filterDropdown" class="absolute top-full right-0 mt-1 w-80 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-lg z-50 hidden">
                <div class="p-4 space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status</label>
                        <select id="statusFilter" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                            <option value="">All Status</option>
                            <option value="pending">🟡 Pending</option>
                            <option value="active">🟢 Active</option>
                            <option value="warning">🟠 Warning</option>
                            <option value="hold">🔵 Hold</option>
                            <option value="suspended">🔴 Suspended</option>
                            <option value="blocked">⚫ Blocked</option>
                        </select>
                    </div>
                    <div>
                        <button id="resetFilters" class="w-full bg-gray-300 dark:bg-gray-600 text-gray-700 dark:text-gray-300 px-4 py-2 rounded-lg text-sm hover:bg-gray-400 dark:hover:bg-gray-500">Reset</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Column Visibility Icon -->
        <div class="relative">
            <button id="columnButton" class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition-colors">
                <i class="fas fa-columns"></i>
            </button>
            <div id="columnDropdown" class="absolute top-full right-0 mt-1 w-48 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-lg z-50 hidden">
                <div class="p-2">
                    <label class="flex items-center px-2 py-1 hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 rounded cursor-pointer">
                        <input type="checkbox" class="column-toggle mr-2" data-column="user" checked> User
                    </label>
                    <label class="flex items-center px-2 py-1 hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 rounded cursor-pointer">
                        <input type="checkbox" class="column-toggle mr-2" data-column="email" checked> Email
                    </label>
                    <label class="flex items-center px-2 py-1 hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 rounded cursor-pointer">
                        <input type="checkbox" class="column-toggle mr-2" data-column="status" checked> Status
                    </label>
                    <label class="flex items-center px-2 py-1 hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 rounded cursor-pointer">
                        <input type="checkbox" class="column-toggle mr-2" data-column="country"> Country
                    </label>
                    <label class="flex items-center px-2 py-1 hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 rounded cursor-pointer">
                        <input type="checkbox" class="column-toggle mr-2" data-column="coins"> Coins
                    </label>
                    <label class="flex items-center px-2 py-1 hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 rounded cursor-pointer">
                        <input type="checkbox" class="column-toggle mr-2" data-column="affiliate"> Affiliate
                    </label>
                    <label class="flex items-center px-2 py-1 hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 rounded cursor-pointer">
                        <input type="checkbox" class="column-toggle mr-2" data-column="theme"> Theme
                    </label>
                    <label class="flex items-center px-2 py-1 hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 rounded cursor-pointer">
                        <input type="checkbox" class="column-toggle mr-2" data-column="joined" checked> Joined
                    </label>
                    <label class="flex items-center px-2 py-1 hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 rounded cursor-pointer">
                        <input type="checkbox" class="column-toggle mr-2" data-column="actions" checked> Actions
                    </label>
                </div>
            </div>
        </div>
    </div>

    <div id="usersContainer">
        @include('management.portal.admin.users.partials.users-table')
    </div>

    <!-- Login as User Modal -->
    <div id="loginModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-[9999]">
        <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4">
            <div class="text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-green-100 mb-4">
                    <i class="fas fa-sign-in-alt text-green-600 text-xl"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Login as User</h3>
                <p class="text-sm text-gray-500 mb-6">Are you sure you want to login as <span id="modalUserName" class="font-semibold"></span>?</p>
                <div class="flex gap-3 justify-center">
                    <button id="cancelLogin" class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400 transition-colors">
                        No
                    </button>
                    <button id="confirmLogin" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition-colors">
                        Yes
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-[9999]">
        <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4">
            <div class="text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 mb-4">
                    <i class="fas fa-trash text-red-600 text-xl"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Delete User</h3>
                <p class="text-sm text-gray-500 mb-6">Are you sure you want to delete <span id="deleteUserName" class="font-semibold"></span>? This action cannot be undone.</p>
                <div class="flex gap-3 justify-center">
                    <button id="cancelDelete" class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400 transition-colors">
                        Cancel
                    </button>
                    <button id="confirmDelete" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 transition-colors">
                        Delete
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        let searchTimeout;
        let currentStatus = '';

        // Real-time search
        document.getElementById('searchInput').addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(filterUsers, 300);
        });

        // Filter dropdown
        const filterButton = document.getElementById('filterButton');
        if (filterButton) {
            filterButton.addEventListener('click', function(e) {
                e.stopPropagation();
                const dropdown = document.getElementById('filterDropdown');
                const columnDropdown = document.getElementById('columnDropdown');
                if (dropdown) dropdown.classList.toggle('hidden');
                if (columnDropdown) columnDropdown.classList.add('hidden');
            });
        }

        // Status filter change
        document.getElementById('statusFilter').addEventListener('change', function() {
            currentStatus = this.value;
            filterUsers();
        });

        // Column dropdown
        document.getElementById('columnButton').addEventListener('click', function(e) {
            e.stopPropagation();
            document.getElementById('columnDropdown').classList.toggle('hidden');
            document.getElementById('filterDropdown').classList.add('hidden');
        });

        // Column toggles
        document.querySelectorAll('.column-toggle').forEach(toggle => {
            toggle.addEventListener('change', function(e) {
                e.stopPropagation();
                const column = this.dataset.column;
                const isVisible = this.checked;
                const elements = document.querySelectorAll(`[data-column="${column}"]`);
                elements.forEach(el => {
                    if (isVisible) {
                        el.classList.remove('hidden');
                        el.style.display = '';
                    } else {
                        el.classList.add('hidden');
                        el.style.display = 'none';
                    }
                });
            });
        });

        // Close dropdowns when clicking outside
        document.addEventListener('click', function(e) {
            if (!e.target.closest('#filterButton') && !e.target.closest('#filterDropdown')) {
                document.getElementById('filterDropdown').classList.add('hidden');
            }
            if (!e.target.closest('#columnButton') && !e.target.closest('#columnDropdown')) {
                document.getElementById('columnDropdown').classList.add('hidden');
            }
        });

        // Reset filters
        document.getElementById('resetFilters').addEventListener('click', function() {
            document.getElementById('searchInput').value = '';
            document.getElementById('statusFilter').value = '';
            currentStatus = '';
            filterUsers();
        });

        function filterUsers() {
            const params = new URLSearchParams({
                search: document.getElementById('searchInput').value,
                status: currentStatus
            });

            fetch('{{ route("admin.users.index") }}?' + params, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.text())
            .then(html => {
                document.getElementById('usersContainer').innerHTML = html;
            })
            .catch(error => console.error('Error:', error));
        }

        // Login as user modal functions
        let currentUserId = null;

        // Make function global so it works after AJAX table reload
        window.showLoginModal = function(userName, userId) {
            currentUserId = userId;
            document.getElementById('modalUserName').textContent = userName;
            document.getElementById('loginModal').classList.remove('hidden');
            document.getElementById('loginModal').classList.add('flex');
        }

        document.getElementById('cancelLogin').addEventListener('click', function() {
            document.getElementById('loginModal').classList.add('hidden');
            document.getElementById('loginModal').classList.remove('flex');
            currentUserId = null;
        });

        document.getElementById('confirmLogin').addEventListener('click', function() {
            if (currentUserId) {
                const button = this;
                button.disabled = true;
                button.textContent = 'Loading...';

                fetch('/management/portal/admin/users/' + currentUserId + '/login-as', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        return response.text().then(text => {
                            throw new Error(`HTTP ${response.status}: ${text}`);
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        // Open in new tab to preserve admin session
                        window.open(data.redirect_url, '_blank');
                        document.getElementById('loginModal').classList.add('hidden');
                        document.getElementById('loginModal').classList.remove('flex');
                        currentUserId = null;
                        

                    } else {
                        alert('Failed to login as user: ' + (data.message || 'Unknown error'));
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error: ' + error.message);
                })
                .finally(() => {
                    button.disabled = false;
                    button.textContent = 'Yes';
                });
            }
        });

        // Delete confirmation modal functions
        let deleteUrl = null;

        // Make function global so it works after AJAX table reload
        window.confirmDelete = function(userName, url) {
            deleteUrl = url;
            document.getElementById('deleteUserName').textContent = userName;
            document.getElementById('deleteModal').classList.remove('hidden');
            document.getElementById('deleteModal').classList.add('flex');
        }

        document.getElementById('cancelDelete').addEventListener('click', function() {
            document.getElementById('deleteModal').classList.add('hidden');
            document.getElementById('deleteModal').classList.remove('flex');
            deleteUrl = null;
        });

        document.getElementById('confirmDelete').addEventListener('click', function() {
            if (deleteUrl) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = deleteUrl;
                form.innerHTML = `
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="_method" value="DELETE">
                `;
                document.body.appendChild(form);
                form.submit();
            }
        });


    </script>


    </div>
</div>
</x-admin-layout>
