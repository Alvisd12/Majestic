<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Peminjaman;
use App\Models\Motor;
use Carbon\Carbon;

class UpdatePeminjamanStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'peminjaman:update-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update peminjaman status based on rental dates';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = Carbon::today();
        
        // Update status to "Disewa" for confirmed rentals that have reached rental date
        $confirmedRentals = Peminjaman::where('status', 'Confirmed')
            ->whereDate('tanggal_rental', '<=', $today)
            ->get();
            
        foreach ($confirmedRentals as $peminjaman) {
            $peminjaman->update(['status' => 'Disewa']);
            
            // Update motor status to "Disewa"
            $motor = Motor::where('merk', 'like', '%' . explode(' ', $peminjaman->jenis_motor)[0] . '%')->first();
            if ($motor) {
                $motor->update(['status' => 'Disewa']);
            }
            
            $this->info("Peminjaman ID {$peminjaman->id} status updated to Disewa");
        }
        
        // Update status to "Belum Kembali" for active rentals that have passed return date
        $overdueRentals = Peminjaman::whereIn('status', ['Confirmed', 'Disewa'])
            ->whereDate('tanggal_kembali', '<', $today)
            ->get();
            
        foreach ($overdueRentals as $peminjaman) {
            $peminjaman->update(['status' => 'Belum Kembali']);
            $this->info("Peminjaman ID {$peminjaman->id} status updated to Belum Kembali (overdue)");
        }
        
        $this->info("Status update completed. {$confirmedRentals->count()} rentals started, {$overdueRentals->count()} rentals overdue.");
    }
} 