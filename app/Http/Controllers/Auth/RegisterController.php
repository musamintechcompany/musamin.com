<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Auth\Events\Registered;



class RegisterController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Password::defaults()],
            'terms' => 'accepted',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Fire Registered event for email verification and admin notifications
        event(new Registered($user));

        // Handle login/redirect based on verification requirement
        if ($user->isEmailVerificationRequired()) {
            Auth::login($user);
            return redirect()->route('verification.notice')
                ->with('status', 'verification-link-sent');
        } else {
            Auth::login($user);
            return redirect()->route('dashboard');
        }
    }
}