@extends('layouts.admin')

@section('title', 'Admin Accounts')

@section('page-title', 'Admin Accounts')

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
        <form method="GET" action="{{ route('admin.admin_accounts') }}" class="flex-grow-1 me-3">
            <div class="search-box">
                <input type="text" class="form-control" name="search" 
                       placeholder="Search admin accounts..." value="{{ request('search') }}">
                <i class="fas fa-search"></i>
            </div>
        </form>
        <a href="{{ route('admin.admin_accounts.create') }}" class="btn btn-warning">
            <i class="fas fa-plus text-white"></i>
            <span class="text-white">Tambah Admin</span>
        </a>
    </div>

    <!-- Data Table -->
    <div class="data-table">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Avatar</th>
                        <th>Nama</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Role</th>
                        <th>Tanggal Dibuat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($admins as $index => $admin)
                    <tr>
                        <td>{{ $admins->firstItem() + $index }}.</td>
                        <td>
                            <div class="admin-avatar">
                                <div class="bg-primary d-flex align-items-center justify-content-center rounded-circle" 
                                     style="width: 40px; height: 40px;">
                                    <i class="fas fa-user text-white"></i>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="fw-semibold">{{ $admin->nama }}</div>
                        </td>
                        <td>{{ $admin->username }}</td>
                        <td>{{ $admin->email ?: '-' }}</td>
                        <td>{{ $admin->phone }}</td>
                        <td>
                            <span class="badge {{ $admin->role === 'super_admin' ? 'bg-danger' : 'bg-primary' }}">
                                {{ ucfirst(str_replace('_', ' ', $admin->role)) }}
                            </span>
                        </td>
                        <td>{{ \Carbon\Carbon::parse($admin->created_at)->format('M d, Y') }}</td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('admin.admin_accounts.edit', $admin->id) }}" 
                                   class="btn btn-sm btn-outline-primary" 
                                   title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" class="btn btn-sm btn-outline-danger delete-admin-btn" 
                                        data-id="{{ $admin->id }}" 
                                        title="Delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center py-4">
                            <i class="fas fa-users fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Tidak ada data admin</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        @if($admins->hasPages())
        <div class="pagination-container">
            {{ $admins->appends(request()->query())->links() }}
        </div>
        @endif
    </div>
@endsection

@section('additional-scripts')
<script>
    // Delete Admin Function using event delegation
    document.addEventListener('DOMContentLoaded', function() {
        // Handle delete button clicks
        document.addEventListener('click', function(e) {
            if (e.target.closest('.delete-admin-btn')) {
                const button = e.target.closest('.delete-admin-btn');
                const id = button.getAttribute('data-id');
                
                if (confirm('Apakah Anda yakin ingin menghapus admin ini?')) {
                    fetch(`/admin/admin-accounts/${id}`, {
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
                            alert(data.message || 'Gagal menghapus admin');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Gagal menghapus admin');
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
