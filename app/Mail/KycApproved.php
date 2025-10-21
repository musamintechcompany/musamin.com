<?php

namespace App\Mail;

use App\Models\KycVerification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class KycApproved extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $kyc;

    public function __construct(KycVerification $kyc)
    {
        $this->kyc = $kyc;
    }

    public function build()
    {
        return $this->onQueue('emails')
                    ->subject('KYC Verification Approved - Welcome to ' . config('app.name'))
                    ->from(config('mail.from.address'), config('mail.from.name'))
                    ->view('emails.kyc.approved')
                    ->with([
                        'user' => $this->kyc->user,
                        'kyc' => $this->kyc,
                    ]);
    }
}