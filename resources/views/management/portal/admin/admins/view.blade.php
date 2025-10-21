<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                {{ __('Admin Details') }}
            </h2>
            <div class="flex items-center space-x-3">
                @if(auth('admin')->user()->can('edit-admins'))
                <a href="{{ route('admin.admins.edit', $admin) }}" class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-yellow-600 border border-transparent rounded-md hover:bg-yellow-700 focus:bg-yellow-700 active:bg-yellow-900 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                    <i class="fas fa-edit mr-2"></i>
                    {{ __('Edit') }}
                </a>
                @endif
                <a href="{{ route('admin.admins.index') }}" class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-gray-700 uppercase transition duration-150 ease-in-out bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-700">
                    <i class="fas fa-arrow-left mr-2"></i>
                    {{ __('Back to Admins') }}
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-4xl sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
                <!-- Admin Information -->
                <div class="overflow-hidden bg-white shadow-xl dark:bg-gray-800 sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
                            Admin Information
                        </h3>
                        
                        <div class="flex items-center mb-6">
                            <img class="h-16 w-16 rounded-full" src="https://ui-avatars.com/api/?name={{ urlencode($admin->name) }}&background=ef4444&color=fff" alt="{{ $admin->name }}">
                            <div class="ml-4">
                                <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $admin->name }}</h4>
                                <p class="text-gray-600 dark:text-gray-400">{{ $admin->email }}</p>
                            </div>
                        </div>
                        
                        <dl class="space-y-4">
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Status</dt>
                                <dd class="mt-1">
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $admin->is_active ? 'bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-200' : 'bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-200' }}">
                                        {{ $admin->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </dd>
                            </div>
                            
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Created At</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                    {{ $admin->created_at->format('F j, Y \a\t g:i A') }}
                                </dd>
                            </div>
                            
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Last Updated</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                    {{ $admin->updated_at->format('F j, Y \a\t g:i A') }}
                                </dd>
                            </div>
                        </dl>
                    </div>
                </div>

                <!-- Roles & Permissions -->
                <div class="overflow-hidden bg-white shadow-xl dark:bg-gray-800 sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
                            Roles & Permissions
                        </h3>
                        
                        @if($admin->roles->count() > 0)
                            <div class="space-y-4">
                                @foreach($admin->roles as $role)
                                    <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                        <div class="flex items-center justify-between mb-2">
                                            <h4 class="font-medium text-gray-900 dark:text-gray-100">{{ $role->name }}</h4>
                                            <span class="text-xs text-gray-500 dark:text-gray-400">{{ $role->permissions->count() }} permissions</span>
                                        </div>
                                        @if($role->permissions->count() > 0)
                                            <div class="flex flex-wrap gap-1">
                                                @foreach($role->permissions->take(5) as $permission)
                                                    <span class="inline-flex px-2 py-1 text-xs font-medium text-blue-800 bg-blue-100 rounded dark:bg-blue-800 dark:text-blue-200">
                                                        {{ $permission->name }}
                                                    </span>
                                                @endforeach
                                                @if($role->permissions->count() > 5)
                                                    <span class="inline-flex px-2 py-1 text-xs font-medium text-gray-600 bg-gray-200 rounded dark:bg-gray-600 dark:text-gray-300">
                                                        +{{ $role->permissions->count() - 5 }} more
                                                    </span>
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8">
                                <i class="fas fa-user-tag text-4xl text-gray-400 dark:text-gray-600 mb-4"></i>
                                <p class="text-gray-500 dark:text-gray-400">
                                    No roles assigned to this admin.
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>