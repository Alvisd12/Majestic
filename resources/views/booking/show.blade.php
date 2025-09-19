@extends('index')

@section('title', 'Booking Details')

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

    .back-btn {
        background: var(--primary-yellow);
        border: none;
        border-radius: 8px;
        padding: 0.625rem 1.25rem;
        color: var(--text-dark);
        font-weight: 600;
        transition: all 0.2s ease;
        text-decoration: none;
    }

    .back-btn:hover {
        background: var(--dark-yellow);
        color: white;
        transform: translateY(-2px);
    }

    .detail-section {
        background: var(--light-blue);
        border-radius: 12px;
        padding: 1.5rem;
        margin: 1.5rem 0;
    }

    .section-title {
        font-size: 1.125rem;
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .section-icon {
        width: 32px;
        height: 32px;
        background: linear-gradient(135deg, var(--primary-blue) 0%, var(--dark-blue) 100%);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 0.875rem;
    }

    .detail-table {
        background: white;
        border-radius: 8px;
        overflow: hidden;
    }

    .detail-row {
        display: flex;
        align-items: center;
        padding: 1rem;
        border-bottom: 1px solid #f3f4f6;
        transition: background-color 0.2s ease;
    }

    .detail-row:last-child {
        border-bottom: none;
    }

    .detail-row:hover {
        background: #f8fafc;
    }

    .detail-label {
        font-weight: 600;
        color: var(--text-light);
        min-width: 140px;
        margin-right: 1rem;
    }

    .detail-value {
        font-weight: 600;
        color: var(--text-dark);
        flex: 1;
    }

    .status-badge {
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-weight: 700;
        font-size: 0.875rem;
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

    .price-highlight {
        font-size: 1.25rem;
        font-weight: 700;
        color: #059669;
    }

    .booking-id {
        font-family: 'Courier New', monospace;
        background: var(--light-yellow);
        color: var(--text-dark);
        padding: 0.25rem 0.5rem;
        border-radius: 6px;
        font-weight: 700;
    }

    .action-section {
        background: var(--light-yellow);
        border-radius: 12px;
        padding: 1.5rem;
        margin-top: 1.5rem;
    }

    .action-buttons {
        display: flex;
        gap: 0.75rem;
        flex-wrap: wrap;
    }

    .btn-action {
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        border: none;
        font-weight: 600;
        transition: all 0.2s ease;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-edit {
        background: var(--primary-yellow);
        color: var(--text-dark);
    }

    .btn-edit:hover {
        background: var(--dark-yellow);
        color: white;
        transform: translateY(-2px);
    }

    .btn-delete {
        background: #ef4444;
        color: white;
    }

    .btn-delete:hover {
        background: #dc2626;
        transform: translateY(-2px);
    }

    .motor-info {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .motor-icon {
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, var(--primary-blue) 0%, var(--dark-blue) 100%);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.125rem;
    }

    .motor-name {
        font-size: 1.125rem;
        font-weight: 700;
        color: var(--text-dark);
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
        
        .detail-section {
            padding: 1rem;
        }
        
        .detail-row {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.5rem;
        }
        
        .detail-label {
            min-width: auto;
            margin-right: 0;
        }
        
        .action-buttons {
            justify-content: center;
        }
        
        .btn-action {
            flex: 1;
            justify-content: center;
        }
    }
</style>

<div class="booking-container">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="main-card">
                    <!-- Header -->
                    <div class="header-section d-flex justify-content-between align-items-center flex-wrap">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-eye me-3" style="font-size: 1.5rem;"></i>
                            <h1 class="page-title">Detail Pesanan</h1>
                        </div>
                        <a href="{{ route('user.bookings') }}" class="back-btn mt-3 mt-md-0">
                            <i class="fas fa-arrow-left me-2"></i>Kembali ke Riwayat
                        </a>
                    </div>
                    
                    <div class="card-body p-4">
                        <!-- Booking Information Section -->
                        <div class="detail-section">
                            <div class="section-title">
                                <div class="section-icon">
                                    <i class="fas fa-info-circle"></i>
                                </div>
                                Informasi Pesanan
                            </div>
                            <div class="detail-table">
                                <div class="detail-row">
                                    <div class="detail-label">ID Pesanan:</div>
                                    <div class="detail-value">
                                        <span class="booking-id">#{{ $peminjaman->id }}</span>
                                    </div>
                                </div>
                                <div class="detail-row">
                                    <div class="detail-label">Pelanggan:</div>
                                    <div class="detail-value">{{ $peminjaman->user->nama ?? 'N/A' }}</div>
                                </div>
                                <div class="detail-row">
                                    <div class="detail-label">Jenis Motor:</div>
                                    <div class="detail-value">
                                        <div class="motor-info">
                                            <div class="motor-icon">
                                                <i class="fas fa-motorcycle"></i>
                                            </div>
                                            <div class="motor-name">{{ $peminjaman->jenis_motor }}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="detail-row">
                                    <div class="detail-label">Tanggal Rental:</div>
                                    <div class="detail-value">{{ \Carbon\Carbon::parse($peminjaman->tanggal_rental)->format('d M Y') }}</div>
                                </div>
                                @if($peminjaman->jam_sewa)
                                <div class="detail-row">
                                    <div class="detail-label">Jam Rental:</div>
                                    <div class="detail-value">{{ $peminjaman->jam_sewa }}</div>
                                </div>
                                @endif
                                <div class="detail-row">
                                    <div class="detail-label">Durasi:</div>
                                    <div class="detail-value">
                                        <span class="badge" style="background: var(--light-yellow); color: var(--text-dark); padding: 0.5rem 1rem; border-radius: 20px; font-weight: 600;">
                                            {{ $peminjaman->durasi_sewa }} hari
                                        </span>
                                    </div>
                                </div>
                                <div class="detail-row">
                                    <div class="detail-label">Dibuat:</div>
                                    <div class="detail-value">{{ $peminjaman->created_at->format('d M Y H:i') }}</div>
                                </div>
                                @if($peminjaman->tanggal_kembali)
                                <div class="detail-row">
                                    <div class="detail-label">Tanggal Kembali:</div>
                                    <div class="detail-value">{{ \Carbon\Carbon::parse($peminjaman->tanggal_kembali)->format('d M Y') }}</div>
                                </div>
                                @endif
                            </div>
                        </div>

                        <!-- Status & Payment Section -->
                        <div class="detail-section">
                            <div class="section-title">
                                <div class="section-icon">
                                    <i class="fas fa-credit-card"></i>
                                </div>
                                Status & Pembayaran
                            </div>
                            <div class="detail-table">
                                <div class="detail-row">
                                    <div class="detail-label">Status:</div>
                                    <div class="detail-value">
                                        @php
                                            $statusConfig = match($peminjaman->status) {
                                                'Pending' => ['class' => 'status-pending', 'text' => 'Pending'],
                                                'Confirmed' => ['class' => 'status-confirmed', 'text' => 'Confirmed'],
                                                'Disewa' => ['class' => 'status-disewa', 'text' => 'Disewa'],
                                                'Selesai' => ['class' => 'status-selesai', 'text' => 'Selesai'],
                                                'Cancelled' => ['class' => 'status-cancelled', 'text' => 'Cancelled'],
                                                default => ['class' => 'status-pending', 'text' => $peminjaman->status]
                                            };
                                        @endphp
                                        <span class="status-badge {{ $statusConfig['class'] }}">
                                            {{ $statusConfig['text'] }}
                                        </span>
                                    </div>
                                </div>
                                <div class="detail-row">
                                    <div class="detail-label">Total Biaya:</div>
                                    <div class="detail-value price-highlight">
                                        Rp {{ number_format($peminjaman->total_harga, 0, ',', '.') }}
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection