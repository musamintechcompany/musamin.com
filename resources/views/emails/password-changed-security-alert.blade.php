<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Security Alert - Password Changed</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            line-height: 1.6;
            color: #374151;
            background-color: #f9fafb;
        }
        .email-wrapper {
            width: 100%;
            background-color: #f9fafb;
            padding: 40px 20px;
        }
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .header {
            background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
            padding: 40px 30px;
            text-align: center;
        }
        .header h1 {
            color: #ffffff;
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 8px;
        }
        .header p {
            color: #fecaca;
            font-size: 16px;
        }
        .content {
            padding: 40px 30px;
        }
        .alert-icon {
            text-align: center;
            font-size: 48px;
            margin-bottom: 20px;
        }
        .greeting {
            font-size: 18px;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 20px;
        }
        .message {
            font-size: 16px;
            color: #4b5563;
            margin-bottom: 25px;
            line-height: 1.7;
        }
        .password-change-info {
            background-color: #fef3c7;
            border-left: 4px solid #f59e0b;
            padding: 20px;
            margin: 25px 0;
            border-radius: 0 8px 8px 0;
        }
        .password-change-info h3 {
            color: #92400e;
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 10px;
        }
        .password-change-info p {
            color: #92400e;
            margin: 5px 0;
            font-size: 14px;
        }
        .security-actions {
            background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
            border: 2px solid #f87171;
            padding: 25px;
            margin: 30px 0;
            border-radius: 8px;
        }
        .security-actions h3 {
            color: #dc2626;
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 15px;
        }
        .action-list {
            list-style: none;
            padding: 0;
        }
        .action-list li {
            color: #b91c1c;
            margin: 8px 0;
            padding-left: 20px;
            position: relative;
        }
        .action-list li:before {
            content: "🔒";
            position: absolute;
            left: 0;
        }
        .cta-container {
            text-align: center;
            margin: 30px 0;
        }
        .cta-button {
            display: inline-block;
            background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
            color: #ffffff;
            text-decoration: none;
            padding: 14px 28px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 16px;
            margin: 0 10px 10px 0;
        }
        .footer {
            background-color: #f9fafb;
            padding: 30px;
            text-align: center;
            border-top: 1px solid #e5e7eb;
        }
        .footer p {
            color: #6b7280;
            font-size: 14px;
            margin-bottom: 10px;
        }
        @media (max-width: 600px) {
            .email-wrapper { padding: 20px 10px; }
            .header, .content, .footer { padding: 30px 20px; }
            .cta-button { display: block; margin: 10px 0; }
        }
    </style>
</head>
<body>
    <div class="email-wrapper">
        <div class="email-container">
            <div class="header">
                <h1>🔐 Security Alert</h1>
                <p>Your {{ config('app.name') }} password was changed</p>
            </div>

            <div class="content">
                <div class="alert-icon">⚠️</div>
                
                <div class="greeting">Hello {{ $user->name }},</div>

                <div class="message">
                    This is an important security notification. The password for your {{ config('app.name') }} account has been successfully changed.
                </div>

                <div class="password-change-info">
                    <h3>🔑 Password Change Details</h3>
                    <p><strong>Account:</strong> {{ $user->name }} ({{ $user->username }})</p>
                    <p><strong>Email:</strong> {{ $user->email }}</p>
                    <p><strong>Changed On:</strong> {{ now()->format('M j, Y \a\t g:i A T') }}</p>
                    <p><strong>IP Address:</strong> {{ request()->ip() }}</p>
                </div>

                <div class="message">
                    <strong>If you made this change:</strong> No action is required. Your account is secure and you can continue using {{ config('app.name') }} with your new password.
                </div>

                <div class="security-actions">
                    <h3>🚨 If you DID NOT make this change:</h3>
                    <ul class="action-list">
                        <li>Someone may have unauthorized access to your account</li>
                        <li>Change your password immediately using account recovery</li>
                        <li>Enable Two-Factor Authentication for extra security</li>
                        <li>Review your recent account activity</li>
                        <li>Contact our support team for immediate assistance</li>
                    </ul>
                </div>

                <div class="cta-container">
                    <a href="{{ url('/settings/security') }}" class="cta-button">
                        🔒 Secure My Account
                    </a>
                    <a href="{{ url('/support') }}" class="cta-button">
                        📞 Contact Support
                    </a>
                </div>

                <div class="message">
                    <strong>Security Tip:</strong> Use a strong, unique password and enable Two-Factor Authentication to keep your account secure. Never share your password with anyone.
                </div>
            </div>

            <div class="footer">
                <p>This is an automated security alert from {{ config('app.name') }}.</p>
                <p>If you have questions, contact our support team immediately.</p>
                <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
            </div>
        </div>
    </div>
</body>
</html>