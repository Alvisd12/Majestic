@extends('layouts.admin')

@section('title', 'Menunggu Konfirmasi')

@section('page-title', 'Menunggu di konfirmasi')

@section('content')
    <!-- Status Update Notification -->
    @if(session('status_updated'))
        <div class="alert alert-info alert-dismissible fade show mb-4 modern-alert info-alert" role="alert">
            <div class="d-flex align-items-center">
                <div class="alert-icon me-3 info-icon">
                    <i class="fas fa-sync-alt"></i>
                </div>
                <div class="flex-grow-1">
                    <strong>Status Update:</strong> {{ session('status_updated') }}
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
                    <div class="icon-wrapper warning-gradient">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="header-text">
                        <h4 class="header-title">Menunggu Konfirmasi</h4>
                        <p class="header-subtitle">Kelola peminjaman yang menunggu persetujuan</p>
                    </div>
                </div>
                
                <div class="header-right">
                    <!-- Search Bar -->
                    <div class="search-container">
                        <form method="GET" action="{{ route('admin.konfirmasi') }}">
                            <div class="modern-search">
                                <i class="fas fa-search search-icon"></i>
                                <input type="text" class="search-input" name="search" 
                                       placeholder="Cari peminjaman..." value="{{ request('search') }}">
                                @if(request('search'))
                                    <button type="button" class="clear-search" 
                                            onclick="window.location.href='{{ route(';admin.konfirmasi;') }}'">
                                        <i class="fas fa-times"></i>
                                    </button>
                                @endif
                            </div>
                        </form>
                    </div>

                    <!-- Status Badge -->
                    @if(isset($peminjaman))
                        <div class="total-badge warning-badge">
                            <span class="badge-text">{{ $peminjaman->total() }}</span>
                            <span class="badge-label">Pending</span>
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
                            <th class="number-col">#</th>
                            <th class="user-col">Penyewa</th>
                            <th class="motor-col">Motor</th>
                            <th class="date-col">Tanggal Rental</th>
                            <th class="duration-col">Durasi</th>
                            <th class="pickup-col">Pengambilan</th>
                            <th class="price-col">Total Biaya</th>
                            <th class="phone-col">Kontak</th>
                            <th class="proof-col">Bukti Jaminan</th>
                            <th class="status-col">Status</th>
                            <th class="action-col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="modern-tbody">
                        @forelse($peminjaman as $index => $item)
                        <tr class="table-row" data-id="{{ $item->id }}">
                            <td class="number-col">
                                <span class="row-number">{{ $peminjaman->firstItem() + $index }}</span>
                            </td>
                            <td class="user-col">
                                <div class="user-info">
                                    <div class="user-details">
                                        <span class="user-name">
                                            <i class="fas fa-user me-1"></i>
                                            {{ $item->user->nama ?? 'Unknown' }}
                                        </span>
                                        <span class="user-id">ID: {{ $item->user->id ?? '-' }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="motor-col">
                                <div class="motor-info">
                                    <span class="motor-name">{{ $item->jenis_motor }}</span>
                                </div>
                            </td>
                            <td class="date-col">
                                <div class="date-info">
                                    <span class="date">{{ \Carbon\Carbon::parse($item->tanggal_rental)->format('d M Y') }}</span>
                                    <span class="day">{{ dayNameIndonesian($item->tanggal_rental) }}</span>
                                </div>
                            </td>
                            <td class="duration-col">
                                <div class="duration-badge">
                                    <i class="fas fa-calendar-alt me-1"></i>
                                    <span>{{ $item->durasi_sewa }} Hari</span>
                                </div>
                            </td>
                            <td class="pickup-col">
                                @if($item->pilihan_pengambilan)
                                    <div>
                                        <div class="pickup-badge">
                                            <i class="fas fa-{{ $item->pilihan_pengambilan == 'diantar' ? 'truck' : 'map-marker-alt' }} me-1"></i>
                                            <span>{{ ucfirst($item->pilihan_pengambilan) }}</span>
                                        </div>
                                        @if($item->pilihan_pengambilan == 'diantar' && $item->alamat_pengiriman)
                                            <div class="alamat-pengiriman mt-2" style="font-size: 0.75rem; color: #666; margin-top: 8px;">
                                                <i class="fas fa-map-marker-alt me-1 text-primary"></i>
                                                <span title="{{ $item->alamat_pengiriman }}">{{ Str::limit($item->alamat_pengiriman, 50) }}</span>
                                            </div>
                                        @endif
                                    </div>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td class="price-col">
                                <div class="price-info">
                                    <span class="currency">Rp</span>
                                    <span class="amount">{{ number_format($item->total_harga, 0, ',', '.') }}</span>
                                </div>
                            </td>
                            <td class="phone-col">
                                @if($item->user->no_handphone)
                                    <a href="tel:{{ $item->user->no_handphone }}" class="phone-link">
                                        <i class="fas fa-phone me-1"></i>
                                        {{ $item->user->no_handphone }}
                                    </a>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td class="proof-col">
                                @if($item->bukti_jaminan)
                                    <button type="button" class="proof-btn" 
                                            onclick="viewBuktiJaminan('{{ $item->bukti_jaminan }}')">
                                        <i class="fas fa-image"></i>
                                        <span>Lihat Bukti</span>
                                    </button>
                                @else
                                    <span class="no-proof">
                                        <i class="fas fa-times-circle"></i>
                                        Tidak ada
                                    </span>
                                @endif
                            </td>
                            <td class="status-col">
                                <div class="status-badge status-pending">
                                    <i class="fas fa-clock"></i>
                                    <span>Menunggu Konfirmasi</span>
                                </div>
                            </td>
                            <td class="action-col">
                                <div class="action-buttons">
                                    <button type="button" class="action-btn approve-btn" 
                                            onclick="approvePeminjaman('{{ $item->id }}')"
                                            data-bs-toggle="tooltip" title="Setujui Peminjaman">
                                        <i class="fas fa-check"></i>
                                    </button>
                                    <button type="button" class="action-btn reject-btn" 
                                            onclick="rejectPeminjaman('{{ $item->id }}')"
                                            data-bs-toggle="tooltip" title="Tolak Peminjaman">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr class="empty-row">
                            <td colspan="10">
                                <div class="empty-state">
                                    <div class="empty-icon">
                                        <i class="fas fa-clipboard-check"></i>
                                    </div>
                                    <h5>Tidak Ada Peminjaman</h5>
                                    <p>Saat ini tidak ada peminjaman yang menunggu konfirmasi</p>
                                    <div class="empty-actions">
                                        <a href="{{ route('admin.dashboard') }}" class="modern-btn modern-btn-outline">
                                            <i class="fas fa-arrow-left me-2"></i>Kembali ke Dashboard
                                        </a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Modern Pagination -->
            @if($peminjaman->hasPages())
            <div class="modern-pagination">
                <div class="pagination-info">
                    <div class="showing-info">
                        <span>Menampilkan <strong>{{ $peminjaman->firstItem() }}</strong> - <strong>{{ $peminjaman->lastItem() }}</strong> dari <strong>{{ $peminjaman->total() }}</strong> peminjaman</span>
                    </div>
                </div>
                <div class="pagination-links">
                    {{ $peminjaman->appends(request()->query())->links('vendor.pagination.custom-inline') }}
                </div>
            </div>
            @endif
        </div>
    </div>

    <!-- Enhanced Modal for Bukti Jaminan -->
    <div class="modal fade" id="buktiJaminanModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content modern-modal">
                <div class="modal-header modern-modal-header">
                    <div class="d-flex align-items-center gap-3">
                        <div class="modal-icon">
                            <i class="fas fa-image"></i>
                        </div>
                        <div>
                            <h5 class="modal-title">Bukti Jaminan</h5>
                            <small class="text-muted">Dokumen jaminan peminjaman</small>
                        </div>
                    </div>
                    <button type="button" class="btn-close modern-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body modern-modal-body">
                    <div class="image-container">
                        <img id="buktiJaminanImage" src="" alt="Bukti Jaminan" class="proof-image">
                        <div class="image-overlay">
                            <button type="button" class="zoom-btn" onclick="toggleZoom()">
                                <i class="fas fa-search-plus"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="modal-footer modern-modal-footer">
                    <button type="button" class="modern-btn modern-btn-outline" data-bs-dismiss="modal">
                        Tutup
                    </button>
                    <button type="button" class="modern-btn modern-btn-primary" onclick="downloadImage()">
                        <i class="fas fa-download me-2"></i>Download
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('additional-scripts')
<style>
/* Import CSS Variables from previous design */
:root {
    --primary-color: #3b82f6;
    --primary-light: #dbeafe;
    --success-color: #10b981;
    --success-light: #d1fae5;
    --danger-color: #ef4444;
    --danger-light: #fee2e2;
    --warning-color: #f59e0b;
    --warning-light: #fef3c7;
    --info-color: #06b6d4;
    --info-light: #cffafe;
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

/* Modern Alert Variants */
.info-alert {
    background: linear-gradient(135deg, var(--info-light) 0%, #e0f7fa 100%);
    border: 1px solid var(--info-color);
}

.info-icon {
    background: var(--info-color);
}

/* Modern Card - Reuse from previous design */
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

/* Header with Primary Theme */
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

.warning-gradient {
    background: linear-gradient(135deg, var(--primary-color) 0%, #1d4ed8 100%);
}

.icon-wrapper {
    width: 48px;
    height: 48px;
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

/* Search - Reuse from previous design */
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

/* Primary Badge */
.warning-badge {
    background: var(--primary-light);
    border: 1px solid var(--primary-color);
    border-radius: var(--border-radius);
    padding: 8px 16px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.warning-badge .badge-text {
    font-weight: 700;
    font-size: 16px;
    color: var(--primary-color);
}

.warning-badge .badge-label {
    font-size: 12px;
    color: var(--gray-600);
    text-transform: uppercase;
    font-weight: 600;
    letter-spacing: 0.5px;
}

/* Table Body */
.modern-card-body {
    padding: 0;
}

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

/* Column Widths - Specific to this page */
.number-col { width: 60px; }
.user-col { width: 200px; }
.motor-col { width: 150px; }
.date-col { width: 130px; }
.duration-col { width: 100px; }
.price-col { width: 150px; }
.phone-col { width: 150px; }
.proof-col { width: 120px; }
.status-col { width: 180px; }
.action-col { width: 100px; text-align: center; }

/* Table Body */
.modern-tbody tr {
    transition: all 0.2s ease;
    border-bottom: 1px solid var(--gray-100);
}

.modern-tbody tr:hover {
    background: linear-gradient(135deg, var(--primary-light) 0%, #f0f9ff 100%);
    transform: scale(1.001);
}

.modern-tbody td {
    padding: 20px 16px;
    vertical-align: middle;
    color: var(--gray-700);
}

/* Row Number */
.row-number {
    font-weight: 600;
    color: var(--gray-500);
    font-size: 13px;
}

/* User Info */
.user-info {
    display: flex;
    align-items: center;
    gap: 12px;
}

.avatar-container {
    position: relative;
    display: inline-block;
}

.user-avatar, .avatar-placeholder {
    width: 44px;
    height: 44px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid white;
    box-shadow: var(--shadow-sm);
}

.avatar-placeholder {
    background: linear-gradient(135deg, var(--gray-400) 0%, var(--gray-500) 100%);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
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

.status-indicator.pending {
    background: var(--primary-color);
    animation: pulse 2s infinite;
}

.user-details {
    display: flex;
    flex-direction: column;
    gap: 2px;
}

.user-name {
    font-weight: 600;
    color: var(--gray-900);
    font-size: 15px;
}

.user-id {
    font-size: 12px;
    color: var(--gray-500);
}

/* Motor Info */
.motor-info {
    display: flex;
    align-items: center;
    font-weight: 500;
    color: var(--gray-700);
}

.motor-name {
    font-weight: 600;
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

.day {
    color: var(--gray-500);
    font-size: 11px;
    text-transform: capitalize;
}

/* Duration Badge */
.duration-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 12px;
    background: var(--primary-light);
    color: var(--primary-color);
    border-radius: 16px;
    font-size: 12px;
    font-weight: 600;
}

/* Price Info */
.price-info {
    display: flex;
    align-items: baseline;
    gap: 2px;
}

.currency {
    font-size: 12px;
    color: var(--gray-500);
    font-weight: 500;
}

.amount {
    font-weight: 700;
    color: var(--success-color);
    font-size: 15px;
}

/* Phone Link */
.phone-link {
    color: var(--primary-color);
    text-decoration: none;
    font-weight: 500;
    transition: all 0.2s ease;
    display: inline-flex;
    align-items: center;
}

.phone-link:hover {
    color: var(--primary-color);
    transform: scale(1.05);
}

/* Proof Button */
.proof-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 8px 12px;
    background: var(--info-light);
    color: var(--info-color);
    border: 1px solid var(--info-color);
    border-radius: 8px;
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
}

.proof-btn:hover {
    background: var(--info-color);
    color: white;
    transform: translateY(-1px);
}

.no-proof {
    color: var(--gray-400);
    font-size: 12px;
    display: flex;
    align-items: center;
    gap: 6px;
}

/* Status Badge */
.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 8px 16px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.status-pending {
    background: var(--primary-light);
    color: var(--primary-color);
    border: 1px solid var(--primary-color);
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

.approve-btn {
    background: var(--success-light);
    color: var(--success-color);
}

.approve-btn:hover {
    background: var(--success-color);
    color: white;
    transform: translateY(-1px);
}

.reject-btn {
    background: var(--danger-light);
    color: var(--danger-color);
}

.reject-btn:hover {
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
    color: var(--primary-color);
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

.empty-actions {
    display: flex;
    gap: 12px;
    justify-content: center;
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

/* Custom Pagination Styling */
.modern-pagination .pagination {
    margin: 0;
    gap: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-wrap: nowrap;
}

.modern-pagination .page-item {
    margin: 0;
}

.modern-pagination .page-link {
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

.modern-pagination .page-link:hover {
    background: var(--primary-color);
    color: white;
    border-color: var(--primary-color);
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
}

.modern-pagination .page-item.active .page-link {
    background: var(--primary-color);
    border-color: var(--primary-color);
    color: white;
    box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
}

.modern-pagination .page-item.disabled .page-link {
    background: var(--gray-100);
    color: var(--gray-400);
    border-color: var(--gray-200);
    cursor: not-allowed;
}

.modern-pagination .page-item.disabled .page-link:hover {
    background: var(--gray-100);
    color: var(--gray-400);
    border-color: var(--gray-200);
    transform: none;
    box-shadow: none;
}

/* Pagination Navigation Icons */
.modern-pagination .page-link[rel="prev"],
.modern-pagination .page-link[rel="next"] {
    font-weight: 600;
    padding: 12px 20px;
}

.modern-pagination .page-link[rel="prev"]:before {
    content: "‹";
    margin-right: 4px;
}

.modern-pagination .page-link[rel="next"]:after {
    content: "›";
    margin-left: 4px;
}

/* Override Bootstrap default pagination styling */
.modern-pagination .pagination .page-item:first-child .page-link {
    border-top-left-radius: 8px;
    border-bottom-left-radius: 8px;
    margin-left: 0;
}

.modern-pagination .pagination .page-item:last-child .page-link {
    border-top-right-radius: 8px;
    border-bottom-right-radius: 8px;
}

.modern-pagination .pagination .page-item .page-link {
    border-radius: 8px !important;
    margin-left: 0;
    margin-right: 8px;
}

.modern-pagination .pagination .page-item:last-child .page-link {
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

.modern-pagination .pagination {
    flex: 0 0 auto;
}

/* Enhanced Modal */
.modern-modal {
    border: none;
    border-radius: 16px;
    box-shadow: var(--shadow-xl);
    overflow: hidden;
}

.modern-modal-header {
    background: linear-gradient(135deg, var(--gray-50) 0%, var(--gray-100) 100%);
    padding: 24px;
    border-bottom: 1px solid var(--gray-200);
}

.modal-icon {
    width: 40px;
    height: 40px;
    background: linear-gradient(135deg, var(--info-color) 0%, #0891b2 100%);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 16px;
}

.modal-title {
    font-size: 18px;
    font-weight: 700;
    color: var(--gray-900);
    margin: 0;
}

.modern-close {
    background: var(--gray-100);
    border-radius: 8px;
    width: 32px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 1;
}

.modern-close:hover {
    background: var(--gray-200);
}

.modern-modal-body {
    padding: 0;
    position: relative;
}

.image-container {
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--gray-50);
    min-height: 300px;
}

.proof-image {
    max-width: 100%;
    max-height: 70vh;
    object-fit: contain;
    border-radius: 8px;
    box-shadow: var(--shadow-lg);
    transition: transform 0.3s ease;
}

.proof-image.zoomed {
    transform: scale(1.5);
    cursor: zoom-out;
}

.image-overlay {
    position: absolute;
    top: 16px;
    right: 16px;
}

.zoom-btn {
    width: 40px;
    height: 40px;
    background: rgba(0, 0, 0, 0.7);
    color: white;
    border: none;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s ease;
}

.zoom-btn:hover {
    background: rgba(0, 0, 0, 0.9);
    transform: scale(1.1);
}

.modern-modal-footer {
    padding: 20px 24px;
    background: var(--gray-50);
    border-top: 1px solid var(--gray-200);
    display: flex;
    gap: 12px;
    justify-content: flex-end;
}

/* Animations */
@keyframes pulse {
    0%, 100% {
        opacity: 1;
    }
    50% {
        opacity: 0.5;
    }
}

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

@keyframes fadeOut {
    from {
        opacity: 1;
        transform: scale(1);
    }
    to {
        opacity: 0;
        transform: scale(0.95);
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
    
    /* Hide less important columns on tablet */
    .phone-col, .duration-col, .number-col {
        display: none;
    }
    
    .modern-pagination {
        flex-direction: column;
        gap: 16px;
        text-align: center;
    }
    
    .user-info {
        flex-direction: column;
        align-items: flex-start;
        gap: 8px;
    }
    
    .proof-image {
        max-height: 50vh;
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
    
    .user-avatar, .avatar-placeholder {
        width: 36px;
        height: 36px;
        font-size: 14px;
    }
    
    .action-btn {
        width: 32px;
        height: 32px;
        font-size: 12px;
    }
    
    .status-badge {
        font-size: 10px;
        padding: 6px 12px;
    }
    
    /* Hide more columns on mobile */
    .date-col, .proof-col {
        display: none;
    }
    
    .motor-info {
        flex-direction: column;
        align-items: flex-start;
        gap: 4px;
    }
    
    .price-info {
        flex-direction: column;
        align-items: flex-start;
    }
    
    .modern-modal-header {
        padding: 16px;
    }
    
    .modern-modal-footer {
        padding: 16px;
        flex-direction: column;
    }
    
    .modern-btn {
        width: 100%;
    }
}

/* Loading States */
.loading {
    position: relative;
    pointer-events: none;
}

.loading::after {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 20px;
    height: 20px;
    margin: -10px 0 0 -10px;
    border: 2px solid var(--gray-300);
    border-top: 2px solid var(--primary-color);
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

/* Focus States */
.modern-btn:focus,
.proof-btn:focus,
.phone-link:focus,
.action-btn:focus {
    outline: 2px solid var(--primary-color);
    outline-offset: 2px;
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

/* Print Styles */
@media print {
    .modern-card-header,
    .action-col,
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
    
    .status-badge,
    .duration-badge {
        border: 1px solid #000;
        background: white !important;
        color: black !important;
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

    // Keyboard navigation
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
});

// Enhanced View Bukti Jaminan Function
function viewBuktiJaminan(imagePath) {
    const modal = document.getElementById('buktiJaminanModal');
    const image = document.getElementById('buktiJaminanImage');
    
    // Set image source
    image.src = '/storage/' + imagePath;
    image.classList.remove('zoomed');
    
    // Show modal
    const bootstrapModal = new bootstrap.Modal(modal);
    bootstrapModal.show();
    
    // Store current image path for download
    modal.setAttribute('data-current-image', imagePath);
}

// Toggle zoom function
function toggleZoom() {
    const image = document.getElementById('buktiJaminanImage');
    const zoomBtn = document.querySelector('.zoom-btn i');
    
    image.classList.toggle('zoomed');
    
    if (image.classList.contains('zoomed')) {
        zoomBtn.className = 'fas fa-search-minus';
    } else {
        zoomBtn.className = 'fas fa-search-plus';
    }
}

// Download image function
function downloadImage() {
    const modal = document.getElementById('buktiJaminanModal');
    const imagePath = modal.getAttribute('data-current-image');
    
    if (imagePath) {
        const link = document.createElement('a');
        link.href = '/storage/' + imagePath;
        link.download = 'bukti-jaminan-' + Date.now() + '.jpg';
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }
}

// Enhanced Approve Peminjaman Function
function approvePeminjaman(id) {
    showConfirmationModal(
        'Setujui Peminjaman',
        'Apakah Anda yakin ingin menyetujui peminjaman ini?',
        'success',
        function() {
            performAction(`/admin/peminjaman/${id}/approve`, 'POST', id, 'approved');
        }
    );
}

// Enhanced Reject Peminjaman Function
function rejectPeminjaman(id) {
    showConfirmationModal(
        'Tolak Peminjaman',
        'Apakah Anda yakin ingin menolak peminjaman ini? Data akan dihapus permanen.',
        'danger',
        function() {
            performAction(`/admin/peminjaman/${id}/reject`, 'POST', id, 'rejected');
        }
    );
}

// Show confirmation modal
function showConfirmationModal(title, message, type, callback) {
    const iconClass = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-triangle';
    const colorClass = type === 'success' ? 'success' : 'danger';
    
    const modalHtml = `
        <div class="modal fade" id="confirmationModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content modern-modal">
                    <div class="modal-header modern-modal-header">
                        <div class="d-flex align-items-center gap-3">
                            <div style="width: 48px; height: 48px; background: var(--${colorClass}-light); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas ${iconClass}" style="color: var(--${colorClass}-color); font-size: 20px;"></i>
                            </div>
                            <div>
                                <h5 class="modal-title">${title}</h5>
                                <small class="text-muted">Konfirmasi tindakan</small>
                            </div>
                        </div>
                        <button type="button" class="btn-close modern-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body modern-modal-body" style="padding: 20px 24px;">
                        <p style="color: var(--gray-600); margin: 0;">${message}</p>
                    </div>
                    <div class="modal-footer modern-modal-footer">
                        <button type="button" class="modern-btn modern-btn-outline" data-bs-dismiss="modal">Batal</button>
                        <button type="button" class="modern-btn modern-btn-${type === 'success' ? 'primary' : 'danger'}" id="confirmAction">
                            <i class="fas ${type === 'success' ? 'fa-check' : 'fa-times'} me-2"></i>
                            ${type === 'success' ? 'Setujui' : 'Tolak'}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    `;

    // Remove existing modal if any
    const existingModal = document.getElementById('confirmationModal');
    if (existingModal) {
        existingModal.remove();
    }

    // Add modal to DOM
    document.body.insertAdjacentHTML('beforeend', modalHtml);
    
    // Show modal
    const modal = new bootstrap.Modal(document.getElementById('confirmationModal'));
    modal.show();

    // Handle confirm action
    document.getElementById('confirmAction').addEventListener('click', function() {
        const button = this;
        const originalContent = button.innerHTML;
        
        // Show loading state
        button.innerHTML = `<i class="fas fa-spinner fa-spin me-2"></i>${type === 'success' ? 'Menyetujui...' : 'Menolak...'}`;
        button.disabled = true;

        // Execute callback
        callback();
        
        // Close modal after a short delay
        setTimeout(() => {
            modal.hide();
        }, 500);
    });

    // Clean up modal when hidden
    document.getElementById('confirmationModal').addEventListener('hidden.bs.modal', function() {
        this.remove();
    });
}

// Perform action function
function performAction(url, method, id, action) {
    fetch(url, {
        method: method,
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Animate row removal
            const row = document.querySelector(`tr[data-id="${id}"]`);
            if (row) {
                row.style.transition = 'all 0.5s ease';
                row.style.opacity = '0';
                row.style.transform = 'translateX(-20px)';
                
                setTimeout(() => {
                    row.remove();
                    
                    // Check if table is empty
                    const remainingRows = document.querySelectorAll('.table-row').length;
                    if (remainingRows <= 1) { // Only the removed row remains
                        setTimeout(() => {
                            location.reload();
                        }, 300);
                    }
                }, 500);
            }
            
            // Show success notification
            const message = action === 'approved' ? 'Peminjaman berhasil disetujui!' : 'Peminjaman berhasil ditolak!';
            showNotification(message, 'success');
        } else {
            throw new Error(data.message || `Gagal ${action === 'approved' ? 'menyetujui' : 'menolak'} peminjaman`);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification(error.message || `Gagal ${action === 'approved' ? 'menyetujui' : 'menolak'} peminjaman`, 'error');
    });
}

// Notification system
function showNotification(message, type = 'info') {
    const iconClass = type === 'success' ? 'fa-check-circle' : type === 'error' ? 'fa-exclamation-circle' : 'fa-info-circle';
    const bgColor = type === 'success' ? 'var(--success-color)' : type === 'error' ? 'var(--danger-color)' : 'var(--info-color)';
    
    const notificationHtml = `
        <div class="toast-notification ${type}" style="
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            padding: 16px 20px;
            background: ${bgColor};
            color: white;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-lg);
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 600;
            animation: slideInRight 0.3s ease;
            min-width: 300px;
        ">
            <i class="fas ${iconClass}"></i>
            <span>${message}</span>
        </div>
    `;

    document.body.insertAdjacentHTML('beforeend', notificationHtml);
    
    const notification = document.querySelector('.toast-notification');
    
    // Auto remove after 4 seconds
    setTimeout(() => {
        notification.style.animation = 'slideOutRight 0.3s ease';
        setTimeout(() => {
            notification.remove();
        }, 300);
    }, 4000);
    
    // Click to dismiss
    notification.addEventListener('click', function() {
        this.style.animation = 'slideOutRight 0.3s ease';
        setTimeout(() => {
            this.remove();
        }, 300);
    });
}
</script>
@endsection