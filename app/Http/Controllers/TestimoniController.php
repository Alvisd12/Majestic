<?php

namespace App\Http\Controllers;

use App\Models\Testimoni;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class TestimoniController extends Controller
{
    public function index()
    {
        $testimoni = Testimoni::where('is_approved', true)->latest()->get();
        
        return view('testimoni.index', compact('testimoni'));
    }

    public function getApproved()
    {
        $testimoni = Testimoni::approved()
            ->latest()
            ->get()
            ->map(function($item) {
                return [
                    'id' => $item->id,
                    'nama' => $item->nama,
                    'testimoni' => $item->testimoni_text,
                    'rating' => $item->rating,
                    'created_at' => $item->created_at->format('d F Y')
                ];
            });
        
        return response()->json($testimoni);
    }
    
    public function show($id)
    {
        AuthController::requireAuth();
        
        $testimoni = Testimoni::findOrFail($id);
        
        return view('testimoni.show', compact('testimoni'));
    }

    public function create($booking_id)
    {
        // Check if user is logged in using session
        if (!session('is_logged_in')) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Get booking details
        $booking = \App\Models\Peminjaman::where('id', $booking_id)
            ->where('user_id', session('user_id'))
            ->where(function($q) {
                $q->where('status', 'Selesai')
                  ->orWhere('status', 'like', 'Selesai (Telat%');
            })
            ->firstOrFail();

        return view('testimoni.create', compact('booking'));
    }

    public function store(Request $request)
    {
        // Check if user is logged in
        if (!session('is_logged_in') || !session('user_id')) {
            return response()->json([
                'success' => false,
                'message' => 'Anda harus login terlebih dahulu untuk memberikan testimoni.'
            ], 401);
        }

        $userId = session('user_id');

        $request->validate([
            'testimoni' => 'required|string|min:10',
            'rating' => 'required|integer|min:1|max:5',
            'peminjaman_id' => 'required|exists:peminjaman,id'
        ]);

        // Verify that the peminjaman belongs to the user and is completed
        $peminjaman = \App\Models\Peminjaman::where('id', $request->peminjaman_id)
            ->where('user_id', $userId)
            ->where(function($q) {
                $q->where('status', 'Selesai')
                  ->orWhere('status', 'like', 'Selesai (Telat%');
            })
            ->first();

        if (!$peminjaman) {
            return response()->json([
                'success' => false,
                'message' => 'Peminjaman tidak ditemukan atau belum selesai.'
            ], 404);
        }

        // Check if user already submitted testimonial for this rental
        $existingTestimoni = Testimoni::where('id_pengunjung', $userId)
            ->where('peminjaman_id', $request->peminjaman_id)
            ->first();
        
        if ($existingTestimoni) {
            return response()->json([
                'success' => false,
                'message' => 'Anda sudah memberikan testimoni untuk peminjaman ini.'
            ], 409);
        }

        // Get user name from pengunjung table
        $pengunjung = \App\Models\Pengunjung::find($userId);
        if (!$pengunjung) {
            return response()->json([
                'success' => false,
                'message' => 'Data pengguna tidak ditemukan.'
            ], 404);
        }

        $testimoni = Testimoni::create([
            'id_pengunjung' => $userId,
            'peminjaman_id' => $request->peminjaman_id,
            'nama' => $pengunjung->nama,
            'testimoni' => $request->testimoni,
            'pesan' => $request->testimoni, // For backward compatibility
            'rating' => $request->rating,
            'is_approved' => false,
            'approved' => false // For backward compatibility
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Testimoni berhasil dikirim dan akan ditinjau oleh admin.',
            'data' => $testimoni
        ]);
    }

    public function storePublic(Request $request)
    {
        return $this->store($request);
    }

    public function checkEligibility()
    {
        // Check if user is logged in
        if (!session('is_logged_in') || !session('user_id')) {
            return response()->json([
                'eligible' => false,
                'is_logged_in' => false,
                'message' => 'Anda harus login terlebih dahulu untuk memberikan testimoni.'
            ]);
        }

        $userId = session('user_id');

        // Get all completed rentals for the user
        $completedRentals = \App\Models\Peminjaman::where('user_id', $userId)
            ->where(function($q) {
                $q->where('status', 'Selesai')
                  ->orWhere('status', 'like', 'Selesai (Telat%');
            })
            ->with('motor')
            ->get();

        if ($completedRentals->isEmpty()) {
            return response()->json([
                'eligible' => false,
                'is_logged_in' => true,
                'has_completed_rental' => false,
                'message' => 'Anda hanya dapat memberikan testimoni setelah menyelesaikan penyewaan motor.'
            ]);
        }

        // Get existing testimonials for this user
        $existingTestimoniIds = Testimoni::where('id_pengunjung', $userId)
            ->pluck('peminjaman_id')
            ->toArray();

        // Filter rentals that don't have testimonials yet
        $availableRentals = $completedRentals->filter(function($rental) use ($existingTestimoniIds) {
            return !in_array($rental->id, $existingTestimoniIds);
        });

        if ($availableRentals->isEmpty()) {
            $totalTestimoni = count($existingTestimoniIds);
            return response()->json([
                'eligible' => false,
                'is_logged_in' => true,
                'has_completed_rental' => true,
                'message' => "Anda sudah memberikan testimoni untuk semua peminjaman yang telah selesai ($totalTestimoni testimoni)."
            ]);
        }

        // Get user name
        $pengunjung = \App\Models\Pengunjung::find($userId);
        
        // Format available rentals for frontend
        $availableRentalsData = $availableRentals->map(function($rental) {
            return [
                'id' => $rental->id,
                'motor_name' => $rental->motor->full_name ?? 'Motor',
                'tanggal_sewa' => $rental->tanggal_sewa,
                'tanggal_kembali' => $rental->tanggal_kembali,
                'formatted_date' => date('d F Y', strtotime($rental->tanggal_sewa))
            ];
        })->values();
        
        return response()->json([
            'eligible' => true,
            'is_logged_in' => true,
            'has_completed_rental' => true,
            'user_name' => $pengunjung ? $pengunjung->nama : 'Pengguna',
            'available_rentals' => $availableRentalsData,
            'total_available' => $availableRentals->count(),
            'total_completed' => count($existingTestimoniIds)
        ]);
    }
}
