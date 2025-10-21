<?php

namespace App\Observers;

use App\Models\CoinTransaction;
use App\Models\Admin;
use App\Notifications\Admin\CoinTransactionPendingNotification;

class CoinTransactionObserver
{
    public function updated(CoinTransaction $transaction)
    {
        if ($transaction->isDirty('status') && $transaction->status === 'pending') {
            $admins = Admin::permission('manage coin transactions')->get();
            
            foreach ($admins as $admin) {
                $admin->notify(new CoinTransactionPendingNotification($transaction));
            }
        }
    }
}