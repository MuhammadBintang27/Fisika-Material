<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProfilLaboratorium;
use App\Models\Misi;
use Illuminate\Support\Str;

class AboutController extends Controller
{
    public function index()
    {
        $profil = ProfilLaboratorium::with('misi')->first();
        $misis = Misi::all();
        return view('admin.about.index', compact('profil', 'misis'));
    }

    public function edit()
    {
        $profil = ProfilLaboratorium::first();
        $misis = Misi::all();
        return view('admin.about.edit', compact('profil', 'misis'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'namaLaboratorium' => 'required|string|max:255',
            'tentangLaboratorium' => 'required|string',
            'visi' => 'required|string',
            'misi' => 'required|array',
            'misi.*' => 'required|string',
        ]);

        $profil = ProfilLaboratorium::first();
        
        if (!$profil) {
            $profil = new ProfilLaboratorium();
        }

        $profil->namaLaboratorium = $request->namaLaboratorium;
        $profil->tentangLaboratorium = $request->tentangLaboratorium;
        $profil->visi = $request->visi;
        $profil->save();

        // Update misi
        Misi::truncate(); // Hapus semua misi lama
        foreach ($request->misi as $pointMisi) {
            Misi::create([
                'pointMisi' => $pointMisi,
                'profilLaboratoriumId' => $profil->id,
            ]);
        }

        return redirect()->route('admin.about.index')->with('success', 'Profil laboratorium berhasil diperbarui.');
    }
} 
 