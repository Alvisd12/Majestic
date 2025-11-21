@extends('layouts.admin')

@section('title', 'Dikembalikan')

@section('page-title', 'Dikembalikan')

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
                    <div class="icon-wrapper success-gradient">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="header-text">
                        <h4 class="header-title">Motor Dikembalikan</h4>
                        <p class="header-subtitle">Kelola data motor yang sudah dikembalikan</p>
                    </div>
                </div>
                
                <div class="header-right">
                    <!-- Search Bar -->
                    <div class="search-container">
                        <form method="GET" action="{{ route('admin.dikembalikan') }}">
                            <div class="modern-search">
                                <i class="fas fa-search search-icon"></i>
                                <input type="text" class="search-input" name="search" 
                                       placeholder="Cari penyewa, motor, atau tanggal..." value="{{ request('search') }}">
                                @if(request('search'))
                                    <button type="button" class="clear-search" 
                                            onclick="window.location.href='{{route(';admin.dikembalikan;') }}'">
                                        <i class="fas fa-times"></i>
                                    </button>
                                @endif
                            </div>
                        </form>
                    </div>

                    <!-- Status Badge -->
                    @if(isset($peminjaman))
                        <div class="total-badge success-badge">
                            <span class="badge-text">{{ $peminjaman->total() }}</span>
                            <span class="badge-label">Dikembalikan</span>
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
                            <th class="start-date-col">Tanggal Sewa</th>
                            <th class="end-date-col">Tanggal Kembali</th>
                            <th class="duration-col">Durasi</th>
                            <th class="pickup-col">Pengambilan</th>
                            <th class="price-col">Total Biaya</th>
                            <th class="penalty-col">Denda</th>
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
                            <td class="start-date-col">
                                <div class="date-info">
                                    <span class="date">{{ \Carbon\Carbon::parse($item->tanggal_rental)->format('d M Y') }}</span>
                                    <span class="day">{{ dayNameIndonesian($item->tanggal_rental) }}</span>
                                </div>
                            </td>
                            <td class="end-date-col">
                                <div class="date-info">
                                    <span class="date">{{ \Carbon\Carbon::parse($item->tanggal_kembali)->format('d M Y') }}</span>
                                    <span class="day">{{ dayNameIndonesian($item->tanggal_kembali) }}</span>
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
                            <td class="penalty-col">
                                <div class="penalty-info">
                                    @if(str_starts_with($item->status, 'Terlambat') || str_starts_with($item->status, 'Selesai (Telat'))
                                        @php
                                            $lateDays = 0;
                                            if(str_starts_with($item->status, 'Terlambat') && preg_match('/Terlambat (\d+) hari/', $item->status, $matches)) {
                                                $lateDays = (int) $matches[1];
                                            } elseif(str_starts_with($item->status, 'Selesai (Telat') && preg_match('/Telat (\d+) hari/', $item->status, $matches)) {
                                                $lateDays = (int) $matches[1];
                                            }

                                            $dailyPrice = 0;
                                            if($item->motor && $item->motor->harga_per_hari) {
                                                $dailyPrice = $item->motor->harga_per_hari;
                                            } elseif($item->durasi_sewa > 0) {
                                                $dailyPrice = $item->total_harga / $item->durasi_sewa;
                                            }

                                            $calculatedPenalty = ($lateDays > 0 && $dailyPrice > 0) ? $lateDays * $dailyPrice : 0;
                                            $displayPenalty = $item->denda > 0 ? $item->denda : $calculatedPenalty;
                                        @endphp

                                        @if($displayPenalty > 0 && $lateDays > 0)
                                            <div class="penalty-amount text-danger fw-bold">
                                                Rp {{ number_format($displayPenalty, 0, ',', '.') }}
                                            </div>
                                            <div class="penalty-days text-muted small">
                                                {{ $lateDays }} hari terlambat
                                            </div>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
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
                                @php
                                    $status = $item->status ?? 'Selesai';
                                    $statusConfig = match(true) {
                                        $status === 'Menunggu Konfirmasi' => ['class' => 'status-warning', 'icon' => 'fas fa-clock', 'text' => 'Menunggu Konfirmasi'],
                                        $status === 'Dikonfirmasi' => ['class' => 'status-info', 'icon' => 'fas fa-check', 'text' => 'Dikonfirmasi'],
                                        $status === 'Selesai' => ['class' => 'status-success', 'icon' => 'fas fa-check-circle', 'text' => 'Selesai'],
                                        str_starts_with($status, 'Selesai (Telat') => ['class' => 'status-warning', 'icon' => 'fas fa-clock', 'text' => $status],
                                        $status === 'Dibatalkan' => ['class' => 'status-danger', 'icon' => 'fas fa-times', 'text' => 'Dibatalkan'],
                                        str_starts_with($status, 'Terlambat') => ['class' => 'status-danger', 'icon' => 'fas fa-exclamation-triangle', 'text' => $status],
                                        default => ['class' => 'status-secondary', 'icon' => 'fas fa-question', 'text' => $status]
                                    };
                                @endphp
                                <div class="status-badge {{ $statusConfig['class'] }}">
                                    <i class="{{ $statusConfig['icon'] }}"></i>
                                    <span>{{ $statusConfig['text'] }}</span>
                                </div>
                            </td>
                            <td class="action-col">
                                <div class="action-buttons">
                                    <button type="button" class="action-btn view-btn" 
                                            onclick="viewDetails('{{ $item->id }}')"
                                            data-bs-toggle="tooltip" title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button type="button" class="action-btn delete-btn" 
                                            onclick="deletePeminjaman('{{ $item->id }}')"
                                            data-bs-toggle="tooltip" title="Hapus Peminjaman">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr class="empty-row">
                            <td colspan="12">
                                <div class="empty-state">
                                    <div class="empty-icon">
                                        <i class="fas fa-check-circle"></i>
                                    </div>
                                    <h5>Tidak Ada Motor Dikembalikan</h5>
                                    <p>Saat ini tidak ada motor yang sudah dikembalikan</p>
                                    <div class="empty-actions">
                                        <a href="{{ route('admin.dipinjam') }}" class="modern-btn modern-btn-primary">
                                            <i class="fas fa-motorcycle me-2"></i>Lihat Motor Dipinjam
                                        </a>
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
/* Import CSS Variables from dipinjam design */
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

/* Modern Alert */
.modern-alert {
    background: linear-gradient(135deg, var(--success-light) 0%, #ecfdf5 100%);
    border: 1px solid var(--success-color);
    border-radius: var(--border-radius);
    box-shadow: var(--shadow-sm);
    animation: slideInDown 0.3s ease-out;
}

.info-alert {
    background: linear-gradient(135deg, var(--info-light) 0%, #e0f7fa 100%);
    border: 1px solid var(--info-color);
}

.alert-icon {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 18px;
}

.info-icon {
    background: var(--info-color);
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

/* Header with Success Theme (Green) for Dikembalikan */
.modern-card-header {
    background: linear-gradient(135deg,  #f8fafc 0%, #e2e8f0 100%);
    padding: 20px;
    border-bottom: 1px solid var(--gray-200);
}

.header-content {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 20px;
    flex-wrap: wrap;
}

.header-left {
    display: flex;
    align-items: center;
    gap: 12px;
}

.success-gradient {
    background: linear-gradient(135deg, var(--primary-color) 0%, #1d4ed8 100% );
}

.icon-wrapper {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 16px;
    box-shadow: var(--shadow-sm);
}

.header-title {
    font-size: 18px;
    font-weight: 700;
    color: var(--gray-900);
    margin: 0;
    line-height: 1.2;
}

.header-subtitle {
    font-size: 13px;
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

/* Search */
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
    min-width: 320px;
}

.modern-search:focus-within {
    border-color: var(--success-color);
    box-shadow: 0 0 0 3px var(--success-light);
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

/* Success Badge (Green) for Dikembalikan */
.success-badge {
    background: var(--success-light);
    border: 1px solid var(--success-color);
    border-radius: var(--border-radius);
    padding: 6px 12px;
    display: flex;
    align-items: center;
    gap: 6px;
}

.success-badge .badge-text {
    font-weight: 700;
    font-size: 14px;
    color: var(--success-color);
}

.success-badge .badge-label {
    font-size: 11px;
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
    font-size: 13px;
    background: white;
}

.modern-thead {
    background: linear-gradient(135deg, var(--gray-50) 0%, var(--gray-100) 100%);
    border-bottom: 2px solid var(--gray-200);
}

.modern-thead th {
    padding: 14px 12px;
    text-align: left;
    font-weight: 700;
    color: var(--gray-700);
    text-transform: uppercase;
    font-size: 11px;
    letter-spacing: 0.5px;
    position: sticky;
    top: 0;
    z-index: 10;
    background: linear-gradient(135deg, var(--gray-50) 0%, var(--gray-100) 100%);
    border-right: 1px solid var(--gray-200);
    white-space: nowrap;
}

.modern-thead th:last-child {
    border-right: none;
}

/* Column Widths */
.number-col { width: 45px; text-align: center; }
.user-col { width: 160px; }
.motor-col { width: 120px; }
.start-date-col, .end-date-col { width: 100px; }
.duration-col { width: 80px; text-align: center; }
.price-col { width: 110px; text-align: right; }
.penalty-col { width: 120px; text-align: center; }
.phone-col { width: 120px; }
.proof-col { width: 90px; text-align: center; }
.status-col { width: 120px; text-align: center; }
.action-col { width: 100px; text-align: center; }

/* Table Body */
.modern-tbody tr {
    transition: all 0.2s ease;
    border-bottom: 1px solid var(--gray-100);
}

.modern-tbody tr:hover {
    background: linear-gradient(135deg, var(--success-light) 0%, #f0fdf4 100%);
    transform: scale(1.001);
}

.modern-tbody td {
    padding: 12px;
    vertical-align: middle;
    color: var(--gray-700);
    border-right: 1px solid var(--gray-100);
    font-size: 13px;
}

.modern-tbody td:last-child {
    border-right: none;
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
    gap: 8px;
}

.avatar-container {
    position: relative;
    display: inline-block;
    flex-shrink: 0;
}

.user-avatar, .avatar-placeholder {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid white;
    box-shadow: var(--shadow-sm);
}

.avatar-placeholder {
    background: linear-gradient(135deg, var(--gray-400) 0%, var(--gray-500) 100%);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
}

.status-indicator {
    position: absolute;
    bottom: -1px;
    right: -1px;
    width: 10px;
    height: 10px;
    border-radius: 50%;
    border: 2px solid white;
}

.status-indicator.completed {
    background: var(--success-color);
}

.user-details {
    display: flex;
    flex-direction: column;
    gap: 1px;
    min-width: 0;
}

.user-name {
    font-weight: 600;
    color: var(--gray-900);
    font-size: 13px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.user-id {
    font-size: 10px;
    color: var(--gray-500);
}

/* Motor Info */
.motor-info {
    display: flex;
    align-items: center;
    font-weight: 500;
    color: var(--gray-700);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.motor-name {
    font-weight: 600;
    font-size: 13px;
}

/* Date Info */
.date-info {
    display: flex;
    flex-direction: column;
    gap: 1px;
}

.date {
    font-weight: 600;
    color: var(--gray-800);
    font-size: 12px;
}

.day {
    color: var(--gray-500);
    font-size: 10px;
    text-transform: capitalize;
}

/* Duration Badge */
.duration-badge {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    padding: 4px 8px;
    background: var(--success-light);
    color: var(--success-color);
    border-radius: 12px;
    font-size: 10px;
    font-weight: 600;
    white-space: nowrap;
}

/* Price Info */
.price-info {
    display: flex;
    align-items: baseline;
    gap: 2px;
    justify-content: flex-end;
}

.currency {
    font-size: 10px;
    color: var(--gray-500);
    font-weight: 500;
}

.amount {
    font-weight: 700;
    color: var(--success-color);
    font-size: 12px;
}

/* Penalty Info */
.penalty-info {
    display: flex;
    flex-direction: column;
    gap: 1px;
    text-align: center;
}

.penalty-amount {
    font-weight: 700;
    color: var(--danger-color);
    font-size: 11px;
}

.penalty-days {
    font-size: 9px;
    color: var(--gray-500);
}

/* Phone Link */
.phone-link {
    color: var(--success-color);
    text-decoration: none;
    font-weight: 500;
    transition: all 0.2s ease;
    display: inline-flex;
    align-items: center;
    font-size: 12px;
    white-space: nowrap;
}

.phone-link:hover {
    color: var(--success-color);
    transform: scale(1.02);
}

/* Proof Button */
.proof-btn {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    padding: 4px 8px;
    background: var(--info-light);
    color: var(--info-color);
    border: 1px solid var(--info-color);
    border-radius: 6px;
    font-size: 10px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
    white-space: nowrap;
}

.proof-btn:hover {
    background: var(--info-color);
    color: white;
    transform: translateY(-1px);
}

.no-proof {
    color: var(--gray-400);
    font-size: 11px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 4px;
}

/* Status Badges */
.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    padding: 4px 10px;
    border-radius: 16px;
    font-size: 10px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.3px;
    white-space: nowrap;
}

.status-info {
    background: var(--info-light);
    color: var(--info-color);
    border: 1px solid var(--info-color);
}

.status-success {
    background: var(--success-light);
    color: var(--success-color);
    border: 1px solid var(--success-color);
}

.status-danger {
    background: var(--danger-light);
    color: var(--danger-color);
    border: 1px solid var(--danger-color);
}

.status-warning {
    background: var(--warning-light);
    color: var(--warning-color);
    border: 1px solid var(--warning-color);
}

.status-secondary {
    background: var(--gray-100);
    color: var(--gray-600);
    border: 1px solid var(--gray-300);
}

/* Action Buttons */
.action-buttons {
    display: flex;
    gap: 4px;
    justify-content: center;
}

.action-btn {
    width: 28px;
    height: 28px;
    border: none;
    border-radius: 6px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s ease;
    font-size: 11px;
}

.view-btn {
    background: var(--primary-light);
    color: var(--primary-color);
}

.view-btn:hover {
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
    padding: 60px 20px;
    color: var(--gray-500);
}

.empty-icon {
    font-size: 4rem;
    color: var(--success-color);
    margin-bottom: 20px;
}

.empty-state h5 {
    font-size: 1.25rem;
    font-weight: 600;
    color: var(--gray-700);
    margin-bottom: 8px;
}

.empty-state p {
    font-size: 0.95rem;
    margin-bottom: 24px;
}

.empty-actions {
    display: flex;
    gap: 12px;
    justify-content: center;
    flex-wrap: wrap;
}

.modern-btn {
    display: inline-flex;
    align-items: center;
    padding: 10px 20px;
    border-radius: 8px;
    font-weight: 600;
    font-size: 14px;
    text-decoration: none;
    transition: all 0.2s ease;
    border: none;
    cursor: pointer;
}

.modern-btn-primary {
    background: var(--success-color);
    color: white;
}

.modern-btn-primary:hover {
    background: #059669;
    color: white;
    transform: translateY(-1px);
}

.modern-btn-outline {
    background: transparent;
    color: var(--gray-600);
    border: 1px solid var(--gray-300);
}

.modern-btn-outline:hover {
    background: var(--gray-50);
    color: var(--gray-700);
    border-color: var(--gray-400);
}

/* Modern Pagination */
.modern-pagination {
    padding: 20px;
    border-top: 1px solid var(--gray-200);
    background: var(--gray-50);
    display: flex;
    justify-content: between;
    align-items: center;
    flex-wrap: wrap;
    gap: 16px;
}

.pagination-info {
    flex: 1;
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

.pagination-links {
    flex: 1;
    display: flex;
    justify-content: flex-end;
}

/* Modern Modal */
.modern-modal {
    border-radius: 16px;
    border: none;
    box-shadow: var(--shadow-xl);
}

.modern-modal-header {
    background: linear-gradient(135deg, var(--gray-50) 0%, var(--gray-100) 100%);
    border-bottom: 1px solid var(--gray-200);
    padding: 20px;
    border-radius: 16px 16px 0 0;
}

.modal-icon {
    width: 40px;
    height: 40px;
    background: var(--info-color);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 18px;
}

.modern-modal-body {
    padding: 20px;
}

.image-container {
    position: relative;
    text-align: center;
}

.proof-image {
    max-width: 100%;
    max-height: 500px;
    border-radius: 12px;
    box-shadow: var(--shadow-md);
}

.image-overlay {
    position: absolute;
    top: 10px;
    right: 10px;
}

.zoom-btn {
    width: 40px;
    height: 40px;
    background: rgba(0, 0, 0, 0.7);
    color: white;
    border: none;
    border-radius: 50%;
    cursor: pointer;
    transition: all 0.2s ease;
}

.zoom-btn:hover {
    background: rgba(0, 0, 0, 0.9);
    transform: scale(1.1);
}

.modern-modal-footer {
    padding: 20px;
    border-top: 1px solid var(--gray-200);
    background: var(--gray-50);
    border-radius: 0 0 16px 16px;
    display: flex;
    gap: 12px;
    justify-content: flex-end;
}

.modern-close {
    background: var(--gray-100);
    border-radius: 50%;
    width: 32px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
}

/* Animations */
@keyframes slideInDown {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes pulse {
    0%, 100% {
        opacity: 1;
    }
    50% {
        opacity: 0.5;
    }
}
</style>

<script>
    // View Bukti Jaminan Function
    function viewBuktiJaminan(imagePath) {
        document.getElementById('buktiJaminanImage').src = '/storage/' + imagePath;
        new bootstrap.Modal(document.getElementById('buktiJaminanModal')).show();
    }

    // View Details Function
    function viewDetails(id) {
        window.location.href = `/admin/peminjaman/${id}`;
    }

    // Delete Peminjaman Function
    function deletePeminjaman(id) {
        if (confirm('Apakah Anda yakin ingin menghapus peminjaman ini?')) {
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
                } else {
                    alert('Gagal menghapus peminjaman');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Gagal menghapus peminjaman');
            });
        }
    }

    // Toggle Zoom Function
    function toggleZoom() {
        const img = document.getElementById('buktiJaminanImage');
        const btn = document.querySelector('.zoom-btn i');
        
        if (img.style.transform === 'scale(2)') {
            img.style.transform = 'scale(1)';
            img.style.cursor = 'default';
            btn.className = 'fas fa-search-plus';
        } else {
            img.style.transform = 'scale(2)';
            img.style.cursor = 'move';
            btn.className = 'fas fa-search-minus';
        }
    }

    // Download Image Function
    function downloadImage() {
        const img = document.getElementById('buktiJaminanImage');
        const link = document.createElement('a');
        link.href = img.src;
        link.download = 'bukti-jaminan.jpg';
        link.click();
    }

    // Auto-submit search form on input
    document.querySelector('input[name="search"]').addEventListener('keyup', function(e) {
        if (e.key === 'Enter') {
            this.form.submit();
        }
    });

    // Initialize tooltips
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>
@endsection 