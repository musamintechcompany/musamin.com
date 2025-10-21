<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionController extends Controller
{
    public function index()
    {
        $permissions = Permission::where('guard_name', 'admin')
            ->orderBy('group')
            ->orderBy('name')
            ->paginate(50);
        
        $widgets = $this->getPermissionWidgets();

        return view('management.portal.admin.permissions.index', compact('permissions', 'widgets'));
    }

    public function getGroups()
    {
        return ['Users', 'Admins', 'Roles', 'Permissions', 'Widgets', 'Other'];
    }

    private function getPermissionWidgets()
    {
        $widgets = [];
        $admin = auth('admin')->user();
        
        if ($admin->can('view-permissions-widget')) {
            $widgets[] = [
                'title' => 'Total Permissions',
                'value' => Permission::where('guard_name', 'admin')->count(),
                'icon' => 'shield-alt',
                'color' => 'blue',
                'subtitle' => 'System permissions'
            ];
        }

        if ($admin->can('view-used-permissions-widget')) {
            $widgets[] = [
                'title' => 'Used Permissions',
                'value' => Permission::where('guard_name', 'admin')->whereHas('roles')->count(),
                'icon' => 'check-shield',
                'color' => 'green',
                'subtitle' => 'Assigned to roles'
            ];
        }

        if ($admin->can('view-roles-widget')) {
            $widgets[] = [
                'title' => 'Available Roles',
                'value' => Role::where('guard_name', 'admin')->count(),
                'icon' => 'user-tag',
                'color' => 'purple',
                'subtitle' => 'Total roles'
            ];
        }

        return $widgets;
    }

    public function create()
    {
        $groups = $this->getGroups();
        return view('management.portal.admin.permissions.create', compact('groups'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:permissions,name',
            'group' => 'required|string|in:' . implode(',', $this->getGroups())
        ]);

        Permission::create([
            'name' => $request->name,
            'guard_name' => 'admin',
            'group' => $request->group
        ]);

        return redirect()->route('admin.permissions.index')
            ->with('success', 'Permission created successfully.');
    }

    public function view(Permission $permission)
    {
        $roles = Role::where('guard_name', 'admin')
            ->whereHas('permissions', function($query) use ($permission) {
                $query->where('permissions.id', $permission->id);
            })
            ->get();

        return view('management.portal.admin.permissions.view', compact('permission', 'roles'));
    }

    public function edit(Permission $permission)
    {
        $groups = $this->getGroups();
        return view('management.portal.admin.permissions.edit', compact('permission', 'groups'));
    }

    public function update(Request $request, Permission $permission)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:permissions,name,' . $permission->id,
            'group' => 'required|string|in:' . implode(',', $this->getGroups())
        ]);

        $permission->update([
            'name' => $request->name,
            'group' => $request->group
        ]);

        return redirect()->route('admin.permissions.index')
            ->with('success', 'Permission updated successfully.');
    }

    public function destroy(Permission $permission)
    {
        $permission->delete();

        return redirect()->route('admin.permissions.index')
            ->with('success', 'Permission deleted successfully.');
    }

    public function getWidgetsData()
    {
        $widgets = $this->getPermissionWidgets();
        return response()->json($widgets);
    }
}