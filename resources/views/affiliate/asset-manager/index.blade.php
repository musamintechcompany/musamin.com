<x-affiliate-layout>
    <div class="py-6">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Asset Manager</h1>
                    <p class="text-gray-600 dark:text-gray-400">Manage your digital assets</p>
                </div>
                <a href="{{ route('affiliate.assets.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors">
                    <i class="fas fa-plus mr-2"></i>Create Asset
                </a>
            </div>

            <!-- Asset Stats Widgets -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <x-widgets.affiliate.assets.my-assets />
                <x-widgets.affiliate.assets.live-assets />
                <x-widgets.affiliate.assets.total-earnings />
            </div>

            <!-- Assets List -->
            <div class="bg-white rounded-lg shadow-sm dark:bg-gray-800">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Your Assets</h3>
                    
                    @if($assets->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Asset</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($assets as $asset)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                @if($asset->media->first())
                                                    <img class="h-10 w-10 rounded-lg object-cover" src="{{ Storage::url($asset->media->first()->file_path) }}" alt="">
                                                @else
                                                    <div class="h-10 w-10 rounded-lg bg-gray-200 flex items-center justify-center">
                                                        <i class="fas fa-image text-gray-400"></i>
                                                    </div>
                                                @endif
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">{{ $asset->title }}</div>
                                                    <div class="text-sm text-gray-500">{{ Str::limit($asset->short_description, 50) }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($asset->marketplace_status === 'live')
                                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Live</span>
                                            @elseif($asset->marketplace_status === 'removed')
                                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Removed</span>
                                            @else
                                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Suspended</span>
                                            @endif
                                            
                                            @if($asset->inspection_status === 'pending')
                                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800 ml-1">Pending Review</span>
                                            @elseif($asset->inspection_status === 'rejected')
                                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800 ml-1">Rejected</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            @if($asset->is_buyable)
                                                ${{ number_format($asset->buy_price, 2) }}
                                            @else
                                                Rental Only
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $asset->created_at->format('M d, Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex space-x-2">
                                                <a href="{{ route('affiliate.assets.show', $asset) }}" class="text-indigo-600 hover:text-indigo-900">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('affiliate.assets.edit', $asset) }}" class="text-gray-600 hover:text-gray-900">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Pagination -->
                        <div class="mt-6">
                            {{ $assets->links() }}
                        </div>
                    @else
                        <div class="text-center py-12">
                            <div class="text-gray-500">
                                <i class="fas fa-box fa-3x mb-4"></i>
                                <p class="text-lg mb-2">No assets yet</p>
                                <p class="text-sm">Create your first digital asset to get started</p>
                                <a href="{{ route('affiliate.assets.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 mt-4">
                                    <i class="fas fa-plus mr-2"></i>Create Asset
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <x-widgets.realtime-updater />

</x-affiliate-layout>