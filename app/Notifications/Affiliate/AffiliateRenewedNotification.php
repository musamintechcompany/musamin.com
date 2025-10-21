<?php

namespace App\Notifications\Affiliate;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class AffiliateRenewedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct()
    {
        $this->onQueue('notifications');
    }

    public function via($notifiable): array
    {
        return ['database', 'broadcast'];
    }

    public function toDatabase($notifiable): array
    {
        return [
            'type' => 'affiliate_renewed',
            'message' => 'Your affiliate membership has been renewed successfully!',
            'icon' => 'sync-alt',
            'color' => 'orange',
            'action_url' => route('affiliate.dashboard'),
        ];
    }

    public function toBroadcast($notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
            'type' => 'affiliate_renewed',
            'message' => 'Your affiliate membership has been renewed successfully!',
            'icon' => 'sync-alt',
            'color' => 'orange',
            'sound' => true,
            'action_url' => route('affiliate.dashboard'),
        ]);
    }
}