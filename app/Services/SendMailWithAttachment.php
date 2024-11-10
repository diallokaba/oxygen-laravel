<?php

namespace App\Services;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendMailWithAttachment extends Mailable{
    use Queueable, SerializesModels;
    private $attachment;
    private $user;
    public function __construct($user,$attachment){
        $this->attachment = $attachment;
        $this->user = $user;
    }

    public function build(){
        return $this->subject('Carte Oxygen')
            ->view('mails.carte_oxygen')
            ->attach($this->attachment)
            ->with(['user' => $this->user]);
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Carte Oxygen',
        );
    }

      /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}