<!DOCTYPE html>
<html>
<head>
    <style type="text/css">
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            font-family: 'Segoe UI', Arial, sans-serif;
            background-color: #f9fafb;
            padding: 20px;
        }
        .email-content {
            background-color: #ffffff;
            border-radius: 8px;
            padding: 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        .email-header {
            background-color: #10b981; /* Emerald green for restoration */
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 8px 8px 0 0;
        }
        .restore-box {
            background-color: #ecfdf5;
            border-left: 4px solid #10b981;
            padding: 15px;
            margin: 15px 0;
        }
        .email-button {
            background-color: #10b981;
            color: white !important;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 600;
            display: inline-block;
            margin: 15px 0;
        }
        .email-footer {
            text-align: center;
            padding: 20px;
            color: #6b7280;
            font-size: 14px;
        }
        ul.benefits {
            margin-left: 20px;
            padding-left: 0;
        }
        ul.benefits li {
            margin-bottom: 10px;
            list-style-type: none;
            position: relative;
            padding-left: 25px;
        }
        ul.benefits li:before {
            content: "✓";
            color: #10b981;
            font-weight: bold;
            position: absolute;
            left: 0;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-content">
            <div class="email-header">
                <h1>Account Restored</h1>
                <p>Welcome Back!</p>
            </div>

            <h2>Hello {{ $user->name }},</h2>

            <p>We're pleased to inform you that your account has been successfully restored.</p>

            @if($reason)
            <div class="restore-box">
                <strong>Note:</strong> {{ $reason }}
            </div>
            @endif

            <p>Your account now has full access to all features:</p>

            <ul class="benefits">
                <li>Full access to your dashboard</li>
                <li>Ability to make transactions</li>
                <li>All previous coins and balances restored</li>
                <li>Complete functionality reinstated</li>
            </ul>

            <div style="text-align: center;">
                <a href="{{ route('dashboard') }}" class="email-button">Access Your Account</a>
            </div>

            <p>If you didn't request this restoration or need any assistance, please contact our support team immediately.</p>

            <div class="email-footer">
                <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
                <p>
                    <a href="{{ route('contact') }}" style="color: #6b7280; text-decoration: none;">Contact Support</a> |
                    <a href="{{ route('security') }}" style="color: #6b7280; text-decoration: none;">Security Tips</a>
                </p>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        // Email tracking
        if (window.location.href.indexOf('?track') === -1) {
            var img = new Image();
            img.src = '{{ route('email.track', ['type' => 'open', 'user' => $user->id, 'status' => 'restored']) }}';
        }

        // Enhanced click tracking
        document.addEventListener('DOMContentLoaded', function() {
            var links = document.querySelectorAll('a');
            links.forEach(function(link) {
                link.addEventListener('click', function(e) {
                    var trackUrl = '{{ route('email.track', ['type' => 'click', 'user' => $user->id]) }}' +
                                  '&url=' + encodeURIComponent(this.href) +
                                  '&element=' + encodeURIComponent(this.innerText);
                    new Image().src = trackUrl;
                });
            });
        });
    </script>
</body>
</html>
