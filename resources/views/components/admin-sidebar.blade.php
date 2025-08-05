<!-- Sidebar -->
<div class="sidebar">
    <div class="sidebar-brand">
        <div class="d-flex align-items-center justify-content-center">
            <i class="fas fa-motorcycle text-warning me-2" style="font-size: 2rem;"></i>
            <div>
                <h3>MAJESTIC</h3>
                <small>TRANSPORT</small>
            </div>
        </div>
    </div>
    
    <nav class="sidebar-nav">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                    <i class="fas fa-tachometer-alt"></i>
                    Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="collapse" data-bs-target="#pesananSubmenu" aria-expanded="false">
                    <i class="fas fa-clipboard-list"></i>
                    Pesanan
                    <i class="fas fa-chevron-down ms-auto" style="font-size: 0.8rem;"></i>
                </a>
                <div class="collapse" id="pesananSubmenu">
                    <ul class="nav flex-column ms-3">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.konfirmasi') ? 'active' : '' }}" href="{{ route('admin.konfirmasi') }}">
                                <i class="fas fa-clock"></i>
                                Menunggu Konfirmasi
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.dipinjam') ? 'active' : '' }}" href="{{ route('admin.dipinjam') }}">
                                <i class="fas fa-motorcycle"></i>
                                Dipinjam
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.dikembalikan') ? 'active' : '' }}" href="{{ route('admin.dikembalikan') }}">
                                <i class="fas fa-check-circle"></i>
                                Dikembalikan
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.harga_sewa') ? 'active' : '' }}" href="{{ route('admin.harga_sewa') }}">
                    <i class="fas fa-tags"></i>
                    Harga Sewa
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.galeri*') ? 'active' : '' }}" href="{{ route('admin.galeri') }}">
                    <i class="fas fa-images"></i>
                    Galeri
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('wisata.*') ? 'active' : '' }}" href="{{ route('wisata.index') }}">
                    <i class="fas fa-map-marker-alt"></i>
                    Wisata
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="fas fa-star"></i>
                    Testimoni
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i>
                    Logout
                </a>
            </li>
        </ul>
    </nav>
</div> 