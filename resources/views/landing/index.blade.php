@extends('layouts.home')

@section('title', 'Beranda')

@section('content')

    {{-- ===== HERO ===== --}}
    <section class="relative overflow-hidden">
        {{-- Background Photo --}}
        <div
            class="absolute inset-0 bg-cover bg-center"
            style="background-image: url('{{ asset('assets/img/foto-disdik.webp') }}');"
        ></div>

        {{-- Blue Gradient Overlay --}}
        <div class="absolute inset-0 bg-linear-to-br from-[#2E86C1]/85 to-[#164C74]/85 dark:from-[#1a1a2e]/85 dark:to-[#16213e]/85"></div>

        <div class="relative max-w-4xl mx-auto px-4 sm:px-6 py-24 sm:py-32 flex flex-col items-center gap-5 text-center">

            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-white leading-tight">
                Kelola Data Sarana &amp; Prasarana Sekolah dengan Mudah
            </h1>

            <p class="text-base sm:text-lg text-white/90 max-w-xl">
                Satu sistem untuk mencatat, memantau, dan melaporkan kondisi sarana prasarana
                sekolah menegah pertama kabupaten Lahat.
            </p>

            <div class="flex flex-col sm:flex-row gap-3 justify-center mt-2">
                <a href="{{ route('login') }}" class="inline-flex">
                    <x-button variant="outline-light" size="lg" fullWidth>
                        <i class="bi bi-box-arrow-in-right me-2"></i> Masuk ke Akun
                    </x-button>
                </a>
            </div>
        </div>
    </section>

@endsection