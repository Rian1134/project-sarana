<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

use App\Models\User;
use App\Models\ProfileSekolah;
use App\Models\KondisiGuru;
use App\Models\KondisiStaff;
use App\Models\PagarSekolah;
use App\Models\AirBersih;
use App\Models\KursiSiswa;
use App\Models\MejaSiswa;
use App\Models\KursiGuru;
use App\Models\MejaGuru;
use App\Models\Laptop;
use App\Models\Komputer;
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

class SaranaSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        // Daftar kota di Indonesia (25 kota)
        $kota = [
            'Jakarta', 'Bandung', 'Surabaya', 'Medan', 'Semarang',
            'Yogyakarta', 'Makassar', 'Palembang', 'Denpasar', 'Banjarmasin',
            'Manado', 'Balikpapan', 'Padang', 'Pontianak', 'Jambi',
            'Kupang', 'Palu', 'Ambon', 'Kendari', 'Mataram',
            'Sorong', 'Cilegon', 'Ternate', 'Pekanbaru', 'Jayapura'
        ];

        // Nama kepala sekolah (25 nama)
        $kepalaSekolah = [
            'Dr. Ahmad Fauzi, M.Pd.', 'Drs. Budi Santoso, M.M.', 'Dra. Sri Wahyuni, M.Pd.',
            'Drs. H. Abdul Malik, M.Si.', 'Dra. Rina Marlina, M.Pd.', 'Dr. Supriyanto, M.Pd.',
            'Drs. Andi Rauf, M.M.', 'Dra. Nurhayati, M.Si.', 'Dr. I Wayan Sudiarta, S.Pd.',
            'Drs. H. Zainuddin, M.Ag.', 'Dra. Maria Rumambi, M.Pd.', 'Drs. Hartono, M.Si.',
            'Dra. Yenni Susanti, M.Pd.', 'Drs. H. Mustafa, M.A.', 'Dra. Rukmini, M.Pd.',
            'Drs. Yoseph Nahak, M.Pd.', 'Dra. Rosdiana Lestari, M.Si.', 'Drs. Johan Latupeirissa, M.M.',
            'Dra. Nurlaila Darwis, M.Pd.', 'Drs. I Made Suardika, M.Pd.', 'Dra. Martha Kambuaya, M.Si.',
            'Drs. Amir Maulana, M.M.', 'Dra. Siti Aisyah, M.Pd.', 'Dr. Rina Febriana, S.Pd., M.M.',
            'Drs. Mathias Kogoya, M.Pd.'
        ];

        // Daftar kondisi enum sesuai migration
        $kondisiArr = ['baik', 'rusak_ringan', 'rusak_sedang', 'rusak_berat'];

        for ($i = 0; $i < 25; $i++) {

            // ========================================
            // BUAT USER UNTUK SETIAP SEKOLAH
            // ========================================
            $user = User::create([
                'name'     => $faker->name(),
                'email'    => 'user' . ($i + 1) . '@sekolah.test',
                'password' => Hash::make('password'),
            ]);

            if (method_exists($user, 'assignRole')) {
                $user->assignRole('user');
            }

            // ========================================
            // GENERATE NILAI RANDOM
            // ========================================
            $siswaVii   = $faker->numberBetween(80, 180);
            $siswaViii  = $faker->numberBetween(75, 170);
            $siswaIx    = $faker->numberBetween(70, 165);

            $rombelVii  = (int) ceil($siswaVii / 32);
            $rombelViii = (int) ceil($siswaViii / 32);
            $rombelIx   = (int) ceil($siswaIx / 32);

            // ========================================
            // 1. PROFILE SEKOLAH (TABEL UTAMA)
            // ========================================
            $profile = ProfileSekolah::create([
                'nama_sekolah'         => 'SMP Negeri ' . ($i + 1) . ' ' . $kota[$i],
                'NPSN'                 => '20100' . str_pad($i + 1, 3, '0', STR_PAD_LEFT),
                'alamat_sekolah'       => 'Jl. ' . $faker->streetName() . ' No. ' . $faker->numberBetween(1, 100) . ', ' . $kota[$i],
                'nama_kepala_sekolah'  => $kepalaSekolah[$i],
                'NIP'                  => '196' . $faker->numberBetween(5, 7) . str_pad($faker->numberBetween(1, 12), 2, '0', STR_PAD_LEFT) . '19' . $faker->numberBetween(88, 99) . '03' . str_pad($i + 1, 3, '0', STR_PAD_LEFT),
                'status_sekolah'       => $faker->randomElement(['negeri', 'swasta']),
                'akreditasi'           => $faker->randomElement(['A', 'B', 'C', 'belum_terakreditasi']),
                'website'              => 'https://smpn' . ($i + 1) . strtolower($kota[$i]) . '.sch.id',
                'nomor_hp'             => '08' . $faker->numberBetween(100000000, 999999999),
                'user_id'              => $user->id,
            ]);

            // ========================================
            // 2. KONDISI GURU
            // ========================================
            KondisiGuru::create([
                'profile_sekolah_id' => $profile->id,
                'pns'                => (string) $faker->numberBetween(5, 15),
                'pppk'               => (string) $faker->numberBetween(2, 8),
                'pppk_paruh_waktu'   => (string) $faker->numberBetween(0, 4),
                'honor'              => (string) $faker->numberBetween(3, 12),
                'i'                  => (string) $faker->numberBetween(0, 2),
                'ii'                 => (string) $faker->numberBetween(0, 5),
                'iii'                => (string) $faker->numberBetween(5, 20),
                'iv'                 => (string) $faker->numberBetween(2, 10),
            ]);

            // ========================================
            // 3. KONDISI STAFF TATA USAHA
            // ========================================
            KondisiStaff::create([
                'profile_sekolah_id' => $profile->id,
                'pns'                => (string) $faker->numberBetween(1, 5),
                'pppk'               => (string) $faker->numberBetween(0, 3),
                'pppk_paruh_waktu'   => (string) $faker->numberBetween(0, 2),
                'honor'              => (string) $faker->numberBetween(2, 6),
                'i'                  => (string) $faker->numberBetween(0, 2),
                'ii'                 => (string) $faker->numberBetween(0, 3),
                'iii'                => (string) $faker->numberBetween(2, 8),
                'iv'                 => (string) $faker->numberBetween(0, 4),
            ]);

            // ========================================
            // 4. PAGAR SEKOLAH
            // ========================================
            $pagarStatus = $faker->randomElement(['ada', 'tidak_ada']);
            PagarSekolah::create([
                'profile_sekolah_id' => $profile->id,
                'ada/tidak_ada'      => $pagarStatus,
                'kondisi'             => $pagarStatus === 'ada' ? $faker->randomElement($kondisiArr) : 'nihil',
            ]);

            // ========================================
            // 5. AIR BERSIH
            // ========================================
            $airStatus = $faker->randomElement(['ada', 'tidak_ada']);
            AirBersih::create([
                'profile_sekolah_id' => $profile->id,
                'ada/tidak_ada'      => $airStatus,
                'kondisi'             => $airStatus === 'ada' ? $faker->randomElement($kondisiArr) : 'nihil',
            ]);

            // ========================================
            // 6. KURSI SISWA
            // ========================================
            KursiSiswa::create([
                'profile_sekolah_id' => $profile->id,
                'baik'               => $faker->numberBetween(150, 400),
                'rusak'              => $faker->numberBetween(5, 30),
            ]);

            // ========================================
            // 7. MEJA SISWA
            // ========================================
            MejaSiswa::create([
                'profile_sekolah_id' => $profile->id,
                'baik'               => $faker->numberBetween(60, 150),
                'rusak'              => $faker->numberBetween(2, 15),
            ]);

            // ========================================
            // 8. KURSI GURU
            // ========================================
            KursiGuru::create([
                'profile_sekolah_id' => $profile->id,
                'baik'               => $faker->numberBetween(20, 50),
                'rusak'              => $faker->numberBetween(1, 8),
            ]);

            // ========================================
            // 9. MEJA GURU
            // ========================================
            MejaGuru::create([
                'profile_sekolah_id' => $profile->id,
                'baik'               => $faker->numberBetween(15, 35),
                'rusak'              => $faker->numberBetween(1, 5),
            ]);

            // ========================================
            // 10. LAPTOP
            // ========================================
            Laptop::create([
                'profile_sekolah_id' => $profile->id,
                'baik'               => $faker->numberBetween(5, 20),
                'rusak'              => $faker->numberBetween(0, 4),
            ]);

            // ========================================
            // 11. KOMPUTER
            // ========================================
            Komputer::create([
                'profile_sekolah_id' => $profile->id,
                'baik'               => $faker->numberBetween(5, 25),
                'rusak'              => $faker->numberBetween(0, 5),
            ]);

            // ========================================
            // 12. JUMLAH SISWA
            // ========================================
            JumlahSiswa::create([
                'profile_sekolah_id' => $profile->id,
                'vii'                => $siswaVii,
                'viii'               => $siswaViii,
                'ix'                 => $siswaIx,
            ]);

            // ========================================
            // 13. JUMLAH ROMBEL
            // ========================================
            JumlahRombel::create([
                'profile_sekolah_id' => $profile->id,
                'vii'                => $rombelVii,
                'viii'               => $rombelViii,
                'ix'                 => $rombelIx,
            ]);

            // ========================================
            // 14. RUANG KELAS BARU
            // ========================================
            RuangKelasBaru::create([
                'profile_sekolah_id' => $profile->id,
                'jumlah'             => $faker->numberBetween(0, 4),
            ]);

            // ========================================
            // 15. REHABILITASI RUANG KELAS
            // ========================================
            RehabilitasiRuangKelas::create([
                'profile_sekolah_id' => $profile->id,
                'jumlah'             => $faker->numberBetween(0, 3),
            ]);

            // ========================================
            // 16. RUANG KELAS
            // ========================================
            RuangKelas::create([
                'profile_sekolah_id' => $profile->id,
                'baik'               => $faker->numberBetween(5, 15),
                'rusak'              => $faker->numberBetween(0, 3),
            ]);

            // ========================================
            // 17. TOILET SISWA
            // ========================================
            ToiletSiswa::create([
                'profile_sekolah_id' => $profile->id,
                'baik'               => $faker->numberBetween(3, 10),
                'rusak'              => $faker->numberBetween(0, 3),
            ]);

            // ========================================
            // 18. TOILET GURU
            // ========================================
            ToiletGuru::create([
                'profile_sekolah_id' => $profile->id,
                'baik'               => $faker->numberBetween(1, 4),
                'rusak'              => $faker->numberBetween(0, 2),
            ]);

            // ========================================
            // 19-28. RUANGAN / FASILITAS (ADA/TIDAK_ADA)
            // ========================================
            $ruanganConfig = [
                // [Model, probabilitas 'ada']
                [RuangPerpustakaan::class,   80],
                [RuangKepalaSekolah::class,  90],
                [RuangGuru::class,           90],
                [RuangKantorTu::class,       85],
                [LabIpa::class,              60],
                [LabKomputer::class,         55],
                [UnitKesehatanSekolah::class, 75],
                [RumahDinas::class,          40],
                [RumahIbadah::class,         80],
                [LapanganSekolah::class,     75],
            ];

            foreach ($ruanganConfig as [$model, $probabilitas]) {
                $status = $faker->boolean($probabilitas) ? 'ada' : 'tidak_ada';

                $model::create([
                    'profile_sekolah_id' => $profile->id,
                    'ada/tidak_ada'      => $status,
                    'kondisi'             => $status === 'ada' ? $faker->randomElement($kondisiArr) : 'nihil',
                ]);
            }
        }

        $this->command->info('✅ Berhasil membuat 25 data sekolah beserta sarana & prasarananya!');
        $this->command->info('   - 25 ProfileSekolah + 25 User');
        $this->command->info('   - 25 KondisiGuru & 25 KondisiStaff');
        $this->command->info('   - 27 relasi sarana per sekolah');
    }
}