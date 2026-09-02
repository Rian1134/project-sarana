<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

/**
 * Email verifikasi akun — dipakai oleh App\Notifications\CustomVerifyEmail
 * (menggantikan email verifikasi bawaan Laravel yang polos, dengan versi
 * bertema sesuai branding Project-S).
 */
class VerifyEmailMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $userName,
        public string $verificationUrl,
    ) {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Verifikasi Alamat Email Anda - ' . config('app.name', 'Project-S'),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.verify-email',
            with: [
                'userName' => $this->userName,
                'verificationUrl' => $this->verificationUrl,
            ],
        );
    }
}