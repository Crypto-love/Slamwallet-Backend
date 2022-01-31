<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailVerification extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($email_code, $email)
    {
        $this->email_code = $email_code;
        $this->email      = $email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $email_code = "https://wallet.slamcoin.io/signup/email-verification/".bin2hex(openssl_random_pseudo_bytes(4))."?swuev=".$this->email_code."&ueecp=".$this->email;
        return $this->subject('Email Verification')->view('emails.emailVerification')->with('token', $email_code);
    }
}
