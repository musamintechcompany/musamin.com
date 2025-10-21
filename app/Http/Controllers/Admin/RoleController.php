<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::where('guard_name', 'admin')
            ->with('permissions')
            ->orderBy('name')
            ->get();
        
        $widgets = $this->getRoleWidgets();

        return view('management.portal.admin.roles.index', compact('roles', 'widgets'));
    }

    private function getRoleWidgets()
    {
        $widgets = [];
        $admin = auth('admin')->user();
        
        if ($admin->can('view-roles-widget')) {
            $widgets[] = [
                'title' => 'Total Roles',
                'value' => Role::where('guard_name', 'admin')->count(),
                'icon' => 'user-tag',
                'color' => 'purple',
                'subtitle' => 'Admin roles'
            ];
        }

        if ($admin->can('view-permissions-widget')) {
            $widgets[] = [
                'title' => 'Total Permissions',
                'value' => Permission::where('guard_name', 'admin')->count(),
                'icon' => 'shield-alt',
                'color' => 'blue',
                'subtitle' => 'Available permissions'
            ];
        }

        if ($admin->can('view-active-roles-widget')) {
            $widgets[] = [
                'title' => 'Active Roles',
                'value' => Role::where('guard_name', 'admin')->has('permissions')->count(),
                'icon' => 'check-circle',
                'color' => 'green',
                'subtitle' => 'Roles with permissions'
            ];
        }

        return $widgets;
    }

    public function create()
    {
        $allPermissions = Permission::where('guard_name', 'admin')->orderBy('name')->get();
        
        return view('management.portal.admin.roles.create', compact('allPermissions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
            'permissions' => 'array'
        ]);

        $role = Role::create([
            'name' => $request->name,
            'guard_name' => 'admin'
        ]);

        if ($request->permissions) {
            $role->givePermissionTo($request->permissions);
        }

        return redirect()->route('admin.roles.index')
            ->with('success', 'Role created successfully.');
    }

    public function view(Role $role)
    {
        $role->load('permissions');
        return view('management.portal.admin.roles.view', compact('role'));
    }

    public function edit(Role $role)
    {
        $allPermissions = Permission::where('guard_name', 'admin')->orderBy('name')->get();
        $role->load('permissions');

        return view('management.portal.admin.roles.edit', compact('role', 'allPermissions'));
    }

    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $role->id,
            'permissions' => 'array'
        ]);

        if ($role->name !== 'Super Admin') {
            $role->update(['name' => $request->name]);
            $role->syncPermissions($request->permissions ?? []);
        }

        return redirect()->route('admin.roles.index')
            ->with('success', 'Role updated successfully.');
    }

    public function destroy(Role $role)
    {
        if ($role->name === 'Super Admin') {
            return redirect()->route('admin.roles.index')
                ->with('error', 'Cannot delete Super Admin role.');
        }

        $role->delete();

        return redirect()->route('admin.roles.index')
            ->with('success', 'Role deleted successfully.');
    }

    public function getWidgetsData()
    {
        $widgets = $this->getRoleWidgets();
        return response()->json($widgets);
    }
}