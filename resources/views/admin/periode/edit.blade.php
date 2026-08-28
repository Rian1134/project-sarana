@extends('layouts.admin')

@section('title')
    Pengaturan Periode RKB &amp; Rehabilitasi
@endsection

@section('content')
    <div class="flex flex-col gap-4">
        <!-- Header -->
        <div class="flex flex-wrap items-center justify-between gap-3">
            <h1 class="text-base sm:text-lg font-semibold text-gray-800 dark:text-gray-100 flex items-center gap-2">
                <i class="bi bi-calendar-range"></i>
                Pengaturan Periode RKB &amp; Rehabilitasi
            </h1>
        </div>

        <!-- Peringatan -->
        <x-alert type="warning" icon>
            <strong>Perhatian:</strong> mengubah tahun di bawah akan otomatis me-reset kolom
            <strong>Jumlah</strong> kategori terkait menjadi <strong>0</strong> untuk
            <strong>semua sekolah</strong> — karena data lama dianggap milik periode
            sebelumnya, bukan periode yang baru. Tindakan ini tidak bisa dibatalkan.
        </x-alert>

        {{-- id="periodeForm" dipakai tombol konfirmasi di dalam modal (lihat
             bawah) untuk submit form ini dari luar, lewat atribut form="periodeForm" --}}
        <form id="periodeForm" action="{{ route('admin.periode.update') }}" method="POST" class="flex flex-col gap-4">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- RKB -->
                <x-card>
                    <x-slot:header>
                        <div class="flex items-center gap-2 text-blue-600 dark:text-blue-400">
                            <i class="bi bi-building-add"></i>
                            RKB (Ruang Kelas Baru)
                        </div>
                    </x-slot:header>

                    <div class="flex flex-col gap-4">
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            Periode saat ini: <span
                                class="font-semibold text-gray-800 dark:text-gray-100">{{ $rkb->label() }}</span>
                        </p>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
                            <x-form.input name="rkb_tahun_awal" label="Tahun Awal" type="number" min="2000"
                                max="2100" required :value="old('rkb_tahun_awal', $rkb->tahun_awal)" />
                            <x-form.input name="rkb_tahun_akhir" label="Tahun Akhir" type="number" min="2000"
                                max="2100" required :value="old('rkb_tahun_akhir', $rkb->tahun_akhir)" />
                        </div>
                    </div>
                </x-card>

                <!-- Rehabilitasi -->
                <x-card>
                    <x-slot:header>
                        <div class="flex items-center gap-2 text-blue-600 dark:text-blue-400">
                            <i class="bi bi-tools"></i>
                            Rehabilitasi Ruang Kelas
                        </div>
                    </x-slot:header>

                    <div class="flex flex-col gap-4">
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            Periode saat ini: <span
                                class="font-semibold text-gray-800 dark:text-gray-100">{{ $rehabilitasi->label() }}</span>
                        </p>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
                            <x-form.input name="rehabilitasi_tahun_awal" label="Tahun Awal" type="number" min="2000"
                                max="2100" required :value="old('rehabilitasi_tahun_awal', $rehabilitasi->tahun_awal)" />
                            <x-form.input name="rehabilitasi_tahun_akhir" label="Tahun Akhir" type="number" min="2000"
                                max="2100" required :value="old('rehabilitasi_tahun_akhir', $rehabilitasi->tahun_akhir)" />
                        </div>
                    </div>
                </x-card>
            </div>

            <div class="flex justify-end">
                {{-- Bukan langsung submit — buka modal konfirmasi dulu,
                     karena aksi ini mereset data (destruktif & tidak bisa dibatalkan) --}}
                <x-button type="button" variant="primary" data-modal-open="konfirmasiPeriodeModal" class="w-full sm:w-auto">
                    <i class="bi bi-check-circle me-1"></i> Simpan Periode
                </x-button>
            </div>
        </form>
    </div>

    <!-- ===== MODAL KONFIRMASI UBAH PERIODE ===== -->
    <x-modal id="konfirmasiPeriodeModal" size="sm" centered>
        <x-slot:header>
            <div class="flex items-center gap-2 text-yellow-600">
                <i class="bi bi-exclamation-triangle-fill text-xl"></i>
                <span>Konfirmasi Ubah Periode</span>
            </div>
        </x-slot:header>

        <div class="text-center py-4">
            <div class="text-5xl text-yellow-500 mb-4">
                <i class="bi bi-arrow-repeat"></i>
            </div>
            <h4 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-2">
                Yakin ingin menyimpan perubahan periode?
            </h4>
            <p class="text-sm text-gray-500 dark:text-gray-400">
                Kolom <strong>Jumlah</strong> RKB dan/atau Rehabilitasi Ruang Kelas
                di <strong>semua sekolah</strong> yang periodenya berubah akan
                otomatis <strong>direset ke 0</strong>.
            </p>
            <p class="text-sm text-red-500 dark:text-red-400 mt-2">
                <i class="bi bi-exclamation-circle"></i> Tindakan ini tidak dapat dibatalkan!
            </p>
        </div>

        <x-slot:footer>
            <div class="flex flex-col-reverse sm:flex-row sm:justify-end gap-2 w-full">
                <x-button variant="secondary" data-modal-close class="w-full sm:w-auto">
                    <i class="bi bi-x-circle me-1"></i> Batal
                </x-button>
                {{-- form="periodeForm" -> submit form di atas walau tombol ini
                     posisinya di dalam modal, di luar tag <form> --}}
                <x-button type="submit" form="periodeForm" variant="primary" class="w-full sm:w-auto">
                    <i class="bi bi-check-circle me-1"></i> Ya, Simpan &amp; Reset
                </x-button>
            </div>
        </x-slot:footer>
    </x-modal>
@endsection