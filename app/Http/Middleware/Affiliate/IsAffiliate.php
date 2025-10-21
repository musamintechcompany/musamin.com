<?php

namespace App\Http\Middleware\Affiliate;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsAffiliate
{
    public function handle(Request $request, Closure $next): Response
    {
        /** @var User $user */
        $user = Auth::user();
        if (!Auth::check() || !$user->isAffiliate()) {
            return redirect()->route('dashboard')->with('error', 'You need to be an affiliate to access this area.');
        }

        return $next($request);
    }
}