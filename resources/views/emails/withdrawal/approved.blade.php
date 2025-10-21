<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Withdrawal Approved</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: #10B981; color: white; padding: 20px; text-align: center; border-radius: 8px 8px 0 0; }
        .content { background: #f9f9f9; padding: 30px; border-radius: 0 0 8px 8px; }
        .success-icon { font-size: 48px; color: #10B981; text-align: center; margin-bottom: 20px; }
        .button { display: inline-block; background: #3B82F6; color: white; padding: 12px 24px; text-decoration: none; border-radius: 6px; margin: 20px 0; }
        .footer { text-align: center; margin-top: 30px; color: #666; font-size: 14px; }
        .amount-box { background: white; padding: 20px; border-radius: 6px; margin: 20px 0; border-left: 4px solid #10B981; text-align: center; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>💰 Withdrawal Approved!</h1>
        </div>
        
        <div class="content">
            <div class="success-icon">✅</div>
            
            <h2>Great news, {{ $user->name }}!</h2>
            
            <p>Your withdrawal request has been <strong>approved and processed</strong>!</p>
            
            <div class="amount-box">
                <h3 style="margin-top: 0; color: #10B981;">Withdrawal Details</h3>
                <p><strong>Amount:</strong> {{ number_format($withdrawal->net_amount) }} coins</p>
                <p><strong>Equivalent:</strong> ${{ number_format($withdrawal->net_amount * 0.01, 2) }}</p>
                <p><strong>Bank Account:</strong> {{ $withdrawal->withdrawalDetail->method_name }}</p>
            </div>
            
            <p>Your funds will be transferred to your registered bank account within 1-3 business days.</p>
            
            <div style="text-align: center;">
                <a href="{{ route('wallet') }}" class="button">View Wallet</a>
            </div>
            
            <p>Thank you for using {{ config('app.name') }}!</p>
            
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