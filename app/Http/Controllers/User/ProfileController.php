<?php

namespace App\Http\Controllers\User;

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

class ProfileController extends Controller
{
    /**
     * Tampilkan halaman profil (read-only) user yang sedang login.
     */
    public function index()
    {
        $user = Auth::user();

        // Ambil data sekolah yang terhubung dengan user
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
        ])->where('user_id', $user->id)->first();

        // Modul "Pengajuan Koreksi Data" dan "Rencana Pembangunan" sama-sama
        // memakai tabel `pengajuans`, dibedakan lewat kategori yang dipilih.
        // Masing-masing HARUS difilter dengan kategoriList() milik controllernya
        // sendiri (lihat PengajuanController/RencanaPembangunanController) —
        // tanpa filter ini, kedua tabel di halaman profil akan menampilkan baris
        // yang sama (tercampur), atau salah satunya selalu kosong.
        $pengajuanKategoriKeys = array_keys(PengajuanController::kategoriList());
        $pengajuans = Pengajuan::with('profileSekolah')
            ->where('user_id', Auth::id())
            ->where(function ($query) use ($pengajuanKategoriKeys) {
                foreach ($pengajuanKategoriKeys as $key) {
                    $query->orWhereJsonContains('pengajuan', $key);
                }
            })
            ->latest()
            // pageName unik supaya paginasi tabel ini tidak bentrok dengan
            // paginasi tabel "Rencana Pembangunan" yang tampil di halaman yang sama.
            ->paginate(5, ['*'], 'pengajuan_page');

        $rencanaKategoriKeys = array_keys(RencanaPembangunanController::kategoriList());
        $rencanaPembangunans = Pengajuan::with('profileSekolah')
            ->where('user_id', Auth::id())
            ->where(function ($query) use ($rencanaKategoriKeys) {
                foreach ($rencanaKategoriKeys as $key) {
                    $query->orWhereJsonContains('pengajuan', $key);
                }
            })
            ->latest()
            ->paginate(5, ['*'], 'rencana_page');

        $rkbPeriode = PeriodeLaporan::forKategori('rkb');
        $rehabilitasiPeriode = PeriodeLaporan::forKategori('rehabilitasi');

        return view('user.profile.index', compact('user', 'profileSekolah', 'rkbPeriode', 'rehabilitasiPeriode', 'pengajuans', 'rencanaPembangunans'));
    }

    /**
     * Tampilkan halaman form edit profil user yang sedang login.
     */
    public function edit()
    {
        $user = Auth::user();

        return view('user.profile.edit', compact('user'));
    }

    /**
     * Update informasi dasar profil (nama, email & foto profil).
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
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

            $fotoLama = null;

            if ($request->hasFile('foto')) {
                // Foto baru: convert ke WebP + resize.
                $fotoLama = $user->foto;
                $data['foto'] = User::prosesFoto($request->file('foto'));
            } elseif ($request->boolean('hapus_foto')) {
                // Hapus foto: kolom di database dikosongkan.
                $fotoLama = $user->foto;
                $data['foto'] = null;
            }

            $user->update($data);

            // File foto lama dihapus setelah database berhasil diperbarui.
            User::hapusFileFoto($fotoLama);

            return redirect()->route('user.profile.index')
                ->with('success', 'Profil berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal memperbarui profil: '.$e->getMessage());
        }
    }

    /**
     * Tampilkan halaman form ubah password.
     */
    public function changePassword()
    {
        return view('user.profile.change-password');
    }

    /**
     * Update password user.
     */
    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ], [
            'current_password.current_password' => 'Password saat ini yang Anda masukkan salah.',
        ]);

        try {
            $user->update([
                'password' => Hash::make($request->password),
            ]);

            return redirect()->route('user.profile.index')
                ->with('success', 'Password berhasil diubah!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal mengubah password: '.$e->getMessage());
        }
    }
}