<?php

namespace App\Notifications\Admin;

use App\Models\Idea;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class IdeaSubmittedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Idea $idea)
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
            'type' => 'idea_submitted',
            'idea_id' => $this->idea->id,
            'idea_title' => $this->idea->title,
            'user_name' => $this->idea->user->name,
            'message' => "New idea '{$this->idea->title}' submitted by {$this->idea->user->name}",
            'icon' => 'lightbulb',
            'color' => 'blue',
            'action_url' => route('admin.ideas.view', $this->idea),
        ];
    }

    public function toBroadcast($notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
            'type' => 'idea_submitted',
            'idea_title' => $this->idea->title,
            'user_name' => $this->idea->user->name,
            'message' => "New idea '{$this->idea->title}' submitted by {$this->idea->user->name}",
            'icon' => 'lightbulb',
            'color' => 'blue',
            'sound' => true,
            'action_url' => route('admin.ideas.view', $this->idea),
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