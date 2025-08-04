<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JenisPengujian;
use App\Models\Pengujian;
use App\Models\PengujianItem;
use Illuminate\Support\Str;

class TestingServicesController extends Controller
{
    public function index()
    {
        $jenisPengujian = JenisPengujian::where('isAvailable', true)->get();
        return view('user.services.testing-services', compact('jenisPengujian'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'namaPenguji' => 'required|string|max:255',
            'noHpPenguji' => 'required|string|max:20',
            'deskripsi' => 'required|string',
            'tanggalPengujian' => 'required|date|after_or_equal:today',
            'jenisPengujianIds' => 'required|array|min:1',
            'jenisPengujianIds.*' => 'exists:jenis_pengujian,id',
        ]);
        $jenisList = JenisPengujian::whereIn('id', $request->jenisPengujianIds)->get();
        $totalHarga = $jenisList->sum('hargaPerSampel');
        $pengujian = Pengujian::create([
            'id' => (string) Str::uuid(),
            'namaPenguji' => $request->namaPenguji,
            'noHpPenguji' => $request->noHpPenguji,
            'deskripsi' => $request->deskripsi,
            'totalHarga' => $totalHarga,
            'tanggalPengujian' => $request->tanggalPengujian,
            'status' => 'PENDING',
        ]);
        foreach ($jenisList as $jenis) {
            PengujianItem::create([
                'id' => (string) Str::uuid(),
                'jenisPengujianId' => $jenis->id,
                'pengujianId' => $pengujian->id,
            ]);
        }
        return redirect()->route('pengujian.index')->with('success', 'Permohonan pengujian berhasil dikirim! Kami akan menghubungi Anda dalam 1x24 jam.');
    }
}

