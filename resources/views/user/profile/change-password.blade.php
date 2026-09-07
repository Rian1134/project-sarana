@extends('layouts.app')

@section('title')
    Ubah Password
@endsection

@section('content')
    <div class="container mx-auto px-3 sm:px-4 py-3 sm:py-4">
        <div class="flex flex-col gap-4">
            <!-- Header -->
            <div class="flex flex-wrap items-center justify-between gap-3">
                <div>
                    <h1 class="text-xl font-semibold text-gray-800 dark:text-gray-100 flex items-center gap-2">
                        <i class="bi bi-key text-blue-600 dark:text-blue-400"></i>
                        Ubah Password
                    </h1>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Ganti kata sandi akun Anda</p>
                </div>
                <a href="{{ route('user.profile.index') }}" class="inline-flex">
                    <x-button variant="secondary" size="sm">
                        <i class="bi bi-arrow-left me-1"></i> Kembali
                    </x-button>
                </a>
            </div>

            <!-- Form Ubah Password -->
            <x-card>
                <x-slot:header>
                    <div class="flex items-center gap-2 text-yellow-600 dark:text-yellow-400">
                        <i class="bi bi-shield-lock-fill"></i>
                        Form Ubah Password
                    </div>
                </x-slot:header>

                <form action="{{ route('user.profile.update-password') }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <x-form.input 
                        name="current_password" 
                        label="Password Saat Ini" 
                        type="password" 
                        required 
                        placeholder="Masukkan password saat ini" 
                    />

                    <x-form.input 
                        name="password" 
                        label="Password Baru" 
                        type="password" 
                        required 
                        placeholder="Masukkan password baru (minimal 8 karakter)"
                        helper="Password minimal 8 karakter"
                    />

                    <x-form.input 
                        name="password_confirmation" 
                        label="Konfirmasi Password Baru" 
                        type="password" 
                        required 
                        placeholder="Konfirmasi password baru" 
                    />

                    <div class="flex flex-wrap gap-3 pt-4">
                        <x-button variant="primary" type="submit">
                            <i class="bi bi-key me-1"></i> Ubah Password
                        </x-button>
                        <a href="{{ route('user.profile.index') }}" class="inline-flex">
                            <x-button variant="secondary">
                                <i class="bi bi-x-circle me-1"></i> Batal
                            </x-button>
                        </a>
                    </div>
                </form>
            </x-card>

            <!-- Tips Keamanan -->
            <x-card>
                <x-slot:header>
                    <div class="flex items-center gap-2 text-blue-600 dark:text-blue-400">
                        <i class="bi bi-shield-check"></i>
                        Tips Keamanan Password
                    </div>
                </x-slot:header>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-sm">
                    <div class="flex items-start gap-2 p-2 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                        <i class="bi bi-check-circle-fill text-green-500 mt-0.5"></i>
                        <span class="text-gray-700 dark:text-gray-300">Gunakan kombinasi huruf besar, huruf kecil, angka, dan simbol</span>
                    </div>
                    <div class="flex items-start gap-2 p-2 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                        <i class="bi bi-check-circle-fill text-green-500 mt-0.5"></i>
                        <span class="text-gray-700 dark:text-gray-300">Hindari menggunakan informasi pribadi seperti tanggal lahir atau nama</span>
                    </div>
                    <div class="flex items-start gap-2 p-2 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                        <i class="bi bi-check-circle-fill text-green-500 mt-0.5"></i>
                        <span class="text-gray-700 dark:text-gray-300">Jangan gunakan password yang sama untuk beberapa akun</span>
                    </div>
                    <div class="flex items-start gap-2 p-2 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                        <i class="bi bi-check-circle-fill text-green-500 mt-0.5"></i>
                        <span class="text-gray-700 dark:text-gray-300">Ganti password secara berkala untuk keamanan yang lebih baik</span>
                    </div>
                </div>
            </x-card>
        </div>
    </div>
@endsection