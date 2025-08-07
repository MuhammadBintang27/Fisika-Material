<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kunjungan;
use App\Models\Jadwal;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class KunjunganUserController extends Controller
{
    public function form()
    {
        return view('user.services.visits.index');
    }

    public function store(Request $request)
{
    $request->validate([
        'namaPengunjung' => 'required|string|max:255',
        'noHp' => 'required|string|max:20',
        'namaInstansi' => 'required|string|max:255',
        'tujuan' => 'required|string',
        'tanggal' => 'required|date|after_or_equal:' . Carbon::today()->toDateString(),
        'jamMulai' => 'required|date_format:H:i:s',
        'jamSelesai' => 'required|date_format:H:i:s|after:jamMulai',
        'jumlahPengunjung' => 'required|integer|min:1|max:50',
        'suratPengajuan' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
    ]);

    try {
        return DB::transaction(function () use ($request) {
            $startTime = Carbon::parse($request->jamMulai);
            $endTime = Carbon::parse($request->jamSelesai);
            if ($endTime->lte($startTime)) {
                Log::warning('Invalid time range', ['jamMulai' => $request->jamMulai, 'jamSelesai' => $request->jamSelesai]);
                return back()->withErrors(['jamSelesai' => 'Jam selesai harus setelah jam mulai.'])->withInput();
            }

            $selectedSchedule = Jadwal::where('tanggal', $request->tanggal)
                ->where('jamMulai', $request->jamMulai)
                ->where('jamSelesai', $request->jamSelesai)
                ->where('isActive', true)
                ->whereNull('kunjunganId')
                ->lockForUpdate()
                ->first();

            if (!$selectedSchedule) {
                Log::warning('No available schedule', ['tanggal' => $request->tanggal, 'jamMulai' => $request->jamMulai, 'jamSelesai' => $request->jamSelesai]);
                return back()->withErrors(['jamMulai' => 'Jadwal tidak tersedia untuk waktu yang dipilih.'])->withInput();
            }

            $suratPath = $request->file('suratPengajuan')->store('surat-pengajuan', 'public');

            $kunjungan = Kunjungan::create([
                'id' => \Illuminate\Support\Str::uuid(),
                'tracking_code' => Kunjungan::generateUniqueTrackingCode(),
                'namaPengunjung' => $request->namaPengunjung,
                'noHp' => $request->noHp,
                'namaInstansi' => $request->namaInstansi,
                'tujuan' => $request->tujuan,
                'jumlahPengunjung' => $request->jumlahPengunjung,
                'status' => 'PENDING',
                'suratPengajuan' => $suratPath,
                'jadwal_id' => $selectedSchedule->id,
            ]);

            $selectedSchedule->update(['kunjunganId' => $kunjungan->id]);
            Log::info("Kunjungan created: ID={$kunjungan->id}, TrackingCode={$kunjungan->tracking_code}, Date={$request->tanggal}, User=" . (auth()->id() ?? 'guest') . ", IP={$request->ip()}");
            return redirect()->route('user.kunjungan.success', [
                'tracking_code' => $kunjungan->tracking_code,
                'tracking_link' => route('tracking', ['type' => 'kunjungan', 'tracking_code' => $kunjungan->tracking_code])
            ])->with('success', 'Pengajuan kunjungan berhasil dikirim!');
        });
    } catch (\Exception $e) {
        Log::error("Error creating kunjungan: " . $e->getMessage() . ", User=" . (auth()->id() ?? 'guest') . ", IP={$request->ip()}, Input=" . json_encode($request->all()));
        return back()->with('error', 'Gagal mengajukan kunjungan: ' . $e->getMessage())->withInput();
    }
}

    public function success(Request $request)
    {
        $tracking_code = $request->query('tracking_code');
        $tracking_link = $request->query('tracking_link');
        return view('user.services.visits.success', compact('tracking_code', 'tracking_link'));
    }

    public function cancel(Kunjungan $kunjungan)
    {
        try {
            if (!$kunjungan->canBeCancelled()) {
                return back()->with('error', 'Kunjungan tidak dapat dibatalkan.');
            }
            $kunjungan->jadwal()->update(['kunjunganId' => null]);
            $kunjungan->update(['status' => 'CANCELLED']);
            Log::info("Kunjungan cancelled: ID={$kunjungan->id}, TrackingCode={$kunjungan->tracking_code}, User=" . (auth()->id() ?? 'guest') . ", IP=" . request()->ip());
            return back()->with('success', 'Kunjungan berhasil dibatalkan.');
        } catch (\Exception $e) {
            Log::error("Error cancelling kunjungan: " . $e->getMessage() . ", User=" . (auth()->id() ?? 'guest') . ", IP=" . request()->ip());
            return back()->with('error', 'Gagal membatalkan kunjungan: ' . $e->getMessage());
        }
    }
}