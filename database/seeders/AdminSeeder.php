<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'email_verified_at' => Carbon::now(),
            'password' => bcrypt('admin123'),
        ]);

        $admin->assignRole('admin');

        $user = User::create([
            'name' => 'rian',
            'email' => 'rianjapingw@gmail.com',
            'email_verified_at' => Carbon::now(),
            'password' => bcrypt('12345678'),
        ]);

        $user->assignRole('user');
    }
}
