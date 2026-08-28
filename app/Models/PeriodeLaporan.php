<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Pengaturan periode (tahun_awal - tahun_akhir) untuk kategori RKB &
 * Rehabilitasi Ruang Kelas. Nilainya GLOBAL, berlaku untuk semua sekolah
 * sekaligus — bukan disimpan per-sekolah.
 *
 * Cuma admin yang boleh mengubah nilai ini (lihat PeriodeLaporanController).
 * Mengubah periode otomatis mereset kolom 'jumlah' semua data RKB/Rehab
 * ke 0, karena angka lama sudah tidak relevan dengan periode yang baru.
 */
class PeriodeLaporan extends Model
{
    use HasFactory;

    protected $fillable = [
        'kategori',
        'tahun_awal',
        'tahun_akhir',
    ];

    /**
     * Ambil (atau buat kalau belum ada) periode untuk satu kategori.
     * $kategori: 'rkb' atau 'rehabilitasi'
     */
    public static function forKategori(string $kategori): self
    {
        return static::firstOrCreate(
            ['kategori' => $kategori],
            ['tahun_awal' => 2020, 'tahun_akhir' => 2025]
        );
    }

    public function label(): string
    {
        return "{$this->tahun_awal} s,d {$this->tahun_akhir}";
    }
}
