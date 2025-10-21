<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            // Users Management
            ['name' => 'view-users', 'group' => 'Users'],
            ['name' => 'create-users', 'group' => 'Users'],
            ['name' => 'edit-users', 'group' => 'Users'],
            ['name' => 'delete-users', 'group' => 'Users'],

            // Admins Management
            ['name' => 'view-admins', 'group' => 'Admins'],
            ['name' => 'create-admins', 'group' => 'Admins'],
            ['name' => 'edit-admins', 'group' => 'Admins'],
            ['name' => 'delete-admins', 'group' => 'Admins'],

            // Roles Management
            ['name' => 'view-roles', 'group' => 'Roles'],
            ['name' => 'create-roles', 'group' => 'Roles'],
            ['name' => 'edit-roles', 'group' => 'Roles'],
            ['name' => 'delete-roles', 'group' => 'Roles'],

            // Permissions Management
            ['name' => 'view-permissions', 'group' => 'Permissions'],
            ['name' => 'create-permissions', 'group' => 'Permissions'],
            ['name' => 'edit-permissions', 'group' => 'Permissions'],
            ['name' => 'delete-permissions', 'group' => 'Permissions'],

            // Widget Permissions
            ['name' => 'view-users-widget', 'group' => 'Widgets'],
            ['name' => 'view-admins-widget', 'group' => 'Widgets'],
            ['name' => 'view-online-users-widget', 'group' => 'Widgets'],
            ['name' => 'view-active-users-widget', 'group' => 'Widgets'],
            ['name' => 'view-new-users-widget', 'group' => 'Widgets'],
            ['name' => 'view-roles-widget', 'group' => 'Widgets'],
            ['name' => 'view-permissions-widget', 'group' => 'Widgets'],
            ['name' => 'view-active-roles-widget', 'group' => 'Widgets'],
            ['name' => 'view-used-permissions-widget', 'group' => 'Widgets'],
            ['name' => 'view-weekly-active-users-widget', 'group' => 'Widgets'],
            ['name' => 'view-monthly-active-users-widget', 'group' => 'Widgets'],
            ['name' => 'view-yearly-active-users-widget', 'group' => 'Widgets'],
            ['name' => 'view-total-affiliated-users-widget', 'group' => 'Widgets'],
            ['name' => 'view-line-chart', 'group' => 'Widgets'],
            ['name' => 'view-pie-chart', 'group' => 'Widgets'],

            // Coin Transactions
            ['name' => 'manage coin transactions', 'group' => 'Coin Transactions'],

            // Revenue Management
            ['name' => 'view-revenue', 'group' => 'Revenue'],
            ['name' => 'manage-revenue', 'group' => 'Revenue'],
            
            // System Wallet Management
            ['name' => 'view-system-wallet', 'group' => 'System Wallet'],
            ['name' => 'manage-system-wallet', 'group' => 'System Wallet'],
            
            // Platform Wallet Management
            ['name' => 'view-platform-wallet', 'group' => 'Platform Wallet'],
            ['name' => 'manage-platform-wallet', 'group' => 'Platform Wallet'],

            // Notifications
            ['name' => 'receive-user-registered-notifications', 'group' => 'Notifications'],
            ['name' => 'receive-coin-transaction-notifications', 'group' => 'Notifications'],
            ['name' => 'receive-affiliate-notifications', 'group' => 'Notifications'],
            ['name' => 'receive-kyc-notifications', 'group' => 'Notifications'],
            ['name' => 'receive-idea-notifications', 'group' => 'Notifications'],
            ['name' => 'receive-order-notifications', 'group' => 'Notifications'],
            ['name' => 'receive-system-notifications', 'group' => 'Notifications'],
            ['name' => 'clear-notifications', 'group' => 'Notifications'],
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(
                ['name' => $permission['name'], 'guard_name' => 'admin'],
                ['group' => $permission['group']]
            );
        }
    }
}