<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RehabilitasiRuangKelas extends Model
{
    use HasFactory;

    protected $table = 'rehabilitasi_ruang_kelas';

    protected $fillable = [
        'jumlah',
        'sarana_id',
    ];

    public function sarana()
    {
        return $this->belongsTo(Sarana::class);
    }
}