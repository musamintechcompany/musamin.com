<x-admin-layout title="View User">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">User Details</h1>
                    <p class="text-gray-600 dark:text-gray-400">View user information and statistics</p>
                </div>
                <div class="flex space-x-3">
                    @if(auth('admin')->user()->can('edit-users'))
                    <a href="{{ route('admin.users.edit', $user) }}" class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-lg">
                        <i class="fas fa-edit mr-2"></i>Edit
                    </a>
                    @endif
                    <a href="{{ route('admin.users.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg">
                        <i class="fas fa-arrow-left mr-2"></i>Back to Users
                    </a>
                </div>
            </div>
        </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- User Profile Card -->
        <div class="lg:col-span-1 order-2 lg:order-1">
            <div class="bg-white rounded-lg shadow p-6 text-center">
                @if($user->profile_photo_path)
                    <img class="w-24 h-24 rounded-full mx-auto mb-4 object-cover" src="{{ asset('storage/' . $user->profile_photo_path) }}" alt="{{ $user->name }}">
                @else
                    <img class="w-24 h-24 rounded-full mx-auto mb-4" src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=22c55e&color=fff&size=200" alt="{{ $user->name }}">
                @endif
                <h3 class="text-xl font-semibold text-gray-900 mb-2">{{ $user->name }}</h3>
                <p class="text-gray-600 mb-4">{{ $user->email }}</p>
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
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $config[0] }}">
                    {{ $config[1] }} {{ ucfirst($user->status) }}
                </span>
            </div>
        </div>

        <!-- User Information -->
        <div class="lg:col-span-2 order-1 lg:order-2">
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">User Information</h3>
                </div>
                <div class="p-6">
                    <dl class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Full Name</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $user->name }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Email Address</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $user->email }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">User ID</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">#{{ $user->hashid ?? $user->id }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Email Verified</dt>
                            <dd class="mt-1 text-sm">
                                @if($user->email_verified_at)
                                    <span class="text-green-600 dark:text-green-400">
                                        <i class="fas fa-check-circle mr-1"></i>Verified on {{ $user->email_verified_at->format('M d, Y') }}
                                    </span>
                                @else
                                    <span class="text-red-600 dark:text-red-400">
                                        <i class="fas fa-times-circle mr-1"></i>Not verified
                                    </span>
                                @endif
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Account Status</dt>
                            <dd class="mt-1">
                                @php
                                    $statusConfig = [
                                        'pending' => ['bg-yellow-100 text-yellow-800', '🟡', 'Pending Verification'],
                                        'active' => ['bg-green-100 text-green-800', '🟢', 'Active Account'],
                                        'warning' => ['bg-orange-100 text-orange-800', '🟠', 'Account Warning'],
                                        'hold' => ['bg-blue-100 text-blue-800', '🔵', 'Account on Hold'],
                                        'suspended' => ['bg-red-100 text-red-800', '🔴', 'Account Suspended'],
                                        'blocked' => ['bg-gray-100 text-gray-800', '⚫', 'Account Blocked']
                                    ];
                                    $config = $statusConfig[$user->status] ?? ['bg-gray-100 text-gray-800', '⚪', 'Unknown Status'];
                                @endphp
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $config[0] }}">
                                    {{ $config[1] }} {{ $config[2] }}
                                </span>
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Member Since</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $user->created_at->format('F d, Y') }}</dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>
    </div>

    <!-- Account Statistics -->
    <div class="mt-6">
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Account Statistics</h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    <div class="text-center">
                        <div class="text-2xl font-bold text-blue-600">0</div>
                        <div class="text-sm text-gray-500">Total Coins</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-green-600">0</div>
                        <div class="text-sm text-gray-500">Transactions</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-yellow-600">$0.00</div>
                        <div class="text-sm text-gray-500">Total Spent</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-purple-600">{{ now()->diffInDays($user->created_at) }}</div>
                        <div class="text-sm text-gray-500">Days Active</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</x-admin-layout>