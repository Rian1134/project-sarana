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
                        <p class="mt-2">Lupa password? Hubungi admin untuk direset, karena fitur reset password mandiri belum tersedia.</p>
                    </x-accordion.item>

                    <x-accordion.item title="Bagaimana cara mendapatkan akun?">
                        <p>Akun dibuat oleh admin. Hubungi admin/pengelola sistem di dinas Anda dan berikan nama serta email yang akan dipakai. Setelah akun dibuat, Anda bisa langsung login dan mengganti password sendiri.</p>
                    </x-accordion.item>

                    <x-accordion.item title="Bagaimana cara mengubah profil, foto, atau password?">
                        <p>Klik foto/avatar Anda di pojok kanan atas → pilih <strong>Profil Saya</strong>. Ada dua halaman terpisah:</p>
                        <ul class="list-disc list-inside space-y-1 mt-2">
                            <li><strong>Edit Profil</strong>: ubah nama, email, dan foto profil (foto otomatis diperkecil, maksimal 2 MB, format JPG/PNG/WebP).</li>
                            <li><strong>Ubah Password</strong>: Anda wajib mengisi password saat ini, lalu password baru dan konfirmasinya.</li>
                        </ul>
                    </x-accordion.item>
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
                            <li>Isi seluruh formulir. Data dibagi per kartu: data sekolah (nama, NPSN, status, akreditasi, website, kepala sekolah), guru dan staf TU (status kepegawaian dan golongan), jumlah siswa dan rombel, ruang kelas, toilet, ruang &amp; fasilitas, serta furnitur &amp; perangkat. Isi satu per satu dari atas ke bawah.</li>
                            <li>Klik <strong>Simpan</strong> di bagian paling bawah form.</li>
                        </ol>
                    </x-accordion.item>

                    <x-accordion.item title="Bagaimana cara mengubah data yang sudah tersimpan?">
                        <p>Setiap akun hanya boleh punya 1 data sekolah. Di halaman <strong>Sarana</strong>, klik tombol <strong>Update</strong> pada data yang sudah ada untuk membuka form edit, ubah bagian yang perlu, lalu simpan.</p>
                    </x-accordion.item>

                    <x-accordion.item title="Kenapa ada bagian form yang tidak bisa saya isi (terkunci)?">
                        <p>Admin mengatur izin pengisian per bagian: guru &amp; staf TU, siswa &amp; rombel, ruang kelas, toilet, ruang &amp; fasilitas, serta furnitur &amp; perangkat. Bagian yang izinnya dicabut tidak bisa diisi atau diubah. Saat tambah data pertama, bagian terkunci diisi nilai awal (0 / tidak ada), dan saat edit nilainya dibiarkan seperti yang sudah tersimpan. Kalau bagian itu perlu Anda isi, hubungi admin untuk membuka izinnya.</p>
                    </x-accordion.item>

                    <x-accordion.item title="Apa itu RKB dan Rehabilitasi Ruang Kelas?">
                        <p><strong>RKB (Ruang Kelas Baru)</strong> adalah jumlah ruang kelas yang baru dibangun (bukan renovasi) dalam periode pelaporan tertentu. <strong>Rehabilitasi Ruang Kelas</strong> adalah jumlah ruang kelas lama yang diperbaiki/renovasi (bukan bangunan baru) dalam periode yang sama.</p>
                        <p class="mt-2">Periode tahun untuk keduanya (misalnya "2026 s/d 2030") ditampilkan otomatis di form — <strong>hanya admin</strong> yang bisa mengubah periode ini. Anda cukup mengisi jumlahnya sesuai periode yang sedang berjalan.</p>
                    </x-accordion.item>

                    <x-accordion.item title="Kenapa jumlah RKB/Rehabilitasi saya tiba-tiba jadi 0?">
                        <p>Ini normal — terjadi saat admin memperbarui periode pelaporan. Saat periode berganti, jumlah RKB/Rehabilitasi <strong>seluruh sekolah</strong> otomatis direset ke 0, karena data lama dianggap milik periode sebelumnya. Silakan isi ulang sesuai data periode yang baru.</p>
                    </x-accordion.item>
                </x-accordion>
            </x-card>

            <!-- ===== LAPORAN KERUSAKAN & RENCANA PEMBANGUNAN ===== -->
            <x-card>
                <x-slot:header>
                    <div class="flex items-center gap-2 text-blue-600 dark:text-blue-400">
                        <i class="bi bi-clipboard-check"></i>
                        Laporan Kerusakan &amp; Rencana Pembangunan
                    </div>
                </x-slot:header>

                <x-accordion id="panduanPengajuan">
                    <x-accordion.item title="Bagaimana cara membuat Laporan Kerusakan?" open>
                        <ol class="list-decimal list-inside space-y-1">
                            <li>Buka menu <strong>Laporan Kerusakan</strong>, lalu klik tombol tambah.</li>
                            <li>Centang satu atau beberapa kategori yang rusak (ruang kelas, toilet, ruang guru, lab, pagar, dan lainnya).</li>
                            <li>Isi rincian tiap kategori yang dicentang. Untuk ruang kelas dan toilet, isi <strong>jumlah yang rusak</strong>. Untuk kategori lain, isi <strong>Ada / Tidak Ada</strong> dan <strong>Kondisi Saat Ini</strong> (Rusak Ringan, Rusak Sedang, Rusak Berat, atau Nihil).</li>
                            <li>Klik kirim. Beberapa kategori yang dikirim sekaligus tersimpan sebagai satu laporan.</li>
                        </ol>
                    </x-accordion.item>

                    <x-accordion.item title="Bagaimana cara mengajukan Rencana Pembangunan?">
                        <ol class="list-decimal list-inside space-y-1">
                            <li>Buka menu <strong>Rencana Pembangunan</strong>, lalu klik tombol tambah.</li>
                            <li>Centang kategori yang ingin diajukan.</li>
                            <li>Untuk tiap kategori, pilih jenisnya: <strong>Bangun Baru</strong> (belum ada dan ingin dibangun) atau <strong>Rehabilitasi</strong> (sudah ada dan ingin diperbaiki).</li>
                            <li>Khusus ruang kelas dan toilet, isi juga jumlahnya. Kategori lain cukup memilih jenis.</li>
                            <li>Klik kirim.</li>
                        </ol>
                    </x-accordion.item>

                    <x-accordion.item title="Apa arti status pending, approved, dan rejected?">
                        <ul class="list-disc list-inside space-y-1">
                            <li><strong>Pending</strong>: menunggu review admin.</li>
                            <li><strong>Approved</strong>: disetujui admin.</li>
                            <li><strong>Rejected</strong>: ditolak admin.</li>
                        </ul>
                        <p class="mt-2">Laporan dan pengajuan hanya mencatat usulan. Walaupun disetujui, <strong>data sarana sekolah tidak berubah otomatis</strong>. Kalau kondisi di lapangan sudah berubah, perbarui sendiri lewat menu <strong>Sarana</strong>.</p>
                    </x-accordion.item>

                    <x-accordion.item title="Bisakah laporan/pengajuan yang sudah dikirim diubah atau dihapus?">
                        <p>Bisa, tetapi hanya selama statusnya masih <strong>pending</strong>. Setelah disetujui atau ditolak, laporan tidak bisa diedit maupun dihapus. Saat mengedit, kategori yang sudah tersimpan tetap dipertahankan, dan Anda bisa menambah kategori baru ke laporan yang sama.</p>
                    </x-accordion.item>
                </x-accordion>
            </x-card>

            <!-- ===== UNTUK ADMIN ===== -->
            <x-card>
                <x-slot:header>
                    <div class="flex items-center gap-2 text-blue-600 dark:text-blue-400">
                        <i class="bi bi-shield-check"></i>
                        Untuk Admin
                    </div>
                </x-slot:header>

                <x-accordion id="panduanAdmin">
                    <x-accordion.item title="Bagaimana cara menambah atau mengelola user?" open>
                        <ol class="list-decimal list-inside space-y-1">
                            <li>Buka menu <strong>User</strong>, lalu klik tambah user.</li>
                            <li>Isi nama, email, password, pilih role (admin atau user), dan foto jika perlu.</li>
                            <li>Untuk mengubah, klik <strong>Edit User</strong> di halaman detail. Password boleh dikosongkan kalau tidak ingin diganti.</li>
                        </ol>
                        <p class="mt-2">Menghapus user juga <strong>menghapus data sekolah miliknya</strong>, dan tidak bisa dibatalkan. Anda tidak bisa menghapus akun Anda sendiri.</p>
                    </x-accordion.item>

                    <x-accordion.item title="Bagaimana cara mengatur izin pengisian data user?">
                        <p>Buka detail user, klik <strong>Kelola Izin</strong>. Bagian yang <strong>dicentang</strong> akan dikunci (user tidak bisa mengisinya), sedangkan yang tidak dicentang boleh diisi. Bagian yang bisa diatur: Guru &amp; Staff TU, Jumlah Siswa &amp; Rombel, RKB/Rehabilitasi/Ruang Kelas, Toilet, Ruang &amp; Fasilitas Sekolah, serta Furnitur &amp; Perangkat.</p>
                    </x-accordion.item>

                    <x-accordion.item title="Bagaimana cara mengubah periode RKB dan Rehabilitasi?">
                        <p>Buka halaman pengaturan periode, ubah tahun awal dan tahun akhir untuk RKB dan/atau Rehabilitasi, lalu simpan. Periode berlaku untuk semua sekolah.</p>
                        <p class="mt-2"><strong>Perhatian:</strong> setiap kali periode suatu kategori berubah, jumlah kategori itu di <strong>semua sekolah</strong> otomatis direset ke 0. Beri tahu sekolah agar mengisi ulang.</p>
                    </x-accordion.item>

                    <x-accordion.item title="Bagaimana cara me-review Laporan Kerusakan dan Rencana Pembangunan?">
                        <p>Buka daftar <strong>Laporan Kerusakan</strong> atau <strong>Rencana Pembangunan</strong>, buka salah satu laporan, lalu klik <strong>Setujui</strong> atau <strong>Tolak</strong>. Hanya laporan berstatus pending yang bisa diproses. Yang berubah hanya statusnya, data sarana sekolah tidak ikut diubah.</p>
                    </x-accordion.item>

                    <x-accordion.item title="Bagaimana cara mengunduh (export) data ke Excel?">
                        <p>Di halaman <strong>Sarana</strong> (admin), klik tombol <strong>Export Excel</strong>. File <code>.xlsx</code> berisi data seluruh sekolah dalam format tabel laporan lengkap beserta baris total, dan akan otomatis terunduh.</p>
                    </x-accordion.item>
                </x-accordion>
            </x-card>
        </div>

        <!-- ===== BUTUH BANTUAN LEBIH LANJUT ===== -->
        <x-alert type="info" icon>
            Masih ada pertanyaan yang belum terjawab di sini? Hubungi admin/pengelola sistem di sekolah atau dinas Anda.
        </x-alert>
    </div>
@endsection