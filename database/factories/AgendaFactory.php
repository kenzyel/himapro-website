<?php

namespace Database\Factories;

use App\Models\ProgramKerja;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class AgendaFactory extends Factory
{
    public function definition(): array
    {
        $judul = fake()->sentence(4);
        $mulai = fake()->dateTimeBetween('-1 month', '+3 months');
        $selesai = (clone $mulai)->modify('+' . fake()->numberBetween(1, 4) . ' hours');

        return [
            'program_kerja_id' => ProgramKerja::inRandomOrder()->first()?->id,
            'judul' => $judul,
            'slug' => Str::slug($judul) . '-' . fake()->unique()->numberBetween(1, 9999),
            'deskripsi' => fake()->paragraph(),
            'lokasi' => fake()->randomElement([
                'Ruang Rapat', 'Aula Kampus', 'Gedung A', 'Zoom Meeting',
            ]),
            'tanggal_mulai' => $mulai,
            'tanggal_selesai' => $selesai,
            'status' => fake()->randomElement(['planned', 'ongoing', 'completed']),
            'is_public' => fake()->boolean(80),
        ];
    }
}