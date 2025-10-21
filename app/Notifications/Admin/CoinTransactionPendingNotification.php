<?php

namespace App\Notifications\Admin;

use Illuminate\Notifications\Messages\DatabaseMessage;
use Illuminate\Notifications\Notification;
use App\Models\CoinTransaction;

class CoinTransactionPendingNotification extends Notification
{

    protected $transaction;

    public function __construct(CoinTransaction $transaction)
    {
        $this->transaction = $transaction;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable): array
    {
        return [
            'type' => 'coin_transaction_pending',
            'transaction_id' => $this->transaction->id,
            'user_name' => $this->transaction->user->name,
            'amount' => $this->transaction->amount,
            'payment_method' => $this->transaction->payment_method,
            'message' => "User {$this->transaction->user->name} submitted a coin purchase for <span class='text-green-600 font-semibold'>$" . $this->transaction->amount . "</span> requiring verification",
            'icon' => 'coins',
            'color' => 'orange',
            'action_url' => route('admin.coin-transactions.pending'),
        ];
    }
}