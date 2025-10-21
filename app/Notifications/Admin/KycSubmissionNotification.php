<?php

namespace App\Notifications\Admin;

use App\Models\KycVerification;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;

class KycSubmissionNotification extends Notification
{
    use Queueable;

    protected $kyc;

    public function __construct(KycVerification $kyc)
    {
        $this->kyc = $kyc;
        $this->onQueue('notifications');
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => 'New KYC Submission',
            'message' => $this->kyc->user->name . ' has submitted their KYC verification documents for review.',
            'user_name' => $this->kyc->user->name,
            'user_email' => $this->kyc->user->email,
            'kyc_id' => $this->kyc->id,
            'submitted_at' => $this->kyc->created_at->format('M j, Y g:i A'),
            'action_url' => route('admin.kyc.index'),
            'type' => 'kyc_submission'
        ];
    }
}