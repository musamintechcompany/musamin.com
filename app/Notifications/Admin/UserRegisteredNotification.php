<?php

namespace App\Notifications\Admin;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class UserRegisteredNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public User $user)
    {
        $this->onQueue('notifications');
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
            'type' => 'user_registered',
            'user_id' => $this->user->id,
            'user_name' => $this->user->name,
            'user_email' => $this->user->email,
            'message' => "New user {$this->user->name} has registered",
            'icon' => 'user-plus',
            'color' => 'green',
            'action_url' => route('admin.users.show', $this->user->hashid),
        ];
    }

    public function toBroadcast($notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
            'type' => 'user_registered',
            'user_name' => $this->user->name,
            'message' => "New user {$this->user->name} has registered",
            'icon' => 'user-plus',
            'color' => 'green',
            'sound' => true,
            'action_url' => route('admin.users.show', $this->user->hashid),
        ]);
    }
    
    public function broadcastOn(): array
    {
        return ['admin-notifications'];
    }
    
    public function broadcastAs(): string
    {
        return 'notification';
    }
}