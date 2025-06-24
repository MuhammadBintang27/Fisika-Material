<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\PeminjamanItem;

class LoanController extends Controller
{
    public function index()
    {
        $loans = Peminjaman::with(['items.alat'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        return view('admin.loans.index', compact('loans'));
    }

    public function show($id)
    {
        $loan = Peminjaman::with(['items.alat'])->findOrFail($id);
        return view('admin.loans.show', compact('loan'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:PENDING,APPROVED,REJECTED,COMPLETED',
            'notes' => 'nullable|string',
        ]);

        $loan = Peminjaman::with(['items.alat'])->findOrFail($id);
        $loan->update([
            'status' => $request->status,
            'notes' => $request->notes,
        ]);

        // Compose WhatsApp message
        $wa = preg_replace('/[^0-9]/', '', $loan->noHp);
        if (substr($wa, 0, 1) === '0') {
            $wa = '62' . substr($wa, 1);
        }
        $url = 'https://wa.me/' . $wa . '?text=';
        if ($request->status === 'APPROVED') {
            $msg = "Halo $loan->namaPeminjam, permohonan peminjaman alat Anda telah DISETUJUI.%0A";
            $msg .= "Detail alat:%0A";
            foreach ($loan->items as $item) {
                $msg .= "- $item->alat->nama ($item->jumlah unit)%0A";
            }
            $msg .= "Tanggal Pinjam: " . date('d M Y', strtotime($loan->tanggal_pinjam)) . "%0A";
            $msg .= "Tanggal Kembali: " . date('d M Y', strtotime($loan->tanggal_pengembalian)) . "%0A";
            $msg .= "Silakan koordinasi lebih lanjut dengan admin.";
        } elseif ($request->status === 'REJECTED') {
            $msg = "Mohon maaf, permohonan peminjaman alat Anda TIDAK DAPAT DIPENUHI untuk saat ini. Terima kasih atas pengertiannya.";
        } else {
            $msg = null;
        }
        if ($msg) {
            $url .= urlencode($msg);
            return redirect($url);
        }
        return redirect()->route('admin.loans.show', $id)->with('success', 'Status peminjaman berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $loan = Peminjaman::with('items')->findOrFail($id);
        
        // Hapus semua item peminjaman
        $loan->items()->delete();
        
        // Hapus peminjaman
        $loan->delete();

        return redirect()->route('admin.loans.index')->with('success', 'Data peminjaman berhasil dihapus.');
    }

    public function pending()
    {
        $loans = Peminjaman::with(['items.alat'])
            ->where('status', 'PENDING')
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        return view('admin.loans.pending', compact('loans'));
    }

    public function approved()
    {
        $loans = Peminjaman::with(['items.alat'])
            ->where('status', 'APPROVED')
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        return view('admin.loans.approved', compact('loans'));
    }

    public function completed()
    {
        $loans = Peminjaman::with(['items.alat'])
            ->where('status', 'COMPLETED')
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        return view('admin.loans.completed', compact('loans'));
    }

    public function rejected()
    {
        $loans = \App\Models\Peminjaman::with(['items.alat'])
            ->where('status', 'REJECTED')
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        return view('admin.loans.rejected', compact('loans'));
    }
} 
 