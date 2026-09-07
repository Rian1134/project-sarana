<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\ProfileSekolah;
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
            'airBersih',
            'kursiSiswa',
            'mejaSiswa',
            'kursiGuru',
            'mejaGuru',
            'laptop',
            'komputer',
            'chromebook',
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

        return view('user.profile.index', compact('user', 'profileSekolah'));
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
     * Update informasi dasar profil (nama & email).
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
        ]);

        try {
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);

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