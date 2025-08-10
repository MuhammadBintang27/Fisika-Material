<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kunjungan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session; // Add this import

class KunjunganController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $kunjungan = Kunjungan::with('jadwal')
            ->when($search, function ($query, $search) {
                return $query->where('namaPengunjung', 'like', "%{$search}%")
                    ->orWhere('namaInstansi', 'like', "%{$search}%")
                    ->orWhere('tracking_code', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10);

        return view('admin.kunjungan.index', compact('kunjungan'));
    }

    public function pending(Request $request)
    {
        $search = $request->input('search');
        $kunjungan = Kunjungan::with('jadwal')
            ->where('status', 'PENDING')
            ->when($search, function ($query, $search) {
                return $query->where('namaPengunjung', 'like', "%{$search}%")
                    ->orWhere('namaInstansi', 'like', "%{$search}%")
                    ->orWhere('tracking_code', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10);

        return view('admin.kunjungan.index', compact('kunjungan'));
    }

    public function approved(Request $request)
    {
        $search = $request->input('search');
        $kunjungan = Kunjungan::with('jadwal')
            ->where('status', 'APPROVED')
            ->when($search, function ($query, $search) {
                return $query->where('namaPengunjung', 'like', "%{$search}%")
                    ->orWhere('namaInstansi', 'like', "%{$search}%")
                    ->orWhere('tracking_code', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10);

        return view('admin.kunjungan.index', compact('kunjungan'));
    }

    public function completed(Request $request)
    {
        $search = $request->input('search');
        $kunjungan = Kunjungan::with('jadwal')
            ->where('status', 'COMPLETED')
            ->when($search, function ($query, $search) {
                return $query->where('namaPengunjung', 'like', "%{$search}%")
                    ->orWhere('namaInstansi', 'like', "%{$search}%")
                    ->orWhere('tracking_code', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10);

        return view('admin.kunjungan.index', compact('kunjungan'));
    }

    public function rejected(Request $request)
    {
        $search = $request->input('search');
        $kunjungan = Kunjungan::with('jadwal')
            ->where('status', 'CANCELLED')
            ->when($search, function ($query, $search) {
                return $query->where('namaPengunjung', 'like', "%{$search}%")
                    ->orWhere('namaInstansi', 'like', "%{$search}%")
                    ->orWhere('tracking_code', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10);

        return view('admin.kunjungan.index', compact('kunjungan'));
    }

    public function show($id)
    {
        $kunjungan = Kunjungan::with('jadwal')->findOrFail($id);
        return view('admin.kunjungan.show', compact('kunjungan'));
    }

    public function destroy($id)
    {
        try {
            $kunjungan = Kunjungan::findOrFail($id);
            if ($kunjungan->jadwal) {
                $kunjungan->jadwal()->update(['kunjunganId' => null]);
            }
            $kunjungan->delete();
            Log::info("Kunjungan deleted: ID={$id}, TrackingCode={$kunjungan->tracking_code}");
            return redirect()->route('admin.kunjungan.index')->with('success', 'Kunjungan berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error("Error deleting kunjungan: {$e->getMessage()}, ID={$id}");
            return back()->with('error', 'Gagal menghapus kunjungan: ' . $e->getMessage());
        }
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:PENDING,APPROVED,COMPLETED,CANCELLED',
            'notes' => 'nullable|string',
        ]);

        $kunjungan = Kunjungan::with('jadwal')->findOrFail($id);

        // Prepare WhatsApp message
        $phone = $kunjungan->noHp;
        if (!$phone) {
            return back()->with('error', 'Nomor WhatsApp tidak ditemukan.');
        }

        // Format phone number for WhatsApp (remove non-numeric characters and ensure country code)
        $phone = preg_replace('/[^0-9]/', '', $phone);
        if (substr($phone, 0, 1) === '0') {
            $phone = '62' . substr($phone, 1);
        }

        // Compose WhatsApp message
        $message = "📢 *Informasi Kunjungan Laboratorium*\n\n";
        $message .= "Kode Tracking: {$kunjungan->tracking_code}\n";
        $message .= "Nama Pengunjung: {$kunjungan->namaPengunjung}\n";
        $message .= "Instansi: {$kunjungan->namaInstansi}\n";
        $message .= "Tanggal Kunjungan: " . \Carbon\Carbon::parse($kunjungan->jadwal->tanggal)->format('d M Y') . "\n";
        $message .= "Waktu: {$kunjungan->jadwal->jam_mulai} - {$kunjungan->jadwal->jam_selesai}\n";
        $message .= "Tujuan: {$kunjungan->tujuan}\n\n";

        if ($request->status === 'APPROVED') {
            $message .= "Status: *DISETUJUI*\n";
            $message .= "Kunjungan Anda telah disetujui. Silakan datang sesuai jadwal yang telah ditentukan.";
        } elseif ($request->status === 'COMPLETED') {
            $message .= "Status: *SELESAI*\n";
            $message .= "Terima kasih atas kunjungan Anda ke Laboratorium Fisika Material dan Energi, Universitas Syiah Kuala.";
        } elseif ($request->status === 'CANCELLED') {
            $message .= "Status: *DITOLAK*\n";
            $message .= "Mohon maaf, kunjungan Anda ditolak.";
            if ($request->notes) {
                $message .= " Alasan: {$request->notes}";
            }
        }

        $whatsappUrl = "https://wa.me/{$phone}?text=" . urlencode($message);

        // Store data in session for preview
        Session::put('whatsapp_data', [
            'id' => $id,
            'status' => $request->status,
            'notes' => $request->notes,
            'message' => $message,
            'whatsappUrl' => $whatsappUrl,
            'phone' => $phone,
        ]);

        return redirect()->route('admin.kunjungan.whatsapp-preview', $id);
    }

    public function whatsappPreview(Request $request, $id)
    {
        $whatsappData = Session::get('whatsapp_data');

        if (!$whatsappData || $whatsappData['id'] != $id) {
            return redirect()->route('admin.kunjungan.show', $id)
                ->with('error', 'Data WhatsApp tidak ditemukan.');
        }

        $kunjungan = Kunjungan::with('jadwal')->findOrFail($id);
        $whatsappUrl = $whatsappData['whatsappUrl'];
        $message = $whatsappData['message'];
        $phone = $whatsappData['phone'];

        return view('admin.kunjungan.whatsapp-preview', compact('kunjungan', 'whatsappUrl', 'message', 'phone'));
    }

    public function confirmStatusUpdate(Request $request, $id)
    {
        $whatsappData = Session::get('whatsapp_data');

        if (!$whatsappData || $whatsappData['id'] != $id) {
            return redirect()->route('admin.kunjungan.show', $id)
                ->with('error', 'Data WhatsApp tidak ditemukan.');
        }

        $kunjungan = Kunjungan::findOrFail($id);
        $kunjungan->status = $whatsappData['status'];
        if ($whatsappData['notes']) {
            $kunjungan->notes = $whatsappData['notes'];
        }
        $kunjungan->save();

        // Clear session data
        Session::forget('whatsapp_data');

        Log::info("Kunjungan status updated: ID={$id}, Status={$kunjungan->status}");
        return redirect()->route('admin.kunjungan.show', $id)
            ->with('success', 'Status kunjungan berhasil diperbarui.');
    }
}