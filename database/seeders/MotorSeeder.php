<?php
// database/seeders/MotorSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Motor;

class MotorSeeder extends Seeder
{
    public function run(): void
    {
        $motors = [
            [
                'merk' => 'Honda',
                'model' => 'Beat',
                'tahun' => 2022,
                'plat_nomor' => 'L 1234 AB',
                'harga_per_hari' => 50000.00,
                'status' => 'Tersedia',
                'deskripsi' => 'Motor matic Honda Beat cocok untuk perjalanan dalam kota. Irit bahan bakar dan mudah dikendarai.',
            ],
            [
                'merk' => 'Yamaha',
                'model' => 'Vixion',
                'tahun' => 2021,
                'plat_nomor' => 'L 5678 CD',
                'harga_per_hari' => 75000.00,
                'status' => 'Tersedia',
                'deskripsi' => 'Motor sport Yamaha Vixion dengan performa tinggi. Cocok untuk perjalanan jauh.',
            ],
            [
                'merk' => 'Suzuki',
                'model' => 'Address',
                'tahun' => 2023,
                'plat_nomor' => 'L 9012 EF',
                'harga_per_hari' => 60000.00,
                'status' => 'Tersedia',
                'deskripsi' => 'Motor matic Suzuki Address dengan kapasitas bagasi besar. Ideal untuk berbelanja.',
            ],
            [
                'merk' => 'Honda',
                'model' => 'Scoopy',
                'tahun' => 2022,
                'plat_nomor' => 'L 3456 GH',
                'harga_per_hari' => 55000.00,
                'status' => 'Tersedia',
                'deskripsi' => 'Motor matic Honda Scoopy dengan desain stylish. Cocok untuk wanita.',
            ],
            [
                'merk' => 'Yamaha',
                'model' => 'NMAX',
                'tahun' => 2023,
                'plat_nomor' => 'L 7890 IJ',
                'harga_per_hari' => 85000.00,
                'status' => 'Tersedia',
                'deskripsi' => 'Motor matic premium Yamaha NMAX dengan fitur lengkap dan nyaman.',
            ],
            [
                'merk' => 'Honda',
                'model' => 'PCX',
                'tahun' => 2023,
                'plat_nomor' => 'L 2468 KL',
                'harga_per_hari' => 90000.00,
                'status' => 'Tersedia',
                'deskripsi' => 'Motor matic premium Honda PCX dengan teknologi canggih dan desain mewah.',
            ],
            [
                'merk' => 'Suzuki',
                'model' => 'GSX-R150',
                'tahun' => 2021,
                'plat_nomor' => 'L 1357 MN',
                'harga_per_hari' => 80000.00,
                'status' => 'Tersedia',
                'deskripsi' => 'Motor sport Suzuki GSX-R150 dengan performa racing. Cocok untuk penggemar kecepatan.',
            ],
            [
                'merk' => 'Honda',
                'model' => 'Vario 125',
                'tahun' => 2022,
                'plat_nomor' => 'L 9753 OP',
                'harga_per_hari' => 65000.00,
                'status' => 'Tersedia',
                'deskripsi' => 'Motor matic Honda Vario 125 dengan mesin bertenaga dan irit bahan bakar.',
            ],
            [
                'merk' => 'Yamaha',
                'model' => 'Aerox',
                'tahun' => 2023,
                'plat_nomor' => 'L 8642 QR',
                'harga_per_hari' => 70000.00,
                'status' => 'Maintenance',
                'deskripsi' => 'Motor matic sporty Yamaha Aerox dengan akselerasi yang responsif.',
            ],
            [
                'merk' => 'Honda',
                'model' => 'CBR150R',
                'tahun' => 2021,
                'plat_nomor' => 'L 4681 ST',
                'harga_per_hari' => 95000.00,
                'status' => 'Tersedia',
                'deskripsi' => 'Motor sport Honda CBR150R full fairing dengan performa tinggi.',
            ]
        ];

        foreach ($motors as $motor) {
            Motor::create($motor);
        }
    }
}