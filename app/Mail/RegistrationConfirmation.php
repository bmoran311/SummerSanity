<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Bus\Queueable;

class RegistrationConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $email;
    public $signed_url;

    public function __construct($email, $signed_url)
    {
        $this->email = $email;
        $this->signed_url = $signed_url;
    }

    public function build()
    {
        return $this->subject("Summer Sanity - Just One Quick Step!")
                    ->view('emails.registration_confirmation')
                    ->with([
                        'email' => $this->email,
                        'signedUrl' => $this->signed_url,
                    ]);
    }
}