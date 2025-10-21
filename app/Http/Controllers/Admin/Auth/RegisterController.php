<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        $settings = \App\Models\Setting::first();
        
        if ($settings && $settings->hide_admin_registration) {
            abort(404);
        }
        
        return view('management.portal.admin.auth.register');
    }

    public function register(Request $request)
    {
        $settings = \App\Models\Setting::first();
        
        if ($settings && $settings->hide_admin_registration) {
            abort(404);
        }
        
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:admins'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        $admin = Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_active' => true,
        ]);

        Auth::guard('admin')->login($admin);

        return redirect(route('admin.dashboard'));
    }
}