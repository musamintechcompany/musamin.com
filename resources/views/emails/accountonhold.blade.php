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
            background-color: #1d4ed8;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 8px 8px 0 0;
        }
        .hold-box {
            background-color: #eff6ff;
            border-left: 4px solid #1d4ed8;
            padding: 15px;
            margin: 15px 0;
        }
        .email-button {
            background-color: #1d4ed8;
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
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-content">
            <div class="email-header">
                <h1>Account On Hold</h1>
            </div>

            <h2>Hello {{ $user->name }},</h2>

            <p>Your account has been temporarily placed on hold.</p>

            @if($reason)
            <div class="hold-box">
                <strong>Reason:</strong> {{ $reason }}
            </div>
            @endif

            <p><strong>Current Status:</strong> {{ $user::STATUSES[$user->status] }}</p>
            <p><strong>Previous Status:</strong> {{ $user::STATUSES[$previousStatus] }}</p>

            <p>To restore your account access, please complete the required verification steps.</p>

            <a href="{{ route('account.verify') }}" class="email-button">Verify My Account</a>

            <p>If you need assistance, please contact our support team.</p>

            <div class="email-footer">
                <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        // Same tracking code as in warning.blade.php
        if (window.location.href.indexOf('?track') === -1) {
            var img = new Image();
            img.src = '{{ route('email.track', ['type' => 'open', 'user' => $user->id]) }}';
        }

        document.addEventListener('DOMContentLoaded', function() {
            var links = document.querySelectorAll('a');
            links.forEach(function(link) {
                link.addEventListener('click', function(e) {
                    var trackUrl = '{{ route('email.track', ['type' => 'click', 'user' => $user->id]) }}' +
                                  '&url=' + encodeURIComponent(this.href);
                    new Image().src = trackUrl;
                });
            });
        });
    </script>
</body>
</html>
