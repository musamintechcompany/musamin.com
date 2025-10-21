@if(auth('admin')->user()->can('view-permissions-widget'))
<div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-4 shadow-sm">
    <div class="mb-3">
        <p class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">Total Permissions</p>
        <div class="flex items-center">
            <i class="fas fa-shield-alt text-xl mr-3 text-blue-600 dark:text-blue-400"></i>
            <p class="text-2xl font-bold text-gray-900 dark:text-white" data-stat="Total Permissions">{{ \Spatie\Permission\Models\Permission::where('guard_name', 'admin')->count() }}</p>
        </div>
        
        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
            System permissions
        </p>
    </div>
</div>
@endif