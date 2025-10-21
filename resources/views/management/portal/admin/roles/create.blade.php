<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                {{ __('Create Role') }}
            </h2>
            <a href="{{ route('admin.roles.index') }}" class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-gray-700 uppercase transition duration-150 ease-in-out bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-700">
                <i class="fas fa-arrow-left mr-2"></i>
                {{ __('Back to Roles') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-4xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-xl dark:bg-gray-800 sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700">
                    <form action="{{ route('admin.roles.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-6">
                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Role Name <span class="text-red-500">*</span></label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" 
                                   class="mt-1 block w-full rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white {{ $errors->has('name') ? 'border-red-500' : 'border-gray-300 dark:border-gray-600' }}" 
                                   placeholder="e.g., Manager, Editor, Viewer" required>
                            @error('name')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Available Permissions</h3>
                            
                            @if($allPermissions->count() > 0)
                                @php
                                    $groupedPermissions = $allPermissions->groupBy('group');
                                @endphp
                                
                                @foreach($groupedPermissions as $group => $permissions)
                                    <div class="mb-6">
                                        <h4 class="text-md font-medium text-gray-800 dark:text-gray-200 mb-3 px-3 py-2 bg-gray-100 dark:bg-gray-700 rounded">
                                            <i class="fas fa-{{ $group === 'Users' ? 'users' : ($group === 'Admins' ? 'user-shield' : ($group === 'Roles' ? 'user-tag' : ($group === 'Permissions' ? 'key' : ($group === 'Widgets' ? 'chart-bar' : 'cog')))) }} mr-2"></i>
                                            {{ $group }} ({{ $permissions->count() }})
                                        </h4>
                                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                                            @foreach($permissions as $permission)
                                                <label class="flex items-center p-3 border rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 dark:border-gray-600">
                                                    <input type="checkbox" name="permissions[]" value="{{ $permission->name }}" 
                                                           class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600">
                                                    <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">{{ $permission->name }}</span>
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="text-center py-8">
                                    <i class="fas fa-key text-4xl text-gray-400 dark:text-gray-600 mb-4"></i>
                                    <p class="text-gray-500 dark:text-gray-400">
                                        No permissions found. Please create some permissions first.
                                    </p>
                                    <a href="{{ route('admin.permissions.create') }}" class="mt-4 inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-purple-600 border border-transparent rounded-md hover:bg-purple-700 focus:bg-purple-700 active:bg-purple-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                                        <i class="fas fa-plus mr-2"></i>
                                        Create Permission
                                    </a>
                                </div>
                            @endif
                        </div>

                        <div class="flex items-center justify-end space-x-3">
                            <a href="{{ route('admin.roles.index') }}" class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-gray-700 uppercase transition duration-150 ease-in-out bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-700">
                                {{ __('Cancel') }}
                            </a>
                            <button type="submit" class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-purple-600 border border-transparent rounded-md hover:bg-purple-700 focus:bg-purple-700 active:bg-purple-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                                <i class="fas fa-save mr-2"></i>
                                {{ __('Create Role') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


</x-admin-layout>