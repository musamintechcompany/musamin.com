<?php

namespace App\Mail;

use App\Models\CoinTransaction;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CoinTransactionSubmitted extends Mailable
{
    use Queueable, SerializesModels;

    public $transaction;

    public function __construct(CoinTransaction $transaction)
    {
        $this->transaction = $transaction;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Coin Purchase Submitted - Under Review',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.coin-transaction-submitted',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
