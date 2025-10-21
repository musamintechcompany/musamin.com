<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailChangedSecurityAlert extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $oldEmail;
    public $newEmail;

    public function __construct(User $user, $oldEmail, $newEmail)
    {
        $this->user = $user;
        $this->oldEmail = $oldEmail;
        $this->newEmail = $newEmail;
    }

    public function build()
    {
        return $this->subject('🔐 Security Alert: Email Address Changed - ' . config('app.name'))
                    ->view('emails.email-changed-security-alert');
    }
}