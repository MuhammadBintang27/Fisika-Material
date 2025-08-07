<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\Kunjungan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class TrackingController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->query('type');
        $tracking_code = $request->query('tracking_code');
        $loans = collect();
        $record = null;

        // Validate query parameters
        $validator = Validator::make($request->query(), [
            'type' => 'sometimes|in:peminjaman,kunjungan',
            'tracking_code' => 'sometimes|string|max:255',
        ]);

        if ($validator->fails()) {
            Log::warning("Invalid tracking parameters", [
                'errors' => $validator->errors()->all(),
                'ip' => $request->ip(),
                'query' => $request->query()
            ]);
            return view('user.services.tracking', [
                'loans' => collect(),
                'record' => null,
            ])->withErrors(['error' => 'Jenis pengajuan atau kode tracking tidak valid.']);
        }

        try {
            if ($type && $tracking_code) {
                if ($type === 'peminjaman') {
                    $loans = Peminjaman::with('items.alat')
                        ->where('tracking_code', $tracking_code)
                        ->get();
                    if ($loans->isEmpty()) {
                        Log::info("Tracking failed: No loans found", [
                            'tracking_code' => $tracking_code,
                            'type' => $type,
                            'ip' => $request->ip()
                        ]);
                        return view('user.services.tracking', [
                            'loans' => collect(),
                            'record' => null,
                        ])->withErrors(['error' => 'Tidak ada peminjaman ditemukan untuk kode tracking tersebut.']);
                    }
                } elseif ($type === 'kunjungan') {
                    $record = Kunjungan::with('jadwal')
                        ->where('tracking_code', $tracking_code)
                        ->first();
                    if (!$record) {
                        Log::info("Tracking failed: No kunjungan found", [
                            'tracking_code' => $tracking_code,
                            'type' => $type,
                            'ip' => $request->ip()
                        ]);
                        return view('user.services.tracking', [
                            'loans' => collect(),
                            'record' => null,
                        ])->withErrors(['error' => 'Tidak ada kunjungan ditemukan untuk kode tracking tersebut.']);
                    }
                }
            }

            Log::info("Tracking request processed", [
                'tracking_code' => $tracking_code ?? 'none',
                'type' => $type ?? 'none',
                'ip' => $request->ip()
            ]);

            return view('user.services.tracking', compact('loans', 'record'));
        } catch (\Exception $e) {
            Log::error("Error tracking", [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'tracking_code' => $tracking_code ?? 'none',
                'type' => $type ?? 'none',
                'ip' => $request->ip()
            ]);
            return view('user.services.tracking', [
                'loans' => collect(),
                'record' => null,
            ])->withErrors(['error' => 'Gagal melacak pengajuan: ' . $e->getMessage()]);
        }
    }

    public function cancel(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type' => 'required|in:peminjaman,kunjungan',
            'id' => 'required|string|uuid',
        ]);

        if ($validator->fails()) {
            Log::warning("Cancel failed: Invalid input", [
                'errors' => $validator->errors()->all(),
                'ip' => $request->ip(),
                'input' => $request->all()
            ]);
            return back()->withErrors(['error' => 'Jenis pengajuan atau ID tidak valid.']);
        }

        $type = $request->input('type');
        $id = $request->input('id');

        try {
            if ($type === 'peminjaman') {
                $peminjaman = Peminjaman::findOrFail($id);
                if (!$peminjaman->canBeCancelled()) {
                    Log::warning("Cancel failed: Peminjaman cannot be cancelled", [
                        'id' => $id,
                        'status' => $peminjaman->status,
                        'ip' => $request->ip()
                    ]);
                    return back()->withErrors(['error' => 'Peminjaman tidak dapat dibatalkan karena status saat ini.']);
                }
                $peminjaman->update(['status' => 'CANCELLED']);
                Log::info("Peminjaman cancelled successfully", [
                    'id' => $peminjaman->id,
                    'tracking_code' => $peminjaman->tracking_code,
                    'ip' => $request->ip()
                ]);
                return redirect()->route('tracking', ['type' => 'peminjaman', 'tracking_code' => $peminjaman->tracking_code])
                    ->with('success', 'Peminjaman berhasil dibatalkan.');
            } elseif ($type === 'kunjungan') {
                $kunjungan = Kunjungan::findOrFail($id);
                if (!$kunjungan->canBeCancelled()) {
                    Log::warning("Cancel failed: Kunjungan cannot be cancelled", [
                        'id' => $id,
                        'status' => $kunjungan->status,
                        'ip' => $request->ip()
                    ]);
                    return back()->withErrors(['error' => 'Kunjungan tidak dapat dibatalkan karena status saat ini.']);
                }
                $kunjungan->jadwal()->update(['kunjunganId' => null]);
                $kunjungan->update(['status' => 'CANCELLED']);
                Log::info("Kunjungan cancelled successfully", [
                    'id' => $kunjungan->id,
                    'tracking_code' => $kunjungan->tracking_code,
                    'ip' => $request->ip()
                ]);
                return redirect()->route('tracking', ['type' => 'kunjungan', 'tracking_code' => $kunjungan->tracking_code])
                    ->with('success', 'Kunjungan berhasil dibatalkan.');
            } else {
                Log::warning("Cancel failed: Invalid type", [
                    'type' => $type,
                    'id' => $id,
                    'ip' => $request->ip()
                ]);
                return back()->withErrors(['error' => 'Jenis pengajuan tidak valid.']);
            }
        } catch (\Exception $e) {
            Log::error("Error cancelling", [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'type' => $type,
                'id' => $id,
                'ip' => $request->ip()
            ]);
            return back()->withErrors(['error' => 'Gagal membatalkan pengajuan: ' . $e->getMessage()]);
        }
    }
}