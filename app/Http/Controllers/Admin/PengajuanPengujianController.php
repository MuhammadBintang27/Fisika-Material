<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PengajuanPengujian;
use App\Models\PengajuanHasil;
use App\Models\LayananPengujian;
use App\Services\FileUploadService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class PengajuanPengujianController extends Controller
{
    public function index(Request $request)
    {
        $query = PengajuanPengujian::with(['layanan'])->orderBy('created_at', 'desc');

        // Filter berdasarkan status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter berdasarkan layanan
        if ($request->filled('layanan')) {
            $query->where('layananId', $request->layanan);
        }

        // Search by tracking code, nama pengaju, atau layanan
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('trackingCode', 'like', "%{$search}%")
                  ->orWhere('namaPengaju', 'like', "%{$search}%")
                  ->orWhereHas('layanan', function($layananQuery) use ($search) {
                      $layananQuery->where('namaLayanan', 'like', "%{$search}%");
                  });
            });
        }

        $pengajuan = $query->paginate(15)->withQueryString();
        
        // Get statistics
        $stats = [
            'menunggu' => PengajuanPengujian::where('status', 'MENUNGGU')->count(),
            'disetujui' => PengajuanPengujian::where('status', 'DISETUJUI')->count(),
            'diproses' => PengajuanPengujian::where('status', 'DIPROSES')->count(),
            'selesai' => PengajuanPengujian::where('status', 'SELESAI')->count(),
        ];

        // Get layanan list for filter
        $layananList = LayananPengujian::orderBy('namaLayanan')->get();
        
        return view('admin.pengajuan-pengujian.index', compact('pengajuan', 'stats', 'layananList'));
    }

    public function menunggu(Request $request)
    {
        $query = PengajuanPengujian::with(['layanan'])->where('status', 'MENUNGGU')->orderBy('created_at', 'desc');

        // Search by tracking code, nama pengaju, atau layanan
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('trackingCode', 'like', "%{$search}%")
                  ->orWhere('namaPengaju', 'like', "%{$search}%")
                  ->orWhereHas('layanan', function($layananQuery) use ($search) {
                      $layananQuery->where('namaLayanan', 'like', "%{$search}%");
                  });
            });
        }

        $pengajuan = $query->paginate(15)->withQueryString();
        
        return view('admin.pengajuan-pengujian.menunggu', compact('pengajuan'));
    }

    public function disetujui(Request $request)
    {
        $query = PengajuanPengujian::with(['layanan'])->where('status', 'DISETUJUI')->orderBy('created_at', 'desc');

        // Search by tracking code, nama pengaju, atau layanan
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('trackingCode', 'like', "%{$search}%")
                  ->orWhere('namaPengaju', 'like', "%{$search}%")
                  ->orWhereHas('layanan', function($layananQuery) use ($search) {
                      $layananQuery->where('namaLayanan', 'like', "%{$search}%");
                  });
            });
        }

        $pengajuan = $query->paginate(15)->withQueryString();
        
        return view('admin.pengajuan-pengujian.disetujui', compact('pengajuan'));
    }

    public function diproses(Request $request)
    {
        $query = PengajuanPengujian::with(['layanan'])->where('status', 'DIPROSES')->orderBy('created_at', 'desc');

        // Search by tracking code, nama pengaju, atau layanan
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('trackingCode', 'like', "%{$search}%")
                  ->orWhere('namaPengaju', 'like', "%{$search}%")
                  ->orWhereHas('layanan', function($layananQuery) use ($search) {
                      $layananQuery->where('namaLayanan', 'like', "%{$search}%");
                  });
            });
        }

        $pengajuan = $query->paginate(15)->withQueryString();
        
        return view('admin.pengajuan-pengujian.diproses', compact('pengajuan'));
    }

    public function selesai(Request $request)
    {
        $query = PengajuanPengujian::with(['layanan'])->where('status', 'SELESAI')->orderBy('created_at', 'desc');

        // Search by tracking code, nama pengaju, atau layanan
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('trackingCode', 'like', "%{$search}%")
                  ->orWhere('namaPengaju', 'like', "%{$search}%")
                  ->orWhereHas('layanan', function($layananQuery) use ($search) {
                      $layananQuery->where('namaLayanan', 'like', "%{$search}%");
                  });
            });
        }

        $pengajuan = $query->paginate(15)->withQueryString();
        
        return view('admin.pengajuan-pengujian.selesai', compact('pengajuan'));
    }

    public function ditolak(Request $request)
    {
        $query = PengajuanPengujian::with(['layanan'])->where('status', 'DITOLAK')->orderBy('created_at', 'desc');

        // Search by tracking code, nama pengaju, atau layanan
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('trackingCode', 'like', "%{$search}%")
                  ->orWhere('namaPengaju', 'like', "%{$search}%")
                  ->orWhereHas('layanan', function($layananQuery) use ($search) {
                      $layananQuery->where('namaLayanan', 'like', "%{$search}%");
                  });
            });
        }

        $pengajuan = $query->paginate(15)->withQueryString();
        
        return view('admin.pengajuan-pengujian.ditolak', compact('pengajuan'));
    }

    public function show($id)
    {
        $pengajuan = PengajuanPengujian::with(['layanan', 'hasil'])->findOrFail($id);
        return view('admin.pengajuan-pengujian.show', compact('pengajuan'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:MENUNGGU,DISETUJUI,DITOLAK,DIPROSES,SELESAI',
            'catatan' => 'nullable|string',
        ]);

        $pengajuan = PengajuanPengujian::with(['layanan'])->findOrFail($id);
        
        // Validasi transisi status
        $allowedTransitions = [
            'MENUNGGU' => ['DISETUJUI', 'DITOLAK'],
            'DISETUJUI' => ['DIPROSES'],
            'DIPROSES' => ['SELESAI'],
        ];

        if (!isset($allowedTransitions[$pengajuan->status]) || 
            !in_array($request->status, $allowedTransitions[$pengajuan->status])) {
            return back()->withErrors(['status' => 'Transisi status tidak valid.']);
        }

        // Validasi khusus untuk SELESAI - harus ada hasil yang diunggah
        if ($request->status === 'SELESAI' && $pengajuan->hasil()->count() === 0) {
            return back()->withErrors(['status' => 'Tidak dapat menandai selesai tanpa mengupload hasil.']);
        }

        // Store intended status and notes in session
        session([
            'intended_status' => $request->status,
            'intended_catatan' => $request->input('catatan', ''),
        ]);

        // Prepare WhatsApp message
        $wa = preg_replace('/[^0-9]/', '', $pengajuan->noHp);
        if (substr($wa, 0, 1) === '0') {
            $wa = '62' . substr($wa, 1);
        }
        $url = 'https://wa.me/' . $wa . '?text=';
        $msg = '';

        $header = "Selamat datang di *Laboratorium Fisika Material dan Energi*,\n";
        $header .= "_Departemen Fisika, Universitas Syiah Kuala_\n\n";
        $header .= "Halo *{$pengajuan->namaPengaju}*,\n\n";

        if ($request->status === 'DISETUJUI') {
            $msg .= $header;
            $msg .= "Pengajuan pengujian Anda telah *DISETUJUI*. Berikut detail pengajuan Anda:\n\n";
            $msg .= "*Kode Tracking*: {$pengajuan->trackingCode}\n\n";
            $msg .= "*Detail Layanan*:\n";
            $msg .= "- Layanan: {$pengajuan->layanan->namaLayanan}\n";
            $msg .= "- Jumlah Sampel: {$pengajuan->jumlahSampel} sampel\n";
            $msg .= "- Tanggal Penyerahan: " . \Carbon\Carbon::parse($pengajuan->tanggalPenyerahan)->format('d M Y') . "\n";
            if ($pengajuan->estimasiSelesai) {
                $msg .= "- Estimasi Selesai: " . \Carbon\Carbon::parse($pengajuan->estimasiSelesai)->format('d M Y') . "\n";
            }
            $msg .= "\n*Langkah Selanjutnya*:\n";
            $msg .= "Silakan serahkan sampel sesuai dengan jadwal yang telah ditentukan di laboratorium.\n\n";
            $msg .= "Terima kasih dan sukses selalu untuk penelitian Anda! 🌟";
        } elseif ($request->status === 'DIPROSES') {
            $msg .= $header;
            $msg .= "Sampel pengujian Anda sedang *DIPROSES*. Berikut detail pengajuan Anda:\n\n";
            $msg .= "*Kode Tracking*: {$pengajuan->trackingCode}\n\n";
            $msg .= "*Detail Layanan*:\n";
            $msg .= "- Layanan: {$pengajuan->layanan->namaLayanan}\n";
            $msg .= "- Jumlah Sampel: {$pengajuan->jumlahSampel} sampel\n";
            if ($pengajuan->estimasiSelesai) {
                $msg .= "- Estimasi Selesai: " . \Carbon\Carbon::parse($pengajuan->estimasiSelesai)->format('d M Y') . "\n";
            }
            $msg .= "\n🔬 *Status*: Sampel sedang dalam proses pengujian di laboratorium kami.\n\n";
            $msg .= "Hasil pengujian akan segera tersedia setelah proses selesai.\n\n";
            $msg .= "Terima kasih atas kesabaran Anda! 🌟";
        } elseif ($request->status === 'SELESAI') {
            $msg .= $header;
            $msg .= "Pengujian Anda telah *SELESAI*! Berikut detail pengajuan Anda:\n\n";
            $msg .= "*Kode Tracking*: {$pengajuan->trackingCode}\n\n";
            $msg .= "*Detail Layanan*:\n";
            $msg .= "- Layanan: {$pengajuan->layanan->namaLayanan}\n";
            $msg .= "- Jumlah Sampel: {$pengajuan->jumlahSampel} sampel\n\n";
            $msg .= "✅ *Hasil pengujian sudah tersedia* dan dapat diunduh melalui halaman tracking di website kami.\n\n";
            $msg .= "🔗 *Link tracking*: [Website URL]/tracking\n\n";
            $msg .= "Terima kasih telah menggunakan layanan Laboratorium Fisika Material dan Energi.\n";
            $msg .= "Sukses selalu untuk penelitian Anda! 🌟";
        } elseif ($request->status === 'DITOLAK') {
            $msg .= $header;
            $msg .= "Kami informasikan bahwa pengajuan pengujian Anda *TIDAK DAPAT DIPENUHI*. Berikut informasinya:\n\n";
            $msg .= "*Kode Tracking*: {$pengajuan->trackingCode}\n\n";
            $msg .= "*Alasan Penolakan*:\n";
            $msg .= $request->input('catatan', 'Tidak ada alasan spesifik yang diberikan.') . "\n\n";
            $msg .= "Jika Anda memiliki pertanyaan, silakan hubungi admin laboratorium.\n\n";
            $msg .= "Terima kasih atas pengertian Anda.";
        }

        // Store WhatsApp data in session
        session([
            'whatsapp_url' => $url . urlencode($msg),
            'whatsapp_message' => $msg,
            'whatsapp_phone' => $wa,
        ]);

        return redirect()->route('admin.pengajuan-pengujian.whatsapp-preview', $id);
    }

    /**
     * Show WhatsApp preview page
     */
    public function whatsappPreview(Request $request, $id)
    {
        $pengajuan = PengajuanPengujian::with(['layanan'])->findOrFail($id);
        
        $whatsappUrl = session('whatsapp_url');
        $message = session('whatsapp_message');
        $phone = session('whatsapp_phone');
        
        if (!$whatsappUrl || !$message || !$phone) {
            return redirect()->route('admin.pengajuan-pengujian.show', $id)->with('error', 'Data WhatsApp tidak ditemukan.');
        }
        
        return view('admin.pengajuan-pengujian.whatsapp-preview', compact('pengajuan', 'whatsappUrl', 'message', 'phone'));
    }

    /**
     * Confirm status update after WhatsApp
     */
    public function confirmStatusUpdate(Request $request, $id)
    {
        $pengajuan = PengajuanPengujian::with(['layanan'])->findOrFail($id);
        
        $intendedStatus = session('intended_status');
        $intendedCatatan = session('intended_catatan');
        
        if (!$intendedStatus) {
            return redirect()->route('admin.pengajuan-pengujian.show', $id)->with('error', 'Data status tidak ditemukan.');
        }
        
        // Update status
        $updateData = [
            'status' => $intendedStatus,
            'catatanAdmin' => $intendedCatatan,
        ];

        // Set tanggal selesai untuk status SELESAI
        if ($intendedStatus === 'SELESAI') {
            $updateData['tanggalSelesai'] = now();
        }

        $pengajuan->update($updateData);
        
        session()->forget(['whatsapp_url', 'whatsapp_message', 'whatsapp_phone', 'intended_status', 'intended_catatan']);
        
        $statusMessages = [
            'DISETUJUI' => 'Pengajuan berhasil disetujui.',
            'DITOLAK' => 'Pengajuan berhasil ditolak.',
            'DIPROSES' => 'Pengajuan berhasil diubah ke status diproses.',
            'SELESAI' => 'Pengajuan berhasil diselesaikan.',
        ];

        $message = $statusMessages[$intendedStatus] ?? 'Status pengajuan berhasil diupdate.';
        
        return redirect()->route('admin.pengajuan-pengujian.show', $id)->with('success', $message);
    }

    public function uploadHasil(Request $request, $id)
    {
        $request->validate([
            'catatan' => 'nullable|string|max:1000',
            'file' => 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240', // max 10MB
        ]);

        try {
            $pengajuan = PengajuanPengujian::findOrFail($id);
            $fileUploadService = new FileUploadService();

            // Upload file using service
            $fileData = $fileUploadService->uploadTestingResult(
                $request->file('file'), 
                $pengajuan->trackingCode
            );

            // Simpan ke database
            PengajuanHasil::create([
                'pengajuanId' => $pengajuan->id,
                'fileHasil' => $fileData['file_path'],
                'namaFile' => $fileData['original_name'],
                'ukuranFile' => $fileData['file_size'],
                'tipeFile' => $fileData['mime_type'],
                'catatan' => $request->catatan,
                'uploadedAt' => now(),
            ]);

            return redirect()->back()->with('success', 'File hasil pengujian berhasil diupload.');
            
        } catch (\InvalidArgumentException $e) {
            return redirect()->back()->withErrors(['file' => $e->getMessage()]);
        } catch (\Exception $e) {
            \Log::error('Upload hasil error: ' . $e->getMessage());
            return redirect()->back()->withErrors(['file' => 'Terjadi kesalahan saat mengupload file.']);
        }
    }
}
