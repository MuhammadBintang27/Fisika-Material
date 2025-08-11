<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminManagementController extends Controller
{
    /**
     * Display a listing of the admins.
     */
    public function index()
    {
        $admins = User::where('is_admin', true)
            ->orWhere('is_super_admin', true)
            ->orderBy('is_super_admin', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.admin-management.index', compact('admins'));
    }

    /**
     * Show the form for creating a new admin.
     */
    public function create()
    {
        return view('admin.admin-management.create');
    }

    /**
     * Store a newly created admin in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'is_super_admin' => 'sometimes|boolean',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_admin' => true,
            'is_super_admin' => $request->boolean('is_super_admin', false),
        ]);

        return redirect()->route('admin.admin-management.index')
            ->with('success', 'Admin berhasil ditambahkan.');
    }

    /**
     * Display the specified admin.
     */
    public function show($id)
    {
        $admin = User::where('is_admin', true)
            ->orWhere('is_super_admin', true)
            ->findOrFail($id);

        return view('admin.admin-management.show', compact('admin'));
    }

    /**
     * Show the form for editing the specified admin.
     */
    public function edit($id)
    {
        $admin = User::where('is_admin', true)
            ->orWhere('is_super_admin', true)
            ->findOrFail($id);

        // Prevent editing the last super admin
        if ($admin->is_super_admin && User::where('is_super_admin', true)->count() === 1) {
            return redirect()->route('admin.admin-management.index')
                ->with('error', 'Tidak dapat mengedit super admin terakhir.');
        }

        return view('admin.admin-management.edit', compact('admin'));
    }

    /**
     * Update the specified admin in storage.
     */
    public function update(Request $request, $id)
    {
        $admin = User::where('is_admin', true)
            ->orWhere('is_super_admin', true)
            ->findOrFail($id);

        // Prevent editing the last super admin
        if ($admin->is_super_admin && User::where('is_super_admin', true)->count() === 1) {
            return redirect()->route('admin.admin-management.index')
                ->with('error', 'Tidak dapat mengubah super admin terakhir.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($admin->id)],
            'password' => 'nullable|string|min:8|confirmed',
            'is_super_admin' => 'sometimes|boolean',
        ]);

        $updateData = [
            'name' => $request->name,
            'email' => $request->email,
            'is_admin' => true,
            'is_super_admin' => $request->boolean('is_super_admin', false),
        ];

        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($request->password);
        }

        $admin->update($updateData);

        return redirect()->route('admin.admin-management.index')
            ->with('success', 'Admin berhasil diperbarui.');
    }

    /**
     * Remove the specified admin from storage.
     */
    public function destroy($id)
    {
        $admin = User::where('is_admin', true)
            ->orWhere('is_super_admin', true)
            ->findOrFail($id);

        // Prevent deleting the last super admin
        if ($admin->is_super_admin && User::where('is_super_admin', true)->count() === 1) {
            return redirect()->route('admin.admin-management.index')
                ->with('error', 'Tidak dapat menghapus super admin terakhir.');
        }

        // Prevent admin from deleting themselves
        if ($admin->id === auth()->id()) {
            return redirect()->route('admin.admin-management.index')
                ->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $admin->delete();

        return redirect()->route('admin.admin-management.index')
            ->with('success', 'Admin berhasil dihapus.');
    }
}
