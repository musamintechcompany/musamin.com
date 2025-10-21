<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>New Digital Order Received</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: #10b981; color: white; padding: 20px; text-align: center; }
        .content { padding: 20px; background: #f9fafb; }
        .order-item { border-bottom: 1px solid #e5e7eb; padding: 10px 0; }
        .total { font-weight: bold; font-size: 18px; }
        .footer { text-align: center; padding: 20px; color: #6b7280; }
        .success { background: #ecfdf5; border: 1px solid #10b981; padding: 15px; margin: 15px 0; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>💰 Digital Sale Completed!</h1>
        </div>
        
        <div class="content">
            @php
                $store = \App\Models\Store::find($order->order_data['store_id']);
            @endphp
            
            <p>Hello {{ $store->user->name }},</p>
            
            <p>Excellent! You've made a digital sale in your store <strong>{{ $store->name ?? 'Your Store' }}</strong>.</p>
            
            <div style="border: 1px solid #e5e7eb; padding: 15px; margin: 20px 0;">
                <h3>Order Details</h3>
                <p><strong>Order Number:</strong> {{ $order->order_number }}</p>
                <p><strong>Order Date:</strong> {{ $order->created_at->format('M d, Y h:i A') }}</p>
                <p><strong>Customer:</strong> {{ $order->user->name }}</p>
                
                <h4>Digital Products Sold:</h4>
                @foreach($order->order_data['items'] as $item)
                <div class="order-item">
                    <strong>{{ $item['product_snapshot']['name'] }}</strong><br>
                    <small>📱 Digital Product</small><br>
                    Quantity: {{ $item['quantity'] }} × ${{ number_format($item['unit_price'], 2) }} = ${{ number_format($item['total_price'], 2) }}
                </div>
                @endforeach
                
                <div style="margin-top: 15px;">
                    <p class="total">Total: ${{ number_format($order->total_amount, 2) }} ({{ number_format($order->total_coins_used) }} coins)</p>
                </div>
            </div>
            
            <div class="success">
                <h4>💰 Payment Completed!</h4>
                <p><strong>{{ number_format($order->total_coins_used) }} coins have been credited to your earned wallet immediately!</strong></p>
                <p>Since this is a digital product, the customer has instant access and payment is released right away. No waiting period required!</p>
            </div>
            
            @if($order->notes)
            <h4>📝 Customer Notes</h4>
            <p style="background: white; padding: 15px; border: 1px solid #e5e7eb;">{{ $order->notes }}</p>
            @endif
            
            <div style="margin: 30px 0; padding: 20px; background: #dbeafe; border: 1px solid #3b82f6;">
                <h4>✅ What Happened:</h4>
                <ul>
                    <li>Customer purchased and paid for your digital product</li>
                    <li>Product was automatically delivered to customer</li>
                    <li>Payment was instantly credited to your earned wallet</li>
                    <li>Order is marked as completed</li>
                </ul>
            </div>
            
            <p>You can view this sale and communicate with the customer through your affiliate dashboard.</p>
        </div>
        
        <div class="footer">
            <p>Keep creating amazing digital products!</p>
            <p>{{ config('app.name') }} Affiliate Team</p>
        </div>
    </div>
</body>
</html>