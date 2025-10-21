<?php

namespace App\Observers\Admin;

use App\Models\User;
use App\Events\Admin\UserRegistered;
use Illuminate\Support\Facades\Log;

class UserObserver
{
    public function created(User $user): void
    {
        Log::info('UserObserver triggered for user: ' . $user->email);
        
        // Send welcome notification to the new user
        $user->notify(new \App\Notifications\User\WelcomeNotification($user));
        
        // Directly notify admins
        Log::info('Directly notifying admins from UserObserver');
        $listener = new \App\Listeners\Admin\NotifyAdminsOfNewUser();
        $event = new UserRegistered($user);
        $listener->handle($event);
        
        Log::info('UserObserver completed for user: ' . $user->email);
    }
}