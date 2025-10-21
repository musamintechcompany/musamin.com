<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class EmailVerificationController extends Controller
{


    /**
     * Initiate email change process.
     */
    public function initiateChange(Request $request)
    {
        try {
            $user = $request->user();
            
            $request->validate([
                'email' => ['required', 'email', 'unique:users,email,' . $user->id . ',id']
            ]);

            // Check if email verification is required from admin settings
            $settings = \App\Models\Setting::first();
            $verificationRequired = $settings ? $settings->email_verification_required : false;

            if ($verificationRequired) {
                // Send verification code
                $user->initiateEmailChange($request->email);
                
                return response()->json([
                    'success' => true,
                    'verification_required' => true,
                    'message' => 'Verification code sent to your new email address'
                ]);
            } else {
                // Update email directly
                $user->update(['email' => $request->email]);
                
                return response()->json([
                    'success' => true,
                    'verification_required' => false,
                    'message' => 'Email updated successfully'
                ]);
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'The email address is already taken or invalid.'
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while changing email.'
            ], 500);
        }
    }

    /**
     * Verify and complete email change.
     */
    public function verifyChange(Request $request)
    {
        try {
            $request->validate([
                'verification_code' => ['required', 'string', 'size:6']
            ]);

            $user = $request->user();
            $result = $user->completeEmailChange($request->verification_code);
            
            if ($result['success']) {
                return response()->json($result);
            }

            return response()->json($result, 400);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while verifying email change.'
            ], 500);
        }
    }

    /**
     * Verify email with 6-digit code.
     */
    public function verifyCode(Request $request)
    {
        $request->validate([
            'code' => ['required', 'string', 'size:6']
        ]);

        $user = $request->user();
        
        if (!$user) {
            return redirect()->route('login');
        }

        if ($user->hasVerifiedEmail()) {
            return redirect()->route('dashboard')
                ->with('status', 'Email already verified!');
        }

        $result = $user->verifyWithCode($request->code);
        
        if ($result) {
            return redirect()->route('dashboard')
                ->with('status', 'Email verified successfully!');
        }

        return back()->withErrors([
            'code' => 'Invalid or expired verification code.',
        ]);
    }
}