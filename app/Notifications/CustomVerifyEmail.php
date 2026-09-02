<?php

namespace App\Notifications;

use App\Mail\VerifyEmailMail;
use Illuminate\Auth\Notifications\VerifyEmail as VerifyEmailBase;

/**
 * Notifikasi verifikasi email kustom.
 *
 * Meng-extend notifikasi bawaan Laravel (VerifyEmailBase) supaya tetap
 * dapat pembuatan URL verifikasi yang sudah ditandatangani (signed URL)
 * dan expired-nya otomatis mengikuti config('auth.verification.expire'),
 * tapi meng-override toMail() supaya isinya pakai template kustom
 * (resources/views/emails/verify-email.blade.php) alih-alih tampilan
 * MailMessage bawaan Laravel yang polos.
 *
 * Cara pakai: di App\Models\User, override method
 * sendEmailVerificationNotification() supaya memakai notifikasi ini
 * (lihat catatan di bawah / instruksi terpisah).
 */
class CustomVerifyEmail extends VerifyEmailBase
{
    public function toMail($notifiable)
    {
        $verificationUrl = $this->verificationUrl($notifiable);

        return (new VerifyEmailMail($notifiable->name, $verificationUrl))
            ->to($notifiable->email);
    }
}