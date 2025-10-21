<x-admin-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Welcome Message Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-xl dark:bg-gray-800 sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ $welcome->title }}</h3>
                        <div class="flex space-x-2">
                            <a href="{{ route('admin.welcomes.edit', $welcome) }}" class="px-4 py-2 text-sm font-medium text-white bg-yellow-600 rounded-md hover:bg-yellow-700">
                                Edit
                            </a>
                            <a href="{{ route('admin.welcomes.index') }}" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 rounded-md hover:bg-gray-300">
                                Back to List
                            </a>
                        </div>
                    </div>

                    @if(session('success'))
                        <div class="p-4 mb-4 text-green-700 bg-green-100 border border-green-300 rounded dark:bg-green-800 dark:text-green-200">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                        <div>
                            <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300">Title</h4>
                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $welcome->title }}</p>
                        </div>

                        <div>
                            <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300">Status</h4>
                            <span class="inline-flex px-2 mt-1 text-xs font-semibold leading-5 rounded-full {{ $welcome->is_active ? 'text-green-800 bg-green-100' : 'text-red-800 bg-red-100' }}">
                                {{ $welcome->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </div>

                        <div>
                            <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300">Text Color</h4>
                            <div class="flex items-center mt-1">
                                <div class="w-6 h-6 border border-gray-300 rounded" style="background-color: {{ $welcome->text_color ?? '#ffffff' }}"></div>
                                <span class="ml-2 text-sm text-gray-900 dark:text-gray-100">{{ $welcome->text_color ?? '#ffffff' }}</span>
                            </div>
                        </div>

                        <div>
                            <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300">Created</h4>
                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $welcome->created_at->format('M d, Y H:i') }}</p>
                        </div>
                    </div>

                    <div class="mt-6">
                        <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300">Message Body</h4>
                        <div class="p-4 mt-1 bg-gray-50 border border-gray-200 rounded dark:bg-gray-700 dark:border-gray-600">
                            <p class="text-sm text-gray-900 dark:text-gray-100">{{ $welcome->body }}</p>
                        </div>
                    </div>

                    @if($welcome->explore_link)
                        <div class="mt-6">
                            <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300">Explore Link</h4>
                            <a href="{{ $welcome->explore_link }}" target="_blank" class="mt-1 text-sm text-blue-600 hover:text-blue-800 dark:text-blue-400">
                                {{ $welcome->explore_link }}
                            </a>
                        </div>
                    @endif

                    @if($welcome->image)
                        <div class="mt-6">
                            <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300">Background Image</h4>
                            <div class="mt-2">
                                <img src="{{ asset('storage/' . $welcome->image) }}" alt="Welcome Image" class="max-w-md rounded-lg shadow-md">
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>