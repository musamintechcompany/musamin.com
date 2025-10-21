<?php

namespace App\Notifications\Admin;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class UserRenewedAffiliateNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public User $user, public string $planType = 'monthly')
    {
        $this->queue = 'notifications';
    }

    public function via($notifiable): array
    {
        return ['database', 'broadcast'];
    }
    
    public function viaQueues(): array
    {
        return [
            'database' => 'notifications',
            'broadcast' => 'notifications',
        ];
    }

    public function toDatabase($notifiable): array
    {
        return [
            'type' => 'user_renewed_affiliate',
            'user_id' => $this->user->id,
            'user_name' => $this->user->name,
            'user_email' => $this->user->email,
            'message' => "{$this->user->name} renewed their affiliate membership on {$this->planType} plan",
            'icon' => 'sync-alt',
            'color' => 'orange',
            'action_url' => route('admin.users.show', $this->user->hashid),
        ];
    }

    public function toBroadcast($notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
            'type' => 'user_renewed_affiliate',
            'user_name' => $this->user->name,
            'message' => "{$this->user->name} renewed their affiliate membership on {$this->planType} plan",
            'icon' => 'sync-alt',
            'color' => 'orange',
            'sound' => true,
            'action_url' => route('admin.users.show', $this->user->hashid),
        ]);
    }
}