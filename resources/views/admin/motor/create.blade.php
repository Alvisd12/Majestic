@extends('layouts.admin')

@section('title', 'Tambah Motor')

@section('page-title', 'Tambah Motor')

@section('content')
    <div class="form-card">
        <form action="{{ route('admin.motor.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="merk" class="form-label">Merk Motor *</label>
                    <input type="text" class="form-control @error('merk') is-invalid @enderror" 
                           id="merk" name="merk" value="{{ old('merk') }}" required>
                    @error('merk')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-6 mb-3">
                    <label for="model" class="form-label">Model Motor *</label>
                    <input type="text" class="form-control @error('model') is-invalid @enderror" 
                           id="model" name="model" value="{{ old('model') }}" required>
                    @error('model')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="jenis_motor" class="form-label">Jenis Motor *</label>
                    <select class="form-control @error('jenis_motor') is-invalid @enderror" 
                            id="jenis_motor" name="jenis_motor" required>
                        <option value="">Pilih Jenis Motor</option>
                        <option value="Matic" {{ old('jenis_motor') == 'Matic' ? 'selected' : '' }}>Matic</option>
                        <option value="Manual" {{ old('jenis_motor') == 'Manual' ? 'selected' : '' }}>Manual</option>
                        <option value="Sport" {{ old('jenis_motor') == 'Sport' ? 'selected' : '' }}>Sport</option>
                    </select>
                    @error('jenis_motor')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-6 mb-3">
                    <label for="warna" class="form-label">Warna</label>
                    <input type="text" class="form-control @error('warna') is-invalid @enderror" 
                           id="warna" name="warna" value="{{ old('warna') }}">
                    @error('warna')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="tahun" class="form-label">Tahun *</label>
                    <input type="number" class="form-control @error('tahun') is-invalid @enderror" 
                           id="tahun" name="tahun" value="{{ old('tahun') }}" 
                           min="1990" max="{{ date('Y') + 1 }}" required>
                    @error('tahun')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-6 mb-3">
                    <label for="plat_nomor" class="form-label">Plat Nomor *</label>
                    <input type="text" class="form-control @error('plat_nomor') is-invalid @enderror" 
                           id="plat_nomor" name="plat_nomor" value="{{ old('plat_nomor') }}" required>
                    @error('plat_nomor')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="harga_per_hari" class="form-label">Harga per Hari *</label>
                    <div class="input-group">
                        <span class="input-group-text">Rp</span>
                        <input type="number" class="form-control @error('harga_per_hari') is-invalid @enderror" 
                               id="harga_per_hari" name="harga_per_hari" value="{{ old('harga_per_hari') }}" 
                               min="0" step="1000" required>
                    </div>
                    @error('harga_per_hari')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-6 mb-3">
                    <label for="foto" class="form-label">Foto Motor</label>
                    <input type="file" class="form-control @error('foto') is-invalid @enderror" 
                           id="foto" name="foto" accept="image/*">
                    <small class="text-muted">Format: JPG, JPEG, PNG. Maksimal 2MB</small>
                    @error('foto')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="mb-3">
                <label for="deskripsi" class="form-label">Deskripsi</label>
                <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                          id="deskripsi" name="deskripsi" rows="4">{{ old('deskripsi') }}</textarea>
                @error('deskripsi')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="d-flex gap-3">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i>Simpan
                </button>
                <a href="{{ route('admin.harga_sewa') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Kembali
                </a>
            </div>
        </form>
    </div>
@endsection 