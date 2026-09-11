<?php

namespace Database\Seeders;

use App\Models\Departemen;
use App\Models\Pengurus;
use Illuminate\Database\Seeder;

class PengurusSeeder extends Seeder
{
    public function run(): void
    {
        $periode = '2026/2027';

        /*
        |--------------------------------------------------------------------------
        | Pembina
        |--------------------------------------------------------------------------
        */

        $pembina = Pengurus::updateOrCreate(
            [
                'nama' => 'Suastika Yulia Riska, S.Pd., M.Kom',
                'periode' => $periode,
            ],
            [
                'departemen_id' => null,
                'parent_id' => null,
                'jabatan' => 'Pembina',
                'tipe_jabatan' => 'pembina',
                'urutan' => 1,
                'status' => 'active',
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | Ketua & Wakil
        |--------------------------------------------------------------------------
        */

        $ketua = Pengurus::updateOrCreate(
            [
                'nama' => 'Gilang Dwi Hermawan',
                'periode' => $periode,
            ],
            [
                'departemen_id' => null,
                'parent_id' => null,
                'jabatan' => 'Ketua Umum',
                'tipe_jabatan' => 'pimpinan',
                'urutan' => 2,
                'status' => 'active',
            ]
        );

        $wakil = Pengurus::updateOrCreate(
            [
                'nama' => 'Fika Aulia',
                'periode' => $periode,
            ],
            [
                'departemen_id' => null,
                'parent_id' => $ketua->id,
                'jabatan' => 'Wakil Ketua Umum',
                'tipe_jabatan' => 'pimpinan',
                'urutan' => 3,
                'status' => 'active',
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | Sekretaris
        |--------------------------------------------------------------------------
        */

        Pengurus::updateOrCreate(
            [
                'nama' => 'Muhammad Fadel',
                'periode' => $periode,
            ],
            [
                'departemen_id' => null,
                'parent_id' => $ketua->id,
                'jabatan' => 'Sekretaris Umum I',
                'tipe_jabatan' => 'sekretaris',
                'urutan' => 4,
                'status' => 'active',
            ]
        );

        Pengurus::updateOrCreate(
            [
                'nama' => 'Nadhifah Irbah Hafizhah',
                'periode' => $periode,
            ],
            [
                'departemen_id' => null,
                'parent_id' => $ketua->id,
                'jabatan' => 'Sekretaris Umum II',
                'tipe_jabatan' => 'sekretaris',
                'urutan' => 5,
                'status' => 'active',
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | Bendahara
        |--------------------------------------------------------------------------
        */

        Pengurus::updateOrCreate(
            [
                'nama' => 'Wangi Suci Avrillya',
                'periode' => $periode,
            ],
            [
                'departemen_id' => null,
                'parent_id' => $ketua->id,
                'jabatan' => 'Bendahara Umum I',
                'tipe_jabatan' => 'bendahara',
                'urutan' => 6,
                'status' => 'active',
            ]
        );

        Pengurus::updateOrCreate(
            [
                'nama' => 'Lailatul Putri Wijayanti',
                'periode' => $periode,
            ],
            [
                'departemen_id' => null,
                'parent_id' => $ketua->id,
                'jabatan' => 'Bendahara Umum II',
                'tipe_jabatan' => 'bendahara',
                'urutan' => 7,
                'status' => 'active',
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | Departemen Internal
        |--------------------------------------------------------------------------
        */

        $internal = Departemen::where('slug', 'internal')->firstOrFail();

        $coInternal = Pengurus::updateOrCreate(
            [
                'nama' => 'Muhammad Emre Grimley',
                'periode' => $periode,
            ],
            [
                'departemen_id' => $internal->id,
                'parent_id' => $ketua->id,
                'jabatan' => 'CO Departemen Internal',
                'tipe_jabatan' => 'co',
                'urutan' => 8,
                'status' => 'active',
            ]
        );

        foreach ([
            'Kinash Putri Ramadhani',
            'Variza Allana Gazara Putra',
            'Gita Patricia Ramadhani',
        ] as $index => $nama) {
            Pengurus::updateOrCreate(
                [
                    'nama' => $nama,
                    'periode' => $periode,
                ],
                [
                    'departemen_id' => $internal->id,
                    'parent_id' => $coInternal->id,
                    'jabatan' => 'Anggota Departemen Internal',
                    'tipe_jabatan' => 'agt',
                    'urutan' => 9 + $index,
                    'status' => 'active',
                ]
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Departemen Eksternal
        |--------------------------------------------------------------------------
        */

        $eksternal = Departemen::where('slug', 'eksternal')->firstOrFail();

        $coEksternal = Pengurus::updateOrCreate(
            [
                'nama' => 'Adnan Abiyan Amrullah',
                'periode' => $periode,
            ],
            [
                'departemen_id' => $eksternal->id,
                'parent_id' => $ketua->id,
                'jabatan' => 'CO Departemen Eksternal',
                'tipe_jabatan' => 'co',
                'urutan' => 12,
                'status' => 'active',
            ]
        );

        foreach ([
            'Revanya Julianti Arsa Pradana',
            'Farhan Ahmad Syah',
            'Adi Jaya Wibawa',
        ] as $index => $nama) {
            Pengurus::updateOrCreate(
                [
                    'nama' => $nama,
                    'periode' => $periode,
                ],
                [
                    'departemen_id' => $eksternal->id,
                    'parent_id' => $coEksternal->id,
                    'jabatan' => 'Anggota Departemen Eksternal',
                    'tipe_jabatan' => 'agt',
                    'urutan' => 13 + $index,
                    'status' => 'active',
                ]
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Departemen Minat Bakat
        |--------------------------------------------------------------------------
        */

        $minatBakat = Departemen::where('slug', 'minat-bakat')->firstOrFail();

        $coMinatBakat = Pengurus::updateOrCreate(
            [
                'nama' => 'Nathanael Ivan Susanto',
                'periode' => $periode,
            ],
            [
                'departemen_id' => $minatBakat->id,
                'parent_id' => $ketua->id,
                'jabatan' => 'CO Departemen Minat Bakat',
                'tipe_jabatan' => 'co',
                'urutan' => 16,
                'status' => 'active',
            ]
        );

        foreach ([
            'Dafit Fernandus Ferdi Hardiansyah',
            'Jumiati',
            'Khoirudin',
        ] as $index => $nama) {
            Pengurus::updateOrCreate(
                [
                    'nama' => $nama,
                    'periode' => $periode,
                ],
                [
                    'departemen_id' => $minatBakat->id,
                    'parent_id' => $coMinatBakat->id,
                    'jabatan' => 'Anggota Departemen Minat Bakat',
                    'tipe_jabatan' => 'agt',
                    'urutan' => 17 + $index,
                    'status' => 'active',
                ]
            );
        }
    }
}