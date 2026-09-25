@extends('layouts.app')

@section('title', 'Edit Rencana Pembangunan')

@section('content')
    <div class="container mx-auto px-3 sm:px-4 py-3 sm:py-4">
        <div class="flex flex-col gap-3 sm:gap-4">
            {{-- Header --}}
            <div class="flex flex-wrap items-center justify-between gap-2">
                <h1 class="text-base sm:text-xl font-semibold text-gray-800 dark:text-gray-100 flex items-center gap-2">
                    <i class="bi bi-pencil-square"></i>
                    <span class="hidden sm:inline">Edit Rencana Pembangunan</span>
                    <span class="sm:hidden">Edit Rencana</span>
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
                Kategori yang sudah diajukan sebelumnya otomatis terbuka & terisi. Anda bisa menghapus
                kategori mana pun (termasuk yang sudah diajukan sebelumnya) dengan tombol "Hapus", atau
                menambah kategori lain lewat dropdown "Tambah Kategori" di bawah.
            </p>

            @if ($errors->any())
                <x-alert type="danger" dismissible>
                    Ada isian yang belum lengkap, silakan periksa kembali.
                </x-alert>
            @endif

            @php
                $perubahanTersimpan = $pengajuan->perubahan ?? [];
                $kategoriTersimpan = is_array($pengajuan->pengajuan)
                    ? $pengajuan->pengajuan
                    : array_filter([$pengajuan->pengajuan]);
            @endphp

            <form action="{{ route('user.rencana-pembangunan.update', $pengajuan) }}" method="POST" id="pengajuanForm"
                class="flex flex-col gap-4">
                @csrf
                @method('PUT')

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
                        Belum ada kategori tambahan yang ditambahkan.
                    </p>
                </x-card>

                @foreach ($kategoriList as $key => $kat)
                    @php
                        $fields = $fieldsByTipe[$kat['tipe']];
                        $sudahAda = in_array($key, $kategoriTersimpan, true);

                        $oldPilih = old('pilih.' . $key, $sudahAda);
                    @endphp

                    {{-- Dibungkus <div data-kategori> (bukan atribut langsung di <x-card>)
                     supaya JS Tambah/Hapus tidak bergantung pada apakah komponen
                     x-card meneruskan atribut HTML tambahan. Kategori yang sudah
                     tersimpan ($sudahAda) langsung terbuka; sisanya disembunyikan
                     sampai ditambahkan lewat dropdown di atas. data-baru dipakai JS
                     untuk membedakan kategori BARU (belum tersimpan) vs kategori
                     lama, khusus untuk pesan "belum ada kategori tambahan" —
                     tombol Hapus sendiri sekarang tersedia untuk KEDUANYA, supaya
                     kategori yang sudah diajukan pun bisa dihapus dari sini. --}}
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
                                    <button type="button"
                                        class="btn-hapus-kategori inline-flex items-center gap-1 text-sm text-red-600 hover:text-red-700 dark:text-red-400"
                                        data-kategori="{{ $key }}">
                                        <i class="bi bi-x-circle"></i> Hapus
                                    </button>
                                </div>
                            </x-slot:header>

                            @if ($kat['tipe'] === 'ada_kondisi')
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    <i class="bi bi-info-circle me-1"></i>
                                    Kategori ini diajukan sebagai rencana pembangunan
                                    <strong>{{ $kat['label'] }}</strong> yang baru. Tidak ada isian
                                    tambahan yang perlu diisi.
                                </p>
                            @elseif ($kat['tipe'] === 'siswa_rombel')
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    @foreach ($fields as $field)
                                        @php $oldVal = old('perubahan.' . $key . '.' . $field['name'], $perubahanTersimpan[$key][$field['name']] ?? 0); @endphp
                                        <x-form.input name="perubahan[{{ $key }}][{{ $field['name'] }}]"
                                            label="{{ $field['label'] }}" type="number" min="0"
                                            :value="$oldVal" />
                                    @endforeach
                                </div>
                            @elseif ($kat['tipe'] === 'jumlah')
                                @php $oldJumlah = old('perubahan.' . $key . '.jumlah', $perubahanTersimpan[$key]['jumlah'] ?? 0); @endphp
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <x-form.input name="perubahan[{{ $key }}][jumlah]" label="Jumlah"
                                        type="number" min="0" :value="$oldJumlah" />
                                </div>
                            @else
                                {{-- baik_rusak --}}
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    @foreach ($fields as $field)
                                        @php $oldVal = old('perubahan.' . $key . '.' . $field['name'], $perubahanTersimpan[$key][$field['name']] ?? 0); @endphp
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
                            Lampiran<span class="text-red-600 underline">wajib</span><span class="text-red-600">*</span>
                        </div>
                    </x-slot:header>
                    <div class="flex flex-col gap-5">
                        <x-card>
                            <x-slot:header>
                                silahkan lampirkan
                            </x-slot:header>

                            <div class="ms-5 mb-3">
                                <ol class="list-decimal">
                                    <li>dukemntasi lahan kosong </li>
                                    <li>foto copy akta tanah</li>
                                    <li>proposal</li>
                                </ol>
                            </div>

                            <span>jangan lupa dibuat dalam folder baru!</span>

                        </x-card>

                        <div>
                            cari <span class="font-bold">nama sekolah yang sesuai</span> di dalam folder dan upload di
                            folder <span class="font-bold">pembangunan</span>
                        </div>

                    </div>
                    <x-slot:footer>
                        <x-button href="https://gofile.me/7Hsao/ZjQEsygfo">
                            <i class="bi bi-cloud-arrow-up"></i> upload file
                        </x-button>
                    </x-slot:footer>

                </x-card>

                <x-card>
                    <x-slot:header>
                        <div class="flex items-center gap-2 text-blue-600 dark:text-blue-400">
                            <i class="bi bi-card-heading"></i>
                            Lampiran <span class="text-red-600 underline">wajib</span><span class="text-red-600">*</span>
                        </div>
                    </x-slot:header>
                    <div class="flex flex-col gap-5">
                        <x-card>
                            <x-slot:header>
                                silahkan lampirkan
                            </x-slot:header>

                            <div class="ms-5 mb-3">
                                <ol class="list-decimal">
                                    <li>dukemntasi foto kerusakan </li>
                                    <li>form tingkat kerusakan</li>
                                    <li>proposal</li>
                                </ol>
                            </div>

                            <span>jangan lupa dibuat dalam folder baru!</span>

                        </x-card>

                        <div>
                            cari <span class="font-bold">nama sekolah yang sesuai</span> di dalam folder dan upload di
                            folder <span class="font-bold">rehabilitasi</span>
                        </div>

                    </div>
                    <x-slot:footer>
                        <x-button href="https://gofile.me/7Hsao/ZjQEsygfo">
                            <i class="bi bi-cloud-arrow-up"></i> upload file
                        </x-button>
                    </x-slot:footer>

                </x-card>

                {{-- Tombol Aksi --}}
                <x-card>
                    <x-slot:footer>
                        <div class="flex flex-wrap gap-2">
                            <x-button variant="primary" type="submit">
                                <i class="bi bi-save"></i> Simpan Perubahan
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

            // Pesan "belum ada kategori tambahan" di sini hanya soal kategori BARU
            // (yang belum tersimpan sebelumnya), ditandai lewat data-baru="1" —
            // bukan lewat tombol Hapus lagi, karena sekarang kategori lama pun
            // punya tombol Hapus.
            function updatePesanKosong() {
                const adaTambahanTampil = form.querySelectorAll('[data-kategori][data-baru="1"]:not(.hidden)')
                    .length > 0;
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

            // Sekarang dipakai untuk kategori BARU maupun kategori yang sudah
            // tersimpan sebelumnya — menghapus hidden input pilih[key] berarti
            // kategori itu tidak akan ikut terkirim, jadi akan benar-benar
            // hilang dari pengajuan setelah disimpan (asalkan controller
            // update() juga tidak lagi merge balik ke kategori lama).
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
