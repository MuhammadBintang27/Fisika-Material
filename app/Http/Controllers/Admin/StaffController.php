<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BiodataPengurus;
use App\Models\Gambar;
use App\Services\FileUploadService;
use Illuminate\Support\Str;

class StaffController extends Controller
{
    protected $fileUploadService;

    public function __construct(FileUploadService $fileUploadService)
    {
        $this->fileUploadService = $fileUploadService;
    }
    public function index()
    {
        $staff = BiodataPengurus::with('gambar')->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.staff.index', compact('staff'));
    }

    public function create()
    {
        $jabatans = ['Ketua Laboratorium', 'Tenaga Laboran'];
        return view('admin.staff.create', compact('jabatans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'jabatan' => 'required|in:Ketua Laboratorium,Tenaga Laboran',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $staff = BiodataPengurus::create([
            'id' => (string) Str::uuid(),
            'nama' => $request->nama,
            'jabatan' => $request->jabatan,
        ]);

        if ($request->hasFile('image')) {
            try {
                $uploadResult = $this->fileUploadService->uploadStaffImage($request->file('image'));

                Gambar::create([
                    'id' => (string) Str::uuid(),
                    'pengurusId' => $staff->id,
                    'url' => $uploadResult['file_path'],
                    'kategori' => 'PENGURUS',
                ]);
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Gagal mengupload gambar: ' . $e->getMessage());
            }
        }

        return redirect()->route('admin.staff.index')->with('success', 'Staf berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $staff = BiodataPengurus::with('gambar')->findOrFail($id);
        $jabatans = ['Ketua Laboratorium', 'Tenaga Laboran'];
        return view('admin.staff.edit', compact('staff', 'jabatans'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'jabatan' => 'required|in:Ketua Laboratorium,Tenaga Laboran',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $staff = BiodataPengurus::findOrFail($id);
        $staff->update([
            'nama' => $request->nama,
            'jabatan' => $request->jabatan,
        ]);

        if ($request->hasFile('image')) {
            try {
                // Hapus gambar lama jika ada
                if ($staff->gambar->first()) {
                    $oldImagePath = $staff->gambar->first()->url;
                    if ($this->fileUploadService->fileExists($oldImagePath)) {
                        $this->fileUploadService->deleteFile($oldImagePath);
                    }
                    $staff->gambar->first()->delete();
                }

                $uploadResult = $this->fileUploadService->uploadStaffImage($request->file('image'));

                Gambar::create([
                    'id' => (string) Str::uuid(),
                    'pengurusId' => $staff->id,
                    'url' => $uploadResult['file_path'],
                    'kategori' => 'PENGURUS',
                ]);
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Gagal mengupload gambar: ' . $e->getMessage());
            }
        }

        return redirect()->route('admin.staff.index')->with('success', 'Data staf berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $staff = BiodataPengurus::with('gambar')->findOrFail($id);
        
        // Hapus gambar jika ada
        if ($staff->gambar->isNotEmpty()) {
            $gambar = $staff->gambar->first(); // Ambil gambar pertama
            $imagePath = $gambar->url; // Akses url dari instance Gambar
            if ($this->fileUploadService->fileExists($imagePath)) {
                $this->fileUploadService->deleteFile($imagePath);
            }
            $gambar->delete(); // Hapus record gambar
        }

        $staff->delete();

        return redirect()->route('admin.staff.index')->with('success', 'Staf berhasil dihapus.');
    }
}