<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class VerificationEmail extends Mailable
{
    // we are now recieving the email that registration pass which is the user email 
    public $userEmail; 
    use Queueable, SerializesModels;
    /**
     * Create a new message instance.
     */
    public function __construct($userEmail)
    {
        $this->userEmail = $userEmail;
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

    public function build()
    {
      return $this
        ->subject('Emai Verification')
        ->markdown('emails.verification')
        ->with(['email' => $this->userEmail]);
    }
}
