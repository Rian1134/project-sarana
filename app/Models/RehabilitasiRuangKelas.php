<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RehabilitasiRuangKelas extends Model
{
    use HasFactory;

    protected $table = 'rehabilitasi_ruang_kelas';

    protected $fillable = [
        'jumlah',
        'profile_sekolah_id',
    ];

    public function profileSekoh()
    {
        return $this->belongsTo(ProfileSekolah::class);
    }
}