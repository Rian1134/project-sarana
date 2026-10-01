<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Jalankan setelah RolePermissionSeeder (role `user` harus sudah ada).
     */
    public function run(): void
    {
        // Isi daftar email di sini
        $emails = [
           // 'contoh1@gmail.com',
        ];

        // Password awal untuk semua user di atas (sebaiknya diganti setelah login)
        $password = '12345678';

        foreach ($emails as $i => $email) {
            $email = strtolower(trim($email));

            $user = User::firstOrCreate(
                ['email' => $email],
                [
                    // Nama berurutan sesuai urutan email: user1, user2, dst
                    'name' => 'user' . ($i + 1),
                    'email_verified_at' => Carbon::now(),
                    'password' => bcrypt($password),
                ]
            );

            $user->assignRole('user');
        }
    }
}