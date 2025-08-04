<?php
// database/seeders/PeminjamanSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Peminjaman;
use App\Models\Pengunjung;
use App\Models\Motor;
use Carbon\Carbon;

class PeminjamanSeeder extends Seeder
{
    public function run(): void
    {
        $pengunjungs = Pengunjung::all();
        $motors = Motor::all();
        
        $statuses = ['Pending', 'Confirmed', 'Disewa', 'Selesai', 'Cancelled'];
        
        // Generate sample peminjaman data
        for ($i = 0; $i < 15; $i++) {
            $pengunjung = $pengunjungs->random();
            $motor = $motors->random();
            $status = $statuses[array_rand($statuses)];
            $durasiSewa = rand(1, 7);
            $tanggalRental = Carbon::now()->subDays(rand(0, 30));
            
            $peminjaman = [
                'user_id' => $pengunjung->id,
                'nama' => $pengunjung->nama,
                'no_handphone' => $pengunjung->phone,
                'tanggal_rental' => $tanggalRental->toDateString(),
                'jam_sewa' => sprintf('%02d:%02d', rand(8, 17), rand(0, 59)),
                'jenis_motor' => $motor->merk . ' ' . $motor->model . ' (' . $motor->tahun . ')',
                'durasi_sewa' => $durasiSewa,
                'total_harga' => $motor->harga_per_hari * $durasiSewa,
                'status' => $status,
                'keterangan' => $status === 'Cancelled' ? 'Dibatalkan karena kondisi cuaca buruk' : null,
                'created_at' => $tanggalRental,
                'updated_at' => $tanggalRental,
            ];
            
            // Set tanggal kembali jika status selesai
            if ($status === 'Selesai') {
                $peminjaman['tanggal_kembali'] = $tanggalRental->addDays($durasiSewa)->toDateString();
            }
            
            Peminjaman::create($peminjaman);
        }
    }
}