<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Majestic Transport</title>

  <!-- Iconify -->
  <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    html, body {
      margin: 0;
      padding: 0;
      font-family: 'Poppins', sans-serif;
    }

    body {
      min-height: 2000px;
      
    }

    header.navbar {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      background: transparent;
      padding: 2rem 2rem; /* tinggi saat awal (transparan) */
      display: flex;
      justify-content: space-between;
      align-items: center;
      z-index: 999;
      transition: background-color 0.3s ease, padding 0.3s ease;
    }

    header.navbar.scrolled {
      background-color: #FFF56C;
      padding: 1rem 2rem; /* lebih ramping saat scroll */
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .logo img {
      height: 50px;
    }

    nav {
      display: flex;
      align-items: center;
      gap: 1.5rem;
    }

    ul.nav-links {
      list-style: none;
      display: flex;
      gap: 20px;
    }

    ul.nav-links li a {
      text-decoration: none;
      color: black;
      font-weight: 600;
      font-size: 1.1rem;
      position: relative;
      padding: 5px 0;
    }

    ul.nav-links li a.active::after {
      content: '';
      position: absolute;
      width: 100%;
      height: 3px;
      background: #0466C8;
      left: 0;
      bottom: -4px;
    }

    .nav-actions {
      display: flex;
      align-items: center;
      gap: 1rem;
    }

    .search-container {
      display: flex;
      align-items: center;
      background: #0466C8;
      border-radius: 25px;
      padding: 0.3rem 0.8rem;
    }

    .search-container iconify-icon {
      color: white;
      font-size: 1.3rem;
    }

    .search-container input {
      border: none;
      outline: none;
      padding: 0.3rem 0.5rem;
      border-radius: 25px;
      margin-left: 0.3rem;
      font-size: 0.95rem;
      width: 120px;
    }

    .login-btn {
      background: #0466C8;
      color: white;
      padding: 0.4rem 1rem;
      border-radius: 25px;
      border: none;
      font-weight: 600;
      text-decoration: none;
      font-size: 1rem;
    }
  </style>
</head>
<body>

  <header class="navbar">
    <div class="logo">
      <a href="/">
        <img src="{{ asset('assets/images/logo.png') }}" alt="Majestic Transport Logo">
      </a>
    </div>

    <nav>
      <ul class="nav-links">
        <li><a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">Home</a></li>
        <li><a href="{{ route('harga_sewa') }}" class="{{ request()->routeIs('harga_sewa') ? 'active' : '' }}">Harga Sewa</a></li>
        <li><a href="{{ route('layanan') }}" class="{{ request()->routeIs('layanan') ? 'active' : '' }}">Layanan</a></li>
        <li><a href="{{ route('galeri') }}" class="{{ request()->routeIs('galeri') ? 'active' : '' }}">Galeri</a></li>
        <li><a href="{{ route('kontak') }}" class="{{ request()->routeIs('kontak') ? 'active' : '' }}">Kontak Kami</a></li>
      </ul>

      <div class="nav-actions">
        <div class="search-container">
          <input type="text" placeholder="Search..." />
        </div>

        <a href="{{ route('login') }}" class="login-btn">Login</a>
      </div>
    </nav>
  </header>

  <script>
    // Scroll effect
    window.addEventListener('scroll', function () {
      const navbar = document.querySelector('.navbar');
      navbar.classList.toggle('scrolled', window.scrollY > 50);
    });
  </script>

</body>
</html>
