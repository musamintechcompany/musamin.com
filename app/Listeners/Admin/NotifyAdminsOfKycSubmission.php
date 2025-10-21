<?php

namespace App\Listeners\Admin;

use App\Events\Admin\KycSubmitted;
use App\Models\Admin;
use App\Notifications\Admin\KycSubmissionNotification;
use Illuminate\Support\Facades\Log;

class NotifyAdminsOfKycSubmission
{
    public function handle(KycSubmitted $event): void
    {
        Log::info('NotifyAdminsOfKycSubmission listener triggered');
        
        $admins = Admin::all();
        Log::info('Found ' . $admins->count() . ' admins to notify');
        
        foreach ($admins as $admin) {
            try {
                $admin->notify(new KycSubmissionNotification($event->kyc));
                Log::info('Notified admin: ' . $admin->email);
            } catch (\Exception $e) {
                Log::error('Failed to notify admin ' . $admin->email . ': ' . $e->getMessage());
            }
        }
        
        Log::info('NotifyAdminsOfKycSubmission listener completed');
    }
}