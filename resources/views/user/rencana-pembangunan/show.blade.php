@extends('layouts.app')

@section('title', 'Detail Rencana Pembangunan')

@section('content')
    <div class="max-w-5xl mx-auto px-3 sm:px-4 py-4 sm:py-6">
        <div class="flex flex-col gap-4 sm:gap-6">

            @php
                $kategoriKeys = is_array($pengajuan->pengajuan)
                    ? $pengajuan->pengajuan
                    : array_filter([$pengajuan->pengajuan]);
                // Field tambahan lain (kalau ada) di luar kategori resmi.
                $tambahanKeys = array_keys(array_diff_key($pengajuan->perubahan ?? [], array_flip($kategoriKeys)));
                $ikonKategori = \App\Http\Controllers\User\RencanaPembangunanController::ikonKategori();
            @endphp

            {{-- Ringkasan Pengajuan --}}
            <x-card class="p-2 md:p-4">
                <x-slot:header>
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                        <div class="flex flex-col gap-1 min-w-0">
                            <span class="text-xs text-gray-500 dark:text-gray-400">
                                Diajukan pada {{ $pengajuan->created_at }}
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

                {{-- Kolom alasan_penolakan belum ada di migration yang diunggah.
                 Tambahkan kolom ini kalau alur reject admin butuh menyimpan alasan. --}}
                @if ($pengajuan->status === 'rejected' && !empty($pengajuan->alasan_penolakan))
                    <x-alert type="danger" :icon="true">
                        <span class="font-medium">Alasan Ditolak:</span> {{ $pengajuan->alasan_penolakan }}
                    </x-alert>
                @endif
            </x-card>

            {{-- Rincian Perubahan: satu kategori satu card, disusun dalam grid
             responsif (1 kolom di HP, 2 di tablet, 3 di layar besar). --}}
            <div>
                <h2 class="text-sm font-semibold text-gray-600 dark:text-gray-300 uppercase mb-2">
                    Rincian Perubahan
                </h2>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach ($kategoriKeys as $kunci)
                        @php $fields = $pengajuan->perubahan[$kunci] ?? []; @endphp
                        <x-card class="p-2 md:p-4">
                            <x-slot:header>
                                <div class="flex items-center gap-2 text-blue-600 dark:text-blue-400 text-sm font-semibold">
                                    <i class="bi {{ $ikonKategori[$kunci] ?? 'bi-tag' }}"></i>
                                    {{ \App\Http\Controllers\User\RencanaPembangunanController::categoryLabel($kunci) }}
                                </div>
                            </x-slot:header>

                            <dl class="divide-y divide-gray-100 dark:divide-gray-700">
                                @forelse ($fields as $field => $value)
                                    <div class="flex justify-between gap-3 py-2 text-sm">
                                        <dt class="text-gray-500 dark:text-gray-400">
                                            {{ \App\Http\Controllers\User\RencanaPembangunanController::fieldLabel($kunci, $field) }}
                                        </dt>
                                        <dd class="font-medium text-right">
                                            {{ ucfirst(str_replace('_', ' ', (string) $value)) }}
                                        </dd>
                                    </div>
                                @empty
                                    <div class="py-2 text-sm text-gray-400 italic">
                                        Diajukan untuk dibangun
                                    </div>
                                @endforelse
                            </dl>
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
                                            {{ ucfirst(str_replace('_', ' ', (string) $pengajuan->perubahan[$namaField])) }}
                                        </dd>
                                    </div>
                                @endforeach
                            </dl>
                        </x-card>
                    @endif
                </div>
            </div>

            {{-- Tombol Aksi --}}
            <div class="flex flex-col sm:flex-row sm:justify-end gap-2">
                <x-button href="{{ route('user.rencana-pembangunan.index') }}" variant="light"
                    class="w-full sm:w-auto justify-center">
                    Kembali
                </x-button>
                @if ($pengajuan->status === 'pending')
                    <x-button href="{{ route('user.rencana-pembangunan.edit', $pengajuan) }}" variant="warning"
                        class="w-full sm:w-auto justify-center">
                        Edit
                    </x-button>
                @endif
            </div>
        </div>
    </div>
@endsection
