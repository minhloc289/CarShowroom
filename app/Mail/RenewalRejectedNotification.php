<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RenewalRejectedNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    /**
     * Create a new message instance.
     *
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Thông báo từ chối yêu cầu gia hạn')
                    ->view('emails.renewals.rejected')
                    ->with([
                        'name' => $this->data['name'],
                        'renewal_id' => $this->data['renewal_id'],
                        'rental_end_date' => $this->data['rental_end_date'],
                    ]);
    }
}
