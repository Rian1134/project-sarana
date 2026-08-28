<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PagarSekolah extends Model
{
    use HasFactory;

    protected $table = 'pagar_sekolahs';

    protected $fillable = [
        'sarana_id',
        'ada/tidak_ada',
        'kodisi'
    ];

    // Relasi belongsTo
    public function sarana()
    {
        return $this->belongsTo(Sarana::class);
    }
}