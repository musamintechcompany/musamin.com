<?php

namespace App\Listeners\Admin;

use App\Events\Admin\UserRenewedAffiliate;
use App\Models\Admin;
use App\Notifications\Admin\UserRenewedAffiliateNotification;
use Illuminate\Support\Facades\Notification;

class NotifyAdminsOfAffiliateRenewal
{
    public function handle(UserRenewedAffiliate $event): void
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
            Notification::send($admins, new UserRenewedAffiliateNotification($event->user, $event->planType));
        }
    }
}