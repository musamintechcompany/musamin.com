<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use PragmaRX\Google2FA\Google2FA;
use PragmaRX\Google2FAQRCode\Google2FA as Google2FAQRCode;
use Illuminate\Support\Str;

class UserController extends Controller
{
    /**
     * Update the user's address details
     */
    public function updateAddress(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'country' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'city' => 'required|string|max:100',
            'postal_code' => 'required|string|max:20',
            'address' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $user = User::find(Auth::id());
            $user->update([
                'country' => $request->country,
                'state' => $request->state,
                'city' => $request->city,
                'postal_code' => $request->postal_code,
                'address' => $request->address
            ]);

            $user->refresh();

            return response()->json([
                'success' => true,
                'message' => 'Address updated successfully',
                'user' => $user->only(['country', 'state', 'city', 'postal_code', 'address'])
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update address',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    public function getCoinBalance()
    {
        $user = Auth::user();
        
        return response()->json([
            'balance' => $user->spendable_coins ?? 0,
            'spendable_coins' => $user->spendable_coins ?? 0,
            'earned_coins' => $user->earned_coins ?? 0
        ]);
    }

    /**
     * Update user theme preference
     */
    public function updateTheme(Request $request)
    {
        $validated = $request->validate([
            'theme' => 'required|in:light,dark'
        ]);

        $request->user()->update([
            'theme' => $validated['theme']
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Theme preference updated successfully',
            'theme' => $validated['theme']
        ]);
    }

    /**
     * Send phone verification code
     */
    public function sendPhoneVerification(Request $request)
    {
        $validated = $request->validate([
            'phone' => 'required|string|max:20'
        ]);

        $user = $request->user();
        $user->update(['phone' => $validated['phone']]);
        
        $result = $user->sendPhoneVerificationCode();
        
        return response()->json($result);
    }

    /**
     * Verify phone with code
     */
    public function verifyPhone(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|size:6'
        ]);

        $user = $request->user();
        $verified = $user->verifyPhone($validated['code']);
        
        if ($verified) {
            return response()->json([
                'success' => true,
                'message' => 'Phone verified successfully'
            ]);
        }
        
        return response()->json([
            'success' => false,
            'message' => 'Invalid or expired verification code'
        ], 422);
    }

    /**
     * Update name
     */
    public function updateName(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|min:2|max:100|regex:/^[a-zA-Z0-9\s\'-\.]+$/'
            ]);

            $user = $request->user();
            
            // Check if user can change name (first time or 7 days passed)
            if ($user->name_last_changed_at && $user->name_last_changed_at->gt(now()->subDays(7))) {
                $nextAllowed = $user->name_last_changed_at->addDays(7);
                return response()->json([
                    'success' => false,
                    'message' => 'You can change your name again on ' . $nextAllowed->format('M j, Y')
                ], 422);
            }

            $user->update([
                'name' => $validated['name'],
                'name_last_changed_at' => now()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Name updated successfully'
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->validator->errors()->first()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating name'
            ], 500);
        }
    }

    /**
     * Update username
     */
    public function updateUsername(Request $request)
    {
        try {
            $validated = $request->validate([
                'username' => 'required|string|max:50|unique:users,username,' . $request->user()->id
            ]);

            $user = $request->user();
            $username = $validated['username'];
            
            // Ensure username starts with @
            if (!str_starts_with($username, '@')) {
                $username = '@' . $username;
            }
            
            // Check if user can change username (first time or 30 days passed)
            if ($user->username_last_changed_at && $user->username_last_changed_at->gt(now()->subDays(30))) {
                $nextAllowed = $user->username_last_changed_at->addDays(30);
                return response()->json([
                    'success' => false,
                    'message' => 'You can change your username again on ' . $nextAllowed->format('M j, Y')
                ], 422);
            }

            $user->update([
                'username' => $username,
                'username_last_changed_at' => now()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Username updated successfully',
                'username' => $username
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Username already exists'
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating username'
            ], 500);
        }
    }

    /**
     * Enable Two-Factor Authentication
     */
    public function enableTwoFactor(Request $request)
    {
        $user = $request->user();
        
        if ($user->two_factor_confirmed_at) {
            return response()->json([
                'success' => false,
                'message' => 'Two-factor authentication is already enabled'
            ], 422);
        }

        $google2fa = new Google2FA();
        $secretKey = $google2fa->generateSecretKey();
        
        $user->update([
            'two_factor_secret' => encrypt($secretKey),
            'two_factor_recovery_codes' => encrypt(json_encode($this->generateRecoveryCodes()))
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Two-factor authentication setup initiated',
            'secret_key' => $secretKey,
            'qr_code_url' => $this->generateQRCodeUrl($user, $secretKey)
        ]);
    }

    /**
     * Confirm Two-Factor Authentication
     */
    public function confirmTwoFactor(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|size:6'
        ]);

        $user = $request->user();
        
        if (!$user->two_factor_secret) {
            return response()->json([
                'success' => false,
                'message' => 'Two-factor authentication not initiated'
            ], 422);
        }

        $google2fa = new Google2FA();
        $secretKey = decrypt($user->two_factor_secret);
        
        $valid = $google2fa->verifyKey($secretKey, $validated['code']);
        
        if ($valid) {
            $user->update([
                'two_factor_confirmed_at' => now()
            ]);
            
            // Clear session flags and set recovery codes flag
            session()->forget(['2fa_showing_qr', '2fa_showing_confirmation']);
            session(['2fa_showing_recovery' => true]);
            
            return response()->json([
                'success' => true,
                'message' => 'Two-factor authentication enabled successfully',
                'recovery_codes' => json_decode(decrypt($user->two_factor_recovery_codes))
            ]);
        }
        
        return response()->json([
            'success' => false,
            'message' => 'Invalid authentication code'
        ], 422);
    }

    /**
     * Disable Two-Factor Authentication
     */
    public function disableTwoFactor(Request $request)
    {
        $validated = $request->validate([
            'password' => 'required|string'
        ]);

        $user = $request->user();
        
        if (!\Hash::check($validated['password'], $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid password'
            ], 422);
        }

        $user->update([
            'two_factor_secret' => null,
            'two_factor_recovery_codes' => null,
            'two_factor_confirmed_at' => null
        ]);

        // Clear all 2FA session flags
        session()->forget(['2fa_showing_qr', '2fa_showing_confirmation', '2fa_showing_recovery']);

        return response()->json([
            'success' => true,
            'message' => 'Two-factor authentication disabled successfully'
        ]);
    }

    /**
     * Show Recovery Codes
     */
    public function showRecoveryCodes(Request $request)
    {
        $user = $request->user();
        
        if (!$user->two_factor_confirmed_at || !$user->two_factor_recovery_codes) {
            return response()->json([
                'success' => false,
                'message' => 'Two-factor authentication not enabled'
            ], 422);
        }

        return response()->json([
            'success' => true,
            'recovery_codes' => json_decode(decrypt($user->two_factor_recovery_codes))
        ]);
    }

    /**
     * Regenerate Recovery Codes
     */
    public function regenerateRecoveryCodes(Request $request)
    {
        $user = $request->user();
        
        if (!$user->two_factor_confirmed_at) {
            return response()->json([
                'success' => false,
                'message' => 'Two-factor authentication not enabled'
            ], 422);
        }

        $recoveryCodes = $this->generateRecoveryCodes();
        
        $user->update([
            'two_factor_recovery_codes' => encrypt(json_encode($recoveryCodes))
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Recovery codes regenerated successfully',
            'recovery_codes' => $recoveryCodes
        ]);
    }

    /**
     * Generate QR Code URL
     */
    private function generateQRCodeUrl($user, $secretKey)
    {
        $google2fa = new Google2FAQRCode();
        
        return $google2fa->getQRCodeInline(
            config('app.name'),
            $user->email,
            $secretKey
        );
    }

    /**
     * Generate Recovery Codes
     */
    private function generateRecoveryCodes()
    {
        $codes = [];
        for ($i = 0; $i < 8; $i++) {
            $codes[] = Str::random(10);
        }
        return $codes;
    }

    /**
     * Logout other browser sessions
     */
    public function logoutOtherSessions(Request $request)
    {
        $validated = $request->validate([
            'password' => 'required|string'
        ]);

        if (!\Hash::check($validated['password'], $request->user()->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid password'
            ], 422);
        }

        // Get current session ID
        $currentSessionId = $request->session()->getId();
        
        // Delete all other sessions for this user
        \DB::table('sessions')
            ->where('user_id', $request->user()->id)
            ->where('id', '!=', $currentSessionId)
            ->delete();
            
        // Also use Laravel's method for additional cleanup
        \Auth::logoutOtherDevices($validated['password']);

        return response()->json([
            'success' => true,
            'message' => 'Successfully logged out other browser sessions'
        ]);
    }

    /**
     * Update profile photo
     */
    public function updateProfilePhoto(Request $request)
    {
        $validated = $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        try {
            $user = $request->user();
            
            // Delete old photo if exists
            if ($user->profile_photo_path) {
                \Storage::disk('public')->delete($user->profile_photo_path);
            }
            
            // Store new photo
            $path = $request->file('photo')->store('profile-photos', 'public');
            
            $user->update([
                'profile_photo_path' => $path
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Profile photo updated successfully',
                'photo_url' => $user->profile_photo_url
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error uploading photo: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove profile photo
     */
    public function removeProfilePhoto(Request $request)
    {
        try {
            $user = $request->user();
            
            if ($user->profile_photo_path) {
                \Storage::disk('public')->delete($user->profile_photo_path);
                
                $user->update([
                    'profile_photo_path' => null
                ]);
            }
            
            return response()->json([
                'success' => true,
                'message' => 'Profile photo removed successfully'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error removing photo: ' . $e->getMessage()
            ], 500);
        }
    }





    /**
     * Update phone number with SMS verification if enabled
     */
    public function updatePhone(Request $request)
    {
        try {
            $validated = $request->validate([
                'phone' => 'nullable|string|max:20'
            ]);

            $user = $request->user();
            $settings = \App\Models\Setting::first();
            
            // Check if SMS is enabled in settings
            if ($settings && $settings->sms_enabled) {
                // SMS enabled - send verification code, don't save phone yet
                $user->update([
                    'phone' => $validated['phone'],
                    'phone_verified_at' => null // Reset verification status
                ]);
                
                $result = $user->sendPhoneVerificationCode();
                
                if ($result['success']) {
                    return response()->json([
                        'success' => true,
                        'verification_required' => true,
                        'message' => 'Verification code sent to your phone'
                    ]);
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => $result['message']
                    ], 500);
                }
            } else {
                // SMS disabled - save phone directly
                $user->update([
                    'phone' => $validated['phone'],
                    'phone_verified_at' => now() // Mark as verified since SMS is disabled
                ]);

                return response()->json([
                    'success' => true,
                    'verification_required' => false,
                    'message' => 'Phone number updated successfully'
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating phone number'
            ], 500);
        }
    }

    /**
     * Update currency preference
     */
    public function updateCurrency(Request $request)
    {
        try {
            $validated = $request->validate([
                'currency_id' => 'nullable|string|size:3|in:USD,EUR,GBP,NGN,CAD,AUD'
            ]);

            $user = $request->user();
            $user->update([
                'currency_id' => $validated['currency_id']
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Currency preference updated successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating currency preference'
            ], 500);
        }
    }

    /**
     * Update date of birth
     */
    public function updateDateOfBirth(Request $request)
    {
        try {
            $validated = $request->validate([
                'date_of_birth' => 'required|date|before:today'
            ]);

            $user = $request->user();
            $user->update([
                'date_of_birth' => $validated['date_of_birth']
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Date of birth updated successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating date of birth'
            ], 500);
        }
    }

    /**
     * Delete user account
     */
    public function deleteAccount(Request $request)
    {
        $validated = $request->validate([
            'password' => 'required|string'
        ]);

        $user = $request->user();

        if (!\Hash::check($validated['password'], $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid password'
            ], 422);
        }

        // Delete user account
        $user->delete();

        // Logout and invalidate session
        \Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json([
            'success' => true,
            'message' => 'Account deleted successfully'
        ]);
    }

    /**
     * Update withdrawal details
     */
    public function updateWithdrawalDetails(Request $request)
    {
        $details = $request->input('details', []);
        $user = Auth::user();
        
        // Clear existing withdrawal details
        $user->withdrawalDetails()->delete();
        
        // Add new withdrawal details
        foreach ($details as $detail) {
            if (!empty($detail['method_name']) && !empty($detail['credentials'])) {
                \App\Models\WithdrawalDetail::create([
                    'user_id' => $user->id,
                    'method_name' => $detail['method_name'],
                    'credentials' => $detail['credentials']
                ]);
            }
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Withdrawal details updated successfully'
        ]);
    }
}
