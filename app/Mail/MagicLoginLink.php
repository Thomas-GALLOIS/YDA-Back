<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\URL;

//pour verifier si le mail est bien arrive sur le compte mailtrap voici les infos du compte
//moenah@hotmail.com mdp : Mo&181504

class MagicLoginLink extends Mailable
{
    use Queueable, SerializesModels;

    public $plaintextToken;
    public $expiresAt;
    public $user_email;

    public function __construct($plaintextToken, $expiresAt, $user_email)
    {
        $this->plaintextToken = $plaintextToken;
        $this->expiresAt = $expiresAt;
        $this->user_email = $user_email;
    }

    public function build()
    {
        return $this->subject(config('app.name') . ' Login Verification')
            ->markdown('emails.magic-login-link', [
                'url' => URL::temporarySignedRoute('verify-login', $this->expiresAt, [
                    'token' => $this->plaintextToken, 'user_email' => $this->user_email
                ]),
            ]);
    }
}
