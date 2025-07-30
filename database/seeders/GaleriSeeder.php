<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Galeri;
use Carbon\Carbon;

class GaleriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get admin ID (assuming there's at least one admin)
        $adminId = \App\Models\Admin::first()->id ?? 1;
        
        $galeriData = [
            [
                'id_admin' => $adminId,
                'gambar' => 'galeri/motor1.jpg',
                'deskripsi' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.',
                'tanggal_sewa' => '2021-03-25',
                'kategori' => 'motor',
                'created_at' => '2021-03-25 10:00:00',
                'updated_at' => '2021-03-25 10:00:00'
            ],
            [
                'id_admin' => $adminId,
                'gambar' => 'galeri/motor2.jpg',
                'deskripsi' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.',
                'tanggal_sewa' => '2021-03-25',
                'kategori' => 'motor',
                'created_at' => '2021-03-25 10:00:00',
                'updated_at' => '2021-03-25 10:00:00'
            ],
            [
                'id_admin' => $adminId,
                'gambar' => 'galeri/wisata1.jpg',
                'deskripsi' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.',
                'tanggal_sewa' => '2021-03-25',
                'kategori' => 'wisata',
                'created_at' => '2021-03-25 10:00:00',
                'updated_at' => '2021-03-25 10:00:00'
            ],
            [
                'id_admin' => $adminId,
                'gambar' => 'galeri/event1.jpg',
                'deskripsi' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.',
                'tanggal_sewa' => '2021-03-25',
                'kategori' => 'event',
                'created_at' => '2021-03-25 10:00:00',
                'updated_at' => '2021-03-25 10:00:00'
            ],
            [
                'id_admin' => $adminId,
                'gambar' => 'galeri/lainnya1.jpg',
                'deskripsi' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.',
                'tanggal_sewa' => '2021-03-25',
                'kategori' => 'lainnya',
                'created_at' => '2021-03-25 10:00:00',
                'updated_at' => '2021-03-25 10:00:00'
            ]
        ];

        foreach ($galeriData as $data) {
            Galeri::create($data);
        }
    }
} 