<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KondisiGuru extends Model
{
    use HasFactory;

    protected $table = 'kondisi_gurus';

    protected $fillable = [
        'pns',
        'pppk',
        'pppk_paruh_waktu',
        'honor',
        'i',
        'ii',
        'iii',
        'iv',
        'profile_sekolah_id',
    ];

    public function profileSekolah()
    {
        return $this->belongsTo(ProfileSekolah::class);
    }
}
