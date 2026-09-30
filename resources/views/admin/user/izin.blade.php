@extends('layouts.admin')

@section('title')
    Kelola Izin User
@endsection

@section('content')
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between mb-5">
        <div>
            <h1 class="text-xl font-semibold text-gray-800 dark:text-gray-100 flex items-center gap-2">
                <i class="bi bi-shield-lock-fill text-blue-600 dark:text-blue-400"></i>
                Kelola Izin Update Data
            </h1>
            <p class="text-sm text-gray-500 dark:text-gray-400">
                {{ $user->name }} ({{ $user->email }})
            </p>
        </div>
        <a href="{{ route('user.index') }}" class="inline-flex">
            <x-button variant="secondary" size="sm">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </x-button>
        </a>
    </div>

    <x-card>
        @if ($user->hasRole('admin'))
            {{-- Admin sudah punya semua izin lewat role, jadi tidak perlu diatur per user --}}
            <p class="text-sm text-gray-600 dark:text-gray-300">
                <i class="bi bi-info-circle"></i>
                User ini adalah <strong>admin</strong> dan sudah memiliki semua izin lewat role-nya.
            </p>
        @else
            <form action="{{ route('user.izin.update', $user->id) }}" method="POST" class="flex flex-col gap-4">
                @csrf
                @method('PUT')

                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Centang bagian form yang ingin dikunci. Bagian yang tidak dicentang tetap boleh diisi user ini.
                </p>

                {{-- Pilih semua --}}
                <label
                    class="flex items-center gap-2 font-semibold text-gray-800 dark:text-gray-100 pb-3 border-b border-gray-200 dark:border-gray-700">
                    <input type="checkbox" id="pilihSemua" class="size-4">
                    Kunci Semua
                </label>

                {{-- Satu per satu --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    @foreach ($daftarIzin as $izin => $label)
                        <label class="flex items-center gap-2 text-sm text-gray-700 dark:text-gray-200">
                            <input type="checkbox" name="izin[]" value="{{ $izin }}" class="izin-item size-4"
                                @checked(in_array($izin, old('izin', $terkunci)))>
                            {{ $label }}
                        </label>
                    @endforeach
                </div>

                <div class="flex flex-wrap gap-2 pt-2">
                    <x-button variant="primary" type="submit" class="gap-1">
                        <i class="bi bi-save"></i> Simpan Izin
                    </x-button>
                    <a href="{{ route('user.index') }}" class="inline-flex">
                        <x-button variant="secondary" type="button">Batal</x-button>
                    </a>
                </div>
            </form>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const semua = document.getElementById('pilihSemua');
                    const items = document.querySelectorAll('.izin-item');

                    // Centang/uncentang semua sekaligus
                    semua.addEventListener('change', () => items.forEach(i => i.checked = semua.checked));

                    // "Pilih Semua" ikut tercentang kalau semua item tercentang
                    function sinkron() {
                        semua.checked = [...items].every(i => i.checked);
                    }
                    items.forEach(i => i.addEventListener('change', sinkron));
                    sinkron();
                });
            </script>
        @endif
    </x-card>
@endsection