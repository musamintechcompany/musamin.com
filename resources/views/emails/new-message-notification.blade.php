<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>New Message</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: #8b5cf6; color: white; padding: 20px; text-align: center; }
        .content { padding: 20px; background: #f9fafb; }
        .message-box { background: white; border: 1px solid #e5e7eb; padding: 15px; margin: 15px 0; }
        .footer { text-align: center; padding: 20px; color: #6b7280; }
        .btn { display: inline-block; background: #3b82f6; color: white; padding: 12px 24px; text-decoration: none; border-radius: 6px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>💬 New Message</h1>
        </div>
        
        <div class="content">
            <p>Hello,</p>
            
            <p>You have received a new message from <strong>{{ $message->sender->name }}</strong>.</p>
            
            @if($conversation->product)
            <p><strong>Regarding:</strong> {{ $conversation->product->name }}</p>
            @endif
            
            @if($conversation->subject)
            <p><strong>Subject:</strong> {{ $conversation->subject }}</p>
            @endif
            
            <div class="message-box">
                <h4>Message:</h4>
                <p>{{ $message->message }}</p>
                <small style="color: #6b7280;">Sent on {{ $message->created_at->format('M d, Y h:i A') }}</small>
            </div>
            
            <div style="text-align: center; margin: 30px 0;">
                <a href="{{ route('inbox.show', $conversation) }}" class="btn">Reply to Message</a>
            </div>
            
            <p>You can also reply directly through your inbox in the platform.</p>
        </div>
        
        <div class="footer">
            <p>{{ config('app.name') }}</p>
        </div>
    </div>
</body>
</html>