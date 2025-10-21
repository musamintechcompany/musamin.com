<?php

namespace App\Listeners;

use App\Events\CoinTransactionProcessed;
use App\Notifications\CoinTransactionNotification;

class SendCoinTransactionNotification
{
    public function handle(CoinTransactionProcessed $event): void
    {
        $event->user->notify(new CoinTransactionNotification(
            $event->type,
            $event->amount,
            $event->status,
            $event->transactionId
        ));
    }
}