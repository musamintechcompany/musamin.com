<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules\Password;
use App\Mail\PasswordChangedSecurityAlert;

class PasswordChangeController extends Controller
{
    public function sendCode(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $user = $request->user();
        
        // Check if email verification is required from admin settings
        $settings = \App\Models\Setting::first();
        $verificationRequired = $settings ? $settings->email_verification_required : false;

        if ($verificationRequired) {
            // Store new password temporarily in session
            session([
                'pending_password' => $request->password,
                'password_change_initiated' => true
            ]);
            
            // Send verification code
            $user->sendPasswordResetCode();
            
            return response()->json([
                'success' => true,
                'verification_required' => true,
                'message' => 'Verification code sent to your email'
            ]);
        } else {
            // Change password directly
            $user->update([
                'password' => Hash::make($request->password)
            ]);
            
            return response()->json([
                'success' => true,
                'verification_required' => false,
                'message' => 'Password changed successfully'
            ]);
        }
    }

    public function verifyAndChange(Request $request)
    {
        $request->validate([
            'verification_code' => ['required', 'string', 'size:6']
        ]);

        $user = $request->user();
        $pendingPassword = session('pending_password');
        
        if (!$pendingPassword || !session('password_change_initiated')) {
            return response()->json([
                'success' => false,
                'message' => 'No password change in progress'
            ], 400);
        }

        if ($user->verifyPasswordResetCode($request->verification_code)) {
            $user->update([
                'password' => Hash::make($pendingPassword),
                'password_reset_code' => null,
                'password_reset_code_expires_at' => null
            ]);
            
            // Clear session
            session()->forget(['pending_password', 'password_change_initiated']);
            
            // Send security alert email
            Mail::to($user->email)
                ->queue((new PasswordChangedSecurityAlert($user))->onQueue('emails'));
            
            return response()->json([
                'success' => true,
                'message' => 'Password changed successfully'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Invalid or expired verification code'
        ], 400);
    }
}