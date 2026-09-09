<?php

/**
 * config/sarana.php
 *
 * Pemetaan tiap kategori sarana ke:
 * - model      : class Eloquent-nya
 * - type       : bentuk datanya, menentukan cara ekstraksi nilai untuk chart
 *                'baik_rusak'   -> field baik & rusak (angka)
 *                'ada_kondisi'  -> field ada/tidak_ada & kodisi (status)
 *                'jumlah'       -> field jumlah tunggal (angka)
 *                'tingkat'      -> field vii, viii, ix (angka per tingkat)
 * - label      : label yang ditampilkan di dropdown pemilih kategori
 */

return [
    'kategori' => [
        'jumlah_siswa' => [
            'model' => \App\Models\JumlahSiswa::class,
            'type'  => 'tingkat',
            'label' => 'Jumlah Siswa',
        ],
        'jumlah_rombel' => [
            'model' => \App\Models\JumlahRombel::class,
            'type'  => 'tingkat',
            'label' => 'Jumlah Rombongan Belajar',
        ],
        'rkb' => [
            'model' => \App\Models\RuangKelasBaru::class,
            'type'  => 'jumlah',
            'label' => 'Pembangunan Ruang Kelas Baru',
        ],
        'rehabilitasi' => [
            'model' => \App\Models\RehabilitasiRuangKelas::class,
            'type'  => 'jumlah',
            'label' => 'Rehabilitasi Ruang Kelas',
        ],
        'ruang_kelas' => [
            'model' => \App\Models\RuangKelas::class,
            'type'  => 'baik_rusak',
            'label' => 'Ruang Kelas',
        ],
        'toilet_siswa' => [
            'model' => \App\Models\ToiletSiswa::class,
            'type'  => 'baik_rusak',
            'label' => 'Toilet Siswa',
        ],
        'toilet_guru' => [
            'model' => \App\Models\ToiletGuru::class,
            'type'  => 'baik_rusak',
            'label' => 'Toilet Guru',
        ],
        'perpustakaan' => [
            'model' => \App\Models\RuangPerpustakaan::class,
            'type'  => 'ada_kondisi',
            'label' => 'R. Perpustakaan',
        ],
        'kepala_sekolah' => [
            'model' => \App\Models\RuangKepalaSekolah::class,
            'type'  => 'ada_kondisi',
            'label' => 'R. Kepala Sekolah',
        ],
        'ruang_guru' => [
            'model' => \App\Models\RuangGuru::class,
            'type'  => 'ada_kondisi',
            'label' => 'R. Guru',
        ],
        'kantor_tu' => [
            'model' => \App\Models\RuangKantorTu::class,
            'type'  => 'ada_kondisi',
            'label' => 'R. Kantor / TU',
        ],
        'lab_ipa' => [
            'model' => \App\Models\LabIpa::class,
            'type'  => 'ada_kondisi',
            'label' => 'Lab IPA',
        ],
        'lab_komputer' => [
            'model' => \App\Models\LabKomputer::class,
            'type'  => 'ada_kondisi',
            'label' => 'Lab Komputer',
        ],
        'uks' => [
            'model' => \App\Models\UnitKesehatanSekolah::class,
            'type'  => 'ada_kondisi',
            'label' => 'UKS',
        ],
        'rumah_dinas' => [
            'model' => \App\Models\RumahDinas::class,
            'type'  => 'ada_kondisi',
            'label' => 'Rumah Dinas',
        ],
        'rumah_ibadah' => [
            'model' => \App\Models\RumahIbadah::class,
            'type'  => 'ada_kondisi',
            'label' => 'Rumah Ibadah',
        ],
        'lapangan' => [
            'model' => \App\Models\LapanganSekolah::class,
            'type'  => 'ada_kondisi',
            'label' => 'Lapangan Sekolah',
        ],
        'pagar' => [
            'model' => \App\Models\PagarSekolah::class,
            'type'  => 'ada_kondisi',
            'label' => 'Pagar Sekolah',
        ],
        'air_bersih' => [
            'model' => \App\Models\AirBersih::class,
            'type'  => 'ada_kondisi',
            'label' => 'Persediaan Air Bersih',
        ],
        'kursi_siswa' => [
            'model' => \App\Models\KursiSiswa::class,
            'type'  => 'baik_rusak',
            'label' => 'Kursi Siswa',
        ],
        'meja_siswa' => [
            'model' => \App\Models\MejaSiswa::class,
            'type'  => 'baik_rusak',
            'label' => 'Meja Siswa',
        ],
        'kursi_guru' => [
            'model' => \App\Models\KursiGuru::class,
            'type'  => 'baik_rusak',
            'label' => 'Kursi Guru',
        ],
        'meja_guru' => [
            'model' => \App\Models\MejaGuru::class,
            'type'  => 'baik_rusak',
            'label' => 'Meja Guru',
        ],
        'laptop' => [
            'model' => \App\Models\Laptop::class,
            'type'  => 'baik_rusak',
            'label' => 'Laptop',
        ],
        'komputer' => [
            'model' => \App\Models\Komputer::class,
            'type'  => 'baik_rusak',
            'label' => 'Komputer',
        ],
        'chromebook' => [
            'model' => \App\Models\Chromebook::class,
            'type'  => 'baik_rusak',
            'label' => 'Chromebook',
        ],
    ],
];
