<?php

namespace App\Models;

use App\Traits\LogsSaranaActivity;
use App\Traits\RecordsSaranaSnapshot;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Komputer extends Model
{
    use HasFactory, LogsSaranaActivity, RecordsSaranaSnapshot;

    protected $table = 'komputers';

    protected $fillable = [
        'profile_sekolah_id',
        'baik',
        'rusak'
    ];

    public function profileSekoh()
    {
        return $this->belongsTo(ProfileSekolah::class);
    }
}