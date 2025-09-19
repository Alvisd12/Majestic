@extends('layouts.admin')

@section('title', 'Edit Galeri')

@section('page-title', 'Edit Galeri')

@section('content')
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Edit Item Galeri</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.galeri.update', $galeri->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="gambar" class="form-label">Gambar</label>
                            <input type="file" class="form-control @error('gambar') is-invalid @enderror" 
                                   id="gambar" name="gambar" accept="image/*">
                            @error('gambar')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Format: JPG, PNG, GIF. Maksimal 2MB. Kosongkan jika tidak ingin mengubah gambar.</small>
                            
                            @if($galeri->gambar)
                                <div class="mt-2">
                                    <label class="form-label">Gambar Saat Ini:</label>
                                    <img src="{{ asset('storage/' . $galeri->gambar) }}" 
                                         alt="Current Image" 
                                         class="img-thumbnail d-block" 
                                         style="max-width: 200px; max-height: 150px;">
                                </div>
                            @endif
                        </div>
                        
                        <div class="mb-3">
                            <label for="tanggal_sewa" class="form-label">Tanggal Sewa (Opsional)</label>
                            <input type="date" class="form-control @error('tanggal_sewa') is-invalid @enderror" 
                                   id="tanggal_sewa" name="tanggal_sewa" 
                                   value="{{ old('tanggal_sewa', $galeri->tanggal_sewa) }}">
                            @error('tanggal_sewa')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-12">
                        <div class="d-flex justify-content-end">
                            <a href="{{ route('admin.galeri') }}" class="btn btn-secondary me-2">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-warning">
                                <i class="fas fa-save"></i> Update
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('additional-scripts')
<script>
    // Preview image before upload
    document.getElementById('gambar').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                // Create preview if not exists
                let preview = document.getElementById('image-preview');
                if (!preview) {
                    preview = document.createElement('div');
                    preview.id = 'image-preview';
                    preview.className = 'mt-2';
                    document.getElementById('gambar').parentNode.appendChild(preview);
                }
                preview.innerHTML = `
                    <label class="form-label">Preview Gambar Baru:</label>
                    <img src="${e.target.result}" class="img-thumbnail d-block" style="max-width: 200px; max-height: 150px;">
                `;
            };
            reader.readAsDataURL(file);
        }
    });
</script>
@endsection 