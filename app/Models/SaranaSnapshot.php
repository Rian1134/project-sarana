<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaranaSnapshot extends Model
{
    protected $fillable = [
        'profile_sekolah_id', 'snapshotable_type', 'snapshotable_id', 'data', 'recorded_at',
    ];

    protected $casts = [
        'data'        => 'array',
        'recorded_at' => 'datetime',
    ];

    public function snapshotable()
    {
        return $this->morphTo();
    }

    public function profileSekolah()
    {
        return $this->belongsTo(ProfileSekolah::class);
    }
}
