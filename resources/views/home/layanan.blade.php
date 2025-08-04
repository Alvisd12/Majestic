@extends('index')

@section('content')

<script src="https://code.iconify.design/iconify-icon/1.0.8/iconify-icon.min.js"></script>

<style>
  /* Layout utama */
  .halaman-layanan-wrapper {
    display: flex;
    flex-direction: column;
    min-height: 100vh;
  }

  .spacer-top {
    height: 80px;
    background-color: #fff;
  }

  .layanan-section {
    background: linear-gradient(135deg, #4A90E2 0%, #357ABD 100%);
    padding: 60px 20px 100px 20px;
    color: #fff;
    flex-grow: 1;
  }

  .layanan-section h2 {
    font-weight: 700;
    color: #FFEB3B;
    text-align: center;
    margin-bottom: 50px;
    font-size: 2.2rem;
  }

  .layanan-container {
    max-width: 1000px;
    margin: 0 auto;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 30px;
  }

  .layanan-row {
    display: flex;
    gap: 25px;
    flex-wrap: wrap;
    justify-content: center;
  }

  .layanan-card {
    background: white;
    color: #333;
    width: 280px;
    border-radius: 15px;
    padding: 25px 20px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    text-align: center;
  }

  .icon-container {
    background: linear-gradient(135deg, #FFEB3B 0%, #FDD835 100%);
    border-radius: 50%;
    width: 70px;
    height: 70px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 20px;
    box-shadow: 0 3px 10px rgba(255, 235, 59, 0.3);
  }

  .icon-container iconify-icon {
    font-size: 32px;
    color: #4A90E2;
  }

  .spacer-footer {
    height: 60px;
    background-color: #fff;
  }

  footer.layanan-footer {
    background: #ffbf00;
    text-align: center;
    padding: 20px 0;
    font-weight: bold;
  }

  @media (max-width: 768px) {
    .layanan-section {
      padding: 40px 15px 80px 15px;
    }

    .layanan-card {
      width: 100%;
      max-width: 300px;
    }

    .spacer-top {
      height: 50px;
    }

    .spacer-footer {
      height: 40px;
    }
  }
</style>

<div class="halaman-layanan-wrapper">
  <!-- Spacer atas untuk jarak dari header -->
  <div class="spacer-top"></div>

  <!-- Section layanan -->
  <section class="layanan-section">
    <h2>Fasilitas & Layanan Kami</h2>
    <div class="layanan-container">
      <div class="layanan-row">
        <div class="layanan-card">
          <div class="icon-container">
            <iconify-icon icon="mdi:helmet"></iconify-icon>
          </div>
          <h5>Fasilitas 2 helm</h5>
          <p>Setiap sewa motor dilengkapi 2 helm standar demi keselamatan berkendara.</p>
        </div>
        <div class="layanan-card">
          <div class="icon-container">
            <iconify-icon icon="wi:rain"></iconify-icon>
          </div>
          <h5>Fasilitas 2 jas hujan</h5>
          <p>Kami sediakan jas hujan untuk mendukung kenyamanan Anda di segala cuaca.</p>
        </div>
        <div class="layanan-card">
          <div class="icon-container">
            <iconify-icon icon="mdi:motorbike"></iconify-icon>
          </div>
          <h5>Motor terjamin</h5>
          <p>Motor selalu dalam kondisi prima karena rutin dirawat, demi kenyamanan dan keamanan Anda.</p>
        </div>
      </div>

      <div class="layanan-row">
        <div class="layanan-card">
          <div class="icon-container">
            <iconify-icon icon="mdi:handshake"></iconify-icon>
          </div>
          <h5>Pelayanan ramah</h5>
          <p>Kami melayani dengan sepenuh hati, ramah, dan dapat dipercaya.</p>
        </div>
        <div class="layanan-card">
          <div class="icon-container">
            <iconify-icon icon="mdi:cash"></iconify-icon>
          </div>
          <h5>Harga sewa terjangkau</h5>
          <p>Nikmati tarif sewa yang ramah di kantong dengan pilihan motor sesuai kebutuhan Anda.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Spacer bawah untuk jarak ke footer -->
  <div class="spacer-footer"></div>


@endsection
p