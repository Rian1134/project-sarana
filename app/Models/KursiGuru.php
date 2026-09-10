<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KursiGuru extends Model
{
    use HasFactory;

    protected $table = 'kursi_gurus';

    protected $fillable = [
        'profile_sekolah_id',
        'baik',
        'rusak'
    ];

    public function profileSekolah()
    {
        return $this->belongsTo(ProfileSekolah::class);
    }
}