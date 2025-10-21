<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PhysicalOrderConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $orders;

    public function __construct($orders)
    {
        $this->orders = is_array($orders) ? $orders : [$orders];
    }

    public function build()
    {
        return $this->subject('Order Confirmation - Your Items Will Be Shipped Soon!')
                    ->onQueue('emails')
                    ->view('emails.physical-order-confirmation')
                    ->with(['orders' => $this->orders]);
    }
}