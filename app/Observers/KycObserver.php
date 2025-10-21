<?php

namespace App\Observers;

use App\Models\KycVerification;
use App\Events\Admin\KycSubmitted;
use Illuminate\Support\Facades\Log;

class KycObserver
{
    public function created(KycVerification $kyc): void
    {
        Log::info('KycObserver triggered for user: ' . $kyc->user->email);
        
        // Directly notify admins
        Log::info('Directly notifying admins from KycObserver');
        $listener = new \App\Listeners\Admin\NotifyAdminsOfKycSubmission();
        $event = new KycSubmitted($kyc);
        $listener->handle($event);
        
        Log::info('KycObserver completed for user: ' . $kyc->user->email);
    }
}