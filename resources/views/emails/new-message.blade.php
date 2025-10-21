<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>New Message - {{ config('app.name') }}</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: #3b82f6; color: white; padding: 20px; text-align: center; }
        .content { background: #f9fafb; padding: 30px; }
        .message-box { background: white; padding: 20px; border-radius: 8px; margin: 20px 0; }
        .button { display: inline-block; background: #3b82f6; color: white; padding: 12px 24px; text-decoration: none; border-radius: 6px; }
        .footer { text-align: center; color: #6b7280; font-size: 14px; margin-top: 30px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>{{ config('app.name') }}</h1>
            <p>You have a new message!</p>
        </div>
        
        <div class="content">
            <h2>Hi {{ $recipient->name }},</h2>
            
            <p><strong>{{ $sender->name }}</strong> sent you a message:</p>
            
            <div class="message-box">
                @if($message->isImage())
                    <p><em>📷 Sent an image</em></p>
                @elseif($message->isVideo())
                    <p><em>🎥 Sent a video</em></p>
                @elseif($message->isFile())
                    <p><em>📁 Sent a file: {{ $message->file_name }}</em></p>
                @endif
                
                @if($message->message)
                    <p>"{{ $message->message }}"</p>
                @endif
            </div>
            
            <p>
                <a href="{{ route('inbox.index', $message->conversation_id) }}" class="button">
                    View Message
                </a>
            </p>
            
            <p>Login to {{ config('app.name') }} to reply and see all your messages.</p>
        </div>
        
        <div class="footer">
            <p>This email was sent because you have an account on {{ config('app.name') }}.</p>
            <p>If you don't want to receive these emails, you can update your notification preferences in your account settings.</p>
        </div>
    </div>
</body>
</html>