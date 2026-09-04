@extends('layouts.app')

@section('title')
    Tambah Data Sarana & Prasarana
@endsection

@section('content')
    <div class="container mx-auto px-3 sm:px-4 py-3 sm:py-4">
        <div class="flex flex-col gap-3 sm:gap-4">
            <!-- Header -->
            <div class="flex flex-wrap items-center justify-between gap-2">
                <h1 class="text-base sm:text-xl font-semibold text-gray-800 dark:text-gray-100 flex items-center gap-2">
                    <i class="bi bi-plus-circle"></i>
                    <span class="hidden sm:inline">Form Tambah Data Sarana & Prasarana Sekolah</span>
                    <span class="sm:hidden">Tambah Data</span>
                </h1>
                <a href="{{ route('user.data.index') }}" class="inline-flex">
                    <x-button variant="secondary" size="sm">
                        <i class="bi bi-arrow-left me-1"></i>
                        <span class="hidden sm:inline">Kembali</span>
                        <span class="sm:hidden">Back</span>
                    </x-button>
                </a>
            </div>

            {{-- Alert error validasi sudah ditangani otomatis oleh master layout --}}

            <!-- Form -->
            <form action="{{ route('user.data.store') }}" method="POST" id="saranaForm" class="flex flex-col gap-4">
                @csrf

                <!-- A. Data Sekolah -->
                <x-card>
                    <x-slot:header>
                        <div class="flex items-center gap-2 text-blue-600 dark:text-blue-400">
                            <i class="bi bi-building"></i>
                            A. Data Sekolah
                        </div>
                    </x-slot:header>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <x-form.input
                            name="nama_sekolah"
                            label="Nama Sekolah"
                            placeholder="Masukkan nama sekolah"
                            required
                            :value="old('nama_sekolah')"
                        />

                        <x-form.input
                            name="NPSN"
                            label="NPSN"
                            placeholder="Masukkan NPSN"
                            required
                            :value="old('NPSN')"
                        />

                        <div class="md:col-span-2">
                            <x-form.textarea
                                name="alamat_sekolah"
                                label="Alamat Sekolah"
                                rows="2"
                                placeholder="Masukkan alamat lengkap sekolah"
                                required
                                :value="old('alamat_sekolah')"
                            />
                        </div>

                        <x-form.input
                            name="nama_kepala_sekolah"
                            label="Nama Kepala Sekolah"
                            placeholder="Masukkan nama kepala sekolah"
                            required
                            :value="old('nama_kepala_sekolah')"
                        />

                        <x-form.input
                            name="NIP"
                            label="NIP"
                            placeholder="Masukkan NIP"
                            required
                            :value="old('NIP')"
                        />

                        <x-form.input
                            name="nomor_hp"
                            label="Nomor HP"
                            placeholder="Masukkan nomor HP"
                            required
                            :value="old('nomor_hp')"
                        />
                    </div>
                </x-card>

                <!-- B. Jumlah Siswa -->
                <x-card>
                    <x-slot:header>
                        <div class="flex items-center gap-2 text-blue-600 dark:text-blue-400">
                            <i class="bi-mortarboard"></i>
                            B. Jumlah Siswa
                        </div>
                    </x-slot:header>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <x-form.input name="jumlah_siswa_vii" label="Kelas VII" type="number" min="0" required :value="old('jumlah_siswa_vii', 0)" />
                        <x-form.input name="jumlah_siswa_viii" label="Kelas VIII" type="number" min="0" required :value="old('jumlah_siswa_viii', 0)" />
                        <x-form.input name="jumlah_siswa_ix" label="Kelas IX" type="number" min="0" required :value="old('jumlah_siswa_ix', 0)" />
                    </div>
                </x-card>

                <!-- C. Jumlah Rombongan Belajar -->
                <x-card>
                    <x-slot:header>
                        <div class="flex items-center gap-2 text-blue-600 dark:text-blue-400">
                            <i class="bi-diagram-3"></i>
                            C. Jumlah Rombongan Belajar
                        </div>
                    </x-slot:header>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <x-form.input name="jumlah_rombel_vii" label="Kelas VII" type="number" min="0" required :value="old('jumlah_rombel_vii', 0)" />
                        <x-form.input name="jumlah_rombel_viii" label="Kelas VIII" type="number" min="0" required :value="old('jumlah_rombel_viii', 0)" />
                        <x-form.input name="jumlah_rombel_ix" label="Kelas IX" type="number" min="0" required :value="old('jumlah_rombel_ix', 0)" />
                    </div>
                </x-card>

                <!-- D. RKB (Ruang Kelas Baru) -->
                <x-card>
                    <x-slot:header>
                        <div class="flex items-center gap-2 text-blue-600 dark:text-blue-400">
                            <i class="bi-building-add"></i>
                            D. Pembangunan Ruang Kelas Baru (RKB)
                        </div>
                    </x-slot:header>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                        <x-form.input name="rkb_jumlah" label="Jumlah" type="number" min="0" required :value="old('rkb_jumlah', 0)" />
                        <div class="md:col-span-2 flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400 pb-2">
                            <i class="bi bi-calendar-range"></i>
                            Periode pelaporan:
                            <x-badge variant="secondary">{{ $rkbPeriode->label() }}</x-badge>
                            <span class="text-xs text-gray-400">(diatur admin, berlaku untuk semua sekolah)</span>
                        </div>
                    </div>
                </x-card>

                <!-- E. Rehabilitasi Ruang Kelas -->
                <x-card>
                    <x-slot:header>
                        <div class="flex items-center gap-2 text-blue-600 dark:text-blue-400">
                            <i class="bi-tools"></i>
                            E. Rehabilitasi Ruang Kelas
                        </div>
                    </x-slot:header>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                        <x-form.input name="rehabilitasi_jumlah" label="Jumlah" type="number" min="0" required :value="old('rehabilitasi_jumlah', 0)" />
                        <div class="md:col-span-2 flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400 pb-2">
                            <i class="bi bi-calendar-range"></i>
                            Periode pelaporan:
                            <x-badge variant="secondary">{{ $rehabilitasiPeriode->label() }}</x-badge>
                            <span class="text-xs text-gray-400">(diatur admin, berlaku untuk semua sekolah)</span>
                        </div>
                    </div>
                </x-card>

                <!-- F. Ruang Kelas -->
                <x-card>
                    <x-slot:header>
                        <div class="flex items-center gap-2 text-blue-600 dark:text-blue-400">
                            <i class="bi-door-closed"></i>
                            F. Ruang Kelas
                        </div>
                    </x-slot:header>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <x-form.input name="ruang_kelas_bagus" label="Jumlah Baik" type="number" min="0" required :value="old('ruang_kelas_bagus', 0)" />
                        <x-form.input name="ruang_kelas_rusak" label="Jumlah Rusak" type="number" min="0" required :value="old('ruang_kelas_rusak', 0)" />
                    </div>
                </x-card>

                <!-- G. Toilet Siswa -->
                <x-card>
                    <x-slot:header>
                        <div class="flex items-center gap-2 text-blue-600 dark:text-blue-400">
                            <i class="bi-droplet-half"></i>
                            G. Toilet Siswa
                        </div>
                    </x-slot:header>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <x-form.input name="toilet_siswa_bagus" label="Jumlah Baik" type="number" min="0" required :value="old('toilet_siswa_bagus', 0)" />
                        <x-form.input name="toilet_siswa_rusak" label="Jumlah Rusak" type="number" min="0" required :value="old('toilet_siswa_rusak', 0)" />
                    </div>
                </x-card>

                <!-- H. Toilet Guru -->
                <x-card>
                    <x-slot:header>
                        <div class="flex items-center gap-2 text-blue-600 dark:text-blue-400">
                            <i class="bi-droplet"></i>
                            H. Toilet Guru
                        </div>
                    </x-slot:header>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <x-form.input name="toilet_guru_bagus" label="Jumlah Baik" type="number" min="0" required :value="old('toilet_guru_bagus', 0)" />
                        <x-form.input name="toilet_guru_rusak" label="Jumlah Rusak" type="number" min="0" required :value="old('toilet_guru_rusak', 0)" />
                    </div>
                </x-card>

                <!-- I. Ruang Perpustakaan -->
                <x-card>
                    <x-slot:header>
                        <div class="flex items-center gap-2 text-blue-600 dark:text-blue-400">
                            <i class="bi-book"></i>
                            I. Ruang Perpustakaan
                        </div>
                    </x-slot:header>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="form-label">
                                Keberadaan Ruang Perpustakaan <span class="text-danger">*</span>
                            </label>
                            <div class="flex flex-wrap gap-4 mt-1">
                                <x-form.radio name="perpustakaan_ada_tidak" value="ada" label="Ada" :checked="old('perpustakaan_ada_tidak') == 'ada'" required />
                                <x-form.radio name="perpustakaan_ada_tidak" value="tidak_ada" label="Tidak Ada" :checked="old('perpustakaan_ada_tidak') == 'tidak_ada'" />
                            </div>
                            @error('perpustakaan_ada_tidak')
                                <p class="invalid-feedback">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <x-form.select
                                name="perpustakaan_kondisi"
                                label="Kondisi Ruang Perpustakaan"
                                placeholder="-- Pilih Kondisi --"
                                :options="['bagus' => 'Bagus', 'rusak' => 'Rusak', 'nihil' => 'Nihil']"
                                :value="old('perpustakaan_kondisi')"
                            />
                        </div>
                    </div>
                </x-card>

                <!-- J. Ruang Kepala Sekolah -->
                <x-card>
                    <x-slot:header>
                        <div class="flex items-center gap-2 text-blue-600 dark:text-blue-400">
                            <i class="bi-person-workspace"></i>
                            J. Ruang Kepala Sekolah
                        </div>
                    </x-slot:header>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="form-label">
                                Keberadaan Ruang Kepala Sekolah <span class="text-danger">*</span>
                            </label>
                            <div class="flex flex-wrap gap-4 mt-1">
                                <x-form.radio name="kepala_sekolah_ada_tidak" value="ada" label="Ada" :checked="old('kepala_sekolah_ada_tidak') == 'ada'" required />
                                <x-form.radio name="kepala_sekolah_ada_tidak" value="tidak_ada" label="Tidak Ada" :checked="old('kepala_sekolah_ada_tidak') == 'tidak_ada'" />
                            </div>
                            @error('kepala_sekolah_ada_tidak')
                                <p class="invalid-feedback">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <x-form.select
                                name="kepala_sekolah_kondisi"
                                label="Kondisi Ruang Kepala Sekolah"
                                placeholder="-- Pilih Kondisi --"
                                :options="['bagus' => 'Bagus', 'rusak' => 'Rusak', 'nihil' => 'Nihil']"
                                :value="old('kepala_sekolah_kondisi')"
                            />
                        </div>
                    </div>
                </x-card>

                <!-- K. Ruang Guru -->
                <x-card>
                    <x-slot:header>
                        <div class="flex items-center gap-2 text-blue-600 dark:text-blue-400">
                            <i class="bi-easel2"></i>
                            K. Ruang Guru
                        </div>
                    </x-slot:header>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="form-label">
                                Keberadaan Ruang Guru <span class="text-danger">*</span>
                            </label>
                            <div class="flex flex-wrap gap-4 mt-1">
                                <x-form.radio name="ruang_guru_ada_tidak" value="ada" label="Ada" :checked="old('ruang_guru_ada_tidak') == 'ada'" required />
                                <x-form.radio name="ruang_guru_ada_tidak" value="tidak_ada" label="Tidak Ada" :checked="old('ruang_guru_ada_tidak') == 'tidak_ada'" />
                            </div>
                            @error('ruang_guru_ada_tidak')
                                <p class="invalid-feedback">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <x-form.select
                                name="ruang_guru_kondisi"
                                label="Kondisi Ruang Guru"
                                placeholder="-- Pilih Kondisi --"
                                :options="['bagus' => 'Bagus', 'rusak' => 'Rusak', 'nihil' => 'Nihil']"
                                :value="old('ruang_guru_kondisi')"
                            />
                        </div>
                    </div>
                </x-card>

                <!-- L. Ruang Kantor/Tata Usaha -->
                <x-card>
                    <x-slot:header>
                        <div class="flex items-center gap-2 text-blue-600 dark:text-blue-400">
                            <i class="bi-briefcase"></i>
                            L. Ruang Kantor/Tata Usaha
                        </div>
                    </x-slot:header>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="form-label">
                                Keberadaan Ruang Kantor/Tata Usaha <span class="text-danger">*</span>
                            </label>
                            <div class="flex flex-wrap gap-4 mt-1">
                                <x-form.radio name="kantor_tu_ada_tidak" value="ada" label="Ada" :checked="old('kantor_tu_ada_tidak') == 'ada'" required />
                                <x-form.radio name="kantor_tu_ada_tidak" value="tidak_ada" label="Tidak Ada" :checked="old('kantor_tu_ada_tidak') == 'tidak_ada'" />
                            </div>
                            @error('kantor_tu_ada_tidak')
                                <p class="invalid-feedback">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <x-form.select
                                name="kantor_tu_kondisi"
                                label="Kondisi Ruang Kantor/Tata Usaha"
                                placeholder="-- Pilih Kondisi --"
                                :options="['bagus' => 'Bagus', 'rusak' => 'Rusak', 'nihil' => 'Nihil']"
                                :value="old('kantor_tu_kondisi')"
                            />
                        </div>
                    </div>
                </x-card>

                <!-- M. Lab IPA -->
                <x-card>
                    <x-slot:header>
                        <div class="flex items-center gap-2 text-blue-600 dark:text-blue-400">
                            <i class="bi-flask"></i>
                            M. Lab IPA
                        </div>
                    </x-slot:header>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="form-label">
                                Keberadaan Lab IPA <span class="text-danger">*</span>
                            </label>
                            <div class="flex flex-wrap gap-4 mt-1">
                                <x-form.radio name="lab_ipa_ada_tidak" value="ada" label="Ada" :checked="old('lab_ipa_ada_tidak') == 'ada'" required />
                                <x-form.radio name="lab_ipa_ada_tidak" value="tidak_ada" label="Tidak Ada" :checked="old('lab_ipa_ada_tidak') == 'tidak_ada'" />
                            </div>
                            @error('lab_ipa_ada_tidak')
                                <p class="invalid-feedback">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <x-form.select
                                name="lab_ipa_kondisi"
                                label="Kondisi Lab IPA"
                                placeholder="-- Pilih Kondisi --"
                                :options="['bagus' => 'Bagus', 'rusak' => 'Rusak', 'nihil' => 'Nihil']"
                                :value="old('lab_ipa_kondisi')"
                            />
                        </div>
                    </div>
                </x-card>

                <!-- N. Lab Komputer -->
                <x-card>
                    <x-slot:header>
                        <div class="flex items-center gap-2 text-blue-600 dark:text-blue-400">
                            <i class="bi-pc-display-horizontal"></i>
                            N. Lab Komputer
                        </div>
                    </x-slot:header>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="form-label">
                                Keberadaan Lab Komputer <span class="text-danger">*</span>
                            </label>
                            <div class="flex flex-wrap gap-4 mt-1">
                                <x-form.radio name="lab_komputer_ada_tidak" value="ada" label="Ada" :checked="old('lab_komputer_ada_tidak') == 'ada'" required />
                                <x-form.radio name="lab_komputer_ada_tidak" value="tidak_ada" label="Tidak Ada" :checked="old('lab_komputer_ada_tidak') == 'tidak_ada'" />
                            </div>
                            @error('lab_komputer_ada_tidak')
                                <p class="invalid-feedback">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <x-form.select
                                name="lab_komputer_kondisi"
                                label="Kondisi Lab Komputer"
                                placeholder="-- Pilih Kondisi --"
                                :options="['bagus' => 'Bagus', 'rusak' => 'Rusak', 'nihil' => 'Nihil']"
                                :value="old('lab_komputer_kondisi')"
                            />
                        </div>
                    </div>
                </x-card>

                <!-- O. UKS -->
                <x-card>
                    <x-slot:header>
                        <div class="flex items-center gap-2 text-blue-600 dark:text-blue-400">
                            <i class="bi-heart-pulse"></i>
                            O. UKS
                        </div>
                    </x-slot:header>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="form-label">
                                Keberadaan UKS <span class="text-danger">*</span>
                            </label>
                            <div class="flex flex-wrap gap-4 mt-1">
                                <x-form.radio name="uks_ada_tidak" value="ada" label="Ada" :checked="old('uks_ada_tidak') == 'ada'" required />
                                <x-form.radio name="uks_ada_tidak" value="tidak_ada" label="Tidak Ada" :checked="old('uks_ada_tidak') == 'tidak_ada'" />
                            </div>
                            @error('uks_ada_tidak')
                                <p class="invalid-feedback">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <x-form.select
                                name="uks_kondisi"
                                label="Kondisi UKS"
                                placeholder="-- Pilih Kondisi --"
                                :options="['bagus' => 'Bagus', 'rusak' => 'Rusak', 'nihil' => 'Nihil']"
                                :value="old('uks_kondisi')"
                            />
                        </div>
                    </div>
                </x-card>

                <!-- P. Rumah Dinas -->
                <x-card>
                    <x-slot:header>
                        <div class="flex items-center gap-2 text-blue-600 dark:text-blue-400">
                            <i class="bi-house-door"></i>
                            P. Rumah Dinas
                        </div>
                    </x-slot:header>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="form-label">
                                Keberadaan Rumah Dinas <span class="text-danger">*</span>
                            </label>
                            <div class="flex flex-wrap gap-4 mt-1">
                                <x-form.radio name="rumah_dinas_ada_tidak" value="ada" label="Ada" :checked="old('rumah_dinas_ada_tidak') == 'ada'" required />
                                <x-form.radio name="rumah_dinas_ada_tidak" value="tidak_ada" label="Tidak Ada" :checked="old('rumah_dinas_ada_tidak') == 'tidak_ada'" />
                            </div>
                            @error('rumah_dinas_ada_tidak')
                                <p class="invalid-feedback">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <x-form.select
                                name="rumah_dinas_kondisi"
                                label="Kondisi Rumah Dinas"
                                placeholder="-- Pilih Kondisi --"
                                :options="['bagus' => 'Bagus', 'rusak' => 'Rusak', 'nihil' => 'Nihil']"
                                :value="old('rumah_dinas_kondisi')"
                            />
                        </div>
                    </div>
                </x-card>

                <!-- Q. Rumah Ibadah -->
                <x-card>
                    <x-slot:header>
                        <div class="flex items-center gap-2 text-blue-600 dark:text-blue-400">
                            <i class="bi-building"></i>
                            Q. Rumah Ibadah
                        </div>
                    </x-slot:header>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="form-label">
                                Keberadaan Rumah Ibadah <span class="text-danger">*</span>
                            </label>
                            <div class="flex flex-wrap gap-4 mt-1">
                                <x-form.radio name="rumah_ibadah_ada_tidak" value="ada" label="Ada" :checked="old('rumah_ibadah_ada_tidak') == 'ada'" required />
                                <x-form.radio name="rumah_ibadah_ada_tidak" value="tidak_ada" label="Tidak Ada" :checked="old('rumah_ibadah_ada_tidak') == 'tidak_ada'" />
                            </div>
                            @error('rumah_ibadah_ada_tidak')
                                <p class="invalid-feedback">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <x-form.select
                                name="rumah_ibadah_kondisi"
                                label="Kondisi Rumah Ibadah"
                                placeholder="-- Pilih Kondisi --"
                                :options="['bagus' => 'Bagus', 'rusak' => 'Rusak', 'nihil' => 'Nihil']"
                                :value="old('rumah_ibadah_kondisi')"
                            />
                        </div>
                    </div>
                </x-card>

                <!-- R. Lapangan Sekolah -->
                <x-card>
                    <x-slot:header>
                        <div class="flex items-center gap-2 text-blue-600 dark:text-blue-400">
                            <i class="bi-flag"></i>
                            R. Lapangan Sekolah
                        </div>
                    </x-slot:header>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="form-label">
                                Keberadaan Lapangan Sekolah <span class="text-danger">*</span>
                            </label>
                            <div class="flex flex-wrap gap-4 mt-1">
                                <x-form.radio name="lapangan_sekolah_ada_tidak" value="ada" label="Ada" :checked="old('lapangan_sekolah_ada_tidak') == 'ada'" required />
                                <x-form.radio name="lapangan_sekolah_ada_tidak" value="tidak_ada" label="Tidak Ada" :checked="old('lapangan_sekolah_ada_tidak') == 'tidak_ada'" />
                            </div>
                            @error('lapangan_sekolah_ada_tidak')
                                <p class="invalid-feedback">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <x-form.select
                                name="lapangan_sekolah_kondisi"
                                label="Kondisi Lapangan Sekolah"
                                placeholder="-- Pilih Kondisi --"
                                :options="['bagus' => 'Bagus', 'rusak' => 'Rusak', 'nihil' => 'Nihil']"
                                :value="old('lapangan_sekolah_kondisi')"
                            />
                        </div>
                    </div>
                </x-card>

                <!-- S. Pagar -->
                <x-card>
                    <x-slot:header>
                        <div class="flex items-center gap-2 text-blue-600 dark:text-blue-400">
                            <i class="bi-border-all"></i>
                            S. Pagar
                        </div>
                    </x-slot:header>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="form-label">
                                Keberadaan Pagar <span class="text-danger">*</span>
                            </label>
                            <div class="flex flex-wrap gap-4 mt-1">
                                <x-form.radio name="pagar_ada_tidak" value="ada" label="Ada" :checked="old('pagar_ada_tidak') == 'ada'" required />
                                <x-form.radio name="pagar_ada_tidak" value="tidak_ada" label="Tidak Ada" :checked="old('pagar_ada_tidak') == 'tidak_ada'" />
                            </div>
                            @error('pagar_ada_tidak')
                                <p class="invalid-feedback">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <x-form.select
                                name="pagar_kondisi"
                                label="Kondisi Pagar"
                                placeholder="-- Pilih Kondisi --"
                                :options="['bagus' => 'Bagus', 'rusak' => 'Rusak', 'nihil' => 'Nihil']"
                                :value="old('pagar_kondisi')"
                            />
                        </div>
                    </div>
                </x-card>

                <!-- T. Air -->
                <x-card>
                    <x-slot:header>
                        <div class="flex items-center gap-2 text-blue-600 dark:text-blue-400">
                            <i class="bi-droplet"></i>
                            T. Air
                        </div>
                    </x-slot:header>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="form-label">
                                Keberadaan Air <span class="text-danger">*</span>
                            </label>
                            <div class="flex flex-wrap gap-4 mt-1">
                                <x-form.radio name="air_ada_tidak" value="ada" label="Ada" :checked="old('air_ada_tidak') == 'ada'" required />
                                <x-form.radio name="air_ada_tidak" value="tidak_ada" label="Tidak Ada" :checked="old('air_ada_tidak') == 'tidak_ada'" />
                            </div>
                            @error('air_ada_tidak')
                                <p class="invalid-feedback">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <x-form.select
                                name="air_kondisi"
                                label="Kondisi Air"
                                placeholder="-- Pilih Kondisi --"
                                :options="['bagus' => 'Bagus', 'rusak' => 'Rusak', 'nihil' => 'Nihil']"
                                :value="old('air_kondisi')"
                            />
                        </div>
                    </div>
                </x-card>

                <!-- U. Kursi Siswa -->
                <x-card>
                    <x-slot:header>
                        <div class="flex items-center gap-2 text-blue-600 dark:text-blue-400">
                            <i class="bi-person"></i>
                            U. Kursi Siswa
                        </div>
                    </x-slot:header>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <x-form.input name="kursi_siswa_bagus" label="Jumlah Baik" type="number" min="0" required :value="old('kursi_siswa_bagus', 0)" />
                        <x-form.input name="kursi_siswa_rusak" label="Jumlah Rusak" type="number" min="0" required :value="old('kursi_siswa_rusak', 0)" />
                    </div>
                </x-card>

                <!-- V. Meja Siswa -->
                <x-card>
                    <x-slot:header>
                        <div class="flex items-center gap-2 text-blue-600 dark:text-blue-400">
                            <i class="bi-table"></i>
                            V. Meja Siswa
                        </div>
                    </x-slot:header>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <x-form.input name="meja_siswa_bagus" label="Jumlah Baik" type="number" min="0" required :value="old('meja_siswa_bagus', 0)" />
                        <x-form.input name="meja_siswa_rusak" label="Jumlah Rusak" type="number" min="0" required :value="old('meja_siswa_rusak', 0)" />
                    </div>
                </x-card>

                <!-- W. Kursi Guru -->
                <x-card>
                    <x-slot:header>
                        <div class="flex items-center gap-2 text-blue-600 dark:text-blue-400">
                            <i class="bi-person-badge"></i>
                            W. Kursi Guru
                        </div>
                    </x-slot:header>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <x-form.input name="kursi_guru_bagus" label="Jumlah Baik" type="number" min="0" required :value="old('kursi_guru_bagus', 0)" />
                        <x-form.input name="kursi_guru_rusak" label="Jumlah Rusak" type="number" min="0" required :value="old('kursi_guru_rusak', 0)" />
                    </div>
                </x-card>

                <!-- X. Meja Guru -->
                <x-card>
                    <x-slot:header>
                        <div class="flex items-center gap-2 text-blue-600 dark:text-blue-400">
                            <i class="bi-table"></i>
                            X. Meja Guru
                        </div>
                    </x-slot:header>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <x-form.input name="meja_guru_bagus" label="Jumlah Baik" type="number" min="0" required :value="old('meja_guru_bagus', 0)" />
                        <x-form.input name="meja_guru_rusak" label="Jumlah Rusak" type="number" min="0" required :value="old('meja_guru_rusak', 0)" />
                    </div>
                </x-card>

                <!-- Y. Laptop -->
                <x-card>
                    <x-slot:header>
                        <div class="flex items-center gap-2 text-blue-600 dark:text-blue-400">
                            <i class="bi-laptop"></i>
                            Y. Laptop
                        </div>
                    </x-slot:header>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <x-form.input name="laptop_bagus" label="Jumlah Baik" type="number" min="0" required :value="old('laptop_bagus', 0)" />
                        <x-form.input name="laptop_rusak" label="Jumlah Rusak" type="number" min="0" required :value="old('laptop_rusak', 0)" />
                    </div>
                </x-card>

                <!-- Z. Komputer -->
                <x-card>
                    <x-slot:header>
                        <div class="flex items-center gap-2 text-blue-600 dark:text-blue-400">
                            <i class="bi-pc-display"></i>
                            Z. Komputer
                        </div>
                    </x-slot:header>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <x-form.input name="komputer_bagus" label="Jumlah Baik" type="number" min="0" required :value="old('komputer_bagus', 0)" />
                        <x-form.input name="komputer_rusak" label="Jumlah Rusak" type="number" min="0" required :value="old('komputer_rusak', 0)" />
                    </div>
                </x-card>

                <!-- AA. Chromebook -->
                <x-card>
                    <x-slot:header>
                        <div class="flex items-center gap-2 text-blue-600 dark:text-blue-400">
                            <i class="bi-laptop"></i>
                            AA. Chromebook
                        </div>
                    </x-slot:header>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <x-form.input name="chromebook_bagus" label="Jumlah Baik" type="number" min="0" required :value="old('chromebook_bagus', 0)" />
                        <x-form.input name="chromebook_rusak" label="Jumlah Rusak" type="number" min="0" required :value="old('chromebook_rusak', 0)" />
                    </div>
                </x-card>

                <!-- Tombol Aksi -->
                <x-card>
                    <x-slot:footer>
                        <div class="flex flex-wrap gap-2">
                            <x-button variant="primary" type="submit">
                                <i class="bi bi-save"></i> Simpan Data
                            </x-button>
                            <x-button variant="warning" type="reset">
                                <i class="bi bi-arrow-counterclockwise"></i> Reset
                            </x-button>
                            <a href="{{ route('user.data.index') }}" class="inline-flex">
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
            // Fungsi untuk mengatur kondisi otomatis
            function setupConditionAuto(radioName, selectId) {
                const radios = document.querySelectorAll(`input[name="${radioName}"]`);
                const select = document.querySelector(`select[name="${selectId}"]`);
                if (!select || radios.length === 0) return; // jaga-jaga elemen belum ada / id salah ketik

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

                // Cek kondisi awal
                const checked = document.querySelector(`input[name="${radioName}"]:checked`);
                if (checked && checked.value === 'tidak_ada') {
                    select.value = 'nihil';
                    select.disabled = true;
                }
            }

            // Setup untuk Pagar dan Air Bersih
            setupConditionAuto('perpustakaan_ada_tidak', 'perpustakaan_kondisi');
            setupConditionAuto('kepala_sekolah_ada_tidak', 'kepala_sekolah_kondisi');
            setupConditionAuto('ruang_guru_ada_tidak', 'ruang_guru_kondisi');
            setupConditionAuto('kantor_tu_ada_tidak', 'kantor_tu_kondisi');
            setupConditionAuto('lab_ipa_ada_tidak', 'lab_ipa_kondisi');
            setupConditionAuto('lab_komputer_ada_tidak', 'lab_komputer_kondisi');
            setupConditionAuto('uks_ada_tidak', 'uks_kondisi');
            setupConditionAuto('rumah_dinas_ada_tidak', 'rumah_dinas_kondisi');
            setupConditionAuto('rumah_ibadah_ada_tidak', 'rumah_ibadah_kondisi');
            setupConditionAuto('lapangan_sekolah_ada_tidak', 'lapangan_sekolah_kondisi');
            setupConditionAuto('pagar_ada_tidak', 'pagar_kondisi');
            setupConditionAuto('air_ada_tidak', 'air_kondisi');
        });
    </script>
@endpush