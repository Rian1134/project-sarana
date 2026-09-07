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
                                    class="text-base font-semibold text-gray-800 dark:text-gray-100 break-words hyphens-auto">
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

                        <div class="mt-4 flex justify-end">
                            <a href="{{ route('user.data.index') }}" class="inline-flex">
                                <x-button variant="info" size="sm">
                                    <i class="bi bi-building me-1"></i> Data Sarana
                                </x-button>
                            </a>
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
                        (int) ($profileSekolah->ruangKelas?->bagus ?? 0),
                        (int) ($profileSekolah->ruangKelas?->rusak ?? 0),
                    ];
                @endphp

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
                                        class="bg-rose-50 dark:bg-rose-900/20 p-3 sm:p-6 rounded-lg text-center flex flex-col items-center justify-center">
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
            @endif
        </div>
    </div>

    @if ($profileSekolah)
        <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const isDark = document.documentElement.classList.contains('dark');
                Chart.defaults.color = isDark ? '#9ca3af' : '#6b7280';
                Chart.defaults.borderColor = isDark ? '#374151' : '#e5e7eb';
                Chart.defaults.font.family = 'inherit';

                const barOptions = {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: { beginAtZero: true, ticks: { precision: 0 } },
                    },
                };

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
                        plugins: { legend: { position: 'bottom' } },
                    },
                });
            });
        </script>
    @endif
@endsection