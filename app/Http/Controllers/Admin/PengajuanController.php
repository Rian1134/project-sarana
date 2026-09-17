<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengajuan;
use App\Models\ProfileSekolah;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PengajuanController extends Controller
{
    /**
     * Gabungan SEMUA kategori dari kedua modul user (Koreksi Data +
     * Rencana Pembangunan). HARUS SAMA PERSIS dengan gabungan
     * User\PengajuanController::kategoriList() dan
     * User\RencanaPembangunanController::kategoriList() — kalau salah satu
     * berubah (kategori baru/dihapus/tipe berubah), method ini WAJIB
     * disesuaikan juga, atau approve/reject bisa salah menerapkan perubahan.
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
     * HARUS SAMA PERSIS (gabungan) dengan fieldsByTipe() di kedua controller user.
     *
     * - ada_kondisi: KOSONG SENGAJA — "usul bangun baru", nilai baik/ada
     *   ditetapkan otomatis saat approve (lihat terapkanAdaKondisi()).
     * - update_kondisi: field 'kodisi' — lapor kondisi TERKINI fasilitas yang
     *   sudah ada (termasuk "Rusak"); nilainya DIBACA dari input user
     *   (lihat terapkanUpdateKondisi()), bukan ditetapkan otomatis.
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
                ['name' => 'kodisi', 'label' => 'Kondisi Saat Ini', 'type' => 'select', 'options' => ['baik' => 'Baik', 'rusak' => 'Rusak', 'nihil' => 'Nihil']],
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
     * Relasi sarana di ProfileSekolah diambil SECARA GENERIK dari key kategori
     * lewat Str::camel() — untuk kategori *_kondisi, akhiran "_kondisi" DIBUANG
     * dulu sebelum di-camel-kan, karena relasinya menunjuk ke tabel sarana yang
     * SAMA dengan kategori ada_kondisi/baik_rusak pasangannya (contoh:
     * 'ruang_guru_kondisi' & 'ruang_guru' sama-sama relasi ruangGuru()).
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
            // Field tambahan bebas (di luar kategoriList) tidak punya tabel
            // sarana tujuan — sengaja dilewati, bukan error.
            if (! isset($kategoriList[$kategori])) {
                continue;
            }

            $data = $perubahan[$kategori] ?? [];

            $namaRelasi = Str::endsWith($kategori, '_kondisi')
                ? Str::beforeLast($kategori, '_kondisi')
                : $kategori;
            $relasi = Str::camel($namaRelasi);

            if (! method_exists($profileSekolah, $relasi)) {
                continue;
            }

            // Ambil baris sarana yang sudah ada, atau buat baru kalau sekolah
            // ini belum pernah punya data kategori tersebut sama sekali.
            $sarana = $profileSekolah->{$relasi}()->firstOrCreate([]);

            match ($kategoriList[$kategori]['tipe']) {
                'baik_rusak' => $this->terapkanBaikRusak($sarana, $data),
                'ada_kondisi' => $this->terapkanAdaKondisi($sarana),
                'update_kondisi' => $this->terapkanUpdateKondisi($sarana, $data),
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
     * ada_kondisi: form user (Rencana Pembangunan) TIDAK mengumpulkan field
     * apapun — mencentang kategori ini SUDAH berarti "usul dibangun". Jadi
     * begitu admin approve, statusnya otomatis diset "ada" dengan kondisi
     * "baik" (fasilitas baru yang baru saja terwujud), BUKAN dibaca dari
     * input user (karena memang tidak ada inputnya).
     */
    private function terapkanAdaKondisi($sarana): void
    {
        $sarana->{'ada/tidak_ada'} = 'ada';
        $sarana->kodisi = 'baik';
        $sarana->save();
    }

    /**
     * update_kondisi: kebalikan dari ada_kondisi — ini buat fasilitas yang
     * SUDAH ADA, user melaporkan kondisi terkininya (termasuk "Rusak").
     * Nilai kodisi DIBACA LANGSUNG dari input user dan MENGGANTIKAN
     * (bukan menambah/mengurangi) nilai lama, karena fasilitas jenis ini
     * cuma satu unit per sekolah, bukan stok berjumlah banyak seperti
     * baik_rusak. Status ada/tidak_ada juga dipastikan "ada", karena
     * melaporkan kondisi cuma masuk akal kalau fasilitasnya memang sudah ada.
     */
    private function terapkanUpdateKondisi($sarana, array $data): void
    {
        if (array_key_exists('kodisi', $data)) {
            $sarana->kodisi = $data['kodisi'];
        }

        $sarana->{'ada/tidak_ada'} = 'ada';
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