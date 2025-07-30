@extends('layouts.admin')

@section('title', 'Menunggu Konfirmasi')

@section('page-title', 'Menunggu di konfirmasi')

@section('content')
    <!-- Status Update Notification -->
    @if(session('status_updated'))
        <div class="alert alert-info alert-dismissible fade show mb-4" role="alert">
            <i class="fas fa-sync-alt me-2"></i>
            <strong>Status Update:</strong> {{ session('status_updated') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Search Box -->
    <form method="GET" action="{{ route('admin.konfirmasi') }}">
        <div class="search-box mb-4">
            <input type="text" class="form-control" name="search" 
                   placeholder="Search here..." value="{{ request('search') }}">
            <i class="fas fa-search"></i>
        </div>
    </form>

    <!-- Data Table -->
    <div class="data-table">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Jenis Motor</th>
                        <th>Tanggal Rental</th>
                        <th>Durasi Sewa</th>
                        <th>Total Biaya</th>
                        <th>No. Handphone</th>
                        <th>Bukti Jaminan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($peminjaman as $index => $item)
                    <tr data-id="{{ $item->id }}">
                        <td>{{ $peminjaman->firstItem() + $index }}.</td>
                        <td class="fw-bold">{{ $item->user->nama ?? 'Unknown' }}</td>
                        <td>{{ $item->jenis_motor }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->tanggal_rental)->format('M d, Y') }}</td>
                        <td>{{ $item->durasi_sewa }} Hari</td>
                        <td class="fw-bold">Rp {{ number_format($item->total_harga, 0, ',', '.') }}</td>
                        <td>
                            <a href="tel:{{ $item->user->phone ?? '' }}" class="text-primary text-decoration-none">
                                #{{ $item->user->phone ?? '123456789' }}
                            </a>
                        </td>
                        <td>
                            @if($item->bukti_jaminan)
                                <button type="button" class="btn btn-sm btn-outline-secondary" 
                                        onclick="viewBuktiJaminan('{{ $item->bukti_jaminan }}')">
                                    <i class="fas fa-eye"></i> Lihat
                                </button>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge bg-danger">Menunggu di konfirmasi</span>
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-sm btn-success" 
                                        onclick="approvePeminjaman({{ $item->id }})" 
                                        title="Setujui">
                                    <i class="fas fa-check"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-danger" 
                                        onclick="rejectPeminjaman({{ $item->id }})" 
                                        title="Tolak">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" class="text-center py-4">
                            <i class="fas fa-clipboard-list fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Tidak ada pesanan yang menunggu konfirmasi</p>
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

    <!-- Modal for Bukti Jaminan -->
    <div class="modal fade" id="buktiJaminanModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Bukti Jaminan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center">
                    <img id="buktiJaminanImage" src="" alt="Bukti Jaminan" class="img-fluid">
                </div>
            </div>
        </div>
    </div>
@endsection

@section('additional-scripts')
<script>
    // View Bukti Jaminan Function
    function viewBuktiJaminan(imagePath) {
        document.getElementById('buktiJaminanImage').src = '/storage/' + imagePath;
        new bootstrap.Modal(document.getElementById('buktiJaminanModal')).show();
    }

    // Approve Peminjaman Function
    function approvePeminjaman(id) {
        if (confirm('Apakah Anda yakin ingin menyetujui peminjaman ini?')) {
            fetch(`/admin/peminjaman/${id}/approve`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Remove the row from the table
                    const row = document.querySelector(`tr[data-id="${id}"]`);
                    if (row) {
                        row.remove();
                    }
                    // Reload page to refresh the data
                    location.reload();
                } else {
                    alert('Gagal menyetujui peminjaman');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Gagal menyetujui peminjaman');
            });
        }
    }

    // Reject Peminjaman Function
    function rejectPeminjaman(id) {
        if (confirm('Apakah Anda yakin ingin menolak peminjaman ini? Data akan dihapus permanen.')) {
            fetch(`/admin/peminjaman/${id}/reject`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Remove the row from the table
                    const row = document.querySelector(`tr[data-id="${id}"]`);
                    if (row) {
                        row.remove();
                    }
                    // Reload page to refresh the data
                    location.reload();
                } else {
                    alert('Gagal menolak peminjaman');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Gagal menolak peminjaman');
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