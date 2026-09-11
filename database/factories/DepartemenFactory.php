<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class DepartemenFactory extends Factory
{
    public function definition(): array
    {
        $nama = fake()->unique()->randomElement([
            'Internal', 'Eksternal', 'Minat Bakat',
            'Kaderisasi', 'Sosial', 'Media',
        ]) . ' ' . fake()->unique()->numberBetween(1, 999);

        return [
            'nama' => $nama,
            'slug' => Str::slug($nama),
            'kode' => strtoupper(Str::random(3)),
            'deskripsi' => fake()->paragraph(),
            'warna' => fake()->randomElement(['#FFD21A', '#F5A900', '#3B82F6', '#10B981']),
            'icon' => fake()->randomElement(['bi-people-fill', 'bi-globe', 'bi-star-fill']),
            'urutan' => fake()->numberBetween(1, 10),
            'status' => 'active',
        ];
    }
}