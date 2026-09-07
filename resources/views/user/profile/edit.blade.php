@extends('layouts.app')

@section('title')
    Edit Profil
@endsection

@section('content')
    <div class="container mx-auto px-3 sm:px-4 py-3 sm:py-4">
        <div class="flex flex-col gap-4">
            <!-- Header -->
            <div class="flex flex-wrap items-center justify-between gap-3">
                <div>
                    <h1 class="text-xl font-semibold text-gray-800 dark:text-gray-100 flex items-center gap-2">
                        <i class="bi bi-pencil-square text-yellow-600 dark:text-yellow-400"></i>
                        Edit Profil
                    </h1>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Perbarui informasi akun Anda</p>
                </div>
                <a href="{{ route('user.profile.index') }}" class="inline-flex">
                    <x-button variant="secondary" size="sm">
                        <i class="bi bi-arrow-left me-1"></i> Kembali
                    </x-button>
                </a>
            </div>

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
                        @foreach($user->roles as $role)
                            <x-badge variant="primary">{{ ucfirst($role->name) }}</x-badge>
                        @endforeach
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

                            <div class="flex flex-wrap justify-end gap-2">
                                <button type="submit" class="inline-flex items-center px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors shadow-sm hover:shadow-md">
                                    <i class="bi bi-check-circle me-2"></i>
                                    Simpan Perubahan
                                </button>
                                <a href="{{ route('user.profile.index') }}" 
                                   class="inline-flex items-center px-6 py-2.5 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition-colors shadow-sm hover:shadow-md">
                                    <i class="bi bi-x-circle me-2"></i>
                                    Batal
                                </a>
                            </div>
                        </form>
                    </x-card>

                    <!-- B. Ubah Password -->
                    <x-card>
                        <x-slot:header>
                            <div class="flex items-center gap-2 text-yellow-600 dark:text-yellow-400">
                                <i class="bi bi-key"></i>
                                Ubah Password
                            </div>
                        </x-slot:header>

                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">
                            Ingin mengganti password? Klik tombol di bawah untuk mengubah kata sandi Anda.
                        </p>

                        <div class="flex justify-end">
                            <a href="{{ route('user.profile.change-password') }}" class="inline-flex">
                                <x-button variant="warning">
                                    <i class="bi bi-key me-1"></i> Ubah Password
                                </x-button>
                            </a>
                        </div>
                    </x-card>
                </div>
            </div>
        </div>
    </div>
@endsection