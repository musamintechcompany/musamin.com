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

class CoinTransferSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;
    public $amount;
    public $fee;
    public $transferType;
    public $recipientName;
    public $currentBalance;

    public function __construct(User $user, $amount, $fee, $transferType, $recipientName = null, $currentBalance = 0)
    {
        $this->user = $user;
        $this->amount = $amount;
        $this->fee = $fee;
        $this->transferType = $transferType;
        $this->recipientName = $recipientName;
        $this->currentBalance = $currentBalance;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('user.' . $this->user->id);
    }

    public function broadcastWith()
    {
        return [
            'type' => 'coin_transfer_sent',
            'title' => 'Coin Transfer Successful',
            'message' => $this->transferType === 'internal' 
                ? "Successfully transferred {$this->amount} coins to spending wallet"
                : "Successfully sent {$this->amount} coins to {$this->recipientName}",
            'amount' => $this->amount,
            'fee' => $this->fee,
            'current_balance' => $this->currentBalance
        ];
    }
}