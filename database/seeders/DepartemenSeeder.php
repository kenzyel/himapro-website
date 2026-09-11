<?php

namespace Database\Seeders;

use App\Models\Departemen;
use Illuminate\Database\Seeder;

class DepartemenSeeder extends Seeder
{
    public function run(): void
    {
        $departemens = [
            [
                'nama' => 'Internal',
                'slug' => 'internal',
                'kode' => 'INT',
                'deskripsi' => 'Departemen yang berfokus pada pengelolaan internal organisasi HIMAPRO TI SAKTI.',
                'warna' => '#FFD21A',
                'icon' => 'users',
                'urutan' => 1,
                'status' => 'active',
            ],
            [
                'nama' => 'Eksternal',
                'slug' => 'eksternal',
                'kode' => 'EXT',
                'deskripsi' => 'Departemen yang berfokus pada hubungan eksternal dan kerja sama organisasi.',
                'warna' => '#F5A900',
                'icon' => 'globe',
                'urutan' => 2,
                'status' => 'active',
            ],
            [
                'nama' => 'Minat Bakat',
                'slug' => 'minat-bakat',
                'kode' => 'MB',
                'deskripsi' => 'Departemen yang mewadahi pengembangan minat, bakat, dan potensi mahasiswa.',
                'warna' => '#FFD21A',
                'icon' => 'sparkles',
                'urutan' => 3,
                'status' => 'active',
            ],
        ];

        foreach ($departemens as $departemen) {
            Departemen::updateOrCreate(
                ['slug' => $departemen['slug']],
                $departemen
            );
        }
    }
}