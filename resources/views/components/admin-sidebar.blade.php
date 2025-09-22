<!-- Sidebar -->
<div class="sidebar">
    <div class="sidebar-brand">
        <image src="{{ asset('assets/images/logoputih.png') }}" alt="Logo" class="logo">
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
                <a class="nav-link {{ request()->routeIs('admin.admin_accounts*') ? 'active' : '' }}" href="{{ route('admin.admin_accounts') }}">
                    <i class="fas fa-users-cog"></i>
                    Daftar Admin
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
                    <span>Galeri</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.blog*') ? 'active' : '' }}" href="{{ route('admin.blog') }}">
                    <i class="fas fa-blog"></i>
                    <span>Blog</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.testimoni*') ? 'active' : '' }}" href="{{ route('admin.testimoni') }}">
                    <i class="fas fa-star"></i>
                    <span>Testimoni</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.general*') ? 'active' : '' }}" href="{{ route('admin.general.index') }}">
                    <i class="fas fa-cogs"></i>
                    <span>Pengaturan Umum</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.profile.show') ? 'active' : '' }}" href="{{ route('admin.profile.show') }}">
                    <i class="fas fa-user-cog"></i>
                    <span>Edit Profil</span>
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