<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengajuan;
use App\Models\PeriodeLaporan;
use App\Models\ProfileSekolah;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::with('profileSekolah')->get();

        return view('admin.user.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::orderBy('name')->get();

        return view('admin.user.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $roles = Role::pluck('name')->toArray();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Password::defaults()],
            'role' => ['required', Rule::in($roles)],
            'foto' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ], [
            'foto.image' => 'File harus berupa gambar.',
            'foto.mimes' => 'Format foto harus JPG, PNG, atau WebP.',
            'foto.max' => 'Ukuran foto maksimal 2 MB.',
        ]);

        $fotoPath = null;

        try {
            if ($request->hasFile('foto')) {
                $fotoPath = User::prosesFoto($request->file('foto'));
            }

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'foto' => $fotoPath,
            ]);

            $user->assignRole($request->role);

            return redirect()->route('user.index')
                ->with('success', 'User berhasil ditambahkan!');
        } catch (\Exception $e) {
            // Jika user gagal dibuat tapi foto sudah terlanjur tersimpan, bersihkan.
            User::hapusFileFoto($fotoPath);

            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal menambahkan user: '.$e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::with('profileSekolah')->find($id);

        if (! $user) {
            return redirect()->route('user.index')
                ->with('error', 'User tidak ditemukan.');
        }

        // Load data profile sekolah dengan relasi lengkap
        $profileSekolah = ProfileSekolah::with([
            'pagarSekolah',
            'kondisiGuru',
            'kondisiStaff',
            'airBersih',
            'kursiSiswa',
            'mejaSiswa',
            'kursiGuru',
            'mejaGuru',
            'laptop',
            'komputer',
            'jumlahSiswa',
            'jumlahRombel',
            'ruangKelasBaru',
            'rehabilitasiRuangKelas',
            'ruangKelas',
            'toiletSiswa',
            'toiletGuru',
            'ruangPerpustakaan',
            'ruangKepalaSekolah',
            'ruangGuru',
            'ruangKantorTu',
            'labIpa',
            'labKomputer',
            'unitKesehatanSekolah',
            'rumahDinas',
            'rumahIbadah',
            'lapanganSekolah',
        ])->where('user_id', $id)->first();

        $rkbPeriode = PeriodeLaporan::forKategori('rkb');
        $rehabilitasiPeriode = PeriodeLaporan::forKategori('rehabilitasi');

        // Riwayat pengajuan perubahan data yang pernah diajukan user ini,
        // ditampilkan di tabel "Pengajuan Rencana Pembangunan" pada halaman show.
        $pengajuans = Pengajuan::where('user_id', $id)
            ->latest()
            ->paginate(10);

        // Data lengkap (tanpa pagination) untuk chart "Riwayat Pengajuan per Bulan":
        // cuma kolom yang dibutuhkan (kategori + tanggal), difilter/diagregasi di
        // sisi JS berdasarkan tahun & kategori yang dipilih di dropdown.
        $pengajuanChartData = Pengajuan::where('user_id', $id)
            ->get(['pengajuan', 'created_at'])
            ->map(function ($item) {
                $kategoriKeys = is_array($item->pengajuan) ? $item->pengajuan : array_filter([$item->pengajuan]);

                return [
                    'tahun' => (int) $item->created_at->format('Y'),
                    'bulan' => (int) $item->created_at->format('n'), // 1-12
                    'kategori' => array_values($kategoriKeys),
                ];
            })
            ->values();

        $tahunTersedia = $pengajuanChartData->pluck('tahun')->unique()->sortDesc()->values();
        if ($tahunTersedia->isEmpty()) {
            $tahunTersedia = collect([(int) now()->format('Y')]);
        }

        $kategoriListChart = \App\Http\Controllers\User\PengajuanController::kategoriList();

        return view('admin.user.show', compact(
            'user',
            'profileSekolah',
            'rkbPeriode',
            'rehabilitasiPeriode',
            'pengajuans',
            'pengajuanChartData',
            'tahunTersedia',
            'kategoriListChart',
        ));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::find($id);

        if (! $user) {
            return redirect()->route('user.index')
                ->with('error', 'User tidak ditemukan.');
        }

        // Dipakai oleh dropdown Role di edit.blade.php
        $roles = Role::orderBy('name')->get();
        $userRole = $user->roles->first();

        return view('admin.user.edit', compact('user', 'roles', 'userRole'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::find($id);

        if (! $user) {
            return redirect()->route('user.index')
                ->with('error', 'User tidak ditemukan.');
        }

        $roles = Role::pluck('name')->toArray();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            // Password opsional saat edit: kosong = tidak diubah.
            'password' => ['nullable', 'confirmed', Password::defaults()],
            'role' => ['required', Rule::in($roles)],
            'foto' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'hapus_foto' => ['nullable', 'boolean'],
        ], [
            'foto.image' => 'File harus berupa gambar.',
            'foto.mimes' => 'Format foto harus JPG, PNG, atau WebP.',
            'foto.max' => 'Ukuran foto maksimal 2 MB.',
        ]);

        try {
            $data = [
                'name' => $request->name,
                'email' => $request->email,
            ];

            if ($request->filled('password')) {
                $data['password'] = Hash::make($request->password);
            }

            $fotoLama = null;

            if ($request->hasFile('foto')) {
                $fotoLama = $user->foto;
                $data['foto'] = User::prosesFoto($request->file('foto'));
            } elseif ($request->boolean('hapus_foto')) {
                $fotoLama = $user->foto;
                $data['foto'] = null;
            }

            $user->update($data);

            User::hapusFileFoto($fotoLama);

            $user->syncRoles([$request->role]);

            return redirect()->route('user.index')
                ->with('success', 'User berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal memperbarui user: '.$e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Cegah menghapus diri sendiri
        if (Auth::id() == $id) {
            return redirect()->route('user.index')
                ->with('error', 'Anda tidak dapat menghapus akun sendiri.');
        }

        $user = User::find($id);

        if (! $user) {
            return redirect()->route('user.index')
                ->with('error', 'User tidak ditemukan.');
        }

        // Hapus data profileSekolah yang dimiliki user
        if ($user->profileSekolah) {
            $user->profileSekolah->delete();
        }

        // Hapus file foto profil dari storage
        User::hapusFileFoto($user->foto);

        $user->delete();

        return redirect()->route('user.index')
            ->with('success', 'User berhasil dihapus.');
    }
}