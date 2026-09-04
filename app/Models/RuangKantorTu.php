<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RuangKantorTu extends Model
{
    use HasFactory;

    protected $table = 'ruang_kantor_tus';

    protected $fillable = [
        'ada/tidak_ada',
        'kodisi',
        'profile_sekolah_id',
    ];

    public function profileSekoh()
    {
        return $this->belongsTo(ProfileSekolah::class);
    }
}
