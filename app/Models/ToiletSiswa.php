<?php

namespace App\Models;

use App\Traits\LogsSaranaActivity;
use App\Traits\RecordsSaranaSnapshot;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ToiletSiswa extends Model
{
    use HasFactory, LogsSaranaActivity ,RecordsSaranaSnapshot;

    protected $table = 'toilet_siswas';

    protected $fillable = [
        'baik',
        'rusak',
        'profile_sekolah_id',
    ];

    public function profileSekolah()
    {
        return $this->belongsTo(ProfileSekolah::class);
    }
}
