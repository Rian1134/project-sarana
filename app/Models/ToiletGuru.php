<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ToiletGuru extends Model
{
    use HasFactory;

    protected $table = 'toilet_gurus';

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
