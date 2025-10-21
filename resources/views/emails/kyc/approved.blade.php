<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>KYC Approved</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: #10B981; color: white; padding: 20px; text-align: center; border-radius: 8px 8px 0 0; }
        .content { background: #f9f9f9; padding: 30px; border-radius: 0 0 8px 8px; }
        .success-icon { font-size: 48px; color: #10B981; text-align: center; margin-bottom: 20px; }
        .button { display: inline-block; background: #3B82F6; color: white; padding: 12px 24px; text-decoration: none; border-radius: 6px; margin: 20px 0; }
        .footer { text-align: center; margin-top: 30px; color: #666; font-size: 14px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🎉 KYC Verification Approved!</h1>
        </div>
        
        <div class="content">
            <div class="success-icon">✅</div>
            
            <h2>Congratulations, {{ $user->name }}!</h2>
            
            <p>We're excited to inform you that your KYC (Know Your Customer) verification has been <strong>successfully approved</strong>!</p>
            
            <div style="background: white; padding: 20px; border-radius: 6px; margin: 20px 0; border-left: 4px solid #10B981;">
                <h3 style="margin-top: 0; color: #10B981;">✓ Verification Complete</h3>
                <p>Your identity verification has been successfully completed and approved.</p>
            </div>
            
            <h3>What's Next?</h3>
            <ul>
                <li>✅ Full access to all platform features</li>
                <li>✅ Higher transaction limits</li>
                <li>✅ Priority customer support</li>
                <li>✅ Access to premium services</li>
            </ul>
            
            <div style="text-align: center;">
                <a href="{{ route('dashboard') }}" class="button">Access Your Dashboard</a>
            </div>
            
            <p>Thank you for completing the verification process. If you have any questions, our support team is here to help.</p>
            
            <p>Best regards,<br>
            The {{ config('app.name') }} Team</p>
        </div>
        
        <div class="footer">
            <p>This email was sent to {{ $user->email }}. If you have any questions, please contact our support team.</p>
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
        </div>
    </div>
</body>
</html>