<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pengajuan extends Model
{
    protected $fillable = [
        'user_id',
        'profile_sekolah_id',
        'judul',
        'pengajuan',
        'perubahan',
        'status',
        'lampiran',
    ];

    protected $casts = [
        'pengajuan' => 'array',
        'perubahan' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function profileSekolah(): BelongsTo
    {
        return $this->belongsTo(ProfileSekolah::class);
    }
}
