<?php

namespace App\Models;

use App\Traits\LogsSaranaActivity;
use App\Traits\RecordsSaranaSnapshot;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RehabilitasiRuangKelas extends Model
{
    use HasFactory, LogsSaranaActivity, RecordsSaranaSnapshot;

    protected $table = 'rehabilitasi_ruang_kelas';

    protected $fillable = [
        'jumlah',
        'profile_sekolah_id',
    ];

    public function profileSekoh()
    {
        return $this->belongsTo(ProfileSekolah::class);
    }
}