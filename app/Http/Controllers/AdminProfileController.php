<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Admin;

class AdminProfileController extends Controller
{
    /**
     * Show admin profile page
     */
    public function show()
    {
        \App\Http\Controllers\AuthController::requireAdmin();
        
        $admin = \App\Http\Controllers\AuthController::getCurrentUser();
        
        return view('admin.profile.show', compact('admin'));
    }

    /**
     * Update admin profile
     */
    public function update(Request $request)
    {
        \App\Http\Controllers\AuthController::requireAdmin();
        
        $admin = \App\Http\Controllers\AuthController::getCurrentUser();
        
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'nullable|email|max:255|unique:admin,email,' . $admin->id,
            'phone' => 'required|string|max:20|unique:admin,phone,' . $admin->id,
            'password' => 'nullable|string|min:8|confirmed',
            'profile_photo' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
        ], [
            'nama.required' => 'Nama wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan.',
            'phone.required' => 'Nomor handphone wajib diisi.',
            'phone.unique' => 'Nomor handphone sudah digunakan.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'profile_photo.image' => 'File harus berupa gambar.',
            'profile_photo.mimes' => 'Format gambar harus JPG, JPEG, atau PNG.',
            'profile_photo.max' => 'Ukuran gambar maksimal 2MB.',
        ]);

        // Update data
        $updateData = [
            'nama' => $validated['nama'],
            'phone' => $validated['phone'],
        ];
        
        if (isset($validated['email'])) {
            $updateData['email'] = $validated['email'];
        }

        // Handle profile photo upload
        if ($request->hasFile('profile_photo')) {
            // Delete old profile photo if exists
            if ($admin->profile_photo && Storage::disk('public')->exists($admin->profile_photo)) {
                Storage::disk('public')->delete($admin->profile_photo);
            }
            
            $file = $request->file('profile_photo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $profilePhotoPath = $file->storeAs('profile_photos', $filename, 'public');
            $updateData['profile_photo'] = $profilePhotoPath;
        }

        // Update password if provided
        if (!empty($validated['password'])) {
            $updateData['password'] = bcrypt($validated['password']);
        }

        Admin::where('id', $admin->id)->update($updateData);

        // Update session data
        session(['user_name' => $validated['nama']]);

        return redirect()->route('admin.profile.show')->with('success', 'Profile berhasil diperbarui!');
    }

    /**
     * Upload profile photo only
     */
    public function uploadPhoto(Request $request)
    {
        \App\Http\Controllers\AuthController::requireAdmin();
        
        $request->validate([
            'profile_photo' => 'required|image|mimes:jpeg,jpg,png|max:2048',
        ], [
            'profile_photo.required' => 'Foto profil wajib dipilih.',
            'profile_photo.image' => 'File harus berupa gambar.',
            'profile_photo.mimes' => 'Format gambar harus JPG, JPEG, atau PNG.',
            'profile_photo.max' => 'Ukuran gambar maksimal 2MB.',
        ]);

        $admin = \App\Http\Controllers\AuthController::getCurrentUser();

        // Delete old profile photo if exists
        if ($admin->profile_photo && Storage::disk('public')->exists($admin->profile_photo)) {
            Storage::disk('public')->delete($admin->profile_photo);
        }

        // Upload new profile photo
        $file = $request->file('profile_photo');
        $filename = time() . '_' . $file->getClientOriginalName();
        $profilePhotoPath = $file->storeAs('profile_photos', $filename, 'public');

        // Update database
        Admin::where('id', $admin->id)->update(['profile_photo' => $profilePhotoPath]);

        return response()->json([
            'success' => true,
            'message' => 'Foto profil berhasil diupload!',
            'photo_url' => Storage::url($profilePhotoPath)
        ]);
    }

    /**
     * Delete profile photo
     */
    public function deletePhoto(Request $request)
    {
        \App\Http\Controllers\AuthController::requireAdmin();
        
        $admin = \App\Http\Controllers\AuthController::getCurrentUser();

        if ($admin->profile_photo) {
            // Delete file from storage
            if (Storage::disk('public')->exists($admin->profile_photo)) {
                Storage::disk('public')->delete($admin->profile_photo);
            }

            // Update database
            Admin::where('id', $admin->id)->update(['profile_photo' => null]);

            return response()->json([
                'success' => true,
                'message' => 'Foto profil berhasil dihapus!'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Tidak ada foto profil untuk dihapus.'
        ]);
    }
}
