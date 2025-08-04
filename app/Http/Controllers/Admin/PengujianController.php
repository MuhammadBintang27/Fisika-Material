<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pengujian;
use App\Models\JenisPengujian;
use Illuminate\Support\Str;

class PengujianController extends Controller
{
    public function index(Request $request)
    {
        $query = Pengujian::with('pengujianItems.jenisPengujian')->orderBy('created_at', 'desc');

        // Filter berdasarkan status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter berdasarkan rentang tanggal
        if ($request->filled('start_date')) {
            $query->whereDate('tanggalPengujian', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('tanggalPengujian', '<=', $request->end_date);
        }

        $pengujian = $query->paginate(10)->withQueryString();
        
        return view('admin.pengujian.index', compact('pengujian'));
    }

    public function create()
    {
        $jenisPengujian = JenisPengujian::where('isAvailable', true)->get();
        return view('admin.pengujian.create', compact('jenisPengujian'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'namaPenguji' => 'required|string|max:255',
            'noHpPenguji' => 'required|string|max:20',
            'deskripsi' => 'required|string',
            'totalHarga' => 'required|integer|min:0',
            'tanggalPengujian' => 'required|date',
            'status' => 'required|in:PENDING,PROCESSING,COMPLETED,CANCELLED',
            'jenisPengujianIds' => 'required|array|min:1',
            'jenisPengujianIds.*' => 'exists:jenis_pengujian,id',
        ]);

        $pengujian = Pengujian::create([
            'id' => (string) Str::uuid(),
            'namaPenguji' => $request->namaPenguji,
            'noHpPenguji' => $request->noHpPenguji,
            'deskripsi' => $request->deskripsi,
            'totalHarga' => $request->totalHarga,
            'tanggalPengujian' => $request->tanggalPengujian,
            'status' => $request->status,
        ]);

        // Attach jenis pengujian
        foreach ($request->jenisPengujianIds as $jenisPengujianId) {
            $pengujian->pengujianItems()->create([
                'id' => (string) Str::uuid(),
                'jenisPengujianId' => $jenisPengujianId,
                'pengujianId' => $pengujian->id,
            ]);
        }

        return redirect()->route('admin.pengujian.index')->with('success', 'Pengujian berhasil ditambahkan.');
    }

    public function show($id)
    {
        $pengujian = Pengujian::with('pengujianItems.jenisPengujian')->findOrFail($id);
        return view('admin.pengujian.show', compact('pengujian'));
    }

    public function edit($id)
    {
        $pengujian = Pengujian::with('pengujianItems')->findOrFail($id);
        $jenisPengujian = JenisPengujian::where('isAvailable', true)->get();
        return view('admin.pengujian.edit', compact('pengujian', 'jenisPengujian'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'namaPenguji' => 'required|string|max:255',
            'noHpPenguji' => 'required|string|max:20',
            'deskripsi' => 'required|string',
            'totalHarga' => 'required|integer|min:0',
            'tanggalPengujian' => 'required|date',
            'status' => 'required|in:PENDING,PROCESSING,COMPLETED,CANCELLED',
            'jenisPengujianIds' => 'required|array|min:1',
            'jenisPengujianIds.*' => 'exists:jenis_pengujian,id',
        ]);

        $pengujian = Pengujian::findOrFail($id);
        $pengujian->update([
            'namaPenguji' => $request->namaPenguji,
            'noHpPenguji' => $request->noHpPenguji,
            'deskripsi' => $request->deskripsi,
            'totalHarga' => $request->totalHarga,
            'tanggalPengujian' => $request->tanggalPengujian,
            'status' => $request->status,
        ]);

        // Update jenis pengujian
        $pengujian->pengujianItems()->delete();
        foreach ($request->jenisPengujianIds as $jenisPengujianId) {
            $pengujian->pengujianItems()->create([
                'id' => (string) Str::uuid(),
                'jenisPengujianId' => $jenisPengujianId,
                'pengujianId' => $pengujian->id,
            ]);
        }

        return redirect()->route('admin.pengujian.index')->with('success', 'Pengujian berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $pengujian = Pengujian::findOrFail($id);
        $pengujian->delete();

        return redirect()->route('admin.pengujian.index')->with('success', 'Pengujian berhasil dihapus.');
    }

    public function approve($id)
    {
        $pengujian = Pengujian::findOrFail($id);
        if ($pengujian->status === 'PENDING') {
            $pengujian->status = 'PROCESSING';
            $pengujian->save();
        }
        return redirect()->route('admin.pengujian.show', $id)->with('success', 'Pengujian disetujui dan diproses.');
    }

    public function reject($id)
    {
        $pengujian = Pengujian::findOrFail($id);
        if ($pengujian->status === 'PENDING') {
            $pengujian->status = 'CANCELLED';
            $pengujian->save();
        }
        return redirect()->route('admin.pengujian.show', $id)->with('success', 'Pengujian ditolak.');
    }
} 
 