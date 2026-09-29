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
use Illuminate\Http\UploadedFile;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Format;
use Intervention\Image\ImageManager;
use Spatie\Permission\Traits\HasRoles;

#[Fillable(['name', 'email', 'password', 'foto'])]
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

    /**
     * URL foto profil. Jika user belum punya foto, pakai avatar inisial nama.
     * Pemakaian di view: $user->foto_url
     */
    public function getFotoUrlAttribute(): string
    {
        if ($this->foto) {
            return asset('storage/'.$this->foto);
        }

        return 'https://ui-avatars.com/api/?background=random&name='.urlencode($this->name);
    }

    /**
     * Ubah foto ke WebP 400x400, simpan ke storage/app/public/profile-photos,
     * lalu kembalikan path-nya untuk disimpan di kolom users.foto.
     */
    public static function prosesFoto(UploadedFile $file): string
    {
        $image = ImageManager::usingDriver(Driver::class)
            ->decodePath($file->getRealPath())
            ->cover(400, 400)
            ->encodeUsingFormat(Format::WEBP, quality: 80);

        $path = 'profile-photos/'.Str::uuid().'.webp';

        Storage::disk('public')->put($path, (string) $image);

        return $path;
    }

    /**
     * Hapus file foto dari storage (aman dipanggil dengan null).
     */
    public static function hapusFileFoto(?string $path): void
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }

    public function profileSekolah()
    {
        return $this->hasOne(ProfileSekolah::class);
    }

    public function pengajuan()
    {
        return $this->hasOne(Pengajuan::class);
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