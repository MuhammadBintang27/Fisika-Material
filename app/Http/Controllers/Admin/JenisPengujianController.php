<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JenisPengujian;
use Illuminate\Support\Str;

class JenisPengujianController extends Controller
{
    public function index()
    {
        $jenisPengujian = JenisPengujian::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.jenis-pengujian.index', compact('jenisPengujian'));
    }

    public function create()
    {
        return view('admin.jenis-pengujian.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'namaPengujian' => 'required|string|max:255',
            'hargaPerSampel' => 'required|integer|min:0',
            'isAvailable' => 'boolean',
        ]);

        JenisPengujian::create([
            'id' => (string) Str::uuid(),
            'namaPengujian' => $request->namaPengujian,
            'hargaPerSampel' => $request->hargaPerSampel,
            'isAvailable' => $request->has('isAvailable'),
        ]);

        return redirect()->route('admin.jenis-pengujian.index')->with('success', 'Jenis pengujian berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $jenisPengujian = JenisPengujian::findOrFail($id);
        return view('admin.jenis-pengujian.edit', compact('jenisPengujian'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'namaPengujian' => 'required|string|max:255',
            'hargaPerSampel' => 'required|integer|min:0',
            'isAvailable' => 'boolean',
        ]);

        $jenisPengujian = JenisPengujian::findOrFail($id);
        $jenisPengujian->update([
            'namaPengujian' => $request->namaPengujian,
            'hargaPerSampel' => $request->hargaPerSampel,
            'isAvailable' => $request->has('isAvailable'),
        ]);

        return redirect()->route('admin.jenis-pengujian.index')->with('success', 'Jenis pengujian berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $jenisPengujian = JenisPengujian::findOrFail($id);
        $jenisPengujian->delete();

        return redirect()->route('admin.jenis-pengujian.index')->with('success', 'Jenis pengujian berhasil dihapus.');
    }
} 
 