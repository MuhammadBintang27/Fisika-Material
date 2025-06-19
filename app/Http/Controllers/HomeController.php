<?php

namespace App\Http\Controllers;
use App\Models\ProfilLaboratorium;
use App\Models\Misi;
use App\Models\Artikel;

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

        return view('home', compact('featuredArticles', 'profil', 'misis'));
    }

    public function about()
    {
        return view('about');
    }

    public function equipment()
    {
        // Data equipment untuk halaman terpisah
        $equipment = [
            [
                'name' => 'Seismometer',
                'description' => 'Alat pengukur aktivitas seismik dengan presisi tinggi untuk monitoring gempa bumi',
                'image' => 'images/seismometer.jpg',
                'category' => 'Geofisika'
            ],
            [
                'name' => 'Magnetometer',
                'description' => 'Instrumen untuk mengukur medan magnet bumi dan anomali magnetik',
                'image' => 'images/magnetometer.jpg',
                'category' => 'Geofisika'
            ],
            [
                'name' => 'Ground Penetrating Radar',
                'description' => 'Teknologi radar untuk pemetaan struktur bawah permukaan',
                'image' => 'images/gpr.jpg',
                'category' => 'Geofisika'
            ],
            [
                'name' => 'GPS Geodetik',
                'description' => 'Sistem positioning dengan akurasi centimeter untuk survei geodetik',
                'image' => 'images/gps-geodetik.jpg',
                'category' => 'Geodesi'
            ],
            [
                'name' => 'Resistivity Meter',
                'description' => 'Alat ukur resistivitas untuk eksplorasi bawah permukaan',
                'image' => 'images/resistivity-meter.jpg',
                'category' => 'Geofisika'
            ],
            [
                'name' => 'Gravimeter',
                'description' => 'Instrumen untuk mengukur variasi gravitasi bumi',
                'image' => 'images/gravimeter.jpg',
                'category' => 'Geofisika'
            ],
            [
                'name' => 'Osiloskop Digital',
                'description' => 'Alat untuk menganalisis sinyal listrik dan gelombang dengan presisi tinggi',
                'image' => 'images/oscilloscope.jpg',
                'category' => 'Elektronika'
            ],
            [
                'name' => 'Spektrometer',
                'description' => 'Instrumen untuk menganalisis spektrum cahaya dan radiasi elektromagnetik',
                'image' => 'images/spectrometer.jpg',
                'category' => 'Optik'
            ],
            [
                'name' => 'Generator Fungsi',
                'description' => 'Perangkat untuk menghasilkan berbagai bentuk gelombang listrik',
                'image' => 'images/function-generator.jpg',
                'category' => 'Elektronika'
            ],
            [
                'name' => 'Multimeter Digital',
                'description' => 'Alat ukur listrik serbaguna untuk tegangan, arus, dan resistansi',
                'image' => 'images/multimeter.jpg',
                'category' => 'Elektronika'
            ],
            [
                'name' => 'Power Supply',
                'description' => 'Sumber daya listrik DC yang dapat diatur dengan presisi tinggi',
                'image' => 'images/power-supply.jpg',
                'category' => 'Elektronika'
            ],
            [
                'name' => 'Interferometer',
                'description' => 'Instrumen untuk mengukur panjang gelombang dan indeks bias dengan akurasi tinggi',
                'image' => 'images/interferometer.jpg',
                'category' => 'Optik'
            ]
        ];

        return view('equipment', compact('equipment'));
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
