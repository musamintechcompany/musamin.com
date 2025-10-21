<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Coins Received</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px;">
    <div style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%); padding: 30px; text-align: center; border-radius: 10px 10px 0 0;">
        <h1 style="color: white; margin: 0; font-size: 28px;">Coins Received!</h1>
        <p style="color: rgba(255,255,255,0.9); margin: 10px 0 0 0; font-size: 16px;">You've received coins from another user</p>
    </div>
    
    <div style="background: #f8f9fa; padding: 30px; border-radius: 0 0 10px 10px;">
        <div style="background: white; padding: 25px; border-radius: 8px; margin-bottom: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
            <h2 style="color: #333; margin-top: 0; font-size: 20px;">Transfer Details</h2>
            
            <div style="border-left: 4px solid #28a745; padding-left: 15px; margin: 20px 0;">
                <p style="margin: 5px 0;"><strong>Amount Received:</strong> {{ number_format($amount) }} coins</p>
                <p style="margin: 5px 0;"><strong>From:</strong> {{ $senderName }}</p>
                <p style="margin: 5px 0;"><strong>Sender Wallet:</strong> <code style="background: #f1f3f4; padding: 2px 6px; border-radius: 4px;">{{ $senderWallet }}</code></p>
            </div>
            
            <div style="border-left: 4px solid #6f42c1; padding-left: 15px; margin: 20px 0;">
                <p style="margin: 5px 0;"><strong>Credited To:</strong> Earned Wallet</p>
                <p style="margin: 5px 0;"><strong>Current Balance:</strong> {{ number_format($currentBalance) }} coins</p>
            </div>
        </div>
        
        <div style="text-align: center; margin-top: 30px;">
            <a href="{{ route('wallet') }}" style="background: #28a745; color: white; padding: 12px 30px; text-decoration: none; border-radius: 6px; display: inline-block; font-weight: bold;">View Wallet</a>
        </div>
        
        <div style="text-align: center; margin-top: 30px; padding-top: 20px; border-top: 1px solid #dee2e6; color: #6c757d; font-size: 14px;">
            <p>Thank you for using {{ config('app.name') }}!</p>
            <p>If you have any questions, please contact our support team.</p>
        </div>
    </div>
</body>
</html>