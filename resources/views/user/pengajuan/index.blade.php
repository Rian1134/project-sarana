@extends('layouts.app')

@section('title', 'Pengajuan Perubahan Data')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-6">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-xl font-semibold text-gray-800 dark:text-gray-100 flex items-center gap-2">
            <i class="bi bi-list-check"></i>
            Pengajuan Perubahan Data
        </h1>
        <x-button href="{{ route('user.pengajuan.create') }}" variant="primary">
            <i class="bi bi-plus-lg"></i> Ajukan Perubahan
        </x-button>
    </div>

    {{-- ============================================================
         CARD & TABEL UTAMA
         Mengikuti style tabel pada index admin data
         ============================================================ --}}
    <div class="card">
        <div class="card-body">
            <x-table bordered class="text-sm">
                <x-slot:head>
                    <tr class="bg-gray-800 text-white text-center">
                        <x-table.heading class="text-white! align-middle px-3 py-2">
                            Kategori Data
                        </x-table.heading>
                        <x-table.heading class="text-white! align-middle px-3 py-2">
                            Rincian Pembaruan
                        </x-table.heading>
                        <x-table.heading class="text-white! align-middle px-3 py-2">
                            Status
                        </x-table.heading>
                        <x-table.heading class="text-white! align-middle px-3 py-2">
                            Diajukan
                        </x-table.heading>
                        <x-table.heading class="text-white! align-middle px-3 py-2">
                            Aksi
                        </x-table.heading>
                    </tr>
                </x-slot:head>

            @forelse ($pengajuans as $item)
                @php
                    $kategoriLabel = \App\Http\Controllers\PengajuanController::kategoriList()[$item->pengajuan]['label'] ?? $item->pengajuan;
                @endphp
                <x-table.row class="align-middle">
                    <x-table.cell class="font-medium px-3 py-2.5">
                        {{ $kategoriLabel }}
                    </x-table.cell>
                    <x-table.cell class="px-3 py-2.5">
                        <ul class="space-y-0.5 text-sm">
                            @foreach ($item->perubahan as $field => $value)
                                <li>
                                    <span class="text-gray-500 dark:text-gray-400">{{ \App\Http\Controllers\PengajuanController::fieldLabel($item->pengajuan, $field) }}:</span>
                                    <span class="font-medium">{{ $value }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </x-table.cell>
                    <x-table.cell class="text-center px-3 py-2.5">
                        @if ($item->status === 'pending')
                            <x-badge variant="warning">Menunggu Review</x-badge>
                        @elseif ($item->status === 'approved')
                            <x-badge variant="success">Disetujui</x-badge>
                        @elseif ($item->status === 'rejected')
                            <x-badge variant="danger">Ditolak</x-badge>
                        @else
                            <x-badge variant="secondary">{{ ucfirst($item->status) }}</x-badge>
                        @endif
                    </x-table.cell>
                    <x-table.cell class="text-center whitespace-nowrap px-3 py-2.5">
                        {{ $item->created_at->format('d M Y H:i') }}
                    </x-table.cell>
                    <x-table.cell class="text-center px-3 py-2.5">
                        <div class="flex justify-center gap-1">
                            <x-button href="{{ route('user.pengajuan.show', $item) }}" variant="info" size="xs">
                                <i class="bi bi-eye-fill"></i>
                            </x-button>
                            @if ($item->status === 'pending')
                                <x-button href="{{ route('user.pengajuan.edit', $item) }}" variant="warning" size="xs">
                                    <i class="bi bi-pencil-fill"></i>
                                </x-button>
                                <form action="{{ route('user.pengajuan.destroy', $item) }}" method="POST" onsubmit="return confirm('Hapus pengajuan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <x-button type="submit" variant="danger" size="xs">
                                        <i class="bi bi-trash-fill"></i>
                                    </x-button>
                                </form>
                            @endif
                        </div>
                    </x-table.cell>
                </x-table.row>
            @empty
                <x-table.empty colspan="5" message="Belum ada pengajuan perubahan data." />
            @endforelse
            </x-table>
        </div>
    </div>

    <x-pagination :paginator="$pengajuans" class="mt-4" />
</div>
@endsection