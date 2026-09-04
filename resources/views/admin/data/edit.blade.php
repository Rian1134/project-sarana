@extends('layouts.admin')

@section('title')
    Edit Data Sarana & Prasarana
@endsection

@section('content')
<div class="container mx-auto px-3 sm:px-4 py-3 sm:py-4">
    <div class="flex flex-col gap-3 sm:gap-4">
        <!-- Header -->
        <div class="flex flex-wrap items-center justify-between gap-2">
            <div>
                <h1 class="text-base sm:text-xl font-semibold text-gray-800 dark:text-gray-100 flex items-center gap-2">
                    <i class="bi bi-pencil-square text-yellow-600 dark:text-yellow-400"></i>
                    <span class="hidden sm:inline">Form Edit Data Sarana & Prasarana Sekolah</span>
                    <span class="sm:hidden">Edit Data</span>
                </h1>
                <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 hidden sm:block">
                    Edit data profileSekolah prasarana sekolah yang sudah ada
                </p>
            </div>
            <a href="{{ route('sarana.index') }}" class="inline-flex">
                <x-button variant="secondary" size="sm">
                    <i class="bi bi-arrow-left me-1"></i>
                    <span class="hidden sm:inline">Kembali</span>
                    <span class="sm:hidden">Back</span>
                </x-button>
            </a>
        </div>

        {{-- Alert error/success sudah ditangani otomatis oleh master layout --}}

        <!-- Form -->
        <form action="{{ route('sarana.update', $profileSekolah->id) }}" method="POST" id="saranaForm" class="flex flex-col gap-3 sm:gap-4">
            @csrf
            @method('PUT')

            <!-- A. Data Sekolah -->
            <x-card>
                <x-slot:header>
                    <div class="flex items-center gap-2 text-blue-600 dark:text-blue-400 font-semibold text-xs sm:text-sm">
                        <i class="bi bi-building"></i>
                        <span>A. Data Sekolah</span>
                    </div>
                </x-slot:header>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5 sm:gap-4">
                    <div class="sm:col-span-2">
                        <x-form.input 
                            name="nama_sekolah" 
                            label="Nama Sekolah" 
                            required 
                            placeholder="Masukkan nama sekolah" 
                            value="{{ old('nama_sekolah', $profileSekolah->nama_sekolah) }}"
                        />
                    </div>

                    <x-form.input 
                        name="NPSN" 
                        label="NPSN" 
                        required 
                        placeholder="Masukkan NPSN" 
                        value="{{ old('NPSN', $profileSekolah->NPSN) }}"
                    />

                    <x-form.input 
                        name="nomor_hp" 
                        label="Nomor HP" 
                        required 
                        placeholder="Masukkan nomor HP" 
                        value="{{ old('nomor_hp', $profileSekolah->nomor_hp) }}"
                    />

                    <div class="sm:col-span-2">
                        <x-form.textarea 
                            name="alamat_sekolah" 
                            label="Alamat Sekolah" 
                            rows="2" 
                            required 
                            placeholder="Masukkan alamat lengkap sekolah"
                        >{{ old('alamat_sekolah', $profileSekolah->alamat_sekolah) }}</x-form.textarea>
                    </div>

                    <x-form.input 
                        name="nama_kepala_sekolah" 
                        label="Nama Kepala Sekolah" 
                        required 
                        placeholder="Masukkan nama kepala sekolah" 
                        value="{{ old('nama_kepala_sekolah', $profileSekolah->nama_kepala_sekolah) }}"
                    />

                    <x-form.input 
                        name="NIP" 
                        label="NIP" 
                        required 
                        placeholder="Masukkan NIP" 
                        value="{{ old('NIP', $profileSekolah->NIP) }}"
                    />
                </div>
            </x-card>

            <!-- B. Jumlah Siswa -->
            <x-card>
                <x-slot:header>
                    <div class="flex items-center gap-2 text-green-700 dark:text-green-400 font-semibold text-xs sm:text-sm">
                        <i class="bi bi-mortarboard"></i>
                        <span>B. Jumlah Siswa</span>
                    </div>
                </x-slot:header>

                <div class="grid grid-cols-3 gap-2 sm:gap-4">
                    <x-form.input 
                        name="jumlah_siswa_vii" 
                        label="Kelas VII" 
                        type="number" 
                        required 
                        value="{{ old('jumlah_siswa_vii', $profileSekolah->jumlahSiswa?->vii ?? 0) }}" 
                        min="0"
                    />
                    <x-form.input 
                        name="jumlah_siswa_viii" 
                        label="Kelas VIII" 
                        type="number" 
                        required 
                        value="{{ old('jumlah_siswa_viii', $profileSekolah->jumlahSiswa?->viii ?? 0) }}" 
                        min="0"
                    />
                    <x-form.input 
                        name="jumlah_siswa_ix" 
                        label="Kelas IX" 
                        type="number" 
                        required 
                        value="{{ old('jumlah_siswa_ix', $profileSekolah->jumlahSiswa?->ix ?? 0) }}" 
                        min="0"
                    />
                </div>
            </x-card>

            <!-- C. Jumlah Rombongan Belajar -->
            <x-card>
                <x-slot:header>
                    <div class="flex items-center gap-2 text-purple-700 dark:text-purple-400 font-semibold text-xs sm:text-sm">
                        <i class="bi bi-diagram-3"></i>
                        <span>C. Jumlah Rombongan Belajar</span>
                    </div>
                </x-slot:header>

                <div class="grid grid-cols-3 gap-2 sm:gap-4">
                    <x-form.input 
                        name="jumlah_rombel_vii" 
                        label="Kelas VII" 
                        type="number" 
                        required 
                        value="{{ old('jumlah_rombel_vii', $profileSekolah->jumlahRombel?->vii ?? 0) }}" 
                        min="0"
                    />
                    <x-form.input 
                        name="jumlah_rombel_viii" 
                        label="Kelas VIII" 
                        type="number" 
                        required 
                        value="{{ old('jumlah_rombel_viii', $profileSekolah->jumlahRombel?->viii ?? 0) }}" 
                        min="0"
                    />
                    <x-form.input 
                        name="jumlah_rombel_ix" 
                        label="Kelas IX" 
                        type="number" 
                        required 
                        value="{{ old('jumlah_rombel_ix', $profileSekolah->jumlahRombel?->ix ?? 0) }}" 
                        min="0"
                    />
                </div>
            </x-card>

            <!-- D. RKB (Ruang Kelas Baru) -->
            <x-card>
                <x-slot:header>
                    <div class="flex items-center gap-2 text-blue-700 dark:text-blue-400 font-semibold text-xs sm:text-sm">
                        <i class="bi bi-building-add"></i>
                        <span class="inline">D. Pembangunan Ruang Kelas Baru (RKB)</span>
                    </div>
                </x-slot:header>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-2 sm:gap-4 items-end">
                    <x-form.input 
                        name="rkb_jumlah" 
                        label="Jumlah" 
                        type="number" 
                        required 
                        value="{{ old('rkb_jumlah', $profileSekolah->ruangKelasBaru?->jumlah ?? 0) }}" 
                        min="0"
                    />
                    <div class="sm:col-span-2 flex flex-wrap items-center gap-2 text-xs sm:text-sm text-gray-500 dark:text-gray-400 pb-1.5">
                        <i class="bi bi-calendar-range"></i>
                        Periode pelaporan:
                        <x-badge variant="secondary">{{ $rkbPeriode->label() }}</x-badge>
                        <span class="text-[10px] text-gray-400">(diatur admin, berlaku untuk semua sekolah)</span>
                    </div>
                </div>
            </x-card>

            <!-- E. Rehabilitasi Ruang Kelas -->
            <x-card>
                <x-slot:header>
                    <div class="flex items-center gap-2 text-orange-700 dark:text-orange-400 font-semibold text-xs sm:text-sm">
                        <i class="bi bi-tools"></i>
                        <span class="inline">E. Rehabilitasi Ruang Kelas</span>
                    </div>
                </x-slot:header>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-2 sm:gap-4 items-end">
                    <x-form.input 
                        name="rehabilitasi_jumlah" 
                        label="Jumlah" 
                        type="number" 
                        required 
                        value="{{ old('rehabilitasi_jumlah', $profileSekolah->rehabilitasiRuangKelas?->jumlah ?? 0) }}" 
                        min="0"
                    />
                    <div class="sm:col-span-2 flex flex-wrap items-center gap-2 text-xs sm:text-sm text-gray-500 dark:text-gray-400 pb-1.5">
                        <i class="bi bi-calendar-range"></i>
                        Periode pelaporan:
                        <x-badge variant="secondary">{{ $rehabilitasiPeriode->label() }}</x-badge>
                        <span class="text-[10px] text-gray-400">(diatur admin, berlaku untuk semua sekolah)</span>
                    </div>
                </div>
            </x-card>

            <!-- F. Ruang Kelas -->
            <x-card>
                <x-slot:header>
                    <div class="flex items-center gap-2 text-blue-700 dark:text-blue-400 font-semibold text-xs sm:text-sm">
                        <i class="bi bi-door-closed"></i>
                        <span>F. Ruang Kelas</span>
                    </div>
                </x-slot:header>

                <div class="grid grid-cols-2 gap-2 sm:gap-4">
                    <x-form.input 
                        name="ruang_kelas_bagus" 
                        label="Bagus" 
                        type="number" 
                        required 
                        value="{{ old('ruang_kelas_bagus', $profileSekolah->ruangKelas?->bagus ?? 0) }}" 
                        min="0"
                    />
                    <x-form.input 
                        name="ruang_kelas_rusak" 
                        label="Rusak" 
                        type="number" 
                        required 
                        value="{{ old('ruang_kelas_rusak', $profileSekolah->ruangKelas?->rusak ?? 0) }}" 
                        min="0"
                    />
                </div>
            </x-card>

            <!-- G. Toilet Siswa & H. Toilet Guru -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
                <x-card>
                    <x-slot:header>
                        <div class="flex items-center gap-2 text-cyan-700 dark:text-cyan-400 font-semibold text-xs sm:text-sm">
                            <i class="bi bi-droplet-half"></i>
                            <span class="inline">G. Toilet Siswa</span>
                        </div>
                    </x-slot:header>

                    <div class="grid grid-cols-2 gap-2">
                        <x-form.input 
                            name="toilet_siswa_bagus" 
                            label="Bagus" 
                            type="number" 
                            required 
                            value="{{ old('toilet_siswa_bagus', $profileSekolah->toiletSiswa?->bagus ?? 0) }}" 
                            min="0"
                        />
                        <x-form.input 
                            name="toilet_siswa_rusak" 
                            label="Rusak" 
                            type="number" 
                            required 
                            value="{{ old('toilet_siswa_rusak', $profileSekolah->toiletSiswa?->rusak ?? 0) }}" 
                            min="0"
                        />
                    </div>
                </x-card>

                <x-card>
                    <x-slot:header>
                        <div class="flex items-center gap-2 text-cyan-700 dark:text-cyan-400 font-semibold text-xs sm:text-sm">
                            <i class="bi bi-droplet"></i>
                            <span class="inline">H. Toilet Guru</span>
                        </div>
                    </x-slot:header>

                    <div class="grid grid-cols-2 gap-2">
                        <x-form.input 
                            name="toilet_guru_bagus" 
                            label="Bagus" 
                            type="number" 
                            required 
                            value="{{ old('toilet_guru_bagus', $profileSekolah->toiletGuru?->bagus ?? 0) }}" 
                            min="0"
                        />
                        <x-form.input 
                            name="toilet_guru_rusak" 
                            label="Rusak" 
                            type="number" 
                            required 
                            value="{{ old('toilet_guru_rusak', $profileSekolah->toiletGuru?->rusak ?? 0) }}" 
                            min="0"
                        />
                    </div>
                </x-card>
            </div>

            <!-- I. Ruang Perpustakaan -->
            <x-card>
                <x-slot:header>
                    <div class="flex items-center gap-2 text-yellow-700 dark:text-yellow-400 font-semibold text-xs sm:text-sm">
                        <i class="bi bi-book"></i>
                        <span>I. Ruang Perpustakaan</span>
                    </div>
                </x-slot:header>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 sm:gap-4">
                    <div>
                        <label class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Keberadaan <span class="text-red-600">*</span>
                        </label>
                        <div class="flex flex-wrap gap-3 sm:gap-4 mt-1">
                            <x-form.radio 
                                name="perpustakaan_ada_tidak" 
                                value="ada" 
                                label="Ada" 
                                :checked="old('perpustakaan_ada_tidak', $profileSekolah->ruangPerpustakaan?->{'ada/tidak_ada'}) == 'ada'"
                            />
                            <x-form.radio 
                                name="perpustakaan_ada_tidak" 
                                value="tidak_ada" 
                                label="Tidak Ada" 
                                :checked="old('perpustakaan_ada_tidak', $profileSekolah->ruangPerpustakaan?->{'ada/tidak_ada'}) == 'tidak_ada'"
                            />
                        </div>
                        @error('perpustakaan_ada_tidak')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <x-form.select 
                        name="perpustakaan_kondisi" 
                        label="Kondisi" 
                        :options="['' => '-- Pilih --', 'bagus' => 'Bagus', 'rusak' => 'Rusak', 'nihil' => 'Nihil']" 
                        value="{{ old('perpustakaan_kondisi', $profileSekolah->ruangPerpustakaan?->kodisi) }}"
                    />
                </div>
            </x-card>

            <!-- J. Ruang Kepala Sekolah -->
            <x-card>
                <x-slot:header>
                    <div class="flex items-center gap-2 text-pink-700 dark:text-pink-400 font-semibold text-xs sm:text-sm">
                        <i class="bi bi-person-workspace"></i>
                        <span>J. Ruang Kepala Sekolah</span>
                    </div>
                </x-slot:header>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 sm:gap-4">
                    <div>
                        <label class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Keberadaan <span class="text-red-600">*</span>
                        </label>
                        <div class="flex flex-wrap gap-3 sm:gap-4 mt-1">
                            <x-form.radio 
                                name="kepala_sekolah_ada_tidak" 
                                value="ada" 
                                label="Ada" 
                                :checked="old('kepala_sekolah_ada_tidak', $profileSekolah->ruangKepalaSekolah?->{'ada/tidak_ada'}) == 'ada'"
                            />
                            <x-form.radio 
                                name="kepala_sekolah_ada_tidak" 
                                value="tidak_ada" 
                                label="Tidak Ada" 
                                :checked="old('kepala_sekolah_ada_tidak', $profileSekolah->ruangKepalaSekolah?->{'ada/tidak_ada'}) == 'tidak_ada'"
                            />
                        </div>
                        @error('kepala_sekolah_ada_tidak')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <x-form.select 
                        name="kepala_sekolah_kondisi" 
                        label="Kondisi" 
                        :options="['' => '-- Pilih --', 'bagus' => 'Bagus', 'rusak' => 'Rusak', 'nihil' => 'Nihil']" 
                        value="{{ old('kepala_sekolah_kondisi', $profileSekolah->ruangKepalaSekolah?->kodisi) }}"
                    />
                </div>
            </x-card>

            <!-- K. Ruang Guru -->
            <x-card>
                <x-slot:header>
                    <div class="flex items-center gap-2 text-indigo-700 dark:text-indigo-400 font-semibold text-xs sm:text-sm">
                        <i class="bi bi-easel2"></i>
                        <span>K. Ruang Guru</span>
                    </div>
                </x-slot:header>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 sm:gap-4">
                    <div>
                        <label class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Keberadaan <span class="text-red-600">*</span>
                        </label>
                        <div class="flex flex-wrap gap-3 sm:gap-4 mt-1">
                            <x-form.radio 
                                name="ruang_guru_ada_tidak" 
                                value="ada" 
                                label="Ada" 
                                :checked="old('ruang_guru_ada_tidak', $profileSekolah->ruangGuru?->{'ada/tidak_ada'}) == 'ada'"
                            />
                            <x-form.radio 
                                name="ruang_guru_ada_tidak" 
                                value="tidak_ada" 
                                label="Tidak Ada" 
                                :checked="old('ruang_guru_ada_tidak', $profileSekolah->ruangGuru?->{'ada/tidak_ada'}) == 'tidak_ada'"
                            />
                        </div>
                        @error('ruang_guru_ada_tidak')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <x-form.select 
                        name="ruang_guru_kondisi" 
                        label="Kondisi" 
                        :options="['' => '-- Pilih --', 'bagus' => 'Bagus', 'rusak' => 'Rusak', 'nihil' => 'Nihil']" 
                        value="{{ old('ruang_guru_kondisi', $profileSekolah->ruangGuru?->kodisi) }}"
                    />
                </div>
            </x-card>

            <!-- L. Ruang Kantor/Tata Usaha -->
            <x-card>
                <x-slot:header>
                    <div class="flex items-center gap-2 text-amber-700 dark:text-amber-400 font-semibold text-xs sm:text-sm">
                        <i class="bi bi-briefcase"></i>
                        <span>L. Ruang Kantor/Tata Usaha</span>
                    </div>
                </x-slot:header>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 sm:gap-4">
                    <div>
                        <label class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Keberadaan <span class="text-red-600">*</span>
                        </label>
                        <div class="flex flex-wrap gap-3 sm:gap-4 mt-1">
                            <x-form.radio 
                                name="kantor_tu_ada_tidak" 
                                value="ada" 
                                label="Ada" 
                                :checked="old('kantor_tu_ada_tidak', $profileSekolah->ruangKantorTu?->{'ada/tidak_ada'}) == 'ada'"
                            />
                            <x-form.radio 
                                name="kantor_tu_ada_tidak" 
                                value="tidak_ada" 
                                label="Tidak Ada" 
                                :checked="old('kantor_tu_ada_tidak', $profileSekolah->ruangKantorTu?->{'ada/tidak_ada'}) == 'tidak_ada'"
                            />
                        </div>
                        @error('kantor_tu_ada_tidak')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <x-form.select 
                        name="kantor_tu_kondisi" 
                        label="Kondisi" 
                        :options="['' => '-- Pilih --', 'bagus' => 'Bagus', 'rusak' => 'Rusak', 'nihil' => 'Nihil']" 
                        value="{{ old('kantor_tu_kondisi', $profileSekolah->ruangKantorTu?->kodisi) }}"
                    />
                </div>
            </x-card>

            <!-- M. Lab IPA & N. Lab Komputer -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
                <x-card>
                    <x-slot:header>
                        <div class="flex items-center gap-2 text-emerald-700 dark:text-emerald-400 font-semibold text-xs sm:text-sm">
                            <i class="bi bi-flask"></i>
                            <span class="inline">M. Lab IPA</span>
                        </div>
                    </x-slot:header>

                    <div class="grid grid-cols-1 gap-2">
                        <div>
                            <label class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Keberadaan <span class="text-red-600">*</span>
                            </label>
                            <div class="flex flex-wrap gap-3 sm:gap-4 mt-1">
                                <x-form.radio 
                                    name="lab_ipa_ada_tidak" 
                                    value="ada" 
                                    label="Ada" 
                                    :checked="old('lab_ipa_ada_tidak', $profileSekolah->labIpa?->{'ada/tidak_ada'}) == 'ada'"
                                />
                                <x-form.radio 
                                    name="lab_ipa_ada_tidak" 
                                    value="tidak_ada" 
                                    label="Tidak Ada" 
                                    :checked="old('lab_ipa_ada_tidak', $profileSekolah->labIpa?->{'ada/tidak_ada'}) == 'tidak_ada'"
                                />
                            </div>
                            @error('lab_ipa_ada_tidak')
                                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <x-form.select 
                            name="lab_ipa_kondisi" 
                            label="Kondisi" 
                            :options="['' => '-- Pilih --', 'bagus' => 'Bagus', 'rusak' => 'Rusak', 'nihil' => 'Nihil']" 
                            value="{{ old('lab_ipa_kondisi', $profileSekolah->labIpa?->kodisi) }}"
                        />
                    </div>
                </x-card>

                <x-card>
                    <x-slot:header>
                        <div class="flex items-center gap-2 text-cyan-700 dark:text-cyan-400 font-semibold text-xs sm:text-sm">
                            <i class="bi bi-pc-display-horizontal"></i>
                            <span class="inline">N. Lab Komputer</span>
                        </div>
                    </x-slot:header>

                    <div class="grid grid-cols-1 gap-2">
                        <div>
                            <label class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Keberadaan <span class="text-red-600">*</span>
                            </label>
                            <div class="flex flex-wrap gap-3 sm:gap-4 mt-1">
                                <x-form.radio 
                                    name="lab_komputer_ada_tidak" 
                                    value="ada" 
                                    label="Ada" 
                                    :checked="old('lab_komputer_ada_tidak', $profileSekolah->labKomputer?->{'ada/tidak_ada'}) == 'ada'"
                                />
                                <x-form.radio 
                                    name="lab_komputer_ada_tidak" 
                                    value="tidak_ada" 
                                    label="Tidak Ada" 
                                    :checked="old('lab_komputer_ada_tidak', $profileSekolah->labKomputer?->{'ada/tidak_ada'}) == 'tidak_ada'"
                                />
                            </div>
                            @error('lab_komputer_ada_tidak')
                                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <x-form.select 
                            name="lab_komputer_kondisi" 
                            label="Kondisi" 
                            :options="['' => '-- Pilih --', 'bagus' => 'Bagus', 'rusak' => 'Rusak', 'nihil' => 'Nihil']" 
                            value="{{ old('lab_komputer_kondisi', $profileSekolah->labKomputer?->kodisi) }}"
                        />
                    </div>
                </x-card>
            </div>

            <!-- O. UKS -->
            <x-card>
                <x-slot:header>
                    <div class="flex items-center gap-2 text-rose-700 dark:text-rose-400 font-semibold text-xs sm:text-sm">
                        <i class="bi bi-heart-pulse"></i>
                        <span>O. UKS</span>
                    </div>
                </x-slot:header>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 sm:gap-4">
                    <div>
                        <label class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Keberadaan <span class="text-red-600">*</span>
                        </label>
                        <div class="flex flex-wrap gap-3 sm:gap-4 mt-1">
                            <x-form.radio 
                                name="uks_ada_tidak" 
                                value="ada" 
                                label="Ada" 
                                :checked="old('uks_ada_tidak', $profileSekolah->unitKesehatanSekolah?->{'ada/tidak_ada'}) == 'ada'"
                            />
                            <x-form.radio 
                                name="uks_ada_tidak" 
                                value="tidak_ada" 
                                label="Tidak Ada" 
                                :checked="old('uks_ada_tidak', $profileSekolah->unitKesehatanSekolah?->{'ada/tidak_ada'}) == 'tidak_ada'"
                            />
                        </div>
                        @error('uks_ada_tidak')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <x-form.select 
                        name="uks_kondisi" 
                        label="Kondisi" 
                        :options="['' => '-- Pilih --', 'bagus' => 'Bagus', 'rusak' => 'Rusak', 'nihil' => 'Nihil']" 
                        value="{{ old('uks_kondisi', $profileSekolah->unitKesehatanSekolah?->kodisi) }}"
                    />
                </div>
            </x-card>

            <!-- P. Rumah Dinas & Q. Rumah Ibadah & R. Lapangan Sekolah -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-4">
                <x-card>
                    <x-slot:header>
                        <div class="flex items-center gap-2 text-teal-700 dark:text-teal-400 font-semibold text-xs sm:text-sm">
                            <i class="bi bi-house-door"></i>
                            <span class="inline">P. Rumah Dinas</span>
                        </div>
                    </x-slot:header>

                    <div class="grid grid-cols-1 gap-2">
                        <div>
                            <label class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Keberadaan <span class="text-red-600">*</span>
                            </label>
                            <div class="flex flex-wrap gap-3 sm:gap-4 mt-1">
                                <x-form.radio 
                                    name="rumah_dinas_ada_tidak" 
                                    value="ada" 
                                    label="Ada" 
                                    :checked="old('rumah_dinas_ada_tidak', $profileSekolah->rumahDinas?->{'ada/tidak_ada'}) == 'ada'"
                                />
                                <x-form.radio 
                                    name="rumah_dinas_ada_tidak" 
                                    value="tidak_ada" 
                                    label="Tidak Ada" 
                                    :checked="old('rumah_dinas_ada_tidak', $profileSekolah->rumahDinas?->{'ada/tidak_ada'}) == 'tidak_ada'"
                                />
                            </div>
                            @error('rumah_dinas_ada_tidak')
                                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <x-form.select 
                            name="rumah_dinas_kondisi" 
                            label="Kondisi" 
                            :options="['' => '-- Pilih --', 'bagus' => 'Bagus', 'rusak' => 'Rusak', 'nihil' => 'Nihil']" 
                            value="{{ old('rumah_dinas_kondisi', $profileSekolah->rumahDinas?->kodisi) }}"
                        />
                    </div>
                </x-card>

                <x-card>
                    <x-slot:header>
                        <div class="flex items-center gap-2 text-violet-700 dark:text-violet-400 font-semibold text-xs sm:text-sm">
                            <i class="bi bi-building"></i>
                            <span class="inline">Q. Rumah Ibadah</span>
                        </div>
                    </x-slot:header>

                    <div class="grid grid-cols-1 gap-2">
                        <div>
                            <label class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Keberadaan <span class="text-red-600">*</span>
                            </label>
                            <div class="flex flex-wrap gap-3 sm:gap-4 mt-1">
                                <x-form.radio 
                                    name="rumah_ibadah_ada_tidak" 
                                    value="ada" 
                                    label="Ada" 
                                    :checked="old('rumah_ibadah_ada_tidak', $profileSekolah->rumahIbadah?->{'ada/tidak_ada'}) == 'ada'"
                                />
                                <x-form.radio 
                                    name="rumah_ibadah_ada_tidak" 
                                    value="tidak_ada" 
                                    label="Tidak Ada" 
                                    :checked="old('rumah_ibadah_ada_tidak', $profileSekolah->rumahIbadah?->{'ada/tidak_ada'}) == 'tidak_ada'"
                                />
                            </div>
                            @error('rumah_ibadah_ada_tidak')
                                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <x-form.select 
                            name="rumah_ibadah_kondisi" 
                            label="Kondisi" 
                            :options="['' => '-- Pilih --', 'bagus' => 'Bagus', 'rusak' => 'Rusak', 'nihil' => 'Nihil']" 
                            value="{{ old('rumah_ibadah_kondisi', $profileSekolah->rumahIbadah?->kodisi) }}"
                        />
                    </div>
                </x-card>

                <x-card>
                    <x-slot:header>
                        <div class="flex items-center gap-2 text-lime-700 dark:text-lime-400 font-semibold text-xs sm:text-sm">
                            <i class="bi bi-flag"></i>
                            <span class="inline">R. Lapangan Sekolah</span>
                        </div>
                    </x-slot:header>

                    <div class="grid grid-cols-1 gap-2">
                        <div>
                            <label class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Keberadaan <span class="text-red-600">*</span>
                            </label>
                            <div class="flex flex-wrap gap-3 sm:gap-4 mt-1">
                                <x-form.radio 
                                    name="lapangan_sekolah_ada_tidak" 
                                    value="ada" 
                                    label="Ada" 
                                    :checked="old('lapangan_sekolah_ada_tidak', $profileSekolah->lapanganSekolah?->{'ada/tidak_ada'}) == 'ada'"
                                />
                                <x-form.radio 
                                    name="lapangan_sekolah_ada_tidak" 
                                    value="tidak_ada" 
                                    label="Tidak Ada" 
                                    :checked="old('lapangan_sekolah_ada_tidak', $profileSekolah->lapanganSekolah?->{'ada/tidak_ada'}) == 'tidak_ada'"
                                />
                            </div>
                            @error('lapangan_sekolah_ada_tidak')
                                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <x-form.select 
                            name="lapangan_sekolah_kondisi" 
                            label="Kondisi" 
                            :options="['' => '-- Pilih --', 'bagus' => 'Bagus', 'rusak' => 'Rusak', 'nihil' => 'Nihil']" 
                            value="{{ old('lapangan_sekolah_kondisi', $profileSekolah->lapanganSekolah?->kodisi) }}"
                        />
                    </div>
                </x-card>
            </div>

            <!-- S. Pagar & T. Air -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
                <x-card>
                    <x-slot:header>
                        <div class="flex items-center gap-2 text-gray-700 dark:text-gray-300 font-semibold text-xs sm:text-sm">
                            <i class="bi bi-border-all"></i>
                            <span>S. Pagar Sekola</span>
                        </div>
                    </x-slot:header>

                    <div class="grid grid-cols-1 gap-2">
                        <div>
                            <label class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Keberadaan <span class="text-red-600">*</span>
                            </label>
                            <div class="flex flex-wrap gap-3 sm:gap-4 mt-1">
                                <x-form.radio 
                                    name="pagar_ada_tidak" 
                                    value="ada" 
                                    label="Ada" 
                                    :checked="old('pagar_ada_tidak', $profileSekolah->pagarSekolah?->{'ada/tidak_ada'}) == 'ada'"
                                />
                                <x-form.radio 
                                    name="pagar_ada_tidak" 
                                    value="tidak_ada" 
                                    label="Tidak Ada" 
                                    :checked="old('pagar_ada_tidak', $profileSekolah->pagarSekolah?->{'ada/tidak_ada'}) == 'tidak_ada'"
                                />
                            </div>
                            @error('pagar_ada_tidak')
                                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <x-form.select 
                            name="pagar_kondisi" 
                            label="Kondisi" 
                            :options="['' => '-- Pilih --', 'bagus' => 'Bagus', 'rusak' => 'Rusak', 'nihil' => 'Nihil']" 
                            value="{{ old('pagar_kondisi', $profileSekolah->pagarSekolah?->kodisi) }}"
                        />
                    </div>
                </x-card>

                <x-card>
                    <x-slot:header>
                        <div class="flex items-center gap-2 text-blue-700 dark:text-blue-400 font-semibold text-xs sm:text-sm">
                            <i class="bi bi-droplet"></i>
                            <span>T. Air Bersih</span>
                        </div>
                    </x-slot:header>

                    <div class="grid grid-cols-1 gap-2">
                        <div>
                            <label class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Keberadaan <span class="text-red-600">*</span>
                            </label>
                            <div class="flex flex-wrap gap-3 sm:gap-4 mt-1">
                                <x-form.radio 
                                    name="air_ada_tidak" 
                                    value="ada" 
                                    label="Ada" 
                                    :checked="old('air_ada_tidak', $profileSekolah->airBersih?->{'ada/tidak_ada'}) == 'ada'"
                                />
                                <x-form.radio 
                                    name="air_ada_tidak" 
                                    value="tidak_ada" 
                                    label="Tidak Ada" 
                                    :checked="old('air_ada_tidak', $profileSekolah->airBersih?->{'ada/tidak_ada'}) == 'tidak_ada'"
                                />
                            </div>
                            @error('air_ada_tidak')
                                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <x-form.select 
                            name="air_kondisi" 
                            label="Kondisi" 
                            :options="['' => '-- Pilih --', 'bagus' => 'Bagus', 'rusak' => 'Rusak', 'nihil' => 'Nihil']" 
                            value="{{ old('air_kondisi', $profileSekolah->airBersih?->kodisi) }}"
                        />
                    </div>
                </x-card>
            </div>

            <!-- U-Z: Furniture & Elektronik -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
                <!-- Furniture -->
                <x-card>
                    <x-slot:header>
                        <div class="flex items-center gap-2 text-yellow-700 dark:text-yellow-400 font-semibold text-xs sm:text-sm">
                            <i class="bi bi-table"></i>
                            <span>Furniture</span>
                        </div>
                    </x-slot:header>

                    <div class="grid grid-cols-2 gap-2 sm:gap-3">
                        <x-form.input 
                            name="kursi_siswa_bagus" 
                            label="Kursi Siswa Bagus" 
                            type="number" 
                            required 
                            value="{{ old('kursi_siswa_bagus', $profileSekolah->kursiSiswa?->bagus ?? 0) }}" 
                            min="0"
                        />
                        <x-form.input 
                            name="kursi_siswa_rusak" 
                            label="Kursi Siswa Rusak" 
                            type="number" 
                            required 
                            value="{{ old('kursi_siswa_rusak', $profileSekolah->kursiSiswa?->rusak ?? 0) }}" 
                            min="0"
                        />
                        <x-form.input 
                            name="meja_siswa_bagus" 
                            label="Meja Siswa Bagus" 
                            type="number" 
                            required 
                            value="{{ old('meja_siswa_bagus', $profileSekolah->mejaSiswa?->bagus ?? 0) }}" 
                            min="0"
                        />
                        <x-form.input 
                            name="meja_siswa_rusak" 
                            label="Meja Siswa Rusak" 
                            type="number" 
                            required 
                            value="{{ old('meja_siswa_rusak', $profileSekolah->mejaSiswa?->rusak ?? 0) }}" 
                            min="0"
                        />
                        <x-form.input 
                            name="kursi_guru_bagus" 
                            label="Kursi Guru Bagus" 
                            type="number" 
                            required 
                            value="{{ old('kursi_guru_bagus', $profileSekolah->kursiGuru?->bagus ?? 0) }}" 
                            min="0"
                        />
                        <x-form.input 
                            name="kursi_guru_rusak" 
                            label="Kursi Guru Rusak" 
                            type="number" 
                            required 
                            value="{{ old('kursi_guru_rusak', $profileSekolah->kursiGuru?->rusak ?? 0) }}" 
                            min="0"
                        />
                        <x-form.input 
                            name="meja_guru_bagus" 
                            label="Meja Guru Bagus" 
                            type="number" 
                            required 
                            value="{{ old('meja_guru_bagus', $profileSekolah->mejaGuru?->bagus ?? 0) }}" 
                            min="0"
                        />
                        <x-form.input 
                            name="meja_guru_rusak" 
                            label="Meja Guru Rusak" 
                            type="number" 
                            required 
                            value="{{ old('meja_guru_rusak', $profileSekolah->mejaGuru?->rusak ?? 0) }}" 
                            min="0"
                        />
                    </div>
                </x-card>

                <!-- Elektronik -->
                <x-card>
                    <x-slot:header>
                        <div class="flex items-center gap-2 text-purple-700 dark:text-purple-400 font-semibold text-xs sm:text-sm">
                            <i class="bi bi-laptop"></i>
                            <span>Elektronik</span>
                        </div>
                    </x-slot:header>

                    <div class="grid grid-cols-2 gap-2 sm:gap-3">
                        <x-form.input 
                            name="laptop_bagus" 
                            label="Laptop Bagus" 
                            type="number" 
                            required 
                            value="{{ old('laptop_bagus', $profileSekolah->laptop?->bagus ?? 0) }}" 
                            min="0"
                        />
                        <x-form.input 
                            name="laptop_rusak" 
                            label="Laptop Rusak" 
                            type="number" 
                            required 
                            value="{{ old('laptop_rusak', $profileSekolah->laptop?->rusak ?? 0) }}" 
                            min="0"
                        />
                        <x-form.input 
                            name="komputer_bagus" 
                            label="Komputer Bagus" 
                            type="number" 
                            required 
                            value="{{ old('komputer_bagus', $profileSekolah->komputer?->bagus ?? 0) }}" 
                            min="0"
                        />
                        <x-form.input 
                            name="komputer_rusak" 
                            label="Komputer Rusak" 
                            type="number" 
                            required 
                            value="{{ old('komputer_rusak', $profileSekolah->komputer?->rusak ?? 0) }}" 
                            min="0"
                        />

                        <x-form.input 
                            name="chromebook_bagus" 
                            label="Chromebook Bagus" 
                            type="number" 
                            required 
                            value="{{ old('chromebook_bagus', $profileSekolah->chromebook?->bagus ?? 0) }}" 
                            min="0"
                        />
                        <x-form.input 
                            name="chromebook_rusak" 
                            label="Chromebook Rusak" 
                            type="number" 
                            required 
                            value="{{ old('chromebook_rusak', $profileSekolah->chromebook?->rusak ?? 0) }}" 
                            min="0"
                        />
                    </div>
                </x-card>
            </div>

            <!-- Tombol Aksi -->
            <x-card>
                <x-slot:footer>
                    <div class="flex flex-wrap gap-2">
                        <x-button type="submit" variant="warning" size="md">
                            <i class="bi bi-save me-1"></i>
                            <span class="hidden sm:inline">Update Data</span>
                            <span class="sm:hidden">Update</span>
                        </x-button>
                        <x-button type="reset" variant="secondary" size="md">
                            <i class="bi bi-arrow-counterclockwise me-1"></i>
                            <span class="hidden sm:inline">Reset</span>
                            <span class="sm:hidden">Reset</span>
                        </x-button>
                        <a href="{{ route('sarana.show', $profileSekolah->id) }}" class="inline-flex">
                            <x-button variant="primary" size="md">
                                <i class="bi bi-eye me-1"></i>
                                <span class="hidden sm:inline">Lihat Detail</span>
                                <span class="sm:hidden">Detail</span>
                            </x-button>
                        </a>
                        <a href="{{ route('sarana.index') }}" class="inline-flex">
                            <x-button variant="secondary" size="md">
                                <i class="bi bi-x-circle me-1"></i>
                                <span class="hidden sm:inline">Batal</span>
                                <span class="sm:hidden">Batal</span>
                            </x-button>
                        </a>
                    </div>
                </x-slot:footer>
            </x-card>
        </form>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        function setupConditionAuto(radioName, selectId) {
            const radios = document.querySelectorAll(`input[name="${radioName}"]`);
            const select = document.querySelector(`select[name="${selectId}"]`);
            
            if (!radios.length || !select) return;

            radios.forEach(radio => {
                radio.addEventListener('change', function() {
                    if (this.value === 'tidak_ada') {
                        select.value = 'nihil';
                        select.disabled = true;
                    } else {
                        select.disabled = false;
                        if (select.value === 'nihil') {
                            select.value = '';
                        }
                    }
                });
            });

            const checked = document.querySelector(`input[name="${radioName}"]:checked`);
            if (checked && checked.value === 'tidak_ada') {
                select.value = 'nihil';
                select.disabled = true;
            }
        }

        const facilities = [
            'perpustakaan', 'kepala_sekolah', 'ruang_guru', 'kantor_tu',
            'lab_ipa', 'lab_komputer', 'uks', 'rumah_dinas',
            'rumah_ibadah', 'lapangan_sekolah', 'pagar', 'air'
        ];

        facilities.forEach(facility => {
            setupConditionAuto(
                `${facility}_ada_tidak`,
                `${facility}_kondisi`
            );
        });
    });
</script>
@endpush
@endsection