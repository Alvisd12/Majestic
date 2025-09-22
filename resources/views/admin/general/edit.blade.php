@extends('layouts.admin')

@section('title', 'Edit Pengaturan Umum')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Edit Pengaturan Umum</h3>
                    <a href="{{ route('admin.general.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
                <div class="card-body">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.general.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="persyaratan" class="form-label">Persyaratan <span class="text-danger">*</span></label>
                                    <textarea class="form-control" id="persyaratan" name="persyaratan" rows="6" required>{{ old('persyaratan', $general->persyaratan) }}</textarea>
                                    <div class="form-text">Masukkan persyaratan untuk penyewaan motor</div>
                                </div>

                                <div class="mb-3">
                                    <label for="jam_operasional" class="form-label">Jam Operasional <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="jam_operasional" name="jam_operasional" 
                                           value="{{ old('jam_operasional', $general->jam_operasional) }}" 
                                           placeholder="Contoh: Senin - Minggu, 08:00 - 17:00" required>
                                    <div class="form-text">Masukkan jam operasional rental</div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="lokasi" class="form-label">Lokasi <span class="text-danger">*</span></label>
                                    <textarea class="form-control" id="lokasi" name="lokasi" rows="4" required>{{ old('lokasi', $general->lokasi) }}</textarea>
                                    <div class="form-text">Masukkan alamat lengkap rental</div>
                                </div>

                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.general.index') }}" class="btn btn-secondary">Batal</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan Pengaturan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-resize textareas
    const textareas = document.querySelectorAll('textarea');
    textareas.forEach(textarea => {
        textarea.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = this.scrollHeight + 'px';
        });
        
        // Initial resize
        textarea.style.height = 'auto';
        textarea.style.height = textarea.scrollHeight + 'px';
    });
});
</script>
@endsection
