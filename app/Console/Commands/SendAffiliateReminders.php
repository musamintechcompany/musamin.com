<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Affiliate;
use App\Mail\Affiliate\AffiliateExpirationReminder;
use Illuminate\Support\Facades\Mail;

class SendAffiliateReminders extends Command
{
    protected $signature = 'affiliate:send-reminders';
    protected $description = 'Send expiration reminder emails to affiliates';

    public function handle()
    {
        $this->info('Checking for affiliate reminders...');

        // Get environment-based timing
        $isProduction = app()->environment('production');
        
        // Send first reminders (7 days or testing equivalent)
        $firstReminders = $this->getFirstReminderAffiliates($isProduction);
        foreach ($firstReminders as $affiliate) {
            $this->sendReminder($affiliate, 'first');
            $affiliate->update(['reminder_7_days_sent_at' => now()]);
            $this->info("First reminder sent to: {$affiliate->user->email}");
        }

        // Send final reminders (24 hours or testing equivalent)
        $finalReminders = $this->getFinalReminderAffiliates($isProduction);
        foreach ($finalReminders as $affiliate) {
            $this->sendReminder($affiliate, 'final');
            $affiliate->update(['reminder_24_hours_sent_at' => now()]);
            $this->info("Final reminder sent to: {$affiliate->user->email}");
        }

        $totalSent = $firstReminders->count() + $finalReminders->count();
        $this->info("Total reminders sent: {$totalSent}");
    }

    private function getFirstReminderAffiliates($isProduction)
    {
        if ($isProduction) {
            // 7 days before expiration
            $targetDate = now()->addDays(7)->startOfDay();
            return Affiliate::with('user')
                ->where('status', 'active')
                ->whereDate('expires_at', $targetDate)
                ->whereNull('reminder_7_days_sent_at')
                ->get();
        } else {
            // Testing: Send first reminder when 30-60 minutes remaining
            return Affiliate::with('user')
                ->where('status', 'active')
                ->where('expires_at', '>', now()->addMinutes(30)) // At least 30 min left
                ->where('expires_at', '<=', now()->addMinutes(60)) // Max 60 min left
                ->whereNull('reminder_7_days_sent_at')
                ->get();
        }
    }

    private function getFinalReminderAffiliates($isProduction)
    {
        if ($isProduction) {
            // 24 hours before expiration
            $targetTime = now()->addHours(24);
            return Affiliate::with('user')
                ->where('status', 'active')
                ->whereBetween('expires_at', [$targetTime->copy()->subHour(), $targetTime->copy()->addHour()])
                ->whereNull('reminder_24_hours_sent_at')
                ->get();
        } else {
            // Testing: Send final reminder when 10-40 minutes remaining
            return Affiliate::with('user')
                ->where('status', 'active')
                ->where('expires_at', '>', now()->addMinutes(10)) // At least 10 min left
                ->where('expires_at', '<=', now()->addMinutes(40)) // Max 40 min left
                ->whereNull('reminder_24_hours_sent_at')
                ->get();
        }
    }

    private function sendReminder($affiliate, $type)
    {
        Mail::to($affiliate->user->email)
            ->queue((new AffiliateExpirationReminder($affiliate->user, $affiliate, $type))->onQueue('emails'));
    }
}