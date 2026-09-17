@extends('layouts.admin')

@section('title', 'Pengajuan Perubahan Data')

@section('content')

    <div class="max-w-7xl mx-auto px-3 sm:px-4 py-4 sm:py-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-4 sm:mb-6">
            <h1 class="text-lg sm:text-xl font-semibold text-gray-800 dark:text-gray-100 flex items-center gap-2">
                <i class="bi bi-list-check"></i>
                Pengajuan Perubahan Data
            </h1>
        </div>
        {{-- ============================================================
             MOBILE (< sm): satu pengajuan = satu kartu.
             ============================================================ --}}
        <div class="sm:hidden flex flex-col gap-3">
            @forelse ($pengajuans as $item)
                @php
                    $kategoriKeys = is_array($item->pengajuan) ? $item->pengajuan : array_filter([$item->pengajuan]);
                    $perubahan = is_array($item->perubahan) ? $item->perubahan : [];
                    $tambahanKeys = array_keys(array_diff_key($perubahan, array_flip($kategoriKeys)));
                @endphp

                <x-card class="p-3">
                    <div class="flex items-start justify-between gap-2 mb-2">
                        <p class="font-semibold text-gray-800 dark:text-gray-100 wrap-break-word">
                            {{ $item->judul }}
                        </p>

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

                    <div class="text-xs text-gray-500 dark:text-gray-400 mb-2 space-y-1">
                        <div><span class="font-semibold">User ID:</span> {{ $item->user_id }}</div>
                        <div><span class="font-semibold">Sekolah:</span> {{ $item->profileSekolah->nama_sekolah ?? '-' }}</div>
                        <div><span class="font-semibold">Diajukan:</span> {{ $item->created_at->format('d M Y H:i') }}</div>
                    </div>

                    <div class="text-sm mb-3">
                        @foreach ($kategoriKeys as $kunci)
                            <div class="mb-2">
                                <div class="text-xs font-semibold text-gray-400 uppercase mb-1">
                                    {{ \App\Http\Controllers\Admin\PengajuanController::categoryLabel($kunci) }}
                                </div>
                                <ul class="space-y-0.5">
                                    @foreach ($perubahan[$kunci] ?? [] as $field => $value)
                                        <li>
                                            <span class="text-gray-500 dark:text-gray-400">
                                                {{ \App\Http\Controllers\Admin\PengajuanController::fieldLabel($kunci, $field) }}:
                                            </span>
                                            <span class="font-medium text-gray-800 dark:text-gray-200">
                                                {{ is_array($value) ? json_encode($value) : $value }}
                                            </span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endforeach

                        @if (count($tambahanKeys))
                            <div>
                                <div class="text-xs font-semibold text-gray-400 uppercase mb-1">Perubahan Lainnya</div>
                                <ul class="space-y-0.5">
                                    @foreach ($tambahanKeys as $namaField)
                                        <li>
                                            <span class="text-gray-500 dark:text-gray-400">{{ ucwords(str_replace('_', ' ', $namaField)) }}:</span>
                                            <span class="font-medium text-gray-800 dark:text-gray-200">
                                                {{ is_array($perubahan[$namaField] ?? null) ? json_encode($perubahan[$namaField]) : $perubahan[$namaField] ?? '-' }}
                                            </span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>

                    <div class="flex items-center justify-end pt-2 border-t border-gray-200 dark:border-gray-700">
                        <div class="flex gap-1">
                            <x-button href="{{ route('pengajuan.show', $item) }}" variant="info" size="xs" title="Lihat">
                                <i class="bi bi-eye-fill"></i>
                            </x-button>

                            @if ($item->status === 'pending')
                                <form action="{{ route('pengajuan.approve', $item) }}" method="POST" class="inline"
                                    onsubmit="return confirm('Setujui pengajuan ini? Data sarana sekolah akan diperbarui sesuai isi pengajuan.');">
                                    @csrf
                                    <x-button type="submit" variant="success" size="xs" title="Setujui">
                                        <i class="bi bi-check-lg"></i>
                                    </x-button>
                                </form>

                                <form action="{{ route('pengajuan.reject', $item) }}" method="POST" class="inline"
                                    onsubmit="return confirm('Tolak pengajuan ini?');">
                                    @csrf
                                    <x-button type="submit" variant="danger" size="xs" title="Tolak">
                                        <i class="bi bi-x-lg"></i>
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

        {{-- ============================================================
             DESKTOP (>= sm): tabel dipadatkan jadi 5 kolom saja — Sekolah &
             Judul digabung satu kolom, Perubahan & Rincian Pembaruan juga
             digabung satu kolom (kategori jadi sub-judul, field-nya di bawahnya).
             Ini yang paling banyak makan lebar di versi sebelumnya (8 kolom
             dengan beberapa kolom lebar sendiri-sendiri), jadi digabung supaya
             muat di layout admin tanpa perlu scroll di layar biasa.
             ============================================================ --}}
        <div class="hidden sm:block">
            <x-card class="p-4">
                <x-table bordered class="text-sm">
                    <x-slot:head>
                        <tr class="bg-gray-800 text-white text-center">
                            <x-table.heading class="text-white! align-middle px-3 py-2">
                                Sekolah &amp; Judul
                            </x-table.heading>
                            <x-table.heading class="text-white! align-middle px-3 py-2">
                                Perubahan
                            </x-table.heading>
                            <x-table.heading class="text-white! align-middle px-3 py-2 whitespace-nowrap">
                                Status
                            </x-table.heading>
                            <x-table.heading class="text-white! align-middle px-3 py-2 whitespace-nowrap">
                                Diajukan
                            </x-table.heading>
                            <x-table.heading class="text-white! align-middle px-3 py-2 whitespace-nowrap">
                                Aksi
                            </x-table.heading>
                        </tr>
                    </x-slot:head>

                    @forelse ($pengajuans as $item)
                        @php
                            $kategoriKeys = is_array($item->pengajuan) ? $item->pengajuan : array_filter([$item->pengajuan]);
                            $perubahan = is_array($item->perubahan) ? $item->perubahan : [];
                            $tambahanKeys = array_keys(array_diff_key($perubahan, array_flip($kategoriKeys)));
                            $jumlahField = collect($kategoriKeys)->sum(fn ($k) => count($perubahan[$k] ?? [])) + count($tambahanKeys);
                        @endphp

                        <x-table.row class="align-top">
                            {{-- SEKOLAH & JUDUL --}}
                            <x-table.cell class="px-3 py-3 align-top">
                                <div class="font-medium text-gray-800 dark:text-gray-100 wrap-break-word">{{ $item->judul }}</div>
                                <div class="text-xs text-gray-500 dark:text-gray-400 mt-0.5 wrap-break-word">
                                    {{ $item->profileSekolah->nama_sekolah ?? '-' }} &middot; User #{{ $item->user_id }}
                                </div>
                            </x-table.cell>

                            {{-- PERUBAHAN: cuma ringkasan kategori + jumlah field, rincian
                                 lengkapnya dilihat lewat tombol "Lihat" (halaman show).
                                 Sengaja tidak menampilkan detail field:nilai di sini karena
                                 itu yang bikin kolom ini melebar tak terkendali kalau
                                 pengajuannya berisi banyak kategori/field sekaligus. --}}
                            <x-table.cell class="px-3 py-3 align-top">
                                <div class="flex flex-wrap gap-1">
                                    @foreach ($kategoriKeys as $kunci)
                                        <span class="inline-block text-xs px-2 py-0.5 rounded bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200">
                                            {{ \App\Http\Controllers\Admin\PengajuanController::categoryLabel($kunci) }}
                                        </span>
                                    @endforeach
                                    @if (count($tambahanKeys))
                                        <span class="inline-block text-xs px-2 py-0.5 rounded bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200">
                                            Perubahan Lainnya
                                        </span>
                                    @endif
                                </div>
                                <div class="text-xs text-gray-400 mt-1">{{ $jumlahField }} field diubah</div>
                            </x-table.cell>

                            {{-- STATUS --}}
                            <x-table.cell class="text-center px-3 py-3 whitespace-nowrap">
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

                            {{-- DIAJUKAN --}}
                            <x-table.cell class="text-center whitespace-nowrap px-3 py-3">
                                {{ $item->created_at->format('d M Y H:i') }}
                            </x-table.cell>

                            {{-- AKSI --}}
                            <x-table.cell class="text-center px-3 py-3 whitespace-nowrap">
                                <div class="flex justify-center gap-1">
                                    <x-button href="{{ route('pengajuan.show', $item) }}" variant="info" size="xs" class="p-1.5" title="Lihat rincian">
                                        <i class="bi bi-eye-fill"></i>
                                    </x-button>

                                    @if ($item->status === 'pending')
                                        <form action="{{ route('pengajuan.approve', $item) }}" method="POST" class="inline"
                                            onsubmit="return confirm('Setujui pengajuan ini? Data sarana sekolah akan diperbarui sesuai isi pengajuan.');">
                                            @csrf
                                            <x-button type="submit" variant="success" size="xs" class="p-1.5" title="Setujui">
                                                <i class="bi bi-check-lg"></i>
                                            </x-button>
                                        </form>

                                        <form action="{{ route('pengajuan.reject', $item) }}" method="POST" class="inline"
                                            onsubmit="return confirm('Tolak pengajuan ini?');">
                                            @csrf
                                            <x-button type="submit" variant="danger" size="xs" class="p-1.5" title="Tolak">
                                                <i class="bi bi-x-lg"></i>
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
            </x-card>
        </div>

        <x-pagination :paginator="$pengajuans" class="mt-4" />

    </div>
@endsection