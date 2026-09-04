<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfileSekolah extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_sekolah',
        'NPSN',
        'alamat_sekolah',
        'nama_kepala_sekolah',
        'NIP',
        'status_sekolah',
        'akreditasi',
        'nomor_hp',
        'user_id',
    ];

    public function pagarSekolah()
    {
        return $this->hasOne(PagarSekolah::class);
    }

    public function airBersih()
    {
        return $this->hasOne(AirBersih::class);
    }

    public function kursiSiswa()
    {
        return $this->hasOne(KursiSiswa::class);
    }

    public function mejaSiswa()
    {
        return $this->hasOne(MejaSiswa::class);
    }

    public function kursiGuru()
    {
        return $this->hasOne(KursiGuru::class);
    }

    public function mejaGuru()
    {
        return $this->hasOne(MejaGuru::class);
    }

    public function laptop()
    {
        return $this->hasOne(Laptop::class);
    }

    public function komputer()
    {
        return $this->hasOne(Komputer::class);
    }

    public function jumlahSiswa()
    {
        return $this->hasOne(JumlahSiswa::class);
    }

    public function jumlahRombel()
    {
        return $this->hasOne(JumlahRombel::class);
    }

    public function ruangKelasBaru()
    {
        return $this->hasOne(RuangKelasBaru::class);
    }

    public function rehabilitasiRuangKelas()
    {
        return $this->hasOne(RehabilitasiRuangKelas::class);
    }

    public function ruangKelas()
    {
        return $this->hasOne(RuangKelas::class);
    }

    public function toiletSiswa()
    {
        return $this->hasOne(ToiletSiswa::class);
    }

    public function toiletGuru()
    {
        return $this->hasOne(ToiletGuru::class);
    }

    public function ruangPerpustakaan()
    {
        return $this->hasOne(RuangPerpustakaan::class);
    }

    public function ruangKepalaSekolah()
    {
        return $this->hasOne(RuangKepalaSekolah::class);
    }

    public function ruangGuru()
    {
        return $this->hasOne(RuangGuru::class);
    }

    public function ruangKantorTu()
    {
        return $this->hasOne(RuangKantorTu::class);
    }

    public function labIpa()
    {
        return $this->hasOne(LabIpa::class);
    }

    public function labKomputer()
    {
        return $this->hasOne(LabKomputer::class);
    }

    public function unitKesehatanSekolah()
    {
        return $this->hasOne(UnitKesehatanSekolah::class);
    }

    public function rumahDinas()
    {
        return $this->hasOne(RumahDinas::class);
    }

    public function rumahIbadah()
    {
        return $this->hasOne(RumahIbadah::class);
    }

    public function lapanganSekolah()
    {
        return $this->hasOne(LapanganSekolah::class);
    }

    public function chromebook()
    {
        return $this->hasOne(Chromebook::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
