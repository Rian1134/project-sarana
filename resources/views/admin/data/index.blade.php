@extends('layouts.admin')

@section('title', 'Sarana & Prasarana')
@section('content')

    {{-- ============================================================
         HEADER HALAMAN (Judul, Tombol Export & Tambah)
         ============================================================ --}}
    <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between mb-5">
        <h1 class="text-xl font-semibold text-gray-800 dark:text-gray-100 flex items-center gap-2">
            <i class="bi bi-clipboard2-data-fill"></i>
            Data Sarana Sekolah
        </h1>
    </div>

    {{-- ============================================================
         GRAFIK RINGKASAN (agregat seluruh sekolah)
         ============================================================ --}}
    @php
        $chartSiswaRombel = [
            'vii' => [
                $profileSekolahs->sum(fn($item) => $item->jumlahSiswa?->vii ?? 0),
                $profileSekolahs->sum(fn($item) => $item->jumlahRombel?->vii ?? 0),
            ],
            'viii' => [
                $profileSekolahs->sum(fn($item) => $item->jumlahSiswa?->viii ?? 0),
                $profileSekolahs->sum(fn($item) => $item->jumlahRombel?->viii ?? 0),
            ],
            'ix' => [
                $profileSekolahs->sum(fn($item) => $item->jumlahSiswa?->ix ?? 0),
                $profileSekolahs->sum(fn($item) => $item->jumlahRombel?->ix ?? 0),
            ],
        ];

        $chartRuangKelas = [
            $profileSekolahs->sum(fn($item) => $item->ruangKelas?->baik ?? 0),
            $profileSekolahs->sum(fn($item) => $item->ruangKelas?->rusak ?? 0),
        ];

        // Kondisi Toilet Siswa
        $chartToiletSiswa = [
            $profileSekolahs->sum(fn($item) => $item->toiletSiswa?->baik ?? 0),
            $profileSekolahs->sum(fn($item) => $item->toiletSiswa?->rusak ?? 0),
        ];

        // Kondisi Toilet Guru
        $chartToiletGuru = [
            $profileSekolahs->sum(fn($item) => $item->toiletGuru?->baik ?? 0),
            $profileSekolahs->sum(fn($item) => $item->toiletGuru?->rusak ?? 0),
        ];

        // ====================================================
        // DATA SARANA UTAMA (per-jenis sarana, bukan digabung
        // jadi 1 total — ditampilkan sebagai grouped bar chart)
        // ====================================================
        $fasilitasLabels = [
            'ruangPerpustakaan' => 'R. Perpustakaan',
            'ruangKepalaSekolah' => 'R. Kepsek',
            'ruangGuru' => 'R. Guru',
            'ruangKantorTu' => 'R. Kantor/TU',
            'labIpa' => 'Lab IPA',
            'labKomputer' => 'Lab Komputer',
            'unitKesehatanSekolah' => 'UKS',
            'rumahDinas' => 'Rumah Dinas',
            'rumahIbadah' => 'Rumah Ibadah',
            'lapanganSekolah' => 'Lapangan',
            'pagarSekolah' => 'Pagar',
            'airBersih' => 'Air Bersih',
        ];

        $chartSaranaUtama = [
            'labels' => array_values($fasilitasLabels),
            'baik' => [],
            'rusak_ringan' => [],
            'rusak_sedang' => [],
            'rusak_berat' => [],
            'nihil' => [],
        ];

        foreach ($fasilitasLabels as $rel => $label) {
            $countBaik = 0;
            $countRusakRingan = 0;
            $countRusakSedang = 0;
            $countRusakBerat = 0;
            $countNihil = 0;
            foreach ($profileSekolahs as $item) {
                $kondisiFasilitas = $item->$rel?->kondisi ?? null;
                match ($kondisiFasilitas) {
                    'baik' => $countBaik++,
                    'rusak_ringan' => $countRusakRingan++,
                    'rusak_sedang' => $countRusakSedang++,
                    'rusak_berat' => $countRusakBerat++,
                    default => $countNihil++,
                };
            }
            $chartSaranaUtama['baik'][] = $countBaik;
            $chartSaranaUtama['rusak_ringan'][] = $countRusakRingan;
            $chartSaranaUtama['rusak_sedang'][] = $countRusakSedang;
            $chartSaranaUtama['rusak_berat'][] = $countRusakBerat;
            $chartSaranaUtama['nihil'][] = $countNihil;
        }
    @endphp

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-4 mb-4">
        {{-- CARD 1: TOTAL SISWA & ROMBEL PER TINGKAT --}}
        <div class="card">
            <div class="card-body">
                <h2 class="text-sm font-semibold text-gray-700 dark:text-gray-200 flex items-center gap-2 mb-1">
                    <i class="bi bi-bar-chart-fill"></i> Total Siswa & Rombel per Tingkat
                </h2>
                <p class="text-xs text-gray-500 dark:text-gray-400 mb-2">{{ $profileSekolahs->count() }} Sekolah</p>
                <div class="h-56 sm:h-64">
                    <canvas id="adminChartSiswaRombel"></canvas>
                </div>
            </div>
        </div>

        {{-- CARD 2: TOTAL KONDISI RUANG KELAS --}}
        <div class="card">
            <div class="card-body">
                <h2 class="text-sm font-semibold text-gray-700 dark:text-gray-200 flex items-center gap-2 mb-1">
                    <i class="bi bi-pie-chart-fill"></i> Total Kondisi Ruang Kelas
                </h2>
                <p class="text-xs text-gray-500 dark:text-gray-400 mb-2">{{ $profileSekolahs->count() }} Sekolah</p>
                <div class="h-56 sm:h-64">
                    <canvas id="adminChartRuangKelas"></canvas>
                </div>
            </div>
        </div>

        {{-- CARD 3: TOTAL KONDISI TOILET SISWA (donat) --}}
        <div class="card">
            <div class="card-body">
                <h2 class="text-sm font-semibold text-gray-700 dark:text-gray-200 flex items-center gap-2 mb-1">
                    <i class="bi bi-pie-chart-fill"></i> Total Kondisi Toilet Siswa
                </h2>
                <p class="text-xs text-gray-500 dark:text-gray-400 mb-2">{{ $profileSekolahs->count() }} Sekolah</p>
                <div class="h-56 sm:h-64">
                    <canvas id="adminChartToiletSiswa"></canvas>
                </div>
            </div>
        </div>

        {{-- CARD 4: TOTAL KONDISI TOILET GURU (donat) --}}
        <div class="card">
            <div class="card-body">
                <h2 class="text-sm font-semibold text-gray-700 dark:text-gray-200 flex items-center gap-2 mb-1">
                    <i class="bi bi-pie-chart-fill"></i> Total Kondisi Toilet Guru
                </h2>
                <p class="text-xs text-gray-500 dark:text-gray-400 mb-2">{{ $profileSekolahs->count() }} Sekolah</p>
                <div class="h-56 sm:h-64">
                    <canvas id="adminChartToiletGuru"></canvas>
                </div>
            </div>
        </div>
    </div>

    {{-- CARD 3: DATA SARANA UTAMA (terpisah, grouped bar per jenis sarana) --}}
    <div class="card mb-4">
        <div class="card-body">
            <h2 class="text-sm font-semibold text-gray-700 dark:text-gray-200 flex items-center gap-2 mb-1">
                <i class="bi bi-building-fill-gear"></i> Kondisi Data Sarana Utama
            </h2>
            <p class="text-xs text-gray-500 dark:text-gray-400 mb-2">
                {{ $profileSekolahs->count() }} Sekolah — R. Perpustakaan, R. Kepsek, R. Guru, R. Kantor/TU, Lab
                IPA, Lab Komputer, UKS, Rumah Dinas, Rumah Ibadah, Lapangan, Pagar, Air Bersih
            </p>
            <div class="h-72 sm:h-80">
                <canvas id="adminChartSaranaUtama"></canvas>
            </div>
        </div>
    </div>

    <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between mb-2">
        {{-- ============================================================
             SEARCH BAR (Cari Nama Sekolah) — live filter pakai JS,
             tanpa reload halaman
             ============================================================ --}}
        <div class="flex items-center gap-2 w-full lg:w-auto lg:flex-1 lg:max-w-sm">
            <div class="relative w-full">
                <i class="bi bi-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                <input type="text" id="searchSarana" placeholder="Cari" autocomplete="off"
                    class="w-full pl-9 pr-8 py-1.5 text-sm rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-sky-700 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-primary-500">
                <button type="button" id="searchSaranaClear"
                    class="hidden absolute right-2 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200"
                    title="Hapus pencarian">
                    <i class="bi bi-x-lg text-xs"></i>
                </button>
            </div>
            <span id="searchSaranaCount" class="hidden text-xs text-gray-500 dark:text-gray-400 whitespace-nowrap"></span>
        </div>

        <div class="flex flex-wrap gap-2">
            {{-- Tombol Pengaturan Periode RKB & Rehabilitasi (admin only) --}}
            <a href="{{ route('admin.periode.edit') }}" class="inline-flex">
                <x-button variant="secondary" size="sm">
                    <i class="bi bi-calendar-range"></i> Pengaturan Periode
                </x-button>
            </a>
            {{-- Tombol Export Excel dengan form POST --}}
            <form action="{{ route('data.export') }}" method="POST" class="inline">
                @csrf
                <x-button variant="success" size="sm" type="submit">
                    <i class="bi bi-file-earmark-excel"></i> Export Excel
                </x-button>
            </form>
            {{-- Tombol Tambah Data --}}
            <a href="{{ route('sarana.create') }}" class="inline-flex">
                <x-button variant="primary" size="sm">
                    <i class="bi bi-plus-lg"></i> Tambah Data
                </x-button>
            </a>
        </div>
    </div>

    {{-- ============================================================
         CARD & TABEL UTAMA
         ============================================================ --}}
    <div class="card">
        <div class="card-body">

            <x-table bordered id="tabelSarana" class="text-[11px]">

                {{-- ============================================================
                     HEADER TABEL (3 BARIS DENGAN ROWSPAN & COLSPAN)
                     ============================================================ --}}
                <x-slot:head>

                    {{-- ============================================================
                         BARIS 1: JUDUL UTAMA
                         ============================================================ --}}
                    <tr class="bg-sky-700 text-white text-center">
                        {{-- DATA SEKOLAH (7 kolom) --}}
                        <x-table.heading rowspan="3" class="text-white! align-middle w-7 px-1 py-1">No</x-table.heading>
                        <x-table.heading rowspan="3" class="text-white! align-middle min-w-25 px-1 py-1">Nama
                            Sekolah</x-table.heading>
                        <x-table.heading rowspan="3"
                            class="text-white! align-middle min-w-17.5 px-1 py-1">NPSN</x-table.heading>
                        <x-table.heading rowspan="3"
                            class="text-white! align-middle min-w-30 px-1 py-1">Alamat</x-table.heading>
                        <x-table.heading rowspan="3" class="text-white! align-middle min-w-22.5 px-1 py-1">Kepala
                            Sekolah</x-table.heading>
                        <x-table.heading rowspan="3"
                            class="text-white! align-middle min-w-20 px-1 py-1">NIP</x-table.heading>
                        <x-table.heading rowspan="3" class="text-white! align-middle min-w-17.5 px-1 py-1">No.
                            HP</x-table.heading>

                        {{-- SARANA & PRASARANA (55 kolom) --}}
                        <x-table.heading colspan="61" class="text-white! text-center align-middle px-1 py-1">Sarana
                            &amp;
                            Prasarana</x-table.heading>

                        {{-- AKSI --}}
                        <x-table.heading rowspan="3"
                            class="text-white! align-middle w-20 px-1 py-1">Aksi</x-table.heading>
                    </tr>

                    {{-- ============================================================
                         BARIS 2: KATEGORI
                         ============================================================ --}}
                    <tr class="bg-sky-700 text-white text-center">
                        {{-- URUTAN 1: JUMLAH SISWA (4 kolom) --}}
                        <x-table.heading colspan="4" class="text-white! min-w-16 px-1 py-1">Jumlah
                            Siswa</x-table.heading>

                        {{-- URUTAN 2: JUMLAH ROMBONGAN BELAJAR (4 kolom) --}}
                        <x-table.heading colspan="4" class="text-white! min-w-16 px-1 py-1">Jumlah Rombongan
                            Belajar</x-table.heading>

                        {{-- URUTAN 3: RKB (RUANG KELAS BARU) (1 kolom) --}}
                        <x-table.heading colspan="1" class="text-white! min-w-16 px-1 py-1">
                            Pembangunan Ruang Kelas Baru (RKB) dari
                            ({{ $rkbPeriode->label() }})
                        </x-table.heading>

                        {{-- URUTAN 4: REHABILITASI RUANG KELAS (1 kolom) --}}
                        <x-table.heading colspan="1" class="text-white! min-w-16 px-1 py-1">
                            Rehabilitasi Ruang Kelas dari
                            ({{ $rehabilitasiPeriode->label() }})
                        </x-table.heading>

                        {{-- URUTAN 5: RUANG KELAS (3 kolom) --}}
                        <x-table.heading colspan="3" class="text-white! min-w-16 px-1 py-1">Ruang
                            Kelas</x-table.heading>

                        {{-- URUTAN 6: TOILET SISWA (3 kolom) --}}
                        <x-table.heading colspan="3" class="text-white! min-w-16 px-1 py-1">Toilet
                            Siswa</x-table.heading>

                        {{-- URUTAN 7: TOILET GURU (3 kolom) --}}
                        <x-table.heading colspan="3" class="text-white! min-w-16 px-1 py-1">Toilet / Jamban
                            Guru</x-table.heading>

                        {{-- URUTAN 8: R. PERPUSTAKAAN (2 kolom) --}}
                        <x-table.heading colspan="2" class="text-white! min-w-16 px-1 py-1">R.
                            Perpustakaan</x-table.heading>

                        {{-- URUTAN 9: R. KEPALA SEKOLAH (2 kolom) --}}
                        <x-table.heading colspan="2" class="text-white! min-w-16 px-1 py-1">R. Kepala
                            Sekolah</x-table.heading>

                        {{-- URUTAN 10: R. GURU (2 kolom) --}}
                        <x-table.heading colspan="2" class="text-white! min-w-16 px-1 py-1">R. Guru</x-table.heading>

                        {{-- URUTAN 11: R. KANTOR/TU (2 kolom) --}}
                        <x-table.heading colspan="2" class="text-white! min-w-16 px-1 py-1">R.
                            Kantor/TU</x-table.heading>

                        {{-- URUTAN 12: LAB IPA (2 kolom) --}}
                        <x-table.heading colspan="2" class="text-white! min-w-16 px-1 py-1">R. Laboratorium
                            IPA</x-table.heading>

                        {{-- URUTAN 13: LAB KOMPUTER (2 kolom) --}}
                        <x-table.heading colspan="2" class="text-white! min-w-16 px-1 py-1">Lab
                            Komputer</x-table.heading>

                        {{-- URUTAN 14: UKS (2 kolom) --}}
                        <x-table.heading colspan="2" class="text-white! min-w-16 px-1 py-1">UKS</x-table.heading>

                        {{-- URUTAN 15: RUMAH DINAS (2 kolom) --}}
                        <x-table.heading colspan="2" class="text-white! min-w-16 px-1 py-1">Rumah
                            Dinas</x-table.heading>

                        {{-- URUTAN 16: RUMAH IBADAH (2 kolom) --}}
                        <x-table.heading colspan="2" class="text-white! min-w-16 px-1 py-1">Rumah
                            Ibadah</x-table.heading>

                        {{-- URUTAN 17: LAPANGAN SEKOLAH (2 kolom) --}}
                        <x-table.heading colspan="2" class="text-white! min-w-16 px-1 py-1">Lapangan
                            Sekolah</x-table.heading>

                        {{-- URUTAN 18: PAGAR (2 kolom) --}}
                        <x-table.heading colspan="2" class="text-white! min-w-12.5 px-1 py-1">Pagar</x-table.heading>

                        {{-- URUTAN 19: AIR (2 kolom) --}}
                        <x-table.heading colspan="2" class="text-white! min-w-12.5 px-1 py-1">Air</x-table.heading>

                        {{-- URUTAN 20: KURSI SISWA (3 kolom) --}}
                        <x-table.heading colspan="3" class="text-white! min-w-16 px-1 py-1">Kursi
                            Siswa</x-table.heading>

                        {{-- URUTAN 21: MEJA SISWA (3 kolom) --}}
                        <x-table.heading colspan="3" class="text-white! min-w-16 px-1 py-1">Meja
                            Siswa</x-table.heading>

                        {{-- URUTAN 22: KURSI GURU (3 kolom) --}}
                        <x-table.heading colspan="3" class="text-white! min-w-16 px-1 py-1">Kursi
                            Guru</x-table.heading>

                        {{-- URUTAN 23: MEJA GURU (3 kolom) --}}
                        <x-table.heading colspan="3" class="text-white! min-w-16 px-1 py-1">Meja Guru</x-table.heading>

                        {{-- URUTAN 24: LAPTOP (3 kolom) --}}
                        <x-table.heading colspan="3" class="text-white! min-w-16 px-1 py-1">Laptop /
                            Chromebook</x-table.heading>


                        {{-- URUTAN 25: KOMPUTER (3 kolom) --}}
                        <x-table.heading colspan="3" class="text-white! min-w-16 px-1 py-1">Komputer</x-table.heading>
                    </tr>

                    {{-- ============================================================
                         BARIS 3: DETAIL
                         ============================================================ --}}
                    <tr class="bg-sky-100 dark:bg-sky-900/40 text-center">

                        {{-- URUTAN 1: JUMLAH SISWA --}}

                        <x-table.heading class="text-[10px] px-1 py-0.5">VII</x-table.heading>
                        <x-table.heading class="text-[10px] px-1 py-0.5">VIII</x-table.heading>
                        <x-table.heading class="text-[10px] px-1 py-0.5">IX</x-table.heading>
                        <x-table.heading
                            class="text-[10px] px-1 py-0.5 bg-orange-200 dark:bg-orange-800/60 font-bold">Jumlah</x-table.heading>

                        {{-- URUTAN 2: JUMLAH ROMBONGAN BELAJAR --}}

                        <x-table.heading class="text-[10px] px-1 py-0.5">VII</x-table.heading>
                        <x-table.heading class="text-[10px] px-1 py-0.5">VIII</x-table.heading>
                        <x-table.heading class="text-[10px] px-1 py-0.5">IX</x-table.heading>
                        <x-table.heading
                            class="text-[10px] px-1 py-0.5 bg-orange-200 dark:bg-orange-800/60 font-bold">Jumlah</x-table.heading>

                        {{-- URUTAN 3: RKB (RUANG KELAS BARU) --}}

                        <x-table.heading
                            class="text-[10px] px-1 py-0.5 bg-orange-200 dark:bg-orange-800/60 font-bold">Jumlah</x-table.heading>

                        {{-- URUTAN 4: REHABILITASI RUANG KELAS --}}

                        <x-table.heading
                            class="text-[10px] px-1 py-0.5 bg-orange-200 dark:bg-orange-800/60 font-bold">Jumlah</x-table.heading>

                        {{-- URUTAN 5: RUANG KELAS --}}

                        <x-table.heading class="text-[10px] px-1 py-0.5">Baik</x-table.heading>
                        <x-table.heading class="text-[10px] px-1 py-0.5">Rusak</x-table.heading>
                        <x-table.heading
                            class="text-[10px] px-1 py-0.5 bg-orange-200 dark:bg-orange-800/60 font-bold">Jumlah</x-table.heading>

                        {{-- URUTAN 6: TOILET SISWA --}}

                        <x-table.heading class="text-[10px] px-1 py-0.5">Baik</x-table.heading>
                        <x-table.heading class="text-[10px] px-1 py-0.5">Rusak</x-table.heading>
                        <x-table.heading
                            class="text-[10px] px-1 py-0.5 bg-orange-200 dark:bg-orange-800/60 font-bold">Jumlah</x-table.heading>

                        {{-- URUTAN 7: TOILET GURU --}}

                        <x-table.heading class="text-[10px] px-1 py-0.5">Baik</x-table.heading>
                        <x-table.heading class="text-[10px] px-1 py-0.5">Rusak</x-table.heading>
                        <x-table.heading
                            class="text-[10px] px-1 py-0.5 bg-orange-200 dark:bg-orange-800/60 font-bold">Jumlah</x-table.heading>

                        {{-- URUTAN 8: R. PERPUSTAKAAN --}}

                        <x-table.heading class="text-[10px] px-1 py-0.5">Ada/Tidak</x-table.heading>
                        <x-table.heading class="text-[10px] px-1 py-0.5">Kondisi</x-table.heading>

                        {{-- URUTAN 9: R. KEPALA SEKOLAH --}}

                        <x-table.heading class="text-[10px] px-1 py-0.5">Ada/Tidak</x-table.heading>
                        <x-table.heading class="text-[10px] px-1 py-0.5">Kondisi</x-table.heading>

                        {{-- URUTAN 10: R. GURU --}}

                        <x-table.heading class="text-[10px] px-1 py-0.5">Ada/Tidak</x-table.heading>
                        <x-table.heading class="text-[10px] px-1 py-0.5">Kondisi</x-table.heading>

                        {{-- URUTAN 11: R. KANTOR/TU --}}

                        <x-table.heading class="text-[10px] px-1 py-0.5">Ada/Tidak</x-table.heading>
                        <x-table.heading class="text-[10px] px-1 py-0.5">Kondisi</x-table.heading>

                        {{-- URUTAN 12: LAB IPA --}}

                        <x-table.heading class="text-[10px] px-1 py-0.5">Ada/Tidak</x-table.heading>
                        <x-table.heading class="text-[10px] px-1 py-0.5">Kondisi</x-table.heading>

                        {{-- URUTAN 13: LAB KOMPUTER --}}

                        <x-table.heading class="text-[10px] px-1 py-0.5">Ada/Tidak</x-table.heading>
                        <x-table.heading class="text-[10px] px-1 py-0.5">Kondisi</x-table.heading>

                        {{-- URUTAN 14: UKS --}}

                        <x-table.heading class="text-[10px] px-1 py-0.5">Ada/Tidak</x-table.heading>
                        <x-table.heading class="text-[10px] px-1 py-0.5">Kondisi</x-table.heading>

                        {{-- URUTAN 15: RUMAH DINAS --}}

                        <x-table.heading class="text-[10px] px-1 py-0.5">Ada/Tidak</x-table.heading>
                        <x-table.heading class="text-[10px] px-1 py-0.5">Kondisi</x-table.heading>

                        {{-- URUTAN 16: RUMAH IBADAH --}}

                        <x-table.heading class="text-[10px] px-1 py-0.5">Ada/Tidak</x-table.heading>
                        <x-table.heading class="text-[10px] px-1 py-0.5">Kondisi</x-table.heading>

                        {{-- URUTAN 17: LAPANGAN SEKOLAH --}}

                        <x-table.heading class="text-[10px] px-1 py-0.5">Ada/Tidak</x-table.heading>
                        <x-table.heading class="text-[10px] px-1 py-0.5">Kondisi</x-table.heading>

                        {{-- URUTAN 18: PAGAR --}}

                        <x-table.heading class="text-[10px] px-1 py-0.5">Ada/Tidak</x-table.heading>
                        <x-table.heading class="text-[10px] px-1 py-0.5">Kondisi</x-table.heading>

                        {{-- URUTAN 19: AIR --}}

                        <x-table.heading class="text-[10px] px-1 py-0.5">Ada/Tidak</x-table.heading>
                        <x-table.heading class="text-[10px] px-1 py-0.5">Kondisi</x-table.heading>

                        {{-- URUTAN 20: KURSI SISWA --}}

                        <x-table.heading class="text-[10px] px-1 py-0.5">Baik</x-table.heading>
                        <x-table.heading class="text-[10px] px-1 py-0.5">Rusak</x-table.heading>
                        <x-table.heading
                            class="text-[10px] px-1 py-0.5 bg-orange-200 dark:bg-orange-800/60 font-bold">Jumlah</x-table.heading>

                        {{-- URUTAN 21: MEJA SISWA --}}

                        <x-table.heading class="text-[10px] px-1 py-0.5">Baik</x-table.heading>
                        <x-table.heading class="text-[10px] px-1 py-0.5">Rusak</x-table.heading>
                        <x-table.heading
                            class="text-[10px] px-1 py-0.5 bg-orange-200 dark:bg-orange-800/60 font-bold">Jumlah</x-table.heading>

                        {{-- URUTAN 22: KURSI GURU --}}

                        <x-table.heading class="text-[10px] px-1 py-0.5">Baik</x-table.heading>
                        <x-table.heading class="text-[10px] px-1 py-0.5">Rusak</x-table.heading>
                        <x-table.heading
                            class="text-[10px] px-1 py-0.5 bg-orange-200 dark:bg-orange-800/60 font-bold">Jumlah</x-table.heading>

                        {{-- URUTAN 23: MEJA GURU --}}

                        <x-table.heading class="text-[10px] px-1 py-0.5">Baik</x-table.heading>
                        <x-table.heading class="text-[10px] px-1 py-0.5">Rusak</x-table.heading>
                        <x-table.heading
                            class="text-[10px] px-1 py-0.5 bg-orange-200 dark:bg-orange-800/60 font-bold">Jumlah</x-table.heading>

                        {{-- URUTAN 24: LAPTOP --}}

                        <x-table.heading class="text-[10px] px-1 py-0.5">Baik</x-table.heading>
                        <x-table.heading class="text-[10px] px-1 py-0.5">Rusak</x-table.heading>
                        <x-table.heading
                            class="text-[10px] px-1 py-0.5 bg-orange-200 dark:bg-orange-800/60 font-bold">Jumlah</x-table.heading>


                        {{-- URUTAN 25: KOMPUTER --}}

                        <x-table.heading class="text-[10px] px-1 py-0.5">Baik</x-table.heading>
                        <x-table.heading class="text-[10px] px-1 py-0.5">Rusak</x-table.heading>
                        <x-table.heading
                            class="text-[10px] px-1 py-0.5 bg-orange-200 dark:bg-orange-800/60 font-bold">Jumlah</x-table.heading>

                    </tr>

                    {{-- ============================================================
                         RINGKASAN TOTAL (dipindah ke atas / bawah header tabel,
                         supaya terlihat tanpa perlu scroll ke bawah)
                         ============================================================ --}}
                    {{-- ============================================================
                         BARIS 1: TOTAL DATA + JUMLAH PER KATEGORI
                         ============================================================ --}}
                    <tr class="bg-gray-100 dark:bg-gray-700">
                        {{-- Total Data --}}
                        <x-table.cell colspan="7" class="font-bold">Total Data:
                            {{ $profileSekolahs->count() }}</x-table.cell>

                        {{-- URUTAN 1: JUMLAH SISWA --}}

                        {{-- VII --}}
                        <x-table.cell class="text-center font-bold">
                            {{ $profileSekolahs->sum(fn($item) => $item->jumlahSiswa?->vii ?? 0) }}
                        </x-table.cell>

                        {{-- VIII --}}
                        <x-table.cell class="text-center font-bold">
                            {{ $profileSekolahs->sum(fn($item) => $item->jumlahSiswa?->viii ?? 0) }}
                        </x-table.cell>

                        {{-- IX --}}
                        <x-table.cell class="text-center font-bold">
                            {{ $profileSekolahs->sum(fn($item) => $item->jumlahSiswa?->ix ?? 0) }}
                        </x-table.cell>

                        {{-- total jumlah --}}
                        <x-table.cell class="text-center font-bold bg-orange-200 dark:bg-orange-800/60">
                            {{ $profileSekolahs->sum(fn($item) => ($item->jumlahSiswa?->vii ?? 0) + ($item->jumlahSiswa?->viii ?? 0) + ($item->jumlahSiswa?->ix ?? 0)) }}
                        </x-table.cell>

                        {{-- URUTAN 2: JUMLAH ROMBONGAN BELAJAR --}}
                        {{-- VII --}}
                        <x-table.cell class="text-center font-bold">
                            {{ $profileSekolahs->sum(fn($item) => $item->jumlahRombel?->vii ?? 0) }}
                        </x-table.cell>

                        {{-- VIII --}}
                        <x-table.cell class="text-center font-bold">
                            {{ $profileSekolahs->sum(fn($item) => $item->jumlahRombel?->viii ?? 0) }}
                        </x-table.cell>

                        {{-- IX --}}
                        <x-table.cell class="text-center font-bold">
                            {{ $profileSekolahs->sum(fn($item) => $item->jumlahRombel?->ix ?? 0) }}
                        </x-table.cell>

                        <x-table.cell class="text-center font-bold bg-orange-200 dark:bg-orange-800/60">
                            {{ $profileSekolahs->sum(fn($item) => ($item->jumlahRombel?->vii ?? 0) + ($item->jumlahRombel?->viii ?? 0) + ($item->jumlahRombel?->ix ?? 0)) }}
                        </x-table.cell>

                        {{-- URUTAN 3: RKB (RUANG KELAS BARU) --}}
                        <x-table.cell class="text-center font-bold bg-orange-200 dark:bg-orange-800/60">
                            {{ $profileSekolahs->sum(fn($item) => $item->ruangKelasBaru?->jumlah ?? 0) }}
                        </x-table.cell>

                        {{-- URUTAN 4: REHABILITASI RUANG KELAS --}}
                        <x-table.cell class="text-center font-bold bg-orange-200 dark:bg-orange-800/60">
                            {{ $profileSekolahs->sum(fn($item) => $item->rehabilitasiRuangKelas?->jumlah ?? 0) }}
                        </x-table.cell>

                        {{-- URUTAN 5: RUANG KELAS --}}

                        {{-- baik --}}
                        <x-table.cell class="text-center font-bold">
                            {{ $profileSekolahs->sum(fn($item) => $item->ruangKelas?->baik ?? 0) }}
                        </x-table.cell>

                        {{-- RUSAK --}}
                        <x-table.cell class="text-center font-bold">
                            {{ $profileSekolahs->sum(fn($item) => $item->ruangKelas?->rusak ?? 0) }}
                        </x-table.cell>

                        {{-- TOTAL --}}
                        <x-table.cell class="text-center font-bold bg-orange-200 dark:bg-orange-800/60">
                            {{ $profileSekolahs->sum(fn($item) => ($item->ruangKelas?->baik ?? 0) + ($item->ruangKelas?->rusak ?? 0)) }}
                        </x-table.cell>

                        {{-- URUTAN 6: TOILET SISWA --}}

                        {{-- baik --}}
                        <x-table.cell class="text-center font-bold">
                            {{ $profileSekolahs->sum(fn($item) => ($item->toiletSiswa?->baik ?? 0) + ($item->ruangKelas?->rusak ?? 0)) }}
                        </x-table.cell>

                        {{-- RUSAK --}}
                        <x-table.cell class="text-center font-bold">
                            {{ $profileSekolahs->sum(fn($item) => ($item->toiletSiswa?->rusak ?? 0) + ($item->ruangKelas?->rusak ?? 0)) }}
                        </x-table.cell>

                        {{-- TOTAL --}}
                        <x-table.cell class="text-center font-bold bg-orange-200 dark:bg-orange-800/60">
                            {{ $profileSekolahs->sum(fn($item) => ($item->toiletSiswa?->baik ?? 0) + ($item->toiletSiswa?->rusak ?? 0)) }}
                        </x-table.cell>

                        {{-- URUTAN 7: TOILET GURU --}}

                        {{-- baik --}}
                        <x-table.cell class="text-center font-bold">
                            {{ $profileSekolahs->sum(fn($item) => ($item->toiletGuru?->baik ?? 0) + ($item->ruangKelas?->rusak ?? 0)) }}
                        </x-table.cell>

                        {{-- RUSAK --}}
                        <x-table.cell class="text-center font-bold">
                            {{ $profileSekolahs->sum(fn($item) => ($item->toiletGuru?->rusak ?? 0) + ($item->ruangKelas?->rusak ?? 0)) }}
                        </x-table.cell>

                        {{-- TOTAL --}}
                        <x-table.cell class="text-center font-bold bg-orange-200 dark:bg-orange-800/60">
                            {{ $profileSekolahs->sum(fn($item) => ($item->toiletGuru?->baik ?? 0) + ($item->toiletGuru?->rusak ?? 0)) }}
                        </x-table.cell>

                        {{-- URUTAN 8: R. PERPUSTAKAAN --}}

                        {{-- KEBERADAAN --}}
                        <x-table.cell class="text-center font-bold">
                            <span
                                class="text-emerald-600 font-bold">{{ $profileSekolahs->filter(fn($item) => ($item->ruangPerpustakaan?->{'ada/tidak_ada'} ?? null) === 'ada')->count() }}</span>
                            / <span
                                class="text-red-600 font-bold">{{ $profileSekolahs->filter(fn($item) => ($item->ruangPerpustakaan?->{'ada/tidak_ada'} ?? null) === 'tidak_ada')->count() }}</span>
                        </x-table.cell>

                        {{-- KONDISI --}}
                        <x-table.cell class="text-center font-bold">
                            <span
                                class="text-emerald-600 font-bold">{{ $profileSekolahs->filter(fn($item) => ($item->ruangPerpustakaan?->kondisi ?? null) === 'baik')->count() }}</span>
                            / <span
                                class="text-amber-600 font-bold">{{ $profileSekolahs->filter(fn($item) => in_array($item->ruangPerpustakaan?->kondisi ?? null, ['rusak_ringan', 'rusak_sedang', 'rusak_berat']))->count() }}</span>
                        </x-table.cell>

                        {{-- URUTAN 9: R. KEPALA SEKOLAH --}}

                        {{-- KEBERADAAN --}}
                        <x-table.cell class="text-center font-bold">
                            <span
                                class="text-emerald-600 font-bold">{{ $profileSekolahs->filter(fn($item) => ($item->ruangKepalaSekolah?->{'ada/tidak_ada'} ?? null) === 'ada')->count() }}</span>
                            / <span
                                class="text-red-600 font-bold">{{ $profileSekolahs->filter(fn($item) => ($item->ruangKepalaSekolah?->{'ada/tidak_ada'} ?? null) === 'tidak_ada')->count() }}</span>
                        </x-table.cell>

                        {{-- KONDISI --}}
                        <x-table.cell class="text-center font-bold">
                            <span
                                class="text-emerald-600 font-bold">{{ $profileSekolahs->filter(fn($item) => ($item->ruangKepalaSekolah?->kondisi ?? null) === 'baik')->count() }}</span>
                            / <span
                                class="text-amber-600 font-bold">{{ $profileSekolahs->filter(fn($item) => in_array($item->ruangKepalaSekolah?->kondisi ?? null, ['rusak_ringan', 'rusak_sedang', 'rusak_berat']))->count() }}</span>
                        </x-table.cell>

                        {{-- URUTAN 10: R. GURU --}}

                        {{-- KEBERADAAN --}}
                        <x-table.cell class="text-center font-bold">
                            <span
                                class="text-emerald-600 font-bold">{{ $profileSekolahs->filter(fn($item) => ($item->ruangGuru?->{'ada/tidak_ada'} ?? null) === 'ada')->count() }}</span>
                            / <span
                                class="text-red-600 font-bold">{{ $profileSekolahs->filter(fn($item) => ($item->ruangGuru?->{'ada/tidak_ada'} ?? null) === 'tidak_ada')->count() }}</span>
                        </x-table.cell>

                        {{-- KONDISI --}}
                        <x-table.cell class="text-center font-bold">
                            <span
                                class="text-emerald-600 font-bold">{{ $profileSekolahs->filter(fn($item) => ($item->ruangGuru?->kondisi ?? null) === 'baik')->count() }}</span>
                            / <span
                                class="text-amber-600 font-bold">{{ $profileSekolahs->filter(fn($item) => in_array($item->ruangGuru?->kondisi ?? null, ['rusak_ringan', 'rusak_sedang', 'rusak_berat']))->count() }}</span>
                        </x-table.cell>

                        {{-- URUTAN 11: R. KANTOR/TU --}}

                        {{-- KEBERADAAN --}}
                        <x-table.cell class="text-center font-bold">
                            <span
                                class="text-emerald-600 font-bold">{{ $profileSekolahs->filter(fn($item) => ($item->ruangKantorTu?->{'ada/tidak_ada'} ?? null) === 'ada')->count() }}</span>
                            / <span
                                class="text-red-600 font-bold">{{ $profileSekolahs->filter(fn($item) => ($item->ruangKantorTu?->{'ada/tidak_ada'} ?? null) === 'tidak_ada')->count() }}</span>
                        </x-table.cell>

                        {{-- KONDISI --}}
                        <x-table.cell class="text-center font-bold">
                            <span
                                class="text-emerald-600 font-bold">{{ $profileSekolahs->filter(fn($item) => ($item->ruangKantorTu?->kondisi ?? null) === 'baik')->count() }}</span>
                            / <span
                                class="text-amber-600 font-bold">{{ $profileSekolahs->filter(fn($item) => in_array($item->ruangKantorTu?->kondisi ?? null, ['rusak_ringan', 'rusak_sedang', 'rusak_berat']))->count() }}</span>
                        </x-table.cell>

                        {{-- URUTAN 12: LAB IPA --}}
                        {{-- KEBERADAAN --}}
                        <x-table.cell class="text-center font-bold">
                            <span
                                class="text-emerald-600 font-bold">{{ $profileSekolahs->filter(fn($item) => ($item->labIpa?->{'ada/tidak_ada'} ?? null) === 'ada')->count() }}</span>
                            / <span
                                class="text-red-600 font-bold">{{ $profileSekolahs->filter(fn($item) => ($item->labIpa?->{'ada/tidak_ada'} ?? null) === 'tidak_ada')->count() }}</span>
                        </x-table.cell>

                        {{-- KONDISI --}}
                        <x-table.cell class="text-center font-bold">
                            <span
                                class="text-emerald-600 font-bold">{{ $profileSekolahs->filter(fn($item) => ($item->labIpa?->kondisi ?? null) === 'baik')->count() }}</span>
                            / <span
                                class="text-amber-600 font-bold">{{ $profileSekolahs->filter(fn($item) => in_array($item->labIpa?->kondisi ?? null, ['rusak_ringan', 'rusak_sedang', 'rusak_berat']))->count() }}</span>
                        </x-table.cell>

                        {{-- URUTAN 13: LAB KOMPUTER --}}

                        {{-- KEBERADAAN --}}
                        <x-table.cell class="text-center font-bold">
                            <span
                                class="text-emerald-600 font-bold">{{ $profileSekolahs->filter(fn($item) => ($item->labIpa?->{'ada/tidak_ada'} ?? null) === 'ada')->count() }}</span>
                            / <span
                                class="text-red-600 font-bold">{{ $profileSekolahs->filter(fn($item) => ($item->labIpa?->{'ada/tidak_ada'} ?? null) === 'tidak_ada')->count() }}</span>
                        </x-table.cell>

                        {{-- KONDISI --}}
                        <x-table.cell class="text-center font-bold">
                            <span
                                class="text-emerald-600 font-bold">{{ $profileSekolahs->filter(fn($item) => ($item->labIpa?->kondisi ?? null) === 'baik')->count() }}</span>
                            / <span
                                class="text-amber-600 font-bold">{{ $profileSekolahs->filter(fn($item) => in_array($item->labIpa?->kondisi ?? null, ['rusak_ringan', 'rusak_sedang', 'rusak_berat']))->count() }}</span>
                        </x-table.cell>

                        {{-- URUTAN 14: UKS --}}

                        {{-- KEBERADAAN --}}
                        <x-table.cell class="text-center font-bold">
                            <span
                                class="text-emerald-600 font-bold">{{ $profileSekolahs->filter(fn($item) => ($item->uks?->{'ada/tidak_ada'} ?? null) === 'ada')->count() }}</span>
                            / <span
                                class="text-red-600 font-bold">{{ $profileSekolahs->filter(fn($item) => ($item->uks?->{'ada/tidak_ada'} ?? null) === 'tidak_ada')->count() }}</span>
                        </x-table.cell>

                        {{-- KONDISI --}}
                        <x-table.cell class="text-center font-bold">
                            <span
                                class="text-emerald-600 font-bold">{{ $profileSekolahs->filter(fn($item) => ($item->uks?->kondisi ?? null) === 'baik')->count() }}</span>
                            / <span
                                class="text-amber-600 font-bold">{{ $profileSekolahs->filter(fn($item) => in_array($item->uks?->kondisi ?? null, ['rusak_ringan', 'rusak_sedang', 'rusak_berat']))->count() }}</span>
                        </x-table.cell>

                        {{-- URUTAN 15: RUMAH DINAS --}}
                        {{-- KEBERADAAN --}}
                        <x-table.cell class="text-center font-bold">
                            <span
                                class="text-emerald-600 font-bold">{{ $profileSekolahs->filter(fn($item) => ($item->rumahDinas?->{'ada/tidak_ada'} ?? null) === 'ada')->count() }}</span>
                            / <span
                                class="text-red-600 font-bold">{{ $profileSekolahs->filter(fn($item) => ($item->rumahDinas?->{'ada/tidak_ada'} ?? null) === 'tidak_ada')->count() }}</span>
                        </x-table.cell>

                        {{-- KONDISI --}}
                        <x-table.cell class="text-center font-bold">
                            <span
                                class="text-emerald-600 font-bold">{{ $profileSekolahs->filter(fn($item) => ($item->rumahDinas?->kondisi ?? null) === 'baik')->count() }}</span>
                            / <span
                                class="text-amber-600 font-bold">{{ $profileSekolahs->filter(fn($item) => in_array($item->rumahDinas?->kondisi ?? null, ['rusak_ringan', 'rusak_sedang', 'rusak_berat']))->count() }}</span>
                        </x-table.cell>

                        {{-- URUTAN 16: RUMAH IBADAH --}}

                        {{-- KEBERADAAN --}}
                        <x-table.cell class="text-center font-bold">
                            <span
                                class="text-emerald-600 font-bold">{{ $profileSekolahs->filter(fn($item) => ($item->rumahIbadah?->{'ada/tidak_ada'} ?? null) === 'ada')->count() }}</span>
                            / <span
                                class="text-red-600 font-bold">{{ $profileSekolahs->filter(fn($item) => ($item->rumahIbadah?->{'ada/tidak_ada'} ?? null) === 'tidak_ada')->count() }}</span>
                        </x-table.cell>

                        {{-- KONDISI --}}
                        <x-table.cell class="text-center font-bold">
                            <span
                                class="text-emerald-600 font-bold">{{ $profileSekolahs->filter(fn($item) => ($item->rumahIbadah?->kondisi ?? null) === 'baik')->count() }}</span>
                            / <span
                                class="text-amber-600 font-bold">{{ $profileSekolahs->filter(fn($item) => in_array($item->rumahIbadah?->kondisi ?? null, ['rusak_ringan', 'rusak_sedang', 'rusak_berat']))->count() }}</span>
                        </x-table.cell>

                        {{-- URUTAN 17: LAPANGAN SEKOLAH --}}

                        {{-- KEBERADAAN --}}
                        <x-table.cell class="text-center font-bold">
                            <span
                                class="text-emerald-600 font-bold">{{ $profileSekolahs->filter(fn($item) => ($item->lapanganSekolah?->{'ada/tidak_ada'} ?? null) === 'ada')->count() }}</span>
                            / <span
                                class="text-red-600 font-bold">{{ $profileSekolahs->filter(fn($item) => ($item->lapanganSekolah?->{'ada/tidak_ada'} ?? null) === 'tidak_ada')->count() }}</span>
                        </x-table.cell>

                        {{-- KONDISI --}}
                        <x-table.cell class="text-center font-bold">
                            <span
                                class="text-emerald-600 font-bold">{{ $profileSekolahs->filter(fn($item) => ($item->lapanganSekolah?->kondisi ?? null) === 'baik')->count() }}</span>
                            / <span
                                class="text-amber-600 font-bold">{{ $profileSekolahs->filter(fn($item) => in_array($item->lapanganSekolah?->kondisi ?? null, ['rusak_ringan', 'rusak_sedang', 'rusak_berat']))->count() }}</span>
                        </x-table.cell>

                        {{-- URUTAN 18: PAGAR --}}

                        {{-- KEBERADAAN --}}
                        <x-table.cell class="text-center font-bold">
                            <span
                                class="text-emerald-600 font-bold">{{ $profileSekolahs->filter(fn($item) => ($item->pagarSekolah?->{'ada/tidak_ada'} ?? null) === 'ada')->count() }}</span>
                            / <span
                                class="text-red-600 font-bold">{{ $profileSekolahs->filter(fn($item) => ($item->pagarSekolah?->{'ada/tidak_ada'} ?? null) === 'tidak_ada')->count() }}</span>
                        </x-table.cell>

                        {{-- KONDISI --}}
                        <x-table.cell class="text-center font-bold">
                            <span
                                class="text-emerald-600 font-bold">{{ $profileSekolahs->filter(fn($item) => ($item->pagarSekolah?->kondisi ?? null) === 'baik')->count() }}</span>
                            / <span
                                class="text-amber-600 font-bold">{{ $profileSekolahs->filter(fn($item) => in_array($item->pagarSekolah?->kondisi ?? null, ['rusak_ringan', 'rusak_sedang', 'rusak_berat']))->count() }}</span>
                        </x-table.cell>

                        {{-- URUTAN 19: AIR --}}

                        {{-- KEBERADAAN --}}
                        <x-table.cell class="text-center font-bold">
                            <span
                                class="text-emerald-600 font-bold">{{ $profileSekolahs->filter(fn($item) => ($item->airBersih?->{'ada/tidak_ada'} ?? null) === 'ada')->count() }}</span>
                            / <span
                                class="text-red-600 font-bold">{{ $profileSekolahs->filter(fn($item) => ($item->airBersih?->{'ada/tidak_ada'} ?? null) === 'tidak_ada')->count() }}</span>
                        </x-table.cell>

                        {{-- KONDISI --}}
                        <x-table.cell class="text-center font-bold">
                            <span
                                class="text-emerald-600 font-bold">{{ $profileSekolahs->filter(fn($item) => ($item->airBersih?->kondisi ?? null) === 'baik')->count() }}</span>
                            / <span
                                class="text-amber-600 font-bold">{{ $profileSekolahs->filter(fn($item) => in_array($item->airBersih?->kondisi ?? null, ['rusak_ringan', 'rusak_sedang', 'rusak_berat']))->count() }}</span>
                        </x-table.cell>

                        {{-- URUTAN 20: KURSI SISWA --}}

                        {{-- baik --}}
                        <x-table.cell class="text-center font-bold">
                            {{ $profileSekolahs->sum(fn($item) => $item->kusriSiswa?->baik ?? 0) }}
                        </x-table.cell>

                        {{-- RUSAK --}}
                        <x-table.cell class="text-center font-bold">
                            {{ $profileSekolahs->sum(fn($item) => $item->kusriSiswa?->rusak ?? 0) }}
                        </x-table.cell>

                        <x-table.cell class="text-center font-bold bg-orange-200 dark:bg-orange-800/60">
                            {{ $profileSekolahs->sum(fn($item) => ($item->kursiSiswa?->baik ?? 0) + ($item->kursiSiswa?->rusak ?? 0)) }}
                        </x-table.cell>

                        {{-- URUTAN 21: MEJA SISWA --}}

                        {{-- baik --}}
                        <x-table.cell class="text-center font-bold">
                            {{ $profileSekolahs->sum(fn($item) => $item->mejaSiswa?->baik ?? 0) }}
                        </x-table.cell>

                        {{-- RUSAK --}}
                        <x-table.cell class="text-center font-bold">
                            {{ $profileSekolahs->sum(fn($item) => $item->mejaSiswa?->rusak ?? 0) }}
                        </x-table.cell>

                        <x-table.cell class="text-center font-bold bg-orange-200 dark:bg-orange-800/60">
                            {{ $profileSekolahs->sum(fn($item) => ($item->mejaSiswa?->baik ?? 0) + ($item->mejaSiswa?->rusak ?? 0)) }}
                        </x-table.cell>

                        {{-- URUTAN 22: KURSI GURU --}}
                        {{-- baik --}}
                        <x-table.cell class="text-center font-bold">
                            {{ $profileSekolahs->sum(fn($item) => $item->kursiGuru?->baik ?? 0) }}
                        </x-table.cell>

                        {{-- RUSAK --}}
                        <x-table.cell class="text-center font-bold">
                            {{ $profileSekolahs->sum(fn($item) => $item->kursiGuru?->rusak ?? 0) }}
                        </x-table.cell>

                        <x-table.cell class="text-center font-bold bg-orange-200 dark:bg-orange-800/60">
                            {{ $profileSekolahs->sum(fn($item) => ($item->kursiGuru?->baik ?? 0) + ($item->kursiGuru?->rusak ?? 0)) }}
                        </x-table.cell>

                        {{-- URUTAN 23: MEJA GURU --}}

                        {{-- baik --}}
                        <x-table.cell class="text-center font-bold">
                            {{ $profileSekolahs->sum(fn($item) => $item->mejaGuru?->baik ?? 0) }}
                        </x-table.cell>

                        {{-- RUSAK --}}
                        <x-table.cell class="text-center font-bold">
                            {{ $profileSekolahs->sum(fn($item) => $item->mejaGuru?->rusak ?? 0) }}
                        </x-table.cell>

                        <x-table.cell class="text-center font-bold bg-orange-200 dark:bg-orange-800/60">
                            {{ $profileSekolahs->sum(fn($item) => ($item->mejaGuru?->baik ?? 0) + ($item->mejaGuru?->rusak ?? 0)) }}
                        </x-table.cell>

                        {{-- URUTAN 24: LAPTOP --}}

                        {{-- baik --}}
                        <x-table.cell class="text-center font-bold">
                            {{ $profileSekolahs->sum(fn($item) => $item->laptop?->baik ?? 0) }}
                        </x-table.cell>

                        {{-- RUSAK --}}
                        <x-table.cell class="text-center font-bold">
                            {{ $profileSekolahs->sum(fn($item) => $item->laptop?->rusak ?? 0) }}
                        </x-table.cell>

                        <x-table.cell class="text-center font-bold bg-orange-200 dark:bg-orange-800/60">
                            {{ $profileSekolahs->sum(fn($item) => ($item->laptop?->baik ?? 0) + ($item->laptop?->rusak ?? 0)) }}
                        </x-table.cell>

                        {{-- URUTAN 25: KOMPUTER --}}

                        {{-- baik --}}
                        <x-table.cell class="text-center font-bold">
                            {{ $profileSekolahs->sum(fn($item) => $item->komputer?->baik ?? 0) }}
                        </x-table.cell>

                        {{-- RUSAK --}}
                        <x-table.cell class="text-center font-bold">
                            {{ $profileSekolahs->sum(fn($item) => $item->komputer?->rusak ?? 0) }}
                        </x-table.cell>

                        <x-table.cell class="text-center font-bold bg-orange-200 dark:bg-orange-800/60">
                            {{ $profileSekolahs->sum(fn($item) => ($item->komputer?->baik ?? 0) + ($item->komputer?->rusak ?? 0)) }}
                        </x-table.cell>

                        <x-table.cell></x-table.cell>
                    </tr>
                </x-slot:head>

                {{-- ============================================================
                     BODY TABEL
                     ============================================================ --}}
                @forelse ($profileSekolahs as $item)
                    @php
                        // ============================================================
                        // VARIABEL PERHITUNGAN
                        // ============================================================

                        // 1. JUMLAH SISWA
                        $jmlJumlahSiswa =
                            ($item->jumlahSiswa?->vii ?? 0) +
                            ($item->jumlahSiswa?->viii ?? 0) +
                            ($item->jumlahSiswa?->ix ?? 0);

                        // 2. JUMLAH ROMBONGAN BELAJAR
                        $jmlJumlahRombel =
                            ($item->jumlahRombel?->vii ?? 0) +
                            ($item->jumlahRombel?->viii ?? 0) +
                            ($item->jumlahRombel?->ix ?? 0);

                        // 3. RKB (RUANG KELAS BARU)

                        // 4. REHABILITASI RUANG KELAS

                        // 5. RUANG KELAS
                        $jmlRuangKelas = ($item->ruangKelas?->baik ?? 0) + ($item->ruangKelas?->rusak ?? 0);

                        // 6. TOILET SISWA
                        $jmlToiletSiswa = ($item->toiletSiswa?->baik ?? 0) + ($item->toiletSiswa?->rusak ?? 0);

                        // 7. TOILET GURU
                        $jmlToiletGuru = ($item->toiletGuru?->baik ?? 0) + ($item->toiletGuru?->rusak ?? 0);

                        // 8. R. PERPUSTAKAAN
                        $ruangPerpustakaanStatus = $item->ruangPerpustakaan?->{'ada/tidak_ada'} ?? '-';
                        $ruangPerpustakaanBadge =
                            $ruangPerpustakaanStatus == 'ada'
                                ? 'success'
                                : ($ruangPerpustakaanStatus == 'tidak_ada'
                                    ? 'danger'
                                    : 'light');
                        $ruangPerpustakaanKondisi = $item->ruangPerpustakaan?->kondisi ?? '-';
                        $ruangPerpustakaanKondisiBadge =
                            $ruangPerpustakaanKondisi == 'baik'
                                ? 'success'
                                : (in_array($ruangPerpustakaanKondisi, ['rusak_ringan', 'rusak_sedang', 'rusak_berat'])
                                    ? 'warning'
                                    : 'light');

                        // 9. R. KEPALA SEKOLAH
                        $ruangKepalaSekolahStatus = $item->ruangKepalaSekolah?->{'ada/tidak_ada'} ?? '-';
                        $ruangKepalaSekolahBadge =
                            $ruangKepalaSekolahStatus == 'ada'
                                ? 'success'
                                : ($ruangKepalaSekolahStatus == 'tidak_ada'
                                    ? 'danger'
                                    : 'light');
                        $ruangKepalaSekolahKondisi = $item->ruangKepalaSekolah?->kondisi ?? '-';
                        $ruangKepalaSekolahKondisiBadge =
                            $ruangKepalaSekolahKondisi == 'baik'
                                ? 'success'
                                : (in_array($ruangKepalaSekolahKondisi, ['rusak_ringan', 'rusak_sedang', 'rusak_berat'])
                                    ? 'warning'
                                    : 'light');

                        // 10. R. GURU
                        $ruangGuruStatus = $item->ruangGuru?->{'ada/tidak_ada'} ?? '-';
                        $ruangGuruBadge =
                            $ruangGuruStatus == 'ada'
                                ? 'success'
                                : ($ruangGuruStatus == 'tidak_ada'
                                    ? 'danger'
                                    : 'light');
                        $ruangGuruKondisi = $item->ruangGuru?->kondisi ?? '-';
                        $ruangGuruKondisiBadge =
                            $ruangGuruKondisi == 'baik'
                                ? 'success'
                                : (in_array($ruangGuruKondisi, ['rusak_ringan', 'rusak_sedang', 'rusak_berat'])
                                    ? 'warning'
                                    : 'light');

                        // 11. R. KANTOR/TU
                        $ruangKantorTuStatus = $item->ruangKantorTu?->{'ada/tidak_ada'} ?? '-';
                        $ruangKantorTuBadge =
                            $ruangKantorTuStatus == 'ada'
                                ? 'success'
                                : ($ruangKantorTuStatus == 'tidak_ada'
                                    ? 'danger'
                                    : 'light');
                        $ruangKantorTuKondisi = $item->ruangKantorTu?->kondisi ?? '-';
                        $ruangKantorTuKondisiBadge =
                            $ruangKantorTuKondisi == 'baik'
                                ? 'success'
                                : (in_array($ruangKantorTuKondisi, ['rusak_ringan', 'rusak_sedang', 'rusak_berat'])
                                    ? 'warning'
                                    : 'light');

                        // 12. LAB IPA
                        $labIpaStatus = $item->labIpa?->{'ada/tidak_ada'} ?? '-';
                        $labIpaBadge =
                            $labIpaStatus == 'ada' ? 'success' : ($labIpaStatus == 'tidak_ada' ? 'danger' : 'light');
                        $labIpaKondisi = $item->labIpa?->kondisi ?? '-';
                        $labIpaKondisiBadge =
                            $labIpaKondisi == 'baik'
                                ? 'success'
                                : (in_array($labIpaKondisi, ['rusak_ringan', 'rusak_sedang', 'rusak_berat'])
                                    ? 'warning'
                                    : 'light');

                        // 13. LAB KOMPUTER
                        $labKomputerStatus = $item->labKomputer?->{'ada/tidak_ada'} ?? '-';
                        $labKomputerBadge =
                            $labKomputerStatus == 'ada'
                                ? 'success'
                                : ($labKomputerStatus == 'tidak_ada'
                                    ? 'danger'
                                    : 'light');
                        $labKomputerKondisi = $item->labKomputer?->kondisi ?? '-';
                        $labKomputerKondisiBadge =
                            $labKomputerKondisi == 'baik'
                                ? 'success'
                                : (in_array($labKomputerKondisi, ['rusak_ringan', 'rusak_sedang', 'rusak_berat'])
                                    ? 'warning'
                                    : 'light');

                        // 14. UKS
                        $unitKesehatanSekolahStatus = $item->unitKesehatanSekolah?->{'ada/tidak_ada'} ?? '-';
                        $unitKesehatanSekolahBadge =
                            $unitKesehatanSekolahStatus == 'ada'
                                ? 'success'
                                : ($unitKesehatanSekolahStatus == 'tidak_ada'
                                    ? 'danger'
                                    : 'light');
                        $unitKesehatanSekolahKondisi = $item->unitKesehatanSekolah?->kondisi ?? '-';
                        $unitKesehatanSekolahKondisiBadge =
                            $unitKesehatanSekolahKondisi == 'baik'
                                ? 'success'
                                : (in_array($unitKesehatanSekolahKondisi, [
                                    'rusak_ringan',
                                    'rusak_sedang',
                                    'rusak_berat',
                                ])
                                    ? 'warning'
                                    : 'light');

                        // 15. RUMAH DINAS
                        $rumahDinasStatus = $item->rumahDinas?->{'ada/tidak_ada'} ?? '-';
                        $rumahDinasBadge =
                            $rumahDinasStatus == 'ada'
                                ? 'success'
                                : ($rumahDinasStatus == 'tidak_ada'
                                    ? 'danger'
                                    : 'light');
                        $rumahDinasKondisi = $item->rumahDinas?->kondisi ?? '-';
                        $rumahDinasKondisiBadge =
                            $rumahDinasKondisi == 'baik'
                                ? 'success'
                                : (in_array($rumahDinasKondisi, ['rusak_ringan', 'rusak_sedang', 'rusak_berat'])
                                    ? 'warning'
                                    : 'light');

                        // 16. RUMAH IBADAH
                        $rumahIbadahStatus = $item->rumahIbadah?->{'ada/tidak_ada'} ?? '-';
                        $rumahIbadahBadge =
                            $rumahIbadahStatus == 'ada'
                                ? 'success'
                                : ($rumahIbadahStatus == 'tidak_ada'
                                    ? 'danger'
                                    : 'light');
                        $rumahIbadahKondisi = $item->rumahIbadah?->kondisi ?? '-';
                        $rumahIbadahKondisiBadge =
                            $rumahIbadahKondisi == 'baik'
                                ? 'success'
                                : (in_array($rumahIbadahKondisi, ['rusak_ringan', 'rusak_sedang', 'rusak_berat'])
                                    ? 'warning'
                                    : 'light');

                        // 17. LAPANGAN SEKOLAH
                        $lapanganSekolahStatus = $item->lapanganSekolah?->{'ada/tidak_ada'} ?? '-';
                        $lapanganSekolahBadge =
                            $lapanganSekolahStatus == 'ada'
                                ? 'success'
                                : ($lapanganSekolahStatus == 'tidak_ada'
                                    ? 'danger'
                                    : 'light');
                        $lapanganSekolahKondisi = $item->lapanganSekolah?->kondisi ?? '-';
                        $lapanganSekolahKondisiBadge =
                            $lapanganSekolahKondisi == 'baik'
                                ? 'success'
                                : (in_array($lapanganSekolahKondisi, ['rusak_ringan', 'rusak_sedang', 'rusak_berat'])
                                    ? 'warning'
                                    : 'light');

                        // 18. PAGAR
                        $pagarSekolahStatus = $item->pagarSekolah?->{'ada/tidak_ada'} ?? '-';
                        $pagarSekolahBadge =
                            $pagarSekolahStatus == 'ada'
                                ? 'success'
                                : ($pagarSekolahStatus == 'tidak_ada'
                                    ? 'danger'
                                    : 'light');
                        $pagarSekolahKondisi = $item->pagarSekolah?->kondisi ?? '-';
                        $pagarSekolahKondisiBadge =
                            $pagarSekolahKondisi == 'baik'
                                ? 'success'
                                : (in_array($pagarSekolahKondisi, ['rusak_ringan', 'rusak_sedang', 'rusak_berat'])
                                    ? 'warning'
                                    : 'light');

                        // 19. AIR
                        $airBersihStatus = $item->airBersih?->{'ada/tidak_ada'} ?? '-';
                        $airBersihBadge =
                            $airBersihStatus == 'ada'
                                ? 'success'
                                : ($airBersihStatus == 'tidak_ada'
                                    ? 'danger'
                                    : 'light');
                        $airBersihKondisi = $item->airBersih?->kondisi ?? '-';
                        $airBersihKondisiBadge =
                            $airBersihKondisi == 'baik'
                                ? 'success'
                                : (in_array($airBersihKondisi, ['rusak_ringan', 'rusak_sedang', 'rusak_berat'])
                                    ? 'warning'
                                    : 'light');

                        // 20. KURSI SISWA
                        $jmlKursiSiswa = ($item->kursiSiswa?->baik ?? 0) + ($item->kursiSiswa?->rusak ?? 0);

                        // 21. MEJA SISWA
                        $jmlMejaSiswa = ($item->mejaSiswa?->baik ?? 0) + ($item->mejaSiswa?->rusak ?? 0);

                        // 22. KURSI GURU
                        $jmlKursiGuru = ($item->kursiGuru?->baik ?? 0) + ($item->kursiGuru?->rusak ?? 0);

                        // 23. MEJA GURU
                        $jmlMejaGuru = ($item->mejaGuru?->baik ?? 0) + ($item->mejaGuru?->rusak ?? 0);

                        // 24. LAPTOP
                        $jmlLaptop = ($item->laptop?->baik ?? 0) + ($item->laptop?->rusak ?? 0);

                        // 26. KOMPUTER
                        $jmlKomputer = ($item->komputer?->baik ?? 0) + ($item->komputer?->rusak ?? 0);
                    @endphp
                    <x-table.row data-sarana-row>
                        {{-- ============================================================
                             DATA SEKOLAH (7 kolom)
                             ============================================================ --}}
                        <x-table.cell class="text-center font-bold">{{ $loop->iteration }}</x-table.cell>
                        <x-table.cell>
                            <a class="link" href="{{ route('user.show', $item->user_id) }}">
                                {{ $item->nama_sekolah }}
                            </a>
                        </x-table.cell>
                        <x-table.cell class="text-center">{{ $item->NPSN }}</x-table.cell>
                        <x-table.cell>{{ Str::limit($item->alamat_sekolah, 25) }}</x-table.cell>
                        <x-table.cell>{{ $item->nama_kepala_sekolah }}</x-table.cell>
                        <x-table.cell class="text-center">{{ $item->NIP }}</x-table.cell>
                        <x-table.cell class="text-center">{{ $item->nomor_hp }}</x-table.cell>

                        {{-- URUTAN 1: JUMLAH SISWA (4 kolom) --}}
                        <x-table.cell class="text-center">{{ $item->jumlahSiswa?->vii ?? 0 }}</x-table.cell>
                        <x-table.cell class="text-center">{{ $item->jumlahSiswa?->viii ?? 0 }}</x-table.cell>
                        <x-table.cell class="text-center">{{ $item->jumlahSiswa?->ix ?? 0 }}</x-table.cell>
                        <x-table.cell
                            class="text-center font-bold bg-orange-200 dark:bg-orange-800/60">{{ $jmlJumlahSiswa }}</x-table.cell>

                        {{-- URUTAN 2: JUMLAH ROMBONGAN BELAJAR (4 kolom) --}}
                        <x-table.cell class="text-center">{{ $item->jumlahRombel?->vii ?? 0 }}</x-table.cell>
                        <x-table.cell class="text-center">{{ $item->jumlahRombel?->viii ?? 0 }}</x-table.cell>
                        <x-table.cell class="text-center">{{ $item->jumlahRombel?->ix ?? 0 }}</x-table.cell>
                        <x-table.cell
                            class="text-center font-bold bg-orange-200 dark:bg-orange-800/60">{{ $jmlJumlahRombel }}</x-table.cell>

                        {{-- URUTAN 3: RKB (RUANG KELAS BARU) (1 kolom) --}}
                        <x-table.cell
                            class="text-center font-bold bg-orange-200 dark:bg-orange-800/60">{{ $item->ruangKelasBaru?->jumlah ?? 0 }}</x-table.cell>

                        {{-- URUTAN 4: REHABILITASI RUANG KELAS (1 kolom) --}}
                        <x-table.cell
                            class="text-center font-bold bg-orange-200 dark:bg-orange-800/60">{{ $item->rehabilitasiRuangKelas?->jumlah ?? 0 }}</x-table.cell>

                        {{-- URUTAN 5: RUANG KELAS (3 kolom) --}}
                        <x-table.cell class="text-center">{{ $item->ruangKelas?->baik ?? 0 }}</x-table.cell>
                        <x-table.cell class="text-center">{{ $item->ruangKelas?->rusak ?? 0 }}</x-table.cell>
                        <x-table.cell
                            class="text-center font-bold bg-orange-200 dark:bg-orange-800/60">{{ $jmlRuangKelas }}</x-table.cell>

                        {{-- URUTAN 6: TOILET SISWA (3 kolom) --}}
                        <x-table.cell class="text-center">{{ $item->toiletSiswa?->baik ?? 0 }}</x-table.cell>
                        <x-table.cell class="text-center">{{ $item->toiletSiswa?->rusak ?? 0 }}</x-table.cell>
                        <x-table.cell
                            class="text-center font-bold bg-orange-200 dark:bg-orange-800/60">{{ $jmlToiletSiswa }}</x-table.cell>

                        {{-- URUTAN 7: TOILET GURU (3 kolom) --}}
                        <x-table.cell class="text-center">{{ $item->toiletGuru?->baik ?? 0 }}</x-table.cell>
                        <x-table.cell class="text-center">{{ $item->toiletGuru?->rusak ?? 0 }}</x-table.cell>
                        <x-table.cell
                            class="text-center font-bold bg-orange-200 dark:bg-orange-800/60">{{ $jmlToiletGuru }}</x-table.cell>

                        {{-- URUTAN 8: R. PERPUSTAKAAN (2 kolom) --}}
                        <x-table.cell class="text-center"><x-badge variant="{{ $ruangPerpustakaanBadge }}"
                                class="text-[9px]">{{ $ruangPerpustakaanStatus }}</x-badge></x-table.cell>
                        <x-table.cell class="text-center"><x-badge variant="{{ $ruangPerpustakaanKondisiBadge }}"
                                class="text-[9px]">{{ $ruangPerpustakaanKondisi }}</x-badge></x-table.cell>

                        {{-- URUTAN 9: R. KEPALA SEKOLAH (2 kolom) --}}
                        <x-table.cell class="text-center"><x-badge variant="{{ $ruangKepalaSekolahBadge }}"
                                class="text-[9px]">{{ $ruangKepalaSekolahStatus }}</x-badge></x-table.cell>
                        <x-table.cell class="text-center"><x-badge variant="{{ $ruangKepalaSekolahKondisiBadge }}"
                                class="text-[9px]">{{ $ruangKepalaSekolahKondisi }}</x-badge></x-table.cell>

                        {{-- URUTAN 10: R. GURU (2 kolom) --}}
                        <x-table.cell class="text-center"><x-badge variant="{{ $ruangGuruBadge }}"
                                class="text-[9px]">{{ $ruangGuruStatus }}</x-badge></x-table.cell>
                        <x-table.cell class="text-center"><x-badge variant="{{ $ruangGuruKondisiBadge }}"
                                class="text-[9px]">{{ $ruangGuruKondisi }}</x-badge></x-table.cell>

                        {{-- URUTAN 11: R. KANTOR/TU (2 kolom) --}}
                        <x-table.cell class="text-center"><x-badge variant="{{ $ruangKantorTuBadge }}"
                                class="text-[9px]">{{ $ruangKantorTuStatus }}</x-badge></x-table.cell>
                        <x-table.cell class="text-center"><x-badge variant="{{ $ruangKantorTuKondisiBadge }}"
                                class="text-[9px]">{{ $ruangKantorTuKondisi }}</x-badge></x-table.cell>

                        {{-- URUTAN 12: LAB IPA (2 kolom) --}}
                        <x-table.cell class="text-center"><x-badge variant="{{ $labIpaBadge }}"
                                class="text-[9px]">{{ $labIpaStatus }}</x-badge></x-table.cell>
                        <x-table.cell class="text-center"><x-badge variant="{{ $labIpaKondisiBadge }}"
                                class="text-[9px]">{{ $labIpaKondisi }}</x-badge></x-table.cell>

                        {{-- URUTAN 13: LAB KOMPUTER (2 kolom) --}}
                        <x-table.cell class="text-center"><x-badge variant="{{ $labKomputerBadge }}"
                                class="text-[9px]">{{ $labKomputerStatus }}</x-badge></x-table.cell>
                        <x-table.cell class="text-center"><x-badge variant="{{ $labKomputerKondisiBadge }}"
                                class="text-[9px]">{{ $labKomputerKondisi }}</x-badge></x-table.cell>

                        {{-- URUTAN 14: UKS (2 kolom) --}}
                        <x-table.cell class="text-center"><x-badge variant="{{ $unitKesehatanSekolahBadge }}"
                                class="text-[9px]">{{ $unitKesehatanSekolahStatus }}</x-badge></x-table.cell>
                        <x-table.cell class="text-center"><x-badge variant="{{ $unitKesehatanSekolahKondisiBadge }}"
                                class="text-[9px]">{{ $unitKesehatanSekolahKondisi }}</x-badge></x-table.cell>

                        {{-- URUTAN 15: RUMAH DINAS (2 kolom) --}}
                        <x-table.cell class="text-center"><x-badge variant="{{ $rumahDinasBadge }}"
                                class="text-[9px]">{{ $rumahDinasStatus }}</x-badge></x-table.cell>
                        <x-table.cell class="text-center"><x-badge variant="{{ $rumahDinasKondisiBadge }}"
                                class="text-[9px]">{{ $rumahDinasKondisi }}</x-badge></x-table.cell>

                        {{-- URUTAN 16: RUMAH IBADAH (2 kolom) --}}
                        <x-table.cell class="text-center"><x-badge variant="{{ $rumahIbadahBadge }}"
                                class="text-[9px]">{{ $rumahIbadahStatus }}</x-badge></x-table.cell>
                        <x-table.cell class="text-center"><x-badge variant="{{ $rumahIbadahKondisiBadge }}"
                                class="text-[9px]">{{ $rumahIbadahKondisi }}</x-badge></x-table.cell>

                        {{-- URUTAN 17: LAPANGAN SEKOLAH (2 kolom) --}}
                        <x-table.cell class="text-center"><x-badge variant="{{ $lapanganSekolahBadge }}"
                                class="text-[9px]">{{ $lapanganSekolahStatus }}</x-badge></x-table.cell>
                        <x-table.cell class="text-center"><x-badge variant="{{ $lapanganSekolahKondisiBadge }}"
                                class="text-[9px]">{{ $lapanganSekolahKondisi }}</x-badge></x-table.cell>

                        {{-- URUTAN 18: PAGAR (2 kolom) --}}
                        <x-table.cell class="text-center"><x-badge variant="{{ $pagarSekolahBadge }}"
                                class="text-[9px]">{{ $pagarSekolahStatus }}</x-badge></x-table.cell>
                        <x-table.cell class="text-center"><x-badge variant="{{ $pagarSekolahKondisiBadge }}"
                                class="text-[9px]">{{ $pagarSekolahKondisi }}</x-badge></x-table.cell>

                        {{-- URUTAN 19: AIR (2 kolom) --}}
                        <x-table.cell class="text-center"><x-badge variant="{{ $airBersihBadge }}"
                                class="text-[9px]">{{ $airBersihStatus }}</x-badge></x-table.cell>
                        <x-table.cell class="text-center"><x-badge variant="{{ $airBersihKondisiBadge }}"
                                class="text-[9px]">{{ $airBersihKondisi }}</x-badge></x-table.cell>

                        {{-- URUTAN 20: KURSI SISWA (3 kolom) --}}
                        <x-table.cell class="text-center">{{ $item->kursiSiswa?->baik ?? 0 }}</x-table.cell>
                        <x-table.cell class="text-center">{{ $item->kursiSiswa?->rusak ?? 0 }}</x-table.cell>
                        <x-table.cell
                            class="text-center font-bold bg-orange-200 dark:bg-orange-800/60">{{ $jmlKursiSiswa }}</x-table.cell>

                        {{-- URUTAN 21: MEJA SISWA (3 kolom) --}}
                        <x-table.cell class="text-center">{{ $item->mejaSiswa?->baik ?? 0 }}</x-table.cell>
                        <x-table.cell class="text-center">{{ $item->mejaSiswa?->rusak ?? 0 }}</x-table.cell>
                        <x-table.cell
                            class="text-center font-bold bg-orange-200 dark:bg-orange-800/60">{{ $jmlMejaSiswa }}</x-table.cell>

                        {{-- URUTAN 22: KURSI GURU (3 kolom) --}}
                        <x-table.cell class="text-center">{{ $item->kursiGuru?->baik ?? 0 }}</x-table.cell>
                        <x-table.cell class="text-center">{{ $item->kursiGuru?->rusak ?? 0 }}</x-table.cell>
                        <x-table.cell
                            class="text-center font-bold bg-orange-200 dark:bg-orange-800/60">{{ $jmlKursiGuru }}</x-table.cell>

                        {{-- URUTAN 23: MEJA GURU (3 kolom) --}}
                        <x-table.cell class="text-center">{{ $item->mejaGuru?->baik ?? 0 }}</x-table.cell>
                        <x-table.cell class="text-center">{{ $item->mejaGuru?->rusak ?? 0 }}</x-table.cell>
                        <x-table.cell
                            class="text-center font-bold bg-orange-200 dark:bg-orange-800/60">{{ $jmlMejaGuru }}</x-table.cell>

                        {{-- URUTAN 24: LAPTOP (3 kolom) --}}
                        <x-table.cell class="text-center">{{ $item->laptop?->baik ?? 0 }}</x-table.cell>
                        <x-table.cell class="text-center">{{ $item->laptop?->rusak ?? 0 }}</x-table.cell>
                        <x-table.cell
                            class="text-center font-bold bg-orange-200 dark:bg-orange-800/60">{{ $jmlLaptop }}</x-table.cell>


                        {{-- URUTAN 25: KOMPUTER (3 kolom) --}}
                        <x-table.cell class="text-center">{{ $item->komputer?->baik ?? 0 }}</x-table.cell>
                        <x-table.cell class="text-center">{{ $item->komputer?->rusak ?? 0 }}</x-table.cell>
                        <x-table.cell
                            class="text-center font-bold bg-orange-200 dark:bg-orange-800/60">{{ $jmlKomputer }}</x-table.cell>

                        {{-- ============================================================
                             AKSI (Tombol Lihat, Edit, Hapus)
                             ============================================================ --}}
                        <x-table.cell class="text-center">
                            <div class="flex justify-center gap-1">
                                <x-button href="{{ route('user.show', $item->user_id) }}" variant="info" size="xs"
                                    class="p-1.5!" title="Lihat Detail">
                                    <i class="bi bi-eye-fill"></i>
                                </x-button>
                                <x-button href="{{ route('sarana.edit', $item->id) }}" variant="warning" size="xs"
                                    class="p-1.5!" title="Edit Data">
                                    <i class="bi bi-pencil-fill"></i>
                                </x-button>
                                <x-button variant="danger" size="xs" class="p-1.5!" title="Hapus Data"
                                    data-modal-open="deleteModal{{ $item->id }}">
                                    <i class="bi bi-trash-fill"></i>
                                </x-button>
                            </div>
                        </x-table.cell>
                    </x-table.row>
                @empty
                    <x-table.empty colspan="69" message="Belum ada data sarana sekolah" />
                @endforelse

                {{-- Baris ini disembunyikan (hidden) secara default, dan hanya
                     dimunculkan oleh JS ketika hasil pencarian kosong --}}
                <x-table.empty id="searchSaranaNoResult" class="hidden" colspan="69"
                    message="Tidak ada sekolah yang cocok dengan pencarian" />
            </x-table>

            {{-- ============================================================
                 PAGINATION
                 ============================================================ --}}
            @if (method_exists($profileSekolahs, 'links'))
                <x-pagination :paginator="$profileSekolahs" class="mt-3" />
            @endif

        </div>
    </div>

    {{-- ============================================================
         MODAL DELETE (Loop untuk setiap item)
         ============================================================ --}}
    @foreach ($profileSekolahs as $item)
        <x-modal id="deleteModal{{ $item->id }}" size="sm" centered>
            <x-slot:header>
                <div class="flex items-center gap-2 text-red-600">
                    <i class="bi bi-exclamation-triangle-fill text-xl"></i>
                    <span>Konfirmasi Hapus</span>
                </div>
            </x-slot:header>

            <div class="text-center py-4">
                <div class="text-5xl text-red-500 mb-4">
                    <i class="bi bi-trash"></i>
                </div>
                <h4 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-2">
                    Yakin ingin menghapus data ini?
                </h4>
                <p class="text-sm text-gray-500 dark:text-gray-400 font-medium">
                    {{ $item->nama_sekolah }}
                </p>
                <p class="text-sm text-red-500 dark:text-red-400 mt-2">
                    <i class="bi bi-exclamation-circle"></i> Data yang dihapus tidak dapat dikembalikan!
                </p>
            </div>

            <x-slot:footer>
                <div class="flex flex-wrap justify-end gap-2 w-full">
                    <x-button variant="secondary" data-modal-close>
                        <i class="bi bi-x-circle me-1"></i> Batal
                    </x-button>
                    <form action="{{ route('sarana.destroy', $item->id) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <x-button variant="danger" type="submit">
                            <i class="bi bi-trash me-1"></i> Ya, Hapus
                        </x-button>
                    </form>
                </div>
            </x-slot:footer>
        </x-modal>
    @endforeach

@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.2.0/dist/chartjs-plugin-datalabels.min.js">
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Guard: jika CDN plugin datalabels gagal dimuat (mis. terblokir),
            // chart utama tetap harus muncul — hanya angka labelnya yang tidak tampil.
            if (typeof ChartDataLabels !== 'undefined') {
                Chart.register(ChartDataLabels);
                Chart.defaults.set('plugins.datalabels', {
                    display: true,
                });
            } else {
                console.warn('chartjs-plugin-datalabels gagal dimuat, label angka pada chart tidak akan tampil.');
            }

            new Chart(document.getElementById('adminChartSiswaRombel'), {
                type: 'bar',
                data: {
                    labels: ['VII', 'VIII', 'IX'],
                    datasets: [{
                            label: 'Siswa',
                            data: [
                                {{ $chartSiswaRombel['vii'][0] }},
                                {{ $chartSiswaRombel['viii'][0] }},
                                {{ $chartSiswaRombel['ix'][0] }},
                            ],
                            backgroundColor: '#22c55e',
                            borderRadius: 4,
                        },
                        {
                            label: 'Rombel',
                            data: [
                                {{ $chartSiswaRombel['vii'][1] }},
                                {{ $chartSiswaRombel['viii'][1] }},
                                {{ $chartSiswaRombel['ix'][1] }},
                            ],
                            backgroundColor: '#8b5cf6',
                            borderRadius: 4,
                        },
                    ],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        },
                        datalabels: {
                            anchor: 'end',
                            align: 'top',
                            color: '#374151',
                            font: {
                                size: 10,
                                weight: 'bold'
                            },
                            formatter: (value) => value > 0 ? value : '',
                        },
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0
                            }
                        }
                    },
                },
            });

            new Chart(document.getElementById('adminChartRuangKelas'), {
                type: 'doughnut',
                data: {
                    labels: ['Baik', 'Rusak'],
                    datasets: [{
                        data: @json($chartRuangKelas),
                        backgroundColor: ['#0ea5e9', '#f43f5e'],
                        borderWidth: 0,
                    }],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '65%',
                    plugins: {
                        legend: {
                            position: 'bottom'
                        },
                        datalabels: {
                            color: '#fff',
                            font: {
                                size: 12,
                                weight: 'bold'
                            },
                            formatter: (value) => value > 0 ? value : '',
                        },
                    },
                },
            });

            new Chart(document.getElementById('adminChartToiletSiswa'), {
                type: 'doughnut',
                data: {
                    labels: ['Baik', 'Rusak'],
                    datasets: [{
                        data: @json($chartToiletSiswa),
                        backgroundColor: ['#14b8a6', '#f97316'],
                        borderWidth: 0,
                    }],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '65%',
                    plugins: {
                        legend: {
                            position: 'bottom'
                        },
                        datalabels: {
                            color: '#fff',
                            font: {
                                size: 12,
                                weight: 'bold'
                            },
                            formatter: (value) => value > 0 ? value : '',
                        },
                    },
                },
            });

            new Chart(document.getElementById('adminChartToiletGuru'), {
                type: 'doughnut',
                data: {
                    labels: ['Baik', 'Rusak'],
                    datasets: [{
                        data: @json($chartToiletGuru),
                        backgroundColor: ['#0ea5e9', '#ef4444'],
                        borderWidth: 0,
                    }],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '65%',
                    plugins: {
                        legend: {
                            position: 'bottom'
                        },
                        datalabels: {
                            color: '#fff',
                            font: {
                                size: 12,
                                weight: 'bold'
                            },
                            formatter: (value) => value > 0 ? value : '',
                        },
                    },
                },
            });

            new Chart(document.getElementById('adminChartSaranaUtama'), {
                type: 'bar',
                data: {
                    labels: @json($chartSaranaUtama['labels']),
                    datasets: [{
                            label: 'Baik',
                            data: @json($chartSaranaUtama['baik']),
                            backgroundColor: '#22c55e',
                            borderRadius: 3,
                        },
                        {
                            label: 'Rusak Ringan',
                            data: @json($chartSaranaUtama['rusak_ringan']),
                            backgroundColor: '#facc15',
                            borderRadius: 3,
                        },
                        {
                            label: 'Rusak Sedang',
                            data: @json($chartSaranaUtama['rusak_sedang']),
                            backgroundColor: '#f97316',
                            borderRadius: 3,
                        },
                        {
                            label: 'Rusak Berat',
                            data: @json($chartSaranaUtama['rusak_berat']),
                            backgroundColor: '#ef4444',
                            borderRadius: 3,
                        },
                        {
                            label: 'Nihil',
                            data: @json($chartSaranaUtama['nihil']),
                            backgroundColor: '#9ca3af',
                            borderRadius: 3,
                        },
                    ],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        },
                        datalabels: {
                            anchor: 'end',
                            align: 'top',
                            color: '#374151',
                            font: {
                                size: 8
                            },
                            formatter: (value) => value > 0 ? value : '',
                        },
                    },
                    scales: {
                        x: {
                            ticks: {
                                autoSkip: false,
                                font: {
                                    size: 10
                                }
                            }
                        },
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0
                            }
                        }
                    },
                },
            });
        });
    </script>
@endpush
