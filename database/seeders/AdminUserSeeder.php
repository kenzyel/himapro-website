<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $role = Role::where('slug', 'super-admin')->firstOrFail();

        User::updateOrCreate(
            [
                'email' => 'admin@himapro.test',
            ],
            [
                'role_id' => $role->id,
                'name' => 'Super Administrator',
                'password' => Hash::make('Himapro@2026!'),
                'status' => 'active',
            ]
        );
    }
}