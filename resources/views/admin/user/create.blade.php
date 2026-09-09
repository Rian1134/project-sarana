@extends('layouts.admin')

@section('title')
    Tambah User
@endsection

@section('content')
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between mb-5">
        <div>
            <h1 class="text-xl font-semibold text-gray-800 dark:text-gray-100">Tambah User Baru</h1>
        </div>
        <div>
            <x-button href="{{ route('user.index') }}" variant="secondary" class="gap-1">
                <i class="bi bi-arrow-left"></i> Kembali
            </x-button>
        </div>
    </div>

    <x-card>
        <div class="p-4">
            <form action="{{ route('user.store') }}" method="POST">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    {{-- Nama --}}
                    <x-form.input 
                        name="name" 
                        label="Nama Lengkap" 
                        required 
                        placeholder="Masukkan nama lengkap" 
                        value="{{ old('name') }}"
                    />

                    {{-- Email --}}
                    <x-form.input 
                        name="email" 
                        label="Email" 
                        type="email" 
                        required 
                        placeholder="Masukkan email" 
                        value="{{ old('email') }}"
                    />

                    {{-- Password --}}
                    <div class="col-span-full md:col-span-1">
                        <x-form.input 
                            name="password" 
                            label="Password" 
                            type="password" 
                            required 
                            placeholder="Minimal 8 karakter"
                        />
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                            Password minimal 8 karakter
                        </p>
                    </div>

                    {{-- Konfirmasi Password --}}
                    <div class="col-span-full md:col-span-1">
                        <x-form.input 
                            name="password_confirmation" 
                            label="Konfirmasi Password" 
                            type="password" 
                            required 
                            placeholder="Konfirmasi password"
                        />
                    </div>

                    
                </div>

                <div class="mt-6 flex gap-2">
                    <x-button type="submit" variant="primary" class="gap-1">
                        <i class="bi bi-save"></i> Simpan
                    </x-button>
                    <x-button href="{{ route('user.index') }}" variant="secondary" class="gap-1">
                        <i class="bi bi-x-circle"></i> Batal
                    </x-button>
                </div>
            </form>
        </div>
    </x-card>
@endsection