<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;

class profileMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */

    public function __construct(private User $user){}

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Email verification',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $id = $this->user->id;
        $name = $this->user->name;
        $email = $this->user->email;
        $date = $this->user->created_at;

        $link = url('') . '/verify-email/' . base64_encode($id . '/' .$date);

        return new Content(
            view: 'emails.confirm-email',
            with: compact('name', 'email', 'link')
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
