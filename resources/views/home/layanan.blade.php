@extends('index')

@section('content')

<script src="https://code.iconify.design/iconify-icon/1.0.8/iconify-icon.min.js"></script>

<style>
  body {
  font-family: 'Poppins', sans-serif;
}

  /* Layout utama */
  .halaman-layanan-wrapper {
    display: flex;
    flex-direction: column;
    min-height: 100vh;
    position: relative;
    overflow-x: hidden;
  }

  .spacer-top {
    height: 80px;
    background: linear-gradient(180deg, #ffffff 0%, #f8f9fa 100%);
  }

.layanan-section {
    background: #ffffff; /* putih polos */
    padding: 80px 20px 120px 20px;
    color: #333; /* teks default hitam */
    flex-grow: 1;
    position: relative;
}


  /* Background decorative elements */
  .layanan-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: 
      radial-gradient(circle at 20% 80%, rgba(255, 235, 59, 0.1) 0%, transparent 50%),
      radial-gradient(circle at 80% 20%, rgba(255, 235, 59, 0.1) 0%, transparent 50%);
    pointer-events: none;
  }

  .layanan-section h2 {
    font-weight: 800;
    color: #0466C8;
    text-align: center;
    margin-bottom: 60px;
    font-size: 2.5rem;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
    position: relative;
    animation: fadeInDown 1s ease-out;
  }



  .layanan-container {
    max-width: 1100px;
    margin: 0 auto;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 40px;
  }

  .layanan-row {
    display: flex;
    gap: 30px;
    flex-wrap: wrap;
    justify-content: center;
  }

  .layanan-card {
    background: linear-gradient(145deg, #ffffff, #f8f9fa);
    color: #333;
    width: 300px;
    border-radius: 20px;
    padding: 30px 25px;
    box-shadow: 
      0 10px 30px rgba(0, 0, 0, 0.1),
      0 4px 15px rgba(0, 0, 0, 0.05);
    text-align: center;
    position: relative;
    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    transform: translateY(0);
    opacity: 0;
    animation: cardFadeInUp 0.8s ease-out forwards;
    border: 1px solid rgba(255, 255, 255, 0.2);
  }

  .layanan-card:nth-child(1) { animation-delay: 0.2s; }
  .layanan-card:nth-child(2) { animation-delay: 0.4s; }
  .layanan-card:nth-child(3) { animation-delay: 0.6s; }
  .layanan-card:nth-child(4) { animation-delay: 0.8s; }
  .layanan-card:nth-child(5) { animation-delay: 1s; }

  .layanan-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 5px;
    background: linear-gradient(90deg, #FFEB3B, #FDD835);
    border-radius: 20px 20px 0 0;
    transform: scaleX(0);
    transition: transform 0.3s ease-out;
  }


  .layanan-card:hover::before {
    transform: scaleX(1);
  }

  .icon-container {
    background: linear-gradient(135deg, #FFEB3B 0%, #FDD835 50%, #F9A825 100%);
    border-radius: 50%;
    width: 80px;
    height: 80px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 25px;
    box-shadow: 
      0 8px 25px rgba(255, 235, 59, 0.4),
      inset 0 2px 4px rgba(255, 255, 255, 0.3);
    position: relative;
    transition: all 0.3s ease-out;
  }

  .icon-container::before {
    content: '';
    position: absolute;
    top: -3px;
    left: -3px;
    right: -3px;
    bottom: -3px;
    background: linear-gradient(135deg, #FFEB3B, #FDD835);
    border-radius: 50%;
    z-index: -1;
    opacity: 0;
    transition: opacity 0.3s ease-out;
  }

  .layanan-card:hover .icon-container {
    transform: scale(1.1);
   
  }

  .layanan-card:hover .icon-container::before {
    opacity: 0.7;
  }

  .icon-container iconify-icon {
    font-size: 36px;
    color: #0466C8;
    transition: all 0.3s ease-out;
  }

  .layanan-card:hover .icon-container iconify-icon {
    transform: scale(1.1);
    color: #034078;
  }

  .layanan-card h5 {
    font-size: 1.3rem;
    font-weight: 700;
    margin-bottom: 15px;
    color: #2C5282;
    transition: color 0.3s ease-out;
  }

  .layanan-card:hover h5 {
    color: #1A365D;
  }

  .layanan-card p {
    font-size: 0.95rem;
    line-height: 1.6;
    color: #666;
    margin: 0;
    transition: color 0.3s ease-out;
  }

  .layanan-card:hover p {
    color: #555;
  }

  .spacer-footer {
    height: 80px;
    background: linear-gradient(180deg, #f8f9fa 0%, #ffffff 100%);
  }

  /* Animations */
  @keyframes fadeInDown {
    from {
      opacity: 0;
      transform: translateY(-30px);
    }
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }

  @keyframes slideIn {
    from {
      width: 0;
      opacity: 0;
    }
    to {
      width: 80px;
      opacity: 1;
    }
  }

  @keyframes cardFadeInUp {
    from {
      opacity: 0;
      transform: translateY(50px);
    }
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }

  @keyframes pulse {
    0%, 100% {
      box-shadow: 
        0 8px 25px rgba(255, 235, 59, 0.4),
        inset 0 2px 4px rgba(255, 255, 255, 0.3);
    }
    50% {
      box-shadow: 
        0 12px 35px rgba(255, 235, 59, 0.6),
        inset 0 2px 4px rgba(255, 255, 255, 0.3);
    }
  }

  @keyframes float {
    0%, 100% {
      transform: translateY(0px);
    }
    50% {
      transform: translateY(-10px);
    }
  }

  /* Scroll animations */
  @media (prefers-reduced-motion: no-preference) {
    .layanan-card {
      animation: cardFadeInUp 0.8s ease-out forwards;
    }
  }

  /* Responsive Design */
  @media (max-width: 768px) {
    .layanan-section {
      padding: 60px 15px 100px 15px;
    }

    .layanan-section h2 {
      font-size: 2rem;
      margin-bottom: 40px;
    }

    .layanan-card {
      width: 100%;
      max-width: 320px;
      padding: 25px 20px;
    }

    .icon-container {
      width: 70px;
      height: 70px;
    }

    .icon-container iconify-icon {
      font-size: 32px;
    }

    .spacer-top {
      height: 60px;
    }

    .spacer-footer {
      height: 60px;
    }

    .layanan-container {
      gap: 25px;
    }

    .layanan-row {
      gap: 20px;
    }
  }

  @media (max-width: 480px) {
    .layanan-section {
      padding: 40px 10px 80px 10px;
    }

    .layanan-section h2 {
      font-size: 1.8rem;
    }

    .layanan-card {
      padding: 20px 15px;
    }

    .spacer-top {
      height: 50px;
    }
  }

  /* Accessibility improvements */
  @media (prefers-reduced-motion: reduce) {
    * {
      animation-duration: 0.01ms !important;
      animation-iteration-count: 1 !important;
      transition-duration: 0.01ms !important;
    }
  }

  /* Focus states for accessibility */
  .layanan-card:focus-within {
    outline: 3px solid #FFEB3B;
    outline-offset: 2px;
  }
</style>

<div class="halaman-layanan-wrapper">
  <!-- Spacer atas untuk jarak dari header -->
  <div class="spacer-top"></div>

  <!-- Section layanan -->
  <section class="layanan-section">
    <h2>Fasilitas Layanan Kami</h2>
    <div class="layanan-container">
      <div class="layanan-row">
        <div class="layanan-card">
          <div class="icon-container">
            <iconify-icon icon="mdi:helmet"></iconify-icon>
          </div>
          <h5>Fasilitas 2 Helm</h5>
          <p>Setiap sewa motor dilengkapi 2 helm standar demi keselamatan berkendara yang optimal.</p>
        </div>
        <div class="layanan-card">
          <div class="icon-container">
            <iconify-icon icon="wi:rain"></iconify-icon>
          </div>
          <h5>Fasilitas 2 Jas Hujan</h5>
          <p>Kami sediakan jas hujan berkualitas untuk mendukung kenyamanan Anda di segala cuaca.</p>
        </div>
        <div class="layanan-card">
          <div class="icon-container">
            <iconify-icon icon="mdi:motorbike"></iconify-icon>
          </div>
          <h5>Motor Terjamin</h5>
          <p>Motor selalu dalam kondisi prima karena rutin dirawat, demi kenyamanan dan keamanan Anda.</p>
        </div>
      </div>

      <div class="layanan-row">
        <div class="layanan-card">
          <div class="icon-container">
            <iconify-icon icon="mdi:handshake"></iconify-icon>
          </div>
          <h5>Pelayanan Ramah</h5>
          <p>Kami melayani dengan sepenuh hati, ramah, profesional, dan dapat dipercaya sepenuhnya.</p>
        </div>
        <div class="layanan-card">
          <div class="icon-container">
            <iconify-icon icon="mdi:cash"></iconify-icon>
          </div>
          <h5>Harga Sewa Terjangkau</h5>
          <p>Nikmati tarif sewa yang ramah di kantong dengan pilihan motor sesuai kebutuhan Anda.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Spacer bawah untuk jarak ke footer -->
  <div class="spacer-footer"></div>
</div>

@endsection