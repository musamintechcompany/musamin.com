<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        // Run PermissionSeeder first
        $this->call(PermissionSeeder::class);

        // Create Super Admin role
        $superAdminRole = Role::firstOrCreate([
            'name' => 'Super Admin',
            'guard_name' => 'admin'
        ]);

        // Assign all permissions to Super Admin role
        $superAdminRole->syncPermissions(Permission::where('guard_name', 'admin')->get());

        // Create Super Admin user
        $admin = Admin::firstOrCreate([
            'email' => 'admin@musamin.com'
        ], [
            'name' => 'Super Admin',
            'password' => Hash::make('Osaretine@70'),
            'is_active' => true,
        ]);

        // Assign Super Admin role
        $admin->assignRole('Super Admin');

        $this->command->info('Super Admin setup completed!');
        $this->command->info('Email: admin@musamin.com');
        $this->command->info('Password: Osaretine@70');
        $this->command->info('Role: Super Admin (All Permissions)');
    }
}
