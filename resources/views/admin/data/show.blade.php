@extends('layouts.admin')

@section('title')
    Detail Data Sarana & Prasarana
@endsection

@section('content')
<div class="container mx-auto px-3 sm:px-4 py-3 sm:py-4">
    <div class="flex flex-col gap-3 sm:gap-4">
        <!-- Header -->
        <div class="flex flex-wrap items-center justify-between gap-2">
            <div>
                <h1 class="text-lg sm:text-xl font-semibold text-gray-800 dark:text-gray-100 flex items-center gap-2">
                    <i class="bi bi-eye text-blue-600 dark:text-blue-400"></i>
                    <span class="hidden sm:inline">Detail Data Sarana & Prasarana</span>
                    <span class="sm:hidden">Detail Sarana</span>
                </h1>
                <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 hidden sm:block">
                    Detail lengkap data sarana prasarana sekolah
                </p>
            </div>
            <div class="flex flex-wrap gap-1.5 sm:gap-2">
                <a href="{{ route('sarana.edit', $sarana->id) }}" class="inline-flex">
                    <x-button variant="warning" size="sm">
                        <i class="bi bi-pencil me-1 text-xs sm:text-sm"></i>
                        <span class="hidden sm:inline">Edit</span>
                        <span class="sm:hidden">Edit</span>
                    </x-button>
                </a>
                <x-button type="button" variant="danger" size="sm" data-modal-open="deleteModal">
                    <i class="bi bi-trash me-1 text-xs sm:text-sm"></i>
                    <span class="hidden sm:inline">Hapus</span>
                    <span class="sm:hidden">Hapus</span>
                </x-button>
                <a href="{{ route('sarana.index') }}" class="inline-flex">
                    <x-button variant="secondary" size="sm">
                        <i class="bi bi-arrow-left me-1 text-xs sm:text-sm"></i>
                        <span class="hidden sm:inline">Kembali</span>
                        <span class="sm:hidden">Kembali</span>
                    </x-button>
                </a>
            </div>
        </div>

        <!-- A. Data Sekolah -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="p-3 sm:p-4 border-b border-gray-200 dark:border-gray-700 bg-linear-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20">
                <div class="flex items-center gap-2 text-blue-600 dark:text-blue-400 font-semibold text-sm sm:text-base">
                    <i class="bi bi-building"></i>
                    <span>A. Data Sekolah</span>
                </div>
            </div>
            <div class="p-3 sm:p-4 space-y-2 sm:space-y-3">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 sm:gap-3">
                    <div class="bg-gray-50 dark:bg-gray-700/30 p-2 sm:p-3 rounded-lg">
                        <p class="text-[10px] sm:text-xs text-gray-500 dark:text-gray-400">Nama Sekolah</p>
                        <p class="text-xs sm:text-sm font-medium text-gray-900 dark:text-white wrap-break-word">{{ $sarana->nama_sekolah }}</p>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-700/30 p-2 sm:p-3 rounded-lg">
                        <p class="text-[10px] sm:text-xs text-gray-500 dark:text-gray-400">NPSN</p>
                        <p class="text-xs sm:text-sm font-medium text-gray-900 dark:text-white">{{ $sarana->NPSN }}</p>
                    </div>
                    <div class="sm:col-span-2 bg-gray-50 dark:bg-gray-700/30 p-2 sm:p-3 rounded-lg">
                        <p class="text-[10px] sm:text-xs text-gray-500 dark:text-gray-400">Alamat Sekolah</p>
                        <p class="text-xs sm:text-sm font-medium text-gray-900 dark:text-white wrap-break-word">{{ $sarana->alamat_sekolah }}</p>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-700/30 p-2 sm:p-3 rounded-lg">
                        <p class="text-[10px] sm:text-xs text-gray-500 dark:text-gray-400">Kepala Sekolah</p>
                        <p class="text-xs sm:text-sm font-medium text-gray-900 dark:text-white wrap-break-word">{{ $sarana->nama_kepala_sekolah }}</p>
                        <p class="text-[10px] text-gray-500 dark:text-gray-400">NIP: {{ $sarana->NIP }}</p>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-700/30 p-2 sm:p-3 rounded-lg">
                        <p class="text-[10px] sm:text-xs text-gray-500 dark:text-gray-400">Nomor HP</p>
                        <p class="text-xs sm:text-sm font-medium text-gray-900 dark:text-white">{{ $sarana->nomor_hp }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- B. Jumlah Siswa -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="p-3 sm:p-4 border-b border-gray-200 dark:border-gray-700 bg-linear-to-r from-green-50 to-emerald-50 dark:from-green-900/20 dark:to-emerald-900/20">
                <div class="flex items-center gap-2 text-green-700 dark:text-green-400 font-semibold text-sm sm:text-base">
                    <i class="bi bi-mortarboard"></i>
                    <span>B. Jumlah Siswa</span>
                </div>
            </div>
            <div class="p-3 sm:p-4">
                <div class="grid grid-cols-3 gap-1.5 sm:gap-3">
                    <div class="bg-green-50 dark:bg-green-900/20 p-2 sm:p-3 rounded-lg text-center">
                        <p class="text-[10px] sm:text-xs text-gray-500 dark:text-gray-400">VII</p>
                        <p class="text-lg sm:text-2xl font-bold text-gray-900 dark:text-white">{{ $sarana->jumlahSiswa?->vii ?? 0 }}</p>
                    </div>
                    <div class="bg-emerald-50 dark:bg-emerald-900/20 p-2 sm:p-3 rounded-lg text-center">
                        <p class="text-[10px] sm:text-xs text-gray-500 dark:text-gray-400">VIII</p>
                        <p class="text-lg sm:text-2xl font-bold text-gray-900 dark:text-white">{{ $sarana->jumlahSiswa?->viii ?? 0 }}</p>
                    </div>
                    <div class="bg-teal-50 dark:bg-teal-900/20 p-2 sm:p-3 rounded-lg text-center">
                        <p class="text-[10px] sm:text-xs text-gray-500 dark:text-gray-400">IX</p>
                        <p class="text-lg sm:text-2xl font-bold text-gray-900 dark:text-white">{{ $sarana->jumlahSiswa?->ix ?? 0 }}</p>
                    </div>
                </div>
                <div class="mt-2 sm:mt-3 pt-2 sm:pt-3 border-t border-gray-200 dark:border-gray-700">
                    <div class="flex justify-between items-center">
                        <span class="text-xs sm:text-sm text-gray-600 dark:text-gray-400">Total Siswa</span>
                        <span class="text-base sm:text-lg font-bold text-green-600 dark:text-green-400">
                            {{ ($sarana->jumlahSiswa?->vii ?? 0) + ($sarana->jumlahSiswa?->viii ?? 0) + ($sarana->jumlahSiswa?->ix ?? 0) }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- C. Jumlah Rombongan Belajar -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="p-3 sm:p-4 border-b border-gray-200 dark:border-gray-700 bg-linear-to-r from-purple-50 to-violet-50 dark:from-purple-900/20 dark:to-violet-900/20">
                <div class="flex items-center gap-2 text-purple-700 dark:text-purple-400 font-semibold text-sm sm:text-base">
                    <i class="bi bi-diagram-3"></i>
                    <span>C. Jumlah Rombongan Belajar</span>
                </div>
            </div>
            <div class="p-3 sm:p-4">
                <div class="grid grid-cols-3 gap-1.5 sm:gap-3">
                    <div class="bg-purple-50 dark:bg-purple-900/20 p-2 sm:p-3 rounded-lg text-center">
                        <p class="text-[10px] sm:text-xs text-gray-500 dark:text-gray-400">VII</p>
                        <p class="text-lg sm:text-2xl font-bold text-gray-900 dark:text-white">{{ $sarana->jumlahRombel?->vii ?? 0 }}</p>
                    </div>
                    <div class="bg-violet-50 dark:bg-violet-900/20 p-2 sm:p-3 rounded-lg text-center">
                        <p class="text-[10px] sm:text-xs text-gray-500 dark:text-gray-400">VIII</p>
                        <p class="text-lg sm:text-2xl font-bold text-gray-900 dark:text-white">{{ $sarana->jumlahRombel?->viii ?? 0 }}</p>
                    </div>
                    <div class="bg-indigo-50 dark:bg-indigo-900/20 p-2 sm:p-3 rounded-lg text-center">
                        <p class="text-[10px] sm:text-xs text-gray-500 dark:text-gray-400">IX</p>
                        <p class="text-lg sm:text-2xl font-bold text-gray-900 dark:text-white">{{ $sarana->jumlahRombel?->ix ?? 0 }}</p>
                    </div>
                </div>
                <div class="mt-2 sm:mt-3 pt-2 sm:pt-3 border-t border-gray-200 dark:border-gray-700">
                    <div class="flex justify-between items-center">
                        <span class="text-xs sm:text-sm text-gray-600 dark:text-gray-400">Total Rombel</span>
                        <span class="text-base sm:text-lg font-bold text-purple-600 dark:text-purple-400">
                            {{ ($sarana->jumlahRombel?->vii ?? 0) + ($sarana->jumlahRombel?->viii ?? 0) + ($sarana->jumlahRombel?->ix ?? 0) }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- D & E - RKB & Rehabilitasi (2 Kolom) -->
        <div class="grid grid-cols-2 gap-3 sm:gap-4">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="p-2 sm:p-3 border-b border-gray-200 dark:border-gray-700 bg-linear-to-r from-blue-50 to-cyan-50 dark:from-blue-900/20 dark:to-cyan-900/20">
                    <div class="flex items-center gap-1.5 sm:gap-2 text-blue-700 dark:text-blue-400 font-semibold text-[10px] sm:text-sm">
                        <i class="bi bi-building-add text-sm sm:text-lg"></i>
                        <span class="hidden sm:inline">D. RKB</span>
                        <span class="sm:hidden">RKB</span>
                    </div>
                </div>
                <div class="p-2 sm:p-3 text-center">
                    <p class="text-xl sm:text-3xl font-bold text-blue-600 dark:text-blue-400">{{ $sarana->ruangKelasBaru?->jumlah ?? 0 }}</p>
                    <p class="text-[8px] sm:text-xs text-gray-500 dark:text-gray-400">Ruang Kelas Baru</p>
                    <p class="text-[8px] sm:text-xs text-gray-400 dark:text-gray-500">
                        {{ $sarana->ruangKelasBaru->tahun_awal ?? 2020 }}-{{ $sarana->ruangKelasBaru->tahun_akhir ?? 2025 }}
                    </p>
                </div>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="p-2 sm:p-3 border-b border-gray-200 dark:border-gray-700 bg-linear-to-r from-orange-50 to-amber-50 dark:from-orange-900/20 dark:to-amber-900/20">
                    <div class="flex items-center gap-1.5 sm:gap-2 text-orange-700 dark:text-orange-400 font-semibold text-[10px] sm:text-sm">
                        <i class="bi bi-tools text-sm sm:text-lg"></i>
                        <span class="hidden sm:inline">E. Rehabilitasi</span>
                        <span class="sm:hidden">Rehab</span>
                    </div>
                </div>
                <div class="p-2 sm:p-3 text-center">
                    <p class="text-xl sm:text-3xl font-bold text-orange-600 dark:text-orange-400">{{ $sarana->rehabilitasiRuangKelas?->jumlah ?? 0 }}</p>
                    <p class="text-[8px] sm:text-xs text-gray-500 dark:text-gray-400">Ruang Kelas</p>
                    <p class="text-[8px] sm:text-xs text-gray-400 dark:text-gray-500">
                        {{ $sarana->rehabilitasiRuangKelas->tahun_awal ?? 2020 }}-{{ $sarana->rehabilitasiRuangKelas->tahun_akhir ?? 2025 }}
                    </p>
                </div>
            </div>
        </div>

        <!-- F. Ruang Kelas -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="p-3 sm:p-4 border-b border-gray-200 dark:border-gray-700 bg-linear-to-r from-blue-50 to-sky-50 dark:from-blue-900/20 dark:to-sky-900/20">
                <div class="flex items-center gap-2 text-blue-700 dark:text-blue-400 font-semibold text-sm sm:text-base">
                    <i class="bi bi-door-closed"></i>
                    <span>F. Ruang Kelas</span>
                </div>
            </div>
            <div class="p-3 sm:p-4">
                <div class="grid grid-cols-2 gap-2 sm:gap-4">
                    <div class="bg-green-50 dark:bg-green-900/20 p-2 sm:p-3 rounded-lg text-center">
                        <p class="text-[10px] sm:text-xs text-gray-500 dark:text-gray-400">Baik</p>
                        <p class="text-lg sm:text-2xl font-bold text-green-600 dark:text-green-400">{{ $sarana->ruangKelas?->bagus ?? 0 }}</p>
                    </div>
                    <div class="bg-red-50 dark:bg-red-900/20 p-2 sm:p-3 rounded-lg text-center">
                        <p class="text-[10px] sm:text-xs text-gray-500 dark:text-gray-400">Rusak</p>
                        <p class="text-lg sm:text-2xl font-bold text-red-600 dark:text-red-400">{{ $sarana->ruangKelas?->rusak ?? 0 }}</p>
                    </div>
                </div>
                <div class="mt-2 sm:mt-3 pt-2 sm:pt-3 border-t border-gray-200 dark:border-gray-700">
                    <div class="flex justify-between items-center">
                        <span class="text-xs sm:text-sm text-gray-600 dark:text-gray-400">Total Ruang Kelas</span>
                        <span class="text-base sm:text-lg font-bold text-blue-600 dark:text-blue-400">
                            {{ ($sarana->ruangKelas?->bagus ?? 0) + ($sarana->ruangKelas?->rusak ?? 0) }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- G & H - Toilet Siswa & Guru -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="p-2 sm:p-3 border-b border-gray-200 dark:border-gray-700 bg-linear-to-r from-cyan-50 to-teal-50 dark:from-cyan-900/20 dark:to-teal-900/20">
                    <div class="flex items-center gap-1.5 sm:gap-2 text-cyan-700 dark:text-cyan-400 font-semibold text-[10px] sm:text-sm">
                        <i class="bi bi-droplet-half text-sm sm:text-lg"></i>
                        <span>G. Toilet Siswa</span>
                    </div>
                </div>
                <div class="p-2 sm:p-3">
                    <div class="grid grid-cols-2 gap-1.5 sm:gap-2">
                        <div class="bg-green-50 dark:bg-green-900/20 p-1.5 sm:p-2 rounded-lg text-center">
                            <p class="text-[8px] sm:text-xs text-gray-500 dark:text-gray-400">Baik</p>
                            <p class="text-base sm:text-xl font-bold text-green-600 dark:text-green-400">{{ $sarana->toiletSiswa?->bagus ?? 0 }}</p>
                        </div>
                        <div class="bg-red-50 dark:bg-red-900/20 p-1.5 sm:p-2 rounded-lg text-center">
                            <p class="text-[8px] sm:text-xs text-gray-500 dark:text-gray-400">Rusak</p>
                            <p class="text-base sm:text-xl font-bold text-red-600 dark:text-red-400">{{ $sarana->toiletSiswa?->rusak ?? 0 }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="p-2 sm:p-3 border-b border-gray-200 dark:border-gray-700 bg-linear-to-r from-cyan-50 to-blue-50 dark:from-cyan-900/20 dark:to-blue-900/20">
                    <div class="flex items-center gap-1.5 sm:gap-2 text-cyan-700 dark:text-cyan-400 font-semibold text-[10px] sm:text-sm">
                        <i class="bi bi-droplet text-sm sm:text-lg"></i>
                        <span>H. Toilet Guru</span>
                    </div>
                </div>
                <div class="p-2 sm:p-3">
                    <div class="grid grid-cols-2 gap-1.5 sm:gap-2">
                        <div class="bg-green-50 dark:bg-green-900/20 p-1.5 sm:p-2 rounded-lg text-center">
                            <p class="text-[8px] sm:text-xs text-gray-500 dark:text-gray-400">Baik</p>
                            <p class="text-base sm:text-xl font-bold text-green-600 dark:text-green-400">{{ $sarana->toiletGuru?->bagus ?? 0 }}</p>
                        </div>
                        <div class="bg-red-50 dark:bg-red-900/20 p-1.5 sm:p-2 rounded-lg text-center">
                            <p class="text-[8px] sm:text-xs text-gray-500 dark:text-gray-400">Rusak</p>
                            <p class="text-base sm:text-xl font-bold text-red-600 dark:text-red-400">{{ $sarana->toiletGuru?->rusak ?? 0 }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Fasilitas Lainnya - Grid Badge -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="p-3 sm:p-4 border-b border-gray-200 dark:border-gray-700 bg-linear-to-r from-orange-50 to-red-50 dark:from-orange-900/20 dark:to-red-900/20">
                <div class="flex items-center gap-2 text-orange-700 dark:text-orange-400 font-semibold text-sm sm:text-base">
                    <i class="bi bi-grid"></i>
                    <span>I. Fasilitas Lainnya</span>
                </div>
            </div>
            <div class="p-3 sm:p-4">
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-1.5 sm:gap-2">
                    @php
                        $fasilitas = [
                            ['label' => 'Pagar', 'value' => $sarana->pagarSekolah?->{'ada/tidak_ada'}, 'icon' => 'bi-border-all'],
                            ['label' => 'Air Bersih', 'value' => $sarana->airBersih?->{'ada/tidak_ada'}, 'icon' => 'bi-droplet'],
                            ['label' => 'Perpustakaan', 'value' => $sarana->ruangPerpustakaan?->{'ada/tidak_ada'}, 'icon' => 'bi-book'],
                            ['label' => 'R. Kepsek', 'value' => $sarana->ruangKepalaSekolah?->{'ada/tidak_ada'}, 'icon' => 'bi-person-workspace'],
                            ['label' => 'R. Guru', 'value' => $sarana->ruangGuru?->{'ada/tidak_ada'}, 'icon' => 'bi-easel2'],
                            ['label' => 'R. TU', 'value' => $sarana->ruangKantorTu?->{'ada/tidak_ada'}, 'icon' => 'bi-briefcase'],
                            ['label' => 'Lab IPA', 'value' => $sarana->labIpa?->{'ada/tidak_ada'}, 'icon' => 'bi-flask'],
                            ['label' => 'Lab Komputer', 'value' => $sarana->labKomputer?->{'ada/tidak_ada'}, 'icon' => 'bi-pc-display-horizontal'],
                            ['label' => 'UKS', 'value' => $sarana->unitKesehatanSekolah?->{'ada/tidak_ada'}, 'icon' => 'bi-heart-pulse'],
                            ['label' => 'Rumah Dinas', 'value' => $sarana->rumahDinas?->{'ada/tidak_ada'}, 'icon' => 'bi-house-door'],
                            ['label' => 'Rumah Ibadah', 'value' => $sarana->rumahIbadah?->{'ada/tidak_ada'}, 'icon' => 'bi-building'],
                            ['label' => 'Lapangan', 'value' => $sarana->lapanganSekolah?->{'ada/tidak_ada'}, 'icon' => 'bi-flag'],
                        ];
                    @endphp
                    @foreach($fasilitas as $item)
                        <div class="flex items-center gap-1 p-1.5 sm:p-2 rounded-lg text-[10px] sm:text-xs {{ $item['value'] == 'ada' ? 'bg-green-50 dark:bg-green-900/20' : 'bg-red-50 dark:bg-red-900/20' }}">
                            <i class="bi {{ $item['icon'] }} {{ $item['value'] == 'ada' ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }} text-[10px] sm:text-xs"></i>
                            <span class="font-medium text-gray-700 dark:text-gray-300 truncate">{{ $item['label'] }}</span>
                            <span class="ml-auto text-[10px] sm:text-xs {{ $item['value'] == 'ada' ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                {{ $item['value'] == 'ada' ? '✓' : '✗' }}
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- U-Z: Furniture & Elektronik -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
            <!-- Furniture -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="p-2 sm:p-3 border-b border-gray-200 dark:border-gray-700 bg-linear-to-r from-yellow-50 to-amber-50 dark:from-yellow-900/20 dark:to-amber-900/20">
                    <div class="flex items-center gap-1.5 sm:gap-2 text-yellow-700 dark:text-yellow-400 font-semibold text-[10px] sm:text-sm">
                        <i class="bi bi-table text-sm sm:text-lg"></i>
                        <span>Furniture</span>
                    </div>
                </div>
                <div class="p-2 sm:p-3 space-y-1.5 sm:space-y-2">
                    <div class="flex justify-between items-center p-1.5 sm:p-2 bg-gray-50 dark:bg-gray-700/30 rounded-lg">
                        <span class="text-[10px] sm:text-xs text-gray-600 dark:text-gray-400">Kursi Siswa</span>
                        <span class="text-xs sm:text-sm font-bold text-gray-900 dark:text-white">
                            {{ ($sarana->kursiSiswa?->bagus ?? 0) + ($sarana->kursiSiswa?->rusak ?? 0) }}
                            <span class="text-[8px] sm:text-[10px] font-normal text-gray-500 dark:text-gray-400">
                                (B: {{ $sarana->kursiSiswa?->bagus ?? 0 }} | R: {{ $sarana->kursiSiswa?->rusak ?? 0 }})
                            </span>
                        </span>
                    </div>
                    <div class="flex justify-between items-center p-1.5 sm:p-2 bg-gray-50 dark:bg-gray-700/30 rounded-lg">
                        <span class="text-[10px] sm:text-xs text-gray-600 dark:text-gray-400">Meja Siswa</span>
                        <span class="text-xs sm:text-sm font-bold text-gray-900 dark:text-white">
                            {{ ($sarana->mejaSiswa?->bagus ?? 0) + ($sarana->mejaSiswa?->rusak ?? 0) }}
                            <span class="text-[8px] sm:text-[10px] font-normal text-gray-500 dark:text-gray-400">
                                (B: {{ $sarana->mejaSiswa?->bagus ?? 0 }} | R: {{ $sarana->mejaSiswa?->rusak ?? 0 }})
                            </span>
                        </span>
                    </div>
                    <div class="flex justify-between items-center p-1.5 sm:p-2 bg-gray-50 dark:bg-gray-700/30 rounded-lg">
                        <span class="text-[10px] sm:text-xs text-gray-600 dark:text-gray-400">Kursi Guru</span>
                        <span class="text-xs sm:text-sm font-bold text-gray-900 dark:text-white">
                            {{ ($sarana->kursiGuru?->bagus ?? 0) + ($sarana->kursiGuru?->rusak ?? 0) }}
                            <span class="text-[8px] sm:text-[10px] font-normal text-gray-500 dark:text-gray-400">
                                (B: {{ $sarana->kursiGuru?->bagus ?? 0 }} | R: {{ $sarana->kursiGuru?->rusak ?? 0 }})
                            </span>
                        </span>
                    </div>
                    <div class="flex justify-between items-center p-1.5 sm:p-2 bg-gray-50 dark:bg-gray-700/30 rounded-lg">
                        <span class="text-[10px] sm:text-xs text-gray-600 dark:text-gray-400">Meja Guru</span>
                        <span class="text-xs sm:text-sm font-bold text-gray-900 dark:text-white">
                            {{ ($sarana->mejaGuru?->bagus ?? 0) + ($sarana->mejaGuru?->rusak ?? 0) }}
                            <span class="text-[8px] sm:text-[10px] font-normal text-gray-500 dark:text-gray-400">
                                (B: {{ $sarana->mejaGuru?->bagus ?? 0 }} | R: {{ $sarana->mejaGuru?->rusak ?? 0 }})
                            </span>
                        </span>
                    </div>
                </div>
            </div>

            <!-- Elektronik -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="p-2 sm:p-3 border-b border-gray-200 dark:border-gray-700 bg-linear-to-r from-purple-50 to-pink-50 dark:from-purple-900/20 dark:to-pink-900/20">
                    <div class="flex items-center gap-1.5 sm:gap-2 text-purple-700 dark:text-purple-400 font-semibold text-[10px] sm:text-sm">
                        <i class="bi bi-laptop text-sm sm:text-lg"></i>
                        <span>Elektronik</span>
                    </div>
                </div>
                <div class="p-2 sm:p-3 space-y-1.5 sm:space-y-2">
                    <div class="flex justify-between items-center p-1.5 sm:p-2 bg-gray-50 dark:bg-gray-700/30 rounded-lg">
                        <span class="text-[10px] sm:text-xs text-gray-600 dark:text-gray-400">Laptop</span>
                        <span class="text-xs sm:text-sm font-bold text-gray-900 dark:text-white">
                            {{ ($sarana->laptop?->bagus ?? 0) + ($sarana->laptop?->rusak ?? 0) }}
                            <span class="text-[8px] sm:text-[10px] font-normal text-gray-500 dark:text-gray-400">
                                (B: {{ $sarana->laptop?->bagus ?? 0 }} | R: {{ $sarana->laptop?->rusak ?? 0 }})
                            </span>
                        </span>
                    </div>
                    <div class="flex justify-between items-center p-1.5 sm:p-2 bg-gray-50 dark:bg-gray-700/30 rounded-lg">
                        <span class="text-[10px] sm:text-xs text-gray-600 dark:text-gray-400">Komputer</span>
                        <span class="text-xs sm:text-sm font-bold text-gray-900 dark:text-white">
                            {{ ($sarana->komputer?->bagus ?? 0) + ($sarana->komputer?->rusak ?? 0) }}
                            <span class="text-[8px] sm:text-[10px] font-normal text-gray-500 dark:text-gray-400">
                                (B: {{ $sarana->komputer?->bagus ?? 0 }} | R: {{ $sarana->komputer?->rusak ?? 0 }})
                            </span>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="p-3 sm:p-4 bg-gray-50 dark:bg-gray-800/50">
                <div class="flex flex-wrap justify-between items-center gap-2">
                    <div class="text-xs sm:text-sm text-gray-500 dark:text-gray-400">
                        <i class="bi bi-clock"></i> Dibuat: {{ $sarana->created_at->format('d/m/Y H:i') }}
                        <span class="mx-2 hidden sm:inline">|</span>
                        <span class="block sm:inline mt-1 sm:mt-0">
                            <i class="bi bi-pencil"></i> Diupdate: {{ $sarana->updated_at->format('d/m/Y H:i') }}
                        </span>
                    </div>
                    <div class="flex flex-wrap gap-2">
                        <a href="{{ route('sarana.edit', $sarana->id) }}" class="btn btn-warning btn-sm">
                            <i class="bi bi-pencil"></i> Edit
                        </a>
                        <button type="button" class="btn btn-danger btn-sm" data-modal-open="deleteModal">
                            <i class="bi bi-trash"></i> Hapus
                        </button>
                        <a href="{{ route('sarana.index') }}" class="btn btn-secondary btn-sm">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Delete -->
        <div id="deleteModal" data-modal class="hidden fixed inset-0 z-50 overflow-y-auto" role="dialog">
            <div class="flex items-center justify-center min-h-screen p-3 sm:p-4">
                <div class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm transition-opacity" data-modal-close></div>
                <div class="relative w-full max-w-sm bg-white dark:bg-gray-800 rounded-xl shadow-2xl transform transition-all scale-95 mx-3">
                    <div class="flex items-center justify-between p-3 sm:p-4 border-b dark:border-gray-700">
                        <div class="flex items-center gap-2 text-red-600">
                            <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-red-100 dark:bg-red-900/30 flex items-center justify-center">
                                <i class="bi bi-exclamation-triangle-fill text-base sm:text-xl"></i>
                            </div>
                            <span class="font-bold text-sm sm:text-base">Konfirmasi Hapus</span>
                        </div>
                        <button type="button" data-modal-close class="text-gray-400 hover:text-gray-900 dark:hover:text-white transition-colors p-1">
                            <i class="bi bi-x-lg text-lg sm:text-xl"></i>
                        </button>
                    </div>
                    <div class="p-3 sm:p-4 text-center">
                        <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-full bg-red-100 dark:bg-red-900/30 flex items-center justify-center mx-auto mb-3 sm:mb-4">
                            <i class="bi bi-trash text-3xl sm:text-4xl text-red-600 dark:text-red-400"></i>
                        </div>
                        <h4 class="text-base sm:text-lg font-bold text-gray-800 dark:text-gray-100 mb-1 sm:mb-2">
                            Yakin ingin menghapus data?
                        </h4>
                        <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 wrap-break-word">
                            Data sarana <strong class="text-gray-700 dark:text-gray-300">{{ $sarana->nama_sekolah }}</strong> akan dihapus permanen.
                        </p>
                    </div>
                    <div class="flex flex-wrap justify-end gap-2 p-3 sm:p-4 border-t dark:border-gray-700">
                        <button type="button" data-modal-close class="px-3 sm:px-4 py-1.5 sm:py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 text-xs sm:text-sm font-medium rounded-lg transition-colors dark:bg-gray-700 dark:text-white dark:hover:bg-gray-600">
                            <i class="bi bi-x-circle me-1"></i> Batal
                        </button>
                        <form action="{{ route('sarana.destroy', $sarana->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-3 sm:px-4 py-1.5 sm:py-2 bg-red-600 hover:bg-red-700 text-white text-xs sm:text-sm font-medium rounded-lg transition-colors shadow-md hover:shadow-lg">
                                <i class="bi bi-trash me-1"></i> Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Modal functionality
        document.querySelectorAll('[data-modal-open]').forEach(trigger => {
            trigger.addEventListener('click', function() {
                const targetId = this.dataset.modalOpen;
                const modal = document.getElementById(targetId);
                if (modal) {
                    modal.classList.remove('hidden');
                    modal.style.display = 'block';
                    document.body.style.overflow = 'hidden';
                }
            });
        });

        document.querySelectorAll('[data-modal-close]').forEach(button => {
            button.addEventListener('click', function() {
                const modal = this.closest('[data-modal]');
                if (modal) {
                    modal.classList.add('hidden');
                    modal.style.display = 'none';
                    document.body.style.overflow = '';
                }
            });
        });

        document.querySelectorAll('[data-modal]').forEach(modal => {
            modal.addEventListener('click', function(e) {
                if (e.target === this || e.target.classList.contains('backdrop-blur-sm')) {
                    this.classList.add('hidden');
                    this.style.display = 'none';
                    document.body.style.overflow = '';
                }
            });
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                document.querySelectorAll('[data-modal]:not(.hidden)').forEach(modal => {
                    modal.classList.add('hidden');
                    modal.style.display = 'none';
                    document.body.style.overflow = '';
                });
            }
        });
    });
</script>

<style>
    .wrap-break-word {
        word-wrap: break-word;
        white-space: normal;
    }
</style>
@endsection