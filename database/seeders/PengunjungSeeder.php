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
                'password' => Hash::make('password'),
                'phone' => '082345678901',
                'foto_ktp' => null,
            ],
            [
                'nama' => 'Jane Smith',
                'username' => 'janesmith',
                'password' => Hash::make('password'),
                'phone' => '083456789012',
                'foto_ktp' => null,
            ],
            [
                'nama' => 'Ahmad Fauzi',
                'username' => 'ahmadfauzi',
                'password' => Hash::make('password'),
                'phone' => '084567890123',
                'foto_ktp' => null,
            ],
            [
                'nama' => 'Siti Nurhaliza',
                'username' => 'sitinur',
                'password' => Hash::make('password'),
                'phone' => '085678901234',
                'foto_ktp' => null,
            ],
            [
                'nama' => 'Budi Santoso',
                'username' => 'budisantoso',
                'password' => Hash::make('password'),
                'phone' => '086789012345',
                'foto_ktp' => null,
            ]
        ];

        foreach ($pengunjungs as $pengunjung) {
            Pengunjung::create($pengunjung);
        }
    }
}