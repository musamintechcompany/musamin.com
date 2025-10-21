<x-affiliate-layout>
    <div class="py-6">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <!-- Asset Stats Widgets -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <x-widgets.affiliate.assets.my-assets />
                <x-widgets.affiliate.assets.live-assets />
                <x-widgets.affiliate.assets.total-earnings />
            </div>
            
            <!-- Store Stats Widgets -->
            @if(auth()->user()->store)
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <x-widgets.affiliate.store.store-visits />
                <x-widgets.affiliate.store.active-products />
            </div>
            @endif



            <!-- Performance Overview Chart -->
            <div class="mb-6">
                <x-widgets.affiliate.dashboard.line-chart />
            </div>



            <!-- Recent Activity -->
            <div class="bg-white rounded-lg shadow-sm dark:bg-gray-800">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h5 class="text-lg font-semibold text-gray-900 dark:text-white">Recent Conversions</h5>
                        <a href="#" class="px-4 py-2 text-sm font-medium text-indigo-600 border border-indigo-600 rounded-md hover:bg-indigo-50 dark:text-indigo-400 dark:border-indigo-400 dark:hover:bg-indigo-900">View All</a>
                    </div>

                    <div class="space-y-3" id="activityList">
                        <!-- Items will be added dynamically -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
            // Chart Data and Initialization
            document.addEventListener('DOMContentLoaded', function() {




                const recentConversions = [
                    { name: 'Sarah Johnson', amount: 49.99, product: 'Premium Plan', time: '10 min ago', status: 'completed' },
                    { name: 'Mike Peterson', amount: 99.99, product: 'Business Plan', time: '25 min ago', status: 'completed' },
                    { name: 'Emily Chen', amount: 29.99, product: 'Basic Plan', time: '1 hour ago', status: 'pending' },
                    { name: 'David Wilson', amount: 49.99, product: 'Premium Plan', time: '2 hours ago', status: 'completed' },
                    { name: 'Lisa Kim', amount: 99.99, product: 'Business Plan', time: '3 hours ago', status: 'completed' }
                ];





                // Populate activity list
                const activityList = document.getElementById('activityList');
                recentConversions.forEach(item => {
                    const statusClass = item.status === 'completed' ? 'text-green-600' : 'text-yellow-600';
                    const statusIcon = item.status === 'completed' ? 'fas fa-check-circle' : 'fas fa-clock';

                    const activityItem = document.createElement('div');
                    activityItem.className = 'flex items-center justify-between p-4 border-l-4 border-indigo-500 bg-gray-50 rounded-r-lg dark:bg-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors cursor-pointer';
                    activityItem.innerHTML = `
                        <div class="flex-1">
                            <h6 class="font-medium text-gray-900 dark:text-white">${item.name}</h6>
                            <p class="text-sm text-gray-500 dark:text-gray-400">${item.product}</p>
                        </div>
                        <div class="text-right">
                            <p class="font-semibold text-gray-900 dark:text-white">$${item.amount}</p>
                            <p class="text-sm ${statusClass}">
                                <i class="${statusIcon} mr-1"></i> ${item.time}
                            </p>
                        </div>
                    `;
                    activityList.appendChild(activityItem);
                });
            });
    </script>
    @endpush
</x-affiliate-layout>
