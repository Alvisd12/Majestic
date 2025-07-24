@extends('index')

@section('content')

<section class="layanan-section section-spacing">
  <div class="container">
    <h2 class="text-center mb-5 text-primary fw-bold">Fasilitas & Layanan Kami</h2>
    <div class="row justify-content-center">
      <div class="col-md-4 col-sm-6 mb-4">
        <div class="layanan-card text-center">
          <img src="{{ asset('assets/icons/helm.png') }}" alt="Helm" class="icon-img mb-3">
          <h5 class="fw-bold">Fasilitas 2 helm</h5>
          <p>Setiap sewa motor dilengkapi 2 helm standar demi keselamatan berkendara.</p>
        </div>
      </div>
      <div class="col-md-4 col-sm-6 mb-4">
        <div class="layanan-card text-center">
          <img src="{{ asset('assets/icons/jas.png') }}" alt="Jas Hujan" class="icon-img mb-3">
          <h5 class="fw-bold">Fasilitas 2 jas hujan</h5>
          <p>Kami sediakan jas hujan untuk mendukung kenyamanan Anda di segala cuaca.</p>
        </div>
      </div>
      <div class="col-md-4 col-sm-6 mb-4">
        <div class="layanan-card text-center">
          <img src="{{ asset('assets/icons/motor.png') }}" alt="Motor Aman" class="icon-img mb-3">
          <h5 class="fw-bold">Motor terjamin</h5>
          <p>Motor selalu dalam kondisi prima karena rutin dirawat, demi kenyamanan dan keamanan Anda.</p>
        </div>
      </div>
      <div class="col-md-4 col-sm-6 mb-4">
        <div class="layanan-card text-center">
          <img src="{{ asset('assets/icons/tangan.png') }}" alt="Ramah" class="icon-img mb-3">
          <h5 class="fw-bold">Pelayanan ramah</h5>
          <p>Kami melayani dengan sepenuh hati, ramah, dan dapat dipercaya.</p>
        </div>
      </div>
      <div class="col-md-4 col-sm-6 mb-4">
        <div class="layanan-card text-center">
          <img src="{{ asset('assets/icons/uang.png') }}" alt="Harga" class="icon-img mb-3">
          <h5 class="fw-bold">Harga sewa terjangkau</h5>
          <p>Nikmati tarif sewa yang ramah di kantong dengan pilihan motor sesuai kebutuhan Anda.</p>
        </div>
      </div>
    </div>
  </div>
</section>

@endsection