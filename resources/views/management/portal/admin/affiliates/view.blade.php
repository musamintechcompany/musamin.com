<x-admin-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Affiliate Details</h1>
                    <p class="text-gray-600 dark:text-gray-400">{{ $affiliate->user->name }} - {{ $affiliate->affiliate_code }}</p>
                </div>
                <a href="{{ route('admin.affiliates.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Back to Affiliates
                </a>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- User Information -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">User Information</h3>
                        <div class="space-y-4">
                            <div class="flex items-center">
                                <img class="h-12 w-12 rounded-full" src="https://ui-avatars.com/api/?name={{ urlencode($affiliate->user->name) }}&background=6366f1&color=fff" alt="">
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $affiliate->user->name }}</div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400">{{ $affiliate->user->email }}</div>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Username</label>
                                    <p class="text-sm text-gray-900 dark:text-white">{{ $affiliate->user->username ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">User Status</label>
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{ $affiliate->user->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ ucfirst($affiliate->user->status) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Affiliate Information -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Affiliate Information</h3>
                        <div class="space-y-4">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Affiliate Code</label>
                                    <p class="text-sm font-mono text-gray-900 dark:text-white bg-gray-100 dark:bg-gray-700 px-2 py-1 rounded">{{ $affiliate->affiliate_code }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status</label>
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{ $affiliate->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ ucfirst($affiliate->status) }}
                                    </span>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Plan Type</label>
                                    <p class="text-sm text-gray-900 dark:text-white">{{ ucfirst($affiliate->plan_type ?? 'monthly') }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Fee Paid</label>
                                    <p class="text-sm text-gray-900 dark:text-white">${{ number_format($affiliate->fee_paid, 2) }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Dates & Timeline -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Timeline</h3>
                        <div class="space-y-4">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Joined Date</label>
                                    <p class="text-sm text-gray-900 dark:text-white">{{ $affiliate->joined_at?->format('M d, Y g:i A') ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Expires Date</label>
                                    <p class="text-sm text-gray-900 dark:text-white">{{ $affiliate->expires_at?->format('M d, Y g:i A') ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Last Renewed</label>
                                    <p class="text-sm text-gray-900 dark:text-white">{{ $affiliate->last_renewed_at?->format('M d, Y g:i A') ?? 'Never' }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Renewal Count</label>
                                    <p class="text-sm text-gray-900 dark:text-white">{{ $affiliate->renewed_count }} times</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Renewal History -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Renewal History</h3>
                        @if($affiliate->renewal_history && count($affiliate->renewal_history) > 0)
                            <div class="space-y-3">
                                @foreach($affiliate->renewal_history as $renewal)
                                    <div class="border-l-4 border-blue-400 pl-4 py-2 bg-blue-50 dark:bg-blue-900/20">
                                        <div class="flex justify-between items-start">
                                            <div>
                                                <p class="text-sm font-medium text-gray-900 dark:text-white">
                                                    Renewed on {{ \Carbon\Carbon::parse($renewal['renewed_at'])->format('M d, Y g:i A') }}
                                                </p>
                                                <p class="text-xs text-gray-600 dark:text-gray-400">
                                                    Plan: {{ ucfirst($renewal['plan_type'] ?? 'monthly') }} | 
                                                    Fee: ${{ number_format($renewal['fee_paid'] ?? 0, 2) }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-sm text-gray-500 dark:text-gray-400">No renewal history available</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- User Coins & Stats -->
            <div class="mt-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">User Account Stats</h3>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div class="bg-blue-50 dark:bg-blue-900/20 p-4 rounded-lg">
                            <div class="text-sm font-medium text-blue-600 dark:text-blue-400">Spendable Coins</div>
                            <div class="text-2xl font-bold text-blue-900 dark:text-blue-100">{{ number_format($affiliate->user->spendable_coins) }}</div>
                        </div>
                        <div class="bg-green-50 dark:bg-green-900/20 p-4 rounded-lg">
                            <div class="text-sm font-medium text-green-600 dark:text-green-400">Earned Coins</div>
                            <div class="text-2xl font-bold text-green-900 dark:text-green-100">{{ number_format($affiliate->user->earned_coins) }}</div>
                        </div>
                        <div class="bg-yellow-50 dark:bg-yellow-900/20 p-4 rounded-lg">
                            <div class="text-sm font-medium text-yellow-600 dark:text-yellow-400">Pending Coins</div>
                            <div class="text-2xl font-bold text-yellow-900 dark:text-yellow-100">{{ number_format($affiliate->user->pending_earned_coins) }}</div>
                        </div>
                        <div class="bg-purple-50 dark:bg-purple-900/20 p-4 rounded-lg">
                            <div class="text-sm font-medium text-purple-600 dark:text-purple-400">Member Since</div>
                            <div class="text-lg font-bold text-purple-900 dark:text-purple-100">{{ $affiliate->user->created_at->format('M Y') }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>