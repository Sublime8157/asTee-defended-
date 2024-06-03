<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewOrderMadeMail extends Mailable
{
    use Queueable, SerializesModels;
    public $invoiceData; 
    /**
     * Create a new message instance.
     */
    public function __construct($invoiceData)
    {
        // 
        $this->invoiceData = $invoiceData;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New order has been made ',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.newOrderMade',
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

    public function build(){
        return $this->view('mail.newOrderMade')
                    ->with(['invoiceData' => $this->invoiceData]);
    }
}
