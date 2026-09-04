<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
// use App\Notifications\CustomVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable 
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, HasRoles, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function profileSekolah()
    {
        return $this->hasOne(ProfileSekolah::class);
    }

    /**
     * Override supaya email verifikasi memakai template kustom
     * (App\Notifications\CustomVerifyEmail -> App\Mail\VerifyEmailMail)
     * alih-alih email verifikasi bawaan Laravel yang polos.
     */
    // public function sendEmailVerificationNotification(): void
    // {
    //     $this->notify(new CustomVerifyEmail);
    // }
}
