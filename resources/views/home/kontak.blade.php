@extends('index')

@section('content')

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Card Testimoni Modern</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
/* Modern Contact Section Styles - Blue & Yellow Theme with All White Cards */
.kontak-section {
  background: linear-gradient(135deg, #f8fbff 0%, #e3f2fd 100%);
  color: #333;
  padding: 100px 0;
  position: relative;
  overflow: hidden;
}

.kontak-section::before {
  content: '';
  position: absolute;
  top: -50%;
  left: -50%;
  width: 200%;
  height: 200%;
  background: radial-gradient(circle, rgba(33, 150, 243, 0.05) 0%, transparent 50%);
  animation: float 20s ease-in-out infinite;
}

@keyframes float {
  0%, 100% { transform: translateY(0px) rotate(0deg); }
  50% { transform: translateY(-20px) rotate(180deg); }
}

.kontak-section .container {
  position: relative;
  z-index: 2;
}

.kontak-section h2 {
  font-size: 3rem;
  font-weight: 800;
  margin-bottom: 0.5rem;
  color: #1565c0;
  text-shadow: 0 3px 6px rgba(21, 101, 192, 0.2);
  letter-spacing: -0.02em;
}

.kontak-section h4 {
  font-size: 1.4rem;
  font-weight: 400;
  margin-bottom: 4rem;
  color: #546e7a;
  opacity: 0.9;
}

/* Updated All White Cards */
.kontak-card {
  background: white;
  border-radius: 24px;
  padding: 2.5rem 2rem;
  text-align: center;
  box-shadow: 0 8px 32px rgba(33, 150, 243, 0.12);
  transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
  border: 2px solid #e3f2fd;
  height: 220px;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  position: relative;
  overflow: hidden;
  color: #1565c0;
}

.kontak-card::before {
  content: '';
  position: absolute;
  top: 0;
  left: -100%;
  width: 100%;
  height: 100%;
  background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
  transition: all 0.6s;
}

.kontak-card:hover::before {
  left: 100%;
}

.kontak-card:hover {
  transform: translateY(-15px) scale(1.02);
  box-shadow: 0 20px 60px rgba(33, 150, 243, 0.25);
  border-color: #2196f3;
  background: linear-gradient(135deg, #f8fbff 0%, #e3f2fd 100%);
  color: #0d47a1;
}

.kontak-card i {
  margin-bottom: 1.5rem;
  padding: 20px;
  border-radius: 50%;
  width: 80px;
  height: 80px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 2rem;
  transition: all 0.3s ease;
  background: linear-gradient(135deg, #2196f3 0%, #1976d2 100%);
  color: white;
  box-shadow: 0 4px 20px rgba(33, 150, 243, 0.3);
}

.kontak-card:hover i {
  transform: scale(1.1) rotate(5deg);
  box-shadow: 0 6px 30px rgba(33, 150, 243, 0.4);
}

.kontak-card p {
  margin: 0;
  font-size: 1.1rem;
  line-height: 1.6;
  font-weight: 600;
  letter-spacing: 0.01em;
}

/* Testimoni Section */
.testimoni-section {
  background: linear-gradient(135deg, #ffffff 0%, #f8fbff 100%);
  padding: 100px 0;
  position: relative;
}

.testimoni-section::after {
  content: '';
  position: absolute;
  bottom: 0;
  left: 0;
  right: 0;
  height: 1px;
  background: linear-gradient(90deg, transparent, #2196f3, transparent);
}

.testimoni-section h2 {
  font-size: 3rem;
  font-weight: 800;
  margin-bottom: 0.5rem;
  color: #1565c0;
  text-shadow: 0 3px 6px rgba(21, 101, 192, 0.2);
  letter-spacing: -0.02em;
}

.testimoni-section h4 {
  font-size: 1.4rem;
  font-weight: 400;
  margin-bottom: 4rem;
  color: #546e7a;
  opacity: 0.9;
}

/* Testimoni Card */
.testimoni-card {
  background: white;
  border-radius: 24px;
  padding: 2.5rem;
  box-shadow: 0 8px 32px rgba(33, 150, 243, 0.12);
  transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
  border: 2px solid #e3f2fd;
  position: relative;
  overflow: hidden;
  margin-bottom: 2rem;
  text-align: left;
}

.testimoni-card::before {
  content: '';
  position: absolute;
  top: 0;
  left: -100%;
  width: 100%;
  height: 100%;
  background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
  transition: all 0.6s;
}

.testimoni-card:hover::before {
  left: 100%;
}

.testimoni-card:hover {
  transform: translateY(-10px) scale(1.02);
  box-shadow: 0 20px 60px rgba(33, 150, 243, 0.25);
  border-color: #2196f3;
  background: linear-gradient(135deg, #f8fbff 0%, #e3f2fd 100%);
}

/* Quote Icon */
.quote-icon {
  position: absolute;
  top: 20px;
  right: 25px;
  font-size: 3rem;
  color: #e3f2fd;
  opacity: 0.8;
  transform: rotate(180deg);
  transition: all 0.3s ease;
}

.testimoni-card:hover .quote-icon {
  color: #2196f3;
  opacity: 1;
  transform: rotate(180deg) scale(1.1);
}

/* User Info */
.user-info {
  display: flex;
  align-items: center;
  margin-bottom: 1.5rem;
}

.user-avatar {
  width: 60px;
  height: 60px;
  border-radius: 50%;
  background: linear-gradient(135deg, #2196f3 0%, #1976d2 100%);
  display: flex;
  align-items: center;
  justify-content: center;
  color: white;
  font-size: 1.5rem;
  font-weight: 700;
  margin-right: 1rem;
  box-shadow: 0 4px 20px rgba(33, 150, 243, 0.3);
  transition: all 0.3s ease;
}

.testimoni-card:hover .user-avatar {
  transform: scale(1.05);
  box-shadow: 0 6px 30px rgba(33, 150, 243, 0.4);
}

.user-details h5 {
  margin: 0;
  color: #1565c0;
  font-weight: 700;
  font-size: 1.2rem;
  letter-spacing: -0.01em;
}

.user-details .user-date {
  color: #90a4ae;
  font-size: 0.9rem;
  margin: 0;
}

/* Rating Stars */
.rating-display {
  margin: 1rem 0;
  display: flex;
  gap: 4px;
}

.rating-display .fa-star {
  color: #ffc107;
  font-size: 1.2rem;
  text-shadow: 0 1px 3px rgba(255, 193, 7, 0.4);
}

.rating-display .fa-star.empty {
  color: #e0e0e0;
}

/* Testimoni Text */
.testimoni-text {
  color: #546e7a;
  font-size: 1.1rem;
  line-height: 1.7;
  margin: 0;
  font-style: italic;
  position: relative;
  padding-left: 1rem;
}

.testimoni-text::before {
  content: '';
  position: absolute;
  left: 0;
  top: 0;
  bottom: 0;
  width: 4px;
  background: linear-gradient(135deg, #2196f3 0%, #1976d2 100%);
  border-radius: 2px;
  transition: all 0.3s ease;
}

.testimoni-card:hover .testimoni-text::before {
  width: 6px;
  background: linear-gradient(135deg, #ffc107 0%, #ff9800 100%);
}

/* Form Testimoni */
.review-form {
  background: white;
  border-radius: 24px;
  padding: 3rem;
  box-shadow: 0 20px 60px rgba(33, 150, 243, 0.12);
  border: 2px solid #e3f2fd;
  position: relative;
  height: fit-content;
}

.review-form::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  height: 6px;
  background: linear-gradient(90deg, #2196f3, #ffc107, #2196f3);
  border-radius: 24px 24px 0 0;
}

.review-form h5 {
  color: #1565c0;
  font-weight: 800;
  margin-bottom: 2rem;
  font-size: 1.5rem;
  text-align: center;
  letter-spacing: -0.01em;
}

.form-label {
  color: #1565c0;
  font-weight: 600;
  margin-bottom: 0.8rem;
  font-size: 1rem;
}

.form-control {
  border: 3px solid #e3f2fd;
  border-radius: 16px;
  padding: 16px 20px;
  font-size: 1.1rem;
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  background: #f8fbff;
  color: #333;
}

.form-control:focus {
  border-color: #2196f3;
  box-shadow: 0 0 0 4px rgba(33, 150, 243, 0.15);
  background: white;
  outline: none;
}

.form-control::placeholder {
  color: #90a4ae;
}

/* Rating Stars */
.rating-container {
  text-align: center;
  padding: 1.5rem 0;
}

.rating {
  display: flex;
  justify-content: center;
  gap: 12px;
  margin-bottom: 1.5rem;
}

.rating .fa-star {
  font-size: 3rem;
  color: #e0e0e0;
  cursor: pointer;
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  padding: 8px;
  border-radius: 50%;
  position: relative;
}

.rating .fa-star:hover,
.rating .fa-star.hovered {
  color: #ffc107;
  transform: scale(1.2) rotate(10deg);
  text-shadow: 0 0 20px rgba(255, 193, 7, 0.6);
}

.rating .fa-star.selected {
  color: #ffc107;
  animation: starPulse 0.6s ease;
}

@keyframes starPulse {
  0% { transform: scale(1); }
  50% { transform: scale(1.3); }
  100% { transform: scale(1); }
}

.rating-text {
  font-size: 1.3rem;
  font-weight: 700;
  color: #90a4ae;
  margin-bottom: 2rem;
  min-height: 35px;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: all 0.4s ease;
  letter-spacing: 0.02em;
}

.rating-text.active {
  transform: scale(1.1);
  text-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

/* Rating Colors */
.rating-text.rating-1 { color: #f44336; }
.rating-text.rating-2 { color: #ff9800; }
.rating-text.rating-3 { color: #ffc107; }
.rating-text.rating-4 { color: #4caf50; }
.rating-text.rating-5 { color: #2196f3; }

/* Submit Button */
.btn-submit {
  background: linear-gradient(135deg, #2196f3 0%, #1976d2 100%);
  border: none;
  border-radius: 16px;
  padding: 18px 40px;
  font-weight: 700;
  color: white;
  font-size: 1.2rem;
  transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
  box-shadow: 0 8px 32px rgba(33, 150, 243, 0.4);
  width: 100%;
  position: relative;
  overflow: hidden;
}

.btn-submit::before {
  content: '';
  position: absolute;
  top: 0;
  left: -100%;
  width: 100%;
  height: 100%;
  background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
  transition: all 0.6s;
}

.btn-submit:hover::before {
  left: 100%;
}

.btn-submit:hover {
  transform: translateY(-3px);
  box-shadow: 0 12px 48px rgba(33, 150, 243, 0.6);
  background: linear-gradient(135deg, #1976d2 0%, #1565c0 100%);
}

.btn-submit:active {
  transform: translateY(-1px);
}

.btn-submit:disabled {
  opacity: 0.7;
  transform: none;
  cursor: not-allowed;
}

/* Maps Container */
.maps-container {
  position: relative;
  overflow: hidden;
  border-radius: 24px;
  box-shadow: 0 20px 60px rgba(33, 150, 243, 0.15);
  border: 3px solid #e3f2fd;
}

.maps-container iframe {
  width: 100%;
  height: 450px;
  border: none;
  border-radius: 21px;
  transition: all 0.3s ease;
}

.maps-container:hover {
  transform: scale(1.02);
  box-shadow: 0 25px 80px rgba(33, 150, 243, 0.25);
  border-color: #2196f3;
}

/* UPDATED MODERN MODAL STYLES - NO DARK OVERLAY */
.modal-backdrop {
  display: none !important;
}

.modal {
  background: rgba(248, 251, 255, 0.95) !important;
  backdrop-filter: blur(10px);
}

.modal-dialog {
  max-width: 500px;
  margin: 5vh auto;
}

.modal-content {
  border: none;
  border-radius: 28px;
  overflow: hidden;
  box-shadow: 0 30px 80px rgba(33, 150, 243, 0.2);
  background: white;
  position: relative;
  animation: modalSlideIn 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
}

@keyframes modalSlideIn {
  0% {
    transform: scale(0.8) translateY(-50px);
    opacity: 0;
  }
  100% {
    transform: scale(1) translateY(0);
    opacity: 1;
  }
}

.modal-header {
  background: linear-gradient(135deg, #2196f3 0%, #1976d2 100%);
  color: white;
  border: none;
  padding: 2.5rem;
  text-align: center;
  position: relative;
}

.modal-header::after {
  content: '';
  position: absolute;
  bottom: 0;
  left: 0;
  right: 0;
  height: 4px;
  background: linear-gradient(90deg, #ffc107, #ff9800, #ffc107);
}

.modal-header .modal-title {
  font-size: 1.8rem;
  font-weight: 800;
  margin: 0;
  text-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
  letter-spacing: -0.02em;
}

.modal-body {
  padding: 3.5rem 2.5rem;
  text-align: center;
  background: linear-gradient(135deg, #ffffff 0%, #f8fbff 100%);
  position: relative;
}

.modal-body::before {
  content: '';
  position: absolute;
  top: 0;
  left: 20%;
  right: 20%;
  height: 1px;
  background: linear-gradient(90deg, transparent, #e3f2fd, transparent);
}

.modal-body .success-icon {
  font-size: 5rem;
  color: #4caf50;
  margin-bottom: 2rem;
  animation: successBounce 0.8s ease-in-out;
  text-shadow: 0 4px 20px rgba(76, 175, 80, 0.3);
  filter: drop-shadow(0 0 20px rgba(76, 175, 80, 0.2));
}

@keyframes successBounce {
  0% {
    transform: scale(0) rotate(-180deg);
    opacity: 0;
  }
  50% {
    transform: scale(1.2) rotate(0deg);
  }
  80% {
    transform: scale(0.9) rotate(0deg);
  }
  100% {
    transform: scale(1) rotate(0deg);
    opacity: 1;
  }
}

.modal-body h5 {
  color: #1565c0;
  font-weight: 800;
  margin-bottom: 1.5rem;
  font-size: 1.6rem;
  letter-spacing: -0.01em;
}

.modal-body p {
  color: #546e7a;
  font-size: 1.15rem;
  line-height: 1.6;
  margin-bottom: 2.5rem;
  max-width: 400px;
  margin-left: auto;
  margin-right: auto;
}

.btn-close-modal {
  background: linear-gradient(135deg, #4caf50 0%, #388e3c 100%);
  border: none;
  border-radius: 20px;
  padding: 16px 40px;
  color: white;
  font-weight: 700;
  font-size: 1.1rem;
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  box-shadow: 0 8px 25px rgba(76, 175, 80, 0.4);
  position: relative;
  overflow: hidden;
  min-width: 160px;
}

.btn-close-modal::before {
  content: '';
  position: absolute;
  top: 0;
  left: -100%;
  width: 100%;
  height: 100%;
  background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
  transition: all 0.6s;
}

.btn-close-modal:hover::before {
  left: 100%;
}

.btn-close-modal:hover {
  transform: translateY(-2px);
  box-shadow: 0 12px 35px rgba(76, 175, 80, 0.5);
  background: linear-gradient(135deg, #388e3c 0%, #2e7d32 100%);
}

.btn-close-modal:active {
  transform: translateY(0);
}

/* Floating Elements */
.modal-body::after {
  content: '✨';
  position: absolute;
  top: 20px;
  right: 30px;
  font-size: 2rem;
  animation: float 3s ease-in-out infinite;
  opacity: 0.6;
}

.modal-header::before {
  content: '🎉';
  position: absolute;
  top: 20px;
  left: 30px;
  font-size: 2rem;
  animation: float 3s ease-in-out infinite reverse;
  opacity: 0.8;
}

/* Success animation */
.form-success {
  animation: successPulse 0.8s ease;
}

@keyframes successPulse {
  0% { transform: scale(1); }
  25% { transform: scale(1.02); }
  50% { transform: scale(1.05); }
  75% { transform: scale(1.02); }
  100% { transform: scale(1); }
}

/* Loading animation */
@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

.btn-submit:disabled i {
  animation: spin 1s linear infinite;
}

/* Responsive Design */
@media (max-width: 768px) {
  .kontak-section,
  .testimoni-section {
    padding: 80px 0;
  }
  
  .kontak-section h2,
  .testimoni-section h2 {
    font-size: 2.2rem;
  }
  
  .kontak-card {
    margin-bottom: 1.5rem;
    height: 200px;
    padding: 2rem 1.5rem;
  }
  
  .kontak-card i {
    width: 70px;
    height: 70px;
    font-size: 1.8rem;
  }
  
  .testimoni-card {
    padding: 2rem;
    margin-bottom: 1.5rem;
  }
  
  .maps-container iframe {
    height: 350px;
  }
  
  .quote-icon {
    font-size: 2.5rem;
    top: 15px;
    right: 20px;
  }

  .modal-dialog {
    margin: 2vh 15px;
  }

  .modal-header {
    padding: 2rem 1.5rem;
  }

  .modal-body {
    padding: 2.5rem 1.5rem;
  }

  .modal-header .modal-title {
    font-size: 1.5rem;
  }

  .modal-body .success-icon {
    font-size: 4rem;
  }

  .modal-body h5 {
    font-size: 1.4rem;
  }

  .modal-body p {
    font-size: 1rem;
  }
}

@media (max-width: 576px) {
  .kontak-section h2,
  .testimoni-section h2 {
    font-size: 1.8rem;
  }
  
  .kontak-card {
    height: 180px;
    padding: 1.5rem 1rem;
  }
  
  .kontak-card p {
    font-size: 1rem;
  }
  
  .testimoni-card {
    padding: 1.5rem;
  }
  
  .user-avatar {
    width: 50px;
    height: 50px;
    font-size: 1.2rem;
  }
  
  .user-details h5 {
    font-size: 1.1rem;
  }
  
  .testimoni-text {
    font-size: 1rem;
  }
}

/* Animation for cards */
@keyframes fadeInUp {
  from {
    opacity: 0;
    transform: translateY(50px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.kontak-card,
.testimoni-card {
  animation: fadeInUp 0.8s ease forwards;
}

.kontak-card:nth-child(1) { animation-delay: 0.1s; }
.kontak-card:nth-child(2) { animation-delay: 0.2s; }
.kontak-card:nth-child(3) { animation-delay: 0.3s; }
.kontak-card:nth-child(4) { animation-delay: 0.4s; }
.kontak-card:nth-child(5) { animation-delay: 0.5s; }
.kontak-card:nth-child(6) { animation-delay: 0.6s; }

.testimoni-card:nth-child(1) { animation-delay: 0.2s; }
.testimoni-card:nth-child(2) { animation-delay: 0.4s; }
.testimoni-card:nth-child(3) { animation-delay: 0.6s; }
.testimoni-card:nth-child(4) { animation-delay: 0.8s; }
</style>
</head>
<body>

<section class="kontak-section">
  <div class="container text-center">
    <h2>Jika Ada Pertanyaan</h2>
    <h4>Silahkan Hubungi Kami</h4>

    <!-- Baris Pertama - 3 Card -->
    <div class="row justify-content-center g-4 mb-5">
      <div class="col-lg-4 col-md-6">
        <a href="https://maps.google.com/?q=Gg.+Kaserin+M+U,+Lesanpuro,+Kec.+Kedungkandang,+Kota+Malang,+Jawa+Timur+65138" target="_blank" style="text-decoration: none; color: inherit;">
          <div class="kontak-card">
            <i class="bi bi-geo-alt-fill"></i>
            <p>Gg. Kaserin M U, Lesanpuro, Kec. Kedungkandang, Kota Malang, Jawa Timur 65138</p>
          </div>
        </a>
      </div>
      <div class="col-lg-4 col-md-6">
        <a href="tel:+6285105474050" style="text-decoration: none; color: inherit;">
          <div class="kontak-card">
            <i class="bi bi-telephone-fill"></i>
            <p>0851-0547-4050</p>
          </div>
        </a>
      </div>
      <div class="col-lg-4 col-md-6">
        <a href="mailto:majestictransport@gmail.com" style="text-decoration: none; color: inherit;">
          <div class="kontak-card">
            <i class="bi bi-envelope-fill"></i>
            <p>majestictransport@gmail.com</p>
          </div>
        </a>
      </div>
    </div>

    <!-- Baris Kedua - 3 Card -->
    <div class="row justify-content-center g-4">
      <div class="col-lg-4 col-md-6">
        <div class="kontak-card">
          <i class="bi bi-clock-fill"></i>
          <p>07.00 s/d 21.00 WIB</p>
        </div>
      </div>
      <div class="col-lg-4 col-md-6">
        <a href="https://instagram.com/sewamotormalang_id" target="_blank" style="text-decoration: none; color: inherit;">
          <div class="kontak-card">
            <i class="bi bi-instagram"></i>
            <p>@sewamotormalang_id</p>
          </div>
        </a>
      </div>
      <div class="col-lg-4 col-md-6">
        <a href="https://tiktok.com/@sewamotormalang.batu" target="_blank" style="text-decoration: none; color: inherit;">
          <div class="kontak-card">
            <i class="bi bi-tiktok"></i>
            <p>@sewamotormalang.batu</p>
          </div>
        </a>
      </div>
    </div>
  </div>
</section>

<section class="testimoni-section">
  <div class="container">
    <div class="text-center mb-5">
      <h2>Testimoni Pelanggan</h2>
      <h4>Apa Kata Mereka Tentang Layanan Kami</h4>
    </div>

    <div class="row g-5">
      <div class="col-lg-6">
        <div class="maps-container">
          <iframe 
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3952.642738517732!2d112.66624467493238!3d-7.829595177215577!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e78840cfaa7e93d%3A0x9db1ad118a89faea!2sJl.%20Lesanpuro%2C%20Lesanpuro%2C%20Kec.%20Kedungkandang%2C%20Kota%20Malang%2C%20Jawa%20Timur%2065138!5e0!3m2!1sid!2sid!4v1691390290304!5m2!1sid!2sid" 
            allowfullscreen="" 
            loading="lazy" 
            referrerpolicy="no-referrer-when-downgrade">
          </iframe>
        </div>
      </div>

      <div class="col-lg-6">
        <!-- Form Berikan Testimoni -->
        <div class="review-form" id="testimonialFormContainer" style="display: none;">
          <h5><i class="bi bi-chat-heart-fill me-2"></i>Berikan Testimoni Anda</h5>
          <p class="text-muted mb-4">Halo <span id="userName"></span>, Anda dapat memberikan testimoni untuk <span id="availableCount" class="fw-bold text-primary"></span> peminjaman yang telah selesai!</p>
          
          <!-- Rental Selection -->
          <div class="mb-4" id="rentalSelection">
            <label class="form-label"><i class="bi bi-motorcycle me-2"></i>Pilih Peminjaman untuk Testimoni</label>
            <select class="form-control" id="peminjamanSelect" required>
              <option value="">Pilih peminjaman...</option>
            </select>
            <small class="text-muted">Anda sudah memberikan <span id="completedCount" class="fw-bold">0</span> testimoni sebelumnya.</small>
          </div>
          
          <form id="testimonialForm">
            <input type="hidden" name="peminjaman_id" id="selectedPeminjamanId">
            
            <div class="mb-4">
              <label class="form-label"><i class="bi bi-chat-text-fill me-2"></i>Testimoni</label>
              <textarea class="form-control" id="customerReview" placeholder="Ceritakan pengalaman Anda menggunakan layanan kami..." rows="4" required></textarea>
            </div>

            <div class="mb-4">
              <label class="form-label"><i class="bi bi-star-fill me-2"></i>Rating Layanan</label>
              <div class="rating-container">
                <div class="rating" id="rating">
                  <i class="fa fa-star" data-value="1"></i>
                  <i class="fa fa-star" data-value="2"></i>
                  <i class="fa fa-star" data-value="3"></i>
                  <i class="fa fa-star" data-value="4"></i>
                  <i class="fa fa-star" data-value="5"></i>
                </div>
                <div class="rating-text" id="rating-text">Pilih rating Anda</div>
              </div>
              <input type="hidden" name="rating" id="rating-value" required>
            </div>

            <button type="submit" class="btn btn-submit">
              <i class="bi bi-send-fill me-2"></i>Kirim Testimoni
            </button>
          </form>
        </div>

        <!-- Message for users who can't submit testimonials -->
        <div class="review-form" id="testimonialMessage" style="display: none;">
          <h5><i class="bi bi-info-circle-fill me-2"></i>Informasi Testimoni</h5>
          <div class="alert alert-info" style="border-radius: 16px; border: none; background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);">
            <p class="mb-0" id="messageText"></p>
          </div>
          <div class="text-center mt-3">
            <a href="{{ route('harga_sewa') }}" class="btn btn-submit" id="testimonialActionBtn" style="width: auto; padding: 12px 30px;">
              <i class="bi bi-box-arrow-in-right me-2"></i>Sewa untuk memberikan Testimoni
            </a>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Testimoni Cards Section -->
    <div class="row mt-5">
      <div class="col-12 text-center mb-4">
        <h3 style="color: #1565c0; font-weight: 700;">Testimoni Pelanggan Kami</h3>
        <p style="color: #546e7a;">Apa kata mereka yang sudah menggunakan layanan kami</p>
      </div>
      
      <div class="col-lg-4 col-md-6 mb-4">
        <!-- Testimoni Card 1 -->
        <div class="testimoni-card">
          <i class="fas fa-quote-right quote-icon"></i>
          <div class="user-info">
            <div class="user-avatar">AN</div>
            <div class="user-details">
              <h5>Ahmad Nuryadi</h5>
              <p class="user-date">15 Agustus 2024</p>
            </div>
          </div>
          <div class="rating-display">
            <i class="fa fa-star"></i>
            <i class="fa fa-star"></i>
            <i class="fa fa-star"></i>
            <i class="fa fa-star"></i>
            <i class="fa fa-star"></i>
          </div>
          <p class="testimoni-text">
            "Pelayanan sangat memuaskan! Motor dalam kondisi prima dan bersih. Staff ramah dan profesional. Pasti akan sewa lagi di sini untuk liburan berikutnya."
          </p>
        </div>
      </div>
      
      <div class="col-lg-4 col-md-6 mb-4">
        <!-- Testimoni Card 2 -->
        <div class="testimoni-card">
          <i class="fas fa-quote-right quote-icon"></i>
          <div class="user-info">
            <div class="user-avatar">SR</div>
            <div class="user-details">
              <h5>Sari Rahayu</h5>
              <p class="user-date">28 Juli 2024</p>
            </div>
          </div>
          <div class="rating-display">
            <i class="fa fa-star"></i>
            <i class="fa fa-star"></i>
            <i class="fa fa-star"></i>
            <i class="fa fa-star"></i>
            <i class="fa fa-star"></i>
          </div>
          <p class="testimoni-text">
            "Harga terjangkau dengan kualitas terbaik! Proses sewa mudah dan cepat. Motor terawat dengan baik dan nyaman dikendarai keliling Malang-Batu."
          </p>
        </div>
      </div>
      
      <div class="col-lg-4 col-md-6 mb-4">
        <!-- Testimoni Card 3 -->
        <div class="testimoni-card">
          <i class="fas fa-quote-right quote-icon"></i>
          <div class="user-info">
            <div class="user-avatar">BP</div>
            <div class="user-details">
              <h5>Budi Pratama</h5>
              <p class="user-date">10 Agustus 2024</p>
            </div>
          </div>
          <div class="rating-display">
            <i class="fa fa-star"></i>
            <i class="fa fa-star"></i>
            <i class="fa fa-star"></i>
            <i class="fa fa-star"></i>
            <i class="fa fa-star empty"></i>
          </div>
          <p class="testimoni-text">
            "Recommended banget! Lokasi strategis, motor bagus-bagus, dan harga bersahabat. Customer service responsif dan helpful. Top deh!"
          </p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- UPDATED MODERN MODAL WITHOUT DARK OVERLAY -->
<div class="modal fade" id="thankYouModal" tabindex="-1" aria-labelledby="thankYouModalLabel" aria-hidden="true" data-bs-backdrop="false">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title w-100" id="thankYouModalLabel">
          <i class="bi bi-heart-fill me-2"></i>Terima Kasih!
        </h4>
      </div>
      <div class="modal-body">
        <i class="bi bi-check-circle-fill success-icon"></i>
        <h5>Testimoni Berhasil Dikirim!</h5>
        <p>Terima kasih telah memberikan testimoni. Masukan Anda sangat berharga untuk meningkatkan pelayanan kami.</p>
        <button type="button" class="btn btn-close-modal" data-bs-dismiss="modal">
          <i class="bi bi-hand-thumbs-up me-2"></i>Tutup
        </button>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {
  const stars = document.querySelectorAll("#rating .fa-star");
  const ratingValue = document.getElementById("rating-value");
  const ratingText = document.getElementById("rating-text");
  const testimonialForm = document.getElementById("testimonialForm");
  const thankYouModal = new bootstrap.Modal(document.getElementById('thankYouModal'));
  
  const ratingTexts = {
    1: "Sangat Buruk",
    2: "Buruk", 
    3: "Cukup",
    4: "Baik",
    5: "Sangat Baik"
  };

  // Rating functionality
  stars.forEach((star, index) => {
    star.addEventListener("mouseover", () => {
      stars.forEach((s, i) => {
        s.classList.toggle("hovered", i <= index);
      });
      
      // Show rating text on hover
      const rating = index + 1;
      ratingText.textContent = ratingTexts[rating];
      ratingText.className = `rating-text rating-${rating} active`;
    });

    star.addEventListener("mouseout", () => {
      stars.forEach(s => s.classList.remove("hovered"));
      
      // Reset to selected rating or default text
      if (ratingValue.value) {
        const selectedRating = parseInt(ratingValue.value);
        ratingText.textContent = ratingTexts[selectedRating];
        ratingText.className = `rating-text rating-${selectedRating} active`;
      } else {
        ratingText.textContent = "Pilih rating Anda";
        ratingText.className = "rating-text";
      }
    });

    star.addEventListener("click", () => {
      const rating = index + 1;
      
      stars.forEach((s, i) => {
        s.classList.toggle("selected", i <= index);
      });
      
      ratingValue.value = rating;
      ratingText.textContent = ratingTexts[rating];
      ratingText.className = `rating-text rating-${rating} active`;
      
      // Add a little animation to show selection
      star.style.transform = "scale(1.4) rotate(15deg)";
      setTimeout(() => {
        star.style.transform = "scale(1)";
      }, 300);
    });
  });

  // Load testimonials from database
  function loadTestimonials() {
    fetch('/testimoni/approved')
      .then(response => response.json())
      .then(data => {
        const testimoniContainer = document.querySelector('.row.mt-5');
        const testimoniCardsContainer = testimoniContainer.querySelector('.col-12').nextElementSibling?.parentElement || testimoniContainer;
        
        // Remove existing testimonial cards (keep the header)
        const existingCards = testimoniCardsContainer.querySelectorAll('.col-lg-4.col-md-6.mb-4');
        existingCards.forEach(card => card.remove());
        
        // Add new testimonial cards from database
        data.forEach((testimoni, index) => {
          const cardHtml = `
            <div class="col-lg-4 col-md-6 mb-4">
              <div class="testimoni-card" style="animation-delay: ${(index + 1) * 0.2}s;">
                <i class="fas fa-quote-right quote-icon"></i>
                <div class="user-info">
                  <div class="user-avatar">${testimoni.nama.substring(0, 2).toUpperCase()}</div>
                  <div class="user-details">
                    <h5>${testimoni.nama}</h5>
                    <p class="user-date">${testimoni.created_at}</p>
                  </div>
                </div>
                <div class="rating-display">
                  ${Array.from({length: 5}, (_, i) => 
                    `<i class="fa fa-star${i < testimoni.rating ? '' : ' empty'}"></i>`
                  ).join('')}
                </div>
                <p class="testimoni-text">
                  "${testimoni.testimoni}"
                </p>
              </div>
            </div>
          `;
          testimoniCardsContainer.insertAdjacentHTML('beforeend', cardHtml);
        });
      })
      .catch(error => {
        console.error('Error loading testimonials:', error);
      });
  }

  // Load testimonials on page load
  loadTestimonials();

  // Check testimonial eligibility on page load
  checkTestimonialEligibility();

  // Function to check testimonial eligibility
  function checkTestimonialEligibility() {
    fetch('/testimoni/check-eligibility')
      .then(response => response.json())
      .then(data => {
        const formContainer = document.getElementById('testimonialFormContainer');
        const messageContainer = document.getElementById('testimonialMessage');
        const userNameSpan = document.getElementById('userName');
        const messageText = document.getElementById('messageText');
        const actionBtn = document.getElementById('testimonialActionBtn');
        
        if (data.eligible) {
          // Show form for eligible users
          formContainer.style.display = 'block';
          messageContainer.style.display = 'none';
          userNameSpan.textContent = data.user_name;
          
          // Update available and completed counts
          document.getElementById('availableCount').textContent = data.total_available;
          document.getElementById('completedCount').textContent = data.total_completed;
          
          // Populate rental selection dropdown
          const peminjamanSelect = document.getElementById('peminjamanSelect');
          peminjamanSelect.innerHTML = '<option value="">Pilih peminjaman...</option>';
          
          data.available_rentals.forEach(rental => {
            const option = document.createElement('option');
            option.value = rental.id;
            option.textContent = `${rental.motor_name} - ${rental.formatted_date}`;
            peminjamanSelect.appendChild(option);
          });
          
          // Add change event listener to update hidden field
          peminjamanSelect.addEventListener('change', function() {
            document.getElementById('selectedPeminjamanId').value = this.value;
          });
          
        } else {
          // Show message for ineligible users
          formContainer.style.display = 'none';
          messageContainer.style.display = 'block';
          messageText.textContent = data.message;
          
          // Update button based on user status
          if (data.is_logged_in && !data.has_completed_rental) {
            // Logged in but never rented - change to "Sewa untuk Memberi Testimoni"
            actionBtn.href = '{{ route("harga_sewa") }}';
            actionBtn.innerHTML = '<i class="bi bi-motorcycle me-2"></i>Sewa untuk Memberi Testimoni';
          } else if (!data.is_logged_in) {
            // Not logged in - show login button
            actionBtn.href = '{{ route("login") }}';
            actionBtn.innerHTML = '<i class="bi bi-box-arrow-in-right me-2"></i>Login untuk Testimoni';
          }
        }
      })
      .catch(error => {
        console.error('Error checking eligibility:', error);
        // Show default message on error
        const formContainer = document.getElementById('testimonialFormContainer');
        const messageContainer = document.getElementById('testimonialMessage');
        const messageText = document.getElementById('messageText');
        const actionBtn = document.getElementById('testimonialActionBtn');
        
        formContainer.style.display = 'none';
        messageContainer.style.display = 'block';
        messageText.textContent = 'Silakan login terlebih dahulu untuk memberikan testimoni.';
        actionBtn.href = '{{ route("login") }}';
        actionBtn.innerHTML = '<i class="bi bi-box-arrow-in-right me-2"></i>Login untuk Testimoni';
      });
  }

  // Form submission
  testimonialForm.addEventListener("submit", function(e) {
    e.preventDefault();
    
    const review = document.getElementById("customerReview").value.trim();
    const rating = ratingValue.value;
    
    // Basic validation
    if (!review || !rating) {
      alert("Mohon lengkapi testimoni dan rating!");
      return;
    }
    
    if (review.length < 10) {
      alert("Testimoni harus minimal 10 karakter!");
      return;
    }
    
    // Add loading state to button
    const submitBtn = document.querySelector('.btn-submit');
    const originalText = submitBtn.innerHTML;
    submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Mengirim...';
    submitBtn.disabled = true;
    
    // Add success animation to form
    testimonialForm.classList.add('form-success');
    
    // Get selected peminjaman ID
    const peminjamanId = document.getElementById('selectedPeminjamanId').value;
    if (!peminjamanId) {
      alert('Mohon pilih peminjaman terlebih dahulu!');
      submitBtn.innerHTML = originalText;
      submitBtn.disabled = false;
      testimonialForm.classList.remove('form-success');
      return;
    }
    
    // Submit to Laravel backend using FormData instead of JSON
    const formData = new FormData();
    formData.append('testimoni', review);
    formData.append('rating', parseInt(rating));
    formData.append('peminjaman_id', peminjamanId);
    
    // Get CSRF token
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    if (csrfToken) {
      formData.append('_token', csrfToken);
    }

    fetch('/testimoni', {
      method: 'POST',
      headers: {
        'X-CSRF-TOKEN': csrfToken || '',
        'Accept': 'application/json'
      },
      body: formData
    })
    .then(response => {
      if (!response.ok) {
        throw new Error(`HTTP error! status: ${response.status}`);
      }
      return response.json();
    })
    .then(data => {
      if (data.success) {
        // Show thank you modal
        thankYouModal.show();
        
        // Reset form
        testimonialForm.reset();
        stars.forEach(s => {
          s.classList.remove("selected");
        });
        ratingValue.value = "";
        ratingText.textContent = "Pilih rating Anda";
        ratingText.className = "rating-text";
        
        // Load updated testimonials
        loadTestimonials();
        
        // Refresh eligibility to update available rentals
        setTimeout(() => {
          checkTestimonialEligibility();
        }, 1000);
      } else {
        alert('Terjadi kesalahan: ' + (data.message || 'Silakan coba lagi'));
      }
    })
    .catch(error => {
      console.error('Error:', error);
      alert('Terjadi kesalahan saat mengirim testimoni. Silakan coba lagi.');
    })
    .finally(() => {
      // Reset button
      submitBtn.innerHTML = originalText;
      submitBtn.disabled = false;
      
      // Remove success animation
      testimonialForm.classList.remove('form-success');
    });
  });
  
  // Add form validation feedback
  const inputs = document.querySelectorAll('#testimonialForm input, #testimonialForm textarea');
  inputs.forEach(input => {
    input.addEventListener('blur', function() {
      if (this.value.trim() === '') {
        this.style.borderColor = '#f44336';
        this.style.backgroundColor = '#ffebee';
      } else {
        this.style.borderColor = '#4caf50';
        this.style.backgroundColor = '#e8f5e8';
      }
    });
    
    input.addEventListener('focus', function() {
      this.style.borderColor = '#2196f3';
      this.style.backgroundColor = 'white';
    });
    
    input.addEventListener('input', function() {
      if (this.value.trim() !== '') {
        this.style.borderColor = '#4caf50';
        this.style.backgroundColor = '#e8f5e8';
      }
    });
  });
});
</script>

</body>
</html>

@endsection