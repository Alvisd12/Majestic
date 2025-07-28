<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Dashboard - Majestic</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-blue: #2563eb;
            --sidebar-bg: #1e40af;
            --sidebar-active: #fbbf24;
            --text-muted: #6b7280;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8fafc;
        }

        .sidebar {
            background: linear-gradient(180deg, var(--sidebar-bg) 0%, #1d4ed8 100%);
            min-height: 100vh;
            width: 250px;
            position: fixed;
            left: 0;
            top: 0;
            z-index: 1000;
            transition: all 0.3s ease;
        }

        .sidebar-brand {
            padding: 20px;
            text-align: center;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .sidebar-brand img {
            width: 40px;
            height: 40px;
            margin-right: 10px;
        }

        .sidebar-brand h3 {
            color: white;
            font-weight: bold;
            margin: 0;
            font-size: 1.5rem;
        }

        .sidebar-brand small {
            color: rgba(255,255,255,0.7);
            font-size: 0.8rem;
        }

        .sidebar-nav {
            padding: 20px 0;
        }

        .nav-item {
            margin-bottom: 5px;
        }

        .nav-link {
            color: rgba(255,255,255,0.8);
            padding: 12px 20px;
            display: flex;
            align-items: center;
            text-decoration: none;
            transition: all 0.3s ease;
            border-radius: 0;
        }

        .nav-link:hover {
            background-color: rgba(255,255,255,0.1);
            color: white;
        }

        .nav-link.active {
            background-color: var(--sidebar-active);
            color: #1f2937;
            font-weight: 600;
        }

        .nav-link i {
            width: 20px;
            margin-right: 12px;
            text-align: center;
        }

        .main-content {
            margin-left: 250px;
            min-height: 100vh;
        }

        .topbar {
            background: white;
            padding: 15px 30px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .page-title {
            font-size: 1.8rem;
            font-weight: 600;
            color: #1f2937;
            margin: 0;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
        }

        .content-area {
            padding: 30px;
        }

        .search-box {
            position: relative;
            max-width: 400px;
            margin-bottom: 25px;
        }

        .search-box input {
            padding-left: 45px;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            height: 45px;
        }

        .search-box i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
        }

        .data-table {
            background: white;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            overflow: hidden;
        }

        .table {
            margin: 0;
        }

        .table thead th {
            background-color: #f8fafc;
            border-bottom: 1px solid #e5e7eb;
            color: #374151;
            font-weight: 600;
            padding: 15px;
            font-size: 0.9rem;
        }

        .table tbody td {
            padding: 15px;
            vertical-align: middle;
            border-bottom: 1px solid #f3f4f6;
        }

        .table tbody tr:hover {
            background-color: #f9fafb;
        }

        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .status-badge.btn-danger {
            background-color: #fee2e2;
            color: #dc2626;
        }

        .status-badge.btn-warning {
            background-color: #fef3c0;
            color: #d97706;
        }

        .status-badge.btn-primary {
            background-color: #dbeafe;
            color: #2563eb;
        }

        .action-btn {
            width: 35px;
            height: 35px;
            border-radius: 8px;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .btn-delete {
            background-color: #fee2e2;
            color: #dc2626;
        }

        .btn-delete:hover {
            background-color: #fecaca;
            transform: scale(1.1);
        }

        .pagination-container {
            padding: 20px;
            display: flex;
            justify-content: center;
        }

        .jaminan-placeholder {
            width: 60px;
            height: 40px;
            background-color: #e5e7eb;
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-muted);
            font-size: 0.8rem;
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }
            
            .sidebar.show {
                transform: translateX(0);
            }
            
            .main-content {
                margin-left: 0;
            }
            
            .topbar {
                padding: 15px 20px;
            }
            
            .content-area {
                padding: 20px 15px;
            }
            
            .table-responsive {
                font-size: 0.85rem;
            }
        }
    </style>
</head>
<body>
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
                    <a class="nav-link" href="{{ route('admin.dashboard') }}">
                        <i class="fas fa-tachometer-alt"></i>
                        Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="{{ route('admin.dashboard') }}">
                        <i class="fas fa-clipboard-list"></i>
                        Pesanan
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="fas fa-tags"></i>
                        Harga Sewa
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="fas fa-images"></i>
                        Galeri
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
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

    <!-- Main Content -->
    <div class="main-content">
        <!-- Topbar -->
        <div class="topbar">
            <h1 class="page-title">Peminjaman</h1>
            <div class="user-profile">
                <i class="fas fa-bell text-muted"></i>
                <i class="fas fa-cog text-muted"></i>
                <div class="text-end me-2">
                    <div class="fw-bold">{{ Auth::user()->nama ?? 'Nabila A.' }}</div>
                    <small class="text-muted">Admin</small>
                </div>
                <div class="user-avatar">
                    {{ substr(Auth::user()->nama ?? 'NA', 0, 1) }}
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="content-area">
            <!-- Search Box -->
            <form method="GET" action="{{ route('admin.dashboard') }}">
                <div class="search-box">
                    <input type="text" class="form-control" name="search" 
                           placeholder="Search here..." value="{{ request('search') }}">
                    <i class="fas fa-search"></i>
                </div>
            </form>

            <!-- Data Table -->
            <div class="data-table">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>No. Handphone</th>
                                <th>Tanggal Rental</th>
                                <th>Jenis Motor</th>
                                <th>Durasi Sewa</th>
                                <th>Bukti Jaminan</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($peminjaman as $index => $item)
                            <tr>
                                <td>{{ $peminjaman->firstItem() + $index }}.</td>
                                <td class="fw-bold">{{ $item->nama }}</td>
                                <td class="text-primary">{{ $item->no_handphone }}</td>
                                <td class="text-muted">{{ $item->tanggal_rental->format('M d, Y') }}</td>
                                <td>{{ $item->jenis_motor }}</td>
                                <td>{{ $item->durasi_sewa }} Hari</td>
                                <td>
                                    <div class="jaminan-placeholder">
                                        @if($item->bukti_jaminan)
                                            <img src="{{ asset('storage/' . $item->bukti_jaminan) }}" 
                                                 class="img-fluid" alt="Jaminan">
                                        @else
                                            <i class="fas fa-image"></i>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button class="status-badge btn-{{ $item->status_color }} dropdown-toggle" 
                                                data-bs-toggle="dropdown">
                                            {{ $item->status }}
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="#" 
                                                   onclick="updateStatus({{ $item->id }}, 'Belum Kembali')">Belum Kembali</a></li>
                                            <li><a class="dropdown-item" href="#" 
                                                   onclick="updateStatus({{ $item->id }}, 'Disewa')">Disewa</a></li>
                                            <li><a class="dropdown-item" href="#" 
                                                   onclick="updateStatus({{ $item->id }}, 'Selesai')">Selesai</a></li>
                                        </ul>
                                    </div>
                                </td>
                                <td>
                                    <button class="action-btn btn-delete" 
                                            onclick="deletePeminjaman({{ $item->id }})">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9" class="text-center py-4">
                                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                    <p class="text-muted">Tidak ada data peminjaman</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                @if($peminjaman->hasPages())
                <div class="pagination-container">
                    {{ $peminjaman->appends(request()->query())->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Logout Form -->
    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
        @csrf
    </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // CSRF Token Setup
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Update Status Function
        function updateStatus(id, status) {
            fetch(`/admin/peminjaman/${id}/status`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ status: status })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Gagal mengupdate status');
            });
        }

        // Delete Function
        function deletePeminjaman(id) {
            if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
                fetch(`/admin/peminjaman/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Gagal menghapus data');
                });
            }
        }

        // Mobile Sidebar Toggle
        function toggleSidebar() {
            document.querySelector('.sidebar').classList.toggle('show');
        }

        // Auto-submit search form on input
        document.querySelector('input[name="search"]').addEventListener('keyup', function(e) {
            if (e.key === 'Enter') {
                this.form.submit();
            }
        });
    </script>
</body>
</html>