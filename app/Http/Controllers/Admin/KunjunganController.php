<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kunjungan;
use Illuminate\Support\Str;

class KunjunganController extends Controller
{
    public function index()
    {
        $kunjungan = Kunjungan::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.kunjungan.index', compact('kunjungan'));
    }

    public function show($id)
    {
        $kunjungan = Kunjungan::findOrFail($id);
        return view('admin.kunjungan.show', compact('kunjungan'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:PENDING,PROCESSING,COMPLETED,CANCELLED',
        ]);
        $kunjungan = Kunjungan::findOrFail($id);
        $kunjungan->status = $request->status;
        $kunjungan->save();
        return redirect()->route('admin.kunjungan.index')->with('success', 'Status kunjungan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $kunjungan = Kunjungan::findOrFail($id);
        $kunjungan->delete();
        return redirect()->route('admin.kunjungan.index')->with('success', 'Kunjungan berhasil dihapus.');
    }
} 
 