@extends('layouts.admin')

@section('title')
    Detail User
@endsection

@section('content')
    <div class="container mx-auto px-4 py-4">
        <div class="flex flex-col gap-4">
            <!-- Header -->
            <div class="flex flex-wrap items-center justify-between gap-3">
                <h1 class="text-xl font-semibold text-gray-800 dark:text-gray-100 flex items-center gap-2">
                    <i class="bi bi-person-badge"></i>
                    Detail User
                </h1>
                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('user.index') }}" class="btn btn-secondary btn-sm">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>

            <!-- Alert -->
            @if (session('success'))
                <x-alert type="success" dismissible icon>
                    <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                </x-alert>
            @endif

            @if (session('error'))
                <x-alert type="danger" dismissible icon>
                    <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
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
                        <div
                            class="flex h-32 w-32 items-center justify-center rounded-full bg-blue-600 text-5xl font-semibold text-white shadow-lg">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                        <span class="badge badge-primary text-sm">
                            {{ $user->getRoleNames()->isNotEmpty() ? $user->getRoleNames()->first() : 'User' }}
                        </span>
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
                            Total: {{ $user->sarana ? 1 : 0 }} data
                        </span>
                    </div>
                </x-slot:header>

                @if ($user->sarana)
                    <div class="overflow-x-auto">
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr class="bg-gray-800 text-white text-center">
                                    <th class="text-center">No</th>
                                    <th>Nama Sekolah</th>
                                    <th>NPSN</th>
                                    <th>Alamat</th>
                                    <th>Kepala Sekolah</th>
                                    <th>No. HP</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-center font-bold">1</td>
                                    <td>{{ $user->sarana->nama_sekolah }}</td>
                                    <td class="text-center">{{ $user->sarana->NPSN }}</td>
                                    <td>{{ Str::limit($user->sarana->alamat_sekolah, 30) }}</td>
                                    <td>{{ $user->sarana->nama_kepala_sekolah }}</td>
                                    <td class="text-center">{{ $user->sarana->nomor_hp }}</td>
                                    <td class="text-center">
                                        <div class="flex justify-center gap-1">
                                            <a href="{{ route('sarana.show', $user->sarana->id) }}"
                                                class="btn btn-info btn-xs" title="Lihat Detail">
                                                <i class="bi bi-eye-fill"></i>
                                            </a>
                                            <a href="{{ route('sarana.edit', $user->sarana->id) }}"
                                                class="btn btn-warning btn-xs" title="Edit Data">
                                                <i class="bi bi-pencil-fill"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                        <i class="bi bi-inbox text-4xl block mb-3"></i>
                        <p class="text-lg">User ini belum memiliki data sarana.</p>
                        <a href="{{ route('sarana.create') }}" class="btn btn-primary btn-sm mt-2">
                            <i class="bi bi-plus-lg"></i> Tambah Data Sarana
                        </a>
                    </div>
                @endif
            </x-card>

            <!-- Tombol Aksi -->
            <x-card>
                <x-slot:footer>
                    <div class="flex flex-wrap gap-2">
                        <a href="{{ route('user.index') }}" class="btn btn-secondary btn-sm">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                    </div>
                </x-slot:footer>
            </x-card>
        </div>
    </div>

    <style>
        /* Custom style untuk avatar */
        .avatar-large {
            width: 128px;
            height: 128px;
            font-size: 3rem;
        }

        /* Dark mode untuk badge */
        .dark .badge-primary {
            background-color: rgba(59, 130, 246, 0.3);
            color: #93c5fd;
        }

        .badge-primary {
            background-color: #dbeafe;
            color: #1e40af;
        }
    </style>
@endsection
