@extends('layouts.admin')

@section('title', 'Admin Profile')

@section('page-title', 'Profile Settings')

@section('content')
<div class="min-vh-100 bg-white py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-10">
                <!-- Header Section -->
                <div class="text-center mb-5">
                    <h2 class="display-6 fw-bold text-black mb-2">Profil Admin</h2>
                    <p class="text-black">Kelola pengaturan akun admin dan preferensi Anda</p>
                </div>

                <!-- Main Profile Card -->
                <div class="card border-0 shadow-lg rounded-4 overflow-hidden mb-4">
                    <div class="card-body p-0">
                        <!-- Alert Messages -->
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show m-4 mb-0 rounded-3 border-0" role="alert">
                                <i class="fas fa-check-circle me-2 text-warning"></i><span class="text-black">{{ session('success') }}</span>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if($errors->any())
                            <div class="alert alert-danger m-4 mb-0 rounded-3 border-0">
                                <i class="fas fa-exclamation-circle me-2 text-warning"></i>
                                <strong class="text-black">Harap perbaiki kesalahan berikut:</strong>
                                <ul class="mb-0 mt-2 text-black">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <!-- Profile Header with Photo -->
                        <div class="bg-gradient-to-r from-gray-800 to-black text-white p-4">
                            <div class="row align-items-center">
                                <div class="col-md-auto">
                                    <div class="position-relative">
                                        @if($admin->profile_photo)
                                            <img src="{{ asset('storage/' . $admin->profile_photo) }}" 
                                                 alt="Profile Photo" 
                                                 class="rounded-circle border border-4 border-white shadow-lg" 
                                                 style="width: 120px; height: 120px; object-fit: cover;"
                                                 id="profile-photo-preview">
                                        @else
                                            <div class="rounded-circle bg-white bg-opacity-20 d-flex align-items-center justify-content-center border border-4 border-white shadow-lg" 
                                                 style="width: 120px; height: 120px;"
                                                 id="profile-photo-preview">
                                                <i class="fas fa-user text-warning fa-3x"></i>
                                            </div>
                                        @endif
                                        <div class="position-absolute bottom-0 end-0">
                                            <button class="btn btn-light btn-sm rounded-circle p-2 shadow" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#photoModal">
                                                <i class="fas fa-camera text-warning"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <h3 class="mb-1 fw-bold text-white">{{ $admin->nama }}</h3>
                                    <p class="mb-2 text-white">{{ $admin->email }}</p>
                                    <div class="d-flex align-items-center">
                                        <span class="badge bg-warning px-3 py-2 rounded-pill me-3 text-black fw-bold">
                                            <i class="fas fa-crown me-1"></i>{{ ucfirst($admin->role ?? 'Administrator') }}
                                        </span>
                                        <span class="small opacity-75 text-white">
                                            <i class="fas fa-calendar-alt me-1 text-warning"></i>
                                            Bergabung sejak {{ \Carbon\Carbon::parse($admin->created_at)->format('M Y') }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Profile Form -->
                        <div class="p-4">
                            <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                
                                <!-- Personal Information Section -->
                                <div class="mb-5">
                                    <h5 class="fw-bold text-black mb-4">
                                        <i class="fas fa-user text-warning me-2"></i>Informasi Pribadi
                                    </h5>
                                    
                                    <div class="row g-4">
                                        <div class="col-md-6">
                                            <div class="form-floating">
                                                <input type="text" class="form-control border-0 bg-light rounded-3 text-black" 
                                                       id="nama" name="nama" placeholder="Nama Lengkap"
                                                       value="{{ old('nama', $admin->nama) }}" required>
                                                <label for="nama" class="text-black">Nama Lengkap <span class="text-danger">*</span></label>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="form-floating">
                                                <input type="email" class="form-control border-0 bg-light rounded-3 text-black" 
                                                       id="email" name="email" placeholder="Email"
                                                       value="{{ old('email', $admin->email) }}" required>
                                                <label for="email" class="text-black">Alamat Email <span class="text-danger">*</span></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Contact Information Section -->
                                <div class="mb-5">
                                    <h5 class="fw-bold text-black mb-4">
                                        <i class="fas fa-phone text-warning me-2"></i>Informasi Kontak
                                    </h5>
                                    
                                    <div class="row g-4">
                                        <div class="col-md-6">
                                            <div class="form-floating">
                                                <input type="text" class="form-control border-0 bg-light rounded-3 text-black" 
                                                       id="phone" name="phone" placeholder="Nomor Telepon"
                                                       value="{{ old('phone', $admin->phone) }}" required>
                                                <label for="phone" class="text-black">Nomor Telepon <span class="text-danger">*</span></label>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="form-floating">
                                                <input type="text" class="form-control border-0 bg-light rounded-3 text-black" 
                                                       value="{{ ucfirst($admin->role ?? 'Administrator') }}" readonly>
                                                <label for="role" class="text-black">Peran</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Security Section -->
                                <div class="mb-5">
                                    <h5 class="fw-bold text-black mb-2">
                                        <i class="fas fa-lock text-warning me-2"></i>Keamanan
                                    </h5>
                                    <p class="text-black small mb-4">Biarkan kolom password kosong jika Anda tidak ingin mengubah password</p>
                                    
                                    <div class="row g-4">
                                        <div class="col-md-6">
                                            <div class="form-floating">
                                                <input type="password" class="form-control border-0 bg-light rounded-3 text-black" 
                                                       id="password" name="password" placeholder="Password Baru" minlength="8">
                                                <label for="password" class="text-black">Password Baru</label>
                                            </div>
                                            <div class="form-text text-black mt-2">
                                                <i class="fas fa-info-circle me-1 text-warning"></i>Minimal 8 karakter
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="form-floating">
                                                <input type="password" class="form-control border-0 bg-light rounded-3 text-black" 
                                                       id="password_confirmation" name="password_confirmation" 
                                                       placeholder="Konfirmasi Password" minlength="8">
                                                <label for="password_confirmation" class="text-black">Konfirmasi Password</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                                <div class="d-flex gap-3 justify-content-end">
                                    <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary rounded-pill px-4 py-2 text-black">
                                        <i class="fas fa-times me-2 text-warning"></i>Batal
                                    </a>
                                    <button type="submit" class="btn btn-dark rounded-pill px-4 py-2 shadow-sm text-white">
                                        <i class="fas fa-save me-2 text-warning"></i>Perbarui Profil
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Photo Upload Modal -->
<div class="modal fade" id="photoModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow-lg">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold text-black">
                    <i class="fas fa-camera text-warning me-2"></i>Foto Profil
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="photo-upload-form" enctype="multipart/form-data">
                    @csrf
                    <div class="text-center mb-4">
                        <div class="upload-area border-2 border-dashed border-dark rounded-4 p-4 bg-light bg-opacity-50">
                            <i class="fas fa-cloud-upload-alt text-warning fa-3x mb-3"></i>
                            <h6 class="text-black fw-bold mb-2">Pilih foto untuk diunggah</h6>
                            <p class="text-black small mb-3">JPG, JPEG, PNG. Maksimal 2MB</p>
                            <input type="file" id="profile_photo" name="profile_photo" 
                                   accept="image/*" class="form-control" style="display: none;">
                            <button type="button" class="btn btn-outline-dark rounded-pill px-4 text-black" 
                                    onclick="document.getElementById('profile_photo').click()">
                                <i class="fas fa-folder-open me-2 text-warning"></i>Pilih File
                            </button>
                        </div>
                    </div>
                    
                    <div id="selected-file" class="alert alert-info rounded-3 border-0" style="display: none;">
                        <i class="fas fa-file-image me-2 text-warning"></i>
                        <span id="file-name" class="text-black"></span>
                    </div>
                    
                    <div class="d-flex gap-3 justify-content-end">
                        @if($admin->profile_photo)
                            <button type="button" class="btn btn-outline-danger rounded-pill px-4 text-black" id="delete-photo-btn">
                                <i class="fas fa-trash me-2 text-warning"></i>Hapus Foto
                            </button>
                        @endif
                        <button type="button" class="btn btn-dark rounded-pill px-4 text-white" id="upload-photo-btn" disabled>
                            <i class="fas fa-upload me-2 text-warning"></i>Unggah Foto
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('additional-scripts')
<style>
/* Custom gradient backgrounds */
.bg-gradient-to-br {
    background: linear-gradient(135deg, #f8fafc 0%, #e0e7ff 100%);
}

.bg-gradient-to-r {
    background: linear-gradient(90deg, #374151 0%, #000000 100%);
}

/* Enhanced form controls */
.form-floating > .form-control:focus {
    border-color: #4f46e5;
    box-shadow: 0 0 0 0.2rem rgba(79, 70, 229, 0.25);
}

.form-floating > label {
    color: #000000 !important;
}

/* Text colors */
.text-black {
    color: #000000 !important;
}

/* Icon colors - Yellow/Warning */
.text-warning {
    color: #ffc107 !important;
}

/* Upload area hover effects */
.upload-area {
    transition: all 0.3s ease;
    cursor: pointer;
}

.upload-area:hover {
    background-color: rgba(79, 70, 229, 0.05) !important;
    transform: translateY(-2px);
}

/* Button enhancements */
.btn {
    transition: all 0.3s ease;
}

.btn:hover {
    transform: translateY(-1px);
}

.btn-dark {
    background: linear-gradient(135deg, #374151 0%, #000000 100%);
    border: none;
}

.btn-dark:hover {
    background: linear-gradient(135deg, #1f2937 0%, #111827 100%);
}

.btn-outline-secondary {
    border-color: #6c757d;
}

.btn-outline-secondary:hover {
    background-color: #6c757d;
    color: #ffffff !important;
}

.btn-outline-dark {
    border-color: #374151;
}

.btn-outline-dark:hover {
    background-color: #374151;
    color: #ffffff !important;
}

.btn-outline-danger {
    border-color: #dc3545;
}

.btn-outline-danger:hover {
    background-color: #dc3545;
    color: #ffffff !important;
}

/* Card shadows */
.card {
    transition: all 0.3s ease;
}

/* Loading spinner */
.spinner-border-sm {
    width: 1rem;
    height: 1rem;
}

/* Alert styling */
.alert {
    border: none;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
}

/* Profile photo styling */
#profile-photo-preview {
    transition: all 0.3s ease;
}

#profile-photo-preview:hover {
    transform: scale(1.02);
}

/* Input text color */
.form-control {
    color: #000000 !important;
}

.form-control::placeholder {
    color: #666666 !important;
}

/* Modal styling */
.modal-content {
    color: #000000;
}

.modal-title {
    color: #000000 !important;
}
</style>

<script>
$(document).ready(function() {
    // File selection handling
    $('#profile_photo').change(function() {
        const file = this.files[0];
        if (file) {
            $('#selected-file').show();
            $('#file-name').text(file.name);
            $('#upload-photo-btn').prop('disabled', false);
            
            // Preview the selected image
            const reader = new FileReader();
            reader.onload = function(e) {
                $('#profile-photo-preview').html(
                    '<img src="' + e.target.result + '" alt="Profile Photo Preview" class="rounded-circle border border-4 border-white shadow-lg" style="width: 120px; height: 120px; object-fit: cover;">'
                );
            };
            reader.readAsDataURL(file);
        } else {
            $('#selected-file').hide();
            $('#upload-photo-btn').prop('disabled', true);
        }
    });

    // Upload photo functionality
    $('#upload-photo-btn').click(function() {
        const fileInput = $('#profile_photo')[0];
        const file = fileInput.files[0];
        
        if (!file) {
            showNotification('error', 'Harap pilih foto terlebih dahulu.');
            return;
        }
        
        const formData = new FormData();
        formData.append('profile_photo', file);
        formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
        
        const uploadBtn = $(this);
        const originalText = uploadBtn.html();
        uploadBtn.html('<i class="fas fa-spinner fa-spin me-2 text-warning"></i><span class="text-white">Mengunggah...</span>').prop('disabled', true);
        
        $.ajax({
            url: '{{ route("admin.profile.upload-photo") }}',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    // Update the preview image
                    $('#profile-photo-preview').html(
                        '<img src="' + response.photo_url + '" alt="Profile Photo" class="rounded-circle border border-4 border-white shadow-lg" style="width: 120px; height: 120px; object-fit: cover;">'
                    );
                    
                    // Reset form and hide modal
                    fileInput.value = '';
                    $('#selected-file').hide();
                    $('#photoModal').modal('hide');
                    
                    // Show success message
                    showNotification('success', response.message);
                    
                    // Add delete button if it doesn't exist
                    if ($('#delete-photo-btn').length === 0) {
                        location.reload(); // Reload to show delete button
                    }
                } else {
                    showNotification('error', 'Unggah gagal. Silakan coba lagi.');
                }
            },
            error: function(xhr) {
                let errorMessage = 'Unggah gagal. Silakan coba lagi.';
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    errorMessage = Object.values(xhr.responseJSON.errors)[0][0];
                }
                showNotification('error', errorMessage);
            },
            complete: function() {
                uploadBtn.html(originalText).prop('disabled', false);
            }
        });
    });
    
    // Delete photo functionality
    $(document).on('click', '#delete-photo-btn', function() {
        if (!confirm('Apakah Anda yakin ingin menghapus foto profil?')) {
            return;
        }
        
        const deleteBtn = $(this);
        const originalText = deleteBtn.html();
        deleteBtn.html('<i class="fas fa-spinner fa-spin me-2 text-warning"></i><span class="text-black">Menghapus...</span>').prop('disabled', true);
        
        $.ajax({
            url: '{{ route("admin.profile.delete-photo") }}',
            type: 'DELETE',
            data: {
                '_token': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    // Update the preview to default
                    $('#profile-photo-preview').html(
                        '<div class="rounded-circle bg-white bg-opacity-20 d-flex align-items-center justify-content-center border border-4 border-white shadow-lg" style="width: 120px; height: 120px;">' +
                        '<i class="fas fa-user text-warning fa-3x"></i></div>'
                    );
                    
                    // Hide modal and show success
                    $('#photoModal').modal('hide');
                    showNotification('success', response.message);
                    
                    // Reload page to update delete button visibility
                    setTimeout(() => location.reload(), 1500);
                } else {
                    showNotification('error', response.message || 'Hapus gagal. Silakan coba lagi.');
                }
            },
            error: function() {
                showNotification('error', 'Hapus gagal. Silakan coba lagi.');
            },
            complete: function() {
                deleteBtn.html(originalText).prop('disabled', false);
            }
        });
    });
    
    // Modern notification system
    function showNotification(type, message) {
        const iconClass = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle';
        const bgClass = type === 'success' ? 'alert-success' : 'alert-danger';
        
        const alertHtml = `
            <div class="alert ${bgClass} alert-dismissible fade show rounded-3 border-0 shadow-sm" role="alert" style="position: fixed; top: 20px; right: 20px; z-index: 9999; min-width: 300px;">
                <i class="fas ${iconClass} me-2 text-warning"></i><span class="text-black">${message}</span>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `;
        
        $('body').append(alertHtml);
        
        // Auto dismiss after 5 seconds
        setTimeout(function() {
            $('.alert').fadeOut(500, function() {
                $(this).remove();
            });
        }, 5000);
    }

    // Form validation enhancements
    $('form').on('submit', function() {
        $(this).find('button[type="submit"]').html('<i class="fas fa-spinner fa-spin me-2 text-warning"></i><span class="text-white">Memperbarui...</span>').prop('disabled', true);
    });
});
</script>
@endsection
