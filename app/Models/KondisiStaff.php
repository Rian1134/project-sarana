<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KondisiStaff extends Model
{
    protected $table = 'kondisi_staffs';

    protected $fillable = [
        'pns',
        'pppk',
        'pppk_paruh_waktu',
        'honor',
        'i',
        'ii',
        'iii',
        'iv',
        'profile_sekolah_id',
    ];

    public function profileSekolah()
    {
        return $this->belongsTo(ProfileSekolah::class);
    }
}
