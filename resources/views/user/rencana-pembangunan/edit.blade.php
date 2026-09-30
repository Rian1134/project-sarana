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
                Kategori yang sudah diajukan sebelumnya otomatis terbuka & terisi, termasuk jenis
                pengajuannya (Bangun Baru / Rehabilitasi). Anda bisa menghapus kategori mana pun
                dengan tombol "Hapus", atau menambah kategori lain lewat dropdown di bawah.
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

                    <p class="flex items-start gap-2 text-sm text-blue-700 dark:text-blue-300 mb-3">
                        <i class="bi bi-info-circle mt-0.5"></i>
                        <span>Pengajuan bisa lebih dari satu. Pilih kategori lalu klik <strong>Tambah</strong>, ulangi untuk menambah kategori lain ke pengajuan ini.</span>
                    </p>

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
                        $sudahAda = in_array($key, $kategoriTersimpan, true);
                        $oldPilih = old('pilih.' . $key, $sudahAda);
                        $fieldsTersimpan = $perubahanTersimpan[$key] ?? [];
                        $fields = $fieldsByTipe[$kat['tipe']] ?? [];
                        $jenisTersimpan = old('perubahan.' . $key . '.jenis', $fieldsTersimpan['jenis'] ?? 'bangun');
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
                                    <label class="inline-flex items-center gap-1.5">
                                        <input type="radio" name="perubahan[{{ $key }}][jenis]" value="rehab"
                                            {{ $jenisTersimpan === 'rehab' ? 'checked' : '' }}>
                                        Rehabilitasi
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

                {{-- Lampiran: bagian tampil sesuai jenis pengajuan (diatur JS updateLampiran) --}}
                <div id="lampiranCard" class="hidden">
                    <x-card>
                        <x-slot:header>
                            <div class="flex items-center gap-2 text-blue-600 dark:text-blue-400">
                                <i class="bi bi-paperclip"></i>
                                Lampiran <span class="text-red-600 underline">wajib</span><span class="text-red-600">*</span>
                            </div>
                        </x-slot:header>

                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">
                            Cari folder dengan <strong>nama sekolah</strong>, lalu upload lewat tombol di samping dokumen.
                        </p>

                        <div id="lampiranBangun" class="hidden space-y-2 text-sm">
                            <p class="font-semibold">Untuk Pembangunan</p>
                            <div class="flex items-center justify-between gap-2 rounded-lg border border-gray-200 dark:border-gray-700 px-3 py-2">
                                <span>Dokumen Photo Lahan Kosong</span>
                                <a href="https://bidangsmp.quickconnect.to/sharing/tRn9cXnRG" target="_blank" rel="noopener noreferrer">
                                    <x-button type="button" size="sm"><i class="bi bi-cloud-arrow-up"></i> Upload</x-button>
                                </a>
                            </div>
                            <div class="flex items-center justify-between gap-2 rounded-lg border border-gray-200 dark:border-gray-700 px-3 py-2">
                                <span>Dokumen Photo Copy Akte / Surat Tanah</span>
                                <a href="https://bidangsmp.quickconnect.to/sharing/Mj27zN3jN" target="_blank" rel="noopener noreferrer">
                                    <x-button type="button" size="sm"><i class="bi bi-cloud-arrow-up"></i> Upload</x-button>
                                </a>
                            </div>
                            <div class="flex items-center justify-between gap-2 rounded-lg border border-gray-200 dark:border-gray-700 px-3 py-2">
                                <span>Dokumen Proposal</span>
                                <a href="https://bidangsmp.quickconnect.to/sharing/ajB6Jr5QL" target="_blank" rel="noopener noreferrer">
                                    <x-button type="button" size="sm"><i class="bi bi-cloud-arrow-up"></i> Upload</x-button>
                                </a>
                            </div>
                        </div>

                        <div id="lampiranRehab" class="hidden space-y-2 text-sm">
                            <p class="font-semibold">Untuk Rehabilitasi</p>
                            <div class="flex items-center justify-between gap-2 rounded-lg border border-gray-200 dark:border-gray-700 px-3 py-2">
                                <span>Dokumen Photo Kerusakan</span>
                                <a href="https://bidangsmp.quickconnect.to/sharing/YurNiw2bm" target="_blank" rel="noopener noreferrer">
                                    <x-button type="button" size="sm"><i class="bi bi-cloud-arrow-up"></i> Upload</x-button>
                                </a>
                            </div>
                            <div class="flex items-center justify-between gap-2 rounded-lg border border-gray-200 dark:border-gray-700 px-3 py-2">
                                <span>Form Perhitungan Tingkat Kerusakan</span>
                                <a href="https://bidangsmp.quickconnect.to/sharing/ok8fhBxWe" target="_blank" rel="noopener noreferrer">
                                    <x-button type="button" size="sm"><i class="bi bi-cloud-arrow-up"></i> Upload</x-button>
                                </a>
                            </div>
                            <div class="flex items-center justify-between gap-2 rounded-lg border border-gray-200 dark:border-gray-700 px-3 py-2">
                                <span>Dokumen Proposal</span>
                                <a href="https://bidangsmp.quickconnect.to/sharing/llroKMhTo" target="_blank" rel="noopener noreferrer">
                                    <x-button type="button" size="sm"><i class="bi bi-cloud-arrow-up"></i> Upload</x-button>
                                </a>
                            </div>
                        </div>
                    </x-card>
                </div>

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

            // Pesan "belum ada kategori tambahan" di sini hanya soal kategori BARU
            // (yang belum tersimpan sebelumnya), ditandai lewat data-baru="1".
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
                updateLampiran();
            }

            // Sekarang dipakai untuk kategori BARU maupun kategori yang sudah
            // tersimpan sebelumnya — menghapus hidden input pilih[key] berarti
            // kategori itu tidak akan ikut terkirim, jadi akan benar-benar
            // hilang dari pengajuan setelah disimpan.
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
                updateLampiran();
        });
    </script>
@endpush