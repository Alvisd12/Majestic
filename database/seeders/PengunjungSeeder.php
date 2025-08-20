<?php
// database/seeders/PengunjungSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Pengunjung;

class PengunjungSeeder extends Seeder
{
    public function run(): void
    {
        $pengunjungs = [
            [
                'nama' => 'John Doe',
                'username' => 'johndoe',
                'email' => 'johndoe@example.com',
                'password' => Hash::make('password'),
                'no_handphone' => '082345678901',
                'alamat' => 'Jl. Contoh No. 1, Jakarta Selatan',
                'foto_ktp' => null,
            ],
            [
                'nama' => 'Jane Smith',
                'username' => 'janesmith',
                'email' => 'janesmith@example.com',
                'password' => Hash::make('password'),
                'no_handphone' => '083456789012',
                'alamat' => 'Jl. Contoh No. 2, Jakarta Pusat',
                'foto_ktp' => null,
            ],
            [
                'nama' => 'Ahmad Fauzi',
                'username' => 'ahmadfauzi',
                'email' => 'ahmadfauzi@example.com',
                'password' => Hash::make('password'),
                'no_handphone' => '084567890123',
                'alamat' => 'Jl. Contoh No. 3, Jakarta Timur',
                'foto_ktp' => null,
            ],
            [
                'nama' => 'Siti Nurhaliza',
                'username' => 'sitinur',
                'email' => 'sitinur@example.com',
                'password' => Hash::make('password'),
                'no_handphone' => '085678901234',
                'alamat' => 'Jl. Contoh No. 4, Jakarta Barat',
                'foto_ktp' => null,
            ],
            [
                'nama' => 'Budi Santoso',
                'username' => 'budisantoso',
                'email' => 'budisantoso@example.com',
                'password' => Hash::make('password'),
                'no_handphone' => '086789012345',
                'alamat' => 'Jl. Contoh No. 5, Jakarta Utara',
                'foto_ktp' => null,
            ]
        ];

        foreach ($pengunjungs as $pengunjung) {
            Pengunjung::create($pengunjung);
        }
    }
}