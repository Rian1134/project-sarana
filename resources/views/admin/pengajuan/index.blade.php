@extends('layouts.admin')

@section('title', 'Laporan Kerusakan')
@section('content')

    {{-- ============================================================
         HEADER HALAMAN (Judul)
         ============================================================
         Catatan: sesuaikan $laporanKerusakans dengan nama variabel
         yang dikirim dari controller (bisa jadi paginated collection).
         ============================================================ --}}
    <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between mb-5">
        <div>
            <h1 class="text-xl font-semibold text-gray-800 dark:text-gray-100 flex items-center gap-2">
                <i class="bi bi-exclamation-triangle-fill text-amber-500"></i> Laporan Kerusakan
            </h1>
        </div>

        {{-- SEARCH BAR (Cari Nama Sekolah) --}}
        <div class="flex items-center gap-2 w-full lg:w-auto lg:flex-1 lg:max-w-sm">
            <div class="relative w-full">
                <i class="bi bi-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                <input type="text" id="searchLaporan" placeholder="Cari sekolah" autocomplete="off"
                    class="w-full pl-9 pr-8 py-1.5 text-sm rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-sky-700 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-primary-500">
                <button type="button" id="searchLaporanClear"
                    class="hidden absolute right-2 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200"
                    title="Hapus pencarian">
                    <i class="bi bi-x-lg text-xs"></i>
                </button>
            </div>
            <span id="searchLaporanCount" class="hidden text-xs text-gray-500 dark:text-gray-400 whitespace-nowrap"></span>
        </div>
    </div>

    {{-- ============================================================
         CARD & TABEL UTAMA
         ============================================================ --}}
    <div class="card">
        <div class="card-body">

            <x-table bordered hover id="tabelLaporanKerusakan">

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

                @forelse ($laporanKerusakans as $item)
                    <x-table.row data-search-row data-search-text="{{ strtolower($item->profileSekolah->nama_sekolah ?? $item->sekolah->nama_sekolah ?? '') }}">
                        <x-table.cell class="text-center">
                            {{ $loop->iteration + ($laporanKerusakans instanceof \Illuminate\Pagination\AbstractPaginator ? $laporanKerusakans->firstItem() - 1 : 0) }}
                        </x-table.cell>

                        {{-- SEKOLAH --}}
                        <x-table.cell>
                            <span class="font-medium text-gray-700 dark:text-gray-200">
                                {{ $item->profileSekolah->nama_sekolah ?? $item->sekolah->nama_sekolah ?? '-' }}
                            </span>
                        </x-table.cell>

                        {{-- PERUBAHAN --}}
                        <x-table.cell>
                            @if (!empty($item->perubahan) && is_iterable($item->perubahan))
                                <ul class="list-disc list-inside space-y-0.5 text-xs">
                                    @foreach ($item->perubahan as $field => $perubahan)
                                        <li>
                                            <span class="font-medium">{{ is_string($field) ? \Illuminate\Support\Str::headline($field) : ($perubahan['label'] ?? '') }}:</span>
                                            <span class="text-red-500 line-through">{{ $perubahan['lama'] ?? $perubahan['old'] ?? '-' }}</span>
                                            <i class="bi bi-arrow-right mx-1 text-gray-400"></i>
                                            <span class="text-green-600 font-medium">{{ $perubahan['baru'] ?? $perubahan['new'] ?? '-' }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <span class="text-gray-600 dark:text-gray-300 text-xs">
                                    {{ $item->deskripsi ?? $item->keterangan ?? '-' }}
                                </span>
                            @endif
                        </x-table.cell>

                        {{-- STATUS --}}
                        <x-table.cell class="text-center">
                            @php
                                $statusVariant = match ($item->status) {
                                    'disetujui', 'approved' => 'success',
                                    'ditolak', 'rejected' => 'danger',
                                    default => 'warning',
                                };
                                $statusLabel = match ($item->status) {
                                    'disetujui', 'approved' => 'Disetujui',
                                    'ditolak', 'rejected' => 'Ditolak',
                                    default => 'Menunggu',
                                };
                            @endphp
                            <x-badge :variant="$statusVariant" pill>{{ $statusLabel }}</x-badge>
                        </x-table.cell>

                        {{-- DIAJUKAN --}}
                        <x-table.cell class="text-center text-xs whitespace-nowrap">
                            {{ optional($item->created_at)->translatedFormat('d M Y H:i') ?? '-' }}
                        </x-table.cell>

                        {{-- AKSI --}}
                        <x-table.cell class="text-center">
                            <div class="flex justify-center gap-1">
                                <x-button href="{{ route('laporan-kerusakan.show', $item->id) }}" variant="info"
                                    size="xs" class="p-1.5!" title="Lihat Detail">
                                    <i class="bi bi-eye-fill"></i>
                                </x-button>

                                @if ($item->status === 'pending' || $item->status === null)
                                    <form action="{{ route('pengajuan.approve', $item->id) }}" method="POST" class="inline">
                                        @csrf
                                        <x-button type="submit" variant="success" size="xs" class="p-1.5!" title="Setujui">
                                            <i class="bi bi-check-lg"></i>
                                        </x-button>
                                    </form>
                                    <x-button variant="danger" size="xs" class="p-1.5!" title="Tolak"
                                        data-modal-open="rejectModal{{ $item->id }}">
                                        <i class="bi bi-x-lg"></i>
                                    </x-button>
                                @endif
                            </div>
                        </x-table.cell>
                    </x-table.row>
                @empty
                    <x-table.empty colspan="6" message="Belum ada laporan kerusakan." />
                @endforelse

                {{-- Baris disembunyikan default, dimunculkan JS saat hasil pencarian kosong --}}
                <x-table.empty id="searchLaporanNoResult" class="hidden" colspan="6"
                    message="Tidak ada sekolah yang cocok dengan pencarian" />
            </x-table>

            @if (method_exists($laporanKerusakans, 'links'))
                <x-pagination :paginator="$laporanKerusakans" class="mt-3" />
            @endif

        </div>
    </div>

    {{-- ============================================================
         MODAL TOLAK (Loop untuk setiap item berstatus pending)
         ============================================================ --}}
    @foreach ($laporanKerusakans as $item)
        @if ($item->status === 'pending' || $item->status === null)
            <x-modal id="rejectModal{{ $item->id }}" size="sm" centered>
                <x-slot:header>
                    <div class="flex items-center gap-2 text-red-600">
                        <i class="bi bi-x-circle-fill text-xl"></i>
                        <span>Tolak Laporan</span>
                    </div>
                </x-slot:header>

                <form action="{{ route('pengajuan.reject', $item->id) }}" method="POST">
                    @csrf
                    <p class="text-sm text-gray-500 dark:text-gray-400 font-medium mb-3">
                        {{ $item->profileSekolah->nama_sekolah ?? $item->sekolah->nama_sekolah ?? '-' }}
                    </p>
                    <x-form.textarea name="alasan_penolakan" label="Alasan Penolakan" rows="3" required />

                    <x-slot:footer>
                        <div class="flex flex-wrap justify-end gap-2 w-full">
                            <x-button type="button" variant="secondary" data-modal-close>
                                <i class="bi bi-x-circle me-1"></i> Batal
                            </x-button>
                            <x-button type="submit" variant="danger">
                                <i class="bi bi-x-lg me-1"></i> Ya, Tolak
                            </x-button>
                        </div>
                    </x-slot:footer>
                </form>
            </x-modal>
        @endif
    @endforeach

@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('searchLaporan');
            const clearBtn = document.getElementById('searchLaporanClear');
            const countEl = document.getElementById('searchLaporanCount');
            const noResultRow = document.getElementById('searchLaporanNoResult');
            const rows = Array.from(document.querySelectorAll('#tabelLaporanKerusakan tbody tr[data-search-row]'));

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