@extends('layouts.home')

@section('title')
    Panduan Penggunaan
@endsection

@section('content')
    <div class="flex flex-col gap-4 px-4 sm:px-6 lg:px-8 py-6 sm:py-8 max-w-6xl mx-auto">
        <!-- Header -->
        <div class="flex flex-wrap items-center justify-between gap-3">
            <h1 class="text-base sm:text-lg font-semibold text-gray-800 dark:text-gray-100 flex items-center gap-2">
                <i class="bi bi-question-circle"></i>
                Panduan Penggunaan
            </h1>
        </div>

        <p class="text-sm text-gray-500 dark:text-gray-400 max-w-2xl">
            Kumpulan langkah singkat untuk membantu Anda memakai sistem data sarana &amp;
            prasarana sekolah ini. Klik tiap topik untuk membuka penjelasannya.
        </p>

        <!-- ===== GRID PANDUAN (2 kolom di layar besar) ===== -->
        <div class="grid grid-cols-1 gap-4">
                <!-- ===== UNTUK SEMUA PENGGUNA ===== -->
                <x-card>
                <x-slot:header>
                    <div class="flex items-center gap-2 text-blue-600 dark:text-blue-400">
                        <i class="bi bi-person"></i>
                        Untuk Semua Pengguna
                    </div>
                </x-slot:header>

                <x-accordion id="panduanUmum">
                    <x-accordion.item title="Bagaimana cara masuk (login) ke sistem?" open>
                        <ol class="list-decimal list-inside space-y-1">
                            <li>Buka halaman utama, klik tombol <strong>Login</strong>.</li>
                            <li>Masukkan email dan password akun Anda.</li>
                            <li>Klik tombol <strong>Login</strong> — Anda akan diarahkan ke halaman sesuai peran (admin atau user).</li>
                        </ol>
                        <p class="mt-2">Lupa password? Hubungi admin sekolah/dinas untuk direset, karena fitur reset password mandiri belum tersedia.</p>
                    </x-accordion.item>

                    <x-accordion.item title="Bagaimana cara mendaftar akun baru?">
                        <ol class="list-decimal list-inside space-y-1">
                            <li>Dari halaman Login, klik <strong>Daftar Sekarang</strong>.</li>
                            <li>Isi Username, Email, Password, dan Konfirmasi Password.</li>
                            <li>Klik <strong>Daftar Sekarang</strong>.</li>
                            <li>Cek email Anda dan klik link verifikasi yang dikirim sebelum bisa login.</li>
                        </ol>
                    </x-accordion.item>

                    <x-accordion.item title="Saya tidak menerima email verifikasi, bagaimana?">
                        <ul class="list-disc list-inside space-y-1">
                            <li>Cek folder <strong>Spam/Junk</strong> di email Anda.</li>
                            <li>Kalau belum ada juga, buka halaman verifikasi dan klik tombol <strong>Kirim Ulang Email Verifikasi</strong>.</li>
                            <li>Pastikan alamat email yang didaftarkan benar. Kalau salah ketik, logout lalu daftar ulang dengan email yang benar.</li>
                        </ul>
                    </x-accordion.item>

                    <x-accordion.item title="Bagaimana cara mengganti password / profil saya?">
                        <p>Klik foto/avatar Anda di pojok kanan atas navbar → pilih <strong>Profil Saya</strong>. Di sana ada 2 form terpisah: ubah nama/email, dan ubah password — bisa diisi salah satu saja tanpa harus mengisi keduanya.</p>
                    </x-accordion.item>

                    {{-- <x-accordion.item title="Bagaimana cara ganti tampilan gelap (dark mode)?">
                        <p>Klik ikon bulan/matahari di navbar bagian atas (sebelah kiri foto profil Anda). Pilihan ini otomatis tersimpan di perangkat Anda untuk kunjungan berikutnya.</p>
                    </x-accordion.item> --}}
                </x-accordion>
            </x-card>

            <!-- ===== UNTUK USER (SEKOLAH) ===== -->
            <x-card>
                <x-slot:header>
                    <div class="flex items-center gap-2 text-blue-600 dark:text-blue-400">
                        <i class="bi bi-building"></i>
                        Untuk Sekolah (User)
                    </div>
                </x-slot:header>

                <x-accordion id="panduanUser">
                    <x-accordion.item title="Bagaimana cara mengisi data sarana sekolah pertama kali?" open>
                        <ol class="list-decimal list-inside space-y-1">
                            <li>Masuk ke menu <strong>Sarana</strong> di sidebar.</li>
                            <li>Kalau belum ada data, klik tombol <strong>Tambah Data</strong>.</li>
                            <li>Isi seluruh formulir (data sekolah, jumlah siswa, kondisi ruang kelas, furnitur, dst.) — data dibagi per kategori dalam beberapa kartu, isi satu per satu dari atas ke bawah.</li>
                            <li>Klik <strong>Simpan</strong> di bagian paling bawah form.</li>
                        </ol>
                    </x-accordion.item>

                    <x-accordion.item title="Bagaimana cara mengubah data yang sudah tersimpan?">
                        <p>Setiap sekolah cuma boleh punya 1 data. Di halaman <strong>Sarana</strong>, klik tombol <strong>Update</strong> pada data yang sudah ada untuk membuka form edit, ubah bagian yang perlu, lalu simpan.</p>
                    </x-accordion.item>

                    <x-accordion.item title="Apa itu RKB dan Rehabilitasi Ruang Kelas?">
                        <p><strong>RKB (Ruang Kelas Baru)</strong> adalah jumlah ruang kelas yang baru dibangun (bukan renovasi) dalam periode pelaporan tertentu. <strong>Rehabilitasi Ruang Kelas</strong> adalah jumlah ruang kelas lama yang diperbaiki/renovasi (bukan bangunan baru) dalam periode yang sama.</p>
                        <p class="mt-2">Periode tahun untuk keduanya (misalnya "2020-2025") ditampilkan otomatis di form — <strong>hanya admin</strong> yang bisa mengubah periode ini. Anda cukup mengisi jumlahnya sesuai periode yang sedang berjalan.</p>
                    </x-accordion.item>

                    <x-accordion.item title="Kenapa jumlah RKB/Rehabilitasi saya tiba-tiba jadi 0?">
                        <p>Ini normal — terjadi saat admin memperbarui periode pelaporan (misalnya dari 2020-2025 ke periode baru). Saat periode berganti, jumlah RKB/Rehabilitasi <strong>seluruh sekolah</strong> otomatis direset ke 0, karena data lama dianggap milik periode sebelumnya. Silakan isi ulang sesuai data periode yang baru.</p>
                    </x-accordion.item>

                    {{-- <x-accordion.item title="Bagaimana cara mengunduh (export) data sekolah saya ke Excel?">
                        <p>Di halaman <strong>Sarana</strong>, klik tombol <strong>Export Excel</strong> di bagian atas (hanya muncul kalau data sekolah Anda sudah ada). File akan otomatis terunduh dalam format <code>.xlsx</code>.</p>
                    </x-accordion.item> --}}
                </x-accordion>
            </x-card>
        </div>

        <!-- ===== BUTUH BANTUAN LEBIH LANJUT ===== -->
        <x-alert type="info" icon>
            Masih ada pertanyaan yang belum terjawab di sini? Hubungi admin/pengelola sistem di sekolah atau dinas Anda.
        </x-alert>
    </div>
@endsection