<?php

namespace App\Models;

use App\Traits\LogsSaranaActivity;
use App\Traits\RecordsSaranaSnapshot;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laptop extends Model
{
    use HasFactory,LogsSaranaActivity, RecordsSaranaSnapshot;

    protected $table = 'laptops';

    protected $fillable = [
        'profile_sekolah_id',
        'baik',
        'rusak',
    ];

    public function profileSekolah()
    {
        return $this->belongsTo(ProfileSekolah::class);
    }
}
