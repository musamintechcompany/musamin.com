<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        channels: __DIR__.'/../routes/channels.php',
        then: function () {
            Route::middleware('web')
                ->group(base_path('routes/admin.php'));
            Route::middleware('web')
                ->group(base_path('routes/affiliate.php'));
        },
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'affiliate' => \App\Http\Middleware\Affiliate\IsAffiliate::class,
            'admin' => \App\Http\Middleware\Admin\AdminMiddleware::class,
            'admin.permission' => \App\Http\Middleware\Admin\CheckPermission::class,
            'user' => \App\Http\Middleware\UserMiddleware::class,
        ]);
        
        $middleware->web(append: [
            \App\Http\Middleware\UserMiddleware::class
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
