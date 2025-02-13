<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class VerifyEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $account;

    /**
     * Create a new message instance.
     */
    public function __construct($account)
    {
        $this->account = $account;
    }

    public function build()
    {
        if (!isset($this->account->name) || !isset($this->account->email_verification_token)) {
            throw new \Exception("Invalid account data for email verification");
        }

        return $this->view('emails.verify_email')
                    ->subject('Email Verification')
                    ->with([
                        'name' => $this->account->name,
                        'verificationUrl' => route('verify.email', ['token' => $this->account->email_verification_token]),
                    ]);
    }   


    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Verify Email',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.verify_email',
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
