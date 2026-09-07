<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KursiSiswa extends Model
{
    use HasFactory;

    protected $table = 'kursi_siswas';

    protected $fillable = [
        'profile_sekolah_id',
        'baik',
        'rusak'
    ];

    public function profileSekoh()
    {
        return $this->belongsTo(ProfileSekolah::class);
    }
}