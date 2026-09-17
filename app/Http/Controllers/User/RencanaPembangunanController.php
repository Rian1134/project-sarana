<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Pengajuan;
use App\Models\ProfileSekolah;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

/**
 * Modul "Rencana Pembangunan". Berpasangan dengan User\PengajuanController
 * (modul "Koreksi Data" / update kondisi) — keduanya sama-sama pakai tabel
 * `pengajuans`, dibedakan lewat kategori mana yang dipilih (lihat
 * kategoriList() di masing-masing controller, tidak saling tumpang tindih
 * key-nya dengan punya PengajuanController).
 *
 * Kategori di sini semuanya soal USUL PEMBANGUNAN BARU — bukan koreksi/laporan
 * kondisi data yang sudah ada:
 *   - jumlah        → RKB & Rehabilitasi Ruang Kelas (berapa unit yang diusulkan)
 *   - ada_kondisi    → semua ruangan/fasilitas lain (Ruang Guru, Perpustakaan,
 *                      dst) — SENGAJA TANPA FIELD sama sekali. Mencentang/
 *                      menambahkan kategori ini di form SUDAH berarti "ingin
 *                      membangun fasilitas ini"; begitu admin approve, statusnya
 *                      otomatis di-set "ada" + kondisi "baik" (lihat
 *                      Admin\PengajuanController::terapkanAdaKondisi()).
 */
class RencanaPembangunanController extends Controller
{
    public static function kategoriList(): array
    {
        return [
            'ruang_kelas_baru' => ['label' => 'Ruang Kelas Baru (RKB)', 'table' => 'ruang_kelas_barus', 'tipe' => 'jumlah'],
            'rehabilitasi_ruang_kelas' => ['label' => 'Rehabilitasi Ruang Kelas', 'table' => 'rehabilitasi_ruang_kelas', 'tipe' => 'jumlah'],
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
     * Ikon Bootstrap Icons per kategori, dipakai di view create/edit/show.
     */
    public static function ikonKategori(): array
    {
        return [
            'ruang_kelas_baru' => 'bi-building-add',
            'rehabilitasi_ruang_kelas' => 'bi-tools',
            'ruang_guru' => 'bi-easel2',
            'ruang_kepala_sekolah' => 'bi-person-workspace',
            'ruang_kantor_tu' => 'bi-briefcase',
            'ruang_perpustakaan' => 'bi-book',
            'lab_ipa' => 'bi-flask',
            'lab_komputer' => 'bi-pc-display-horizontal',
            'unit_kesehatan_sekolah' => 'bi-heart-pulse',
            'lapangan_sekolah' => 'bi-flag',
            'pagar_sekolah' => 'bi-border-all',
            'air_bersih' => 'bi-droplet',
            'rumah_dinas' => 'bi-house-door',
            'rumah_ibadah' => 'bi-building',
        ];
    }

    /**
     * Definisi field per tipe.
     *
     * ada_kondisi KOSONG SENGAJA — lihat catatan di docblock class. jumlah cuma
     * satu field: berapa unit yang diusulkan.
     */
    public static function fieldsByTipe(): array
    {
        return [
            'jumlah' => [
                ['name' => 'jumlah', 'label' => 'Jumlah', 'type' => 'number'],
            ],
            'ada_kondisi' => [],
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
     * Pisahkan data "perubahan" jadi dua: yang termasuk kategori resmi (di
     * kategoriList), dan field tambahan bebas yang nama serta nilainya diketik
     * sendiri oleh user (bukan kategori, cuma field lepas). Dipakai di index & show
     * supaya field bebas ini tidak dianggap/dilabeli sebagai kategori.
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
     * Bangun rules validasi untuk field-field satu kategori (dipakai store & update).
     * Kategori ada_kondisi tidak punya field, jadi otomatis menghasilkan array
     * rules kosong — tidak ada yang divalidasi untuk kategori itu.
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

        return view('user.rencana-pembangunan.index', compact('pengajuans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $kategoriList = self::kategoriList();
        $fieldsByTipe = self::fieldsByTipe();
        $ikonKategori = self::ikonKategori();

        return view('user.rencana-pembangunan.create', compact('kategoriList', 'fieldsByTipe', 'ikonKategori'));
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
            'judul_perubahan' => ['required', 'string', 'max:255'],
            'pilih' => ['nullable', 'array'],
        ]);

        $dipilih = array_values(array_intersect(
            array_keys($request->input('pilih', [])),
            array_keys($kategoriList)
        ));

        if (empty($dipilih)) {
            return back()
                ->withInput()
                ->withErrors(['pilih' => 'Pilih minimal satu kategori yang ingin diusulkan pembangunannya.']);
        }

        $rules = [];
        foreach ($dipilih as $key) {
            foreach ($this->rulesForKategori($key) as $field => $fieldRules) {
                $rules["perubahan.$key.$field"] = $fieldRules;
            }
        }
        $validated = $request->validate($rules);

        $perubahan = $validated['perubahan'] ?? [];

        // Kategori bertipe ada_kondisi tidak punya field/rules sama sekali, jadi
        // tidak akan muncul di $validated. Tetap catat sebagai array kosong supaya
        // kategori itu diketahui "diajukan" (bukan tak tercatat sama sekali).
        foreach ($dipilih as $key) {
            if (! array_key_exists($key, $perubahan)) {
                $perubahan[$key] = [];
            }
        }

        $profileSekolah = ProfileSekolah::where('user_id', Auth::id())->firstOrFail();

        Pengajuan::create([
            'user_id' => Auth::id(),
            'profile_sekolah_id' => $profileSekolah->id,
            'judul' => $request->input('judul_perubahan'),
            'pengajuan' => $dipilih,
            'perubahan' => $perubahan,
            'status' => 'pending',
        ]);

        return redirect()
            ->route('user.rencana-pembangunan.index')
            ->with('success', 'Rencana pembangunan berhasil diajukan, menunggu review admin.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Pengajuan $pengajuan)
    {
        $this->authorizeOwner($pengajuan);

        $kategoriList = self::kategoriList();
        $ikonKategori = self::ikonKategori();

        return view('user.rencana-pembangunan.show', compact('pengajuan', 'kategoriList', 'ikonKategori'));
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

        return view('user.rencana-pembangunan.edit', compact('pengajuan', 'kategoriList', 'fieldsByTipe', 'ikonKategori'));
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

        foreach ($dipilih as $key) {
            if (! array_key_exists($key, $perubahanBaru)) {
                $perubahanBaru[$key] = [];
            }
        }

        // Gabungkan: data kategori/field lama yang tidak disentuh tetap ada, yang
        // dipilih ulang di form ini menimpa nilai lamanya dengan yang baru.
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
            ->route('user.rencana-pembangunan.index')
            ->with('success', 'Rencana pembangunan berhasil diperbarui.');
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
            ->route('user.rencana-pembangunan.index')
            ->with('success', 'Rencana pembangunan berhasil dihapus.');
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