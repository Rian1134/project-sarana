@extends('layouts.app')

@section('title', 'Detail Pengajuan')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-6">
    <h1 class="text-xl font-semibold text-gray-800 dark:text-gray-100 mb-6">Detail Pengajuan</h1>

    <x-card class="p-2 md:p-4">
        <x-slot:header>
            <div class="flex items-center justify-between px-2 md:px-4">
                <span class="text-lg font-semibold">{{ $kategoriList[$pengajuan->pengajuan]['label'] ?? $pengajuan->pengajuan }}</span>
                @if ($pengajuan->status === 'pending')
                    <x-badge variant="warning" class="text-sm px-3 py-1">Menunggu Review</x-badge>
                @elseif ($pengajuan->status === 'approved')
                    <x-badge variant="success" class="text-sm px-3 py-1">Disetujui</x-badge>
                @elseif ($pengajuan->status === 'rejected')
                    <x-badge variant="danger" class="text-sm px-3 py-1">Ditolak</x-badge>
                @else
                    <x-badge variant="secondary" class="text-sm px-3 py-1">{{ ucfirst($pengajuan->status) }}</x-badge>
                @endif
            </div>
        </x-slot:header>

        <x-table striped>
            <x-slot:head>
                <tr>
                    <x-table.heading>Field</x-table.heading>
                    <x-table.heading>Nilai Baru</x-table.heading>
                </tr>
            </x-slot:head>

            @foreach ($pengajuan->perubahan as $field => $value)
                <x-table.row>
                    <x-table.cell class="text-gray-500 dark:text-gray-400">
                        {{ \App\Http\Controllers\PengajuanController::fieldLabel($pengajuan->pengajuan, $field) }}
                    </x-table.cell>
                    <x-table.cell class="font-medium">
                        {{ ucfirst(str_replace('_', ' ', (string) $value)) }}
                    </x-table.cell>
                </x-table.row>
            @endforeach
        </x-table>

        <div class="mt-4 px-2 md:px-4 pb-2 flex flex-col gap-1">
            <span class="text-sm text-gray-500 dark:text-gray-400">Diajukan pada</span>
            <span class="text-sm font-medium text-gray-800 dark:text-gray-100">{{ $pengajuan->created_at->format('d M Y H:i') }}</span>
        </div>

        {{-- Kolom alasan_penolakan belum ada di migration yang diunggah.
             Tambahkan kolom ini kalau alur reject admin butuh menyimpan alasan. --}}
        @if ($pengajuan->status === 'rejected' && !empty($pengajuan->alasan_penolakan))
            <div class="mt-4 px-2 md:px-4">
                <x-alert type="danger" :icon="true">
                    <span class="font-medium">Alasan Ditolak:</span> {{ $pengajuan->alasan_penolakan }}
                </x-alert>
            </div>
        @endif

        <x-slot:footer>
            <div class="flex justify-end gap-2">
                <x-button href="{{ route('user.pengajuan.index') }}" variant="light">Kembali</x-button>
                @if ($pengajuan->status === 'pending')
                    <x-button href="{{ route('user.pengajuan.edit', $pengajuan) }}" variant="warning">Edit</x-button>
                @endif
            </div>
        </x-slot:footer>
    </x-card>
</div>
@endsection