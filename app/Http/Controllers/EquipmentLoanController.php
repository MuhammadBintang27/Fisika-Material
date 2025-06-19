<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alat;
use App\Models\Peminjaman;
use App\Models\PeminjamanItem;
use Illuminate\Support\Str;

class EquipmentLoanController extends Controller
{
    public function index()
    {
        $equipments = Alat::with(['gambar' => function($q) {
            $q->where('kategori', 'ALAT');
        }])->get();
        // Optionally, build categories dynamically from alat table if needed
        $categories = ['all' => 'Semua Kategori'];
        // ... you can add more logic for categories if you add a category field to alat
        $success = session('success');
        return view('services.equipment-loan', compact('equipments', 'categories', 'success'));
    }

    public function show($id)
    {
        $equipment = Alat::with('gambar')->find($id);
        if (!$equipment) {
            abort(404);
        }
        return view('services.equipment-detail', compact('equipment'));
    }

    public function requestLoan(Request $request)
    {
        $request->validate([
            'namaPeminjam' => 'required|string|max:255',
            'noHp' => 'required|string|max:20',
            'tujuanPeminjaman' => 'nullable|string',
            'tanggal_pinjam' => 'required|date|after_or_equal:today',
            'tanggal_pengembalian' => 'required|date|after:tanggal_pinjam',
            'alat' => 'required',
        ]);
        $alatArr = json_decode($request->alat, true);
        if (!is_array($alatArr) || count($alatArr) < 1) {
            return back()->withErrors(['alat' => 'Pilih minimal satu alat']);
        }
        $peminjaman = Peminjaman::create([
            'id' => Str::uuid(),
            'namaPeminjam' => $request->namaPeminjam,
            'noHp' => $request->noHp,
            'tujuanPeminjaman' => $request->tujuanPeminjaman,
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'tanggal_pengembalian' => $request->tanggal_pengembalian,
            'status' => 'PENDING',
        ]);
        foreach ($alatArr as $item) {
            PeminjamanItem::create([
                'id' => Str::uuid(),
                'peminjamanId' => $peminjaman->id,
                'alat_id' => $item['id'],
                'jumlah' => $item['jumlah'],
            ]);
        }
        return redirect()->route('equipment.loan')->with('success', 'Permohonan peminjaman berhasil dikirim! Kami akan menghubungi Anda dalam 1x24 jam.');
    }

    private function getEquipmentById($id)
    {
        $equipments = $this->getAllEquipments();
        return collect($equipments)->where('id', $id)->first();
    }

    
}
