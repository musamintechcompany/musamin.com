<x-admin-layout title="Package Details">
<div class="p-6">
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-6 gap-4">
        <h1 class="text-xl sm:text-2xl font-bold text-gray-900">Package Details: {{ $coinPackage->pack_name }}</h1>
        <div class="flex flex-col sm:flex-row gap-3">
            <a href="{{ route('admin.coin-packages.edit', $coinPackage) }}" class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-lg text-center">
                <i class="fas fa-edit mr-2"></i>Edit
            </a>
            <a href="{{ route('admin.coin-packages.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg text-center">
                <i class="fas fa-arrow-left mr-2"></i>Back
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Package Info -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Package Information -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Package Information</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Package Name</label>
                        <div class="flex items-center mt-1">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium text-white mr-2" 
                                  style="background-color: {{ $coinPackage->badge_color ?? '#3b82f6' }}">
                                {{ $coinPackage->pack_name }}
                            </span>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Badge Color</label>
                        <div class="flex items-center mt-1">
                            <div class="w-6 h-6 rounded border border-gray-300 mr-2" 
                                 style="background-color: {{ $coinPackage->badge_color ?? '#3b82f6' }}"></div>
                            <span class="text-sm text-gray-900">{{ $coinPackage->badge_color ?? '#3b82f6' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pricing & Coins -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Pricing & Coins</h3>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div class="text-center p-4 bg-blue-50 rounded-lg">
                        <div class="text-xl sm:text-2xl font-bold text-blue-600">{{ number_format($coinPackage->coins) }}</div>
                        <div class="text-sm text-gray-600">Base Coins</div>
                    </div>
                    <div class="text-center p-4 bg-green-50 rounded-lg">
                        <div class="text-xl sm:text-2xl font-bold text-green-600">{{ number_format($coinPackage->bonus_coins) }}</div>
                        <div class="text-sm text-gray-600">Bonus Coins</div>
                    </div>
                    <div class="text-center p-4 bg-purple-50 rounded-lg">
                        <div class="text-xl sm:text-2xl font-bold text-purple-600">${{ number_format($coinPackage->price, 2) }}</div>
                        <div class="text-sm text-gray-600">Price (USD)</div>
                    </div>
                </div>
                <div class="mt-4 text-center p-4 bg-gray-50 rounded-lg">
                    <div class="text-3xl font-bold text-gray-900">{{ number_format($coinPackage->total_coins) }}</div>
                    <div class="text-sm text-gray-600">Total Coins (Base + Bonus)</div>
                </div>
            </div>

            <!-- Package Features -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Package Features</h3>
                @if($coinPackage->features && count($coinPackage->features) > 0)
                    <div class="space-y-3">
                        @foreach($coinPackage->features as $feature)
                            @if(!empty(trim($feature)))
                                <div class="flex items-center">
                                    <i class="fas fa-check-circle text-green-500 mr-3"></i>
                                    <span class="text-gray-700">{{ $feature }}</span>
                                </div>
                            @endif
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8 text-gray-500">
                        <i class="fas fa-list text-4xl mb-4"></i>
                        <p>No features defined for this package.</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Sidebar Info -->
        <div class="space-y-6">
            <!-- Package Status -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Package Status</h3>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Status</label>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $coinPackage->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $coinPackage->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Sort Order</label>
                        <span class="text-sm text-gray-900">{{ $coinPackage->sort_order }}</span>
                    </div>
                </div>
            </div>

            <!-- Package Metrics -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Package Metrics</h3>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Value per Dollar</label>
                        <span class="text-sm text-gray-900">{{ number_format($coinPackage->total_coins / $coinPackage->price, 2) }} coins/$</span>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Bonus Percentage</label>
                        <span class="text-sm text-gray-900">
                            @if($coinPackage->coins > 0)
                                {{ number_format(($coinPackage->bonus_coins / $coinPackage->coins) * 100, 1) }}%
                            @else
                                0%
                            @endif
                        </span>
                    </div>
                </div>
            </div>

            <!-- Package Details -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Package Details</h3>
                <div class="space-y-3 text-sm">
                    <div>
                        <span class="text-gray-500">Package ID:</span>
                        <span class="text-gray-900 font-mono">{{ $coinPackage->hashid ?? $coinPackage->id }}</span>
                    </div>
                    <div>
                        <span class="text-gray-500">Created:</span>
                        <span class="text-gray-900">{{ $coinPackage->created_at->format('M d, Y H:i') }}</span>
                    </div>
                    <div>
                        <span class="text-gray-500">Updated:</span>
                        <span class="text-gray-900">{{ $coinPackage->updated_at->format('M d, Y H:i') }}</span>
                    </div>
                </div>
            </div>


        </div>
    </div>
</div>
</x-admin-layout>