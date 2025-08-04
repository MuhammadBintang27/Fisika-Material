<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Alat;
use App\Models\Peminjaman;
use App\Models\PeminjamanItem;
use Illuminate\Support\Str;
use Carbon\Carbon;

class EquipmentLoanController extends Controller
{
    public function index()
    {
        $equipments = Alat::with(['gambar' => function($q) {
            $q->where('kategori', 'ALAT');
        }])->get();
        
        return view('user.services.loans.index', compact('equipments'));
    }



    public function form()
    {
        return view('user.services.loans.form');
    }

    public function enhanced()
    {
        $equipments = Alat::with(['gambar' => function($q) {
            $q->where('kategori', 'ALAT');
        }])->get();
        
        $success = session('success');
        return view('user.services.loans.enhanced', compact('equipments', 'success'));
    }

    public function show($id)
    {
        $equipment = Alat::with('gambar')->find($id);
        if (!$equipment) {
            abort(404);
        }
        return view('user.services.loans.detail', compact('equipment'));
    }

    public function submit(Request $request)
    {
        try {
            \Log::info('Equipment loan submission started', $request->all());
            
            // Validate user type
            $request->validate([
                'user_type' => 'required|in:dosen,mahasiswa,pihak-luar',
                'judul_penelitian' => 'required|string|max:255',
                'tanggal_mulai' => 'required|date|after_or_equal:' . Carbon::now()->addDays(7)->format('Y-m-d'),
                'tanggal_selesai' => 'required|date|after:tanggal_mulai',
                'waktu_mulai' => 'required',
                'durasi_jam' => 'required|integer|min:1|max:24',
                'selected_equipment' => 'required',
            ]);

        // Validate based on user type
        $this->validateUserTypeData($request);

        $selectedEquipment = json_decode($request->selected_equipment, true);
        if (!is_array($selectedEquipment) || count($selectedEquipment) < 1) {
            return back()->withErrors(['selected_equipment' => 'Pilih minimal satu alat']);
        }

        // Create peminjaman record
        $trackingCode = Str::random(10);
        $peminjaman = Peminjaman::create([
            'id' => Str::uuid(),
            'tracking_code' => $trackingCode,
            'user_type' => $request->user_type,
            'namaPeminjam' => $this->getPeminjamName($request),
            'noHp' => $this->getPeminjamPhone($request),
            'email' => $this->getPeminjamEmail($request),
            'nip_nim' => $this->getPeminjamId($request),
            'instansi' => $request->user_type === 'pihak-luar' ? $request->instansi : 'Universitas Syiah Kuala',
            'jabatan' => $request->user_type === 'pihak-luar' ? $request->jabatan : null,
            'judul_penelitian' => $request->judul_penelitian,
            'deskripsi_penelitian' => $request->deskripsi_penelitian,
            'tanggal_pinjam' => $request->tanggal_mulai . ' ' . $request->waktu_mulai,
            'tanggal_pengembalian' => $request->tanggal_selesai . ' ' . $request->waktu_mulai,
            'durasi_jam' => $request->durasi_jam,
            'status' => 'PENDING',
            'supervisor_name' => $request->user_type === 'mahasiswa' ? $request->nama_pembimbing : null,
            'supervisor_nip' => $request->user_type === 'mahasiswa' ? $request->nip_pembimbing : null,
        ]);

        // Create peminjaman items
        foreach ($selectedEquipment as $item) {
            PeminjamanItem::create([
                'id' => Str::uuid(),
                'peminjamanId' => $peminjaman->id,
                'alat_id' => $item['id'],
                'jumlah' => $item['jumlah'],
            ]);
        }

        // Clear session storage
        session()->forget('selectedEquipment');

        \Log::info('Equipment loan submission successful', ['peminjaman_id' => $peminjaman->id]);
        // Redirect ke halaman sukses dengan link tracking
        return view('user.services.loans.success', [
            'tracking_link' => route('loans.tracking', $trackingCode)
        ]);
        
        } catch (\Exception $e) {
            \Log::error('Equipment loan submission failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all()
            ]);
            
            return back()->withErrors(['error' => 'Terjadi kesalahan saat mengirim permohonan. Silakan coba lagi.'])->withInput();
        }
    }

    public function letter($id)
    {
        $loan = Peminjaman::with(['items.alat'])->findOrFail($id);
        return view('user.services.loans.letter', compact('loan'));
    }

    public function download($id)
    {
        $loan = Peminjaman::with(['items.alat'])->findOrFail($id);
        
        // Generate PDF using DomPDF or similar library
        // For now, we'll redirect to the letter page for printing
        return redirect()->route('equipment.loan.letter', $id);
    }

    public function tracking(Request $request)
    {
        $loans = collect();
        
        if ($request->filled('nama') || $request->filled('nip_nim')) {
            $query = Peminjaman::with(['items.alat.gambar']);
            
            if ($request->filled('nama')) {
                $query->where('namaPeminjam', 'like', '%' . $request->nama . '%');
            }
            
            if ($request->filled('nip_nim')) {
                $query->where('nip_nim', 'like', '%' . $request->nip_nim . '%');
            }
            
            $loans = $query->orderBy('created_at', 'desc')->get();
        }
        
        return view('user.services.loans.tracking', compact('loans'));
    }

    public function tracking($tracking_code)
    {
        $peminjaman = \App\Models\Peminjaman::where('tracking_code', $tracking_code)->firstOrFail();
        return view('user.services.loans.tracking', compact('peminjaman'));
    }

    public function requestLoan(Request $request)
    {
        // Validate user type
        $request->validate([
            'user_type' => 'required|in:dosen,mahasiswa,pihak-luar',
            'judul_penelitian' => 'required|string|max:255',
            'tanggal_mulai' => 'required|date|after_or_equal:' . Carbon::now()->addDays(7)->format('Y-m-d'),
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
            'waktu_mulai' => 'required',
            'durasi_jam' => 'required|integer|min:1|max:24',
            'alat' => 'required',
        ]);

        // Validate based on user type
        $this->validateUserTypeData($request);

        $alatArr = json_decode($request->alat, true);
        if (!is_array($alatArr) || count($alatArr) < 1) {
            return back()->withErrors(['alat' => 'Pilih minimal satu alat']);
        }

        // Create peminjaman record
        $peminjaman = Peminjaman::create([
            'id' => Str::uuid(),
            'user_type' => $request->user_type,
            'namaPeminjam' => $this->getPeminjamName($request),
            'noHp' => $this->getPeminjamPhone($request),
            'email' => $this->getPeminjamEmail($request),
            'nip_nim' => $this->getPeminjamId($request),
            'instansi' => $request->user_type === 'pihak-luar' ? $request->instansi : 'Universitas Syiah Kuala',
            'jabatan' => $request->user_type === 'pihak-luar' ? $request->jabatan : null,
            'judul_penelitian' => $request->judul_penelitian,
            'deskripsi_penelitian' => $request->deskripsi_penelitian,
            'tanggal_pinjam' => $request->tanggal_mulai . ' ' . $request->waktu_mulai,
            'tanggal_pengembalian' => $request->tanggal_selesai . ' ' . $request->waktu_mulai,
            'durasi_jam' => $request->durasi_jam,
            'status' => 'PENDING',
            'supervisor_name' => $request->user_type === 'mahasiswa' ? $request->nama_pembimbing : null,
            'supervisor_nip' => $request->user_type === 'mahasiswa' ? $request->nip_pembimbing : null,
        ]);

        // Create peminjaman items
        foreach ($alatArr as $item) {
            PeminjamanItem::create([
                'id' => Str::uuid(),
                'peminjamanId' => $peminjaman->id,
                'alat_id' => $item['id'],
                'jumlah' => $item['jumlah'],
            ]);
        }

        return redirect()->route('equipment.loan.enhanced')->with('success', 'Permohonan peminjaman berhasil dikirim! Kami akan menghubungi Anda dalam 1x24 jam.');
    }

    private function validateUserTypeData(Request $request)
    {
        $userType = $request->user_type;
        
        if ($userType === 'dosen') {
            $request->validate([
                'nama_dosen' => 'required|string|max:255',
                'nip_dosen' => 'required|string|max:20',
                'no_hp_dosen' => 'required|string|max:20',
                'email_dosen' => 'required|email|max:255',
            ]);
        } elseif ($userType === 'mahasiswa') {
            $request->validate([
                'nama_mahasiswa' => 'required|string|max:255',
                'nim_mahasiswa' => 'required|string|max:20',
                'no_hp_mahasiswa' => 'required|string|max:20',
                'email_mahasiswa' => 'required|email|max:255',
                'nama_pembimbing' => 'required|string|max:255',
                'nip_pembimbing' => 'required|string|max:20',
            ]);
        } elseif ($userType === 'pihak-luar') {
            $request->validate([
                'nama_pihak_luar' => 'required|string|max:255',
                'nip_pihak_luar' => 'required|string|max:20',
                'instansi' => 'required|string|max:255',
                'jabatan' => 'required|string|max:255',
                'no_hp_pihak_luar' => 'required|string|max:20',
                'email_pihak_luar' => 'required|email|max:255',
            ]);
        }
    }

    private function getPeminjamName(Request $request)
    {
        $userType = $request->user_type;
        
        switch ($userType) {
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

    private function getPeminjamPhone(Request $request)
    {
        $userType = $request->user_type;
        
        switch ($userType) {
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

    private function getPeminjamEmail(Request $request)
    {
        $userType = $request->user_type;
        
        switch ($userType) {
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

    private function getPeminjamId(Request $request)
    {
        $userType = $request->user_type;
        
        switch ($userType) {
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

    private function getEquipmentById($id)
    {
        $equipments = $this->getAllEquipments();
        return collect($equipments)->where('id', $id)->first();
    }
}
