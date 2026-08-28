{{--
    demo.blade.php
    Halaman contoh yang menampilkan hampir seluruh komponen library ini.
    Salin ke resources/views/demo.blade.php lalu buat route:

        Route::view('/demo', 'demo');

    Pastikan @vite sudah memuat resources/css/app.css & resources/js/app.js
    di layout, atau tempel langsung <head> di bawah ini bila ingin dites berdiri sendiri.
--}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Demo UI Kit</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 dark:bg-gray-900 min-h-screen">

    <div id="toast-container" class="fixed z-50 top-4 right-4 flex flex-col gap-2 w-full sm:w-auto px-4 sm:px-0"></div>

    <x-navbar>
        <x-slot:brand>UI Kit</x-slot:brand>
        <a href="#" class="nav-link active">Beranda</a>
        <a href="#" class="nav-link">Komponen</a>
        <x-slot:actions>
            <x-button size="sm" variant="outline-primary">Masuk</x-button>
        </x-slot:actions>
    </x-navbar>

    <main class="mx-auto max-w-5xl px-4 py-8 space-y-10">

        <x-breadcrumb :items="[
            ['label' => 'Beranda', 'url' => '#'],
            ['label' => 'Demo Komponen'],
        ]" />

        {{-- Buttons --}}
        <x-card>
            <x-slot:header>Buttons</x-slot:header>
            <div class="flex flex-wrap gap-2">
                <x-button variant="primary">Primary</x-button>
                <x-button variant="secondary">Secondary</x-button>
                <x-button variant="success">Success</x-button>
                <x-button variant="danger">Danger</x-button>
                <x-button variant="warning">Warning</x-button>
                <x-button variant="info">Info</x-button>
                <x-button variant="dark">Dark</x-button>
                <x-button variant="light">Light</x-button>
                <x-button variant="outline-primary">Outline</x-button>
                <x-button variant="link">Link</x-button>
                <x-button variant="primary" loading>Loading</x-button>
                <x-button variant="primary" disabled>Disabled</x-button>
            </div>
        </x-card>

        {{-- Alerts --}}
        <div class="space-y-3">
            <x-alert type="success" dismissible>Data berhasil disimpan.</x-alert>
            <x-alert type="danger">Terjadi kesalahan pada server.</x-alert>
            <x-alert type="warning">Periksa kembali data Anda.</x-alert>
            <x-alert type="info">Sistem akan maintenance pukul 23.00.</x-alert>
        </div>

        {{-- Badges --}}
        <x-card>
            <x-slot:header>Badges</x-slot:header>
            <div class="flex flex-wrap gap-2">
                <x-badge variant="primary">Primary</x-badge>
                <x-badge variant="success" pill>Aktif</x-badge>
                <x-badge variant="danger" pill>99+</x-badge>
                <x-badge variant="primary" outline>Baru</x-badge>
            </div>
        </x-card>

        {{-- Modal trigger --}}
        <x-card>
            <x-slot:header>Modal</x-slot:header>
            <x-button data-modal-open="demoModal">Buka Modal</x-button>
        </x-card>

        <x-modal id="demoModal" size="md">
            <x-slot:header>Tambah Pengguna</x-slot:header>
            <div class="space-y-4">
                <x-form.input name="nama" label="Nama" placeholder="Nama lengkap" />
                <x-form.input name="email" label="Email" type="email" placeholder="nama@email.com" />
            </div>
            <x-slot:footer>
                <x-button variant="light" data-modal-close>Batal</x-button>
                <x-button variant="primary" onclick="showToast({type:'success', message:'Data tersimpan!'})" data-modal-close>Simpan</x-button>
            </x-slot:footer>
        </x-modal>

        {{-- Dropdown --}}
        <x-card>
            <x-slot:header>Dropdown</x-slot:header>
            <x-dropdown>
                <x-slot:trigger>
                    <x-button variant="light">Opsi ▾</x-button>
                </x-slot:trigger>
                <x-dropdown.item href="#">Edit</x-dropdown.item>
                <x-dropdown.item href="#">Duplikat</x-dropdown.item>
                <x-dropdown.item danger href="#">Hapus</x-dropdown.item>
            </x-dropdown>
        </x-card>

        {{-- Accordion --}}
        <x-card>
            <x-slot:header>Accordion</x-slot:header>
            <x-accordion id="demoAccordion">
                <x-accordion.item title="Apa itu Laravel?" open>
                    Laravel adalah framework PHP untuk pengembangan web modern.
                </x-accordion.item>
                <x-accordion.item title="Apakah gratis?">
                    Ya, Laravel open source dan gratis digunakan.
                </x-accordion.item>
            </x-accordion>
        </x-card>

        {{-- Tabs --}}
        <x-card>
            <x-slot:header>Tabs</x-slot:header>
            <x-tabs id="demoTabs">
                <x-slot:nav>
                    <x-tabs.link target="tab-akun" active>Akun</x-tabs.link>
                    <x-tabs.link target="tab-keamanan">Keamanan</x-tabs.link>
                </x-slot:nav>
                <x-tabs.pane id="tab-akun" active>Konten pengaturan akun.</x-tabs.pane>
                <x-tabs.pane id="tab-keamanan">Konten pengaturan keamanan.</x-tabs.pane>
            </x-tabs>
        </x-card>

        {{-- Progress & Spinner --}}
        <x-card>
            <x-slot:header>Progress & Spinner</x-slot:header>
            <div class="space-y-3">
                <x-progress :value="65" variant="success" label />
                <x-progress :value="40" striped animated />
                <div class="flex gap-3 items-center">
                    <x-spinner size="sm" /> <x-spinner size="md" color="success" /> <x-spinner size="lg" color="danger" />
                </div>
            </div>
        </x-card>

        {{-- Avatar --}}
        <x-card>
            <x-slot:header>Avatar</x-slot:header>
            <div class="flex gap-3 items-center">
                <x-avatar name="Budi Santoso" size="md" status="online" />
                <x-avatar name="Siti Aminah" size="lg" />
                <x-avatar name="Andi" size="sm" status="busy" />
            </div>
        </x-card>

        {{-- List group --}}
        <x-card>
            <x-slot:header>List Group</x-slot:header>
            <x-list-group>
                <a href="#" class="list-group-item active">Dashboard</a>
                <a href="#" class="list-group-item">Pengguna</a>
                <a href="#" class="list-group-item">Pengaturan</a>
            </x-list-group>
        </x-card>

        {{-- Table --}}
        <x-card>
            <x-slot:header>Table</x-slot:header>
            @php
                $demoUsers = [
                    ['name' => 'Budi Santoso', 'email' => 'budi@email.com'],
                    ['name' => 'Siti Aminah', 'email' => 'siti@email.com'],
                ];
            @endphp
            <x-table striped hover>
                <x-slot:head>
                    <tr>
                        <x-table.heading>Nama</x-table.heading>
                        <x-table.heading>Email</x-table.heading>
                        <x-table.heading class="text-right">Aksi</x-table.heading>
                    </tr>
                </x-slot:head>

                @forelse($demoUsers as $user)
                    <x-table.row>
                        <x-table.cell>{{ $user['name'] }}</x-table.cell>
                        <x-table.cell>{{ $user['email'] }}</x-table.cell>
                        <x-table.cell class="text-right">
                            <x-button size="xs" variant="outline-primary">Edit</x-button>
                        </x-table.cell>
                    </x-table.row>
                @empty
                    <x-table.empty colspan="3" message="Belum ada data pengguna." />
                @endforelse
            </x-table>
        </x-card>

        {{-- Toast trigger --}}
        <x-card>
            <x-slot:header>Toast</x-slot:header>
            <x-button variant="success" onclick="showToast({type:'success', message:'Berhasil disimpan!'})">Tampilkan Toast</x-button>
        </x-card>

        {{-- Offcanvas --}}
        <x-card>
            <x-slot:header>Offcanvas</x-slot:header>
            <x-button data-offcanvas-open="demoOffcanvas">Buka Panel Filter</x-button>
        </x-card>

        <x-offcanvas id="demoOffcanvas" placement="end">
            <x-slot:header>Filter</x-slot:header>
            <x-form.select name="kategori" label="Kategori" placeholder="Pilih kategori"
                :options="['a' => 'Elektronik', 'b' => 'Fashion', 'c' => 'Buku']" />
        </x-offcanvas>

        {{-- Form --}}
        <x-card>
            <x-slot:header>Form</x-slot:header>
            <form class="space-y-4">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <x-form.input name="nama" label="Nama Lengkap" required />
                    <x-form.input name="email" label="Email" type="email" required />
                </div>
                <x-form.textarea name="alamat" label="Alamat" rows="3" />
                <div class="flex flex-wrap gap-6">
                    <x-form.checkbox name="setuju" label="Saya menyetujui S&K" />
                    <x-form.switch name="notifikasi" label="Notifikasi" checked />
                </div>
                <div class="flex gap-6">
                    <x-form.radio name="gender" value="L" label="Laki-laki" checked />
                    <x-form.radio name="gender" value="P" label="Perempuan" />
                </div>
                <x-button type="submit" variant="primary">Simpan</x-button>
            </form>
        </x-card>

    </main>

</body>
</html>
