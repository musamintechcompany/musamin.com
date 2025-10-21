@php
use Illuminate\Support\Facades\Storage;
@endphp

<x-admin-layout title="Digital Assets">
<div class="p-4 lg:p-6">
    <div class="space-y-4 overflow-hidden">
        <div class="flex flex-col sm:flex-row lg:justify-between lg:items-center gap-4">
            <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold text-gray-900">Digital Assets</h1>
            <a href="{{ route('admin.assets.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 lg:px-6 lg:py-3 rounded-lg text-center transition-colors">
                <i class="fas fa-plus mr-2"></i>Create Asset
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <!-- Asset Stats Widgets -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <x-widgets.admin.assets.total-assets />
            <x-widgets.admin.assets.pending-inspection />
            <x-widgets.admin.assets.live-assets />
            <x-widgets.admin.assets.flagged-assets />
        </div>

        <!-- Search and Controls -->
        <div class="flex items-center gap-4 mb-4">
            <div class="flex-1 min-w-0 max-w-md">
                <input type="text" id="searchInput" placeholder="Search assets..." class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm" value="{{ request('search') }}">
            </div>
            
            <div class="relative">
                <button id="filterButton" class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition-colors">
                    <i class="fas fa-filter"></i>
                </button>
                <div id="filterDropdown" class="absolute top-full right-0 mt-1 w-80 bg-white border border-gray-200 rounded-lg shadow-lg z-50 hidden">
                    <div class="p-4 space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                            <select id="statusFilter" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                                <option value="">All Status</option>
                                <option value="live">Live</option>
                                <option value="removed">Removed</option>
                                <option value="suspended">Suspended</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Inspection</label>
                            <select id="inspectionFilter" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                                <option value="">All Inspections</option>
                                <option value="pending">Pending</option>
                                <option value="approved">Approved</option>
                                <option value="rejected">Rejected</option>
                                <option value="flagged">Flagged</option>
                            </select>
                        </div>
                        <div>
                            <button id="resetFilters" class="w-full bg-gray-300 text-gray-700 px-4 py-2 rounded-lg text-sm hover:bg-gray-400">Reset</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Assets Table -->
        <div class="bg-white shadow overflow-hidden sm:rounded-md">
            <div class="px-4 py-5 sm:p-6">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Asset</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Owner</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Inspection</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($assets as $asset)
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
                                    <div class="flex items-center">
                                        <img class="h-8 w-8 rounded-full" src="{{ $asset->user->profile_photo_url }}" alt="">
                                        <div class="ml-3">
                                            <div class="text-sm font-medium text-gray-900">{{ $asset->user->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $asset->user->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                        {{ \App\Models\DigitalAsset::ASSET_TYPES[$asset->asset_type] }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($asset->marketplace_status === 'live')
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Live</span>
                                    @elseif($asset->marketplace_status === 'removed')
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Removed</span>
                                    @else
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Suspended</span>
                                    @endif
                                    
                                    @if($asset->is_featured)
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-purple-100 text-purple-800 ml-1">Featured</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($asset->inspection_status === 'pending')
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                                    @elseif($asset->inspection_status === 'approved')
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Approved</span>
                                    @elseif($asset->inspection_status === 'rejected')
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Rejected</span>
                                    @else
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">Flagged</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $asset->created_at->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('admin.assets.view', $asset) }}" class="text-indigo-600 hover:text-indigo-900">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.assets.edit', $asset) }}" class="text-gray-600 hover:text-gray-900">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center">
                                    <div class="text-gray-500">
                                        <i class="fas fa-box fa-3x mb-4"></i>
                                        <p>No assets found</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <div class="mt-6">
                    {{ $assets->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<x-widgets.realtime-updater />

</x-admin-layout>