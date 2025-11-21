@extends('layouts.admin')

@section('title', 'Dashboard')

@php
    $pageTitle = 'Dashboard';
    $status = request('status');
    switch($status) {
        case 'Pending':
            $pageTitle = 'Pesanan - Menunggu Konfirmasi';
            break;
        case 'Disewa':
            $pageTitle = 'Pesanan - Disewa';
            break;
        case 'Selesai':
            $pageTitle = 'Pesanan - Dikembalikan';
            break;
    }
@endphp

@section('page-title', $pageTitle)

@section('content')
    <!-- Status Update Notification -->
    @if(session('status_updated'))
        <div class="alert alert-info alert-dismissible fade show mb-4" role="alert">
            <i class="fas fa-sync-alt me-2"></i>
            <strong>Status Update:</strong> {{ session('status_updated') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Status Filter Indicator -->
    @if(request('status'))
        <div class="alert alert-info alert-dismissible fade show mb-4" role="alert">
            <i class="fas fa-filter me-2"></i>
            Menampilkan pesanan dengan status: 
            <strong>
                @switch(request('status'))
                    @case('Disewa')
                        Disewa (Aktif & Terlambat)
                        @break
                    @case('Selesai')
                        Selesai (Normal & Telat)
                        @break
                    @default
                        {{ request('status') }}
                @endswitch
            </strong>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-outline-info ms-2">
                <i class="fas fa-times me-1"></i>Hapus Filter
            </a>
        </div>
    @endif

    <!-- Statistics Cards -->
    <div class="row mb-5">
        <div class="col-xl-3 col-lg-6 col-md-6 mb-4">
            <div class="stats-card stats-card-primary">
                <div class="stats-card-body">
                    <div class="stats-icon">
                        <i class="fas fa-clipboard-list"></i>
                    </div>
                    <div class="stats-content">
                        <div class="stats-number">{{ $totalPeminjaman ?? 0 }}</div>
                        <div class="stats-label">Total Peminjaman</div>
                        <div class="stats-trend">
                            <i class="fas fa-arrow-up"></i>
                            <span>+12%</span>
                        </div>
                    </div>
                </div>
                <div class="stats-card-footer">
                    <small class="text-white-50">Dari bulan lalu</small>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 mb-4">
            <div class="stats-card stats-card-success">
                <div class="stats-card-body">
                    <div class="stats-icon">
                        <i class="fas fa-motorcycle"></i>
                    </div>
                    <div class="stats-content">
                        <div class="stats-number">{{ $motorTersedia ?? 0 }}</div>
                        <div class="stats-label">Motor Tersedia</div>
                        <div class="stats-trend">
                            <i class="fas fa-arrow-up"></i>
                            <span>+5%</span>
                        </div>
                    </div>
                </div>
                <div class="stats-card-footer">
                    <small class="text-white-50">Siap disewakan</small>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 mb-4">
            <div class="stats-card stats-card-warning">
                <div class="stats-card-body">
                    <div class="stats-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="stats-content">
                        <div class="stats-number">{{ $peminjamanAktif ?? 0 }}</div>
                        <div class="stats-label">Peminjaman Aktif</div>
                        <div class="stats-trend">
                            <i class="fas fa-arrow-down"></i>
                            <span>-3%</span>
                        </div>
                    </div>
                </div>
                <div class="stats-card-footer">
                    <small class="text-white-50">Sedang berlangsung</small>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 mb-4">
            <div class="stats-card stats-card-info">
                <div class="stats-card-body">
                    <div class="stats-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stats-content">
                        <div class="stats-number">{{ $totalPengunjung ?? 0 }}</div>
                        <div class="stats-label">Total Pengunjung</div>
                        <div class="stats-trend">
                            <i class="fas fa-arrow-up"></i>
                            <span>+8%</span>
                        </div>
                    </div>
                </div>
                <div class="stats-card-footer">
                    <small class="text-white-50">Pengguna terdaftar</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Search Box -->
    <div class="row mb-4">
        <div class="col-lg-8 col-md-6">
            <form method="GET" action="{{ route('admin.dashboard') }}">
                <div class="modern-search-box">
                    <div class="search-input-wrapper">
                        <i class="fas fa-search search-icon"></i>
                        <input type="text" class="form-control search-input" name="search" 
                               placeholder="Cari peminjaman, nama penyewa, atau jenis motor..." 
                               value="{{ request('search') }}">
                        @if(request('search'))
                            <button type="button" class="clear-search" onclick="window.location.href='{{ route(';admin.dashboard;') }}'">
                                <i class="fas fa-times"></i>
                            </button>
                        @endif
                    </div>
                </div>
            </form>
        </div>
        <div class="col-lg-4 col-md-6">
            <div class="d-flex justify-content-end gap-2">
                <div class="dropdown">
                    <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <i class="fas fa-filter me-2"></i>Filter Status
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">Semua Status</a></li>
                        <li><a class="dropdown-item" href="{{ route('admin.dashboard', ['status' => 'Menunggu Konfirmasi']) }}">Menunggu Konfirmasi</a></li>
                        <li><a class="dropdown-item" href="{{ route('admin.dashboard', ['status' => 'Dikonfirmasi']) }}">Dikonfirmasi</a></li>
                        <li><a class="dropdown-item" href="{{ route('admin.dashboard', ['status' => 'Disewa']) }}">Disewa (Aktif & Terlambat)</a></li>
                        <li><a class="dropdown-item" href="{{ route('admin.dashboard', ['status' => 'Selesai']) }}">Selesai (Normal & Telat)</a></li>
                        <li><a class="dropdown-item" href="{{ route('admin.dashboard', ['status' => 'Dibatalkan']) }}">Dibatalkan</a></li>
                    </ul>
                </div>
                <button class="btn btn-primary" onclick="window.location.reload()">
                    <i class="fas fa-sync-alt me-2"></i>Refresh
                </button>
            </div>
        </div>
    </div>

    <!-- Data Peminjaman Terbaru -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="modern-table-card">
                <div class="table-card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <div class="table-icon">
                                <i class="fas fa-list"></i>
                            </div>
                            <div>
                                <h5 class="table-title mb-0">Data Peminjaman Terbaru</h5>
                                <small class="table-subtitle">Kelola dan pantau semua peminjaman</small>
                            </div>
                        </div>
                        <div class="d-flex align-items-center gap-3">
                            <div class="table-stats">
                                <span class="stats-badge">{{ $recentRentals->total() ?? 0 }} Total</span>
                            </div>
                            <small class="text-muted">{{ now()->format('d M Y, H:i') }}</small>
                        </div>
                    </div>
                </div>
                <div class="table-card-body">
                    <div class="modern-table-responsive">
                        <table class="modern-table">
                            <thead>
                                <tr>
                                    <th class="table-header-cell">
                                        <div class="header-content">
                                            <span>#</span>
                                        </div>
                                    </th>
                                    <th class="table-header-cell">
                                        <div class="header-content">
                                            <span>Penyewa</span>
                                        </div>
                                    </th>
                                    <th class="table-header-cell">
                                        <div class="header-content">
                                            <span>Motor & Durasi</span>
                                        </div>
                                    </th>
                                    <th class="table-header-cell">
                                        <div class="header-content">
                                            <span>Tanggal Sewa</span>
                                        </div>
                                    </th>
                                    <th class="table-header-cell">
                                        <div class="header-content">
                                            <span>Status</span>
                                        </div>
                                    </th>
                                    <th class="table-header-cell">
                                        <div class="header-content">
                                            <span>Total Harga</span>
                                        </div>
                                    </th>
                                    <th class="table-header-cell">
                                        <div class="header-content">
                                            <span>Denda</span>
                                        </div>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentRentals as $index => $rental)
                                <tr class="table-row">
                                    <td class="table-cell">
                                        <div class="row-number">
                                            {{ ($recentRentals->currentPage() - 1) * $recentRentals->perPage() + $index + 1 }}
                                        </div>
                                    </td>
                                    <td class="table-cell">
                                        <div class="user-info">
                                            <div class="user-details">
                                                <div class="user-name">
                                                    <i class="fas fa-user me-1"></i>
                                                    {{ $rental->user->nama ?? $rental->nama ?? 'N/A' }}
                                                </div>
                                                @if($rental->user->no_handphone ?? $rental->no_handphone)
                                                    <div class="user-phone">{{ $rental->user->no_handphone ?? $rental->no_handphone }}</div>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="table-cell">
                                        <div class="motor-info">
                                            <div class="motor-name">{{ $rental->jenis_motor ?? 'N/A' }}</div>
                                            <div class="motor-duration">
                                                {{ $rental->durasi_sewa ?? 1 }} hari
                                            </div>
                                        </div>
                                    </td>
                                    <td class="table-cell">
                                        <div class="date-info">
                                            <div class="rental-date">{{ $rental->tanggal_rental ? $rental->tanggal_rental->format('d M Y') : 'N/A' }}</div>
                                            <div class="relative-time">{{ $rental->created_at ? $rental->created_at->diffForHumans() : 'N/A' }}</div>
                                        </div>
                                    </td>
                                    <td class="table-cell">
                                        @php
                                            $status = $rental->status ?? 'Menunggu Konfirmasi';
                                            $statusConfig = match(true) {
                                                $status === 'Menunggu Konfirmasi' => ['class' => 'status-warning', 'text' => 'Menunggu Konfirmasi'],
                                                $status === 'Dikonfirmasi' => ['class' => 'status-info', 'text' => 'Dikonfirmasi'],
                                                $status === 'Selesai' => ['class' => 'status-success', 'text' => 'Selesai'],
                                                str_starts_with($status, 'Selesai (Telat') => ['class' => 'status-warning', 'text' => $status],
                                                $status === 'Dibatalkan' => ['class' => 'status-danger', 'text' => 'Dibatalkan'],
                                                str_starts_with($status, 'Terlambat') => ['class' => 'status-danger', 'text' => $status],
                                                default => ['class' => 'status-secondary', 'text' => $status]
                                            };
                                        @endphp
                                        <div class="status-badge {{ $statusConfig['class'] }}">
                                            <span>{{ $statusConfig['text'] }}</span>
                                        </div>
                                    </td>
                                    <td class="table-cell">
                                        <div class="price-info">
                                            <div class="price-amount">Rp {{ number_format($rental->total_harga ?? 0, 0, ',', '.') }}</div>
                                        </div>
                                    </td>
                                    <td class="table-cell">
                                        <div class="penalty-info">
                                            @if(str_starts_with($rental->status, 'Terlambat') || str_starts_with($rental->status, 'Selesai (Telat'))
                                                @if($rental->denda > 0)
                                                    <div class="penalty-amount text-danger fw-bold">
                                                        Rp {{ number_format($rental->denda, 0, ',', '.') }}
                                                    </div>
                                                    @php
                                                        $lateDays = 0;
                                                        if(str_starts_with($rental->status, 'Terlambat') && preg_match('/Terlambat (\d+) hari/', $rental->status, $matches)) {
                                                            $lateDays = $matches[1];
                                                        } elseif(str_starts_with($rental->status, 'Selesai (Telat') && preg_match('/Telat (\d+) hari/', $rental->status, $matches)) {
                                                            $lateDays = $matches[1];
                                                        }
                                                    @endphp
                                                    @if($lateDays > 0)
                                                        <div class="penalty-days text-muted small">
                                                            {{ $lateDays }} hari terlambat
                                                        </div>
                                                    @endif
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr class="empty-row">
                                    <td colspan="7" class="text-center py-5">
                                        <div class="empty-state">
                                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                            <h5 class="text-muted">Tidak ada data peminjaman</h5>
                                            <p class="text-muted">
                                                @if(request('search') || request('status') || request('tanggal_mulai') || request('tanggal_akhir'))
                                                    Tidak ada data yang sesuai dengan filter yang dipilih.
                                                @else
                                                    Belum ada data peminjaman yang tersedia.
                                                @endif
                                            </p>
                                            @if(request('search') || request('status') || request('tanggal_mulai') || request('tanggal_akhir'))
                                                <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-primary btn-sm">
                                                    <i class="fas fa-times me-1"></i>
                                                    Hapus Filter
                                                </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    @if(isset($recentRentals) && $recentRentals->hasPages())
                    <div class="d-flex justify-content-center mt-4">
                        <nav aria-label="Pagination Navigation">
                            {{ $recentRentals->appends(request()->query())->links('pagination::bootstrap-4') }}
                        </nav>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('additional-scripts')
<script src="{{ asset('js/dashboard.js') }}"></script>

<style>
/* Modern Dashboard Styles */
:root {
    --gradient-primary: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%); /* Blue */
    --gradient-success: linear-gradient(135deg, #f59e0b 0%, #f59e0b 100%); /* Cyan to Blue */
    --gradient-warning: linear-gradient(135deg, #1d4ed8 0%, #1d4ed8 100%); /* Yellow */
    --gradient-info: linear-gradient(135deg, #f59e0b 0%, #f59e0b  100%); /* Light Blue */
    --shadow-soft: 0 10px 25px rgba(0, 0, 0, 0.1);
    --shadow-hover: 0 15px 35px rgba(0, 0, 0, 0.15);
    --border-radius: 16px;
    --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

/* Statistics Cards */
.stats-card {
    background: white;
    border-radius: var(--border-radius);
    box-shadow: var(--shadow-soft);
    overflow: hidden;
    transition: var(--transition);
    position: relative;
    border: none;
}

.stats-card:hover {
    transform: translateY(-8px);
    box-shadow: var(--shadow-hover);
}

.stats-card-primary {
    background: var(--gradient-primary);
    color: white;
}

.stats-card-success {
    background: var(--gradient-success);
    color: white;
}

.stats-card-warning {
    background: var(--gradient-warning);
    color: white;
}

.stats-card-info {
    background: var(--gradient-info);
    color: white;
}

.stats-card-body {
    padding: 2rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.stats-icon {
    width: 70px;
    height: 70px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
    backdrop-filter: blur(10px);
}

.stats-content {
    text-align: right;
    flex: 1;
    margin-left: 1.5rem;
}

.stats-number {
    font-size: 2.5rem;
    font-weight: 700;
    line-height: 1;
    margin-bottom: 0.5rem;
}

.stats-label {
    font-size: 0.95rem;
    opacity: 0.9;
    margin-bottom: 0.75rem;
}

.stats-trend {
    display: flex;
    align-items: center;
    justify-content: flex-end;
    gap: 0.5rem;
    font-size: 0.85rem;
    opacity: 0.8;
}

.stats-card-footer {
    padding: 1rem 2rem;
    background: rgba(0, 0, 0, 0.1);
    backdrop-filter: blur(10px);
}

/* Modern Search Box */
.modern-search-box {
    margin-bottom: 2rem;
}

.search-input-wrapper {
    position: relative;
    display: flex;
    align-items: center;
}

.search-icon {
    position: absolute;
    left: 1.25rem;
    color: #6b7280;
    z-index: 2;
    font-size: 1.1rem;
}

.search-input {
    padding: 1rem 1rem 1rem 3.5rem;
    border: 2px solid #e5e7eb;
    border-radius: 12px;
    font-size: 1rem;
    transition: var(--transition);
    background: white;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
}

.search-input:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
    outline: none;
}

.clear-search {
    position: absolute;
    right: 1rem;
    background: #ef4444;
    color: white;
    border: none;
    width: 28px;
    height: 28px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.75rem;
    transition: var(--transition);
}

.clear-search:hover {
    background: #dc2626;
    transform: scale(1.1);
}

/* Modern Table Card */
.modern-table-card {
    background: white;
    border-radius: var(--border-radius);
    box-shadow: var(--shadow-soft);
    overflow: hidden;
    border: none;
}

.table-card-header {
    background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%); /* Light blue */
    padding: 2rem;
    border-bottom: 1px solid #bfdbfe;
}

.table-icon {
    width: 50px;
    height: 50px;
    background: linear-gradient(135deg, #2563eb 0%, #fbbf24 100%); /* Blue to Yellow */
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.25rem;
    margin-right: 1rem;
}

.table-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: #1f2937;
    margin: 0;
}

.table-subtitle {
    color: #6b7280;
    font-size: 0.9rem;
}

.stats-badge {
    background: linear-gradient(135deg, #2563eb 0%, #fbbf24 100%); /* Blue to Yellow */
    color: #0b1324;
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.85rem;
    font-weight: 700;
}

.table-card-body {
    padding: 0;
}

/* Modern Table */
.modern-table-responsive {
    overflow-x: auto;
}

.modern-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
}

.table-header-cell {
    background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
    padding: 1.5rem 1.25rem;
    border-bottom: 2px solid #bfdbfe;
    font-weight: 700;
    color: #0b1324;
    font-size: 0.9rem;
    text-align: left;
}

/* Sticky table header */
.modern-table thead th {
    position: sticky;
    top: 0;
    z-index: 1;
}

.modern-table thead th:first-child {
    border-top-left-radius: 12px;
}

.modern-table thead th:last-child {
    border-top-right-radius: 12px;
}

.header-content {
    display: flex;
    align-items: center;
}

.table-row {
    transition: var(--transition);
    border-bottom: 1px solid #f1f5f9;
}

.table-row:hover {
    background: linear-gradient(135deg, #fffbea 0%, #fef3c7 100%); /* Light yellow */
    transform: scale(1.01);
}

.table-cell {
    padding: 1.5rem 1.25rem;
    vertical-align: middle;
    border-bottom: 1px solid #f1f5f9;
}

.row-number {
    width: 35px;
    height: 35px;
    background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%); /* Light blue */
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    color: #1e3a8a;
    font-size: 0.9rem;
}

/* User Info */
.user-info {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.user-avatar-wrapper {
    position: relative;
}

.user-avatar-img {
    width: 45px;
    height: 45px;
    border-radius: 12px;
    object-fit: cover;
    border: 2px solid #e2e8f0;
}

.user-avatar-placeholder {
    width: 45px;
    height: 45px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.1rem;
}

.user-name {
    font-weight: 600;
    color: #1f2937;
    font-size: 0.95rem;
    margin-bottom: 0.25rem;
}

.user-phone {
    color: #6b7280;
    font-size: 0.8rem;
}

/* Motor Info */
.motor-name {
    font-weight: 600;
    color: #1f2937;
    font-size: 0.95rem;
    margin-bottom: 0.25rem;
}

.motor-duration {
    color: #6b7280;
    font-size: 0.8rem;
    display: flex;
    align-items: center;
}

/* Date Info */
.rental-date {
    font-weight: 600;
    color: #1f2937;
    font-size: 0.9rem;
    margin-bottom: 0.25rem;
}

.relative-time {
    color: #6b7280;
    font-size: 0.8rem;
}

/* Status Badges */
.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.6rem 1rem;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.status-primary {
    background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
    color: white;
}

.status-success {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: white;
}

.status-warning {
    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    color: white;
}

.status-info {
    background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%);
    color: white;
}

.status-danger {
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    color: white;
}

.status-secondary {
    background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%);
    color: white;
}

/* Price Info */
.price-amount {
    font-weight: 700;
    color: #059669;
    font-size: 1rem;
}

/* Pagination Styling */
.pagination {
    margin: 0;
    padding: 2rem;
    border-top: 1px solid #f1f5f9;
    background: #f8fafc;
}

.pagination .page-item {
    margin: 0 3px;
}

.pagination .page-link {
    border-radius: 10px;
    border: 2px solid #e2e8f0;
    color: #6b7280;
    padding: 0.75rem 1rem;
    font-size: 0.9rem;
    font-weight: 600;
    transition: var(--transition);
    text-decoration: none;
    background: white;
}

.pagination .page-link:hover {
    background: linear-gradient(135deg, #2563eb 0%, #fbbf24 100%); /* Blue to Yellow */
    border-color: #2563eb;
    color: #0b1324;
    transform: translateY(-2px);
    box-shadow: 0 8px 15px rgba(37, 99, 235, 0.25);
}

.pagination .page-item.active .page-link {
    background: linear-gradient(135deg, #2563eb 0%, #fbbf24 100%);
    border-color: #2563eb;
    color: #0b1324;
    box-shadow: 0 8px 15px rgba(37, 99, 235, 0.25);
}

.pagination .page-item.disabled .page-link {
    color: #cbd5e1;
    background-color: #f8fafc;
    border-color: #e2e8f0;
    cursor: not-allowed;
}

.pagination .page-item.disabled .page-link:hover {
    transform: none;
    box-shadow: none;
    background: #f8fafc;
    color: #cbd5e1;
}

/* Responsive Design */
@media (max-width: 768px) {
    .stats-card-body {
        padding: 1.5rem;
        flex-direction: column;
        text-align: center;
        gap: 1rem;
    }
    
    .stats-content {
        text-align: center;
        margin-left: 0;
    }
    
    .stats-number {
        font-size: 2rem;
    }
    
    .table-card-header {
        padding: 1.5rem;
    }
    
    .table-title {
        font-size: 1.25rem;
    }
    
    .modern-table-responsive {
        font-size: 0.85rem;
    }
    
    .table-cell {
        padding: 1rem 0.75rem;
    }
    
    .user-info {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.5rem;
    }
    
    .pagination .page-link {
        padding: 0.5rem 0.75rem;
        font-size: 0.8rem;
    }
}

@media (max-width: 576px) {
    .stats-number {
        font-size: 1.75rem;
    }
    
    .table-card-header .d-flex {
        flex-direction: column;
        gap: 1rem;
    }
    
    .pagination .page-item {
        margin: 0 1px;
    }
}

/* Animation Keyframes */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.stats-card {
    animation: fadeInUp 0.6s ease-out;
}

.modern-table-card {
    animation: fadeInUp 0.8s ease-out;
}
</style>
@endsection