@extends('index')

@section('content')
<div class="container-fluid vh-100 d-flex align-items-center justify-content-center" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
    <div class="row justify-content-center w-100">
        <div class="col-md-6 col-lg-4">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-body p-5 text-center">
                    <div class="mb-4">
                        <i class="fas fa-exclamation-triangle text-warning" style="font-size: 4rem;"></i>
                    </div>
                    
                    <h3 class="card-title mb-3 text-dark fw-bold">Sesi Telah Berakhir</h3>
                    
                    <p class="text-muted mb-4">
                        Anda telah logout dari sistem. Untuk mengakses halaman ini, silakan login kembali.
                    </p>
                    
                    <div class="d-grid gap-2">
                        <a href="{{ route('login') }}" class="btn btn-primary btn-lg rounded-pill">
                            <i class="fas fa-sign-in-alt me-2"></i>Login Kembali
                        </a>
                        <a href="{{ route('home') }}" class="btn btn-outline-secondary rounded-pill">
                            <i class="fas fa-home me-2"></i>Kembali ke Beranda
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.card {
    backdrop-filter: blur(10px);
    background: rgba(255, 255, 255, 0.95);
}

.btn-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    transition: all 0.3s ease;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
}

.btn-outline-secondary {
    border-color: #6c757d;
    color: #6c757d;
    transition: all 0.3s ease;
}

.btn-outline-secondary:hover {
    background-color: #6c757d;
    border-color: #6c757d;
    transform: translateY(-2px);
}
</style>

<script>
// Prevent back button on this page
document.addEventListener('DOMContentLoaded', function() {
    if (window.history && window.history.pushState) {
        window.history.pushState(null, null, window.location.href);
        window.addEventListener('popstate', function() {
            window.history.pushState(null, null, window.location.href);
        });
    }
});
</script>
@endsection
