<?php
// database/seeders/DatabaseSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;
use App\Models\Pengunjung;
use App\Models\Motor;
use App\Models\Peminjaman;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create default admin
        Admin::create([
            'nama' => 'Administrator',
            'username' => 'admin',
            'password' => Hash::make('admin123'),
            'phone' => '081234567890',
            'email' => 'admin@majesticrentals.com'
        ]);

        // Create sample pengunjung
        $pengunjung1 = Pengunjung::create([
            'nama' => 'John Doe',
            'username' => 'johndoe',
            'password' => Hash::make('password123'),
            'phone' => '081234567891',
            'foto_ktp' => null
        ]);

        $pengunjung2 = Pengunjung::create([
            'nama' => 'Jane Smith',
            'username' => 'janesmith',
            'password' => Hash::make('password123'),
            'phone' => '081234567892',
            'foto_ktp' => null
        ]);

        // Create sample motors
        $motors = [
            [
                'merk' => 'Honda',
                'model' => 'Beat',
                'tahun' => 2022,
                'plat_nomor' => 'L 1234 AB',
                'harga_per_hari' => 50000,
                'status' => 'Tersedia',
                'deskripsi' => 'Motor matic cocok untuk perjalanan dalam kota. Irit bensin dan mudah dikendarai.'
            ],
            [
                'merk' => 'Yamaha',
                'model' => 'Vixion',
                'tahun' => 2021,
                'plat_nomor' => 'L 5678 CD',
                'harga_per_hari' => 75000,
                'status' => 'Tersedia',
                'deskripsi' => 'Motor sport dengan performa tinggi. Cocok untuk perjalanan jauh dan touring.'
            ],
            [
                'merk' => 'Suzuki',
                'model' => 'Address',
                'tahun' => 2023,
                'plat_nomor' => 'L 9012 EF',
                'harga_per_hari' => 60000,
                'status' => 'Tersedia',
                'deskripsi' => 'Motor matic dengan kapasitas bagasi besar. Nyaman untuk berbagai keperluan.'
            ],
            [
                'merk' => 'Honda',
                'model' => 'PCX',
                'tahun' => 2022,
                'plat_nomor' => 'L 3456 GH',
                'harga_per_hari' => 85000,
                'status' => 'Tersedia',
                'deskripsi' => 'Motor premium dengan fitur lengkap dan desain elegan.'
            ],
            [
                'merk' => 'Yamaha',
                'model' => 'NMAX',
                'tahun' => 2023,
                'plat_nomor' => 'L 7890 IJ',
                'harga_per_hari' => 80000,
                'status' => 'Disewa',
                'deskripsi' => 'Motor matic premium dengan teknologi terdepan.'
            ],
            [
                'merk' => 'Honda',
                'model' => 'Scoopy',
                'tahun' => 2021,
                'plat_nomor' => 'L 2468 KL',
                'harga_per_hari' => 45000,
                'status' => 'Maintenance',
                'deskripsi' => 'Motor matic retro dengan desain yang unik dan menarik.'
            ]
        ];

        foreach ($motors as $motorData) {
            Motor::create($motorData);
        }

        // Create sample peminjaman
        Peminjaman::create([
            'user_id' => $pengunjung1->id,
            'tanggal_rental' => now()->subDays(2),
            'jam_sewa' => '09:00',
            'durasi_sewa' => 3,
            'jenis_motor' => 'Honda Beat',
            'total_harga' => 150000,
            'status' => 'Disewa'
        ]);

        Peminjaman::create([
            'user_id' => $pengunjung2->id,
            'tanggal_rental' => now()->subDays(5),
            'jam_sewa' => '10:00',
            'durasi_sewa' => 2,
            'jenis_motor' => 'Yamaha Vixion',
            'total_harga' => 150000,
            'status' => 'Selesai',
            'tanggal_kembali' => now()->subDays(3)
        ]);

        Peminjaman::create([
            'user_id' => $pengunjung1->id,
            'tanggal_rental' => now()->addDays(1),
            'jam_sewa' => '08:00',
            'durasi_sewa' => 1,
            'jenis_motor' => 'Suzuki Address',
            'total_harga' => 60000,
            'status' => 'Confirmed'
        ]);

        // Call other seeders
        $this->call([
            MotorSeeder::class,
            PengunjungSeeder::class,
            PeminjamanSeeder::class,
            TestimoniSeeder::class,
            BlogSeeder::class,
            GaleriSeeder::class,
        ]);
    }
}