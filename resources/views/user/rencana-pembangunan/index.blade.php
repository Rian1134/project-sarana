@extends('layouts.app')

@section('title', 'Rencana Pembangunan')

@section('content')
    <div class="max-w-7xl mx-auto px-3 sm:px-4 py-4 sm:py-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-4 sm:mb-6">
            <h1 class="text-lg sm:text-xl font-semibold text-gray-800 dark:text-gray-100 flex items-center gap-2">
                <i class="bi bi-list-check"></i>
                Rencana Pembangunan
            </h1>
            <x-button href="{{ route('user.rencana-pembangunan.create') }}" variant="primary"
                class="w-full sm:w-auto justify-center">
                <i class="bi bi-plus-lg"></i> Ajukan Rencana
            </x-button>
        </div>

        {{-- ============================================================
         MOBILE (< sm): daftar berbentuk kartu, satu pengajuan = satu kartu,
         supaya tidak perlu scroll horizontal / tabel tidak "kepanjangan".
         DESKTOP (>= sm): tabel biasa, mengikuti style tabel index admin data.
         ============================================================ --}}
        <div class="sm:hidden flex flex-col gap-3">
            @forelse ($pengajuans as $item)
                @php
                    $kategoriKeys = is_array($item->pengajuan) ? $item->pengajuan : array_filter([$item->pengajuan]);
                    $tambahanKeys = array_keys(array_diff_key($item->perubahan ?? [], array_flip($kategoriKeys)));
                @endphp
                <x-card class="p-3">
                    <div class="flex items-start justify-between gap-2 mb-2">
                        <p class="font-semibold text-gray-800 dark:text-gray-100 wrap-break-word">{{ $item->judul }}</p>
                        @if ($item->status === 'pending')
                            <x-badge variant="warning" class="shrink-0">Menunggu</x-badge>
                        @elseif ($item->status === 'approved')
                            <x-badge variant="success" class="shrink-0">Disetujui</x-badge>
                        @elseif ($item->status === 'rejected')
                            <x-badge variant="danger" class="shrink-0">Ditolak</x-badge>
                        @else
                            <x-badge variant="secondary" class="shrink-0">{{ ucfirst($item->status) }}</x-badge>
                        @endif
                    </div>

                    <ul class="text-xs text-gray-500 dark:text-gray-400 mb-2">
                        @foreach ($kategoriKeys as $kunci)
                            <li>{{ \App\Http\Controllers\User\RencanaPembangunanController::categoryLabel($kunci) }}</li>
                        @endforeach
                        @if (count($tambahanKeys))
                            <li>Perubahan Lainnya</li>
                        @endif
                    </ul>

                    <div class="text-sm mb-2">
                        @foreach ($kategoriKeys as $kunci)
                            <div class="mb-1.5">
                                @if (count($kategoriKeys) > 1 || count($tambahanKeys))
                                    <div class="text-xs font-semibold text-gray-400 uppercase">
                                        {{ \App\Http\Controllers\User\RencanaPembangunanController::categoryLabel($kunci) }}
                                    </div>
                                @endif
                                <ul class="space-y-0.5">
                                    @forelse (($item->perubahan[$kunci] ?? []) as $field => $value)
                                        <li>
                                            <span
                                                class="text-gray-500 dark:text-gray-400">{{ \App\Http\Controllers\User\RencanaPembangunanController::fieldLabel($kunci, $field) }}:</span>
                                            <span class="font-medium">{{ $value }}</span>
                                        </li>
                                    @empty
                                        <li class="text-gray-400 italic">Diajukan untuk dibangun</li>
                                    @endforelse
                                </ul>
                            </div>
                        @endforeach
                        @if (count($tambahanKeys))
                            <div>
                                @if (count($kategoriKeys) > 0)
                                    <div class="text-xs font-semibold text-gray-400 uppercase">Perubahan Lainnya</div>
                                @endif
                                <ul class="space-y-0.5">
                                    @foreach ($tambahanKeys as $namaField)
                                        <li>
                                            <span
                                                class="text-gray-500 dark:text-gray-400">{{ ucwords(str_replace('_', ' ', $namaField)) }}:</span>
                                            <span class="font-medium">{{ $item->perubahan[$namaField] }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>

                    <div class="flex items-center justify-between pt-2 border-t border-gray-200 dark:border-gray-700">
                        <span class="text-xs text-gray-400">{{ $item->created_at->format('d M Y H:i') }}</span>
                        <div class="flex gap-1">
                            <x-button href="{{ route('user.rencana-pembangunan.show', $item) }}" variant="info"
                                size="xs">
                                <i class="bi bi-eye-fill"></i>
                            </x-button>
                            @if ($item->status === 'pending')
                                <x-button href="{{ route('user.rencana-pembangunan.edit', $item) }}" variant="warning"
                                    size="xs">
                                    <i class="bi bi-pencil-fill"></i>
                                </x-button>
                                <form action="{{ route('user.rencana-pembangunan.destroy', $item) }}" method="POST"
                                    onsubmit="return confirm('Hapus pengajuan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <x-button type="submit" variant="danger" size="xs">
                                        <i class="bi bi-trash-fill"></i>
                                    </x-button>
                                </form>
                            @endif
                        </div>
                    </div>
                </x-card>
                @empty
                    <x-card class="p-6 text-center text-gray-500 dark:text-gray-400">
                        <i class="bi bi-inbox text-2xl block mb-2"></i>
                        Belum ada rencana pembangunan yang diajukan.
                    </x-card>
                @endforelse
            </div>

            <div class="hidden sm:block">
                <x-card class="w-full">
                    <div class="w-full">
                        <x-table bordered hover class="w-full text-xs sm:text-sm">
                            <x-slot:head>
                                <tr class="bg-gray-800 dark:bg-gray-900 text-white text-center">
                                    <x-table.heading class="text-white! align-middle px-2 py-2">
                                        Judul
                                    </x-table.heading>

                                    <x-table.heading class="text-white! align-middle px-2 py-2">
                                        Perubahan
                                    </x-table.heading>

                                    <x-table.heading class="text-white! align-middle px-2 py-2">
                                        Rincian Pembaruan
                                    </x-table.heading>

                                    <x-table.heading class="text-white! align-middle px-2 py-2 whitespace-nowrap">
                                        Status
                                    </x-table.heading>

                                    <x-table.heading class="text-white! align-middle px-2 py-2 whitespace-nowrap">
                                        Diajukan
                                    </x-table.heading>

                                    <x-table.heading class="text-white! align-middle px-2 py-2">
                                        Lampiran
                                    </x-table.heading>

                                    <x-table.heading class="text-white! align-middle px-2 py-2 whitespace-nowrap">
                                        Aksi
                                    </x-table.heading>
                                </tr>
                            </x-slot:head>

                            @forelse ($pengajuans as $item)
                                @php
                                    $kategoriKeys = is_array($item->pengajuan)
                                        ? $item->pengajuan
                                        : array_filter([$item->pengajuan]);

                                    $tambahanKeys = array_keys(
                                        array_diff_key($item->perubahan ?? [], array_flip($kategoriKeys)),
                                    );
                                @endphp

                                <x-table.row class="align-top">
                                    <x-table.cell class="px-2 py-3 align-top">
                                        <div class="font-medium text-gray-800 dark:text-gray-100 wrap-break-word">
                                            {{ $item->judul }}
                                        </div>
                                    </x-table.cell>

                                    <x-table.cell class="px-2 py-3 align-top">
                                        <div class="space-y-1">
                                            @foreach ($kategoriKeys as $kunci)
                                                <div class="wrap-break-word">
                                                    {{ \App\Http\Controllers\User\RencanaPembangunanController::categoryLabel($kunci) }}
                                                </div>
                                            @endforeach

                                            @if (count($tambahanKeys))
                                                <div class="text-gray-500 dark:text-gray-400">
                                                    Perubahan Lainnya
                                                </div>
                                            @endif
                                        </div>
                                    </x-table.cell>

                                    <x-table.cell class="px-2 py-3 align-top">
                                        <div class="space-y-3">
                                            @foreach ($kategoriKeys as $kunci)
                                                <div>
                                                    @if (count($kategoriKeys) > 1 || count($tambahanKeys))
                                                        <div
                                                            class="mb-1 text-[10px] font-semibold uppercase tracking-wide text-gray-400">
                                                            {{ \App\Http\Controllers\User\RencanaPembangunanController::categoryLabel($kunci) }}
                                                        </div>
                                                    @endif

                                                    <div class="space-y-1">
                                                        @forelse (($item->perubahan[$kunci] ?? []) as $field => $value)
                                                            <div class="wrap-break-word">
                                                                <span class="text-gray-500 dark:text-gray-400">
                                                                    {{ \App\Http\Controllers\User\RencanaPembangunanController::fieldLabel($kunci, $field) }}:
                                                                </span>

                                                                <span class="font-medium text-gray-800 dark:text-gray-100">
                                                                    {{ is_array($value) ? json_encode($value) : $value }}
                                                                </span>
                                                            </div>
                                                        @empty
                                                            <div class="italic text-gray-400">
                                                                Diajukan untuk dibangun
                                                            </div>
                                                        @endforelse
                                                    </div>
                                                </div>
                                            @endforeach

                                            @if (count($tambahanKeys))
                                                <div>
                                                    @if (count($kategoriKeys))
                                                        <div
                                                            class="mb-1 text-[10px] font-semibold uppercase tracking-wide text-gray-400">
                                                            Perubahan Lainnya
                                                        </div>
                                                    @endif

                                                    <div class="space-y-1">
                                                        @foreach ($tambahanKeys as $namaField)
                                                            <div class="wrap-break-word">
                                                                <span class="text-gray-500 dark:text-gray-400">
                                                                    {{ ucwords(str_replace('_', ' ', $namaField)) }}:
                                                                </span>

                                                                <span class="font-medium text-gray-800 dark:text-gray-100">
                                                                    {{ is_array($item->perubahan[$namaField])
                                                                        ? json_encode($item->perubahan[$namaField])
                                                                        : $item->perubahan[$namaField] }}
                                                                </span>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </x-table.cell>

                                    <x-table.cell class="px-2 py-3 text-center align-top whitespace-nowrap">
                                        @if ($item->status === 'pending')
                                            <x-badge variant="warning">
                                                Menunggu
                                            </x-badge>
                                        @elseif ($item->status === 'approved')
                                            <x-badge variant="success">
                                                Disetujui
                                            </x-badge>
                                        @elseif ($item->status === 'rejected')
                                            <x-badge variant="danger">
                                                Ditolak
                                            </x-badge>
                                        @else
                                            <x-badge variant="secondary">
                                                {{ ucfirst($item->status) }}
                                            </x-badge>
                                        @endif
                                    </x-table.cell>

                                    <x-table.cell class="px-2 py-3 text-center align-top whitespace-nowrap">
                                        <div class="text-xs">
                                            {{ $item->created_at->format('d/m/Y') }}
                                        </div>

                                        <div class="mt-0.5 text-[11px] text-gray-500 dark:text-gray-400">
                                            {{ $item->created_at->format('H:i') }}
                                        </div>
                                    </x-table.cell>

                                    <x-table.cell class="px-2 py-3 text-center align-top">
                                        @if ($item->lampiran)
                                            <span class="break-all text-xs text-gray-700 dark:text-gray-300">
                                                <a href="{{ $item->lampiran }}" target='blank' class="link">{{ $item->lampiran }}</a>
                                            </span>
                                        @else
                                            <span class="text-gray-400">
                                                -
                                            </span>
                                        @endif
                                    </x-table.cell>

                                    <x-table.cell class="px-2 py-3 align-top">
                                        <div class="flex flex-wrap justify-center gap-1">
                                            <x-button href="{{ route('user.rencana-pembangunan.show', $item) }}" variant="info"
                                                size="xs" title="Lihat">
                                                <i class="bi bi-eye-fill"></i>
                                            </x-button>

                                            @if ($item->status === 'pending')
                                                <x-button href="{{ route('user.rencana-pembangunan.edit', $item) }}"
                                                    variant="warning" size="xs" title="Edit">
                                                    <i class="bi bi-pencil-fill"></i>
                                                </x-button>

                                                <form action="{{ route('user.rencana-pembangunan.destroy', $item) }}"
                                                    method="POST" onsubmit="return confirm('Hapus pengajuan ini?')">
                                                    @csrf
                                                    @method('DELETE')

                                                    <x-button type="submit" variant="danger" size="xs" title="Hapus">
                                                        <i class="bi bi-trash-fill"></i>
                                                    </x-button>
                                                </form>
                                            @endif
                                        </div>
                                    </x-table.cell>
                                </x-table.row>

                                @empty
                                    <x-table.empty colspan="7" message="Belum ada rencana pembangunan yang diajukan." />
                                @endforelse
                            </x-table>
                        </div>
                    </x-card>
                </div>
            @endsection
