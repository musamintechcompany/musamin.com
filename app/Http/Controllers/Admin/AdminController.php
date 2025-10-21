<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{
    public function index()
    {
        $admins = Admin::with('roles')->orderBy('created_at', 'desc')->paginate(15);
        return view('management.portal.admin.admins.index', compact('admins'));
    }

    public function create()
    {
        $roles = Role::where('guard_name', 'admin')->get();
        return view('management.portal.admin.admins.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:admins',
            'password' => 'required|string|min:8|confirmed',
            'roles' => 'array'
        ]);

        $admin = Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_active' => true
        ]);

        if ($request->roles) {
            $admin->assignRole($request->roles);
        }

        return redirect()->route('admin.admins.index')
            ->with('success', 'Admin created successfully.');
    }

    public function view(Admin $admin)
    {
        $admin->load('roles.permissions');
        return view('management.portal.admin.admins.view', compact('admin'));
    }

    public function edit(Admin $admin)
    {
        $roles = Role::where('guard_name', 'admin')->get();
        $admin->load('roles');
        return view('management.portal.admin.admins.edit', compact('admin', 'roles'));
    }

    public function update(Request $request, Admin $admin)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:admins,email,' . $admin->id,
            'password' => 'nullable|string|min:8|confirmed',
            'roles' => 'array',
            'is_active' => 'boolean'
        ]);

        $admin->update([
            'name' => $request->name,
            'email' => $request->email,
            'is_active' => $request->boolean('is_active', true)
        ]);

        if ($request->password) {
            $admin->update(['password' => Hash::make($request->password)]);
        }

        $admin->syncRoles($request->roles ?? []);

        return redirect()->route('admin.admins.index')
            ->with('success', 'Admin updated successfully.');
    }

    public function destroy(Admin $admin)
    {
        if ($admin->id === auth('admin')->id()) {
            return redirect()->route('admin.admins.index')
                ->with('error', 'You cannot delete your own account.');
        }

        if ($admin->hasRole('Super Admin')) {
            return redirect()->route('admin.admins.index')
                ->with('error', 'Cannot delete Super Admin user.');
        }

        $admin->delete();

        return redirect()->route('admin.admins.index')
            ->with('success', 'Admin deleted successfully.');
    }
}