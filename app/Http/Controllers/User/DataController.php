<?php

namespace App\Http\Controllers\User;

namespace App\Http\Controllers\User;

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
use App\Models\PeriodeLaporan; // <-- TAMBAHKAN INI
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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DataController extends Controller
{
    public function index()
    {
        // Ambil data user yang sedang login (max 1 data per user)
        $sarana = Sarana::with([
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
        ])->where('user_id', Auth::id())->first();

        // dd(Auth::user());

        return view('user.data.index', compact('sarana'));
    }

    public function create()
    {
        // Cek apakah user sudah punya data
        if (Sarana::where('user_id', Auth::id())->exists()) {
            return redirect()->route('user.data.index')
                ->with('error', 'Anda sudah memiliki data. Tidak dapat membuat data baru karena maksimal 1 data per user.');
        }

        // Ambil periode dari database
        $rkbPeriode = PeriodeLaporan::forKategori('rkb');
        $rehabilitasiPeriode = PeriodeLaporan::forKategori('rehabilitasi');

        return view('user.data.create', compact('rkbPeriode', 'rehabilitasiPeriode'));
    }

    public function store(Request $request)
    {
        // Cek apakah user sudah punya data
        if (Sarana::where('user_id', Auth::id())->exists()) {
            return redirect()->route('user.data.index')
                ->with('error', 'Anda sudah memiliki data. Tidak dapat membuat data baru.');
        }

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
            // Simpan data sekolah dengan user_id dari user yang sedang login
            $sarana = Sarana::create([
                'nama_sekolah' => $request->nama_sekolah,
                'NPSN' => $request->NPSN,
                'alamat_sekolah' => $request->alamat_sekolah,
                'nama_kepala_sekolah' => $request->nama_kepala_sekolah,
                'NIP' => $request->NIP,
                'nomor_hp' => $request->nomor_hp,
                'user_id' => Auth::id(),
            ]);

            // 1. Simpan Pagar Sekolah
            PagarSekolah::create([
                'sarana_id' => $sarana->id,
                'ada/tidak_ada' => $request->pagar_ada_tidak,
                'kodisi' => $request->pagar_kondisi ?? 'nihil',
            ]);

            // 2. Simpan Air Bersih
            AirBersih::create([
                'sarana_id' => $sarana->id,
                'ada/tidak_ada' => $request->air_ada_tidak,
                'kodisi' => $request->air_kondisi ?? 'nihil',
            ]);

            // 3. Simpan Kursi Siswa
            KursiSiswa::create([
                'sarana_id' => $sarana->id,
                'baik' => $request->kursi_siswa_baik,
                'rusak' => $request->kursi_siswa_rusak,
            ]);

            // 4. Simpan Meja Siswa
            MejaSiswa::create([
                'sarana_id' => $sarana->id,
                'baik' => $request->meja_siswa_baik,
                'rusak' => $request->meja_siswa_rusak,
            ]);

            // 5. Simpan Kursi Guru
            KursiGuru::create([
                'sarana_id' => $sarana->id,
                'baik' => $request->kursi_guru_baik,
                'rusak' => $request->kursi_guru_rusak,
            ]);

            // 6. Simpan Meja Guru
            MejaGuru::create([
                'sarana_id' => $sarana->id,
                'baik' => $request->meja_guru_baik,
                'rusak' => $request->meja_guru_rusak,
            ]);

            // 7. Simpan Laptop
            Laptop::create([
                'sarana_id' => $sarana->id,
                'baik' => $request->laptop_baik,
                'rusak' => $request->laptop_rusak,
            ]);

            // 8. Simpan Komputer
            Komputer::create([
                'sarana_id' => $sarana->id,
                'baik' => $request->komputer_baik,
                'rusak' => $request->komputer_rusak,
            ]);

            // 9. Simpan Jumlah Siswa
            JumlahSiswa::create([
                'sarana_id' => $sarana->id,
                'vii' => $request->jumlah_siswa_vii,
                'viii' => $request->jumlah_siswa_viii,
                'ix' => $request->jumlah_siswa_ix,
            ]);

            // 10. Simpan Jumlah Rombel
            JumlahRombel::create([
                'sarana_id' => $sarana->id,
                'vii' => $request->jumlah_rombel_vii,
                'viii' => $request->jumlah_rombel_viii,
                'ix' => $request->jumlah_rombel_ix,
            ]);

            // 11. Simpan Ruang Kelas Baru
            RuangKelasBaru::create([
                'sarana_id' => $sarana->id,
                'jumlah' => $request->rkb_jumlah,
            ]);

            // 12. Simpan Rehabilitasi Ruang Kelas
            RehabilitasiRuangKelas::create([
                'sarana_id' => $sarana->id,
                'jumlah' => $request->rehabilitasi_jumlah,
            ]);

            // 13. Simpan Ruang Kelas
            RuangKelas::create([
                'sarana_id' => $sarana->id,
                'baik' => $request->ruang_kelas_baik,
                'rusak' => $request->ruang_kelas_rusak,
            ]);

            // 14. Simpan Toilet Siswa
            ToiletSiswa::create([
                'sarana_id' => $sarana->id,
                'baik' => $request->toilet_siswa_baik,
                'rusak' => $request->toilet_siswa_rusak,
            ]);

            // 15. Simpan Toilet Guru
            ToiletGuru::create([
                'sarana_id' => $sarana->id,
                'baik' => $request->toilet_guru_baik,
                'rusak' => $request->toilet_guru_rusak,
            ]);

            // 16. Simpan Ruang Perpustakaan
            RuangPerpustakaan::create([
                'sarana_id' => $sarana->id,
                'ada/tidak_ada' => $request->perpustakaan_ada_tidak,
                'kodisi' => $request->perpustakaan_kondisi ?? 'nihil',
            ]);

            // 17. Simpan Ruang Kepala Sekolah
            RuangKepalaSekolah::create([
                'sarana_id' => $sarana->id,
                'ada/tidak_ada' => $request->kepala_sekolah_ada_tidak,
                'kodisi' => $request->kepala_sekolah_kondisi ?? 'nihil',
            ]);

            // 18. Simpan Ruang Guru
            RuangGuru::create([
                'sarana_id' => $sarana->id,
                'ada/tidak_ada' => $request->ruang_guru_ada_tidak,
                'kodisi' => $request->ruang_guru_kondisi ?? 'nihil',
            ]);

            // 19. Simpan Ruang Kantor TU
            RuangKantorTu::create([
                'sarana_id' => $sarana->id,
                'ada/tidak_ada' => $request->kantor_tu_ada_tidak,
                'kodisi' => $request->kantor_tu_kondisi ?? 'nihil',
            ]);

            // 20. Simpan Lab IPA
            LabIpa::create([
                'sarana_id' => $sarana->id,
                'ada/tidak_ada' => $request->lab_ipa_ada_tidak,
                'kodisi' => $request->lab_ipa_kondisi ?? 'nihil',
            ]);

            // 21. Simpan Lab Komputer
            LabKomputer::create([
                'sarana_id' => $sarana->id,
                'ada/tidak_ada' => $request->lab_komputer_ada_tidak,
                'kodisi' => $request->lab_komputer_kondisi ?? 'nihil',
            ]);

            // 22. Simpan UKS
            UnitKesehatanSekolah::create([
                'sarana_id' => $sarana->id,
                'ada/tidak_ada' => $request->uks_ada_tidak,
                'kodisi' => $request->uks_kondisi ?? 'nihil',
            ]);

            // 23. Simpan Rumah Dinas
            RumahDinas::create([
                'sarana_id' => $sarana->id,
                'ada/tidak_ada' => $request->rumah_dinas_ada_tidak,
                'kodisi' => $request->rumah_dinas_kondisi ?? 'nihil',
            ]);

            // 24. Simpan Rumah Ibadah
            RumahIbadah::create([
                'sarana_id' => $sarana->id,
                'ada/tidak_ada' => $request->rumah_ibadah_ada_tidak,
                'kodisi' => $request->rumah_ibadah_kondisi ?? 'nihil',
            ]);

            // 25. Simpan Lapangan Sekolah
            LapanganSekolah::create([
                'sarana_id' => $sarana->id,
                'ada/tidak_ada' => $request->lapangan_sekolah_ada_tidak,
                'kodisi' => $request->lapangan_sekolah_kondisi ?? 'nihil',
            ]);

            return redirect()->route('user.data.index')
                ->with('success', 'Data Sarana berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal menyimpan data: '.$e->getMessage());
        }
    }

    public function edit(Sarana $sarana)
    {
        if ($sarana->user_id !== Auth::id()) {
            return redirect()->route('user.data.index')
                ->with('error', 'Anda tidak memiliki akses untuk mengedit data ini.');
        }

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

        // Ambil periode dari database
        $rkbPeriode = PeriodeLaporan::forKategori('rkb');
        $rehabilitasiPeriode = PeriodeLaporan::forKategori('rehabilitasi');

        return view('user.data.edit', compact('sarana', 'rkbPeriode', 'rehabilitasiPeriode'));
    }

    public function update(Request $request, Sarana $sarana)
    {
        // User hanya bisa update data miliknya sendiri
        if ($sarana->user_id !== Auth::id()) {
            return redirect()->route('user.data.index')
                ->with('error', 'Anda tidak memiliki akses untuk mengupdate data ini.');
        }

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

            RuangKelasBaru::updateOrCreate(
                ['sarana_id' => $sarana->id],
                [
                    'jumlah' => $request->rkb_jumlah,
                ]
            );

            RehabilitasiRuangKelas::updateOrCreate(
                ['sarana_id' => $sarana->id],
                [
                    'jumlah' => $request->rehabilitasi_jumlah,
                ]
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

            return redirect()->route('user.data.index')
                ->with('success', 'Data Sarana berhasil diupdate!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal mengupdate data: '.$e->getMessage());
        }
    }

    public function destroy(Sarana $sarana)
    {
        // User hanya bisa menghapus data miliknya sendiri
        if ($sarana->user_id !== Auth::id()) {
            return redirect()->route('user.data.index')
                ->with('error', 'Anda tidak memiliki akses untuk menghapus data ini.');
        }

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

            return redirect()->route('user.data.index')
                ->with('success', 'Data Sarana berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menghapus data: '.$e->getMessage());
        }
    }
}
