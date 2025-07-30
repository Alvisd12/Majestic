<?php
// database/seeders/BlogSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Blog;
use App\Models\Admin;

class BlogSeeder extends Seeder
{
    public function run(): void
    {
        $admin = Admin::first();
        
        if (!$admin) {
            return;
        }

        $blogs = [
            [
                'judul' => 'Tips Aman Berkendara Motor di Jalan Raya',
                'isi' => 'Berkendara motor di jalan raya memerlukan kehati-hatian dan pengetahuan yang baik tentang keselamatan. Berikut adalah beberapa tips penting untuk memastikan perjalanan Anda aman dan nyaman.

1. Selalu Gunakan Helm SNI
Helm adalah perlengkapan wajib yang harus digunakan setiap kali berkendara motor. Pastikan helm Anda sudah memenuhi standar SNI dan dalam kondisi baik.

2. Periksa Kondisi Motor
Sebelum berangkat, pastikan motor dalam kondisi prima. Periksa tekanan ban, rem, lampu, dan bahan bakar.

3. Patuhi Rambu Lalu Lintas
Selalu patuhi rambu lalu lintas dan aturan berkendara yang berlaku. Ini akan melindungi Anda dan pengguna jalan lainnya.

4. Jaga Jarak Aman
Pertahankan jarak aman dengan kendaraan di depan Anda untuk menghindari tabrakan mendadak.

5. Gunakan Lampu Sein
Selalu gunakan lampu sein saat akan berbelok atau berpindah jalur untuk memberi tahu pengendara lain.

Dengan mengikuti tips-tips di atas, perjalanan Anda akan lebih aman dan nyaman.',
                'gambar' => null,
                'published' => true,
            ],
            [
                'judul' => 'Destinasi Wisata Terbaik untuk Road Trip Motor',
                'isi' => 'Indonesia memiliki banyak destinasi wisata yang indah dan cocok untuk road trip menggunakan motor. Berikut adalah beberapa rekomendasi destinasi yang bisa Anda kunjungi:

1. Puncak, Bogor
Destinasi favorit untuk weekend getaway dengan udara sejuk dan pemandangan alam yang indah.

2. Bandung, Jawa Barat
Kota kembang dengan berbagai destinasi wisata seperti Tangkuban Perahu, Kawah Putih, dan berbagai tempat kuliner.

3. Yogyakarta
Kota budaya dengan berbagai destinasi menarik seperti Candi Borobudur, Malioboro, dan pantai-pantai indah.

4. Malang, Jawa Timur
Dengan udara sejuk dan berbagai destinasi seperti Bromo, Batu, dan pantai-pantai di sekitarnya.

5. Bali
Pulau dewata dengan berbagai destinasi wisata yang terkenal di seluruh dunia.

Setiap destinasi memiliki keunikan tersendiri dan cocok untuk road trip dengan motor. Pastikan untuk merencanakan perjalanan dengan baik dan memilih motor yang sesuai dengan kebutuhan Anda.',
                'gambar' => null,
                'published' => true,
            ],
            [
                'judul' => 'Cara Merawat Motor Agar Tetap Prima',
                'isi' => 'Merawat motor secara rutin sangat penting untuk menjaga performa dan umur mesin motor Anda. Berikut adalah panduan lengkap cara merawat motor:

1. Ganti Oli Secara Berkala
Oli adalah darah bagi mesin motor. Ganti oli sesuai dengan jadwal yang direkomendasikan pabrik untuk menjaga performa mesin.

2. Periksa dan Bersihkan Filter Udara
Filter udara yang kotor akan mempengaruhi performa mesin. Bersihkan atau ganti filter udara secara berkala.

3. Periksa Tekanan Ban
Tekanan ban yang tidak sesuai akan mempengaruhi handling dan konsumsi bahan bakar. Periksa tekanan ban secara rutin.

4. Bersihkan Motor Secara Rutin
Bersihkan motor secara rutin untuk mencegah karat dan menjaga penampilan motor tetap menarik.

5. Periksa Sistem Rem
Sistem rem yang tidak berfungsi dengan baik sangat berbahaya. Periksa dan ganti kampas rem jika diperlukan.

6. Periksa Rantai Motor
Untuk motor dengan transmisi rantai, pastikan rantai selalu dalam kondisi baik dan terolesi dengan benar.

7. Periksa Lampu dan Elektrik
Pastikan semua lampu dan sistem elektrik berfungsi dengan baik untuk keselamatan berkendara.

Dengan merawat motor secara rutin, motor Anda akan tetap prima dan awet dalam jangka waktu yang lama.',
                'gambar' => null,
                'published' => true,
            ]
        ];

        foreach ($blogs as $blog) {
            Blog::create([
                'id_admin' => $admin->id,
                'judul' => $blog['judul'],
                'isi' => $blog['isi'],
                'gambar' => $blog['gambar'],
                'published' => $blog['published'],
            ]);
        }
    }
} 