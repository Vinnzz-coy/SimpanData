<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPasswordOtpMail extends Mailable
{
    use Queueable, SerializesModels;

    public $otp;
    public $userEmail;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($otp, $email = null)
    {
        $this->otp = $otp;
        $this->userEmail = $email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('🔐 Kode OTP Reset Password')
            ->view('emails.reset-password-otp')
            ->with([
                'otp' => $this->otp,
                'email' => $this->userEmail,
            ]);
    }
}
