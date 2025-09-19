@extends('layouts.admin')

@section('title', 'Blog')

@section('page-title', 'Blog')

@section('content')
    <!-- Success Notification -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Search and Add Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <form method="GET" action="{{ route('admin.blog') }}" class="flex-grow-1 me-3">
            <div class="search-box">
                <input type="text" class="form-control" name="search" 
                       placeholder="Search blog..." value="{{ request('search') }}">
                <i class="fas fa-search"></i>
            </div>
        </form>
        <a href="{{ route('admin.blog.create') }}" class="btn btn-warning">
            <i class="fas fa-plus text-white"></i>
            <span class="text-white">Tambah Blog</span>
        </a>
    </div>

    <!-- Data Table -->
    <div class="data-table">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Gambar</th>
                        <th>Judul</th>
                        <th>Isi</th>
                        <th>Penulis</th>
                        <th>Lokasi</th>
                        <th>Status</th>
                        <th>Tanggal Dibuat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($blogs as $index => $blog)
                    <tr>
                        <td>{{ $blogs->firstItem() + $index }}.</td>
                        <td>
                            @if($blog->gambar)
                                <img src="{{ asset('storage/' . $blog->gambar) }}" 
                                     alt="Blog Image" 
                                     class="img-thumbnail" 
                                     style="width: 80px; height: 60px; object-fit: cover;">
                            @else
                                <div class="bg-secondary d-flex align-items-center justify-content-center" 
                                     style="width: 80px; height: 60px;">
                                    <i class="fas fa-image text-white"></i>
                                </div>
                            @endif
                        </td>
                        <td>
                            <div class="text-truncate" style="max-width: 200px;" title="{{ $blog->judul }}">
                                {{ $blog->judul }}
                            </div>
                        </td>
                        <td>
                            <div class="text-truncate" style="max-width: 250px;" title="{{ strip_tags($blog->isi) }}">
                                {{ Str::limit(strip_tags($blog->isi), 100) }}
                            </div>
                        </td>
                        <td>{{ $blog->penulis ?? $blog->admin->nama ?? 'Admin' }}</td>
                        <td>
                            @if($blog->lokasi)
                                <div class="text-truncate" style="max-width: 150px;" title="{{ $blog->lokasi }}">
                                    <i class="fas fa-map-marker-alt text-primary"></i> {{ $blog->lokasi }}
                                </div>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            @if($blog->published)
                                <span class="badge bg-success">Published</span>
                            @else
                                <span class="badge bg-warning">Draft</span>
                            @endif
                        </td>
                        <td>{{ $blog->created_at->format('M d, Y') }}</td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('admin.blog.edit', $blog->id) }}" 
                                   class="btn btn-sm btn-outline-primary" 
                                   title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" class="btn btn-sm btn-outline-danger delete-btn" 
                                        data-id="{{ $blog->id }}" 
                                        title="Delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center py-4">
                            <i class="fas fa-blog fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Tidak ada data blog</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        @if($blogs->hasPages())
        <div class="pagination-container">
            {{ $blogs->appends(request()->query())->links() }}
        </div>
        @endif
    </div>
@endsection

@section('additional-scripts')
<script>
    // Delete Blog Function using event delegation
    document.addEventListener('DOMContentLoaded', function() {
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

        // Auto-submit search form on input
        const searchInput = document.querySelector('input[name="search"]');
        if (searchInput) {
            searchInput.addEventListener('keyup', function(e) {
                if (e.key === 'Enter') {
                    this.form.submit();
                }
            });
        }
    });
</script>
@endsection
