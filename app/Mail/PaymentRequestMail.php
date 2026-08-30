<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PaymentRequestMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Order $order,
        public string $paymentUrl,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: __('payment_request.subject'),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.payment-request',
        );
    }
}
