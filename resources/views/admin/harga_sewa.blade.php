@extends('layouts.admin')

@section('title', 'Harga Sewa')

@section('page-title', 'Harga Sewa')

@section('content')
    <!-- Search and Add Button Row -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <!-- Search Box -->
                <form method="GET" action="{{ route('admin.harga_sewa') }}" class="d-flex align-items-center">
                    <div class="search-box me-3">
                        <input type="text" class="form-control" name="search" 
                               placeholder="Search here..." value="{{ request('search') }}">
                        <i class="fas fa-search"></i>
                    </div>
                </form>
                
                <!-- Add Button -->
                <button class="add-button" onclick="addMotor()">
                    <i class="fas fa-plus"></i>
                    Tambah
                </button>
            </div>

            <!-- Data Table -->
            <div class="data-table">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Gambar</th>
                                <th>Jenis Motor</th>
                                <th>Plat Motor</th>
                                <th>Warna Motor</th>
                                <th>Harga</th>
                                <th>Deskripsi</th>
                                <th>Tanggal Upload</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($motors as $index => $motor)
                            <tr>
                                <td>{{ $motors->firstItem() + $index }}.</td>
                                <td>
                                    <div class="motor-image">
                                        @if($motor->foto)
                                            <img src="{{ asset('storage/' . $motor->foto) }}" alt="{{ $motor->merk }} {{ $motor->model }}">
                                        @else
                                            <i class="fas fa-motorcycle"></i>
                                        @endif
                                    </div>
                                </td>
                                <td class="fw-bold">{{ $motor->merk }} {{ $motor->model }}</td>
                                <td class="text-primary">{{ $motor->plat_nomor }}</td>
                                <td class="text-muted">{{ $motor->warna ?: 'Hitam' }}</td>
                                <td>
                                    <span class="price-badge">
                                        Rp {{ number_format($motor->harga_per_hari, 0, ',', '.') }}
                                    </span>
                                </td>
                                <td class="text-muted">
                                    {{ Str::limit($motor->deskripsi ?: 'Motor ' . $motor->merk . ' ' . $motor->model . ' tahun ' . $motor->tahun, 50) }}
                                </td>
                                <td class="text-muted">{{ $motor->created_at->format('M d, Y') }}</td>
                                <td>
                                    <button class="action-btn btn-edit" onclick="editMotor({{ $motor->id }})">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="action-btn btn-delete" onclick="deleteMotor({{ $motor->id }})">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9" class="text-center py-4">
                                    <i class="fas fa-motorcycle fa-3x text-muted mb-3"></i>
                                    <p class="text-muted">Tidak ada data motor</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                @if($motors->hasPages())
                <div class="pagination-container">
                    {{ $motors->appends(request()->query())->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>

@endsection

@section('additional-scripts')
<script>
    // Add Motor Function
    function addMotor() {
        // Redirect to motor create page or show modal
        window.location.href = '{{ route("admin.motor.create") }}';
    }

    // Edit Motor Function
    function editMotor(id) {
        // Redirect to motor edit page
        window.location.href = `/admin/motor/${id}/edit`;
    }

    // Delete Motor Function
    function deleteMotor(id) {
        if (confirm('Apakah Anda yakin ingin menghapus motor ini?')) {
            fetch(`/admin/motor/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Gagal menghapus motor');
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