<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard') - Majestic Transport</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @include('components.admin-styles')
    @yield('additional-styles')
</head>
<body>
    <!-- Sidebar -->
    @include('components.admin-sidebar')

    <!-- Main Content -->
    <div class="main-content">
        <!-- Topbar -->
        <div class="topbar">
            <h1 class="page-title">@yield('page-title', 'Dashboard')</h1>
            <div class="user-profile">
                @php
                    $currentAdmin = \App\Http\Controllers\AuthController::getCurrentUser();
                @endphp
                <div class="text-end me-2">
                    <div class="fw-bold">{{ $currentAdmin->nama ?? 'Administrator' }}</div>
                    <small class="text-muted">{{ ucfirst($currentAdmin->role ?? 'Admin') }}</small>
                </div>
                <div class="user-avatar">
                    {{ substr($currentAdmin->nama ?? 'A', 0, 1) }}
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="content-area">
            <!-- Success Message -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Error Message -->
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </div>

    <!-- Logout Form -->
    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
        @csrf
    </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- CSRF Token Setup -->
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    
    @yield('additional-scripts')
    
    <script>
        // Auto-expand dropdown if any sub-menu is active
        document.addEventListener('DOMContentLoaded', function() {
            const pesananSubmenu = document.getElementById('pesananSubmenu');
            const activeSubmenuItem = pesananSubmenu.querySelector('.nav-link.active');
            
            if (activeSubmenuItem) {
                pesananSubmenu.classList.add('show');
                const dropdownToggle = pesananSubmenu.previousElementSibling;
                dropdownToggle.setAttribute('aria-expanded', 'true');
            }
            
            // Also expand if status parameter is present in URL
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.has('status')) {
                pesananSubmenu.classList.add('show');
                const dropdownToggle = pesananSubmenu.previousElementSibling;
                dropdownToggle.setAttribute('aria-expanded', 'true');
            }
        });
    </script>
</body>
</html> 