<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        $admin = Auth::guard('admin')->user();
        return view('management.portal.admin.profile.index', compact('admin'));
    }

    public function updateTheme(Request $request)
    {
        $request->validate([
            'theme' => 'required|in:light,dark'
        ]);

        Auth::guard('admin')->user()->update([
            'theme' => $request->theme
        ]);

        return response()->json(['success' => true]);
    }
}