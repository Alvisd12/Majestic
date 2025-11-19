@extends('layouts.admin')

@section('title', 'Galeri')

@section('page-title', 'Galeri')

@section('content')
    <!-- Success Notification -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4 modern-alert success-alert" role="alert">
            <div class="d-flex align-items-center">
                <div class="alert-icon me-3 success-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="flex-grow-1">
                    <strong>Berhasil:</strong> {{ session('success') }}
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    @endif

    <!-- Modern Card Container -->
    <div class="modern-card">
        <!-- Header with Search and Add Button -->
        <div class="modern-card-header">
            <div class="header-content">
                <div class="header-left">
                    <div class="icon-wrapper success-gradient">
                        <i class="fas fa-images"></i>
                    </div>
                    <div>
                        <h4 class="header-title">Manajemen Galeri</h4>
                        <p class="header-subtitle">Kelola foto dan dokumentasi rental</p>
                    </div>
                </div>
                <div class="header-right">
                    <!-- Search Box -->
                    <form method="GET" action="{{ route('admin.galeri') }}" class="search-container">
                        <div class="modern-search">
                            <i class="fas fa-search search-icon"></i>
                            <input type="text" class="search-input" name="search" 
                                   placeholder="Cari foto, penulis, tanggal..." 
                                   value="{{ request('search') }}">
                            @if(request('search'))
                                <button type="button" class="clear-search" onclick="clearSearch()">
                                    <i class="fas fa-times"></i>
                                </button>
                            @endif
                        </div>
                    </form>
                    
                    <!-- Add Button -->
                    <a href="{{ route('admin.galeri.create') }}" class="modern-btn modern-btn-primary">
                        <i class="fas fa-plus me-2"></i>
                        Tambah Foto
                    </a>
                    
                    <!-- Statistics Badge -->
                    <div class="success-badge">
                        <div class="badge-text">{{ $galeri->total() }}</div>
                        <div class="badge-label">Total Foto</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Table Body -->
        <div class="modern-card-body">
            <div class="table-container">
                <table class="modern-table">
                    <thead class="modern-thead">
                        <tr>
                            <th class="number-col">No</th>
                            <th class="image-col"></th>
                            <th class="user-col">Penulis</th>
                            <th class="jenis-col">Jenis Motor</th>
                            <th class="rental-date-col">Tanggal Sewa</th>
                            <th class="upload-date-col">Tanggal Upload</th>
                            <th class="action-col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="modern-tbody">
                        @forelse($galeri as $index => $item)
                        <tr class="table-row" data-id="{{ $item->id }}">
                            <td class="number-col">
                                <span class="row-number">{{ $galeri->firstItem() + $index }}</span>
                            </td>
                            <td class="image-col">
                                <div class="gallery-image-wrapper">
                                    @if($item->gambar)
                                        <div class="image-preview-container">
                                            <img src="{{ asset('storage/' . $item->gambar) }}" 
                                                 alt="Galeri Image" 
                                                 class="gallery-preview-image"
                                                 data-image="{{ $item->gambar }}"
                                                 data-author="{{ $item->admin->nama ?? 'Admin' }}"
                                                 data-date="{{ $item->tanggal_sewa ? \Carbon\Carbon::parse($item->tanggal_sewa)->format('d M Y') . ' - ' . dayNameIndonesian($item->tanggal_sewa) : 'Tanggal tidak tersedia' }}"
                                                 onclick="viewGalleryImageFromData(this)">
                                            <div class="image-overlay">
                                                <i class="fas fa-eye"></i>
                                            </div>
                                        </div>
                                    @else
                                        <div class="no-image-placeholder">
                                            <i class="fas fa-image"></i>
                                        </div>
                                    @endif
                                </div>
                            </td>
                            <td class="user-col">
                                <div class="user-info">
                                    <div class="user-details">
                                        <div class="user-name">
                                            <i class="fas fa-user me-1"></i>
                                            {{ $item->admin->nama ?? 'Admin' }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="jenis-col">
                                @if($item->jenis_motor)
                                    <div class="jenis-badge">
                                        @php
                                            $jenisColors = [
                                                'Matic' => 'badge-primary',
                                                'Manual' => 'badge-success', 
                                                'Sport' => 'badge-danger'
                                            ];
                                            $colorClass = $jenisColors[$item->jenis_motor] ?? 'badge-secondary';
                                        @endphp
                                        <span class="badge {{ $colorClass }}">
                                            {{ $item->jenis_motor }}
                                        </span>
                                    </div>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td class="rental-date-col">
                                @if($item->tanggal_sewa)
                                    <div class="date-info">
                                        <div class="date">{{ \Carbon\Carbon::parse($item->tanggal_sewa)->format('M d, Y') }}</div>
                                        <div class="day">{{ dayNameIndonesian($item->tanggal_sewa) }}</div>
                                    </div>
                                @else
                                    <span class="no-date">-</span>
                                @endif
                            </td>
                            <td class="upload-date-col">
                                <div class="date-info">
                                    <div class="date">{{ \Carbon\Carbon::parse($item->created_at)->format('M d, Y') }}</div>
                                    <div class="day">{{ dayNameIndonesian($item->created_at) }}</div>
                                </div>
                            </td>
                            <td class="action-col">
                                <div class="action-buttons">
                                    <button type="button" class="action-btn view-btn" 
                                            data-image="{{ $item->gambar }}"
                                            data-author="{{ $item->admin->nama ?? 'Admin' }}"
                                            data-date="{{ $item->tanggal_sewa ? \Carbon\Carbon::parse($item->tanggal_sewa)->format('d M Y') . ' - ' . dayNameIndonesian($item->tanggal_sewa) : 'Tanggal tidak tersedia' }}"
                                            onclick="viewGalleryImageFromData(this)" 
                                            title="Lihat Gambar">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <a href="{{ route('admin.galeri.edit', $item->id) }}" 
                                       class="action-btn edit-btn" 
                                       title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="action-btn delete-btn" 
                                            onclick="deleteGalleryItem('{{ $item->id }}')" 
                                            title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="empty-state">
                                <div class="empty-icon">
                                    <i class="fas fa-images"></i>
                                </div>
                                <h5>Tidak ada foto galeri</h5>
                                <p>Belum ada foto yang diupload ke galeri</p>
                                <div class="empty-actions">
                                    <a href="{{ route('admin.galeri.create') }}" class="modern-btn modern-btn-primary">
                                        <i class="fas fa-plus me-2"></i>
                                        Tambah Foto Pertama
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
        <!-- Pagination -->
        @if($galeri->hasPages())
        <div class="modern-pagination">
            <div class="pagination-info">
                <div class="showing-info">
                    Menampilkan {{ $galeri->firstItem() }} - {{ $galeri->lastItem() }} dari {{ $galeri->total() }} foto
                </div>
            </div>
            <div class="pagination-links">
                {{ $galeri->appends(request()->query())->links('vendor.pagination.custom-inline') }}
            </div>
        </div>
        @endif
    </div>

    <!-- Enhanced Modal for Gallery Image -->
    <div class="modal fade" id="galleryImageModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content modern-modal">
                <div class="modal-header modern-modal-header">
                    <div class="d-flex align-items-center gap-3">
                        <div class="modal-icon">
                            <i class="fas fa-image"></i>
                        </div>
                        <div>
                            <h5 class="modal-title">Preview Foto Galeri</h5>
                            <small class="text-muted" id="imageDetails">Detail foto</small>
                        </div>
                    </div>
                    <button type="button" class="btn-close modern-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body modern-modal-body">
                    <div class="image-container">
                        <img id="galleryModalImage" src="" alt="Gallery Image" class="gallery-modal-image">
                        <div class="image-overlay">
                            <button type="button" class="zoom-btn" onclick="toggleImageZoom()">
                                <i class="fas fa-search-plus"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="modal-footer modern-modal-footer">
                    <button type="button" class="modern-btn modern-btn-outline" data-bs-dismiss="modal">
                        Tutup
                    </button>
                    <button type="button" class="modern-btn modern-btn-primary" onclick="downloadGalleryImage()">
                        <i class="fas fa-download me-2"></i>Download
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('additional-scripts')
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

// Clear search function
function clearSearch() {
    const searchInput = document.querySelector('.search-input');
    if (searchInput) {
        searchInput.value = '';
        searchInput.form.submit();
    }
}

// Enhanced View Gallery Image Function
function viewGalleryImage(imagePath, authorName, rentalDate) {
    const modal = document.getElementById('galleryImageModal');
    const image = document.getElementById('galleryModalImage');
    const details = document.getElementById('imageDetails');
    
    // Set image source and details
    image.src = '/storage/' + imagePath;
    image.classList.remove('zoomed');
    details.textContent = `Oleh ${authorName} • ${rentalDate}`;
    
    // Show modal
    const bootstrapModal = new bootstrap.Modal(modal);
    bootstrapModal.show();
    
    // Store current image path for download
    modal.setAttribute('data-current-image', imagePath);
}

// View Gallery Image from Data Attributes
function viewGalleryImageFromData(element) {
    const imagePath = element.getAttribute('data-image');
    const authorName = element.getAttribute('data-author');
    const rentalDate = element.getAttribute('data-date');
    
    viewGalleryImage(imagePath, authorName, rentalDate);
}

// Toggle image zoom function
function toggleImageZoom() {
    const image = document.getElementById('galleryModalImage');
    const zoomBtn = document.querySelector('.zoom-btn i');
    
    image.classList.toggle('zoomed');
    
    if (image.classList.contains('zoomed')) {
        zoomBtn.className = 'fas fa-search-minus';
    } else {
        zoomBtn.className = 'fas fa-search-plus';
    }
}

// Download gallery image function
function downloadGalleryImage() {
    const modal = document.getElementById('galleryImageModal');
    const imagePath = modal.getAttribute('data-current-image');
    
    if (imagePath) {
        const link = document.createElement('a');
        link.href = '/storage/' + imagePath;
        link.download = 'galeri-foto-' + Date.now() + '.jpg';
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }
}

// Enhanced Delete Gallery Item Function
function deleteGalleryItem(id) {
    showConfirmationModal(
        'Hapus Foto Galeri',
        'Apakah Anda yakin ingin menghapus foto ini dari galeri? Foto akan dihapus secara permanen.',
        'danger',
        function() {
            performAction(`/admin/galeri/${id}`, 'DELETE', id, 'deleted');
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
                        <button type="button" class="modern-btn modern-btn-danger" id="confirmAction">
                            <i class="fas fa-trash me-2"></i>Hapus
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
        
        // Show loading state
        button.innerHTML = `<i class="fas fa-spinner fa-spin me-2"></i>Menghapus...`;
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
                    if (remainingRows <= 1) {
                        setTimeout(() => {
                            location.reload();
                        }, 300);
                    }
                }, 500);
            }
            
            // Show success notification
            showNotification('Foto berhasil dihapus dari galeri!', 'success');
        } else {
            throw new Error(data.message || 'Gagal menghapus foto');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification(error.message || 'Gagal menghapus foto', 'error');
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

// Add modern-btn-danger class style
const style = document.createElement('style');
style.textContent = `
    .modern-btn-danger {
        background: linear-gradient(135deg, var(--danger-color) 0%, #dc2626 100%);
        color: white;
        box-shadow: var(--shadow-sm);
    }
    
    .modern-btn-danger:hover {
        background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
        box-shadow: var(--shadow-md);
        transform: translateY(-1px);
        color: white;
    }
`;
document.head.appendChild(style);
</script>
@endsection

@section('additional-styles')
<style>
/* Import CSS Variables and Base Styles from Dipinjam Design */
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

.success-alert {
    background: linear-gradient(135deg, var(--success-light) 0%, #ecfdf5 100%);
    border: 1px solid var(--success-color);
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

.success-icon {
    background: var(--success-color);
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

/* Header */
.modern-card-header {
    background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
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
    background: linear-gradient(135deg, var(--primary-color) 0%, #1d4ed8 100%);
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

/* Search Container */
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

/* Badge */
.success-badge {
    background: var(--primary-light);
    border: 1px solid var(--primary-color);
    border-radius: var(--border-radius);
    padding: 6px 12px;
    display: flex;
    align-items: center;
    gap: 6px;
}

.success-badge .badge-text {
    font-weight: 700;
    font-size: 14px;
    color: var(--primary-color);
}

.success-badge .badge-label {
    font-size: 11px;
    color: var(--gray-600);
    text-transform: uppercase;
    font-weight: 600;
    letter-spacing: 0.5px;
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

/* Table Body */
.modern-card-body {
    padding: 0;
}

.table-container {
    overflow-x: auto;
    scrollbar-width: thin;
    scrollbar-color: var(--gray-300) var(--gray-100);
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

/* Column Widths for Gallery */
.number-col { width: 60px; text-align: center; }
.image-col { width: 120px; text-align: center; }
.user-col { width: 200px; }
.rental-date-col, .upload-date-col { width: 150px; }
.action-col { width: 120px; text-align: center; }

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
    padding: 16px 12px;
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

/* Gallery Image Wrapper */
.gallery-image-wrapper {
    display: flex;
    justify-content: center;
    align-items: center;
}

.image-preview-container {
    position: relative;
    display: inline-block;
    border-radius: 12px;
    overflow: hidden;
    transition: all 0.3s ease;
    cursor: pointer;
    box-shadow: var(--shadow-sm);
}

.image-preview-container:hover {
    transform: translateY(-2px) scale(1.02);
    box-shadow: var(--shadow-lg);
}

.gallery-preview-image {
    width: 80px;
    height: 60px;
    object-fit: cover;
    transition: all 0.3s ease;
}

.image-preview-container:hover .gallery-preview-image {
    opacity: 0.8;
}

.image-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.7);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s ease;
    border-radius: 12px;
}

.image-overlay i {
    color: white;
    font-size: 18px;
    transform: scale(0.8);
    transition: transform 0.3s ease;
}

.image-preview-container:hover .image-overlay {
    opacity: 1;
    visibility: visible;
}

.image-preview-container:hover .image-overlay i {
    transform: scale(1);
}

.no-image-placeholder {
    width: 80px;
    height: 60px;
    background: var(--gray-100);
    border: 2px dashed var(--gray-300);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--gray-400);
    font-size: 20px;
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
    flex-shrink: 0;
}

.avatar-placeholder {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--gray-400) 0%, var(--gray-500) 100%);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 14px;
    border: 2px solid white;
    box-shadow: var(--shadow-sm);
}

.admin-avatar {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid white;
    box-shadow: var(--shadow-sm);
}

.status-indicator {
    position: absolute;
    bottom: -1px;
    right: -1px;
    width: 12px;
    height: 12px;
    border-radius: 50%;
    border: 2px solid white;
}

.status-indicator.active {
    background: var(--success-color);
    animation: pulse 2s infinite;
}

.user-details {
    display: flex;
    flex-direction: column;
    gap: 2px;
    min-width: 0;
}

.user-name {
    font-weight: 600;
    color: var(--gray-900);
    font-size: 14px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.user-id {
    font-size: 11px;
    color: var(--gray-500);
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
    font-size: 13px;
}

.day {
    color: var(--gray-500);
    font-size: 11px;
    text-transform: capitalize;
}

.no-date {
    color: var(--gray-400);
    font-size: 14px;
    text-align: center;
}

/* Action Buttons */
.action-buttons {
    display: flex;
    gap: 6px;
    justify-content: center;
}

.action-btn {
    width: 32px;
    height: 32px;
    border: none;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s ease;
    font-size: 12px;
    text-decoration: none;
}

.view-btn {
    background: var(--info-light);
    color: var(--info-color);
}

.view-btn:hover {
    background: var(--info-color);
    color: white;
    transform: translateY(-1px);
}

.edit-btn {
    background: var(--warning-light);
    color: var(--warning-color);
}

.edit-btn:hover {
    background: var(--warning-color);
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
    flex-wrap: wrap;
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
    min-height: 400px;
}

.gallery-modal-image {
    max-width: 100%;
    max-height: 80vh;
    object-fit: contain;
    border-radius: 8px;
    box-shadow: var(--shadow-lg);
    transition: transform 0.3s ease;
}

.gallery-modal-image.zoomed {
    transform: scale(1.5);
    cursor: zoom-out;
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
    .number-col, .rental-date-col {
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
    
    .empty-actions {
        flex-direction: column;
        align-items: center;
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
    
    .avatar-placeholder {
        width: 32px;
        height: 32px;
        font-size: 12px;
    }
    
    .action-btn {
        width: 28px;
        height: 28px;
        font-size: 11px;
    }
    
    .gallery-preview-image {
        width: 60px;
        height: 45px;
    }
    
    .no-image-placeholder {
        width: 60px;
        height: 45px;
        font-size: 16px;
    }
    
    /* Hide more columns on mobile */
    .user-col {
        display: none;
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
    
    .image-preview-container {
        border: 1px solid #000;
    }
}
</style>
@endsection