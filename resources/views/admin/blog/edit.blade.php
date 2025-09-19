@extends('layouts.admin')

@section('title', 'Edit Blog')

@section('page-title', 'Edit Blog')

@section('content')
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Edit Blog</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.blog.update', $blog->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="judul" class="form-label">Judul Blog <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('judul') is-invalid @enderror" 
                                   id="judul" name="judul" value="{{ old('judul', $blog->judul) }}" required>
                            @error('judul')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="penulis" class="form-label">Penulis</label>
                            <input type="text" class="form-control @error('penulis') is-invalid @enderror" 
                                   id="penulis" name="penulis" value="{{ old('penulis', $blog->penulis) }}" 
                                   placeholder="Kosongkan untuk menggunakan nama admin">
                            @error('penulis')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Jika kosong, akan menggunakan nama admin yang sedang login.</small>
                        </div>

                        <div class="mb-3">
                            <label for="lokasi" class="form-label">Lokasi Wisata</label>
                            <input type="text" class="form-control @error('lokasi') is-invalid @enderror" 
                                   id="lokasi" name="lokasi" value="{{ old('lokasi', $blog->lokasi) }}" 
                                   placeholder="Contoh: Malang, Jawa Timur">
                            @error('lokasi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Alamat atau lokasi tempat wisata (opsional).</small>
                        </div>

                        <div class="mb-3">
                            <label for="gambar" class="form-label">Gambar Blog</label>
                            @if($blog->gambar)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $blog->gambar) }}" 
                                         alt="Current Image" 
                                         class="img-thumbnail" 
                                         style="max-width: 200px; max-height: 150px;">
                                    <p class="small text-muted mt-1">Gambar saat ini</p>
                                </div>
                            @endif
                            <input type="file" class="form-control @error('gambar') is-invalid @enderror" 
                                   id="gambar" name="gambar" accept="image/*">
                            @error('gambar')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Format: JPG, PNG, GIF. Maksimal 2MB. Kosongkan jika tidak ingin mengubah gambar.</small>
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="published" name="published" value="1" 
                                       {{ old('published', $blog->published) ? 'checked' : '' }}>
                                <label class="form-check-label" for="published">
                                    Publikasikan Blog
                                </label>
                            </div>
                            <small class="form-text text-muted">Centang untuk mempublikasikan blog, hapus centang untuk menyimpan sebagai draft.</small>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="isi" class="form-label">Isi Blog <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('isi') is-invalid @enderror" 
                                      id="isi" name="isi" rows="12" required
                                      placeholder="Tulis isi blog di sini...">{{ old('isi', $blog->isi) }}</textarea>
                            @error('isi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Anda dapat menggunakan HTML untuk formatting.</small>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-12">
                        <div class="d-flex justify-content-end">
                            <a href="{{ route('admin.blog') }}" class="btn btn-secondary me-2">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-warning">
                                <i class="fas fa-save"></i> Update Blog
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
                    <img src="${e.target.result}" class="img-thumbnail" style="max-width: 200px; max-height: 150px;">
                    <p class="small text-muted mt-1">Preview gambar baru</p>
                `;
            };
            reader.readAsDataURL(file);
        }
    });

    // Auto-resize textarea
    const textarea = document.getElementById('isi');
    textarea.addEventListener('input', function() {
        this.style.height = 'auto';
        this.style.height = this.scrollHeight + 'px';
    });

    // Character counter for title
    const judulInput = document.getElementById('judul');
    const judulCounter = document.createElement('small');
    judulCounter.className = 'form-text text-muted';
    judulInput.parentNode.appendChild(judulCounter);
    
    function updateJudulCounter() {
        const length = judulInput.value.length;
        judulCounter.textContent = `${length}/255 karakter`;
        if (length > 200) {
            judulCounter.className = 'form-text text-warning';
        } else {
            judulCounter.className = 'form-text text-muted';
        }
    }
    
    judulInput.addEventListener('input', updateJudulCounter);
    updateJudulCounter();
</script>
@endsection
