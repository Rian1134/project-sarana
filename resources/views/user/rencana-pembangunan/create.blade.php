@extends('layouts.app')

@section('title', 'Ajukan Rencana Pembangunan')

@section('content')
    <div class="container mx-auto px-3 sm:px-4 py-3 sm:py-4">
        <div class="flex flex-col gap-3 sm:gap-4">
            {{-- Header --}}
            <div class="flex flex-wrap items-center justify-between gap-2">
                <h1 class="text-base sm:text-xl font-semibold text-gray-800 dark:text-gray-100 flex items-center gap-2">
                    <i class="bi bi-plus-circle"></i>
                    <span class="hidden sm:inline">Form Ajukan Rencana Pembangunan</span>
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
                Pilih kategori bangunan/ruang yang ingin diusulkan pembangunannya dari dropdown di bawah
                lalu klik "Tambah". Anda bisa mengusulkan beberapa kategori sekaligus dalam satu pengiriman.
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
                        $fields = $fieldsByTipe[$kat['tipe']];

                        // Ambil old() dengan string concatenation biasa (bukan interpolasi
                        // ber-quote di dalam atribut Blade) supaya tidak ada masalah
                        // escaping tanda kutip yang bikin komponen x-form.* gagal render.
                        $oldPilih = old('pilih.' . $key);
                    @endphp

                    {{-- Dibungkus <div data-kategori> (bukan atribut langsung di <x-card>)
                     supaya JS Tambah/Hapus tidak bergantung pada apakah komponen
                     x-card meneruskan atribut HTML tambahan. Card ini disembunyikan
                     (hidden) sampai kategorinya ditambahkan lewat dropdown di atas,
                     kecuali kalau sebelumnya sudah dipilih user tapi validasi gagal. --}}
                    <div data-kategori="{{ $key }}" class="{{ $oldPilih ? '' : 'hidden' }}">
                        <x-card>
                            <x-slot:header>
                                <div class="flex flex-wrap items-center justify-between gap-2">
                                    <div class="flex items-center gap-2 text-blue-600 dark:text-blue-400">
                                        <i class="bi {{ $ikonKategori[$key] ?? 'bi-tag' }}"></i>
                                        {{ $kat['label'] }}
                                    </div>
                                    <button type="button"
                                        class="btn-hapus-kategori inline-flex items-center gap-1 text-sm text-red-600 hover:text-red-700 dark:text-red-400"
                                        data-kategori="{{ $key }}">
                                        <i class="bi bi-x-circle"></i> Hapus
                                    </button>
                                </div>
                            </x-slot:header>

                            @if ($kat['tipe'] === 'ada_kondisi')
                                {{-- Rencana Pembangunan: mencentang/menambahkan kategori ini SUDAH
                                 berarti "ingin membangun {{ $kat['label'] }}" — tidak perlu isi
                                 status ada/tidak-ada atau kondisi apa pun lagi. --}}
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    <i class="bi bi-info-circle me-1"></i>
                                    Kategori ini akan diajukan sebagai rencana-pembangunan pembangunan
                                    <strong>{{ $kat['label'] }}</strong> yang baru. Tidak ada isian
                                    tambahan yang perlu diisi — cukup pastikan kategori ini sudah
                                    ditambahkan di atas.
                                </p>
                            @elseif ($kat['tipe'] === 'siswa_rombel')
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    @foreach ($fields as $field)
                                        @php $oldVal = old('perubahan.' . $key . '.' . $field['name'], 0); @endphp
                                        <x-form.input name="perubahan[{{ $key }}][{{ $field['name'] }}]"
                                            label="{{ $field['label'] }}" type="number" min="0"
                                            :value="$oldVal" />
                                    @endforeach
                                </div>
                            @elseif ($kat['tipe'] === 'jumlah')
                                @php $oldJumlah = old('perubahan.' . $key . '.jumlah', 0); @endphp
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <x-form.input name="perubahan[{{ $key }}][jumlah]" label="Jumlah"
                                        type="number" min="0" :value="$oldJumlah" />
                                </div>
                            @else
                                {{-- baik_rusak --}}
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    @foreach ($fields as $field)
                                        @php $oldVal = old('perubahan.' . $key . '.' . $field['name'], 0); @endphp
                                        <x-form.input name="perubahan[{{ $key }}][{{ $field['name'] }}]"
                                            label="{{ $field['label'] }}" type="number" min="0"
                                            :value="$oldVal" />
                                    @endforeach
                                </div>
                            @endif
                        </x-card>
                    </div>
                @endforeach

                <x-card>
                    <x-slot:header>
                        <div class="flex items-center gap-2 text-blue-600 dark:text-blue-400">
                            <i class="bi bi-card-heading"></i>
                            Lampiran
                        </div>
                    </x-slot:header>

                    <x-form.input name="lampiran" label="lampiran" placeholder="masukan link dirve (wajib)" required
                        :value="old('lampiran')" />
                </x-card>

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
                }, 0);
            });

            // Tampilkan ulang kategori yang sudah dipilih user sebelum validasi gagal.
            @foreach ($kategoriList as $key => $kat)
                @if (old('pilih.' . $key))
                    tampilkanKategori('{{ $key }}');
                @endif
            @endforeach

            updatePesanKosong();
        });
    </script>
@endpush
