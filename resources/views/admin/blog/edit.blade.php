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
                            <div class="input-group">
                                <input type="text" class="form-control @error('lokasi') is-invalid @enderror" 
                                       id="lokasi" name="lokasi" value="{{ old('lokasi', $blog->lokasi) }}" 
                                       placeholder="Masukkan alamat lengkap (contoh: Jl. Veteran No.1, Malang, Jawa Timur)">
                                <button type="button" class="btn btn-outline-primary" id="search-location">
                                    <i class="fas fa-search"></i> Cari di Maps
                                </button>
                                <button type="button" class="btn btn-outline-success" id="use-current-location">
                                    <i class="fas fa-map-marker-alt"></i> Lokasi Saya
                                </button>
                            </div>
                            @error('lokasi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Masukkan alamat lengkap, atau klik "Cari di Maps" untuk mencari lokasi, atau gunakan "Lokasi Saya" untuk GPS.</small>
                            
                            <!-- Search Results -->
                            <div id="search-results" class="mt-2" style="display: none;">
                                <div class="alert alert-info">
                                    <strong>Hasil Pencarian:</strong>
                                    <div id="results-list"></div>
                                </div>
                            </div>
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
// Search location using Nominatim API (OpenStreetMap)
function searchLocation() {
    console.log('Search location clicked');
    
    const address = document.getElementById('lokasi').value.trim();
    if (!address) {
        alert('Masukkan alamat untuk dicari');
        document.getElementById('lokasi').focus();
        return;
    }
    
    console.log('Searching for address:', address);
    
    // Show loading state
    const searchBtn = document.getElementById('search-location');
    const originalText = searchBtn.innerHTML;
    searchBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Mencari...';
    searchBtn.disabled = true;
    
    // Use Nominatim API for geocoding
    const query = encodeURIComponent(address + ', Indonesia');
    const url = `https://nominatim.openstreetmap.org/search?format=json&q=${query}&limit=5&countrycodes=id`;
    
    fetch(url)
        .then(response => response.json())
        .then(data => {
            // Reset button
            searchBtn.innerHTML = originalText;
            searchBtn.disabled = false;
            
            console.log('Search results:', data);
            
            if (data && data.length > 0) {
                showSearchResults(data);
            } else {
                alert('Lokasi tidak ditemukan. Coba dengan alamat yang lebih spesifik seperti "Jalan Veteran, Malang, Jawa Timur".');
            }
        })
        .catch(error => {
            // Reset button
            searchBtn.innerHTML = originalText;
            searchBtn.disabled = false;
            
            console.error('Search error:', error);
            alert('Terjadi kesalahan saat mencari lokasi. Periksa koneksi internet Anda.');
        });
}

// Show search results
function showSearchResults(results) {
    const resultsContainer = document.getElementById('search-results');
    const resultsList = document.getElementById('results-list');
    
    resultsList.innerHTML = '';
    
    results.forEach((result, index) => {
        const resultItem = document.createElement('div');
        resultItem.className = 'result-item p-2 border rounded mb-2 cursor-pointer';
        resultItem.style.cursor = 'pointer';
        resultItem.innerHTML = `
            <strong>${result.display_name}</strong><br>
            <small class="text-muted">Lat: ${result.lat}, Lon: ${result.lon}</small>
        `;
        
        resultItem.addEventListener('click', function() {
            selectLocation(result);
        });
        
        resultsList.appendChild(resultItem);
    });
    
    resultsContainer.style.display = 'block';
}

// Select a location from search results
function selectLocation(location) {
    document.getElementById('lokasi').value = location.display_name;
    document.getElementById('search-results').style.display = 'none';
    
    // Open in Google Maps
    const mapsUrl = `https://www.google.com/maps/search/?api=1&query=${location.lat},${location.lon}`;
    window.open(mapsUrl, '_blank');
    
    alert('Lokasi berhasil dipilih! Google Maps telah dibuka di tab baru.');
}

// Use current location
function useCurrentLocation() {
    console.log('Use current location clicked');
    
    if (!navigator.geolocation) {
        alert('Geolocation tidak didukung oleh browser Anda.');
        return;
    }
    
    // Show loading state
    const currentBtn = document.getElementById('use-current-location');
    const originalText = currentBtn.innerHTML;
    currentBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Mencari...';
    currentBtn.disabled = true;
    
    navigator.geolocation.getCurrentPosition(
        function(position) {
            const lat = position.coords.latitude;
            const lon = position.coords.longitude;
            
            console.log('Current location:', lat, lon);
            
            // Reverse geocoding to get address
            const url = `https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lon}`;
            
            fetch(url)
                .then(response => response.json())
                .then(data => {
                    // Reset button
                    currentBtn.innerHTML = originalText;
                    currentBtn.disabled = false;
                    
                    if (data && data.display_name) {
                        document.getElementById('lokasi').value = data.display_name;
                        
                        // Open in Google Maps
                        const mapsUrl = `https://www.google.com/maps/search/?api=1&query=${lat},${lon}`;
                        window.open(mapsUrl, '_blank');
                        
                        alert('Lokasi saat ini berhasil didapatkan! Google Maps telah dibuka di tab baru.');
                    } else {
                        alert('Tidak dapat mendapatkan alamat dari lokasi saat ini.');
                    }
                })
                .catch(error => {
                    // Reset button
                    currentBtn.innerHTML = originalText;
                    currentBtn.disabled = false;
                    
                    console.error('Reverse geocoding error:', error);
                    
                    // Still set coordinates even if reverse geocoding fails
                    document.getElementById('lokasi').value = `${lat}, ${lon}`;
                    
                    // Open in Google Maps
                    const mapsUrl = `https://www.google.com/maps/search/?api=1&query=${lat},${lon}`;
                    window.open(mapsUrl, '_blank');
                    
                    alert('Lokasi saat ini berhasil didapatkan (koordinat)! Google Maps telah dibuka di tab baru.');
                });
        },
        function(error) {
            // Reset button
            currentBtn.innerHTML = originalText;
            currentBtn.disabled = false;
            
            console.error('Geolocation error:', error);
            alert('Tidak dapat mengakses lokasi Anda. Pastikan Anda mengizinkan akses lokasi.');
        },
        {
            enableHighAccuracy: true,
            timeout: 10000,
            maximumAge: 300000
        }
    );
}

// Event listeners
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM loaded, setting up event listeners');
    
    // Check if elements exist before adding listeners
    const searchBtn = document.getElementById('search-location');
    const currentLocationBtn = document.getElementById('use-current-location');
    const lokasiInput = document.getElementById('lokasi');
    
    if (searchBtn) {
        searchBtn.addEventListener('click', function(e) {
            e.preventDefault();
            console.log('Search button clicked');
            searchLocation();
        });
    }
    
    if (currentLocationBtn) {
        currentLocationBtn.addEventListener('click', function(e) {
            e.preventDefault();
            console.log('Current location button clicked');
            useCurrentLocation();
        });
    }
    
    // Allow Enter key to search
    if (lokasiInput) {
        lokasiInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                searchLocation();
            }
        });
    }
    
    // Hide search results when clicking outside
    document.addEventListener('click', function(e) {
        const searchResults = document.getElementById('search-results');
        const lokasiInput = document.getElementById('lokasi');
        const searchBtn = document.getElementById('search-location');
        
        if (searchResults && 
            !searchResults.contains(e.target) && 
            e.target !== lokasiInput && 
            e.target !== searchBtn) {
            searchResults.style.display = 'none';
        }
    });
    
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
});
</script>
@endsection
