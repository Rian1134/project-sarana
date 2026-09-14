<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pengajuan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'profile_sekolah_id',
        'pengajuan',
        'perubahan',
        'status',
    ];

    protected $casts = [
        'perubahan' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function profileSekolah()
    {
        return $this->belongsTo(ProfileSekolah::class);
    }
}