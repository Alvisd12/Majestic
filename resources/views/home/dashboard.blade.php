@extends('index')

@section('content')

<style>
    :root {
        --primary-yellow: #FFD700;
        --secondary-blue: #1E90FF;
        --accent-orange: #FF8C00;
    }

    .section-title {
        font-size: 2.5rem;
        font-weight: bold;
        color: #333;
        margin-bottom: 30px;
    }

    .about-section {
        padding: 80px 0;
        background: #fff;
    }

    .facility-section {
        padding: 80px 0;
        background: linear-gradient(135deg, #FFE55C 0%, #FFD700 100%);
    }

    .facility-card {
        background: white;
        border-radius: 15px;
        padding: 30px 20px;
        text-align: center;
        box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        margin-bottom: 30px;
        transition: transform 0.3s ease;
        height: 100%;
    }

    .facility-card:hover {
        transform: translateY(-10px);
    }

    .facility-icon {
        width: 60px;
        height: 60px;
        background: var(--secondary-blue);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        color: white;
        font-size: 24px;
    }

    .facility-card h5 {
        font-weight: bold;
        margin-bottom: 15px;
        color: #333;
    }

    .motor-section {
        padding: 80px 0;
        background: #f8f9fa;
    }

    .motor-card {
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        transition: transform 0.3s ease;
        margin-bottom: 30px;
        background: white;
    }

    .motor-card:hover {
        transform: scale(1.05);
    }

    .motor-card img {
        width: 100%;
        height: 250px;
        object-fit: cover;
    }

    .motor-price {
        background: var(--accent-orange);
        color: white;
        font-weight: bold;
        padding: 15px;
        text-align: center;
    }

    .wisata-section {
        padding: 80px 0;
        background: #fff;
    }

    .wisata-card {
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        transition: transform 0.3s ease;
        background: white;
        height: 100%;
    }

    .wisata-card:hover {
        transform: translateY(-10px);
    }

    .wisata-card img {
        width: 100%;
        height: 200px;
        object-fit: cover;
    }

    .wisata-card .card-body {
        padding: 25px;
    }

    .wisata-card .card-title {
        font-weight: bold;
        color: #333;
        margin-bottom: 15px;
    }

    .testimoni-section {
        padding: 80px 0;
        background: linear-gradient(135deg, var(--secondary-blue) 0%, #4169E1 100%);
        color: white;
    }

    .testimoni-card {
        background: white;
        color: #333;
        border-radius: 15px;
        padding: 30px;
        box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        margin-bottom: 30px;
        height: 100%;
    }

    .stars {
        color: #FFD700;
        margin-bottom: 15px;
        font-size: 18px;
    }

    .btn-sewa {
        background: var(--secondary-blue);
        border: none;
        border-radius: 25px;
        color: white;
        font-weight: bold;
        padding: 15px 40px;
        font-size: 18px;
        transition: all 0.3s ease;
    }

    .btn-sewa:hover {
        background: #1873CC;
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(30, 144, 255, 0.3);
    }

    .wisata-subtitle {
        color: var(--accent-orange);
        font-size: 1.8rem;
        font-weight: 600;
        margin-bottom: 40px;
    }
</style>

<!-- Tentang Kami -->
<section class="about-section">
    <div class="container">
        <div class="text-center">
            <h2 class="section-title">Tentang Kami</h2>
            <p class="lead mb-5">
                Rental Motor Majestic adalah pilihan tepat untuk Anda yang ingin menyewa motor<br>
                dengan nyaman dan aman. Kami menyediakan motor yang selalu dirawat dengan baik, proses sewa yang mudah,<br>
                serta fasilitas lengkap seperti helm dan jas hujan. Dengan pelayanan yang ramah dan harga yang terjangkau,<br>
                kami siap mendukung setiap perjalanan Anda.
            </p>
        </div>
        <div class="row g-4">
            <div class="col-md-4">
                <img src="{{ asset('assets/images/foto4.png') }}" class="img-fluid rounded shadow" alt="Motor 1">
            </div>
            <div class="col-md-4">
                <img src="{{ asset('assets/images/foto2.jpg') }}" class="img-fluid rounded shadow" alt="Motor 2">
            </div>
            <div class="col-md-4">
                <img src="{{ asset('assets/images/foto5.png') }}" class="img-fluid rounded shadow" alt="Motor 3">
            </div>
        </div>
    </div>
</section>

<!-- Fasilitas & Layanan -->
<section class="facility-section">
    <div class="container">
        <h2 class="section-title text-center">Fasilitas & Layanan Kami</h2>
        <div class="row g-4">
            <div class="col-lg-4 col-md-6">
                <div class="facility-card">
                    <div class="facility-icon">🪖</div>
                    <h5>Fasilitas 2 helm</h5>
                    <p class="text-muted mb-0">Helm berkualitas untuk keamanan perjalanan Anda dengan standar SNI</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="facility-card">
                    <div class="facility-icon">🧥</div>
                    <h5>Fasilitas 2 jas hujan</h5>
                    <p class="text-muted mb-0">Jas hujan untuk melindungi dari cuaca buruk selama perjalanan</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="facility-card">
                    <div class="facility-icon">🏍️</div>
                    <h5>Motor terjamin</h5>
                    <p class="text-muted mb-0">Motor selalu dalam kondisi prima dan terawat dengan service rutin</p>
                </div>
            </div>
            <div class="col-lg-6 col-md-6">
                <div class="facility-card">
                    <div class="facility-icon">😊</div>
                    <h5>Pelayanan ramah</h5>
                    <p class="text-muted mb-0">Tim yang siap membantu dengan pelayanan terbaik 24/7</p>
                </div>
            </div>
            <div class="col-lg-6 col-md-6">
                <div class="facility-card">
                    <div class="facility-icon">💰</div>
                    <h5>Harga sewa terjangkau</h5>
                    <p class="text-muted mb-0">Tarif kompetitif untuk semua kalangan tanpa biaya tersembunyi</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Sewa Motor Sekarang -->
<section class="motor-section">
    <div class="container">
        <h2 class="section-title text-center">Sewa Motor Sekarang</h2>
        <div class="row g-4">
            @for ($i = 1; $i <= 6; $i++)
                <div class="col-lg-4 col-md-6">
                    <div class="motor-card">
                        <img src="{{ asset("assets/images/motor{$i}.jpg") }}" class="card-img-top" alt="Motor {{ $i }}">
                        <div class="motor-price">Harga: Rp 70K</div>
                    </div>
                </div>
            @endfor
        </div>
        <div class="text-center mt-5">
            <button class="btn btn-sewa btn-lg">SEWA</button>
        </div>
    </div>
</section>

<!-- Rekomendasi Destinasi Wisata -->
<section class="wisata-section">
    <div class="container">
        <h2 class="section-title text-center">Rekomendasi Destinasi Wisata</h2>
        <h3 class="text-center wisata-subtitle">Malang & Batu</h3>
        <div class="row g-4">
            <div class="col-lg-4 col-md-6">
                <div class="wisata-card">
                    <img src="{{ asset('assets/images/bukit-nirwana.jpg') }}" class="card-img-top" alt="Bukit Nirwana">
                    <div class="card-body">
                        <h5 class="card-title">Bukit Nirwana</h5>
                        <p class="card-text">Pemandangan hijau memukau yang akan membuat perjalanan Anda tak terlupakan. Tempat yang sempurna untuk menikmati sunrise dan sunset.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="wisata-card">
                    <img src="{{ asset('assets/images/mata-air-sumber.jpg') }}" class="card-img-top" alt="Mata Air Sumber Sirah">
                    <div class="card-body">
                        <h5 class="card-title">Mata Air Sumber Sirah</h5>
                        <p class="card-text">Wisata air jernih alami yang menyegarkan dan cocok untuk bersantai. Air yang dingin dan segar langsung dari pegunungan.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="wisata-card">
                    <img src="{{ asset('assets/images/pantai-parang.jpg') }}" class="card-img-top" alt="Pantai Parang Dowo">
                    <div class="card-body">
                        <h5 class="card-title">Pantai Parang Dowo</h5>
                        <p class="card-text">Pantai pasir putih dan tenang, sempurna untuk menikmati sunset. Lokasi yang instagramable dengan pemandangan laut yang indah.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Testimoni -->
<section class="testimoni-section">
    <div class="container">
        <h2 class="section-title text-center">Testimoni</h2>
        <div class="row g-4">
            <div class="col-lg-4 col-md-6">
                <div class="testimoni-card">
                    <div class="stars">⭐⭐⭐⭐⭐</div>
                    <p class="mb-3">"Motor bersih dan nyaman, pelayanan sangat memuaskan. Recommended banget untuk yang mau jalan-jalan di Malang! Proses penyewaan cepat dan mudah."</p>
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                            <strong>A</strong>
                        </div>
                        <div>
                            <strong>Ahmad Ridwan</strong>
                            <small class="d-block text-muted">Jakarta</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="testimoni-card">
                    <div class="stars">⭐⭐⭐⭐⭐</div>
                    <p class="mb-3">"Harga terjangkau dan pelayanan cepat. Motor dalam kondisi prima, cocok untuk touring keliling Batu dan Malang. Fasilitas lengkap dengan helm dan jas hujan."</p>
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                            <strong>S</strong>
                        </div>
                        <div>
                            <strong>Sari Dewi</strong>
                            <small class="d-block text-muted">Surabaya</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="testimoni-card">
                    <div class="stars">⭐⭐⭐⭐⭐</div>
                    <p class="mb-3">"Proses mudah dan terpercaya. Fasilitas lengkap dengan helm dan jas hujan. Pasti akan sewa lagi! Staff nya ramah dan membantu memberikan rekomendasi tempat wisata."</p>
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle bg-warning text-white d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                            <strong>B</strong>
                        </div>
                        <div>
                            <strong>Budi Santoso</strong>
                            <small class="d-block text-muted">Malang</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add animation on scroll
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);

    // Apply animation to cards
    document.querySelectorAll('.facility-card, .motor-card, .wisata-card, .testimoni-card').forEach(el => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(30px)';
        el.style.transition = 'all 0.6s ease';
        observer.observe(el);
    });

    // Button SEWA click handler
    document.querySelector('.btn-sewa')?.addEventListener('click', function() {
        // Redirect ke halaman login atau register
        window.location.href = "{{ route('login') }}";
    });
});
</script>

@endsection