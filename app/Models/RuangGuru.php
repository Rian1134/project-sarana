<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RuangGuru extends Model
{
    use HasFactory;

    protected $table = 'ruang_gurus';

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
