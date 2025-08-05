@extends('layouts.app')

@section('title', $wisata->judul)

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
            <!-- Header -->
            <header class="main-header d-flex justify-content-between align-items-center mb-4">
                <div class="d-flex align-items-center">
                    <a href="{{ route('wisata.index') }}" class="btn btn-outline-primary me-3">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                    <h2 class="page-title mb-0">Detail Wisata</h2>
                </div>
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

            <!-- Wisata Detail -->
            <div class="row">
                <div class="col-lg-8">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <!-- Featured Image -->
                            @if($wisata->gambar)
                            <div class="featured-image mb-4">
                                <img src="{{ asset('storage/' . $wisata->gambar) }}" 
                                     alt="{{ $wisata->judul }}" 
                                     class="img-fluid rounded"
                                     style="width: 100%; height: 300px; object-fit: cover;">
                            </div>
                            @endif

                            <!-- Article Header -->
                            <div class="article-header mb-4">
                                <h1 class="article-title">{{ $wisata->judul }}</h1>
                                <div class="article-meta d-flex align-items-center text-muted mb-3">
                                    <i class="fas fa-user me-2"></i>
                                    <span class="me-3">{{ $wisata->admin ? $wisata->admin->nama : 'Admin' }}</span>
                                    <i class="fas fa-calendar me-2"></i>
                                    <span class="me-3">{{ $wisata->created_at->format('d F Y') }}</span>
                                    <i class="fas fa-clock me-2"></i>
                                    <span>{{ $wisata->created_at->format('H:i') }}</span>
                                </div>
                            </div>

                            <!-- Article Content -->
                            <div class="article-content">
                                {!! nl2br(e($wisata->isi)) !!}
                            </div>

                            <!-- Share Buttons -->
                            <div class="share-section mt-5 pt-4 border-top">
                                <h6 class="mb-3">Bagikan Wisata Ini:</h6>
                                <div class="share-buttons">
                                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ url()->current() }}" 
                                       target="_blank" class="btn btn-facebook me-2">
                                        <i class="fab fa-facebook-f"></i> Facebook
                                    </a>
                                    <a href="https://twitter.com/intent/tweet?url={{ url()->current() }}&text={{ $wisata->judul }}" 
                                       target="_blank" class="btn btn-twitter me-2">
                                        <i class="fab fa-twitter"></i> Twitter
                                    </a>
                                    <a href="https://wa.me/?text={{ $wisata->judul }} - {{ url()->current() }}" 
                                       target="_blank" class="btn btn-whatsapp">
                                        <i class="fab fa-whatsapp"></i> WhatsApp
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="col-lg-4">
                    <!-- Related Wisata -->
                    @if($relatedWisata->count() > 0)
                    <div class="card shadow-sm">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">Wisata Lainnya</h5>
                        </div>
                        <div class="card-body">
                            @foreach($relatedWisata as $related)
                            <div class="related-item d-flex mb-3 pb-3 {{ !$loop->last ? 'border-bottom' : '' }}">
                                <div class="related-image me-3">
                                    @if($related->gambar)
                                        <img src="{{ asset('storage/' . $related->gambar) }}" 
                                             alt="{{ $related->judul }}" 
                                             class="img-fluid rounded"
                                             style="width: 60px; height: 45px; object-fit: cover;">
                                    @else
                                        <div class="bg-light rounded d-flex align-items-center justify-content-center" 
                                             style="width: 60px; height: 45px;">
                                            <i class="fas fa-image text-muted"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="related-content">
                                    <h6 class="mb-1">
                                        <a href="{{ route('wisata.show', $related->id) }}" 
                                           class="text-decoration-none text-dark">
                                            {{ Str::limit($related->judul, 40) }}
                                        </a>
                                    </h6>
                                    <small class="text-muted">
                                        {{ $related->created_at->format('d M Y') }}
                                    </small>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Quick Info -->
                    <div class="card shadow-sm mt-4">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">Informasi Wisata</h5>
                        </div>
                        <div class="card-body">
                            <div class="info-item d-flex justify-content-between mb-2">
                                <strong>Penulis:</strong>
                                <span>{{ $wisata->admin ? $wisata->admin->nama : 'Admin' }}</span>
                            </div>
                            <div class="info-item d-flex justify-content-between mb-2">
                                <strong>Dipublikasi:</strong>
                                <span>{{ $wisata->created_at->format('d M Y') }}</span>
                            </div>
                            <div class="info-item d-flex justify-content-between mb-2">
                                <strong>Diperbarui:</strong>
                                <span>{{ $wisata->updated_at->format('d M Y') }}</span>
                            </div>
                            <div class="info-item d-flex justify-content-between">
                                <strong>Status:</strong>
                                <span class="badge bg-success">Published</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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

.article-title {
    font-size: 2rem;
    font-weight: 700;
    color: #333;
    line-height: 1.3;
}

.article-meta {
    font-size: 0.9rem;
}

.article-content {
    font-size: 1.1rem;
    line-height: 1.8;
    color: #444;
    text-align: justify;
}

.share-buttons .btn {
    border-radius: 25px;
    padding: 8px 16px;
    font-size: 0.9rem;
}

.btn-facebook {
    background-color: #3b5998;
    color: white;
    border: none;
}

.btn-facebook:hover {
    background-color: #2d4373;
    color: white;
}

.btn-twitter {
    background-color: #1da1f2;
    color: white;
    border: none;
}

.btn-twitter:hover {
    background-color: #0d8bd9;
    color: white;
}

.btn-whatsapp {
    background-color: #25d366;
    color: white;
    border: none;
}

.btn-whatsapp:hover {
    background-color: #1ebe57;
    color: white;
}

.related-item:hover {
    background-color: #f8f9fa;
    border-radius: 8px;
    padding: 0.5rem;
    margin: -0.5rem;
}

.related-item a:hover {
    color: #667eea !important;
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
    
    .article-title {
        font-size: 1.5rem;
    }
    
    .share-buttons .btn {
        margin-bottom: 0.5rem;
        display: block;
        width: 100%;
    }
}
</style>
@endsection