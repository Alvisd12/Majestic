@extends('index')

@section('content')
  <section class="galeri-section pt-5 pb-5">
    <div class="container text-center">
      <h2 class="mb-4 fw-bold text-uppercase">Galeri Sewa Motor</h2>
      <div class="row">
        @php
          $galeri = [
            'foto1.jpg', 'foto2.jpg', 'foto3.jpg',
            'foto4.png', 'foto5.png', 'foto6.png',
            'foto7.png', 'foto8.png', 'foto9.png',
            'foto10.png', 'foto11.png', 'foto12.png',
          ];
        @endphp

        @foreach($galeri as $gambar)
          <div class="col-lg-4 col-md-6 mb-4">
            <div class="galeri-card">
              <img src="{{ asset('assets/images/' . $gambar) }}" alt="Galeri Gambar" class="img-fluid galeri-img">
            </div>
          </div>
        @endforeach
      </div>
    </div>
  </section>
@endsection
