<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\PeminjamanItem;
use App\Models\Alat;

class LoanController extends Controller
{
    public function index(Request $request)
    {
        $query = Peminjaman::with(['items.alat'])->orderBy('created_at', 'desc');
        
        // Search functionality
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('tracking_code', 'like', "%{$search}%")
                  ->orWhere('namaPeminjam', 'like', "%{$search}%");
            });
        }

        $loans = $query->paginate(15);
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
            'return_conditions' => 'nullable|array', // For COMPLETED status
            'return_conditions.*' => 'nullable|in:BAIK,RUSAK', // Validate each return condition
        ]);

        $loan = Peminjaman::with(['items.alat'])->findOrFail($id);
        $loan->update([
            'status' => $request->status,
            'notes' => $request->notes,
        ]);

        // Handle return conditions for COMPLETED status
        if ($request->status === 'COMPLETED' && $request->has('return_conditions')) {
            foreach ($loan->items as $item) {
                $condition = $request->input('return_conditions.' . $item->id);
                if ($condition) {
                    $item->update(['return_condition' => $condition]);
                    // If the item is returned damaged, decrease the stock
                    if ($condition === 'RUSAK') {
                        $alat = Alat::findOrFail($item->alat_id);
                        $newStock = max(0, $alat->stok - $item->jumlah); // Ensure stock doesn't go negative
                        $alat->update([
                            'stok' => $newStock,
                            'isBroken' => $newStock === 0 ? true : $alat->isBroken, // Mark as broken if no stock left
                        ]);
                    }
                }
            }
        }

        // Compose WhatsApp message
        $wa = preg_replace('/[^0-9]/', '', $loan->noHp);
        if (substr($wa, 0, 1) === '0') {
            $wa = '62' . substr($wa, 1);
        }
        $url = 'https://wa.me/' . $wa . '?text=';
        $msg = '';

        if ($request->status === 'APPROVED') {
            $msg = "Halo *{$loan->namaPeminjam}*,%0A%0A";
            $msg .= "🎉 *Permohonan Peminjaman Alat Anda Telah Disetujui!*%0A%0A";
            $msg .= "📌 *Kode Peminjaman*: {$loan->tracking_code}%0A%0A";
            $msg .= "📋 *Detail Penelitian*:%0A";
            $msg .= "- Judul: " . ($loan->judul_penelitian ?? 'Tidak Ada') . "%0A";
            $msg .= "- Kategori: {$loan->user_type_label}%0A%0A";
            $msg .= "🔧 *Alat yang Disetujui*:%0A";
            foreach ($loan->items as $item) {
                $msg .= "- {$item->alat->nama} ({$item->jumlah} unit)%0A";
            }
            $msg .= "%0A📅 *Jadwal Penelitian*:%0A";
            $msg .= "- Mulai: " . $loan->tanggal_pinjam->format('d M Y H:i') . "%0A";
            $msg .= "- Selesai: " . $loan->tanggal_pengembalian->format('d M Y H:i') . "%0A";
            $msg .= "- Durasi: " . ($loan->durasi_jam ?? 'Tidak Ada') . " jam%0A%0A";
            $msg .= "📍 *Lokasi*:%0A";
            $msg .= "Laboratorium Fisika Material dan Energi%0A";
            $msg .= "Departemen Fisika, Universitas Syiah Kuala%0A%0A";
            $msg .= "📢 *Langkah Selanjutnya*:%0A";
            $msg .= "Silakan hubungi admin laboratorium untuk koordinasi lebih lanjut.%0A";
            $msg .= "Terima kasih dan sukses untuk penelitian Anda! 🌟";
        } elseif ($request->status === 'REJECTED') {
            $msg = "Halo *{$loan->namaPeminjam}*,%0A%0A";
            $msg .= "❌ *Permohonan Peminjaman Alat Anda Tidak Dapat Dipenuhi* %0A%0A";
            $msg .= "📌 *Kode Peminjaman*: {$loan->tracking_code}%0A%0A";
            $msg .= "📋 *Detail Pengajuan*:%0A";
            $msg .= "- Judul Penelitian: " . ($loan->judul_penelitian ?? 'Tidak Ada') . "%0A";
            $msg .= "- Tanggal Pengajuan: " . $loan->created_at->format('d M Y') . "%0A%0A";
            if ($request->notes) {
                $msg .= "📝 *Catatan Penolakan*:%0A{$request->notes}%0A%0A";
            }
            $msg .= "🙏 Terima kasih atas pengertiannya. Anda dapat mengajukan ulang di waktu yang lebih sesuai.";
        } elseif ($request->status === 'COMPLETED') {
            $msg = "Halo *{$loan->namaPeminjam}*,%0A%0A";
            $msg .= "✅ *Peminjaman Alat Anda Telah Selesai* %0A%0A";
            $msg .= "📌 *Kode Peminjaman*: {$loan->tracking_code}%0A%0A";
            $msg .= "📋 *Detail Penelitian*:%0A";
            $msg .= "- Judul: " . ($loan->judul_penelitian ?? 'Tidak Ada') . "%0A";
            $msg .= "- Kategori: {$loan->user_type_label}%0A%0A";
            $msg .= "🔧 *Alat yang Dikembalikan*:%0A";
            foreach ($loan->items as $item) {
                $condition = $item->return_condition ?? 'Tidak Diketahui';
                $conditionText = $condition === 'BAIK' ? '✅ Baik' : ($condition === 'RUSAK' ? '❌ Rusak' : 'ℹ️ Tidak Diketahui');
                $msg .= "- {$item->alat->nama} ({$item->jumlah} unit) - {$conditionText}%0A";
            }
            $msg .= "%0A📅 *Periode Peminjaman*:%0A";
            $msg .= "- Mulai: " . $loan->tanggal_pinjam->format('d M Y H:i') . "%0A";
            $msg .= "- Selesai: " . $loan->tanggal_pengembalian->format('d M Y H:i') . "%0A%0A";
            $msg .= "📝 *Catatan*:%0A";
            $msg .= "Jika ada alat yang dikembalikan dalam keadaan rusak, mohon maaf atas ketidaknyamanannya. Silakan hubungi admin untuk informasi lebih lanjut.%0A%0A";
            $msg .= "🙏 Terima kasih telah menggunakan fasilitas Laboratorium Fisika Material dan Energi, Universitas Syiah Kuala.%0A";
            $msg .= "Semoga penelitian Anda sukses! 🌟";
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
        $loans = Peminjaman::with(['items.alat'])
            ->where('status', 'REJECTED')
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        return view('admin.loans.rejected', compact('loans'));
    }
}