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
            background-color: #6b7280;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 8px 8px 0 0;
        }
        .deleted-box {
            background-color: #f3f4f6;
            border-left: 4px solid #6b7280;
            padding: 15px;
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
            content: "🗑️";
            position: absolute;
            left: 0;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-content">
            <div class="email-header">
                <h1>Account Deletion Confirmation</h1>
            </div>

            <h2>Hello {{ $user->name }},</h2>

            <p>We're confirming that your account has been successfully deleted as requested.</p>

            @if($reason)
            <div class="deleted-box">
                <strong>Reason:</strong> {{ $reason }}
            </div>
            @endif

            <p>This action means:</p>

            <ul class="consequences">
                <li>All your personal data has been removed from our systems</li>
                <li>Any remaining coins or balances have been forfeited</li>
                <li>You can no longer access our services with this account</li>
            </ul>

            <p>If you didn't request this deletion or change your mind within the next 14 days,
            you may be able to recover your account by contacting our support team immediately.</p>

            <div class="email-footer">
                <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
                <p><a href="{{ route('contact') }}" style="color: #6b7280; text-decoration: none;">Contact Support</a></p>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        if (window.location.href.indexOf('?track') === -1) {
            var img = new Image();
            img.src = '{{ route('email.track', ['type' => 'open', 'user' => $user->id, 'status' => 'deleted']) }}';
        }
    </script>
</body>
</html>
