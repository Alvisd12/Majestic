<header style="background: #FFF56C; padding: 1rem 2rem; display: flex; justify-content: space-between; align-items: center;">
  <div class="logo">
    <a href="/">
      <img src="{{ asset('assets/images/logo.png') }}" alt="Majestic Transport Logo" style="height: 40px;">
    </a>
  </div>
  <nav>
    <ul style="display: flex; gap: 20px; list-style: none; margin: 0; align-items: center;">
      <li><a href="{{ route('home') }}">Home</a></li>
      <li><a href="{{ route('harga_sewa') }}">Harga Sewa</a></li>
      <li><a href="{{ route('layanan') }}">Layanan</a></li>
      <li><a href="{{ route('galeri') }}">Galeri</a></li>
      <li><a href="{{ route('kontak') }}">Kontak Kami</a></li>
      
      @if(session('is_logged_in'))
        <!-- User is logged in -->
        <li class="dropdown" style="position: relative;">
          <a href="#" class="dropdown-toggle" style="display: flex; align-items: center; gap: 8px; text-decoration: none; color: #333; font-weight: 500;" onclick="toggleDropdown(event)">
            <i class="fas fa-user-circle" style="font-size: 20px;"></i>
            {{ session('user_name') }}
            <i class="fas fa-chevron-down" style="font-size: 12px;"></i>
          </a>
          <div class="dropdown-menu" id="userDropdown" style="display: none; position: absolute; top: 100%; right: 0; background: white; border: 1px solid #ddd; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); min-width: 200px; z-index: 1000;">
            <div style="padding: 12px 16px; border-bottom: 1px solid #eee; font-size: 14px; color: #666;">
              <strong>{{ session('user_name') }}</strong><br>
              <small>{{ ucfirst(session('user_role')) }}</small>
            </div>
            @if(session('user_role') === 'pengunjung')
              <a href="{{ route('booking.create') }}" style="display: block; padding: 10px 16px; text-decoration: none; color: #333; border-bottom: 1px solid #eee;">
                <i class="fas fa-motorcycle me-2"></i>Booking Motor
              </a>
              <a href="{{ route('user.bookings') }}" style="display: block; padding: 10px 16px; text-decoration: none; color: #333; border-bottom: 1px solid #eee;">
                <i class="fas fa-history me-2"></i>Riwayat Booking
              </a>
              <a href="{{ route('user.profile') }}" style="display: block; padding: 10px 16px; text-decoration: none; color: #333; border-bottom: 1px solid #eee;">
                <i class="fas fa-user me-2"></i>Profil Saya
              </a>
            @else
              <a href="{{ route('admin.dashboard') }}" style="display: block; padding: 10px 16px; text-decoration: none; color: #333; border-bottom: 1px solid #eee;">
                <i class="fas fa-tachometer-alt me-2"></i>Dashboard Admin
              </a>
            @endif
            <a href="{{ route('logout') }}" style="display: block; padding: 10px 16px; text-decoration: none; color: #dc3545;" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
              <i class="fas fa-sign-out-alt me-2"></i>Logout
            </a>
          </div>
        </li>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
          @csrf
        </form>
      @else
        <!-- User is not logged in -->
        <li><a href="{{ route('login') }}">Login</a></li>
      @endif
    </ul>
  </nav>
</header>

<script>
function toggleDropdown(event) {
  event.preventDefault();
  const dropdown = document.getElementById('userDropdown');
  dropdown.style.display = dropdown.style.display === 'none' ? 'block' : 'none';
}

// Close dropdown when clicking outside
document.addEventListener('click', function(event) {
  const dropdown = document.getElementById('userDropdown');
  const toggle = document.querySelector('.dropdown-toggle');
  
  if (dropdown && !toggle.contains(event.target) && !dropdown.contains(event.target)) {
    dropdown.style.display = 'none';
  }
});
</script>

<style>
.dropdown-menu a:hover {
  background-color: #f8f9fa;
}

.dropdown-toggle:hover {
  background-color: rgba(255, 255, 255, 0.1);
  border-radius: 6px;
  padding: 6px 10px;
  margin: -6px -10px;
}
</style>