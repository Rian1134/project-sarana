<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ToiletSiswa extends Model
{
    use HasFactory;

    protected $table = 'toilet_siswas';

    protected $fillable = [
        'baik',
        'rusak',
        'sarana_id',
    ];

    public function sarana()
    {
        return $this->belongsTo(Sarana::class);
    }
}
