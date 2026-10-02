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
            'smpnlahatsarana@gmail.com',
            'smpndualahat@ymail.com',
            'smpn3lahat@gmail.com',
            'smpn4lahat2026@gmail.com',
            'smpn5lht.sarpras@gmail.com',
            'smpn7lahat@yahoo.com',
            'smpn8lhtalap@gmail.com',
            'smpneg9lahat@gmail.com',
            'lahatsmpmuhammadiyah@gmail.com',
            'ikhlascendekia@gmail.com',
            'smpndualahatselatan@gmail.com',
            'smpn1guta@gmail.com',
            'smpn1pulpin@gmail.com',
            'smpn01.kikimtimur@gmail.com',
            'smpnegeriduakikimtimur@gmail.com',
            'smpnegeri3kikimtimur@gmail.com',
            'smp4kikimtimur@gmail.com',
            'smpn5cecar@gamil.com',
            'smpn2mbmerapibarat@gmail.com',
            'smpnegeri3merapibarat@gmail.com',
            'smpn1gumayulu07@gmail.com',
            'smpnpseksulahat@gmail.com',
            'smpn2pseksu@gmail.com',
            'smpneg3pseksu@gmail.com',
            'smpn1kimteng98@gmail.com',
            'smpn2kimteng@gmail.com',
            'smpn1kikimselatan10@gmail.com',
            'smpn2kimsel@gmail.com',
            'kikimselatansmpn@gmail.com',
            'smpn4ks@gmail.com',
            'smpnsatukotaagunglahat@yahoo.co.id',
            'Dapodik.smpn2kotaagung@gmail.com',
            'smpnegeri1pagargununggg@gmail.com',
            'smpn2pagargunung@gmail.com',
            'smpnegeri1merapitimur@gmail.com',
            'smpn2merapitimur@gmail.com',
            'smpnegeri1tanjungtebat@gmail.com',
            'smpn2tanjungtebat@gmail.com',
            'smpn1mulakulubercerita@gmail.com',
            'smpn3mu2005@gmail.com',
            'smpn1mulaksebingkai@gmail.com',
            'smpnegeri01kikimbarat@gmail.com',
            'smpn2.kimbar@gmail.com',
            'smpitdarussalam10@gmail.com',
            'smpnegeri.1jarai@gmail.com',
            'smpm.jarai@gmail.com',
            'smpn1pb@gmail.com',
            'smp1.sukamerindu@gmail.com',
            'smpn1ts.pumi@gmail.com',
            'smpn2tspumi@gmail.com',
            'smpntigatjspumi@gmail.com',
            'smp4pumi@gmail.com',
            'smpn1tspumu@gmail.com',
            'smpn2tanjungsaktipumu@gmail.com',

        ];

        // Password awal untuk semua user di atas (sebaiknya diganti setelah login)
        $password = '12345678';

        foreach ($emails as $i => $email) {
            $email = strtolower(trim($email));

            $user = User::firstOrCreate(
                ['email' => $email],
                [
                    // Nama berurutan sesuai urutan email: user1, user2, dst
                    'name' => 'user'.($i + 1),
                    'email_verified_at' => Carbon::now(),
                    'password' => bcrypt($password),
                ]
            );

            $user->assignRole('user');
        }
    }
}
