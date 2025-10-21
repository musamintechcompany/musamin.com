<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CoinTransferReceivedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $amount;
    public $senderName;
    public $senderWallet;
    public $currentBalance;

    public function __construct($amount, $senderName, $senderWallet, $currentBalance)
    {
        $this->amount = $amount;
        $this->senderName = $senderName;
        $this->senderWallet = $senderWallet;
        $this->currentBalance = $currentBalance;
    }

    public function build()
    {
        return $this->subject('Coins Received - ' . config('app.name'))
                    ->view('emails.coin-transfer-received');
    }
}