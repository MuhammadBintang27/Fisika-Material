<?php

namespace App\Http\Controllers\User;    

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Artikel;
use App\Models\Gambar;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Artikel::with(['gambar' => function($q) {
            $q->where('kategori', 'ACARA');
        }])->orderByDesc('tanggalAcara')->get();
        return view('user.articles.index', compact('articles'));
    }

    public function show($id)
    {
        $article = Artikel::with(['gambar' => function($q) {
            $q->where('kategori', 'ACARA');
        }])->findOrFail($id);
        return view('user.articles.show', compact('article'));
    }

    // Method tambahan untuk API
    public function latest()
    {
        $latestArticles = Artikel::orderByDesc('tanggalAcara')->take(5)->get();
        return response()->json($latestArticles);
    }

    public function featured()
    {
        $featuredArticles = Artikel::orderByDesc('tanggalAcara')->take(3)->get();
        return response()->json($featuredArticles);
    }
}
