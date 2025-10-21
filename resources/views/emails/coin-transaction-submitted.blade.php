<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Coin Purchase Submitted</title>
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
            background-color: #4A90E2;
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
        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #4A90E2;
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
            <h1>Coin Purchase Submitted</h1>
        </div>

        <div class="email-body">
            <p>Hello {{ $transaction->user->name ?? 'Customer' }},</p>
            <p>We've received your purchase of <strong>{{ $transaction->package_name ?? 'Coin Package' }}</strong> and it's currently under review.</p>

            <div class="transaction-details">
                <div class="detail-row">
                    <span class="detail-label">Transaction ID:</span>
                    <span>{{ $transaction->hashid ?? $transaction->id }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Package:</span>
                    <span>{{ $transaction->package_name ?? 'N/A' }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Payment Method:</span>
                    <span>{{ $transaction->payment_method ?? 'N/A' }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Amount:</span>
                    <span>${{ number_format($transaction->amount ?? 0, 2) }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Coins:</span>
                    <span>{{ number_format(($transaction->base_coins ?? 0) + ($transaction->bonus_coins ?? 0)) }}</span>
                </div>
            </div>

            <p>Our team will review your transaction and notify you once it's processed. This usually takes 1-2 business days.</p>

            <p>Thank you for your patience!</p>

            <div class="footer">
                <p>If you have any questions, please contact our support team.</p>
                <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
            </div>
        </div>
    </div>
</body>
</html>
