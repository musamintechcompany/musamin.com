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
            background-color: #dc2626;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 8px 8px 0 0;
        }
        .suspended-box {
            background-color: #fef2f2;
            border-left: 4px solid #dc2626;
            padding: 15px;
            margin: 15px 0;
        }
        .email-button {
            background-color: #dc2626;
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
            content: "⚠️";
            position: absolute;
            left: 0;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-content">
            <div class="email-header">
                <h1>Account Suspended</h1>
            </div>

            <h2>Hello {{ $user->name }},</h2>

            <p>We regret to inform you that your account has been suspended.</p>

            @if($reason)
            <div class="suspended-box">
                <strong>Reason:</strong> {{ $reason }}
            </div>
            @endif

            <p><strong>Current Status:</strong> {{ $user::STATUSES[$user->status] }}</p>
            <p><strong>Previous Status:</strong> {{ $user::STATUSES[$previousStatus] }}</p>

            <p>This suspension means:</p>

            <ul class="consequences">
                <li>You cannot access your account dashboard</li>
                <li>All active transactions have been paused</li>
                <li>Your coins remain in your wallet but cannot be used</li>
            </ul>

            <p>If you believe this suspension is in error, you may appeal this decision.</p>

            <a href="{{ route('account.appeal') }}" class="email-button">Appeal Suspension</a>

            <p>The appeal process typically takes 3-5 business days for review.</p>

            <div class="email-footer">
                <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
                <p><a href="{{ route('contact') }}" style="color: #6b7280; text-decoration: none;">Contact Support</a></p>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        // Email tracking
        if (window.location.href.indexOf('?track') === -1) {
            var img = new Image();
            img.src = '{{ route('email.track', ['type' => 'open', 'user' => $user->id, 'status' => 'suspended']) }}';
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
