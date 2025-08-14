<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Fasilitas;
use App\Models\GaleriLaboratorium;
use Illuminate\Http\Request;

class FacilitiesController extends Controller
{
    public function index()
    {
        // Ambil fasilitas aktif
        $fasilitas = Fasilitas::active()->orderBy('nama')->get();
        
        // Ambil data galeri
        $galeriData = GaleriLaboratorium::all();
        
        return view('user.facilities.facilities', compact('fasilitas', 'galeriData'));
    }
}
