<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PasswordMail extends Mailable
{
 
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */

    public function __construct(private string $email, private string $token){}

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Changing password',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $hash = base64_encode($this->email . '/' . $this->token);
        $link = url('') . '/forgot-password/' . $hash;

        return new Content(
            view: 'emails.change-password',
            with: compact('link')
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