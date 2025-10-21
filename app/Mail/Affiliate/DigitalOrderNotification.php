<?php

namespace App\Mail\Affiliate;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DigitalOrderNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $order;

    public function __construct($order)
    {
        $this->order = $order;
        $this->onQueue('emails');
    }

    public function build()
    {
        return $this->view('emails.affiliate.digital-order-notification')
                    ->subject('💰 Digital Sale Completed - Payment Credited!')
                    ->with(['order' => $this->order]);
    }
}