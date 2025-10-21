<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ForgotPasswordController extends Controller
{
    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password');
    }

    public function sendResetCode(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email'
        ]);

        $user = User::where('email', $request->email)->first();
        
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'No account found with this email address.'
            ]);
        }

        $code = $user->sendPasswordResetCode();

        return response()->json([
            'success' => true,
            'message' => 'Reset code sent to your email address.'
        ]);
    }

    public function resetWithCode(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'code' => 'required|string|size:6',
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $user = User::where('email', $request->email)->first();
        
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'No account found with this email address.'
            ]);
        }

        if (!$user->verifyPasswordResetCode($request->code)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid or expired verification code.'
            ]);
        }

        $success = $user->resetPasswordWithCode($request->code, $request->password);

        if ($success) {
            return response()->json([
                'success' => true,
                'message' => 'Password reset successfully.'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Failed to reset password. Please try again.'
        ]);
    }
}