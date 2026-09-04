<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnitKesehatanSekolah extends Model
{
    use HasFactory;

    protected $table = 'unit_kesehatan_sekolahs';

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
