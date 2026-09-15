<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JumlahGuru extends Model
{
    use HasFactory;

    protected $table = 'jumlah_gurus';

    protected $fillable = [
        'pns',
        'pppk',
        'honor',
        'i',
        'ii',
        'iii',
        'iv',
        'profile_sekolah_id',
    ];

    public function profileSekolah()
    {
        return $this->belongsTo(ProfileSekolah::class);
    }
}
