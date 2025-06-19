<?php
// app/Http/Controllers/ArticleController.php

namespace App\Http\Controllers;

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
        return view('articles.index', compact('articles'));
    }

    public function show($id)
    {
        $article = Artikel::with(['gambar' => function($q) {
            $q->where('kategori', 'ACARA');
        }])->findOrFail($id);
        return view('articles.show', compact('article'));
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
