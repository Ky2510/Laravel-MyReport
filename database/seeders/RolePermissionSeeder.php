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
        Permission::create(['name' => 'create-post']);
        Permission::create(['name' => 'edit-post']);
        Permission::create(['name' => 'delete-post']);

        // Roles
        $admin = Role::create(['name' => 'admin']);
        $user = Role::create(['name' => 'user']);
        // Give permissions to admin
        $admin->givePermissionTo(Permission::all());
        $user->givePermissionTo('edit-post');
    }
}
