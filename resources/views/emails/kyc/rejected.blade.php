<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>KYC Verification Update</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: #EF4444; color: white; padding: 20px; text-align: center; border-radius: 8px 8px 0 0; }
        .content { background: #f9f9f9; padding: 30px; border-radius: 0 0 8px 8px; }
        .warning-icon { font-size: 48px; color: #EF4444; text-align: center; margin-bottom: 20px; }
        .button { display: inline-block; background: #3B82F6; color: white; padding: 12px 24px; text-decoration: none; border-radius: 6px; margin: 20px 0; }
        .footer { text-align: center; margin-top: 30px; color: #666; font-size: 14px; }
        .rejection-box { background: white; padding: 20px; border-radius: 6px; margin: 20px 0; border-left: 4px solid #EF4444; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>KYC Verification Update</h1>
        </div>
        
        <div class="content">
            <div class="warning-icon">⚠️</div>
            
            <h2>Hello {{ $user->name }},</h2>
            
            <p>We've reviewed your KYC (Know Your Customer) verification submission, and unfortunately, we need you to resubmit your documents.</p>
            
            <div class="rejection-box">
                <h3 style="margin-top: 0; color: #EF4444;">📋 Reason for Rejection</h3>
                <p style="background: #FEF2F2; padding: 15px; border-radius: 4px; color: #DC2626;">
                    {{ $kyc->rejection_reason }}
                </p>
            </div>
            
            <h3>What You Need to Do:</h3>
            <ul>
                <li>📄 Review the rejection reason above</li>
                <li>📸 Prepare new, clear documents</li>
                <li>✅ Ensure all information is accurate</li>
                <li>🔄 Submit a new KYC application</li>
            </ul>
            
            <div style="background: #EBF8FF; padding: 20px; border-radius: 6px; margin: 20px 0; border-left: 4px solid #3B82F6;">
                <h4 style="margin-top: 0; color: #1E40AF;">💡 Tips for Success:</h4>
                <ul style="margin-bottom: 0;">
                    <li>Ensure documents are clear and readable</li>
                    <li>Make sure all information matches exactly</li>
                    <li>Use good lighting when taking photos</li>
                    <li>Double-check all fields before submitting</li>
                </ul>
            </div>
            
            <div style="text-align: center;">
                <a href="{{ route('settings.kyc.identity') }}" class="button">Resubmit KYC Application</a>
            </div>
            
            <p>If you have any questions about the rejection or need assistance with your resubmission, please don't hesitate to contact our support team.</p>
            
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