<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::with('sarana')->get();
        return view('admin.user.index', compact('users')); // Kirim sebagai $users
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::with('sarana')->find($id);
        
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
        $user = User::find($id);
        
        if (!$user) {
            return redirect()->route('user.index')
                ->with('error', 'User tidak ditemukan.');
        }
        
        // Hapus data sarana yang dimiliki user
        if ($user->sarana) {
            $user->sarana->delete();
        }
        
        $user->delete();

        return redirect()->route('user.index')
            ->with('success', 'User berhasil dihapus.');
    }
}