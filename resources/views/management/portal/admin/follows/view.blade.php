<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Follow Relationship Details') }}
            </h2>
            <a href="{{ route('admin.follows.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Back to Follows
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 lg:p-8 bg-white dark:bg-gray-800">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Follower</h3>
                            <div class="flex items-center space-x-4">
                                <img class="h-16 w-16 rounded-full" src="https://ui-avatars.com/api/?name={{ urlencode($follow->follower->name) }}&background=6366f1&color=fff" alt="">
                                <div>
                                    <h4 class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ $follow->follower->name }}</h4>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $follow->follower->email }}</p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Joined {{ $follow->follower->created_at->format('M d, Y') }}</p>
                                </div>
                            </div>
                        </div>

                        <div>
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Following</h3>
                            <div class="flex items-center space-x-4">
                                <img class="h-16 w-16 rounded-full" src="https://ui-avatars.com/api/?name={{ urlencode($follow->following->name) }}&background=22c55e&color=fff" alt="">
                                <div>
                                    <h4 class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ $follow->following->name }}</h4>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $follow->following->email }}</p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Joined {{ $follow->following->created_at->format('M d, Y') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Relationship Details</h3>
                        <dl class="space-y-3">
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Started Following</dt>
                                <dd class="text-sm text-gray-900 dark:text-gray-100">{{ $follow->created_at->format('M d, Y H:i') }}</dd>
                            </div>
                        </dl>
                    </div>

                    <div class="mt-6 flex justify-end">
                        <form action="{{ route('admin.follows.destroy', $follow) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" onclick="return confirm('Are you sure you want to remove this follow relationship?')">
                                Remove Follow Relationship
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>