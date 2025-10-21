<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Digital Order Confirmation</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: #10b981; color: white; padding: 20px; text-align: center; }
        .content { padding: 20px; background: #f9fafb; }
        .order-item { border-bottom: 1px solid #e5e7eb; padding: 15px 0; }
        .download-section { background: #ecfdf5; border: 1px solid #10b981; padding: 15px; margin: 10px 0; border-radius: 8px; }
        .download-btn { display: inline-block; background: #10b981; color: white; padding: 12px 24px; text-decoration: none; border-radius: 6px; margin: 5px 0; }
        .total { font-weight: bold; font-size: 18px; }
        .footer { text-align: center; padding: 20px; color: #6b7280; }
        .important { background: #fef3c7; border-left: 4px solid #f59e0b; padding: 15px; margin: 15px 0; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🎉 Your Digital Products Are Ready!</h1>
        </div>
        
        <div class="content">
            <p>Dear {{ $orders[0]->user->name }},</p>
            
            <p>Great news! Your digital order has been processed and your products are ready for download.</p>
            
            @foreach($orders as $order)
            @php
                $store = \App\Models\Store::find($order->order_data['store_id']);
            @endphp
            <div style="margin-bottom: 30px; border: 1px solid #e5e7eb; padding: 15px;">
                <h3>Order #{{ $order->order_number }}</h3>
                <p><strong>Store:</strong> {{ $store->name ?? 'Store' }}</p>
                
                <h4>Your Digital Products:</h4>
                @foreach($order->order_data['items'] as $item)
                <div class="order-item">
                    <strong>{{ $item['product_snapshot']['name'] }}</strong><br>
                    <small>Digital Product</small><br>
                    Quantity: {{ $item['quantity'] }} × ${{ number_format($item['unit_price'], 2) }} = ${{ number_format($item['total_price'], 2) }}
                    
                    <div class="download-section">
                        <h4>📥 Download Your Product</h4>
                        <p>Click the button below to download your digital product:</p>
                        <a href="{{ route('orders.download', ['order' => $order->id, 'product' => $item['product_id']]) }}" class="download-btn">
                            Download Now
                        </a>
                        <p><small>Download link is valid for 30 days from purchase date.</small></p>
                    </div>
                </div>
                @endforeach
                
                <div style="margin-top: 15px;">
                    <p class="total">Total: ${{ number_format($order->total_amount, 2) }} ({{ number_format($order->total_coins_used) }} coins)</p>
                </div>
            </div>
            @endforeach
            
            <div class="important">
                <h4>📋 Important Information:</h4>
                <ul>
                    <li>Your digital products are available for immediate download</li>
                    <li>Download links are valid for 30 days</li>
                    <li>You can also access your downloads from your account dashboard</li>
                    <li>Keep your downloaded files safe - we recommend backing them up</li>
                </ul>
            </div>
            
            <p>You can access all your digital purchases anytime from your <a href="{{ route('orders.index') }}">Orders Dashboard</a>.</p>
            
            <p>If you have any questions about your digital products, please contact the store owner through our messaging system.</p>
        </div>
        
        <div class="footer">
            <p>Thank you for your digital purchase!</p>
            <p>{{ config('app.name') }}</p>
        </div>
    </div>
</body>
</html>