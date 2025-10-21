<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Reserved Item Details') }}
            </h2>
            <a href="{{ route('admin.reserved.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Back to Reserved
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 lg:p-8 bg-white dark:bg-gray-800">
                    <div class="max-w-2xl">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Reserved Item Information</h3>
                        <dl class="space-y-4">
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Reserved Word</dt>
                                <dd class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $reserved->word }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Hash ID</dt>
                                <dd class="text-sm text-gray-900 dark:text-gray-100 font-mono">{{ $reserved->hashid ?? 'N/A' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Type</dt>
                                <dd class="text-sm text-gray-900 dark:text-gray-100">
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                        @if($reserved->type === 'route') bg-blue-100 text-blue-800
                                        @elseif($reserved->type === 'system') bg-red-100 text-red-800
                                        @else bg-gray-100 text-gray-800 @endif">
                                        {{ ucfirst($reserved->type) }}
                                    </span>
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Reason</dt>
                                <dd class="text-sm text-gray-900 dark:text-gray-100">{{ $reserved->reason ?? 'No reason provided' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Created At</dt>
                                <dd class="text-sm text-gray-900 dark:text-gray-100">{{ $reserved->created_at->format('M d, Y H:i') }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Updated At</dt>
                                <dd class="text-sm text-gray-900 dark:text-gray-100">{{ $reserved->updated_at->format('M d, Y H:i') }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>