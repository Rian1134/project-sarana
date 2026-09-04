<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PeriodeLaporan;
use App\Models\RehabilitasiRuangKelas;
use App\Models\RuangKelasBaru;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Mengatur periode (tahun_awal - tahun_akhir) untuk kategori RKB dan
 * Rehabilitasi Ruang Kelas. HANYA untuk admin — route ini wajib dipasangi
 * middleware role admin (lihat catatan di routes/web.php).
 *
 * Saat periode salah satu kategori diubah, kolom 'jumlah' SEMUA sekolah
 * untuk kategori itu otomatis direset ke 0 — karena angka lama sudah
 * tidak relevan lagi dengan periode pelaporan yang baru.
 */
class PeriodeLaporanController extends Controller
{
    public function edit()
    {
        $rkb = PeriodeLaporan::forKategori('rkb');
        $rehabilitasi = PeriodeLaporan::forKategori('rehabilitasi');

        return view('admin.periode.edit', compact('rkb', 'rehabilitasi'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'rkb_tahun_awal' => 'required|integer|min:2000|max:2100',
            'rkb_tahun_akhir' => 'required|integer|min:2000|max:2100|gte:rkb_tahun_awal',
            'rehabilitasi_tahun_awal' => 'required|integer|min:2000|max:2100',
            'rehabilitasi_tahun_akhir' => 'required|integer|min:2000|max:2100|gte:rehabilitasi_tahun_awal',
        ]);

        try {
            $direset = [];

            DB::transaction(function () use ($request, &$direset) {
                // ===== RKB =====
                $rkb = PeriodeLaporan::forKategori('rkb');
                $rkbBerubah = (int) $rkb->tahun_awal !== (int) $request->rkb_tahun_awal
                    || (int) $rkb->tahun_akhir !== (int) $request->rkb_tahun_akhir;

                if ($rkbBerubah) {
                    $rkb->update([
                        'tahun_awal' => $request->rkb_tahun_awal,
                        'tahun_akhir' => $request->rkb_tahun_akhir,
                    ]);
                    // Periode baru -> jumlah lama tidak relevan lagi, reset ke 0
                    RuangKelasBaru::query()->update(['jumlah' => 0]);
                    $direset[] = 'RKB';
                }

                // ===== Rehabilitasi =====
                $rehab = PeriodeLaporan::forKategori('rehabilitasi');
                $rehabBerubah = (int) $rehab->tahun_awal !== (int) $request->rehabilitasi_tahun_awal
                    || (int) $rehab->tahun_akhir !== (int) $request->rehabilitasi_tahun_akhir;

                if ($rehabBerubah) {
                    $rehab->update([
                        'tahun_awal' => $request->rehabilitasi_tahun_awal,
                        'tahun_akhir' => $request->rehabilitasi_tahun_akhir,
                    ]);
                    RehabilitasiRuangKelas::query()->update(['jumlah' => 0]);
                    $direset[] = 'Rehabilitasi Ruang Kelas';
                }
            });

            $pesan = empty($direset)
                ? 'Tidak ada perubahan periode.'
                : 'Periode '.implode(' & ', $direset).' berhasil diperbarui. '
                    .'Jumlah data '.implode(' & ', $direset).' di SEMUA sekolah sudah direset ke 0.';

            return redirect()->route('sarana.index')->with('success', $pesan);
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal memperbarui periode: '.$e->getMessage());
        }
    }
}
