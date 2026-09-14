@extends('layouts.app')

@section('title', 'Ajukan Perubahan Data')

@section('content')
<div class="container mx-auto px-3 sm:px-4 py-3 sm:py-4">
    <div class="flex flex-col gap-3 sm:gap-4">
        {{-- Header --}}
        <div class="flex flex-wrap items-center justify-between gap-2">
            <h1 class="text-base sm:text-xl font-semibold text-gray-800 dark:text-gray-100 flex items-center gap-2">
                <i class="bi bi-plus-circle"></i>
                <span class="hidden sm:inline">Form Ajukan Perubahan Data Sarana & Prasarana</span>
                <span class="sm:hidden">Ajukan Perubahan</span>
            </h1>
            <a href="{{ route('user.pengajuan.index') }}" class="inline-flex">
                <x-button variant="secondary" size="sm">
                    <i class="bi bi-arrow-left me-1"></i>
                    <span class="hidden sm:inline">Kembali</span>
                    <span class="sm:hidden">Back</span>
                </x-button>
            </a>
        </div>

        <p class="text-sm text-gray-500 dark:text-gray-400">
            Centang kategori data yang ingin diajukan perubahannya, isi nilai barunya, lalu kirim.
            Anda bisa mengajukan beberapa kategori sekaligus dalam satu pengiriman.
        </p>

        @if ($errors->any())
            <x-alert type="danger" dismissible>
                Ada isian yang belum lengkap, silakan periksa kembali kategori yang Anda centang.
            </x-alert>
        @endif

        @php
            // Ikon per kategori, sekadar polesan visual biar konsisten dengan form
            // Tambah Data Sarpras. Kategori yang tidak ada di daftar ini pakai ikon default.
            $ikonKategori = [
                'jumlah_siswa' => 'bi-mortarboard',
                'jumlah_rombel' => 'bi-diagram-3',
                'ruang_kelas_baru' => 'bi-building-add',
                'rehabilitasi_ruang_kelas' => 'bi-tools',
                'ruang_kelas' => 'bi-door-closed',
                'ruang_guru' => 'bi-easel2',
                'ruang_kepala_sekolah' => 'bi-person-workspace',
                'ruang_kantor_tu' => 'bi-briefcase',
                'ruang_perpustakaan' => 'bi-book',
                'lab_ipa' => 'bi-flask',
                'lab_komputer' => 'bi-pc-display-horizontal',
                'toilet_siswa' => 'bi-droplet-half',
                'toilet_guru' => 'bi-droplet',
                'meja_siswa' => 'bi-table',
                'meja_guru' => 'bi-table',
                'kursi_siswa' => 'bi-person',
                'kursi_guru' => 'bi-person-badge',
                'komputer' => 'bi-pc-display',
                'laptop' => 'bi-laptop',
                'chromebook' => 'bi-laptop',
                'unit_kesehatan_sekolah' => 'bi-heart-pulse',
                'lapangan_sekolah' => 'bi-flag',
                'pagar_sekolah' => 'bi-border-all',
                'air_bersih' => 'bi-droplet',
                'rumah_dinas' => 'bi-house-door',
                'rumah_ibadah' => 'bi-building',
            ];
        @endphp

        <form action="{{ route('user.pengajuan.store') }}" method="POST" id="pengajuanForm" class="flex flex-col gap-4">
            @csrf

            @foreach ($kategoriList as $key => $kat)
                @php
                    $fields = $fieldsByTipe[$kat['tipe']];

                    // Ambil old() dengan string concatenation biasa (bukan interpolasi
                    // ber-quote di dalam atribut Blade) supaya tidak ada masalah
                    // escaping tanda kutip yang bikin komponen x-form.* gagal render.
                    $oldPilih = old('pilih.' . $key);
                    $oldAda = old('perubahan.' . $key . '.ada/tidak_ada');
                    $oldKodisi = old('perubahan.' . $key . '.kodisi');
                @endphp

                <x-card>
                    <x-slot:header>
                        <div class="flex flex-wrap items-center justify-between gap-2">
                            <div class="flex items-center gap-2 text-blue-600 dark:text-blue-400">
                                <i class="bi {{ $ikonKategori[$key] ?? 'bi-tag' }}"></i>
                                {{ $kat['label'] }}
                            </div>
                            <x-form.checkbox
                                name="pilih[{{ $key }}]"
                                value="1"
                                label="Sertakan dalam pengajuan"
                                :checked="$oldPilih"
                            />
                        </div>
                    </x-slot:header>

                    @if ($kat['tipe'] === 'ada_kondisi')
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="form-label">Keberadaan {{ $kat['label'] }}</label>
                                <div class="flex flex-wrap gap-4 mt-1">
                                    <x-form.radio
                                        name="perubahan[{{ $key }}][ada/tidak_ada]"
                                        value="ada"
                                        label="Ada"
                                        :checked="$oldAda === 'ada'"
                                    />
                                    <x-form.radio
                                        name="perubahan[{{ $key }}][ada/tidak_ada]"
                                        value="tidak_ada"
                                        label="Tidak Ada"
                                        :checked="$oldAda === 'tidak_ada'"
                                    />
                                </div>
                            </div>

                            <div>
                                <x-form.select
                                    name="perubahan[{{ $key }}][kodisi]"
                                    label="Kondisi"
                                    placeholder="-- Pilih Kondisi --"
                                    :options="['baik' => 'Baik', 'rusak' => 'Rusak', 'nihil' => 'Nihil']"
                                    :value="$oldKodisi"
                                />
                            </div>
                        </div>
                    @elseif ($kat['tipe'] === 'siswa_rombel')
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            @foreach ($fields as $field)
                                @php $oldVal = old('perubahan.' . $key . '.' . $field['name'], 0); @endphp
                                <x-form.input
                                    name="perubahan[{{ $key }}][{{ $field['name'] }}]"
                                    label="{{ $field['label'] }}"
                                    type="number"
                                    min="0"
                                    :value="$oldVal"
                                />
                            @endforeach
                        </div>
                    @elseif ($kat['tipe'] === 'jumlah')
                        @php $oldJumlah = old('perubahan.' . $key . '.jumlah', 0); @endphp
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <x-form.input
                                name="perubahan[{{ $key }}][jumlah]"
                                label="Jumlah"
                                type="number"
                                min="0"
                                :value="$oldJumlah"
                            />
                        </div>
                    @else {{-- baik_rusak --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach ($fields as $field)
                                @php $oldVal = old('perubahan.' . $key . '.' . $field['name'], 0); @endphp
                                <x-form.input
                                    name="perubahan[{{ $key }}][{{ $field['name'] }}]"
                                    label="{{ $field['label'] }}"
                                    type="number"
                                    min="0"
                                    :value="$oldVal"
                                />
                            @endforeach
                        </div>
                    @endif
                </x-card>
            @endforeach

            {{-- Tombol Aksi --}}
            <x-card>
                <x-slot:footer>
                    <div class="flex flex-wrap gap-2">
                        <x-button variant="primary" type="submit">
                            <i class="bi bi-send"></i> Kirim Pengajuan
                        </x-button>
                        <x-button variant="warning" type="reset">
                            <i class="bi bi-arrow-counterclockwise"></i> Reset
                        </x-button>
                        <a href="{{ route('user.pengajuan.index') }}" class="inline-flex">
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
        document.addEventListener('DOMContentLoaded', function () {
            // Kalau radio "Tidak Ada" dipilih, kondisi otomatis dikunci ke "Nihil".
            // Sengaja TIDAK memakai select.disabled = true, karena input yang disabled
            // tidak ikut terkirim saat form di-submit (validasi server jadi gagal).
            // Dikunci secara visual saja, nilainya tetap terkirim.
            function setupConditionAuto(radioName, selectName) {
                const radios = document.querySelectorAll(`input[name="${radioName}"]`);
                const select = document.querySelector(`select[name="${selectName}"]`);
                if (!select || radios.length === 0) return;

                function lock() {
                    select.value = 'nihil';
                    select.setAttribute('aria-disabled', 'true');
                    select.classList.add('opacity-60', 'pointer-events-none');
                }
                function unlock() {
                    select.removeAttribute('aria-disabled');
                    select.classList.remove('opacity-60', 'pointer-events-none');
                    if (select.value === 'nihil') {
                        select.value = '';
                    }
                }

                radios.forEach(radio => {
                    radio.addEventListener('change', function () {
                        this.value === 'tidak_ada' ? lock() : unlock();
                    });
                });

                const checked = document.querySelector(`input[name="${radioName}"]:checked`);
                if (checked && checked.value === 'tidak_ada') {
                    lock();
                }
            }

            @foreach ($kategoriList as $key => $kat)
                @if ($kat['tipe'] === 'ada_kondisi')
                    setupConditionAuto('perubahan[{{ $key }}][ada/tidak_ada]', 'perubahan[{{ $key }}][kodisi]');
                @endif
            @endforeach
        });
    </script>
@endpush