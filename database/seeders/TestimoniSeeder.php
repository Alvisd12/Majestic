<?php
// database/seeders/TestimoniSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Testimoni;
use App\Models\Pengunjung;

class TestimoniSeeder extends Seeder
{
    public function run(): void
    {
        $pengunjungs = Pengunjung::all();
        
        $testimonis = [
            [
                'pesan' => 'Pelayanan sangat memuaskan! Motor dalam kondisi prima dan harga terjangkau.',
                'rating' => 5,
                'approved' => true,
            ],
            [
                'pesan' => 'Proses rental mudah dan cepat. Pemilik sangat ramah dan profesional.',
                'rating' => 5,
                'approved' => true,
            ],
            [
                'pesan' => 'Motor bersih dan terawat dengan baik. Recommended untuk rental motor!',
                'rating' => 4,
                'approved' => true,
            ],
            [
                'pesan' => 'Harga kompetitif dan motor sesuai dengan deskripsi. Akan rental lagi!',
                'rating' => 4,
                'approved' => false,
            ],
            [
                'pesan' => 'Lokasi strategis dan mudah dijangkau. Terima kasih atas pelayanannya.',
                'rating' => 5,
                'approved' => true,
            ]
        ];

        foreach ($testimonis as $index => $testimoni) {
            $pengunjung = $pengunjungs->get($index % $pengunjungs->count());
            
            Testimoni::create([
                'id_pengunjung' => $pengunjung->id,
                'pesan' => $testimoni['pesan'],
                'rating' => $testimoni['rating'],
                'approved' => $testimoni['approved'],
            ]);
        }
    }
}