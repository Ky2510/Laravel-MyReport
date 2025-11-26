<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User;

class AuthSeeder extends Seeder
{
    public function run()
    {
        // Buat permissions (API guard)
        $permissions = [
            'create-post',
            'edit-post',
            'delete-post'
        ];

        foreach ($permissions as $item) {
            Permission::firstOrCreate([
                'name' => $item,
                'guard_name' => 'api'
            ]);
        }

        // Buat roles
        $admin = Role::firstOrCreate([
            'name' => 'admin',
            'guard_name' => 'api'
        ]);

        $user = Role::firstOrCreate([
            'name' => 'user',
            'guard_name' => 'api'
        ]);

        $super = Role::firstOrCreate([
            'name' => 'superadmin',
            'guard_name' => 'api'
        ]);

        // Beri permission
        $admin->givePermissionTo(Permission::all());
        $user->givePermissionTo('edit-post');
        $super->givePermissionTo(Permission::all());

        // Buat akun SuperAdmin
        $superUser = User::firstOrCreate(
            ['email' => 'super@admin.com'],
            [
                'name' => 'Super Admin',
                'password' => bcrypt('password123'),
                'api_token' => null
            ]
        );

        $superUser->assignRole('superadmin');
    }
}
