@extends('index')

@section('content')

<style>
    :root {
        --primary-yellow: #FFD700;
        --secondary-blue: #1E90FF;
        --accent-orange: #FF8C00;
    }

    .section-title-tentangkami{
        font-size: 2rem;
        font-weight: bold;
        color: #0466C8;
        margin-bottom: 20px;
    }

    .section-title{
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
        background-color: var(--secondary-blue);
        max-width: 150px;
    }

    .decorative-line .dot {
        width: 16px;
        height: 16px;
        background-color: #FFF56C;
        border-radius: 50%;
        margin: 0 20px;
    }

    .section-description {
        font-size: 1rem;
        font-weight: 500;
        line-height: 1.6;
        color: #333333;
        max-width: 800px;
        margin: 0 auto;
        text-align: center;
    }

    .about-section {
        padding: 80px 0;
        background: #fff;
    }

    /* Carousel Container */
    .tentangkami-carousel-wrapper {
        position: relative;
        max-width: 100%;
        margin-top: 50px;
        overflow: hidden;
    }

    /* Carousel Track */
    .tentangkami-carousel {
        display: flex;
        transition: transform 0.8s ease-in-out;
        gap: 0;
    }

    /* Carousel Slide - Contains 3 photos */
    .carousel-slide {
        min-width: 100%;
        display: flex;
        justify-content: center;
        gap: 40px;
        padding: 10px;
        box-sizing: border-box;
    }

    /* Individual Photo Card */
    .photo-card {
        flex: 1;
        max-width: 250px;
        background: white;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        transition: transform 0.3s ease;
    }

    .photo-card:hover {
        transform: translateY(-10px);
    }

    /* Image styling - ukuran asli dengan aspect ratio terjaga */
    .photo-card img {
        width: 100%;
        height: auto;
        min-height: 250px;
        max-height: none;
        object-fit: contain;
        display: block;
        background: #f8f9fa;
    }

    /* Carousel Navigation Buttons */
    .carousel-btn {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background: rgba(255, 255, 255, 0.9);
        border: none;
        font-size: 2rem;
        color: var(--secondary-blue);
        z-index: 10;
        cursor: pointer;
        padding: 15px 20px;
        border-radius: 50%;
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        transition: all 0.3s ease;
    }

    .carousel-btn:hover {
        background: white;
        color: var(--accent-orange);
        transform: translateY(-50%) scale(1.1);
    }

    .carousel-btn.left {
        left: 20px;
    }

    .carousel-btn.right {
        right: 20px;
    }

    /* Carousel Indicators */
    .carousel-indicators {
        display: flex;
        justify-content: center;
        gap: 10px;
        margin-top: 30px;
    }

    .carousel-indicator {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: #ddd;
        cursor: pointer;
        transition: background 0.3s ease;
    }

    .carousel-indicator.active {
        background: var(--secondary-blue);
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .carousel-slide {
            flex-direction: column;
            align-items: center;
            gap: 25px;
        }
        
        .photo-card {
            max-width: 90%;
        }
        
        .carousel-btn {
            padding: 10px 15px;
            font-size: 1.5rem;
        }
        
        .carousel-btn.left {
            left: 10px;
        }
        
        .carousel-btn.right {
            right: 10px;
        }
    }

    @media (max-width: 576px) {
        .photo-card img {
            min-height: 250px;
            object-fit: contain;
        }
    }
    
.facility-section {
    padding: 35px 0; /* Further reduced from 50px */
    background:	#0466C8;
}

.facility-grid {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 1.2rem; /* Further reduced from 1.5rem */
    max-width: 950px; /* Further reduced from 1100px */
    margin: 0 auto;
}

.facility-card {
    background: white;
    border-radius: 15px; /* Further reduced from 18px */
    width: 240px; /* Further reduced from 280px */
    padding: 20px 15px; /* Further reduced from 25px 20px */
    text-align: center;
    box-shadow: 2px 2px 6px rgba(0, 0, 0, 0.08); /* Further reduced shadow */
    transition: transform 0.3s ease;
    flex-shrink: 0;
}

.facility-card:hover {
    transform: translateY(-3px); /* Further reduced from -5px */
}

.facility-icon {
    width: 60px; /* Further reduced from 70px */
    height: 60px; /* Further reduced from 70px */
    background: #FFCD29;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 15px; /* Further reduced from 18px */
}

.facility-icon iconify-icon {
    font-size: 28px; /* Further reduced from 32px */
    color: white;
}

.facility-card h5 {
    font-weight: bold;
    font-size: 18px; /* Further reduced from 20px */
    margin-bottom: 10px; /* Further reduced from 12px */
    color: #000;
    line-height: 1.1; /* Further reduced */
}

.facility-card p {
    font-size: 13px; /* Further reduced from 15px */
    font-weight: 400;
    color: #222;
    margin: 0;
    line-height: 1.3; /* Further reduced */
}

/* Responsive Design */
@media (max-width: 1200px) {
    .facility-grid {
        max-width: 800px; /* Further reduced */
        gap: 1rem; /* Further reduced */
    }
    
    .facility-card {
        width: 230px; /* Further reduced */
    }
}

@media (max-width: 768px) {
    .facility-section {
        padding: 30px 0; /* Further reduced from 40px */
    }
    
    .facility-grid {
        gap: 0.8rem; /* Further reduced */
        padding: 0 10px; /* Further reduced padding */
    }
    
    .facility-card {
        width: 75%; /* Further reduced from 80% */
        max-width: 250px; /* Reduced */
        padding: 18px 12px; /* Further reduced */
    }
    
    .facility-icon {
        width: 50px; /* Further reduced from 60px */
        height: 50px; /* Further reduced from 60px */
        margin-bottom: 10px; /* Further reduced */
    }
    
    .facility-icon iconify-icon {
        font-size: 24px; /* Further reduced from 28px */
    }

    .facility-card h5 {
        font-size: 16px; /* Further reduced from 18px */
    }

    .facility-card p {
        font-size: 12px; /* Further reduced from 14px */
    }
}

@media (max-width: 576px) {
    .facility-section {
        padding: 25px 0; /* Further reduced */
    }
    
    .facility-card {
        width: 80%; /* Adjusted for mobile */
        padding: 15px 12px; /* Further reduced */
    }

    .facility-card h5 {
        font-size: 15px; /* Further reduced from 17px */
    }

    .facility-card p {
        font-size: 11px; /* Further reduced from 13px */
    }
    
    .facility-icon {
        width: 45px; /* Further reduced */
        height: 45px;
        margin-bottom: 8px; /* Further reduced */
    }
    
    .facility-icon iconify-icon {
        font-size: 20px; /* Further reduced */
    }
}


.section-title {
    font-size: 2rem;
    font-weight: 700;
    text-align: center;
    color: #FFF56C;
    margin-bottom: 40px;
}

.wisata-section {
    padding: 80px 0;
    background-color: #fff;
}

.judul-wisata {
    font-size: 32px;
    font-weight: bold;
    color: #0052A0;
}

.subjudul-wisata {
    font-size: 24px;
    font-weight: bold;
    color: #F7C200;
    margin-top: 10px;
}

.card-wrapper {
    position: relative;
    height: 100%;
    max-width: 280px;
    margin: 0 auto;
}

.card-back {
    position: absolute;
    top: 12px;
    left: 12px;
    width: 100%;
    height: 100%;
    border-radius: 20px;
    background-color: #007BBD;
    z-index: 0;
}

.wisata-card {
    background-color: #FEF16C;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
    display: flex;
    flex-direction: column;
    height: 100%;
    position: relative;
    z-index: 1;
    transition: transform 0.3s ease;
}

.wisata-card:hover {
    transform: translateY(-6px);
}

.wisata-card img {
    width: 100%;
    height: 140px;
    object-fit: cover;
}

.wisata-card-body {
    padding: 15px;
    background-color: #FEF16C;
    flex-grow: 1;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

.wisata-card-body h5 {
    font-weight: bold;
    font-size: 16px;
    margin-bottom: 10px;
    color: #000;
}

.wisata-card-body p {
    color: #222;
    font-size: 13px;
    margin-bottom: 10px;
    flex-grow: 1;
}

.lokasi {
    font-size: 12px;
    color: #333;
    margin-top: 10px;
}

.lokasi i {
    margin-right: 6px;
    color: #000;
}

.lokasi a {
    color: #000;
    text-decoration: none;
}

.lokasi a:hover {
    text-decoration: underline;
}

.testimoni-section {
  padding: 30px 30px 45px 30px;
  background: linear-gradient(135deg, #1e3c72 0%, #2a5298 50%, #4169E1 100%);
  position: relative;
  overflow: hidden;
  color: #333;
  margin: 60px 30px 100px 30px;
  border-radius: 18px;
}

.testimoni-section::before,
.testimoni-section::after {
  display: none;
}

.testimoni-section .container {
  position: relative;
  z-index: 2;
}

.testimoni-title {
  color: #FFF56C;
  font-size: 2rem;
  font-weight: 700;
  text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
  margin-bottom: 2.5rem;
  position: relative;
  z-index: 2;
  text-align: center;
}

.testimoni-title::after {
  content: '';
  position: absolute;
  bottom: -10px;
  left: 50%;
  transform: translateX(-50%);
  width: 70px;
  height: 2.5px;
  background: linear-gradient(90deg, #FFF56C, #FFD700);
  border-radius: 2px;
}

.testimoni-card {
  background: rgba(255, 255, 255, 0.98);
  backdrop-filter: blur(10px);
  color: #333;
  border-radius: 12px;
  padding: 20px;
  box-shadow: 
    0 8px 20px rgba(0, 0, 0, 0.15),
    0 4px 10px rgba(0, 0, 0, 0.1);
  border: 1px solid rgba(255, 255, 255, 0.2);
  transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
  position: relative;
  overflow: hidden;
  height: 100%;
  min-height: 260px;
  z-index: 2;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
}

.testimoni-card::before {
  display: none;
}

.testimoni-card:hover {
  transform: translateY(-6px) scale(1.015);
  box-shadow: 
    0 18px 35px rgba(0, 0, 0, 0.25),
    0 6px 20px rgba(0, 0, 0, 0.2);
}

.testimoni-card .stars {
  margin-bottom: 12px;
  display: flex;
  gap: 2px;
  justify-content: flex-start;
}

.testimoni-card .stars iconify-icon {
  font-size: 16px;
  color: #FFD700;
  filter: drop-shadow(0 2px 4px rgba(255, 215, 0, 0.4));
  transition: transform 0.2s ease;
}

.testimoni-card:hover .stars iconify-icon {
  transform: scale(1.08);
}

.testimoni-content {
  flex-grow: 1;
  margin-bottom: 16px;
}

.testimoni-card p {
  font-size: 0.9rem;
  line-height: 1.5;
  margin-bottom: 0;
  color: #555;
  font-style: italic;
  position: relative;
  text-align: justify;
}

.testimoni-footer {
  display: flex;
  align-items: center;
  gap: 12px;
  margin-top: 15px;
  padding-top: 12px;
  border-top: 1px solid rgba(0, 0, 0, 0.1);
}

.avatar-img {
  width: 45px;
  height: 45px;
  border-radius: 50%;
  border: 2px solid #4169E1;
  object-fit: cover;
  transition: transform 0.3s ease;
  flex-shrink: 0;
}

.testimoni-card:hover .avatar-img {
  transform: scale(1.1);
  border-color: #FFF56C;
}

.testimoni-info {
  flex-grow: 1;
}

.testimoni-card strong {
  color: #2c3e50;
  font-weight: 600;
  font-size: 0.95rem;
  display: block;
  margin-bottom: 2px;
}

.testimoni-card .text-muted {
  color: #7f8c8d !important;
  font-size: 0.8rem;
  font-style: normal;
}

/* Responsive adjustments */
@media (max-width: 768px) {
  .testimoni-section {
    padding: 25px 18px 40px 18px;
    margin: 50px 18px 80px 18px;
    border-radius: 15px;
  }

  .testimoni-title {
    font-size: 1.7rem;
    margin-bottom: 2rem;
  }

  .testimoni-card {
    padding: 18px;
    min-height: 240px;
  }
}

@media (max-width: 576px) {
  .testimoni-section {
    padding: 20px 12px 35px 12px;
    margin: 40px 12px 70px 12px;
    border-radius: 12px;
  }

  .testimoni-title {
    font-size: 1.5rem;
    margin-bottom: 1.8rem;
  }

  .testimoni-card {
    padding: 16px;
    min-height: 220px;
  }

  .testimoni-footer {
    gap: 10px;
  }

  .avatar-img {
    width: 42px;
    height: 42px;
  }
}


/* Responsive adjustments */
@media (max-width: 768px) {
  .testimoni-section {
    padding: 40px 20px 50px 20px;
    margin: 60px 20px 100px 20px;
    border-radius: 15px;
  }
  
  .testimoni-title {
    font-size: 1.8rem;
    margin-bottom: 2.5rem;
  }
  
  .testimoni-card {
    padding: 20px;
    min-height: 280px;
  }
}

@media (max-width: 576px) {
  .testimoni-section {
    padding: 30px 15px 40px 15px;
    margin: 50px 15px 80px 15px;
    border-radius: 12px;
  }
  
  .testimoni-title {
    font-size: 1.6rem;
    margin-bottom: 2rem;
  }
  
  .testimoni-card {
    padding: 18px;
    min-height: 250px;
  }
  
  .testimoni-footer {
    gap: 12px;
  }
  
  .avatar-img {
    width: 45px;
    height: 45px;
  }
}


.avatar-img {
  width: 50px;
  height: 50px;
  border-radius: 50%;
  object-fit: cover;
  border: 2px solid #FFD700;
}

.btn-sewa {
    background: var(--secondary-blue);
    border: none;
    border-radius: 20px; /* Reduced from 25px */
    color: white;
    font-weight: bold;
    padding: 12px 30px; /* Reduced from 15px 40px */
    font-size: 16px; /* Reduced from 18px */
    transition: all 0.3s ease;
}

.btn-sewa:hover {
    background: #1873CC;
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(30, 144, 255, 0.25); /* Reduced shadow */
}

.wisata-subtitle {
    color: var(--accent-orange);
    font-size: 1.6rem; /* Reduced from 1.8rem */
    font-weight: 600;
    margin-bottom: 30px; /* Reduced from 40px */
}

.btn-sewa {
    background: var(--secondary-blue);
    border: none;
    border-radius: 20px; /* Reduced from 25px */
    color: white;
    font-weight: bold;
    padding: 12px 30px; /* Reduced from 15px 40px */
    font-size: 16px; /* Reduced from 18px */
    transition: all 0.3s ease;
}

.btn-sewa:hover {
    background: #1873CC;
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(30, 144, 255, 0.25); /* Reduced shadow */
}

.wisata-subtitle {
    color: var(--accent-orange);
    font-size: 1.6rem; /* Reduced from 1.8rem */
    font-weight: 600;
    margin-bottom: 30px; /* Reduced from 40px */
}

.motor-section {
    padding: 45px 0; /* Further reduced from 60px */
    background: #ffffff;
}

.motor-section .section-title {
    font-weight: 700;
    font-size: 2rem; /* Further reduced from 2.2rem */
    color: #0074e0;
    margin-bottom: 30px; /* Further reduced from 40px */
}

.motor-grid-container {
    max-width: 1000px; /* Further reduced from 1200px */
    margin: 0 auto;
    padding: 0 15px; /* Reduced padding */
}

.motor-row {
    display: flex;
    justify-content: center;
    gap: 1.5rem; /* Further reduced from 2rem */
    margin-bottom: 1.5rem; /* Further reduced from 2rem */
}

.motor-row-top {
    /* 3 cards in top row */
}

.motor-row-bottom {
    /* 2 cards in bottom row - centered */
}

.motor-card {
    background: white;
    border-radius: 14px; /* Further reduced from 16px */
    box-shadow: 2px 2px 8px rgba(0, 0, 0, 0.08); /* Further reduced shadow */
    transition: transform 0.3s ease;
    overflow: hidden;
    width: 260px; /* Further reduced from 320px */
    flex-shrink: 0;
    position: relative;
}

.motor-card:hover {
    transform: translateY(-2px); /* Further reduced from -3px */
}

.motor-card img {
    width: 100%;
    height: auto;
    object-fit: contain;
    display: block;
    background: #f8f9fa;
    min-height: 220px; /* Further reduced from 280px */
}

.motor-price {
    background: #FF3D00;
    color: white;
    font-weight: bold;
    font-size: 12px; /* Further reduced from 13px */
    text-align: center;
    padding: 6px; /* Further reduced from 8px */
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    border-bottom-left-radius: 14px; /* Adjusted to match card radius */
    border-bottom-right-radius: 14px; /* Adjusted to match card radius */
}

.btn-sewa {
    background-color: #0074e0;
    color: white;
    border-radius: 25px; /* Reduced from 999px for more compact look */
    padding: 12px 32px; /* Reduced from 15px 40px */
    font-weight: bold;
    font-size: 16px; /* Reduced from 18px */
    border: none;
    box-shadow: 3px 3px 8px rgba(0, 0, 0, 0.15); /* Reduced shadow */
    transition: all 0.3s ease;
}

.btn-sewa:hover {
    background-color: #005bb5;
    transform: translateY(-2px); /* Reduced from -3px */
    box-shadow: 0 6px 20px rgba(0, 116, 224, 0.25); /* Reduced shadow */
}

/* Responsive Design */
@media (max-width: 1024px) {
    .motor-card {
        width: 300px; /* Reduced from 350px */
    }
    
    .motor-row {
        gap: 1.8rem; /* Reduced from 2rem */
    }
    
    .motor-card img {
        min-height: 260px; /* Reduced from 300px */
    }
}

@media (max-width: 768px) {
    .motor-section {
        padding: 50px 0; /* Reduced from 60px */
    }
    
    .motor-row {
        flex-direction: column;
        align-items: center;
        gap: 1.5rem; /* Reduced from 2rem */
    }
    
    .motor-card {
        width: 85%; /* Reduced from 90% */
        max-width: 350px; /* Reduced from 400px */
    }
    
    .motor-card img {
        min-height: 240px; /* Reduced from 280px */
    }
    
    .btn-sewa {
        padding: 10px 28px; /* Further reduced for mobile */
        font-size: 15px; /* Reduced for mobile */
    }
}

@media (max-width: 576px) {
    .motor-section {
        padding: 40px 0; /* Further reduced */
    }
    
    .motor-card {
        width: 90%; /* Adjusted from 95% */
        max-width: 320px; /* Reduced from 380px */
    }
    
    .motor-card img {
        height: auto;
        min-height: 220px; /* Reduced from 260px */
    }
    
    .motor-price {
        font-size: 12px; /* Further reduced */
        padding: 6px; /* Further reduced */
    }
    
    .btn-sewa {
        padding: 10px 25px; /* Further reduced for small mobile */
        font-size: 14px; /* Further reduced */
    }
}

.garis-destinasi {
  display: flex;
  align-items: center;
  justify-content: center;
  margin-top: 20px;
  margin-bottom: 40px;
}

.garis-destinasi .garis {
  width: 320px; /* Ubah nilai ini untuk mengatur panjang garis kiri & kanan */
  height: 1px;
  background-color: #2196f3;
}

.garis-destinasi .titik {
  width: 14px;
  height: 14px;
  background-color: #0d6efd;
  border-radius: 50%;
  margin: 0 12px; /* Jarak antara garis dan titik */
}




</style>

<!-- Tentang Kami -->
<section class="about-section">
    <div class="container">
        <div class="text-center">
            <h2 class="section-title-tentangkami">Tentang Kami</h2>
            <div class="decorative-line">
                <div class="dot"></div>
            </div>
            <p class="section-description">
                Rental Motor Majestic adalah pilihan tepat untuk Anda yang ingin menyewa motor<br>
                dengan nyaman dan aman. Kami menyediakan motor yang selalu dirawat dengan baik, proses sewa yang mudah,
                serta fasilitas lengkap seperti helm <br> dan jas hujan. Dengan pelayanan yang ramah dan harga<br> yang terjangkau,
                kami siap  mendukung setiap perjalanan Anda.
            </p>
        </div>

        <div class="tentangkami-carousel-wrapper">
            <div class="tentangkami-carousel" id="tentangKamiCarousel">
                <!-- Slide 1 -->
                <div class="carousel-slide">
                    <div class="photo-card">
                        <img src="{{ asset('assets/images/orang1.jpg') }}" alt="Motor 1">
                    </div>
                    <div class="photo-card">
                        <img src="{{ asset('assets/images/orang2.jpg') }}" alt="Motor 2">
                    </div>
                    <div class="photo-card">
                        <img src="{{ asset('assets/images/orang3.jpg') }}" alt="Motor 3">
                    </div>
                </div>
                
                <!-- Slide 2 -->
                <div class="carousel-slide">
                    <div class="photo-card">
                        <img src="{{ asset('assets/images/orang1.jpg') }}" alt="Motor 4">
                    </div>
                    <div class="photo-card">
                        <img src="{{ asset('assets/images/orang2.jpg') }}" alt="Motor 5">
                    </div>
                    <div class="photo-card">
                        <img src="{{ asset('assets/images/orang3.jpg') }}" alt="Motor 6">
                    </div>
                </div>
            </div>
            
            <!-- Carousel Indicators -->
            <div class="carousel-indicators">
                <div class="carousel-indicator active" onclick="goToSlide(0)"></div>
                <div class="carousel-indicator" onclick="goToSlide(1)"></div>
            </div>
        </div>
    </div>
</section>

<script>
let currentSlide = 0;
const totalSlides = 2; // Jumlah slide yang ada

function showSlide(slideIndex) {
    const carousel = document.getElementById('tentangKamiCarousel');
    const indicators = document.querySelectorAll('.carousel-indicator');
    
    // Update slide position
    carousel.style.transform = `translateX(-${slideIndex * 100}%)`;
    
    // Update indicators
    indicators.forEach((indicator, index) => {
        indicator.classList.toggle('active', index === slideIndex);
    });
    
    currentSlide = slideIndex;
}

function nextSlide() {
    currentSlide = (currentSlide + 1) % totalSlides;
    showSlide(currentSlide);
    resetAutoPlay(); // Reset auto-play timer when manually navigating
}

function prevSlide() {
    currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
    showSlide(currentSlide);
    resetAutoPlay(); // Reset auto-play timer when manually navigating
}

function goToSlide(slideIndex) {
    showSlide(slideIndex);
    resetAutoPlay(); // Reset auto-play timer when manually navigating
}

// Auto-play carousel
let autoPlayInterval;

function startAutoPlay() {
    autoPlayInterval = setInterval(nextSlide, 2500); // Ganti slide setiap 2.5 detik (lebih cepat)
}

function stopAutoPlay() {
    clearInterval(autoPlayInterval);
}

function resetAutoPlay() {
    stopAutoPlay();
    startAutoPlay();
}

// Start auto-play when page loads
startAutoPlay();

// Stop auto-play when user interacts, then restart after delay
document.querySelector('.tentangkami-carousel-wrapper').addEventListener('mouseenter', stopAutoPlay);
document.querySelector('.tentangkami-carousel-wrapper').addEventListener('mouseleave', startAutoPlay);

// Touch/swipe support for mobile
let startX = 0;
let endX = 0;

document.getElementById('tentangKamiCarousel').addEventListener('touchstart', function(e) {
    startX = e.changedTouches[0].screenX;
});

document.getElementById('tentangKamiCarousel').addEventListener('touchend', function(e) {
    endX = e.changedTouches[0].screenX;
    handleSwipe();
});

function handleSwipe() {
    const threshold = 50; // Minimum swipe distance
    const diff = startX - endX;
    
    if (Math.abs(diff) > threshold) {
        if (diff > 0) {
            nextSlide(); // Swipe left - go to next slide
        } else {
            prevSlide(); // Swipe right - go to previous slide
        }
        resetAutoPlay(); // Reset auto-play timer after swipe
    }
}
</script>

<!-- Fasilitas-->
<section class="facility-section">
  <div class="container">
    <h2 class="section-title">Fasilitas & Layanan Kami</h2>
    <div class="facility-grid">

      <div class="facility-card">
        <div class="facility-icon">
          <iconify-icon icon="mdi:helmet"></iconify-icon>
        </div>
        <h5>Fasilitas 2 helm</h5>
        <p>Setiap sewa motor dilengkapi 2 helm standar demi keselamatan berkendara.</p>
      </div>

      <div class="facility-card">
        <div class="facility-icon">
          <iconify-icon icon="material-symbols:rainy"></iconify-icon>
        </div>
        <h5>Fasilitas 2 jas hujan</h5>
        <p>Kami sediakan jas hujan untuk mendukung kenyamanan Anda di segala cuaca.</p>
      </div>

      <div class="facility-card">
        <div class="facility-icon">
          <iconify-icon icon="mdi:motorbike"></iconify-icon>
        </div>
        <h5>Motor terjamin</h5>
        <p>Motor selalu dalam kondisi prima karena rutin dirawat, demi kenyamanan dan keamanan Anda.</p>
      </div>

      <div class="facility-card">
        <div class="facility-icon">
          <iconify-icon icon="mdi:handshake"></iconify-icon>
        </div>
        <h5>Pelayanan ramah</h5>
        <p>Kami melayani dengan sepenuh hati, ramah, dan dapat dipercaya.</p>
      </div>

      <div class="facility-card">
        <div class="facility-icon">
          <iconify-icon icon="mdi:cash-multiple"></iconify-icon>
        </div>
        <h5>Harga sewa terjangkau</h5>
        <p>Nikmati tarif sewa yang ramah di kantong dengan pilihan motor sesuai kebutuhan Anda.</p>
      </div>

    </div>
  </div>
</section>

<!-- Sewa Motor Sekarang -->
<section class="motor-section">
    <div class="container">
        <h2 class="section-title text-center">Sewa Motor Sekarang</h2>
        <div class="motor-grid-container">
            <!-- Top row - 3 motorcycles -->
            <div class="motor-row motor-row-top">
                @for ($i = 1; $i <= 3; $i++)
                    <div class="motor-card">
                        <img src="{{ asset("assets/images/motor{$i}.jpg") }}" alt="Motor {{ $i }}">
                    </div>
                @endfor
            </div>
            
            <!-- Bottom row - 2 motorcycles -->
            <div class="motor-row motor-row-bottom">
                @for ($i = 4; $i <= 5; $i++)
                    <div class="motor-card">
                        <img src="{{ asset("assets/images/motor{$i}.jpg") }}" alt="Motor {{ $i }}">
                    </div>
                @endfor
            </div>
        </div>
        <div class="text-center mt-5">
            <button class="btn btn-sewa btn-lg" onclick="window.location.href='/harga_sewa.blade'">NEXT</button> 
        </div>
    </div>
</section>

<!-- Rekomendasi Destinasi Wisata -->
<section class="wisata-section">
  <div class="container">
    <h2 class="text-center judul-wisata">Rekomendasi Destinasi Wisata</h2>
    <h3 class="text-center subjudul-wisata">Malang & Batu</h3>

    <!-- Garis dan Titik Dekoratif -->
    <div class="garis-destinasi">
      <div class="garis"></div>
      <div class="titik"></div>
      <div class="garis"></div>
    </div>

    <div class="row justify-content-center g-4">

      <!-- CARD 1 -->
      <div class="col-lg-3 col-md-4 col-sm-6">
        <div class="card-wrapper">
          <div class="card-back"></div>
          <div class="wisata-card d-flex flex-column h-100">
            <img src="{{ asset('assets/images/bukit nirwana.jpg') }}" alt="Bukit Nirwana">
            <div class="wisata-card-body">
              <h5>Bukit Nirwana</h5>
              <p>Bukit Nirwana menawarkan pemandangan pegunungan yang memesona, taman bunga warna-warni,
                dan udara sejuk <br> yang cocok untuk healing maupun berfoto. Tempat ini ideal untuk kamu
                yang ingin melepas penat dari hiruk-pikuk kota.<br></p>
              <p class="lokasi">
                <i class="fa-solid fa-location-dot"></i>
                <a href="https://maps.app.goo.gl/CSP26HSj5dpSto9j7" target="_blank">
                 Tulungrejo, Desa Pujon Kidul, Kecamatan Pujon,
                 Kabupaten Malang, Jawa Timur 65391
                </a>
              </p>
            </div>
          </div>
        </div>
      </div>

      <!-- CARD 2 -->
      <div class="col-lg-3 col-md-4 col-sm-6">
        <div class="card-wrapper">
          <div class="card-back"></div>
          <div class="wisata-card d-flex flex-column h-100">
            <img src="{{ asset('assets/images/sumber sirah.jpg') }}" alt="Mata Air Sumber Sirah">
            <div class="wisata-card-body">
              <h5>Mata Air Sumber Sirah</h5>
              <p>Sumber Sirah merupakan mata air jernih alami dengan tanaman air yang menawan. 
                Cocok untuk berenang atau snorkeling ringan, tempat ini memberikan pengalaman menyegarkan di tengah alam pedesaan.</p>
              <p class="lokasi">
                <i class="fa-solid fa-location-dot"></i>
                <a href="https://maps.app.goo.gl/apYcnzsUH8kRhimu7" target="_blank">
                  Jl. Sunan Gunungjati, Putukrejo, Kecamatan Gondanglegi, Kabupaten Malang, Jawa Timur 65174
                </a>
              </p>
            </div>
          </div>
        </div>
      </div>

      <!-- CARD 3 -->
      <div class="col-lg-3 col-md-4 col-sm-6">
        <div class="card-wrapper">
          <div class="card-back"></div>
          <div class="wisata-card d-flex flex-column h-100">
            <img src="{{ asset('assets/images/pantai.jpg') }}" alt="Pantai Parang Dowo">
            <div class="wisata-card-body">
              <h5>Pantai Parang Dowo</h5>
              <p>Pantai Parang Dowo menyuguhkan suasana tenang dengan tebing batu unik dan pasir putih. 
                Lokasinya yang tersembunyi membuat pantai ini cocok untuk menikmati keindahan alam tanpa keramaian.</p>
              <p class="lokasi">
                <i class="fa-solid fa-location-dot"></i>
                <a href="https://maps.app.goo.gl/2pUFpahCgtk7pWFc9" target="_blank">
                  Desa Gajahrejo, Kecamatan Gedangan, Kabupaten Malang, Jawa Timur 65178
                </a>
              </p>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>

   </div>

      <!-- CARD 4 -->
      <div class="col-lg-3 col-md-4 col-sm-6">
        <div class="card-wrapper">
          <div class="card-back"></div>
          <div class="wisata-card d-flex flex-column h-100">
            <img src="{{ asset('assets/images/coban pelangi.jpg') }}" alt="Pantai Parang Dowo">
            <div class="wisata-card-body">
              <h5>Coban Pelangi</h5>
              <p>Coban Pelangi menawarkan pesona air terjun yang jatuh dari ketinggian di tengah hutan yang sejuk. Pelangi sering muncul di sekitar air terjun karena pantulan sinar matahari, menjadikannya spot favorit untuk berfoto dan menikmati keindahan alam..</p>
              <p class="lokasi">
                <i class="fa-solid fa-location-dot"></i>
                <a href="https://maps.app.goo.gl/YYmWe4ptdFZMENBw8" target="_blank">
                  Desa Gajahrejo, Kecamatan Gedangan, Kabupaten Malang, Jawa Timur 65178
                </a>
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

   </div>

      <!-- CARD 5 -->
      <div class="col-lg-3 col-md-4 col-sm-6">
        <div class="card-wrapper">
          <div class="card-back"></div>
          <div class="wisata-card d-flex flex-column h-100">
            <img src="{{ asset('assets/images/pantai2.png') }}" alt="Pantai Parang Dowo">
            <div class="wisata-card-body">
              <h5>Pantai Balekambang</h5>
              <p>Pantai Balekambang dikenal dengan pura kecil di atas batu karang yang mirip Tanah Lot di Bali. Pantai ini memiliki pasir putih dan ombak tenang, cocok untuk berlibur bersama keluarga maupun bersantai menikmati matahari terbenam..</p>
              <p class="lokasi">
                <i class="fa-solid fa-location-dot"></i>
                <a href="https://maps.app.goo.gl/jbqvfkb8zSie6a9F7" target="_blank">
                  Desa Gajahrejo, Kecamatan Gedangan, Kabupaten Malang, Jawa Timur 65178
                </a>
              </p>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>

   </div>

      <!-- CARD 6-->
      <div class="col-lg-3 col-md-4 col-sm-6">
        <div class="card-wrapper">
          <div class="card-back"></div>
          <div class="wisata-card d-flex flex-column h-100">
            <img src="{{ asset('assets/images/kampung.jpg') }}" alt="Pantai Parang Dowo">
            <div class="wisata-card-body">
              <h5>Kampung Warna-Warni Jodipan</h5>
              <p>Destinasi unik di tengah kota Malang dengan rumah-rumah penduduk yang dicat warna-warni. Cocok untuk berswafoto dan menikmati seni mural yang menghiasi dinding rumah. Tempat ini juga memberikan pengalaman sosial dan budaya yang menarik.</p>
              <p class="lokasi">
                <i class="fa-solid fa-location-dot"></i>
                <a href="https://maps.app.goo.gl/2pUFpahCgtk7pWFc9" target="_blank">
                  Desa Gajahrejo, Kecamatan Gedangan, Kabupaten Malang, Jawa Timur 65178
                </a>
              </p>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>


</section>

<!-- Testimoni -->
<section class="testimoni-section">
  <div class="container">
    <h2 class="section-title text-center mb-5 testimoni-title">Testimoni</h2>
    <div class="row g-4">
      <!-- Testimoni 1 -->
      <div class="col-lg-4 col-md-6">
        <div class="testimoni-card">
          <div class="stars">
            <iconify-icon icon="mdi:star" style="color: #FFD700;"></iconify-icon>
            <iconify-icon icon="mdi:star" style="color: #FFD700;"></iconify-icon>
            <iconify-icon icon="mdi:star" style="color: #FFD700;"></iconify-icon>
            <iconify-icon icon="mdi:star" style="color: #FFD700;"></iconify-icon>
            <iconify-icon icon="mdi:star-half-full" style="color: #FFD700;"></iconify-icon>
          </div>
          <p>“Aku udah coba beberapa tempat rental di Malang, tapi sejauh ini Majestic yang paling oke. Fast response, ramah, dan motor yang dikasih selalu dalam kondisi bagus.”</p>
          <div class="d-flex align-items-center mt-4">
            <img src="assets/images/avatar1.png" alt="shelter" class="avatar-img me-3">
            <div>
              <strong>Shelter Morgues</strong>
              <div class="text-muted small">sheltermor@gmail.com</div>
            </div>
          </div>
        </div>
      </div>

      <!-- Testimoni 2 -->
      <div class="col-lg-4 col-md-6">
        <div class="testimoni-card">
          <div class="stars">
            <iconify-icon icon="mdi:star" style="color: #FFD700;"></iconify-icon>
            <iconify-icon icon="mdi:star" style="color: #FFD700;"></iconify-icon>
            <iconify-icon icon="mdi:star" style="color: #FFD700;"></iconify-icon>
            <iconify-icon icon="mdi:star" style="color: #FFD700;"></iconify-icon>
            <iconify-icon icon="mdi:star" style="color: #FFD700;"></iconify-icon>
          </div>
          <p>“Sewa motor di Majestic bener-bener memudahkan liburan aku di Malang. Proses booking cepat, motor bersih dan terawat, helm dan jas hujan juga disiapkan.”</p>
          <div class="d-flex align-items-center mt-4">
            <img src="assets/images/avatar2.png" alt="ayesha" class="avatar-img me-3">
            <div>
              <strong>Ayesha</strong>
              <div class="text-muted small">ayeshanay@gmail.com</div>
            </div>
          </div>
        </div>
      </div>

      <!-- Testimoni 3 -->
      <div class="col-lg-4 col-md-6">
        <div class="testimoni-card">
          <div class="stars">
            <iconify-icon icon="mdi:star" style="color: #FFD700;"></iconify-icon>
            <iconify-icon icon="mdi:star" style="color: #FFD700;"></iconify-icon>
            <iconify-icon icon="mdi:star" style="color: #FFD700;"></iconify-icon>
            <iconify-icon icon="mdi:star" style="color: #FFD700;"></iconify-icon>
            <iconify-icon icon="mdi:star" style="color: #FFD700;"></iconify-icon>
          </div>
          <p>“Kalau kamu cari rental motor yang nggak ribet, fast response, dan unitnya terawat, Majestic jawabannya. Plus, semua perlengkapan kayak helm dan jas hujan selalu disiapkan.”</p>
          <div class="d-flex align-items-center mt-4">
            <img src="assets/images/avatar3.png" alt="varisha" class="avatar-img me-3">
            <div>
              <strong>Varisha</strong>
              <div class="text-muted small">varisha123@gmail.com</div>
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