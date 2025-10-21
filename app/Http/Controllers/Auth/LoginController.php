<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use PragmaRX\Google2FA\Google2FA;

class LoginController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $user = Auth::user();
            
            // Check if email verification is required and user hasn't verified
            if ($user->isEmailVerificationRequired() && !$user->hasVerifiedEmail()) {
                return redirect()->route('verification.notice');
            }
            
            // Check if user has 2FA enabled
            if ($user->two_factor_confirmed_at) {
                // Log out the user temporarily
                Auth::logout();
                
                // Store user ID in session for 2FA verification
                $request->session()->put('2fa_user_id', $user->id);
                
                return redirect()->route('two-factor.challenge');
            }
            
            $request->session()->regenerate();
            
            // Get intended URL and check if it's an AJAX endpoint
            $intended = $request->session()->get('url.intended');
            if ($intended && (str_contains($intended, '/api/') || str_contains($intended, '/count') || str_contains($intended, '/data'))) {
                $request->session()->forget('url.intended');
                return redirect()->route('dashboard');
            }
            
            return redirect()->intended(route('dashboard'));
        }

        throw ValidationException::withMessages([
            'email' => __('The provided credentials do not match our records.'),
        ]);
    }

    public function destroy(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();
        $request->session()->forget('url.intended');

        return redirect('/');
    }

    public function twoFactorLogin(Request $request)
    {
        $userId = $request->session()->get('2fa_user_id');
        
        if (!$userId) {
            return redirect()->route('login');
        }
        
        $user = User::find($userId);
        
        if (!$user || !$user->two_factor_confirmed_at) {
            return redirect()->route('login');
        }
        
        if ($request->filled('code')) {
            $request->validate(['code' => 'required|string|size:6']);
            
            $google2fa = new Google2FA();
            $secretKey = decrypt($user->two_factor_secret);
            
            if ($google2fa->verifyKey($secretKey, $request->code)) {
                Auth::login($user);
                $request->session()->forget('2fa_user_id');
                $request->session()->regenerate();
                
                // Get intended URL and check if it's an AJAX endpoint
                $intended = $request->session()->get('url.intended');
                if ($intended && (str_contains($intended, '/api/') || str_contains($intended, '/count') || str_contains($intended, '/data'))) {
                    $request->session()->forget('url.intended');
                    return redirect()->route('dashboard');
                }
                
                return redirect()->intended(route('dashboard'));
            }
            
            throw ValidationException::withMessages([
                'code' => __('The provided two factor authentication code was invalid.'),
            ]);
        }
        
        if ($request->filled('recovery_code')) {
            $request->validate(['recovery_code' => 'required|string']);
            
            $recoveryCodes = json_decode(decrypt($user->two_factor_recovery_codes), true);
            
            if (in_array($request->recovery_code, $recoveryCodes)) {
                // Remove used recovery code
                $recoveryCodes = array_diff($recoveryCodes, [$request->recovery_code]);
                $user->update([
                    'two_factor_recovery_codes' => encrypt(json_encode(array_values($recoveryCodes)))
                ]);
                
                Auth::login($user);
                $request->session()->forget('2fa_user_id');
                $request->session()->regenerate();
                
                // Get intended URL and check if it's an AJAX endpoint
                $intended = $request->session()->get('url.intended');
                if ($intended && (str_contains($intended, '/api/') || str_contains($intended, '/count') || str_contains($intended, '/data'))) {
                    $request->session()->forget('url.intended');
                    return redirect()->route('dashboard');
                }
                
                return redirect()->intended(route('dashboard'));
            }
            
            throw ValidationException::withMessages([
                'recovery_code' => __('The provided recovery code was invalid.'),
            ]);
        }
        
        throw ValidationException::withMessages([
            'code' => __('Please provide an authentication code or recovery code.'),
        ]);
    }
}