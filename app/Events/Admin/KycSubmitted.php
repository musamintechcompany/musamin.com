<?php

namespace App\Events\Admin;

use App\Models\KycVerification;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class KycSubmitted
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $kyc;

    public function __construct(KycVerification $kyc)
    {
        $this->kyc = $kyc;
    }
}