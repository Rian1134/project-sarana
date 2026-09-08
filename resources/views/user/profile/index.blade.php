@extends('layouts.app')

@section('title')
    Profil Sekolah
@endsection

@section('content')
    <div class="container mx-auto px-3 sm:px-4 py-3 sm:py-4">
        <div class="flex flex-col gap-4">
            <!-- Header -->
            <div class="flex flex-wrap items-center justify-between gap-3">
                <div>
                    <h1 class="text-xl font-semibold text-gray-800 dark:text-gray-100 flex items-center gap-2">
                        <i class="bi bi-person-circle text-blue-600 dark:text-blue-400"></i>
                        Profil Sekolah
                    </h1>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Informasi akun dan data sekolah</p>
                </div>
                <div class="flex flex-wrap gap-2">
                    @if ($profileSekolah)
                        <a href="{{ route('user.data.edit', $profileSekolah->id) }}" class="inline-flex">
                            <x-button variant="warning" size="sm">
                                <i class="bi bi-database-up me-1"></i> Update
                            </x-button>
                        </a>
                        <x-button type="button" variant="danger" size="sm" data-modal-open="hapusDataSekolahModal">
                            <i class="bi bi-trash me-1"></i> Hapus
                        </x-button>
                    @else
                        <a href="{{ route('user.data.create') }}" class="inline-flex">
                            <x-button variant="primary" size="sm">
                                <i class="bi bi-plus-lg me-1"></i> Tambah Data Sekolah
                            </x-button>
                        </a>
                    @endif
                </div>
            </div>
            <!-- ============================================================
                         Profil User (kiri) & Data Sekolah (kanan)
                         ============================================================ -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                <!-- Kiri: Profil User -->
                <x-card>
                    <x-slot:header>
                        <div class="flex items-center gap-2 text-blue-600 dark:text-blue-400">
                            <i class="bi bi-person-lines-fill"></i>
                            Profil Akun
                        </div>
                    </x-slot:header>

                    <div class="flex flex-col gap-6">
                        <!-- Profile Summary -->
                        <div
                            class="flex flex-col sm:flex-row items-center sm:items-start gap-4 sm:gap-6 pb-4 border-b border-gray-200 dark:border-gray-700">
                            <x-avatar :name="$user->name" size="xl" />
                            <div class="text-center sm:text-left">
                                <p class="text-xl font-semibold text-gray-800 dark:text-gray-100">{{ $user->name }}</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $user->email }}</p>
                                <div class="flex flex-wrap justify-center sm:justify-start gap-1 mt-1">
                                    @foreach ($user->roles as $role)
                                        <x-badge variant="primary">{{ ucfirst($role->name) }}</x-badge>
                                    @endforeach
                                </div>
                                <p class="text-xs text-gray-400 dark:text-gray-500 mt-2">
                                    <i class="bi bi-calendar3 me-1"></i>
                                    Bergabung sejak {{ $user->created_at?->translatedFormat('d F Y') ?? '-' }}
                                </p>
                            </div>
                        </div>

                        <!-- Detail Informasi -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="text-sm text-gray-500 dark:text-gray-400 font-medium">Nama Lengkap</label>
                                <p class="text-base font-semibold text-gray-800 dark:text-gray-100">{{ $user->name }}</p>
                            </div>
                            <div>
                                <label class="text-sm text-gray-500 dark:text-gray-400 font-medium">Email</label>
                                <p class="text-base font-semibold text-gray-800 dark:text-gray-100">{{ $user->email }}</p>
                            </div>
                            <div>
                                <label class="text-sm text-gray-500 dark:text-gray-400 font-medium">Role</label>
                                <p class="text-base font-semibold text-gray-800 dark:text-gray-100">
                                    @foreach ($user->roles as $role)
                                        {{ ucfirst($role->name) }}
                                    @endforeach
                                </p>
                            </div>
                            <div>
                                <label class="text-sm text-gray-500 dark:text-gray-400 font-medium">Bergabung Sejak</label>
                                <p class="text-base font-semibold text-gray-800 dark:text-gray-100">
                                    {{ $user->created_at?->translatedFormat('d F Y') ?? '-' }}
                                </p>
                            </div>
                            <div>
                                <label class="text-sm text-gray-500 dark:text-gray-400 font-medium">Password</label>
                                <p class="text-base font-semibold text-gray-800 dark:text-gray-100">••••••••</p>
                            </div>
                            <div>
                                <label class="text-sm text-gray-500 dark:text-gray-400 font-medium">Terakhir
                                    Diperbarui</label>
                                <p class="text-base font-semibold text-gray-800 dark:text-gray-100">
                                    {{ $user->updated_at?->translatedFormat('d F Y, H:i') ?? '-' }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <x-slot:footer>
                        <div class="flex flex-wrap justify-end gap-2">
                            <a href="{{ route('user.profile.edit') }}" class="inline-flex">
                                <x-button variant="primary" size="sm">
                                    <i class="bi bi-pencil-square me-1"></i> Edit Profil
                                </x-button>
                            </a>
                            <a href="{{ route('user.profile.change-password') }}" class="inline-flex">
                                <x-button variant="warning" size="sm">
                                    <i class="bi bi-key me-1"></i> Ubah Password
                                </x-button>
                            </a>
                        </div>
                    </x-slot:footer>
                </x-card>

                <!-- Kanan: Data Sekolah -->
                @if ($profileSekolah)
                    <x-card>
                        <x-slot:header>
                            <div class="flex items-center gap-2 text-green-600 dark:text-green-400">
                                <i class="bi bi-building"></i>
                                Data Sekolah
                            </div>
                        </x-slot:header>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="text-sm text-gray-500 dark:text-gray-400 font-medium">Nama Sekolah</label>
                                <p class="text-base font-semibold text-gray-800 dark:text-gray-100">
                                    {{ $profileSekolah->nama_sekolah }}</p>
                            </div>
                            <div>
                                <label class="text-sm text-gray-500 dark:text-gray-400 font-medium">NPSN</label>
                                <p class="text-base font-semibold text-gray-800 dark:text-gray-100">
                                    {{ $profileSekolah->NPSN }}</p>
                            </div>
                            <div>
                                <label class="text-sm text-gray-500 dark:text-gray-400 font-medium">Status Sekolah</label>
                                <p class="text-base font-semibold">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        {{ $profileSekolah->status_sekolah == 'negeri' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300' : 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300' }}">
                                        {{ ucfirst($profileSekolah->status_sekolah) }}
                                    </span>
                                </p>
                            </div>
                            <div>
                                <label class="text-sm text-gray-500 dark:text-gray-400 font-medium">Akreditasi</label>
                                <p class="text-base font-semibold">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        {{ $profileSekolah->akreditasi == 'A'
                                            ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300'
                                            : ($profileSekolah->akreditasi == 'B'
                                                ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300'
                                                : ($profileSekolah->akreditasi == 'C'
                                                    ? 'bg-orange-100 text-orange-800 dark:bg-orange-900/30 dark:text-orange-300'
                                                    : 'bg-gray-100 text-gray-800 dark:bg-gray-700/30 dark:text-gray-300')) }}">
                                        {{ $profileSekolah->akreditasi == 'belum_terakreditasi' ? 'Belum Terakreditasi' : $profileSekolah->akreditasi }}
                                    </span>
                                </p>
                            </div>
                            <!-- Website -->
                            <div class="sm:col-span-2">
                                <label class="text-sm text-gray-500 dark:text-gray-400 font-medium">Website</label>
                                <p class="text-base font-semibold text-gray-800 dark:text-gray-100">
                                    @if ($profileSekolah->website)
                                        <a href="{{ $profileSekolah->website }}" target="_blank"
                                            class="text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 transition-colors">
                                            Kunjungi Laman
                                            <i class="bi bi-box-arrow-up-right text-base ms-1"></i>
                                        </a>
                                    @else
                                        <span class="text-gray-400 dark:text-gray-500">-</span>
                                    @endif
                                </p>
                            </div>
                            <div class="sm:col-span-2">
                                <label class="text-sm text-gray-500 dark:text-gray-400 font-medium">Alamat Sekolah</label>
                                <p
                                    class="text-base font-semibold text-gray-800 dark:text-gray-100 wrap-break-word hyphens-auto">
                                    {{ $profileSekolah->alamat_sekolah }}
                                </p>
                            </div>
                            <div>
                                <label class="text-sm text-gray-500 dark:text-gray-400 font-medium">Kepala Sekolah</label>
                                <p class="text-base font-semibold text-gray-800 dark:text-gray-100">
                                    {{ $profileSekolah->nama_kepala_sekolah }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">NIP: {{ $profileSekolah->NIP }}</p>
                            </div>
                            <div>
                                <label class="text-sm text-gray-500 dark:text-gray-400 font-medium">Nomor HP</label>
                                <p class="text-base font-semibold text-gray-800 dark:text-gray-100">
                                    {{ $profileSekolah->nomor_hp }}</p>
                            </div>
                        </div>

                        <div class="mt-4 flex flex-wrap justify-end gap-2">
                            {{-- kosong sementara --}}
                        </div>
                    </x-card>
                @else
                    <!-- Belum Ada Data Sekolah -->
                    <div
                        class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                        <div class="flex flex-col items-center justify-center text-center py-6 sm:py-8 px-3 sm:px-4 h-full">
                            <div class="relative inline-block">
                                <div
                                    class="w-16 h-16 sm:w-20 sm:h-20 rounded-full bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center mx-auto mb-3 sm:mb-4">
                                    <i class="bi bi-building text-3xl sm:text-4xl text-blue-600 dark:text-blue-400"></i>
                                </div>
                                <div
                                    class="absolute -top-1 -right-1 w-5 h-5 sm:w-6 sm:h-6 rounded-full bg-yellow-400 flex items-center justify-center shadow-lg">
                                    <i class="bi bi-plus-lg text-white text-[8px] sm:text-xs"></i>
                                </div>
                            </div>
                            <h3 class="text-base sm:text-lg font-bold text-gray-800 dark:text-gray-100 mb-1">
                                Belum Ada Data Sekolah
                            </h3>
                            <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mb-3 sm:mb-4">
                                Tambahkan data sekolah untuk melengkapi profil Anda.
                            </p>
                            <a href="{{ route('user.data.create') }}"
                                class="inline-flex items-center px-4 sm:px-5 py-1.5 sm:py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors shadow-sm hover:shadow-md">
                                <i class="bi bi-plus-lg me-1"></i>
                                Tambah Data Sekolah
                            </a>
                        </div>
                    </div>
                @endif
            </div>

            @if ($profileSekolah)
                <!-- ===== MODAL KONFIRMASI HAPUS DATA SEKOLAH ===== -->
                <x-modal id="hapusDataSekolahModal" size="sm" centered>
                    <x-slot:header>
                        <div class="flex items-center gap-2 text-red-600">
                            <i class="bi bi-exclamation-triangle-fill text-xl"></i>
                            <span>Konfirmasi Hapus Data</span>
                        </div>
                    </x-slot:header>

                    <div class="text-center py-4">
                        <div class="text-5xl text-red-500 mb-4">
                            <i class="bi bi-trash"></i>
                        </div>
                        <h4 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-2">
                            Yakin ingin menghapus data sekolah ini?
                        </h4>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            Seluruh data sarana &amp; prasarana <strong>{{ $profileSekolah->nama_sekolah }}</strong>
                            (jumlah siswa, rombel, ruang kelas, fasilitas, furnitur, dst) akan ikut terhapus.
                            Tindakan ini tidak bisa dibatalkan.
                        </p>
                    </div>

                    <x-slot:footer>
                        <div class="flex flex-wrap justify-end gap-2 w-full">
                            <x-button variant="secondary" data-modal-close>
                                <i class="bi bi-x-circle me-1"></i> Batal
                            </x-button>
                            <form action="{{ route('user.data.destroy', $profileSekolah->id) }}" method="POST"
                                class="inline">
                                @csrf
                                @method('DELETE')
                                <x-button variant="danger" type="submit">
                                    <i class="bi bi-trash me-1"></i> Ya, Hapus
                                </x-button>
                            </form>
                        </div>
                    </x-slot:footer>
                </x-modal>
            @endif

            @if ($profileSekolah)
                @php
                    $chartSiswa = [
                        (int) ($profileSekolah->jumlahSiswa?->vii ?? 0),
                        (int) ($profileSekolah->jumlahSiswa?->viii ?? 0),
                        (int) ($profileSekolah->jumlahSiswa?->ix ?? 0),
                    ];
                    $chartRombel = [
                        (int) ($profileSekolah->jumlahRombel?->vii ?? 0),
                        (int) ($profileSekolah->jumlahRombel?->viii ?? 0),
                        (int) ($profileSekolah->jumlahRombel?->ix ?? 0),
                    ];
                    $chartRuangKelas = [
                        (int) ($profileSekolah->ruangKelas?->baik ?? 0),
                        (int) ($profileSekolah->ruangKelas?->rusak ?? 0),
                    ];
                    $chartRkbRehab = [
                        (int) ($profileSekolah->ruangKelasBaru?->jumlah ?? 0),
                        (int) ($profileSekolah->rehabilitasiRuangKelas?->jumlah ?? 0),
                    ];

                    // ============================================================
                    // Fasilitas Ada/Tidak + Kondisi (yang tadinya belum ditampilkan)
                    // ============================================================
                    $fasilitas = [
                        'ruangPerpustakaan' => ['label' => 'Perpustakaan', 'icon' => 'bi-book'],
                        'ruangKepalaSekolah' => ['label' => 'R. Kepala Sekolah', 'icon' => 'bi-person-badge'],
                        'ruangGuru' => ['label' => 'R. Guru', 'icon' => 'bi-easel'],
                        'ruangKantorTu' => ['label' => 'Kantor / TU', 'icon' => 'bi-folder'],
                        'labIpa' => ['label' => 'Lab IPA', 'icon' => 'bi-flask'],
                        'labKomputer' => ['label' => 'Lab Komputer', 'icon' => 'bi-pc-display'],
                        'unitKesehatanSekolah' => ['label' => 'UKS', 'icon' => 'bi-heart-pulse'],
                        'rumahDinas' => ['label' => 'Rumah Dinas', 'icon' => 'bi-house-door'],
                        'rumahIbadah' => ['label' => 'Rumah Ibadah', 'icon' => 'bi-moon-stars'],
                        'lapanganSekolah' => ['label' => 'Lapangan Sekolah', 'icon' => 'bi-flag'],
                        'pagarSekolah' => ['label' => 'Pagar Sekolah', 'icon' => 'bi-bricks'],
                        'airBersih' => ['label' => 'Air Bersih', 'icon' => 'bi-droplet'],
                    ];

                    $countAda = 0;
                    $countTidakAda = 0;
                    $countKondisiBaik = 0;
                    $countKondisiRusak = 0;
                    $countKondisiNihil = 0;
                    foreach ($fasilitas as $rel => $info) {
                        $status = $profileSekolah->$rel?->{'ada/tidak_ada'} ?? null;
                        $kondisiFasilitas = $profileSekolah->$rel?->kodisi ?? null;

                        if ($status === 'ada') {
                            $countAda++;
                        } else {
                            $countTidakAda++;
                        }

                        if ($kondisiFasilitas === 'baik') {
                            $countKondisiBaik++;
                        } elseif ($kondisiFasilitas === 'rusak') {
                            $countKondisiRusak++;
                        } else {
                            $countKondisiNihil++;
                        }
                    }
                    $chartFasilitas = [$countAda, $countTidakAda];
                    $chartFasilitasKondisi = [$countKondisiBaik, $countKondisiRusak, $countKondisiNihil];

                    // ============================================================
                    // Furnitur, Toilet & Elektronik (Baik/Rusak)
                    // ============================================================
                    $furnitur = [
                        'toiletSiswa' => 'Toilet Siswa',
                        'toiletGuru' => 'Toilet Guru',
                        'kursiSiswa' => 'Kursi Siswa',
                        'mejaSiswa' => 'Meja Siswa',
                        'kursiGuru' => 'Kursi Guru',
                        'mejaGuru' => 'Meja Guru',
                        'laptop' => 'Laptop',
                        'komputer' => 'Komputer/PC',
                        'chromebook' => 'Chromebook',
                    ];

                    $chartFurniturLabel = [];
                    $chartFurniturBaik = [];
                    $chartFurniturRusak = [];
                    foreach ($furnitur as $rel => $label) {
                        $chartFurniturLabel[] = $label;
                        $chartFurniturBaik[] = (int) ($profileSekolah->$rel?->baik ?? 0);
                        $chartFurniturRusak[] = (int) ($profileSekolah->$rel?->rusak ?? 0);
                    }
                    $chartFurniturTotal = [array_sum($chartFurniturBaik), array_sum($chartFurniturRusak)];
                @endphp

                <!-- ============================================================
                             RKB & Rehabilitasi Ruang Kelas
                             ============================================================ -->
                <x-card>
                    <x-slot:header>
                        <div class="flex items-center gap-2 text-gray-700 dark:text-gray-200">
                            <i class="bi bi-tools"></i>
                            Rencana Pembangunan &amp; Rehabilitasi Ruang Kelas
                        </div>
                    </x-slot:header>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="text-sm text-gray-500 dark:text-gray-400 font-medium">Pembangunan Ruang Kelas
                                Baru (RKB)</label>
                            <div class="bg-blue-50 dark:bg-blue-900/20 p-3 sm:p-4 rounded-lg text-center mt-1.5">
                                <p class="text-2xl sm:text-3xl font-bold text-blue-600 dark:text-blue-400">
                                    {{ $chartRkbRehab[0] }}
                                </p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Ruang Kelas Baru</p>
                                <p class="text-[11px] text-gray-400 dark:text-gray-500 mt-0.5">
                                    Periode {{ $rkbPeriode->label() }}
                                </p>
                            </div>
                        </div>
                        <div>
                            <label class="text-sm text-gray-500 dark:text-gray-400 font-medium">Rehabilitasi Ruang
                                Kelas</label>
                            <div class="bg-orange-50 dark:bg-orange-900/20 p-3 sm:p-4 rounded-lg text-center mt-1.5">
                                <p class="text-2xl sm:text-3xl font-bold text-orange-600 dark:text-orange-400">
                                    {{ $chartRkbRehab[1] }}
                                </p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Ruang Kelas</p>
                                <p class="text-[11px] text-gray-400 dark:text-gray-500 mt-0.5">
                                    Periode {{ $rehabilitasiPeriode->label() }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 h-40 sm:h-48">
                        <canvas id="rkbRehabChart"></canvas>
                    </div>
                </x-card>

                <!-- ============================================================
                             Jumlah Siswa, Rombongan Belajar & Ruang Kelas (di bawah,
                             selebar penuh)
                             ============================================================ -->
                <x-card>
                    <x-slot:header>
                        <div class="flex items-center gap-2 text-gray-700 dark:text-gray-200">
                            <i class="bi bi-bar-chart-fill"></i>
                            Jumlah Siswa, Rombongan Belajar &amp; Ruang Kelas
                        </div>
                    </x-slot:header>

                    <div class="flex flex-col gap-4">
                        <!-- Baris atas: Jumlah Siswa & Jumlah Rombel -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <!-- Jumlah Siswa -->
                            <div>
                                <label class="text-sm text-gray-500 dark:text-gray-400 font-medium">Jumlah Siswa</label>
                                <div class="grid grid-cols-3 gap-2 mt-1">
                                    <div class="bg-green-50 dark:bg-green-900/20 p-2 rounded-lg text-center">
                                        <p class="text-xs text-gray-500 dark:text-gray-400">Kelas VII</p>
                                        <p class="text-lg font-bold text-gray-900 dark:text-white">
                                            {{ $chartSiswa[0] }}</p>
                                    </div>
                                    <div class="bg-emerald-50 dark:bg-emerald-900/20 p-2 rounded-lg text-center">
                                        <p class="text-xs text-gray-500 dark:text-gray-400">Kelas VIII</p>
                                        <p class="text-lg font-bold text-gray-900 dark:text-white">
                                            {{ $chartSiswa[1] }}</p>
                                    </div>
                                    <div class="bg-teal-50 dark:bg-teal-900/20 p-2 rounded-lg text-center">
                                        <p class="text-xs text-gray-500 dark:text-gray-400">Kelas IX</p>
                                        <p class="text-lg font-bold text-gray-900 dark:text-white">
                                            {{ $chartSiswa[2] }}</p>
                                    </div>
                                </div>
                                <div class="mt-2 pt-2 border-t border-gray-200 dark:border-gray-700">
                                    <div class="flex justify-between items-center">
                                        <span class="text-xs text-gray-500 dark:text-gray-400">Total</span>
                                        <span class="text-sm font-bold text-green-600 dark:text-green-400">
                                            {{ array_sum($chartSiswa) }}
                                        </span>
                                    </div>
                                </div>
                                <div class="mt-3 h-36 sm:h-40">
                                    <canvas id="siswaChart"></canvas>
                                </div>
                            </div>

                            <!-- Jumlah Rombel -->
                            <div>
                                <label class="text-sm text-gray-500 dark:text-gray-400 font-medium">Jumlah Rombongan
                                    Belajar</label>
                                <div class="grid grid-cols-3 gap-2 mt-1">
                                    <div class="bg-purple-50 dark:bg-purple-900/20 p-2 rounded-lg text-center">
                                        <p class="text-xs text-gray-500 dark:text-gray-400">Kelas VII</p>
                                        <p class="text-lg font-bold text-gray-900 dark:text-white">
                                            {{ $chartRombel[0] }}</p>
                                    </div>
                                    <div class="bg-violet-50 dark:bg-violet-900/20 p-2 rounded-lg text-center">
                                        <p class="text-xs text-gray-500 dark:text-gray-400">Kelas VIII</p>
                                        <p class="text-lg font-bold text-gray-900 dark:text-white">
                                            {{ $chartRombel[1] }}</p>
                                    </div>
                                    <div class="bg-indigo-50 dark:bg-indigo-900/20 p-2 rounded-lg text-center">
                                        <p class="text-xs text-gray-500 dark:text-gray-400">Kelas IX</p>
                                        <p class="text-lg font-bold text-gray-900 dark:text-white">
                                            {{ $chartRombel[2] }}</p>
                                    </div>
                                </div>
                                <div class="mt-2 pt-2 border-t border-gray-200 dark:border-gray-700">
                                    <div class="flex justify-between items-center">
                                        <span class="text-xs text-gray-500 dark:text-gray-400">Total</span>
                                        <span class="text-sm font-bold text-purple-600 dark:text-purple-400">
                                            {{ array_sum($chartRombel) }}
                                        </span>
                                    </div>
                                </div>
                                <div class="mt-3 h-36 sm:h-40">
                                    <canvas id="rombelChart"></canvas>
                                </div>
                            </div>
                        </div>

                        <!-- Baris bawah: Jumlah Ruang Kelas (selebar penuh, di tengah) -->
                        <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
                            <label class="text-sm text-gray-500 dark:text-gray-400 font-medium text-center block">Jumlah
                                Ruang Kelas</label>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6 mt-3 items-center">
                                <div class="grid grid-cols-3 gap-2 sm:gap-4">
                                    <div
                                        class="bg-sky-50 dark:bg-sky-900/20 p-3 sm:p-6 rounded-lg text-center flex flex-col items-center justify-center">
                                        <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400">Baik</p>
                                        <p class="text-xl sm:text-4xl font-bold text-gray-900 dark:text-white">
                                            {{ $chartRuangKelas[0] }}</p>
                                    </div>
                                    <div
                                        class="bg-rose-50 dark:bg-red-900/20 p-3 sm:p-6 rounded-lg text-center flex flex-col items-center justify-center">
                                        <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400">Rusak</p>
                                        <p class="text-xl sm:text-4xl font-bold text-gray-900 dark:text-white">
                                            {{ $chartRuangKelas[1] }}</p>
                                    </div>
                                    <div
                                        class="bg-sky-100 dark:bg-sky-900/40 p-3 sm:p-6 rounded-lg text-center flex flex-col items-center justify-center">
                                        <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400">Total</p>
                                        <p class="text-xl sm:text-4xl font-bold text-sky-700 dark:text-sky-300">
                                            {{ array_sum($chartRuangKelas) }}
                                        </p>
                                    </div>
                                </div>
                                <div class="h-40 sm:h-48 flex items-center justify-center">
                                    <canvas id="ruangKelasChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </x-card>

                <!-- ============================================================
                             Fasilitas Ruang & Bangunan Sekolah (Perpustakaan, R.Kepsek,
                             R.Guru, Kantor/TU, Lab IPA, Lab Komputer, UKS, Rumah Dinas,
                             Rumah Ibadah, Lapangan, Pagar, Air Bersih)
                             ============================================================ -->
                <x-card>
                    <x-slot:header>
                        <div class="flex items-center gap-2 text-gray-700 dark:text-gray-200">
                            <i class="bi bi-buildings"></i>
                            Fasilitas Ruang &amp; Bangunan Sekolah
                        </div>
                    </x-slot:header>

                    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3">
                        @foreach ($fasilitas as $rel => $info)
                            @php
                                $ada = $profileSekolah->$rel?->{'ada/tidak_ada'} ?? null;
                                $kondisi = $profileSekolah->$rel?->kodisi ?? null;
                            @endphp
                            <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-3 flex flex-col gap-1.5">
                                <div class="flex items-center gap-1.5 text-gray-700 dark:text-gray-200">
                                    <i class="bi {{ $info['icon'] }} text-sm"></i>
                                    <span class="text-xs font-medium leading-tight">{{ $info['label'] }}</span>
                                </div>
                                <div class="flex flex-wrap gap-1">
                                    @if ($ada === 'ada')
                                        <span
                                            class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300">Ada</span>
                                        <span
                                            @class([
                                                'inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-medium',
                                                'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300' =>
                                                    $kondisi == 'baik',
                                                'bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-300' =>
                                                    $kondisi == 'rusak',
                                                'bg-gray-100 text-gray-600 dark:bg-gray-700/40 dark:text-gray-300' => !in_array(
                                                    $kondisi,
                                                    ['baik', 'rusak']),
                                            ])>{{ $kondisi == 'baik' ? 'Baik' : ($kondisi == 'rusak' ? 'Rusak' : 'Nihil') }}</span>
                                    @else
                                        <span
                                            class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-medium bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300">Tidak
                                            Ada</span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-4">
                        <div>
                            <p class="text-xs text-gray-500 dark:text-gray-400 font-medium text-center mb-1">
                                Ketersediaan (Ada / Tidak Ada)
                            </p>
                            <div class="h-40 sm:h-48">
                                <canvas id="fasilitasChart"></canvas>
                            </div>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 dark:text-gray-400 font-medium text-center mb-1">
                                Kondisi (Baik / Rusak / Nihil)
                            </p>
                            <div class="h-40 sm:h-48">
                                <canvas id="fasilitasKondisiChart"></canvas>
                            </div>
                        </div>
                    </div>
                </x-card>

                <!-- ============================================================
                             Furnitur, Toilet & Elektronik (Baik/Rusak)
                             ============================================================ -->
                <x-card>
                    <x-slot:header>
                        <div class="flex items-center gap-2 text-gray-700 dark:text-gray-200">
                            <i class="bi bi-inboxes"></i>
                            Furnitur, Toilet &amp; Elektronik
                        </div>
                    </x-slot:header>

                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                        @foreach ($furnitur as $rel => $label)
                            @php
                                $baik = (int) ($profileSekolah->$rel?->baik ?? 0);
                                $rusak = (int) ($profileSekolah->$rel?->rusak ?? 0);
                            @endphp
                            <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-3">
                                <p class="text-xs font-medium text-gray-700 dark:text-gray-200 mb-2">{{ $label }}
                                </p>
                                <div class="flex items-center justify-between text-sm">
                                    <span class="text-green-600 dark:text-green-400 font-bold">{{ $baik }} <span
                                            class="font-normal text-gray-400 text-[10px]">Baik</span></span>
                                    <span class="text-amber-600 dark:text-amber-400 font-bold">{{ $rusak }} <span
                                            class="font-normal text-gray-400 text-[10px]">Rusak</span></span>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mt-4">
                        <div class="lg:col-span-2 h-56 sm:h-64">
                            <canvas id="furniturChart"></canvas>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 dark:text-gray-400 font-medium text-center mb-1">
                                Total Kondisi (Semua Item)
                            </p>
                            <div class="h-40 sm:h-48">
                                <canvas id="furniturTotalChart"></canvas>
                            </div>
                        </div>
                    </div>
                </x-card>
            @endif
        </div>
    </div>

    @if ($profileSekolah)
        <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const isDark = document.documentElement.classList.contains('dark');
                Chart.defaults.color = isDark ? '#9ca3af' : '#6b7280';
                Chart.defaults.borderColor = isDark ? '#374151' : '#e5e7eb';
                Chart.defaults.font.family = 'inherit';

                const barOptions = {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0
                            }
                        },
                    },
                };

                new Chart(document.getElementById('rkbRehabChart'), {
                    type: 'bar',
                    data: {
                        labels: ['Pembangunan RKB', 'Rehabilitasi Ruang Kelas'],
                        datasets: [{
                            label: 'Jumlah Ruang Kelas',
                            data: @json($chartRkbRehab),
                            backgroundColor: ['#2563eb', '#ea580c'],
                            borderRadius: 6,
                            maxBarThickness: 64,
                        }],
                    },
                    options: barOptions,
                });

                new Chart(document.getElementById('siswaChart'), {
                    type: 'bar',
                    data: {
                        labels: ['Kelas VII', 'Kelas VIII', 'Kelas IX'],
                        datasets: [{
                            label: 'Jumlah Siswa',
                            data: @json($chartSiswa),
                            backgroundColor: ['#10b981', '#059669', '#0d9488'],
                            borderRadius: 6,
                            maxBarThickness: 48,
                        }],
                    },
                    options: barOptions,
                });

                new Chart(document.getElementById('rombelChart'), {
                    type: 'bar',
                    data: {
                        labels: ['Kelas VII', 'Kelas VIII', 'Kelas IX'],
                        datasets: [{
                            label: 'Jumlah Rombel',
                            data: @json($chartRombel),
                            backgroundColor: ['#a855f7', '#8b5cf6', '#6366f1'],
                            borderRadius: 6,
                            maxBarThickness: 48,
                        }],
                    },
                    options: barOptions,
                });

                new Chart(document.getElementById('ruangKelasChart'), {
                    type: 'doughnut',
                    data: {
                        labels: ['Baik', 'Rusak'],
                        datasets: [{
                            data: @json($chartRuangKelas),
                            backgroundColor: ['#0ea5e9', '#f43f5e'],
                            borderWidth: 0,
                        }],
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '65%',
                        plugins: {
                            legend: {
                                position: 'bottom'
                            }
                        },
                    },
                });

                new Chart(document.getElementById('fasilitasChart'), {
                    type: 'doughnut',
                    data: {
                        labels: ['Ada', 'Tidak Ada'],
                        datasets: [{
                            data: @json($chartFasilitas),
                            backgroundColor: ['#22c55e', '#ef4444'],
                            borderWidth: 0,
                        }],
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '65%',
                        plugins: {
                            legend: {
                                position: 'bottom'
                            }
                        },
                    },
                });

                new Chart(document.getElementById('fasilitasKondisiChart'), {
                    type: 'doughnut',
                    data: {
                        labels: ['Baik', 'Rusak', 'Nihil'],
                        datasets: [{
                            data: @json($chartFasilitasKondisi),
                            backgroundColor: ['#22c55e', '#f59e0b', '#9ca3af'],
                            borderWidth: 0,
                        }],
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '65%',
                        plugins: {
                            legend: {
                                position: 'bottom'
                            }
                        },
                    },
                });

                new Chart(document.getElementById('furniturChart'), {
                    type: 'bar',
                    data: {
                        labels: @json($chartFurniturLabel),
                        datasets: [{
                                label: 'Baik',
                                data: @json($chartFurniturBaik),
                                backgroundColor: '#22c55e',
                                borderRadius: 4,
                            },
                            {
                                label: 'Rusak',
                                data: @json($chartFurniturRusak),
                                backgroundColor: '#f59e0b',
                                borderRadius: 4,
                            },
                        ],
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom'
                            }
                        },
                        scales: {
                            x: {
                                stacked: false,
                                ticks: {
                                    autoSkip: false,
                                    maxRotation: 40,
                                    minRotation: 0
                                }
                            },
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    precision: 0
                                }
                            },
                        },
                    },
                });

                new Chart(document.getElementById('furniturTotalChart'), {
                    type: 'doughnut',
                    data: {
                        labels: ['Baik', 'Rusak'],
                        datasets: [{
                            data: @json($chartFurniturTotal),
                            backgroundColor: ['#22c55e', '#f59e0b'],
                            borderWidth: 0,
                        }],
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '65%',
                        plugins: {
                            legend: {
                                position: 'bottom'
                            }
                        },
                    },
                });
            });
        </script>
    @endif
@endsection