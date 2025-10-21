<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>New Order Received</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: #10b981; color: white; padding: 20px; text-align: center; }
        .content { padding: 20px; background: #f9fafb; }
        .order-item { border-bottom: 1px solid #e5e7eb; padding: 10px 0; }
        .total { font-weight: bold; font-size: 18px; }
        .footer { text-align: center; padding: 20px; color: #6b7280; }
        .alert { background: #fef3c7; border: 1px solid #f59e0b; padding: 15px; margin: 15px 0; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🎉 New Order Received!</h1>
        </div>
        
        <div class="content">
            @php
                $store = \App\Models\Store::find($order->order_data['store_id']);
                $deliveryInfo = $order->order_data['delivery_snapshot'] ?? [];
            @endphp
            
            <p>Hello {{ $store->user->name }},</p>
            
            <p>Great news! You have received a new order in your store <strong>{{ $store->name ?? 'Your Store' }}</strong>.</p>
            
            <div style="border: 1px solid #e5e7eb; padding: 15px; margin: 20px 0;">
                <h3>Order Details</h3>
                <p><strong>Order Number:</strong> {{ $order->order_number }}</p>
                <p><strong>Order Date:</strong> {{ $order->created_at->format('M d, Y h:i A') }}</p>
                <p><strong>Customer:</strong> {{ $order->user->name }}</p>
                <p><strong>Customer Email:</strong> {{ $deliveryInfo['email'] ?? $order->user->email }}</p>
                
                <h4>Items Ordered:</h4>
                @foreach($order->order_data['items'] as $item)
                <div class="order-item">
                    <strong>{{ $item['product_snapshot']['name'] }}</strong><br>
                    <small>{{ $item['product_snapshot']['type'] }} product</small><br>
                    Quantity: {{ $item['quantity'] }} × ${{ number_format($item['unit_price'], 2) }} = ${{ number_format($item['total_price'], 2) }}
                </div>
                @endforeach
                
                <div style="margin-top: 15px;">
                    <p>Subtotal: ${{ number_format($order->order_data['subtotal'], 2) }}</p>
                    <p>Shipping: ${{ number_format($order->order_data['shipping_cost'], 2) }}</p>
                    <p class="total">Total: ${{ number_format($order->total_amount, 2) }} ({{ number_format($order->total_coins_used) }} coins)</p>
                </div>
            </div>
            
            <div class="alert">
                <h4>💰 Payment Status</h4>
                <p>The customer has paid {{ number_format($order->total_coins_used) }} coins. This amount is currently in your <strong>pending balance</strong> and will be released to your available balance once the customer confirms receipt of the order.</p>
            </div>
            
            @if(!empty($deliveryInfo['address']))
            <h4>📦 Shipping Information</h4>
            <p><strong>Delivery Address:</strong></p>
            <div style="background: white; padding: 15px; border: 1px solid #e5e7eb;">
                {{ $deliveryInfo['name'] }}<br>
                @if($deliveryInfo['phone'])
                    Phone: {{ $deliveryInfo['phone'] }}<br>
                @endif
                {{ $deliveryInfo['address'] }}<br>
                {{ $deliveryInfo['city'] }}, {{ $deliveryInfo['state'] }}<br>
                {{ $deliveryInfo['country'] }}
                @if($deliveryInfo['postal_code'])
                    {{ $deliveryInfo['postal_code'] }}
                @endif
            </div>
            @endif
            
            @if($order->notes)
            <h4>📝 Customer Notes</h4>
            <p style="background: white; padding: 15px; border: 1px solid #e5e7eb;">{{ $order->notes }}</p>
            @endif
            
            <div style="margin: 30px 0; padding: 20px; background: #dbeafe; border: 1px solid #3b82f6;">
                <h4>Next Steps:</h4>
                <ol>
                    <li>Log into your affiliate dashboard to view full order details</li>
                    <li>Prepare the items for shipping</li>
                    <li>Update the order status as you process it</li>
                    <li>The customer will confirm receipt, and payment will be released</li>
                </ol>
            </div>
            
            <p>You can manage this order and communicate with the customer through your affiliate dashboard.</p>
        </div>
        
        <div class="footer">
            <p>Happy selling!</p>
            <p>{{ config('app.name') }} Affiliate Team</p>
        </div>
    </div>
</body>
</html>