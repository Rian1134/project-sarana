<?php

namespace App\Http\Controllers\User;

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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class DataController extends Controller
{
    public function index()
    {
        $profileSekolah = ProfileSekolah::with([
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
        ])->where('user_id', Auth::id())->first();

        $rkbPeriode = PeriodeLaporan::forKategori('rkb');
        $rehabilitasiPeriode = PeriodeLaporan::forKategori('rehabilitasi');

        return view('user.data.index', compact('profileSekolah', 'rkbPeriode', 'rehabilitasiPeriode'));
    }

    public function create()
    {
        if (ProfileSekolah::where('user_id', Auth::id())->exists()) {
            return redirect()->route('user.data.index')
                ->with('error', 'Anda sudah memiliki data. Maksimal 1 data per user.');
        }

        $rkbPeriode = PeriodeLaporan::forKategori('rkb');
        $rehabilitasiPeriode = PeriodeLaporan::forKategori('rehabilitasi');

        return view('user.data.create', compact('rkbPeriode', 'rehabilitasiPeriode'));
    }

    public function store(Request $request)
    {
        if (ProfileSekolah::where('user_id', Auth::id())->exists()) {
            return redirect()->route('user.data.index')
                ->with('error', 'Anda sudah memiliki data. Maksimal 1 data per user.');
        }

        $validator = Validator::make($request->all(), [
            'nama_sekolah' => 'required|string|max:255',
            'NPSN' => 'required|string|unique:profile_sekolahs,NPSN|max:20',
            'alamat_sekolah' => 'required|string',
            'nama_kepala_sekolah' => 'required|string|max:255',
            'NIP' => 'required|string|unique:profile_sekolahs,NIP|max:20',
            'nomor_hp' => 'required|string|unique:profile_sekolahs,nomor_hp|max:15',
            'status_sekolah' => 'required|in:negeri,swasta',
            'akreditasi' => 'required|in:A,B,C,belum_terakreditasi',

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

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $profileSekolah = ProfileSekolah::create([
                'nama_sekolah' => $request->nama_sekolah,
                'NPSN' => $request->NPSN,
                'alamat_sekolah' => $request->alamat_sekolah,
                'nama_kepala_sekolah' => $request->nama_kepala_sekolah,
                'NIP' => $request->NIP,
                'nomor_hp' => $request->nomor_hp,
                'status_sekolah' => $request->status_sekolah,
                'akreditasi' => $request->akreditasi,
                'user_id' => Auth::id(),
            ]);

            PagarSekolah::create([
                'profile_sekolah_id' => $profileSekolah->id,
                'ada/tidak_ada' => $request->pagar_ada_tidak,
                'kodisi' => $request->pagar_kondisi ?? 'nihil',
            ]);

            AirBersih::create([
                'profile_sekolah_id' => $profileSekolah->id,
                'ada/tidak_ada' => $request->air_ada_tidak,
                'kodisi' => $request->air_kondisi ?? 'nihil',
            ]);

            KursiSiswa::create([
                'profile_sekolah_id' => $profileSekolah->id,
                'bagus' => $request->kursi_siswa_bagus,
                'rusak' => $request->kursi_siswa_rusak,
            ]);

            MejaSiswa::create([
                'profile_sekolah_id' => $profileSekolah->id,
                'bagus' => $request->meja_siswa_bagus,
                'rusak' => $request->meja_siswa_rusak,
            ]);

            KursiGuru::create([
                'profile_sekolah_id' => $profileSekolah->id,
                'bagus' => $request->kursi_guru_bagus,
                'rusak' => $request->kursi_guru_rusak,
            ]);

            MejaGuru::create([
                'profile_sekolah_id' => $profileSekolah->id,
                'bagus' => $request->meja_guru_bagus,
                'rusak' => $request->meja_guru_rusak,
            ]);

            Laptop::create([
                'profile_sekolah_id' => $profileSekolah->id,
                'bagus' => $request->laptop_bagus,
                'rusak' => $request->laptop_rusak,
            ]);

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

            JumlahSiswa::create([
                'profile_sekolah_id' => $profileSekolah->id,
                'vii' => $request->jumlah_siswa_vii,
                'viii' => $request->jumlah_siswa_viii,
                'ix' => $request->jumlah_siswa_ix,
            ]);

            JumlahRombel::create([
                'profile_sekolah_id' => $profileSekolah->id,
                'vii' => $request->jumlah_rombel_vii,
                'viii' => $request->jumlah_rombel_viii,
                'ix' => $request->jumlah_rombel_ix,
            ]);

            RuangKelasBaru::create([
                'profile_sekolah_id' => $profileSekolah->id,
                'jumlah' => $request->rkb_jumlah,
            ]);

            RehabilitasiRuangKelas::create([
                'profile_sekolah_id' => $profileSekolah->id,
                'jumlah' => $request->rehabilitasi_jumlah,
            ]);

            RuangKelas::create([
                'profile_sekolah_id' => $profileSekolah->id,
                'bagus' => $request->ruang_kelas_bagus,
                'rusak' => $request->ruang_kelas_rusak,
            ]);

            ToiletSiswa::create([
                'profile_sekolah_id' => $profileSekolah->id,
                'bagus' => $request->toilet_siswa_bagus,
                'rusak' => $request->toilet_siswa_rusak,
            ]);

            ToiletGuru::create([
                'profile_sekolah_id' => $profileSekolah->id,
                'bagus' => $request->toilet_guru_bagus,
                'rusak' => $request->toilet_guru_rusak,
            ]);

            RuangPerpustakaan::create([
                'profile_sekolah_id' => $profileSekolah->id,
                'ada/tidak_ada' => $request->perpustakaan_ada_tidak,
                'kodisi' => $request->perpustakaan_kondisi ?? 'nihil',
            ]);

            RuangKepalaSekolah::create([
                'profile_sekolah_id' => $profileSekolah->id,
                'ada/tidak_ada' => $request->kepala_sekolah_ada_tidak,
                'kodisi' => $request->kepala_sekolah_kondisi ?? 'nihil',
            ]);

            RuangGuru::create([
                'profile_sekolah_id' => $profileSekolah->id,
                'ada/tidak_ada' => $request->ruang_guru_ada_tidak,
                'kodisi' => $request->ruang_guru_kondisi ?? 'nihil',
            ]);

            RuangKantorTu::create([
                'profile_sekolah_id' => $profileSekolah->id,
                'ada/tidak_ada' => $request->kantor_tu_ada_tidak,
                'kodisi' => $request->kantor_tu_kondisi ?? 'nihil',
            ]);

            LabIpa::create([
                'profile_sekolah_id' => $profileSekolah->id,
                'ada/tidak_ada' => $request->lab_ipa_ada_tidak,
                'kodisi' => $request->lab_ipa_kondisi ?? 'nihil',
            ]);

            LabKomputer::create([
                'profile_sekolah_id' => $profileSekolah->id,
                'ada/tidak_ada' => $request->lab_komputer_ada_tidak,
                'kodisi' => $request->lab_komputer_kondisi ?? 'nihil',
            ]);

            UnitKesehatanSekolah::create([
                'profile_sekolah_id' => $profileSekolah->id,
                'ada/tidak_ada' => $request->uks_ada_tidak,
                'kodisi' => $request->uks_kondisi ?? 'nihil',
            ]);

            RumahDinas::create([
                'profile_sekolah_id' => $profileSekolah->id,
                'ada/tidak_ada' => $request->rumah_dinas_ada_tidak,
                'kodisi' => $request->rumah_dinas_kondisi ?? 'nihil',
            ]);

            RumahIbadah::create([
                'profile_sekolah_id' => $profileSekolah->id,
                'ada/tidak_ada' => $request->rumah_ibadah_ada_tidak,
                'kodisi' => $request->rumah_ibadah_kondisi ?? 'nihil',
            ]);

            LapanganSekolah::create([
                'profile_sekolah_id' => $profileSekolah->id,
                'ada/tidak_ada' => $request->lapangan_sekolah_ada_tidak,
                'kodisi' => $request->lapangan_sekolah_kondisi ?? 'nihil',
            ]);

            return redirect()->route('user.data.index')
                ->with('success', 'Data Sarana berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }

    public function show(ProfileSekolah $profileSekolah)
    {
        if ($profileSekolah->user_id !== Auth::id()) {
            return redirect()->route('user.data.index')
                ->with('error', 'Anda tidak memiliki akses untuk melihat data ini.');
        }

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

        return view('user.data.show', compact('profileSekolah', 'rkbPeriode', 'rehabilitasiPeriode'));
    }

    public function edit(ProfileSekolah $profileSekolah)
    {
        if ($profileSekolah->user_id !== Auth::id()) {
            return redirect()->route('user.data.index')
                ->with('error', 'Anda tidak memiliki akses untuk mengedit data ini.');
        }

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

        return view('user.data.edit', compact('profileSekolah', 'rkbPeriode', 'rehabilitasiPeriode'));
    }

    public function update(Request $request, ProfileSekolah $profileSekolah)
    {
        if ($profileSekolah->user_id !== Auth::id()) {
            return redirect()->route('user.data.index')
                ->with('error', 'Anda tidak memiliki akses untuk mengupdate data ini.');
        }

        $validator = Validator::make($request->all(), [
            'nama_sekolah' => 'required|string|max:255',
            'NPSN' => 'required|string|max:20|unique:profile_sekolahs,NPSN,' . $profileSekolah->id,
            'alamat_sekolah' => 'required|string',
            'nama_kepala_sekolah' => 'required|string|max:255',
            'NIP' => 'required|string|max:20|unique:profile_sekolahs,NIP,' . $profileSekolah->id,
            'nomor_hp' => 'required|string|max:15|unique:profile_sekolahs,nomor_hp,' . $profileSekolah->id,
            'status_sekolah' => 'required|in:negeri,swasta',
            'akreditasi' => 'required|in:A,B,C,belum_terakreditasi',

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

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $profileSekolah->update([
                'nama_sekolah' => $request->nama_sekolah,
                'NPSN' => $request->NPSN,
                'alamat_sekolah' => $request->alamat_sekolah,
                'nama_kepala_sekolah' => $request->nama_kepala_sekolah,
                'NIP' => $request->NIP,
                'nomor_hp' => $request->nomor_hp,
                'status_sekolah' => $request->status_sekolah,
                'akreditasi' => $request->akreditasi,
            ]);

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

            Komputer::updateOrCreate(
                ['profile_sekolah_id' => $profileSekolah->id],
                [
                    'bagus' => $request->komputer_bagus,
                    'rusak' => $request->komputer_rusak,
                ]
            );

            Chromebook::updateOrCreate(
                ['profile_sekolah_id' => $profileSekolah->id],
                [
                    'bagus' => $request->chromebook_bagus,
                    'rusak' => $request->chromebook_rusak,
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

            return redirect()->route('user.data.index')
                ->with('success', 'Data Sarana berhasil diupdate!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal mengupdate data: ' . $e->getMessage());
        }
    }

    public function destroy(ProfileSekolah $profileSekolah)
    {
        if ($profileSekolah->user_id !== Auth::id()) {
            return redirect()->route('user.data.index')
                ->with('error', 'Anda tidak memiliki akses untuk menghapus data ini.');
        }

        try {
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

            $profileSekolah->delete();

            return redirect()->route('user.data.index')
                ->with('success', 'Data Sarana berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }
}