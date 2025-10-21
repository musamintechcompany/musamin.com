<?php

namespace App\Notifications;

use App\Models\Withdrawal;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WithdrawalApprovedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public Withdrawal $withdrawal
    ) {}

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'title' => 'Withdrawal Approved',
            'message' => 'Your withdrawal of ' . number_format($this->withdrawal->net_amount) . ' coins has been approved and processed.',
            'type' => 'withdrawal_approved',
            'withdrawal_id' => $this->withdrawal->id,
            'amount' => $this->withdrawal->net_amount,
            'icon' => 'check-circle',
            'color' => 'green'
        ];
    }
}