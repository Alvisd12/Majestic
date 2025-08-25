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
      padding: 2rem 2rem;
      display: flex;
      justify-content: space-between;
      align-items: center;
      z-index: 999;
      transition: background-color 0.3s ease, padding 0.3s ease;
    }

    header.navbar.scrolled {
      background-color: #ffffffff;
      padding: 1rem 2rem;
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
      gap: 30px;
      align-items: center;
      margin: 0;
      padding: 0;
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
      background: #FFC107;
      left: 0;
      bottom: -4px;
    }

    .nav-actions {
      display: flex;
      align-items: center;
      gap: 1rem;
      position: relative;
    }

    /* Search bar yang lebih clean */
    .search-bar {
      position: relative;
      display: flex;
      align-items: center;
    }

    .search-bar input {
      padding: 0.5rem 2.5rem 0.5rem 1rem;
      border: none;
      border-radius: 999px;
      background: white;
      font-size: 0.95rem;
      width: 250px;
      outline: none;
      box-shadow: 0 2px 6px rgba(0,0,0,0.15);
    }

    .search-bar .search-icon {
      position: absolute;
      right: 15px;
      color: black;
      pointer-events: none;
      font-size: 1.2rem;
    }

    .login-btn {
      background: #FFC107;
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
        <li><a href="{{ route('galeri') }}" class="{{ request()->routeIs('galeri') ? 'active' : '' }}">Galeri</a></li>
        <li><a href="{{ route('kontak') }}" class="{{ request()->routeIs('kontak') ? 'active' : '' }}">Kontak Kami</a></li>
      </ul>

      <div class="nav-actions">
        <div class="search-bar">
          <input type="text" placeholder="Search" />
          <span class="search-icon">
            <iconify-icon icon="ic:baseline-search"></iconify-icon>
          </span>
        </div>
        <a href="{{ route('login') }}" class="login-btn">Login</a>
      </div>
    </nav>
  </header>

  <script>
    // Navbar scroll behavior
    window.addEventListener('scroll', function () {
      const navbar = document.querySelector('.navbar');
      navbar.classList.toggle('scrolled', window.scrollY > 50);
    });
  </script>

</body>
</html>