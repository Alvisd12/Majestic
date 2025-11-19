@extends('layouts.admin')

@section('title', 'Admin Accounts')

@section('page-title', 'Admin Accounts')

@section('content')
    <!-- Alert sukses dengan animasi -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4 modern-alert" role="alert">
            <div class="d-flex align-items-center">
                <div class="alert-icon me-3">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="flex-grow-1">
                    <strong>Berhasil!</strong> {{ session('success') }}
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    @endif

    <!-- Modern Card Container -->
    <div class="modern-card">
        <!-- Enhanced Header -->
        <div class="modern-card-header">
            <div class="header-content">
                <div class="header-left">
                    <div class="icon-wrapper">
                        <i class="fas fa-users-cog"></i>
                    </div>
                    <div class="header-text">
                        <h4 class="header-title">Daftar Admin</h4>
                        <p class="header-subtitle">Kelola akun administrator sistem</p>
                    </div>
                </div>
                
                <div class="header-right">
                    <!-- Search Bar -->
                    <div class="search-container">
                        <form method="GET" action="{{ route('admin.admin_accounts') }}">
                            <div class="modern-search">
                                <i class="fas fa-search search-icon"></i>
                                <input type="text" class="search-input" name="search" 
                                       placeholder="Cari admin..." value="{{ request('search') }}">
                                <input type="hidden" name="per_page" value="{{ request('per_page', $admins->perPage()) }}">
                                @if(request('search'))
                                    <button type="button" class="clear-search" 
                                            onclick="window.location.href='{{ route(';admin.admin_accounts;')}}'">
                                        <i class="fas fa-times"></i>
                                    </button>
                                @endif
                            </div>
                        </form>
                    </div>

                    <!-- Filter Dropdown -->
                    <div class="dropdown">
                        <button class="modern-btn modern-btn-outline dropdown-toggle" type="button" 
                                data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-filter me-2"></i>Role
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end modern-dropdown">
                            <li><a class="dropdown-item" href="{{ route('admin.admin_accounts') }}">
                                <i class="fas fa-list me-2"></i>Semua Role</a></li>
                            <li><a class="dropdown-item" href="{{ route('admin.admin_accounts', ['role' => 'admin']) }}">
                                <i class="fas fa-user me-2"></i>Admin</a></li>
                            <li><a class="dropdown-item" href="{{ route('admin.admin_accounts', ['role' => 'super_admin']) }}">
                                <i class="fas fa-user-shield me-2"></i>Super Admin</a></li>
                        </ul>
                    </div>

                    <!-- Add Button - Only for Super Admin -->
                    @php
                        $currentUser = auth()->guard('admin')->user();
                        $isLoggedIn = auth()->guard('admin')->check();
                        $userRole = $currentUser ? $currentUser->role : 'null';
                        $isSuperAdmin = $isLoggedIn && $userRole === 'super_admin';
                    @endphp
                    
                    @if($isSuperAdmin)
                        <a href="{{ route('admin.admin_accounts.create') }}" class="modern-btn modern-btn-primary">
                            <i class="fas fa-plus me-2"></i>Tambah Admin
                        </a>
                    @else
                        <div class="alert alert-info" style="font-size: 12px; padding: 8px;">
                            Debug Info: Login: {{ $isLoggedIn ? 'Yes' : 'No' }}, Role: {{ $userRole }}
                        </div>
                    @endif

                    <!-- Total Badge -->
                    @if(isset($admins))
                        <div class="total-badge">
                            <span class="badge-text">{{ $admins->total() }}</span>
                            <span class="badge-label">Total</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Modern Table -->
        <div class="modern-card-body">
            <div class="table-container">
                <table class="modern-table">
                    <thead class="modern-thead">
                        <tr>
                            <th class="checkbox-col">
                                <div class="checkbox-wrapper">
                                    <input type="checkbox" class="modern-checkbox" id="select-all" disabled>
                                    <label for="select-all"></label>
                                </div>
                            </th>
                            <th class="number-col">#</th>
                            <th class="avatar-col"></th>
                            <th class="name-col">Nama</th>
                            <th class="username-col">Username</th>
                            <th class="email-col">Email</th>
                            <th class="phone-col">Phone</th>
                            <th class="role-col">Role</th>
                            <th class="date-col">Tanggal Dibuat</th>
                            <th class="action-col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="modern-tbody">
                        @forelse($admins as $index => $admin)
                        <tr class="table-row" data-id="{{ $admin->id }}">
                            <td class="checkbox-col">
                                <div class="checkbox-wrapper">
                                    <input type="checkbox" class="modern-checkbox row-checkbox" 
                                           id="check-{{ $admin->id }}" disabled>
                                    <label for="check-{{ $admin->id }}"></label>
                                </div>
                            </td>
                            <td class="number-col">
                                <span class="row-number">{{ $admins->firstItem() + $index }}</span>
                            </td>
                            <td class="avatar-col">
                                <div class="avatar-container">
                                    <div class="avatar-placeholder">
                                        <i class="fas fa-user"></i>
                                    </div>
                                    <div class="status-indicator online"></div>
                                </div>
                            </td>
                            <td class="name-col">
                                <div class="admin-info">
                                    <span class="admin-name">{{ $admin->nama }}</span>
                                </div>
                            </td>
                            <td class="username-col">
                                <span class="username">{{ $admin->username }}</span>
                            </td>
                            <td class="email-col">
                                <span class="email">{{ $admin->email ?: '-' }}</span>
                            </td>
                            <td class="phone-col">
                                <span class="phone">{{ $admin->phone ?? '-' }}</span>
                            </td>
                            <td class="role-col">
                                @php
                                    $role = $admin->role;
                                    $roleConfig = match($role) {
                                        'super_admin' => ['class' => 'super-admin', 'icon' => 'fa-crown', 'text' => 'Super Admin'],
                                        'admin' => ['class' => 'admin', 'icon' => 'fa-user-tie', 'text' => 'Admin'],
                                        default => ['class' => 'default', 'icon' => 'fa-user', 'text' => 'User']
                                    };
                                @endphp
                                <div class="role-badge role-{{ $roleConfig['class'] }}">
                                    <i class="fas {{ $roleConfig['icon'] }}"></i>
                                    <span>{{ $roleConfig['text'] }}</span>
                                </div>
                            </td>
                            <td class="date-col">
                                <div class="date-info">
                                    <span class="date">{{ \Carbon\Carbon::parse($admin->created_at)->format('d M Y') }}</span>
                                    <span class="time">{{ \Carbon\Carbon::parse($admin->created_at)->format('H:i') }}</span>
                                </div>
                            </td>
                            <td class="action-col">
                                <div class="action-buttons">
                                    @php
                                        $currentUser = auth()->guard('admin')->user();
                                        $isLoggedIn = auth()->guard('admin')->check();
                                        $userRole = $currentUser ? $currentUser->role : 'null';
                                        $isSuperAdmin = $isLoggedIn && $userRole === 'super_admin';
                                    @endphp
                                    
                                    @if($isSuperAdmin)
                                        <a href="{{ route('admin.admin_accounts.edit', $admin->id) }}" 
                                           class="action-btn edit-btn"
                                           data-bs-toggle="tooltip" title="Edit Admin">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button class="action-btn delete-btn delete-admin-btn" 
                                                data-id="{{ $admin->id }}"
                                                data-bs-toggle="tooltip" title="Hapus Admin">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    @else
                                        <span class="text-muted small">
                                            Hanya Super Admin 
                                            <small style="display: block; font-size: 10px;">
                                                (Login: {{ $isLoggedIn ? 'Yes' : 'No' }}, Role: {{ $userRole }})
                                            </small>
                                        </span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr class="empty-row">
                            <td colspan="10">
                                <div class="empty-state">
                                    <div class="empty-icon">
                                        <i class="fas fa-users"></i>
                                    </div>
                                    <h5>Tidak Ada Data</h5>
                                    <p>Belum ada administrator yang terdaftar dalam sistem</p>
                                    @if(auth()->guard('admin')->check() && auth()->guard('admin')->user()->role === 'super_admin')
                                        <a href="{{ route('admin.admin_accounts.create') }}" class="modern-btn modern-btn-primary">
                                            <i class="fas fa-plus me-2"></i>Tambah Admin Pertama
                                        </a>
                                    @else
                                        <p class="text-muted">Hanya Super Admin yang dapat menambah administrator baru</p>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Modern Pagination -->
            <div class="modern-pagination">
                <div class="pagination-info">
                    <div class="showing-info">
                        <span>Menampilkan <strong>{{ $admins->firstItem() }}</strong> - <strong>{{ $admins->lastItem() }}</strong> dari <strong>{{ $admins->total() }}</strong> data</span>
                    </div>
                    <div class="entries-per-page">
                        <form method="GET" action="{{ route('admin.admin_accounts') }}" class="entries-form">
                            <input type="hidden" name="search" value="{{ request('search') }}">
                            <label>Tampilkan</label>
                            <select name="per_page" class="modern-select" onchange="this.form.submit()">
                                @foreach([10,25,50,100] as $size)
                                    <option value="{{ $size }}" {{ (request('per_page', $admins->perPage()) == $size) ? 'selected' : '' }}>{{ $size }}</option>
                                @endforeach
                            </select>
                            <span>entri</span>
                        </form>
                    </div>
                </div>
                <div class="pagination-links" style="display: flex; justify-content: center; align-items: center;">
                    {{ $admins->appends(request()->query())->links('vendor.pagination.custom-inline') }}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('additional-scripts')
<style>
/* CSS Variables for consistent theming */
:root {
    --primary-color: #3b82f6;
    --primary-light: #dbeafe;
    --success-color: #10b981;
    --success-light: #d1fae5;
    --danger-color: #ef4444;
    --danger-light: #fee2e2;
    --warning-color: #f59e0b;
    --warning-light: #fef3c7;
    --gray-50: #f9fafb;
    --gray-100: #f3f4f6;
    --gray-200: #e5e7eb;
    --gray-300: #d1d5db;
    --gray-400: #9ca3af;
    --gray-500: #6b7280;
    --gray-600: #4b5563;
    --gray-700: #374151;
    --gray-800: #1f2937;
    --gray-900: #111827;
    --border-radius: 12px;
    --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
    --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
    --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
    --shadow-xl: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
}

/* Modern Alert */
.modern-alert {
    background: linear-gradient(135deg, var(--success-light) 0%, #ecfdf5 100%);
    border: 1px solid var(--success-color);
    border-radius: var(--border-radius);
    box-shadow: var(--shadow-sm);
    animation: slideInDown 0.3s ease-out;
}

.alert-icon {
    width: 40px;
    height: 40px;
    background: var(--success-color);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 18px;
}

/* Modern Card */
.modern-card {
    background: white;
    border-radius: 16px;
    box-shadow: var(--shadow-lg);
    overflow: hidden;
    transition: all 0.3s ease;
}

.modern-card:hover {
    box-shadow: var(--shadow-xl);
}

/* Enhanced Header */
.modern-card-header {
    background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
    padding: 24px;
    border-bottom: 1px solid var(--gray-200);
}

.header-content {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 24px;
    flex-wrap: wrap;
}

.header-left {
    display: flex;
    align-items: center;
    gap: 16px;
}

.icon-wrapper {
    width: 48px;
    height: 48px;
    background: linear-gradient(135deg, var(--primary-color) 0%, #1e40af 100%);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 20px;
    box-shadow: var(--shadow-md);
}

.header-title {
    font-size: 20px;
    font-weight: 700;
    color: var(--gray-900);
    margin: 0;
    line-height: 1.2;
}

.header-subtitle {
    font-size: 14px;
    color: var(--gray-500);
    margin: 0;
    margin-top: 2px;
}

.header-right {
    display: flex;
    align-items: center;
    gap: 16px;
    flex-wrap: wrap;
}

/* Modern Search */
.search-container {
    position: relative;
}

.modern-search {
    position: relative;
    display: flex;
    align-items: center;
    background: white;
    border: 2px solid var(--gray-200);
    border-radius: 12px;
    transition: all 0.2s ease;
    overflow: hidden;
    min-width: 280px;
}

.modern-search:focus-within {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px var(--primary-light);
}

.search-icon {
    position: absolute;
    left: 12px;
    color: var(--gray-400);
    z-index: 2;
}

.search-input {
    flex: 1;
    padding: 12px 16px 12px 40px;
    border: none;
    background: transparent;
    font-size: 14px;
    color: var(--gray-700);
    outline: none;
}

.search-input::placeholder {
    color: var(--gray-400);
}

.clear-search {
    position: absolute;
    right: 8px;
    width: 24px;
    height: 24px;
    border: none;
    background: var(--gray-100);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--gray-500);
    cursor: pointer;
    transition: all 0.2s ease;
}

.clear-search:hover {
    background: var(--gray-200);
    color: var(--gray-700);
}

/* Modern Buttons */
.modern-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 10px 20px;
    font-size: 14px;
    font-weight: 600;
    border-radius: var(--border-radius);
    border: 2px solid transparent;
    text-decoration: none;
    transition: all 0.2s ease;
    cursor: pointer;
    min-height: 44px;
}

.modern-btn-primary {
    background: linear-gradient(135deg, var(--primary-color) 0%, #1d4ed8 100%);
    color: white;
    box-shadow: var(--shadow-sm);
}

.modern-btn-primary:hover {
    background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
    box-shadow: var(--shadow-md);
    transform: translateY(-1px);
    color: white;
}

.modern-btn-outline {
    background: white;
    color: var(--gray-600);
    border-color: var(--gray-300);
}

.modern-btn-outline:hover {
    background: var(--gray-50);
    border-color: var(--gray-400);
    color: var(--gray-700);
}

/* Modern Dropdown */
.modern-dropdown {
    border: none;
    box-shadow: var(--shadow-lg);
    border-radius: var(--border-radius);
    padding: 8px 0;
    min-width: 200px;
}

.modern-dropdown .dropdown-item {
    padding: 12px 20px;
    font-size: 14px;
    color: var(--gray-700);
    transition: all 0.2s ease;
    display: flex;
    align-items: center;
}

.modern-dropdown .dropdown-item:hover {
    background: var(--gray-50);
    color: var(--gray-900);
}

/* Total Badge */
.total-badge {
    background: var(--primary-light);
    border: 1px solid var(--primary-color);
    border-radius: var(--border-radius);
    padding: 8px 16px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.badge-text {
    font-weight: 700;
    font-size: 16px;
    color: var(--primary-color);
}

.badge-label {
    font-size: 12px;
    color: var(--gray-600);
    text-transform: uppercase;
    font-weight: 600;
    letter-spacing: 0.5px;
}

/* Modern Card Body */
.modern-card-body {
    padding: 0;
}

/* Table Container */
.table-container {
    overflow-x: auto;
    scrollbar-width: thin;
    scrollbar-color: var(--gray-300) var(--gray-100);
}

.table-container::-webkit-scrollbar {
    height: 8px;
}

.table-container::-webkit-scrollbar-track {
    background: var(--gray-100);
    border-radius: 4px;
}

.table-container::-webkit-scrollbar-thumb {
    background: var(--gray-300);
    border-radius: 4px;
}

.table-container::-webkit-scrollbar-thumb:hover {
    background: var(--gray-400);
}

/* Modern Table */
.modern-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 14px;
}

/* Table Header */
.modern-thead {
    background: linear-gradient(135deg, var(--gray-50) 0%, var(--gray-100) 100%);
    border-bottom: 2px solid var(--gray-200);
}

.modern-thead th {
    padding: 20px 16px;
    text-align: left;
    font-weight: 700;
    color: var(--gray-700);
    text-transform: uppercase;
    font-size: 12px;
    letter-spacing: 0.5px;
    position: sticky;
    top: 0;
    z-index: 10;
    background: linear-gradient(135deg, var(--gray-50) 0%, var(--gray-100) 100%);
}

/* Column Widths */
.checkbox-col { width: 50px; }
.number-col { width: 60px; }
.avatar-col { width: 80px; }
.name-col { width: 200px; }
.username-col { width: 150px; }
.email-col { width: 200px; }
.phone-col { width: 150px; }
.role-col { width: 120px; }
.date-col { width: 150px; }
.action-col { width: 120px; text-align: center; }

/* Table Body */
.modern-tbody tr {
    transition: all 0.2s ease;
    border-bottom: 1px solid var(--gray-100);
}

.modern-tbody tr:hover {
    background: linear-gradient(135deg, var(--gray-50) 0%, #fafafa 100%);
    transform: scale(1.001);
}

.modern-tbody td {
    padding: 20px 16px;
    vertical-align: middle;
    color: var(--gray-700);
}

/* Modern Checkbox */
.checkbox-wrapper {
    position: relative;
    display: inline-block;
}

.modern-checkbox {
    opacity: 0;
    position: absolute;
}

.modern-checkbox + label {
    position: relative;
    cursor: pointer;
    display: inline-block;
    width: 20px;
    height: 20px;
    background: white;
    border: 2px solid var(--gray-300);
    border-radius: 4px;
    transition: all 0.2s ease;
}

.modern-checkbox:checked + label {
    background: var(--primary-color);
    border-color: var(--primary-color);
}

.modern-checkbox:checked + label:after {
    content: '✓';
    position: absolute;
    top: -1px;
    left: 3px;
    color: white;
    font-size: 12px;
    font-weight: bold;
}

/* Row Number */
.row-number {
    font-weight: 600;
    color: var(--gray-500);
    font-size: 13px;
}

/* Avatar Container */
.avatar-container {
    position: relative;
    display: inline-block;
}

.admin-avatar, .avatar-placeholder {
    width: 44px;
    height: 44px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid white;
    box-shadow: var(--shadow-sm);
}

.avatar-placeholder {
    background: linear-gradient(135deg, var(--primary-color) 0%, #1d4ed8 100%);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 16px;
}

.status-indicator {
    position: absolute;
    bottom: 0;
    right: 0;
    width: 12px;
    height: 12px;
    border-radius: 50%;
    border: 2px solid white;
}

.status-indicator.online {
    background: var(--success-color);
}

/* Admin Info */
.admin-name {
    font-weight: 600;
    color: var(--gray-900);
    font-size: 15px;
}

.username, .email, .phone {
    color: var(--gray-600);
    font-size: 14px;
}

/* Role Badge */
.role-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.role-super-admin {
    background: var(--danger-light);
    color: var(--danger-color);
    border: 1px solid var(--danger-color);
}

.role-admin {
    background: var(--primary-light);
    color: var(--primary-color);
    border: 1px solid var(--primary-color);
}

.role-default {
    background: var(--gray-100);
    color: var(--gray-600);
    border: 1px solid var(--gray-300);
}

/* Date Info */
.date-info {
    display: flex;
    flex-direction: column;
    gap: 2px;
}

.date {
    font-weight: 600;
    color: var(--gray-800);
    font-size: 13px;
}

.time {
    color: var(--gray-500);
    font-size: 12px;
}

/* Action Buttons */
.action-buttons {
    display: flex;
    gap: 8px;
    justify-content: center;
}

.action-btn {
    width: 36px;
    height: 36px;
    border: none;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s ease;
    font-size: 14px;
}

.edit-btn {
    background: var(--primary-light);
    color: var(--primary-color);
}

.edit-btn:hover {
    background: var(--primary-color);
    color: white;
    transform: translateY(-1px);
}

.delete-btn {
    background: var(--danger-light);
    color: var(--danger-color);
}

.delete-btn:hover {
    background: var(--danger-color);
    color: white;
    transform: translateY(-1px);
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 80px 40px;
    color: var(--gray-500);
}

.empty-icon {
    font-size: 64px;
    margin-bottom: 24px;
    opacity: 0.5;
}

.empty-state h5 {
    font-size: 18px;
    font-weight: 600;
    color: var(--gray-700);
    margin-bottom: 8px;
}

.empty-state p {
    font-size: 14px;
    margin-bottom: 32px;
}

/* Modern Pagination */
.modern-pagination {
    padding: 24px;
    background: var(--gray-50);
    border-top: 1px solid var(--gray-200);
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 20px;
    flex-wrap: wrap;
}

.pagination-info {
    display: flex;
    align-items: center;
    gap: 24px;
    flex-wrap: wrap;
}

.showing-info {
    font-size: 14px;
    color: var(--gray-600);
}

/* Custom Pagination Styling - Force inline layout */
.modern-pagination .pagination-links .pagination {
    margin: 0 !important;
    gap: 8px;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    flex-wrap: nowrap !important;
    flex-direction: row !important;
}

.modern-pagination .pagination-links .page-item {
    margin: 0 !important;
    display: inline-block !important;
    float: none !important;
}

/* Force Bootstrap pagination to be inline */
.pagination {
    display: flex !important;
    flex-direction: row !important;
    flex-wrap: nowrap !important;
    margin: 0 !important;
}

.pagination .page-item {
    display: inline-block !important;
    margin: 0 !important;
    float: none !important;
}

/* Additional force inline styling */
.modern-pagination .pagination-links {
    display: flex !important;
    justify-content: center !important;
    align-items: center !important;
}

.modern-pagination .pagination-links nav {
    display: flex !important;
    justify-content: center !important;
}

.modern-pagination .pagination-links nav .pagination {
    display: flex !important;
    flex-direction: row !important;
    align-items: center !important;
    justify-content: center !important;
    flex-wrap: nowrap !important;
    gap: 8px !important;
    margin: 0 !important;
}

.modern-pagination .pagination-links nav .pagination .page-item {
    display: inline-flex !important;
    margin: 0 !important;
    margin-right: 8px !important;
}

.modern-pagination .pagination-links nav .pagination .page-item:last-child {
    margin-right: 0 !important;
}

/* Override Laravel default pagination completely */
nav[role="navigation"] {
    display: flex !important;
    justify-content: center !important;
    align-items: center !important;
}

nav[role="navigation"] .pagination {
    display: flex !important;
    flex-direction: row !important;
    align-items: center !important;
    justify-content: center !important;
    flex-wrap: nowrap !important;
    gap: 8px !important;
    margin: 0 !important;
    padding: 0 !important;
    list-style: none !important;
}

nav[role="navigation"] .pagination li {
    display: inline-flex !important;
    margin: 0 !important;
    margin-right: 8px !important;
    list-style: none !important;
}

nav[role="navigation"] .pagination li:last-child {
    margin-right: 0 !important;
}

/* Force all pagination elements to be inline */
.pagination-links * {
    display: inline-flex !important;
    flex-direction: row !important;
}

.modern-pagination .pagination-links .page-link {
    border: 1px solid var(--gray-300);
    color: var(--gray-700);
    padding: 12px 16px;
    border-radius: 8px;
    font-weight: 500;
    text-decoration: none;
    transition: all 0.2s ease;
    background: white;
    min-width: 44px;
    text-align: center;
    display: flex;
    align-items: center;
    justify-content: center;
}

.modern-pagination .pagination-links .page-link:hover {
    background: var(--primary-color);
    color: white;
    border-color: var(--primary-color);
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
}

.modern-pagination .pagination-links .page-item.active .page-link {
    background: var(--primary-color);
    border-color: var(--primary-color);
    color: white;
    box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
}

.modern-pagination .pagination-links .page-item.disabled .page-link {
    background: var(--gray-100);
    color: var(--gray-400);
    border-color: var(--gray-200);
    cursor: not-allowed;
}

.modern-pagination .pagination-links .page-item.disabled .page-link:hover {
    background: var(--gray-100);
    color: var(--gray-400);
    border-color: var(--gray-200);
    transform: none;
    box-shadow: none;
}

/* Pagination Navigation Icons */
.modern-pagination .pagination-links .page-link[rel="prev"],
.modern-pagination .pagination-links .page-link[rel="next"] {
    font-weight: 600;
    padding: 12px 20px;
}

.modern-pagination .pagination-links .page-link[rel="prev"]:before {
    content: "‹";
    margin-right: 4px;
}

.modern-pagination .pagination-links .page-link[rel="next"]:after {
    content: "›";
    margin-left: 4px;
}

/* Override Bootstrap default pagination styling */
.modern-pagination .pagination-links .pagination .page-item:first-child .page-link {
    border-top-left-radius: 8px;
    border-bottom-left-radius: 8px;
    margin-left: 0;
}

.modern-pagination .pagination-links .pagination .page-item:last-child .page-link {
    border-top-right-radius: 8px;
    border-bottom-right-radius: 8px;
}

.modern-pagination .pagination-links .pagination .page-item .page-link {
    border-radius: 8px !important;
    margin-left: 0;
    margin-right: 8px;
}

.modern-pagination .pagination-links .pagination .page-item:last-child .page-link {
    margin-right: 0;
}

/* Ensure proper alignment */
.modern-pagination {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 16px;
}

.modern-pagination .pagination-info {
    flex: 0 0 auto;
}

.modern-pagination .pagination-links {
    flex: 0 0 auto;
}

.entries-form {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 14px;
    color: var(--gray-600);
}

.modern-select {
    padding: 6px 12px;
    border: 1px solid var(--gray-300);
    border-radius: 6px;
    background: white;
    color: var(--gray-700);
    font-size: 14px;
    cursor: pointer;
    transition: all 0.2s ease;
}

.modern-select:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px var(--primary-light);
    outline: none;
}

/* Animation */
@keyframes slideInDown {
    from {
        transform: translateY(-20px);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}

/* Responsive Design */
@media (max-width: 1200px) {
    .header-content {
        flex-direction: column;
        align-items: stretch;
        gap: 20px;
    }
    
    .header-right {
        justify-content: center;
    }
}

@media (max-width: 768px) {
    .modern-card-header {
        padding: 20px;
    }
    
    .header-left {
        justify-content: center;
        text-align: center;
    }
    
    .modern-search {
        min-width: 100%;
    }
    
    .header-right {
        flex-direction: column;
        gap: 12px;
    }
    
    .modern-btn {
        width: 100%;
        justify-content: center;
    }
    
    /* Hide less important columns on mobile */
    .email-col, .phone-col, .number-col, .date-col {
        display: none;
    }
    
    .modern-pagination {
        flex-direction: column;
        gap: 16px;
        text-align: center;
    }
}

@media (max-width: 480px) {
    .modern-table {
        font-size: 12px;
    }
    
    .modern-thead th {
        padding: 12px 8px;
        font-size: 11px;
    }
    
    .modern-tbody td {
        padding: 16px 8px;
    }
    
    .admin-avatar, .avatar-placeholder {
        width: 36px;
        height: 36px;
        font-size: 14px;
    }
    
    .action-btn {
        width: 32px;
        height: 32px;
        font-size: 12px;
    }
    
    .role-badge {
        font-size: 10px;
        padding: 4px 8px;
    }
    
    .username-col {
        display: none;
    }
}

/* Loading Animation */
@keyframes shimmer {
    0% {
        background-position: -200px 0;
    }
    100% {
        background-position: calc(200px + 100%) 0;
    }
}

.loading-shimmer {
    animation: shimmer 1.5s ease-in-out infinite;
    background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
    background-size: 200px 100%;
}

/* Custom Scrollbar for Webkit browsers */
* {
    scrollbar-width: thin;
    scrollbar-color: var(--gray-300) var(--gray-100);
}

*::-webkit-scrollbar {
    width: 8px;
    height: 8px;
}

*::-webkit-scrollbar-track {
    background: var(--gray-100);
    border-radius: 4px;
}

*::-webkit-scrollbar-thumb {
    background: var(--gray-300);
    border-radius: 4px;
    transition: background 0.2s ease;
}

*::-webkit-scrollbar-thumb:hover {
    background: var(--gray-400);
}

/* Focus States */
.modern-btn:focus,
.modern-select:focus,
.search-input:focus,
.action-btn:focus {
    outline: 2px solid var(--primary-color);
    outline-offset: 2px;
}

/* Print Styles */
@media print {
    .modern-card-header,
    .action-col,
    .checkbox-col,
    .modern-pagination {
        display: none !important;
    }
    
    .modern-card {
        box-shadow: none;
        border: 1px solid #000;
    }
    
    .modern-table {
        font-size: 12px;
    }
    
    .modern-thead {
        background: #f0f0f0 !important;
    }
}

/* High Contrast Mode */
@media (prefers-contrast: high) {
    :root {
        --gray-100: #e0e0e0;
        --gray-200: #c0c0c0;
        --gray-300: #a0a0a0;
        --gray-500: #606060;
        --gray-700: #303030;
        --gray-900: #000000;
    }
}

/* Reduced Motion */
@media (prefers-reduced-motion: reduce) {
    *,
    *::before,
    *::after {
        animation-duration: 0.01ms !important;
        animation-iteration-count: 1 !important;
        transition-duration: 0.01ms !important;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize tooltips
    if (window.bootstrap) {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.forEach(function (tooltipTriggerEl) {
            new bootstrap.Tooltip(tooltipTriggerEl, {
                delay: { show: 500, hide: 100 }
            });
        });
    }

    // Enhanced search functionality
    const searchInput = document.querySelector('.search-input');
    if (searchInput) {
        let searchTimeout;
        
        // Real-time search with debouncing
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                // Add loading state
                this.parentElement.classList.add('loading');
                
                // Auto-submit after 500ms of no typing
                if (this.value.length >= 2 || this.value.length === 0) {
                    this.form.submit();
                }
            }, 500);
        });

        // Submit on Enter
        searchInput.addEventListener('keyup', function(e) {
            if (e.key === 'Enter') {
                clearTimeout(searchTimeout);
                this.form.submit();
            }
        });
    }

    // Enhanced delete functionality
    document.addEventListener('click', function(e) {
        if (e.target.closest('.delete-admin-btn')) {
            e.preventDefault();
            const button = e.target.closest('.delete-admin-btn');
            const adminId = button.getAttribute('data-id');
            const row = button.closest('tr');
            
            // Create custom confirmation modal
            showDeleteConfirmation(adminId, row);
        }
    });

    function showDeleteConfirmation(adminId, row) {
        // Create modal HTML
        const modalHtml = `
            <div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content" style="border-radius: 16px; border: none; box-shadow: var(--shadow-xl);">
                        <div class="modal-header border-0" style="padding: 24px 24px 0;">
                            <div class="d-flex align-items-center gap-3">
                                <div style="width: 48px; height: 48px; background: var(--danger-light); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-exclamation-triangle" style="color: var(--danger-color); font-size: 20px;"></i>
                                </div>
                                <div>
                                    <h5 class="modal-title" style="color: var(--gray-900); font-weight: 700;">Konfirmasi Penghapusan</h5>
                                </div>
                            </div>
                        </div>
                        <div class="modal-body" style="padding: 16px 24px;">
                            <p style="color: var(--gray-600); margin: 0;">Apakah Anda yakin ingin menghapus administrator ini? Tindakan ini tidak dapat dibatalkan.</p>
                        </div>
                        <div class="modal-footer border-0" style="padding: 0 24px 24px; gap: 12px;">
                            <button type="button" class="modern-btn modern-btn-outline" data-bs-dismiss="modal">Batal</button>
                            <button type="button" class="modern-btn" id="confirmDelete" style="background: var(--danger-color); color: white;">
                                <i class="fas fa-trash me-2"></i>Hapus
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        `;

        // Remove existing modal if any
        const existingModal = document.getElementById('deleteModal');
        if (existingModal) {
            existingModal.remove();
        }

        // Add modal to DOM
        document.body.insertAdjacentHTML('beforeend', modalHtml);
        
        // Show modal
        const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
        modal.show();

        // Handle confirm delete
        document.getElementById('confirmDelete').addEventListener('click', function() {
            const button = this;
            const originalContent = button.innerHTML;
            
            // Show loading state
            button.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Menghapus...';
            button.disabled = true;

            // Perform delete request
            fetch(`/admin/admin-accounts/${adminId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Animate row removal
                    row.style.transition = 'all 0.3s ease';
                    row.style.opacity = '0';
                    row.style.transform = 'translateX(-20px)';
                    
                    setTimeout(() => {
                        modal.hide();
                        setTimeout(() => {
                            location.reload();
                        }, 300);
                    }, 300);
                    
                    // Show success notification
                    showNotification('Admin berhasil dihapus!', 'success');
                } else {
                    throw new Error(data.message || 'Gagal menghapus admin');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification(error.message || 'Gagal menghapus admin', 'error');
                
                // Reset button
                button.innerHTML = originalContent;
                button.disabled = false;
            });
        });

        // Clean up modal when hidden
        document.getElementById('deleteModal').addEventListener('hidden.bs.modal', function() {
            this.remove();
        });
    }

    // Notification system
    function showNotification(message, type = 'info') {
        const notificationHtml = `
            <div class="toast-notification ${type}" style="
                position: fixed;
                top: 20px;
                right: 20px;
                z-index: 9999;
                padding: 16px 20px;
                background: ${type === 'success' ? 'var(--success-color)' : 'var(--danger-color)'};
                color: white;
                border-radius: var(--border-radius);
                box-shadow: var(--shadow-lg);
                display: flex;
                align-items: center;
                gap: 12px;
                font-weight: 600;
                animation: slideInRight 0.3s ease;
            ">
                <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'}"></i>
                <span>${message}</span>
            </div>
        `;

        document.body.insertAdjacentHTML('beforeend', notificationHtml);
        
        const notification = document.querySelector('.toast-notification');
        
        // Auto remove after 3 seconds
        setTimeout(() => {
            notification.style.animation = 'slideOutRight 0.3s ease';
            setTimeout(() => {
                notification.remove();
            }, 300);
        }, 3000);
    }

    // Row hover effects
    const tableRows = document.querySelectorAll('.table-row');
    tableRows.forEach(row => {
        row.addEventListener('mouseenter', function() {
            this.style.boxShadow = '0 4px 12px rgba(0,0,0,0.08)';
            this.style.zIndex = '1';
        });
        
        row.addEventListener('mouseleave', function() {
            this.style.boxShadow = '';
            this.style.zIndex = '';
        });
    });

    // Table sticky header effect
    const tableContainer = document.querySelector('.table-container');
    if (tableContainer) {
        tableContainer.addEventListener('scroll', function() {
            const thead = tableContainer.querySelector('.modern-thead');
            const isScrolled = tableContainer.scrollTop > 0;
            
            if (isScrolled) {
                thead.style.boxShadow = '0 2px 8px rgba(0,0,0,0.1)';
            } else {
                thead.style.boxShadow = '';
            }
        });
    }

    // Checkbox functionality (if needed in future)
    const selectAllCheckbox = document.getElementById('select-all');
    const rowCheckboxes = document.querySelectorAll('.row-checkbox');
    
    if (selectAllCheckbox && rowCheckboxes.length > 0) {
        selectAllCheckbox.addEventListener('change', function() {
            rowCheckboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
                updateRowSelection(checkbox);
            });
            updateBulkActions();
        });

        rowCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                updateRowSelection(this);
                updateSelectAllState();
                updateBulkActions();
            });
        });
    }

    function updateRowSelection(checkbox) {
        const row = checkbox.closest('tr');
        if (checkbox.checked) {
            row.classList.add('selected');
        } else {
            row.classList.remove('selected');
        }
    }

    function updateSelectAllState() {
        const checkedCount = document.querySelectorAll('.row-checkbox:checked').length;
        const totalCount = rowCheckboxes.length;
        
        if (selectAllCheckbox) {
            selectAllCheckbox.checked = checkedCount === totalCount;
            selectAllCheckbox.indeterminate = checkedCount > 0 && checkedCount < totalCount;
        }
    }

    function updateBulkActions() {
        const selectedCount = document.querySelectorAll('.row-checkbox:checked').length;
        // Future: Show/hide bulk action buttons based on selection
    }

    // Smooth scrolling for pagination
    const paginationLinks = document.querySelectorAll('.pagination a');
    paginationLinks.forEach(link => {
        link.addEventListener('click', function() {
            // Add loading overlay or spinner if needed
            document.body.style.cursor = 'wait';
        });
    });

    // Enhanced keyboard navigation
    document.addEventListener('keydown', function(e) {
        // Ctrl/Cmd + F to focus search
        if ((e.ctrlKey || e.metaKey) && e.key === 'f') {
            e.preventDefault();
            if (searchInput) {
                searchInput.focus();
            }
        }
        
        // Escape to clear search
        if (e.key === 'Escape' && document.activeElement === searchInput) {
            if (searchInput.value) {
                searchInput.value = '';
                searchInput.form.submit();
            } else {
                searchInput.blur();
            }
        }
    });

    // Performance optimization: Lazy load profile images
    const profileImages = document.querySelectorAll('.admin-avatar');
    if ('IntersectionObserver' in window) {
        const imageObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    if (img.dataset.src) {
                        img.src = img.dataset.src;
                        img.classList.remove('loading-shimmer');
                        observer.unobserve(img);
                    }
                }
            });
        });

        profileImages.forEach(img => {
            if (img.src && !img.complete) {
                img.classList.add('loading-shimmer');
                imageObserver.observe(img);
            }
        });
    }
});

// Additional animations
const style = document.createElement('style');
style.textContent = `
    @keyframes slideInRight {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    
    @keyframes slideOutRight {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(100%);
            opacity: 0;
        }
    }
    
    .table-row.selected td {
        background: linear-gradient(135deg, var(--primary-light) 0%, #e0f2fe 100%) !important;
        border-color: var(--primary-color);
    }
    
    .table-row.selected .admin-avatar,
    .table-row.selected .avatar-placeholder {
        box-shadow: 0 0 0 2px var(--primary-color);
    }
    `;
document.head.appendChild(style);
</script>
@endsection