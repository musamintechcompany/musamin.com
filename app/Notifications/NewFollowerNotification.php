<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;
use Illuminate\Notifications\Messages\BroadcastMessage;
use App\Models\User;

class NewFollowerNotification extends Notification
{
    use Queueable;

    public function __construct(
        public User $follower
    ) {}

    public function via($notifiable): array
    {
        return ['database', 'broadcast'];
    }

    public function toDatabase($notifiable): array
    {
        return [
            'type' => 'new_follower',
            'follower_id' => $this->follower->id,
            'follower_name' => $this->follower->name,
            'follower_avatar' => $this->follower->profile_photo_url,
            'message' => $this->follower->name . ' started following you',
            'icon' => 'user-plus',
            'color' => 'blue'
        ];
    }

    public function toBroadcast($notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
            'type' => 'new_follower',
            'follower_id' => $this->follower->id,
            'follower_name' => $this->follower->name,
            'follower_avatar' => $this->follower->profile_photo_url,
            'message' => $this->follower->name . ' started following you',
            'icon' => 'user-plus',
            'color' => 'blue'
        ]);
    }


}