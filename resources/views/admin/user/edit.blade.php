@extends('layouts.admin')

@section('title')
    Edit User
@endsection

@section('content')
    {{-- Header --}}
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-xl font-semibold text-gray-800 dark:text-gray-100">Edit user</h1>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                Perbarui data akun, foto profil, dan hak akses {{ $user->name }}.
            </p>
        </div>
        <div>
            <x-button href="{{ route('user.index') }}" variant="secondary" class="gap-1">
                <i class="bi bi-arrow-left"></i> Kembali
            </x-button>
        </div>
    </div>

    <form id="form-edit-user" action="{{ route('user.update', $user->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 gap-5 lg:grid-cols-3">

            {{-- Kolom kiri: foto profil & info akun --}}
            <div class="space-y-5 lg:col-span-1">
                <x-card>
                    <div class="p-5">
                        <h2 class="text-base font-semibold text-gray-800 dark:text-gray-100">Foto profil</h2>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                            Tampil di daftar user dan di halaman profil.
                        </p>

                        <div class="mt-6">
                            <x-foto-upload :user="$user" />
                        </div>
                    </div>
                </x-card>

                <x-card>
                    <div class="p-5">
                        <h2 class="text-base font-semibold text-gray-800 dark:text-gray-100">Info akun</h2>

                        <dl class="mt-4 space-y-3 text-sm">
                            <div class="flex items-center justify-between gap-3">
                                <dt class="text-gray-500 dark:text-gray-400">ID user</dt>
                                <dd class="font-medium text-gray-900 dark:text-white">{{ $user->id }}</dd>
                            </div>
                            <div class="flex items-center justify-between gap-3">
                                <dt class="text-gray-500 dark:text-gray-400">Bergabung</dt>
                                <dd class="font-medium text-gray-900 dark:text-white">
                                    {{ $user->created_at->format('d-m-Y H:i') }}
                                </dd>
                            </div>
                            <div class="flex items-center justify-between gap-3">
                                <dt class="text-gray-500 dark:text-gray-400">Terakhir update</dt>
                                <dd class="font-medium text-gray-900 dark:text-white">
                                    {{ $user->updated_at->format('d-m-Y H:i') }}
                                </dd>
                            </div>
                        </dl>
                    </div>
                </x-card>
            </div>

            {{-- Kolom kanan: data akun --}}
            <div class="space-y-5 lg:col-span-2">

                {{-- Informasi akun --}}
                <x-card>
                    <div class="p-5">
                        <h2 class="text-base font-semibold text-gray-800 dark:text-gray-100">Informasi akun</h2>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                            Email dipakai user untuk masuk ke aplikasi.
                        </p>

                        <div class="mt-5 grid grid-cols-1 gap-4 md:grid-cols-2">
                            <x-form.input
                                name="name"
                                label="Nama lengkap"
                                required
                                placeholder="Contoh: Budi Santoso"
                                value="{{ old('name', $user->name) }}"
                            />

                            <x-form.input
                                name="email"
                                label="Email"
                                type="email"
                                required
                                placeholder="nama@contoh.com"
                                value="{{ old('email', $user->email) }}"
                            />
                        </div>
                    </div>
                </x-card>

                {{-- Keamanan --}}
                <x-card>
                    <div class="p-5">
                        <h2 class="text-base font-semibold text-gray-800 dark:text-gray-100">Kata sandi</h2>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                            Kosongkan jika tidak ingin mengubah kata sandi. Jika diisi, minimal 8 karakter.
                        </p>

                        <div class="mt-5 grid grid-cols-1 gap-4 md:grid-cols-2">
                            <x-form.input
                                name="password"
                                label="Kata sandi baru"
                                type="password"
                                placeholder="Kosongkan jika tidak diubah"
                            />

                            <x-form.input
                                name="password_confirmation"
                                label="Ulangi kata sandi baru"
                                type="password"
                                placeholder="Ketik ulang kata sandi baru"
                            />
                        </div>
                    </div>
                </x-card>

                {{-- Hak akses --}}
                <x-card>
                    <div class="p-5">
                        <h2 class="text-base font-semibold text-gray-800 dark:text-gray-100">Hak akses</h2>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                            Tentukan apa saja yang boleh diakses user ini.
                        </p>

                        @php
                            $infoRole = [
                                'admin' => [
                                    'ikon' => 'bi-shield-lock',
                                    'judul' => 'Admin',
                                    'deskripsi' => 'Mengelola user, data sarana, periode laporan, dan pengajuan.',
                                ],
                                'user' => [
                                    'ikon' => 'bi-person',
                                    'judul' => 'User sekolah',
                                    'deskripsi' => 'Mengisi data sekolah dan mengajukan koreksi atau rencana pembangunan.',
                                ],
                            ];
                            $roleTerpilih = old('role', $userRole->name ?? null);
                        @endphp

                        <fieldset class="mt-5">
                            <legend class="sr-only">Pilih role</legend>

                            <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
                                @foreach ($roles as $role)
                                    @php
                                        $info = $infoRole[$role->name] ?? [
                                            'ikon' => 'bi-person-badge',
                                            'judul' => ucfirst($role->name),
                                            'deskripsi' => 'Hak akses ' . $role->name . '.',
                                        ];
                                    @endphp

                                    <label class="relative block cursor-pointer">
                                        <input type="radio"
                                               name="role"
                                               value="{{ $role->name }}"
                                               class="peer sr-only"
                                               @checked($roleTerpilih === $role->name)>

                                        <div class="flex h-full gap-3 rounded-xl border border-gray-200 p-4 transition hover:border-gray-400 peer-checked:border-gray-800 peer-checked:bg-gray-50 peer-checked:ring-1 peer-checked:ring-gray-800 peer-focus-visible:ring-2 peer-focus-visible:ring-gray-400 dark:border-gray-700 dark:hover:border-gray-500 dark:peer-checked:border-gray-100 dark:peer-checked:bg-gray-800 dark:peer-checked:ring-gray-100">
                                            <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-gray-100 text-lg text-gray-700 dark:bg-gray-700 dark:text-gray-100">
                                                <i class="bi {{ $info['ikon'] }}"></i>
                                            </span>
                                            <span class="pr-6">
                                                <span class="block text-sm font-medium text-gray-900 dark:text-gray-100">{{ $info['judul'] }}</span>
                                                <span class="mt-0.5 block text-sm leading-snug text-gray-500 dark:text-gray-400">{{ $info['deskripsi'] }}</span>
                                            </span>
                                        </div>

                                        <i class="bi bi-check-circle-fill absolute right-3 top-3 text-lg text-gray-800 opacity-0 transition peer-checked:opacity-100 dark:text-gray-100"></i>
                                    </label>
                                @endforeach
                            </div>

                            @error('role')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </fieldset>
                    </div>
                </x-card>
            </div>
        </div>

        {{-- Tombol aksi --}}
        <div class="mt-6 flex flex-col-reverse gap-2 sm:flex-row sm:justify-end">
            <x-button href="{{ route('user.index') }}" variant="secondary" class="justify-center gap-1">
                <i class="bi bi-x-circle"></i> Batal
            </x-button>
            <x-button type="submit" variant="primary" class="justify-center gap-1" id="tombol-simpan">
                <i class="bi bi-save"></i> Simpan perubahan
            </x-button>
        </div>
    </form>

    <script>
        (function () {
            const form = document.getElementById('form-edit-user');
            if (!form) return;

            // --- Tombol tampil/sembunyi pada kolom kata sandi ---
            const kolomPassword = form.querySelectorAll('input[type="password"]');

            kolomPassword.forEach(function (input) {
                const pembungkus = document.createElement('div');
                pembungkus.className = 'relative';
                input.parentNode.insertBefore(pembungkus, input);
                pembungkus.appendChild(input);
                input.classList.add('pr-11');

                const tombol = document.createElement('button');
                tombol.type = 'button';
                tombol.setAttribute('aria-label', 'Tampilkan kata sandi');
                tombol.className = 'absolute inset-y-0 right-0 flex w-11 items-center justify-center rounded-r-lg text-gray-500 hover:text-gray-800 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-gray-400 dark:text-gray-400 dark:hover:text-gray-100';
                tombol.innerHTML = '<i class="bi bi-eye"></i>';

                tombol.addEventListener('click', function () {
                    const tampil = input.type === 'password';
                    input.type = tampil ? 'text' : 'password';
                    tombol.setAttribute('aria-label', tampil ? 'Sembunyikan kata sandi' : 'Tampilkan kata sandi');
                    tombol.innerHTML = tampil ? '<i class="bi bi-eye-slash"></i>' : '<i class="bi bi-eye"></i>';
                });

                pembungkus.appendChild(tombol);
            });

            // --- Petunjuk langsung: apakah kedua kata sandi sama ---
            const password = form.querySelector('input[name="password"]');
            const konfirmasi = form.querySelector('input[name="password_confirmation"]');

            if (password && konfirmasi) {
                const petunjuk = document.createElement('p');
                petunjuk.className = 'mt-1 hidden text-sm';
                petunjuk.setAttribute('aria-live', 'polite');
                konfirmasi.parentNode.insertAdjacentElement('afterend', petunjuk);

                function periksaKesamaan() {
                    if (!konfirmasi.value) {
                        petunjuk.classList.add('hidden');
                        return;
                    }
                    const sama = password.value === konfirmasi.value;
                    petunjuk.classList.remove('hidden');
                    petunjuk.textContent = sama ? 'Kata sandi sama.' : 'Kata sandi belum sama.';
                    petunjuk.className = 'mt-1 text-sm ' + (sama
                        ? 'text-green-600 dark:text-green-400'
                        : 'text-amber-600 dark:text-amber-400');
                }

                password.addEventListener('input', periksaKesamaan);
                konfirmasi.addEventListener('input', periksaKesamaan);
            }

            // --- Cegah klik ganda saat menyimpan (foto diproses dulu, bisa butuh beberapa detik) ---
            form.addEventListener('submit', function () {
                const tombolSimpan = document.getElementById('tombol-simpan')
                    || form.querySelector('button[type="submit"]');
                if (!tombolSimpan) return;
                tombolSimpan.disabled = true;
                tombolSimpan.classList.add('opacity-70', 'cursor-not-allowed');
                tombolSimpan.innerHTML = '<i class="bi bi-hourglass-split"></i> Menyimpan...';
            });
        })();
    </script>
@endsection