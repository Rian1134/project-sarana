<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Pengajuan;
use App\Models\ProfileSekolah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

/**
 * Modul "Laporan Kerusakan" (dulu disebut "Koreksi Data"). Berpasangan dengan
 * RencanaPembangunanController — keduanya sama-sama pakai tabel `pengajuans`,
 * dibedakan lewat kategori mana yang dipilih (lihat kategoriList() di masing-
 * masing controller, tidak saling tumpang tindih key-nya).
 */
class PengajuanController extends Controller
{
    public static function kategoriList(): array
    {
        return [
            'ruang_kelas_kondisi' => ['label' => 'Ruang Kelas — Lapor Kerusakan', 'table' => 'ruang_kelas', 'tipe' => 'baik_rusak'],
            'toilet_siswa_kondisi' => ['label' => 'Toilet Siswa — Lapor Kerusakan', 'table' => 'toilet_siswas', 'tipe' => 'baik_rusak'],
            'toilet_guru_kondisi' => ['label' => 'Toilet Guru — Lapor Kerusakan', 'table' => 'toilet_gurus', 'tipe' => 'baik_rusak'],
            'ruang_guru_kondisi' => ['label' => 'Ruang Guru — Lapor Kerusakan', 'table' => 'ruang_gurus', 'tipe' => 'update_kondisi'],
            'ruang_kepala_sekolah_kondisi' => ['label' => 'Ruang Kepala Sekolah — Lapor Kerusakan', 'table' => 'ruang_kepala_sekolahs', 'tipe' => 'update_kondisi'],
            'ruang_kantor_tu_kondisi' => ['label' => 'Ruang Kantor TU — Lapor Kerusakan', 'table' => 'ruang_kantor_tus', 'tipe' => 'update_kondisi'],
            'ruang_perpustakaan_kondisi' => ['label' => 'Ruang Perpustakaan — Lapor Kerusakan', 'table' => 'ruang_perpustakaans', 'tipe' => 'update_kondisi'],
            'lab_ipa_kondisi' => ['label' => 'Laboratorium IPA — Lapor Kerusakan', 'table' => 'lab_ipas', 'tipe' => 'update_kondisi'],
            'lab_komputer_kondisi' => ['label' => 'Laboratorium Komputer — Lapor Kerusakan', 'table' => 'lab_komputers', 'tipe' => 'update_kondisi'],
            'unit_kesehatan_sekolah_kondisi' => ['label' => 'Unit Kesehatan Sekolah (UKS) — Lapor Kerusakan', 'table' => 'unit_kesehatan_sekolahs', 'tipe' => 'update_kondisi'],
            'lapangan_sekolah_kondisi' => ['label' => 'Lapangan Sekolah — Lapor Kerusakan', 'table' => 'lapangan_sekolahs', 'tipe' => 'update_kondisi'],
            'pagar_sekolah_kondisi' => ['label' => 'Pagar Sekolah — Lapor Kerusakan', 'table' => 'pagar_sekolahs', 'tipe' => 'update_kondisi'],
            'air_bersih_kondisi' => ['label' => 'Air Bersih — Lapor Kerusakan', 'table' => 'air_bersihs', 'tipe' => 'update_kondisi'],
            'rumah_dinas_kondisi' => ['label' => 'Rumah Dinas — Lapor Kerusakan', 'table' => 'rumah_dinas', 'tipe' => 'update_kondisi'],
            'rumah_ibadah_kondisi' => ['label' => 'Rumah Ibadah — Lapor Kerusakan', 'table' => 'rumah_ibadahs', 'tipe' => 'update_kondisi'],
        ];
    }

    /**
     * Ikon Bootstrap Icons per kategori, dipakai di view create/edit.
     */
    public static function ikonKategori(): array
    {
        return [
            'ruang_kelas' => 'bi-door-closed',
            'toilet_siswa' => 'bi-droplet-half',
            'toilet_guru' => 'bi-droplet',
            'ruang_guru_kondisi' => 'bi-easel2',
            'ruang_kepala_sekolah_kondisi' => 'bi-person-workspace',
            'ruang_kantor_tu_kondisi' => 'bi-briefcase',
            'ruang_perpustakaan_kondisi' => 'bi-book',
            'lab_ipa_kondisi' => 'bi-flask',
            'lab_komputer_kondisi' => 'bi-pc-display-horizontal',
            'unit_kesehatan_sekolah_kondisi' => 'bi-heart-pulse',
            'lapangan_sekolah_kondisi' => 'bi-flag',
            'pagar_sekolah_kondisi' => 'bi-border-all',
            'air_bersih_kondisi' => 'bi-droplet',
            'rumah_dinas_kondisi' => 'bi-house-door',
            'rumah_ibadah_kondisi' => 'bi-building',
        ];
    }

    /**
     * Definisi field per tipe. Kedua tipe di bawah soal melaporkan status
     * TERKINI fasilitas yang sudah ada:
     *   - `baik_rusak`     → cuma field `rusak` (jumlah unit yang rusak).
     *   - `update_kondisi` → field `ada/tidak_ada` (status terkini fasilitas)
     *                        dan `kodisi` dengan opsi tingkat kerusakan
     *                        ("Rusak Ringan", "Rusak Sedang", "Rusak Berat")
     *                        plus "Nihil" (kalau fasilitasnya sudah tidak
     *                        relevan/tidak ada lagi). Opsi "Baik" sengaja
     *                        tidak disediakan di sini karena form ini memang
     *                        khusus untuk melaporkan masalah/kerusakan.
     * Berbeda dengan `ada_kondisi` milik RencanaPembangunanController yang
     * memang sengaja TIDAK punya field sama sekali (itu untuk usul bangun baru,
     * bukan laporan kerusakan).
     */
    public static function fieldsByTipe(): array
    {
        return [
            'baik_rusak' => [
                ['name' => 'rusak', 'label' => 'Kondisi Rusak', 'type' => 'number'],
            ],
            'update_kondisi' => [
                ['name' => 'ada/tidak_ada', 'label' => 'Ada / Tidak Ada', 'type' => 'select', 'options' => [
                    'ada' => 'Ada',
                    'tidak_ada' => 'Tidak Ada',
                ]],
                ['name' => 'kodisi', 'label' => 'Kondisi Saat Ini', 'type' => 'select', 'options' => [
                    'rusak_ringan' => 'Rusak Ringan',
                    'rusak_sedang' => 'Rusak Sedang',
                    'rusak_berat' => 'Rusak Berat',
                    'nihil' => 'Nihil',
                ]],
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
     * Bangun rules validasi untuk field-field satu kategori (dipakai store & update).
     */
    private function rulesForKategori(string $kategori): array
    {
        $tipe = self::kategoriList()[$kategori]['tipe'];
        $rules = [];

        foreach (self::fieldsByTipe()[$tipe] as $field) {
            $rules[$field['name']] = $field['type'] === 'select'
                ? ['required', Rule::in(array_keys($field['options']))]
                : ['required', 'integer', 'min:0'];
        }

        return $rules;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $kategoriKeys = array_keys(self::kategoriList());

        $pengajuans = Pengajuan::with('profileSekolah')
            ->where('user_id', Auth::id())
            ->where(function ($query) use ($kategoriKeys) {
                foreach ($kategoriKeys as $key) {
                    $query->orWhereJsonContains('pengajuan', $key);
                }
            })
            ->latest()
            ->paginate(10);

        return view('user.pengajuan.index', compact('pengajuans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $kategoriList = self::kategoriList();
        $fieldsByTipe = self::fieldsByTipe();
        $ikonKategori = self::ikonKategori();

        return view('user.pengajuan.create', compact('kategoriList', 'fieldsByTipe', 'ikonKategori'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * Satu kali submit = SATU baris Pengajuan, walaupun user memilih beberapa
     * kategori sekaligus. Kolom `pengajuan` menyimpan array key kategori resmi
     * yang dipilih, kolom `perubahan` menyimpan data semua kategori itu
     * sekaligus, dikelompokkan per key kategori.
     */
    public function store(Request $request)
    {
        $kategoriList = self::kategoriList();

        $request->validate([
            'pilih' => ['nullable', 'array'],
        ]);

        $dipilih = array_values(array_intersect(
            array_keys($request->input('pilih', [])),
            array_keys($kategoriList)
        ));

        if (empty($dipilih)) {
            return back()
                ->withInput()
                ->withErrors(['pilih' => 'Pilih minimal satu kategori sarana/prasarana yang ingin dilaporkan rusak.']);
        }

        $rules = [];
        foreach ($dipilih as $key) {
            foreach ($this->rulesForKategori($key) as $field => $fieldRules) {
                $rules["perubahan.$key.$field"] = $fieldRules;
            }
        }
        $validated = $request->validate($rules);

        $perubahan = $validated['perubahan'] ?? [];

        $profileSekolah = ProfileSekolah::where('user_id', Auth::id())->firstOrFail();

        Pengajuan::create([
            'user_id' => Auth::id(),
            'profile_sekolah_id' => $profileSekolah->id,
            'pengajuan' => $dipilih,
            'perubahan' => $perubahan,
            'status' => 'pending',
        ]);

        return redirect()
            ->route('user.pengajuan.index')
            ->with('success', 'Laporan kerusakan berhasil dikirim, menunggu review admin.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Pengajuan $pengajuan)
    {
        $this->authorizeOwner($pengajuan);

        $kategoriList = self::kategoriList();

        return view('user.pengajuan.show', compact('pengajuan', 'kategoriList'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pengajuan $pengajuan)
    {
        $this->authorizeOwner($pengajuan);
        $this->guardEditable($pengajuan);

        $kategoriList = self::kategoriList();
        $fieldsByTipe = self::fieldsByTipe();
        $ikonKategori = self::ikonKategori();

        return view('user.pengajuan.edit', compact('pengajuan', 'kategoriList', 'fieldsByTipe', 'ikonKategori'));
    }

    /**
     * Update the specified resource in storage.
     *
     * Data kategori yang sudah tersimpan sebelumnya TETAP dipertahankan; kategori
     * yang dipilih ulang di form ini akan menimpa nilai lamanya (kalau memang
     * diubah), dan kategori baru yang baru dipilih akan ditambahkan ke baris
     * pengajuan yang sama.
     */
    public function update(Request $request, Pengajuan $pengajuan)
    {
        $this->authorizeOwner($pengajuan);
        $this->guardEditable($pengajuan);

        $kategoriList = self::kategoriList();

        $request->validate([
            'judul_perubahan' => ['required', 'string', 'max:255'],
            'pilih' => ['nullable', 'array'],
        ]);

        $dipilih = array_values(array_intersect(
            array_keys($request->input('pilih', [])),
            array_keys($kategoriList)
        ));

        $rules = [];
        foreach ($dipilih as $key) {
            foreach ($this->rulesForKategori($key) as $field => $fieldRules) {
                $rules["perubahan.$key.$field"] = $fieldRules;
            }
        }
        $validated = $request->validate($rules);

        $perubahanBaru = $validated['perubahan'] ?? [];

        $perubahanLama = $pengajuan->perubahan ?? [];
        $perubahanGabungan = array_merge($perubahanLama, $perubahanBaru);

        $kategoriLama = is_array($pengajuan->pengajuan) ? $pengajuan->pengajuan : array_filter([$pengajuan->pengajuan]);
        $kategoriGabungan = array_values(array_unique(array_merge($kategoriLama, $dipilih)));

        $pengajuan->update([
            'judul' => $request->input('judul_perubahan'),
            'pengajuan' => $kategoriGabungan,
            'perubahan' => $perubahanGabungan,
        ]);

        return redirect()
            ->route('user.pengajuan.index')
            ->with('success', 'Laporan kerusakan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pengajuan $pengajuan)
    {
        $this->authorizeOwner($pengajuan);
        $this->guardEditable($pengajuan, 'dihapus');

        $pengajuan->delete();

        return redirect()
            ->route('user.pengajuan.index')
            ->with('success', 'Laporan kerusakan berhasil dihapus.');
    }

    private function authorizeOwner(Pengajuan $pengajuan): void
    {
        abort_unless($pengajuan->user_id === Auth::id(), 403);
    }

    private function guardEditable(Pengajuan $pengajuan, string $aksi = 'diedit'): void
    {
        abort_if(
            $pengajuan->status !== 'pending',
            403,
            "Hanya pengajuan berstatus pending yang bisa {$aksi}."
        );
    }
}