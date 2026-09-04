<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RuangKelasBaru extends Model
{
    use HasFactory;

    protected $table = 'ruang_kelas_barus';

    protected $fillable = [
        'jumlah',
        'profile_sekolah_id',
    ];

    public function profileSekoh()
    {
        return $this->belongsTo(ProfileSekolah::class);
    }
}