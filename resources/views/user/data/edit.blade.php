@extends('layouts.app')

@section('title')
    Edit Data Sarana & Prasarana
@endsection

@section('content')
    <div class="container mx-auto px-3 sm:px-4 py-3 sm:py-4">
        <div class="flex flex-col gap-3 sm:gap-4">
            <!-- Header -->
            <div class="flex flex-wrap items-center justify-between gap-2">
                <h1 class="text-base sm:text-xl font-semibold text-gray-800 dark:text-gray-100 flex items-center gap-2">
                    <i class="bi bi-pencil-square text-yellow-600 dark:text-yellow-400"></i>
                    <span class="hidden sm:inline">Form Edit Data Sarana & Prasarana Sekolah</span>
                    <span class="sm:hidden">Edit Data</span>
                </h1>
                <a href="{{ route('user.data.index') }}" class="inline-flex">
                    <x-button variant="secondary" size="sm">
                        <i class="bi bi-arrow-left me-1"></i>
                        <span class="hidden sm:inline">Kembali</span>
                        <span class="sm:hidden">Back</span>
                    </x-button>
                </a>
            </div>

            <!-- Alert Error -->
            @if ($errors->any())
                <x-alert type="danger" dismissible icon>
                    <div class="flex flex-col gap-1">
                        <strong class="text-sm"><i class="bi bi-exclamation-triangle-fill"></i> Terjadi Kesalahan!</strong>
                        <ul class="list-disc list-inside text-xs sm:text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </x-alert>
            @endif

            <!-- Alert Success -->
            @if (session('success'))
                <x-alert type="success" dismissible icon>
                    <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                </x-alert>
            @endif

            <!-- Alert Error dari Controller -->
            @if (session('error'))
                <x-alert type="danger" dismissible icon>
                    <i class="bi bi-x-octagon-fill me-2"></i> {{ session('error') }}
                </x-alert>
            @endif

            <!-- Form -->
            <form action="{{ route('user.data.update', $sarana->id) }}" method="POST" id="saranaForm" class="flex flex-col gap-3 sm:gap-4">
                @csrf
                @method('PUT')

                <!-- A. Data Sekolah -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="p-2.5 sm:p-4 border-b border-gray-200 dark:border-gray-700 bg-linear-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20">
                        <div class="flex items-center gap-2 text-blue-600 dark:text-blue-400 font-semibold text-xs sm:text-sm">
                            <i class="bi bi-building"></i>
                            <span>A. Data Sekolah</span>
                        </div>
                    </div>
                    <div class="p-3 sm:p-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5 sm:gap-4">
                            <div class="sm:col-span-2">
                                <x-form.input name="nama_sekolah" label="Nama Sekolah" placeholder="Masukkan nama sekolah"
                                    required :value="old('nama_sekolah', $sarana->nama_sekolah)" />
                            </div>

                            <x-form.input name="NPSN" label="NPSN" placeholder="Masukkan NPSN" required
                                :value="old('NPSN', $sarana->NPSN)" />

                            <x-form.input name="nomor_hp" label="Nomor HP" placeholder="Masukkan nomor HP" required
                                :value="old('nomor_hp', $sarana->nomor_hp)" />

                            <div class="sm:col-span-2">
                                <x-form.textarea name="alamat_sekolah" label="Alamat Sekolah" rows="2"
                                    placeholder="Masukkan alamat lengkap sekolah" required :value="old('alamat_sekolah', $sarana->alamat_sekolah)" />
                            </div>

                            <x-form.input name="nama_kepala_sekolah" label="Nama Kepala Sekolah"
                                placeholder="Masukkan nama kepala sekolah" required :value="old('nama_kepala_sekolah', $sarana->nama_kepala_sekolah)" />

                            <x-form.input name="NIP" label="NIP" placeholder="Masukkan NIP" required
                                :value="old('NIP', $sarana->NIP)" />
                        </div>
                    </div>
                </div>

                <!-- B. Jumlah Siswa -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="p-2.5 sm:p-4 border-b border-gray-200 dark:border-gray-700 bg-linear-to-r from-green-50 to-emerald-50 dark:from-green-900/20 dark:to-emerald-900/20">
                        <div class="flex items-center gap-2 text-green-700 dark:text-green-400 font-semibold text-xs sm:text-sm">
                            <i class="bi bi-mortarboard"></i>
                            <span>B. Jumlah Siswa</span>
                        </div>
                    </div>
                    <div class="p-3 sm:p-4">
                        <div class="grid grid-cols-3 gap-2 sm:gap-4">
                            <x-form.input name="jumlah_siswa_vii" label="VII" type="number" min="0" required
                                :value="old('jumlah_siswa_vii', $sarana->jumlahSiswa?->vii ?? 0)" />
                            <x-form.input name="jumlah_siswa_viii" label="VIII" type="number" min="0" required
                                :value="old('jumlah_siswa_viii', $sarana->jumlahSiswa?->viii ?? 0)" />
                            <x-form.input name="jumlah_siswa_ix" label="IX" type="number" min="0" required
                                :value="old('jumlah_siswa_ix', $sarana->jumlahSiswa?->ix ?? 0)" />
                        </div>
                    </div>
                </div>

                <!-- C. Jumlah Rombongan Belajar -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="p-2.5 sm:p-4 border-b border-gray-200 dark:border-gray-700 bg-linear-to-r from-purple-50 to-violet-50 dark:from-purple-900/20 dark:to-violet-900/20">
                        <div class="flex items-center gap-2 text-purple-700 dark:text-purple-400 font-semibold text-xs sm:text-sm">
                            <i class="bi bi-diagram-3"></i>
                            <span>C. Jumlah Rombongan Belajar</span>
                        </div>
                    </div>
                    <div class="p-3 sm:p-4">
                        <div class="grid grid-cols-3 gap-2 sm:gap-4">
                            <x-form.input name="jumlah_rombel_vii" label="VII" type="number" min="0" required
                                :value="old('jumlah_rombel_vii', $sarana->jumlahRombel?->vii ?? 0)" />
                            <x-form.input name="jumlah_rombel_viii" label="VIII" type="number" min="0" required
                                :value="old('jumlah_rombel_viii', $sarana->jumlahRombel?->viii ?? 0)" />
                            <x-form.input name="jumlah_rombel_ix" label="IX" type="number" min="0" required
                                :value="old('jumlah_rombel_ix', $sarana->jumlahRombel?->ix ?? 0)" />
                        </div>
                    </div>
                </div>

                <!-- D. RKB (Ruang Kelas Baru) -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="p-2.5 sm:p-4 border-b border-gray-200 dark:border-gray-700 bg-linear-to-r from-blue-50 to-cyan-50 dark:from-blue-900/20 dark:to-cyan-900/20">
                        <div class="flex items-center gap-2 text-blue-700 dark:text-blue-400 font-semibold text-xs sm:text-sm">
                            <i class="bi bi-building-add"></i>
                            <span class="hidden sm:inline">D. RKB</span>
                            <span class="sm:hidden">RKB</span>
                        </div>
                    </div>
                    <div class="p-3 sm:p-4">
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-2 sm:gap-4 items-end">
                            <x-form.input name="rkb_jumlah" label="Jumlah" type="number" min="0" required
                                :value="old('rkb_jumlah', $sarana->ruangKelasBaru?->jumlah ?? 0)" />
                            <div class="sm:col-span-2 flex flex-wrap items-center gap-2 text-xs sm:text-sm text-gray-500 dark:text-gray-400 pb-1.5">
                                <i class="bi bi-calendar-range"></i>
                                Periode pelaporan:
                                <x-badge variant="secondary">{{ $rkbPeriode->label() }}</x-badge>
                                <span class="text-[10px] text-gray-400">(diatur admin, berlaku untuk semua sekolah)</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- E. Rehabilitasi Ruang Kelas -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="p-2.5 sm:p-4 border-b border-gray-200 dark:border-gray-700 bg-linear-to-r from-orange-50 to-amber-50 dark:from-orange-900/20 dark:to-amber-900/20">
                        <div class="flex items-center gap-2 text-orange-700 dark:text-orange-400 font-semibold text-xs sm:text-sm">
                            <i class="bi bi-tools"></i>
                            <span class="hidden sm:inline">E. Rehabilitasi</span>
                            <span class="sm:hidden">Rehab</span>
                        </div>
                    </div>
                    <div class="p-3 sm:p-4">
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-2 sm:gap-4 items-end">
                            <x-form.input name="rehabilitasi_jumlah" label="Jumlah" type="number" min="0"
                                required :value="old('rehabilitasi_jumlah', $sarana->rehabilitasiRuangKelas?->jumlah ?? 0)" />
                            <div class="sm:col-span-2 flex flex-wrap items-center gap-2 text-xs sm:text-sm text-gray-500 dark:text-gray-400 pb-1.5">
                                <i class="bi bi-calendar-range"></i>
                                Periode pelaporan:
                                <x-badge variant="secondary">{{ $rehabilitasiPeriode->label() }}</x-badge>
                                <span class="text-[10px] text-gray-400">(diatur admin, berlaku untuk semua sekolah)</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- F. Ruang Kelas -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="p-2.5 sm:p-4 border-b border-gray-200 dark:border-gray-700 bg-linear-to-r from-blue-50 to-sky-50 dark:from-blue-900/20 dark:to-sky-900/20">
                        <div class="flex items-center gap-2 text-blue-700 dark:text-blue-400 font-semibold text-xs sm:text-sm">
                            <i class="bi bi-door-closed"></i>
                            <span>F. Ruang Kelas</span>
                        </div>
                    </div>
                    <div class="p-3 sm:p-4">
                        <div class="grid grid-cols-2 gap-2 sm:gap-4">
                            <x-form.input name="ruang_kelas_baik" label="Baik" type="number" min="0" required
                                :value="old('ruang_kelas_baik', $sarana->ruangKelas?->baik ?? 0)" />
                            <x-form.input name="ruang_kelas_rusak" label="Rusak" type="number" min="0" required
                                :value="old('ruang_kelas_rusak', $sarana->ruangKelas?->rusak ?? 0)" />
                        </div>
                    </div>
                </div>

                <!-- G. Toilet Siswa & H. Toilet Guru -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                        <div class="p-2.5 sm:p-4 border-b border-gray-200 dark:border-gray-700 bg-linear-to-r from-cyan-50 to-teal-50 dark:from-cyan-900/20 dark:to-teal-900/20">
                            <div class="flex items-center gap-2 text-cyan-700 dark:text-cyan-400 font-semibold text-xs sm:text-sm">
                                <i class="bi bi-droplet-half"></i>
                                <span class="hidden sm:inline">G. Toilet Siswa</span>
                                <span class="sm:hidden">T. Siswa</span>
                            </div>
                        </div>
                        <div class="p-3 sm:p-4">
                            <div class="grid grid-cols-2 gap-2">
                                <x-form.input name="toilet_siswa_baik" label="Baik" type="number" min="0"
                                    required :value="old('toilet_siswa_baik', $sarana->toiletSiswa?->baik ?? 0)" />
                                <x-form.input name="toilet_siswa_rusak" label="Rusak" type="number" min="0"
                                    required :value="old('toilet_siswa_rusak', $sarana->toiletSiswa?->rusak ?? 0)" />
                            </div>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                        <div class="p-2.5 sm:p-4 border-b border-gray-200 dark:border-gray-700 bg-linear-to-r from-cyan-50 to-blue-50 dark:from-cyan-900/20 dark:to-blue-900/20">
                            <div class="flex items-center gap-2 text-cyan-700 dark:text-cyan-400 font-semibold text-xs sm:text-sm">
                                <i class="bi bi-droplet"></i>
                                <span class="hidden sm:inline">H. Toilet Guru</span>
                                <span class="sm:hidden">T. Guru</span>
                            </div>
                        </div>
                        <div class="p-3 sm:p-4">
                            <div class="grid grid-cols-2 gap-2">
                                <x-form.input name="toilet_guru_baik" label="Baik" type="number" min="0"
                                    required :value="old('toilet_guru_baik', $sarana->toiletGuru?->baik ?? 0)" />
                                <x-form.input name="toilet_guru_rusak" label="Rusak" type="number" min="0"
                                    required :value="old('toilet_guru_rusak', $sarana->toiletGuru?->rusak ?? 0)" />
                            </div>
                        </div>
                    </div>
                </div>

                <!-- I. R. Perpustakaan -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="p-2.5 sm:p-4 border-b border-gray-200 dark:border-gray-700 bg-linear-to-r from-yellow-50 to-amber-50 dark:from-yellow-900/20 dark:to-amber-900/20">
                        <div class="flex items-center gap-2 text-yellow-700 dark:text-yellow-400 font-semibold text-xs sm:text-sm">
                            <i class="bi bi-book"></i>
                            <span>I. R. Perpustakaan</span>
                        </div>
                    </div>
                    <div class="p-3 sm:p-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 sm:gap-4">
                            <div>
                                <label class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Keberadaan <span class="text-red-600">*</span>
                                </label>
                                <div class="flex flex-wrap gap-3 sm:gap-4 mt-1">
                                    <x-form.radio name="perpustakaan_ada_tidak" value="ada" label="Ada"
                                        :checked="old('perpustakaan_ada_tidak', $sarana->ruangPerpustakaan?->{'ada/tidak_ada'}) == 'ada'" />
                                    <x-form.radio name="perpustakaan_ada_tidak" value="tidak_ada" label="Tidak Ada"
                                        :checked="old('perpustakaan_ada_tidak', $sarana->ruangPerpustakaan?->{'ada/tidak_ada'}) == 'tidak_ada'" />
                                </div>
                                @error('perpustakaan_ada_tidak')
                                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <x-form.select name="perpustakaan_kondisi" label="Kondisi" :options="['' => '-- Pilih --', 'baik' => 'Baik', 'rusak' => 'Rusak', 'nihil' => 'Nihil']"
                                :value="old('perpustakaan_kondisi', $sarana->ruangPerpustakaan?->kodisi)" />
                        </div>
                    </div>
                </div>

                <!-- J. R. Kepala Sekolah -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="p-2.5 sm:p-4 border-b border-gray-200 dark:border-gray-700 bg-linear-to-r from-pink-50 to-rose-50 dark:from-pink-900/20 dark:to-rose-900/20">
                        <div class="flex items-center gap-2 text-pink-700 dark:text-pink-400 font-semibold text-xs sm:text-sm">
                            <i class="bi bi-person-workspace"></i>
                            <span>J. R. Kepala Sekolah</span>
                        </div>
                    </div>
                    <div class="p-3 sm:p-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 sm:gap-4">
                            <div>
                                <label class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Keberadaan <span class="text-red-600">*</span>
                                </label>
                                <div class="flex flex-wrap gap-3 sm:gap-4 mt-1">
                                    <x-form.radio name="kepala_sekolah_ada_tidak" value="ada" label="Ada"
                                        :checked="old('kepala_sekolah_ada_tidak', $sarana->ruangKepalaSekolah?->{'ada/tidak_ada'}) == 'ada'" />
                                    <x-form.radio name="kepala_sekolah_ada_tidak" value="tidak_ada" label="Tidak Ada"
                                        :checked="old('kepala_sekolah_ada_tidak', $sarana->ruangKepalaSekolah?->{'ada/tidak_ada'}) == 'tidak_ada'" />
                                </div>
                                @error('kepala_sekolah_ada_tidak')
                                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <x-form.select name="kepala_sekolah_kondisi" label="Kondisi" :options="['' => '-- Pilih --', 'baik' => 'Baik', 'rusak' => 'Rusak', 'nihil' => 'Nihil']"
                                :value="old('kepala_sekolah_kondisi', $sarana->ruangKepalaSekolah?->kodisi)" />
                        </div>
                    </div>
                </div>

                <!-- K. R. Guru -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="p-2.5 sm:p-4 border-b border-gray-200 dark:border-gray-700 bg-linear-to-r from-indigo-50 to-blue-50 dark:from-indigo-900/20 dark:to-blue-900/20">
                        <div class="flex items-center gap-2 text-indigo-700 dark:text-indigo-400 font-semibold text-xs sm:text-sm">
                            <i class="bi bi-easel2"></i>
                            <span>K. R. Guru</span>
                        </div>
                    </div>
                    <div class="p-3 sm:p-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 sm:gap-4">
                            <div>
                                <label class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Keberadaan <span class="text-red-600">*</span>
                                </label>
                                <div class="flex flex-wrap gap-3 sm:gap-4 mt-1">
                                    <x-form.radio name="ruang_guru_ada_tidak" value="ada" label="Ada"
                                        :checked="old('ruang_guru_ada_tidak', $sarana->ruangGuru?->{'ada/tidak_ada'}) == 'ada'" />
                                    <x-form.radio name="ruang_guru_ada_tidak" value="tidak_ada" label="Tidak Ada"
                                        :checked="old('ruang_guru_ada_tidak', $sarana->ruangGuru?->{'ada/tidak_ada'}) == 'tidak_ada'" />
                                </div>
                                @error('ruang_guru_ada_tidak')
                                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <x-form.select name="ruang_guru_kondisi" label="Kondisi" :options="['' => '-- Pilih --', 'baik' => 'Baik', 'rusak' => 'Rusak', 'nihil' => 'Nihil']"
                                :value="old('ruang_guru_kondisi', $sarana->ruangGuru?->kodisi)" />
                        </div>
                    </div>
                </div>

                <!-- L. R. Kantor/TU -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="p-2.5 sm:p-4 border-b border-gray-200 dark:border-gray-700 bg-linear-to-r from-amber-50 to-yellow-50 dark:from-amber-900/20 dark:to-yellow-900/20">
                        <div class="flex items-center gap-2 text-amber-700 dark:text-amber-400 font-semibold text-xs sm:text-sm">
                            <i class="bi bi-briefcase"></i>
                            <span>L. R. Kantor/TU</span>
                        </div>
                    </div>
                    <div class="p-3 sm:p-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 sm:gap-4">
                            <div>
                                <label class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Keberadaan <span class="text-red-600">*</span>
                                </label>
                                <div class="flex flex-wrap gap-3 sm:gap-4 mt-1">
                                    <x-form.radio name="kantor_tu_ada_tidak" value="ada" label="Ada"
                                        :checked="old('kantor_tu_ada_tidak', $sarana->ruangKantorTu?->{'ada/tidak_ada'}) == 'ada'" />
                                    <x-form.radio name="kantor_tu_ada_tidak" value="tidak_ada" label="Tidak Ada"
                                        :checked="old('kantor_tu_ada_tidak', $sarana->ruangKantorTu?->{'ada/tidak_ada'}) == 'tidak_ada'" />
                                </div>
                                @error('kantor_tu_ada_tidak')
                                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <x-form.select name="kantor_tu_kondisi" label="Kondisi" :options="['' => '-- Pilih --', 'baik' => 'Baik', 'rusak' => 'Rusak', 'nihil' => 'Nihil']"
                                :value="old('kantor_tu_kondisi', $sarana->ruangKantorTu?->kodisi)" />
                        </div>
                    </div>
                </div>

                <!-- M. Lab IPA & N. Lab Komputer -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                        <div class="p-2.5 sm:p-4 border-b border-gray-200 dark:border-gray-700 bg-linear-to-r from-emerald-50 to-green-50 dark:from-emerald-900/20 dark:to-green-900/20">
                            <div class="flex items-center gap-2 text-emerald-700 dark:text-emerald-400 font-semibold text-xs sm:text-sm">
                                <i class="bi bi-flask"></i>
                                <span class="hidden sm:inline">M. Lab IPA</span>
                                <span class="sm:hidden">Lab IPA</span>
                            </div>
                        </div>
                        <div class="p-3 sm:p-4">
                            <div class="grid grid-cols-1 gap-2">
                                <div>
                                    <label class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                        Keberadaan <span class="text-red-600">*</span>
                                    </label>
                                    <div class="flex flex-wrap gap-3 sm:gap-4 mt-1">
                                        <x-form.radio name="lab_ipa_ada_tidak" value="ada" label="Ada"
                                            :checked="old('lab_ipa_ada_tidak', $sarana->labIpa?->{'ada/tidak_ada'}) == 'ada'" />
                                        <x-form.radio name="lab_ipa_ada_tidak" value="tidak_ada" label="Tidak Ada"
                                            :checked="old('lab_ipa_ada_tidak', $sarana->labIpa?->{'ada/tidak_ada'}) == 'tidak_ada'" />
                                    </div>
                                    @error('lab_ipa_ada_tidak')
                                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <x-form.select name="lab_ipa_kondisi" label="Kondisi" :options="['' => '-- Pilih --', 'baik' => 'Baik', 'rusak' => 'Rusak', 'nihil' => 'Nihil']"
                                    :value="old('lab_ipa_kondisi', $sarana->labIpa?->kodisi)" />
                            </div>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                        <div class="p-2.5 sm:p-4 border-b border-gray-200 dark:border-gray-700 bg-linear-to-r from-cyan-50 to-sky-50 dark:from-cyan-900/20 dark:to-sky-900/20">
                            <div class="flex items-center gap-2 text-cyan-700 dark:text-cyan-400 font-semibold text-xs sm:text-sm">
                                <i class="bi bi-pc-display-horizontal"></i>
                                <span class="hidden sm:inline">N. Lab Komputer</span>
                                <span class="sm:hidden">Lab Komp</span>
                            </div>
                        </div>
                        <div class="p-3 sm:p-4">
                            <div class="grid grid-cols-1 gap-2">
                                <div>
                                    <label class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                        Keberadaan <span class="text-red-600">*</span>
                                    </label>
                                    <div class="flex flex-wrap gap-3 sm:gap-4 mt-1">
                                        <x-form.radio name="lab_komputer_ada_tidak" value="ada" label="Ada"
                                            :checked="old('lab_komputer_ada_tidak', $sarana->labKomputer?->{'ada/tidak_ada'}) == 'ada'" />
                                        <x-form.radio name="lab_komputer_ada_tidak" value="tidak_ada" label="Tidak Ada"
                                            :checked="old('lab_komputer_ada_tidak', $sarana->labKomputer?->{'ada/tidak_ada'}) == 'tidak_ada'" />
                                    </div>
                                    @error('lab_komputer_ada_tidak')
                                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <x-form.select name="lab_komputer_kondisi" label="Kondisi" :options="['' => '-- Pilih --', 'baik' => 'Baik', 'rusak' => 'Rusak', 'nihil' => 'Nihil']"
                                    :value="old('lab_komputer_kondisi', $sarana->labKomputer?->kodisi)" />
                            </div>
                        </div>
                    </div>
                </div>

                <!-- O. UKS -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="p-2.5 sm:p-4 border-b border-gray-200 dark:border-gray-700 bg-linear-to-r from-rose-50 to-pink-50 dark:from-rose-900/20 dark:to-pink-900/20">
                        <div class="flex items-center gap-2 text-rose-700 dark:text-rose-400 font-semibold text-xs sm:text-sm">
                            <i class="bi bi-heart-pulse"></i>
                            <span>O. UKS</span>
                        </div>
                    </div>
                    <div class="p-3 sm:p-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 sm:gap-4">
                            <div>
                                <label class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Keberadaan <span class="text-red-600">*</span>
                                </label>
                                <div class="flex flex-wrap gap-3 sm:gap-4 mt-1">
                                    <x-form.radio name="uks_ada_tidak" value="ada" label="Ada"
                                        :checked="old('uks_ada_tidak', $sarana->unitKesehatanSekolah?->{'ada/tidak_ada'}) == 'ada'" />
                                    <x-form.radio name="uks_ada_tidak" value="tidak_ada" label="Tidak Ada"
                                        :checked="old('uks_ada_tidak', $sarana->unitKesehatanSekolah?->{'ada/tidak_ada'}) == 'tidak_ada'" />
                                </div>
                                @error('uks_ada_tidak')
                                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <x-form.select name="uks_kondisi" label="Kondisi" :options="['' => '-- Pilih --', 'baik' => 'Baik', 'rusak' => 'Rusak', 'nihil' => 'Nihil']"
                                :value="old('uks_kondisi', $sarana->unitKesehatanSekolah?->kodisi)" />
                        </div>
                    </div>
                </div>

                <!-- P. Rumah Dinas & Q. Rumah Ibadah & R. Lapangan Sekolah -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-4">
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                        <div class="p-2.5 sm:p-4 border-b border-gray-200 dark:border-gray-700 bg-linear-to-r from-teal-50 to-cyan-50 dark:from-teal-900/20 dark:to-cyan-900/20">
                            <div class="flex items-center gap-2 text-teal-700 dark:text-teal-400 font-semibold text-xs sm:text-sm">
                                <i class="bi bi-house-door"></i>
                                <span class="hidden sm:inline">P. Rumah Dinas</span>
                                <span class="sm:hidden">R. Dinas</span>
                            </div>
                        </div>
                        <div class="p-3 sm:p-4">
                            <div class="grid grid-cols-1 gap-2">
                                <div>
                                    <label class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                        Keberadaan <span class="text-red-600">*</span>
                                    </label>
                                    <div class="flex flex-wrap gap-3 sm:gap-4 mt-1">
                                        <x-form.radio name="rumah_dinas_ada_tidak" value="ada" label="Ada"
                                            :checked="old('rumah_dinas_ada_tidak', $sarana->rumahDinas?->{'ada/tidak_ada'}) == 'ada'" />
                                        <x-form.radio name="rumah_dinas_ada_tidak" value="tidak_ada" label="Tidak Ada"
                                            :checked="old('rumah_dinas_ada_tidak', $sarana->rumahDinas?->{'ada/tidak_ada'}) == 'tidak_ada'" />
                                    </div>
                                    @error('rumah_dinas_ada_tidak')
                                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <x-form.select name="rumah_dinas_kondisi" label="Kondisi" :options="['' => '-- Pilih --', 'baik' => 'Baik', 'rusak' => 'Rusak', 'nihil' => 'Nihil']"
                                    :value="old('rumah_dinas_kondisi', $sarana->rumahDinas?->kodisi)" />
                            </div>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                        <div class="p-2.5 sm:p-4 border-b border-gray-200 dark:border-gray-700 bg-linear-to-r from-violet-50 to-purple-50 dark:from-violet-900/20 dark:to-purple-900/20">
                            <div class="flex items-center gap-2 text-violet-700 dark:text-violet-400 font-semibold text-xs sm:text-sm">
                                <i class="bi bi-building"></i>
                                <span class="hidden sm:inline">Q. Rumah Ibadah</span>
                                <span class="sm:hidden">R. Ibadah</span>
                            </div>
                        </div>
                        <div class="p-3 sm:p-4">
                            <div class="grid grid-cols-1 gap-2">
                                <div>
                                    <label class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                        Keberadaan <span class="text-red-600">*</span>
                                    </label>
                                    <div class="flex flex-wrap gap-3 sm:gap-4 mt-1">
                                        <x-form.radio name="rumah_ibadah_ada_tidak" value="ada" label="Ada"
                                            :checked="old('rumah_ibadah_ada_tidak', $sarana->rumahIbadah?->{'ada/tidak_ada'}) == 'ada'" />
                                        <x-form.radio name="rumah_ibadah_ada_tidak" value="tidak_ada" label="Tidak Ada"
                                            :checked="old('rumah_ibadah_ada_tidak', $sarana->rumahIbadah?->{'ada/tidak_ada'}) == 'tidak_ada'" />
                                    </div>
                                    @error('rumah_ibadah_ada_tidak')
                                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <x-form.select name="rumah_ibadah_kondisi" label="Kondisi" :options="['' => '-- Pilih --', 'baik' => 'Baik', 'rusak' => 'Rusak', 'nihil' => 'Nihil']"
                                    :value="old('rumah_ibadah_kondisi', $sarana->rumahIbadah?->kodisi)" />
                            </div>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                        <div class="p-2.5 sm:p-4 border-b border-gray-200 dark:border-gray-700 bg-linear-to-r from-lime-50 to-green-50 dark:from-lime-900/20 dark:to-green-900/20">
                            <div class="flex items-center gap-2 text-lime-700 dark:text-lime-400 font-semibold text-xs sm:text-sm">
                                <i class="bi bi-flag"></i>
                                <span class="hidden sm:inline">R. Lapangan</span>
                                <span class="sm:hidden">Lapangan</span>
                            </div>
                        </div>
                        <div class="p-3 sm:p-4">
                            <div class="grid grid-cols-1 gap-2">
                                <div>
                                    <label class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                        Keberadaan <span class="text-red-600">*</span>
                                    </label>
                                    <div class="flex flex-wrap gap-3 sm:gap-4 mt-1">
                                        <x-form.radio name="lapangan_sekolah_ada_tidak" value="ada" label="Ada"
                                            :checked="old('lapangan_sekolah_ada_tidak', $sarana->lapanganSekolah?->{'ada/tidak_ada'}) == 'ada'" />
                                        <x-form.radio name="lapangan_sekolah_ada_tidak" value="tidak_ada" label="Tidak Ada"
                                            :checked="old('lapangan_sekolah_ada_tidak', $sarana->lapanganSekolah?->{'ada/tidak_ada'}) == 'tidak_ada'" />
                                    </div>
                                    @error('lapangan_sekolah_ada_tidak')
                                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <x-form.select name="lapangan_sekolah_kondisi" label="Kondisi" :options="['' => '-- Pilih --', 'baik' => 'Baik', 'rusak' => 'Rusak', 'nihil' => 'Nihil']"
                                    :value="old('lapangan_sekolah_kondisi', $sarana->lapanganSekolah?->kodisi)" />
                            </div>
                        </div>
                    </div>
                </div>

                <!-- S. Pagar & T. Air -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                        <div class="p-2.5 sm:p-4 border-b border-gray-200 dark:border-gray-700 bg-linear-to-r from-gray-100 to-slate-100 dark:from-gray-700/50 dark:to-slate-700/50">
                            <div class="flex items-center gap-2 text-gray-700 dark:text-gray-300 font-semibold text-xs sm:text-sm">
                                <i class="bi bi-border-all"></i>
                                <span>S. Pagar</span>
                            </div>
                        </div>
                        <div class="p-3 sm:p-4">
                            <div class="grid grid-cols-1 gap-2">
                                <div>
                                    <label class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                        Keberadaan <span class="text-red-600">*</span>
                                    </label>
                                    <div class="flex flex-wrap gap-3 sm:gap-4 mt-1">
                                        <x-form.radio name="pagar_ada_tidak" value="ada" label="Ada"
                                            :checked="old('pagar_ada_tidak', $sarana->pagarSekolah?->{'ada/tidak_ada'}) == 'ada'" />
                                        <x-form.radio name="pagar_ada_tidak" value="tidak_ada" label="Tidak Ada"
                                            :checked="old('pagar_ada_tidak', $sarana->pagarSekolah?->{'ada/tidak_ada'}) == 'tidak_ada'" />
                                    </div>
                                    @error('pagar_ada_tidak')
                                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <x-form.select name="pagar_kondisi" label="Kondisi" :options="['' => '-- Pilih --', 'baik' => 'Baik', 'rusak' => 'Rusak', 'nihil' => 'Nihil']"
                                    :value="old('pagar_kondisi', $sarana->pagarSekolah?->kodisi)" />
                            </div>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                        <div class="p-2.5 sm:p-4 border-b border-gray-200 dark:border-gray-700 bg-linear-to-r from-blue-50 to-sky-50 dark:from-blue-900/20 dark:to-sky-900/20">
                            <div class="flex items-center gap-2 text-blue-700 dark:text-blue-400 font-semibold text-xs sm:text-sm">
                                <i class="bi bi-droplet"></i>
                                <span>T. Air</span>
                            </div>
                        </div>
                        <div class="p-3 sm:p-4">
                            <div class="grid grid-cols-1 gap-2">
                                <div>
                                    <label class="block text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                        Keberadaan <span class="text-red-600">*</span>
                                    </label>
                                    <div class="flex flex-wrap gap-3 sm:gap-4 mt-1">
                                        <x-form.radio name="air_ada_tidak" value="ada" label="Ada"
                                            :checked="old('air_ada_tidak', $sarana->airBersih?->{'ada/tidak_ada'}) == 'ada'" />
                                        <x-form.radio name="air_ada_tidak" value="tidak_ada" label="Tidak Ada"
                                            :checked="old('air_ada_tidak', $sarana->airBersih?->{'ada/tidak_ada'}) == 'tidak_ada'" />
                                    </div>
                                    @error('air_ada_tidak')
                                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <x-form.select name="air_kondisi" label="Kondisi" :options="['' => '-- Pilih --', 'baik' => 'Baik', 'rusak' => 'Rusak', 'nihil' => 'Nihil']"
                                    :value="old('air_kondisi', $sarana->airBersih?->kodisi)" />
                            </div>
                        </div>
                    </div>
                </div>

                <!-- U-Z: Furniture & Elektronik -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
                    <!-- Furniture -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                        <div class="p-2.5 sm:p-4 border-b border-gray-200 dark:border-gray-700 bg-linear-to-r from-yellow-50 to-amber-50 dark:from-yellow-900/20 dark:to-amber-900/20">
                            <div class="flex items-center gap-2 text-yellow-700 dark:text-yellow-400 font-semibold text-xs sm:text-sm">
                                <i class="bi bi-table"></i>
                                <span>Furniture</span>
                            </div>
                        </div>
                        <div class="p-3 sm:p-4">
                            <div class="grid grid-cols-2 gap-2 sm:gap-3">
                                <!-- Kursi Siswa -->
                                <div class="col-span-2">
                                    <div class="text-xs font-semibold text-gray-600 dark:text-gray-400 mb-1">Kursi Siswa</div>
                                    <div class="grid grid-cols-2 gap-2">
                                        <x-form.input name="kursi_siswa_baik" label="Baik" type="number"
                                            min="0" required :value="old('kursi_siswa_baik', $sarana->kursiSiswa?->baik ?? 0)" />
                                        <x-form.input name="kursi_siswa_rusak" label="Rusak" type="number"
                                            min="0" required :value="old('kursi_siswa_rusak', $sarana->kursiSiswa?->rusak ?? 0)" />
                                    </div>
                                </div>

                                <!-- Meja Siswa -->
                                <div class="col-span-2">
                                    <div class="text-xs font-semibold text-gray-600 dark:text-gray-400 mb-1">Meja Siswa</div>
                                    <div class="grid grid-cols-2 gap-2">
                                        <x-form.input name="meja_siswa_baik" label="Baik" type="number"
                                            min="0" required :value="old('meja_siswa_baik', $sarana->mejaSiswa?->baik ?? 0)" />
                                        <x-form.input name="meja_siswa_rusak" label="Rusak" type="number"
                                            min="0" required :value="old('meja_siswa_rusak', $sarana->mejaSiswa?->rusak ?? 0)" />
                                    </div>
                                </div>

                                <!-- Kursi Guru -->
                                <div class="col-span-2">
                                    <div class="text-xs font-semibold text-gray-600 dark:text-gray-400 mb-1">Kursi Guru</div>
                                    <div class="grid grid-cols-2 gap-2">
                                        <x-form.input name="kursi_guru_baik" label="Baik" type="number"
                                            min="0" required :value="old('kursi_guru_baik', $sarana->kursiGuru?->baik ?? 0)" />
                                        <x-form.input name="kursi_guru_rusak" label="Rusak" type="number"
                                            min="0" required :value="old('kursi_guru_rusak', $sarana->kursiGuru?->rusak ?? 0)" />
                                    </div>
                                </div>

                                <!-- Meja Guru -->
                                <div class="col-span-2">
                                    <div class="text-xs font-semibold text-gray-600 dark:text-gray-400 mb-1">Meja Guru</div>
                                    <div class="grid grid-cols-2 gap-2">
                                        <x-form.input name="meja_guru_baik" label="Baik" type="number" min="0"
                                            required :value="old('meja_guru_baik', $sarana->mejaGuru?->baik ?? 0)" />
                                        <x-form.input name="meja_guru_rusak" label="Rusak" type="number"
                                            min="0" required :value="old('meja_guru_rusak', $sarana->mejaGuru?->rusak ?? 0)" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Elektronik -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                        <div class="p-2.5 sm:p-4 border-b border-gray-200 dark:border-gray-700 bg-linear-to-r from-purple-50 to-pink-50 dark:from-purple-900/20 dark:to-pink-900/20">
                            <div class="flex items-center gap-2 text-purple-700 dark:text-purple-400 font-semibold text-xs sm:text-sm">
                                <i class="bi bi-laptop"></i>
                                <span>Elektronik</span>
                            </div>
                        </div>
                        <div class="p-3 sm:p-4">
                            <div class="grid grid-cols-2 gap-2 sm:gap-3">
                                <!-- Laptop -->
                                <div class="col-span-2">
                                    <div class="text-xs font-semibold text-gray-600 dark:text-gray-400 mb-1">Laptop</div>
                                    <div class="grid grid-cols-2 gap-2">
                                        <x-form.input name="laptop_baik" label="Baik" type="number" min="0"
                                            required :value="old('laptop_baik', $sarana->laptop?->baik ?? 0)" />
                                        <x-form.input name="laptop_rusak" label="Rusak" type="number" min="0"
                                            required :value="old('laptop_rusak', $sarana->laptop?->rusak ?? 0)" />
                                    </div>
                                </div>

                                <!-- Komputer -->
                                <div class="col-span-2">
                                    <div class="text-xs font-semibold text-gray-600 dark:text-gray-400 mb-1">Komputer</div>
                                    <div class="grid grid-cols-2 gap-2">
                                        <x-form.input name="komputer_baik" label="Baik" type="number" min="0"
                                            required :value="old('komputer_baik', $sarana->komputer?->baik ?? 0)" />
                                        <x-form.input name="komputer_rusak" label="Rusak" type="number" min="0"
                                            required :value="old('komputer_rusak', $sarana->komputer?->rusak ?? 0)" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tombol Aksi -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="p-3 sm:p-4 border-t border-gray-200 dark:border-gray-700">
                        <div class="flex flex-wrap gap-2">
                            <x-button type="button" variant="warning" size="md" data-modal-open="confirmEditModal">
                                <i class="bi bi-save me-1"></i>
                                <span class="hidden sm:inline">Update Data</span>
                                <span class="sm:hidden">Update</span>
                            </x-button>
                            <x-button type="reset" variant="secondary" size="md">
                                <i class="bi bi-arrow-counterclockwise me-1"></i>
                                <span class="hidden sm:inline">Reset</span>
                                <span class="sm:hidden">Reset</span>
                            </x-button>
                            <a href="{{ route('user.data.index') }}" class="inline-flex">
                                <x-button variant="secondary" size="md">
                                    <i class="bi bi-x-circle me-1"></i>
                                    <span class="hidden sm:inline">Batal</span>
                                    <span class="sm:hidden">Batal</span>
                                </x-button>
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Konfirmasi Update -->
    <x-modal id="confirmEditModal" size="sm" centered>
        <x-slot:header>
            <div class="flex items-center gap-2 text-yellow-600">
                <i class="bi bi-exclamation-triangle-fill text-xl"></i>
                <span>Konfirmasi Update</span>
            </div>
        </x-slot:header>

        <div class="text-center py-4">
            <div class="text-5xl text-yellow-500 mb-4">
                <i class="bi bi-pencil-square"></i>
            </div>
            <h4 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-2">
                Yakin ingin mengupdate data ini?
            </h4>
            <p class="text-sm text-red-500 dark:text-gray-400">
                Pastikan semua data yang diisi sudah benar sebelum mengupdate.
            </p>
        </div>

        <x-slot:footer>
            <div class="flex flex-wrap justify-end gap-2 w-full">
                <a href="#" class="inline-flex" data-modal-close>
                    <x-button variant="secondary">
                        <i class="bi bi-x-circle me-1"></i> Batal
                    </x-button>
                </a>
                <x-button variant="warning" type="submit" form="saranaForm">
                    <i class="bi bi-check-circle me-1"></i> Ya, Update
                </x-button>
            </div>
        </x-slot:footer>
    </x-modal>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Fungsi untuk mengatur kondisi otomatis (disable select saat "tidak_ada")
                function setupConditionAuto(radioName, selectId) {
                    const radios = document.querySelectorAll(`input[name="${radioName}"]`);
                    const select = document.getElementById(selectId);

                    if (!radios.length || !select) return;

                    radios.forEach(radio => {
                        radio.addEventListener('change', function() {
                            if (this.value === 'tidak_ada') {
                                select.value = 'nihil';
                                select.disabled = true;
                                select.classList.add('opacity-50', 'cursor-not-allowed');
                            } else {
                                select.disabled = false;
                                select.classList.remove('opacity-50', 'cursor-not-allowed');
                                if (select.value === 'nihil') {
                                    select.value = '';
                                }
                            }
                        });
                    });

                    // Cek kondisi awal
                    const checked = document.querySelector(`input[name="${radioName}"]:checked`);
                    if (checked && checked.value === 'tidak_ada') {
                        select.value = 'nihil';
                        select.disabled = true;
                        select.classList.add('opacity-50', 'cursor-not-allowed');
                    }
                }

                // Setup untuk semua fasilitas
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