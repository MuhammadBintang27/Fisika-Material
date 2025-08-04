<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kunjungan;
use App\Models\Jadwal;
use Illuminate\Support\Str;

class KunjunganController extends Controller
{
    public function index()
    {
        return view('user.services.visit');
    }

    public function store(Request $request)
    {
        $request->validate([
            'namaPengunjung' => 'required|string|max:255',
            'tujuan' => 'nullable|string',
            'jumlahPengunjung' => 'required|integer|min:1',
            'tanggalKunjungan' => 'required|date|after_or_equal:today',
        ]);
        $kunjungan = Kunjungan::create([
            'id' => (string) Str::uuid(),
            'namaPengunjung' => $request->namaPengunjung,
            'tujuan' => $request->tujuan,
            'jumlahPengunjung' => $request->jumlahPengunjung,
            'status' => 'PENDING',
        ]);
        Jadwal::create([
            'id' => (string) Str::uuid(),
            'kunjunganId' => $kunjungan->id,
            'tanggalMulai' => $request->tanggalKunjungan,
        ]);
        return redirect()->route('kunjungan.form')->with('success', 'Permohonan kunjungan berhasil dikirim! Kami akan menghubungi Anda untuk konfirmasi.');
    }

    public function form()
    {
        return view('user.services.visit');
    }
} 