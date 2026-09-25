<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login - Masuk Akun</title>

    @vite(['resources/css/app.css'])
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <script>
        (function() {
            const stored = localStorage.getItem('theme');
            const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            if (stored === 'dark' || (!stored && prefersDark)) {
                document.documentElement.classList.add('dark');
            }
        })();
    </script>
</head>

<body>
    <div class="min-h-screen grid grid-cols-1 md:grid-cols-2">
        {{-- Left Side: Hero/Illustration --}}
        <div
            class="hidden md:flex flex-col items-center justify-center gap-1 p-8 text-white text-center bg-linear-to-br from-[#2E86C1] to-[#164C74] dark:from-[#1a1a2e] dark:to-[#16213e]">
            <img src="{{ asset('assets/img/logo.webp') }}" alt="Logo Kementerian Pendidikan Dasar dan Menengah"
                class="w-48 h-48 lg:w-100 lg:h-100 xl:w-full xl:h-full object-cover mb-4 drop-shadow-lg">
            <h1 class="text-3xl font-bold">Sistem Manajemen</h1>
            <p class="opacity-90 mt-1">Kelola data sarana & prasarana sekolah menegah pertama kabupaten Lahat</p>
            <div class="mt-8 flex gap-2 text-sm opacity-80">
                <span class="px-3 py-1 bg-white/20 rounded-full">✓ Aman & Terpercaya</span>
                <span class="px-3 py-1 bg-white/20 rounded-full">✓ 24/7 Support</span>
            </div>
        </div>

        {{-- Right Side: Form --}}
        <div class="flex items-start md:items-center justify-center bg-white dark:bg-gray-800 p-8 pt-12 md:pt-8">
            <div class="w-full max-w-100">
                <div class="mb-6">
                    <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Selamat Datang Kembali</h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Masuk untuk melanjutkan ke akun Anda</p>
                </div>

                {{-- ALERT SUKSES --}}
                @if (session('success'))
                    <x-alert type="success" dismissible icon class="mb-4">
                        <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                    </x-alert>
                @endif

                {{-- ALERT ERROR --}}
                @if (session('error'))
                    <x-alert type="danger" dismissible icon class="mb-4">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
                    </x-alert>
                @endif

                {{-- ALERT VALIDASI ERROR --}}
                @if ($errors->any())
                    <x-alert type="danger" dismissible icon class="mb-4">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        <ul class="list-disc list-inside text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </x-alert>
                @endif

                <form action="{{ route('auth.authenticate') }}" method="post" class="flex flex-col gap-4">
                    @csrf

                    <x-form.input name="email" label="Alamat Email" type="email" placeholder="nama@email.com"
                        required :value="old('email')">
                        <x-slot:prefix>
                            <i class="bi bi-envelope-at-fill"></i>
                        </x-slot:prefix>
                    </x-form.input>

                    <x-form.input name="password" label="Password" type="password" placeholder="Masukkan password"
                        required>
                        <x-slot:prefix>
                            <i class="bi bi-key-fill"></i>
                        </x-slot:prefix>
                        <x-slot:suffix>
                            <button type="button" data-toggle-password="password"
                                class="focus:outline-none text-gray-400 hover:text-gray-600 dark:hover:text-gray-200"
                                aria-label="Tampilkan/sembunyikan password">
                                <i class="bi bi-eye-fill" data-toggle-password-icon></i>
                            </button>
                        </x-slot:suffix>
                    </x-form.input>

                    <x-button variant="primary" type="submit" block class="mt-2">
                        <i class="bi bi-box-arrow-in-right me-2"></i> Login
                    </x-button>
                </form>
            </div>
        </div>
    </div>

    @vite(['resources/js/app.js'])

    {{-- Toggle show/hide password --}}
    <script>
        document.addEventListener('click', function(event) {
            const btn = event.target.closest('[data-toggle-password]');
            if (!btn) return;

            const input = document.getElementById(btn.getAttribute('data-toggle-password'));
            const icon = btn.querySelector('[data-toggle-password-icon]');
            if (!input || !icon) return;

            const isHidden = input.type === 'password';
            input.type = isHidden ? 'text' : 'password';
            icon.classList.toggle('bi-eye-fill', !isHidden);
            icon.classList.toggle('bi-eye-slash-fill', isHidden);
        });
    </script>
</body>

</html>