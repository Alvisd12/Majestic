@extends('index')

@section('content')
<style>
    :root {
        --primary-blue: #3b82f6;
        --primary-yellow: #fbbf24;
        --light-blue: #dbeafe;
        --white: #ffffff;
        --light-yellow: #fef3c7;
        --dark-blue: #1e40af;
        --dark-yellow: #d97706;
        --text-dark: #1f2937;
        --text-light: #6b7280;
    }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background: #f8fafc;
        }

        .booking-container {
            background: linear-gradient(135deg, var(--white) 0%, #ffffff 100%);
            min-height: 100vh;
            padding: 2rem 0;
        }

        .main-card {
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(59, 130, 246, 0.1);
            border: none;
            background: white;
        }

        .header-section {
            background: linear-gradient(135deg, var(--primary-blue) 0%, var(--dark-blue) 100%);
            border-radius: 16px 16px 0 0;
            padding: 1.5rem;
        }

        .page-title {
            font-size: 1.75rem;
            font-weight: 700;
            color: white;
            margin: 0;
        }

        .new-booking-btn {
            background: var(--primary-yellow);
            border: none;
            border-radius: 8px;
            padding: 0.625rem 1.25rem;
            color: var(--text-dark);
            font-weight: 600;
            transition: all 0.2s ease;
            text-decoration: none;
        }

        .new-booking-btn:hover {
            background: var(--dark-yellow);
            color: white;
            transform: translateY(-2px);
        }

        .search-container {
            background: var(--light-blue);
            border-radius: 12px;
            padding: 1.5rem;
            margin: 1.5rem 0;
        }

        .search-input, .status-filter {
            border: 2px solid transparent;
            border-radius: 8px;
            padding: 0.625rem 1rem;
            background: white;
            transition: all 0.2s ease;
        }

        .search-input:focus, .status-filter:focus {
            border-color: var(--primary-blue);
            box-shadow: 0 0 0 0.125rem rgba(59, 130, 246, 0.15);
            outline: none;
        }

        .search-btn {
            background: var(--primary-blue);
            border: none;
            border-radius: 8px;
            padding: 0.625rem 1.25rem;
            color: white;
            font-weight: 600;
            transition: all 0.2s ease;
        }

        .search-btn:hover {
            background: var(--dark-blue);
        }

        .bookings-table {
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid #e5e7eb;
        }

        .table-head {
            background: var(--light-yellow);
            font-weight: 600;
            color: var(--text-dark);
            font-size: 0.875rem;
        }

        .booking-row {
            transition: background-color 0.2s ease;
            border-bottom: 1px solid #f3f4f6;
        }

        .booking-row:hover {
            background: #f8fafc;
        }

        .bike-info {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .bike-icon {
            width: 36px;
            height: 36px;
            background: linear-gradient(135deg, var(--primary-blue) 0%, var(--dark-blue) 100%);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1rem;
        }

        .status-badge {
            padding: 0.375rem 0.75rem;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.025em;
        }

        .status-pending {
            background: var(--primary-yellow);
            color: var(--text-dark);
        }

        .status-confirmed {
            background: var(--primary-blue);
            color: white;
        }

        .status-disewa {
            background: #8b5cf6;
            color: white;
        }

        .status-selesai {
            background: #10b981;
            color: white;
        }

        .status-cancelled {
            background: #ef4444;
            color: white;
        }

        .action-buttons {
            display: flex;
            gap: 0.375rem;
        }

        .btn-action {
            width: 32px;
            height: 32px;
            border-radius: 6px;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
            font-size: 0.875rem;
            text-decoration: none;
        }

        .btn-view {
            background: var(--primary-blue);
            color: white;
        }

        .btn-edit {
            background: var(--primary-yellow);
            color: var(--text-dark);
        }

        .btn-delete {
            background: #ef4444;
            color: white;
        }

        .btn-receipt {
            background: #10b981;
            color: white;
        }

        .btn-action:hover {
            transform: translateY(-1px);
        }

        .empty-state {
            text-align: center;
            padding: 3rem;
            background: var(--light-blue);
            border-radius: 12px;
            margin: 2rem 0;
        }

        .empty-icon {
            font-size: 3rem;
            color: var(--primary-blue);
            margin-bottom: 1rem;
            opacity: 0.7;
        }

        .price-display {
            font-weight: 700;
            color: #059669;
            font-size: 1rem;
        }

        .duration-badge {
            background: var(--light-yellow);
            color: var(--text-dark);
            padding: 0.25rem 0.5rem;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .header-section {
                padding: 1rem;
                text-align: center;
            }
            
            .page-title {
                font-size: 1.5rem;
                margin-bottom: 1rem;
            }
            
            .search-container {
                padding: 1rem;
            }
            
            .bike-info {
                flex-direction: column;
                text-align: center;
                gap: 0.5rem;
            }
            
            .action-buttons {
                justify-content: center;
            }
            
            .table-responsive {
                font-size: 0.875rem;
            }
        }

        /* Custom scrollbar for table */
        .table-responsive::-webkit-scrollbar {
            height: 6px;
        }

        .table-responsive::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 3px;
        }

        .table-responsive::-webkit-scrollbar-thumb {
            background: var(--primary-blue);
            border-radius: 3px;
        }
</style>

<div class="booking-container">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="main-card">
                    <!-- Header -->
                    <div class="header-section d-flex justify-content-between align-items-center flex-wrap">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-history me-3" style="font-size: 1.5rem;"></i>
                            <h1 class="page-title">Riwayat Pesanan</h1>
                        </div>
                        <a href="{{ route('peminjaman.create') }}" class="new-booking-btn mt-3 mt-md-0">
                            <i class="fas fa-plus me-2"></i>Pesanan Baru
                        </a>
                    </div>
                    
                    <div class="card-body p-4">
                        <!-- Search Section -->
                        <div class="search-container">
                            <form method="GET" action="{{ route('user.bookings') }}">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <input type="text" class="search-input form-control" name="search"
                                               placeholder="Cari jenis motor atau status..." 
                                               value="{{ request('search') }}">
                                    </div>
                                    <div class="col-md-4">
                                        <select class="status-filter form-select" name="status">
                                            <option value="">Semua Status</option>
                                            <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="Confirmed" {{ request('status') == 'Confirmed' ? 'selected' : '' }}>Confirmed</option>
                                            <option value="Disewa" {{ request('status') == 'Disewa' ? 'selected' : '' }}>Disewa</option>
                                            <option value="Selesai" {{ request('status') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                                            <option value="Cancelled" {{ request('status') == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="submit" class="search-btn btn w-100">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        @if($bookings->count() > 0)
                            <div class="bookings-table">
                                <div class="table-responsive">
                                    <table class="table table-borderless mb-0">
                                        <thead class="table-head">
                                            <tr>
                                                <th class="px-3 py-3">#</th>
                                                <th class="px-3 py-3">Jenis Motor</th>
                                                <th class="px-3 py-3">Tanggal</th>
                                                <th class="px-3 py-3">Durasi</th>
                                                <th class="px-3 py-3">Pengambilan</th>
                                                <th class="px-3 py-3">Total</th>
                                                <th class="px-3 py-3">Status</th>
                                                <th class="px-3 py-3">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($bookings as $index => $booking)
                                                <tr class="booking-row">
                                                    <td class="px-3 py-3">
                                                        <span class="fw-bold text-primary">#{{ $bookings->firstItem() + $index }}</span>
                                                    </td>
                                                    <td class="px-3 py-3">
                                                        <div class="bike-info">
                                                            <div class="bike-icon">
                                                                <i class="fas fa-motorcycle"></i>
                                                            </div>
                                                            <div>
                                                                <div class="fw-bold">{{ $booking->jenis_motor }}</div>
                                                                @if($booking->jam_sewa)
                                                                    <small class="text-muted">{{ $booking->jam_sewa }}</small>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="px-3 py-3">
                                                        <div class="fw-semibold">{{ \Carbon\Carbon::parse($booking->tanggal_rental)->format('d M Y') }}</div>
                                                        <small class="text-muted">{{ \Carbon\Carbon::parse($booking->tanggal_rental)->format('D') }}</small>
                                                    </td>
                                                    <td class="px-3 py-3">
                                                        <span class="duration-badge">
                                                            {{ $booking->durasi_sewa }} hari
                                                        </span>
                                                    </td>
                                                    <td class="px-3 py-3">
                                                        @if($booking->pilihan_pengambilan)
                                                            <div>
                                                                <span class="badge" style="background: #e0e7ff; color: #3730a3; padding: 0.25rem 0.5rem; border-radius: 12px; font-size: 0.75rem; font-weight: 600;">
                                                                    <i class="fas fa-{{ $booking->pilihan_pengambilan == 'diantar' ? 'truck' : 'map-marker-alt' }} me-1"></i>
                                                                    {{ ucfirst($booking->pilihan_pengambilan) }}
                                                                </span>
                                                                @if($booking->pilihan_pengambilan == 'diantar' && $booking->alamat_pengiriman)
                                                                    <br><small class="text-muted mt-1 d-block" style="font-size: 0.7rem; margin-top: 4px;">
                                                                        <i class="fas fa-map-marker-alt me-1"></i>
                                                                        {{ Str::limit($booking->alamat_pengiriman, 40) }}
                                                                    </small>
                                                                @endif
                                                            </div>
                                                        @else
                                                            <span class="text-muted">-</span>
                                                        @endif
                                                    </td>
                                                    <td class="px-3 py-3">
                                                        <div class="price-display">Rp {{ number_format($booking->total_harga, 0, ',', '.') }}</div>
                                                    </td>
                                                    <td class="px-3 py-3">
                                                        @php
                                                            $statusConfig = match($booking->status) {
                                                                'Pending' => ['class' => 'status-pending', 'text' => 'Pending'],
                                                                'Confirmed' => ['class' => 'status-confirmed', 'text' => 'Confirmed'],
                                                                'Disewa' => ['class' => 'status-disewa', 'text' => 'Disewa'],
                                                                'Selesai' => ['class' => 'status-selesai', 'text' => 'Selesai'],
                                                                'Cancelled' => ['class' => 'status-cancelled', 'text' => 'Cancelled'],
                                                                default => ['class' => 'status-pending', 'text' => $booking->status]
                                                            };
                                                        @endphp
                                                        <span class="status-badge {{ $statusConfig['class'] }}">
                                                            {{ $statusConfig['text'] }}
                                                        </span>
                                                    </td>
                                                    <td class="px-3 py-3">
                                                        <div class="action-buttons">
                                                            <a href="{{ route('peminjaman.show', $booking->id) }}" class="btn-action btn-view" title="Lihat Detail">
                                                                <i class="fas fa-eye"></i>
                                                            </a>
                                                            @if(in_array($booking->status, ['Pending', 'Confirmed']))
                                                                <a href="{{ route('peminjaman.edit', $booking->id) }}" class="btn-action btn-edit" title="Edit">
                                                                    <i class="fas fa-edit"></i>
                                                                </a>
                                                            @endif
                                                            @if(in_array($booking->status, ['Selesai', 'Dikonfirmasi']))
                                                                <a href="{{ route('peminjaman.print', $booking->id) }}" class="btn-action btn-receipt" title="Cetak Struk">
                                                                    <i class="fas fa-receipt"></i>
                                                                </a>
                                                            @endif
                                                            @if(in_array($booking->status, ['Pending', 'Cancelled']))
                                                                <form action="{{ route('peminjaman.destroy', $booking->id) }}" 
                                                                      method="POST" class="d-inline"
                                                                      onsubmit="return confirm('Yakin ingin menghapus pesanan ini?')">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn-action btn-delete" title="Hapus">
                                                                        <i class="fas fa-trash"></i>
                                                                    </button>
                                                                </form>
                                                            @endif
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Pagination -->
                            <div class="d-flex justify-content-center mt-4">
                                {{ $bookings->appends(request()->query())->links('pagination::bootstrap-4') }}
                            </div>
                        @else
                            <div class="empty-state">
                                <div class="empty-icon">
                                    <i class="fas fa-motorcycle"></i>
                                </div>
                                <h3 class="text-muted mb-3">Belum Ada Pesanan</h3>
                                <p class="text-muted mb-4">Anda belum memiliki riwayat pesanan motor. Mulai petualangan Anda hari ini!</p>
                                <a href="{{ route('peminjaman.create') }}" class="new-booking-btn">
                                    <i class="fas fa-plus me-2"></i>Buat Pesanan Pertama
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
