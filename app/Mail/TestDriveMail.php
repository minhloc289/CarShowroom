<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TestDriveMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data; // Biến để chứa dữ liệu từ controller

    /**
     * Create a new message instance.
     */
    public function __construct($data)
    {
        $this->data = $data; // Gán dữ liệu được truyền từ controller vào biến $data
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Test Drive Registration Confirmation', // Tiêu đề email
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.testDriveMail', // Đường dẫn view của email
            with: ['data' => $this->data] // Truyền dữ liệu vào view
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return []; // Nếu không có file đính kèm, giữ nguyên
    }
}
