@extends('index')

@section('content')

<!-- Bagian Data Motor -->
@php
  $motors = [
    ['nama' => 'Beat Deluxe', 'gambar' => 'assets/images/motor1.jpg', 'harga_sewa' => 70000, 'deskripsi' => 'Motor irit dan nyaman'],
    ['nama' => 'Vario', 'gambar' => 'assets/images/motor2.jpg', 'harga_sewa' => 70000, 'deskripsi' => 'Kapasitas besar dan stabil'],
    ['nama' => 'Scoopy 2020', 'gambar' => 'assets/images/motor3.jpg', 'harga_sewa' => 70000, 'deskripsi' => 'Desain retro modern'],
    ['nama' => 'Genio', 'gambar' => 'assets/images/motor4.jpg', 'harga_sewa' => 70000, 'deskripsi' => 'Ringan dan gesit'],
    ['nama' => 'Beat Deluxe', 'gambar' => 'assets/images/motor5.jpg', 'harga_sewa' => 70000, 'deskripsi' => 'Motor irit dan nyaman'],
    ['nama' => 'Vario', 'gambar' => 'assets/images/motor6.jpg', 'harga_sewa' => 70000, 'deskripsi' => 'Kapasitas besar dan stabil'],
    ['nama' => 'Scoopy 2020', 'gambar' => 'assets/images/motor7.jpg', 'harga_sewa' => 70000, 'deskripsi' => 'Desain retro modern'],
    ['nama' => 'Genio', 'gambar' => 'assets/images/motor8.jpg', 'harga_sewa' => 70000, 'deskripsi' => 'Ringan dan gesit'],
  ];
@endphp

<!-- Tampilan Harga Sewa -->
<section class="harga-sewa py-5">
  <div class="container">
    <h2 class="text-center mb-4">Harga Sewa Motor</h2>
    <div class="row justify-content-center">
      @foreach ($motors as $motor)
        <div class="col-md-4 col-lg-3 mb-4">
          <div class="card shadow-sm h-100">
            <img src="{{ asset($motor['gambar']) }}" class="card-img-top" alt="{{ $motor['nama'] }}">
            <div class="card-body text-center">
              <h5 class="card-title">{{ $motor['nama'] }}</h5>
              <p class="card-text">{{ $motor['deskripsi'] }}</p>
              <p class="text-warning fw-bold">Rp {{ number_format($motor['harga_sewa'], 0, ',', '.') }}/hari</p>
            </div>
          </div>
        </div>
      @endforeach
    </div>
  </div>
</section>

@endsection
