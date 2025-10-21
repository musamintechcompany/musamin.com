<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Conversation;

class ConversationUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $conversation;

    public function __construct(Conversation $conversation)
    {
        $this->conversation = $conversation->load(['userOne', 'userTwo', 'latestMessage']);
    }

    public function broadcastOn()
    {
        return [
            new PrivateChannel('App.Models.User.' . $this->conversation->user_one_id),
            new PrivateChannel('App.Models.User.' . $this->conversation->user_two_id)
        ];
    }

    public function broadcastWith()
    {
        return [
            'conversation' => $this->conversation
        ];
    }
}