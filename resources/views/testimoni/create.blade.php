@extends('index')

@section('content')

<style>
    .section-title {
        font-size: 2.9rem;
        font-weight: bold;
        color: #333;
        margin-bottom: 10px;
    }

    .decorative-line {
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 30px;
        margin-top: -5px;
    }

    .decorative-line::before,
    .decorative-line::after {
        content: '';
        flex: 1;
        height: 2px;
        background-color: #1E90FF;
        max-width: 150px;
    }

    .decorative-line .dot {
        width: 16px;
        height: 16px;
        background-color: #FFF56C;
        border-radius: 50%;
        margin: 0 20px;
    }

    .testimoni-form {
        background: white;
        border-radius: 15px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        padding: 40px;
        margin-bottom: 30px;
    }

    .form-label {
        font-weight: 600;
        color: #333;
        margin-bottom: 8px;
    }

    .form-control, .form-select {
        border-radius: 8px;
        border: 2px solid #e9ecef;
        padding: 12px 15px;
        transition: all 0.3s ease;
    }

    .form-control:focus, .form-select:focus {
        border-color: #007bff;
        box-shadow: 0 0 0 0.2rem rgba(0,123,255,0.25);
    }

    .rating-container {
        text-align: center;
        padding: 20px;
        background: #f8f9fa;
        border-radius: 10px;
        margin: 20px 0;
    }

    .rating {
        display: flex;
        justify-content: center;
        gap: 10px;
        margin-bottom: 15px;
    }

    .rating .star {
        display: inline-block;
        cursor: pointer;
        margin: 0 2px;
    }

    .rating .star i {
        font-size: 2.5rem;
        color: #e0e0e0;
        transition: all 0.3s ease;
    }

    .rating .star:hover i {
        transform: scale(1.1);
    }

    .rating .star.selected i {
        color: #ffd700 !important;
    }

    .rating .star.hover i {
        color: #ffd700 !important;
    }

    .rating .star.active i {
        color: #ffd700 !important;
    }

    .rating-text {
        font-size: 1.1rem;
        font-weight: 600;
        color: #666;
        transition: all 0.3s ease;
    }

    .rating-text.active {
        color: #007bff;
    }

    .booking-info {
        background: linear-gradient(135deg, #007bff, #0056b3);
        color: white;
        padding: 20px;
        border-radius: 10px;
        margin-bottom: 30px;
    }

    .booking-info h5 {
        margin-bottom: 15px;
        font-weight: 600;
    }

    .booking-detail {
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
    }

    .booking-detail:last-child {
        margin-bottom: 0;
    }

    .btn-submit {
        background: linear-gradient(135deg, #007bff, #0056b3);
        border: none;
        padding: 15px 40px;
        font-size: 1.1rem;
        font-weight: 600;
        border-radius: 50px;
        transition: all 0.3s ease;
    }

    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 15px rgba(0,123,255,0.3);
    }

    @media (max-width: 768px) {
        .testimoni-form {
            padding: 25px;
        }
        
        .rating .fa-star {
            font-size: 2rem;
            gap: 5px;
        }
    }
</style>

<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="hero-content text-center">
                    <h1 class="section-title">Berikan Testimoni</h1>
                    <div class="decorative-line mx-auto">
                        <div class="dot"></div>
                    </div>
                    <p class="hero-subtitle">Bagikan pengalaman Anda menggunakan layanan kami</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Main Content -->
<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <!-- Booking Information -->
                <div class="booking-info">
                    <h5><i class="fas fa-motorcycle me-2"></i>Detail Peminjaman</h5>
                    <div class="booking-detail">
                        <span>Motor:</span>
                        <strong>{{ $booking->jenis_motor }}</strong>
                    </div>
                    <div class="booking-detail">
                        <span>Tanggal Rental:</span>
                        <strong>{{ \Carbon\Carbon::parse($booking->tanggal_rental)->format('d M Y') }}</strong>
                    </div>
                    <div class="booking-detail">
                        <span>Durasi:</span>
                        <strong>{{ $booking->durasi_sewa }} hari</strong>
                    </div>
                    <div class="booking-detail">
                        <span>Total Biaya:</span>
                        <strong>Rp {{ number_format($booking->total_harga, 0, ',', '.') }}</strong>
                    </div>
                </div>

                <!-- Testimoni Form -->
                <div class="testimoni-form">
                    <form action="{{ route('testimoni.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="booking_id" value="{{ $booking->id }}">
                        
                        <div class="mb-4">
                            <label class="form-label"><i class="fas fa-user me-2"></i>Nama Anda</label>
                            <input type="text" class="form-control" name="nama" 
                                   placeholder="Masukkan nama lengkap Anda" 
                                   value="{{ auth()->user()->nama ?? '' }}" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label"><i class="fas fa-comment me-2"></i>Testimoni</label>
                            <textarea class="form-control" name="testimoni" 
                                      placeholder="Ceritakan pengalaman Anda menggunakan layanan kami..." 
                                      rows="5" required></textarea>
                            <div class="form-text">Minimal 10 karakter</div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label"><i class="fas fa-star me-2"></i>Rating Layanan</label>
                            <div class="rating-container">
                                <div class="rating" id="rating">
                                    <span class="star-rating" data-value="1" style="font-size: 2.5rem; color: #e0e0e0; cursor: pointer; margin: 0 5px;">☆</span>
                                    <span class="star-rating" data-value="2" style="font-size: 2.5rem; color: #e0e0e0; cursor: pointer; margin: 0 5px;">☆</span>
                                    <span class="star-rating" data-value="3" style="font-size: 2.5rem; color: #e0e0e0; cursor: pointer; margin: 0 5px;">☆</span>
                                    <span class="star-rating" data-value="4" style="font-size: 2.5rem; color: #e0e0e0; cursor: pointer; margin: 0 5px;">☆</span>
                                    <span class="star-rating" data-value="5" style="font-size: 2.5rem; color: #e0e0e0; cursor: pointer; margin: 0 5px;">☆</span>
                                </div>
                                <div class="rating-text" id="rating-text">Pilih rating Anda</div>
                            </div>
                            <input type="hidden" name="rating" id="rating-value" required>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                            <a href="{{ route('user.bookings') }}" class="btn btn-outline-secondary btn-lg me-md-2">
                                <i class="fas fa-arrow-left me-2"></i>Kembali
                            </a>
                            <button type="submit" class="btn btn-primary btn-lg btn-submit">
                                <i class="fas fa-paper-plane me-2"></i>Kirim Testimoni
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

<!-- Success Message Container -->
<div id="success-container"></div>

<!-- Success Modal -->
<div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="successModalLabel">
                    <i class="fas fa-check-circle me-2"></i>Testimoni Berhasil Dikirim!
                </h5>
            </div>
            <div class="modal-body text-center">
                <div class="mb-3">
                    <i class="fas fa-thumbs-up text-success" style="font-size: 3rem;"></i>
                </div>
                <p class="mb-0">Terima kasih atas testimoni Anda! Testimoni akan ditinjau oleh admin dan akan ditampilkan setelah disetujui.</p>
            </div>
            <div class="modal-footer justify-content-center">
                <a href="{{ route('user.bookings') }}" class="btn btn-primary btn-lg">
                    <i class="fas fa-arrow-left me-2"></i>Kembali ke Booking Saya
                </a>
            </div>
        </div>
    </div>
</div>

@section('additional-scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM loaded - setting up star rating...');
    
    const ratingValue = document.getElementById("rating-value");
    const ratingText = document.getElementById("rating-text");
    const stars = document.querySelectorAll('.star-rating');
    
    let selectedRating = 0;
    const ratingTexts = {
        1: "Sangat Buruk",
        2: "Buruk", 
        3: "Cukup",
        4: "Baik",
        5: "Sangat Baik"
    };
    
    console.log('Found stars:', stars.length);
    
    // Add click event to each star
    stars.forEach(function(star) {
        star.addEventListener('click', function() {
            const rating = parseInt(this.getAttribute('data-value'));
            selectedRating = rating;
            
            console.log('Star clicked! Rating:', rating);
            
            // Update all stars
            stars.forEach(function(s, index) {
                if (index < rating) {
                    s.innerHTML = '★';
                    s.style.color = '#ffd700';
                } else {
                    s.innerHTML = '☆';
                    s.style.color = '#e0e0e0';
                }
            });
            
            // Update form
            ratingValue.value = rating;
            ratingText.textContent = ratingTexts[rating];
            ratingText.style.color = '#007bff';
        });
        
        // Add hover effect
        star.addEventListener('mouseenter', function() {
            const rating = parseInt(this.getAttribute('data-value'));
            
            stars.forEach(function(s, index) {
                if (index < rating) {
                    s.style.color = '#ffd700';
                } else {
                    s.style.color = '#e0e0e0';
                }
            });
        });
        
        star.addEventListener('mouseleave', function() {
            // Reset to selected rating
            stars.forEach(function(s, index) {
                if (index < selectedRating) {
                    s.style.color = '#ffd700';
                } else {
                    s.style.color = '#e0e0e0';
                }
            });
        });
    });

    // Enhanced form validation
    document.querySelector('form').addEventListener('submit', function(e) {
        const name = document.querySelector('input[name="nama"]').value.trim();
        const testimoni = document.querySelector('textarea[name="testimoni"]').value.trim();
        const rating = ratingValue.value;
        
        let errors = [];
        
        if (!name || name.length < 2) {
            errors.push('Nama harus diisi minimal 2 karakter');
        }
        
        if (!testimoni || testimoni.length < 10) {
            errors.push('Testimoni harus diisi minimal 10 karakter');
        }
        
        if (!rating) {
            errors.push('Rating harus dipilih (klik salah satu bintang)');
        }
        
        if (errors.length > 0) {
            e.preventDefault();
            
            // Create custom alert modal
            const alertHtml = `
                <div class="modal fade" id="validationModal" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header bg-danger text-white">
                                <h5 class="modal-title"><i class="fas fa-exclamation-triangle me-2"></i>Data Tidak Lengkap</h5>
                            </div>
                            <div class="modal-body">
                                <p class="mb-2">Mohon lengkapi data berikut:</p>
                                <ul class="list-unstyled">
                                    ${errors.map(error => `<li class="text-danger"><i class="fas fa-times me-2"></i>${error}</li>`).join('')}
                                </ul>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Mengerti</button>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            
            // Remove existing modal if any
            const existingModal = document.getElementById('validationModal');
            if (existingModal) {
                existingModal.remove();
            }
            
            // Add new modal
            document.body.insertAdjacentHTML('beforeend', alertHtml);
            const validationModal = new bootstrap.Modal(document.getElementById('validationModal'));
            validationModal.show();
            
            return;
        }
        
        // Show loading state
        const submitBtn = document.querySelector('.btn-submit');
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Mengirim...';
        submitBtn.disabled = true;
    });

    // Show success message if form was submitted
    <?php if(session('success')): ?>
    showSuccessMessage();
    <?php endif; ?>

    function showSuccessMessage() {
        const successHtml = `
            <div class="position-fixed top-0 start-50 translate-middle-x mt-3" style="z-index: 9999;">
                <div class="alert alert-success alert-dismissible fade show shadow-lg" role="alert" style="min-width: 400px;">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-check-circle me-3" style="font-size: 2rem;"></i>
                        <div class="flex-grow-1">
                            <h5 class="alert-heading mb-1">Testimoni Berhasil Dikirim!</h5>
                            <p class="mb-2">Terima kasih atas testimoni Anda! Testimoni akan ditinjau oleh admin dan akan ditampilkan setelah disetujui.</p>
                            <div class="mt-3">
                                <a href="{{ route('user.bookings') }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-arrow-left me-1"></i>Kembali ke Booking Saya
                                </a>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn-close" onclick="this.parentElement.parentElement.remove()"></button>
                </div>
            </div>
        `;
        
        document.getElementById('success-container').innerHTML = successHtml;
        
        // Auto-hide after 8 seconds
        setTimeout(function() {
            const successAlert = document.querySelector('.alert-success');
            if (successAlert) {
                successAlert.style.transition = 'opacity 0.5s ease';
                successAlert.style.opacity = '0';
                setTimeout(function() {
                    successAlert.remove();
                }, 500);
            }
        }, 8000);
    }
});
</script>
@endsection
