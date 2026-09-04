<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chromebook extends Model
{
    use HasFactory;

    protected $table = 'chromebooks';

    protected $fillable = [
        'profile_sekolah_id',
        'bagus',
        'rusak'
    ];

    public function profileSekolah()
    {
        return $this->belongsTo(ProfileSekolah::class);
    }
}