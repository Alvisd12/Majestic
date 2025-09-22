<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Peminjaman;
use Carbon\Carbon;

class UpdateLateRentals extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rentals:update-late';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update late rental status and calculate penalties';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Updating late rental status...');
        
        // Get all completed rentals that were returned late
        $lateRentals = Peminjaman::where(function($q) {
            $q->where('status', 'Selesai')
              ->orWhere('status', 'Dikembalikan')
              ->orWhere('status', 'Belum Kembali');
        })
        ->whereNotNull('tanggal_kembali')
        ->get();
        
        $updated = 0;
        
        foreach ($lateRentals as $rental) {
            // Calculate expected return date
            $expectedReturnDate = $rental->tanggal_rental->addDays($rental->durasi_sewa);
            $actualReturnDate = Carbon::parse($rental->tanggal_kembali);
            
            // Check if returned late
            if ($actualReturnDate->gt($expectedReturnDate)) {
                $lateDays = ceil($expectedReturnDate->diffInDays($actualReturnDate, false));
                
                // Update status to show late days
                $newStatus = "Selesai (Telat {$lateDays} hari)";
                
                // Calculate penalty
                $dailyPrice = $rental->motor ? $rental->motor->harga_per_hari : ($rental->total_harga / $rental->durasi_sewa);
                $penalty = $lateDays * $dailyPrice;
                
                $rental->update([
                    'status' => $newStatus,
                    'denda' => $penalty
                ]);
                
                $updated++;
                $this->line("Updated: {$rental->user->nama} - {$rental->jenis_motor} - Late {$lateDays} days - Penalty: Rp " . number_format($penalty));
            }
        }
        
        // Update currently overdue rentals
        $overdueRentals = Peminjaman::whereIn('status', ['Dikonfirmasi', 'Sedang Disewa', 'Confirmed', 'Disewa'])
            ->whereDate('tanggal_kembali', '<', now())
            ->get();
            
        foreach ($overdueRentals as $rental) {
            $expectedReturnDate = Carbon::parse($rental->tanggal_rental)->addDays($rental->durasi_sewa);
            $lateDays = $expectedReturnDate->diffInDays(Carbon::now(), false);
            
            if ($lateDays > 0) {
                $lateDays = ceil($lateDays); // Round up to nearest whole day
                $newStatus = "Terlambat {$lateDays} hari";
                
                // Calculate and update penalty
                $rental->update(['status' => $newStatus]);
                $rental->updateDenda();
                
                $updated++;
                $this->line("Updated overdue: {$rental->user->nama} - {$rental->jenis_motor} - Late {$lateDays} days");
            }
        }
        
        $this->info("Updated {$updated} rental records.");
        
        return Command::SUCCESS;
    }
}
