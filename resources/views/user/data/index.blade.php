@extends('layouts.app')

@section('title', 'Data Sarana & Prasarana')

@section('content')
<div class="container mx-auto px-3 sm:px-4 py-3 sm:py-4">
    <div class="flex flex-col gap-3 sm:gap-4">
        <!-- Header -->
        <div class="flex flex-wrap items-center justify-between gap-2">
            <div>
                <h1 class="text-lg sm:text-xl font-semibold text-gray-800 dark:text-gray-100 flex items-center gap-2">
                    <i class="bi bi-building text-blue-600 dark:text-blue-400"></i>
                    <span class="hidden sm:inline">Data Sarana & Prasarana</span>
                    <span class="sm:hidden">Sarana</span>
                </h1>
                <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 hidden sm:block">
                    Kelola data profileSekolah prasarana sekolah Anda
                </p>
            </div>
            <div class="flex flex-wrap gap-1.5 sm:gap-2">
                @if(!$profileSekolah)
                    <a href="{{ route('user.data.create') }}" class="inline-flex">
                        <x-button variant="primary" size="sm">
                            <i class="bi bi-plus-circle me-1 text-xs sm:text-sm"></i>
                            <span class="hidden sm:inline">Tambah Data</span>
                            <span class="sm:hidden">Tambah</span>
                        </x-button>
                    </a>
                @endif
            </div>
        </div>

        <!-- Content -->
        @if($profileSekolah)
            <!-- A. Data Sekolah -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="p-3 sm:p-4 border-b border-gray-200 dark:border-gray-700 bg-linear-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20">
                    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-2">
                        <div class="flex items-center gap-2 text-blue-600 dark:text-blue-400 font-semibold text-sm sm:text-base">
                            <i class="bi bi-building"></i>
                            <span>A. Data Sekolah</span>
                        </div>
                        <div class="flex flex-wrap gap-1.5 w-full sm:w-auto">
                            <a href="{{ route('user.data.edit', $profileSekolah->id) }}" class="flex-1 sm:flex-none inline-flex">
                                <x-button variant="warning" size="xs" fullWidth>
                                    <i class="bi bi-database-up me-1"></i>
                                    <span class="inline">Update</span>
                                </x-button>
                            </a>
                            <x-button type="button" variant="danger" size="xs" data-modal-open="deleteModal" class="flex-1 sm:flex-none">
                                <i class="bi bi-trash me-1"></i>
                                <span class="inline">Hapus</span>
                            </x-button>
                        </div>
                    </div>
                </div>
                <div class="p-3 sm:p-4 space-y-2 sm:space-y-3">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 sm:gap-3">
                        <div class="bg-gray-50 dark:bg-gray-700/30 p-2 sm:p-3 rounded-lg">
                            <p class="text-[10px] sm:text-xs text-gray-500 dark:text-gray-400">Nama Sekolah</p>
                            <p class="text-xs sm:text-sm font-medium text-gray-900 dark:text-white wrap-break-word">{{ $profileSekolah->nama_sekolah }}</p>
                        </div>
                        <div class="bg-gray-50 dark:bg-gray-700/30 p-2 sm:p-3 rounded-lg">
                            <p class="text-[10px] sm:text-xs text-gray-500 dark:text-gray-400">NPSN</p>
                            <p class="text-xs sm:text-sm font-medium text-gray-900 dark:text-white">{{ $profileSekolah->NPSN }}</p>
                        </div>
                        <div class="sm:col-span-2 bg-gray-50 dark:bg-gray-700/30 p-2 sm:p-3 rounded-lg">
                            <p class="text-[10px] sm:text-xs text-gray-500 dark:text-gray-400">Alamat Sekolah</p>
                            <p class="text-xs sm:text-sm font-medium text-gray-900 dark:text-white wrap-break-word">{{ $profileSekolah->alamat_sekolah }}</p>
                        </div>
                        <div class="bg-gray-50 dark:bg-gray-700/30 p-2 sm:p-3 rounded-lg">
                            <p class="text-[10px] sm:text-xs text-gray-500 dark:text-gray-400">Kepala Sekolah</p>
                            <p class="text-xs sm:text-sm font-medium text-gray-900 dark:text-white wrap-break-word">{{ $profileSekolah->nama_kepala_sekolah }}</p>
                            <p class="text-[10px] text-gray-500 dark:text-gray-400">NIP: {{ $profileSekolah->NIP }}</p>
                        </div>
                        <div class="bg-gray-50 dark:bg-gray-700/30 p-2 sm:p-3 rounded-lg">
                            <p class="text-[10px] sm:text-xs text-gray-500 dark:text-gray-400">Nomor HP</p>
                            <p class="text-xs sm:text-sm font-medium text-gray-900 dark:text-white">{{ $profileSekolah->nomor_hp }}</p>
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
                            <p class="text-[10px] sm:text-xs text-gray-500 dark:text-gray-400">Kelas VII</p>
                            <p class="text-lg sm:text-2xl font-bold text-gray-900 dark:text-white">{{ $profileSekolah->jumlahSiswa?->vii ?? 0 }}</p>
                        </div>
                        <div class="bg-emerald-50 dark:bg-emerald-900/20 p-2 sm:p-3 rounded-lg text-center">
                            <p class="text-[10px] sm:text-xs text-gray-500 dark:text-gray-400">Kelas VIII</p>
                            <p class="text-lg sm:text-2xl font-bold text-gray-900 dark:text-white">{{ $profileSekolah->jumlahSiswa?->viii ?? 0 }}</p>
                        </div>
                        <div class="bg-teal-50 dark:bg-teal-900/20 p-2 sm:p-3 rounded-lg text-center">
                            <p class="text-[10px] sm:text-xs text-gray-500 dark:text-gray-400">Kelas IX</p>
                            <p class="text-lg sm:text-2xl font-bold text-gray-900 dark:text-white">{{ $profileSekolah->jumlahSiswa?->ix ?? 0 }}</p>
                        </div>
                    </div>
                    <div class="mt-2 sm:mt-3 pt-2 sm:pt-3 border-t border-gray-200 dark:border-gray-700">
                        <div class="flex justify-between items-center">
                            <span class="text-xs sm:text-sm text-gray-600 dark:text-gray-400">Total Siswa</span>
                            <span class="text-base sm:text-lg font-bold text-green-600 dark:text-green-400">
                                {{ ($profileSekolah->jumlahSiswa?->vii ?? 0) + ($profileSekolah->jumlahSiswa?->viii ?? 0) + ($profileSekolah->jumlahSiswa?->ix ?? 0) }}
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
                            <p class="text-[10px] sm:text-xs text-gray-500 dark:text-gray-400">Kelas VII</p>
                            <p class="text-lg sm:text-2xl font-bold text-gray-900 dark:text-white">{{ $profileSekolah->jumlahRombel?->vii ?? 0 }}</p>
                        </div>
                        <div class="bg-violet-50 dark:bg-violet-900/20 p-2 sm:p-3 rounded-lg text-center">
                            <p class="text-[10px] sm:text-xs text-gray-500 dark:text-gray-400">Kelas VIII</p>
                            <p class="text-lg sm:text-2xl font-bold text-gray-900 dark:text-white">{{ $profileSekolah->jumlahRombel?->viii ?? 0 }}</p>
                        </div>
                        <div class="bg-indigo-50 dark:bg-indigo-900/20 p-2 sm:p-3 rounded-lg text-center">
                            <p class="text-[10px] sm:text-xs text-gray-500 dark:text-gray-400">Kelas IX</p>
                            <p class="text-lg sm:text-2xl font-bold text-gray-900 dark:text-white">{{ $profileSekolah->jumlahRombel?->ix ?? 0 }}</p>
                        </div>
                    </div>
                    <div class="mt-2 sm:mt-3 pt-2 sm:pt-3 border-t border-gray-200 dark:border-gray-700">
                        <div class="flex justify-between items-center">
                            <span class="text-xs sm:text-sm text-gray-600 dark:text-gray-400">Total Rombel</span>
                            <span class="text-base sm:text-lg font-bold text-purple-600 dark:text-purple-400">
                                {{ ($profileSekolah->jumlahRombel?->vii ?? 0) + ($profileSekolah->jumlahRombel?->viii ?? 0) + ($profileSekolah->jumlahRombel?->ix ?? 0) }}
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
                            <span class="inline">D. Pembangunan Ruang Kelas Baru (RKB) </span>
                        </div>
                    </div>
                    <div class="p-2 sm:p-3 text-center">
                        <p class="text-xl sm:text-3xl font-bold text-blue-600 dark:text-blue-400">{{ $profileSekolah->ruangKelasBaru?->jumlah ?? 0 }}</p>
                        <p class="text-[8px] sm:text-xs text-gray-500 dark:text-gray-400">Ruang Kelas Baru</p>
                        <p class="text-[8px] sm:text-xs text-gray-400 dark:text-gray-500">
                            {{ $rkbPeriode->label() }}
                        </p>
                    </div>
                </div>
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="p-2 sm:p-3 border-b border-gray-200 dark:border-gray-700 bg-linear-to-r from-orange-50 to-amber-50 dark:from-orange-900/20 dark:to-amber-900/20">
                        <div class="flex items-center gap-1.5 sm:gap-2 text-orange-700 dark:text-orange-400 font-semibold text-[10px] sm:text-sm">
                            <i class="bi bi-tools text-sm sm:text-lg"></i>
                            <span class="inline">E. Rehabilitasi Ruang Kelas</span>
                        </div>
                    </div>
                    <div class="p-2 sm:p-3 text-center">
                        <p class="text-xl sm:text-3xl font-bold text-orange-600 dark:text-orange-400">{{ $profileSekolah->rehabilitasiRuangKelas?->jumlah ?? 0 }}</p>
                        <p class="text-[8px] sm:text-xs text-gray-500 dark:text-gray-400">Ruang Kelas</p>
                        <p class="text-[8px] sm:text-xs text-gray-400 dark:text-gray-500">
                            {{ $rehabilitasiPeriode->label() }}
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
                            <p class="text-lg sm:text-2xl font-bold text-green-600 dark:text-green-400">{{ $profileSekolah->ruangKelas?->bagus ?? 0 }}</p>
                        </div>
                        <div class="bg-red-50 dark:bg-red-900/20 p-2 sm:p-3 rounded-lg text-center">
                            <p class="text-[10px] sm:text-xs text-gray-500 dark:text-gray-400">Rusak</p>
                            <p class="text-lg sm:text-2xl font-bold text-red-600 dark:text-red-400">{{ $profileSekolah->ruangKelas?->rusak ?? 0 }}</p>
                        </div>
                    </div>
                    <div class="mt-2 sm:mt-3 pt-2 sm:pt-3 border-t border-gray-200 dark:border-gray-700">
                        <div class="flex justify-between items-center">
                            <span class="text-xs sm:text-sm text-gray-600 dark:text-gray-400">Total Ruang Kelas</span>
                            <span class="text-base sm:text-lg font-bold text-blue-600 dark:text-blue-400">
                                {{ ($profileSekolah->ruangKelas?->bagus ?? 0) + ($profileSekolah->ruangKelas?->rusak ?? 0) }}
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
                                <p class="text-base sm:text-xl font-bold text-green-600 dark:text-green-400">{{ $profileSekolah->toiletSiswa?->bagus ?? 0 }}</p>
                            </div>
                            <div class="bg-red-50 dark:bg-red-900/20 p-1.5 sm:p-2 rounded-lg text-center">
                                <p class="text-[8px] sm:text-xs text-gray-500 dark:text-gray-400">Rusak</p>
                                <p class="text-base sm:text-xl font-bold text-red-600 dark:text-red-400">{{ $profileSekolah->toiletSiswa?->rusak ?? 0 }}</p>
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
                                <p class="text-base sm:text-xl font-bold text-green-600 dark:text-green-400">{{ $profileSekolah->toiletGuru?->bagus ?? 0 }}</p>
                            </div>
                            <div class="bg-red-50 dark:bg-red-900/20 p-1.5 sm:p-2 rounded-lg text-center">
                                <p class="text-[8px] sm:text-xs text-gray-500 dark:text-gray-400">Rusak</p>
                                <p class="text-base sm:text-xl font-bold text-red-600 dark:text-red-400">{{ $profileSekolah->toiletGuru?->rusak ?? 0 }}</p>
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
                                ['label' => 'Pagar', 'value' => $profileSekolah->pagarSekolah?->{'ada/tidak_ada'}, 'icon' => 'bi-border-all'],
                                ['label' => 'Air Bersih', 'value' => $profileSekolah->airBersih?->{'ada/tidak_ada'}, 'icon' => 'bi-droplet'],
                                ['label' => 'Perpustakaan', 'value' => $profileSekolah->ruangPerpustakaan?->{'ada/tidak_ada'}, 'icon' => 'bi-book'],
                                ['label' => 'R. Kepsek', 'value' => $profileSekolah->ruangKepalaSekolah?->{'ada/tidak_ada'}, 'icon' => 'bi-person-workspace'],
                                ['label' => 'R. Guru', 'value' => $profileSekolah->ruangGuru?->{'ada/tidak_ada'}, 'icon' => 'bi-easel2'],
                                ['label' => 'R. TU', 'value' => $profileSekolah->ruangKantorTu?->{'ada/tidak_ada'}, 'icon' => 'bi-briefcase'],
                                ['label' => 'Lab IPA', 'value' => $profileSekolah->labIpa?->{'ada/tidak_ada'}, 'icon' => 'bi-flask'],
                                ['label' => 'Lab Komputer', 'value' => $profileSekolah->labKomputer?->{'ada/tidak_ada'}, 'icon' => 'bi-pc-display-horizontal'],
                                ['label' => 'UKS', 'value' => $profileSekolah->unitKesehatanSekolah?->{'ada/tidak_ada'}, 'icon' => 'bi-heart-pulse'],
                                ['label' => 'Rumah Dinas', 'value' => $profileSekolah->rumahDinas?->{'ada/tidak_ada'}, 'icon' => 'bi-house-door'],
                                ['label' => 'Rumah Ibadah', 'value' => $profileSekolah->rumahIbadah?->{'ada/tidak_ada'}, 'icon' => 'bi-building'],
                                ['label' => 'Lapangan', 'value' => $profileSekolah->lapanganSekolah?->{'ada/tidak_ada'}, 'icon' => 'bi-flag'],
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
                                {{ ($profileSekolah->kursiSiswa?->bagus ?? 0) + ($profileSekolah->kursiSiswa?->rusak ?? 0) }}
                                <span class="text-[8px] sm:text-[10px] font-normal text-gray-500 dark:text-gray-400">
                                    (B: {{ $profileSekolah->kursiSiswa?->bagus ?? 0 }} | R: {{ $profileSekolah->kursiSiswa?->rusak ?? 0 }})
                                </span>
                            </span>
                        </div>
                        <div class="flex justify-between items-center p-1.5 sm:p-2 bg-gray-50 dark:bg-gray-700/30 rounded-lg">
                            <span class="text-[10px] sm:text-xs text-gray-600 dark:text-gray-400">Meja Siswa</span>
                            <span class="text-xs sm:text-sm font-bold text-gray-900 dark:text-white">
                                {{ ($profileSekolah->mejaSiswa?->bagus ?? 0) + ($profileSekolah->mejaSiswa?->rusak ?? 0) }}
                                <span class="text-[8px] sm:text-[10px] font-normal text-gray-500 dark:text-gray-400">
                                    (B: {{ $profileSekolah->mejaSiswa?->bagus ?? 0 }} | R: {{ $profileSekolah->mejaSiswa?->rusak ?? 0 }})
                                </span>
                            </span>
                        </div>
                        <div class="flex justify-between items-center p-1.5 sm:p-2 bg-gray-50 dark:bg-gray-700/30 rounded-lg">
                            <span class="text-[10px] sm:text-xs text-gray-600 dark:text-gray-400">Kursi Guru</span>
                            <span class="text-xs sm:text-sm font-bold text-gray-900 dark:text-white">
                                {{ ($profileSekolah->kursiGuru?->bagus ?? 0) + ($profileSekolah->kursiGuru?->rusak ?? 0) }}
                                <span class="text-[8px] sm:text-[10px] font-normal text-gray-500 dark:text-gray-400">
                                    (B: {{ $profileSekolah->kursiGuru?->bagus ?? 0 }} | R: {{ $profileSekolah->kursiGuru?->rusak ?? 0 }})
                                </span>
                            </span>
                        </div>
                        <div class="flex justify-between items-center p-1.5 sm:p-2 bg-gray-50 dark:bg-gray-700/30 rounded-lg">
                            <span class="text-[10px] sm:text-xs text-gray-600 dark:text-gray-400">Meja Guru</span>
                            <span class="text-xs sm:text-sm font-bold text-gray-900 dark:text-white">
                                {{ ($profileSekolah->mejaGuru?->bagus ?? 0) + ($profileSekolah->mejaGuru?->rusak ?? 0) }}
                                <span class="text-[8px] sm:text-[10px] font-normal text-gray-500 dark:text-gray-400">
                                    (B: {{ $profileSekolah->mejaGuru?->bagus ?? 0 }} | R: {{ $profileSekolah->mejaGuru?->rusak ?? 0 }})
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
                                {{ ($profileSekolah->laptop?->bagus ?? 0) + ($profileSekolah->laptop?->rusak ?? 0) }}
                                <span class="text-[8px] sm:text-[10px] font-normal text-gray-500 dark:text-gray-400">
                                    (B: {{ $profileSekolah->laptop?->bagus ?? 0 }} | R: {{ $profileSekolah->laptop?->rusak ?? 0 }})
                                </span>
                            </span>
                        </div>
                        <div class="flex justify-between items-center p-1.5 sm:p-2 bg-gray-50 dark:bg-gray-700/30 rounded-lg">
                            <span class="text-[10px] sm:text-xs text-gray-600 dark:text-gray-400">Komputer</span>
                            <span class="text-xs sm:text-sm font-bold text-gray-900 dark:text-white">
                                {{ ($profileSekolah->komputer?->bagus ?? 0) + ($profileSekolah->komputer?->rusak ?? 0) }}
                                <span class="text-[8px] sm:text-[10px] font-normal text-gray-500 dark:text-gray-400">
                                    (B: {{ $profileSekolah->komputer?->bagus ?? 0 }} | R: {{ $profileSekolah->komputer?->rusak ?? 0 }})
                                </span>
                            </span>
                        </div>
                        <div class="flex justify-between items-center p-1.5 sm:p-2 bg-gray-50 dark:bg-gray-700/30 rounded-lg">
                            <span class="text-[10px] sm:text-xs text-gray-600 dark:text-gray-400">Chromebook</span>
                            <span class="text-xs sm:text-sm font-bold text-gray-900 dark:text-white">
                                {{ ($profileSekolah->chromebook?->bagus ?? 0) + ($profileSekolah->chromebook?->rusak ?? 0) }}
                                <span class="text-[8px] sm:text-[10px] font-normal text-gray-500 dark:text-gray-400">
                                    (B: {{ $profileSekolah->chromebook?->bagus ?? 0 }} | R: {{ $profileSekolah->chromebook?->rusak ?? 0 }})
                                </span>
                            </span>
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
                                Data profileSekolah <strong class="text-gray-700 dark:text-gray-300">{{ $profileSekolah->nama_sekolah }}</strong> akan dihapus permanen.
                            </p>
                        </div>
                        <div class="flex flex-wrap justify-end gap-2 p-3 sm:p-4 border-t dark:border-gray-700">
                            <button type="button" data-modal-close class="px-3 sm:px-4 py-1.5 sm:py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 text-xs sm:text-sm font-medium rounded-lg transition-colors dark:bg-gray-700 dark:text-white dark:hover:bg-gray-600">
                                <i class="bi bi-x-circle me-1"></i> Batal
                            </button>
                            <form action="{{ route('user.data.destroy', $profileSekolah->id) }}" method="POST" class="inline">
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

        @else
            <!-- Empty State -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="text-center py-8 sm:py-12 px-3 sm:px-4">
                    <div class="relative inline-block">
                        <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-full bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center mx-auto mb-4 sm:mb-6">
                            <i class="bi bi-building text-4xl sm:text-5xl text-blue-600 dark:text-blue-400"></i>
                        </div>
                        <div class="absolute -top-1 -right-1 w-6 h-6 sm:w-8 sm:h-8 rounded-full bg-yellow-400 flex items-center justify-center shadow-lg">
                            <i class="bi bi-plus-lg text-white text-[10px] sm:text-sm"></i>
                        </div>
                    </div>
                    <h3 class="text-base sm:text-xl font-bold text-gray-800 dark:text-gray-100 mb-1 sm:mb-2">
                        Belum Ada Data Sarana
                    </h3>
                    <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mb-4 sm:mb-6 max-w-md mx-auto px-2">
                        Anda belum memiliki data profileSekolah prasarana sekolah. Mulai dengan menambahkan data sekarang.
                    </p>
                    <a href="{{ route('user.data.create') }}" 
                       class="inline-flex items-center px-4 sm:px-6 py-2 sm:py-3 bg-blue-600 hover:bg-blue-700 text-white text-sm sm:text-base font-semibold rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl">
                        <i class="bi bi-plus-lg me-1 sm:me-2"></i>
                        Tambah Data Sekarang
                    </a>
                </div>
            </div>
        @endif
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
@endsection