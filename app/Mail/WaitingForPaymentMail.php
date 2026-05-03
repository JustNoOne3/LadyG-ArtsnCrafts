<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Order;

class WaitingForPaymentMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $order;
    public $paymentLink;

    /**
     * Create a new message instance.
     */
    public function __construct(Order $order, $paymentLink)
    {
        $this->order = $order;
        $this->paymentLink = $paymentLink;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Your Order: Waiting for Payment')
            ->view('emails.waiting-for-payment');
    }
}
