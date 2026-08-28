<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laptop extends Model
{
    use HasFactory;

    protected $table = 'laptops';

    protected $fillable = [
        'sarana_id',
        'baik',
        'rusak'
    ];

    public function sarana()
    {
        return $this->belongsTo(Sarana::class);
    }
}