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
            background-color: #b91c1c;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 8px 8px 0 0;
        }
        .blocked-box {
            background-color: #fef2f2;
            border: 1px solid #b91c1c;
            border-radius: 4px;
            padding: 15px;
            margin: 15px 0;
        }
        .email-button {
            background-color: #b91c1c;
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
            border-top: 1px solid #e5e7eb;
            margin-top: 20px;
        }
        ul.consequences {
            margin-left: 20px;
            padding-left: 0;
        }
        ul.consequences li {
            margin-bottom: 10px;
            list-style-type: none;
            position: relative;
            padding-left: 25px;
        }
        ul.consequences li:before {
            content: "❌";
            position: absolute;
            left: 0;
        }
        .urgent-notice {
            font-weight: 700;
            color: #b91c1c;
            text-transform: uppercase;
            font-size: 0.9em;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-content">
            <div class="email-header">
                <h1>Account Blocked</h1>
                <p class="urgent-notice">Urgent Security Notice</p>
            </div>

            <h2>Hello {{ $user->name }},</h2>

            <p>We have detected severe violations of our Terms of Service and have <strong>permanently blocked</strong> your account.</p>

            @if($reason)
            <div class="blocked-box">
                <strong>Violation Reason:</strong> {{ $reason }}
            </div>
            @endif

            <p><strong>Current Status:</strong> {{ $user::STATUSES[$user->status] }}</p>
            <p><strong>Previous Status:</strong> {{ $user::STATUSES[$previousStatus] }}</p>

            <p>This action means:</p>

            <ul class="consequences">
                <li>Immediate termination of all account access</li>
                <li>Forfeiture of any remaining coins or balances</li>
                <li>Permanent prohibition from creating new accounts</li>
                <li>Possible legal action in cases of fraud</li>
            </ul>

            <p>If you believe this action was taken in error, you have <strong>7 days</strong> to submit an appeal with evidence supporting your claim.</p>

            <a href="{{ route('account.appeal') }}" class="email-button">Submit Final Appeal</a>

            <p><strong>Note:</strong> Appeals for blocked accounts typically take 7-10 business days for review. All decisions are final.</p>

            <div class="email-footer">
                <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
                <p>
                    <a href="{{ route('terms') }}" style="color: #6b7280; text-decoration: none; margin: 0 5px;">Terms of Service</a> |
                    <a href="{{ route('privacy') }}" style="color: #6b7280; text-decoration: none; margin: 0 5px;">Privacy Policy</a>
                </p>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        // Enhanced tracking for blocked accounts
        if (window.location.href.indexOf('?track') === -1) {
            var trackPixel = new Image();
            trackPixel.src = '{{ route('email.track', [
                'type' => 'open',
                'user' => $user->id,
                'status' => 'blocked',
                'reason' => urlencode($reason ?? 'none')
            ]) }}';
        }

        // Detailed click tracking
        document.addEventListener('DOMContentLoaded', function() {
            var links = document.querySelectorAll('a');
            links.forEach(function(link) {
                link.addEventListener('click', function(e) {
                    var trackUrl = '{{ route('email.track', ['type' => 'click', 'user' => $user->id]) }}' +
                                  '&url=' + encodeURIComponent(this.href) +
                                  '&element=' + encodeURIComponent(this.innerText) +
                                  '&status=blocked';
                    new Image().src = trackUrl;

                    // Small delay to ensure tracking fires before navigation
                    setTimeout(function() {
                        window.location.href = this.href;
                    }.bind(this), 150);
                });
            });
        });
    </script>
</body>
</html>
