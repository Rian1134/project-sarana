@extends('layouts.admin')

@section('title')
    Edit User
@endsection

@section('content')
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between mb-5">
        <div>
            <h1 class="text-xl font-semibold text-gray-800 dark:text-gray-100">Edit User</h1>
        </div>
        <div>
            <x-button href="{{ route('user.index') }}" variant="secondary" class="gap-1">
                <i class="bi bi-arrow-left"></i> Kembali
            </x-button>
        </div>
    </div>

    <x-card>
        <div class="p-4">
            <form action="{{ route('user.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    {{-- Nama --}}
                    <x-form.input 
                        name="name" 
                        label="Nama Lengkap" 
                        required 
                        placeholder="Masukkan nama lengkap" 
                        value="{{ old('name', $user->name) }}"
                    />

                    {{-- Email --}}
                    <x-form.input 
                        name="email" 
                        label="Email" 
                        type="email" 
                        required 
                        placeholder="Masukkan email" 
                        value="{{ old('email', $user->email) }}"
                    />

                    {{-- Password --}}
                    <div class="col-span-full md:col-span-1">
                        <x-form.input 
                            name="password" 
                            label="Password Baru" 
                            type="password" 
                            placeholder="Kosongkan jika tidak ingin mengubah"
                        />
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                            Password minimal 8 karakter. Kosongkan jika tidak ingin mengubah password.
                        </p>
                    </div>

                    {{-- Konfirmasi Password --}}
                    <div class="col-span-full md:col-span-1">
                        <x-form.input 
                            name="password_confirmation" 
                            label="Konfirmasi Password Baru" 
                            type="password" 
                            placeholder="Konfirmasi password baru"
                        />
                    </div>

                    {{-- Role --}}
                    <div class="col-span-full">
                        <x-form.select 
                            name="role" 
                            label="Role" 
                            required 
                            placeholder="Pilih Role"
                            :options="$roles->pluck('name', 'name')->map(function($name) { return ucfirst($name); })->toArray()"
                            value="{{ old('role', $userRole->name ?? '') }}"
                        />
                    </div>
                </div>

                {{-- Informasi Tambahan --}}
                <div class="mt-6 p-4 bg-gray-50 dark:bg-gray-800 rounded-lg">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <span class="text-sm text-gray-600 dark:text-gray-400">ID User</span>
                            <p class="font-medium text-gray-900 dark:text-white">{{ $user->id }}</p>
                        </div>
                        <div>
                            <span class="text-sm text-gray-600 dark:text-gray-400">Tanggal Bergabung</span>
                            <p class="font-medium text-gray-900 dark:text-white">
                                {{ $user->created_at->format('d-m-Y H:i') }}
                            </p>
                        </div>
                        <div>
                            <span class="text-sm text-gray-600 dark:text-gray-400">Terakhir Update</span>
                            <p class="font-medium text-gray-900 dark:text-white">
                                {{ $user->updated_at->format('d-m-Y H:i') }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="mt-6 flex gap-2">
                    <x-button type="submit" variant="primary" class="gap-1">
                        <i class="bi bi-save"></i> Update
                    </x-button>
                    <x-button href="{{ route('user.index') }}" variant="secondary" class="gap-1">
                        <i class="bi bi-x-circle"></i> Batal
                    </x-button>
                </div>
            </form>
        </div>
    </x-card>
@endsection