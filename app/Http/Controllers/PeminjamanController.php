<?php
// app/Http/Controllers/PeminjamanController.php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Motor;
use Illuminate\Http\Request;

class PeminjamanController extends Controller
{
    public function index(Request $request)
    {
        AuthController::requireAuth(); // Cek login
        
        $user = AuthController::getCurrentUser();
        
        $query = Peminjaman::with('user'); // Load relasi user untuk mendapatkan nama
        
        // Jika admin, tampilkan semua peminjaman
        if (AuthController::isAdmin()) {
            // Search functionality untuk admin
            if ($request->has('search') && $request->search) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('nama', 'like', "%{$search}%")
                      ->orWhere('no_handphone', 'like', "%{$search}%")
                      ->orWhere('jenis_motor', 'like', "%{$search}%")
                      ->orWhereHas('user', function($userQuery) use ($search) {
                          $userQuery->where('nama', 'like', "%{$search}%");
                      });
                });
            }
            
            // Filter by status
            if ($request->has('status') && $request->status) {
                $query->where('status', $request->status);
            }
        } else {
            // Jika pengunjung, tampilkan hanya peminjaman miliknya
            $query->where('user_id', $user->id);
        }
        
        $peminjaman = $query->orderBy('created_at', 'desc')->paginate(10);
        
        return view('peminjaman.index', compact('peminjaman'));
    }

    public function create()
    {
        AuthController::requireAuth(); // Cek login
        
        // Ambil motor yang tersedia
        $motors = Motor::tersedia()->get();
        
        return view('peminjaman.create', compact('motors'));
    }

    public function store(Request $request)
    {
        AuthController::requireAuth(); // Cek login
        
        $user = AuthController::getCurrentUser();
        
        $validated = $request->validate([
            'tanggal_rental' => 'required|date|after_or_equal:today',
            'jam_sewa' => 'nullable|date_format:H:i',
            'jenis_motor' => 'required|string|max:255',
            'durasi_sewa' => 'required|integer|min:1',
        ], [
            'tanggal_rental.required' => 'Tanggal rental wajib diisi.',
            'tanggal_rental.after_or_equal' => 'Tanggal rental tidak boleh kurang dari hari ini.',
            'jam_sewa.date_format' => 'Format jam sewa tidak valid (HH:MM).',
            'jenis_motor.required' => 'Jenis motor wajib diisi.',
            'durasi_sewa.required' => 'Durasi sewa wajib diisi.',
            'durasi_sewa.min' => 'Durasi sewa minimal 1 hari.',
        ]);

        // Cari motor yang sesuai
        $motor = Motor::where('merk', 'like', '%' . explode(' ', $validated['jenis_motor'])[0] . '%')
            ->where('status', 'Tersedia')
            ->first();

        $totalHarga = null;
        if ($motor) {
            $totalHarga = $motor->harga_per_hari * $validated['durasi_sewa'];
        }

        // Buat peminjaman
        Peminjaman::create([
            'user_id' => $user->id,
            'tanggal_rental' => $validated['tanggal_rental'],
            'jam_sewa' => $validated['jam_sewa'],
            'jenis_motor' => $validated['jenis_motor'],
            'durasi_sewa' => $validated['durasi_sewa'],
            'total_harga' => $totalHarga,
            'status' => 'Pending',
        ]);

        // Update status motor menjadi Disewa
        if ($motor) {
            $motor->update(['status' => 'Disewa']);
        }

        return redirect()->route('peminjaman.index')
            ->with('success', 'Peminjaman berhasil diajukan! Menunggu konfirmasi admin.');
    }

    public function show($id)
    {
        AuthController::requireAuth(); // Cek login
        
        $user = AuthController::getCurrentUser();
        $peminjaman = Peminjaman::with('user')->findOrFail($id);
        
        // Cek apakah user berhak melihat peminjaman ini
        if (!AuthController::isAdmin() && $peminjaman->user_id !== $user->id) {
            abort(403, 'Anda tidak berhak melihat data ini.');
        }
        
        return view('peminjaman.show', compact('peminjaman'));
    }

    public function edit($id)
    {
        AuthController::requireAuth(); // Cek login
        
        $user = AuthController::getCurrentUser();
        $peminjaman = Peminjaman::findOrFail($id);
        
        // Cek apakah user berhak mengedit peminjaman ini
        if (!AuthController::isAdmin() && $peminjaman->user_id !== $user->id) {
            abort(403, 'Anda tidak berhak mengedit data ini.');
        }
        
        // Tidak bisa edit jika status sudah 'Selesai' atau 'Cancelled'
        if (in_array($peminjaman->status, ['Selesai', 'Cancelled'])) {
            return redirect()->route('peminjaman.index')
                ->with('error', 'Tidak dapat mengedit peminjaman yang sudah selesai atau dibatalkan.');
        }
        
        // Ambil motor yang tersedia untuk dropdown
        $motors = Motor::tersedia()->get();
        
        return view('peminjaman.edit', compact('peminjaman', 'motors'));
    }

    public function update(Request $request, $id)
    {
        AuthController::requireAuth(); // Cek login
        
        $user = AuthController::getCurrentUser();
        $peminjaman = Peminjaman::findOrFail($id);
        
        // Cek apakah user berhak mengupdate peminjaman ini
        if (!AuthController::isAdmin() && $peminjaman->user_id !== $user->id) {
            abort(403, 'Anda tidak berhak mengupdate data ini.');
        }
        
        $validated = $request->validate([
            'tanggal_rental' => 'required|date',
            'jam_sewa' => 'nullable|date_format:H:i',
            'jenis_motor' => 'required|string|max:255',
            'durasi_sewa' => 'required|integer|min:1',
        ]);



        // Hitung ulang total harga jika motor berubah
        if ($validated['jenis_motor'] !== $peminjaman->jenis_motor || $validated['durasi_sewa'] !== $peminjaman->durasi_sewa) {
            $motor = Motor::where('merk', 'like', '%' . explode(' ', $validated['jenis_motor'])[0] . '%')->first();
            if ($motor) {
                $validated['total_harga'] = $motor->harga_per_hari * $validated['durasi_sewa'];
            }
        }

        $peminjaman->update($validated);

        return redirect()->route('peminjaman.index')
            ->with('success', 'Peminjaman berhasil diupdate!');
    }

    public function destroy($id)
    {
        AuthController::requireAuth(); // Cek login
        
        $user = AuthController::getCurrentUser();
        $peminjaman = Peminjaman::findOrFail($id);
        
        // Cek apakah user berhak menghapus peminjaman ini
        if (!AuthController::isAdmin() && $peminjaman->user_id !== $user->id) {
            abort(403, 'Anda tidak berhak menghapus data ini.');
        }
        

        
        $peminjaman->delete();

        return redirect()->route('peminjaman.index')
            ->with('success', 'Peminjaman berhasil dihapus!');
    }

    // Method khusus untuk admin
    public function updateStatus(Request $request, $id)
    {
        AuthController::requireAdmin(); // Cek admin access
        
        $validated = $request->validate([
            'status' => 'required|in:Pending,Confirmed,Belum Kembali,Disewa,Selesai,Cancelled'
        ]);
        
        $peminjaman = Peminjaman::findOrFail($id);
        
        // Set tanggal kembali jika status menjadi Selesai
        if ($validated['status'] === 'Selesai' && !$peminjaman->tanggal_kembali) {
            $validated['tanggal_kembali'] = now()->toDateString();
        }
        
        $peminjaman->update($validated);
        
        return response()->json(['success' => true, 'message' => 'Status berhasil diupdate!']);
    }

    public function confirm($id)
    {
        AuthController::requireAdmin(); // Cek admin access
        
        $peminjaman = Peminjaman::findOrFail($id);
        $peminjaman->update(['status' => 'Confirmed']);
        
        return redirect()->back()->with('success', 'Peminjaman berhasil dikonfirmasi!');
    }

    public function reject($id)
    {
        AuthController::requireAdmin(); // Cek admin access
        
        $peminjaman = Peminjaman::findOrFail($id);
        $peminjaman->update(['status' => 'Cancelled']);
        
        return redirect()->back()->with('success', 'Peminjaman berhasil ditolak!');
    }

    public function startRental($id)
    {
        AuthController::requireAdmin(); // Cek admin access
        
        $peminjaman = Peminjaman::findOrFail($id);
        
        // Update status motor menjadi disewa
        $motor = Motor::where('merk', 'like', '%' . explode(' ', $peminjaman->jenis_motor)[0] . '%')->first();
        if ($motor) {
            $motor->update(['status' => 'Disewa']);
        }
        
        $peminjaman->update(['status' => 'Disewa']);
        
        return redirect()->back()->with('success', 'Rental berhasil dimulai!');
    }

    public function finishRental($id)
    {
        AuthController::requireAdmin(); // Cek admin access
        
        $peminjaman = Peminjaman::findOrFail($id);
        
        // Update status motor menjadi tersedia
        $motor = Motor::where('merk', 'like', '%' . explode(' ', $peminjaman->jenis_motor)[0] . '%')->first();
        if ($motor) {
            $motor->update(['status' => 'Tersedia']);
        }
        
        $peminjaman->update([
            'status' => 'Selesai',
            'tanggal_kembali' => now()->toDateString()
        ]);
        
        return redirect()->back()->with('success', 'Rental berhasil diselesaikan!');
    }
}