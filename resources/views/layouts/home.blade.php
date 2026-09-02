<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sapras - @yield('title', 'Sistem Data Sarana & Prasarana Sekolah')</title>

    @vite(['resources/css/app.css'])
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    {{-- Dark mode: default selalu LIGHT, cuma aktif kalau user pernah pilih sendiri --}}
    <script>
        (function() {
            if (localStorage.getItem('theme') === 'dark') {
                document.documentElement.classList.add('dark');
            }
        })();
    </script>

    @stack('styles')
</head>

<body class="bg-white dark:bg-gray-900">

    {{-- ===== NAVBAR PUBLIK ===== --}}
    <x-navbar fixed class="bg-white! dark:bg-gray-900! border-b border-gray-100 dark:border-gray-800 shadow-sm">
        <x-slot:brand>
            <a href="{{ url('/') }}" class="flex items-center gap-2 font-bold text-lg text-gray-800 dark:text-gray-100">
                <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-green-600 text-white">
                    <i class="bi bi-building"></i>
                </span>
                Sapras
            </a>
        </x-slot:brand>

        <x-slot:menu>
            <a href="#tentang" class="nav-link">Tentang</a>
            <a href="#kontak" class="nav-link">Kontak</a>
        </x-slot:menu>

        <x-slot:actions>
            <button data-theme-toggle aria-label="Ganti tema" class="inline-flex items-center justify-center rounded-md p-1.5 text-gray-500 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-800">
                <i class="bi bi-moon-stars-fill" data-theme-icon-dark></i>
                <i class="bi bi-sun-fill hidden" data-theme-icon-light></i>
            </button>

            <a href="{{ route('login') }}" class="hidden sm:inline-flex">
                <x-button variant="light" size="sm">Login</x-button>
            </a>
            <a href="{{ route('auth.register') }}" class="inline-flex">
                <x-button variant="success" size="sm">
                    <span class="hidden sm:inline">Daftar Sekarang</span>
                    <span class="sm:hidden">Daftar</span>
                </x-button>
            </a>
        </x-slot:actions>
    </x-navbar>

    {{-- ===== KONTEN HALAMAN (diisi tiap halaman via @section('content')) ===== --}}
    <main class="pt-14 sm:pt-16">
        @yield('content')
    </main>

    {{-- ===== FOOTER PUBLIK ===== --}}
    <footer id="kontak" class="border-t border-gray-100 dark:border-gray-800 bg-gray-50 dark:bg-gray-900 mt-12">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 py-10 grid grid-cols-1 sm:grid-cols-3 gap-8">
            <div>
                <div class="flex items-center gap-2 font-bold text-gray-800 dark:text-gray-100 mb-2">
                    <span class="flex h-7 w-7 items-center justify-center rounded-lg bg-green-600 text-white text-sm">
                        <i class="bi bi-building"></i>
                    </span>
                    Sapras
                </div>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Sistem pendataan sarana &amp; prasarana sekolah — cepat, rapi, dan mudah dipantau.
                </p>
            </div>

            <div>
                <p class="text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">Tautan</p>
                <ul class="flex flex-col gap-1.5 text-sm text-gray-500 dark:text-gray-400">
                    <li><a href="{{ route('login') }}" class="hover:text-green-600 dark:hover:text-green-400 transition-colors">Login</a></li>
                    <li><a href="{{ route('auth.register') }}" class="hover:text-green-600 dark:hover:text-green-400 transition-colors">Daftar</a></li>
                </ul>
            </div>

            <div>
                <p class="text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">Kontak</p>
                <ul class="flex flex-col gap-1.5 text-sm text-gray-500 dark:text-gray-400">
                    <li class="flex items-center gap-2"><i class="bi bi-envelope"></i> info@project-s.test</li>
                    <li class="flex items-center gap-2"><i class="bi bi-telephone"></i> (0xx) xxx-xxxx</li>
                </ul>
            </div>
        </div>

        <div class="border-t border-gray-100 dark:border-gray-800 py-4 text-center text-xs text-gray-400 dark:text-gray-600">
            &copy; {{ date('Y') }} Sapras — Sistem Data Sarana &amp; Prasarana Sekolah.
        </div>
    </footer>

    @vite(['resources/js/app.js'])
    @stack('scripts')
</body>

</html>