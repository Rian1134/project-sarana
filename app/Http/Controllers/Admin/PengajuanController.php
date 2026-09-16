<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengajuan;
use App\Models\ProfileSekolah;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
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
     * dibaca di index/show. Nama field di sini SAMA PERSIS dengan nama kolom
     * asli di tabel sarana (sudah dikonfirmasi lewat Model: baik/rusak,
     * ada/tidak_ada, kodisi, jumlah) — dipakai juga oleh terapkanPerubahan().
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
     * Field tambahan (di luar kategori resmi) yang ada di `perubahan`. Dipakai
     * di index/show supaya field bebas ini tidak dianggap/dilabeli sebagai
     * kategori — dan (lihat terapkanPerubahan) sengaja DILEWATI saat approve,
     * karena tidak ada tabel sarana yang jadi tujuannya.
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

    public function index()
    {
        $pengajuans = Pengajuan::with('profileSekolah')
            ->latest()
            ->paginate(10);

        return view('admin.pengajuan.index', compact('pengajuans'));
    }

    /**
     * Display the specified resource.
     *
     * FIX: sebelumnya method ini menerima string $id, membuat query builder
     * tanpa pernah dieksekusi (tidak ada ->first()/->firstOrFail()), dan
     * mengembalikan view 'admin.pengajuan.index' (bukan view show). Sekarang
     * pakai route model binding (konsisten dengan User\PengajuanController)
     * supaya otomatis 404 kalau id tidak ditemukan, dan mengembalikan view
     * show yang benar.
     */
    public function show(Pengajuan $pengajuan)
    {
        $pengajuan->load('profileSekolah');

        $kategoriList = self::kategoriList();

        return view('admin.pengajuan.show', compact('pengajuan', 'kategoriList'));
    }

    /**
     * Setujui pengajuan: terapkan seluruh perubahan ke data sarana sekolah
     * terkait, lalu tandai status jadi 'approved'. Dibungkus DB transaction
     * supaya kalau salah satu update gagal di tengah jalan, semuanya
     * dibatalkan (tidak ada perubahan stok yang nyangkut separuh).
     */
    public function approve(Pengajuan $pengajuan)
    {
        abort_if($pengajuan->status !== 'pending', 403, 'Hanya pengajuan berstatus pending yang bisa disetujui.');

        DB::transaction(function () use ($pengajuan) {
            $this->terapkanPerubahan($pengajuan);

            $pengajuan->update([
                'status' => 'approved',
            ]);
        });

        return redirect()
            ->route('pengajuan.index')
            ->with('success', 'Pengajuan disetujui, data sarana sekolah sudah diperbarui.');
    }

    /**
     * Tolak pengajuan. Tidak ada perubahan data sarana sama sekali — hanya
     * status yang diubah.
     */
    public function reject(Pengajuan $pengajuan)
    {
        abort_if($pengajuan->status !== 'pending', 403, 'Hanya pengajuan berstatus pending yang bisa ditolak.');

        $pengajuan->update([
            'status' => 'rejected',
        ]);

        return redirect()
            ->route('pengajuan.index')
            ->with('success', 'Pengajuan ditolak.');
    }

    /**
     * Terapkan seluruh kategori yang diajukan ke tabel sarana terkait.
     *
     * Relasi sarana di ProfileSekolah (ruangKelas(), kursiSiswa(), dst) diambil
     * SECARA GENERIK dari key kategori lewat Str::camel() — bukan di-hardcode
     * satu-satu — karena penamaannya sudah konsisten (dicek manual untuk
     * semua 23 kategori). Kalau suatu saat ada kategori baru yang nama
     * relasinya tidak mengikuti pola ini, method ini akan MELEWATI (skip)
     * kategori itu dengan aman (lihat method_exists check), bukan error.
     */
    private function terapkanPerubahan(Pengajuan $pengajuan): void
    {
        /** @var ProfileSekolah $profileSekolah */
        $profileSekolah = $pengajuan->profileSekolah;

        $kategoriTerpilih = is_array($pengajuan->pengajuan)
            ? $pengajuan->pengajuan
            : array_filter([$pengajuan->pengajuan]);

        $perubahan = $pengajuan->perubahan ?? [];
        $kategoriList = self::kategoriList();

        foreach ($kategoriTerpilih as $kategori) {
            $data = $perubahan[$kategori] ?? null;

            // Field tambahan bebas (di luar kategoriList) tidak punya tabel
            // sarana tujuan — sengaja dilewati, bukan error.
            if (! $data || ! isset($kategoriList[$kategori])) {
                continue;
            }

            $relasi = Str::camel($kategori);

            if (! method_exists($profileSekolah, $relasi)) {
                continue;
            }

            // Ambil baris sarana yang sudah ada, atau buat baru kalau sekolah
            // ini belum pernah punya data kategori tersebut sama sekali.
            $sarana = $profileSekolah->{$relasi}()->firstOrCreate([]);

            match ($kategoriList[$kategori]['tipe']) {
                'baik_rusak' => $this->terapkanBaikRusak($sarana, $data),
                'ada_kondisi' => $this->terapkanAdaKondisi($sarana, $data),
                'jumlah' => $this->terapkanJumlah($profileSekolah, $kategori, $sarana, $data),
                default => null,
            };
        }
    }

    /**
     * baik_rusak: barang kondisi "baik" yang diajukan MENAMBAH stok baik;
     * barang yang dilaporkan "rusak" dianggap PINDAH dari stok baik ke stok
     * rusak (baik berkurang, rusak bertambah sejumlah yang sama). Stok baik
     * di-clamp minimal 0 supaya tidak pernah negatif kalau rusak yang
     * dilaporkan lebih besar dari stok baik yang tercatat.
     */
    private function terapkanBaikRusak($sarana, array $data): void
    {
        $baikBaru = (int) ($data['baik'] ?? 0);
        $rusakBaru = (int) ($data['rusak'] ?? 0);

        $sarana->baik = max(0, $sarana->baik + $baikBaru - $rusakBaru);
        $sarana->rusak = $sarana->rusak + $rusakBaru;
        $sarana->save();
    }

    /**
     * ada_kondisi: field status "ada/tidak_ada" & "kodisi" merepresentasikan
     * kondisi TERKINI (bukan angka kumulatif) — jadi nilai baru MENGGANTIKAN
     * nilai lama, bukan ditambah/dikurang.
     */
    private function terapkanAdaKondisi($sarana, array $data): void
    {
        if (array_key_exists('ada/tidak_ada', $data)) {
            $sarana->{'ada/tidak_ada'} = $data['ada/tidak_ada'];
        }

        if (array_key_exists('kodisi', $data)) {
            $sarana->kodisi = $data['kodisi'];
        }

        $sarana->save();
    }

    /**
     * jumlah: hanya dipakai oleh RKB & Rehabilitasi Ruang Kelas. Tabel jumlah
     * miliknya sendiri diakumulasi (total yang pernah diajukan & disetujui),
     * DAN keduanya juga berdampak ke stok Ruang Kelas (baik/rusak):
     * - RKB: ruang kelas baru langsung masuk hitungan "baik".
     * - Rehab: ruang yang tadinya "rusak", setelah direhab jadi "baik"
     *   (rusak berkurang, baik bertambah sejumlah yang sama, rusak
     *   di-clamp minimal 0).
     */
    private function terapkanJumlah(ProfileSekolah $profileSekolah, string $kategori, $sarana, array $data): void
    {
        $jumlahBaru = (int) ($data['jumlah'] ?? 0);

        $sarana->jumlah = $sarana->jumlah + $jumlahBaru;
        $sarana->save();

        $ruangKelas = $profileSekolah->ruangKelas()->firstOrCreate([]);

        if ($kategori === 'ruang_kelas_baru') {
            $ruangKelas->baik = $ruangKelas->baik + $jumlahBaru;
        } elseif ($kategori === 'rehabilitasi_ruang_kelas') {
            $ruangKelas->rusak = max(0, $ruangKelas->rusak - $jumlahBaru);
            $ruangKelas->baik = $ruangKelas->baik + $jumlahBaru;
        }

        $ruangKelas->save();
    }
}