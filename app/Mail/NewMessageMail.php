<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Message;
use App\Models\User;

class NewMessageMail extends Mailable
{
    use Queueable, SerializesModels;

    public $message;
    public $sender;
    public $recipient;

    public function __construct(Message $message, User $sender, User $recipient)
    {
        $this->message = $message;
        $this->sender = $sender;
        $this->recipient = $recipient;
    }

    public function build()
    {
        return $this->subject('New message from ' . $this->sender->name . ' - ' . config('app.name'))
                    ->view('emails.new-message')
                    ->with([
                        'message' => $this->message,
                        'sender' => $this->sender,
                        'recipient' => $this->recipient,
                    ]);
    }
}