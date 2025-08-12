<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LayananPengujian;

class LayananPengujianController extends Controller
{
    public function index()
    {
        $layananPengujian = LayananPengujian::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.layanan-pengujian.index', compact('layananPengujian'));
    }

    public function create()
    {
        return view('admin.layanan-pengujian.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'namaLayanan' => 'required|string|max:255|unique:layanan_pengujian,namaLayanan',
            'deskripsi' => 'nullable|string',
            'estimasiSelesaiHari' => 'required|integer|min:1|max:365',
            'harga' => 'nullable|integer|min:0',
            'isAktif' => 'boolean',
            'instruksiSampel' => 'nullable|string',
        ]);

        LayananPengujian::create([
            'namaLayanan' => $request->namaLayanan,
            'deskripsi' => $request->deskripsi,
            'estimasiSelesaiHari' => $request->estimasiSelesaiHari,
            'harga' => $request->harga,
            'isAktif' => $request->has('isAktif'),
            'instruksiSampel' => $request->instruksiSampel,
        ]);

        return redirect()->route('admin.layanan-pengujian.index')
            ->with('success', 'Layanan pengujian berhasil ditambahkan.');
    }

    public function show($id)
    {
        $layanan = LayananPengujian::with(['pengajuanPengujian' => function($query) {
            $query->orderBy('created_at', 'desc')->limit(10);
        }])->findOrFail($id);
        
        return view('admin.layanan-pengujian.show', compact('layanan'));
    }

    public function edit($id)
    {
        $layananPengujian = LayananPengujian::findOrFail($id);
        return view('admin.layanan-pengujian.edit', compact('layananPengujian'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'namaLayanan' => 'required|string|max:255|unique:layanan_pengujian,namaLayanan,' . $id,
            'deskripsi' => 'nullable|string',
            'estimasiSelesaiHari' => 'required|integer|min:1|max:365',
            'harga' => 'nullable|integer|min:0',
            'isAktif' => 'required|in:0,1',
            'instruksiSampel' => 'nullable|string',
        ]);

        $layanan = LayananPengujian::findOrFail($id);
        $layanan->update([
            'namaLayanan' => $request->namaLayanan,
            'deskripsi' => $request->deskripsi,
            'estimasiSelesaiHari' => $request->estimasiSelesaiHari,
            'harga' => $request->harga,
            'isAktif' => $request->isAktif == '1',
            'instruksiSampel' => $request->instruksiSampel,
        ]);

        return redirect()->route('admin.layanan-pengujian.index')
            ->with('success', 'Layanan pengujian berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $layanan = LayananPengujian::findOrFail($id);
        
        // Check if there are any pengajuan for this layanan
        if ($layanan->pengajuanPengujian()->count() > 0) {
            return redirect()->route('admin.layanan-pengujian.index')
                ->with('error', 'Tidak dapat menghapus layanan yang sudah memiliki pengajuan.');
        }
        
        $layanan->delete();

        return redirect()->route('admin.layanan-pengujian.index')
            ->with('success', 'Layanan pengujian berhasil dihapus.');
    }
} 
 