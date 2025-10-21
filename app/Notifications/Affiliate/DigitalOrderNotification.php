<?php

namespace App\Notifications\Affiliate;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\DatabaseMessage;
use App\Models\Order;

class DigitalOrderNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
        $this->onQueue('notifications');
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => '💰 Digital Sale Completed',
            'message' => 'Digital order #' . $this->order->order_number . ' completed! $' . number_format($this->order->total_amount, 2) . ' credited to your earned wallet.',
            'order_id' => $this->order->id,
            'order_number' => $this->order->order_number,
            'total_amount' => $this->order->total_amount,
            'customer_name' => $this->order->user->name,
            'action_url' => route('affiliate.orders.view', $this->order->id)
        ];
    }
}