@extends('layouts.app')

@section('title')
    Profil Sekolah
@endsection

@section('content')
    <div class="flex flex-col gap-4">
        <!-- Header -->
        <div class="flex flex-wrap items-center justify-between gap-3">
            <h1 class="text-xl font-semibold text-gray-800 dark:text-gray-100 flex items-center gap-2">
                <i class="bi bi-person-circle"></i>
                Profil Sekolah
            </h1>
            <a href="{{ route('user.profile.edit') }}" class="inline-flex">
                <x-button variant="primary" size="sm">
                    <i class="bi bi-pencil-square me-1"></i> Edit Profil
                </x-button>
            </a>
        </div>

        <!-- Pesan Sukses -->
        @if (session('success'))
            <x-alert type="success" dismissible icon>
                {{ session('success') }}
            </x-alert>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
            <!-- Kartu ringkasan akun -->
            <x-card class="lg:col-span-1 h-fit">
                <div class="flex flex-col items-center text-center gap-3 py-2">
                    <x-avatar :name="$user->name" size="xl" />
                    <div>
                        <p class="font-semibold text-gray-800 dark:text-gray-100">{{ $user->name }}</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ $user->email }}</p>
                    </div>
                    <x-badge variant="primary">{{ ucfirst($user->role ?? 'Pengguna') }}</x-badge>
                    <p class="text-xs text-gray-400 dark:text-gray-500 mt-2">
                        Bergabung sejak {{ $user->created_at?->translatedFormat('d F Y') ?? '-' }}
                    </p>
                </div>
            </x-card>

            <!-- Detail informasi akun -->
            <x-card class="lg:col-span-2 h-fit">
                <x-slot:header>
                    <div class="flex items-center gap-2 text-blue-600 dark:text-blue-400">
                        <i class="bi bi-person-lines-fill"></i>
                        Informasi Akun
                    </div>
                </x-slot:header>

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
                        <p class="text-base font-semibold text-gray-800 dark:text-gray-100">{{ ucfirst($user->role ?? 'Pengguna') }}</p>
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
                        <label class="text-sm text-gray-500 dark:text-gray-400 font-medium">Terakhir Diperbarui</label>
                        <p class="text-base font-semibold text-gray-800 dark:text-gray-100">
                            {{ $user->updated_at?->translatedFormat('d F Y, H:i') ?? '-' }}
                        </p>
                    </div>
                </div>

                <x-slot:footer>
                    <div class="flex justify-end gap-2">
                        <a href="{{ route('user.profile.edit') }}" class="inline-flex">
                            <x-button variant="primary" size="sm">
                                <i class="bi bi-pencil-square me-1"></i> Edit Profil
                            </x-button>
                        </a>
                    </div>
                </x-slot:footer>
            </x-card>
        </div>
    </div>
@endsection