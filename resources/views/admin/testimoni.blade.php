@extends('layouts.admin')

@section('title', 'Testimoni')

@section('page-title', 'Testimoni')

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
        <form method="GET" action="{{ route('admin.testimoni') }}" class="flex-grow-1 me-3">
            <div class="search-box">
                <input type="text" class="form-control" name="search" 
                       placeholder="Search testimoni..." value="{{ request('search') }}">
                <i class="fas fa-search"></i>
            </div>
        </form>
    </div>

    <!-- Data Table -->
    <div class="data-table">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Pengunjung</th>
                        <th>Pesan</th>
                        <th>Rating</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($testimoni as $index => $item)
                    <tr>
                        <td>{{ $testimoni->firstItem() + $index }}.</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="bg-primary d-flex align-items-center justify-content-center rounded-circle me-2" 
                                     style="width: 35px; height: 35px;">
                                    <i class="fas fa-user text-white"></i>
                                </div>
                                <div>
                                    <div class="fw-semibold">{{ $item->pengunjung->nama ?? 'Unknown' }}</div>
                                    <small class="text-muted">{{ $item->pengunjung->username ?? '-' }}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="text-truncate" style="max-width: 300px;" title="{{ $item->pesan }}">
                                {{ $item->pesan }}
                            </div>
                        </td>
                        <td>
                            <div class="rating-stars text-warning">
                                {!! $item->rating_stars !!}
                            </div>
                            <small class="text-muted">({{ $item->rating }}/5)</small>
                        </td>
                        <td>{{ \Carbon\Carbon::parse($item->created_at)->format('M d, Y') }}</td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('admin.testimoni.show', $item->id) }}" 
                                   class="btn btn-sm btn-outline-info" 
                                   title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <button type="button" class="btn btn-sm btn-outline-danger delete-testimoni-btn" 
                                        data-id="{{ $item->id }}" 
                                        title="Delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-4">
                            <i class="fas fa-star fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Tidak ada data testimoni</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        @if($testimoni->hasPages())
        <div class="pagination-container">
            {{ $testimoni->appends(request()->query())->links() }}
        </div>
        @endif
    </div>
@endsection

@section('additional-scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Handle approve button clicks
        document.addEventListener('click', function(e) {
            if (e.target.closest('.approve-btn')) {
                const button = e.target.closest('.approve-btn');
                const id = button.getAttribute('data-id');
                
                if (confirm('Apakah Anda yakin ingin menyetujui testimoni ini?')) {
                    fetch(`/admin/testimoni/${id}/approve`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            location.reload();
                        } else {
                            alert(data.message || 'Gagal menyetujui testimoni');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Gagal menyetujui testimoni');
                    });
                }
            }
        });

        // Handle reject button clicks
        document.addEventListener('click', function(e) {
            if (e.target.closest('.reject-btn')) {
                const button = e.target.closest('.reject-btn');
                const id = button.getAttribute('data-id');
                
                if (confirm('Apakah Anda yakin ingin menolak testimoni ini?')) {
                    fetch(`/admin/testimoni/${id}/reject`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            location.reload();
                        } else {
                            alert(data.message || 'Gagal menolak testimoni');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Gagal menolak testimoni');
                    });
                }
            }
        });

        // Handle delete button clicks
        document.addEventListener('click', function(e) {
            if (e.target.closest('.delete-testimoni-btn')) {
                const button = e.target.closest('.delete-testimoni-btn');
                const id = button.getAttribute('data-id');
                
                if (confirm('Apakah Anda yakin ingin menghapus testimoni ini?')) {
                    fetch(`/admin/testimoni/${id}`, {
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
                            alert(data.message || 'Gagal menghapus testimoni');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Gagal menghapus testimoni');
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
