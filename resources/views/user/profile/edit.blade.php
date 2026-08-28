@extends('layouts.app')

@section('title')
    Profil Saya
@endsection

@section('content')
    <div class="flex flex-col gap-4">
        <!-- Header -->
        <div class="flex flex-wrap items-center justify-between gap-3">
            <h1 class="text-xl font-semibold text-gray-800 dark:text-gray-100 flex items-center gap-2">
                <i class="bi bi-person-circle"></i>
                Profil Saya
            </h1>
            <a href="{{ route('user.profile.index') }}" class="inline-flex">
                <x-button variant="secondary" size="sm">
                    <i class="bi bi-arrow-left me-1"></i> Kembali
                </x-button>
            </a>
        </div>

        <!-- Pesan Sukses -->
        @if (session('success'))
            <x-alert type="success" dismissible icon>
                {{ session('success') }}
            </x-alert>
        @endif

        <!-- Pesan Error -->
        @if (session('error'))
            <x-alert type="danger" dismissible icon>
                {{ session('error') }}
            </x-alert>
        @endif

        @if ($errors->any())
            <x-alert type="danger" dismissible icon>
                <div class="flex flex-col gap-1">
                    <strong><i class="bi bi-exclamation-triangle-fill"></i> Terjadi Kesalahan!</strong>
                    <ul class="list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
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

            <div class="lg:col-span-2 flex flex-col gap-4">
                <!-- A. Informasi Profil -->
                <x-card>
                    <x-slot:header>
                        <div class="flex items-center gap-2 text-blue-600 dark:text-blue-400">
                            <i class="bi bi-person-lines-fill"></i>
                            Informasi Profil
                        </div>
                    </x-slot:header>

                    <form action="{{ route('user.profile.update') }}" method="POST" class="flex flex-col gap-4">
                        @csrf
                        @method('PUT')

                        <x-form.input name="name" label="Nama Lengkap" type="text" required :value="old('name', $user->name)" />

                        <x-form.input name="email" label="Email" type="email" required :value="old('email', $user->email)" />

                        <div class="flex justify-end">
                            <x-button type="submit" variant="primary">
                                <i class="bi bi-check-circle me-1"></i> Simpan Perubahan
                            </x-button>
                        </div>
                    </form>
                </x-card>
            </div>
        </div>
    </div>
@endsection
