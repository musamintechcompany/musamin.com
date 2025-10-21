<?php

namespace App\Mail\Affiliate;

use App\Models\User;
use App\Models\Affiliate;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AffiliateExpirationReminder extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public User $user;
    public Affiliate $affiliate;
    public string $reminderType;
    public string $timeRemaining;
    public string $renewalUrl;

    public function __construct(User $user, Affiliate $affiliate, string $reminderType)
    {
        $this->user = $user;
        $this->affiliate = $affiliate;
        $this->reminderType = $reminderType;
        $this->renewalUrl = route('affiliate.join');
        
        // Calculate time remaining
        $this->timeRemaining = $this->calculateTimeRemaining();
    }

    public function envelope(): Envelope
    {
        $subject = $this->reminderType === 'first' 
            ? 'Your Affiliate Membership Expires Soon!' 
            : 'Final Notice: Affiliate Membership Expires Tomorrow!';
            
        return new Envelope(subject: $subject);
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.affiliate.expiration-reminder',
            with: [
                'user' => $this->user,
                'affiliate' => $this->affiliate,
                'reminderType' => $this->reminderType,
                'timeRemaining' => $this->timeRemaining,
                'renewalUrl' => $this->renewalUrl,
                'planType' => $this->affiliate->plan_type,
                'expiresAt' => $this->affiliate->expires_at,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }

    private function calculateTimeRemaining(): string
    {
        $now = now();
        $expiresAt = $this->affiliate->expires_at;
        
        if ($expiresAt->isPast()) {
            return 'Expired';
        }
        
        $diff = $now->diff($expiresAt);
        
        if ($diff->days > 0) {
            return $diff->days . ' day' . ($diff->days > 1 ? 's' : '');
        } elseif ($diff->h > 0) {
            return $diff->h . ' hour' . ($diff->h > 1 ? 's' : '');
        } else {
            return $diff->i . ' minute' . ($diff->i > 1 ? 's' : '');
        }
    }
}