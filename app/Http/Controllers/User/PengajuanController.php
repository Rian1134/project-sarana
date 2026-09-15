<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Pengajuan;
use App\Models\ProfileSekolah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class PengajuanController extends Controller
{
    public static function kategoriList(): array
    {
        return [
            'ruang_kelas_baru' => ['label' => 'Ruang Kelas Baru (RKB)', 'table' => 'ruang_kelas_barus', 'tipe' => 'jumlah'],
            'rehabilitasi_ruang_kelas' => ['label' => 'Rehabilitasi Ruang Kelas', 'table' => 'rehabilitasi_ruang_kelas', 'tipe' => 'jumlah'],
            'ruang_kelas' => ['label' => 'Ruang Kelas', 'table' => 'ruang_kelas', 'tipe' => 'baik_rusak'],
            'ruang_guru' => ['label' => 'Ruang Guru', 'table' => 'ruang_gurus', 'tipe' => 'ada_kondisi'],
            'ruang_kepala_sekolah' => ['label' => 'Ruang Kepala Sekolah', 'table' => 'ruang_kepala_sekolahs', 'tipe' => 'ada_kondisi'],
            'ruang_kantor_tu' => ['label' => 'Ruang Kantor TU', 'table' => 'ruang_kantor_tus', 'tipe' => 'ada_kondisi'],
            'ruang_perpustakaan' => ['label' => 'Ruang Perpustakaan', 'table' => 'ruang_perpustakaans', 'tipe' => 'ada_kondisi'],
            'lab_ipa' => ['label' => 'Laboratorium IPA', 'table' => 'lab_ipas', 'tipe' => 'ada_kondisi'],
            'lab_komputer' => ['label' => 'Laboratorium Komputer', 'table' => 'lab_komputers', 'tipe' => 'ada_kondisi'],
            'toilet_siswa' => ['label' => 'Toilet Siswa', 'table' => 'toilet_siswas', 'tipe' => 'baik_rusak'],
            'toilet_guru' => ['label' => 'Toilet Guru', 'table' => 'toilet_gurus', 'tipe' => 'baik_rusak'],
            'meja_siswa' => ['label' => 'Meja Siswa', 'table' => 'meja_siswas', 'tipe' => 'baik_rusak'],
            'meja_guru' => ['label' => 'Meja Guru', 'table' => 'meja_gurus', 'tipe' => 'baik_rusak'],
            'kursi_siswa' => ['label' => 'Kursi Siswa', 'table' => 'kursi_siswas', 'tipe' => 'baik_rusak'],
            'kursi_guru' => ['label' => 'Kursi Guru', 'table' => 'kursi_gurus', 'tipe' => 'baik_rusak'],
            'komputer' => ['label' => 'Komputer', 'table' => 'komputers', 'tipe' => 'baik_rusak'],
            'laptop' => ['label' => 'Laptop', 'table' => 'laptops', 'tipe' => 'baik_rusak'],
            'chromebook' => ['label' => 'Chromebook', 'table' => 'chromebooks', 'tipe' => 'baik_rusak'],
            'unit_kesehatan_sekolah' => ['label' => 'Unit Kesehatan Sekolah (UKS)', 'table' => 'unit_kesehatan_sekolahs', 'tipe' => 'ada_kondisi'],
            'lapangan_sekolah' => ['label' => 'Lapangan Sekolah', 'table' => 'lapangan_sekolahs', 'tipe' => 'ada_kondisi'],
            'pagar_sekolah' => ['label' => 'Pagar Sekolah', 'table' => 'pagar_sekolahs', 'tipe' => 'ada_kondisi'],
            'air_bersih' => ['label' => 'Air Bersih', 'table' => 'air_bersihs', 'tipe' => 'ada_kondisi'],
            'rumah_dinas' => ['label' => 'Rumah Dinas', 'table' => 'rumah_dinas', 'tipe' => 'ada_kondisi'],
            'rumah_ibadah' => ['label' => 'Rumah Ibadah', 'table' => 'rumah_ibadahs', 'tipe' => 'ada_kondisi'],
        ];
    }

    /**
     * Definisi field per tipe, disesuaikan dengan kolom asli tiap tabel sarana.
     * Dirender langsung oleh Blade di view create/edit (bukan JS), dan dipakai
     * fieldLabel() untuk menerjemahkan key JSON `perubahan` jadi label yang enak
     * dibaca di index/show.
     */
    public static function fieldsByTipe(): array
    {
        return [
            'baik_rusak' => [
                ['name' => 'baik', 'label' => 'Kondisi Baik', 'type' => 'number'],
                ['name' => 'rusak', 'label' => 'Kondisi Rusak', 'type' => 'number'],
            ],
            'siswa_rombel' => [
                ['name' => 'vii', 'label' => 'Kelas VII', 'type' => 'number'],
                ['name' => 'viii', 'label' => 'Kelas VIII', 'type' => 'number'],
                ['name' => 'ix', 'label' => 'Kelas IX', 'type' => 'number'],
            ],
            'jumlah' => [
                ['name' => 'jumlah', 'label' => 'Jumlah', 'type' => 'number'],
            ],
            'ada_kondisi' => [
                ['name' => 'ada/tidak_ada', 'label' => 'Status', 'type' => 'select', 'options' => ['ada' => 'Ada', 'tidak_ada' => 'Tidak Ada']],
                ['name' => 'kodisi', 'label' => 'Kondisi', 'type' => 'select', 'options' => ['baik' => 'Baik', 'rusak' => 'Rusak', 'nihil' => 'Nihil']],
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
    public function index()
    {
        $pengajuans = Pengajuan::with('profileSekolah')
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('user.pengajuan.index', compact('pengajuans'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * Satu halaman untuk semua kategori sekaligus (gaya form create data sarpras):
     * tiap kategori jadi satu panel accordion berisi checkbox "sertakan" + field
     * sesuai tipenya. Semua dirender oleh Blade di server, tanpa JS.
     */
    public function create()
    {
        $kategoriList = self::kategoriList();
        $fieldsByTipe = self::fieldsByTipe();

        return view('user.pengajuan.create', compact('kategoriList', 'fieldsByTipe'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * Satu kali submit = SATU baris Pengajuan, walaupun user mencentang beberapa
     * kategori sekaligus. Kolom `pengajuan` menyimpan array key kategori resmi yang
     * dipilih (di-cast ke array oleh model), kolom `perubahan` menyimpan data semua
     * kategori itu sekaligus, dikelompokkan per key kategori.
     *
     * Judul Perubahan disimpan ke kolom `judul` sendiri (sesuai migration), BUKAN
     * dicampur ke dalam `perubahan` — supaya tidak ikut muncul di rincian
     * pembaruan per kategori.
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
                ->withErrors(['pilih' => 'Pilih minimal satu kategori data yang ingin diajukan.']);
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
            'judul' => $request->input('judul_perubahan'),
            'pengajuan' => $dipilih,
            'perubahan' => $perubahan,
            'status' => 'pending',
        ]);

        return redirect()
            ->route('user.pengajuan.index')
            ->with('success', 'Pengajuan berhasil dikirim, menunggu review admin.');
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
     *
     * Menampilkan SEMUA kategori (sama seperti create), dengan kategori yang sudah
     * ada di pengajuan ini otomatis tercentang & terisi nilainya. User bisa
     * menambah kategori lain sekaligus di form yang sama.
     */
    public function edit(Pengajuan $pengajuan)
    {
        $this->authorizeOwner($pengajuan);
        $this->guardEditable($pengajuan);

        $kategoriList = self::kategoriList();
        $fieldsByTipe = self::fieldsByTipe();

        return view('user.pengajuan.edit', compact('pengajuan', 'kategoriList', 'fieldsByTipe'));
    }

    /**
     * Update the specified resource in storage.
     *
     * Data kategori yang sudah tersimpan sebelumnya TETAP dipertahankan; kategori
     * yang dicentang ulang di form ini akan menimpa nilai lamanya (kalau memang
     * diubah), dan kategori baru yang baru dicentang akan ditambahkan ke baris
     * pengajuan yang sama — jadi hasil akhirnya gabungan data lama + data baru,
     * bukan menggantikan semuanya.
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

        // Gabungkan: data kategori/field lama yang tidak disentuh tetap ada, yang
        // dicentang/diisi ulang di form ini menimpa nilai lamanya dengan yang baru.
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
            ->with('success', 'Pengajuan berhasil diperbarui.');
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
            ->with('success', 'Pengajuan berhasil dihapus.');
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