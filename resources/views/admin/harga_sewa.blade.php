@extends('layouts.admin')

@section('title', 'Harga Sewa')

@section('page-title', 'Harga Sewa')

@section('content')
    <!-- Success Notification -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4 modern-alert success-alert auto-dismiss" role="alert" id="sessionAlert">
            <div class="d-flex align-items-center">
                <div class="alert-icon me-3 success-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="flex-grow-1">
                    <strong>Berhasil:</strong> {{ session('success') }}
                </div>
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
                        <i class="fas fa-motorcycle"></i>
                    </div>
                    <div>
                        <h4 class="header-title">Manajemen Harga Sewa</h4>
                        <p class="header-subtitle">Kelola daftar motor dan harga rental</p>
                    </div>
                </div>
                <div class="header-right">
                    <!-- Search Box -->
                    <form method="GET" action="{{ route('admin.harga_sewa') }}" class="search-container">
                        <div class="modern-search">
                            <i class="fas fa-search search-icon"></i>
                            <input type="text" class="search-input" name="search" 
                                   placeholder="Cari motor, plat, warna..." 
                                   value="{{ request('search') }}">
                            @if(request('search'))
                                <button type="button" class="clear-search" onclick="clearSearch()">
                                    <i class="fas fa-times"></i>
                                </button>
                            @endif
                        </div>
                    </form>
                    
                    <!-- Add Button -->
                    <button type="button" class="modern-btn modern-btn-primary" onclick="addMotor()">
                        <i class="fas fa-plus me-2"></i>
                        Tambah Motor
                    </button>
                    
                    <!-- Statistics Badge -->
                    <div class="success-badge">
                        <div class="badge-text">{{ $motors->total() }}</div>
                        <div class="badge-label">Total Motor</div>
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
                            <th class="motor-col">Motor</th>
                            <th class="jenis-col">Jenis</th>
                            <th class="plate-col">Plat Motor</th>
                            <th class="color-col">Warna</th>
                            <th class="price-col">Harga</th>
                            <th class="desc-col">Deskripsi</th>
                            <th class="date-col">Tanggal Upload</th>
                            <th class="status-col">Status</th>
                            <th class="action-col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="modern-tbody">
                        @forelse($motors as $index => $motor)
                        <tr class="table-row" data-id="{{ $motor->id }}">
                            <td class="number-col">
                                <span class="row-number">{{ $motors->firstItem() + $index }}</span>
                            </td>
                            <td class="image-col">
                                <div class="motor-image-wrapper">
                                    @if($motor->foto)
                                        <div class="motor-preview-container">
                                            <img src="{{ asset('storage/' . $motor->foto) }}" 
                                                 alt="{{ $motor->merk }} {{ $motor->model }}" 
                                                 class="motor-preview-image"
                                                 onclick="viewMotorImage('{{ $motor->foto }}', '{{ $motor->merk }} {{ $motor->model }}', '{{ $motor->plat_nomor }}')">
                                            <div class="motor-overlay">
                                                <i class="fas fa-eye"></i>
                                            </div>
                                        </div>
                                    @else
                                        <div class="no-motor-image-placeholder">
                                            <span class="text-muted">Tidak ada foto</span>
                                        </div>
                                    @endif
                                </div>
                            </td>
                            <td class="motor-col">
                                <div class="motor-info">
                                    <div class="motor-name">{{ $motor->merk }} {{ $motor->model }}</div>
                                    <div class="motor-year">Tahun {{ $motor->tahun ?: '2020' }}</div>
                                </div>
                            </td>
                            <td class="jenis-col">
                                <div class="jenis-badge">
                                    @php
                                        $jenisColors = [
                                            'Matic' => 'badge-primary',
                                            'Manual' => 'badge-success', 
                                            'Sport' => 'badge-danger'
                                        ];
                                        $colorClass = $jenisColors[$motor->jenis_motor] ?? 'badge-secondary';
                                    @endphp
                                    <span class="badge {{ $colorClass }}" style="color: black; font-weight: 600;">
                                        {{ $motor->jenis_motor ?: 'Belum diset' }}
                                    </span>
                                </div>
                            </td>
                            <td class="plate-col">
                                <div class="plate-info">
                                    <span class="plate-number">{{ $motor->plat_nomor }}</span>
                                </div>
                            </td>
                            <td class="color-col">
                                @php
                                    $colorMap = [
                                        'Merah' => '#ef4444',
                                        'Biru' => '#3b82f6',
                                        'Putih' => '#ffffff',
                                        'Hijau' => '#10b981',
                                        'Kuning' => '#f59e0b',
                                        'Hitam' => '#1f2937'
                                    ];
                                    $backgroundColor = $colorMap[$motor->warna] ?? '#1f2937';
                                @endphp
                                <div class="color-info">
                                    <div class="color-indicator" style="background-color: '{{ $backgroundColor }}'; border: 1px solid #e5e7eb;"></div>
                                    <span class="color-name">{{ $motor->warna ?: 'Hitam' }}</span>
                                </div>
                            </td>
                            <td class="price-col">
                                <div class="price-info">
                                    <div class="price-amount">Rp {{ number_format($motor->harga_per_hari, 0, ',', '.') }}</div>
                                    <div class="price-unit">per hari</div>
                                </div>
                            </td>
                            <td class="desc-col">
                                <div class="description-info">
                                    {{ Str::limit($motor->deskripsi ?: 'Motor ' . $motor->merk . ' ' . $motor->model . ' tahun ' . ($motor->tahun ?: '2020'), 40) }}
                                </div>
                            </td>
                            <td class="date-col">
                                <div class="date-info">
                                    <div class="date">{{ $motor->created_at->format('M d, Y') }}</div>
                                    <div class="day">{{ dayNameIndonesian($motor->created_at) }}</div>
                                </div>
                            </td>
                            <td class="status-col">
                                @php
                                    $statusClasses = [
                                        'Tersedia' => 'status-success',
                                        'Disewa' => 'status-warning',
                                        'Maintenance' => 'status-danger'
                                    ];
                                    $statusClass = $statusClasses[$motor->status] ?? 'status-secondary';
                                @endphp
                                <span class="status-badge {{ $statusClass }}">
                                    @if($motor->status === 'Tersedia')
                                        <i class="fas fa-check-circle me-1"></i>
                                    @elseif($motor->status === 'Disewa')
                                        <i class="fas fa-clock me-1"></i>
                                    @elseif($motor->status === 'Maintenance')
                                        <i class="fas fa-wrench me-1"></i>
                                    @else
                                        <i class="fas fa-question-circle me-1"></i>
                                    @endif
                                    {{ $motor->status }}
                                </span>
                            </td>
                            <td class="action-col">
                                <div class="action-buttons">
                                    <button type="button" class="action-btn view-btn" 
                                            onclick="viewMotorDetails('{{ $motor->id }}')" 
                                            title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button type="button" class="action-btn edit-btn" 
                                            onclick="editMotor('{{ $motor->id }}')" 
                                            title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button type="button" class="action-btn delete-btn" 
                                            onclick="deleteMotor('{{ $motor->id }}')" 
                                            title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="10" class="empty-state">
                                <div class="empty-icon">
                                    <i class="fas fa-motorcycle"></i>
                                </div>
                                <h5>Tidak ada data motor</h5>
                                <p>Belum ada motor yang terdaftar dalam sistem</p>
                                <div class="empty-actions">
                                    <button type="button" class="modern-btn modern-btn-primary" onclick="addMotor()">
                                        <i class="fas fa-plus me-2"></i>
                                        Tambah Motor Pertama
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
        <!-- Pagination -->
        @if($motors->hasPages())
        <div class="modern-pagination">
            <div class="pagination-info">
                <div class="showing-info">
                    Menampilkan {{ $motors->firstItem() }} - {{ $motors->lastItem() }} dari {{ $motors->total() }} motor
                </div>
            </div>
            <div class="pagination-links">
                {{ $motors->appends(request()->query())->links('vendor.pagination.custom-inline') }}
            </div>
        </div>
        @endif
    </div>

    <!-- Enhanced Modal for Motor Image -->
    <div class="modal fade" id="motorImageModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content modern-modal">
                <div class="modal-header modern-modal-header">
                    <div class="d-flex align-items-center gap-3">
                        <div class="modal-icon">
                            <i class="fas fa-motorcycle"></i>
                        </div>
                        <div>
                            <h5 class="modal-title">Preview Motor</h5>
                            <small class="text-muted" id="motorDetails">Detail motor</small>
                        </div>
                    </div>
                    <button type="button" class="btn-close modern-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body modern-modal-body">
                    <div class="image-container">
                        <img id="motorModalImage" src="" alt="Motor Image" class="motor-modal-image">
                        <div class="image-overlay">
                            <button type="button" class="zoom-btn" onclick="toggleMotorZoom()">
                                <i class="fas fa-search-plus"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="modal-footer modern-modal-footer">
                    <button type="button" class="modern-btn modern-btn-outline" data-bs-dismiss="modal">
                        Tutup
                    </button>
                    <button type="button" class="modern-btn modern-btn-primary" onclick="downloadMotorImage()">
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
    // Initialize session alerts auto-dismiss
    initSessionAlerts();
    
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

// Enhanced View Motor Image Function
function viewMotorImage(imagePath, motorName, plateNumber) {
    const modal = document.getElementById('motorImageModal');
    const image = document.getElementById('motorModalImage');
    const details = document.getElementById('motorDetails');
    
    // Set image source and details
    image.src = '/storage/' + imagePath;
    image.classList.remove('zoomed');
    details.textContent = `${motorName} • ${plateNumber}`;
    
    // Show modal
    const bootstrapModal = new bootstrap.Modal(modal);
    bootstrapModal.show();
    
    // Store current image path for download
    modal.setAttribute('data-current-image', imagePath);
}

// Toggle motor zoom function
function toggleMotorZoom() {
    const image = document.getElementById('motorModalImage');
    const zoomBtn = document.querySelector('.zoom-btn i');
    
    image.classList.toggle('zoomed');
    
    if (image.classList.contains('zoomed')) {
        zoomBtn.className = 'fas fa-search-minus';
    } else {
        zoomBtn.className = 'fas fa-search-plus';
    }
}

// Download motor image function
function downloadMotorImage() {
    const modal = document.getElementById('motorImageModal');
    const imagePath = modal.getAttribute('data-current-image');
    
    if (imagePath) {
        const link = document.createElement('a');
        link.href = '/storage/' + imagePath;
        link.download = 'motor-' + Date.now() + '.jpg';
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }
}

// Add Motor Function
function addMotor() {
    const url = '{{ url("admin/motor/create") }}';
    console.log('Add motor URL:', url);
    window.location.href = url;
}

// View Motor Details Function
function viewMotorDetails(id) {
    console.log('Viewing motor details for ID:', id);
    const baseUrl = '{{ url("admin/motor") }}';
    const url = baseUrl + '/' + id + '/edit';
    console.log('Generated URL:', url);
    // For now, redirect to edit page since there's no dedicated view page
    window.location.href = url;
}

// Edit Motor Function
function editMotor(id) {
    console.log('Editing motor for ID:', id);
    const baseUrl = '{{ url("admin/motor") }}';
    const url = baseUrl + '/' + id + '/edit';
    console.log('Generated URL:', url);
    window.location.href = url;
}

// Enhanced Delete Motor Function
function deleteMotor(id) {
    showConfirmationModal(
        'Hapus Motor',
        'Apakah Anda yakin ingin menghapus motor ini? Data motor akan dihapus secara permanen.',
        'danger',
        function() {
            const baseUrl = '{{ url("admin/motor") }}';
            const url = baseUrl + '/' + id;
            performAction(url, 'DELETE', id, 'deleted');
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
            showNotification('Motor berhasil dihapus!', 'success');
        } else {
            throw new Error(data.message || 'Gagal menghapus motor');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification(error.message || 'Gagal menghapus motor', 'error');
    });
}

// Enhanced Notification system with duplicate prevention
let activeNotifications = [];
let notificationContainer = null;

function initNotificationContainer() {
    if (!notificationContainer) {
        notificationContainer = document.createElement('div');
        notificationContainer.id = 'notification-container';
        notificationContainer.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            display: flex;
            flex-direction: column;
            gap: 10px;
            pointer-events: none;
        `;
        document.body.appendChild(notificationContainer);
    }
}

function showNotification(message, type = 'info', duration = 4000) {
    // Prevent duplicate notifications
    const existingNotification = activeNotifications.find(n => n.message === message && n.type === type);
    if (existingNotification) {
        console.log('Duplicate notification prevented:', message);
        return;
    }
    
    initNotificationContainer();
    
    const iconClass = type === 'success' ? 'fa-check-circle' : type === 'error' ? 'fa-exclamation-circle' : 'fa-info-circle';
    const bgColor = type === 'success' ? 'var(--success-color)' : type === 'error' ? 'var(--danger-color)' : 'var(--info-color)';
    
    const notificationId = 'notification-' + Date.now() + '-' + Math.random().toString(36).substr(2, 9);
    
    const notification = document.createElement('div');
    notification.id = notificationId;
    notification.className = `toast-notification ${type}`;
    notification.style.cssText = `
        padding: 16px 20px;
        background: ${bgColor};
        color: white;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow-lg);
        display: flex;
        align-items: center;
        gap: 12px;
        font-weight: 600;
        min-width: 300px;
        max-width: 400px;
        word-wrap: break-word;
        animation: slideInRight 0.3s ease;
        pointer-events: auto;
        cursor: pointer;
        transition: all 0.2s ease;
    `;
    
    notification.innerHTML = `
        <i class="fas ${iconClass}"></i>
        <span style="flex: 1;">${message}</span>
        <i class="fas fa-times" style="opacity: 0.7; font-size: 12px; margin-left: 8px;"></i>
    `;
    
    // Add to active notifications tracking
    const notificationData = { id: notificationId, message, type, element: notification };
    activeNotifications.push(notificationData);
    
    // Add to container
    notificationContainer.appendChild(notification);
    
    // Hover effects
    notification.addEventListener('mouseenter', function() {
        this.style.transform = 'translateX(-5px)';
        this.style.boxShadow = 'var(--shadow-xl)';
    });
    
    notification.addEventListener('mouseleave', function() {
        this.style.transform = 'translateX(0)';
        this.style.boxShadow = 'var(--shadow-lg)';
    });
    
    // Click to dismiss
    notification.addEventListener('click', function() {
        dismissNotification(notificationId);
    });
    
    // Auto remove after specified duration
    setTimeout(() => {
        dismissNotification(notificationId);
    }, duration);
}

function dismissNotification(notificationId) {
    const notificationData = activeNotifications.find(n => n.id === notificationId);
    if (!notificationData) return;
    
    const notification = notificationData.element;
    if (!notification || !notification.parentNode) return;
    
    notification.style.animation = 'slideOutRight 0.3s ease';
    
    setTimeout(() => {
        if (notification.parentNode) {
            notification.remove();
        }
        
        // Remove from active notifications
        activeNotifications = activeNotifications.filter(n => n.id !== notificationId);
        
        // Clean up container if empty
        if (activeNotifications.length === 0 && notificationContainer) {
            notificationContainer.remove();
            notificationContainer = null;
        }
    }, 300);
}

// Auto-dismiss session alerts
function initSessionAlerts() {
    const sessionAlert = document.getElementById('sessionAlert');
    if (sessionAlert) {
        // Auto dismiss after 5 seconds
        setTimeout(() => {
            sessionAlert.style.animation = 'slideOutUp 0.5s ease';
            setTimeout(() => {
                sessionAlert.remove();
            }, 500);
        }, 5000);
        
        // Click anywhere on alert to dismiss
        sessionAlert.addEventListener('click', function() {
            this.style.animation = 'slideOutUp 0.5s ease';
            setTimeout(() => {
                this.remove();
            }, 500);
        });
    }
}

// Add modern-btn-danger class style and notification animations
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
    
    /* Notification Animations */
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
    
    @keyframes slideInDown {
        from {
            transform: translateY(-100%);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }
    
    @keyframes slideOutUp {
        from {
            transform: translateY(0);
            opacity: 1;
        }
        to {
            transform: translateY(-100%);
            opacity: 0;
        }
    }
    
    /* Auto-dismiss alert styling */
    .auto-dismiss {
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .auto-dismiss:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-lg);
    }
    
    /* Toast notification container */
    #notification-container {
        max-height: calc(100vh - 40px);
        overflow-y: auto;
    }
    
    /* Custom scrollbar for notification container */
    #notification-container::-webkit-scrollbar {
        width: 4px;
    }
    
    #notification-container::-webkit-scrollbar-track {
        background: transparent;
    }
    
    #notification-container::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.3);
        border-radius: 2px;
    }
`;
document.head.appendChild(style);
</script>

@section('additional-styles')
<style>
/* Import CSS Variables and Base Styles */
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

/* Column Widths for Harga Sewa */
.number-col { width: 60px; text-align: center; }
.image-col { width: 100px; text-align: center; }
.motor-col { width: 160px; }
.jenis-col { width: 110px; text-align: left; }
.plate-col { width: 120px; }
.color-col { width: 120px; }
.price-col { width: 140px; text-align: right; }
.desc-col { width: 200px; }
.date-col { width: 120px; }
.status-col { width: 120px; text-align: center; }
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

/* Motor Image Wrapper */
.motor-image-wrapper {
    display: flex;
    justify-content: center;
    align-items: center;
}

.motor-preview-container {
    position: relative;
    display: inline-block;
    border-radius: 12px;
    overflow: hidden;
    transition: all 0.3s ease;
    cursor: pointer;
    box-shadow: var(--shadow-sm);
}

.motor-preview-container:hover {
    transform: translateY(-2px) scale(1.02);
    box-shadow: var(--shadow-lg);
}

.motor-preview-image {
    width: 70px;
    height: 50px;
    object-fit: cover;
    transition: all 0.3s ease;
}

.motor-preview-container:hover .motor-preview-image {
    opacity: 0.8;
}

.motor-overlay {
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

.motor-overlay i {
    color: white;
    font-size: 16px;
    transform: scale(0.8);
    transition: transform 0.3s ease;
}

.motor-preview-container:hover .motor-overlay {
    opacity: 1;
    visibility: visible;
}

.motor-preview-container:hover .motor-overlay i {
    transform: scale(1);
}

.no-motor-image-placeholder {
    width: 70px;
    height: 50px;
    background: var(--gray-100);
    border: 2px dashed var(--gray-300);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--gray-400);
    font-size: 18px;
}

/* Motor Info */
.motor-info {
    display: flex;
    flex-direction: column;
    gap: 2px;
}

.motor-name {
    font-weight: 600;
    color: var(--gray-900);
    font-size: 14px;
}

.motor-year {
    font-size: 11px;
    color: var(--gray-500);
}

/* Plate Info */
.plate-info {
    display: flex;
    align-items: center;
    justify-content: flex-start;
}

.plate-number {
    background: var(--primary-light);
    color: var(--primary-color);
    padding: 4px 8px;
    border-radius: 6px;
    font-weight: 600;
    font-size: 12px;
    border: 1px solid var(--primary-color);
}

/* Color Info */
.color-info {
    display: flex;
    align-items: center;
    gap: 8px;
}

.color-indicator {
    width: 16px;
    height: 16px;
    border-radius: 50%;
    flex-shrink: 0;
}

.color-name {
    font-size: 13px;
    color: var(--gray-700);
    font-weight: 500;
}

/* Price Info */
.price-info {
    display: flex;
    flex-direction: column;
    gap: 1px;
    align-items: flex-end;
}

.price-amount {
    font-weight: 700;
    color: var(--success-color);
    font-size: 14px;
}

.price-unit {
    font-size: 10px;
    color: var(--gray-500);
}

/* Description Info */
.description-info {
    color: var(--gray-600);
    font-size: 12px;
    line-height: 1.4;
    max-width: 200px;
    overflow: hidden;
    text-overflow: ellipsis;
    display: -webkit-box;
    -webkit-box-orient: vertical;
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

/* Status Badges */
.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    padding: 6px 12px;
    border-radius: 16px;
    font-size: 10px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.3px;
    white-space: nowrap;
}

.status-success {
    background: var(--success-light);
    color: var(--success-color);
    border: 1px solid var(--success-color);
}

.status-warning {
    background: var(--warning-light);
    color: var(--warning-color);
    border: 1px solid var(--warning-color);
}

.status-danger {
    background: var(--danger-light);
    color: var(--danger-color);
    border: 1px solid var(--danger-color);
}

.status-secondary {
    background: var(--gray-100);
    color: var(--gray-600);
    border: 1px solid var(--gray-300);
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
.modern-pagination .pagination-links .pagination {
    margin: 0;
    gap: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-wrap: nowrap;
}

.modern-pagination .pagination-links .page-item {
    margin: 0;
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

.motor-modal-image {
    max-width: 100%;
    max-height: 80vh;
    object-fit: contain;
    border-radius: 8px;
    box-shadow: var(--shadow-lg);
    transition: transform 0.3s ease;
}

.motor-modal-image.zoomed {
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
    .number-col, .color-col, .desc-col {
        display: none;
    }
    
    .modern-pagination {
        flex-direction: column;
        gap: 16px;
        text-align: center;
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
    
    .action-btn {
        width: 28px;
        height: 28px;
        font-size: 11px;
    }
    
    .motor-preview-image {
        width: 60px;
        height: 40px;
    }
    
    .no-motor-image-placeholder {
        width: 60px;
        height: 40px;
        font-size: 16px;
    }
    
    /* Hide more columns on mobile */
    .plate-col, .date-col {
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
    
    .status-badge {
        border: 1px solid #000;
        background: white !important;
        color: black !important;
    }
}

/* Badge Jenis Motor - Black Text */
.jenis-badge .badge {
    color: black !important;
    font-weight: 600 !important;
    font-size: 12px !important;
    display: inline-flex !important;
    align-items: center;
    padding: 2px 12px !important;
    border-radius: 999px !important;
    min-width: auto !important;
    width: fit-content !important;
}

.jenis-badge .badge-primary {
    background-color: #dbeafe !important;
    border: 1px solid #3b82f6 !important;
    color: black !important;
}

.jenis-badge .badge-success {
    background-color: #d1fae5 !important;
    border: 1px solid #10b981 !important;
    color: black !important;
}

.jenis-badge .badge-danger {
    background-color: #fee2e2 !important;
    border: 1px solid #ef4444 !important;
    color: black !important;
}

.jenis-badge .badge-secondary {
    background-color: #f3f4f6 !important;
    border: 1px solid #6b7280 !important;
    color: black !important;
}
</style>
@endsection