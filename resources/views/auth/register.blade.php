<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register - Daftar Akun</title>

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
        {{-- Left Side: Form --}}
        <div class="flex items-start md:items-center justify-center bg-white dark:bg-gray-800 p-8 pt-12 md:pt-8">
            <div class="w-full max-w-100">
                <div class="mb-6">
                    <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Buat Akun Baru</h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Silakan isi formulir di bawah ini untuk mendaftar</p>
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

                <form action="{{ route('auth.store') }}" method="post" class="flex flex-col gap-4">
                    @csrf

                    <x-form.input name="name" label="Username" placeholder="Masukkan username" required
                        :value="old('name')">
                        <x-slot:prefix>
                            <i class="bi bi-person-fill"></i>
                        </x-slot:prefix>
                    </x-form.input>

                    <x-form.input name="email" label="Alamat Email" type="email" placeholder="nama@email.com"
                        required :value="old('email')">
                        <x-slot:prefix>
                            <i class="bi bi-envelope-at-fill"></i>
                        </x-slot:prefix>
                    </x-form.input>

                    <x-form.input name="password" label="Password" type="password"
                        placeholder="Minimal 8 karakter" required
                        helper="Gunakan kombinasi huruf, angka, dan simbol">
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

                    <x-form.input name="password_confirmation" label="Konfirmasi Password" type="password"
                        placeholder="Ulangi password" required>
                        <x-slot:prefix>
                            <i class="bi bi-key-fill"></i>
                        </x-slot:prefix>
                        <x-slot:suffix>
                            <button type="button" data-toggle-password="password_confirmation"
                                class="focus:outline-none text-gray-400 hover:text-gray-600 dark:hover:text-gray-200"
                                aria-label="Tampilkan/sembunyikan password">
                                <i class="bi bi-eye-fill" data-toggle-password-icon></i>
                            </button>
                        </x-slot:suffix>
                    </x-form.input>

                    {{-- Terms & Conditions --}}
                    {{-- <div class="flex items-start gap-2 mt-1">
                        <x-form.checkbox name="terms" label="Saya menyetujui Syarat & Ketentuan yang berlaku"
                            required />
                    </div> --}}

                    <x-button variant="primary" type="submit" block class="mt-2">
                        <i class="bi bi-person-plus-fill me-2"></i> Daftar Sekarang
                    </x-button>

                    <div class="text-center text-sm text-gray-500 dark:text-gray-400">
                        Sudah punya akun?
                        <a href="{{ route('login') }}"
                            class="text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 font-medium transition-colors">
                            Login
                        </a>
                    </div>

                    <div class="text-center">
                        <button type="reset"
                            class="text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300 transition-colors">
                            <i class="bi bi-arrow-counterclockwise me-1"></i> Reset Form
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Right Side: Hero/Illustration --}}
        <div
            class="hidden md:flex flex-col items-center justify-center gap-1 p-8 text-white text-center bg-linear-to-br from-[#2E86C1] to-[#164C74] dark:from-[#1a1a2e] dark:to-[#16213e]">
            <div class="bg-white">
                <img src="{{ asset('assets/img/Logo_Kemdikdasmen_bawah.webp') }}"
                    alt="Logo Kementerian Pendidikan Dasar dan Menengah"
                    class="w-32 h-32 lg:w-48 lg:h-48 xl:w-64 xl:h-64 object-contain mb-6 drop-shadow-lg">
            </div>
            <h1 class="text-3xl font-bold">Sistem Manajemen</h1>
            <p class="opacity-90 mt-1">Kelola data sarana & prasarana sekolah dengan mudah</p>
            <div class="mt-8 flex gap-2 text-sm opacity-80">
                <span class="px-3 py-1 bg-white/20 rounded-full">✓ Aman & Terpercaya</span>
                <span class="px-3 py-1 bg-white/20 rounded-full">✓ 24/7 Support</span>
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
    @stack('scripts')
</body>

</html>