@extends('layouts.admin')

@section('title', 'Rencana Pembangunan')
@section('content')

    {{-- ============================================================
         HEADER HALAMAN (Judul + Search)
         ============================================================ --}}
    <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between mb-5">
        <div>
            <h1 class="text-xl font-semibold text-gray-800 dark:text-gray-100 flex items-center gap-2">
                <i class="bi bi-building-add text-sky-600"></i> Rencana Pembangunan
            </h1>
        </div>

        {{-- SEARCH BAR (Cari Nama Sekolah) --}}
        <div class="flex items-center gap-2 w-full lg:w-auto lg:flex-1 lg:max-w-sm">
            <div class="relative w-full">
                <i class="bi bi-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                <input type="text" id="searchRencana" placeholder="Cari sekolah" autocomplete="off"
                    class="w-full pl-9 pr-8 py-1.5 text-sm rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-sky-700 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-primary-500">
                <button type="button" id="searchRencanaClear"
                    class="hidden absolute right-2 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200"
                    title="Hapus pencarian">
                    <i class="bi bi-x-lg text-xs"></i>
                </button>
            </div>
            <span id="searchRencanaCount" class="hidden text-xs text-gray-500 dark:text-gray-400 whitespace-nowrap"></span>
        </div>
    </div>

    {{-- ============================================================
         CARD & TABEL UTAMA
         ============================================================
         Tabel statik: lebar kolom tetap (No/Status/Diajukan/Aksi pakai
         w-*, Sekolah & Perubahan pakai min-w-* supaya isi panjang tetap
         bisa membungkus). Dibungkus overflow-x-auto sendiri di luar
         x-table (yang sudah responsif juga) supaya tidak mungkin
         mendorong body halaman melebar ke samping.
         ============================================================ --}}
    <div class="card">
        <div class="card-body">
            <div class="w-full overflow-x-auto">
                <x-table bordered hover id="tabelRencanaPembangunan" class="min-w-225">

                    <x-slot:head>
                        <tr class="bg-sky-700 text-white text-center">
                            <x-table.heading class="text-white! align-middle w-10 px-2 py-2">No</x-table.heading>
                            <x-table.heading class="text-white! align-middle min-w-40 px-2 py-2 text-left">Sekolah</x-table.heading>
                            <x-table.heading class="text-white! align-middle min-w-56 px-2 py-2 text-left">Perubahan</x-table.heading>
                            <x-table.heading class="text-white! align-middle w-28 px-2 py-2">Status</x-table.heading>
                            <x-table.heading class="text-white! align-middle w-32 px-2 py-2">Diajukan</x-table.heading>
                            <x-table.heading class="text-white! align-middle w-32 px-2 py-2">Aksi</x-table.heading>
                        </tr>
                    </x-slot:head>

                    @forelse ($rencanaPembangunans as $item)
                        @php
                            $kategoriKeys = is_array($item->pengajuan) ? $item->pengajuan : array_filter([$item->pengajuan]);
                            $perubahan = is_array($item->perubahan) ? $item->perubahan : [];
                            $tambahanKeys = array_keys(array_diff_key($perubahan, array_flip($kategoriKeys)));
                            $jumlahField = collect($kategoriKeys)->sum(fn($k) => count($perubahan[$k] ?? [])) + count($tambahanKeys);
                        @endphp
                        <x-table.row data-search-row
                            data-search-text="{{ strtolower($item->profileSekolah->nama_sekolah ?? '') }}">
                            <x-table.cell class="text-center">
                                {{ $loop->iteration + ($rencanaPembangunans instanceof \Illuminate\Pagination\AbstractPaginator ? $rencanaPembangunans->firstItem() - 1 : 0) }}
                            </x-table.cell>

                            {{-- SEKOLAH & JUDUL --}}
                            <x-table.cell class="align-top">
                                <div class="font-medium text-gray-800 dark:text-gray-100 wrap-break-word">
                                    {{ $item->judul }}
                                </div>
                                <div class="text-xs text-gray-500 dark:text-gray-400 mt-0.5 wrap-break-word">
                                    {{ $item->profileSekolah->nama_sekolah ?? '-' }} &middot; User #{{ $item->user_id }}
                                </div>
                            </x-table.cell>

                            {{-- PERUBAHAN: ringkasan kategori + jumlah field, rincian
                                 lengkap dilihat lewat tombol "Lihat" (halaman show). --}}
                            <x-table.cell class="align-top">
                                <div class="flex flex-wrap gap-1">
                                    @foreach ($kategoriKeys as $kunci)
                                        <span
                                            class="inline-block text-xs px-2 py-0.5 rounded bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200">
                                            {{ \App\Http\Controllers\Admin\PengajuanController::categoryLabel($kunci) }}
                                        </span>
                                    @endforeach
                                    @if (count($tambahanKeys))
                                        <span
                                            class="inline-block text-xs px-2 py-0.5 rounded bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200">
                                            Perubahan Lainnya
                                        </span>
                                    @endif
                                </div>
                                <div class="text-xs text-gray-400 mt-1">{{ $jumlahField }} field diubah</div>
                            </x-table.cell>

                            {{-- STATUS --}}
                            <x-table.cell class="text-center">
                                @php
                                    $statusVariant = match ($item->status) {
                                        'approved' => 'success',
                                        'rejected' => 'danger',
                                        default => 'warning',
                                    };
                                    $statusLabel = match ($item->status) {
                                        'approved' => 'Disetujui',
                                        'rejected' => 'Ditolak',
                                        default => 'Menunggu',
                                    };
                                @endphp
                                <x-badge :variant="$statusVariant" pill>{{ $statusLabel }}</x-badge>
                            </x-table.cell>

                            {{-- DIAJUKAN --}}
                            <x-table.cell class="text-center text-xs whitespace-nowrap">
                                {{ $item->created_at->format('d M Y H:i') }}
                            </x-table.cell>

                            {{-- AKSI --}}
                            <x-table.cell class="text-center">
                                <div class="flex justify-center gap-1">
                                    @if ($item->lampiran)
                                        <x-button href="{{ $item->lampiran }}" target="_blank" rel="noopener"
                                            variant="secondary" size="xs" class="p-1.5!" title="Lihat Lampiran">
                                            <i class="bi bi-paperclip"></i>
                                        </x-button>
                                    @endif

                                    <x-button href="{{ route('pengajuan.show', $item) }}" variant="info" size="xs"
                                        class="p-1.5!" title="Lihat Detail">
                                        <i class="bi bi-eye-fill"></i>
                                    </x-button>

                                    @if ($item->status === 'pending')
                                        <form action="{{ route('pengajuan.approve', $item) }}" method="POST"
                                            class="inline"
                                            onsubmit="return confirm('Setujui pengajuan ini? Data sarana sekolah akan diperbarui sesuai isi pengajuan.');">
                                            @csrf
                                            <x-button type="submit" variant="success" size="xs" class="p-1.5!"
                                                title="Setujui">
                                                <i class="bi bi-check-lg"></i>
                                            </x-button>
                                        </form>
                                        <form action="{{ route('pengajuan.reject', $item) }}" method="POST"
                                            class="inline" onsubmit="return confirm('Tolak pengajuan ini?');">
                                            @csrf
                                            <x-button type="submit" variant="danger" size="xs" class="p-1.5!"
                                                title="Tolak">
                                                <i class="bi bi-x-lg"></i>
                                            </x-button>
                                        </form>
                                    @endif
                                </div>
                            </x-table.cell>
                        </x-table.row>
                    @empty
                        <x-table.empty colspan="6" message="Belum ada rencana pembangunan yang diajukan." />
                    @endforelse

                    {{-- Baris disembunyikan default, dimunculkan JS saat hasil pencarian kosong --}}
                    <x-table.empty id="searchRencanaNoResult" class="hidden" colspan="6"
                        message="Tidak ada sekolah yang cocok dengan pencarian" />
                </x-table>
            </div>

            @if (method_exists($rencanaPembangunans, 'links'))
                <x-pagination :paginator="$rencanaPembangunans" class="mt-3" />
            @endif

        </div>
    </div>

@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('searchRencana');
            const clearBtn = document.getElementById('searchRencanaClear');
            const countEl = document.getElementById('searchRencanaCount');
            const noResultRow = document.getElementById('searchRencanaNoResult');
            const rows = Array.from(document.querySelectorAll('#tabelRencanaPembangunan tbody tr[data-search-row]'));

            function applyFilter() {
                const q = searchInput.value.trim().toLowerCase();
                clearBtn.classList.toggle('hidden', q === '');

                let visibleCount = 0;
                rows.forEach(function (row) {
                    const match = row.dataset.searchText.includes(q);
                    row.classList.toggle('hidden', !match);
                    if (match) visibleCount++;
                });

                if (q === '') {
                    countEl.classList.add('hidden');
                    noResultRow.classList.add('hidden');
                } else {
                    countEl.textContent = visibleCount + ' hasil';
                    countEl.classList.remove('hidden');
                    noResultRow.classList.toggle('hidden', visibleCount !== 0 || rows.length === 0);
                }
            }

            if (searchInput) {
                searchInput.addEventListener('input', applyFilter);
                clearBtn.addEventListener('click', function () {
                    searchInput.value = '';
                    applyFilter();
                    searchInput.focus();
                });
            }
        });
    </script>
@endpush