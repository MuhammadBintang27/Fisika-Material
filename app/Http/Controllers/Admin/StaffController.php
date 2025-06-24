<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BiodataPengurus;
use App\Models\Gambar;
use Illuminate\Support\Str;

class StaffController extends Controller
{
    public function index()
    {
        $staff = BiodataPengurus::with('gambar')->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.staff.index', compact('staff'));
    }

    public function create()
    {
        return view('admin.staff.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $staff = BiodataPengurus::create([
            'id' => (string) Str::uuid(),
            'nama' => $request->nama,
            'jabatan' => $request->jabatan,
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/staff'), $imageName);

            Gambar::create([
                'id' => (string) Str::uuid(),
                'pengurusId' => $staff->id,
                'url' => 'images/staff/' . $imageName,
                'kategori' => 'PENGURUS',
            ]);
        }

        return redirect()->route('admin.staff.index')->with('success', 'Staf berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $staff = BiodataPengurus::with('gambar')->findOrFail($id);
        return view('admin.staff.edit', compact('staff'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $staff = BiodataPengurus::findOrFail($id);
        $staff->update([
            'nama' => $request->nama,
            'jabatan' => $request->jabatan,
        ]);

        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($staff->gambar->first()) {
                $oldImagePath = public_path($staff->gambar->first()->url);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
                $staff->gambar->first()->delete();
            }

            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/staff'), $imageName);

            Gambar::create([
                'id' => (string) Str::uuid(),
                'pengurusId' => $staff->id,
                'url' => 'images/staff/' . $imageName,
                'kategori' => 'PENGURUS',
            ]);
        }

        return redirect()->route('admin.staff.index')->with('success', 'Data staf berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $staff = BiodataPengurus::with('gambar')->findOrFail($id);
        
        // Hapus gambar jika ada
        if ($staff->gambar) {
            $imagePath = public_path($staff->gambar->url);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
            $staff->gambar->delete();
        }

        $staff->delete();

        return redirect()->route('admin.staff.index')->with('success', 'Staf berhasil dihapus.');
    }
} 
 