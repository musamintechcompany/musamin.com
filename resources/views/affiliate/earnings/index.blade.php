<x-affiliate-layout>
    <div class="py-6">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Earnings</h1>
                    <p class="text-gray-600 dark:text-gray-400">Track your commissions and manage payouts</p>
                </div>
                <button id="requestPayoutBtn" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                    <i class="fas fa-money-bill-wave mr-2"></i>Request Payout
                </button>
            </div>

            <!-- Earnings Overview -->
            <div class="grid grid-cols-1 gap-6 mb-6 md:grid-cols-4">
                <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-lg shadow-sm p-6 text-white">
                    <h6 class="text-sm font-medium text-green-100 uppercase">Total Earnings</h6>
                    <h3 class="text-2xl font-bold mb-2">$2,847.50</h3>
                    <div class="flex items-center">
                        <span class="inline-flex items-center px-2 py-1 text-xs font-medium text-green-800 bg-green-100 rounded-full">
                            <i class="fas fa-arrow-up mr-1"></i> 15.3%
                        </span>
                        <span class="ml-2 text-sm text-green-100">vs last month</span>
                    </div>
                </div>
                
                <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg shadow-sm p-6 text-white">
                    <h6 class="text-sm font-medium text-blue-100 uppercase">Available Balance</h6>
                    <h3 class="text-2xl font-bold mb-2">$1,284.50</h3>
                    <p class="text-sm text-blue-100">Ready for withdrawal</p>
                </div>
                
                <div class="bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-lg shadow-sm p-6 text-white">
                    <h6 class="text-sm font-medium text-yellow-100 uppercase">Pending</h6>
                    <h3 class="text-2xl font-bold mb-2">$563.00</h3>
                    <p class="text-sm text-yellow-100">Processing commissions</p>
                </div>
                
                <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg shadow-sm p-6 text-white">
                    <h6 class="text-sm font-medium text-purple-100 uppercase">This Month</h6>
                    <h3 class="text-2xl font-bold mb-2">$892.30</h3>
                    <p class="text-sm text-purple-100">Current month earnings</p>
                </div>
            </div>

            <!-- Main Content Tabs -->
            <div class="bg-white rounded-lg shadow-sm dark:bg-gray-800">
                <div class="border-b border-gray-200 dark:border-gray-700">
                    <nav class="flex space-x-8 px-6">
                        <button class="py-4 px-1 border-b-2 border-green-500 font-medium text-sm text-green-600 tab-btn active" data-tab="overview">
                            Overview
                        </button>
                        <button class="py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 tab-btn" data-tab="commissions">
                            Commissions
                        </button>
                        <button class="py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 tab-btn" data-tab="payouts">
                            Payout History
                        </button>
                        <button class="py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 tab-btn" data-tab="settings">
                            Payment Settings
                        </button>
                    </nav>
                </div>

                <!-- Tab Contents -->
                <div class="p-6">
                    <!-- Overview Tab -->
                    <div id="overview" class="tab-content">
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                            <!-- Earnings Chart -->
                            <div class="bg-gray-50 rounded-lg p-6 dark:bg-gray-700">
                                <h4 class="font-semibold text-gray-900 dark:text-white mb-4">Earnings Trend</h4>
                                <div class="h-64 flex items-center justify-center">
                                    <canvas id="earningsChart" class="w-full h-full"></canvas>
                                </div>
                            </div>
                            
                            <!-- Top Assets -->
                            <div class="bg-gray-50 rounded-lg p-6 dark:bg-gray-700">
                                <h4 class="font-semibold text-gray-900 dark:text-white mb-4">Top Earning Assets</h4>
                                <div class="space-y-4">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="font-medium text-gray-900 dark:text-white">E-Commerce Template</p>
                                            <p class="text-sm text-gray-500">15 sales</p>
                                        </div>
                                        <span class="font-bold text-green-600">$450.00</span>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="font-medium text-gray-900 dark:text-white">Portfolio Template</p>
                                            <p class="text-sm text-gray-500">23 sales</p>
                                        </div>
                                        <span class="font-bold text-green-600">$345.00</span>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="font-medium text-gray-900 dark:text-white">Mobile App UI</p>
                                            <p class="text-sm text-gray-500">8 sales</p>
                                        </div>
                                        <span class="font-bold text-green-600">$240.00</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Recent Transactions -->
                        <div class="bg-gray-50 rounded-lg p-6 dark:bg-gray-700">
                            <h4 class="font-semibold text-gray-900 dark:text-white mb-4">Recent Earnings</h4>
                            <div class="space-y-3">
                                <div class="flex items-center justify-between p-3 bg-white rounded-lg dark:bg-gray-800">
                                    <div>
                                        <p class="font-medium text-gray-900 dark:text-white">Commission from E-Commerce Template</p>
                                        <p class="text-sm text-gray-500">Customer: John Doe • 2 hours ago</p>
                                    </div>
                                    <span class="font-bold text-green-600">+$30.00</span>
                                </div>
                                <div class="flex items-center justify-between p-3 bg-white rounded-lg dark:bg-gray-800">
                                    <div>
                                        <p class="font-medium text-gray-900 dark:text-white">Commission from Portfolio Template</p>
                                        <p class="text-sm text-gray-500">Customer: Sarah Miller • 5 hours ago</p>
                                    </div>
                                    <span class="font-bold text-green-600">+$15.00</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Commissions Tab -->
                    <div id="commissions" class="tab-content hidden">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Commission History</h3>
                            <div class="flex space-x-4">
                                <select class="px-3 py-2 border border-gray-300 rounded-md dark:border-gray-600 dark:bg-gray-700">
                                    <option>All Time</option>
                                    <option>This Month</option>
                                    <option>Last Month</option>
                                    <option>Last 3 Months</option>
                                </select>
                                <select class="px-3 py-2 border border-gray-300 rounded-md dark:border-gray-600 dark:bg-gray-700">
                                    <option>All Assets</option>
                                    <option>E-Commerce Template</option>
                                    <option>Portfolio Template</option>
                                </select>
                            </div>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-400">Date</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-400">Asset</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-400">Customer</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-400">Sale Amount</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-400">Commission</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-400">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">Dec 15, 2024</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">E-Commerce Template</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">John Doe</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">$299.00</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-green-600">$30.00</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">Paid</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">Dec 14, 2024</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">Portfolio Template</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Sarah Miller</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">$149.00</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-green-600">$15.00</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 py-1 text-xs font-medium bg-yellow-100 text-yellow-800 rounded-full">Pending</span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Payout History Tab -->
                    <div id="payouts" class="tab-content hidden">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-6">Payout History</h3>
                        
                        <div class="space-y-4">
                            <div class="border border-gray-200 rounded-lg p-4 dark:border-gray-600">
                                <div class="flex items-center justify-between mb-2">
                                    <div>
                                        <h4 class="font-medium text-gray-900 dark:text-white">Payout #PAY-001</h4>
                                        <p class="text-sm text-gray-500">December 1, 2024</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-bold text-gray-900 dark:text-white">$1,250.00</p>
                                        <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">Completed</span>
                                    </div>
                                </div>
                                <p class="text-sm text-gray-600 dark:text-gray-400">PayPal: john@example.com</p>
                            </div>
                            
                            <div class="border border-gray-200 rounded-lg p-4 dark:border-gray-600">
                                <div class="flex items-center justify-between mb-2">
                                    <div>
                                        <h4 class="font-medium text-gray-900 dark:text-white">Payout #PAY-002</h4>
                                        <p class="text-sm text-gray-500">November 1, 2024</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-bold text-gray-900 dark:text-white">$890.50</p>
                                        <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">Completed</span>
                                    </div>
                                </div>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Bank Transfer: ****1234</p>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Settings Tab -->
                    <div id="settings" class="tab-content hidden">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-6">Payment Settings</h3>
                        
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <!-- Payment Methods -->
                            <div>
                                <h4 class="font-medium text-gray-900 dark:text-white mb-4">Payment Methods</h4>
                                <div class="space-y-4">
                                    <div class="border border-gray-200 rounded-lg p-4 dark:border-gray-600">
                                        <div class="flex items-center justify-between mb-2">
                                            <div class="flex items-center">
                                                <i class="fab fa-paypal text-blue-600 text-xl mr-3"></i>
                                                <div>
                                                    <p class="font-medium text-gray-900 dark:text-white">PayPal</p>
                                                    <p class="text-sm text-gray-500">john@example.com</p>
                                                </div>
                                            </div>
                                            <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">Primary</span>
                                        </div>
                                    </div>
                                    
                                    <button class="w-full px-4 py-2 border-2 border-dashed border-gray-300 rounded-lg text-gray-500 hover:border-gray-400 hover:text-gray-600">
                                        <i class="fas fa-plus mr-2"></i>Add Payment Method
                                    </button>
                                </div>
                            </div>
                            
                            <!-- Payout Settings -->
                            <div>
                                <h4 class="font-medium text-gray-900 dark:text-white mb-4">Payout Settings</h4>
                                <form class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Minimum Payout Amount</label>
                                        <select class="w-full px-3 py-2 border border-gray-300 rounded-md dark:border-gray-600 dark:bg-gray-700">
                                            <option>$50.00</option>
                                            <option>$100.00</option>
                                            <option>$250.00</option>
                                            <option>$500.00</option>
                                        </select>
                                    </div>
                                    
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Payout Frequency</label>
                                        <select class="w-full px-3 py-2 border border-gray-300 rounded-md dark:border-gray-600 dark:bg-gray-700">
                                            <option>Manual Request</option>
                                            <option>Weekly</option>
                                            <option>Monthly</option>
                                        </select>
                                    </div>
                                    
                                    <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Save Settings</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Request Payout Modal -->
    <div id="payoutModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-lg shadow-xl max-w-md w-full dark:bg-gray-800">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Request Payout</h3>
                </div>
                
                <form class="p-6 space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Available Balance</label>
                        <p class="text-2xl font-bold text-green-600">$1,284.50</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Payout Amount</label>
                        <input type="number" max="1284.50" min="50" value="1284.50" class="w-full px-3 py-2 border border-gray-300 rounded-md dark:border-gray-600 dark:bg-gray-700">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Payment Method</label>
                        <select class="w-full px-3 py-2 border border-gray-300 rounded-md dark:border-gray-600 dark:bg-gray-700">
                            <option>PayPal - john@example.com</option>
                        </select>
                    </div>
                    
                    <div class="flex justify-end space-x-4">
                        <button type="button" id="cancelPayoutBtn" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">Cancel</button>
                        <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">Request Payout</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Tab functionality
            const tabBtns = document.querySelectorAll('.tab-btn');
            const tabContents = document.querySelectorAll('.tab-content');

            tabBtns.forEach(btn => {
                btn.addEventListener('click', () => {
                    const tabId = btn.dataset.tab;
                    
                    // Update active tab button
                    tabBtns.forEach(b => {
                        b.classList.remove('border-green-500', 'text-green-600');
                        b.classList.add('border-transparent', 'text-gray-500');
                    });
                    btn.classList.remove('border-transparent', 'text-gray-500');
                    btn.classList.add('border-green-500', 'text-green-600');
                    
                    // Update active tab content
                    tabContents.forEach(content => content.classList.add('hidden'));
                    document.getElementById(tabId).classList.remove('hidden');
                });
            });

            // Payout modal
            const requestPayoutBtn = document.getElementById('requestPayoutBtn');
            const payoutModal = document.getElementById('payoutModal');
            const cancelPayoutBtn = document.getElementById('cancelPayoutBtn');

            requestPayoutBtn.addEventListener('click', () => {
                payoutModal.classList.remove('hidden');
            });

            cancelPayoutBtn.addEventListener('click', () => {
                payoutModal.classList.add('hidden');
            });

            // Earnings Chart
            const ctx = document.getElementById('earningsChart');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                    datasets: [{
                        label: 'Earnings',
                        data: [450, 680, 520, 890, 1200, 1284],
                        borderColor: '#10B981',
                        backgroundColor: 'rgba(16, 185, 129, 0.1)',
                        tension: 0.3,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return '$' + value;
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
    @endpush
</x-affiliate-layout>