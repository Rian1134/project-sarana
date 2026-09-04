<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ExportData;
use App\Http\Controllers\Controller;
use App\Models\AirBersih;
use App\Models\Chromebook;
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
use App\Models\ProfileSekolah;
use App\Models\RehabilitasiRuangKelas;
use App\Models\RuangGuru;
use App\Models\RuangKantorTu;
use App\Models\RuangKelas;
use App\Models\RuangKelasBaru;
use App\Models\RuangKepalaSekolah;
use App\Models\RuangPerpustakaan;
use App\Models\RumahDinas;
use App\Models\RumahIbadah;
use App\Models\ToiletGuru;
use App\Models\ToiletSiswa;
use App\Models\UnitKesehatanSekolah;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

 
class DataController extends Controller
{
    public function index(Request $request)
    {
        // Kata kunci pencarian (nama sekolah)
        $search = $request->input('search');

        // Ambil semua data dengan relasi
        $query = ProfileSekolah::with([
            'pagarSekolah',
            'airBersih',
            'kursiSiswa',
            'mejaSiswa',
            'kursiGuru',
            'mejaGuru',
            'laptop',
            'komputer',
            'chromebook',
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

        $profileSekolahs = $query->get();

        // Hitung total untuk setiap kategori
        $totals = [
            'kursi_siswa' => [
                'bagus' => $profileSekolahs->sum(function ($item) {
                    return $item->kursiSiswa?->bagus ?? 0;
                }),
                'rusak' => $profileSekolahs->sum(function ($item) {
                    return $item->kursiSiswa?->rusak ?? 0;
                }),
                'jumlah' => $profileSekolahs->sum(function ($item) {
                    return ($item->kursiSiswa?->bagus ?? 0) + ($item->kursiSiswa?->rusak ?? 0);
                }),
            ],
            'meja_siswa' => [
                'bagus' => $profileSekolahs->sum(function ($item) {
                    return $item->mejaSiswa?->bagus ?? 0;
                }),
                'rusak' => $profileSekolahs->sum(function ($item) {
                    return $item->mejaSiswa?->rusak ?? 0;
                }),
                'jumlah' => $profileSekolahs->sum(function ($item) {
                    return ($item->mejaSiswa?->bagus ?? 0) + ($item->mejaSiswa?->rusak ?? 0);
                }),
            ],
            'kursi_guru' => [
                'bagus' => $profileSekolahs->sum(function ($item) {
                    return $item->kursiGuru?->bagus ?? 0;
                }),
                'rusak' => $profileSekolahs->sum(function ($item) {
                    return $item->kursiGuru?->rusak ?? 0;
                }),
                'jumlah' => $profileSekolahs->sum(function ($item) {
                    return ($item->kursiGuru?->bagus ?? 0) + ($item->kursiGuru?->rusak ?? 0);
                }),
            ],
            'meja_guru' => [
                'bagus' => $profileSekolahs->sum(function ($item) {
                    return $item->mejaGuru?->bagus ?? 0;
                }),
                'rusak' => $profileSekolahs->sum(function ($item) {
                    return $item->mejaGuru?->rusak ?? 0;
                }),
                'jumlah' => $profileSekolahs->sum(function ($item) {
                    return ($item->mejaGuru?->bagus ?? 0) + ($item->mejaGuru?->rusak ?? 0);
                }),
            ],
            'laptop' => [
                'bagus' => $profileSekolahs->sum(function ($item) {
                    return $item->laptop?->bagus ?? 0;
                }),
                'rusak' => $profileSekolahs->sum(function ($item) {
                    return $item->laptop?->rusak ?? 0;
                }),
                'jumlah' => $profileSekolahs->sum(function ($item) {
                    return ($item->laptop?->bagus ?? 0) + ($item->laptop?->rusak ?? 0);
                }),
            ],
            'komputer' => [
                'bagus' => $profileSekolahs->sum(function ($item) {
                    return $item->komputer?->bagus ?? 0;
                }),
                'rusak' => $profileSekolahs->sum(function ($item) {
                    return $item->komputer?->rusak ?? 0;
                }),
                'jumlah' => $profileSekolahs->sum(function ($item) {
                    return ($item->komputer?->bagus ?? 0) + ($item->komputer?->rusak ?? 0);
                }),
            ],
            'chromebook' => [
                'bagus' => $profileSekolahs->sum(function ($item) {
                    return $item->chromebook?->bagus ?? 0;
                }),
                'rusak' => $profileSekolahs->sum(function ($item) {
                    return $item->chromebook?->rusak ?? 0;
                }),
                'jumlah' => $profileSekolahs->sum(function ($item) {
                    return ($item->chromebook?->bagus ?? 0) + ($item->chromebook?->rusak ?? 0);
                }),
            ],
            // Total Pagar - Ada/Tidak
            'pagar_ada' => $profileSekolahs->filter(function ($item) {
                return $item->pagarSekolah?->{'ada/tidak_ada'} == 'ada';
            })->count(),
            'pagar_tidak_ada' => $profileSekolahs->filter(function ($item) {
                return $item->pagarSekolah?->{'ada/tidak_ada'} == 'tidak_ada';
            })->count(),
            // Total Air - Ada/Tidak
            'air_ada' => $profileSekolahs->filter(function ($item) {
                return $item->airBersih?->{'ada/tidak_ada'} == 'ada';
            })->count(),
            'air_tidak_ada' => $profileSekolahs->filter(function ($item) {
                return $item->airBersih?->{'ada/tidak_ada'} == 'tidak_ada';
            })->count(),
            'jumlah_siswa' => [
                'vii' => $profileSekolahs->sum(function ($item) {
                    return $item->jumlahSiswa?->vii ?? 0;
                }),
                'viii' => $profileSekolahs->sum(function ($item) {
                    return $item->jumlahSiswa?->viii ?? 0;
                }),
                'ix' => $profileSekolahs->sum(function ($item) {
                    return $item->jumlahSiswa?->ix ?? 0;
                }),
                'jumlah' => $profileSekolahs->sum(function ($item) {
                    return ($item->jumlahSiswa?->vii ?? 0) + ($item->jumlahSiswa?->viii ?? 0) + ($item->jumlahSiswa?->ix ?? 0);
                }),
            ],
            'jumlah_rombel' => [
                'vii' => $profileSekolahs->sum(function ($item) {
                    return $item->jumlahRombel?->vii ?? 0;
                }),
                'viii' => $profileSekolahs->sum(function ($item) {
                    return $item->jumlahRombel?->viii ?? 0;
                }),
                'ix' => $profileSekolahs->sum(function ($item) {
                    return $item->jumlahRombel?->ix ?? 0;
                }),
                'jumlah' => $profileSekolahs->sum(function ($item) {
                    return ($item->jumlahRombel?->vii ?? 0) + ($item->jumlahRombel?->viii ?? 0) + ($item->jumlahRombel?->ix ?? 0);
                }),
            ],
            'rkb' => $profileSekolahs->sum(function ($item) {
                return $item->ruangKelasBaru?->jumlah ?? 0;
            }),
            'rehabilitasi' => $profileSekolahs->sum(function ($item) {
                return $item->rehabilitasiRuangKelas?->jumlah ?? 0;
            }),
            'ruang_kelas' => [
                'bagus' => $profileSekolahs->sum(function ($item) {
                    return $item->ruangKelas?->bagus ?? 0;
                }),
                'rusak' => $profileSekolahs->sum(function ($item) {
                    return $item->ruangKelas?->rusak ?? 0;
                }),
                'jumlah' => $profileSekolahs->sum(function ($item) {
                    return ($item->ruangKelas?->bagus ?? 0) + ($item->ruangKelas?->rusak ?? 0);
                }),
            ],
            'toilet_siswa' => [
                'bagus' => $profileSekolahs->sum(function ($item) {
                    return $item->toiletSiswa?->bagus ?? 0;
                }),
                'rusak' => $profileSekolahs->sum(function ($item) {
                    return $item->toiletSiswa?->rusak ?? 0;
                }),
                'jumlah' => $profileSekolahs->sum(function ($item) {
                    return ($item->toiletSiswa?->bagus ?? 0) + ($item->toiletSiswa?->rusak ?? 0);
                }),
            ],
            'toilet_guru' => [
                'bagus' => $profileSekolahs->sum(function ($item) {
                    return $item->toiletGuru?->bagus ?? 0;
                }),
                'rusak' => $profileSekolahs->sum(function ($item) {
                    return $item->toiletGuru?->rusak ?? 0;
                }),
                'jumlah' => $profileSekolahs->sum(function ($item) {
                    return ($item->toiletGuru?->bagus ?? 0) + ($item->toiletGuru?->rusak ?? 0);
                }),
            ],
            'perpustakaan_ada' => $profileSekolahs->filter(function ($item) {
                return $item->ruangPerpustakaan?->{'ada/tidak_ada'} == 'ada';
            })->count(),
            'perpustakaan_tidak_ada' => $profileSekolahs->filter(function ($item) {
                return $item->ruangPerpustakaan?->{'ada/tidak_ada'} == 'tidak_ada';
            })->count(),
            'kepala_sekolah_ada' => $profileSekolahs->filter(function ($item) {
                return $item->ruangKepalaSekolah?->{'ada/tidak_ada'} == 'ada';
            })->count(),
            'kepala_sekolah_tidak_ada' => $profileSekolahs->filter(function ($item) {
                return $item->ruangKepalaSekolah?->{'ada/tidak_ada'} == 'tidak_ada';
            })->count(),
            'ruang_guru_ada' => $profileSekolahs->filter(function ($item) {
                return $item->ruangGuru?->{'ada/tidak_ada'} == 'ada';
            })->count(),
            'ruang_guru_tidak_ada' => $profileSekolahs->filter(function ($item) {
                return $item->ruangGuru?->{'ada/tidak_ada'} == 'tidak_ada';
            })->count(),
            'kantor_tu_ada' => $profileSekolahs->filter(function ($item) {
                return $item->ruangKantorTu?->{'ada/tidak_ada'} == 'ada';
            })->count(),
            'kantor_tu_tidak_ada' => $profileSekolahs->filter(function ($item) {
                return $item->ruangKantorTu?->{'ada/tidak_ada'} == 'tidak_ada';
            })->count(),
            'lab_ipa_ada' => $profileSekolahs->filter(function ($item) {
                return $item->labIpa?->{'ada/tidak_ada'} == 'ada';
            })->count(),
            'lab_ipa_tidak_ada' => $profileSekolahs->filter(function ($item) {
                return $item->labIpa?->{'ada/tidak_ada'} == 'tidak_ada';
            })->count(),
            'lab_komputer_ada' => $profileSekolahs->filter(function ($item) {
                return $item->labKomputer?->{'ada/tidak_ada'} == 'ada';
            })->count(),
            'lab_komputer_tidak_ada' => $profileSekolahs->filter(function ($item) {
                return $item->labKomputer?->{'ada/tidak_ada'} == 'tidak_ada';
            })->count(),
            'uks_ada' => $profileSekolahs->filter(function ($item) {
                return $item->unitKesehatanSekolah?->{'ada/tidak_ada'} == 'ada';
            })->count(),
            'uks_tidak_ada' => $profileSekolahs->filter(function ($item) {
                return $item->unitKesehatanSekolah?->{'ada/tidak_ada'} == 'tidak_ada';
            })->count(),
            'rumah_dinas_ada' => $profileSekolahs->filter(function ($item) {
                return $item->rumahDinas?->{'ada/tidak_ada'} == 'ada';
            })->count(),
            'rumah_dinas_tidak_ada' => $profileSekolahs->filter(function ($item) {
                return $item->rumahDinas?->{'ada/tidak_ada'} == 'tidak_ada';
            })->count(),
            'rumah_ibadah_ada' => $profileSekolahs->filter(function ($item) {
                return $item->rumahIbadah?->{'ada/tidak_ada'} == 'ada';
            })->count(),
            'rumah_ibadah_tidak_ada' => $profileSekolahs->filter(function ($item) {
                return $item->rumahIbadah?->{'ada/tidak_ada'} == 'tidak_ada';
            })->count(),
            'lapangan_sekolah_ada' => $profileSekolahs->filter(function ($item) {
                return $item->lapanganSekolah?->{'ada/tidak_ada'} == 'ada';
            })->count(),
            'lapangan_sekolah_tidak_ada' => $profileSekolahs->filter(function ($item) {
                return $item->lapanganSekolah?->{'ada/tidak_ada'} == 'tidak_ada';
            })->count(),
        ];

        $rkbPeriode = PeriodeLaporan::forKategori('rkb');
        $rehabilitasiPeriode = PeriodeLaporan::forKategori('rehabilitasi');

        return view('admin.data.index', compact('profileSekolahs', 'totals', 'rkbPeriode', 'rehabilitasiPeriode'));
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
            'NPSN' => 'required|string|unique:profile_sekolahs,NPSN|max:20',
            'alamat_sekolah' => 'required|string',
            'nama_kepala_sekolah' => 'required|string|max:255',
            'NIP' => 'required|string|unique:profile_sekolahs,NIP|max:20',
            'nomor_hp' => 'required|string|unique:profile_sekolahs,nomor_hp|max:15',

            'pagar_ada_tidak' => 'required|in:ada,tidak_ada',
            'pagar_kondisi' => 'nullable|in:bagus,rusak,nihil',
            'air_ada_tidak' => 'required|in:ada,tidak_ada',
            'air_kondisi' => 'nullable|in:bagus,rusak,nihil',
            'kursi_siswa_bagus' => 'required|integer|min:0',
            'kursi_siswa_rusak' => 'required|integer|min:0',
            'meja_siswa_bagus' => 'required|integer|min:0',
            'meja_siswa_rusak' => 'required|integer|min:0',
            'kursi_guru_bagus' => 'required|integer|min:0',
            'kursi_guru_rusak' => 'required|integer|min:0',
            'meja_guru_bagus' => 'required|integer|min:0',
            'meja_guru_rusak' => 'required|integer|min:0',
            'laptop_bagus' => 'required|integer|min:0',
            'laptop_rusak' => 'required|integer|min:0',
            'komputer_bagus' => 'required|integer|min:0',
            'komputer_rusak' => 'required|integer|min:0',
            'chromebook_bagus' => 'required|integer|min:0',
            'chromebook_rusak' => 'required|integer|min:0',
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
            'ruang_kelas_bagus' => 'required|integer|min:0',
            'ruang_kelas_rusak' => 'required|integer|min:0',
            'toilet_siswa_bagus' => 'required|integer|min:0',
            'toilet_siswa_rusak' => 'required|integer|min:0',
            'toilet_guru_bagus' => 'required|integer|min:0',
            'toilet_guru_rusak' => 'required|integer|min:0',
            'perpustakaan_ada_tidak' => 'required|in:ada,tidak_ada',
            'perpustakaan_kondisi' => 'nullable|in:bagus,rusak,nihil',
            'kepala_sekolah_ada_tidak' => 'required|in:ada,tidak_ada',
            'kepala_sekolah_kondisi' => 'nullable|in:bagus,rusak,nihil',
            'ruang_guru_ada_tidak' => 'required|in:ada,tidak_ada',
            'ruang_guru_kondisi' => 'nullable|in:bagus,rusak,nihil',
            'kantor_tu_ada_tidak' => 'required|in:ada,tidak_ada',
            'kantor_tu_kondisi' => 'nullable|in:bagus,rusak,nihil',
            'lab_ipa_ada_tidak' => 'required|in:ada,tidak_ada',
            'lab_ipa_kondisi' => 'nullable|in:bagus,rusak,nihil',
            'lab_komputer_ada_tidak' => 'required|in:ada,tidak_ada',
            'lab_komputer_kondisi' => 'nullable|in:bagus,rusak,nihil',
            'uks_ada_tidak' => 'required|in:ada,tidak_ada',
            'uks_kondisi' => 'nullable|in:bagus,rusak,nihil',
            'rumah_dinas_ada_tidak' => 'required|in:ada,tidak_ada',
            'rumah_dinas_kondisi' => 'nullable|in:bagus,rusak,nihil',
            'rumah_ibadah_ada_tidak' => 'required|in:ada,tidak_ada',
            'rumah_ibadah_kondisi' => 'nullable|in:bagus,rusak,nihil',
            'lapangan_sekolah_ada_tidak' => 'required|in:ada,tidak_ada',
            'lapangan_sekolah_kondisi' => 'nullable|in:bagus,rusak,nihil',
        ]);

        try {
            // 1. Simpan data sekolah menggunakan Model
            // TAMBAHKAN user_id dari user yang sedang login
            $profileSekolah = ProfileSekolah::create([
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
                'profile_sekolah_id' => $profileSekolah->id,
                'ada/tidak_ada' => $request->pagar_ada_tidak,
                'kodisi' => $request->pagar_kondisi ?? 'nihil',
            ]);

            // 3. Simpan Air Bersih
            AirBersih::create([
                'profile_sekolah_id' => $profileSekolah->id,
                'ada/tidak_ada' => $request->air_ada_tidak,
                'kodisi' => $request->air_kondisi ?? 'nihil',
            ]);

            // 4. Simpan Kursi Siswa
            KursiSiswa::create([
                'profile_sekolah_id' => $profileSekolah->id,
                'bagus' => $request->kursi_siswa_bagus,
                'rusak' => $request->kursi_siswa_rusak,
            ]);

            // 5. Simpan Meja Siswa
            MejaSiswa::create([
                'profile_sekolah_id' => $profileSekolah->id,
                'bagus' => $request->meja_siswa_bagus,
                'rusak' => $request->meja_siswa_rusak,
            ]);

            // 6. Simpan Kursi Guru
            KursiGuru::create([
                'profile_sekolah_id' => $profileSekolah->id,
                'bagus' => $request->kursi_guru_bagus,
                'rusak' => $request->kursi_guru_rusak,
            ]);

            // 7. Simpan Meja Guru
            MejaGuru::create([
                'profile_sekolah_id' => $profileSekolah->id,
                'bagus' => $request->meja_guru_bagus,
                'rusak' => $request->meja_guru_rusak,
            ]);

            // 8. Simpan Laptop
            Laptop::create([
                'profile_sekolah_id' => $profileSekolah->id,
                'bagus' => $request->laptop_bagus,
                'rusak' => $request->laptop_rusak,
            ]);

            // 9. Simpan Komputer
            Komputer::create([
                'profile_sekolah_id' => $profileSekolah->id,
                'bagus' => $request->komputer_bagus,
                'rusak' => $request->komputer_rusak,
            ]);

            Chromebook::create([
                'profile_sekolah_id' => $profileSekolah->id,
                'bagus' => $request->chromebook_bagus,  
                'rusak' => $request->chromebook_rusak,
            ]);

            // Simpan JumlahSiswa
            JumlahSiswa::create([
                'profile_sekolah_id' => $profileSekolah->id,
                'vii' => $request->jumlah_siswa_vii,
                'viii' => $request->jumlah_siswa_viii,
                'ix' => $request->jumlah_siswa_ix,
            ]);

            // Simpan JumlahRombel
            JumlahRombel::create([
                'profile_sekolah_id' => $profileSekolah->id,
                'vii' => $request->jumlah_rombel_vii,
                'viii' => $request->jumlah_rombel_viii,
                'ix' => $request->jumlah_rombel_ix,
            ]);

            // Simpan RuangKelasBaru — tahun sekarang global (PeriodeLaporan),
            // di sini cuma simpan jumlah.
            RuangKelasBaru::create([
                'profile_sekolah_id' => $profileSekolah->id,
                'jumlah' => $request->rkb_jumlah,
            ]);

            // Simpan RehabilitasiRuangKelas
            RehabilitasiRuangKelas::create([
                'profile_sekolah_id' => $profileSekolah->id,
                'jumlah' => $request->rehabilitasi_jumlah,
            ]);

            // Simpan RuangKelas
            RuangKelas::create([
                'profile_sekolah_id' => $profileSekolah->id,
                'bagus' => $request->ruang_kelas_bagus,
                'rusak' => $request->ruang_kelas_rusak,
            ]);

            // Simpan ToiletSiswa
            ToiletSiswa::create([
                'profile_sekolah_id' => $profileSekolah->id,
                'bagus' => $request->toilet_siswa_bagus,
                'rusak' => $request->toilet_siswa_rusak,
            ]);

            // Simpan ToiletGuru
            ToiletGuru::create([
                'profile_sekolah_id' => $profileSekolah->id,
                'bagus' => $request->toilet_guru_bagus,
                'rusak' => $request->toilet_guru_rusak,
            ]);

            // Simpan RuangPerpustakaan
            RuangPerpustakaan::create([
                'profile_sekolah_id' => $profileSekolah->id,
                'ada/tidak_ada' => $request->perpustakaan_ada_tidak,
                'kodisi' => $request->perpustakaan_kondisi ?? 'nihil',
            ]);

            // Simpan RuangKepalaSekolah
            RuangKepalaSekolah::create([
                'profile_sekolah_id' => $profileSekolah->id,
                'ada/tidak_ada' => $request->kepala_sekolah_ada_tidak,
                'kodisi' => $request->kepala_sekolah_kondisi ?? 'nihil',
            ]);

            // Simpan RuangGuru
            RuangGuru::create([
                'profile_sekolah_id' => $profileSekolah->id,
                'ada/tidak_ada' => $request->ruang_guru_ada_tidak,
                'kodisi' => $request->ruang_guru_kondisi ?? 'nihil',
            ]);

            // Simpan RuangKantorTu
            RuangKantorTu::create([
                'profile_sekolah_id' => $profileSekolah->id,
                'ada/tidak_ada' => $request->kantor_tu_ada_tidak,
                'kodisi' => $request->kantor_tu_kondisi ?? 'nihil',
            ]);

            // Simpan LabIpa
            LabIpa::create([
                'profile_sekolah_id' => $profileSekolah->id,
                'ada/tidak_ada' => $request->lab_ipa_ada_tidak,
                'kodisi' => $request->lab_ipa_kondisi ?? 'nihil',
            ]);

            // Simpan LabKomputer
            LabKomputer::create([
                'profile_sekolah_id' => $profileSekolah->id,
                'ada/tidak_ada' => $request->lab_komputer_ada_tidak,
                'kodisi' => $request->lab_komputer_kondisi ?? 'nihil',
            ]);

            // Simpan UnitKesehatanSekolah
            UnitKesehatanSekolah::create([
                'profile_sekolah_id' => $profileSekolah->id,
                'ada/tidak_ada' => $request->uks_ada_tidak,
                'kodisi' => $request->uks_kondisi ?? 'nihil',
            ]);

            // Simpan RumahDinas
            RumahDinas::create([
                'profile_sekolah_id' => $profileSekolah->id,
                'ada/tidak_ada' => $request->rumah_dinas_ada_tidak,
                'kodisi' => $request->rumah_dinas_kondisi ?? 'nihil',
            ]);

            // Simpan RumahIbadah
            RumahIbadah::create([
                'profile_sekolah_id' => $profileSekolah->id,
                'ada/tidak_ada' => $request->rumah_ibadah_ada_tidak,
                'kodisi' => $request->rumah_ibadah_kondisi ?? 'nihil',
            ]);

            // Simpan LapanganSekolah
            LapanganSekolah::create([
                'profile_sekolah_id' => $profileSekolah->id,
                'ada/tidak_ada' => $request->lapangan_sekolah_ada_tidak,
                'kodisi' => $request->lapangan_sekolah_kondisi ?? 'nihil',
            ]);

            return redirect()->route('sarana.index')
                ->with('success', 'Data ProfileSekolah berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal menyimpan data: '.$e->getMessage());
        }
    }

    public function show(ProfileSekolah $profileSekolah)
    {
        $profileSekolah->load([
            'pagarSekolah',
            'airBersih',
            'kursiSiswa',
            'mejaSiswa',
            'kursiGuru',
            'mejaGuru',
            'laptop',
            'komputer',
            'chromebook',
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

        return view('admin.data.show', compact('profileSekolah', 'rkbPeriode', 'rehabilitasiPeriode'));
    }

    public function edit(ProfileSekolah $profileSekolah)
    {
        $profileSekolah->load([
            'pagarSekolah',
            'airBersih',
            'kursiSiswa',
            'mejaSiswa',
            'kursiGuru',
            'mejaGuru',
            'laptop',
            'komputer',
            'chromebook',
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

        return view('admin.data.edit', compact('profileSekolah', 'rkbPeriode', 'rehabilitasiPeriode'));
    }

    public function update(Request $request, ProfileSekolah $profileSekolah)
    {
        $request->validate([
            'nama_sekolah' => 'required|string|max:255',
            'NPSN' => 'required|string|max:20|unique:profile_sekolahs,NPSN,'.$profileSekolah->id,
            'alamat_sekolah' => 'required|string',
            'nama_kepala_sekolah' => 'required|string|max:255',
            'NIP' => 'required|string|max:20|unique:profile_sekolahs,NIP,'.$profileSekolah->id,
            'nomor_hp' => 'required|string|max:15|unique:profile_sekolahs,nomor_hp,'.$profileSekolah->id,

            'pagar_ada_tidak' => 'required|in:ada,tidak_ada',
            'pagar_kondisi' => 'nullable|in:bagus,rusak,nihil',
            'air_ada_tidak' => 'required|in:ada,tidak_ada',
            'air_kondisi' => 'nullable|in:bagus,rusak,nihil',
            'kursi_siswa_bagus' => 'required|integer|min:0',
            'kursi_siswa_rusak' => 'required|integer|min:0',
            'meja_siswa_bagus' => 'required|integer|min:0',
            'meja_siswa_rusak' => 'required|integer|min:0',
            'kursi_guru_bagus' => 'required|integer|min:0',
            'kursi_guru_rusak' => 'required|integer|min:0',
            'meja_guru_bagus' => 'required|integer|min:0',
            'meja_guru_rusak' => 'required|integer|min:0',
            'laptop_bagus' => 'required|integer|min:0',
            'laptop_rusak' => 'required|integer|min:0',
            'komputer_bagus' => 'required|integer|min:0',
            'komputer_rusak' => 'required|integer|min:0',
            'chromebook_bagus' => 'required|integer|min:0',
            'chromebook_rusak' => 'required|integer|min:0',
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
            'ruang_kelas_bagus' => 'required|integer|min:0',
            'ruang_kelas_rusak' => 'required|integer|min:0',
            'toilet_siswa_bagus' => 'required|integer|min:0',
            'toilet_siswa_rusak' => 'required|integer|min:0',
            'toilet_guru_bagus' => 'required|integer|min:0',
            'toilet_guru_rusak' => 'required|integer|min:0',
            'perpustakaan_ada_tidak' => 'required|in:ada,tidak_ada',
            'perpustakaan_kondisi' => 'nullable|in:bagus,rusak,nihil',
            'kepala_sekolah_ada_tidak' => 'required|in:ada,tidak_ada',
            'kepala_sekolah_kondisi' => 'nullable|in:bagus,rusak,nihil',
            'ruang_guru_ada_tidak' => 'required|in:ada,tidak_ada',
            'ruang_guru_kondisi' => 'nullable|in:bagus,rusak,nihil',
            'kantor_tu_ada_tidak' => 'required|in:ada,tidak_ada',
            'kantor_tu_kondisi' => 'nullable|in:bagus,rusak,nihil',
            'lab_ipa_ada_tidak' => 'required|in:ada,tidak_ada',
            'lab_ipa_kondisi' => 'nullable|in:bagus,rusak,nihil',
            'lab_komputer_ada_tidak' => 'required|in:ada,tidak_ada',
            'lab_komputer_kondisi' => 'nullable|in:bagus,rusak,nihil',
            'uks_ada_tidak' => 'required|in:ada,tidak_ada',
            'uks_kondisi' => 'nullable|in:bagus,rusak,nihil',
            'rumah_dinas_ada_tidak' => 'required|in:ada,tidak_ada',
            'rumah_dinas_kondisi' => 'nullable|in:bagus,rusak,nihil',
            'rumah_ibadah_ada_tidak' => 'required|in:ada,tidak_ada',
            'rumah_ibadah_kondisi' => 'nullable|in:bagus,rusak,nihil',
            'lapangan_sekolah_ada_tidak' => 'required|in:ada,tidak_ada',
            'lapangan_sekolah_kondisi' => 'nullable|in:bagus,rusak,nihil',
        ]);

        try {
            // Update data sekolah
            $profileSekolah->update([
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
                ['profile_sekolah_id' => $profileSekolah->id],
                [
                    'ada/tidak_ada' => $request->pagar_ada_tidak,
                    'kodisi' => $request->pagar_kondisi ?? 'nihil',
                ]
            );

            AirBersih::updateOrCreate(
                ['profile_sekolah_id' => $profileSekolah->id],
                [
                    'ada/tidak_ada' => $request->air_ada_tidak,
                    'kodisi' => $request->air_kondisi ?? 'nihil',
                ]
            );

            KursiSiswa::updateOrCreate(
                ['profile_sekolah_id' => $profileSekolah->id],
                [
                    'bagus' => $request->kursi_siswa_bagus,
                    'rusak' => $request->kursi_siswa_rusak,
                ]
            );

            MejaSiswa::updateOrCreate(
                ['profile_sekolah_id' => $profileSekolah->id],
                [
                    'bagus' => $request->meja_siswa_bagus,
                    'rusak' => $request->meja_siswa_rusak,
                ]
            );

            KursiGuru::updateOrCreate(
                ['profile_sekolah_id' => $profileSekolah->id],
                [
                    'bagus' => $request->kursi_guru_bagus,
                    'rusak' => $request->kursi_guru_rusak,
                ]
            );

            MejaGuru::updateOrCreate(
                ['profile_sekolah_id' => $profileSekolah->id],
                [
                    'bagus' => $request->meja_guru_bagus,
                    'rusak' => $request->meja_guru_rusak,
                ]
            );

            Laptop::updateOrCreate(
                ['profile_sekolah_id' => $profileSekolah->id],
                [
                    'bagus' => $request->laptop_bagus,
                    'rusak' => $request->laptop_rusak,
                ]
            );

            Chromebook::updateOrCreate(
                ['profile_sekolah_id' => $profileSekolah->id],
                [
                    'bagus' => $request->chromebook_bagus,
                    'rusak' => $request->chromebook_rusak,
                ]
            );

            Komputer::updateOrCreate(
                ['profile_sekolah_id' => $profileSekolah->id],
                [
                    'bagus' => $request->komputer_bagus,
                    'rusak' => $request->komputer_rusak,
                ]
            );

            JumlahSiswa::updateOrCreate(
                ['profile_sekolah_id' => $profileSekolah->id],
                [
                    'vii' => $request->jumlah_siswa_vii,
                    'viii' => $request->jumlah_siswa_viii,
                    'ix' => $request->jumlah_siswa_ix,
                ]
            );

            JumlahRombel::updateOrCreate(
                ['profile_sekolah_id' => $profileSekolah->id],
                [
                    'vii' => $request->jumlah_rombel_vii,
                    'viii' => $request->jumlah_rombel_viii,
                    'ix' => $request->jumlah_rombel_ix,
                ]
            );

            // RKB & Rehabilitasi: tahun sekarang global (PeriodeLaporan),
            // di sini cuma update jumlah.
            RuangKelasBaru::updateOrCreate(
                ['profile_sekolah_id' => $profileSekolah->id],
                ['jumlah' => $request->rkb_jumlah]
            );

            RehabilitasiRuangKelas::updateOrCreate(
                ['profile_sekolah_id' => $profileSekolah->id],
                ['jumlah' => $request->rehabilitasi_jumlah]
            );

            RuangKelas::updateOrCreate(
                ['profile_sekolah_id' => $profileSekolah->id],
                [
                    'bagus' => $request->ruang_kelas_bagus,
                    'rusak' => $request->ruang_kelas_rusak,
                ]
            );

            ToiletSiswa::updateOrCreate(
                ['profile_sekolah_id' => $profileSekolah->id],
                [
                    'bagus' => $request->toilet_siswa_bagus,
                    'rusak' => $request->toilet_siswa_rusak,
                ]
            );

            ToiletGuru::updateOrCreate(
                ['profile_sekolah_id' => $profileSekolah->id],
                [
                    'bagus' => $request->toilet_guru_bagus,
                    'rusak' => $request->toilet_guru_rusak,
                ]
            );

            RuangPerpustakaan::updateOrCreate(
                ['profile_sekolah_id' => $profileSekolah->id],
                [
                    'ada/tidak_ada' => $request->perpustakaan_ada_tidak,
                    'kodisi' => $request->perpustakaan_kondisi ?? 'nihil',
                ]
            );

            RuangKepalaSekolah::updateOrCreate(
                ['profile_sekolah_id' => $profileSekolah->id],
                [
                    'ada/tidak_ada' => $request->kepala_sekolah_ada_tidak,
                    'kodisi' => $request->kepala_sekolah_kondisi ?? 'nihil',
                ]
            );

            RuangGuru::updateOrCreate(
                ['profile_sekolah_id' => $profileSekolah->id],
                [
                    'ada/tidak_ada' => $request->ruang_guru_ada_tidak,
                    'kodisi' => $request->ruang_guru_kondisi ?? 'nihil',
                ]
            );

            RuangKantorTu::updateOrCreate(
                ['profile_sekolah_id' => $profileSekolah->id],
                [
                    'ada/tidak_ada' => $request->kantor_tu_ada_tidak,
                    'kodisi' => $request->kantor_tu_kondisi ?? 'nihil',
                ]
            );

            LabIpa::updateOrCreate(
                ['profile_sekolah_id' => $profileSekolah->id],
                [
                    'ada/tidak_ada' => $request->lab_ipa_ada_tidak,
                    'kodisi' => $request->lab_ipa_kondisi ?? 'nihil',
                ]
            );

            LabKomputer::updateOrCreate(
                ['profile_sekolah_id' => $profileSekolah->id],
                [
                    'ada/tidak_ada' => $request->lab_komputer_ada_tidak,
                    'kodisi' => $request->lab_komputer_kondisi ?? 'nihil',
                ]
            );

            UnitKesehatanSekolah::updateOrCreate(
                ['profile_sekolah_id' => $profileSekolah->id],
                [
                    'ada/tidak_ada' => $request->uks_ada_tidak,
                    'kodisi' => $request->uks_kondisi ?? 'nihil',
                ]
            );

            RumahDinas::updateOrCreate(
                ['profile_sekolah_id' => $profileSekolah->id],
                [
                    'ada/tidak_ada' => $request->rumah_dinas_ada_tidak,
                    'kodisi' => $request->rumah_dinas_kondisi ?? 'nihil',
                ]
            );

            RumahIbadah::updateOrCreate(
                ['profile_sekolah_id' => $profileSekolah->id],
                [
                    'ada/tidak_ada' => $request->rumah_ibadah_ada_tidak,
                    'kodisi' => $request->rumah_ibadah_kondisi ?? 'nihil',
                ]
            );

            LapanganSekolah::updateOrCreate(
                ['profile_sekolah_id' => $profileSekolah->id],
                [
                    'ada/tidak_ada' => $request->lapangan_sekolah_ada_tidak,
                    'kodisi' => $request->lapangan_sekolah_kondisi ?? 'nihil',
                ]
            );

            return redirect()->route('sarana.index')
                ->with('success', 'Data ProfileSekolah berhasil diupdate!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal mengupdate data: '.$e->getMessage());
        }
    }

    public function destroy(ProfileSekolah $profileSekolah)
    {
        try {
            // Hapus semua relasi
            $profileSekolah->pagarSekolah()->delete();
            $profileSekolah->airBersih()->delete();
            $profileSekolah->kursiSiswa()->delete();
            $profileSekolah->mejaSiswa()->delete();
            $profileSekolah->kursiGuru()->delete();
            $profileSekolah->mejaGuru()->delete();
            $profileSekolah->laptop()->delete();
            $profileSekolah->komputer()->delete();
            $profileSekolah->chromebook()->delete();
            $profileSekolah->jumlahSiswa()->delete();
            $profileSekolah->jumlahRombel()->delete();
            $profileSekolah->ruangKelasBaru()->delete();
            $profileSekolah->rehabilitasiRuangKelas()->delete();
            $profileSekolah->ruangKelas()->delete();
            $profileSekolah->toiletSiswa()->delete();
            $profileSekolah->toiletGuru()->delete();
            $profileSekolah->ruangPerpustakaan()->delete();
            $profileSekolah->ruangKepalaSekolah()->delete();
            $profileSekolah->ruangGuru()->delete();
            $profileSekolah->ruangKantorTu()->delete();
            $profileSekolah->labIpa()->delete();
            $profileSekolah->labKomputer()->delete();
            $profileSekolah->unitKesehatanSekolah()->delete();
            $profileSekolah->rumahDinas()->delete();
            $profileSekolah->rumahIbadah()->delete();
            $profileSekolah->lapanganSekolah()->delete();

            // Hapus data utama
            $profileSekolah->delete();

            return redirect()->route('sarana.index')
                ->with('success', 'Data ProfileSekolah berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menghapus data: '.$e->getMessage());
        }
    }

    public function export_excel(Request $request)
    {
        try {
            $fileName = 'data_ProfileSekolah_sekolah - '.Carbon::now()->format('Y-m-d_His').'.xlsx';

            return Excel::download(new ExportData, $fileName);
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal mengexport data: '.$e->getMessage());
        }
    }
}