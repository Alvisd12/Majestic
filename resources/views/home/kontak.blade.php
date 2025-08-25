@extends('index')

@section('content')
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

/* All card variants now use the same white style */
.kontak-card.primary,
.kontak-card.secondary,
.kontak-card.white {
  background: white;
  color: #1565c0;
  border: 2px solid #e3f2fd;
}

.kontak-card.primary:hover,
.kontak-card.secondary:hover,
.kontak-card.white:hover {
  background: linear-gradient(135deg, #f8fbff 0%, #e3f2fd 100%);
  border-color: #2196f3;
  color: #0d47a1;
  box-shadow: 0 20px 60px rgba(33, 150, 243, 0.25);
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

.kontak-card.primary i,
.kontak-card.secondary i,
.kontak-card.white i {
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

/* Maps and Review Section */
.maps-ulasan {
  background: linear-gradient(135deg, #ffffff 0%, #f8fbff 100%);
  padding: 100px 0;
  position: relative;
}

.maps-ulasan::after {
  content: '';
  position: absolute;
  bottom: 0;
  left: 0;
  right: 0;
  height: 1px;
  background: linear-gradient(90deg, transparent, #2196f3, transparent);
}

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

.review-form {
  background: white;
  border-radius: 24px;
  padding: 3rem;
  box-shadow: 0 20px 60px rgba(33, 150, 243, 0.12);
  border: 2px solid #e3f2fd;
  position: relative;
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

/* Modal Styles */
.modal-content {
  border: none;
  border-radius: 24px;
  overflow: hidden;
  box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
}

.modal-header {
  background: linear-gradient(135deg, #2196f3 0%, #1976d2 100%);
  color: white;
  border: none;
  padding: 2.5rem;
  text-align: center;
}

.modal-body {
  padding: 3rem;
  text-align: center;
  background: linear-gradient(135deg, #f8fbff 0%, white 100%);
}

.modal-body i {
  font-size: 5rem;
  color: #ffc107;
  margin-bottom: 1.5rem;
  animation: checkmark 0.8s ease-in-out;
  text-shadow: 0 4px 20px rgba(255, 193, 7, 0.4);
}

@keyframes checkmark {
  0% {
    transform: scale(0) rotate(-180deg);
    opacity: 0;
  }
  50% {
    transform: scale(1.3) rotate(0deg);
  }
  100% {
    transform: scale(1) rotate(0deg);
    opacity: 1;
  }
}

.modal-body h5 {
  color: #1565c0;
  font-weight: 800;
  margin-bottom: 1rem;
  font-size: 1.5rem;
}

.modal-body p {
  color: #546e7a;
  font-size: 1.2rem;
  line-height: 1.6;
}

.btn-close-modal {
  background: linear-gradient(135deg, #ffc107 0%, #ff9800 100%);
  border: none;
  border-radius: 12px;
  padding: 15px 30px;
  color: white;
  font-weight: 700;
  font-size: 1.1rem;
  transition: all 0.3s ease;
  box-shadow: 0 4px 20px rgba(255, 193, 7, 0.4);
}

.btn-close-modal:hover {
  transform: translateY(-2px);
  box-shadow: 0 6px 30px rgba(255, 193, 7, 0.6);
  background: linear-gradient(135deg, #ff9800 0%, #f57c00 100%);
}

/* Responsive Design */
@media (max-width: 768px) {
  .kontak-section {
    padding: 80px 0;
  }
  
  .kontak-section h2 {
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
  
  .maps-ulasan {
    padding: 80px 0;
  }
  
  .review-form {
    padding: 2rem;
    margin-top: 3rem;
  }
  
  .rating .fa-star {
    font-size: 2.5rem;
    gap: 8px;
  }
  
  .maps-container iframe {
    height: 350px;
  }
}

@media (max-width: 576px) {
  .kontak-section h2 {
    font-size: 1.8rem;
  }
  
  .kontak-card {
    height: 180px;
    padding: 1.5rem 1rem;
  }
  
  .kontak-card p {
    font-size: 1rem;
  }
  
  .rating .fa-star {
    font-size: 2.2rem;
  }
  
  .review-form {
    padding: 1.5rem;
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

.kontak-card {
  animation: fadeInUp 0.8s ease forwards;
}

.kontak-card:nth-child(1) { animation-delay: 0.1s; }
.kontak-card:nth-child(2) { animation-delay: 0.2s; }
.kontak-card:nth-child(3) { animation-delay: 0.3s; }
.kontak-card:nth-child(4) { animation-delay: 0.4s; }
.kontak-card:nth-child(5) { animation-delay: 0.5s; }
.kontak-card:nth-child(6) { animation-delay: 0.6s; }

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
</style>

<section class="kontak-section">
  <div class="container text-center">
    <h2>Jika Ada Pertanyaan</h2>
    <h4>Silahkan Hubungi Kami</h4>

    <!-- Baris Pertama - 3 Card -->
    <div class="row justify-content-center g-4 mb-5">
      <div class="col-lg-4 col-md-6">
        <div class="kontak-card white">
          <i class="bi bi-geo-alt-fill"></i>
          <p>Gg. Kaserin M U, Lesanpuro, Kec. Kedungkandang, Kota Malang, Jawa Timur 65138</p>
        </div>
      </div>
      <div class="col-lg-4 col-md-6">
        <div class="kontak-card white">
          <i class="bi bi-telephone-fill"></i>
          <p>0851-0547-4050</p>
        </div>
      </div>
      <div class="col-lg-4 col-md-6">
        <div class="kontak-card white">
          <i class="bi bi-envelope-fill"></i>
          <p>majestictransport@gmail.com</p>
        </div>
      </div>
    </div>

    <!-- Baris Kedua - 3 Card -->
    <div class="row justify-content-center g-4">
      <div class="col-lg-4 col-md-6">
        <div class="kontak-card white">
          <i class="bi bi-clock-fill"></i>
          <p>07.00 s/d 21.00 WIB</p>
        </div>
      </div>
      <div class="col-lg-4 col-md-6">
        <div class="kontak-card white">
          <i class="bi bi-instagram"></i>
          <p>@sewamotormalang_id</p>
        </div>
      </div>
      <div class="col-lg-4 col-md-6">
        <div class="kontak-card white">
          <i class="bi bi-tiktok"></i>
          <p>@sewamotormalang.batu</p>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="maps-ulasan">
  <div class="container">
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
        <div class="review-form">
          <h5><i class="bi bi-chat-heart-fill me-2"></i>Berikan Testimoni Anda</h5>
          
          <form id="testimonialForm">
            <div class="mb-4">
              <label class="form-label"><i class="bi bi-person-fill me-2"></i>Nama Anda</label>
              <input type="text" class="form-control" id="customerName" placeholder="Masukkan nama lengkap Anda" required>
            </div>

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
      </div>
    </div>
  </div>
</section>

<!-- Modal Thank You -->
<div class="modal fade" id="thankYouModal" tabindex="-1" aria-labelledby="thankYouModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title w-100" id="thankYouModalLabel">
          <i class="bi bi-heart-fill me-2"></i>Terima Kasih!
        </h4>
      </div>
      <div class="modal-body">
        <i class="bi bi-check-circle-fill"></i>
        <h5>Testimoni Berhasil Dikirim!</h5>
        <p>Terima kasih telah memberikan testimoni. Masukan Anda sangat berharga untuk meningkatkan pelayanan kami.</p>
        <button type="button" class="btn btn-close-modal" data-bs-dismiss="modal">
          <i class="bi bi-hand-thumbs-up me-2"></i>Tutup
        </button>
      </div>
    </div>
  </div>
</div>

@endsection

@push('scripts')
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

  // Form submission
  testimonialForm.addEventListener("submit", function(e) {
    e.preventDefault();
    
    const name = document.getElementById("customerName").value.trim();
    const review = document.getElementById("customerReview").value.trim();
    const rating = ratingValue.value;
    
    // Basic validation
    if (!name || !review || !rating) {
      alert("Mohon lengkapi semua field termasuk rating!");
      return;
    }
    
    if (name.length < 2) {
      alert("Nama harus minimal 2 karakter!");
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
    
    // Simulate form submission (replace with actual AJAX call)
    setTimeout(() => {
      console.log("Testimoni submitted:", { 
        name, 
        review, 
        rating: parseInt(rating),
        ratingText: ratingTexts[rating],
        timestamp: new Date().toISOString()
      });
      
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
      
      // Reset button
      submitBtn.innerHTML = originalText;
      submitBtn.disabled = false;
      
      // Remove success animation
      testimonialForm.classList.remove('form-success');
      
    }, 2000);
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
@endpush