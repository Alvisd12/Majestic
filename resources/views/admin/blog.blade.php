@extends('layouts.admin')

@section('title', 'Blog')

@section('page-title', 'Blog')

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
                    <div class="icon-wrapper blog-gradient">
                        <i class="fas fa-blog"></i>
                    </div>
                    <div>
                        <h4 class="header-title">Manajemen Blog</h4>
                        <p class="header-subtitle">Kelola artikel dan konten blog</p>
                    </div>
                </div>
                <div class="header-right">
                    <!-- Search Box -->
                    <form method="GET" action="{{ route('admin.blog') }}" class="search-container">
                        <div class="modern-search">
                            <i class="fas fa-search search-icon"></i>
                            <input type="text" class="search-input" name="search" 
                                   placeholder="Cari judul, penulis, konten..." 
                                   value="{{ request('search') }}">
                            @if(request('search'))
                                <button type="button" class="clear-search" onclick="clearSearch()">
                                    <i class="fas fa-times"></i>
                                </button>
                            @endif
                        </div>
                    </form>
                    
                    <!-- Add Button -->
                    <a href="{{ route('admin.blog.create') }}" class="modern-btn modern-btn-primary">
                        <i class="fas fa-plus me-2"></i>
                        Tambah Blog
                    </a>
                    
                    <!-- Statistics Badge -->
                    <div class="blog-badge">
                        <div class="badge-text">{{ $blogs->total() }}</div>
                        <div class="badge-label">Total Blog</div>
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
                            <th class="image-col">Gambar</th>
                            <th class="title-col">Judul</th>
                            <th class="content-col">Konten</th>
                            <th class="author-col">Penulis</th>
                            <th class="location-col">Lokasi</th>
                            <th class="status-col">Status</th>
                            <th class="date-col">Tanggal</th>
                            <th class="action-col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="modern-tbody">
                        @forelse($blogs as $index => $blog)
                        <tr class="table-row" data-id="{{ $blog->id }}">
                            <td class="number-col">
                                <span class="row-number">{{ $blogs->firstItem() + $index }}</span>
                            </td>
                            <td class="image-col">
                                <div class="blog-image-wrapper">
                                    @if($blog->gambar)
                                        <div class="image-preview-container">
                                            <img src="{{ asset('storage/' . $blog->gambar) }}" 
                                                 alt="Blog Image" 
                                                 class="blog-preview-image"
                                                 data-image="{{ $blog->gambar }}"
                                                 data-title="{{ $blog->judul }}"
                                                 data-author="{{ $blog->penulis ?? $blog->admin->nama ?? 'Admin' }}"
                                                 onclick="viewBlogImageFromData(this)">
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
                            <td class="title-col">
                                <div class="blog-title-wrapper">
                                    <div class="blog-title" title="{{ $blog->judul }}">
                                        {{ Str::limit($blog->judul, 50) }}
                                    </div>
                                    @if($blog->published)
                                        <div class="title-indicator published">
                                            <i class="fas fa-globe"></i>
                                        </div>
                                    @else
                                        <div class="title-indicator draft">
                                            <i class="fas fa-edit"></i>
                                        </div>
                                    @endif
                                </div>
                            </td>
                            <td class="content-col">
                                <div class="content-preview" title="{{ strip_tags($blog->isi) }}">
                                    <div class="content-text">
                                        {{ Str::limit(strip_tags($blog->isi), 80) }}
                                    </div>
                                    <div class="content-length">
                                        {{ Str::length(strip_tags($blog->isi)) }} karakter
                                    </div>
                                </div>
                            </td>
                            <td class="author-col">
                                <div class="author-info">
                                    <div class="avatar-container">
                                        @if($blog->admin && $blog->admin->profile_photo)
                                            <img src="{{ asset('storage/' . $blog->admin->profile_photo) }}" 
                                                 alt="Admin Avatar" 
                                                 class="admin-avatar">
                                        @else
                                            <div class="avatar-placeholder">
                                                <i class="fas fa-user"></i>
                                            </div>
                                        @endif
                                        <div class="status-indicator active"></div>
                                    </div>
                                    <div class="author-details">
                                        <div class="author-name">{{ $blog->penulis ?? $blog->admin->nama ?? 'Admin' }}</div>
                                        <div class="author-role">Author</div>
                                    </div>
                                </div>
                            </td>
                            <td class="location-col">
                                @if($blog->lokasi)
                                    <div class="location-info">
                                        <div class="location-icon">
                                            <i class="fas fa-map-marker-alt"></i>
                                        </div>
                                        <div class="location-text" title="{{ $blog->lokasi }}">
                                            {{ Str::limit($blog->lokasi, 30) }}
                                        </div>
                                    </div>
                                @else
                                    <span class="no-location">-</span>
                                @endif
                            </td>
                            <td class="status-col">
                                @if($blog->published)
                                    <div class="status-badge published">
                                        <div class="status-dot"></div>
                                        <span>Published</span>
                                    </div>
                                @else
                                    <div class="status-badge draft">
                                        <div class="status-dot"></div>
                                        <span>Draft</span>
                                    </div>
                                @endif
                            </td>
                            <td class="date-col">
                                <div class="date-info">
                                    <div class="date">{{ $blog->created_at->format('M d, Y') }}</div>
                                    <div class="day">{{ dayNameIndonesian($blog->created_at) }}</div>
                                </div>
                            </td>
                            <td class="action-col">
                                <div class="action-buttons">
                                    <button type="button" class="action-btn view-btn" 
                                            data-image="{{ $blog->gambar }}"
                                            data-title="{{ $blog->judul }}"
                                            data-author="{{ $blog->penulis ?? $blog->admin->nama ?? 'Admin' }}"
                                            onclick="viewBlogImageFromData(this)" 
                                            title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <a href="{{ route('admin.blog.edit', $blog->id) }}" 
                                       class="action-btn edit-btn" 
                                       title="Edit Blog">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="action-btn delete-btn" 
                                            data-id="{{ $blog->id }}"
                                            title="Hapus Blog">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="empty-state">
                                <div class="empty-icon">
                                    <i class="fas fa-blog"></i>
                                </div>
                                <h5>Tidak ada artikel blog</h5>
                                <p>Belum ada artikel yang dibuat untuk blog</p>
                                <div class="empty-actions">
                                    <a href="{{ route('admin.blog.create') }}" class="modern-btn modern-btn-primary">
                                        <i class="fas fa-plus me-2"></i>
                                        Buat Blog Pertama
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
        @if($blogs->hasPages())
        <div class="modern-pagination">
            <div class="pagination-info">
                <div class="showing-info">
                    Menampilkan {{ $blogs->firstItem() }} - {{ $blogs->lastItem() }} dari {{ $blogs->total() }} artikel
                </div>
            </div>
            <div class="pagination-links">
                {{ $blogs->appends(request()->query())->links('vendor.pagination.custom-inline') }}
            </div>
        </div>
        @endif
    </div>

    <!-- Enhanced Modal for Blog Image -->
    <div class="modal fade" id="blogImageModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content modern-modal">
                <div class="modal-header modern-modal-header">
                    <div class="d-flex align-items-center gap-3">
                        <div class="modal-icon blog-icon">
                            <i class="fas fa-image"></i>
                        </div>
                        <div>
                            <h5 class="modal-title">Preview Gambar Blog</h5>
                            <small class="text-muted" id="blogImageDetails">Detail gambar</small>
                        </div>
                    </div>
                    <button type="button" class="btn-close modern-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body modern-modal-body">
                    <div class="image-container">
                        <img id="blogModalImage" src="" alt="Blog Image" class="blog-modal-image">
                        <div class="image-overlay">
                            <button type="button" class="zoom-btn" onclick="toggleBlogImageZoom()">
                                <i class="fas fa-search-plus"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="modal-footer modern-modal-footer">
                    <button type="button" class="modern-btn modern-btn-outline" data-bs-dismiss="modal">
                        Tutup
                    </button>
                    <button type="button" class="modern-btn modern-btn-primary" onclick="downloadBlogImage()">
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
    // Enhanced search functionality
    const searchInput = document.querySelector('.search-input');
    if (searchInput) {
        searchInput.addEventListener('keyup', function(e) {
            if (e.key === 'Enter') {
                this.form.submit();
            }
        });
    }

    // Handle delete button clicks
    document.addEventListener('click', function(e) {
        if (e.target.closest('.delete-btn')) {
            const button = e.target.closest('.delete-btn');
            const id = button.getAttribute('data-id');
            
            if (confirm('Apakah Anda yakin ingin menghapus blog ini?')) {
                fetch(`/admin/blog/${id}`, {
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
                        alert('Gagal menghapus blog');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Gagal menghapus blog');
                });
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

// View Blog Image Function from Data Attributes
function viewBlogImageFromData(element) {
    const imagePath = element.getAttribute('data-image');
    const title = element.getAttribute('data-title');
    const author = element.getAttribute('data-author');
    
    if (imagePath) {
        viewBlogImage(imagePath, title, author);
    }
}

// View Blog Image Function
function viewBlogImage(imagePath, title, author) {
    const modal = document.getElementById('blogImageModal');
    const image = document.getElementById('blogModalImage');
    const details = document.getElementById('blogImageDetails');
    
    // Set image source and details
    image.src = '/storage/' + imagePath;
    image.classList.remove('zoomed');
    details.textContent = `${title} • Oleh ${author}`;
    
    // Show modal
    const bootstrapModal = new bootstrap.Modal(modal);
    bootstrapModal.show();
    
    // Store current image path for download
    modal.setAttribute('data-current-image', imagePath);
    modal.setAttribute('data-current-title', title);
}

// Toggle blog image zoom function
function toggleBlogImageZoom() {
    const image = document.getElementById('blogModalImage');
    const zoomBtn = document.querySelector('.zoom-btn i');
    
    image.classList.toggle('zoomed');
    
    if (image.classList.contains('zoomed')) {
        zoomBtn.className = 'fas fa-search-minus';
    } else {
        zoomBtn.className = 'fas fa-search-plus';
    }
}

// Download blog image function
function downloadBlogImage() {
    const modal = document.getElementById('blogImageModal');
    const imagePath = modal.getAttribute('data-current-image');
    const title = modal.getAttribute('data-current-title') || 'blog-image';
    
    if (imagePath) {
        const link = document.createElement('a');
        link.href = '/storage/' + imagePath;
        link.download = `${title.replace(/\s+/g, '-').toLowerCase()}-${Date.now()}.jpg`;
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }
}
</script>
@endsection

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
    --blog-color: #8b5cf6;
    --blog-light: #ede9fe;
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

.blog-gradient {
    background: linear-gradient(135deg, var(--blog-color) 0%, #7c3aed 100%);
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

/* Blog Badge */
.blog-badge {
    background: var(--blog-light);
    border: 1px solid var(--blog-color);
    border-radius: var(--border-radius);
    padding: 6px 12px;
    display: flex;
    align-items: center;
    gap: 6px;
}

.blog-badge .badge-text {
    font-weight: 700;
    font-size: 14px;
    color: var(--blog-color);
}

.blog-badge .badge-label {
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

/* Column Widths for Blog */
.number-col { width: 60px; text-align: center; }
.image-col { width: 120px; text-align: center; }
.title-col { width: 250px; }
.content-col { width: 280px; }
.author-col { width: 180px; }
.location-col { width: 150px; }
.status-col { width: 120px; text-align: center; }
.date-col { width: 150px; }
.action-col { width: 120px; text-align: center; }

/* Table Body */
.modern-tbody tr {
    transition: all 0.2s ease;
    border-bottom: 1px solid var(--gray-100);
}

.modern-tbody tr:hover {
    background: linear-gradient(135deg, var(--blog-light) 0%, #faf5ff 100%);
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

/* Blog Image Wrapper */
.blog-image-wrapper {
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

.blog-preview-image {
    width: 80px;
    height: 60px;
    object-fit: cover;
    transition: all 0.3s ease;
}

.image-preview-container:hover .blog-preview-image {
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

/* Blog Title Wrapper */
.blog-title-wrapper {
    display: flex;
    align-items: flex-start;
    gap: 8px;
    position: relative;
}

.blog-title {
    font-weight: 600;
    color: var(--gray-900);
    font-size: 14px;
    line-height: 1.4;
    flex: 1;
}

.title-indicator {
    flex-shrink: 0;
    width: 20px;
    height: 20px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 10px;
    margin-top: 2px;
}

.title-indicator.published {
    background: var(--success-light);
    color: var(--success-color);
}

.title-indicator.draft {
    background: var(--warning-light);
    color: var(--warning-color);
}

/* Content Preview */
.content-preview {
    display: flex;
    flex-direction: column;
    gap: 4px;
}

.content-text {
    font-size: 13px;
    color: var(--gray-700);
    line-height: 1.4;
}

.content-length {
    font-size: 11px;
    color: var(--gray-500);
    font-weight: 500;
}

/* Author Info */
.author-info {
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
    background: linear-gradient(135deg, var(--blog-color) 0%, #7c3aed 100%);
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

.author-details {
    display: flex;
    flex-direction: column;
    gap: 2px;
    min-width: 0;
}

.author-name {
    font-weight: 600;
    color: var(--gray-900);
    font-size: 14px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.author-role {
    font-size: 11px;
    color: var(--gray-500);
    text-transform: uppercase;
    font-weight: 500;
    letter-spacing: 0.5px;
}

/* Location Info */
.location-info {
    display: flex;
    align-items: center;
    gap: 8px;
}

.location-icon {
    color: var(--primary-color);
    font-size: 12px;
    flex-shrink: 0;
}

.location-text {
    font-size: 13px;
    color: var(--gray-700);
    font-weight: 500;
}

.no-location {
    color: var(--gray-400);
    font-size: 14px;
    text-align: center;
}

/* Status Badge */
.status-badge {
    display: flex;
    align-items: center;
    gap: 6px;
    padding: 4px 8px;
    border-radius: 6px;
    font-size: 12px;
    font-weight: 600;
}

.status-badge.published {
    background: var(--success-light);
    color: var(--success-color);
}

.status-badge.draft {
    background: var(--warning-light);
    color: var(--warning-color);
}

.status-dot {
    width: 6px;
    height: 6px;
    border-radius: 50%;
    flex-shrink: 0;
}

.status-badge.published .status-dot {
    background: var(--success-color);
}

.status-badge.draft .status-dot {
    background: var(--warning-color);
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
    color: var(--blog-color);
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
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 16px;
}

.blog-icon {
    background: linear-gradient(135deg, var(--blog-color) 0%, #7c3aed 100%);
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

.blog-modal-image {
    max-width: 100%;
    max-height: 80vh;
    object-fit: contain;
    border-radius: 8px;
    box-shadow: var(--shadow-lg);
    transition: transform 0.3s ease;
}

.blog-modal-image.zoomed {
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
    .number-col, .location-col {
        display: none;
    }
    
    .modern-pagination {
        flex-direction: column;
        gap: 16px;
        text-align: center;
    }
    
    .author-info {
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
    
    .blog-preview-image {
        width: 60px;
        height: 45px;
    }
    
    .no-image-placeholder {
        width: 60px;
        height: 45px;
        font-size: 16px;
    }
    
    /* Hide more columns on mobile */
    .author-col, .content-col {
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
</style>
@endsection
