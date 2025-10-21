<?php

namespace App\Providers;

use App\Events\Admin\UserRegistered;
use App\Events\Admin\UserJoinedAffiliate;
use App\Events\Admin\UserRenewedAffiliate;
use App\Events\CoinTransactionProcessed;
use App\Listeners\Admin\NotifyAdminsOfNewUser;
use App\Listeners\Admin\NotifyAdminsOfNewAffiliate;
use App\Listeners\Admin\NotifyAdminsOfAffiliateRenewal;
use App\Listeners\SendCoinTransactionNotification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        Registered::class => [
            // Laravel's default listener sends verification email automatically
        ],
        
        UserRegistered::class => [
            NotifyAdminsOfNewUser::class,
        ],
        
        UserJoinedAffiliate::class => [
            NotifyAdminsOfNewAffiliate::class,
        ],
        
        UserRenewedAffiliate::class => [
            NotifyAdminsOfAffiliateRenewal::class,
        ],
        
        CoinTransactionProcessed::class => [
            SendCoinTransactionNotification::class,
        ],
    ];

    public function boot(): void
    {
        parent::boot();
        
        // Listen for Laravel's Registered event
        Event::listen(Registered::class, function ($event) {
            // Send email verification if required (only once)
            if ($event->user->isEmailVerificationRequired() && !$event->user->hasVerifiedEmail()) {
                $event->user->sendEmailVerificationNotification();
            } else {
                // Send welcome email if no verification needed
                $event->user->sendWelcomeEmailIfNoVerification();
            }
            
            // Dispatch our custom event for admin notifications
            \Log::info('About to dispatch UserRegistered event');
            UserRegistered::dispatch($event->user);
            \Log::info('UserRegistered event dispatched');
        });
    }

    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}