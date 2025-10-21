<x-admin-layout title="Coin Manager">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Coin Manager</h1>
            <p class="text-gray-600 dark:text-gray-400">Credit or debit coins from user accounts</p>
        </div>

        <div class="bg-white dark:bg-gray-800 shadow-xl rounded-lg overflow-hidden">
            <form action="{{ route('admin.coin-manager.update-coins') }}" method="POST" class="p-6 space-y-6">
                @csrf
                
                <div>
                    <label for="userSearch" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Search User</label>
                    <input type="text" id="userSearch" placeholder="Type user name, email, or username..." 
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <div id="userResults" class="mt-2 max-h-40 overflow-y-auto border rounded-md hidden"></div>
                    <input type="hidden" name="user_id" id="selectedUserId" required>
                    <div id="selectedUserInfo" class="mt-2 hidden">
                        <div class="p-3 bg-blue-50 rounded-md">
                            <div class="font-medium" id="selectedUserName"></div>
                            <div class="text-sm text-gray-600" id="selectedUserEmail"></div>
                            <div class="text-sm font-medium text-blue-600">Current Coins: <span id="selectedUserCoins"></span></div>
                        </div>
                    </div>
                    @error('user_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Action</label>
                        <div class="mt-2 space-y-2">
                            <label class="flex items-center">
                                <input type="radio" name="action" value="credit" class="mr-2" required>
                                <span class="text-green-600">Credit (Add Coins)</span>
                            </label>
                            <label class="flex items-center">
                                <input type="radio" name="action" value="debit" class="mr-2" required>
                                <span class="text-red-600">Debit (Remove Coins)</span>
                            </label>
                        </div>
                        @error('action')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="amount" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Amount</label>
                        <input type="number" name="amount" id="amount" step="0.01" min="0.01" 
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        @error('amount')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="reason" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Reason</label>
                    <textarea name="reason" id="reason" rows="3" 
                              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" 
                              placeholder="Enter reason for this transaction..." required></textarea>
                    @error('reason')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg">
                        Update Coins
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('userSearch').addEventListener('input', function() {
            const query = this.value;
            if (query.length > 2) {
                fetch(`{{ route('admin.coin-manager.search-users') }}?q=${query}`)
                    .then(response => response.json())
                    .then(users => {
                        const results = document.getElementById('userResults');
                        results.innerHTML = '';
                        results.classList.remove('hidden');
                        
                        users.forEach(user => {
                            const div = document.createElement('div');
                            div.className = 'p-3 hover:bg-gray-100 cursor-pointer border-b';
                            div.innerHTML = `
                                <div class="font-medium">${user.name}</div>
                                <div class="text-sm text-gray-600">${user.email}</div>
                                <div class="text-sm text-blue-600">Coins: ${user.coins || 0}</div>
                            `;
                            div.onclick = () => selectUser(user);
                            results.appendChild(div);
                        });
                    });
            } else {
                document.getElementById('userResults').classList.add('hidden');
            }
        });

        function selectUser(user) {
            document.getElementById('selectedUserId').value = user.id;
            document.getElementById('selectedUserName').textContent = user.name;
            document.getElementById('selectedUserEmail').textContent = user.email;
            document.getElementById('selectedUserCoins').textContent = user.coins || 0;
            document.getElementById('selectedUserInfo').classList.remove('hidden');
            document.getElementById('userResults').classList.add('hidden');
            document.getElementById('userSearch').value = user.name;
        }
    </script>
</x-admin-layout>