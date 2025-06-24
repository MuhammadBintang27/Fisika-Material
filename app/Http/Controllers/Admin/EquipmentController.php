<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Alat;
use App\Models\Gambar;
use Illuminate\Support\Str;

class EquipmentController extends Controller
{
    public function index()
    {
        $equipments = Alat::with('gambar')->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.equipment.index', compact('equipments'));
    }

    public function create()
    {
        return view('admin.equipment.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'stok' => 'required|integer|min:0',
            'isBroken' => 'boolean',
            'harga' => 'nullable|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $equipment = Alat::create([
            'id' => (string) Str::uuid(),
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
            'stok' => $request->stok,
            'isBroken' => $request->has('isBroken'),
            'harga' => $request->harga,
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/equipment'), $imageName);

            Gambar::create([
                'id' => (string) Str::uuid(),
                'alatID' => $equipment->id,
                'url' => 'images/equipment/' . $imageName,
                'kategori' => 'ALAT',
            ]);
        }

        return redirect()->route('admin.equipment.index')->with('success', 'Alat berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $equipment = Alat::with('gambar')->findOrFail($id);
        return view('admin.equipment.edit', compact('equipment'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'stok' => 'required|integer|min:0',
            'isBroken' => 'boolean',
            'harga' => 'nullable|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $equipment = Alat::findOrFail($id);
        $equipment->update([
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
            'stok' => $request->stok,
            'isBroken' => $request->has('isBroken'),
            'harga' => $request->harga,
        ]);

        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($equipment->gambar) {
                $oldImagePath = public_path($equipment->gambar->url);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
                $equipment->gambar->delete();
            }

            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/equipment'), $imageName);

            Gambar::create([
                'id' => (string) Str::uuid(),
                'alatID' => $equipment->id,
                'url' => 'images/equipment/' . $imageName,
                'kategori' => 'ALAT',
            ]);
        }

        return redirect()->route('admin.equipment.index')->with('success', 'Alat berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $equipment = Alat::with('gambar')->findOrFail($id);
        
        // Hapus gambar jika ada
        if ($equipment->gambar) {
            $imagePath = public_path($equipment->gambar->url);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
            $equipment->gambar->delete();
        }

        $equipment->delete();

        return redirect()->route('admin.equipment.index')->with('success', 'Alat berhasil dihapus.');
    }
} 
 