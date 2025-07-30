@extends('layouts.admin')

@section('title', 'Edit Motor')

@section('page-title', 'Edit Motor')

@section('content')
    <div class="form-card">
        <form action="{{ route('admin.motor.update', $motor->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="merk" class="form-label">Merk Motor *</label>
                    <input type="text" class="form-control @error('merk') is-invalid @enderror" 
                           id="merk" name="merk" value="{{ old('merk', $motor->merk) }}" required>
                    @error('merk')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-6 mb-3">
                    <label for="model" class="form-label">Model Motor *</label>
                    <input type="text" class="form-control @error('model') is-invalid @enderror" 
                           id="model" name="model" value="{{ old('model', $motor->model) }}" required>
                    @error('model')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="tahun" class="form-label">Tahun *</label>
                    <input type="number" class="form-control @error('tahun') is-invalid @enderror" 
                           id="tahun" name="tahun" value="{{ old('tahun', $motor->tahun) }}" 
                           min="1990" max="{{ date('Y') + 1 }}" required>
                    @error('tahun')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-4 mb-3">
                    <label for="plat_nomor" class="form-label">Plat Nomor *</label>
                    <input type="text" class="form-control @error('plat_nomor') is-invalid @enderror" 
                           id="plat_nomor" name="plat_nomor" value="{{ old('plat_nomor', $motor->plat_nomor) }}" required>
                    @error('plat_nomor')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-4 mb-3">
                    <label for="warna" class="form-label">Warna</label>
                    <input type="text" class="form-control @error('warna') is-invalid @enderror" 
                           id="warna" name="warna" value="{{ old('warna', $motor->warna) }}">
                    @error('warna')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="harga_per_hari" class="form-label">Harga per Hari *</label>
                    <div class="input-group">
                        <span class="input-group-text">Rp</span>
                        <input type="number" class="form-control @error('harga_per_hari') is-invalid @enderror" 
                               id="harga_per_hari" name="harga_per_hari" value="{{ old('harga_per_hari', $motor->harga_per_hari) }}" 
                               min="0" step="1000" required>
                    </div>
                    @error('harga_per_hari')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-4 mb-3">
                    <label for="status" class="form-label">Status *</label>
                    <select class="form-control @error('status') is-invalid @enderror" id="status" name="status" required>
                        <option value="Tersedia" {{ old('status', $motor->status) == 'Tersedia' ? 'selected' : '' }}>Tersedia</option>
                        <option value="Disewa" {{ old('status', $motor->status) == 'Disewa' ? 'selected' : '' }}>Disewa</option>
                        <option value="Maintenance" {{ old('status', $motor->status) == 'Maintenance' ? 'selected' : '' }}>Maintenance</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-4 mb-3">
                    <label for="foto" class="form-label">Foto Motor</label>
                    <input type="file" class="form-control @error('foto') is-invalid @enderror" 
                           id="foto" name="foto" accept="image/*">
                    <small class="text-muted">Format: JPG, JPEG, PNG. Maksimal 2MB</small>
                    @error('foto')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    
                    @if($motor->foto)
                        <div class="mt-2">
                            <label class="form-label">Foto Saat Ini:</label>
                            <img src="{{ asset('storage/' . $motor->foto) }}" alt="Current Photo" class="current-photo">
                        </div>
                    @endif
                </div>
            </div>
            
            <div class="mb-3">
                <label for="deskripsi" class="form-label">Deskripsi</label>
                <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                          id="deskripsi" name="deskripsi" rows="4">{{ old('deskripsi', $motor->deskripsi) }}</textarea>
                @error('deskripsi')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="d-flex gap-3">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i>Update
                </button>
                <a href="{{ route('admin.harga_sewa') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Kembali
                </a>
            </div>
        </form>
    </div>
@endsection 