<?php

namespace App\Mail\Affiliate;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Order;

class PhysicalOrderNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
        $this->onQueue('emails');
    }

    public function build()
    {
        return $this->subject('📦 New Physical Order - ' . $this->order->order_number)
                    ->view('emails.affiliate.physical-order-notification')
                    ->with(['order' => $this->order]);
    }
}