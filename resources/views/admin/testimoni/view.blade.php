@extends('layouts.admin')

@section('title', 'Detail Testimoni')

@section('page-title', 'Detail Testimoni')

@section('content')
    <div class="d-flex align-items-center mb-4">
        <a href="{{ route('admin.testimoni') }}" class="btn btn-outline-primary me-3">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
        <h4 class="mb-0">Detail Testimoni</h4>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Informasi Testimoni</h5>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <label class="form-label fw-bold">Pengunjung</label>
                        <div class="d-flex align-items-center mt-2">
                            <div class="bg-primary d-flex align-items-center justify-content-center rounded-circle me-3" 
                                 style="width: 50px; height: 50px;">
                                <i class="fas fa-user text-white fa-lg"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">{{ $testimoni->pengunjung->nama ?? 'Unknown' }}</h6>
                                <small class="text-muted">{{ $testimoni->pengunjung->username ?? '-' }}</small>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Pesan Testimoni</label>
                        <div class="mt-2 p-3 bg-light rounded">
                            {{ $testimoni->pesan }}
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Rating</label>
                        <div class="mt-2">
                            <div class="rating-stars text-warning fs-4">
                                {!! $testimoni->rating_stars !!}
                            </div>
                            <small class="text-muted">({{ $testimoni->rating }}/5)</small>
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-danger delete-btn" data-id="{{ $testimoni->id }}">
                            <i class="fas fa-trash"></i> Hapus
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Detail Testimoni</h5>
                </div>
                <div class="card-body">
                    <div class="text-center mb-3">
                        <div class="bg-primary d-flex align-items-center justify-content-center rounded-circle mx-auto" 
                             style="width: 60px; height: 60px;">
                            <i class="fas fa-star text-white fa-2x"></i>
                        </div>
                        <h6 class="mt-2 mb-0">{{ $testimoni->pengunjung->nama ?? 'Unknown' }}</h6>
                        <small class="text-muted">{{ $testimoni->pengunjung->username ?? '-' }}</small>
                    </div>
                    
                    <div class="info-item d-flex justify-content-between mb-2">
                        <strong>Rating Saat Ini:</strong>
                        <span class="text-warning">{!! $testimoni->rating_stars !!}</span>
                    </div>
                    <div class="info-item d-flex justify-content-between mb-2">
                        <strong>Dibuat:</strong>
                        <span>{{ $testimoni->created_at->format('d M Y H:i') }}</span>
                    </div>
                    <div class="info-item d-flex justify-content-between">
                        <strong>Diperbarui:</strong>
                        <span>{{ $testimoni->updated_at->format('d M Y H:i') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('additional-scripts')
<script>
// Delete testimoni
$(document).on('click', '.delete-btn', function() {
    const id = $(this).data('id');
    
    Swal.fire({
        title: 'Hapus Testimoni?',
        text: 'Data testimoni akan dihapus permanen',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Hapus',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: `/admin/testimoni/${id}`,
                type: 'DELETE',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content')
                }
            })
            .done(function(response) {
                Swal.fire('Berhasil!', 'Testimoni berhasil dihapus', 'success')
                .then(() => window.location.href = '{{ route("admin.testimoni") }}');
            })
            .fail(function() {
                Swal.fire('Error!', 'Terjadi kesalahan', 'error');
            });
        }
    });
});
</script>
@endsection
