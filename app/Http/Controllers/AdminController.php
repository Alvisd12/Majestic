<?php
// app/Http/Controllers/AdminController.php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Motor;
use App\Models\Pengunjung;
use App\Models\Testimoni;
use App\Services\PeminjamanStatusService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function dashboard(Request $request)
    {
        AuthController::requireAdmin(); // Cek admin access
        
        // Update status otomatis berdasarkan tanggal
        PeminjamanStatusService::updateStatuses();
        
        $currentUser = AuthController::getCurrentUser();
        
        // Statistics
        $totalPeminjaman = Peminjaman::count();
        $totalMotor = Motor::count();
        $totalPengunjung = Pengunjung::count();
        $motorTersedia = Motor::where('status', 'Tersedia')->count();
        $motorDisewa = Motor::where('status', 'Disewa')->count();
        $peminjamanPending = Peminjaman::where('status', 'Menunggu Konfirmasi')->count();
        $peminjamanAktif = Peminjaman::where(function($query) {
            $query->where('status', 'Dikonfirmasi')
                  ->orWhere('status', 'like', 'Terlambat%');
        })->count();
        
        // Monthly statistics comparison
        $currentMonth = now()->startOfMonth();
        $previousMonth = now()->subMonth()->startOfMonth();
        $previousMonthEnd = now()->subMonth()->endOfMonth();
        
        $peminjamanBulanIni = Peminjaman::where('created_at', '>=', $currentMonth)->count();
        $peminjamanBulanLalu = Peminjaman::whereBetween('created_at', [$previousMonth, $previousMonthEnd])->count();
        
        // Calculate percentage change
        $persentasePerubahan = 0;
        if ($peminjamanBulanLalu > 0) {
            $persentasePerubahan = (($peminjamanBulanIni - $peminjamanBulanLalu) / $peminjamanBulanLalu) * 100;
        } elseif ($peminjamanBulanIni > 0) {
            $persentasePerubahan = 100;
        }
        
        $query = Peminjaman::with('user'); // Load relasi user untuk mendapatkan nama

        // Sembunyikan pemesanan Midtrans yang belum dibayar dari daftar admin
        $query->where(function($q) {
            $q->whereNull('payment_method')
              ->orWhere('payment_method', '!=', 'midtrans')
              ->orWhere(function($q2) {
                  $q2->where('payment_method', 'midtrans')
                     ->where('payment_status', 'paid');
              });
        });
        
        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('jenis_motor', 'like', "%{$search}%")
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('nama', 'like', "%{$search}%")
                               ->orWhere('username', 'like', "%{$search}%")
                               ->orWhere('no_handphone', 'like', "%{$search}%");
                  });
            });
        }

        // Filter by status
        if ($request->has('status') && $request->status) {
            $status = $request->status;
            
            if ($status === 'Selesai') {
                // Include both "Selesai" and "Selesai (Telat X hari)"
                $query->where(function($q) {
                    $q->where('status', 'Selesai')
                      ->orWhere('status', 'like', 'Selesai (Telat%');
                });
            } elseif ($status === 'Disewa') {
                // Include "Dikonfirmasi" and "Terlambat X hari" (active rentals)
                $query->where(function($q) {
                    $q->where('status', 'Dikonfirmasi')
                      ->orWhere('status', 'like', 'Terlambat%');
                });
            } else {
                // Exact match for other statuses
                $query->where('status', $status);
            }
        }

        // Filter by date range
        if ($request->has('tanggal_mulai') && $request->tanggal_mulai) {
            $query->whereDate('tanggal_rental', '>=', $request->tanggal_mulai);
        }
        
        if ($request->has('tanggal_akhir') && $request->tanggal_akhir) {
            $query->whereDate('tanggal_rental', '<=', $request->tanggal_akhir);
        }
        
        // Use the filtered query for recent rentals display
        $recentRentals = $query->orderBy('created_at', 'desc')->paginate(10);
        
        // Data untuk chart (contoh: peminjaman per bulan)
        $peminjamanPerBulan = Peminjaman::selectRaw('MONTH(created_at) as bulan, COUNT(*) as total')
            ->whereYear('created_at', date('Y'))
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();
        
        // Set notification message if there were updates
        $updateResult = PeminjamanStatusService::updateStatuses();
        if ($updateResult['total_updated'] > 0) {
            $message = '';
            if ($updateResult['started_rentals'] > 0) {
                $message .= "{$updateResult['started_rentals']} rental dimulai otomatis. ";
            }
            if ($updateResult['overdue_rentals'] > 0) {
                $message .= "{$updateResult['overdue_rentals']} rental terlambat dikembalikan.";
            }
            session()->flash('status_updated', $message);
        }
        
        return view('admin.dashboard', compact(
            'currentUser',
            'totalPeminjaman',
            'totalMotor',
            'totalPengunjung',
            'motorTersedia',
            'motorDisewa',
            'peminjamanPending',
            'peminjamanAktif',
            'peminjamanPerBulan',
            'peminjamanBulanIni',
            'peminjamanBulanLalu',
            'persentasePerubahan',
            'recentRentals'
        ));
    }

    public function updateStatus(Request $request, $id)
    {
        AuthController::requireAdmin(); // Cek admin access
        
        $validated = $request->validate([
            'status' => 'required|string'
        ]);
        
        $peminjaman = Peminjaman::findOrFail($id);
        $oldStatus = $peminjaman->status;
        
        // Handle status motor berdasarkan perubahan status peminjaman
        $this->handleMotorStatus($peminjaman, $oldStatus, $validated['status']);
        
        // Set tanggal kembali jika status menjadi Selesai
        if ($validated['status'] === 'Selesai') {
            $validated['tanggal_kembali'] = now()->toDateString();
            
            // Jika motor terlambat dikembalikan, update status dengan informasi keterlambatan
            if ($peminjaman->isOverdue || str_starts_with($peminjaman->status, 'Terlambat')) {
                $overdueDays = $peminjaman->overdue_days;
                if ($overdueDays > 0) {
                    $validated['status'] = "Selesai (Telat {$overdueDays} hari)";
                }
            }
        }
        
        $peminjaman->update($validated);
        
        return response()->json([
            'success' => true, 
            'message' => 'Status berhasil diupdate!',
            'new_status' => $validated['status']
        ]);
    }

    public function konfirmasi(Request $request)
    {
        AuthController::requireAdmin(); // Cek admin access
        
        // Update status otomatis berdasarkan tanggal
        $updateResult = PeminjamanStatusService::updateStatuses();
        
        $query = Peminjaman::with('user')->where('status', 'Menunggu Konfirmasi');
        
        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('jenis_motor', 'like', "%{$search}%")
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('nama', 'like', "%{$search}%")
                               ->orWhere('username', 'like', "%{$search}%")
                               ->orWhere('no_handphone', 'like', "%{$search}%");
                  });
            });
        }
        
        $peminjaman = $query->orderBy('created_at', 'desc')->paginate(10);
        
        // Set notification message if there were updates
        if ($updateResult['total_updated'] > 0) {
            $message = '';
            if ($updateResult['started_rentals'] > 0) {
                $message .= "{$updateResult['started_rentals']} rental dimulai otomatis. ";
            }
            if ($updateResult['overdue_rentals'] > 0) {
                $message .= "{$updateResult['overdue_rentals']} rental terlambat dikembalikan.";
            }
            session()->flash('status_updated', $message);
        }
        
        return view('admin.konfirmasi', compact('peminjaman'));
    }

    public function approve($id)
    {
        AuthController::requireAdmin(); // Cek admin access
        
        $peminjaman = Peminjaman::findOrFail($id);
        $oldStatus = $peminjaman->status;
        
        // Handle motor status automatically when approving
        $this->handleMotorStatus($peminjaman, $oldStatus, 'Confirmed');
        
        // Update status to Confirmed - data akan otomatis muncul di halaman dipinjam
        $peminjaman->update(['status' => 'Confirmed']);
        
        return response()->json([
            'success' => true, 
            'message' => 'Peminjaman berhasil disetujui! Data akan muncul di halaman Dipinjam.'
        ]);
    }

    public function reject($id)
    {
        AuthController::requireAdmin(); // Cek admin access
        
        $peminjaman = Peminjaman::findOrFail($id);
        
        // Delete related files
        $this->deleteRelatedFiles($peminjaman);
        
        // Delete the peminjaman record
        $peminjaman->delete();
        
        return response()->json([
            'success' => true, 
            'message' => 'Peminjaman berhasil ditolak dan dihapus!'
        ]);
    }

    public function updateLateRentals()
    {
        AuthController::requireAdmin(); // Cek admin access
        
        $updated = 0;
        
        // Update completed rentals that were returned late
        $completedRentals = Peminjaman::whereIn('status', ['Selesai', 'Dikembalikan'])
            ->whereNotNull('tanggal_kembali')
            ->get();
            
        foreach ($completedRentals as $rental) {
            $expectedReturnDate = $rental->tanggal_rental->addDays($rental->durasi_sewa);
            $actualReturnDate = \Carbon\Carbon::parse($rental->tanggal_kembali);
            
            if ($actualReturnDate->gt($expectedReturnDate)) {
                $lateDays = ceil($expectedReturnDate->diffInDays($actualReturnDate, false));
                $newStatus = "Selesai (Telat {$lateDays} hari)";
                
                // Calculate penalty
                $dailyPrice = $rental->motor ? $rental->motor->harga_per_hari : ($rental->total_harga / $rental->durasi_sewa);
                $penalty = $lateDays * $dailyPrice;
                
                $rental->update([
                    'status' => $newStatus,
                    'denda' => $penalty
                ]);
                
                $updated++;
            }
        }
        
        // Update currently overdue rentals
        $overdueRentals = Peminjaman::where('status', 'Dikonfirmasi')
            ->get()
            ->filter(function($rental) {
                $expectedReturnDate = $rental->tanggal_rental->addDays($rental->durasi_sewa);
                return now()->gt($expectedReturnDate);
            });
            
        foreach ($overdueRentals as $rental) {
            $expectedReturnDate = $rental->tanggal_rental->addDays($rental->durasi_sewa);
            $lateDays = ceil($expectedReturnDate->diffInDays(now(), false));
            
            if ($lateDays > 0) {
                $newStatus = "Terlambat {$lateDays} hari";
                $rental->update(['status' => $newStatus]);
                $rental->updateDenda();
                $updated++;
            }
        }
        
        return response()->json([
            'success' => true,
            'message' => "Berhasil mengupdate {$updated} data peminjaman dengan status dan denda yang benar."
        ]);
    }

    public function dipinjam(Request $request)
    {
        AuthController::requireAdmin(); // Cek admin access
        
        // Update status otomatis berdasarkan tanggal
        $updateResult = PeminjamanStatusService::updateStatuses();
        
        $query = Peminjaman::with('user')->active();
        
        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('jenis_motor', 'like', "%{$search}%")
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('nama', 'like', "%{$search}%")
                               ->orWhere('username', 'like', "%{$search}%")
                               ->orWhere('no_handphone', 'like', "%{$search}%");
                  });
            });
        }
        
        $peminjaman = $query->orderBy('created_at', 'desc')->paginate(10);
        
        // Update penalty amounts for overdue rentals
        foreach ($peminjaman as $item) {
            if (str_starts_with($item->status, 'Terlambat')) {
                $item->updateDenda();
            }
        }
        
        // Set notification message if there were updates
        if ($updateResult['total_updated'] > 0) {
            $message = '';
            if ($updateResult['started_rentals'] > 0) {
                $message .= "{$updateResult['started_rentals']} rental dimulai otomatis. ";
            }
            if ($updateResult['overdue_rentals'] > 0) {
                $message .= "{$updateResult['overdue_rentals']} rental terlambat dikembalikan.";
            }
            session()->flash('status_updated', $message);
        }
        
        return view('admin.dipinjam', compact('peminjaman'));
    }

    public function startRental($id)
    {
        AuthController::requireAdmin(); // Cek admin access
        
        $peminjaman = Peminjaman::findOrFail($id);
        $oldStatus = $peminjaman->status;
        
        // Handle motor status automatically
        $this->handleMotorStatus($peminjaman, $oldStatus, 'Disewa');
        
        $peminjaman->update(['status' => 'Disewa']);
        
        return response()->json([
            'success' => true, 
            'message' => 'Rental berhasil dimulai!'
        ]);
    }

    public function finishRental($id)
    {
        AuthController::requireAdmin(); // Cek admin access
        
        $peminjaman = Peminjaman::findOrFail($id);
        $oldStatus = $peminjaman->status;
        
        // Handle motor status automatically
        $this->handleMotorStatus($peminjaman, $oldStatus, 'Selesai');
        
        $peminjaman->update([
            'status' => 'Selesai',
            'tanggal_kembali' => now()->toDateString()
        ]);
        
        return response()->json([
            'success' => true, 
            'message' => 'Rental berhasil diselesaikan!'
        ]);
    }

    public function dikembalikan(Request $request)
    {
        AuthController::requireAdmin(); // Cek admin access
        
        // Update status otomatis berdasarkan tanggal
        PeminjamanStatusService::updateStatuses();
        
        $query = Peminjaman::with('user')->completed();
        
        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('jenis_motor', 'like', "%{$search}%")
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('nama', 'like', "%{$search}%")
                               ->orWhere('username', 'like', "%{$search}%")
                               ->orWhere('no_handphone', 'like', "%{$search}%");
                  });
            });
        }
        
        $peminjaman = $query->orderBy('created_at', 'desc')->paginate(10);
        
        // Set notification message if there were updates
        $updateResult = PeminjamanStatusService::updateStatuses();
        if ($updateResult['total_updated'] > 0) {
            $message = '';
            if ($updateResult['started_rentals'] > 0) {
                $message .= "{$updateResult['started_rentals']} rental dimulai otomatis. ";
            }
            if ($updateResult['overdue_rentals'] > 0) {
                $message .= "{$updateResult['overdue_rentals']} rental terlambat dikembalikan.";
            }
            session()->flash('status_updated', $message);
        }
        
        return view('admin.dikembalikan', compact('peminjaman'));
    }

    public function show($id)
    {
        AuthController::requireAdmin(); // Cek admin access
        
        $peminjaman = Peminjaman::with('user')->findOrFail($id);
        
        return view('admin.peminjaman.show', compact('peminjaman'));
    }

    public function export()
    {
        AuthController::requireAdmin();
        
        // Simple export functionality - can be enhanced later
        return response()->json(['message' => 'Export functionality coming soon']);
    }

    public function getStatistics()
    {
        AuthController::requireAdmin();
        
        // Return statistics for AJAX requests
        $stats = [
            'total_peminjaman' => Peminjaman::count(),
            'motor_tersedia' => Motor::where('status', 'Tersedia')->count(),
            'peminjaman_aktif' => Peminjaman::whereIn('status', ['Confirmed', 'Disewa', 'Belum Kembali'])->count(),
            'total_pengunjung' => Pengunjung::count(),
        ];
        
        return response()->json($stats);
    }

    // Galeri Management
    public function galeriIndex(Request $request)
    {
        AuthController::requireAdmin();
        
        $query = \App\Models\Galeri::query();
        
        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->whereHas('admin', function($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%");
            });
        }
        
        $galeri = $query->orderBy('created_at', 'desc')->paginate(10);
        
        if ($request->ajax()) {
            return view('admin.galeri.partials.table', compact('galeri'));
        }
        
        return view('admin.galeri', compact('galeri'));
    }

    public function galeriCreate()
    {
        AuthController::requireAdmin();
        
        return view('admin.galeri.create');
    }

    public function galeriStore(Request $request)
    {
        AuthController::requireAdmin();

        $validated = $request->validate([
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'tanggal_sewa' => 'nullable|date',
            'jenis_motor' => 'nullable|string|in:Matic,Manual,Sport'
        ], [
            'gambar.required' => 'Gambar wajib diupload.',
            'gambar.image' => 'File harus berupa gambar.',
            'gambar.mimes' => 'Format gambar harus JPG, PNG, atau GIF.',
            'gambar.max' => 'Ukuran gambar maksimal 2MB.',
            'tanggal_sewa.date' => 'Format tanggal tidak valid.',
            'jenis_motor.in' => 'Jenis motor harus salah satu dari: Matic, Manual, atau Sport.'
        ]);

        // Handle file upload
        if ($request->hasFile('gambar')) {
            $gambar = $request->file('gambar');
            $gambarName = time() . '_' . $gambar->getClientOriginalName();
            $gambarPath = $gambar->storeAs('galeri', $gambarName, 'public');
            $validated['gambar'] = $gambarPath;
        }

        // Add admin ID
        $validated['id_admin'] = AuthController::getCurrentUser()->id;

        // Create galeri entry
        $galeri = \App\Models\Galeri::create($validated);

        return redirect()->route('admin.galeri')
            ->with('success', 'Item galeri berhasil ditambahkan!');
    }

    public function galeriEdit($id)
    {
        AuthController::requireAdmin();
        
        $galeri = \App\Models\Galeri::findOrFail($id);
        
        return view('admin.galeri.edit', compact('galeri'));
    }

    public function galeriUpdate(Request $request, $id)
    {
        AuthController::requireAdmin();
        
        $galeri = \App\Models\Galeri::findOrFail($id);
        
        $validated = $request->validate([
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'tanggal_sewa' => 'nullable|date',
            'jenis_motor' => 'nullable|string|in:Matic,Manual,Sport'
        ], [
            'gambar.image' => 'File harus berupa gambar.',
            'gambar.mimes' => 'Format gambar harus JPG, PNG, atau GIF.',
            'gambar.max' => 'Ukuran gambar maksimal 2MB.',
            'tanggal_sewa.date' => 'Format tanggal tidak valid.',
            'jenis_motor.in' => 'Jenis motor harus salah satu dari: Matic, Manual, atau Sport.'
        ]);
        
        // Handle file upload if new image is provided
        if ($request->hasFile('gambar')) {
            // Delete old image
            if ($galeri->gambar && Storage::disk('public')->exists($galeri->gambar)) {
                Storage::disk('public')->delete($galeri->gambar);
            }
            
            $gambar = $request->file('gambar');
            $gambarName = time() . '_' . $gambar->getClientOriginalName();
            $gambarPath = $gambar->storeAs('galeri', $gambarName, 'public');
            $validated['gambar'] = $gambarPath;
        }
        
        $galeri->update($validated);
        
        return redirect()->route('admin.galeri')
            ->with('success', 'Item galeri berhasil diupdate!');
    }

    public function galeriDestroy($id)
    {
        AuthController::requireAdmin();
        
        $galeri = \App\Models\Galeri::findOrFail($id);
        
        // Delete image file
        if ($galeri->gambar && Storage::disk('public')->exists($galeri->gambar)) {
            Storage::disk('public')->delete($galeri->gambar);
        }
        
        $galeri->delete();
        
        return response()->json(['success' => true, 'message' => 'Item galeri berhasil dihapus!']);
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
        
        // Redirect to harga sewa page since that's where motor management is handled
        return redirect()->route('admin.harga_sewa');
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
            'warna' => 'nullable|string|max:50',
            'jenis_motor' => 'required|string|in:Matic,Manual,Sport',
            'harga_per_hari' => 'required|numeric|min:0',
            'deskripsi' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'jenis_motor.required' => 'Jenis motor wajib dipilih.',
            'jenis_motor.in' => 'Jenis motor harus salah satu dari: Matic, Manual, atau Sport.'
        ]);

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('motor_photos', 'public');
        }

        Motor::create($validated);

        return redirect()->route('admin.harga_sewa')
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
            'warna' => 'nullable|string|max:50',
            'jenis_motor' => 'required|string|in:Matic,Manual,Sport',
            'harga_per_hari' => 'required|numeric|min:0',
            'status' => 'required|in:Tersedia,Disewa,Maintenance',
            'deskripsi' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'jenis_motor.required' => 'Jenis motor wajib dipilih.',
            'jenis_motor.in' => 'Jenis motor harus salah satu dari: Matic, Manual, atau Sport.'
        ]);

        if ($request->hasFile('foto')) {
            // Hapus foto lama
            if ($motor->foto && file_exists(public_path('storage/' . $motor->foto))) {
                unlink(public_path('storage/' . $motor->foto));
            }
            
            $validated['foto'] = $request->file('foto')->store('motor_photos', 'public');
        }

        $motor->update($validated);

        return redirect()->route('admin.harga_sewa')
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

    // Harga Sewa Management
    public function hargaSewa(Request $request)
    {
        AuthController::requireAdmin();
        
        $currentUser = AuthController::getCurrentUser();
        
        $query = Motor::query();
        
        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('merk', 'like', "%{$search}%")
                  ->orWhere('model', 'like', "%{$search}%")
                  ->orWhere('plat_nomor', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%");
            });
        }
        
        $motors = $query->orderBy('created_at', 'desc')->paginate(10);
        
        return view('admin.harga_sewa', compact('motors', 'currentUser'));
    }

    // Testimoni Management
    public function testimoniIndex(Request $request)
    {
        AuthController::requireAdmin();
        
        $query = Testimoni::with('pengunjung');
        
        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('testimoni', 'like', "%{$search}%")
                  ->orWhere('pesan', 'like', "%{$search}%")
                  ->orWhere('nama', 'like', "%{$search}%")
                  ->orWhere('rating', 'like', "%{$search}%")
                  ->orWhereHas('pengunjung', function($userQuery) use ($search) {
                      $userQuery->where('nama', 'like', "%{$search}%")
                               ->orWhere('username', 'like', "%{$search}%");
                  });
            });
        }
        
        // Filter by status
        if ($request->has('status') && $request->status) {
            switch ($request->status) {
                case 'pending':
                    $query->whereNull('approved');
                    break;
                case 'approved':
                    $query->where('approved', true);
                    break;
                case 'rejected':
                    $query->where('approved', false);
                    break;
            }
        }
        
        $testimoni = $query->orderBy('created_at', 'desc')->paginate(10);
        
        return view('admin.testimoni', compact('testimoni'));
    }

    public function testimoniCreate()
    {
        AuthController::requireAdmin();
        
        $pengunjung = Pengunjung::orderBy('nama')->get();
        
        return view('admin.testimoni.create', compact('pengunjung'));
    }

    public function testimoniStore(Request $request)
    {
        AuthController::requireAdmin();
        
        $request->validate([
            'id_pengunjung' => 'required|exists:pengunjung,id',
            'pesan' => 'required|string|max:1000',
            'rating' => 'required|integer|min:1|max:5',
            'approved' => 'nullable|boolean',
        ]);

        Testimoni::create([
            'id_pengunjung' => $request->id_pengunjung,
            'pesan' => $request->pesan,
            'rating' => $request->rating,
            'approved' => $request->approved !== '' ? (bool)$request->approved : null,
        ]);

        return redirect()->route('admin.testimoni')->with('success', 'Testimoni berhasil ditambahkan!');
    }

    public function testimoniShow($id)
    {
        AuthController::requireAdmin();
        
        $testimoni = Testimoni::with('pengunjung')->findOrFail($id);
        
        return view('admin.testimoni.show', compact('testimoni'));
    }

    public function testimoniUpdate(Request $request, $id)
    {
        AuthController::requireAdmin();
        
        $testimoni = Testimoni::findOrFail($id);
        
        $request->validate([
            'id_pengunjung' => 'required|exists:pengunjung,id',
            'pesan' => 'required|string|max:1000',
            'rating' => 'required|integer|min:1|max:5',
            'approved' => 'nullable|boolean',
        ]);

        $testimoni->update([
            'id_pengunjung' => $request->id_pengunjung,
            'pesan' => $request->pesan,
            'rating' => $request->rating,
            'approved' => $request->approved !== '' ? (bool)$request->approved : null,
        ]);

        return redirect()->route('admin.testimoni')->with('success', 'Testimoni berhasil diupdate!');
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
        $totalPendapatan = $peminjaman->completed()->sum('total_harga');
        $peminjamanSelesai = $peminjaman->completed()->count();
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
        // Find motor based on jenis_motor with better matching
        $motorParts = explode(' ', $peminjaman->jenis_motor);
        $motor = Motor::where(function($query) use ($motorParts) {
            $query->where('merk', 'like', '%' . $motorParts[0] . '%');
            if (isset($motorParts[1])) {
                $query->where('model', 'like', '%' . $motorParts[1] . '%');
            }
        })->first();
        
        if (!$motor) return;
        
        // Handle motor status based on peminjaman status changes
        if (in_array($newStatus, ['Confirmed', 'Dikonfirmasi']) && !in_array($oldStatus, ['Confirmed', 'Dikonfirmasi'])) {
            // Motor reserved when booking confirmed
            $motor->update(['status' => 'Disewa']);
        } elseif (in_array($newStatus, ['Disewa', 'Sedang Disewa']) && !in_array($oldStatus, ['Disewa', 'Sedang Disewa'])) {
            // Motor actively rented
            $motor->update(['status' => 'Disewa']);
        } elseif (str_starts_with($newStatus, 'Selesai') && !str_starts_with($oldStatus, 'Selesai')) {
            // Motor returned and available again (including late returns)
            $motor->update(['status' => 'Tersedia']);
        } elseif (in_array($newStatus, ['Cancelled', 'Dibatalkan']) && in_array($oldStatus, ['Confirmed', 'Dikonfirmasi', 'Disewa', 'Sedang Disewa'])) {
            // Booking cancelled, motor becomes available
            $motor->update(['status' => 'Tersedia']);
        }
    }

    private function deleteRelatedFiles($peminjaman)
    {
        // File deletion is no longer needed as files are stored in pengunjung table
        // This method is kept for future use if needed
    }

    private function createBlogFromGaleri($galeri)
    {
        // Blog functionality removed - wisata model no longer exists
        // This method is kept for backward compatibility
    }

    private function updateBlogFromGaleri($galeri)
    {
        // Blog functionality removed - wisata model no longer exists
        // This method is kept for backward compatibility
    }

    private function deleteBlogFromGaleri($galeri)
    {
        // Blog functionality removed - wisata model no longer exists
        // This method is kept for backward compatibility
    }

    // Blog Management
    public function blogIndex(Request $request)
    {
        AuthController::requireAdmin();
        
        $query = \App\Models\Blog::query();
        
        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('judul', 'like', '%' . $search . '%')
                  ->orWhere('isi', 'like', '%' . $search . '%')
                  ->orWhere('penulis', 'like', '%' . $search . '%')
                  ->orWhere('lokasi', 'like', '%' . $search . '%');
            });
        }
        
        $blogs = $query->orderBy('created_at', 'desc')->paginate(10);
        
        return view('admin.blog', compact('blogs'));
    }

    public function blogCreate()
    {
        AuthController::requireAdmin();
        
        return view('admin.blog.create');
    }

    public function blogStore(Request $request)
    {
        AuthController::requireAdmin();

        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'penulis' => 'nullable|string|max:255',
            'lokasi' => 'nullable|string|max:255',
            'published' => 'boolean'
        ]);

        // Handle file upload
        if ($request->hasFile('gambar')) {
            $gambar = $request->file('gambar');
            $gambarName = time() . '_' . $gambar->getClientOriginalName();
            $gambarPath = $gambar->storeAs('blog', $gambarName, 'public');
            $validated['gambar'] = $gambarPath;
        }

        // Add admin ID
        $validated['id_admin'] = AuthController::getCurrentUser()->id;
        
        // Set default penulis if not provided
        if (empty($validated['penulis'])) {
            $validated['penulis'] = AuthController::getCurrentUser()->nama;
        }

        \App\Models\Blog::create($validated);

        return redirect()->route('admin.blog')
            ->with('success', 'Blog berhasil ditambahkan!');
    }

    public function blogEdit($id)
    {
        AuthController::requireAdmin();
        
        $blog = \App\Models\Blog::findOrFail($id);
        
        return view('admin.blog.edit', compact('blog'));
    }

    public function blogUpdate(Request $request, $id)
    {
        AuthController::requireAdmin();
        
        $blog = \App\Models\Blog::findOrFail($id);
        
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'penulis' => 'nullable|string|max:255',
            'lokasi' => 'nullable|string|max:255',
            'published' => 'boolean'
        ]);
        
        // Handle file upload if new image is provided
        if ($request->hasFile('gambar')) {
            // Delete old image
            if ($blog->gambar && Storage::disk('public')->exists($blog->gambar)) {
                Storage::disk('public')->delete($blog->gambar);
            }
            
            $gambar = $request->file('gambar');
            $gambarName = time() . '_' . $gambar->getClientOriginalName();
            $gambarPath = $gambar->storeAs('blog', $gambarName, 'public');
            $validated['gambar'] = $gambarPath;
        }
        
        // Set default penulis if not provided
        if (empty($validated['penulis'])) {
            $validated['penulis'] = AuthController::getCurrentUser()->nama;
        }
        
        $blog->update($validated);
        
        return redirect()->route('admin.blog')
            ->with('success', 'Blog berhasil diupdate!');
    }

    public function blogDestroy($id)
    {
        AuthController::requireAdmin();
        
        $blog = \App\Models\Blog::findOrFail($id);
        
        // Delete image file
        if ($blog->gambar && Storage::disk('public')->exists($blog->gambar)) {
            Storage::disk('public')->delete($blog->gambar);
        }
        
        $blog->delete();
        
        return response()->json(['success' => true, 'message' => 'Blog berhasil dihapus!']);
    }
}