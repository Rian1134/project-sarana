<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ExportData;
use App\Http\Controllers\Controller;
use App\Models\AirBersih;
use App\Models\JumlahRombel;
use App\Models\JumlahSiswa;
use App\Models\Komputer;
use App\Models\KursiGuru;
use App\Models\KursiSiswa;
use App\Models\LabIpa;
use App\Models\LabKomputer;
use App\Models\LapanganSekolah;
use App\Models\Laptop;
use App\Models\MejaGuru;
use App\Models\MejaSiswa;
use App\Models\PagarSekolah;
use App\Models\PeriodeLaporan;
use App\Models\RehabilitasiRuangKelas;
use App\Models\RuangGuru;
use App\Models\RuangKantorTu;
use App\Models\RuangKelas;
use App\Models\RuangKelasBaru;
use App\Models\RuangKepalaSekolah;
use App\Models\RuangPerpustakaan;
use App\Models\RumahDinas;
use App\Models\RumahIbadah;
use App\Models\Sarana;
use App\Models\ToiletGuru;
use App\Models\ToiletSiswa;
use App\Models\UnitKesehatanSekolah;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

/**
 * DataController
 *
 * Mengelola CRUD data sarana & prasarana sekolah (25 kategori, mengikuti
 * urutan kolom di excel sumber: Jumlah Siswa s.d Komputer).
 *
 * ==========================================================================
 * SISTEM PERIODE PADA RKB & REHABILITASI RUANG KELAS
 * ==========================================================================
 * Dua kategori ini beda dari kategori lain karena datanya terikat periode
 * pelaporan tertentu — sesuai judul kolom asli di excel:
 * "Pembangunan Ruang Kelas Baru (RKB) Dari Tahun 2020 s.d 2025" dan
 * "Rehabilitasi Ruang Kelas Dari Tahun 2020 s.d 2025".
 *
 * Tahunnya GLOBAL (satu nilai untuk SEMUA sekolah), disimpan di tabel
 * `periode_laporans` (lihat model PeriodeLaporan) — BUKAN per-sekolah,
 * dan BUKAN input di form Sarana ini. Form ini hanya menerima `rkb_jumlah`
 * & `rehabilitasi_jumlah`; tahunnya cuma ditampilkan read-only (diambil
 * dari PeriodeLaporan) sebagai konteks.
 *
 * Yang boleh mengubah tahunnya HANYA admin, lewat halaman terpisah
 * "Pengaturan Periode" (lihat PeriodeLaporanController::update()). Begitu
 * tahun diubah, kolom `jumlah` RKB/Rehabilitasi di SEMUA sekolah otomatis
 * direset ke 0 — karena angka lama dianggap milik periode sebelumnya,
 * bukan periode yang baru.
 * ==========================================================================
 */
class DataController extends Controller
{
    public function index(Request $request)
    {
        // Kata kunci pencarian (nama sekolah)
        $search = $request->input('search');

        // Ambil semua data dengan relasi
        $query = Sarana::with([
            'pagarSekolah',
            'airBersih',
            'kursiSiswa',
            'mejaSiswa',
            'kursiGuru',
            'mejaGuru',
            'laptop',
            'komputer',
            'jumlahSiswa',
            'jumlahRombel',
            'ruangKelasBaru',
            'rehabilitasiRuangKelas',
            'ruangKelas',
            'toiletSiswa',
            'toiletGuru',
            'ruangPerpustakaan',
            'ruangKepalaSekolah',
            'ruangGuru',
            'ruangKantorTu',
            'labIpa',
            'labKomputer',
            'unitKesehatanSekolah',
            'rumahDinas',
            'rumahIbadah',
            'lapanganSekolah',
        ]);

        // Filter pencarian berdasarkan nama sekolah
        if ($search) {
            $query->where('nama_sekolah', 'like', '%'.$search.'%');
        }

        $saranas = $query->get();

        // Hitung total untuk setiap kategori
        $totals = [
            'kursi_siswa' => [
                'baik' => $saranas->sum(function ($item) {
                    return $item->kursiSiswa?->baik ?? 0;
                }),
                'rusak' => $saranas->sum(function ($item) {
                    return $item->kursiSiswa?->rusak ?? 0;
                }),
                'jumlah' => $saranas->sum(function ($item) {
                    return ($item->kursiSiswa?->baik ?? 0) + ($item->kursiSiswa?->rusak ?? 0);
                }),
            ],
            'meja_siswa' => [
                'baik' => $saranas->sum(function ($item) {
                    return $item->mejaSiswa?->baik ?? 0;
                }),
                'rusak' => $saranas->sum(function ($item) {
                    return $item->mejaSiswa?->rusak ?? 0;
                }),
                'jumlah' => $saranas->sum(function ($item) {
                    return ($item->mejaSiswa?->baik ?? 0) + ($item->mejaSiswa?->rusak ?? 0);
                }),
            ],
            'kursi_guru' => [
                'baik' => $saranas->sum(function ($item) {
                    return $item->kursiGuru?->baik ?? 0;
                }),
                'rusak' => $saranas->sum(function ($item) {
                    return $item->kursiGuru?->rusak ?? 0;
                }),
                'jumlah' => $saranas->sum(function ($item) {
                    return ($item->kursiGuru?->baik ?? 0) + ($item->kursiGuru?->rusak ?? 0);
                }),
            ],
            'meja_guru' => [
                'baik' => $saranas->sum(function ($item) {
                    return $item->mejaGuru?->baik ?? 0;
                }),
                'rusak' => $saranas->sum(function ($item) {
                    return $item->mejaGuru?->rusak ?? 0;
                }),
                'jumlah' => $saranas->sum(function ($item) {
                    return ($item->mejaGuru?->baik ?? 0) + ($item->mejaGuru?->rusak ?? 0);
                }),
            ],
            'laptop' => [
                'baik' => $saranas->sum(function ($item) {
                    return $item->laptop?->baik ?? 0;
                }),
                'rusak' => $saranas->sum(function ($item) {
                    return $item->laptop?->rusak ?? 0;
                }),
                'jumlah' => $saranas->sum(function ($item) {
                    return ($item->laptop?->baik ?? 0) + ($item->laptop?->rusak ?? 0);
                }),
            ],
            'komputer' => [
                'baik' => $saranas->sum(function ($item) {
                    return $item->komputer?->baik ?? 0;
                }),
                'rusak' => $saranas->sum(function ($item) {
                    return $item->komputer?->rusak ?? 0;
                }),
                'jumlah' => $saranas->sum(function ($item) {
                    return ($item->komputer?->baik ?? 0) + ($item->komputer?->rusak ?? 0);
                }),
            ],
            // Total Pagar - Ada/Tidak
            'pagar_ada' => $saranas->filter(function ($item) {
                return $item->pagarSekolah?->{'ada/tidak_ada'} == 'ada';
            })->count(),
            'pagar_tidak_ada' => $saranas->filter(function ($item) {
                return $item->pagarSekolah?->{'ada/tidak_ada'} == 'tidak_ada';
            })->count(),
            // Total Air - Ada/Tidak
            'air_ada' => $saranas->filter(function ($item) {
                return $item->airBersih?->{'ada/tidak_ada'} == 'ada';
            })->count(),
            'air_tidak_ada' => $saranas->filter(function ($item) {
                return $item->airBersih?->{'ada/tidak_ada'} == 'tidak_ada';
            })->count(),
            'jumlah_siswa' => [
                'vii' => $saranas->sum(function ($item) {
                    return $item->jumlahSiswa?->vii ?? 0;
                }),
                'viii' => $saranas->sum(function ($item) {
                    return $item->jumlahSiswa?->viii ?? 0;
                }),
                'ix' => $saranas->sum(function ($item) {
                    return $item->jumlahSiswa?->ix ?? 0;
                }),
                'jumlah' => $saranas->sum(function ($item) {
                    return ($item->jumlahSiswa?->vii ?? 0) + ($item->jumlahSiswa?->viii ?? 0) + ($item->jumlahSiswa?->ix ?? 0);
                }),
            ],
            'jumlah_rombel' => [
                'vii' => $saranas->sum(function ($item) {
                    return $item->jumlahRombel?->vii ?? 0;
                }),
                'viii' => $saranas->sum(function ($item) {
                    return $item->jumlahRombel?->viii ?? 0;
                }),
                'ix' => $saranas->sum(function ($item) {
                    return $item->jumlahRombel?->ix ?? 0;
                }),
                'jumlah' => $saranas->sum(function ($item) {
                    return ($item->jumlahRombel?->vii ?? 0) + ($item->jumlahRombel?->viii ?? 0) + ($item->jumlahRombel?->ix ?? 0);
                }),
            ],
            'rkb' => $saranas->sum(function ($item) {
                return $item->ruangKelasBaru?->jumlah ?? 0;
            }),
            'rehabilitasi' => $saranas->sum(function ($item) {
                return $item->rehabilitasiRuangKelas?->jumlah ?? 0;
            }),
            'ruang_kelas' => [
                'baik' => $saranas->sum(function ($item) {
                    return $item->ruangKelas?->baik ?? 0;
                }),
                'rusak' => $saranas->sum(function ($item) {
                    return $item->ruangKelas?->rusak ?? 0;
                }),
                'jumlah' => $saranas->sum(function ($item) {
                    return ($item->ruangKelas?->baik ?? 0) + ($item->ruangKelas?->rusak ?? 0);
                }),
            ],
            'toilet_siswa' => [
                'baik' => $saranas->sum(function ($item) {
                    return $item->toiletSiswa?->baik ?? 0;
                }),
                'rusak' => $saranas->sum(function ($item) {
                    return $item->toiletSiswa?->rusak ?? 0;
                }),
                'jumlah' => $saranas->sum(function ($item) {
                    return ($item->toiletSiswa?->baik ?? 0) + ($item->toiletSiswa?->rusak ?? 0);
                }),
            ],
            'toilet_guru' => [
                'baik' => $saranas->sum(function ($item) {
                    return $item->toiletGuru?->baik ?? 0;
                }),
                'rusak' => $saranas->sum(function ($item) {
                    return $item->toiletGuru?->rusak ?? 0;
                }),
                'jumlah' => $saranas->sum(function ($item) {
                    return ($item->toiletGuru?->baik ?? 0) + ($item->toiletGuru?->rusak ?? 0);
                }),
            ],
            'perpustakaan_ada' => $saranas->filter(function ($item) {
                return $item->ruangPerpustakaan?->{'ada/tidak_ada'} == 'ada';
            })->count(),
            'perpustakaan_tidak_ada' => $saranas->filter(function ($item) {
                return $item->ruangPerpustakaan?->{'ada/tidak_ada'} == 'tidak_ada';
            })->count(),
            'kepala_sekolah_ada' => $saranas->filter(function ($item) {
                return $item->ruangKepalaSekolah?->{'ada/tidak_ada'} == 'ada';
            })->count(),
            'kepala_sekolah_tidak_ada' => $saranas->filter(function ($item) {
                return $item->ruangKepalaSekolah?->{'ada/tidak_ada'} == 'tidak_ada';
            })->count(),
            'ruang_guru_ada' => $saranas->filter(function ($item) {
                return $item->ruangGuru?->{'ada/tidak_ada'} == 'ada';
            })->count(),
            'ruang_guru_tidak_ada' => $saranas->filter(function ($item) {
                return $item->ruangGuru?->{'ada/tidak_ada'} == 'tidak_ada';
            })->count(),
            'kantor_tu_ada' => $saranas->filter(function ($item) {
                return $item->ruangKantorTu?->{'ada/tidak_ada'} == 'ada';
            })->count(),
            'kantor_tu_tidak_ada' => $saranas->filter(function ($item) {
                return $item->ruangKantorTu?->{'ada/tidak_ada'} == 'tidak_ada';
            })->count(),
            'lab_ipa_ada' => $saranas->filter(function ($item) {
                return $item->labIpa?->{'ada/tidak_ada'} == 'ada';
            })->count(),
            'lab_ipa_tidak_ada' => $saranas->filter(function ($item) {
                return $item->labIpa?->{'ada/tidak_ada'} == 'tidak_ada';
            })->count(),
            'lab_komputer_ada' => $saranas->filter(function ($item) {
                return $item->labKomputer?->{'ada/tidak_ada'} == 'ada';
            })->count(),
            'lab_komputer_tidak_ada' => $saranas->filter(function ($item) {
                return $item->labKomputer?->{'ada/tidak_ada'} == 'tidak_ada';
            })->count(),
            'uks_ada' => $saranas->filter(function ($item) {
                return $item->unitKesehatanSekolah?->{'ada/tidak_ada'} == 'ada';
            })->count(),
            'uks_tidak_ada' => $saranas->filter(function ($item) {
                return $item->unitKesehatanSekolah?->{'ada/tidak_ada'} == 'tidak_ada';
            })->count(),
            'rumah_dinas_ada' => $saranas->filter(function ($item) {
                return $item->rumahDinas?->{'ada/tidak_ada'} == 'ada';
            })->count(),
            'rumah_dinas_tidak_ada' => $saranas->filter(function ($item) {
                return $item->rumahDinas?->{'ada/tidak_ada'} == 'tidak_ada';
            })->count(),
            'rumah_ibadah_ada' => $saranas->filter(function ($item) {
                return $item->rumahIbadah?->{'ada/tidak_ada'} == 'ada';
            })->count(),
            'rumah_ibadah_tidak_ada' => $saranas->filter(function ($item) {
                return $item->rumahIbadah?->{'ada/tidak_ada'} == 'tidak_ada';
            })->count(),
            'lapangan_sekolah_ada' => $saranas->filter(function ($item) {
                return $item->lapanganSekolah?->{'ada/tidak_ada'} == 'ada';
            })->count(),
            'lapangan_sekolah_tidak_ada' => $saranas->filter(function ($item) {
                return $item->lapanganSekolah?->{'ada/tidak_ada'} == 'tidak_ada';
            })->count(),
        ];

        $rkbPeriode = PeriodeLaporan::forKategori('rkb');
        $rehabilitasiPeriode = PeriodeLaporan::forKategori('rehabilitasi');

        return view('admin.data.index', compact('saranas', 'totals', 'rkbPeriode', 'rehabilitasiPeriode'));
    }

    public function create()
    {
        $rkbPeriode = PeriodeLaporan::forKategori('rkb');
        $rehabilitasiPeriode = PeriodeLaporan::forKategori('rehabilitasi');

        return view('admin.data.create', compact('rkbPeriode', 'rehabilitasiPeriode'));
    }

    public function store(Request $request)
    {
        // Validasi data
        $request->validate([
            'nama_sekolah' => 'required|string|max:255',
            'NPSN' => 'required|string|unique:saranas,NPSN|max:20',
            'alamat_sekolah' => 'required|string',
            'nama_kepala_sekolah' => 'required|string|max:255',
            'NIP' => 'required|string|unique:saranas,NIP|max:20',
            'nomor_hp' => 'required|string|unique:saranas,nomor_hp|max:15',

            'pagar_ada_tidak' => 'required|in:ada,tidak_ada',
            'pagar_kondisi' => 'nullable|in:baik,rusak,nihil',
            'air_ada_tidak' => 'required|in:ada,tidak_ada',
            'air_kondisi' => 'nullable|in:baik,rusak,nihil',
            'kursi_siswa_baik' => 'required|integer|min:0',
            'kursi_siswa_rusak' => 'required|integer|min:0',
            'meja_siswa_baik' => 'required|integer|min:0',
            'meja_siswa_rusak' => 'required|integer|min:0',
            'kursi_guru_baik' => 'required|integer|min:0',
            'kursi_guru_rusak' => 'required|integer|min:0',
            'meja_guru_baik' => 'required|integer|min:0',
            'meja_guru_rusak' => 'required|integer|min:0',
            'laptop_baik' => 'required|integer|min:0',
            'laptop_rusak' => 'required|integer|min:0',
            'komputer_baik' => 'required|integer|min:0',
            'komputer_rusak' => 'required|integer|min:0',
            'jumlah_siswa_vii' => 'required|integer|min:0',
            'jumlah_siswa_viii' => 'required|integer|min:0',
            'jumlah_siswa_ix' => 'required|integer|min:0',
            'jumlah_rombel_vii' => 'required|integer|min:0',
            'jumlah_rombel_viii' => 'required|integer|min:0',
            'jumlah_rombel_ix' => 'required|integer|min:0',

            // RKB & Rehabilitasi: tahunnya sekarang GLOBAL (lihat
            // App\Models\PeriodeLaporan, cuma admin yang bisa ubah lewat
            // PeriodeLaporanController) — form di sini cuma minta jumlah.
            'rkb_jumlah' => 'required|integer|min:0',
            'rehabilitasi_jumlah' => 'required|integer|min:0',
            'ruang_kelas_baik' => 'required|integer|min:0',
            'ruang_kelas_rusak' => 'required|integer|min:0',
            'toilet_siswa_baik' => 'required|integer|min:0',
            'toilet_siswa_rusak' => 'required|integer|min:0',
            'toilet_guru_baik' => 'required|integer|min:0',
            'toilet_guru_rusak' => 'required|integer|min:0',
            'perpustakaan_ada_tidak' => 'required|in:ada,tidak_ada',
            'perpustakaan_kondisi' => 'nullable|in:baik,rusak,nihil',
            'kepala_sekolah_ada_tidak' => 'required|in:ada,tidak_ada',
            'kepala_sekolah_kondisi' => 'nullable|in:baik,rusak,nihil',
            'ruang_guru_ada_tidak' => 'required|in:ada,tidak_ada',
            'ruang_guru_kondisi' => 'nullable|in:baik,rusak,nihil',
            'kantor_tu_ada_tidak' => 'required|in:ada,tidak_ada',
            'kantor_tu_kondisi' => 'nullable|in:baik,rusak,nihil',
            'lab_ipa_ada_tidak' => 'required|in:ada,tidak_ada',
            'lab_ipa_kondisi' => 'nullable|in:baik,rusak,nihil',
            'lab_komputer_ada_tidak' => 'required|in:ada,tidak_ada',
            'lab_komputer_kondisi' => 'nullable|in:baik,rusak,nihil',
            'uks_ada_tidak' => 'required|in:ada,tidak_ada',
            'uks_kondisi' => 'nullable|in:baik,rusak,nihil',
            'rumah_dinas_ada_tidak' => 'required|in:ada,tidak_ada',
            'rumah_dinas_kondisi' => 'nullable|in:baik,rusak,nihil',
            'rumah_ibadah_ada_tidak' => 'required|in:ada,tidak_ada',
            'rumah_ibadah_kondisi' => 'nullable|in:baik,rusak,nihil',
            'lapangan_sekolah_ada_tidak' => 'required|in:ada,tidak_ada',
            'lapangan_sekolah_kondisi' => 'nullable|in:baik,rusak,nihil',
        ]);

        try {
            // 1. Simpan data sekolah menggunakan Model
            // TAMBAHKAN user_id dari user yang sedang login
            $sarana = Sarana::create([
                'nama_sekolah' => $request->nama_sekolah,
                'NPSN' => $request->NPSN,
                'alamat_sekolah' => $request->alamat_sekolah,
                'nama_kepala_sekolah' => $request->nama_kepala_sekolah,
                'NIP' => $request->NIP,
                'nomor_hp' => $request->nomor_hp,
                'user_id' => Auth::id(), // <- TAMBAHKAN INI
            ]);

            // 2. Simpan Pagar Sekolah
            PagarSekolah::create([
                'sarana_id' => $sarana->id,
                'ada/tidak_ada' => $request->pagar_ada_tidak,
                'kodisi' => $request->pagar_kondisi ?? 'nihil',
            ]);

            // 3. Simpan Air Bersih
            AirBersih::create([
                'sarana_id' => $sarana->id,
                'ada/tidak_ada' => $request->air_ada_tidak,
                'kodisi' => $request->air_kondisi ?? 'nihil',
            ]);

            // 4. Simpan Kursi Siswa
            KursiSiswa::create([
                'sarana_id' => $sarana->id,
                'baik' => $request->kursi_siswa_baik,
                'rusak' => $request->kursi_siswa_rusak,
            ]);

            // 5. Simpan Meja Siswa
            MejaSiswa::create([
                'sarana_id' => $sarana->id,
                'baik' => $request->meja_siswa_baik,
                'rusak' => $request->meja_siswa_rusak,
            ]);

            // 6. Simpan Kursi Guru
            KursiGuru::create([
                'sarana_id' => $sarana->id,
                'baik' => $request->kursi_guru_baik,
                'rusak' => $request->kursi_guru_rusak,
            ]);

            // 7. Simpan Meja Guru
            MejaGuru::create([
                'sarana_id' => $sarana->id,
                'baik' => $request->meja_guru_baik,
                'rusak' => $request->meja_guru_rusak,
            ]);

            // 8. Simpan Laptop
            Laptop::create([
                'sarana_id' => $sarana->id,
                'baik' => $request->laptop_baik,
                'rusak' => $request->laptop_rusak,
            ]);

            // 9. Simpan Komputer
            Komputer::create([
                'sarana_id' => $sarana->id,
                'baik' => $request->komputer_baik,
                'rusak' => $request->komputer_rusak,
            ]);

            // Simpan JumlahSiswa
            JumlahSiswa::create([
                'sarana_id' => $sarana->id,
                'vii' => $request->jumlah_siswa_vii,
                'viii' => $request->jumlah_siswa_viii,
                'ix' => $request->jumlah_siswa_ix,
            ]);

            // Simpan JumlahRombel
            JumlahRombel::create([
                'sarana_id' => $sarana->id,
                'vii' => $request->jumlah_rombel_vii,
                'viii' => $request->jumlah_rombel_viii,
                'ix' => $request->jumlah_rombel_ix,
            ]);

            // Simpan RuangKelasBaru — tahun sekarang global (PeriodeLaporan),
            // di sini cuma simpan jumlah.
            RuangKelasBaru::create([
                'sarana_id' => $sarana->id,
                'jumlah' => $request->rkb_jumlah,
            ]);

            // Simpan RehabilitasiRuangKelas
            RehabilitasiRuangKelas::create([
                'sarana_id' => $sarana->id,
                'jumlah' => $request->rehabilitasi_jumlah,
            ]);

            // Simpan RuangKelas
            RuangKelas::create([
                'sarana_id' => $sarana->id,
                'baik' => $request->ruang_kelas_baik,
                'rusak' => $request->ruang_kelas_rusak,
            ]);

            // Simpan ToiletSiswa
            ToiletSiswa::create([
                'sarana_id' => $sarana->id,
                'baik' => $request->toilet_siswa_baik,
                'rusak' => $request->toilet_siswa_rusak,
            ]);

            // Simpan ToiletGuru
            ToiletGuru::create([
                'sarana_id' => $sarana->id,
                'baik' => $request->toilet_guru_baik,
                'rusak' => $request->toilet_guru_rusak,
            ]);

            // Simpan RuangPerpustakaan
            RuangPerpustakaan::create([
                'sarana_id' => $sarana->id,
                'ada/tidak_ada' => $request->perpustakaan_ada_tidak,
                'kodisi' => $request->perpustakaan_kondisi ?? 'nihil',
            ]);

            // Simpan RuangKepalaSekolah
            RuangKepalaSekolah::create([
                'sarana_id' => $sarana->id,
                'ada/tidak_ada' => $request->kepala_sekolah_ada_tidak,
                'kodisi' => $request->kepala_sekolah_kondisi ?? 'nihil',
            ]);

            // Simpan RuangGuru
            RuangGuru::create([
                'sarana_id' => $sarana->id,
                'ada/tidak_ada' => $request->ruang_guru_ada_tidak,
                'kodisi' => $request->ruang_guru_kondisi ?? 'nihil',
            ]);

            // Simpan RuangKantorTu
            RuangKantorTu::create([
                'sarana_id' => $sarana->id,
                'ada/tidak_ada' => $request->kantor_tu_ada_tidak,
                'kodisi' => $request->kantor_tu_kondisi ?? 'nihil',
            ]);

            // Simpan LabIpa
            LabIpa::create([
                'sarana_id' => $sarana->id,
                'ada/tidak_ada' => $request->lab_ipa_ada_tidak,
                'kodisi' => $request->lab_ipa_kondisi ?? 'nihil',
            ]);

            // Simpan LabKomputer
            LabKomputer::create([
                'sarana_id' => $sarana->id,
                'ada/tidak_ada' => $request->lab_komputer_ada_tidak,
                'kodisi' => $request->lab_komputer_kondisi ?? 'nihil',
            ]);

            // Simpan UnitKesehatanSekolah
            UnitKesehatanSekolah::create([
                'sarana_id' => $sarana->id,
                'ada/tidak_ada' => $request->uks_ada_tidak,
                'kodisi' => $request->uks_kondisi ?? 'nihil',
            ]);

            // Simpan RumahDinas
            RumahDinas::create([
                'sarana_id' => $sarana->id,
                'ada/tidak_ada' => $request->rumah_dinas_ada_tidak,
                'kodisi' => $request->rumah_dinas_kondisi ?? 'nihil',
            ]);

            // Simpan RumahIbadah
            RumahIbadah::create([
                'sarana_id' => $sarana->id,
                'ada/tidak_ada' => $request->rumah_ibadah_ada_tidak,
                'kodisi' => $request->rumah_ibadah_kondisi ?? 'nihil',
            ]);

            // Simpan LapanganSekolah
            LapanganSekolah::create([
                'sarana_id' => $sarana->id,
                'ada/tidak_ada' => $request->lapangan_sekolah_ada_tidak,
                'kodisi' => $request->lapangan_sekolah_kondisi ?? 'nihil',
            ]);

            return redirect()->route('sarana.index')
                ->with('success', 'Data Sarana berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal menyimpan data: '.$e->getMessage());
        }
    }

    public function show(Sarana $sarana)
    {
        $sarana->load([
            'pagarSekolah',
            'airBersih',
            'kursiSiswa',
            'mejaSiswa',
            'kursiGuru',
            'mejaGuru',
            'laptop',
            'komputer',
            'jumlahSiswa',
            'jumlahRombel',
            'ruangKelasBaru',
            'rehabilitasiRuangKelas',
            'ruangKelas',
            'toiletSiswa',
            'toiletGuru',
            'ruangPerpustakaan',
            'ruangKepalaSekolah',
            'ruangGuru',
            'ruangKantorTu',
            'labIpa',
            'labKomputer',
            'unitKesehatanSekolah',
            'rumahDinas',
            'rumahIbadah',
            'lapanganSekolah',
        ]);

        $rkbPeriode = PeriodeLaporan::forKategori('rkb');
        $rehabilitasiPeriode = PeriodeLaporan::forKategori('rehabilitasi');

        return view('admin.data.show', compact('sarana', 'rkbPeriode', 'rehabilitasiPeriode'));
    }

    public function edit(Sarana $sarana)
    {
        $sarana->load([
            'pagarSekolah',
            'airBersih',
            'kursiSiswa',
            'mejaSiswa',
            'kursiGuru',
            'mejaGuru',
            'laptop',
            'komputer',
            'jumlahSiswa',
            'jumlahRombel',
            'ruangKelasBaru',
            'rehabilitasiRuangKelas',
            'ruangKelas',
            'toiletSiswa',
            'toiletGuru',
            'ruangPerpustakaan',
            'ruangKepalaSekolah',
            'ruangGuru',
            'ruangKantorTu',
            'labIpa',
            'labKomputer',
            'unitKesehatanSekolah',
            'rumahDinas',
            'rumahIbadah',
            'lapanganSekolah',
        ]);

        $rkbPeriode = PeriodeLaporan::forKategori('rkb');
        $rehabilitasiPeriode = PeriodeLaporan::forKategori('rehabilitasi');

        return view('admin.data.edit', compact('sarana', 'rkbPeriode', 'rehabilitasiPeriode'));
    }

    public function update(Request $request, Sarana $sarana)
    {
        $request->validate([
            'nama_sekolah' => 'required|string|max:255',
            'NPSN' => 'required|string|max:20|unique:saranas,NPSN,'.$sarana->id,
            'alamat_sekolah' => 'required|string',
            'nama_kepala_sekolah' => 'required|string|max:255',
            'NIP' => 'required|string|max:20|unique:saranas,NIP,'.$sarana->id,
            'nomor_hp' => 'required|string|max:15|unique:saranas,nomor_hp,'.$sarana->id,

            'pagar_ada_tidak' => 'required|in:ada,tidak_ada',
            'pagar_kondisi' => 'nullable|in:baik,rusak,nihil',
            'air_ada_tidak' => 'required|in:ada,tidak_ada',
            'air_kondisi' => 'nullable|in:baik,rusak,nihil',
            'kursi_siswa_baik' => 'required|integer|min:0',
            'kursi_siswa_rusak' => 'required|integer|min:0',
            'meja_siswa_baik' => 'required|integer|min:0',
            'meja_siswa_rusak' => 'required|integer|min:0',
            'kursi_guru_baik' => 'required|integer|min:0',
            'kursi_guru_rusak' => 'required|integer|min:0',
            'meja_guru_baik' => 'required|integer|min:0',
            'meja_guru_rusak' => 'required|integer|min:0',
            'laptop_baik' => 'required|integer|min:0',
            'laptop_rusak' => 'required|integer|min:0',
            'komputer_baik' => 'required|integer|min:0',
            'komputer_rusak' => 'required|integer|min:0',
            'jumlah_siswa_vii' => 'required|integer|min:0',
            'jumlah_siswa_viii' => 'required|integer|min:0',
            'jumlah_siswa_ix' => 'required|integer|min:0',
            'jumlah_rombel_vii' => 'required|integer|min:0',
            'jumlah_rombel_viii' => 'required|integer|min:0',
            'jumlah_rombel_ix' => 'required|integer|min:0',

            // RKB & Rehabilitasi: tahunnya sekarang GLOBAL (lihat
            // App\Models\PeriodeLaporan, cuma admin yang bisa ubah lewat
            // PeriodeLaporanController) — form di sini cuma minta jumlah.
            'rkb_jumlah' => 'required|integer|min:0',
            'rehabilitasi_jumlah' => 'required|integer|min:0',
            'ruang_kelas_baik' => 'required|integer|min:0',
            'ruang_kelas_rusak' => 'required|integer|min:0',
            'toilet_siswa_baik' => 'required|integer|min:0',
            'toilet_siswa_rusak' => 'required|integer|min:0',
            'toilet_guru_baik' => 'required|integer|min:0',
            'toilet_guru_rusak' => 'required|integer|min:0',
            'perpustakaan_ada_tidak' => 'required|in:ada,tidak_ada',
            'perpustakaan_kondisi' => 'nullable|in:baik,rusak,nihil',
            'kepala_sekolah_ada_tidak' => 'required|in:ada,tidak_ada',
            'kepala_sekolah_kondisi' => 'nullable|in:baik,rusak,nihil',
            'ruang_guru_ada_tidak' => 'required|in:ada,tidak_ada',
            'ruang_guru_kondisi' => 'nullable|in:baik,rusak,nihil',
            'kantor_tu_ada_tidak' => 'required|in:ada,tidak_ada',
            'kantor_tu_kondisi' => 'nullable|in:baik,rusak,nihil',
            'lab_ipa_ada_tidak' => 'required|in:ada,tidak_ada',
            'lab_ipa_kondisi' => 'nullable|in:baik,rusak,nihil',
            'lab_komputer_ada_tidak' => 'required|in:ada,tidak_ada',
            'lab_komputer_kondisi' => 'nullable|in:baik,rusak,nihil',
            'uks_ada_tidak' => 'required|in:ada,tidak_ada',
            'uks_kondisi' => 'nullable|in:baik,rusak,nihil',
            'rumah_dinas_ada_tidak' => 'required|in:ada,tidak_ada',
            'rumah_dinas_kondisi' => 'nullable|in:baik,rusak,nihil',
            'rumah_ibadah_ada_tidak' => 'required|in:ada,tidak_ada',
            'rumah_ibadah_kondisi' => 'nullable|in:baik,rusak,nihil',
            'lapangan_sekolah_ada_tidak' => 'required|in:ada,tidak_ada',
            'lapangan_sekolah_kondisi' => 'nullable|in:baik,rusak,nihil',
        ]);

        try {
            // Update data sekolah
            $sarana->update([
                'nama_sekolah' => $request->nama_sekolah,
                'NPSN' => $request->NPSN,
                'alamat_sekolah' => $request->alamat_sekolah,
                'nama_kepala_sekolah' => $request->nama_kepala_sekolah,
                'NIP' => $request->NIP,
                'nomor_hp' => $request->nomor_hp,
                // user_id tidak diupdate agar tetap dengan pembuat awal
            ]);

            // Update atau create relasi
            PagarSekolah::updateOrCreate(
                ['sarana_id' => $sarana->id],
                [
                    'ada/tidak_ada' => $request->pagar_ada_tidak,
                    'kodisi' => $request->pagar_kondisi ?? 'nihil',
                ]
            );

            AirBersih::updateOrCreate(
                ['sarana_id' => $sarana->id],
                [
                    'ada/tidak_ada' => $request->air_ada_tidak,
                    'kodisi' => $request->air_kondisi ?? 'nihil',
                ]
            );

            KursiSiswa::updateOrCreate(
                ['sarana_id' => $sarana->id],
                [
                    'baik' => $request->kursi_siswa_baik,
                    'rusak' => $request->kursi_siswa_rusak,
                ]
            );

            MejaSiswa::updateOrCreate(
                ['sarana_id' => $sarana->id],
                [
                    'baik' => $request->meja_siswa_baik,
                    'rusak' => $request->meja_siswa_rusak,
                ]
            );

            KursiGuru::updateOrCreate(
                ['sarana_id' => $sarana->id],
                [
                    'baik' => $request->kursi_guru_baik,
                    'rusak' => $request->kursi_guru_rusak,
                ]
            );

            MejaGuru::updateOrCreate(
                ['sarana_id' => $sarana->id],
                [
                    'baik' => $request->meja_guru_baik,
                    'rusak' => $request->meja_guru_rusak,
                ]
            );

            Laptop::updateOrCreate(
                ['sarana_id' => $sarana->id],
                [
                    'baik' => $request->laptop_baik,
                    'rusak' => $request->laptop_rusak,
                ]
            );

            Komputer::updateOrCreate(
                ['sarana_id' => $sarana->id],
                [
                    'baik' => $request->komputer_baik,
                    'rusak' => $request->komputer_rusak,
                ]
            );

            JumlahSiswa::updateOrCreate(
                ['sarana_id' => $sarana->id],
                [
                    'vii' => $request->jumlah_siswa_vii,
                    'viii' => $request->jumlah_siswa_viii,
                    'ix' => $request->jumlah_siswa_ix,
                ]
            );

            JumlahRombel::updateOrCreate(
                ['sarana_id' => $sarana->id],
                [
                    'vii' => $request->jumlah_rombel_vii,
                    'viii' => $request->jumlah_rombel_viii,
                    'ix' => $request->jumlah_rombel_ix,
                ]
            );

            // RKB & Rehabilitasi: tahun sekarang global (PeriodeLaporan),
            // di sini cuma update jumlah.
            RuangKelasBaru::updateOrCreate(
                ['sarana_id' => $sarana->id],
                ['jumlah' => $request->rkb_jumlah]
            );

            RehabilitasiRuangKelas::updateOrCreate(
                ['sarana_id' => $sarana->id],
                ['jumlah' => $request->rehabilitasi_jumlah]
            );

            RuangKelas::updateOrCreate(
                ['sarana_id' => $sarana->id],
                [
                    'baik' => $request->ruang_kelas_baik,
                    'rusak' => $request->ruang_kelas_rusak,
                ]
            );

            ToiletSiswa::updateOrCreate(
                ['sarana_id' => $sarana->id],
                [
                    'baik' => $request->toilet_siswa_baik,
                    'rusak' => $request->toilet_siswa_rusak,
                ]
            );

            ToiletGuru::updateOrCreate(
                ['sarana_id' => $sarana->id],
                [
                    'baik' => $request->toilet_guru_baik,
                    'rusak' => $request->toilet_guru_rusak,
                ]
            );

            RuangPerpustakaan::updateOrCreate(
                ['sarana_id' => $sarana->id],
                [
                    'ada/tidak_ada' => $request->perpustakaan_ada_tidak,
                    'kodisi' => $request->perpustakaan_kondisi ?? 'nihil',
                ]
            );

            RuangKepalaSekolah::updateOrCreate(
                ['sarana_id' => $sarana->id],
                [
                    'ada/tidak_ada' => $request->kepala_sekolah_ada_tidak,
                    'kodisi' => $request->kepala_sekolah_kondisi ?? 'nihil',
                ]
            );

            RuangGuru::updateOrCreate(
                ['sarana_id' => $sarana->id],
                [
                    'ada/tidak_ada' => $request->ruang_guru_ada_tidak,
                    'kodisi' => $request->ruang_guru_kondisi ?? 'nihil',
                ]
            );

            RuangKantorTu::updateOrCreate(
                ['sarana_id' => $sarana->id],
                [
                    'ada/tidak_ada' => $request->kantor_tu_ada_tidak,
                    'kodisi' => $request->kantor_tu_kondisi ?? 'nihil',
                ]
            );

            LabIpa::updateOrCreate(
                ['sarana_id' => $sarana->id],
                [
                    'ada/tidak_ada' => $request->lab_ipa_ada_tidak,
                    'kodisi' => $request->lab_ipa_kondisi ?? 'nihil',
                ]
            );

            LabKomputer::updateOrCreate(
                ['sarana_id' => $sarana->id],
                [
                    'ada/tidak_ada' => $request->lab_komputer_ada_tidak,
                    'kodisi' => $request->lab_komputer_kondisi ?? 'nihil',
                ]
            );

            UnitKesehatanSekolah::updateOrCreate(
                ['sarana_id' => $sarana->id],
                [
                    'ada/tidak_ada' => $request->uks_ada_tidak,
                    'kodisi' => $request->uks_kondisi ?? 'nihil',
                ]
            );

            RumahDinas::updateOrCreate(
                ['sarana_id' => $sarana->id],
                [
                    'ada/tidak_ada' => $request->rumah_dinas_ada_tidak,
                    'kodisi' => $request->rumah_dinas_kondisi ?? 'nihil',
                ]
            );

            RumahIbadah::updateOrCreate(
                ['sarana_id' => $sarana->id],
                [
                    'ada/tidak_ada' => $request->rumah_ibadah_ada_tidak,
                    'kodisi' => $request->rumah_ibadah_kondisi ?? 'nihil',
                ]
            );

            LapanganSekolah::updateOrCreate(
                ['sarana_id' => $sarana->id],
                [
                    'ada/tidak_ada' => $request->lapangan_sekolah_ada_tidak,
                    'kodisi' => $request->lapangan_sekolah_kondisi ?? 'nihil',
                ]
            );

            return redirect()->route('sarana.index')
                ->with('success', 'Data Sarana berhasil diupdate!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal mengupdate data: '.$e->getMessage());
        }
    }

    public function destroy(Sarana $sarana)
    {
        try {
            // Hapus semua relasi
            $sarana->pagarSekolah()->delete();
            $sarana->airBersih()->delete();
            $sarana->kursiSiswa()->delete();
            $sarana->mejaSiswa()->delete();
            $sarana->kursiGuru()->delete();
            $sarana->mejaGuru()->delete();
            $sarana->laptop()->delete();
            $sarana->komputer()->delete();
            $sarana->jumlahSiswa()->delete();
            $sarana->jumlahRombel()->delete();
            $sarana->ruangKelasBaru()->delete();
            $sarana->rehabilitasiRuangKelas()->delete();
            $sarana->ruangKelas()->delete();
            $sarana->toiletSiswa()->delete();
            $sarana->toiletGuru()->delete();
            $sarana->ruangPerpustakaan()->delete();
            $sarana->ruangKepalaSekolah()->delete();
            $sarana->ruangGuru()->delete();
            $sarana->ruangKantorTu()->delete();
            $sarana->labIpa()->delete();
            $sarana->labKomputer()->delete();
            $sarana->unitKesehatanSekolah()->delete();
            $sarana->rumahDinas()->delete();
            $sarana->rumahIbadah()->delete();
            $sarana->lapanganSekolah()->delete();

            // Hapus data utama
            $sarana->delete();

            return redirect()->route('sarana.index')
                ->with('success', 'Data Sarana berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menghapus data: '.$e->getMessage());
        }
    }

    public function export_excel(Request $request)
    {
        try {
            $fileName = 'data_sarana_sekolah - '.Carbon::now()->format('Y-m-d_His').'.xlsx';

            return Excel::download(new ExportData, $fileName);
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal mengexport data: '.$e->getMessage());
        }
    }
}