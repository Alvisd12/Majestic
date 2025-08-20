<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminAccountController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = Admin::query();

        if ($search) {
            $query->where('nama', 'like', '%' . $search . '%')
                  ->orWhere('username', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%')
                  ->orWhere('phone', 'like', '%' . $search . '%');
        }

        $admins = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.admin_accounts', compact('admins'));
    }

    public function create()
    {
        return view('admin.admin_accounts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:admin,username',
            'email' => 'nullable|email|unique:admin,email',
            'phone' => 'required|string|max:20|unique:admin,phone',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,super_admin',
        ]);

        Admin::create([
            'nama' => $request->nama,
            'username' => $request->username,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('admin.admin_accounts')->with('success', 'Admin account created successfully.');
    }

    public function edit($id)
    {
        $admin = Admin::findOrFail($id);
        return view('admin.admin_accounts.edit', compact('admin'));
    }

    public function update(Request $request, $id)
    {
        $admin = Admin::findOrFail($id);
        
        $request->validate([
            'nama' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:admin,username,' . $id,
            'email' => 'nullable|email|unique:admin,email,' . $id,
            'phone' => 'required|string|max:20|unique:admin,phone,' . $id,
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|in:admin,super_admin',
        ]);

        $updateData = [
            'nama' => $request->nama,
            'username' => $request->username,
            'email' => $request->email,
            'phone' => $request->phone,
            'role' => $request->role,
        ];

        if ($request->password) {
            $updateData['password'] = Hash::make($request->password);
        }

        $admin->update($updateData);

        return redirect()->route('admin.admin_accounts')->with('success', 'Admin account updated successfully.');
    }

    public function destroy($id)
    {
        $admin = Admin::findOrFail($id);
        
        // Prevent deleting the last admin
        if (Admin::count() <= 1) {
            return response()->json([
                'success' => false, 
                'message' => 'Cannot delete the last admin account!'
            ]);
        }
        
        $admin->delete();

        return response()->json([
            'success' => true, 
            'message' => 'Admin account deleted successfully!'
        ]);
    }
}
