<?php

namespace App\Notifications\Admin;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class UserJoinedAffiliateNotification extends Notification implements ShouldQueue
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
            'type' => 'user_joined_affiliate',
            'user_id' => $this->user->id,
            'user_name' => $this->user->name,
            'user_email' => $this->user->email,
            'message' => "{$this->user->name} joined the affiliate program on {$this->planType} plan",
            'icon' => 'handshake',
            'color' => 'purple',
            'action_url' => route('admin.users.show', $this->user->hashid),
        ];
    }

    public function toBroadcast($notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
            'type' => 'user_joined_affiliate',
            'user_name' => $this->user->name,
            'message' => "{$this->user->name} joined the affiliate program on {$this->planType} plan",
            'icon' => 'handshake',
            'color' => 'purple',
            'sound' => true,
            'action_url' => route('admin.users.show', $this->user->hashid),
        ]);
    }
}