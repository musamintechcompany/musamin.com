<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Affiliate Membership Renewed Successfully</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: linear-gradient(135deg, #f97316 0%, #ea580c 100%); color: white; padding: 30px; text-align: center; border-radius: 10px 10px 0 0; }
        .content { background: #f8f9fa; padding: 30px; border-radius: 0 0 10px 10px; }
        .button { display: inline-block; background: linear-gradient(135deg, #f97316 0%, #ea580c 100%); color: white; padding: 12px 30px; text-decoration: none; border-radius: 5px; margin: 20px 0; }
        .benefits { background: white; padding: 20px; border-radius: 8px; margin: 20px 0; }
        .benefit-item { margin: 10px 0; padding: 10px; border-left: 4px solid #f97316; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🔄 Affiliate Membership Renewed!</h1>
            <p>Thank you for continuing with us, {{ $user->name }}!</p>
        </div>
        
        <div class="content">
            <p>Hi {{ $user->name }},</p>
            
            <p>Great news! Your affiliate membership has been successfully renewed. Your {{ ucfirst($planType) }} Plan payment of {{ number_format($feesPaid) }} coins has been processed, and your affiliate benefits are now extended for another {{ $duration }}.</p>
            
            <div class="benefits">
                <h3>🚀 Your Continued Benefits:</h3>
                <div class="benefit-item">
                    <strong>High Commission:</strong> Continue earning up to 30% commission on every successful referral
                </div>
                <div class="benefit-item">
                    <strong>Your Store:</strong> Keep your public store active and visible to all platform users
                </div>
                <div class="benefit-item">
                    <strong>Marketplace Assets:</strong> Continue adding assets to our marketplace with free promotional ads
                </div>
                <div class="benefit-item">
                    <strong>Free Advertising:</strong> We'll keep promoting your assets across multiple platforms
                </div>
                <div class="benefit-item">
                    <strong>Real-time Analytics:</strong> Access your detailed analytics dashboard without interruption
                </div>
                <div class="benefit-item">
                    <strong>Global Visibility:</strong> Your store remains public to all users worldwide
                </div>
            </div>
            
            <p>Your renewed {{ ucfirst($planType) }} Plan membership is now valid for another {{ $duration }}. Continue building your business and earning commissions with us!</p>
            
            <div style="text-align: center;">
                <a href="{{ route('affiliate.dashboard') }}" class="button">
                    Continue to Your Dashboard
                </a>
            </div>
            
            <p>Thank you for your continued trust in our platform. We're excited to support your success for another {{ $duration }}!</p>
            
            <p>If you have any questions or need assistance, please don't hesitate to contact our support team.</p>
            
            <p>Here's to another successful year!</p>
            
            <p>Best regards,<br>
            The {{ config('app.name') }} Team</p>
        </div>
    </div>
</body>
</html>