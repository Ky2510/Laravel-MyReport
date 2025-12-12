<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AuthSeeder extends Seeder
{
    public function run()
    {
        $now = Carbon::now();

        // --- CREATE ROLE ---
        $superRole = Role::firstOrCreate(
            ['name' => 'super_admin'],
            [
                'id' => (string) Str::uuid(),
                'guard_name' => 'api',
                'created_at' => $now,
                'updated_at' => $now,
            ]
        );

        // --- CREATE USER ---
        $user = User::firstOrCreate(
            ['email' => 'superadmin@example.com'],
            [
                'id' => (string) Str::uuid(),
                'username' => 'superadmin',
                'name' => 'Super Admin',
                'password' => bcrypt('password123'),
                'created_at' => $now,
                'updated_at' => $now,
            ]
        );


        // --- ASSIGN ROLE ---
        if (!$user->hasRole('super_admin')) {
            $user->assignRole('super_admin');
        }

        DB::table('user_roles')->updateOrInsert(
            [
                'userId' => $user->id,
                'roleId' => $superRole->id,
            ],
            [
                'id'        => (string) Str::uuid(), // WAJIB INI!
                'createBy'  => $user->id,
                'updateBy'  => $user->id,
                'createdAt' => $now,
                'updatedAt' => $now,
            ]
        );
    }
}
