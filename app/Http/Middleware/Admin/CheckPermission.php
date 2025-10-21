<?php

namespace App\Http\Middleware\Admin;

use Closure;
use Illuminate\Http\Request;

class CheckPermission
{
    public function handle(Request $request, Closure $next, string $permission)
    {
        if (!auth('admin')->check()) {
            return redirect()->route('admin.login');
        }

        if (!auth('admin')->user()->can($permission)) {
            abort(403, 'You do not have permission to access this resource.');
        }

        return $next($request);
    }

    public static function can(string $permission): bool
    {
        return auth('admin')->check() && auth('admin')->user()->can($permission);
    }
}