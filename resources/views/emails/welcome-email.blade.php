<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Welcome to {{ config('app.name') }}!</title>
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
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            padding: 50px 30px;
            text-align: center;
            position: relative;
        }
        .header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="20" cy="20" r="2" fill="%23ffffff" opacity="0.1"/><circle cx="80" cy="30" r="1.5" fill="%23ffffff" opacity="0.1"/><circle cx="40" cy="70" r="1" fill="%23ffffff" opacity="0.1"/><circle cx="90" cy="80" r="2.5" fill="%23ffffff" opacity="0.1"/></svg>') repeat;
        }
        .header-content {
            position: relative;
            z-index: 1;
        }
        .welcome-icon {
            font-size: 48px;
            margin-bottom: 16px;
        }
        .header h1 {
            color: #ffffff;
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 8px;
        }
        .header p {
            color: #d1fae5;
            font-size: 18px;
        }
        .content {
            padding: 50px 30px;
        }
        .greeting {
            font-size: 24px;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 20px;
            text-align: center;
        }
        .message {
            font-size: 16px;
            color: #4b5563;
            margin-bottom: 25px;
            line-height: 1.7;
        }
        .highlight-box {
            background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
            border-left: 4px solid #0ea5e9;
            padding: 25px;
            margin: 30px 0;
            border-radius: 0 8px 8px 0;
        }
        .highlight-box h3 {
            color: #0c4a6e;
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 10px;
        }
        .highlight-box p {
            color: #075985;
            margin: 0;
        }
        .cta-container {
            text-align: center;
            margin: 40px 0;
        }
        .cta-button {
            display: inline-block;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #ffffff;
            text-decoration: none;
            padding: 16px 32px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 16px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s;
        }
        .cta-button:hover {
            transform: translateY(-2px);
        }
        .features {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin: 40px 0;
        }
        .feature {
            text-align: center;
            padding: 20px;
            background-color: #f9fafb;
            border-radius: 8px;
        }
        .feature-icon {
            font-size: 24px;
            margin-bottom: 10px;
        }
        .feature h4 {
            color: #1f2937;
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 8px;
        }
        .feature p {
            color: #6b7280;
            font-size: 14px;
            margin: 0;
        }
        .footer {
            background-color: #f9fafb;
            padding: 40px 30px;
            text-align: center;
            border-top: 1px solid #e5e7eb;
        }
        .footer p {
            color: #6b7280;
            font-size: 14px;
            margin-bottom: 15px;
        }
        .social-links {
            margin-top: 25px;
        }
        .social-links a {
            display: inline-block;
            margin: 0 12px;
            color: #9ca3af;
            text-decoration: none;
            font-size: 20px;
            transition: color 0.2s;
        }
        .social-links a:hover {
            color: #667eea;
        }
        @media (max-width: 600px) {
            .email-wrapper { padding: 20px 10px; }
            .header, .content, .footer { padding: 30px 20px; }
            .header h1 { font-size: 28px; }
            .greeting { font-size: 20px; }
            .features { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    <div class="email-wrapper">
        <div class="email-container">
            <div class="header">
                <div class="header-content">
                    <div class="welcome-icon">🎉</div>
                    <h1>Welcome to {{ config('app.name') }}!</h1>
                    <p>Your journey starts here</p>
                </div>
            </div>

            <div class="content">
                <div class="greeting">Hello {{ $user->name }}! 🚀</div>

                <div class="message">
                    Congratulations! Your email has been successfully verified and your account is now fully activated. We're thrilled to have you join our community!
                </div>

                <div class="highlight-box">
                    <h3>🎆 You're All Set!</h3>
                    <p>Your {{ config('app.name') }} account is ready to use. You now have access to all our premium features and can start exploring everything we have to offer.</p>
                </div>

                <div class="cta-container">
                    <a href="{{ url('/dashboard') }}" class="cta-button">
                        📊 Explore Your Dashboard
                    </a>
                </div>

                <div class="features">
                    <div class="feature">
                        <div class="feature-icon">💰</div>
                        <h4>Coin Packages</h4>
                        <p>Browse and purchase coin packages to enhance your experience</p>
                    </div>
                    <div class="feature">
                        <div class="feature-icon">🛍️</div>
                        <h4>Marketplace</h4>
                        <p>Discover amazing products and services in our marketplace</p>
                    </div>
                    <div class="feature">
                        <div class="feature-icon">⚙️</div>
                        <h4>Settings</h4>
                        <p>Customize your account and preferences to your liking</p>
                    </div>
                </div>

                <div class="message">
                    If you have any questions or need assistance getting started, our support team is here to help. Don't hesitate to reach out!
                </div>

                <div class="message" style="text-align: center; font-weight: 600; color: #059669;">
                    Welcome aboard! Let's make great things happen together. 🌟
                </div>
            </div>

            <div class="footer">
                <p>Thank you for choosing {{ config('app.name') }}. We're excited to be part of your journey!</p>
                <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>

                <div class="social-links">
                    <a href="#" title="Email">📧</a>
                    <a href="#" title="Twitter">🐦</a>
                    <a href="#" title="Facebook">📘</a>
                    <a href="#" title="Instagram">📷</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
