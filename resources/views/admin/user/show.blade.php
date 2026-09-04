@extends('layouts.admin')

@section('title')
    Detail User
@endsection

@section('content')
    <div class="flex flex-col gap-4">
        <!-- Header -->
        <div class="flex flex-wrap items-center justify-between gap-3">
            <h1 class="text-xl font-semibold text-gray-800 dark:text-gray-100 flex items-center gap-2">
                <i class="bi bi-person-badge"></i>
                Detail User
            </h1>
            <a href="{{ route('user.index') }}" class="inline-flex">
                <x-button variant="secondary" size="sm">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                </x-button>
            </a>
        </div>

        <!-- Alert -->
        @if (session('success'))
            <x-alert type="success" dismissible icon>
                {{ session('success') }}
            </x-alert>
        @endif

        @if (session('error'))
            <x-alert type="danger" dismissible icon>
                {{ session('error') }}
            </x-alert>
        @endif

        <!-- Profile Card -->
        <x-card>
            <x-slot:header>
                <div class="flex items-center gap-2 text-blue-600 dark:text-blue-400">
                    <i class="bi bi-person-circle"></i>
                    Profil User
                </div>
            </x-slot:header>

            <div class="flex flex-col md:flex-row gap-6">
                <!-- Avatar -->
                <div class="flex flex-col items-center gap-3">
                    <x-avatar :name="$user->name" size="xl" />
                    <x-badge variant="primary">
                        {{ $user->getRoleNames()->isNotEmpty() ? $user->getRoleNames()->first() : 'User' }}
                    </x-badge>
                </div>

                <!-- Detail -->
                <div class="flex-1 grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="text-sm text-gray-500 dark:text-gray-400 font-medium">Nama Lengkap</label>
                        <p class="text-lg font-semibold text-gray-800 dark:text-gray-100">{{ $user->name }}</p>
                    </div>
                    <div>
                        <label class="text-sm text-gray-500 dark:text-gray-400 font-medium">Email</label>
                        <p class="text-lg font-semibold text-gray-800 dark:text-gray-100">{{ $user->email }}</p>
                    </div>
                    <div>
                        <label class="text-sm text-gray-500 dark:text-gray-400 font-medium">Role</label>
                        <p class="text-lg font-semibold text-gray-800 dark:text-gray-100">
                            @if ($user->getRoleNames()->isNotEmpty())
                                {{ $user->getRoleNames()->implode(', ') }}
                            @else
                                <span class="text-gray-500">Belum ada role</span>
                            @endif
                        </p>
                    </div>
                    <div>
                        <label class="text-sm text-gray-500 dark:text-gray-400 font-medium">Permissions</label>
                        <p class="text-lg font-semibold text-gray-800 dark:text-gray-100">
                            @if ($user->getAllPermissions()->isNotEmpty())
                                {{ $user->getAllPermissions()->pluck('name')->implode(', ') }}
                            @else
                                <span class="text-gray-500">Belum ada permission</span>
                            @endif
                        </p>
                    </div>
                    <div>
                        <label class="text-sm text-gray-500 dark:text-gray-400 font-medium">Tanggal Dibuat</label>
                        <p class="text-lg font-semibold text-gray-800 dark:text-gray-100">
                            {{ $user->created_at->format('d/m/Y H:i') }}
                        </p>
                    </div>
                    <div>
                        <label class="text-sm text-gray-500 dark:text-gray-400 font-medium">Terakhir Diupdate</label>
                        <p class="text-lg font-semibold text-gray-800 dark:text-gray-100">
                            {{ $user->updated_at->format('d/m/Y H:i') }}
                        </p>
                    </div>
                </div>
            </div>
        </x-card>

        <!-- Data Sarana yang Dimiliki User -->
        <x-card>
            <x-slot:header>
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2 text-blue-600 dark:text-blue-400">
                        <i class="bi bi-building"></i>
                        Data Sarana
                    </div>
                    <span class="text-sm text-gray-500 dark:text-gray-400">
                        Total: {{ $user->profileSekolah ? 1 : 0 }} data
                    </span>
                </div>
            </x-slot:header>

            @if ($user->profileSekolah)
                <x-table bordered>
                    <x-slot:head>
                        <tr>
                            <x-table.heading class="text-center">No</x-table.heading>
                            <x-table.heading>Nama Sekolah</x-table.heading>
                            <x-table.heading>NPSN</x-table.heading>
                            <x-table.heading>Alamat</x-table.heading>
                            <x-table.heading>Kepala Sekolah</x-table.heading>
                            <x-table.heading>No. HP</x-table.heading>
                            <x-table.heading class="text-center">Aksi</x-table.heading>
                        </tr>
                    </x-slot:head>

                    <x-table.row>
                        <x-table.cell class="text-center font-bold">1</x-table.cell>
                        <x-table.cell>{{ $user->profileSekolah->nama_sekolah }}</x-table.cell>
                        <x-table.cell class="text-center">{{ $user->profileSekolah->NPSN }}</x-table.cell>
                        <x-table.cell>{{ Str::limit($user->profileSekolah->alamat_sekolah, 30) }}</x-table.cell>
                        <x-table.cell>{{ $user->profileSekolah->nama_kepala_sekolah }}</x-table.cell>
                        <x-table.cell class="text-center">{{ $user->profileSekolah->nomor_hp }}</x-table.cell>
                        <x-table.cell class="text-center">
                            <div class="flex justify-center gap-1">
                                <x-button href="{{ route('sarana.show', $user->profileSekolah->id) }}" variant="info" size="xs" class="p-1.5!" title="Lihat Detail">
                                    <i class="bi bi-eye-fill"></i>
                                </x-button>
                                <x-button href="{{ route('sarana.edit', $user->profileSekolah->id) }}" variant="warning" size="xs" class="p-1.5!" title="Edit Data">
                                    <i class="bi bi-pencil-fill"></i>
                                </x-button>
                            </div>
                        </x-table.cell>
                    </x-table.row>
                </x-table>
            @else
                <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                    <i class="bi bi-inbox text-4xl block mb-3"></i>
                    <p class="text-lg">User ini belum memiliki data sarana.</p>
                    <a href="{{ route('sarana.create') }}" class="inline-flex mt-2">
                        <x-button variant="primary" size="sm">
                            <i class="bi bi-plus-lg me-1"></i> Tambah Data Sarana
                        </x-button>
                    </a>
                </div>
            @endif
        </x-card>

        <!-- Tombol Aksi -->
        <x-card>
            <x-slot:footer>
                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('user.index') }}" class="inline-flex">
                        <x-button variant="secondary" size="sm">
                            <i class="bi bi-arrow-left me-1"></i> Kembali
                        </x-button>
                    </a>
                </div>
            </x-slot:footer>
        </x-card>
    </div>
@endsection