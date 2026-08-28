<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RuangKelas extends Model
{
    use HasFactory;

    protected $table = 'ruang_kelas';

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
