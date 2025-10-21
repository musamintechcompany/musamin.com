<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Order Confirmation</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: #3b82f6; color: white; padding: 20px; text-align: center; }
        .content { padding: 20px; background: #f9fafb; }
        .order-item { border-bottom: 1px solid #e5e7eb; padding: 10px 0; }
        .total { font-weight: bold; font-size: 18px; }
        .footer { text-align: center; padding: 20px; color: #6b7280; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Order Confirmation</h1>
        </div>
        
        <div class="content">
            <p>Dear {{ $orders[0]->user->name }},</p>
            
            <p>Thank you for your order! We've received your payment and your order is being processed.</p>
            
            @foreach($orders as $order)
            @php
                $store = \App\Models\Store::find($order->order_data['store_id']);
                $deliveryInfo = $order->order_data['delivery_snapshot'] ?? [];
            @endphp
            <div style="margin-bottom: 30px; border: 1px solid #e5e7eb; padding: 15px;">
                <h3>Order #{{ $order->order_number }}</h3>
                <p><strong>Store:</strong> {{ $store->name ?? 'Store' }}</p>
                
                <h4>Items Ordered:</h4>
                @foreach($order->order_data['items'] as $item)
                <div class="order-item">
                    <strong>{{ $item['product_snapshot']['name'] }}</strong><br>
                    <small>{{ ucfirst($item['product_snapshot']['type']) }} product</small><br>
                    Quantity: {{ $item['quantity'] }} × ${{ number_format($item['unit_price'], 2) }} = ${{ number_format($item['total_price'], 2) }}
                </div>
                @endforeach
                
                <div style="margin-top: 15px;">
                    <p>Subtotal: ${{ number_format($order->order_data['subtotal'], 2) }}</p>
                    <p>Shipping: ${{ number_format($order->order_data['shipping_cost'], 2) }}</p>
                    <p class="total">Total: ${{ number_format($order->total_amount, 2) }} ({{ number_format($order->total_coins_used) }} coins)</p>
                </div>
                
                @if(!empty($deliveryInfo['address']))
                <h4>Delivery Address:</h4>
                <p>
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
                </p>
                @endif
            </div>
            @endforeach
            
            <p>You will receive updates as your orders are processed and shipped. You can track your orders in your account dashboard.</p>
            
            <p>If you have any questions, please contact the respective store owners through our messaging system.</p>
        </div>
        
        <div class="footer">
            <p>Thank you for shopping with us!</p>
            <p>{{ config('app.name') }}</p>
        </div>
    </div>
</body>
</html>