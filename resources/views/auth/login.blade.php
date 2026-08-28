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

    <style>
        .login-wrapper {
            min-height: 100vh;
            display: grid;
            grid-template-columns: 1fr 1fr;
        }
        .login-form {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            background: #ffffff;
        }
        .dark .login-form {
            background: #1f2937;
        }
        .login-hero {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
            padding: 2rem;
            color: white;
        }
        .dark .login-hero {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
        }
        .login-card {
            width: 100%;
            max-width: 400px;
        }
        @media (max-width: 768px) {
            .login-wrapper {
                grid-template-columns: 1fr;
            }
            .login-hero {
                display: none;
            }
            .login-form {
                align-items: flex-start;
                padding-top: 2rem;
            }
        }
        .hero-icon {
            font-size: 5rem;
            margin-bottom: 1.5rem;
            opacity: 0.9;
        }
        .hero-title {
            font-size: 2rem;
            font-weight: 700;
            text-align: center;
        }
        .hero-subtitle {
            text-align: center;
            opacity: 0.9;
            margin-top: 0.5rem;
        }
    </style>
</head>

<body>
    <div class="login-wrapper">
        {{-- Left Side: Form --}}
        <div class="login-form">
            <div class="login-card">
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

                    <x-form.input
                        name="email"
                        label="Alamat Email"
                        type="email"
                        placeholder="nama@email.com"
                        required
                        :value="old('email')"
                    >
                        <x-slot:prefix>
                            <i class="bi bi-envelope-at-fill"></i>
                        </x-slot:prefix>
                    </x-form.input>

                    <x-form.input
                        name="password"
                        label="Password"
                        type="password"
                        placeholder="Masukkan password"
                        required
                    >
                        <x-slot:prefix>
                            <i class="bi bi-key-fill"></i>
                        </x-slot:prefix>
                        <x-slot:suffix>
                            <button type="button" data-toggle-password="password" class="focus:outline-none text-gray-400 hover:text-gray-600 dark:hover:text-gray-200" aria-label="Tampilkan/sembunyikan password">
                                <i class="bi bi-eye-fill" data-toggle-password-icon></i>
                            </button>
                        </x-slot:suffix>
                    </x-form.input>

                    <x-button variant="success" type="submit" block class="mt-2">
                        <i class="bi bi-box-arrow-in-right me-2"></i> Login
                    </x-button>

                    <div class="text-center text-sm text-gray-500 dark:text-gray-400">
                        Belum punya akun?
                        <a href="{{ route('auth.register') }}" class="text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 font-medium transition-colors">
                            Daftar Sekarang
                        </a>
                    </div>
                </form>
            </div>
        </div>

        {{-- Right Side: Hero/Illustration --}}
        <div class="login-hero">
            <div class="hero-icon">
                <i class="bi bi-shield-lock-fill"></i>
            </div>
            <h1 class="hero-title">Sistem Manajemen</h1>
            <p class="hero-subtitle">Kelola data sarana & prasarana sekolah dengan mudah</p>
            <div class="mt-8 flex gap-2 text-sm opacity-80">
                <span class="px-3 py-1 bg-white/20 rounded-full">✓ Aman & Terpercaya</span>
                <span class="px-3 py-1 bg-white/20 rounded-full">✓ 24/7 Support</span>
            </div>
        </div>
    </div>

    @vite(['resources/js/app.js'])

    {{-- Toggle show/hide password --}}
    <script>
        document.addEventListener('click', function (event) {
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