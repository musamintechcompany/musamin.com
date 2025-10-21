<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Welcome to Our Affiliate Program</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 30px; text-align: center; border-radius: 10px 10px 0 0; }
        .content { background: #f8f9fa; padding: 30px; border-radius: 0 0 10px 10px; }
        .button { display: inline-block; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 12px 30px; text-decoration: none; border-radius: 5px; margin: 20px 0; }
        .benefits { background: white; padding: 20px; border-radius: 8px; margin: 20px 0; }
        .benefit-item { margin: 10px 0; padding: 10px; border-left: 4px solid #667eea; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🎉 Welcome to Our Affiliate Program!</h1>
            <p>Congratulations, {{ $user->name }}!</p>
        </div>
        
        <div class="content">
            <p>Hi {{ $user->name }},</p>
            
            <p>We're thrilled to welcome you to our exclusive affiliate program! Your {{ ucfirst($planType) }} Plan payment of {{ number_format($feesPaid) }} coins has been successfully processed, and your affiliate membership is now active.</p>
            
            <div class="benefits">
                <h3>🚀 Your Affiliate Benefits:</h3>
                <div class="benefit-item">
                    <strong>High Commission:</strong> Earn up to 30% commission on every successful referral
                </div>
                <div class="benefit-item">
                    <strong>Create Your Store:</strong> Build your own public store visible to all platform users
                </div>
                <div class="benefit-item">
                    <strong>Marketplace Assets:</strong> Add assets to our marketplace with free promotional ads
                </div>
                <div class="benefit-item">
                    <strong>Free Advertising:</strong> We promote your assets across multiple platforms for free
                </div>
                <div class="benefit-item">
                    <strong>Real-time Analytics:</strong> Monitor your performance with detailed analytics dashboard
                </div>
                <div class="benefit-item">
                    <strong>Global Visibility:</strong> Your store becomes public to all users, increasing customer reach
                </div>
            </div>
            
            <p>Your {{ ucfirst($planType) }} Plan membership is valid for {{ $duration }} from today. Start exploring your new affiliate dashboard and begin earning commissions right away!</p>
            
            <div style="text-align: center;">
                <a href="{{ route('affiliate.dashboard') }}" class="button">
                    Access Your Affiliate Dashboard
                </a>
            </div>
            
            <p>If you have any questions or need assistance, please don't hesitate to contact our support team.</p>
            
            <p>Welcome aboard and happy earning!</p>
            
            <p>Best regards,<br>
            The {{ config('app.name') }} Team</p>
        </div>
    </div>
</body>
</html>