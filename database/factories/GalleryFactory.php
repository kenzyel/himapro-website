<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class GalleryFactory extends Factory
{
    public function definition(): array
    {
        $nama = 'Kegiatan ' . fake()->words(3, true);

        return [
            'user_id' => User::inRandomOrder()->first()?->id,
            'nama' => $nama,
            'slug' => Str::slug($nama) . '-' . fake()->unique()->numberBetween(1, 9999),
            'deskripsi' => fake()->paragraph(),
            'cover' => null,
            'tanggal' => fake()->dateTimeBetween('-1 year', 'now'),
            'status' => fake()->randomElement(['draft', 'published', 'published']),
        ];
    }
}