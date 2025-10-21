<?php

namespace App\Mail;

use App\Models\Withdrawal;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WithdrawalApproved extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $withdrawal;

    public function __construct(Withdrawal $withdrawal)
    {
        $this->withdrawal = $withdrawal;
    }

    public function build()
    {
        return $this->onQueue('emails')
                    ->subject('Withdrawal Approved - ' . config('app.name'))
                    ->from(config('mail.from.address'), config('mail.from.name'))
                    ->view('emails.withdrawal.approved')
                    ->with([
                        'user' => $this->withdrawal->user,
                        'withdrawal' => $this->withdrawal,
                    ]);
    }
}