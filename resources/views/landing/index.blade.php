@extends('layouts.home')

@section('title', 'Beranda')

@section('content')

    {{-- ===== HERO ===== --}}
    <section class="relative overflow-hidden bg-linear-to-br from-green-50 via-white to-white dark:from-gray-900 dark:via-gray-900 dark:to-gray-900">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 py-16 sm:py-24 grid grid-cols-1 lg:grid-cols-2 gap-10 items-center">
            <div class="flex flex-col gap-5 text-center lg:text-left">

                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-gray-800 dark:text-gray-100 leading-tight">
                    Kelola Data Sarana &amp; Prasarana Sekolah dengan Mudah
                </h1>

                <p class="text-base sm:text-lg text-gray-500 dark:text-gray-400 max-w-xl mx-auto lg:mx-0">
                    Satu sistem untuk mencatat, memantau, dan melaporkan kondisi sarana prasarana
                    seluruh sekolah dari ruang kelas sampai laptop.
                </p>    

                <div class="flex flex-col sm:flex-row gap-3 justify-center lg:justify-start mt-2">
                    <a href="{{ route('auth.register') }}" class="inline-flex">
                        <x-button variant="success" size="lg" fullWidth>
                            <i class="bi bi-person-plus-fill me-2"></i> Mulai Sekarang
                        </x-button>
                    </a>
                    <a href="{{ route('login') }}" class="inline-flex">
                        <x-button variant="outline-secondary" size="lg" fullWidth>
                            <i class="bi bi-box-arrow-in-right me-2"></i> Masuk ke Akun
                        </x-button>
                    </a>
                </div>
            </div>
        </div>
    </section>

@endsection