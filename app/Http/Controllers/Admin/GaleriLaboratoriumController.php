<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GaleriLaboratorium;
use App\Models\Fasilitas;
use App\Services\FileUploadService;
use Illuminate\Http\Request;

class GaleriLaboratoriumController extends Controller
{
    protected $fileUploadService;

    public function __construct(FileUploadService $fileUploadService)
    {
        $this->fileUploadService = $fileUploadService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $galeri = GaleriLaboratorium::all();
        $fasilitas = Fasilitas::active()->orderBy('nama')->get();
        return view('admin.galeri.index', compact('galeri', 'fasilitas'));
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

        try {
            $uploadResult = $this->fileUploadService->uploadGalleryImage($request->file('gambar'));
            
            GaleriLaboratorium::create([
                'judul' => $request->judul,
                'gambar_url' => $uploadResult['file_path'],
            ]);

            return redirect()->route('admin.galeri.index')->with('success', 'Galeri berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengupload gambar: ' . $e->getMessage());
        }
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
            try {
                // Hapus gambar lama jika ada
                if ($galeri->gambar_url && $this->fileUploadService->fileExists($galeri->gambar_url)) {
                    $this->fileUploadService->deleteFile($galeri->gambar_url);
                }

                $uploadResult = $this->fileUploadService->uploadGalleryImage($request->file('gambar'));
                $data['gambar_url'] = $uploadResult['file_path'];
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Gagal mengupload gambar: ' . $e->getMessage());
            }
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
        
        // Hapus file gambar jika ada
        if ($galeri->gambar_url && $this->fileUploadService->fileExists($galeri->gambar_url)) {
            $this->fileUploadService->deleteFile($galeri->gambar_url);
        }
        
        $galeri->delete();
        return redirect()->route('admin.galeri.index')->with('success', 'Galeri berhasil dihapus.');
    }

    // Methods untuk mengelola fasilitas
    public function storeFasilitas(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255|unique:fasilitas,nama',
        ]);

        Fasilitas::create([
            'nama' => $request->nama,
            'is_active' => true
        ]);

        return redirect()->route('admin.galeri.index')->with('success', 'Fasilitas berhasil ditambahkan.');
    }

    public function updateFasilitas(Request $request, $id)
    {
        $fasilitas = Fasilitas::findOrFail($id);
        
        $request->validate([
            'nama' => 'required|string|max:255|unique:fasilitas,nama,' . $id,
        ]);

        $fasilitas->update([
            'nama' => $request->nama
        ]);

        return redirect()->route('admin.galeri.index')->with('success', 'Fasilitas berhasil diupdate.');
    }

    public function destroyFasilitas($id)
    {
        $fasilitas = Fasilitas::findOrFail($id);
        $fasilitas->delete();

        return redirect()->route('admin.galeri.index')->with('success', 'Fasilitas berhasil dihapus.');
    }

    public function toggleFasilitas($id)
    {
        $fasilitas = Fasilitas::findOrFail($id);
        $fasilitas->update(['is_active' => !$fasilitas->is_active]);

        $status = $fasilitas->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return redirect()->route('admin.galeri.index')->with('success', "Fasilitas berhasil {$status}.");
    }
}
