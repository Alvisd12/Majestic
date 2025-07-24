<header style="background: #FFF56C; padding: 1rem 2rem; display: flex; justify-content: space-between; align-items: center;">
  <div class="logo">
    <a href="/">
      <img src="{{ asset('assets/images/logo.png') }}" alt="Majestic Transport Logo" style="height: 40px;">
    </a>
  </div>
  <nav>
    <ul style="display: flex; gap: 20px; list-style: none; margin: 0;">
      <li><a href="{{ route('dashboard') }}">Home</a></li>
      <li><a href="{{ route('harga_sewa') }}">Harga Sewa</a></li>
      <li><a href="{{ route('layanan') }}">Layanan</a></li>
      <li><a href="{{ route('galeri') }}">Galeri</a></li>
      <li><a href="{{ route('kontak') }}">Kontak Kami</a></li>
      <li><a href="{{ route('login') }}">Login</a></li>
    </ul>
  </nav>
</header>