<?php

namespace App\Services;

use App\Models\Peminjaman;
use App\Models\Motor;
use Carbon\Carbon;

class PeminjamanStatusService
{
    /**
     * Update peminjaman status based on current date
     */
    public static function updateStatuses()
    {
        $today = Carbon::today();
        $updatedCount = 0;
        
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
            
            $updatedCount++;
        }
        
        // Update status to "Belum Kembali" for active rentals that have passed return date
        $overdueRentals = Peminjaman::whereIn('status', ['Confirmed', 'Disewa'])
            ->whereDate('tanggal_kembali', '<', $today)
            ->get();
            
        foreach ($overdueRentals as $peminjaman) {
            $peminjaman->update(['status' => 'Belum Kembali']);
            $updatedCount++;
        }
        
        return [
            'started_rentals' => $confirmedRentals->count(),
            'overdue_rentals' => $overdueRentals->count(),
            'total_updated' => $updatedCount
        ];
    }
    
    /**
     * Check if a peminjaman is overdue
     */
    public static function isOverdue($peminjaman)
    {
        return Carbon::today()->gt($peminjaman->tanggal_kembali) && 
               in_array($peminjaman->status, ['Confirmed', 'Disewa']);
    }
    
    /**
     * Check if a peminjaman should start today
     */
    public static function shouldStartToday($peminjaman)
    {
        return Carbon::today()->gte($peminjaman->tanggal_rental) && 
               $peminjaman->status === 'Confirmed';
    }
    
    /**
     * Get overdue peminjaman count
     */
    public static function getOverdueCount()
    {
        return Peminjaman::whereIn('status', ['Confirmed', 'Disewa'])
            ->whereDate('tanggal_kembali', '<', Carbon::today())
            ->count();
    }
    
    /**
     * Get peminjaman that should start today
     */
    public static function getStartingTodayCount()
    {
        return Peminjaman::where('status', 'Confirmed')
            ->whereDate('tanggal_rental', '<=', Carbon::today())
            ->count();
    }
} 