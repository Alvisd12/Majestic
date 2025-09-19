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
                    @case('Pending')
                        Menunggu Konfirmasi
                        @break
                    @case('Disewa')
                        Disewa
                        @break
                    @case('Selesai')
                        Dikembalikan
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
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-primary bg-opacity-10 p-3 rounded">
                                <i class="fas fa-clipboard-list text-primary fa-2x"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="card-title text-muted mb-1">Total Peminjaman</h6>
                            <h4 class="mb-0 fw-bold">{{ $totalPeminjaman ?? 0 }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-success bg-opacity-10 p-3 rounded">
                                <i class="fas fa-motorcycle text-success fa-2x"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="card-title text-muted mb-1">Motor Tersedia</h6>
                            <h4 class="mb-0 fw-bold">{{ $motorTersedia ?? 0 }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-warning bg-opacity-10 p-3 rounded">
                                <i class="fas fa-clock text-warning fa-2x"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="card-title text-muted mb-1">Peminjaman Aktif</h6>
                            <h4 class="mb-0 fw-bold">{{ $peminjamanAktif ?? 0 }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-info bg-opacity-10 p-3 rounded">
                                <i class="fas fa-users text-info fa-2x"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="card-title text-muted mb-1">Total Pengunjung</h6>
                            <h4 class="mb-0 fw-bold">{{ $totalPengunjung ?? 0 }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Search Box -->
    <form method="GET" action="{{ route('admin.dashboard') }}">
        <div class="search-box">
            <input type="text" class="form-control" name="search" 
                   placeholder="Search here..." value="{{ request('search') }}">
            <i class="fas fa-search"></i>
        </div>
    </form>

    <!-- Data Peminjaman Terbaru -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold"><i class="fas fa-list me-2"></i>Data Peminjaman Terbaru</h5>
                    <small class="text-muted">{{ now()->format('d M Y, H:i') }}</small>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Penyewa</th>
                                    <th>Motor</th>
                                    <th>Tanggal Sewa</th>
                                    <th>Status</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentRentals as $index => $rental)
                                <tr>
                                    <td>{{ ($recentRentals->currentPage() - 1) * $recentRentals->perPage() + $index + 1 }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($rental->user && $rental->user->profile_photo)
                                                <img src="{{ asset('storage/' . $rental->user->profile_photo) }}" 
                                                     alt="Profile" 
                                                     class="avatar-sm rounded-circle me-2"
                                                     style="width: 35px; height: 35px; object-fit: cover;">
                                            @else
                                                <div class="avatar-sm bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-2">
                                                    <i class="fas fa-user text-primary"></i>
                                                </div>
                                            @endif
                                            <div>
                                                <h6 class="mb-0">{{ $rental->user->nama ?? $rental->nama ?? 'N/A' }}</h6>
                                                @if($rental->user->no_handphone ?? $rental->no_handphone)
                                                    <small class="text-muted">{{ $rental->user->no_handphone ?? $rental->no_handphone }}</small>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <span class="fw-bold">{{ $rental->jenis_motor ?? 'N/A' }}</span>
                                            <br>
                                            <small class="text-muted">{{ $rental->durasi_sewa ?? 1 }} hari</small>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="text-muted">{{ $rental->tanggal_rental ? $rental->tanggal_rental->format('d M Y') : 'N/A' }}</span>
                                        <br>
                                        <small class="text-muted">{{ $rental->created_at ? $rental->created_at->diffForHumans() : 'N/A' }}</small>
                                    </td>
                                    <td>
                                        @php
                                            $status = $rental->status ?? 'Pending';
                                            $badgeClass = match($status) {
                                                'Pending' => 'bg-warning',
                                                'Confirmed' => 'bg-info',
                                                'Disewa' => 'bg-primary', 
                                                'Selesai' => 'bg-success',
                                                'Cancelled' => 'bg-danger',
                                                'Belum Kembali' => 'bg-danger',
                                                default => 'bg-secondary'
                                            };
                                        @endphp
                                        <span class="badge {{ $badgeClass }}">{{ $status }}</span>
                                    </td>
                                    <td>
                                        <span class="fw-bold text-success">Rp {{ number_format($rental->total_harga ?? 0, 0, ',', '.') }}</span>
                                    </td>
                                </tr>
                                @empty
                                <!-- Sample Data when no rentals exist -->
                                <tr>
                                    <td>1</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-2">
                                                <i class="fas fa-user text-primary"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-0">Ahmad Rizki</h6>
                                                <small class="text-muted">081234567890</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <span class="fw-bold">Honda Beat</span>
                                            <br>
                                            <small class="text-muted">B 1234 ABC</small>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="text-muted">{{ now()->format('d M Y') }}</span>
                                        <br>
                                        <small class="text-muted">2 jam yang lalu</small>
                                    </td>
                                    <td>
                                        <span class="badge bg-success">Disewa</span>
                                    </td>
                                    <td>
                                        <span class="fw-bold text-success">Rp 150.000</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-2">
                                                <i class="fas fa-user text-primary"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-0">Siti Nurhaliza</h6>
                                                <small class="text-muted">081987654321</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <span class="fw-bold">Yamaha Mio</span>
                                            <br>
                                            <small class="text-muted">B 5678 DEF</small>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="text-muted">{{ now()->subHours(5)->format('d M Y') }}</span>
                                        <br>
                                        <small class="text-muted">5 jam yang lalu</small>
                                    </td>
                                    <td>
                                        <span class="badge bg-warning">Pending</span>
                                    </td>
                                    <td>
                                        <span class="fw-bold text-success">Rp 120.000</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-2">
                                                <i class="fas fa-user text-primary"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-0">Budi Santoso</h6>
                                                <small class="text-muted">081555666777</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <span class="fw-bold">Honda Vario</span>
                                            <br>
                                            <small class="text-muted">B 9012 GHI</small>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="text-muted">{{ now()->subDay()->format('d M Y') }}</span>
                                        <br>
                                        <small class="text-muted">1 hari yang lalu</small>
                                    </td>
                                    <td>
                                        <span class="badge bg-info">Selesai</span>
                                    </td>
                                    <td>
                                        <span class="fw-bold text-success">Rp 200.000</span>
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
.avatar-sm {
    width: 35px;
    height: 35px;
    font-size: 14px;
}

.table-hover tbody tr:hover {
    background-color: rgba(0,0,0,0.02);
}

.badge {
    font-size: 0.75em;
    padding: 0.4em 0.6em;
    border-radius: 0.375rem;
}

.table th {
    font-weight: 600;
    font-size: 0.875rem;
    color: #6c757d;
    border-bottom: 2px solid #dee2e6;
}

.table td {
    vertical-align: middle;
    padding: 1rem 0.75rem;
}

.card {
    border: none;
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
}

.card-header {
    background-color: #f8f9fa;
    border-bottom: 1px solid #dee2e6;
    padding: 1rem 1.25rem;
}

.text-success {
    color: #198754 !important;
}

.border-top {
    border-top: 1px solid #dee2e6 !important;
}

/* Pagination Styling */
.pagination {
    margin: 0;
    padding: 0;
}

.pagination .page-item {
    margin: 0 2px;
}

.pagination .page-link {
    border-radius: 8px;
    border: 1px solid #dee2e6;
    color: #6c757d;
    padding: 0.5rem 0.75rem;
    font-size: 0.875rem;
    font-weight: 500;
    transition: all 0.2s ease;
    text-decoration: none;
}

.pagination .page-link:hover {
    background-color: #f8f9fa;
    border-color: #adb5bd;
    color: #495057;
    transform: translateY(-1px);
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.pagination .page-item.active .page-link {
    background-color: #007bff;
    border-color: #007bff;
    color: white;
    box-shadow: 0 2px 4px rgba(0,123,255,0.3);
}

.pagination .page-item.disabled .page-link {
    color: #adb5bd;
    background-color: #fff;
    border-color: #dee2e6;
    cursor: not-allowed;
}

.pagination .page-item.disabled .page-link:hover {
    transform: none;
    box-shadow: none;
}

/* Pagination container */
.d-flex.justify-content-center {
    padding: 1rem 0;
    border-top: 1px solid #f1f3f4;
    margin-top: 1.5rem;
}

/* Responsive pagination */
@media (max-width: 576px) {
    .pagination .page-link {
        padding: 0.375rem 0.5rem;
        font-size: 0.75rem;
    }
    
    .pagination .page-item {
        margin: 0 1px;
    }
}
</style>
@endsection