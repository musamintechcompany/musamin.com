<?php

namespace App\Notifications\User;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class WelcomeNotification extends Notification
{
    public function __construct(public User $user)
    {
        //
    }

    public function via($notifiable): array
    {
        return ['database', 'broadcast'];
    }
    

    


    public function toDatabase($notifiable): array
    {
        return [
            'type' => 'welcome',
            'user_id' => $this->user->id,
            'user_name' => $this->user->name,
            'message' => "Welcome to " . config('app.name') . "! Thank you for joining us.",
            'icon' => 'glass-cheers',
            'color' => 'green',
        ];
    }

    public function toBroadcast($notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
            'type' => 'welcome',
            'user_name' => $this->user->name,
            'message' => "Welcome to " . config('app.name') . "! Thank you for joining us.",
            'icon' => 'glass-cheers',
            'color' => 'green',
            'sound' => true,
        ]);
    }
}