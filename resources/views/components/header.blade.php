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
      background-color:black;
      padding: 1rem 2rem;
      box-shadow: 0 2px 10px rgba(248, 226, 226, 0.1);
    }

    .logo img {
      height: 60px;
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
      color: white;
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
        <img src="{{ asset('assets/images/logoputih.png') }}" alt="Majestic Transport Logo">
      </a>
    </div>

    <nav>
      <ul class="nav-links">
        <li><a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Home</a></li>
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
        @if(session('user_id') && session('user_role') === 'pengunjung')
          <div class="user-menu" style="position: relative;">
            <button class="user-btn" onclick="toggleUserMenu()" style="background: #FFC107; color: white; padding: 0.4rem 1rem; border-radius: 25px; border: none; font-weight: 600; font-size: 1rem; cursor: pointer; display: flex; align-items: center; gap: 0.5rem;">
              @php
                $user = \App\Models\Pengunjung::find(session('user_id'));
              @endphp
              @if($user && $user->profile_photo)
                <img src="{{ asset('storage/' . $user->profile_photo) }}" alt="Profile" style="width: 25px; height: 25px; border-radius: 50%; object-fit: cover;">
              @else
                <iconify-icon icon="ic:baseline-person"></iconify-icon>
              @endif
              {{ session('user_name') }}
              <iconify-icon icon="ic:baseline-keyboard-arrow-down"></iconify-icon>
            </button>
            <div id="userDropdown" class="user-dropdown" style="display: none; position: absolute; top: 100%; right: 0; background: white; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); min-width: 200px; z-index: 1000; margin-top: 0.5rem;">
              <a href="{{ route('user.profile') }}" style="display: block; padding: 0.75rem 1rem; text-decoration: none; color: #333; border-bottom: 1px solid #eee;">
                <iconify-icon icon="ic:baseline-person" style="margin-right: 0.5rem;"></iconify-icon>
                Profil Saya
              </a>
              <a href="{{ route('user.bookings') }}" style="display: block; padding: 0.75rem 1rem; text-decoration: none; color: #333; border-bottom: 1px solid #eee;">
                <iconify-icon icon="ic:baseline-book" style="margin-right: 0.5rem;"></iconify-icon>
                Booking Saya
              </a>
              <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                @csrf
                <button type="submit" style="width: 100%; text-align: left; padding: 0.75rem 1rem; background: none; border: none; color: #dc3545; cursor: pointer;">
                  <iconify-icon icon="ic:baseline-logout" style="margin-right: 0.5rem;"></iconify-icon>
                  Logout
                </button>
              </form>
            </div>
          </div>
        @else
          <a href="{{ route('login') }}" class="login-btn">Login</a>
        @endif
      </div>
    </nav>
  </header>

  <script>
    // Navbar scroll behavior
    window.addEventListener('scroll', function () {
      const navbar = document.querySelector('.navbar');
      navbar.classList.toggle('scrolled', window.scrollY > 50);
    });

    // User menu toggle
    function toggleUserMenu() {
      const dropdown = document.getElementById('userDropdown');
      dropdown.style.display = dropdown.style.display === 'none' ? 'block' : 'none';
    }

    // Close dropdown when clicking outside
    document.addEventListener('click', function(event) {
      const userMenu = document.querySelector('.user-menu');
      const dropdown = document.getElementById('userDropdown');
      
      if (userMenu && !userMenu.contains(event.target)) {
        dropdown.style.display = 'none';
      }
    });
  </script>

</body>
</html>