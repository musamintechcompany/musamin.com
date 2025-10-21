@php
use Illuminate\Support\Facades\Storage;
@endphp

<x-admin-layout title="Asset Details">
<div class="p-4 lg:p-6">
    <div class="space-y-4 overflow-hidden">
        <div class="flex flex-col sm:flex-row lg:justify-between lg:items-center gap-4">
            <div>
                <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold text-gray-900">{{ $asset->title }}</h1>
                <p class="text-gray-600">Asset Details & Inspection</p>
            </div>
            <div class="flex space-x-3">
                <button onclick="toggleInspection()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors">
                    <i class="fas fa-search mr-2"></i>Inspect Asset
                </button>
                <a href="{{ route('admin.assets.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i>Back to Assets
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Asset Information -->
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Asset Information</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Title</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $asset->title }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Type</dt>
                            <dd class="mt-1">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                    {{ \App\Models\DigitalAsset::ASSET_TYPES[$asset->asset_type] }}
                                </span>
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Category</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ $asset->category->name }}
                                @if($asset->subcategory)
                                    / {{ $asset->subcategory->name }}
                                @endif
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Owner</dt>
                            <dd class="mt-1 flex items-center">
                                <img src="{{ $asset->user->profile_photo_url }}" class="h-6 w-6 rounded-full mr-2" alt="">
                                <span class="text-sm text-gray-900">{{ $asset->user->name }}</span>
                            </dd>
                        </div>
                    </div>

                    <div class="mb-6">
                        <dt class="text-sm font-medium text-gray-500">Short Description</dt>
                        <dd class="mt-2 text-sm text-gray-900">{{ $asset->short_description }}</dd>
                    </div>

                    <div class="mb-6">
                        <dt class="text-sm font-medium text-gray-500">Full Details</dt>
                        <dd class="mt-2 p-4 bg-gray-50 rounded-lg text-sm text-gray-900">
                            {!! nl2br(e($asset->details)) !!}
                        </dd>
                    </div>

                    @if($asset->live_preview_url)
                    <div class="mb-6">
                        <dt class="text-sm font-medium text-gray-500">Live Preview</dt>
                        <dd class="mt-2">
                            <a href="{{ $asset->live_preview_url }}" target="_blank" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200">
                                <i class="fas fa-external-link-alt mr-2"></i>View Preview
                            </a>
                        </dd>
                    </div>
                    @endif

                    <!-- Pricing -->
                    <div class="mb-6">
                        <dt class="text-sm font-medium text-gray-500 mb-2">Pricing</dt>
                        <dd class="flex flex-wrap gap-2">
                            @if($asset->is_buyable)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                    Buy: ${{ number_format($asset->buy_price, 2) }}
                                    @if($asset->slashed_buy_price)
                                        <span class="ml-1 line-through text-gray-500">${{ number_format($asset->slashed_buy_price, 2) }}</span>
                                    @endif
                                </span>
                            @endif
                            
                            @if($asset->is_rentable)
                                @if($asset->daily_rent_price)
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">Daily: ${{ number_format($asset->daily_rent_price, 2) }}</span>
                                @endif
                                @if($asset->weekly_rent_price)
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">Weekly: ${{ number_format($asset->weekly_rent_price, 2) }}</span>
                                @endif
                                @if($asset->monthly_rent_price)
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">Monthly: ${{ number_format($asset->monthly_rent_price, 2) }}</span>
                                @endif
                                @if($asset->yearly_rent_price)
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">Yearly: ${{ number_format($asset->yearly_rent_price, 2) }}</span>
                                @endif
                            @endif
                        </dd>
                    </div>

                    <!-- Tags -->
                    @if($asset->tags->count())
                    <div class="mb-6">
                        <dt class="text-sm font-medium text-gray-500 mb-2">Tags</dt>
                        <dd class="flex flex-wrap gap-2">
                            @foreach($asset->tags as $tag)
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">#{{ $tag->name }}</span>
                            @endforeach
                        </dd>
                    </div>
                    @endif

                    <!-- Features -->
                    @if($asset->features->count())
                    <div class="mb-6">
                        <dt class="text-sm font-medium text-gray-500 mb-2">Features</dt>
                        <dd>
                            <ul class="list-disc list-inside space-y-1 text-sm text-gray-900">
                                @foreach($asset->features as $feature)
                                    <li>{{ $feature->feature_text }}</li>
                                @endforeach
                            </ul>
                        </dd>
                    </div>
                    @endif
                </div>

                <!-- Media -->
                @if($asset->media->count())
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Media Files</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($asset->media as $media)
                        <div class="relative">
                            @if($media->media_type === 'image')
                                <img src="{{ Storage::url($media->file_path) }}" class="w-full h-32 object-cover rounded-lg" alt="{{ $media->alt_text }}">
                            @else
                                <video controls class="w-full h-32 rounded-lg">
                                    <source src="{{ Storage::url($media->file_path) }}" type="video/mp4">
                                </video>
                            @endif
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1 space-y-6">
                <!-- Status & Actions -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Status & Actions</h3>
                    
                    <div class="space-y-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Marketplace Status</dt>
                            <dd class="mt-1">
                                @if($asset->marketplace_status === 'live')
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Live</span>
                                @elseif($asset->marketplace_status === 'removed')
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Removed</span>
                                @else
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Suspended</span>
                                @endif
                            </dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-gray-500">Inspection Status</dt>
                            <dd class="mt-1">
                                @if($asset->inspection_status === 'pending')
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                                @elseif($asset->inspection_status === 'approved')
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Approved</span>
                                @elseif($asset->inspection_status === 'rejected')
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Rejected</span>
                                @else
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">Flagged</span>
                                @endif
                            </dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-gray-500">Featured</dt>
                            <dd class="mt-1">
                                @if($asset->is_featured)
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-purple-100 text-purple-800">Yes</span>
                                    @if($asset->featured_until)
                                        <div class="text-xs text-gray-500 mt-1">Until: {{ $asset->featured_until->format('M d, Y') }}</div>
                                    @endif
                                @else
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">No</span>
                                @endif
                            </dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-gray-500">System Managed</dt>
                            <dd class="mt-1">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $asset->system_managed ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                    {{ $asset->system_managed ? 'Yes (50% share)' : 'No (30% share)' }}
                                </span>
                            </dd>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="mt-6 space-y-3">
                        <form action="{{ route('admin.assets.toggle-marketplace', $asset) }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full {{ $asset->marketplace_status === 'live' ? 'bg-yellow-600 hover:bg-yellow-700' : 'bg-green-600 hover:bg-green-700' }} text-white px-4 py-2 rounded-lg transition-colors">
                                {{ $asset->marketplace_status === 'live' ? 'Remove from Marketplace' : 'Make Live' }}
                            </button>
                        </form>

                        <form action="{{ route('admin.assets.toggle-featured', $asset) }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full {{ $asset->is_featured ? 'bg-gray-600 hover:bg-gray-700' : 'bg-purple-600 hover:bg-purple-700' }} text-white px-4 py-2 rounded-lg transition-colors">
                                {{ $asset->is_featured ? 'Remove Featured' : 'Make Featured' }}
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Inspection -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Asset Inspection</h3>
                    
                    @if($asset->inspector)
                    <div class="mb-4">
                        <dt class="text-sm font-medium text-gray-500">Inspected by</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $asset->inspector->name }}</dd>
                        <dd class="text-xs text-gray-500">{{ $asset->inspected_at->format('M d, Y H:i') }}</dd>
                    </div>
                    @endif

                    @if($asset->inspector_comment)
                    <div class="mb-4">
                        <dt class="text-sm font-medium text-gray-500">Inspector Comment</dt>
                        <dd class="mt-2 p-3 bg-gray-50 rounded-lg text-sm text-gray-900">{{ $asset->inspector_comment }}</dd>
                    </div>
                    @endif

                    <form action="{{ route('admin.assets.inspect', $asset) }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Inspection Status</label>
                            <select name="inspection_status" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                                <option value="approved" {{ $asset->inspection_status === 'approved' ? 'selected' : '' }}>Approve</option>
                                <option value="rejected" {{ $asset->inspection_status === 'rejected' ? 'selected' : '' }}>Reject</option>
                                <option value="flagged" {{ $asset->inspection_status === 'flagged' ? 'selected' : '' }}>Flag for Review</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Marketplace Action</label>
                            <select name="marketplace_action" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                <option value="">No Change</option>
                                <option value="live">Make Live</option>
                                <option value="removed">Remove</option>
                                <option value="suspended">Suspend</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Comment</label>
                            <textarea name="inspector_comment" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="Add inspection notes...">{{ $asset->inspector_comment }}</textarea>
                        </div>

                        <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg transition-colors">
                            Update Inspection
                        </button>
                    </form>
                </div>

                <!-- Stats -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Statistics</h3>
                    <div class="grid grid-cols-3 gap-4 text-center">
                        <div>
                            <div class="text-2xl font-bold text-gray-900">{{ $asset->views_count }}</div>
                            <div class="text-xs text-gray-500">Views</div>
                        </div>
                        <div>
                            <div class="text-2xl font-bold text-gray-900">{{ $asset->downloads_count }}</div>
                            <div class="text-xs text-gray-500">Downloads</div>
                        </div>
                        <div>
                            <div class="text-2xl font-bold text-gray-900">{{ $asset->favorites_count }}</div>
                            <div class="text-xs text-gray-500">Favorites</div>
                        </div>
                    </div>
                    
                    @if($asset->rating_count > 0)
                    <div class="mt-4 pt-4 border-t border-gray-200 text-center">
                        <div class="text-2xl font-bold text-gray-900">{{ number_format($asset->rating_average, 1) }}/5</div>
                        <div class="text-xs text-gray-500">{{ $asset->rating_count }} reviews</div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
</x-admin-layout>