<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserPermissionController extends Controller
{
    /**
     * Izin update data yang bisa diatur admin: nama permission => label di halaman.
     */
    private const IZIN = [
        'update-sdm' => 'Guru & Staff TU (sdm)',
        'update-siswa-rombel' => 'Jumlah Siswa & Rombel',
        'update-ruang-kelas' => 'RKB, Rehabilitasi & Ruang Kelas',
        'update-toilet' => 'Toilet Siswa & Guru',
        'update-ruang-fasilitas' => 'Ruang & Fasilitas Sekolah',
        'update-prangkat-furnitur' => 'Furnitur & Perangkat',
    ];

    public function edit(User $user)
    {
        // Hanya yang punya izin 'change-permission' (admin) yang boleh masuk
        abort_unless(Auth::user()->checkPermissionTo('change-permission'), 403);

        return view('admin.user.izin', [
            'user' => $user,
            'daftarIzin' => self::IZIN,
            // Bagian yang terkunci = izin yang tidak dimiliki user ini
            'terkunci' => array_values(array_diff(
                array_keys(self::IZIN),
                $user->getDirectPermissions()->pluck('name')->all()
            )),
        ]);
    }

    public function update(Request $request, User $user)
    {
        abort_unless(Auth::user()->checkPermissionTo('change-permission'), 403);

        $request->validate([
            'izin' => ['nullable', 'array'],
            'izin.*' => ['in:'.implode(',', array_keys(self::IZIN))],
        ]);

        $dikunci = $request->input('izin', []);

        // Yang dicentang = dikunci (izin dicabut), yang tidak dicentang = boleh diisi (izin diberikan).
        foreach (array_keys(self::IZIN) as $izin) {
            if (in_array($izin, $dikunci)) {
                $user->revokePermissionTo($izin);
            } else {
                $user->givePermissionTo($izin);
            }
        }

        return redirect()->route('user.index')
            ->with('success', 'Izin user '.$user->name.' berhasil diperbarui!');
    }
}