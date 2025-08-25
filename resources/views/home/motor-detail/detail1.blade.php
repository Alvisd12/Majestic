@extends('index')

@section('content')
<!-- Tambahkan Style Khusus -->
<style>
  .main-content {
    padding: 40px 0;
    background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
    min-height: 100vh;
  }

  .product-image {
    background: linear-gradient(135deg, #fff 0%, #f8f9fa 100%);
    border-radius: 20px;
    padding: 30px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    text-align: center;
    margin-bottom: 30px;
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    border: 1px solid rgba(44, 90, 160, 0.1);
    position: relative;
    overflow: hidden;
  }

  .product-image::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, #2c5aa0 0%, #4fc3f7 50%, #ffc107 100%);
  }

  .product-image .image-container {
    position: relative;
    margin-bottom: 25px;
  }

  .product-image img {
    max-width: 100%;
    height: 280px;
    object-fit: cover;
    border-radius: 15px;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    transition: transform 0.3s ease;
  }

  .product-image img:hover {
    transform: scale(1.02);
  }

  .product-badge {
    position: absolute;
    top: 15px;
    right: 15px;
    background: linear-gradient(135deg, #ffc107 0%, #ff9800 100%);
    color: #000;
    padding: 8px 16px;
    border-radius: 25px;
    font-size: 12px;
    font-weight: bold;
    box-shadow: 0 4px 15px rgba(255, 193, 7, 0.4);
  }

  .product-title {
    color: #2c5aa0;
    font-weight: 700;
    font-size: 1.5rem;
    margin-bottom: 10px;
  }

  .product-subtitle {
    color: #666;
    font-size: 1rem;
    margin-bottom: 20px;
  }

  .product-features {
    display: flex;
    justify-content: space-around;
    flex-wrap: wrap;
    gap: 15px;
    margin-top: 20px;
  }

  .feature-item {
    text-align: center;
    flex: 1;
    min-width: 80px;
  }

  .feature-icon {
    width: 40px;
    height: 40px;
    background: linear-gradient(135deg, #2c5aa0 0%, #4fc3f7 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 8px;
    color: white;
    font-size: 18px;
  }

  .feature-text {
    font-size: 12px;
    color: #666;
    font-weight: 600;
  }

  .booking-form {
    background: linear-gradient(135deg, #fff 0%, #f8f9fa 100%);
    border-radius: 20px;
    padding: 30px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    margin-bottom: 30px;
    height: 100%;
    border: 1px solid rgba(44, 90, 160, 0.1);
    position: relative;
    overflow: hidden;
  }

  .booking-form::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, #ffc107 0%, #ff9800 50%, #2c5aa0 100%);
  }

  .booking-form h3 {
    color: #2c5aa0;
    font-weight: 700;
    margin-bottom: 25px;
    font-size: 1.6rem;
    text-align: center;
  }

  .price-section {
    background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
    padding: 20px;
    border-radius: 15px;
    margin-bottom: 25px;
    text-align: center;
    border: 2px solid rgba(44, 90, 160, 0.2);
  }

  .price-section .old-price {
    color: #999;
    text-decoration: line-through;
    font-size: 1.1rem;
    font-weight: 500;
  }

  .price-section .new-price {
    color: #2c5aa0;
    font-weight: 700;
    font-size: 1.8rem;
    margin-left: 10px;
  }

  .discount-badge {
    background: linear-gradient(135deg, #ff5722 0%, #f44336 100%);
    color: white;
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: bold;
    margin-left: 10px;
    display: inline-block;
  }

  .form-group {
    margin-bottom: 20px;
  }

  .form-label {
    font-weight: 600;
    color: #333;
    margin-bottom: 8px;
    font-size: 14px;
  }

  .form-control, .form-select {
    border: 2px solid #e0e0e0;
    border-radius: 12px;
    padding: 14px 18px;
    font-size: 14px;
    background: rgba(255, 255, 255, 0.8);
    transition: all 0.3s ease;
  }

  .form-control:focus, .form-select:focus {
    border-color: #2c5aa0;
    box-shadow: 0 0 0 0.3rem rgba(44, 90, 160, 0.15);
    background: white;
    transform: translateY(-1px);
  }

  .btn-order {
    background: linear-gradient(135deg, #ffc107 0%, #ff9800 100%);
    color: #000;
    border: none;
    padding: 14px 24px;
    font-weight: 700;
    font-size: 1rem;
    border-radius: 12px;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
  }

  .btn-order::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
    transition: left 0.5s;
  }

  .btn-order:hover::before {
    left: 100%;
  }

  .btn-order:hover {
    background: linear-gradient(135deg, #ff9800 0%, #f57c00 100%);
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(255, 193, 7, 0.4);
  }

  .btn-outline-primary {
    border: 2px solid #2c5aa0;
    color: #2c5aa0;
    background: transparent;
    padding: 14px 24px;
    font-weight: 700;
    font-size: 1rem;
    border-radius: 12px;
    transition: all 0.3s ease;
  }

  .btn-outline-primary:hover {
    background-color: #2c5aa0;
    color: white;
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(44, 90, 160, 0.3);
  }

  .info-card {
    background: linear-gradient(135deg, #fff 0%, #f8f9fa 100%);
    border-radius: 20px;
    padding: 35px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    margin-bottom: 30px;
    border: 1px solid rgba(44, 90, 160, 0.1);
    position: relative;
    overflow: hidden;
  }

  .info-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, #2c5aa0 0%, #4fc3f7 100%);
  }

  .info-card h4 {
    color: #2c5aa0;
    font-weight: 700;
    margin-bottom: 30px;
    font-size: 1.4rem;
    border-bottom: 3px solid #2c5aa0;
    padding-bottom: 12px;
    position: relative;
  }

  .info-card h4::after {
    content: '';
    position: absolute;
    bottom: -3px;
    left: 0;
    width: 50px;
    height: 3px;
    background: linear-gradient(90deg, #ffc107 0%, #ff9800 100%);
  }

  .info-list dt {
    font-weight: 700;
    color: #333;
    margin-bottom: 8px;
    font-size: 14px;
  }

  .info-list dd {
    color: #666;
    margin-bottom: 20px;
    padding-left: 15px;
    font-size: 14px;
    line-height: 1.6;
  }

  .terms-list {
    list-style: none;
    padding: 0;
  }

  .terms-list li {
    padding: 12px 0;
    border-bottom: 1px solid #eee;
    position: relative;
    padding-left: 30px;
    color: #333;
    font-size: 14px;
    line-height: 1.6;
    transition: all 0.3s ease;
  }

  .terms-list li:hover {
    background-color: rgba(44, 90, 160, 0.05);
    padding-left: 35px;
  }

  .terms-list li:before {
    content: "✓";
    color: #4caf50;
    font-weight: bold;
    position: absolute;
    left: 0;
    top: 12px;
    width: 20px;
    height: 20px;
    background: rgba(76, 175, 80, 0.1);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
  }

  .terms-list li:last-child {
    border-bottom: none;
  }
.highlight-text {
    background: linear-gradient(135deg, #ffebee 0%, #ffcdd2 100%);
    padding: 20px;
    border-left: 5px solid #f44336;
    border-radius: 10px;
    margin-top: 25px;
    font-weight: 600;
    color: #b71c1c; /* warna teks merah tua */
    font-size: 14px;
    line-height: 1.6;
    box-shadow: 0 4px 15px rgba(244, 67, 54, 0.2);
}


  .stats-row {
    display: flex;
    justify-content: space-between;
    gap: 20px;
    margin: 20px 0;
  }

  .stat-item {
    text-align: center;
    flex: 1;
    padding: 15px;
    background: rgba(44, 90, 160, 0.05);
    border-radius: 12px;
    border: 1px solid rgba(44, 90, 160, 0.1);
  }

  .stat-number {
    font-size: 1.5rem;
    font-weight: 700;
    color: #2c5aa0;
  }

  .stat-label {
    font-size: 12px;
    color: #666;
    margin-top: 5px;
  }

  @media (max-width: 768px) {
    .main-content {
      padding: 20px 0;
    }
    
    .product-image, .booking-form {
      margin-bottom: 20px;
      padding: 20px;
    }
    
    .info-card {
      padding: 20px;
    }

    .product-features {
      gap: 10px;
    }

    .stats-row {
      flex-direction: column;
      gap: 10px;
    }

    .form-control, .form-select {
      padding: 12px 15px;
    }
  }

  /* Animation untuk loading */
  .fade-in {
    animation: fadeIn 0.6s ease-in;
  }

  @keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
  }
</style>

<!-- Main Content Section -->
<section class="main-content">
  <div class="container">
    <div class="row">
      <!-- Product Image -->
      <div class="col-lg-6 col-md-12 fade-in">
        <div class="product-image">
          <div class="image-container">
            <div class="product-badge">PROMO</div>
            <img src="{{ asset('assets/images/motor1.jpg') }}" alt="Honda Beat Deluxe" class="img-fluid">
          </div>
          
          <h5 class="product-title">Honda Beat Deluxe</h5>
          <p class="product-subtitle">Motor matic terbaik untuk berkeliling Malang</p>
          
          <div class="stats-row">
            <div class="stat-item">
              <div class="stat-number">110cc</div>
              <div class="stat-label">Mesin</div>
            </div>
            <div class="stat-item">
              <div class="stat-number">4.2L</div>
              <div class="stat-label">Tangki</div>
            </div>
            <div class="stat-item">
              <div class="stat-number">2023</div>
              <div class="stat-label">Tahun</div>
            </div>
          </div>

          <div class="product-features">
            <div class="feature-item">
              <div class="feature-icon">
                <i class="fas fa-helmet-safety"></i>
              </div>
              <div class="feature-text">2 Helm SNI</div>
            </div>
            <div class="feature-item">
              <div class="feature-icon">
                <i class="fas fa-cloud-rain"></i>
              </div>
              <div class="feature-text">Jas Hujan</div>
            </div>
            <div class="feature-item">
              <div class="feature-icon">
                <i class="fas fa-key"></i>
              </div>
              <div class="feature-text">Kunci Cadangan</div>
            </div>
            <div class="feature-item">
              <div class="feature-icon">
                <i class="fas fa-gas-pump"></i>
              </div>
              <div class="feature-text">Full Tank</div>
            </div>
          </div>
        </div>
      </div>

      <!-- Booking Form -->
      <div class="col-lg-6 col-md-12 fade-in">
        <div class="booking-form">
          <h3><i class="fas fa-calendar-check me-2"></i>Booking Motor Sekarang</h3>
          
          <div class="price-section">
            <span class="old-price">Rp. 75.000</span>
            <span class="new-price">Rp. 70.000</span>
            <span class="discount-badge">HEMAT 7%</span>
            <small class="d-block text-muted mt-2">per 24 jam</small>
          </div>

          <form>
            <div class="form-group">
              <label class="form-label">
                <i class="fas fa-calendar me-1"></i>Pilih Tanggal Sewa
              </label>
              <input type="date" class="form-control" required>
            </div>

            <div class="form-group">
              <label class="form-label">
                <i class="fas fa-clock me-1"></i>Waktu Pengambilan
              </label>
              <select class="form-select" required>
                <option value="">Pilih Waktu</option>
                <option value="07:00">07:00 WIB</option>
                <option value="08:00">08:00 WIB</option>
                <option value="09:00">09:00 WIB</option>
                <option value="10:00">10:00 WIB</option>
                <option value="11:00">11:00 WIB</option>
                <option value="12:00">12:00 WIB</option>
                <option value="13:00">13:00 WIB</option>
                <option value="14:00">14:00 WIB</option>
                <option value="15:00">15:00 WIB</option>
                <option value="16:00">16:00 WIB</option>
                <option value="17:00">17:00 WIB</option>
                <option value="18:00">18:00 WIB</option>
                <option value="19:00">19:00 WIB</option>
                <option value="20:00">20:00 WIB</option>
                <option value="21:00">21:00 WIB</option>
              </select>
            </div>

            <div class="form-group">
              <label class="form-label">
                <i class="fas fa-hourglass-half me-1"></i>Durasi Sewa
              </label>
              <select class="form-select" required>
                <option value="">Pilih Durasi</option>
                <option value="1">1 Hari (24 jam)</option>
                <option value="2">2 Hari (48 jam)</option>
                <option value="3">3 Hari (72 jam)</option>
                <option value="7">1 Minggu (7 hari)</option>
              </select>
            </div>

            <div class="row g-3 mt-2">
              <div class="col-6">
                <a href="{{ route('harga_sewa') }}" class="btn btn-outline-primary w-100">
                  <i class="fas fa-list me-1"></i>Lihat Lainnya
                </a>
              </div>
              <div class="col-6">
                <button type="submit" class="btn btn-order w-100">
                  <i class="fas fa-motorcycle me-1"></i>Pesan Sekarang
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- Product Information -->
    <div class="row mt-4">
      <div class="col-12 fade-in">
        <div class="info-card">
          <h4><i class="fas fa-info-circle me-2"></i>Informasi Produk</h4>
          <dl class="row info-list">
            <dt class="col-sm-3"><i class="fas fa-motorcycle me-2"></i>Kategori Motor</dt>
            <dd class="col-sm-9">Honda Beat Deluxe (Matic)</dd>

            <dt class="col-sm-3"><i class="fas fa-id-card me-2"></i>Persyaratan</dt>
            <dd class="col-sm-9">KTP + SIM C Asli (Wajib Dibawa)</dd>

            <dt class="col-sm-3"><i class="fas fa-gift me-2"></i>Fasilitas Include</dt>
            <dd class="col-sm-9">2 Helm SNI, 2 Jas Hujan, Kunci Cadangan</dd>

            <dt class="col-sm-3"><i class="fas fa-clock me-2"></i>Jam Operasional</dt>
            <dd class="col-sm-9">07.00 - 21.00 WIB (Pengambilan & Pengembalian)</dd>

            <dt class="col-sm-3"><i class="fas fa-map-marker-alt me-2"></i>Lokasi Pickup</dt>
            <dd class="col-sm-9">Gg. Kaserin M I, Lesanpuro, Kec. Kedungkandang, Kota Malang, Jawa Timur</dd>

            <dt class="col-sm-3"><i class="fas fa-check-circle me-2"></i>Kondisi Motor</dt>
            <dd class="col-sm-9">Terawat, Bersih, Bensin Full Tank</dd>
          </dl>
        </div>
      </div>
    </div>

    <!-- Terms and Conditions -->
    <div class="row">
      <div class="col-12 fade-in">
        <div class="info-card">
          <h4><i class="fas fa-clipboard-list me-2"></i>Syarat & Ketentuan</h4>
          <ul class="terms-list">
            <li>Penyewa wajib berusia minimal 18 tahun dan memiliki SIM C aktif</li>
            <li>Wajib menunjukkan KTP dan SIM C asli saat pengambilan motor</li>
            <li>Bertanggung jawab penuh atas motor selama masa sewa berlangsung</li>
            <li>Waktu sewa dihitung per 24 jam (contoh: sewa pukul 10.00, kembali maksimal 10.00 keesokan hari)</li>
            <li>Pembatalan H-1 sebelum tanggal sewa masih diperbolehkan tanpa denda</li>
            <li>Pembatalan di hari-H (hari sewa) akan dikenakan potongan biaya 50%</li>
            <li>Tidak ada pengembalian uang untuk masa sewa yang sudah berjalan</li>
            <li>Kerusakan atau kehilangan motor menjadi tanggung jawab penyewa</li>
            <li>Wajib mengembalikan motor dalam kondisi bersih dan bahan bakar sesuai kondisi awal</li>
            <li>Keterlambatan pengembalian dikenakan denda Rp. 10.000 per jam</li>
          </ul>
          
          <div class="highlight-text">
            <i class="fas fa-exclamation-triangle me-2"></i>
            <strong>Penting:</strong> Dengan melakukan pemesanan motor di layanan kami, penyewa dianggap telah membaca, memahami, dan menyetujui seluruh syarat dan ketentuan yang berlaku.
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Additional Scripts -->
<script>
  // Set minimum date to today
  document.addEventListener('DOMContentLoaded', function() {
    const dateInput = document.querySelector('input[type="date"]');
    if (dateInput) {
      const today = new Date().toISOString().split('T')[0];
      dateInput.min = today;
    }

    // Add fade-in animation to elements
    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('fade-in');
        }
      });
    });

    document.querySelectorAll('.info-card').forEach(el => {
      observer.observe(el);
    });
  });

  // Form validation and interaction
  document.querySelector('form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    // Simple validation
    const requiredFields = this.querySelectorAll('[required]');
    let isValid = true;
    
    requiredFields.forEach(field => {
      if (!field.value) {
        isValid = false;
        field.style.borderColor = '#f44336';
      } else {
        field.style.borderColor = '#e0e0e0';
      }
    });
    
    if (isValid) {
      // Simulate booking process
      const btn = this.querySelector('.btn-order');
      const originalText = btn.innerHTML;
      btn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Memproses...';
      btn.disabled = true;
      
      setTimeout(() => {
        alert('Booking berhasil! Kami akan menghubungi Anda segera.');
        btn.innerHTML = originalText;
        btn.disabled = false;
      }, 2000);
    }
  });
</script>
@endsection