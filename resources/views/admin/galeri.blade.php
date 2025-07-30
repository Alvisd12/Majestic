@extends('layouts.admin')

@section('title', 'Galeri')

@section('page-title', 'Galeri')

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
        <form method="GET" action="{{ route('admin.galeri') }}" class="flex-grow-1 me-3">
            <div class="search-box">
                <input type="text" class="form-control" name="search" 
                       placeholder="Search here..." value="{{ request('search') }}">
                <i class="fas fa-search"></i>
            </div>
        </form>
        <a href="{{ route('admin.galeri.create') }}" class="btn btn-warning">
            <i class="fas fa-plus text-white"></i>
            <span class="text-white">Tambah</span>
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
                        <th>Deskripsi</th>
                        <th>Tanggal Sewa</th>
                        <th>Tanggal Upload</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($galeri as $index => $item)
                    <tr>
                        <td>{{ $galeri->firstItem() + $index }}.</td>
                        <td>
                            @if($item->gambar)
                                <img src="{{ asset('storage/' . $item->gambar) }}" 
                                     alt="Galeri Image" 
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
                            <div class="text-truncate" style="max-width: 200px;" title="{{ $item->deskripsi }}">
                                {{ $item->deskripsi ?: 'Lorem Ipsum is simply dummy text' }}
                            </div>
                        </td>
                        <td>{{ \Carbon\Carbon::parse($item->tanggal_sewa)->format('M d, Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->created_at)->format('M d, Y') }}</td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('admin.galeri.edit', $item->id) }}" 
                                   class="btn btn-sm btn-outline-primary" 
                                   title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" class="btn btn-sm btn-outline-danger" 
                                        onclick="deleteGaleri({{ $item->id }})" 
                                        title="Delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-4">
                            <i class="fas fa-images fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Tidak ada data galeri</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        @if($galeri->hasPages())
        <div class="pagination-container">
            {{ $galeri->appends(request()->query())->links() }}
        </div>
        @endif
    </div>
@endsection

@section('additional-scripts')
<script>
    // Delete Galeri Function
    function deleteGaleri(id) {
        if (confirm('Apakah Anda yakin ingin menghapus item galeri ini?')) {
            fetch(`/admin/galeri/${id}`, {
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
                    alert('Gagal menghapus item galeri');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Gagal menghapus item galeri');
            });
        }
    }

    // Auto-submit search form on input
    document.querySelector('input[name="search"]').addEventListener('keyup', function(e) {
        if (e.key === 'Enter') {
            this.form.submit();
        }
    });
</script>
@endsection 