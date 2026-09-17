@extends('layouts.app')

@section('title', 'Pengajuan Perubahan Data')

@section('content')
<div class="max-w-7xl mx-auto px-3 sm:px-4 py-4 sm:py-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-4 sm:mb-6">
        <h1 class="text-lg sm:text-xl font-semibold text-gray-800 dark:text-gray-100 flex items-center gap-2">
            <i class="bi bi-list-check"></i>
            Pengajuan Perubahan Data
        </h1>
        <x-button href="{{ route('user.pengajuan.create') }}" variant="primary" class="w-full sm:w-auto justify-center">
            <i class="bi bi-plus-lg"></i> Ajukan Perubahan
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
                        <li>{{ \App\Http\Controllers\User\PengajuanController::categoryLabel($kunci) }}</li>
                    @endforeach
                    @if (count($tambahanKeys))
                        <li>Perubahan Lainnya</li>
                    @endif
                </ul>

                <div class="text-sm mb-2">
                    @foreach ($kategoriKeys as $kunci)
                        <div class="mb-1.5">
                            @if (count($kategoriKeys) > 1 || count($tambahanKeys))
                                <div class="text-xs font-semibold text-gray-400 uppercase">{{ \App\Http\Controllers\User\PengajuanController::categoryLabel($kunci) }}</div>
                            @endif
                            <ul class="space-y-0.5">
                                @forelse (($item->perubahan[$kunci] ?? []) as $field => $value)
                                    <li>
                                        <span class="text-gray-500 dark:text-gray-400">{{ \App\Http\Controllers\User\PengajuanController::fieldLabel($kunci, $field) }}:</span>
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
                                        <span class="text-gray-500 dark:text-gray-400">{{ ucwords(str_replace('_', ' ', $namaField)) }}:</span>
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
                </div>
            </x-card>
        @empty
            <x-card class="p-6 text-center text-gray-500 dark:text-gray-400">
                <i class="bi bi-inbox text-2xl block mb-2"></i>
                Belum ada pengajuan perubahan data.
            </x-card>
        @endforelse
    </div>

    <div class="hidden sm:block card">
        <div class="card-body p-4">
            <x-table bordered class="text-sm">
                <x-slot:head>
                    <tr class="bg-gray-800 text-white text-center">
                        <x-table.heading class="text-white! align-middle px-3 py-2">
                            Judul
                        </x-table.heading>
                        <x-table.heading class="text-white! align-middle px-3 py-2">
                            Perubahan
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
                    $kategoriKeys = is_array($item->pengajuan) ? $item->pengajuan : array_filter([$item->pengajuan]);
                    $tambahanKeys = array_keys(array_diff_key($item->perubahan ?? [], array_flip($kategoriKeys)));
                @endphp
                <x-table.row class="align-middle">
                    <x-table.cell class="font-medium px-3 py-2.5">
                        {{ $item->judul }}
                    </x-table.cell>
                    <x-table.cell class="font-medium px-3 py-2.5">
                        <ul class="space-y-0.5">
                            @foreach ($kategoriKeys as $kunci)
                                <li>{{ \App\Http\Controllers\User\PengajuanController::categoryLabel($kunci) }}</li>
                            @endforeach
                            @if (count($tambahanKeys))
                                <li>Perubahan Lainnya</li>
                            @endif
                        </ul>
                    </x-table.cell>
                    <x-table.cell class="px-3 py-2.5">
                        <ul class="space-y-1 text-sm">
                            @foreach ($kategoriKeys as $kunci)
                                <li>
                                    @if (count($kategoriKeys) > 1 || count($tambahanKeys))
                                        <div class="text-xs font-semibold text-gray-400 uppercase">{{ \App\Http\Controllers\User\PengajuanController::categoryLabel($kunci) }}</div>
                                    @endif
                                    <ul class="space-y-0.5 pl-2">
                                        @forelse (($item->perubahan[$kunci] ?? []) as $field => $value)
                                            <li>
                                                <span class="text-gray-500 dark:text-gray-400">{{ \App\Http\Controllers\User\PengajuanController::fieldLabel($kunci, $field) }}:</span>
                                                <span class="font-medium">{{ $value }}</span>
                                            </li>
                                        @empty
                                            <li class="text-gray-400 italic">Diajukan untuk dibangun</li>
                                        @endforelse
                                    </ul>
                                </li>
                            @endforeach
                            @if (count($tambahanKeys))
                                <li>
                                    @if (count($kategoriKeys) > 0)
                                        <div class="text-xs font-semibold text-gray-400 uppercase">Perubahan Lainnya</div>
                                    @endif
                                    <ul class="space-y-0.5 pl-2">
                                        @foreach ($tambahanKeys as $namaField)
                                            <li>
                                                <span class="text-gray-500 dark:text-gray-400">{{ ucwords(str_replace('_', ' ', $namaField)) }}:</span>
                                                <span class="font-medium">{{ $item->perubahan[$namaField] }}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                </li>
                            @endif
                        </ul>
                    </x-table.cell>
                    <x-table.cell class="text-center px-3 py-2.5 whitespace-nowrap">
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
                <x-table.empty colspan="6" message="Belum ada pengajuan perubahan data." />
            @endforelse
            </x-table>
        </div>
    </div>

    <x-pagination :paginator="$pengajuans" class="mt-4" />
</div>
@endsection