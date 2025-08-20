@extends('layouts.admin')

@section('title', 'Harga Sewa')

@section('page-title', 'Harga Sewa')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0 fw-bold">Daftar Harga Sewa Motor</h5>
                </div>
                <div class="card-body">
                    <!-- Search and Add Button Row -->
                    <div class="d-flex justify-content-between align-items-center mb-4">
                <!-- Search Box -->
                <form method="GET" action="{{ route('admin.harga_sewa') }}" class="d-flex align-items-center">
                    <div class="search-box me-3">
                        <input type="text" class="form-control" name="search" 
                               placeholder="Search here..." value="{{ request('search') }}">
                        <i class="fas fa-search"></i>
                    </div>
                </form>
                
                        <!-- Add Button -->
                        <button type="button" class="btn btn-primary" onclick="addMotor()">
                            <i class="fas fa-plus me-2"></i>
                            Tambah Motor
                        </button>
                    </div>

                    <!-- Data Table -->
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Gambar</th>
                                <th>Jenis Motor</th>
                                <th>Plat Motor</th>
                                <th>Warna Motor</th>
                                <th>Harga</th>
                                <th>Deskripsi</th>
                                <th>Tanggal Upload</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($motors as $index => $motor)
                            <tr>
                                <td>{{ $motors->firstItem() + $index }}.</td>
                                <td>
                                    <div class="motor-image">
                                        @if($motor->foto)
                                            <img src="{{ asset('storage/' . $motor->foto) }}" alt="{{ $motor->merk }} {{ $motor->model }}">
                                        @else
                                            <i class="fas fa-motorcycle"></i>
                                        @endif
                                    </div>
                                </td>
                                <td class="fw-bold">{{ $motor->merk }} {{ $motor->model }}</td>
                                <td class="text-primary">{{ $motor->plat_nomor }}</td>
                                <td class="text-muted">{{ $motor->warna ?: 'Hitam' }}</td>
                                <td>
                                    <span class="price-badge">
                                        Rp {{ number_format($motor->harga_per_hari, 0, ',', '.') }}
                                    </span>
                                </td>
                                <td class="text-muted">
                                    {{ Str::limit($motor->deskripsi ?: 'Motor ' . $motor->merk . ' ' . $motor->model . ' tahun ' . $motor->tahun, 50) }}
                                </td>
                                <td class="text-muted">{{ $motor->created_at->format('M d, Y') }}</td>
                                <td class="text-center">
                                    @php
                                        $badgeClass = match($motor->status) {
                                            'Tersedia' => 'badge-success',
                                            'Disewa' => 'badge-warning',
                                            'Maintenance' => 'badge-danger',
                                            default => 'badge-secondary'
                                        };
                                    @endphp
                                    <span class="badge {{ $badgeClass }}">
                                        {{ $motor->status }}
                                    </span></td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-sm btn-outline-primary" onclick="editMotor({{ $motor->id ?? 0 }})">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-danger" onclick="deleteMotor({{ $motor->id ?? 0 }})">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="10" class="text-center py-4">
                                    <i class="fas fa-motorcycle fa-3x text-muted mb-3"></i>
                                    <p class="text-muted">Tidak ada data motor</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                    <!-- Pagination -->
                    @if($motors->hasPages())
                    <div class="d-flex justify-content-center mt-4">
                        {{ $motors->appends(request()->query())->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('additional-styles')
<style>
.motor-image {
    width: 60px;
    height: 60px;
    border-radius: 8px;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #f8f9fa;
    border: 1px solid #dee2e6;
}

.motor-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.motor-image i {
    font-size: 24px;
    color: #6c757d;
}

.price-badge {
    background: linear-gradient(135deg, #28a745, #20c997);
    color: white;
    padding: 6px 12px;
    border-radius: 20px;
    font-weight: 600;
    font-size: 0.875rem;
    display: inline-block;
}

.search-box {
    position: relative;
}

.search-box input {
    padding-left: 40px;
    border-radius: 25px;
    border: 1px solid #dee2e6;
    width: 300px;
}

.search-box i {
    position: absolute;
    left: 15px;
    top: 50%;
    transform: translateY(-50%);
    color: #6c757d;
}

.badge {
    font-size: 0.75rem;
    padding: 6px 12px;
    border-radius: 15px;
    font-weight: 600;
}

.badge-success { 
    background: #d4edda !important; 
    color: #155724 !important; 
    border: 1px solid #c3e6cb;
}

.badge-warning { 
    background: #fff3cd !important; 
    color: #856404 !important; 
    border: 1px solid #ffeaa7;
}

.badge-danger { 
    background: #f8d7da !important; 
    color: #721c24 !important; 
    border: 1px solid #f5c6cb;
}

.badge-secondary { 
    background: #e2e3e5 !important; 
    color: #383d41 !important; 
    border: 1px solid #d6d8db;
}

.table th {
    background: #f8f9fa;
    border-bottom: 2px solid #dee2e6;
    font-weight: 600;
    color: #495057;
}

.table td {
    vertical-align: middle;
    border-bottom: 1px solid #dee2e6;
}

.btn-group .btn {
    margin: 0 2px;
}
</style>
@endsection

@section('additional-scripts')
<script>
    // Add Motor Function
    function addMotor() {
        window.location.href = '{{ route("admin.motor.create") }}';
    }

    // Edit Motor Function
    function editMotor(id) {
        window.location.href = '{{ route("admin.motor.edit", ":id") }}'.replace(':id', id);
    }

    // Delete Motor Function
    function deleteMotor(id) {
        Swal.fire({
            title: 'Konfirmasi Hapus',
            text: 'Apakah Anda yakin ingin menghapus motor ini?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch('{{ route("admin.motor.destroy", ":id") }}'.replace(':id', id), {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire('Berhasil!', 'Motor berhasil dihapus.', 'success')
                        .then(() => location.reload());
                    } else {
                        Swal.fire('Error!', data.message || 'Gagal menghapus motor.', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire('Error!', 'Terjadi kesalahan saat menghapus motor.', 'error');
                });
            }
        });
    }

    // Auto-submit search form on input
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.querySelector('input[name="search"]');
        if (searchInput) {
            searchInput.addEventListener('keyup', function(e) {
                if (e.key === 'Enter') {
                    this.form.submit();
                }
            });
        }
    });
</script>
@endsection