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
            'status' => 'required|in:PENDING,APPROVED,ONGOING,REJECTED,COMPLETED',
            'notes' => 'nullable|string',
            'return_baik' => 'nullable|array',
            'return_rusak' => 'nullable|array',
        ]);

        $loan = Peminjaman::with(['items.alat'])->findOrFail($id);
        
        // Store intended status and notes in session
        session([
            'intended_status' => $request->status,
            'intended_notes' => $request->input('notes', ''),
        ]);

        // Prepare WhatsApp message
        $wa = preg_replace('/[^0-9]/', '', $loan->noHp);
        if (substr($wa, 0, 1) === '0') {
            $wa = '62' . substr($wa, 1);
        }
        $url = 'https://wa.me/' . $wa . '?text=';
        $msg = '';

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
            $msg .= "Silakan unduh surat peminjaman dan bawa saat pengambilan alat di laboratorium.\n\n";
            $msg .= "Terima kasih dan sukses selalu untuk penelitian Anda! 🌟";
        } elseif ($request->status === 'ONGOING') {
            $msg .= $header;
            $msg .= "Peminjaman alat Anda telah resmi *BERLANGSUNG*. Berikut detail peminjaman Anda:\n\n";
            $msg .= "*Kode Peminjaman*: {$loan->tracking_code}\n\n";
            $msg .= "*Detail Penelitian*:\n";
            $msg .= "- Judul: " . ($loan->judul_penelitian ?? 'Tidak Ada') . "\n";
            $msg .= "- Kategori: {$loan->user_type_label}\n\n";
            $msg .= "🔧 *Alat yang Dipinjam*:\n";
            foreach ($loan->items as $item) {
                $msg .= "- {$item->alat->nama} ({$item->jumlah} unit)\n";
            }
            $msg .= "\n*Jadwal Peminjaman*:\n";
            $msg .= "- Mulai: " . $loan->tanggal_pinjam->format('d M Y H:i') . "\n";
            $msg .= "- Selesai: " . $loan->tanggal_pengembalian->format('d M Y H:i') . "\n";
            $msg .= "- Durasi: " . ($loan->durasi_jam ?? 'Tidak Ada') . " jam\n\n";
            $msg .= "*Peringatan*:\n";
            $msg .= "Harap kembalikan alat tepat waktu sesuai jadwal untuk menghindari denda atau sanksi.\n\n";
            $msg .= "Terima kasih dan sukses untuk penelitian Anda! 🌟";
        } elseif ($request->status === 'REJECTED') {
            $msg .= $header;
            $msg .= "Kami informasikan bahwa permohonan peminjaman alat Anda *TIDAK DAPAT DIPENUHI*. Berikut informasinya:\n\n";
            $msg .= "*Kode Peminjaman*: {$loan->tracking_code}\n\n";
            $msg .= "*Alasan Penolakan*:\n";
            $msg .= $request->input('notes', 'Tidak ada alasan spesifik yang diberikan.') . "\n\n";
            $msg .= "Jika Anda memiliki pertanyaan, silakan hubungi admin laboratorium.\n\n";
            $msg .= "Terima kasih atas pengertian Anda.";
        } elseif ($request->status === 'COMPLETED') {
            $msg .= $header;
            $msg .= "Peminjaman alat Anda telah *SELESAI*. Berikut detail pengembalian:\n\n";
            $msg .= "*Kode Peminjaman*: {$loan->tracking_code}\n\n";
            $msg .= "*Detail Pengembalian*:\n";
            foreach ($loan->items as $item) {
                $baik = $request->input('return_baik.' . $item->id, 0);
                $rusak = $request->input('return_rusak.' . $item->id, 0);
                $msg .= "- {$item->alat->nama}: {$baik} baik, {$rusak} rusak\n";
            }
            $msg .= "\n*Tanggal Pengembalian*: " . $loan->tanggal_pengembalian->format('d M Y H:i') . "\n\n";
            $msg .= "Terima kasih telah menggunakan fasilitas Laboratorium Fisika Material dan Energi.\n";
            $msg .= "Sukses selalu untuk penelitian Anda! 🌟";
        }

        // Store WhatsApp data in session
        session([
            'whatsapp_url' => $url . urlencode($msg),
            'whatsapp_message' => $msg,
            'whatsapp_phone' => $wa,
        ]);

        // Handle return conditions for COMPLETED status
        if ($request->status === 'COMPLETED' && ($request->has('return_baik') || $request->has('return_rusak'))) {
            foreach ($loan->items as $item) {
                $jumlah_baik = (int) $request->input('return_baik.' . $item->id, 0);
                $jumlah_rusak = (int) $request->input('return_rusak.' . $item->id, 0);
                $jumlah_total = $item->jumlah;

                if ($jumlah_baik + $jumlah_rusak !== $jumlah_total) {
                    return back()->withErrors(['return_baik' => 'Jumlah baik + rusak harus sama dengan jumlah dipinjam'])->withInput();
                }

                $alat = Alat::findOrFail($item->alat_id);
                $alat->stok_dipinjam = max(0, $alat->stok_dipinjam - $jumlah_total);
                if ($jumlah_baik > 0) {
                    $alat->stok += $jumlah_baik;
                }
                if ($jumlah_rusak > 0) {
                    $alat->stok_rusak += $jumlah_rusak;
                }
                $alat->save();

                $item->update([
                    'return_condition' => $jumlah_rusak > 0 ? 'RUSAK' : 'BAIK',
                ]);
            }
        }

        return redirect()->route('admin.loans.whatsapp-preview', $id);
    }

    public function confirmStatusUpdate(Request $request, $id)
    {
        $loan = Peminjaman::with(['items.alat'])->findOrFail($id);
        
        $intendedStatus = session('intended_status');
        $intendedNotes = session('intended_notes');
        
        if (!$intendedStatus) {
            return redirect()->route('admin.loans.show', $id)->with('error', 'Data status tidak ditemukan.');
        }
        
        $loan->update([
            'status' => $intendedStatus,
            'notes' => $intendedNotes,
        ]);

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
        
        session()->forget(['whatsapp_url', 'whatsapp_message', 'whatsapp_phone', 'intended_status', 'intended_notes']);
        
        return redirect()->route('admin.loans.show', $id)->with('success', 'Status peminjaman berhasil diperbarui.');
    }

    public function whatsappPreview(Request $request, $id)
    {
        $loan = Peminjaman::with(['items.alat'])->findOrFail($id);
        
        $whatsappUrl = session('whatsapp_url');
        $message = session('whatsapp_message');
        $phone = session('whatsapp_phone');
        
        if (!$whatsappUrl || !$message || !$phone) {
            return redirect()->route('admin.loans.show', $id)->with('error', 'Data WhatsApp tidak ditemukan.');
        }
        
        return view('admin.loans.whatsapp-preview', compact('loan', 'whatsappUrl', 'message', 'phone'));
    }

    public function destroy($id)
    {
        $loan = Peminjaman::with('items')->findOrFail($id);
        
        $loan->items()->delete();
        $loan->delete();

        return redirect()->route('admin.loans.index')->with('success', 'Data peminjaman berhasil dihapus.');
    }

    public function pending(Request $request)
    {
        $query = Peminjaman::with(['items.alat'])
            ->where('status', 'PENDING')
            ->orderBy('created_at', 'desc');
        
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
            ->whereIn('status', ['APPROVED', 'ONGOING'])
            ->orderBy('created_at', 'desc');
        
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