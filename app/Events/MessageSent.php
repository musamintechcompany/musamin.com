<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    
    public $broadcastQueue = 'default';
    public $connection = 'sync';

    public $conversationId;
    public $userOneId;
    public $userTwoId;
    public $messageData;

    private $channels;

    public function __construct($conversationId, $userOneId, $userTwoId, $messageData)
    {
        $this->conversationId = $conversationId;
        $this->userOneId = $userOneId;
        $this->userTwoId = $userTwoId;
        $this->messageData = $messageData;

        $this->channels = [
            new PrivateChannel('conversation.' . $conversationId),
            new PrivateChannel('App.Models.User.' . $userOneId),
            new PrivateChannel('App.Models.User.' . $userTwoId)
        ];
    }

    public function broadcastOn()
    {
        return $this->channels;
    }

    public function broadcastWith()
    {
        $sender = $this->messageData['sender'] ?? [];

        return [
            'message' => [
                'id' => $this->messageData['id'] ?? null,
                'conversation_id' => $this->conversationId,
                'sender_id' => $this->messageData['sender_id'] ?? null,
                'message' => isset($this->messageData['message']) ? e($this->messageData['message']) : '',
                'type' => $this->messageData['type'] ?? 'text',
                'file_path' => $this->messageData['file_path'] ?? null,
                'file_name' => $this->messageData['file_name'] ?? null,
                'file_url' => $this->messageData['file_url'] ?? null,
                'created_at' => $this->messageData['created_at'] ?? date('c'),
                'sender' => [
                    'id' => array_key_exists('id', $sender) ? $sender['id'] : null,
                    'name' => array_key_exists('name', $sender) ? e($sender['name']) : ''
                ]
            ]
        ];
    }
}
