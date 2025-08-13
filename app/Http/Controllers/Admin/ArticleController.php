<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Artikel;
use App\Models\Gambar;
use App\Services\FileUploadService;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    protected $fileUploadService;

    public function __construct(FileUploadService $fileUploadService)
    {
        $this->fileUploadService = $fileUploadService;
    }
    public function index(Request $request)
    {
        $query = Artikel::with('gambar')->orderBy('created_at', 'desc');

        // Search by namaAcara or penulis
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('namaAcara', 'like', '%' . $search . '%')
                  ->orWhere('penulis', 'like', '%' . $search . '%');
            });
        }

        // Filter by tanggalAcara range
        if ($fromDate = $request->input('from_date')) {
            $query->where('tanggalAcara', '>=', $fromDate);
        }
        if ($toDate = $request->input('to_date')) {
            $query->where('tanggalAcara', '<=', $toDate);
        }

        $articles = $query->paginate(10);

        return view('admin.articles.index', compact('articles'));
    }

    public function create()
    {
        return view('admin.articles.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'namaAcara' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'penulis' => 'nullable|string|max:255',
            'deskripsi_penulis' => 'nullable|string',
            'tanggalAcara' => 'required|date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $article = Artikel::create([
            'id' => (string) Str::uuid(),
            'namaAcara' => $request->namaAcara,
            'deskripsi' => $request->deskripsi,
            'penulis' => $request->penulis,
            'deskripsi_penulis' => $request->deskripsi_penulis,
            'tanggalAcara' => $request->tanggalAcara,
        ]);

        if ($request->hasFile('image')) {
            try {
                $uploadResult = $this->fileUploadService->uploadArticleImage($request->file('image'));

                Gambar::create([
                    'id' => (string) Str::uuid(),
                    'acaraId' => $article->id,
                    'url' => $uploadResult['file_path'],
                    'kategori' => 'ACARA',
                ]);
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Gagal mengupload gambar: ' . $e->getMessage());
            }
        }

        return redirect()->route('admin.articles.index')->with('success', 'Artikel berhasil dibuat.');
    }

    public function edit($id)
    {
        $article = Artikel::with('gambar')->findOrFail($id);
        return view('admin.articles.edit', compact('article'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'namaAcara' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'penulis' => 'nullable|string|max:255',
            'deskripsi_penulis' => 'nullable|string',
            'tanggalAcara' => 'required|date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $article = Artikel::findOrFail($id);
        $article->update([
            'namaAcara' => $request->namaAcara,
            'deskripsi' => $request->deskripsi,
            'penulis' => $request->penulis,
            'deskripsi_penulis' => $request->deskripsi_penulis,
            'tanggalAcara' => $request->tanggalAcara,
        ]);

        if ($request->hasFile('image')) {
            try {
                // Hapus gambar lama jika ada
                if ($article->gambar && $article->gambar->count() > 0) {
                    foreach ($article->gambar as $gambar) {
                        $oldImagePath = $gambar->url;
                        if ($this->fileUploadService->fileExists($oldImagePath)) {
                            $this->fileUploadService->deleteFile($oldImagePath);
                        }
                    }
                    $article->gambar()->delete();
                }

                $uploadResult = $this->fileUploadService->uploadArticleImage($request->file('image'));

                Gambar::create([
                    'id' => (string) Str::uuid(),
                    'acaraId' => $article->id,
                    'url' => $uploadResult['file_path'],
                    'kategori' => 'ACARA',
                ]);
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Gagal mengupload gambar: ' . $e->getMessage());
            }
        }

        return redirect()->route('admin.articles.index')->with('success', 'Artikel berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $article = Artikel::with('gambar')->findOrFail($id);
        
        // Hapus gambar jika ada
        if ($article->gambar && $article->gambar->count() > 0) {
            foreach ($article->gambar as $gambar) {
                $imagePath = $gambar->url;
                if ($this->fileUploadService->fileExists($imagePath)) {
                    $this->fileUploadService->deleteFile($imagePath);
                }
            }
            $article->gambar()->delete();
        }

        $article->delete();

        return redirect()->route('admin.articles.index')->with('success', 'Artikel berhasil dihapus.');
    }
}