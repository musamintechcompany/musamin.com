<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();
            
            // Update user activity
            $user->update([
                'last_seen_at' => now(),
                'is_online' => true
            ]);
            
            // Skip email verification check for email verification routes
            $excludedRoutes = [
                'verification.notice',
                'verification.verify', 
                'verification.send',
                'verification.verify-code',
                'email.verify-change',
                'email.change'
            ];
            
            if (!in_array($request->route()->getName(), $excludedRoutes)) {
                // Check if email verification is required and user hasn't verified
                if ($user->isEmailVerificationRequired() && !$user->hasVerifiedEmail()) {
                    if ($request->expectsJson()) {
                        return response()->json(['message' => 'Your email address is not verified.'], 409);
                    }
                    return redirect()->route('verification.notice');
                }
            }
        }

        return $next($request);
    }
}