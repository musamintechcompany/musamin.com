<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Withdrawal Request Update</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: #EF4444; color: white; padding: 20px; text-align: center; border-radius: 8px 8px 0 0; }
        .content { background: #f9f9f9; padding: 30px; border-radius: 0 0 8px 8px; }
        .info-icon { font-size: 48px; color: #EF4444; text-align: center; margin-bottom: 20px; }
        .button { display: inline-block; background: #3B82F6; color: white; padding: 12px 24px; text-decoration: none; border-radius: 6px; margin: 20px 0; }
        .footer { text-align: center; margin-top: 30px; color: #666; font-size: 14px; }
        .refund-box { background: white; padding: 20px; border-radius: 6px; margin: 20px 0; border-left: 4px solid #10B981; text-align: center; }
        .reason-box { background: white; padding: 20px; border-radius: 6px; margin: 20px 0; border-left: 4px solid #EF4444; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📋 Withdrawal Request Update</h1>
        </div>
        
        <div class="content">
            <div class="info-icon">ℹ️</div>
            
            <h2>Hello {{ $user->name }},</h2>
            
            <p>We need to inform you about your recent withdrawal request.</p>
            
            @if($withdrawal->admin_notes)
            <div class="reason-box">
                <h3 style="margin-top: 0; color: #EF4444;">Reason for Review</h3>
                <p>{{ $withdrawal->admin_notes }}</p>
            </div>
            @endif
            
            <div class="refund-box">
                <h3 style="margin-top: 0; color: #10B981;">✅ Coins Refunded</h3>
                <p><strong>Refunded Amount:</strong> {{ number_format($withdrawal->amount + $withdrawal->fee) }} coins</p>
                <p><strong>Original Request:</strong> {{ number_format($withdrawal->amount) }} coins</p>
                <p><strong>Fee Refunded:</strong> {{ number_format($withdrawal->fee) }} coins</p>
            </div>
            
            <p>Your coins have been automatically refunded to your earned wallet. You can submit a new withdrawal request at any time.</p>
            
            <div style="text-align: center;">
                <a href="{{ route('wallet') }}" class="button">View Wallet</a>
            </div>
            
            <p>If you have any questions, please don't hesitate to contact our support team.</p>
            
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