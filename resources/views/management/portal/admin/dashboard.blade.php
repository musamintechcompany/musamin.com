<x-admin-layout title="Admin Dashboard">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Admin Dashboard</h1>
            <p class="text-gray-600 dark:text-gray-400">Welcome back, {{ auth('admin')->user()->name }}!</p>
        </div>

        <!-- Widgets Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            <x-widgets.admin.users.total-users />
            <x-widgets.admin.users.active-users />
            <x-widgets.admin.users.new-users />
            <x-widgets.admin.assets.total-assets />
            <x-widgets.admin.assets.pending-inspection />
            <x-widgets.admin.assets.live-assets />
            <x-widgets.admin.revenue.total-revenue />
            <x-widgets.admin.revenue.monthly-revenue />
            <x-widgets.admin.revenue.total-orders />
            <x-widgets.admin.system.online-users />
            <x-widgets.admin.system.weekly-active-users />
            <x-widgets.admin.system.monthly-active-users />
            <x-widgets.admin.system.yearly-active-users />
            <x-widgets.admin.users.total-affiliated-users />
            <x-widgets.admin.system.total-admins />
            <x-widgets.admin.roles.total-roles />
            <x-widgets.admin.permissions.total-permissions />
        </div>

        <!-- Chart Widgets -->
        <div class="mb-8">
            <x-widgets.admin.dashboard.line-chart />
        </div>
        
        <div class="mb-8">
            <x-widgets.admin.dashboard.pie-chart />
        </div>

    </div>

    <x-widgets.realtime-updater />

</x-admin-layout>