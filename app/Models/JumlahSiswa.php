<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JumlahSiswa extends Model
{
    use HasFactory;

    protected $table = 'jumlah_siswas';

    protected $fillable = [
        'vii',
        'viii',
        'ix',
        'profile_sekolah_id',
    ];

    public function profileSekoh()
    {
        return $this->belongsTo(ProfileSekolah::class);
    }
}
