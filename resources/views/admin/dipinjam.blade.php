@extends('layouts.admin')

@section('title', 'Dipinjam')

@section('page-title', 'Dipinjam')

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
    <form method="GET" action="{{ route('admin.dipinjam') }}">
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
                        <th>Tanggal Sewa</th>
                        <th>Tanggal Kembali</th>
                        <th>Durasi Sewa</th>
                        <th>Total Biaya</th>
                        <th>Denda</th>
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
                        <td>
                            <div class="d-flex align-items-center">
                                @if($item->user && $item->user->profile_photo)
                                    <img src="{{ asset('storage/' . $item->user->profile_photo) }}" 
                                         alt="Profile" 
                                         class="rounded-circle me-2"
                                         style="width: 35px; height: 35px; object-fit: cover;">
                                @else
                                    <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-2" 
                                         style="width: 35px; height: 35px;">
                                        <i class="fas fa-user text-primary"></i>
                                    </div>
                                @endif
                                <span class="fw-bold">{{ $item->user->nama ?? 'Unknown' }}</span>
                            </div>
                        </td>
                        <td>{{ $item->jenis_motor }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->tanggal_rental)->format('M d, Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->tanggal_kembali)->format('M d, Y') }}</td>
                        <td>{{ $item->durasi_sewa }} Hari</td>
                        <td class="fw-bold">Rp {{ number_format($item->total_harga, 0, ',', '.') }}</td>
                        <td>
                            @if($item->status === 'Belum Kembali' && $item->denda > 0)
                                <span class="text-danger fw-bold">Rp {{ number_format($item->denda, 0, ',', '.') }}</span>
                                <br>
                                <small class="text-muted">{{ $item->overdue_days }} hari terlambat</small>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            <a href="tel:{{ $item->user->no_handphone ?? '' }}" class="text-primary text-decoration-none">
                                {{ $item->user->no_handphone ?? '-' }}
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
                            @php
                                $statusColors = [
                                    'Confirmed' => 'info',
                                    'Disewa' => 'primary',
                                    'Belum Kembali' => 'danger'
                                ];
                                $statusLabels = [
                                    'Confirmed' => 'Dikonfirmasi',
                                    'Disewa' => 'Dipinjam',
                                    'Belum Kembali' => 'Belum Kembali'
                                ];
                                $color = $statusColors[$item->status] ?? 'secondary';
                                $label = $statusLabels[$item->status] ?? $item->status;
                            @endphp
                            <span class="badge bg-{{ $color }}">{{ $label }}</span>
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-sm btn-outline-primary" 
                                        onclick="viewDetails('{{ $item->id }}')" 
                                        title="Lihat Detail">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-info" 
                                        onclick="finishRental('{{ $item->id }}')" 
                                        title="Selesai Rental">
                                    <i class="fas fa-check-double"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-danger" 
                                        onclick="deletePeminjaman('{{ $item->id }}')" 
                                        title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="12" class="text-center py-4">
                            <i class="fas fa-motorcycle fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Tidak ada data peminjaman yang sedang dipinjam</p>
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

    // View Details Function
    function viewDetails(id) {
        window.location.href = `/admin/peminjaman/${id}`;
    }

    // Start Rental Function
    function startRental(id) {
        if (confirm('Apakah Anda yakin ingin memulai rental ini?')) {
            fetch(`/admin/peminjaman/${id}/start-rental`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Gagal memulai rental');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Gagal memulai rental');
            });
        }
    }

    // Finish Rental Function
    function finishRental(id) {
        if (confirm('Apakah Anda yakin ingin menyelesaikan rental ini?')) {
            fetch(`/admin/peminjaman/${id}/finish-rental`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Gagal menyelesaikan rental');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Gagal menyelesaikan rental');
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