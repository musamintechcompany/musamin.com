<x-admin-layout title="Revenue Analytics">
<div class="p-4 lg:p-6">
    <div class="space-y-4 overflow-hidden">
        <div class="flex flex-col sm:flex-row lg:justify-between lg:items-center gap-4">
            <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold text-gray-900">Revenue Analytics</h1>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mr-4">
                        <i class="fas fa-dollar-sign text-green-600 text-xl"></i>
                    </div>
                    <div class="flex-grow-1">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Total Revenue</p>
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white">${{ number_format($totalRevenue, 2) }}</h3>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mr-4">
                        <i class="fas fa-calendar-day text-blue-600 text-xl"></i>
                    </div>
                    <div class="flex-grow-1">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Today</p>
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white">${{ number_format($todayRevenue, 2) }}</h3>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mr-4">
                        <i class="fas fa-calendar-alt text-purple-600 text-xl"></i>
                    </div>
                    <div class="flex-grow-1">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">This Month</p>
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white">${{ number_format($monthRevenue, 2) }}</h3>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center mr-4">
                        <i class="fas fa-calendar-minus text-orange-600 text-xl"></i>
                    </div>
                    <div class="flex-grow-1">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Last Month</p>
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white">${{ number_format($lastMonthRevenue, 2) }}</h3>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center mr-4">
                        <i class="fas fa-calendar-times text-red-600 text-xl"></i>
                    </div>
                    <div class="flex-grow-1">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Last Year</p>
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white">${{ number_format($lastYearRevenue, 2) }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Revenue Records Table -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow mt-6">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Revenue Records</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Type</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Amount</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Source</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Date</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse(\App\Models\Revenue::with('revenueable')->latest('recorded_at')->paginate(10) as $revenue)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 py-1 text-xs font-medium rounded-full
                                        @if($revenue->type === 'affiliate_join') bg-blue-100 text-blue-800
                                        @elseif($revenue->type === 'affiliate_renewal') bg-purple-100 text-purple-800
                                        @elseif($revenue->type === 'order_commission') bg-green-100 text-green-800
                                        @else bg-gray-100 text-gray-800
                                        @endif">
                                        {{ ucfirst(str_replace('_', ' ', $revenue->type)) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                    ${{ number_format($revenue->amount, 2) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 py-1 text-xs font-medium rounded-full
                                        @if($revenue->status === 'confirmed') bg-green-100 text-green-800
                                        @elseif($revenue->status === 'pending') bg-yellow-100 text-yellow-800
                                        @else bg-red-100 text-red-800
                                        @endif">
                                        {{ ucfirst($revenue->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                    {{ class_basename($revenue->revenueable_type) }} #{{ Str::limit($revenue->revenueable_id, 8) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                    {{ $revenue->created_at->format('M j, Y g:i A') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                    No revenue records found
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</x-admin-layout>