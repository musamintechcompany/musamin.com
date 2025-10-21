<?php

namespace App\Listeners\Admin;

use App\Events\Admin\UserRegistered;
use App\Models\Admin;
use App\Notifications\Admin\UserRegisteredNotification;
use Illuminate\Support\Facades\Notification;

class NotifyAdminsOfNewUser
{
    public function handle($event): void
    {
        \Log::info('NotifyAdminsOfNewUser listener triggered');
        
        $user = $event instanceof UserRegistered ? $event->user : $event->user;
        
        if (!$user instanceof \App\Models\User) {
            \Log::info('User is not instance of User model');
            return;
        }
        
        \Log::info('Processing notification for user: ' . $user->email);
        
        $admins = Admin::where('is_active', true)->get();
        \Log::info('Found ' . $admins->count() . ' admins to notify');
        
        foreach ($admins as $admin) {
            \Log::info('Notifying admin: ' . $admin->email);
            try {
                $admin->notify(new UserRegisteredNotification($user));
                \Log::info('Notification sent successfully to: ' . $admin->email);
            } catch (\Exception $e) {
                \Log::error('Failed to send notification to admin ' . $admin->email . ': ' . $e->getMessage());
            }
        }
        
        \Log::info('Admin notifications completed');
    }
}