<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

// use Illuminate\Http\Request;

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

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::with('profileSekolah')->find($id);
        
        if (!$user) {
            return redirect()->route('user.index')
                ->with('error', 'User tidak ditemukan.');
        }
        
        return view('admin.user.show', compact('user'));
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

        if (!$user) {
            return redirect()->route('user.index')
                ->with('error', 'User tidak ditemukan.');
        }

        // Hapus data profileSekolah yang dimiliki user
        if ($user->profileSekolah) {
            $user->profileSekolah->delete();
        }

        $user->delete();

        return redirect()->route('user.index')
            ->with('success', 'User berhasil dihapus.');
    }
}