<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Bersihkan cache permission Spatie agar perubahan langsung terbaca
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $permissions = [
            'view-sarana',
            'create-sarana',
            'show-sarana',
            'edit-sarana',
            'delete-sarana',

            'view-user',
            'create-user',
            'show-user',
            'edit-user',
            'delete-user',

            'change-permission',

            'update-sdm',
            'update-siswa-rombel',
            'update-ruang-kelas',
            'update-toilet',
            'update-ruang-fasilitas',
            'update-prangkat-furnitur',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        // firstOrCreate: aman dijalankan berulang kali (tidak error duplicate)
        $roleAdmin = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $roleUser = Role::firstOrCreate(['name' => 'user', 'guard_name' => 'web']);

        // Admin: semua permission
        $roleAdmin->syncPermissions($permissions);

        // User: kelola sarana + lihat/ubah data user.
        // Izin update-* TIDAK diberikan lewat role; diatur admin per user (halaman Kelola Izin).
        $roleUser->syncPermissions([
            'show-sarana',
            'edit-sarana',
            'create-sarana',
            'delete-sarana',

            'show-user',
            'edit-user',

            'update-sdm',
            'update-siswa-rombel',
            'update-ruang-kelas',
            'update-toilet',
            'update-ruang-fasilitas',
            'update-prangkat-furnitur',
        ]);
    }
}
