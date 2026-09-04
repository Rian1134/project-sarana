<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RumahDinas extends Model
{
    use HasFactory;

    protected $table = 'rumah_dinas';

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
