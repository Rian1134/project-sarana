@extends('layouts.app')

@section('title', 'Edit Pengajuan')

@section('content')
<div class="container mx-auto px-3 sm:px-4 py-3 sm:py-4">
    <div class="flex flex-col gap-3 sm:gap-4">
        {{-- Header --}}
        <div class="flex flex-wrap items-center justify-between gap-2">
            <h1 class="text-base sm:text-xl font-semibold text-gray-800 dark:text-gray-100 flex items-center gap-2">
                <i class="bi bi-pencil-square"></i>
                <span class="hidden sm:inline">Edit Pengajuan Perubahan Data</span>
                <span class="sm:hidden">Edit Pengajuan</span>
            </h1>
            <a href="{{ route('user.pengajuan.index') }}" class="inline-flex">
                <x-button variant="secondary" size="sm">
                    <i class="bi bi-arrow-left me-1"></i>
                    <span class="hidden sm:inline">Kembali</span>
                    <span class="sm:hidden">Back</span>
                </x-button>
            </a>
        </div>

        @if ($errors->any())
            <x-alert type="danger" dismissible>
                Ada isian yang belum lengkap, silakan periksa kembali.
            </x-alert>
        @endif

        @php
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

            $tipe = $kategoriList[$kategoriTerpilih]['tipe'];
            $fields = $fieldsByTipe[$tipe];

            // Nilai lama cuma relevan kalau kategori yang sedang ditampilkan sama dengan
            // kategori yang tersimpan di database; kalau user baru saja ganti kategori,
            // field di bawah mulai kosong/0.
            $kategoriBerubah = $kategoriTerpilih !== $pengajuan->pengajuan;

            $oldAda = old('perubahan.ada/tidak_ada', $kategoriBerubah ? null : ($pengajuan->perubahan['ada/tidak_ada'] ?? null));
            $oldKodisi = old('perubahan.kodisi', $kategoriBerubah ? null : ($pengajuan->perubahan['kodisi'] ?? null));
        @endphp

        {{-- Ganti kategori lewat form GET (reload halaman dengan `?kategori=...`), tanpa JS. --}}
        <x-card>
            <x-slot:header>
                <div class="flex items-center gap-2 text-blue-600 dark:text-blue-400">
                    <i class="bi bi-arrow-repeat"></i>
                    Ganti Kategori Data
                </div>
            </x-slot:header>

            <form action="{{ route('user.pengajuan.edit', $pengajuan) }}" method="GET" class="flex flex-col sm:flex-row sm:items-end gap-4">
                <div class="flex-1">
                    <x-form.select
                        name="kategori"
                        label="Kategori Data"
                        required
                        :options="collect($kategoriList)->mapWithKeys(fn ($v, $k) => [$k => $v['label']])->all()"
                        :value="$kategoriTerpilih"
                    />
                </div>
                <x-button type="submit" variant="light">Ganti</x-button>
            </form>
        </x-card>

        <form action="{{ route('user.pengajuan.update', $pengajuan) }}" method="POST" class="flex flex-col gap-4">
            @csrf
            @method('PUT')
            <input type="hidden" name="pengajuan" value="{{ $kategoriTerpilih }}">

            <x-card>
                <x-slot:header>
                    <div class="flex items-center gap-2 text-blue-600 dark:text-blue-400">
                        <i class="bi {{ $ikonKategori[$kategoriTerpilih] ?? 'bi-tag' }}"></i>
                        {{ $kategoriList[$kategoriTerpilih]['label'] }}
                    </div>
                </x-slot:header>

                @if ($tipe === 'ada_kondisi')
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="form-label">Keberadaan {{ $kategoriList[$kategoriTerpilih]['label'] }}</label>
                            <div class="flex flex-wrap gap-4 mt-1">
                                <x-form.radio
                                    name="perubahan[ada/tidak_ada]"
                                    value="ada"
                                    label="Ada"
                                    :checked="$oldAda === 'ada'"
                                />
                                <x-form.radio
                                    name="perubahan[ada/tidak_ada]"
                                    value="tidak_ada"
                                    label="Tidak Ada"
                                    :checked="$oldAda === 'tidak_ada'"
                                />
                            </div>
                        </div>

                        <div>
                            <x-form.select
                                name="perubahan[kodisi]"
                                label="Kondisi"
                                placeholder="-- Pilih Kondisi --"
                                :options="['baik' => 'Baik', 'rusak' => 'Rusak', 'nihil' => 'Nihil']"
                                :value="$oldKodisi"
                            />
                        </div>
                    </div>
                @elseif ($tipe === 'siswa_rombel')
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        @foreach ($fields as $field)
                            @php
                                $default = $kategoriBerubah ? null : ($pengajuan->perubahan[$field['name']] ?? null);
                                $oldVal = old('perubahan.' . $field['name'], $default ?? 0);
                            @endphp
                            <x-form.input
                                name="perubahan[{{ $field['name'] }}]"
                                label="{{ $field['label'] }}"
                                type="number"
                                min="0"
                                required
                                :value="$oldVal"
                            />
                        @endforeach
                    </div>
                @elseif ($tipe === 'jumlah')
                    @php
                        $default = $kategoriBerubah ? null : ($pengajuan->perubahan['jumlah'] ?? null);
                        $oldJumlah = old('perubahan.jumlah', $default ?? 0);
                    @endphp
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <x-form.input
                            name="perubahan[jumlah]"
                            label="Jumlah"
                            type="number"
                            min="0"
                            required
                            :value="$oldJumlah"
                        />
                    </div>
                @else {{-- baik_rusak --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach ($fields as $field)
                            @php
                                $default = $kategoriBerubah ? null : ($pengajuan->perubahan[$field['name']] ?? null);
                                $oldVal = old('perubahan.' . $field['name'], $default ?? 0);
                            @endphp
                            <x-form.input
                                name="perubahan[{{ $field['name'] }}]"
                                label="{{ $field['label'] }}"
                                type="number"
                                min="0"
                                required
                                :value="$oldVal"
                            />
                        @endforeach
                    </div>
                @endif
            </x-card>

            <x-card>
                <x-slot:footer>
                    <div class="flex flex-wrap gap-2">
                        <x-button variant="primary" type="submit">
                            <i class="bi bi-save"></i> Simpan Perubahan
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

            @if ($tipe === 'ada_kondisi')
                setupConditionAuto('perubahan[ada/tidak_ada]', 'perubahan[kodisi]');
            @endif
        });
    </script>
@endpush