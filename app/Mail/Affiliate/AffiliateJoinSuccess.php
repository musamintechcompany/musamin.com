<?php

namespace App\Mail\Affiliate;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AffiliateJoinSuccess extends Mailable
{
    use Queueable, SerializesModels;

    public User $user;
    public int $feesPaid;
    public string $planType;
    public string $duration;

    /**
     * Create a new message instance.
     */
    public function __construct(User $user, int $feesPaid = null, string $planType = 'monthly')
    {
        $this->user = $user;
        $this->feesPaid = $feesPaid ?? ($user->affiliate->fee_paid ?? 0);
        $this->planType = $planType;
        $this->duration = $this->planType === 'yearly' ? '1 year' : '1 month';
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Welcome to Our Affiliate Program!',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.affiliate.successfully-joined-affiliate',
            with: [
                'user' => $this->user,
                'feesPaid' => $this->feesPaid,
                'planType' => $this->planType,
                'duration' => $this->duration,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     */
    public function attachments(): array
    {
        return [];
    }
}