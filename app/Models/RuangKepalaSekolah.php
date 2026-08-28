<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RuangKepalaSekolah extends Model
{
    use HasFactory;

    protected $table = 'ruang_kepala_sekolahs';

    protected $fillable = [
        'ada/tidak_ada',
        'kodisi',
        'sarana_id',
    ];

    public function sarana()
    {
        return $this->belongsTo(Sarana::class);
    }
}
