@extends('index')

@section('content')
<section class="kontak-section py-5">
  <div class="container text-center">
    <h2 class="fw-bold text-primary">Jika Ada Pertanyaan</h2>
    <h4 class="fw-bold text-warning mb-5">Silahkan Hubungi Kami</h4>

    <div class="row justify-content-center g-4">
      <div class="col-md-3">
        <div class="kontak-card blue">
          <i class="bi bi-geo-alt-fill fs-4"></i>
          <p>Gg. Kaserin M U, Lesanpuro, Kec. Kedungkandang, Kota Malang, Jawa Timur 65138, Indonesia</p>
        </div>
      </div>
      <div class="col-md-3">
        <div class="kontak-card white">
          <i class="bi bi-telephone-fill fs-4"></i>
          <p>0851-0547-4050</p>
        </div>
      </div>
      <div class="col-md-3">
        <div class="kontak-card blue">
          <i class="bi bi-envelope-fill fs-4"></i>
          <p>majestictransport@gmail.com</p>
        </div>
      </div>
      <div class="col-md-3">
        <div class="kontak-card white">
          <i class="bi bi-clock-fill fs-4"></i>
          <p>07.00 s/d 21.00 WIB</p>
        </div>
      </div>
    </div>

    <div class="row justify-content-center mt-4 g-4">
      <div class="col-md-3">
        <div class="kontak-card blue">
          <i class="bi bi-instagram fs-4"></i>
          <p>sewamotormalang_id</p>
        </div>
      </div>
      <div class="col-md-3">
        <div class="kontak-card white">
          <i class="bi bi-tiktok fs-4"></i>
          <p>sewamotormalang.batu</p>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="maps-ulasan py-5 bg-light">
  <div class="container">
    <div class="row g-4">
      <div class="col-md-6">
        <iframe
          src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d..."
          width="100%" height="350" style="border:0;" allowfullscreen="" loading="lazy">
        </iframe>
      </div>

      <div class="col-md-6">
        <div class="p-4 shadow bg-white rounded">
          <h5 class="fw-bold mb-3">Nama Anda</h5>
          <input type="text" class="form-control mb-3" placeholder="Masukan Nama Anda">

          <h5 class="fw-bold mb-3">Ulasan</h5>
          <textarea class="form-control mb-3" placeholder="Masukan Ulasan Anda" rows="4"></textarea>

          <h5 class="fw-bold mb-3">Rating</h5>
          <div class="rating" id="rating">
            <i class="fa fa-star" data-value="1"></i>
            <i class="fa fa-star" data-value="2"></i>
            <i class="fa fa-star" data-value="3"></i>
            <i class="fa fa-star" data-value="4"></i>
            <i class="fa fa-star" data-value="5"></i>
          </div>
          <input type="hidden" name="rating" id="rating-value">


          <button class="btn btn-warning fw-bold px-4">Kirim</button>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
<script>
  const stars = document.querySelectorAll("#rating .fa-star");
  const ratingValue = document.getElementById("rating-value");

  stars.forEach((star, index) => {
    star.addEventListener("mouseover", () => {
      stars.forEach((s, i) => {
        s.classList.toggle("hovered", i <= index);
      });
    });

    star.addEventListener("mouseout", () => {
      stars.forEach(s => s.classList.remove("hovered"));
    });

    star.addEventListener("click", () => {
      stars.forEach((s, i) => {
        s.classList.toggle("selected", i <= index);
      });
      ratingValue.value = index + 1; // Simpan rating ke input hidden
    });
  });
</script>

<style>
  
</style>