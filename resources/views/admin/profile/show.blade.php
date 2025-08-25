@extends('layouts.admin')

@section('title', 'Admin Profile')

@section('page-title', 'Profile Settings')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="form-card">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Profile Photo Section -->
            <div class="row mb-4">
                <div class="col-md-12">
                    <h5 class="mb-3"><i class="fas fa-camera me-2"></i>Profile Photo</h5>
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            @if($admin->profile_photo)
                                <img src="{{ asset('storage/' . $admin->profile_photo) }}" 
                                     alt="Profile Photo" 
                                     class="rounded-circle" 
                                     style="width: 100px; height: 100px; object-fit: cover; border: 3px solid #e5e7eb;"
                                     id="profile-photo-preview">
                            @else
                                <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center" 
                                     style="width: 100px; height: 100px; border: 3px solid #e5e7eb;"
                                     id="profile-photo-preview">
                                    <i class="fas fa-user text-white fa-2x"></i>
                                </div>
                            @endif
                        </div>
                        <div>
                            <form id="photo-upload-form" enctype="multipart/form-data">
                                @csrf
                                <input type="file" 
                                       id="profile_photo" 
                                       name="profile_photo" 
                                       accept="image/*" 
                                       class="form-control mb-2" 
                                       style="max-width: 250px;">
                                <div class="btn-group" role="group">
                                    <button type="button" 
                                            class="btn btn-primary btn-sm" 
                                            id="upload-photo-btn">
                                        <i class="fas fa-upload me-1"></i>Upload
                                    </button>
                                    @if($admin->profile_photo)
                                        <button type="button" 
                                                class="btn btn-danger btn-sm" 
                                                id="delete-photo-btn">
                                            <i class="fas fa-trash me-1"></i>Delete
                                        </button>
                                    @endif
                                </div>
                            </form>
                            <small class="text-muted d-block mt-1">
                                JPG, JPEG, PNG. Max 2MB.
                            </small>
                        </div>
                    </div>
                </div>
            </div>

            <hr class="my-4">

            <!-- Profile Information Form -->
            <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <h5 class="mb-3"><i class="fas fa-user-edit me-2"></i>Profile Information</h5>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="nama" class="form-label">Full Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="nama" name="nama" 
                               value="{{ old('nama', $admin->nama) }}" required>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" 
                               value="{{ old('email', $admin->email) }}">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="phone" class="form-label">Phone Number <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="phone" name="phone" 
                               value="{{ old('phone', $admin->phone) }}" required>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label for="role" class="form-label">Role</label>
                        <input type="text" class="form-control" value="{{ ucfirst($admin->role ?? 'Admin') }}" readonly>
                    </div>
                </div>

                <hr class="my-4">
                
                <h5 class="mb-3"><i class="fas fa-lock me-2"></i>Change Password</h5>
                <p class="text-muted small">Leave blank if you don't want to change your password</p>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="password" class="form-label">New Password</label>
                        <input type="password" class="form-control" id="password" name="password" 
                               minlength="8">
                        <div class="form-text">Minimum 8 characters</div>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label for="password_confirmation" class="form-label">Confirm New Password</label>
                        <input type="password" class="form-control" id="password_confirmation" 
                               name="password_confirmation" minlength="8">
                    </div>
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary me-md-2">
                        <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Update Profile
                    </button>
                </div>
            </form>
        </div>

        <!-- Account Information Card -->
        <div class="form-card mt-4">
            <h5 class="mb-3"><i class="fas fa-info-circle me-2"></i>Account Information</h5>
            <div class="row">
                <div class="col-md-6">
                    <strong>Account Type:</strong>
                    <span class="badge bg-primary ms-2">Administrator</span>
                </div>
                <div class="col-md-6">
                    <strong>Member Since:</strong>
                    <span class="ms-2">{{ \Carbon\Carbon::parse($admin->created_at)->format('M Y') }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('additional-scripts')
<script>
$(document).ready(function() {
    // Upload photo functionality
    $('#upload-photo-btn').click(function() {
        const fileInput = $('#profile_photo')[0];
        const file = fileInput.files[0];
        
        if (!file) {
            alert('Please select a photo first.');
            return;
        }
        
        const formData = new FormData();
        formData.append('profile_photo', file);
        formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
        
        const uploadBtn = $(this);
        const originalText = uploadBtn.html();
        uploadBtn.html('<i class="fas fa-spinner fa-spin me-1"></i>Uploading...').prop('disabled', true);
        
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
                        '<img src="' + response.photo_url + '" alt="Profile Photo" class="rounded-circle" style="width: 100px; height: 100px; object-fit: cover; border: 3px solid #e5e7eb;">'
                    );
                    
                    // Add delete button if it doesn't exist
                    if ($('#delete-photo-btn').length === 0) {
                        uploadBtn.after(
                            '<button type="button" class="btn btn-danger btn-sm" id="delete-photo-btn">' +
                            '<i class="fas fa-trash me-1"></i>Delete</button>'
                        );
                    }
                    
                    // Clear file input
                    fileInput.value = '';
                    
                    // Show success message
                    showAlert('success', response.message);
                    
                    // Reload page to update topbar avatar
                    setTimeout(function() {
                        location.reload();
                    }, 1500);
                } else {
                    showAlert('danger', 'Upload failed. Please try again.');
                }
            },
            error: function(xhr) {
                let errorMessage = 'Upload failed. Please try again.';
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    errorMessage = Object.values(xhr.responseJSON.errors)[0][0];
                }
                showAlert('danger', errorMessage);
            },
            complete: function() {
                uploadBtn.html(originalText).prop('disabled', false);
            }
        });
    });
    
    // Delete photo functionality
    $(document).on('click', '#delete-photo-btn', function() {
        if (!confirm('Are you sure you want to delete your profile photo?')) {
            return;
        }
        
        const deleteBtn = $(this);
        const originalText = deleteBtn.html();
        deleteBtn.html('<i class="fas fa-spinner fa-spin me-1"></i>Deleting...').prop('disabled', true);
        
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
                        '<div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center" style="width: 100px; height: 100px; border: 3px solid #e5e7eb;">' +
                        '<i class="fas fa-user text-white fa-2x"></i></div>'
                    );
                    
                    // Remove delete button
                    deleteBtn.remove();
                    
                    // Show success message
                    showAlert('success', response.message);
                    
                    // Reload page to update topbar avatar
                    setTimeout(function() {
                        location.reload();
                    }, 1500);
                } else {
                    showAlert('danger', response.message || 'Delete failed. Please try again.');
                }
            },
            error: function() {
                showAlert('danger', 'Delete failed. Please try again.');
            },
            complete: function() {
                deleteBtn.html(originalText).prop('disabled', false);
            }
        });
    });
    
    // Preview selected image before upload
    $('#profile_photo').change(function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                $('#profile-photo-preview').html(
                    '<img src="' + e.target.result + '" alt="Profile Photo Preview" class="rounded-circle" style="width: 100px; height: 100px; object-fit: cover; border: 3px solid #e5e7eb;">'
                );
            };
            reader.readAsDataURL(file);
        }
    });
    
    // Helper function to show alerts
    function showAlert(type, message) {
        const alertHtml = `
            <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `;
        
        // Remove existing alerts
        $('.alert').remove();
        
        // Add new alert at the top of form card
        $('.form-card').prepend(alertHtml);
        
        // Auto dismiss after 5 seconds
        setTimeout(function() {
            $('.alert').fadeOut();
        }, 5000);
    }
});
</script>
@endsection
