<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RolePermissionSeeder::class,
            DepartemenSeeder::class,
            PengurusSeeder::class,
            AdminUserSeeder::class,
            SettingSeeder::class,
            LandingSectionSeeder::class,
        ]);
    }
}