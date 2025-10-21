<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Idea Details') }}
            </h2>
            <a href="{{ route('admin.ideas.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Back to Ideas
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 lg:p-8 bg-white dark:bg-gray-800">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Idea Information</h3>
                            <dl class="space-y-4">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Title</dt>
                                    <dd class="text-sm text-gray-900 dark:text-gray-100 font-semibold">{{ $idea->title ?? 'N/A' }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Category</dt>
                                    <dd class="text-sm text-gray-900 dark:text-gray-100">
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                            {{ $idea->custom_category ?: ucfirst(str_replace('-', ' ', $idea->category)) }}
                                        </span>
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Description</dt>
                                    <dd class="text-sm text-gray-900 dark:text-gray-100 whitespace-pre-wrap">{{ $idea->description ?? 'No description' }}</dd>
                                </div>
                                @if($idea->benefits)
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Expected Benefits</dt>
                                    <dd class="text-sm text-gray-900 dark:text-gray-100 whitespace-pre-wrap">{{ $idea->benefits }}</dd>
                                </div>
                                @endif
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Status</dt>
                                    <dd class="text-sm text-gray-900 dark:text-gray-100">
                                        @if($idea->status === 'seen')
                                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                                Seen
                                            </span>
                                        @else
                                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                                                New
                                            </span>
                                        @endif
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Submitted</dt>
                                    <dd class="text-sm text-gray-900 dark:text-gray-100">{{ $idea->created_at->format('M d, Y H:i') }}</dd>
                                </div>
                            </dl>
                        </div>

                        <div>
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Submitted By</h3>
                            <div class="flex items-center space-x-4 mb-6">
                                <img class="h-16 w-16 rounded-full" src="https://ui-avatars.com/api/?name={{ urlencode($idea->user->name) }}&background=6366f1&color=fff" alt="">
                                <div>
                                    <h4 class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ $idea->user->name }}</h4>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $idea->user->email }}</p>

                                </div>
                            </div>
                            
                            @if($idea->media_files && count($idea->media_files) > 0)
                            <div>
                                <h4 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-3">Attached Files</h4>
                                <div class="grid grid-cols-2 gap-3">
                                    @foreach($idea->media_files as $file)
                                        <div class="border border-gray-200 dark:border-gray-600 rounded-lg p-3">
                                            @if(in_array(pathinfo($file, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif']))
                                                <img src="{{ asset('storage/' . $file) }}" alt="Attachment" class="w-full h-32 object-cover rounded mb-2">
                                            @else
                                                <div class="w-full h-32 bg-gray-100 dark:bg-gray-700 rounded mb-2 flex items-center justify-center">
                                                    <svg class="w-8 h-8 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"></path>
                                                    </svg>
                                                </div>
                                            @endif
                                            <p class="text-xs text-gray-500 dark:text-gray-400 truncate">{{ basename($file) }}</p>
                                            <a href="{{ asset('storage/' . $file) }}" target="_blank" class="text-xs text-blue-600 hover:text-blue-800 dark:text-blue-400">View File</a>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>

                    <div class="mt-6 flex justify-between">
                        @if($idea->status !== 'seen')
                            <form action="{{ route('admin.ideas.mark-seen', $idea) }}" method="POST" class="inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                    Mark as Seen
                                </button>
                            </form>
                        @else
                            <span class="text-green-600 font-semibold">✓ Marked as Seen</span>
                        @endif
                        
                        <form action="{{ route('admin.ideas.destroy', $idea) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" onclick="return confirm('Are you sure?')">
                                Delete Idea
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>