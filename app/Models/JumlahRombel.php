<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JumlahRombel extends Model
{
    use HasFactory;

    protected $table = 'jumlah_rombels';

    protected $fillable = [
        'vii',
        'viii',
        'ix',
        'profile_sekolah_id',
    ];

    public function sarana()
    {
        return $this->belongsTo(ProfileSekolah::class);
    }
}
