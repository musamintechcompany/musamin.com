<?php

namespace App\Notifications\Admin;

use App\Models\Withdrawal;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class WithdrawalSubmittedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Withdrawal $withdrawal)
    {
        $this->onQueue('notifications');
    }

    public function via($notifiable): array
    {
        return ['database', 'broadcast'];
    }
    
    public function viaQueues(): array
    {
        return [
            'database' => 'notifications',
            'broadcast' => 'notifications',
        ];
    }

    public function toDatabase($notifiable): array
    {
        return [
            'type' => 'withdrawal_submitted',
            'withdrawal_id' => $this->withdrawal->id,
            'amount' => $this->withdrawal->amount,
            'net_amount' => $this->withdrawal->net_amount,
            'user_name' => $this->withdrawal->user->name,
            'bank_account' => $this->withdrawal->withdrawalDetail->method_name,
            'message' => "New withdrawal request for {$this->withdrawal->amount} coins from {$this->withdrawal->user->name}",
            'icon' => 'money-bill-wave',
            'color' => 'orange',
            'action_url' => route('admin.withdrawals.view', $this->withdrawal),
        ];
    }

    public function toBroadcast($notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
            'type' => 'withdrawal_submitted',
            'amount' => $this->withdrawal->amount,
            'user_name' => $this->withdrawal->user->name,
            'message' => "New withdrawal request for {$this->withdrawal->amount} coins from {$this->withdrawal->user->name}",
            'icon' => 'money-bill-wave',
            'color' => 'orange',
            'sound' => true,
            'action_url' => route('admin.withdrawals.view', $this->withdrawal),
        ]);
    }
    
    public function broadcastOn(): array
    {
        return ['admin-notifications'];
    }
    
    public function broadcastAs(): string
    {
        return 'notification';
    }
}