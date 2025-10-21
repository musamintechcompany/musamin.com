<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Message;
use App\Models\Conversation;

class NewMessageNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $message;
    public $conversation;

    public function __construct(Message $message, Conversation $conversation)
    {
        $this->message = $message;
        $this->conversation = $conversation;
    }

    public function build()
    {
        return $this->subject('New Message from ' . $this->message->sender->name)
                    ->view('emails.new-message-notification')
                    ->with([
                        'message' => $this->message,
                        'conversation' => $this->conversation
                    ]);
    }
}