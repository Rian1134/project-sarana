@extends('layouts.admin')

@section('title')
    Edit Data Sarana & Prasarana
@endsection

@section('content')
    <div class="container mx-auto px-3 sm:px-4 py-3 sm:py-4">
        <div class="flex flex-col gap-3 sm:gap-4">
            <!-- Header -->
            <div
                class="sticky top-0 z-20 -mx-3 sm:-mx-4 px-3 sm:px-4 py-2.5 flex flex-wrap items-center justify-between gap-2 bg-white/95 dark:bg-gray-800/95 backdrop-blur border-b border-gray-200 dark:border-gray-700">
                <div>
                    <h1 class="text-base sm:text-xl font-semibold text-gray-800 dark:text-gray-100 flex items-center gap-2">
                        <i class="bi bi-pencil-square text-blue-600 dark:text-blue-400"></i>
                        <span class="hidden sm:inline">Form Edit Data Sarana & Prasarana Sekolah</span>
                        <span class="sm:hidden">Edit Data</span>
                    </h1>
                    <p class="hidden sm:block text-xs text-gray-400 dark:text-gray-500 mt-0.5">
                        Perbarui data sarana & prasarana sekolah sesuai kondisi saat ini
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
            <form action="{{ route('sarana.update', $profileSekolah->id) }}" method="POST" id="saranaForm"
                class="flex flex-col gap-4">
                @csrf
                @method('PUT')

                <!-- ===== Kelompok: Data Pokok Sekolah ===== -->
                <div class="flex items-center gap-2 pt-2">
                    <i class="bi bi-building text-blue-600 dark:text-blue-400"></i>
                    <h2 class="text-sm sm:text-base font-bold text-blue-600 dark:text-blue-400 whitespace-nowrap">
                        Data Pokok Sekolah
                    </h2>
                    <div class="flex-1 border-t-2 border-blue-200 dark:border-blue-900"></div>
                </div>

                <!-- A. Data Sekolah -->
                <x-card
                    class="bg-white dark:bg-gray-800 border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-md transition-shadow duration-200">
                    <x-slot:header>
                        <div class="flex items-center gap-2 text-blue-600 dark:text-blue-400">
                            <i class="bi bi-building"></i>
                            Data Sekolah
                        </div>
                    </x-slot:header>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <x-form.input name="nama_sekolah" label="Nama Sekolah" placeholder="Masukkan nama sekolah" required
                            :value="old('nama_sekolah', $profileSekolah->nama_sekolah)" />

                        <x-form.input name="NPSN" label="NPSN" placeholder="Masukkan NPSN" required
                            :value="old('NPSN', $profileSekolah->NPSN)" />

                        <div>
                            <x-form.select name="status_sekolah" label="Status Sekolah" placeholder="-- Pilih Status --"
                                :options="['negeri' => 'Negeri', 'swasta' => 'Swasta']"
                                :value="old('status_sekolah', $profileSekolah->status_sekolah)" required />
                        </div>

                        <div>
                            <x-form.select name="akreditasi" label="Akreditasi" placeholder="-- Pilih Akreditasi --"
                                :options="[
                                    'A' => 'A (Unggul)',
                                    'B' => 'B (Baik)',
                                    'C' => 'C (Cukup)',
                                    'belum_terakreditasi' => 'Belum Terakreditasi',
                                ]" :value="old('akreditasi', $profileSekolah->akreditasi)" required />
                        </div>

                        <div class="md:col-span-2">
                            <x-form.textarea name="alamat_sekolah" label="Alamat Sekolah" rows="2"
                                placeholder="Masukkan alamat lengkap sekolah" required>{{ old('alamat_sekolah', $profileSekolah->alamat_sekolah) }}</x-form.textarea>
                        </div>

                        <x-form.input name="nama_kepala_sekolah" label="Nama Kepala Sekolah" placeholder="Masukkan nama kepala sekolah" required
                            :value="old('nama_kepala_sekolah', $profileSekolah->nama_kepala_sekolah)" />

                        <x-form.input name="NIP" label="NIP" placeholder="Masukkan NIP" required
                            :value="old('NIP', $profileSekolah->NIP)" />

                        <div class="md:col-span-2">
                            <x-form.input name="nomor_hp_kepala_sekolah" label="Nomor HP Kepala Sekolah"
                                placeholder="Masukkan nomor HP kepala sekolah" required
                                :value="old('nomor_hp_kepala_sekolah', $profileSekolah->nomor_hp_kepala_sekolah)" />
                        </div>

                        <x-form.input name="nama_operator" label="Nama Operator" placeholder="Masukkan nama operator"
                            required :value="old('nama_operator', $profileSekolah->nama_operator)" />

                        <x-form.input name="nomor_operator" label="Nomor HP Operator"
                            placeholder="Masukkan nomor HP operator" required
                            :value="old('nomor_operator', $profileSekolah->nomor_operator)" />
                    </div>
                </x-card>

                <!-- ===== Kelompok: Data Siswa & Rombel ===== -->
                <div class="flex items-center gap-2 pt-2">
                    <i class="bi bi-mortarboard text-indigo-600 dark:text-indigo-400"></i>
                    <h2 class="text-sm sm:text-base font-bold text-indigo-600 dark:text-indigo-400 whitespace-nowrap">
                        Data Siswa & Rombel
                    </h2>
                    <div class="flex-1 border-t-2 border-indigo-200 dark:border-indigo-900"></div>
                </div>

                <!-- B. Jumlah Siswa -->
                <x-card
                    class="bg-white dark:bg-gray-800 border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-md transition-shadow duration-200">
                    <x-slot:header>
                        <div class="flex items-center gap-2 text-blue-600 dark:text-blue-400">
                            <i class="bi bi-mortarboard"></i>
                            Jumlah Siswa
                        </div>
                    </x-slot:header>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <x-form.input name="jumlah_siswa_vii" label="Kelas VII" type="number" min="0" required
                            :value="old('jumlah_siswa_vii', $profileSekolah->jumlahSiswa?->vii ?? 0)" />
                        <x-form.input name="jumlah_siswa_viii" label="Kelas VIII" type="number" min="0" required
                            :value="old('jumlah_siswa_viii', $profileSekolah->jumlahSiswa?->viii ?? 0)" />
                        <x-form.input name="jumlah_siswa_ix" label="Kelas IX" type="number" min="0" required
                            :value="old('jumlah_siswa_ix', $profileSekolah->jumlahSiswa?->ix ?? 0)" />
                    </div>
                </x-card>

                <!-- C. Jumlah Rombongan Belajar -->
                <x-card
                    class="bg-white dark:bg-gray-800 border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-md transition-shadow duration-200">
                    <x-slot:header>
                        <div class="flex items-center gap-2 text-blue-600 dark:text-blue-400">
                            <i class="bi bi-diagram-3"></i>
                            Jumlah Rombongan Belajar
                        </div>
                    </x-slot:header>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <x-form.input name="jumlah_rombel_vii" label="Kelas VII" type="number" min="0" required
                            :value="old('jumlah_rombel_vii', $profileSekolah->jumlahRombel?->vii ?? 0)" />
                        <x-form.input name="jumlah_rombel_viii" label="Kelas VIII" type="number" min="0" required
                            :value="old('jumlah_rombel_viii', $profileSekolah->jumlahRombel?->viii ?? 0)" />
                        <x-form.input name="jumlah_rombel_ix" label="Kelas IX" type="number" min="0" required
                            :value="old('jumlah_rombel_ix', $profileSekolah->jumlahRombel?->ix ?? 0)" />
                    </div>
                </x-card>

                <!-- ===== Kelompok: Ruang Kelas ===== -->
                <div class="flex items-center gap-2 pt-2">
                    <i class="bi bi-door-open text-cyan-600 dark:text-cyan-400"></i>
                    <h2 class="text-sm sm:text-base font-bold text-cyan-600 dark:text-cyan-400 whitespace-nowrap">
                        Ruang Kelas
                    </h2>
                    <div class="flex-1 border-t-2 border-cyan-200 dark:border-cyan-900"></div>
                </div>

                <!-- D. RKB (Ruang Kelas Baru) -->
                <x-card
                    class="bg-white dark:bg-gray-800 border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-md transition-shadow duration-200">
                    <x-slot:header>
                        <div class="flex items-center gap-2 text-blue-600 dark:text-blue-400">
                            <i class="bi bi-building-add"></i>
                            Pembangunan Ruang Kelas Baru (RKB)
                        </div>
                    </x-slot:header>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                        <x-form.input name="rkb_jumlah" label="Jumlah" type="number" min="0" required
                            :value="old('rkb_jumlah', $profileSekolah->ruangKelasBaru?->jumlah ?? 0)" />
                        <div
                            class="md:col-span-2 flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400 pb-2">
                            <i class="bi bi-calendar-range"></i>
                            Periode pelaporan:
                            <x-badge variant="secondary">{{ $rkbPeriode->label() }}</x-badge>
                            <span class="text-xs text-gray-400">(diatur admin, berlaku untuk semua sekolah)</span>
                        </div>
                    </div>
                </x-card>

                <!-- E. Rehabilitasi Ruang Kelas -->
                <x-card
                    class="bg-white dark:bg-gray-800 border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-md transition-shadow duration-200">
                    <x-slot:header>
                        <div class="flex items-center gap-2 text-blue-600 dark:text-blue-400">
                            <i class="bi bi-tools"></i>
                            Rehabilitasi Ruang Kelas
                        </div>
                    </x-slot:header>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                        <x-form.input name="rehabilitasi_jumlah" label="Jumlah" type="number" min="0" required
                            :value="old('rehabilitasi_jumlah', $profileSekolah->rehabilitasiRuangKelas?->jumlah ?? 0)" />
                        <div
                            class="md:col-span-2 flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400 pb-2">
                            <i class="bi bi-calendar-range"></i>
                            Periode pelaporan:
                            <x-badge variant="secondary">{{ $rehabilitasiPeriode->label() }}</x-badge>
                            <span class="text-xs text-gray-400">(diatur admin, berlaku untuk semua sekolah)</span>
                        </div>
                    </div>
                </x-card>

                <!-- F. Ruang Kelas -->
                <x-card
                    class="bg-white dark:bg-gray-800 border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-md transition-shadow duration-200">
                    <x-slot:header>
                        <div class="flex items-center gap-2 text-blue-600 dark:text-blue-400">
                            <i class="bi bi-door-closed"></i>
                            Ruang Kelas
                        </div>
                    </x-slot:header>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <x-form.input name="ruang_kelas_baik" label="Jumlah Baik" type="number" min="0" required
                            :value="old('ruang_kelas_baik', $profileSekolah->ruangKelas?->baik ?? 0)" />
                        <x-form.input name="ruang_kelas_rusak" label="Jumlah Rusak" type="number" min="0" required
                            :value="old('ruang_kelas_rusak', $profileSekolah->ruangKelas?->rusak ?? 0)" />
                    </div>
                </x-card>

                <!-- ===== Kelompok: Toilet ===== -->
                <div class="flex items-center gap-2 pt-2">
                    <i class="bi bi-droplet text-teal-600 dark:text-teal-400"></i>
                    <h2 class="text-sm sm:text-base font-bold text-teal-600 dark:text-teal-400 whitespace-nowrap">
                        Toilet
                    </h2>
                    <div class="flex-1 border-t-2 border-teal-200 dark:border-teal-900"></div>
                </div>

                <!-- G. Toilet Siswa -->
                <x-card
                    class="bg-white dark:bg-gray-800 border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-md transition-shadow duration-200">
                    <x-slot:header>
                        <div class="flex items-center gap-2 text-blue-600 dark:text-blue-400">
                            <i class="bi bi-droplet-half"></i>
                            Toilet Siswa
                        </div>
                    </x-slot:header>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <x-form.input name="toilet_siswa_baik" label="Jumlah Baik" type="number" min="0" required
                            :value="old('toilet_siswa_baik', $profileSekolah->toiletSiswa?->baik ?? 0)" />
                        <x-form.input name="toilet_siswa_rusak" label="Jumlah Rusak" type="number" min="0" required
                            :value="old('toilet_siswa_rusak', $profileSekolah->toiletSiswa?->rusak ?? 0)" />
                    </div>
                </x-card>

                <!-- H. Toilet Guru -->
                <x-card
                    class="bg-white dark:bg-gray-800 border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-md transition-shadow duration-200">
                    <x-slot:header>
                        <div class="flex items-center gap-2 text-blue-600 dark:text-blue-400">
                            <i class="bi bi-droplet"></i>
                            Toilet Guru
                        </div>
                    </x-slot:header>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <x-form.input name="toilet_guru_baik" label="Jumlah Baik" type="number" min="0" required
                            :value="old('toilet_guru_baik', $profileSekolah->toiletGuru?->baik ?? 0)" />
                        <x-form.input name="toilet_guru_rusak" label="Jumlah Rusak" type="number" min="0" required
                            :value="old('toilet_guru_rusak', $profileSekolah->toiletGuru?->rusak ?? 0)" />
                    </div>
                </x-card>

                <!-- ===== Kelompok: Ruang & Fasilitas Sekolah ===== -->
                <div class="flex items-center gap-2 pt-2">
                    <i class="bi bi-house-gear text-orange-600 dark:text-orange-400"></i>
                    <h2 class="text-sm sm:text-base font-bold text-orange-600 dark:text-orange-400 whitespace-nowrap">
                        Ruang & Fasilitas Sekolah
                    </h2>
                    <div class="flex-1 border-t-2 border-orange-200 dark:border-orange-900"></div>
                </div>

                <!-- I. Ruang Perpustakaan -->
                <x-card
                    class="bg-white dark:bg-gray-800 border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-md transition-shadow duration-200">
                    <x-slot:header>
                        <div class="flex items-center gap-2 text-blue-600 dark:text-blue-400">
                            <i class="bi bi-book"></i>
                            Ruang Perpustakaan
                        </div>
                    </x-slot:header>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="form-label">
                                Keberadaan Ruang Perpustakaan <span class="text-danger">*</span>
                            </label>
                            <div class="flex flex-wrap gap-4 mt-1">
                                <x-form.radio name="perpustakaan_ada_tidak" value="ada" label="Ada"
                                    :checked="old('perpustakaan_ada_tidak', $profileSekolah->ruangPerpustakaan?->{'ada/tidak_ada'}) == 'ada'" />
                                <x-form.radio name="perpustakaan_ada_tidak" value="tidak_ada" label="Tidak Ada"
                                    :checked="old('perpustakaan_ada_tidak', $profileSekolah->ruangPerpustakaan?->{'ada/tidak_ada'}) == 'tidak_ada'" />
                            </div>
                            @error('perpustakaan_ada_tidak')
                                <p class="invalid-feedback">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <x-form.select name="perpustakaan_kondisi" label="Kondisi Ruang Perpustakaan"
                                placeholder="-- Pilih Kondisi --" :options="[
                                    'baik' => 'Baik',
                                    'rusak_ringan' => 'Rusak Ringan',
                                    'rusak_sedang' => 'Rusak Sedang',
                                    'rusak_berat' => 'Rusak Berat',
                                    'nihil' => 'Nihil',
                                ]"
                                :value="old('perpustakaan_kondisi', $profileSekolah->ruangPerpustakaan?->kodisi)" />
                        </div>
                    </div>
                </x-card>

                <!-- J. Ruang Kepala Sekolah -->
                <x-card
                    class="bg-white dark:bg-gray-800 border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-md transition-shadow duration-200">
                    <x-slot:header>
                        <div class="flex items-center gap-2 text-blue-600 dark:text-blue-400">
                            <i class="bi bi-person-workspace"></i>
                            Ruang Kepala Sekolah
                        </div>
                    </x-slot:header>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="form-label">
                                Keberadaan Ruang Kepala Sekolah <span class="text-danger">*</span>
                            </label>
                            <div class="flex flex-wrap gap-4 mt-1">
                                <x-form.radio name="kepala_sekolah_ada_tidak" value="ada" label="Ada"
                                    :checked="old('kepala_sekolah_ada_tidak', $profileSekolah->ruangKepalaSekolah?->{'ada/tidak_ada'}) == 'ada'" />
                                <x-form.radio name="kepala_sekolah_ada_tidak" value="tidak_ada" label="Tidak Ada"
                                    :checked="old('kepala_sekolah_ada_tidak', $profileSekolah->ruangKepalaSekolah?->{'ada/tidak_ada'}) == 'tidak_ada'" />
                            </div>
                            @error('kepala_sekolah_ada_tidak')
                                <p class="invalid-feedback">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <x-form.select name="kepala_sekolah_kondisi" label="Kondisi Ruang Kepala Sekolah"
                                placeholder="-- Pilih Kondisi --" :options="[
                                    'baik' => 'Baik',
                                    'rusak_ringan' => 'Rusak Ringan',
                                    'rusak_sedang' => 'Rusak Sedang',
                                    'rusak_berat' => 'Rusak Berat',
                                    'nihil' => 'Nihil',
                                ]"
                                :value="old('kepala_sekolah_kondisi', $profileSekolah->ruangKepalaSekolah?->kodisi)" />
                        </div>
                    </div>
                </x-card>

                <!-- K. Ruang Guru -->
                <x-card
                    class="bg-white dark:bg-gray-800 border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-md transition-shadow duration-200">
                    <x-slot:header>
                        <div class="flex items-center gap-2 text-blue-600 dark:text-blue-400">
                            <i class="bi bi-easel2"></i>
                            Ruang Guru
                        </div>
                    </x-slot:header>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="form-label">
                                Keberadaan Ruang Guru <span class="text-danger">*</span>
                            </label>
                            <div class="flex flex-wrap gap-4 mt-1">
                                <x-form.radio name="ruang_guru_ada_tidak" value="ada" label="Ada"
                                    :checked="old('ruang_guru_ada_tidak', $profileSekolah->ruangGuru?->{'ada/tidak_ada'}) == 'ada'" />
                                <x-form.radio name="ruang_guru_ada_tidak" value="tidak_ada" label="Tidak Ada"
                                    :checked="old('ruang_guru_ada_tidak', $profileSekolah->ruangGuru?->{'ada/tidak_ada'}) == 'tidak_ada'" />
                            </div>
                            @error('ruang_guru_ada_tidak')
                                <p class="invalid-feedback">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <x-form.select name="ruang_guru_kondisi" label="Kondisi Ruang Guru"
                                placeholder="-- Pilih Kondisi --" :options="[
                                    'baik' => 'Baik',
                                    'rusak_ringan' => 'Rusak Ringan',
                                    'rusak_sedang' => 'Rusak Sedang',
                                    'rusak_berat' => 'Rusak Berat',
                                    'nihil' => 'Nihil',
                                ]"
                                :value="old('ruang_guru_kondisi', $profileSekolah->ruangGuru?->kodisi)" />
                        </div>
                    </div>
                </x-card>

                <!-- L. Ruang Kantor/Tata Usaha -->
                <x-card
                    class="bg-white dark:bg-gray-800 border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-md transition-shadow duration-200">
                    <x-slot:header>
                        <div class="flex items-center gap-2 text-blue-600 dark:text-blue-400">
                            <i class="bi bi-briefcase"></i>
                            Ruang Kantor/Tata Usaha
                        </div>
                    </x-slot:header>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="form-label">
                                Keberadaan Ruang Kantor/Tata Usaha <span class="text-danger">*</span>
                            </label>
                            <div class="flex flex-wrap gap-4 mt-1">
                                <x-form.radio name="kantor_tu_ada_tidak" value="ada" label="Ada"
                                    :checked="old('kantor_tu_ada_tidak', $profileSekolah->ruangKantorTu?->{'ada/tidak_ada'}) == 'ada'" />
                                <x-form.radio name="kantor_tu_ada_tidak" value="tidak_ada" label="Tidak Ada"
                                    :checked="old('kantor_tu_ada_tidak', $profileSekolah->ruangKantorTu?->{'ada/tidak_ada'}) == 'tidak_ada'" />
                            </div>
                            @error('kantor_tu_ada_tidak')
                                <p class="invalid-feedback">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <x-form.select name="kantor_tu_kondisi" label="Kondisi Ruang Kantor/Tata Usaha"
                                placeholder="-- Pilih Kondisi --" :options="[
                                    'baik' => 'Baik',
                                    'rusak_ringan' => 'Rusak Ringan',
                                    'rusak_sedang' => 'Rusak Sedang',
                                    'rusak_berat' => 'Rusak Berat',
                                    'nihil' => 'Nihil',
                                ]"
                                :value="old('kantor_tu_kondisi', $profileSekolah->ruangKantorTu?->kodisi)" />
                        </div>
                    </div>
                </x-card>

                <!-- M. Lab IPA -->
                <x-card
                    class="bg-white dark:bg-gray-800 border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-md transition-shadow duration-200">
                    <x-slot:header>
                        <div class="flex items-center gap-2 text-blue-600 dark:text-blue-400">
                            <i class="bi bi-flask"></i>
                            Laboratorium IPA
                        </div>
                    </x-slot:header>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="form-label">
                                Keberadaan Laboratorium IPA <span class="text-danger">*</span>
                            </label>
                            <div class="flex flex-wrap gap-4 mt-1">
                                <x-form.radio name="lab_ipa_ada_tidak" value="ada" label="Ada"
                                    :checked="old('lab_ipa_ada_tidak', $profileSekolah->labIpa?->{'ada/tidak_ada'}) == 'ada'" />
                                <x-form.radio name="lab_ipa_ada_tidak" value="tidak_ada" label="Tidak Ada"
                                    :checked="old('lab_ipa_ada_tidak', $profileSekolah->labIpa?->{'ada/tidak_ada'}) == 'tidak_ada'" />
                            </div>
                            @error('lab_ipa_ada_tidak')
                                <p class="invalid-feedback">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <x-form.select name="lab_ipa_kondisi" label="Kondisi Lab IPA"
                                placeholder="-- Pilih Kondisi --" :options="[
                                    'baik' => 'Baik',
                                    'rusak_ringan' => 'Rusak Ringan',
                                    'rusak_sedang' => 'Rusak Sedang',
                                    'rusak_berat' => 'Rusak Berat',
                                    'nihil' => 'Nihil',
                                ]"
                                :value="old('lab_ipa_kondisi', $profileSekolah->labIpa?->kodisi)" />
                        </div>
                    </div>
                </x-card>

                <!-- N. Lab Komputer -->
                <x-card
                    class="bg-white dark:bg-gray-800 border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-md transition-shadow duration-200">
                    <x-slot:header>
                        <div class="flex items-center gap-2 text-blue-600 dark:text-blue-400">
                            <i class="bi bi-pc-display-horizontal"></i>
                            Laboratorium Komputer
                        </div>
                    </x-slot:header>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="form-label">
                                Keberadaan Laboratorium Komputer <span class="text-danger">*</span>
                            </label>
                            <div class="flex flex-wrap gap-4 mt-1">
                                <x-form.radio name="lab_komputer_ada_tidak" value="ada" label="Ada"
                                    :checked="old('lab_komputer_ada_tidak', $profileSekolah->labKomputer?->{'ada/tidak_ada'}) == 'ada'" />
                                <x-form.radio name="lab_komputer_ada_tidak" value="tidak_ada" label="Tidak Ada"
                                    :checked="old('lab_komputer_ada_tidak', $profileSekolah->labKomputer?->{'ada/tidak_ada'}) == 'tidak_ada'" />
                            </div>
                            @error('lab_komputer_ada_tidak')
                                <p class="invalid-feedback">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <x-form.select name="lab_komputer_kondisi" label="Kondisi Lab Komputer"
                                placeholder="-- Pilih Kondisi --" :options="[
                                    'baik' => 'Baik',
                                    'rusak_ringan' => 'Rusak Ringan',
                                    'rusak_sedang' => 'Rusak Sedang',
                                    'rusak_berat' => 'Rusak Berat',
                                    'nihil' => 'Nihil',
                                ]"
                                :value="old('lab_komputer_kondisi', $profileSekolah->labKomputer?->kodisi)" />
                        </div>
                    </div>
                </x-card>

                <!-- O. UKS -->
                <x-card
                    class="bg-white dark:bg-gray-800 border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-md transition-shadow duration-200">
                    <x-slot:header>
                        <div class="flex items-center gap-2 text-blue-600 dark:text-blue-400">
                            <i class="bi bi-heart-pulse"></i>
                            Unit Kesehatan Sekolah (UKS)
                        </div>
                    </x-slot:header>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="form-label">
                                Keberadaan UKS <span class="text-danger">*</span>
                            </label>
                            <div class="flex flex-wrap gap-4 mt-1">
                                <x-form.radio name="uks_ada_tidak" value="ada" label="Ada"
                                    :checked="old('uks_ada_tidak', $profileSekolah->unitKesehatanSekolah?->{'ada/tidak_ada'}) == 'ada'" />
                                <x-form.radio name="uks_ada_tidak" value="tidak_ada" label="Tidak Ada"
                                    :checked="old('uks_ada_tidak', $profileSekolah->unitKesehatanSekolah?->{'ada/tidak_ada'}) == 'tidak_ada'" />
                            </div>
                            @error('uks_ada_tidak')
                                <p class="invalid-feedback">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <x-form.select name="uks_kondisi" label="Kondisi UKS"
                                placeholder="-- Pilih Kondisi --" :options="[
                                    'baik' => 'Baik',
                                    'rusak_ringan' => 'Rusak Ringan',
                                    'rusak_sedang' => 'Rusak Sedang',
                                    'rusak_berat' => 'Rusak Berat',
                                    'nihil' => 'Nihil',
                                ]"
                                :value="old('uks_kondisi', $profileSekolah->unitKesehatanSekolah?->kodisi)" />
                        </div>
                    </div>
                </x-card>

                <!-- P. Rumah Dinas -->
                <x-card
                    class="bg-white dark:bg-gray-800 border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-md transition-shadow duration-200">
                    <x-slot:header>
                        <div class="flex items-center gap-2 text-blue-600 dark:text-blue-400">
                            <i class="bi bi-house-door"></i>
                            Rumah Dinas
                        </div>
                    </x-slot:header>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="form-label">
                                Keberadaan Rumah Dinas <span class="text-danger">*</span>
                            </label>
                            <div class="flex flex-wrap gap-4 mt-1">
                                <x-form.radio name="rumah_dinas_ada_tidak" value="ada" label="Ada"
                                    :checked="old('rumah_dinas_ada_tidak', $profileSekolah->rumahDinas?->{'ada/tidak_ada'}) == 'ada'" />
                                <x-form.radio name="rumah_dinas_ada_tidak" value="tidak_ada" label="Tidak Ada"
                                    :checked="old('rumah_dinas_ada_tidak', $profileSekolah->rumahDinas?->{'ada/tidak_ada'}) == 'tidak_ada'" />
                            </div>
                            @error('rumah_dinas_ada_tidak')
                                <p class="invalid-feedback">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <x-form.select name="rumah_dinas_kondisi" label="Kondisi Rumah Dinas"
                                placeholder="-- Pilih Kondisi --" :options="[
                                    'baik' => 'Baik',
                                    'rusak_ringan' => 'Rusak Ringan',
                                    'rusak_sedang' => 'Rusak Sedang',
                                    'rusak_berat' => 'Rusak Berat',
                                    'nihil' => 'Nihil',
                                ]"
                                :value="old('rumah_dinas_kondisi', $profileSekolah->rumahDinas?->kodisi)" />
                        </div>
                    </div>
                </x-card>

                <!-- Q. Rumah Ibadah -->
                <x-card
                    class="bg-white dark:bg-gray-800 border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-md transition-shadow duration-200">
                    <x-slot:header>
                        <div class="flex items-center gap-2 text-blue-600 dark:text-blue-400">
                            <i class="bi bi-building"></i>
                            Rumah Ibadah
                        </div>
                    </x-slot:header>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="form-label">
                                Keberadaan Rumah Ibadah <span class="text-danger">*</span>
                            </label>
                            <div class="flex flex-wrap gap-4 mt-1">
                                <x-form.radio name="rumah_ibadah_ada_tidak" value="ada" label="Ada"
                                    :checked="old('rumah_ibadah_ada_tidak', $profileSekolah->rumahIbadah?->{'ada/tidak_ada'}) == 'ada'" />
                                <x-form.radio name="rumah_ibadah_ada_tidak" value="tidak_ada" label="Tidak Ada"
                                    :checked="old('rumah_ibadah_ada_tidak', $profileSekolah->rumahIbadah?->{'ada/tidak_ada'}) == 'tidak_ada'" />
                            </div>
                            @error('rumah_ibadah_ada_tidak')
                                <p class="invalid-feedback">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <x-form.select name="rumah_ibadah_kondisi" label="Kondisi Rumah Ibadah"
                                placeholder="-- Pilih Kondisi --" :options="[
                                    'baik' => 'Baik',
                                    'rusak_ringan' => 'Rusak Ringan',
                                    'rusak_sedang' => 'Rusak Sedang',
                                    'rusak_berat' => 'Rusak Berat',
                                    'nihil' => 'Nihil',
                                ]"
                                :value="old('rumah_ibadah_kondisi', $profileSekolah->rumahIbadah?->kodisi)" />
                        </div>
                    </div>
                </x-card>

                <!-- R. Lapangan Sekolah -->
                <x-card
                    class="bg-white dark:bg-gray-800 border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-md transition-shadow duration-200">
                    <x-slot:header>
                        <div class="flex items-center gap-2 text-blue-600 dark:text-blue-400">
                            <i class="bi bi-flag"></i>
                            Lapangan Sekolah
                        </div>
                    </x-slot:header>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="form-label">
                                Keberadaan Lapangan Sekolah <span class="text-danger">*</span>
                            </label>
                            <div class="flex flex-wrap gap-4 mt-1">
                                <x-form.radio name="lapangan_sekolah_ada_tidak" value="ada" label="Ada"
                                    :checked="old('lapangan_sekolah_ada_tidak', $profileSekolah->lapanganSekolah?->{'ada/tidak_ada'}) == 'ada'" />
                                <x-form.radio name="lapangan_sekolah_ada_tidak" value="tidak_ada" label="Tidak Ada"
                                    :checked="old('lapangan_sekolah_ada_tidak', $profileSekolah->lapanganSekolah?->{'ada/tidak_ada'}) == 'tidak_ada'" />
                            </div>
                            @error('lapangan_sekolah_ada_tidak')
                                <p class="invalid-feedback">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <x-form.select name="lapangan_sekolah_kondisi" label="Kondisi Lapangan Sekolah"
                                placeholder="-- Pilih Kondisi --" :options="[
                                    'baik' => 'Baik',
                                    'rusak_ringan' => 'Rusak Ringan',
                                    'rusak_sedang' => 'Rusak Sedang',
                                    'rusak_berat' => 'Rusak Berat',
                                    'nihil' => 'Nihil',
                                ]"
                                :value="old('lapangan_sekolah_kondisi', $profileSekolah->lapanganSekolah?->kodisi)" />
                        </div>
                    </div>
                </x-card>

                <!-- S. Pagar -->
                <x-card
                    class="bg-white dark:bg-gray-800 border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-md transition-shadow duration-200">
                    <x-slot:header>
                        <div class="flex items-center gap-2 text-blue-600 dark:text-blue-400">
                            <i class="bi bi-border-all"></i>
                            Pagar Sekolah
                        </div>
                    </x-slot:header>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="form-label">
                                Keberadaan Pagar <span class="text-danger">*</span>
                            </label>
                            <div class="flex flex-wrap gap-4 mt-1">
                                <x-form.radio name="pagar_ada_tidak" value="ada" label="Ada"
                                    :checked="old('pagar_ada_tidak', $profileSekolah->pagarSekolah?->{'ada/tidak_ada'}) == 'ada'" />
                                <x-form.radio name="pagar_ada_tidak" value="tidak_ada" label="Tidak Ada"
                                    :checked="old('pagar_ada_tidak', $profileSekolah->pagarSekolah?->{'ada/tidak_ada'}) == 'tidak_ada'" />
                            </div>
                            @error('pagar_ada_tidak')
                                <p class="invalid-feedback">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <x-form.select name="pagar_kondisi" label="Kondisi Pagar"
                                placeholder="-- Pilih Kondisi --" :options="[
                                    'baik' => 'Baik',
                                    'rusak_ringan' => 'Rusak Ringan',
                                    'rusak_sedang' => 'Rusak Sedang',
                                    'rusak_berat' => 'Rusak Berat',
                                    'nihil' => 'Nihil',
                                ]"
                                :value="old('pagar_kondisi', $profileSekolah->pagarSekolah?->kodisi)" />
                        </div>
                    </div>
                </x-card>

                <!-- T. Air -->
                <x-card
                    class="bg-white dark:bg-gray-800 border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-md transition-shadow duration-200">
                    <x-slot:header>
                        <div class="flex items-center gap-2 text-blue-600 dark:text-blue-400">
                            <i class="bi bi-droplet"></i>
                            Ketersediaan Air Bersih
                        </div>
                    </x-slot:header>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="form-label">
                                Keberadaan Air <span class="text-danger">*</span>
                            </label>
                            <div class="flex flex-wrap gap-4 mt-1">
                                <x-form.radio name="air_ada_tidak" value="ada" label="Ada"
                                    :checked="old('air_ada_tidak', $profileSekolah->airBersih?->{'ada/tidak_ada'}) == 'ada'" />
                                <x-form.radio name="air_ada_tidak" value="tidak_ada" label="Tidak Ada"
                                    :checked="old('air_ada_tidak', $profileSekolah->airBersih?->{'ada/tidak_ada'}) == 'tidak_ada'" />
                            </div>
                            @error('air_ada_tidak')
                                <p class="invalid-feedback">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <x-form.select name="air_kondisi" label="Kondisi Air"
                                placeholder="-- Pilih Kondisi --" :options="[
                                    'baik' => 'Baik',
                                    'rusak_ringan' => 'Rusak Ringan',
                                    'rusak_sedang' => 'Rusak Sedang',
                                    'rusak_berat' => 'Rusak Berat',
                                    'nihil' => 'Nihil',
                                ]"
                                :value="old('air_kondisi', $profileSekolah->airBersih?->kodisi)" />
                        </div>
                    </div>
                </x-card>

                <!-- ===== Kelompok: Furnitur & Perangkat ===== -->
                <div class="flex items-center gap-2 pt-2">
                    <i class="bi bi-pc-display text-rose-600 dark:text-rose-400"></i>
                    <h2 class="text-sm sm:text-base font-bold text-rose-600 dark:text-rose-400 whitespace-nowrap">
                        Furnitur & Perangkat
                    </h2>
                    <div class="flex-1 border-t-2 border-rose-200 dark:border-rose-900"></div>
                </div>

                <!-- U. Kursi Siswa -->
                <x-card
                    class="bg-white dark:bg-gray-800 border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-md transition-shadow duration-200">
                    <x-slot:header>
                        <div class="flex items-center gap-2 text-blue-600 dark:text-blue-400">
                            <i class="bi bi-person"></i>
                            Kursi Siswa
                        </div>
                    </x-slot:header>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <x-form.input name="kursi_siswa_baik" label="Jumlah Baik" type="number" min="0" required
                            :value="old('kursi_siswa_baik', $profileSekolah->kursiSiswa?->baik ?? 0)" />
                        <x-form.input name="kursi_siswa_rusak" label="Jumlah Rusak" type="number" min="0" required
                            :value="old('kursi_siswa_rusak', $profileSekolah->kursiSiswa?->rusak ?? 0)" />
                    </div>
                </x-card>

                <!-- V. Meja Siswa -->
                <x-card
                    class="bg-white dark:bg-gray-800 border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-md transition-shadow duration-200">
                    <x-slot:header>
                        <div class="flex items-center gap-2 text-blue-600 dark:text-blue-400">
                            <i class="bi bi-table"></i>
                            Meja Siswa
                        </div>
                    </x-slot:header>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <x-form.input name="meja_siswa_baik" label="Jumlah Baik" type="number" min="0" required
                            :value="old('meja_siswa_baik', $profileSekolah->mejaSiswa?->baik ?? 0)" />
                        <x-form.input name="meja_siswa_rusak" label="Jumlah Rusak" type="number" min="0" required
                            :value="old('meja_siswa_rusak', $profileSekolah->mejaSiswa?->rusak ?? 0)" />
                    </div>
                </x-card>

                <!-- W. Kursi Guru -->
                <x-card
                    class="bg-white dark:bg-gray-800 border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-md transition-shadow duration-200">
                    <x-slot:header>
                        <div class="flex items-center gap-2 text-blue-600 dark:text-blue-400">
                            <i class="bi bi-person-badge"></i>
                            Kursi Guru
                        </div>
                    </x-slot:header>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <x-form.input name="kursi_guru_baik" label="Jumlah Baik" type="number" min="0" required
                            :value="old('kursi_guru_baik', $profileSekolah->kursiGuru?->baik ?? 0)" />
                        <x-form.input name="kursi_guru_rusak" label="Jumlah Rusak" type="number" min="0" required
                            :value="old('kursi_guru_rusak', $profileSekolah->kursiGuru?->rusak ?? 0)" />
                    </div>
                </x-card>

                <!-- X. Meja Guru -->
                <x-card
                    class="bg-white dark:bg-gray-800 border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-md transition-shadow duration-200">
                    <x-slot:header>
                        <div class="flex items-center gap-2 text-blue-600 dark:text-blue-400">
                            <i class="bi bi-table"></i>
                            Meja Guru
                        </div>
                    </x-slot:header>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <x-form.input name="meja_guru_baik" label="Jumlah Baik" type="number" min="0" required
                            :value="old('meja_guru_baik', $profileSekolah->mejaGuru?->baik ?? 0)" />
                        <x-form.input name="meja_guru_rusak" label="Jumlah Rusak" type="number" min="0" required
                            :value="old('meja_guru_rusak', $profileSekolah->mejaGuru?->rusak ?? 0)" />
                    </div>
                </x-card>

                <!-- Y. Laptop -->
                <x-card
                    class="bg-white dark:bg-gray-800 border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-md transition-shadow duration-200">
                    <x-slot:header>
                        <div class="flex items-center gap-2 text-blue-600 dark:text-blue-400">
                            <i class="bi bi-laptop"></i>
                            Laptop
                        </div>
                    </x-slot:header>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <x-form.input name="laptop_baik" label="Jumlah Baik" type="number" min="0" required
                            :value="old('laptop_baik', $profileSekolah->laptop?->baik ?? 0)" />
                        <x-form.input name="laptop_rusak" label="Jumlah Rusak" type="number" min="0" required
                            :value="old('laptop_rusak', $profileSekolah->laptop?->rusak ?? 0)" />
                    </div>
                </x-card>

                <!-- Z. Komputer -->
                <x-card
                    class="bg-white dark:bg-gray-800 border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-md transition-shadow duration-200">
                    <x-slot:header>
                        <div class="flex items-center gap-2 text-blue-600 dark:text-blue-400">
                            <i class="bi bi-pc-display"></i>
                            Komputer
                        </div>
                    </x-slot:header>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <x-form.input name="komputer_baik" label="Jumlah Baik" type="number" min="0" required
                            :value="old('komputer_baik', $profileSekolah->komputer?->baik ?? 0)" />
                        <x-form.input name="komputer_rusak" label="Jumlah Rusak" type="number" min="0" required
                            :value="old('komputer_rusak', $profileSekolah->komputer?->rusak ?? 0)" />
                    </div>
                </x-card>

                <!-- Tombol Aksi (Sticky) -->
                <x-card
                    class="bg-white dark:bg-gray-800 border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-md transition-shadow duration-200 sticky bottom-2 z-20 backdrop-blur">
                    <x-slot:footer>
                        <div class="flex flex-wrap items-center justify-between gap-2">
                            <div class="flex flex-wrap gap-2">
                                <x-button variant="primary" type="submit">
                                    <i class="bi bi-save"></i> Update Data
                                </x-button>
                                <x-button variant="warning" type="reset">
                                    <i class="bi bi-arrow-counterclockwise"></i> Reset
                                </x-button>
                                <a href="{{ route('user.show', $profileSekolah->user_id) }}" class="inline-flex">
                                    <x-button variant="secondary" type="button">
                                        <i class="bi bi-eye me-1"></i> Lihat Detail
                                    </x-button>
                                </a>
                            </div>
                            <a href="{{ route('sarana.index') }}" class="inline-flex">
                                <x-button variant="secondary">
                                    <i class="bi bi-x-circle me-1"></i> Batal
                                </x-button>
                            </a>
                        </div>
                    </x-slot:footer>
                </x-card>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            function setupConditionAuto(radioName, selectId) {
                const radios = document.querySelectorAll(`input[name="${radioName}"]`);
                const select = document.querySelector(`select[name="${selectId}"]`);
                if (!select || radios.length === 0) return;

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
                setupConditionAuto(`${facility}_ada_tidak`, `${facility}_kondisi`);
            });
        });
    </script>
@endpush