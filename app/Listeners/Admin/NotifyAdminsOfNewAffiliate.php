<?php

namespace App\Listeners\Admin;

use App\Events\Admin\UserJoinedAffiliate;
use App\Models\Admin;
use App\Notifications\Admin\UserJoinedAffiliateNotification;
use Illuminate\Support\Facades\Notification;

class NotifyAdminsOfNewAffiliate
{
    public function handle(UserJoinedAffiliate $event): void
    {
        $admins = Admin::where('is_active', true)
            ->whereHas('roles.permissions', function($query) {
                $query->where('name', 'receive-affiliate-notifications');
            })
            ->orWhere(function($query) {
                $query->where('is_active', true)->whereDoesntHave('roles');
            })
            ->get();
        
        if ($admins->count() > 0) {
            Notification::send($admins, new UserJoinedAffiliateNotification($event->user, $event->planType));
        }
    }
}