<?php
// app/Http/Controllers/AdminController.php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Motor;
use App\Models\Pengunjung;
use App\Models\Testimoni;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard(Request $request)
    {
        AuthController::requireAdmin(); // Cek admin access
        
        $currentUser = AuthController::getCurrentUser();
        
        // Statistics
        $totalPeminjaman = Peminjaman::count();
        $totalMotor = Motor::count();
        $totalPengunjung = Pengunjung::count();
        $motorTersedia = Motor::where('status', 'Tersedia')->count();
        $motorDisewa = Motor::where('status', 'Disewa')->count();
        $peminjamanPending = Peminjaman::where('status', 'Pending')->count();
        $peminjamanAktif = Peminjaman::whereIn('status', ['Confirmed', 'Disewa', 'Belum Kembali'])->count();
        
        $query = Peminjaman::with('user'); // Load relasi user untuk mendapatkan nama
        
        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('no_handphone', 'like', "%{$search}%")
                  ->orWhere('jenis_motor', 'like', "%{$search}%")
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('nama', 'like', "%{$search}%")
                               ->orWhere('username', 'like', "%{$search}%");
                  });
            });
        }

        // Filter by status
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        // Filter by date range
        if ($request->has('tanggal_mulai') && $request->tanggal_mulai) {
            $query->whereDate('tanggal_rental', '>=', $request->tanggal_mulai);
        }
        
        if ($request->has('tanggal_akhir') && $request->tanggal_akhir) {
            $query->whereDate('tanggal_rental', '<=', $request->tanggal_akhir);
        }
        
        $peminjaman = $query->orderBy('created_at', 'desc')->paginate(10);
        
        // Data untuk chart (contoh: peminjaman per bulan)
        $peminjamanPerBulan = Peminjaman::selectRaw('MONTH(created_at) as bulan, COUNT(*) as total')
            ->whereYear('created_at', date('Y'))
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();
        
        return view('admin.dashboard', compact(
            'peminjaman', 
            'currentUser',
            'totalPeminjaman',
            'totalMotor',
            'totalPengunjung',
            'motorTersedia',
            'motorDisewa',
            'peminjamanPending',
            'peminjamanAktif',
            'peminjamanPerBulan'
        ));
    }

    public function updateStatus(Request $request, $id)
    {
        AuthController::requireAdmin(); // Cek admin access
        
        $validated = $request->validate([
            'status' => 'required|in:Pending,Confirmed,Belum Kembali,Disewa,Selesai,Cancelled'
        ]);
        
        $peminjaman = Peminjaman::findOrFail($id);
        $oldStatus = $peminjaman->status;
        
        // Handle status motor berdasarkan perubahan status peminjaman
        $this->handleMotorStatus($peminjaman, $oldStatus, $validated['status']);
        
        // Set tanggal kembali jika status menjadi Selesai
        if ($validated['status'] === 'Selesai' && !$peminjaman->tanggal_kembali) {
            $validated['tanggal_kembali'] = now()->toDateString();
        }
        
        $peminjaman->update($validated);
        
        return response()->json([
            'success' => true, 
            'message' => 'Status berhasil diupdate!',
            'new_status' => $validated['status']
        ]);
    }

    public function destroy($id)
    {
        AuthController::requireAdmin(); // Cek admin access
        
        $peminjaman = Peminjaman::findOrFail($id);
        
        // Hapus file terkait
        $this->deleteRelatedFiles($peminjaman);
        
        $peminjaman->delete();
        
        return response()->json(['success' => true, 'message' => 'Peminjaman berhasil dihapus!']);
    }

    // Motor Management
    public function motorIndex()
    {
        AuthController::requireAdmin();
        
        $motors = Motor::orderBy('created_at', 'desc')->paginate(10);
        
        return view('admin.motor.index', compact('motors'));
    }

    public function motorCreate()
    {
        AuthController::requireAdmin();
        
        return view('admin.motor.create');
    }

    public function motorStore(Request $request)
    {
        AuthController::requireAdmin();
        
        $validated = $request->validate([
            'merk' => 'required|string|max:100',
            'model' => 'required|string|max:100',
            'tahun' => 'required|integer|min:1990|max:' . (date('Y') + 1),
            'plat_nomor' => 'required|string|max:20|unique:motor,plat_nomor',
            'harga_per_hari' => 'required|numeric|min:0',
            'deskripsi' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('motor_photos', 'public');
        }

        Motor::create($validated);

        return redirect()->route('admin.motor.index')
            ->with('success', 'Motor berhasil ditambahkan!');
    }

    public function motorEdit($id)
    {
        AuthController::requireAdmin();
        
        $motor = Motor::findOrFail($id);
        
        return view('admin.motor.edit', compact('motor'));
    }

    public function motorUpdate(Request $request, $id)
    {
        AuthController::requireAdmin();
        
        $motor = Motor::findOrFail($id);
        
        $validated = $request->validate([
            'merk' => 'required|string|max:100',
            'model' => 'required|string|max:100',
            'tahun' => 'required|integer|min:1990|max:' . (date('Y') + 1),
            'plat_nomor' => 'required|string|max:20|unique:motor,plat_nomor,' . $id,
            'harga_per_hari' => 'required|numeric|min:0',
            'status' => 'required|in:Tersedia,Disewa,Maintenance',
            'deskripsi' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            // Hapus foto lama
            if ($motor->foto && file_exists(public_path('storage/' . $motor->foto))) {
                unlink(public_path('storage/' . $motor->foto));
            }
            
            $validated['foto'] = $request->file('foto')->store('motor_photos', 'public');
        }

        $motor->update($validated);

        return redirect()->route('admin.motor.index')
            ->with('success', 'Motor berhasil diupdate!');
    }

    public function motorDestroy($id)
    {
        AuthController::requireAdmin();
        
        $motor = Motor::findOrFail($id);
        
        // Cek apakah motor sedang disewa
        if ($motor->status === 'Disewa') {
            return response()->json([
                'success' => false, 
                'message' => 'Motor sedang disewa, tidak dapat dihapus!'
            ]);
        }
        
        // Hapus foto jika ada
        if ($motor->foto && file_exists(public_path('storage/' . $motor->foto))) {
            unlink(public_path('storage/' . $motor->foto));
        }
        
        $motor->delete();
        
        return response()->json(['success' => true, 'message' => 'Motor berhasil dihapus!']);
    }

    // Testimoni Management
    public function testimoniIndex()
    {
        AuthController::requireAdmin();
        
        $testimoni = Testimoni::with('pengunjung')->orderBy('created_at', 'desc')->paginate(10);
        
        return view('admin.testimoni.index', compact('testimoni'));
    }

    public function testimoniApprove($id)
    {
        AuthController::requireAdmin();
        
        $testimoni = Testimoni::findOrFail($id);
        $testimoni->update(['approved' => true]);
        
        return response()->json(['success' => true, 'message' => 'Testimoni berhasil disetujui!']);
    }

    public function testimoniReject($id)
    {
        AuthController::requireAdmin();
        
        $testimoni = Testimoni::findOrFail($id);
        $testimoni->update(['approved' => false]);
        
        return response()->json(['success' => true, 'message' => 'Testimoni berhasil ditolak!']);
    }

    public function testimoniDestroy($id)
    {
        AuthController::requireAdmin();
        
        $testimoni = Testimoni::findOrFail($id);
        $testimoni->delete();
        
        return response()->json(['success' => true, 'message' => 'Testimoni berhasil dihapus!']);
    }

    // Reports
    public function reports(Request $request)
    {
        AuthController::requireAdmin();
        
        $currentUser = AuthController::getCurrentUser();
        
        // Default periode: bulan ini
        $startDate = $request->input('start_date', now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', now()->endOfMonth()->toDateString());
        
        // Query data berdasarkan periode
        $peminjaman = Peminjaman::whereBetween('tanggal_rental', [$startDate, $endDate])
            ->with('user')
            ->orderBy('tanggal_rental', 'desc')
            ->get();
        
        // Statistics
        $totalPeminjaman = $peminjaman->count();
        $totalPendapatan = $peminjaman->where('status', 'Selesai')->sum('total_harga');
        $peminjamanSelesai = $peminjaman->where('status', 'Selesai')->count();
        $peminjamanBatal = $peminjaman->where('status', 'Cancelled')->count();
        
        // Motor paling populer
        $motorPopuler = $peminjaman->groupBy('jenis_motor')
            ->map(function ($group) {
                return [
                    'motor' => $group->first()->jenis_motor,
                    'total' => $group->count()
                ];
            })
            ->sortByDesc('total')
            ->take(5);
        
        return view('admin.reports', compact(
            'currentUser',
            'peminjaman',
            'totalPeminjaman',
            'totalPendapatan',
            'peminjamanSelesai',
            'peminjamanBatal',
            'motorPopuler',
            'startDate',
            'endDate'
        ));
    }

    // Settings
    public function settings()
    {
        AuthController::requireAdmin();
        
        $currentUser = AuthController::getCurrentUser();
        
        return view('admin.settings', compact('currentUser'));
    }

    public function updateSettings(Request $request)
    {
        AuthController::requireAdmin();
        
        $user = AuthController::getCurrentUser();
        
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:admin,username,' . $user->id,
            'email' => 'nullable|email|unique:admin,email,' . $user->id,
            'phone' => 'required|string|max:20|unique:admin,phone,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        if ($validated['password']) {
            $validated['password'] = \Illuminate\Support\Facades\Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('admin.settings')
            ->with('success', 'Pengaturan berhasil diupdate!');
    }

    // Helper Methods
    private function handleMotorStatus($peminjaman, $oldStatus, $newStatus)
    {
        $motor = Motor::where('merk', 'like', '%' . explode(' ', $peminjaman->jenis_motor)[0] . '%')->first();
        
        if (!$motor) return;
        
        // Jika status berubah dari non-Disewa ke Disewa
        if ($oldStatus !== 'Disewa' && $newStatus === 'Disewa') {
            $motor->update(['status' => 'Disewa']);
        }
        
        // Jika status berubah dari Disewa ke Selesai atau Cancelled
        if ($oldStatus === 'Disewa' && in_array($newStatus, ['Selesai', 'Cancelled'])) {
            $motor->update(['status' => 'Tersedia']);
        }
    }

    private function deleteRelatedFiles($peminjaman)
    {
        // Hapus file bukti jaminan jika ada
        if ($peminjaman->bukti_jaminan && file_exists(public_path('storage/' . $peminjaman->bukti_jaminan))) {
            unlink(public_path('storage/' . $peminjaman->bukti_jaminan));
        }

        // Hapus file foto KTP jika ada
        if ($peminjaman->foto_ktp && file_exists(public_path('storage/' . $peminjaman->foto_ktp))) {
            unlink(public_path('storage/' . $peminjaman->foto_ktp));
        }
    }
}