<?php

namespace Database\Seeders;

use App\Models\ProfileSekolah;
use App\Models\JumlahSiswa;
use App\Models\JumlahRombel;
use App\Models\RuangKelasBaru;
use App\Models\RehabilitasiRuangKelas;
use App\Models\RuangKelas;
use App\Models\ToiletSiswa;
use App\Models\ToiletGuru;
use App\Models\RuangPerpustakaan;
use App\Models\RuangKepalaSekolah;
use App\Models\RuangGuru;
use App\Models\RuangKantorTu;
use App\Models\LabIpa;
use App\Models\LabKomputer;
use App\Models\UnitKesehatanSekolah;
use App\Models\RumahDinas;
use App\Models\RumahIbadah;
use App\Models\LapanganSekolah;
use App\Models\PagarSekolah;
use App\Models\AirBersih;
use App\Models\KursiSiswa;
use App\Models\KursiGuru;
use App\Models\MejaSiswa;
use App\Models\MejaGuru;
use App\Models\Laptop;
use App\Models\Komputer;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'email_verified_at' => Carbon::now(),
            'password' => bcrypt('12345678'),
        ]);

        $admin->assignRole('admin');

        $user = User::create([
            'name' => 'User',
            'email' => 'user@gmail.com',
            'email_verified_at' => Carbon::now(),
            'password' => bcrypt('12345678'),
        ]);

        $user->assignRole('user');

        $data = [
            'nama_sekolah' => 'SMP Negeri 1 Mars',
            'NPSN' => '20100031',
            'alamat_sekolah' => 'Jl. Melati No. 10, Jakarta',
            'nama_kepala_sekolah' => 'Dr. Ahmad Fauzi, M.Pd.',
            'NIP' => '196512198803001',
            'nomor_hp' => '081234567890',
            'akreditasi' => 'A',
            'status_sekolah' => 'Negeri',
            'user_id' => $user->id,

            'jumlah_guru' => [
                'vii' => 120,
                'viii' => 110,
                'ix' => 100,
            ],

            'jumlah_siswa' => [
                'vii' => 120,
                'viii' => 110,
                'ix' => 100,
            ],
            'jumlah_rombel' => [
                'vii' => 4,
                'viii' => 4,
                'ix' => 4,
            ],
            'ruang_kelas_baru' => 2,
            'rehabilitasi_ruang_kelas' => 1,
            'ruang_kelas' => [
                'baik' => 10,
                'rusak' => 2,
            ],
            'toilet_siswa' => [
                'baik' => 6,
                'rusak' => 1,
            ],
            'toilet_guru' => [
                'baik' => 2,
                'rusak' => 0,
           ],
            'ruang_perpustakaan' => [
                'ada/tidak_ada' => 'ada',
                'kondisi' => 'baik',
            ],
            'ruang_kepala_sekolah' => [
                'ada/tidak_ada' => 'ada',
                'kondisi' => 'baik',
            ],
            'ruang_guru' => [
                'ada/tidak_ada' => 'ada',
                'kondisi' => 'baik',
            ],
            'ruang_kantor_tu' => [
                'ada/tidak_ada' => 'ada',
                'kondisi' => 'baik',
            ],
            'lab_ipa' => [
                'ada/tidak_ada' => 'ada',
                'kondisi' => 'baik',
            ],
            'lab_komputer' => [
                'ada/tidak_ada' => 'ada',
                'kondisi' => 'baik',
            ],
            'uks' => [
                'ada/tidak_ada' => 'ada',
                'kondisi' => 'baik',
            ],
            'rumah_dinas' => [
                'ada/tidak_ada' => 'ada',
                'kondisi' => 'baik',
            ],
            'rumah_ibadah' => [
                'ada/tidak_ada' => 'ada',
                'kondisi' => 'baik',
            ],
            'lapangan_sekolah' => [
                'ada/tidak_ada' => 'ada',
                'kondisi' => 'baik',
            ],
            'pagar_sekolah' => [
                'ada/tidak_ada' => 'ada',
                'kondisi' => 'baik',
            ],
            'air_bersih' => [
                'ada/tidak_ada' => 'ada',
                'kondisi' => 'baik',
            ],
            'kursi_siswa' => [
                'baik' => 300,
                'rusak' => 15,
            ],
            'meja_siswa' => [
                'baik' => 120,
                'rusak' => 8,
            ],
            'kursi_guru' => [
                'baik' => 35,
                'rusak' => 3,
            ],
            'meja_guru' => [
                'baik' => 25,
                'rusak' => 2,
            ],
            'laptop' => [
                'baik' => 12,
                'rusak' => 1,
            ],
            'komputer' => [
                'baik' => 20,
                'rusak' => 2,
            ],
        ];

        // 1. Create ProfileSekolah
        $profileSekolah = ProfileSekolah::create([
            'nama_sekolah' => $data['nama_sekolah'],
            'NPSN' => $data['NPSN'],
            'alamat_sekolah' => $data['alamat_sekolah'],
            'nama_kepala_sekolah' => $data['nama_kepala_sekolah'],
            'NIP' => $data['NIP'],
            'nomor_hp' => $data['nomor_hp'],
            'akreditasi' => $data['akreditasi'],
            'status_sekolah' => $data['status_sekolah'],
            'user_id' => $data['user_id'],
        ]);

        // 2. Jumlah Siswa
        JumlahSiswa::create([
            'profile_sekolah_id' => $profileSekolah->id,
            'vii' => $data['jumlah_siswa']['vii'],
            'viii' => $data['jumlah_siswa']['viii'],
            'ix' => $data['jumlah_siswa']['ix'],
        ]);

        // 3. Jumlah Rombel
        JumlahRombel::create([
            'profile_sekolah_id' => $profileSekolah->id,
            'vii' => $data['jumlah_rombel']['vii'],
            'viii' => $data['jumlah_rombel']['viii'],
            'ix' => $data['jumlah_rombel']['ix'],
        ]);

        // 4. Ruang Kelas Baru
        RuangKelasBaru::create([
            'profile_sekolah_id' => $profileSekolah->id,
            'jumlah' => $data['ruang_kelas_baru'],
        ]);

        // 5. Rehabilitasi Ruang Kelas
        RehabilitasiRuangKelas::create([
            'profile_sekolah_id' => $profileSekolah->id,
            'jumlah' => $data['rehabilitasi_ruang_kelas'],
        ]);

        // 6. Ruang Kelas
        RuangKelas::create([
            'profile_sekolah_id' => $profileSekolah->id,
            'baik' => $data['ruang_kelas']['baik'],
            'rusak' => $data['ruang_kelas']['rusak'],
        ]);

        // 7. Toilet Siswa
        ToiletSiswa::create([
            'profile_sekolah_id' => $profileSekolah->id,
            'baik' => $data['toilet_siswa']['baik'],
            'rusak' => $data['toilet_siswa']['rusak'],
        ]);

        // 8. Toilet Guru
        ToiletGuru::create([
            'profile_sekolah_id' => $profileSekolah->id,
            'baik' => $data['toilet_guru']['baik'],
            'rusak' => $data['toilet_guru']['rusak'],
        ]);

        // 9. Ruang Perpustakaan
        RuangPerpustakaan::create([
            'profile_sekolah_id' => $profileSekolah->id,
            'ada/tidak_ada' => $data['ruang_perpustakaan']['ada/tidak_ada'],
            'kondisi' => $data['ruang_perpustakaan']['kondisi'],
        ]);

        // 10. Ruang Kepala Sekolah
        RuangKepalaSekolah::create([
            'profile_sekolah_id' => $profileSekolah->id,
            'ada/tidak_ada' => $data['ruang_kepala_sekolah']['ada/tidak_ada'],
            'kondisi' => $data['ruang_kepala_sekolah']['kondisi'],
        ]);

        // 11. Ruang Guru
        RuangGuru::create([
            'profile_sekolah_id' => $profileSekolah->id,
            'ada/tidak_ada' => $data['ruang_guru']['ada/tidak_ada'],
            'kondisi' => $data['ruang_guru']['kondisi'],
        ]);

        // 12. Ruang Kantor/TU
        RuangKantorTu::create([
            'profile_sekolah_id' => $profileSekolah->id,
            'ada/tidak_ada' => $data['ruang_kantor_tu']['ada/tidak_ada'],
            'kondisi' => $data['ruang_kantor_tu']['kondisi'],
        ]);

        // 13. Lab IPA
        LabIpa::create([
            'profile_sekolah_id' => $profileSekolah->id,
            'ada/tidak_ada' => $data['lab_ipa']['ada/tidak_ada'],
            'kondisi' => $data['lab_ipa']['kondisi'],
        ]);

        // 14. Lab Komputer
        LabKomputer::create([
            'profile_sekolah_id' => $profileSekolah->id,
            'ada/tidak_ada' => $data['lab_komputer']['ada/tidak_ada'],
            'kondisi' => $data['lab_komputer']['kondisi'],
        ]);

        // 15. UKS
        UnitKesehatanSekolah::create([
            'profile_sekolah_id' => $profileSekolah->id,
            'ada/tidak_ada' => $data['uks']['ada/tidak_ada'],
            'kondisi' => $data['uks']['kondisi'],
        ]);

        // 16. Rumah Dinas
        RumahDinas::create([
            'profile_sekolah_id' => $profileSekolah->id,
            'ada/tidak_ada' => $data['rumah_dinas']['ada/tidak_ada'],
            'kondisi' => $data['rumah_dinas']['kondisi'],
        ]);

        // 17. Rumah Ibadah
        RumahIbadah::create([
            'profile_sekolah_id' => $profileSekolah->id,
            'ada/tidak_ada' => $data['rumah_ibadah']['ada/tidak_ada'],
            'kondisi' => $data['rumah_ibadah']['kondisi'],
        ]);

        // 18. Lapangan Sekolah
        LapanganSekolah::create([
            'profile_sekolah_id' => $profileSekolah->id,
            'ada/tidak_ada' => $data['lapangan_sekolah']['ada/tidak_ada'],
            'kondisi' => $data['lapangan_sekolah']['kondisi'],
        ]);

        // 19. Pagar Sekolah
        PagarSekolah::create([
            'profile_sekolah_id' => $profileSekolah->id,
            'ada/tidak_ada' => $data['pagar_sekolah']['ada/tidak_ada'],
            'kondisi' => $data['pagar_sekolah']['kondisi'],
        ]);

        // 20. Air Bersih
        AirBersih::create([
            'profile_sekolah_id' => $profileSekolah->id,
            'ada/tidak_ada' => $data['air_bersih']['ada/tidak_ada'],
            'kondisi' => $data['air_bersih']['kondisi'],
        ]);

        // 21. Kursi Siswa
        KursiSiswa::create([
            'profile_sekolah_id' => $profileSekolah->id,
            'baik' => $data['kursi_siswa']['baik'],
            'rusak' => $data['kursi_siswa']['rusak'],
        ]);

        // 22. Meja Siswa
        MejaSiswa::create([
            'profile_sekolah_id' => $profileSekolah->id,
            'baik' => $data['meja_siswa']['baik'],
            'rusak' => $data['meja_siswa']['rusak'],
        ]);

        // 23. Kursi Guru
        KursiGuru::create([
            'profile_sekolah_id' => $profileSekolah->id,
            'baik' => $data['kursi_guru']['baik'],
            'rusak' => $data['kursi_guru']['rusak'],
        ]);

        // 24. Meja Guru
        MejaGuru::create([
            'profile_sekolah_id' => $profileSekolah->id,
            'baik' => $data['meja_guru']['baik'],
            'rusak' => $data['meja_guru']['rusak'],
        ]);

        // 25. Laptop
        Laptop::create([
            'profile_sekolah_id' => $profileSekolah->id,
            'baik' => $data['laptop']['baik'],
            'rusak' => $data['laptop']['rusak'],
        ]);

        // 26. Komputer
        Komputer::create([
            'profile_sekolah_id' => $profileSekolah->id,
            'baik' => $data['komputer']['baik'],
            'rusak' => $data['komputer']['rusak'],
        ]);
    }
}
