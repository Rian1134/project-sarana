<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RumahIbadah extends Model
{
    use HasFactory;

    protected $table = 'rumah_ibadahs';

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
