<?php

namespace App\Models;

use App\Traits\LogsSaranaActivity;
use App\Traits\RecordsSaranaSnapshot;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PagarSekolah extends Model
{
    use HasFactory, LogsSaranaActivity, RecordsSaranaSnapshot;

    protected $table = 'pagar_sekolahs';

    protected $fillable = [
        'profile_sekolah_id',
        'ada/tidak_ada',
        'kodisi'
    ];

    // Relasi belongsTo
    public function profileSekoh()
    {
        return $this->belongsTo(ProfileSekolah::class);
    }
}