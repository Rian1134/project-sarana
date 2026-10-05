@extends('layouts.admin')

@section('title', 'Detail Kegiatan Sarpras')

@section('content')
    <div class="max-w-5xl mx-auto px-3 sm:px-4 py-4 sm:py-6">
        <div class="flex flex-col gap-4 sm:gap-6">

            @php
                $ctrl = \App\Http\Controllers\Admin\PengajuanController::class;

                $kategoriKeys = is_array($pengajuan->pengajuan)
                    ? $pengajuan->pengajuan
                    : array_filter([$pengajuan->pengajuan]);
                $perubahan = is_array($pengajuan->perubahan) ? $pengajuan->perubahan : [];
                $tambahanKeys = array_keys(array_diff_key($perubahan, array_flip($kategoriKeys)));

                // Jenis tiap kategori: true = rehab, false = bangun baru (lihat field `jenis`).
                // Dipakai untuk menentukan link file mana yang tampil.
                $jenisList = collect($kategoriKeys)->map(fn($k) => $ctrl::isJenisRehab($perubahan[$k] ?? []));
                $adaRehab = $jenisList->contains(true);
                $adaBangun = $jenisList->contains(false);

                $ikonKategori = [
                    'ruang_kelas_baru' => 'bi-building-add',
                    'ruang_guru' => 'bi-easel2',
                    'ruang_kepala_sekolah' => 'bi-person-workspace',
                    'ruang_kantor_tu' => 'bi-briefcase',
                    'ruang_perpustakaan' => 'bi-book',
                    'lab_ipa' => 'bi-flask',
                    'lab_komputer' => 'bi-pc-display-horizontal',
                    'unit_kesehatan_sekolah' => 'bi-heart-pulse',
                    'lapangan_sekolah' => 'bi-flag',
                    'pagar_sekolah' => 'bi-border-all',
                    'air_bersih' => 'bi-droplet',
                    'rumah_dinas' => 'bi-house-door',
                    'rumah_ibadah' => 'bi-building',
                ];
            @endphp

            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                <h1 class="text-lg sm:text-xl font-semibold text-gray-800 dark:text-gray-100 flex items-center gap-2">
                    <i class="bi bi-building"></i>
                    Detail Kegiatan Sarpras
                </h1>
                <a href="{{ url()->previous() }}" class="inline-flex">
                    <x-button variant="secondary" size="sm" class="gap-1">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </x-button>
                </a>
            </div>

            {{-- Ringkasan Pengajuan --}}
            <x-card class="p-2 md:p-4">
                <x-slot:header>
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                        <div class="flex flex-col gap-1 min-w-0">
                            <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-100 wrap-break-word">
                                User ID {{ $pengajuan->user_id }} &middot;
                                {{ $pengajuan->profileSekolah->nama_sekolah ?? '-' }} &middot;
                                Diajukan {{ $pengajuan->created_at->format('d M Y H:i') }}
                            </h2>
                            <span>
                                <x-badge variant="secondary" class="text-xs">Rencana Pembangunan</x-badge>
                            </span>
                        </div>
                        <div>
                            @if ($pengajuan->status === 'pending')
                                <x-badge variant="warning" class="text-sm px-3 py-1">Menunggu Review</x-badge>
                            @elseif ($pengajuan->status === 'approved')
                                <x-badge variant="success" class="text-sm px-3 py-1">Disetujui</x-badge>
                            @elseif ($pengajuan->status === 'rejected')
                                <x-badge variant="danger" class="text-sm px-3 py-1">Ditolak</x-badge>
                            @else
                                <x-badge variant="secondary"
                                    class="text-sm px-3 py-1">{{ ucfirst($pengajuan->status) }}</x-badge>
                            @endif
                        </div>
                    </div>
                </x-slot:header>

                @if ($pengajuan->status === 'pending')
                    <div class="flex flex-wrap gap-2 mt-2">
                        <form action="{{ route('pengajuan.approve', $pengajuan) }}" method="POST"
                            onsubmit="return confirm('Setujui pengajuan ini?');">
                            @csrf
                            <x-button type="submit" variant="success" class="gap-1">
                                <i class="bi bi-check-lg"></i> Setujui
                            </x-button>
                        </form>

                        <form action="{{ route('pengajuan.reject', $pengajuan) }}" method="POST"
                            onsubmit="return confirm('Tolak pengajuan ini?');">
                            @csrf
                            <x-button type="submit" variant="danger" class="gap-1">
                                <i class="bi bi-x-lg"></i> Tolak
                            </x-button>
                        </form>
                    </div>
                @endif

                {{-- Link file, tampil sesuai jenis kategori yang diajukan --}}
                <div class="flex flex-wrap gap-2 mt-2">
                    @if ($adaBangun)
                        <x-button href="https://gofile.me/7Hsao/HcpL9coFS" target="_blank" variant="info"
                            size="sm" class="gap-1">
                            <i class="bi bi-cloud-arrow-up"></i> File Pembangunan
                        </x-button>
                    @endif

                    @if ($adaRehab)
                        <x-button href="https://gofile.me/7Hsao/SdSn6hyME" target="_blank" variant="info"
                            size="sm" class="gap-1">
                            <i class="bi bi-cloud-arrow-up"></i> File Rehabilitasi
                        </x-button>
                    @endif
                </div>
            </x-card>

            {{-- Rincian Kegiatan --}}
            <div>
                <h2 class="text-sm font-semibold text-gray-600 dark:text-gray-300 uppercase mb-2">
                    Rincian Kegiatan
                </h2>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach ($kategoriKeys as $kunci)
                        @php
                            $fields = $perubahan[$kunci] ?? [];
                            // 'jenis' & 'selesai' penanda internal, tidak ditampilkan sebagai isian
                            $tampil = array_filter($fields, fn($v, $f) => $ctrl::isFieldTampil($f), ARRAY_FILTER_USE_BOTH);
                        @endphp
                        <x-card class="p-2 md:p-4">
                            <x-slot:header>
                                <div class="flex items-center justify-between gap-2">
                                    <div
                                        class="flex items-center gap-2 text-blue-600 dark:text-blue-400 text-sm font-semibold">
                                        <i class="bi {{ $ikonKategori[$kunci] ?? 'bi-tag' }}"></i>
                                        {{ $ctrl::categoryLabel($kunci) }}
                                    </div>
                                    <x-badge :variant="$ctrl::isJenisRehab($fields) ? 'warning' : 'info'" class="text-xs">
                                        {{ $ctrl::labelJenis($fields) }}
                                    </x-badge>
                                </div>
                            </x-slot:header>

                            @if (count($tampil))
                                <dl class="divide-y divide-gray-100 dark:divide-gray-700">
                                    @foreach ($tampil as $field => $value)
                                        <div class="flex justify-between gap-3 py-2 text-sm">
                                            <dt class="text-gray-500 dark:text-gray-400">
                                                {{ $ctrl::fieldLabel($kunci, $field) }}
                                            </dt>
                                            <dd class="font-medium text-right">
                                                {{ ucfirst(str_replace('_', ' ', (string) $value)) }}
                                            </dd>
                                        </div>
                                    @endforeach
                                </dl>
                            @endif
                        </x-card>
                    @endforeach

                    @if (count($tambahanKeys))
                        <x-card class="p-2 md:p-4">
                            <x-slot:header>
                                <div class="flex items-center gap-2 text-blue-600 dark:text-blue-400 text-sm font-semibold">
                                    <i class="bi bi-tag"></i>
                                    Perubahan Lainnya
                                </div>
                            </x-slot:header>

                            <dl class="divide-y divide-gray-100 dark:divide-gray-700">
                                @foreach ($tambahanKeys as $namaField)
                                    <div class="flex justify-between gap-3 py-2 text-sm">
                                        <dt class="text-gray-500 dark:text-gray-400">
                                            {{ ucwords(str_replace('_', ' ', $namaField)) }}
                                        </dt>
                                        <dd class="font-medium text-right">
                                            {{ is_array($perubahan[$namaField] ?? null) ? json_encode($perubahan[$namaField]) : $perubahan[$namaField] ?? '-' }}
                                        </dd>
                                    </div>
                                @endforeach
                            </dl>
                        </x-card>
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection