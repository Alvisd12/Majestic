@extends('layouts.app')

@section('title', 'Wisata')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3 sidebar-container">
            <div class="sidebar">
                <div class="logo mb-4">
                    <img src="{{ asset('assets/images/logo.png') }}" alt="AJESTIC TRANSPORT" class="logo-img">
                    <h5 class="text-white mt-2">AJESTIC</h5>
                    <small class="text-light">TRANSPORT</small>
                </div>
                
                <nav class="nav flex-column">
                    <a class="nav-link" href="{{ route('auth.dashboard') }}">
                        <i class="fas fa-home"></i> Dashboard
                    </a>
                    <a class="nav-link" href="{{ route('peminjaman.index') }}">
                        <i class="fas fa-users"></i> Pesanan
                    </a>
                    <a class="nav-link" href="{{ route('harga_sewa') }}">
                        <i class="fas fa-lock"></i> Harga Sewa
                    </a>
                    <a class="nav-link" href="{{ route('galeri') }}">
                        <i class="fas fa-images"></i> Galeri
                    </a>
                    <a class="nav-link active" href="{{ route('wisata.index') }}">
                        <i class="fas fa-map-marker-alt"></i> Wisata
                    </a>
                    <a class="nav-link" href="#">
                        <i class="fas fa-star"></i> Testimoni
                    </a>
                    <a class="nav-link" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </nav>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-md-9 main-content">
            <header class="main-header d-flex justify-content-between align-items-center mb-4">
                <h2 class="page-title">Wisata</h2>
                <div class="header-right d-flex align-items-center">
                    <div class="notification-bell me-3">
                        <i class="fas fa-bell"></i>
                    </div>
                    <div class="user-profile d-flex align-items-center">
                        <div class="user-info me-2">
                            <small class="text-muted">{{ session('user_name') }}</small><br>
                            <small class="text-muted">{{ ucfirst(session('user_role')) }}</small>
                        </div>
                        <div class="user-avatar">
                            <i class="fas fa-user-circle fa-2x text-primary"></i>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Search and Add Button -->
            <div class="row mb-4">
                <div class="col-md-8">
                    <form method="GET" action="{{ route('wisata.index') }}">
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="fas fa-search text-muted"></i>
                            </span>
                            <input type="text" class="form-control border-start-0" 
                                   placeholder="Search here..." 
                                   name="search" 
                                   value="{{ request('search') }}">
                        </div>
                    </form>
                </div>
                @if(session('user_role') === 'admin')
                <div class="col-md-4 text-end">
                    <a href="#" class="btn btn-warning">
                        <i class="fas fa-plus"></i> Tambah
                    </a>
                </div>
                @endif
            </div>

            <!-- Wisata Table -->
            <div class="card shadow-sm">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 50px;">No</th>
                                    <th style="width: 120px;">Gambar</th>
                                    <th>Nama Wisata</th>
                                    <th>Deskripsi</th>
                                    <th style="width: 150px;">Alamat</th>
                                    <th style="width: 120px;">Tanggal Upload</th>
                                    <th style="width: 100px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($wisata as $index => $item)
                                <tr>
                                    <td>{{ $wisata->firstItem() + $index }}.</td>
                                    <td>
                                        <div class="wisata-image">
                                            @if($item->gambar)
                                                <img src="{{ asset('storage/' . $item->gambar) }}" 
                                                     alt="{{ $item->judul }}" 
                                                     class="img-fluid rounded"
                                                     style="width: 80px; height: 60px; object-fit: cover;">
                                            @else
                                                <div class="bg-light rounded d-flex align-items-center justify-content-center" 
                                                     style="width: 80px; height: 60px;">
                                                    <i class="fas fa-image text-muted"></i>
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <a href="{{ route('wisata.show', $item->id) }}" 
                                           class="text-decoration-none fw-semibold text-primary">
                                            {{ $item->judul }}
                                        </a>
                                    </td>
                                    <td>
                                        <span class="text-muted">
                                            {{ Str::limit(strip_tags($item->isi), 100) }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="text-muted">
                                            {{ $item->admin ? $item->admin->nama : 'Admin' }}
                                        </span>
                                    </td>
                                    <td>
                                        <small class="text-muted">
                                            {{ $item->created_at->format('M d, Y') }}
                                        </small>
                                    </td>
                                    <td>
                                        <div class="action-buttons d-flex gap-1">
                                            <a href="{{ route('wisata.show', $item->id) }}" 
                                               class="btn btn-sm btn-outline-primary" 
                                               title="Lihat Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            @if(session('user_role') === 'admin')
                                            <button type="button" 
                                                    class="btn btn-sm btn-outline-danger" 
                                                    title="Hapus"
                                                    onclick="confirmDelete({{ $item->id }})">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5">
                                        <div class="text-muted">
                                            <i class="fas fa-map-marker-alt fa-3x mb-3"></i>
                                            <p>Belum ada data wisata</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Pagination -->
            @if($wisata->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $wisata->links() }}
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Logout Form -->
<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>

<style>
.sidebar-container {
    padding: 0;
}

.sidebar {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    min-height: 100vh;
    padding: 2rem 1rem;
    color: white;
}

.logo-img {
    width: 40px;
    height: 40px;
}

.nav-link {
    color: rgba(255, 255, 255, 0.8) !important;
    padding: 0.75rem 1rem;
    margin-bottom: 0.5rem;
    border-radius: 8px;
    transition: all 0.3s ease;
}

.nav-link:hover,
.nav-link.active {
    background-color: rgba(255, 255, 255, 0.1);
    color: white !important;
    transform: translateX(5px);
}

.nav-link.active {
    background-color: rgba(255, 193, 7, 0.2);
    border-left: 4px solid #ffc107;
}

.main-content {
    padding: 2rem;
    background-color: #f8f9fa;
    min-height: 100vh;
}

.main-header {
    background: white;
    padding: 1rem 1.5rem;
    border-radius: 10px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.page-title {
    font-size: 1.5rem;
    font-weight: 600;
    color: #333;
    margin: 0;
}

.notification-bell {
    background: #f8f9fa;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
}

.user-info {
    text-align: right;
}

.card {
    border: none;
    border-radius: 12px;
}

.table th {
    background-color: #f8f9fa;
    border-bottom: 2px solid #dee2e6;
    font-weight: 600;
    color: #495057;
}

.table td {
    vertical-align: middle;
    border-bottom: 1px solid #f1f3f4;
}

.btn-warning {
    background-color: #ffc107;
    border-color: #ffc107;
    font-weight: 500;
}

.wisata-image img {
    transition: transform 0.2s ease;
}

.wisata-image img:hover {
    transform: scale(1.05);
}

.pagination {
    justify-content: center;
}

.pagination .page-link {
    border: none;
    color: #667eea;
    font-weight: 500;
}

.pagination .page-item.active .page-link {
    background-color: #667eea;
    border-color: #667eea;
}

@media (max-width: 768px) {
    .sidebar {
        position: fixed;
        left: -250px;
        width: 250px;
        z-index: 1000;
        transition: left 0.3s ease;
    }
    
    .main-content {
        margin-left: 0;
        width: 100%;
    }
}
</style>

<script>
function confirmDelete(id) {
    if (confirm('Apakah Anda yakin ingin menghapus wisata ini?')) {
        // Add delete functionality here
        console.log('Delete wisata with ID:', id);
    }
}

// Auto submit search form on input
document.querySelector('input[name="search"]').addEventListener('input', function() {
    setTimeout(() => {
        this.form.submit();
    }, 500);
});
</script>
@endsection