<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Coin Purchase Declined</title>
    <style>
        /* Base Styles */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f9f9f9;
        }
        .email-container {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .email-header {
            background-color: #e53935;
            color: white;
            padding: 20px;
            text-align: center;
        }
        .email-body {
            padding: 25px;
        }
        .transaction-details {
            background-color: #f5f5f5;
            border-radius: 6px;
            padding: 15px;
            margin: 20px 0;
        }
        .detail-row {
            display: flex;
            margin-bottom: 8px;
        }
        .detail-label {
            font-weight: bold;
            min-width: 120px;
        }
        .decline-reason {
            background-color: #ffebee;
            border-left: 4px solid #e53935;
            padding: 15px;
            margin: 20px 0;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #e53935;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            margin-top: 15px;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <h1>Coin Purchase Declined</h1>
        </div>

        <div class="email-body">
            <p>Hello {{ $transaction->user->name }},</p>
            <p>We regret to inform you that your purchase of <strong>{{ $transaction->package_name }}</strong> could not be processed.</p>

            <div class="decline-reason">
                <p><strong>Reason:</strong> {{ $transaction->decline_reason }}</p>
                @if($transaction->staff_comments)
                <p><strong>Comments:</strong> {{ $transaction->staff_comments }}</p>
                @endif
            </div>

            <div class="transaction-details">
                <div class="detail-row">
                    <span class="detail-label">Transaction ID:</span>
                    <span>{{ $transaction->hashid }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Package:</span>
                    <span>{{ $transaction->package_name }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Payment Method:</span>
                    <span>{{ $transaction->payment_method }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Amount:</span>
                    <span>${{ number_format($transaction->amount, 2) }}</span>
                </div>
            </div>

            <p>If you believe this was a mistake or would like to try again, please contact our support team.</p>

            <a href="{{ url('/contact') }}" class="button">Contact Support</a>

            <div class="footer">
                <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
            </div>
        </div>
    </div>
</body>
</html>
