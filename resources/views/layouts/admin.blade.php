<!doctype html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sarpras - @yield('title')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    {{-- Set dark mode SEBELUM CSS dimuat, supaya tidak ada "flash" warna terang sesaat.
         Default selalu LIGHT — tidak ikut preferensi sistem, dark mode HANYA aktif
         kalau user pernah menekan toggle-nya sendiri. --}}
    <script>
        (function() {
            if (localStorage.getItem('theme') === 'dark') {
                document.documentElement.classList.add('dark');
            }
        })();
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 dark:bg-gray-900">

    {{-- Toast container — wajib ada agar showToast() dari JS berfungsi --}}
    <div id="toast-container" class="fixed z-60 top-4 inset-x-4 sm:inset-x-auto sm:right-4 flex flex-col gap-2 sm:w-auto max-w-md sm:mx-0 mx-auto"></div>

    {{-- ===== MODAL KONFIRMASI LOGOUT ===== --}}
    <x-modal id="logoutModal" size="sm" centered>
        <x-slot:header>
            <div class="flex items-center gap-2 text-red-600">
                <i class="bi bi-exclamation-triangle-fill text-xl"></i>
                <span>Konfirmasi Logout</span>
            </div>
        </x-slot:header>

        <div class="text-center py-4">
            <div class="text-5xl text-red-500 mb-4">
                <i class="bi bi-box-arrow-right"></i>
            </div>
            <h4 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-2">
                Yakin ingin logout?
            </h4>
            <p class="text-sm text-gray-500 dark:text-gray-400">
                Anda akan keluar dari sistem dan perlu login kembali untuk mengakses halaman ini.
            </p>
        </div>

        <x-slot:footer>
            <x-button variant="secondary" data-modal-close>
                <i class="bi bi-x-circle me-1"></i> Batal
            </x-button>
            <form action="{{ route('auth.logout') }}" method="POST" id="logoutForm" class="inline">
                @csrf
                <x-button variant="danger" type="submit">
                    <i class="bi bi-box-arrow-right me-1"></i> Logout
                </x-button>
            </form>
        </x-slot:footer>
    </x-modal>

    {{-- ===== SHELL: sidebar (kiri, full height) + kolom kanan (navbar + konten) ===== --}}
    <div class="flex min-h-screen">

        {{-- Sidebar: overlay drawer di mobile, kolom sticky full-height di desktop.
             Bisa di-collapse jadi mode ikon saja lewat tombol bawaan komponen. --}}
        <x-sidebar id="mainSidebar">
            {{-- Info user --}}
            <div class="flex items-center gap-3 border-b border-gray-200 dark:border-gray-700 pb-4 mb-3">
                <x-avatar :name="Auth::user()->name ?? 'U'" size="md" />
                <div class="min-w-0 flex-1" data-sidebar-label>
                    <p class="truncate text-sm font-semibold text-gray-800 dark:text-gray-100">{{ Auth::user()->name }}</p>
                    <p class="truncate text-xs text-gray-500 dark:text-gray-400">{{ ucfirst(Auth::user()->role ?? 'Admin') }}</p>
                </div>
            </div>

            {{-- Label section menu --}}
            <p class="px-2 mb-1 text-[11px] font-semibold uppercase tracking-wider text-gray-400 dark:text-gray-500" data-sidebar-label>
                Menu Utama
            </p>

            {{-- Menu utama — active state mengikuti route aktif --}}
            <a href="{{ route('sarana.index') }}"
                class="sidebar-link {{ request()->routeIs('sarana.*') ? 'bg-blue-50 text-blue-600 dark:bg-blue-900/30 dark:text-blue-400 font-medium' : '' }}"
                @if (request()->routeIs('sarana.*')) aria-current="page" @endif>
                <i class="bi bi-grid-1x2-fill text-base shrink-0"></i>
                <span data-sidebar-label>Sarana</span>
            </a>
            <a href="{{ route('user.index') }}"
                class="sidebar-link {{ request()->routeIs('user.*') ? 'bg-blue-50 text-blue-600 dark:bg-blue-900/30 dark:text-blue-400 font-medium' : '' }}"
                @if (request()->routeIs('user.*')) aria-current="page" @endif>
                <i class="bi bi-people-fill text-base shrink-0"></i>
                <span data-sidebar-label>User</span>
            </a>

            {{-- Logout — dengan modal konfirmasi, selalu menempel di bawah --}}
            <button type="button" data-modal-open="logoutModal"
                class="sidebar-link mt-auto text-red-600 hover:bg-red-50 dark:text-red-400 dark:hover:bg-red-900/30 w-full text-left border-t border-gray-200 dark:border-gray-700 pt-3">
                <i class="bi bi-box-arrow-right text-base shrink-0"></i>
                <span data-sidebar-label>Logout</span>
            </button>
        </x-sidebar>

        {{-- Kolom kanan: navbar (sticky) + konten + footer --}}
        <div class="flex flex-col flex-1 min-w-0">

            {{-- ===== NAVBAR (sticky di atas kolom kanan, TIDAK menimpa sidebar) ===== --}}
            <x-navbar class="sticky top-0 z-30 shadow-sm">
                <x-slot:brand>
                    <div class="flex items-center gap-2 min-w-0">
                        <button data-sidebar-open="mainSidebar"
                            class="inline-flex items-center justify-center rounded-md p-1.5 text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 sm:hidden shrink-0"
                            aria-label="Buka menu">
                            <i class="bi bi-list text-2xl leading-none"></i>
                        </button>
                        <span class="flex items-center gap-1.5 font-semibold text-gray-800 dark:text-gray-100 truncate">
                            <i class="bi bi-building"></i>
                            <span>Sarpras</span>
                        </span>
                        <x-badge variant="dark" class="hidden sm:inline-flex">Admin</x-badge>
                        @hasSection('title')
                            <span class="hidden md:flex items-center gap-2 text-gray-400 dark:text-gray-500 text-sm min-w-0">
                                <span>/</span>
                                <span class="truncate text-gray-600 dark:text-gray-300">@yield('title')</span>
                            </span>
                        @endif
                    </div>
                </x-slot:brand>

                <x-slot:actions>
                    {{-- Toggle dark mode --}}
                    <button data-theme-toggle aria-label="Ganti tema"
                        class="inline-flex items-center justify-center rounded-md p-1.5 text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 shrink-0">
                        <i class="bi bi-moon-stars-fill" data-theme-icon-dark></i>
                        <i class="bi bi-sun-fill hidden" data-theme-icon-light></i>
                    </button>

                    {{-- Info user & logout --}}
                    <x-dropdown align="right" width="sm">
                        <x-slot:trigger>
                            <button class="inline-flex items-center gap-2 rounded-md px-1.5 sm:px-2 py-1.5 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">
                                <x-avatar :name="Auth::user()->name ?? 'U'" size="xs" />
                                <span class="hidden sm:block max-w-32 truncate">{{ Auth::user()->name }}</span>
                                <i class="bi bi-chevron-down text-xs hidden sm:inline"></i>
                            </button>
                        </x-slot:trigger>

                        <div class="px-3 py-2 sm:hidden">
                            <p class="truncate text-sm font-semibold text-gray-800 dark:text-gray-100">{{ Auth::user()->name }}</p>
                            <p class="truncate text-xs text-gray-500 dark:text-gray-400">{{ ucfirst(Auth::user()->role ?? 'Admin') }}</p>
                        </div>
                        <div class="border-t border-gray-200 dark:border-gray-700 my-1 sm:hidden"></div>

                        <x-dropdown.item danger type="button" data-modal-open="logoutModal">
                            <i class="bi bi-box-arrow-right mr-1"></i> Logout
                        </x-dropdown.item>
                    </x-dropdown>
                </x-slot:actions>
            </x-navbar>

            {{-- ===== KONTEN UTAMA ===== --}}
            <main class="flex-1 w-full">
                <div class="p-3 sm:p-4 lg:p-6 max-w-[1600px] mx-auto flex flex-col gap-4">
                    {{-- ============================================================
                         ALERT / FLASH MESSAGE — global, satu tempat untuk semua
                         halaman. Jangan taruh alert serupa lagi di masing-masing
                         view, cukup pakai session('success') / session('error') /
                         $errors seperti biasa dari controller.
                         ============================================================ --}}
                    @if (session('success'))
                        <x-alert type="success" dismissible icon :auto-dismiss="6000">
                            {{ session('success') }}
                        </x-alert>
                    @endif

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

                    {{ $slot ?? '' }}
                    @yield('content')
                </div>
            </main>

            <footer class="px-3 sm:px-4 lg:px-6 py-4 text-center text-xs text-gray-400 dark:text-gray-600 border-t border-gray-200 dark:border-gray-800">
                &copy; {{ date('Y') }} Sarpras — Panel Admin, Sistem Data Sarana &amp; Prasarana Sekolah
            </footer>
        </div>
    </div>

    {{-- Script per-halaman (dititipkan lewat @push('scripts') di masing-masing view) --}}
    @stack('scripts')

</body>

</html>