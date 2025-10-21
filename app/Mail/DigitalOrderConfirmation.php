<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DigitalOrderConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $orders;

    public function __construct($orders)
    {
        $this->orders = is_array($orders) ? $orders : [$orders];
        $this->onQueue('emails');
    }

    public function build()
    {
        return $this->view('emails.digital-order-confirmation')
                    ->subject('Your Digital Products Are Ready for Download!')
                    ->with(['orders' => $this->orders]);
    }
}