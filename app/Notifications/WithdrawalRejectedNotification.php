<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class WithdrawalRejectedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $withdrawal;

    public function __construct($withdrawal)
    {
        $this->withdrawal = $withdrawal;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        $totalRefunded = $this->withdrawal->amount + $this->withdrawal->fee;
        
        return [
            'type' => 'withdrawal_declined',
            'title' => 'Withdrawal Declined',
            'message' => "Your withdrawal request has been declined and {$totalRefunded} coins have been refunded to your account.",
            'amount' => $totalRefunded,
            'withdrawal_id' => $this->withdrawal->id,
            'withdrawal_amount' => $this->withdrawal->amount,
            'fee_amount' => $this->withdrawal->fee,
            'decline_reason' => $this->withdrawal->admin_notes,
            'status' => 'declined',
            'icon' => 'exclamation-circle',
            'color' => 'red',
            'created_at' => now()->toISOString()
        ];
    }
}