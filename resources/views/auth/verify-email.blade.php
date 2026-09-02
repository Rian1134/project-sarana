<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Verifikasi Email</title>

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
        .auth-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        }
        .dark .auth-wrapper {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
        }
        .auth-card {
            width: 100%;
            max-width: 480px;
        }
        .auth-icon-circle {
            width: 4.5rem;
            height: 4.5rem;
            font-size: 2rem;
            background: #dcfce7;
            color: #16a34a;
        }
        .dark .auth-icon-circle {
            background: rgba(34, 197, 94, 0.15);
            color: #4ade80;
        }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .auth-card { animation: fadeInUp 0.5s ease-out; }
    </style>
</head>

<body>
    <div class="auth-wrapper">
        <div class="auth-card">
            <x-card>
                <div class="flex flex-col items-center text-center gap-4 py-2">
                    <span class="auth-icon-circle flex items-center justify-center rounded-full">
                        <i class="bi bi-envelope-check-fill"></i>
                    </span>

                    <div>
                        <h2 class="text-xl font-bold text-gray-800 dark:text-gray-100">Verifikasi Alamat Email Anda</h2>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-2 max-w-sm">
                            Terima kasih sudah mendaftar! Kami sudah mengirim link verifikasi ke alamat email Anda.
                            Silakan cek kotak masuk (atau folder spam) dan klik link tersebut untuk mengaktifkan akun.
                        </p>
                    </div>

                    {{-- Pesan sukses saat link verifikasi berhasil dikirim ulang --}}
                    @if (session('status') == 'verification-link-sent')
                        <x-alert type="success" dismissible icon class="w-full text-left">
                            Link verifikasi baru sudah dikirim ke alamat email Anda.
                        </x-alert>
                    @endif

                    @if (session('error'))
                        <x-alert type="danger" dismissible icon class="w-full text-left">
                            {{ session('error') }}
                        </x-alert>
                    @endif

                    <div class="flex flex-col sm:flex-row gap-3 w-full mt-2">
                        <form action="{{ route('verification.send') }}" method="POST" class="flex-1">
                            @csrf
                            <x-button type="submit" variant="success" fullWidth>
                                <i class="bi bi-arrow-repeat me-2"></i> Kirim Ulang Email Verifikasi
                            </x-button>
                        </form>

                        <form action="{{ route('auth.logout') }}" method="POST" class="flex-1">
                            @csrf
                            <x-button type="submit" variant="light" fullWidth>
                                <i class="bi bi-box-arrow-right me-2"></i> Logout
                            </x-button>
                        </form>
                    </div>

                    <p class="text-xs text-gray-400 dark:text-gray-600 mt-1">
                        Salah alamat email? Logout dulu, lalu daftar ulang dengan email yang benar.
                    </p>
                </div>
            </x-card>

            <p class="text-center text-xs text-gray-500 dark:text-gray-400 mt-4">
                &copy; {{ date('Y') }} {{ config('app.name', 'Project-S') }}. All rights reserved.
            </p>
        </div>
    </div>

    @vite(['resources/js/app.js'])
</body>

</html>