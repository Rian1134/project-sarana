<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
// use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Menampilkan halaman registrasi
     */
    public function register()
    {
        return view('auth.register');
    }

    /**
     * Memproses registrasi user baru
     */
    public function store(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:50', 'unique:users,name'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'name.required' => 'Nama wajib diisi',
            'name.string' => 'Nama harus berupa teks',
            'name.max' => 'Nama maksimal 50 karakter',
            'name.unique' => 'Nama sudah digunakan',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'password.required' => 'Password wajib diisi',
            'password.string' => 'Password harus berupa teks',
            'password.min' => 'Password minimal 8 karakter',
            'password.confirmed' => 'Konfirmasi password tidak sesuai',
        ]);

        // Jika validasi gagal, kembalikan dengan error
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // Buat user baru
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            $user->assignRole('user'); // role default

            // event(new Registered($user));

            // Login user setelah registrasi
            Auth::login($user);

            if (Auth::user()->hasRole('admin')) {
                return redirect()->route('sarana.index');
            }

            // Redirect ke halaman user data
            return redirect()->to('/')
                ->with('success', 'Registrasi berhasil! Selamat datang ' . $user->name);
        } catch (\Exception $e) {
            // Jika terjadi error, kembalikan dengan pesan error
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }

    /**
     * Menampilkan halaman login
     */
    public function login()
    {
        return view('auth.login');
    }

    /**
     * Memproses login user
     */
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user();

            // Redirect sesuai role
            if ($user->hasRole('admin')) {
                return redirect()->intended('/admin/sarana');
            } elseif ($user->hasRole('user')) {
                return redirect()->intended('/user/data');
            }

            return redirect()->intended('/admin/sarana'); // default untuk role lain (misal member)
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    /**
     * Logout user
     */
    public function logout(Request $request)
    {
        // Logout user
        Auth::logout();

        // Hapus session
        $request->session()->flush();

        // Redirect ke halaman login dengan pesan sukses
        return redirect()->route('login')
            ->with('success', 'Anda berhasil logout. Sampai jumpa!');
    }
}