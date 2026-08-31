<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Sarana;
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
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class SaranaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        // Buat user admin
        $admin = User::find(1);

        // Buat 25 user untuk masing-masing sekolah
        $users = [];
        for ($i = 1; $i <= 25; $i++) {
            $user = User::create([
                'name' => $faker->name(),
                'email' => 'user' . $i . '@sekolah.test',
                'password' => Hash::make('password'),
            ]);
            $user->assignRole('user');
            $users[] = $user;
        }

        // Daftar kota di Indonesia
        $kota = [
            'Jakarta', 'Bandung', 'Surabaya', 'Medan', 'Semarang',
            'Yogyakarta', 'Makassar', 'Palembang', 'Denpasar', 'Banjarmasin',
            'Manado', 'Balikpapan', 'Padang', 'Pontianak', 'Jambi',
            'Kupang', 'Palu', 'Ambon', 'Kendari', 'Mataram',
            'Sorong', 'Cilegon', 'Ternate', 'Pekanbaru', 'Jayapura'
        ];

        // Nama kepala sekolah
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

        $dataSekolah = [];

        for ($i = 0; $i < 25; $i++) {
            // Generate jumlah siswa (80-180 per angkatan)
            $siswaVii = $faker->numberBetween(80, 180);
            $siswaViii = $faker->numberBetween(75, 170);
            $siswaIx = $faker->numberBetween(70, 165);

            // Generate rombel berdasarkan jumlah siswa (1 rombel = 32 siswa)
            $rombelVii = ceil($siswaVii / 32);
            $rombelViii = ceil($siswaViii / 32);
            $rombelIx = ceil($siswaIx / 32);

            // Generate ruang kelas (5-15)
            $ruangKelasBaik = $faker->numberBetween(5, 15);
            $ruangKelasRusak = $faker->numberBetween(0, 3);

            // Generate toilet
            $toiletSiswaBaik = $faker->numberBetween(3, 10);
            $toiletSiswaRusak = $faker->numberBetween(0, 3);
            $toiletGuruBaik = $faker->numberBetween(1, 4);
            $toiletGuruRusak = $faker->numberBetween(0, 2);

            // Generate furniture
            $kursiSiswaBaik = $faker->numberBetween(150, 400);
            $kursiSiswaRusak = $faker->numberBetween(5, 30);
            $mejaSiswaBaik = $faker->numberBetween(60, 150);
            $mejaSiswaRusak = $faker->numberBetween(2, 15);
            $kursiGuruBaik = $faker->numberBetween(20, 50);
            $kursiGuruRusak = $faker->numberBetween(1, 8);
            $mejaGuruBaik = $faker->numberBetween(15, 35);
            $mejaGuruRusak = $faker->numberBetween(1, 5);

            // Generate elektronik
            $laptopBaik = $faker->numberBetween(5, 20);
            $laptopRusak = $faker->numberBetween(0, 4);
            $komputerBaik = $faker->numberBetween(5, 25);
            $komputerRusak = $faker->numberBetween(0, 5);

            // Generate kondisi fasilitas (ada/tidak_ada)
            $statusOptions = ['ada', 'tidak_ada'];
            $kondisiOptions = ['baik', 'rusak', 'nihil'];

            // Pastikan fasilitas utama selalu ada
            $perpustakaanStatus = $faker->randomElement(['ada', 'tidak_ada']);
            $perpustakaanKondisi = $perpustakaanStatus == 'ada' ? $faker->randomElement(['baik', 'rusak']) : 'nihil';

            $kepsekStatus = $faker->randomElement(['ada', 'tidak_ada']);
            $kepsekKondisi = $kepsekStatus == 'ada' ? $faker->randomElement(['baik', 'rusak']) : 'nihil';

            $ruangGuruStatus = $faker->randomElement(['ada', 'tidak_ada']);
            $ruangGuruKondisi = $ruangGuruStatus == 'ada' ? $faker->randomElement(['baik', 'rusak']) : 'nihil';

            $kantorTuStatus = $faker->randomElement(['ada', 'tidak_ada']);
            $kantorTuKondisi = $kantorTuStatus == 'ada' ? $faker->randomElement(['baik', 'rusak']) : 'nihil';

            $labIpaStatus = $faker->randomElement(['ada', 'tidak_ada']);
            $labIpaKondisi = $labIpaStatus == 'ada' ? $faker->randomElement(['baik', 'rusak']) : 'nihil';

            $labKomputerStatus = $faker->randomElement(['ada', 'tidak_ada']);
            $labKomputerKondisi = $labKomputerStatus == 'ada' ? $faker->randomElement(['baik', 'rusak']) : 'nihil';

            $uksStatus = $faker->randomElement(['ada', 'tidak_ada']);
            $uksKondisi = $uksStatus == 'ada' ? $faker->randomElement(['baik', 'rusak']) : 'nihil';

            $rumahDinasStatus = $faker->randomElement(['ada', 'tidak_ada']);
            $rumahDinasKondisi = $rumahDinasStatus == 'ada' ? $faker->randomElement(['baik', 'rusak']) : 'nihil';

            $rumahIbadahStatus = $faker->randomElement(['ada', 'tidak_ada']);
            $rumahIbadahKondisi = $rumahIbadahStatus == 'ada' ? $faker->randomElement(['baik', 'rusak']) : 'nihil';

            $lapanganStatus = $faker->randomElement(['ada', 'tidak_ada']);
            $lapanganKondisi = $lapanganStatus == 'ada' ? $faker->randomElement(['baik', 'rusak']) : 'nihil';

            $pagarStatus = $faker->randomElement(['ada', 'tidak_ada']);
            $pagarKondisi = $pagarStatus == 'ada' ? $faker->randomElement(['baik', 'rusak']) : 'nihil';

            $airStatus = $faker->randomElement(['ada', 'tidak_ada']);
            $airKondisi = $airStatus == 'ada' ? $faker->randomElement(['baik', 'rusak']) : 'nihil';

            $dataSekolah[] = [
                'nama_sekolah' => 'SMP Negeri ' . ($i + 1) . ' ' . $kota[$i],
                'NPSN' => '20100' . str_pad($i + 1, 3, '0', STR_PAD_LEFT),
                'alamat_sekolah' => 'Jl. ' . $faker->streetName() . ' No. ' . $faker->numberBetween(1, 100) . ', ' . $kota[$i],
                'nama_kepala_sekolah' => $kepalaSekolah[$i],
                'NIP' => '196' . $faker->numberBetween(5, 7) . $faker->randomNumber(2) . '19' . $faker->numberBetween(88, 10) . '03' . str_pad($i + 1, 3, '0', STR_PAD_LEFT),
                'nomor_hp' => '08' . $faker->numberBetween(100000000, 999999999),
                'user_id' => $users[$i]->id,
                'jumlah_siswa' => [
                    'vii' => $siswaVii,
                    'viii' => $siswaViii,
                    'ix' => $siswaIx
                ],
                'jumlah_rombel' => [
                    'vii' => $rombelVii,
                    'viii' => $rombelViii,
                    'ix' => $rombelIx
                ],
                'ruang_kelas_baru' => $faker->numberBetween(0, 4),
                'rehabilitasi_ruang_kelas' => $faker->numberBetween(0, 3),
                'ruang_kelas' => [
                    'baik' => $ruangKelasBaik,
                    'rusak' => $ruangKelasRusak
                ],
                'toilet_siswa' => [
                    'baik' => $toiletSiswaBaik,
                    'rusak' => $toiletSiswaRusak
                ],
                'toilet_guru' => [
                    'baik' => $toiletGuruBaik,
                    'rusak' => $toiletGuruRusak
                ],
                'ruang_perpustakaan' => [
                    'ada/tidak_ada' => $perpustakaanStatus,
                    'kodisi' => $perpustakaanKondisi
                ],
                'ruang_kepala_sekolah' => [
                    'ada/tidak_ada' => $kepsekStatus,
                    'kodisi' => $kepsekKondisi
                ],
                'ruang_guru' => [
                    'ada/tidak_ada' => $ruangGuruStatus,
                    'kodisi' => $ruangGuruKondisi
                ],
                'ruang_kantor_tu' => [
                    'ada/tidak_ada' => $kantorTuStatus,
                    'kodisi' => $kantorTuKondisi
                ],
                'lab_ipa' => [
                    'ada/tidak_ada' => $labIpaStatus,
                    'kodisi' => $labIpaKondisi
                ],
                'lab_komputer' => [
                    'ada/tidak_ada' => $labKomputerStatus,
                    'kodisi' => $labKomputerKondisi
                ],
                'uks' => [
                    'ada/tidak_ada' => $uksStatus,
                    'kodisi' => $uksKondisi
                ],
                'rumah_dinas' => [
                    'ada/tidak_ada' => $rumahDinasStatus,
                    'kodisi' => $rumahDinasKondisi
                ],
                'rumah_ibadah' => [
                    'ada/tidak_ada' => $rumahIbadahStatus,
                    'kodisi' => $rumahIbadahKondisi
                ],
                'lapangan_sekolah' => [
                    'ada/tidak_ada' => $lapanganStatus,
                    'kodisi' => $lapanganKondisi
                ],
                'pagar_sekolah' => [
                    'ada/tidak_ada' => $pagarStatus,
                    'kodisi' => $pagarKondisi
                ],
                'air_bersih' => [
                    'ada/tidak_ada' => $airStatus,
                    'kodisi' => $airKondisi
                ],
                'kursi_siswa' => [
                    'baik' => $kursiSiswaBaik,
                    'rusak' => $kursiSiswaRusak
                ],
                'meja_siswa' => [
                    'baik' => $mejaSiswaBaik,
                    'rusak' => $mejaSiswaRusak
                ],
                'kursi_guru' => [
                    'baik' => $kursiGuruBaik,
                    'rusak' => $kursiGuruRusak
                ],
                'meja_guru' => [
                    'baik' => $mejaGuruBaik,
                    'rusak' => $mejaGuruRusak
                ],
                'laptop' => [
                    'baik' => $laptopBaik,
                    'rusak' => $laptopRusak
                ],
                'komputer' => [
                    'baik' => $komputerBaik,
                    'rusak' => $komputerRusak
                ],
            ];
        }

        foreach ($dataSekolah as $data) {
            // 1. Create Sarana
            $sarana = Sarana::create([
                'nama_sekolah' => $data['nama_sekolah'],
                'NPSN' => $data['NPSN'],
                'alamat_sekolah' => $data['alamat_sekolah'],
                'nama_kepala_sekolah' => $data['nama_kepala_sekolah'],
                'NIP' => $data['NIP'],
                'nomor_hp' => $data['nomor_hp'],
                'user_id' => $data['user_id'],
            ]);

            // 2. Jumlah Siswa
            JumlahSiswa::create([
                'sarana_id' => $sarana->id,
                'vii' => $data['jumlah_siswa']['vii'],
                'viii' => $data['jumlah_siswa']['viii'],
                'ix' => $data['jumlah_siswa']['ix'],
            ]);

            // 3. Jumlah Rombel
            JumlahRombel::create([
                'sarana_id' => $sarana->id,
                'vii' => $data['jumlah_rombel']['vii'],
                'viii' => $data['jumlah_rombel']['viii'],
                'ix' => $data['jumlah_rombel']['ix'],
            ]);

            // 4. Ruang Kelas Baru
            RuangKelasBaru::create([
                'sarana_id' => $sarana->id,
                'jumlah' => $data['ruang_kelas_baru'],
            ]);

            // 5. Rehabilitasi Ruang Kelas
            RehabilitasiRuangKelas::create([
                'sarana_id' => $sarana->id,
                'jumlah' => $data['rehabilitasi_ruang_kelas'],
            ]);

            // 6. Ruang Kelas
            RuangKelas::create([
                'sarana_id' => $sarana->id,
                'baik' => $data['ruang_kelas']['baik'],
                'rusak' => $data['ruang_kelas']['rusak'],
            ]);

            // 7. Toilet Siswa
            ToiletSiswa::create([
                'sarana_id' => $sarana->id,
                'baik' => $data['toilet_siswa']['baik'],
                'rusak' => $data['toilet_siswa']['rusak'],
            ]);

            // 8. Toilet Guru
            ToiletGuru::create([
                'sarana_id' => $sarana->id,
                'baik' => $data['toilet_guru']['baik'],
                'rusak' => $data['toilet_guru']['rusak'],
            ]);

            // 9. Ruang Perpustakaan
            RuangPerpustakaan::create([
                'sarana_id' => $sarana->id,
                'ada/tidak_ada' => $data['ruang_perpustakaan']['ada/tidak_ada'],
                'kodisi' => $data['ruang_perpustakaan']['kodisi'],
            ]);

            // 10. Ruang Kepala Sekolah
            RuangKepalaSekolah::create([
                'sarana_id' => $sarana->id,
                'ada/tidak_ada' => $data['ruang_kepala_sekolah']['ada/tidak_ada'],
                'kodisi' => $data['ruang_kepala_sekolah']['kodisi'],
            ]);

            // 11. Ruang Guru
            RuangGuru::create([
                'sarana_id' => $sarana->id,
                'ada/tidak_ada' => $data['ruang_guru']['ada/tidak_ada'],
                'kodisi' => $data['ruang_guru']['kodisi'],
            ]);

            // 12. Ruang Kantor/TU
            RuangKantorTu::create([
                'sarana_id' => $sarana->id,
                'ada/tidak_ada' => $data['ruang_kantor_tu']['ada/tidak_ada'],
                'kodisi' => $data['ruang_kantor_tu']['kodisi'],
            ]);

            // 13. Lab IPA
            LabIpa::create([
                'sarana_id' => $sarana->id,
                'ada/tidak_ada' => $data['lab_ipa']['ada/tidak_ada'],
                'kodisi' => $data['lab_ipa']['kodisi'],
            ]);

            // 14. Lab Komputer
            LabKomputer::create([
                'sarana_id' => $sarana->id,
                'ada/tidak_ada' => $data['lab_komputer']['ada/tidak_ada'],
                'kodisi' => $data['lab_komputer']['kodisi'],
            ]);

            // 15. UKS
            UnitKesehatanSekolah::create([
                'sarana_id' => $sarana->id,
                'ada/tidak_ada' => $data['uks']['ada/tidak_ada'],
                'kodisi' => $data['uks']['kodisi'],
            ]);

            // 16. Rumah Dinas
            RumahDinas::create([
                'sarana_id' => $sarana->id,
                'ada/tidak_ada' => $data['rumah_dinas']['ada/tidak_ada'],
                'kodisi' => $data['rumah_dinas']['kodisi'],
            ]);

            // 17. Rumah Ibadah
            RumahIbadah::create([
                'sarana_id' => $sarana->id,
                'ada/tidak_ada' => $data['rumah_ibadah']['ada/tidak_ada'],
                'kodisi' => $data['rumah_ibadah']['kodisi'],
            ]);

            // 18. Lapangan Sekolah
            LapanganSekolah::create([
                'sarana_id' => $sarana->id,
                'ada/tidak_ada' => $data['lapangan_sekolah']['ada/tidak_ada'],
                'kodisi' => $data['lapangan_sekolah']['kodisi'],
            ]);

            // 19. Pagar Sekolah
            PagarSekolah::create([
                'sarana_id' => $sarana->id,
                'ada/tidak_ada' => $data['pagar_sekolah']['ada/tidak_ada'],
                'kodisi' => $data['pagar_sekolah']['kodisi'],
            ]);

            // 20. Air Bersih
            AirBersih::create([
                'sarana_id' => $sarana->id,
                'ada/tidak_ada' => $data['air_bersih']['ada/tidak_ada'],
                'kodisi' => $data['air_bersih']['kodisi'],
            ]);

            // 21. Kursi Siswa
            KursiSiswa::create([
                'sarana_id' => $sarana->id,
                'baik' => $data['kursi_siswa']['baik'],
                'rusak' => $data['kursi_siswa']['rusak'],
            ]);

            // 22. Meja Siswa
            MejaSiswa::create([
                'sarana_id' => $sarana->id,
                'baik' => $data['meja_siswa']['baik'],
                'rusak' => $data['meja_siswa']['rusak'],
            ]);

            // 23. Kursi Guru
            KursiGuru::create([
                'sarana_id' => $sarana->id,
                'baik' => $data['kursi_guru']['baik'],
                'rusak' => $data['kursi_guru']['rusak'],
            ]);

            // 24. Meja Guru
            MejaGuru::create([
                'sarana_id' => $sarana->id,
                'baik' => $data['meja_guru']['baik'],
                'rusak' => $data['meja_guru']['rusak'],
            ]);

            // 25. Laptop
            Laptop::create([
                'sarana_id' => $sarana->id,
                'baik' => $data['laptop']['baik'],
                'rusak' => $data['laptop']['rusak'],
            ]);

            // 26. Komputer
            Komputer::create([
                'sarana_id' => $sarana->id,
                'baik' => $data['komputer']['baik'],
                'rusak' => $data['komputer']['rusak'],
            ]);
        }
    }
}