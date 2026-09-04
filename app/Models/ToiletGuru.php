<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ToiletGuru extends Model
{
    use HasFactory;

    protected $table = 'toilet_gurus';

    protected $fillable = [
        'bagus',
        'rusak',
        'profile_sekolah_id',
    ];

    public function profileSekoh()
    {
        return $this->belongsTo(ProfileSekolah::class);
    }
}
