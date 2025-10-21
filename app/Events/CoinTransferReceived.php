<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class CoinTransferReceived implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;
    public $amount;
    public $senderName;
    public $currentBalance;

    public function __construct(User $user, $amount, $senderName, $currentBalance)
    {
        $this->user = $user;
        $this->amount = $amount;
        $this->senderName = $senderName;
        $this->currentBalance = $currentBalance;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('user.' . $this->user->id);
    }

    public function broadcastWith()
    {
        return [
            'type' => 'coin_transfer_received',
            'title' => 'Coins Received',
            'message' => "You received {$this->amount} coins from {$this->senderName}",
            'amount' => $this->amount,
            'sender' => $this->senderName,
            'current_balance' => $this->currentBalance
        ];
    }
}