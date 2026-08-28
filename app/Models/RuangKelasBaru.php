<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RuangKelasBaru extends Model
{
    use HasFactory;

    protected $table = 'ruang_kelas_barus';

    protected $fillable = [
        'jumlah',
        'sarana_id',
    ];

    public function sarana()
    {
        return $this->belongsTo(Sarana::class);
    }
}