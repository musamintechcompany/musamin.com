<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                {{ __('Edit Role: ') }}{{ $role->name }}
            </h2>
            <a href="{{ route('admin.roles.index') }}" class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-gray-700 uppercase transition duration-150 ease-in-out bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-700">
                <i class="fas fa-arrow-left mr-2"></i>
                {{ __('Back to Roles') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('admin.roles.update', $role) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-6">
                            <label for="name" class="block text-sm font-medium text-gray-700">Role Name</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $role->name) }}" 
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" 
                                   {{ $role->name === 'Super Admin' ? 'readonly' : 'required' }}>
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        @if($role->name !== 'Super Admin')
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
                                                @php
                                                    $hasPermission = $role->permissions->where('name', $permission->name)->first();
                                                @endphp
                                                <label class="flex items-center p-3 border rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 dark:border-gray-600">
                                                    <input type="checkbox" name="permissions[]" value="{{ $permission->name }}" 
                                                           class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600"
                                                           {{ $hasPermission ? 'checked' : '' }}>
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
                                </div>
                            @endif
                        </div>
                        @else
                        <div class="mb-6 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                            <p class="text-yellow-800">Super Admin has access to all permissions by default.</p>
                        </div>
                        @endif

                        <div class="flex items-center justify-end space-x-4">
                            <a href="{{ route('admin.roles.index') }}" class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-gray-700 uppercase transition duration-150 ease-in-out bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-700">
                                {{ __('Cancel') }}
                            </a>
                            <button type="submit" class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-purple-600 border border-transparent rounded-md hover:bg-purple-700 focus:bg-purple-700 active:bg-purple-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                                <i class="fas fa-save mr-2"></i>
                                {{ __('Update Role') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


</x-admin-layout>