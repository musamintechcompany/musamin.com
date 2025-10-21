<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Schedule affiliate reminder emails
Schedule::command('affiliate:send-reminders')
    ->everyMinute()
    ->description('Send affiliate expiration reminder emails');
