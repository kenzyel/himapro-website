<?php

namespace Database\Factories;

use App\Models\Departemen;
use Illuminate\Database\Eloquent\Factories\Factory;

class PengurusFactory extends Factory
{
    public function definition(): array
    {
        return [
            'departemen_id' => Departemen::inRandomOrder()->first()?->id,
            'parent_id' => null,
            'nama' => fake()->name(),
            'jabatan' => fake()->randomElement([
                'Ketua Umum', 'Wakil Ketua', 'Sekretaris',
                'Bendahara', 'CO', 'Anggota',
            ]),
            'tipe_jabatan' => fake()->randomElement([
                'pimpinan', 'sekretaris', 'bendahara', 'co', 'agt',
            ]),
            'foto' => null,
            'bio' => fake()->sentence(),
            'email' => fake()->safeEmail(),
            'telepon' => fake()->phoneNumber(),
            'periode' => '2026/2027',
            'urutan' => fake()->numberBetween(1, 50),
            'status' => 'active',
        ];
    }
}