<?php

namespace App\Providers;

use App\Models\User;
use App\Models\Idea;
use App\Models\KycVerification;
use App\Models\CoinTransaction;
use App\Observers\Admin\UserObserver;
use App\Observers\IdeaObserver;
use App\Observers\KycObserver;
use App\Observers\CoinTransactionObserver;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        User::observe(UserObserver::class);
        Idea::observe(IdeaObserver::class);
        KycVerification::observe(KycObserver::class);
        CoinTransaction::observe(CoinTransactionObserver::class);
        
        // Force HTTPS URLs in production
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }
    }
}
