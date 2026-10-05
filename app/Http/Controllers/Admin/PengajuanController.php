<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\User\RencanaPembangunanController;
use App\Models\Pengajuan;

class PengajuanController extends Controller
{
    /**
     * Gabungan SEMUA kategori dari kedua modul user (Koreksi Data +
     * Rencana Pembangunan). HARUS SAMA PERSIS dengan gabungan
     * User\PengajuanController::kategoriList() dan
     * User\RencanaPembangunanController::kategoriList() — kalau salah satu
     * berubah (kategori baru/dihapus/tipe berubah), method ini WAJIB
     * disesuaikan juga, atau pemisahan Laporan Kerusakan / Rencana Pembangunan bisa salah.
     */
    public static function kategoriList(): array
    {
        return [
            // ---- dari User\PengajuanController (Koreksi Data) ----
            'ruang_kelas' => ['label' => 'Ruang Kelas', 'table' => 'ruang_kelas', 'tipe' => 'baik_rusak'],
            'toilet_siswa' => ['label' => 'Toilet Siswa', 'table' => 'toilet_siswas', 'tipe' => 'baik_rusak'],
            'toilet_guru' => ['label' => 'Toilet Guru', 'table' => 'toilet_gurus', 'tipe' => 'baik_rusak'],

            'ruang_guru_kondisi' => ['label' => 'Ruang Guru — Update Kondisi', 'table' => 'ruang_gurus', 'tipe' => 'update_kondisi'],
            'ruang_kepala_sekolah_kondisi' => ['label' => 'Ruang Kepala Sekolah — Update Kondisi', 'table' => 'ruang_kepala_sekolahs', 'tipe' => 'update_kondisi'],
            'ruang_kantor_tu_kondisi' => ['label' => 'Ruang Kantor TU — Update Kondisi', 'table' => 'ruang_kantor_tus', 'tipe' => 'update_kondisi'],
            'ruang_perpustakaan_kondisi' => ['label' => 'Ruang Perpustakaan — Update Kondisi', 'table' => 'ruang_perpustakaans', 'tipe' => 'update_kondisi'],
            'lab_ipa_kondisi' => ['label' => 'Laboratorium IPA — Update Kondisi', 'table' => 'lab_ipas', 'tipe' => 'update_kondisi'],
            'lab_komputer_kondisi' => ['label' => 'Laboratorium Komputer — Update Kondisi', 'table' => 'lab_komputers', 'tipe' => 'update_kondisi'],
            'unit_kesehatan_sekolah_kondisi' => ['label' => 'Unit Kesehatan Sekolah (UKS) — Update Kondisi', 'table' => 'unit_kesehatan_sekolahs', 'tipe' => 'update_kondisi'],
            'lapangan_sekolah_kondisi' => ['label' => 'Lapangan Sekolah — Update Kondisi', 'table' => 'lapangan_sekolahs', 'tipe' => 'update_kondisi'],
            'pagar_sekolah_kondisi' => ['label' => 'Pagar Sekolah — Update Kondisi', 'table' => 'pagar_sekolahs', 'tipe' => 'update_kondisi'],
            'air_bersih_kondisi' => ['label' => 'Air Bersih — Update Kondisi', 'table' => 'air_bersihs', 'tipe' => 'update_kondisi'],
            'rumah_dinas_kondisi' => ['label' => 'Rumah Dinas — Update Kondisi', 'table' => 'rumah_dinas', 'tipe' => 'update_kondisi'],
            'rumah_ibadah_kondisi' => ['label' => 'Rumah Ibadah — Update Kondisi', 'table' => 'rumah_ibadahs', 'tipe' => 'update_kondisi'],

            // ---- dari User\RencanaPembangunanController ----
            // Setiap kategori di bawah ini bisa diajukan sebagai "bangun" atau
            // "rehab" — dibedakan lewat field `jenis` di dalam `perubahan`.
            'ruang_kelas_baru' => ['label' => 'Ruang Kelas', 'table' => 'ruang_kelas_barus', 'tipe' => 'jumlah'],
            'ruang_guru' => ['label' => 'Ruang Guru', 'table' => 'ruang_gurus', 'tipe' => 'ada_kondisi'],
            'ruang_kepala_sekolah' => ['label' => 'Ruang Kepala Sekolah', 'table' => 'ruang_kepala_sekolahs', 'tipe' => 'ada_kondisi'],
            'ruang_kantor_tu' => ['label' => 'Ruang Kantor TU', 'table' => 'ruang_kantor_tus', 'tipe' => 'ada_kondisi'],
            'ruang_perpustakaan' => ['label' => 'Ruang Perpustakaan', 'table' => 'ruang_perpustakaans', 'tipe' => 'ada_kondisi'],
            'lab_ipa' => ['label' => 'Laboratorium IPA', 'table' => 'lab_ipas', 'tipe' => 'ada_kondisi'],
            'lab_komputer' => ['label' => 'Laboratorium Komputer', 'table' => 'lab_komputers', 'tipe' => 'ada_kondisi'],
            'unit_kesehatan_sekolah' => ['label' => 'Unit Kesehatan Sekolah (UKS)', 'table' => 'unit_kesehatan_sekolahs', 'tipe' => 'ada_kondisi'],
            'lapangan_sekolah' => ['label' => 'Lapangan Sekolah', 'table' => 'lapangan_sekolahs', 'tipe' => 'ada_kondisi'],
            'pagar_sekolah' => ['label' => 'Pagar Sekolah', 'table' => 'pagar_sekolahs', 'tipe' => 'ada_kondisi'],
            'air_bersih' => ['label' => 'Air Bersih', 'table' => 'air_bersihs', 'tipe' => 'ada_kondisi'],
            'rumah_dinas' => ['label' => 'Rumah Dinas', 'table' => 'rumah_dinas', 'tipe' => 'ada_kondisi'],
            'rumah_ibadah' => ['label' => 'Rumah Ibadah', 'table' => 'rumah_ibadahs', 'tipe' => 'ada_kondisi'],
        ];
    }

    /**
     * HARUS SAMA PERSIS (gabungan) dengan fieldsByTipe() di kedua controller user.
     *
     * - ada_kondisi: KOSONG SENGAJA — "usul bangun baru", tidak ada isian.
     * - update_kondisi: field 'kondisi' — lapor kondisi TERKINI fasilitas yang
     *   sudah ada (termasuk "Rusak").
     */
    public static function fieldsByTipe(): array
    {
        return [
            'baik_rusak' => [
                ['name' => 'baik', 'label' => 'Kondisi Baik', 'type' => 'number'],
                ['name' => 'rusak', 'label' => 'Kondisi Rusak', 'type' => 'number'],
            ],
            'jumlah' => [
                ['name' => 'jumlah', 'label' => 'Jumlah', 'type' => 'number'],
            ],
            'ada_kondisi' => [],
            'update_kondisi' => [
                ['name' => 'kondisi', 'label' => 'Kondisi Saat Ini', 'type' => 'select', 'options' => ['baik' => 'Baik', 'rusak' => 'Rusak', 'nihil' => 'Nihil']],
            ],
        ];
    }

    /**
     * Label yang enak dibaca untuk sebuah key field JSON `perubahan`, dicari lewat
     * tipe kategori yang bersangkutan. Dipakai di view index & show.
     */
    public static function fieldLabel(string $kategori, string $field): string
    {
        $tipe = self::kategoriList()[$kategori]['tipe'] ?? null;
        $fields = self::fieldsByTipe()[$tipe] ?? [];

        foreach ($fields as $def) {
            if ($def['name'] === $field) {
                return $def['label'];
            }
        }

        return ucwords(str_replace(['/', '_'], [' / ', ' '], $field));
    }

    /**
     * Label kategori untuk ditampilkan di index/show.
     */
    public static function categoryLabel(string $kategori): string
    {
        return self::kategoriList()[$kategori]['label'] ?? $kategori;
    }

    /**
     * $fieldsKategori = $pengajuan->perubahan[$kunci] (array satu kategori).
     * Jenis pengajuan: 'bangun' (default, termasuk data lama) atau 'rehab'.
     */
    public static function isJenisRehab(array $fieldsKategori): bool
    {
        return ($fieldsKategori['jenis'] ?? 'bangun') === 'rehab';
    }

    public static function labelJenis(array $fieldsKategori): string
    {
        return self::isJenisRehab($fieldsKategori) ? 'Rehabilitasi' : 'Bangun Baru';
    }

    /**
     * 'jenis' & 'selesai' adalah penanda internal, bukan isian form —
     * jangan ditampilkan sebagai field biasa di index/show.
     */
    public static function isFieldTampil(string $field): bool
    {
        return ! in_array($field, ['jenis', 'selesai'], true);
    }

    /**
     * Field tambahan (di luar kategori resmi) yang ada di `perubahan`. Dipakai
     * di index/show supaya field bebas ini tidak dianggap/dilabeli sebagai
     * kategori.
     */
    public static function pisahkanFieldTambahan(array $pengajuanKeys, array $perubahan): array
    {
        $kategoriValid = array_keys(self::kategoriList());
        $tambahan = [];

        foreach ($perubahan as $key => $value) {
            if (! in_array($key, $kategoriValid, true)) {
                $tambahan[$key] = $value;
            }
        }

        return $tambahan;
    }

    /**
     * Display a listing of Laporan Kerusakan (kategori dari
     * User\PengajuanController::kategoriList() saja).
     *
     * Berpasangan dengan rencanaPembangunanIndex() di bawah — keduanya
     * sengaja jadi VIEW & ROUTE terpisah (mengikuti pola user.pengajuan.*
     * vs user.rencana-pembangunan.* di sisi User), TAPI tetap satu
     * controller & satu tabel `pengajuans` yang sama (tidak ada
     * Admin\RencanaPembangunanController terpisah). Pemisahan kategori
     * mana masuk yang mana diambil dari kategoriList() milik masing-masing
     * controller USER (User\PengajuanController &
     * User\RencanaPembangunanController) — supaya kalau salah satu daftar
     * kategori berubah di sana, pemisahan di sini otomatis ikut berubah,
     * tidak perlu didaftar ulang manual di sini.
     */
    public function index()
    {
        $laporanKerusakanKeys = array_keys(\App\Http\Controllers\User\PengajuanController::kategoriList());

        $laporanKerusakans = Pengajuan::with('profileSekolah')
            ->where(function ($query) use ($laporanKerusakanKeys) {
                foreach ($laporanKerusakanKeys as $key) {
                    $query->orWhereJsonContains('pengajuan', $key);
                }
            })
            ->latest()
            ->paginate(10, ['*'], 'laporan_page');

        return view('admin.pengajuan.index', compact('laporanKerusakans'));
    }

    /**
     * Display a listing of Rencana Pembangunan (kategori dari
     * User\RencanaPembangunanController::kategoriList() saja).
     *
     * Sengaja jadi method & view TERPISAH dari index() di atas — tapi masih
     * di controller yang sama (Admin\PengajuanController), bukan controller
     * baru — lihat catatan di index().
     */
    public function rencanaPembangunanIndex()
    {
        $rencanaPembangunanKeys = array_keys(RencanaPembangunanController::kategoriList());

        $rencanaPembangunans = Pengajuan::with('profileSekolah')
            ->where(function ($query) use ($rencanaPembangunanKeys) {
                foreach ($rencanaPembangunanKeys as $key) {
                    $query->orWhereJsonContains('pengajuan', $key);
                }
            })
            ->latest()
            ->paginate(10, ['*'], 'rencana_page');

        return view('admin.rencana-pembangunan.index', compact('rencanaPembangunans'));
    }

    public function rencanaPembangunanShow(Pengajuan $pengajuan)
    {
        $pengajuan->load('profileSekolah');

        return view('admin.rencana-pembangunan.show', compact('pengajuan'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Pengajuan $pengajuan)
    {
        $pengajuan->load('profileSekolah');

        $kategoriList = self::kategoriList();

        return view('admin.pengajuan.show', compact('pengajuan', 'kategoriList'));
    }

    /**
     * Setujui pengajuan. Fitur ini hanya laporan & pengajuan, jadi yang
     * berubah cuma status — data sarana sekolah TIDAK diubah sama sekali.
     */
    public function approve(Pengajuan $pengajuan)
    {
        abort_if($pengajuan->status !== 'pending', 403, 'Hanya pengajuan berstatus pending yang bisa disetujui.');

        $pengajuan->update([
            'status' => 'approved',
        ]);

        // back(): kembali ke daftar asal (Laporan Kerusakan / Rencana
        // Pembangunan) tanpa perlu tahu nama route-nya.
        return back()->with('success', 'Pengajuan disetujui.');
    }

    /**
     * Tolak pengajuan — hanya status yang diubah.
     */
    public function reject(Pengajuan $pengajuan)
    {
        abort_if($pengajuan->status !== 'pending', 403, 'Hanya pengajuan berstatus pending yang bisa ditolak.');

        $pengajuan->update([
            'status' => 'rejected',
        ]);

        return back()->with('success', 'Pengajuan ditolak.');
    }
}
