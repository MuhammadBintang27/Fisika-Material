<?php

namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LayananPengujian;
use App\Models\PengajuanPengujian;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PengujianController extends Controller
{
    public function index()
    {
        // Halaman katalog layanan pengujian
        $layanan = LayananPengujian::aktif()->orderBy('namaLayanan')->get();
        return view('user.services.pengujian.index', compact('layanan'));
    }

    public function show($id)
    {
        // Detail layanan dan form pengajuan
        $layanan = LayananPengujian::where('isAktif', true)->findOrFail($id);
        return view('user.services.pengujian.detail', compact('layanan'));
    }

    // UNIFIED SUBMIT METHOD - mengikuti pola dari EquipmentLoanController
    public function submit(Request $request)
    {
        try {
            \Log::info('Testing service submission started', $request->all());

            // Validate request
            $request->validate([
                'user_type' => 'required|in:dosen,mahasiswa,pihak-luar',
                'layanan_id' => 'required|exists:layanan_pengujian,id',
                'tanggal_penyerahan' => 'required|date|after:today',
                'jumlah_sampel' => 'required|integer|min:1',
                'deskripsi_sampel' => 'required|string|max:1000',
                'alamat' => 'nullable|string|max:500',
                'file_pendukung' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120', // Max 5MB
            ]);

            // Validate user type specific data
            $this->validateUserTypeData($request);

            // Check service availability
            $layanan = LayananPengujian::where('id', $request->layanan_id)->where('isAktif', true)->first();
            if (!$layanan) {
                return back()->withErrors(['layanan_id' => 'Layanan pengujian sedang tidak tersedia'])->withInput();
            }

            // Handle file upload
            $filePath = null;
            if ($request->hasFile('file_pendukung')) {
                $file = $request->file('file_pendukung');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('pengujian-pendukung', $fileName, 'public');
            }

            // Generate unique tracking code
            do {
                $trackingCode = 'PU' . date('Ymd') . strtoupper(Str::random(4));
            } while (PengajuanPengujian::where('trackingCode', $trackingCode)->exists());

            // Get service for estimasi selesai calculation
            $tanggalPenyerahan = Carbon::parse($request->tanggal_penyerahan);
            $estimasiSelesai = $tanggalPenyerahan->copy()->addDays($layanan->estimasiSelesaiHari);

            // Create pengajuan record
            $pengajuan = PengajuanPengujian::create([
                'trackingCode' => $trackingCode,
                'namaPengaju' => $this->getPengajuName($request),
                'noHp' => $this->getPengajuPhone($request),
                'email' => $this->getPengajuEmail($request),
                'nim' => $request->user_type === 'mahasiswa' ? $request->nim : null,
                'nip' => $request->user_type === 'dosen' ? $request->nip : null,
                'instansi' => $request->user_type === 'pihak-luar' ? $request->instansi_pihak_luar : 'Universitas Syiah Kuala',
                'prodi' => $request->user_type === 'mahasiswa' ? $request->prodi : null,
                'alamat' => $request->alamat,
                'userType' => $this->mapUserType($request->user_type),
                'layananId' => $request->layanan_id,
                'tanggalPengajuan' => now(),
                'tanggalPenyerahan' => $tanggalPenyerahan,
                'jumlahSampel' => $request->jumlah_sampel,
                'deskripsiSampel' => $request->deskripsi_sampel,
                'filePendukung' => $filePath,
                'detailKhusus' => $request->detail_khusus,
                'estimasiSelesai' => $estimasiSelesai,
                'status' => 'MENUNGGU',
            ]);

            \Log::info('Testing service submission successful', ['pengajuan_id' => $pengajuan->id]);

            // Prepare WhatsApp message for admin notification
            $adminPhone = config('app.admin_whatsapp');
            $whatsappMessage = $this->generateAdminWhatsAppMessage($pengajuan, $trackingCode, $layanan);

            return view('user.services.pengujian.success', [
                'tracking_code' => $trackingCode,
                'pengajuan' => $pengajuan,
                'tracking_link' => route('tracking') . '?type=pengujian&tracking_code=' . $pengajuan->trackingCode,
                'admin_whatsapp_url' => "https://wa.me/{$adminPhone}?text=" . urlencode($whatsappMessage)
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::warning('Validation failed', ['errors' => $e->errors()]);
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            \Log::error('Testing service submission failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all()
            ]);
            return back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()])->withInput();
        }
    }

    public function success($id = null)
    {
        if ($id) {
            // Legacy support - redirect by ID
            $pengajuan = PengajuanPengujian::with('layanan')->findOrFail($id);
            return view('user.services.pengujian.success', compact('pengajuan'));
        }
        
        // New pattern - success page shows tracking info
        return view('user.services.pengujian.success');
    }

    public function tracking(Request $request, $tracking_code = null)
    {
        try {
            \Log::info('Testing tracking request received', ['tracking_code' => $tracking_code ?? $request->query('tracking_code')]);

            $trackingCode = $tracking_code ?? $request->query('tracking_code');
            $pengajuan = null;
            $pengajuans = collect();

            if ($trackingCode) {
                $pengajuan = PengajuanPengujian::with(['layanan', 'hasil'])
                    ->where('trackingCode', $trackingCode)
                    ->first();
                    
                $pengajuans = PengajuanPengujian::with(['layanan', 'hasil'])
                    ->where('trackingCode', $trackingCode)
                    ->get();

                if (!$pengajuan) {
                    \Log::warning('Invalid tracking code', ['tracking_code' => $trackingCode]);
                    return view('user.services.pengujian.tracking', [
                        'pengajuan' => null,
                        'pengajuans' => collect()
                    ])->withErrors(['error' => 'Kode tracking tidak valid.']);
                }
            }

            return view('user.services.pengujian.tracking', compact('pengajuan', 'pengajuans'));
        } catch (\Exception $e) {
            \Log::error('Testing tracking failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'tracking_code' => $tracking_code ?? $request->query('tracking_code')
            ]);
            return view('user.services.pengujian.tracking', [
                'pengajuan' => null,
                'pengajuans' => collect()
            ])->withErrors(['error' => 'Terjadi kesalahan saat melacak pengajuan.']);
        }
    }

    private function validateUserTypeData(Request $request)
    {
        $userType = $request->user_type;
        
        if ($userType === 'dosen') {
            $request->validate([
                'nama_dosen' => 'required|string|max:255',
                'nip_dosen' => 'required|string|max:20',
                'no_hp_dosen' => 'required|string|max:20',
                'email_dosen' => 'nullable|email|max:255',
            ]);
        } elseif ($userType === 'mahasiswa') {
            $request->validate([
                'nama_mahasiswa' => 'required|string|max:255',
                'nim_mahasiswa' => 'required|string|max:20',
                'no_hp_mahasiswa' => 'required|string|max:20',
                'email_mahasiswa' => 'nullable|email|max:255',
                'nama_pembimbing' => 'required|string|max:255',
                'nip_pembimbing' => 'required|string|max:20',
            ]);
        } elseif ($userType === 'pihak-luar') {
            $request->validate([
                'nama_pihak_luar' => 'required|string|max:255',
                'nip_pihak_luar' => 'required|string|max:20',
                'instansi_pihak_luar' => 'required|string|max:255',
                'no_hp_pihak_luar' => 'required|string|max:20',
                'email_pihak_luar' => 'nullable|email|max:255',
            ]);
        }
    }

    private function getPengajuName(Request $request)
    {
        switch ($request->user_type) {
            case 'dosen':
                return $request->nama_dosen;
            case 'mahasiswa':
                return $request->nama_mahasiswa;
            case 'pihak-luar':
                return $request->nama_pihak_luar;
            default:
                return '';
        }
    }

    private function getPengajuPhone(Request $request)
    {
        switch ($request->user_type) {
            case 'dosen':
                return $request->no_hp_dosen;
            case 'mahasiswa':
                return $request->no_hp_mahasiswa;
            case 'pihak-luar':
                return $request->no_hp_pihak_luar;
            default:
                return '';
        }
    }

    private function getPengajuEmail(Request $request)
    {
        switch ($request->user_type) {
            case 'dosen':
                return $request->email_dosen;
            case 'mahasiswa':
                return $request->email_mahasiswa;
            case 'pihak-luar':
                return $request->email_pihak_luar;
            default:
                return '';
        }
    }

    private function getPengajuId(Request $request)
    {
        switch ($request->user_type) {
            case 'dosen':
                return $request->nip_dosen;
            case 'mahasiswa':
                return $request->nim_mahasiswa;
            case 'pihak-luar':
                return $request->nip_pihak_luar;
            default:
                return '';
        }
    }

    private function getJabatan(Request $request)
    {
        if ($request->user_type === 'dosen' && $request->filled('jabatan')) {
            return $request->jabatan;
        }
        return null;
    }

    private function mapUserType($userType)
    {
        $mapping = [
            'dosen' => 'DOSEN',
            'mahasiswa' => 'MAHASISWA',
            'pihak-luar' => 'UMUM',
        ];

        return $mapping[$userType] ?? 'UMUM';
    }

    public function downloadHasil($pengajuanId, $hasilId)
    {
        $pengajuan = PengajuanPengujian::findOrFail($pengajuanId);
        $hasil = $pengajuan->hasil()->findOrFail($hasilId);

        if (!$hasil->fileHasil || !Storage::disk('public')->exists($hasil->fileHasil)) {
            abort(404, 'File hasil tidak ditemukan.');
        }

        // Log download activity
        \Log::info('File hasil downloaded', [
            'pengajuan_id' => $pengajuanId,
            'hasil_id' => $hasilId,
            'file_path' => $hasil->fileHasil,
            'original_name' => $hasil->namaFile
        ]);

        // Download with original filename
        return Storage::disk('public')->download(
            $hasil->fileHasil, 
            $hasil->namaFile ?: 'hasil_pengujian.pdf'
        );
    }

    /**
     * Generate WhatsApp message for admin notification
     */
    private function generateAdminWhatsAppMessage($pengajuan, $trackingCode, $layanan)
    {
        $message = "🔔 *PERMOHONAN PENGUJIAN BARU*\n\n";
        $message .= "Halo Admin Laboratorium Fisika Material dan Energi,\n\n";
        $message .= "Ada permohonan pengujian baru yang masuk:\n\n";
        $message .= "📋 *Kode Tracking:* {$trackingCode}\n";
        $message .= "🧪 *Jenis Layanan:* {$layanan->namaLayanan}\n";
        $message .= "👤 *Pengaju:* {$pengajuan->namaPengaju}\n";
        $message .= "📞 *No HP:* {$pengajuan->noHp}\n";
        $message .= "🏷️ *Tipe User:* " . $pengajuan->getUserTypeLabelAttribute() . "\n";
        $message .= "📦 *Jumlah Sampel:* {$pengajuan->jumlahSampel}\n";
        $message .= "📅 *Tanggal Penyerahan:* " . \Carbon\Carbon::parse($pengajuan->tanggalPenyerahan)->format('d/m/Y') . "\n";
        $message .= "📅 *Waktu Pengajuan:* " . $pengajuan->tanggalPengajuan->format('d/m/Y H:i') . "\n";
        $message .= "🌐 *Link Tracking:* " . route('tracking') . '?type=pengujian&tracking_code=' . $trackingCode . "\n\n";
        $message .= "Mohon untuk segera memproses permohonan ini.\n\n";
        $message .= "Terima kasih! 🙏";
        
        return $message;
    }
}

