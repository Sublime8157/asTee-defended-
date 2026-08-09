<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\URL;

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
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        return [];
    }

    public function build()
    {
        return $this
            ->subject('Verify your email address')
            ->markdown('emails.verification')
            ->with([
                'email' => $this->userEmail,
                // Signed and expiring. The route previously took the address straight
                // from the URL with no signature, so anyone could verify any account
                // by typing the email into the address bar.
                'verifyUrl' => URL::temporarySignedRoute(
                    'verified',
                    now()->addHours(48),
                    ['email' => $this->userEmail]
                ),
            ]);
    }
}
