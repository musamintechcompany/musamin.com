<x-affiliate-layout>
    <div class="py-6">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">My Code</h1>
                <p class="text-gray-600 dark:text-gray-400">Generate tracking links and marketing materials</p>
            </div>

            <!-- Quick Stats -->
            <div class="grid grid-cols-1 gap-6 mb-6 md:grid-cols-4">
                <div class="bg-white rounded-lg shadow-sm p-6 dark:bg-gray-800">
                    <h6 class="text-sm font-medium text-gray-500 uppercase dark:text-gray-400">Active Links</h6>
                    <h3 class="text-2xl font-bold text-blue-600">24</h3>
                </div>
                <div class="bg-white rounded-lg shadow-sm p-6 dark:bg-gray-800">
                    <h6 class="text-sm font-medium text-gray-500 uppercase dark:text-gray-400">Total Clicks</h6>
                    <h3 class="text-2xl font-bold text-green-600">1,847</h3>
                </div>
                <div class="bg-white rounded-lg shadow-sm p-6 dark:bg-gray-800">
                    <h6 class="text-sm font-medium text-gray-500 uppercase dark:text-gray-400">Conversions</h6>
                    <h3 class="text-2xl font-bold text-purple-600">73</h3>
                </div>
                <div class="bg-white rounded-lg shadow-sm p-6 dark:bg-gray-800">
                    <h6 class="text-sm font-medium text-gray-500 uppercase dark:text-gray-400">Conversion Rate</h6>
                    <h3 class="text-2xl font-bold text-orange-600">3.95%</h3>
                </div>
            </div>

            <!-- Main Content Tabs -->
            <div class="bg-white rounded-lg shadow-sm dark:bg-gray-800">
                <div class="border-b border-gray-200 dark:border-gray-700">
                    <nav class="flex space-x-8 px-6">
                        <button class="py-4 px-1 border-b-2 border-cyan-500 font-medium text-sm text-cyan-600 tab-btn active" data-tab="links">
                            Referral Links
                        </button>
                        <button class="py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 tab-btn" data-tab="qr">
                            QR Codes
                        </button>
                        <button class="py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 tab-btn" data-tab="materials">
                            Marketing Materials
                        </button>
                        <button class="py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 tab-btn" data-tab="analytics">
                            Link Analytics
                        </button>
                    </nav>
                </div>

                <!-- Tab Contents -->
                <div class="p-6">
                    <!-- Referral Links Tab -->
                    <div id="links" class="tab-content">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Generate Referral Links</h3>
                            <button id="generateLinkBtn" class="px-4 py-2 bg-cyan-600 text-white rounded-lg hover:bg-cyan-700">
                                <i class="fas fa-plus mr-2"></i>Generate New Link
                            </button>
                        </div>

                        <!-- Link Generator Form -->
                        <div class="bg-gray-50 rounded-lg p-6 mb-6 dark:bg-gray-700">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Asset/Page</label>
                                    <select class="w-full px-3 py-2 border border-gray-300 rounded-md dark:border-gray-600 dark:bg-gray-800">
                                        <option>Marketplace Homepage</option>
                                        <option>E-Commerce Template</option>
                                        <option>Portfolio Template</option>
                                        <option>Mobile App Template</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Campaign Name</label>
                                    <input type="text" placeholder="e.g., Social Media Campaign" class="w-full px-3 py-2 border border-gray-300 rounded-md dark:border-gray-600 dark:bg-gray-800">
                                </div>
                                <div class="flex items-end">
                                    <button class="w-full px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Generate Link</button>
                                </div>
                            </div>
                        </div>

                        <!-- Generated Links List -->
                        <div class="space-y-4">
                            <div class="border border-gray-200 rounded-lg p-4 dark:border-gray-600">
                                <div class="flex items-center justify-between mb-2">
                                    <h4 class="font-medium text-gray-900 dark:text-white">Marketplace Homepage - Social Campaign</h4>
                                    <span class="text-sm text-green-600">Active</span>
                                </div>
                                <div class="flex items-center space-x-2 mb-2">
                                    <input type="text" value="https://musamin.com/ref/AF123456" readonly class="flex-1 px-3 py-2 bg-gray-100 border border-gray-300 rounded-md text-sm dark:bg-gray-600 dark:border-gray-500">
                                    <button class="px-3 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 copy-btn">
                                        <i class="fas fa-copy"></i>
                                    </button>
                                </div>
                                <div class="flex items-center justify-between text-sm text-gray-500">
                                    <span>Clicks: 234 | Conversions: 12</span>
                                    <span>Created: 2 days ago</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- QR Codes Tab -->
                    <div id="qr" class="tab-content hidden">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-6">QR Code Generator</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <div class="bg-gray-50 rounded-lg p-6 dark:bg-gray-700">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Select Referral Link</label>
                                    <select class="w-full px-3 py-2 border border-gray-300 rounded-md mb-4 dark:border-gray-600 dark:bg-gray-800">
                                        <option>https://musamin.com/ref/AF123456</option>
                                        <option>https://musamin.com/ref/AF789012</option>
                                    </select>
                                    <button class="w-full px-4 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-700">Generate QR Code</button>
                                </div>
                            </div>
                            <div>
                                <div class="bg-white border-2 border-dashed border-gray-300 rounded-lg p-6 text-center dark:bg-gray-800 dark:border-gray-600">
                                    <div class="w-32 h-32 bg-gray-200 mx-auto mb-4 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-qrcode text-4xl text-gray-400"></i>
                                    </div>
                                    <p class="text-gray-500 dark:text-gray-400">QR Code will appear here</p>
                                    <button class="mt-4 px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700">Download PNG</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Marketing Materials Tab -->
                    <div id="materials" class="tab-content hidden">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-6">Marketing Materials</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            <!-- Banner Templates -->
                            <div class="border border-gray-200 rounded-lg p-4 dark:border-gray-600">
                                <div class="w-full h-24 bg-gradient-to-r from-blue-500 to-purple-600 rounded-lg mb-3 flex items-center justify-center">
                                    <span class="text-white font-bold">Banner 728x90</span>
                                </div>
                                <h4 class="font-medium text-gray-900 dark:text-white mb-2">Leaderboard Banner</h4>
                                <button class="w-full px-3 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 text-sm">Download</button>
                            </div>

                            <!-- Social Media Templates -->
                            <div class="border border-gray-200 rounded-lg p-4 dark:border-gray-600">
                                <div class="w-full h-24 bg-gradient-to-r from-pink-500 to-red-500 rounded-lg mb-3 flex items-center justify-center">
                                    <span class="text-white font-bold">Social Post</span>
                                </div>
                                <h4 class="font-medium text-gray-900 dark:text-white mb-2">Instagram Story</h4>
                                <button class="w-full px-3 py-2 bg-pink-600 text-white rounded-md hover:bg-pink-700 text-sm">Download</button>
                            </div>

                            <!-- Email Templates -->
                            <div class="border border-gray-200 rounded-lg p-4 dark:border-gray-600">
                                <div class="w-full h-24 bg-gradient-to-r from-green-500 to-teal-500 rounded-lg mb-3 flex items-center justify-center">
                                    <span class="text-white font-bold">Email</span>
                                </div>
                                <h4 class="font-medium text-gray-900 dark:text-white mb-2">Newsletter Template</h4>
                                <button class="w-full px-3 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 text-sm">Copy HTML</button>
                            </div>
                        </div>
                    </div>

                    <!-- Analytics Tab -->
                    <div id="analytics" class="tab-content hidden">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-6">Link Performance Analytics</h3>
                        
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <div class="bg-gray-50 rounded-lg p-6 dark:bg-gray-700">
                                <h4 class="font-medium text-gray-900 dark:text-white mb-4">Top Performing Links</h4>
                                <div class="space-y-3">
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm text-gray-600 dark:text-gray-400">Social Campaign</span>
                                        <span class="font-medium text-gray-900 dark:text-white">234 clicks</span>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm text-gray-600 dark:text-gray-400">Email Campaign</span>
                                        <span class="font-medium text-gray-900 dark:text-white">189 clicks</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="bg-gray-50 rounded-lg p-6 dark:bg-gray-700">
                                <h4 class="font-medium text-gray-900 dark:text-white mb-4">Conversion Rates</h4>
                                <div class="space-y-3">
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm text-gray-600 dark:text-gray-400">This Week</span>
                                        <span class="font-medium text-green-600">4.2%</span>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm text-gray-600 dark:text-gray-400">Last Week</span>
                                        <span class="font-medium text-gray-900 dark:text-white">3.8%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
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
                        b.classList.remove('border-cyan-500', 'text-cyan-600');
                        b.classList.add('border-transparent', 'text-gray-500');
                    });
                    btn.classList.remove('border-transparent', 'text-gray-500');
                    btn.classList.add('border-cyan-500', 'text-cyan-600');
                    
                    // Update active tab content
                    tabContents.forEach(content => content.classList.add('hidden'));
                    document.getElementById(tabId).classList.remove('hidden');
                });
            });

            // Copy functionality
            document.querySelectorAll('.copy-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const input = this.parentElement.querySelector('input');
                    input.select();
                    document.execCommand('copy');
                    
                    // Show feedback
                    const originalIcon = this.innerHTML;
                    this.innerHTML = '<i class="fas fa-check"></i>';
                    setTimeout(() => {
                        this.innerHTML = originalIcon;
                    }, 2000);
                });
            });
        });
    </script>
    @endpush
</x-affiliate-layout>