<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Affiliate Membership Reminder</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; margin: 0; padding: 0; background-color: #f4f4f4; }
        .container { max-width: 600px; margin: 0 auto; background: white; padding: 20px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        .header { text-align: center; padding: 20px 0; border-bottom: 2px solid #007bff; }
        .logo { font-size: 24px; font-weight: bold; color: #007bff; }
        .content { padding: 30px 0; }
        .alert { background: #fff3cd; border: 1px solid #ffeaa7; padding: 15px; border-radius: 5px; margin: 20px 0; }
        .alert.urgent { background: #f8d7da; border-color: #f5c6cb; }
        .btn { display: inline-block; padding: 12px 30px; background: #007bff; color: white; text-decoration: none; border-radius: 5px; font-weight: bold; margin: 20px 0; }
        .btn:hover { background: #0056b3; }
        .footer { text-align: center; padding: 20px 0; border-top: 1px solid #eee; color: #666; font-size: 12px; }
        .highlight { color: #007bff; font-weight: bold; }
        .expiry-info { background: #e9ecef; padding: 15px; border-radius: 5px; margin: 15px 0; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">{{ config('app.name', 'Musamin') }}</div>
        </div>

        <div class="content">
            <h2>Hello {{ $user->name }}!</h2>

            @if($reminderType === 'first')
                <div class="alert">
                    <strong>⏰ Reminder:</strong> Your affiliate membership will expire in <span class="highlight">{{ $timeRemaining }}</span>!
                </div>
                
                <p>We wanted to give you a heads up that your <strong>{{ ucfirst($planType) }}</strong> affiliate membership is approaching its expiration date.</p>
            @else
                <div class="alert urgent">
                    <strong>🚨 Final Notice:</strong> Your affiliate membership expires in <span class="highlight">{{ $timeRemaining }}</span>!
                </div>
                
                <p>This is your final reminder! Your <strong>{{ ucfirst($planType) }}</strong> affiliate membership is about to expire.</p>
            @endif

            <div class="expiry-info">
                <strong>Membership Details:</strong><br>
                📅 <strong>Expires:</strong> {{ $expiresAt->format('F j, Y \a\t g:i A') }}<br>
                📋 <strong>Plan Type:</strong> {{ ucfirst($planType) }}<br>
                🔗 <strong>Affiliate Code:</strong> {{ $affiliate->affiliate_code }}
            </div>

            <h3>Why Renew Your Membership?</h3>
            <ul>
                <li>✅ Continue earning commissions from referrals</li>
                <li>✅ Maintain your affiliate status and benefits</li>
                <li>✅ Keep your unique affiliate code active</li>
                <li>✅ Access to exclusive affiliate resources</li>
            </ul>

            @if($reminderType === 'final')
                <p><strong>⚠️ Important:</strong> If you don't renew before the expiration time, your affiliate account will be deactivated and you'll lose access to all affiliate benefits.</p>
            @endif

            <div style="text-align: center; margin: 30px 0;">
                <a href="{{ $renewalUrl }}" class="btn">Renew My Membership Now</a>
            </div>

            <p>If you have any questions about your membership or need assistance with renewal, please don't hesitate to contact our support team.</p>

            <p>Thank you for being a valued affiliate partner!</p>

            <p>Best regards,<br>
            <strong>The {{ config('app.name', 'Musamin') }} Team</strong></p>
        </div>

        <div class="footer">
            <p>This email was sent to {{ $user->email }} because you have an active affiliate membership.</p>
            <p>© {{ date('Y') }} {{ config('app.name', 'Musamin') }}. All rights reserved.</p>
        </div>
    </div>
</body>
</html>