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

        <p class="text-sm text-gray-500 dark:text-gray-400">
            Kategori yang sudah diajukan sebelumnya otomatis terbuka & terisi (tidak bisa dihapus dari
            sini). Untuk menambah kategori lain, pilih dari dropdown "Tambah Kategori" di bawah.
        </p>

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

            $perubahanTersimpan = $pengajuan->perubahan ?? [];
            $kategoriTersimpan = is_array($pengajuan->pengajuan) ? $pengajuan->pengajuan : array_filter([$pengajuan->pengajuan]);
        @endphp

        <form action="{{ route('user.pengajuan.update', $pengajuan) }}" method="POST" id="pengajuanForm" class="flex flex-col gap-4">
            @csrf
            @method('PUT')

            {{-- Judul Perubahan: dari kolom `judul` sendiri, bukan dari `perubahan`. --}}
            <x-card>
                <x-slot:header>
                    <div class="flex items-center gap-2 text-blue-600 dark:text-blue-400">
                        <i class="bi bi-card-heading"></i>
                        Judul Perubahan
                    </div>
                </x-slot:header>

                <x-form.input
                    name="judul_perubahan"
                    label="Judul Perubahan"
                    placeholder="Contoh: Penambahan ruang musik hasil swadaya masyarakat"
                    required
                    :value="old('judul_perubahan', $pengajuan->judul)"
                />
            </x-card>

            {{-- Tambah Kategori: dipakai untuk menambah kategori BARU yang belum ada
                 di pengajuan ini. Kategori yang sudah tersimpan otomatis tampil di
                 bawah dan tidak muncul lagi di dropdown ini. --}}
            <x-card>
                <x-slot:header>
                    <div class="flex items-center gap-2 text-blue-600 dark:text-blue-400">
                        <i class="bi bi-plus-square"></i>
                        Tambah Kategori
                    </div>
                </x-slot:header>

                <div class="flex flex-col sm:flex-row gap-2">
                    <select
                        id="pilihKategoriSelect"
                        class="w-full sm:flex-1 rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 text-sm focus:ring-blue-500 focus:border-blue-500"
                    >
                        <option value="">-- Pilih Kategori --</option>
                        @foreach ($kategoriList as $key => $kat)
                            <option value="{{ $key }}">{{ $kat['label'] }}</option>
                        @endforeach
                    </select>
                    <x-button type="button" variant="primary" id="btnTambahKategori">
                        <i class="bi bi-plus-lg"></i> Tambah
                    </x-button>
                </div>

                <p class="text-xs text-gray-400 mt-2" id="pesanBelumAdaKategori">
                    Belum ada kategori tambahan yang ditambahkan.
                </p>
            </x-card>

            @foreach ($kategoriList as $key => $kat)
                @php
                    $fields = $fieldsByTipe[$kat['tipe']];
                    $sudahAda = in_array($key, $kategoriTersimpan, true);

                    $oldPilih = old('pilih.' . $key, $sudahAda);
                    $oldAda = old('perubahan.' . $key . '.ada/tidak_ada', $perubahanTersimpan[$key]['ada/tidak_ada'] ?? null);
                    $oldKodisi = old('perubahan.' . $key . '.kodisi', $perubahanTersimpan[$key]['kodisi'] ?? null);
                @endphp

                {{-- Dibungkus <div data-kategori> (bukan atribut langsung di <x-card>)
                     supaya JS Tambah/Hapus tidak bergantung pada apakah komponen
                     x-card meneruskan atribut HTML tambahan. Kategori yang sudah
                     tersimpan ($sudahAda) langsung terbuka; sisanya disembunyikan
                     sampai ditambahkan lewat dropdown di atas. --}}
                <div data-kategori="{{ $key }}" class="{{ $oldPilih ? '' : 'hidden' }}">
                    <x-card>
                        <x-slot:header>
                            <div class="flex flex-wrap items-center justify-between gap-2">
                                <div class="flex items-center gap-2 text-blue-600 dark:text-blue-400">
                                    <i class="bi {{ $ikonKategori[$key] ?? 'bi-tag' }}"></i>
                                    {{ $kat['label'] }}
                                    @if ($sudahAda)
                                        <x-badge variant="secondary" class="text-xs">Sudah diajukan</x-badge>
                                    @endif
                                </div>
                                @unless ($sudahAda)
                                    <button
                                        type="button"
                                        class="btn-hapus-kategori inline-flex items-center gap-1 text-sm text-red-600 hover:text-red-700 dark:text-red-400"
                                        data-kategori="{{ $key }}"
                                    >
                                        <i class="bi bi-x-circle"></i> Hapus
                                    </button>
                                @endunless
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
                                    @php $oldVal = old('perubahan.' . $key . '.' . $field['name'], $perubahanTersimpan[$key][$field['name']] ?? 0); @endphp
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
                            @php $oldJumlah = old('perubahan.' . $key . '.jumlah', $perubahanTersimpan[$key]['jumlah'] ?? 0); @endphp
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
                                    @php $oldVal = old('perubahan.' . $key . '.' . $field['name'], $perubahanTersimpan[$key][$field['name']] ?? 0); @endphp
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
                </div>
            @endforeach

            {{-- Tombol Aksi --}}
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

            @foreach ($kategoriList as $key => $kat)
                @if ($kat['tipe'] === 'ada_kondisi')
                    setupConditionAuto('perubahan[{{ $key }}][ada/tidak_ada]', 'perubahan[{{ $key }}][kodisi]');
                @endif
            @endforeach

            // ---- Tambah / Hapus kategori lewat dropdown ----
            const form = document.getElementById('pengajuanForm');
            const select = document.getElementById('pilihKategoriSelect');
            const btnTambah = document.getElementById('btnTambahKategori');
            const pesanKosong = document.getElementById('pesanBelumAdaKategori');

            function wrapperFor(key) {
                return form.querySelector(`[data-kategori="${key}"]`);
            }

            function optionFor(key) {
                return select.querySelector(`option[value="${key}"]`);
            }

            // Pesan "belum ada kategori" di sini hanya soal kategori TAMBAHAN
            // (yang belum tersimpan) — kategori tersimpan tidak punya tombol
            // Hapus, jadi dipakai sebagai penanda "ini kategori baru".
            function updatePesanKosong() {
                const adaTambahanTampil = Array.from(form.querySelectorAll('[data-kategori]:not(.hidden)'))
                    .some(function (wrapper) {
                        return wrapper.querySelector('.btn-hapus-kategori') !== null;
                    });
                if (pesanKosong) pesanKosong.classList.toggle('hidden', adaTambahanTampil);
            }

            // Idempotent: aman dipanggil berkali-kali untuk kategori yang sama
            // (dipakai juga untuk kategori yang sudah tersimpan & saat re-populate
            // setelah validasi gagal).
            function tampilkanKategori(key) {
                const wrapper = wrapperFor(key);
                if (!wrapper) return;

                wrapper.classList.remove('hidden');

                if (!wrapper.querySelector(`input[type="hidden"][name="pilih[${key}]"]`)) {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = `pilih[${key}]`;
                    input.value = '1';
                    wrapper.prepend(input);
                }

                const opt = optionFor(key);
                if (opt) opt.disabled = true;

                updatePesanKosong();
            }

            function sembunyikanKategori(key) {
                const wrapper = wrapperFor(key);
                if (!wrapper) return;

                // Kategori yang sudah tersimpan tidak punya tombol Hapus, jadi
                // fungsi ini hanya akan pernah dipanggil untuk kategori baru.
                wrapper.classList.add('hidden');

                const input = wrapper.querySelector(`input[type="hidden"][name="pilih[${key}]"]`);
                if (input) input.remove();

                const opt = optionFor(key);
                if (opt) opt.disabled = false;

                updatePesanKosong();
            }

            btnTambah.addEventListener('click', function () {
                if (!select.value) return;
                tampilkanKategori(select.value);
                select.value = '';
            });

            form.addEventListener('click', function (e) {
                const btn = e.target.closest('.btn-hapus-kategori');
                if (!btn) return;
                e.preventDefault();
                sembunyikanKategori(btn.dataset.kategori);
            });

            // Tampilkan kategori yang sudah tersimpan ATAU yang sebelumnya dipilih
            // user tapi validasi gagal, dan kunci pilihannya di dropdown.
            @foreach ($kategoriList as $key => $kat)
                @php
                    $sudahAdaJs = in_array($key, $kategoriTersimpan, true);
                    $oldPilihJs = old('pilih.' . $key, $sudahAdaJs);
                @endphp
                @if ($oldPilihJs)
                    tampilkanKategori('{{ $key }}');
                @endif
            @endforeach

            updatePesanKosong();
        });
    </script>
@endpush