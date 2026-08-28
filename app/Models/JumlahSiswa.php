<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JumlahSiswa extends Model
{
    use HasFactory;

    protected $table = 'jumlah_siswas';

    protected $fillable = [
        'vii',
        'viii',
        'ix',
        'sarana_id',
    ];

    public function sarana()
    {
        return $this->belongsTo(Sarana::class);
    }
}
