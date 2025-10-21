<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class CoinTransactionNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public string $type,
        public int $amount,
        public string $status,
        public ?string $transactionId = null
    ) {
        $this->onQueue('notifications');
    }

    public function via($notifiable): array
    {
        return ['database', 'broadcast'];
    }

    public function toDatabase($notifiable): array
    {
        return [
            'type' => $this->type,
            'amount' => $this->amount,
            'status' => $this->status,
            'transaction_id' => $this->transactionId,
            'message' => $this->getMessage(),
            'icon' => $this->getIcon(),
            'color' => $this->getColor(),
        ];
    }

    public function toBroadcast($notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
            'type' => $this->type,
            'amount' => $this->amount,
            'status' => $this->status,
            'message' => $this->getMessage(),
            'icon' => $this->getIcon(),
            'color' => $this->getColor(),
            'sound' => true,
        ]);
    }

    private function getMessage(): string
    {
        return match($this->type) {
            'purchase' => "You purchased {$this->amount} coins",
            'earned' => "You earned {$this->amount} coins",
            'spent' => "You spent {$this->amount} coins",
            'affiliate_bonus' => "Affiliate bonus: {$this->amount} coins",
            default => "Coin transaction: {$this->amount} coins"
        };
    }

    private function getIcon(): string
    {
        return match($this->status) {
            'approved' => 'check-circle',
            'pending' => 'clock',
            'declined' => 'x-circle',
            default => 'coins'
        };
    }

    private function getColor(): string
    {
        return match($this->status) {
            'approved' => 'green',
            'pending' => 'yellow',
            'declined' => 'red',
            default => 'blue'
        };
    }
}