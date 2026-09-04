<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AirBersih extends Model
{
    use HasFactory;

    protected $table = 'air_bersihs';

    protected $fillable = [
        'profile_sekolah_id',
        'ada/tidak_ada',
        'kodisi'
    ];

    public function profileSekolah()
    {
        return $this->belongsTo(ProfileSekolah::class);
    }
}