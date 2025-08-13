<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Alat;
use App\Models\Gambar;
use App\Services\FileUploadService;
use Illuminate\Support\Str;

class EquipmentController extends Controller
{
    protected $fileUploadService;

    public function __construct(FileUploadService $fileUploadService)
    {
        $this->fileUploadService = $fileUploadService;
    }
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
            'stok_dipinjam' => 0,
            'stok_rusak' => $request->stok_rusak ?? 0,
            'harga' => $request->harga,
        ]);

        if ($request->hasFile('image')) {
            try {
                $uploadResult = $this->fileUploadService->uploadEquipmentImage($request->file('image'));
                
                Gambar::create([
                    'id' => (string) Str::uuid(),
                    'alatID' => $equipment->id,
                    'url' => $uploadResult['file_path'],
                    'kategori' => 'ALAT',
                ]);
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Gagal mengupload gambar: ' . $e->getMessage());
            }
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
        $jumlahPerbaikan = (int) $request->input('jumlah_perbaikan', 0);
        $stokRusakLama = $equipment->stok_rusak ?? 0;
        $stokRusakBaru = (int) $request->input('stok_rusak', $stokRusakLama);
        if ($jumlahPerbaikan > $stokRusakLama) {
            $jumlahPerbaikan = $stokRusakLama;
        }
        $stokRusakAkhir = max(0, $stokRusakBaru - $jumlahPerbaikan);
        $stokAkhir = (int) $request->stok + $jumlahPerbaikan;
        $equipment->update([
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
            'stok' => $stokAkhir,
            'stok_rusak' => $stokRusakAkhir,
            'harga' => $request->harga,
        ]);

        if ($request->hasFile('image')) {
            try {
                // Hapus gambar lama jika ada
                if ($equipment->gambar && $equipment->gambar->count() > 0) {
                    foreach ($equipment->gambar as $gambar) {
                        $oldImagePath = $gambar->url;
                        if ($this->fileUploadService->fileExists($oldImagePath)) {
                            $this->fileUploadService->deleteFile($oldImagePath);
                        }
                    }
                    $equipment->gambar()->delete();
                }

                $uploadResult = $this->fileUploadService->uploadEquipmentImage($request->file('image'));

                Gambar::create([
                    'id' => (string) Str::uuid(),
                    'alatID' => $equipment->id,
                    'url' => $uploadResult['file_path'],
                    'kategori' => 'ALAT',
                ]);
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Gagal mengupload gambar: ' . $e->getMessage());
            }
        }

        return redirect()->route('admin.equipment.index')->with('success', 'Alat berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $equipment = Alat::with('gambar')->findOrFail($id);
        
        // Hapus gambar jika ada
        if ($equipment->gambar && $equipment->gambar->count() > 0) {
            foreach ($equipment->gambar as $gambar) {
                $imagePath = $gambar->url;
                if ($this->fileUploadService->fileExists($imagePath)) {
                    $this->fileUploadService->deleteFile($imagePath);
                }
            }
            $equipment->gambar()->delete();
        }

        $equipment->delete();

        return redirect()->route('admin.equipment.index')->with('success', 'Alat berhasil dihapus.');
    }
} 
 