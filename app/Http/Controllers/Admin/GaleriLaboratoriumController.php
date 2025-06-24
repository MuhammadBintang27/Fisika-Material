<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GaleriLaboratorium;
use Illuminate\Http\Request;

class GaleriLaboratoriumController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $galeri = GaleriLaboratorium::all();
        return view('admin.galeri.index', compact('galeri'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.galeri.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);
        $file = $request->file('gambar');
        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('images/galeri'), $filename);
        $gambar_url = 'images/galeri/' . $filename;
        GaleriLaboratorium::create([
            'judul' => $request->judul,
            'gambar_url' => $gambar_url,
        ]);
        return redirect()->route('admin.galeri.index')->with('success', 'Galeri berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $galeri = GaleriLaboratorium::findOrFail($id);
        return view('admin.galeri.edit', compact('galeri'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);
        $galeri = GaleriLaboratorium::findOrFail($id);
        $data = ['judul' => $request->judul];
        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/galeri'), $filename);
            $data['gambar_url'] = 'images/galeri/' . $filename;
        }
        $galeri->update($data);
        return redirect()->route('admin.galeri.index')->with('success', 'Galeri berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $galeri = GaleriLaboratorium::findOrFail($id);
        $galeri->delete();
        return redirect()->route('admin.galeri.index')->with('success', 'Galeri berhasil dihapus.');
    }
}
