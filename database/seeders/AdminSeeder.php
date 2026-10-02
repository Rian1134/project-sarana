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
            'email' => 'diknas.bidangsmp@gmail.com',
            'email_verified_at' => Carbon::now(),
            'password' => bcrypt('simsarpras-smp'),
        ]);

        $admin->assignRole('admin');

        $coAdmin = User::create([
            'name' => 'co-admin',
            'email' => 'rianjapingw@gmail.com',
            'email_verified_at' => Carbon::now(),
            'password' => bcrypt('rjw141009'),
        ]);

        $coAdmin->assignRole('admin');

    }
}
