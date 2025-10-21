<div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
    @if($users->count() > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider border-r border-gray-200 dark:border-gray-600" data-column="user">User</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider border-r border-gray-200 dark:border-gray-600" data-column="email">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider border-r border-gray-200 dark:border-gray-600" data-column="status">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider border-r border-gray-200 dark:border-gray-600 hidden" data-column="country">Country</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider border-r border-gray-200 dark:border-gray-600 hidden" data-column="coins">Coins</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider border-r border-gray-200 dark:border-gray-600 hidden" data-column="affiliate">Affiliate</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider border-r border-gray-200 dark:border-gray-600 hidden" data-column="theme">Theme</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider border-r border-gray-200 dark:border-gray-600" data-column="joined">Joined</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider" data-column="actions">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($users as $user)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap border-r border-gray-200 dark:border-gray-600" data-column="user">
                            <div class="flex items-center max-w-xs">
                                @if($user->profile_photo_path)
                                    <img class="h-10 w-10 rounded-full object-cover flex-shrink-0" src="{{ asset('storage/' . $user->profile_photo_path) }}" alt="{{ $user->name }}">
                                @else
                                    <img class="h-10 w-10 rounded-full flex-shrink-0" src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=22c55e&color=fff" alt="{{ $user->name }}">
                                @endif
                                <div class="ml-4 min-w-0 flex-1">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white truncate" title="{{ $user->name }}">{{ $user->name }}</div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400 truncate">#{{ $user->hashid ?? $user->id }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap border-r border-gray-200 dark:border-gray-600 max-w-xs" data-column="email">
                            <div class="text-sm text-gray-900 dark:text-white truncate" title="{{ $user->email }}">{{ $user->email }}</div>
                            @if($user->email_verified_at)
                                <div class="text-sm text-green-600 dark:text-green-400"><i class="fas fa-check-circle"></i> Verified</div>
                            @else
                                <div class="text-sm text-red-600 dark:text-red-400"><i class="fas fa-times-circle"></i> Unverified</div>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap border-r border-gray-200 dark:border-gray-600" data-column="status">
                            @php
                                $statusConfig = [
                                    'pending' => ['bg-yellow-100 text-yellow-800', '🟡'],
                                    'active' => ['bg-green-100 text-green-800', '🟢'],
                                    'warning' => ['bg-orange-100 text-orange-800', '🟠'],
                                    'hold' => ['bg-blue-100 text-blue-800', '🔵'],
                                    'suspended' => ['bg-red-100 text-red-800', '🔴'],
                                    'blocked' => ['bg-gray-100 text-gray-800', '⚫']
                                ];
                                $config = $statusConfig[$user->status] ?? ['bg-gray-100 text-gray-800', '⚪'];
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-sm font-medium {{ $config[0] }}">
                                {{ $config[1] }} {{ ucfirst($user->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400 border-r border-gray-200 dark:border-gray-600 max-w-24 hidden" data-column="country">
                            <div class="truncate" title="{{ $user->country ?? 'N/A' }}">{{ $user->country ?? 'N/A' }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap border-r border-gray-200 dark:border-gray-600 hidden" data-column="coins">
                            <div class="text-sm text-gray-900 dark:text-white">
                                <div>💰 {{ number_format($user->spendable_coins) }}</div>
                                <div class="text-xs text-gray-500">🏆 {{ number_format($user->earned_coins) }}</div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap border-r border-gray-200 dark:border-gray-600 hidden" data-column="affiliate">
                            @if($user->is_affiliate)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                    ⭐ Active
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    ➖ No
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400 border-r border-gray-200 dark:border-gray-600 max-w-20 hidden" data-column="theme">
                            <div class="truncate">
                                @if($user->theme === 'dark')
                                    🌙 Dark
                                @else
                                    ☀️ Light
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400 border-r border-gray-200 dark:border-gray-600" data-column="joined">
                            {{ $user->created_at->format('M d, Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium" data-column="actions">
                            <div class="flex items-center gap-1">
                                @if(auth('admin')->user()->can('view-users'))
                                <a href="{{ route('admin.users.view', $user) }}" class="inline-flex items-center px-2 py-1 bg-indigo-100 text-indigo-700 rounded hover:bg-indigo-200 transition-colors" title="View User">
                                    <i class="fas fa-eye text-sm"></i>
                                </a>
                                @endif
                                @if(auth('admin')->user()->can('edit-users'))
                                <a href="{{ route('admin.users.edit', $user) }}" class="inline-flex items-center px-2 py-1 bg-yellow-100 text-yellow-700 rounded hover:bg-yellow-200 transition-colors" title="Edit User">
                                    <i class="fas fa-edit text-sm"></i>
                                </a>
                                @endif
                                @if(auth('admin')->user()->can('login-users'))
                                <button type="button" class="inline-flex items-center px-2 py-1 bg-green-100 text-green-700 rounded hover:bg-green-200 transition-colors" onclick="showLoginModal('{{ addslashes($user->name) }}', '{{ $user->id }}')" title="Login as User">
                                    <i class="fas fa-sign-in-alt text-sm"></i>
                                </button>
                                @endif
                                @if(auth('admin')->user()->can('delete-users'))
                                <button type="button" class="inline-flex items-center px-2 py-1 bg-red-100 text-red-700 rounded hover:bg-red-200 transition-colors" onclick="confirmDelete('{{ $user->name }}', '{{ route('admin.users.destroy', $user) }}')" title="Delete User">
                                    <i class="fas fa-trash text-sm"></i>
                                </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
            {{ $users->links() }}
        </div>
    @else
        <div class="text-center py-12">
            <i class="fas fa-users text-gray-400 text-6xl mb-4"></i>
            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">No users found</h3>
            <p class="text-gray-500 dark:text-gray-400 mb-4">Try adjusting your search or filters.</p>
        </div>
    @endif
</div>