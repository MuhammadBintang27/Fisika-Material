<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;

use App\Models\ProfilLaboratorium;
use App\Models\Misi;
use App\Models\Artikel;
use App\Models\GaleriLaboratorium;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Data untuk artikel yang ditampilkan di beranda (3 artikel terbaru)
        $featuredArticles = Artikel::with('gambar')->orderByDesc('tanggalAcara')->take(3)->get();

        $profil = ProfilLaboratorium::with('misi')->first();
        $misis = Misi::all();
        // Dummy fallback jika belum ada data di database
        if (!$profil) {
            $profil = (object) [
                'namaLaboratorium' => 'Fisika Lanjutan',
                'tentangLaboratorium' => 'Laboratorium Fisika Lanjutan merupakan fasilitas unggulan yang berkomitmen untuk mengembangkan penelitian dan pendidikan di bidang fisika dengan teknologi terdepan.',
                'visi' => 'Menjadi laboratorium fisika terdepan di Indonesia yang berkontribusi dalam penelitian dan pengembangan ilmu fisika untuk kemajuan bangsa.'
            ];
        }
        if ($misis->isEmpty()) {
            $misis = collect([
                (object) ['pointMisi' => 'Menyediakan fasilitas penelitian fisika berkualitas tinggi'],
                (object) ['pointMisi' => 'Mengembangkan sumber daya manusia di bidang fisika'],
                (object) ['pointMisi' => 'Berkolaborasi dalam penelitian bertaraf internasional'],
            ]);
        }

        $galeriLaboratorium = GaleriLaboratorium::all();

        return view('user.home.home', compact('featuredArticles', 'profil', 'misis', 'galeriLaboratorium'));
    }

    public function about()
    {
        return view('about');
    }

    

    public function services()
    {
        return view('services');
    }

    public function contact()
    {
        return view('contact');
    }
}
