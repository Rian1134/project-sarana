<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

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
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        Role::create(['name' => 'admin']);
        Role::create(['name' => 'user']);

        $roleAdmin = Role::findByName('admin');

        $roleAdmin->givePermissionTo('view-sarana');
        $roleAdmin->givePermissionTo('show-sarana');
        $roleAdmin->givePermissionTo('edit-sarana');
        $roleAdmin->givePermissionTo('create-sarana');
        $roleAdmin->givePermissionTo('delete-sarana');

        $roleAdmin->givePermissionTo('view-user');
        $roleAdmin->givePermissionTo('edit-user');
        $roleAdmin->givePermissionTo('create-user');
        $roleAdmin->givePermissionTo('delete-user');

        $roleUser = Role::findByName('user');

        $roleUser->givePermissionTo('show-sarana');
        $roleUser->givePermissionTo('edit-sarana');
        $roleUser->givePermissionTo('create-sarana');
        $roleUser->givePermissionTo('delete-sarana');

        $roleUser->givePermissionTo('show-user');
        $roleUser->givePermissionTo('edit-user');
        $roleUser->givePermissionTo('create-user');
        $roleUser->givePermissionTo('delete-user');
    }
}
