<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PesanFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nama' => fake()->name(),
            'email' => fake()->safeEmail(),
            'telepon' => fake()->phoneNumber(),
            'subjek' => fake()->sentence(4),
            'pesan' => fake()->paragraph(5),
            'status' => fake()->randomElement(['unread', 'read', 'replied']),
            'dibaca_at' => null,
            'dibalas_at' => null,
        ];
    }
}