<?php

namespace App\Notifications\Affiliate;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class AffiliateJoinedNotification extends Notification implements ShouldQueue
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
            'type' => 'affiliate_joined',
            'message' => 'Welcome to the Affiliate Program!',
            'icon' => 'star',
            'color' => 'purple',
            'action_url' => route('affiliate.dashboard'),
        ];
    }

    public function toBroadcast($notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
            'type' => 'affiliate_joined',
            'message' => 'Welcome to the Affiliate Program!',
            'icon' => 'star',
            'color' => 'purple',
            'sound' => true,
            'action_url' => route('affiliate.dashboard'),
        ]);
    }
}