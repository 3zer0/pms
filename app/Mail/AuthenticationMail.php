<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;

class AuthenticationMail extends Mailable
{
    use Queueable, SerializesModels;

    private $name;
    private $otpCode;

    public function __construct(string $name, int $otpCode)
    {
        $this->name    = $name;
        $this->otpCode = $otpCode;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('no-reply@dole.gov.ph', 'MIS - Login Authentication'),
            subject: 'One-Time Passcode',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.authenticate',
            with: [
                'name'    => $this->name,
                'otpCode' => $this->otpCode
            ]
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
