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

    <!-- Data Table -->
    <div class="data-table">
        <div class="d-flex justify-content-between align-items-center p-3 border-bottom">
            <h5 class="mb-0 fw-bold">Data Peminjaman Terbaru</h5>
            <a href="{{ route('admin.harga_sewa') }}" class="btn btn-sm btn-outline-primary">
                <i class="fas fa-plus me-1"></i>Kelola Motor
            </a>
        </div>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Pengunjung</th>
                        <th>Jenis Motor</th>
                        <th>Tanggal Rental</th>
                        <th>Durasi</th>
                        <th>Status</th>
                        <th>Total Harga</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($peminjaman as $index => $item)
                    <tr>
                        <td>{{ $peminjaman->firstItem() + $index }}.</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="user-avatar me-2" style="width: 35px; height: 35px; font-size: 0.8rem;">
                                    {{ substr($item->user->nama ?? 'U', 0, 1) }}
                                </div>
                                <div>
                                    <div class="fw-bold">{{ $item->user->nama ?? 'Unknown' }}</div>
                                    <small class="text-muted">{{ $item->user->phone ?? '-' }}</small>
                                </div>
                            </div>
                        </td>
                        <td class="fw-bold">{{ $item->jenis_motor }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->tanggal_rental)->format('M d, Y') }}</td>
                        <td>{{ $item->durasi }} hari</td>
                        <td>
                            @php
                                $statusColors = [
                                    'Pending' => 'warning',
                                    'Confirmed' => 'info',
                                    'Disewa' => 'primary',
                                    'Belum Kembali' => 'warning',
                                    'Selesai' => 'success',
                                    'Cancelled' => 'danger'
                                ];
                                $color = $statusColors[$item->status] ?? 'secondary';
                            @endphp
                            <span class="badge bg-{{ $color }}">{{ $item->status }}</span>
                        </td>
                        <td class="fw-bold">Rp {{ number_format($item->total_harga, 0, ',', '.') }}</td>
                        <td>
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-sm btn-outline-primary" 
                                        onclick="viewDetails({{ $item->id }})">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-success" 
                                        onclick="updateStatus({{ $item->id }}, 'Confirmed')">
                                    <i class="fas fa-check"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-danger" 
                                        onclick="deletePeminjaman({{ $item->id }})">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-4">
                            <i class="fas fa-clipboard-list fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Tidak ada data peminjaman</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        @if($peminjaman->hasPages())
        <div class="pagination-container">
            {{ $peminjaman->appends(request()->query())->links() }}
        </div>
        @endif
    </div>
@endsection

@section('additional-scripts')
<script>
    // View Details Function
    function viewDetails(id) {
        window.location.href = `/admin/peminjaman/${id}`;
    }

    // Update Status Function
    function updateStatus(id, status) {
        if (confirm('Apakah Anda yakin ingin mengubah status peminjaman ini?')) {
            fetch(`/admin/peminjaman/${id}/status`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ status: status })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Gagal mengubah status');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Gagal mengubah status');
            });
        }
    }

    // Delete Peminjaman Function
    function deletePeminjaman(id) {
        if (confirm('Apakah Anda yakin ingin menghapus peminjaman ini?')) {
            fetch(`/admin/peminjaman/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Gagal menghapus peminjaman');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Gagal menghapus peminjaman');
            });
        }
    }

    // Auto-submit search form on input
    document.querySelector('input[name="search"]').addEventListener('keyup', function(e) {
        if (e.key === 'Enter') {
            this.form.submit();
        }
    });
</script>
@endsection