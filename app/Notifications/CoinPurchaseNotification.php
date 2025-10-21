<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CoinPurchaseNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $coinTransaction;

    public function __construct($coinTransaction)
    {
        $this->coinTransaction = $coinTransaction;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function shouldBroadcast()
    {
        return false;
    }

    public function toArray($notifiable)
    {
        $totalCoins = $this->coinTransaction->base_coins + $this->coinTransaction->bonus_coins;
        
        return [
            'type' => 'coin_purchase',
            'title' => 'Coin Purchase Approved',
            'message' => "Your coin purchase has been approved. {$totalCoins} coins have been added to your wallet.",
            'amount' => $totalCoins,
            'transaction_id' => $this->coinTransaction->hashid,
            'package_name' => $this->coinTransaction->package_name ?? 'Custom Package',
            'base_coins' => $this->coinTransaction->base_coins,
            'bonus_coins' => $this->coinTransaction->bonus_coins,
            'created_at' => now()->toISOString()
        ];
    }
}