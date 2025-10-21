<?php

require_once 'vendor/autoload.php';
use Illuminate\Foundation\Application;
use App\Models\User;

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$user = User::where('email', 'augustineosaretinmiracle001@gmail.com')->first();
if ($user) {
    echo "Email: {$user->email}\n";
    echo "Code: " . ($user->verification_code ?? 'None') . "\n";
    echo "Expires: " . ($user->verification_code_expires_at ?? 'None') . "\n";
    echo "Verified: " . ($user->hasVerifiedEmail() ? 'Yes' : 'No') . "\n";
    echo "Status: {$user->status}\n";
    
    echo "\nTesting verification with code 316774:\n";
    $result = $user->verifyWithCode('316774');
    echo "Result: " . ($result ? 'SUCCESS' : 'FAILED') . "\n";
    
    if ($result) {
        echo "User should now be verified and active\n";
    }
}