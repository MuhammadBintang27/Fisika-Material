<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Fasilitas;
use Illuminate\Http\Request;

class FasilitasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $fasilitas = Fasilitas::orderBy('nama')->get();
        return view('admin.fasilitas.index', compact('fasilitas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.fasilitas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255|unique:fasilitas,nama',
        ]);

        Fasilitas::create([
            'nama' => $request->nama,
            'is_active' => true
        ]);

        return redirect()->route('admin.fasilitas.index')
                        ->with('success', 'Fasilitas berhasil ditambahkan');
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
    public function edit(Fasilitas $fasilitas)
    {
        return view('admin.fasilitas.edit', compact('fasilitas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Fasilitas $fasilitas)
    {
        $request->validate([
            'nama' => 'required|string|max:255|unique:fasilitas,nama,' . $fasilitas->id,
            'is_active' => 'boolean'
        ]);

        $fasilitas->update([
            'nama' => $request->nama,
            'is_active' => $request->has('is_active')
        ]);

        return redirect()->route('admin.fasilitas.index')
                        ->with('success', 'Fasilitas berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Fasilitas $fasilitas)
    {
        $fasilitas->delete();
        
        return redirect()->route('admin.fasilitas.index')
                        ->with('success', 'Fasilitas berhasil dihapus');
    }
}
