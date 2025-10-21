<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CoinTransferSentMail extends Mailable
{
    use Queueable, SerializesModels;

    public $amount;
    public $fee;
    public $transferType;
    public $recipientName;
    public $recipientWallet;
    public $fromWallet;
    public $currentBalance;

    public function __construct($amount, $fee, $transferType, $recipientName = null, $recipientWallet = null, $fromWallet = 'earned', $currentBalance = 0)
    {
        $this->amount = $amount;
        $this->fee = $fee;
        $this->transferType = $transferType;
        $this->recipientName = $recipientName;
        $this->recipientWallet = $recipientWallet;
        $this->fromWallet = $fromWallet;
        $this->currentBalance = $currentBalance;
    }

    public function build()
    {
        return $this->subject('Coin Transfer Successful - ' . config('app.name'))
                    ->view('emails.coin-transfer-sent');
    }
}