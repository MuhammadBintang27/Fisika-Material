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
        
        // Don't update status immediately, just prepare WhatsApp message
        // Status will be updated after admin confirms in preview page
        
        // Handle return conditions for COMPLETED status
        if ($request->status === 'COMPLETED' && ($request->has('return_baik') || $request->has('return_rusak'))) {
            foreach ($loan->items as $item) {
                $jumlah_baik = (int) $request->input('return_baik.' . $item->id, 0);
                $jumlah_rusak = (int) $request->input('return_rusak.' . $item->id, 0);
                $jumlah_total = $item->jumlah;
                // Validasi: baik + rusak = jumlah dipinjam
                if ($jumlah_baik + $jumlah_rusak !== $jumlah_total) {
                    return back()->withErrors(['return_baik' => 'Jumlah baik + rusak harus sama dengan jumlah dipinjam'])->withInput();
                }
                $alat = Alat::findOrFail($item->alat_id);
                // Update stok dipinjam
                $alat->stok_dipinjam = max(0, $alat->stok_dipinjam - $jumlah_total);
                // Update stok baik
                if ($jumlah_baik > 0) {
                    $alat->stok += $jumlah_baik;
                }
                // Update stok rusak
                if ($jumlah_rusak > 0) {
                    $alat->stok_rusak += $jumlah_rusak;
                }
                $alat->save();
                // Simpan kondisi ke item (opsional, bisa disesuaikan)
                $item->update([
                    'return_condition' => $jumlah_rusak > 0 ? 'RUSAK' : 'BAIK',
                ]);
            }
        }

        // Compose WhatsApp message
        $wa = preg_replace('/[^0-9]/', '', $loan->noHp);
        if (substr($wa, 0, 1) === '0') {
            $wa = '62' . substr($wa, 1);
        }
        $url = 'https://wa.me/' . $wa . '?text=';
        $msg = '';

        // Header selalu sama
        $header = "Selamat datang di *Laboratorium Fisika Material dan Energi*,\n";
        $header .= "_Departemen Fisika, Universitas Syiah Kuala_\n\n";
        $header .= "Halo *{$loan->namaPeminjam}*,\n\n";

        if ($request->status === 'APPROVED') {
            $msg .= $header;
            $msg .= "Permohonan peminjaman alat Anda telah *DISETUJUI*. Berikut detail peminjaman Anda:\n\n";
            $msg .= "*Kode Peminjaman*: {$loan->tracking_code}\n\n";
            $msg .= "*Detail Penelitian*:\n";
            $msg .= "- Judul: " . ($loan->judul_penelitian ?? 'Tidak Ada') . "\n";
            $msg .= "- Kategori: {$loan->user_type_label}\n\n";
            $msg .= "🔧 *Alat yang Disetujui*:\n";
            foreach ($loan->items as $item) {
                $msg .= "- {$item->alat->nama} ({$item->jumlah} unit)\n";
            }
            $msg .= "\n*Jadwal Penelitian*:\n";
            $msg .= "- Mulai: " . $loan->tanggal_pinjam->format('d M Y H:i') . "\n";
            $msg .= "- Selesai: " . $loan->tanggal_pengembalian->format('d M Y H:i') . "\n";
            $msg .= "- Durasi: " . ($loan->durasi_jam ?? 'Tidak Ada') . " jam\n\n";
            $msg .= "*Lokasi*:\n";
            $msg .= "Laboratorium Fisika Material dan Energi\n";
            $msg .= "Departemen Fisika, Universitas Syiah Kuala\n\n";
            $msg .= "*Langkah Selanjutnya*:\n";
            $msg .= "Silakan menghubungi admin laboratorium untuk koordinasi pengambilan alat dan persiapan penelitian Anda.\n\n";
            $msg .= "Terima kasih dan sukses selalu untuk penelitian Anda! 🌟";
        } elseif ($request->status === 'REJECTED') {
            $msg .= $header;
            $msg .= "Kami informasikan bahwa permohonan peminjaman alat Anda *TIDAK DAPAT DIPENUHI*. Berikut informasinya:\n\n";
            $msg .= "*Kode Peminjaman*: {$loan->tracking_code}\n\n";
            $msg .= "*Detail Pengajuan*:\n";
            $msg .= "- Judul Penelitian: " . ($loan->judul_penelitian ?? 'Tidak Ada') . "\n";
            $msg .= "- Tanggal Pengajuan: " . $loan->created_at->format('d M Y') . "\n\n";
            if ($request->notes) {
                $msg .= "*Catatan Penolakan*:\n{$request->notes}\n\n";
            }
            $msg .= "Kami mohon maaf atas ketidaknyamanan ini. Anda dapat mengajukan permohonan kembali di waktu yang akan datang.\n";
            $msg .= "Terima kasih.";
        } elseif ($request->status === 'COMPLETED') {
            $msg .= $header;
            $msg .= "Peminjaman alat Anda telah *SELESAI*. Berikut ringkasan peminjaman:\n\n";
            $msg .= "*Kode Peminjaman*: {$loan->tracking_code}\n\n";
            $msg .= "*Detail Penelitian*:\n";
            $msg .= "- Judul: " . ($loan->judul_penelitian ?? 'Tidak Ada') . "\n";
            $msg .= "- Kategori: {$loan->user_type_label}\n\n";
            $msg .= "🔧 *Alat yang Dikembalikan*:\n";
            foreach ($loan->items as $item) {
                $condition = $item->return_condition ?? 'Tidak Diketahui';
                $conditionText = $condition === 'BAIK' ? '✅ Baik' : ($condition === 'RUSAK' ? '❌ Rusak' : 'ℹ️ Tidak Diketahui');
                $msg .= "- {$item->alat->nama} ({$item->jumlah} unit) - {$conditionText}\n";
            }
            $msg .= "\n*Periode Peminjaman*:\n";
            $msg .= "- Mulai: " . $loan->tanggal_pinjam->format('d M Y H:i') . "\n";
            $msg .= "- Selesai: " . $loan->tanggal_pengembalian->format('d M Y H:i') . "\n\n";
            $msg .= "*Catatan*:\n";
            $msg .= "Jika ada alat yang mengalami kerusakan, mohon segera berkoordinasi dengan admin laboratorium.\n\n";
            $msg .= "Terima kasih telah menggunakan fasilitas kami. Semoga penelitian Anda sukses! 🌟";
        }

        // Redirect to WhatsApp preview page instead of direct WhatsApp
        if ($msg) {
            $whatsappUrl = $url . urlencode($msg);
            
            // Store data in session including the intended status
            session([
                'whatsapp_url' => $whatsappUrl,
                'whatsapp_message' => $msg,
                'whatsapp_phone' => $wa,
                'intended_status' => $request->status,
                'intended_notes' => $request->notes
            ]);
            
            return redirect()->route('admin.loans.whatsapp-preview', $loan->id);
        }
        
        return redirect()->route('admin.loans.show', $id)->with('success', 'Status peminjaman berhasil diperbarui.');
    }

    public function confirmStatusUpdate(Request $request, $id)
    {
        $loan = Peminjaman::with(['items.alat'])->findOrFail($id);
        
        // Get intended status from session
        $intendedStatus = session('intended_status');
        $intendedNotes = session('intended_notes');
        
        if (!$intendedStatus) {
            return redirect()->route('admin.loans.show', $id)->with('error', 'Data status tidak ditemukan.');
        }
        
        // Update the loan status
        $loan->update([
            'status' => $intendedStatus,
            'notes' => $intendedNotes,
        ]);

        // Jika status berubah ke APPROVED, kurangi stok tersedia dan tambah stok_dipinjam
        if ($intendedStatus === 'APPROVED') {
            foreach ($loan->items as $item) {
                $alat = $item->alat;
                if ($alat) {
                    $newStock = max(0, $alat->stok - $item->jumlah);
                    $newDipinjam = $alat->stok_dipinjam + $item->jumlah;
                    $alat->update([
                        'stok' => $newStock,
                        'stok_dipinjam' => $newDipinjam,
                    ]);
                }
            }
        }
        
        // Clear session data
        session()->forget(['whatsapp_url', 'whatsapp_message', 'whatsapp_phone', 'intended_status', 'intended_notes']);
        
        return redirect()->route('admin.loans.show', $id)->with('success', 'Status peminjaman berhasil diperbarui.');
    }

    public function whatsappPreview(Request $request, $id)
    {
        $loan = Peminjaman::with(['items.alat'])->findOrFail($id);
        
        // Get data from session
        $whatsappUrl = session('whatsapp_url');
        $message = session('whatsapp_message');
        $phone = session('whatsapp_phone');
        
        // If no session data, redirect back
        if (!$whatsappUrl || !$message || !$phone) {
            return redirect()->route('admin.loans.show', $id)->with('error', 'Data WhatsApp tidak ditemukan.');
        }
        
        return view('admin.loans.whatsapp-preview', compact('loan', 'whatsappUrl', 'message', 'phone'));
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

    public function pending(Request $request)
    {
        $query = Peminjaman::with(['items.alat'])
            ->where('status', 'PENDING')
            ->orderBy('created_at', 'desc');
        
        // Search functionality
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('tracking_code', 'like', "%{$search}%")
                  ->orWhere('namaPeminjam', 'like', "%{$search}%");
            });
        }

        $loans = $query->paginate(15);
        return view('admin.loans.pending', compact('loans'));
    }

    public function approved(Request $request)
    {
        $query = Peminjaman::with(['items.alat'])
            ->where('status', 'APPROVED')
            ->orderBy('created_at', 'desc');
        
        // Search functionality
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('tracking_code', 'like', "%{$search}%")
                  ->orWhere('namaPeminjam', 'like', "%{$search}%");
            });
        }

        $loans = $query->paginate(15);
        return view('admin.loans.approved', compact('loans'));
    }

    public function completed(Request $request)
    {
        $query = Peminjaman::with(['items.alat'])
            ->where('status', 'COMPLETED')
            ->orderBy('created_at', 'desc');
        
        // Search functionality
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('tracking_code', 'like', "%{$search}%")
                  ->orWhere('namaPeminjam', 'like', "%{$search}%");
            });
        }

        $loans = $query->paginate(15);
        return view('admin.loans.completed', compact('loans'));
    }

    public function rejected(Request $request)
    {
        $query = Peminjaman::with(['items.alat'])
            ->where('status', 'REJECTED')
            ->orderBy('created_at', 'desc');
        
        // Search functionality
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('tracking_code', 'like', "%{$search}%")
                  ->orWhere('namaPeminjam', 'like', "%{$search}%");
            });
        }

        $loans = $query->paginate(15);
        return view('admin.loans.rejected', compact('loans'));
    }
}