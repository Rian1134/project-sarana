@extends('layouts.app')

@section('title', 'Ajukan Rencana Pembangunan')

@section('content')
    <div class="container mx-auto px-3 sm:px-4 py-3 sm:py-4">
        <div class="flex flex-col gap-3 sm:gap-4">
            {{-- Header --}}
            <div class="flex flex-wrap items-center justify-between gap-2">
                <h1 class="text-base sm:text-xl font-semibold text-gray-800 dark:text-gray-100 flex items-center gap-2">
                    <i class="bi bi-plus-circle"></i>
                    <span class="hidden sm:inline">Form Ajukan Rencana Kegiatan</span>
                    <span class="sm:hidden">Ajukan Rencana</span>
                </h1>
                <a href="{{ route('user.rencana-pembangunan.index') }}" class="inline-flex">
                    <x-button variant="secondary" size="sm">
                        <i class="bi bi-arrow-left me-1"></i>
                        <span class="hidden sm:inline">Kembali</span>
                        <span class="sm:hidden">Back</span>
                    </x-button>
                </a>
            </div>

            <p class="text-sm text-gray-500 dark:text-gray-400">
                Pilih kategori sarana/prasarana dari dropdown di bawah lalu klik "Tambah". Untuk
                setiap kategori yang ditambahkan, tentukan juga jenis pengajuannya: <strong>Bangun
                    Baru</strong> atau <strong>Rehabilitasi</strong>. Anda bisa mengusulkan beberapa
                kategori sekaligus dalam satu pengiriman.
            </p>

            @if ($errors->any())
                <x-alert type="danger" dismissible>
                    Ada isian yang belum lengkap, silakan periksa kembali kategori yang Anda tambahkan.
                </x-alert>
            @endif

            <form action="{{ route('user.rencana-pembangunan.store') }}" method="POST" id="pengajuanForm"
                class="flex flex-col gap-4">
                @csrf

                {{-- Tambah Kategori: kategori baru muncul sebagai card di bawah setelah
                 dipilih dari dropdown ini dan diklik "Tambah". Kategori yang sudah
                 ditambahkan otomatis hilang dari pilihan supaya tidak dobel. --}}
                <x-card>
                    <x-slot:header>
                        <div class="flex items-center gap-2 text-blue-600 dark:text-blue-400">
                            <i class="bi bi-plus-square"></i>
                            Tambah Kategori
                        </div>
                    </x-slot:header>

                    <div class="flex flex-col sm:flex-row gap-2">
                        <select id="pilihKategoriSelect"
                            class="w-full sm:flex-1 rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 text-sm focus:ring-blue-500 focus:border-blue-500">
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
                        Belum ada kategori yang ditambahkan.
                    </p>

                    @error('pilih')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </x-card>

                @foreach ($kategoriList as $key => $kat)
                    @php
                        $sudahAda = false;
                        $oldPilih = old('pilih.' . $key);
                        $fieldsTersimpan = [];
                        $fields = $fieldsByTipe[$kat['tipe']] ?? [];
                        $jenisTersimpan = old('perubahan.' . $key . '.jenis', $fieldsTersimpan['jenis'] ?? 'bangun');
                        $rehabDiblokir = in_array($key, $kategoriSedangRehab ?? [], true);
                    @endphp
                    <div data-kategori="{{ $key }}" data-baru="{{ $sudahAda ? '0' : '1' }}"
                        class="{{ $oldPilih ? '' : 'hidden' }}">
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
                                    <button type="button" data-kategori="{{ $key }}"
                                        class="btn-hapus-kategori inline-flex items-center gap-1 text-sm text-red-600 hover:text-red-700 dark:text-red-400">
                                        <i class="bi bi-x-circle"></i> Hapus
                                    </button>
                                </div>
                            </x-slot:header>

                            {{-- Jenis pengajuan: berlaku untuk semua kategori --}}
                            <div class="mb-3 pb-3 border-b border-gray-100 dark:border-gray-700">
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1.5">
                                    Jenis Pengajuan
                                </label>
                                <div class="flex flex-wrap gap-4 text-sm">
                                    <label class="inline-flex items-center gap-1.5">
                                        <input type="radio" name="perubahan[{{ $key }}][jenis]" value="bangun"
                                            {{ $jenisTersimpan === 'bangun' ? 'checked' : '' }}>
                                        Bangun Baru
                                    </label>
                                    <label class="inline-flex items-center gap-1.5 {{ $rehabDiblokir ? 'opacity-50' : '' }}">
                                        <input type="radio" name="perubahan[{{ $key }}][jenis]" value="rehab"
                                            {{ $rehabDiblokir ? 'disabled' : '' }}
                                            {{ $jenisTersimpan === 'rehab' && ! $rehabDiblokir ? 'checked' : '' }}>
                                        Rehabilitasi
                                        @if ($rehabDiblokir)
                                            <span class="text-[10px] text-amber-600 dark:text-amber-400">(sedang berjalan)</span>
                                        @endif
                                    </label>
                                </div>
                                @error('perubahan.' . $key . '.jenis')
                                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            @if ($kat['tipe'] === 'ada_kondisi')
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    <i class="bi bi-info-circle me-1"></i>
                                    Tidak ada isian tambahan — cukup pilih jenis pengajuan di atas.
                                </p>
                            @else
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    @foreach ($fields as $field)
                                        <x-form.input name="perubahan[{{ $key }}][{{ $field['name'] }}]"
                                            label="{{ $field['label'] }}" type="number" min="0"
                                            :value="old('perubahan.' . $key . '.' . $field['name'], $fieldsTersimpan[$field['name']] ?? 0)" />
                                    @endforeach
                                </div>
                            @endif
                        </x-card>
                    </div>
                @endforeach

                @php
                    $lampiran = [
                        ['id' => 'lampiranBangun', 'judul' => 'Pembangunan', 'folder' => 'pembangunan',
                         'daftar' => ['Dokumentasi lahan kosong', 'Fotokopi akta tanah', 'Proposal']],
                        ['id' => 'lampiranRehab', 'judul' => 'Rehabilitasi', 'folder' => 'rehabilitasi',
                         'daftar' => ['Dokumentasi foto kerusakan', 'Form tingkat kerusakan', 'Proposal']],
                    ];
                @endphp

                {{-- Satu card lampiran; bagian Pembangunan / Rehabilitasi di dalamnya
                 tampil sesuai jenis pengajuan yang dipilih (diatur JS updateLampiran) --}}
                <div id="lampiranCard" class="hidden">
                    <x-card>
                        <x-slot:header>
                            <div class="flex items-center gap-2 text-blue-600 dark:text-blue-400">
                                <i class="bi bi-card-heading"></i>
                                Lampiran <span class="text-red-600 underline">wajib</span><span class="text-red-600">*</span>
                            </div>
                        </x-slot:header>

                        <div class="flex flex-col gap-4 text-sm">
                            @foreach ($lampiran as $l)
                                <div id="{{ $l['id'] }}" class="hidden">
                                    <p class="font-semibold mb-1">Untuk {{ $l['judul'] }}:</p>
                                    <ol class="list-decimal ms-5 mb-1">
                                        @foreach ($l['daftar'] as $dokumen)
                                            <li>{{ $dokumen }}</li>
                                        @endforeach
                                    </ol>
                                    <p>
                                        Upload ke folder <span class="font-bold">{{ $l['folder'] }}</span>.
                                    </p>
                                </div>
                            @endforeach

                            <p class="text-gray-500 dark:text-gray-400">
                                cari folder dengan <span class="font-bold">nama sekolah</span> dan upload sesuai yg diajukan.
                            </p>
                        </div>

                        <x-slot:footer>
                            <x-button href="https://gofile.me/7Hsao/ZjQEsygfo">
                                <i class="bi bi-cloud-arrow-up"></i> Upload File
                            </x-button>
                        </x-slot:footer>
                    </x-card>
                </div>

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
                            <a href="{{ route('user.rencana-pembangunan.index') }}" class="inline-flex">
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
            // ---- Tambah / Hapus kategori lewat dropdown ----
            const form = document.getElementById('pengajuanForm');
            const select = document.getElementById('pilihKategoriSelect');
            const btnTambah = document.getElementById('btnTambahKategori');
            const pesanKosong = document.getElementById('pesanBelumAdaKategori');

            function updateLampiran() {
                let bangun = false, rehab = false;
                form.querySelectorAll('[data-kategori]:not(.hidden)').forEach(function(w) {
                    const r = w.querySelector('input[type="radio"]:checked');
                    if (!r) return;
                    if (r.value === 'rehab') rehab = true; else bangun = true;
                });
                document.getElementById('lampiranCard').classList.toggle('hidden', !bangun && !rehab);
                document.getElementById('lampiranBangun').classList.toggle('hidden', !bangun);
                document.getElementById('lampiranRehab').classList.toggle('hidden', !rehab);
            }
            form.addEventListener('change', updateLampiran);

            function wrapperFor(key) {
                return form.querySelector(`[data-kategori="${key}"]`);
            }

            function optionFor(key) {
                return select.querySelector(`option[value="${key}"]`);
            }

            function updatePesanKosong() {
                const adaYangTampil = form.querySelectorAll('[data-kategori]:not(.hidden)').length > 0;
                if (pesanKosong) pesanKosong.classList.toggle('hidden', adaYangTampil);
            }

            // Idempotent: aman dipanggil berkali-kali untuk kategori yang sama
            // (dipakai juga saat re-populate setelah validasi gagal).
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
                updateLampiran();
            }

            function sembunyikanKategori(key) {
                const wrapper = wrapperFor(key);
                if (!wrapper) return;

                wrapper.classList.add('hidden');

                const input = wrapper.querySelector(`input[type="hidden"][name="pilih[${key}]"]`);
                if (input) input.remove();

                const opt = optionFor(key);
                if (opt) opt.disabled = false;

                updatePesanKosong();
                updateLampiran();
            }

            btnTambah.addEventListener('click', function() {
                if (!select.value) return;
                tampilkanKategori(select.value);
                select.value = '';
            });

            form.addEventListener('click', function(e) {
                const btn = e.target.closest('.btn-hapus-kategori');
                if (!btn) return;
                e.preventDefault();
                sembunyikanKategori(btn.dataset.kategori);
            });

            // Tombol Reset juga mengembalikan semua kategori ke kondisi tersembunyi.
            form.addEventListener('reset', function() {
                setTimeout(function() {
                    form.querySelectorAll('[data-kategori]').forEach(function(wrapper) {
                        wrapper.classList.add('hidden');
                        const input = wrapper.querySelector(
                            'input[type="hidden"][name^="pilih["]');
                        if (input) input.remove();
                    });
                    select.querySelectorAll('option').forEach(function(opt) {
                        opt.disabled = false;
                    });
                    updatePesanKosong();
                updateLampiran();
                }, 0);
            });

            // Tampilkan ulang kategori yang sudah dipilih user sebelum validasi gagal.
            @foreach ($kategoriList as $key => $kat)
                @if (old('pilih.' . $key))
                    tampilkanKategori('{{ $key }}');
                @endif
            @endforeach

            updatePesanKosong();
                updateLampiran();
        });
    </script>
@endpush