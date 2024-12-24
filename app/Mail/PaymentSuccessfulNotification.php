<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PaymentSuccessfulNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $order_id;
    public $receipt_id;
    public $start_date;
    public $end_date;
    public $total_cost;

    /**
     * Create a new message instance.
     *
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->name = $data['name'];
        $this->order_id = $data['order_id'];
        $this->receipt_id = $data['receipt_id'];
        $this->start_date = $data['start_date'];
        $this->end_date = $data['end_date'];
        $this->total_cost = $data['total_cost'];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Xác nhận Thanh Toán Gia Hạn Thành Công')
                    ->view('emails.payment.successful');
    }
}
