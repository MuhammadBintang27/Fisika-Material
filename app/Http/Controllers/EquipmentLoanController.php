<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alat;
use App\Models\Peminjaman;
use App\Models\PeminjamanItem;
use Illuminate\Support\Str;

class EquipmentLoanController extends Controller
{
    public function index()
    {
        $equipments = Alat::with(['gambar' => function($q) {
            $q->where('kategori', 'ALAT');
        }])->get();
        // Optionally, build categories dynamically from alat table if needed
        $categories = ['all' => 'Semua Kategori'];
        // ... you can add more logic for categories if you add a category field to alat
        $success = session('success');
        return view('services.equipment-loan', compact('equipments', 'categories', 'success'));
    }

    public function show($id)
    {
        $equipment = Alat::with('gambar')->find($id);
        if (!$equipment) {
            abort(404);
        }
        return view('services.equipment-detail', compact('equipment'));
    }

    public function requestLoan(Request $request)
    {
        $request->validate([
            'namaPeminjam' => 'required|string|max:255',
            'noHp' => 'required|string|max:20',
            'tujuanPeminjaman' => 'nullable|string',
            'tanggal_pinjam' => 'required|date|after_or_equal:today',
            'tanggal_pengembalian' => 'required|date|after:tanggal_pinjam',
            'alat' => 'required',
        ]);
        $alatArr = json_decode($request->alat, true);
        if (!is_array($alatArr) || count($alatArr) < 1) {
            return back()->withErrors(['alat' => 'Pilih minimal satu alat']);
        }
        $peminjaman = Peminjaman::create([
            'id' => Str::uuid(),
            'namaPeminjam' => $request->namaPeminjam,
            'noHp' => $request->noHp,
            'tujuanPeminjaman' => $request->tujuanPeminjaman,
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'tanggal_pengembalian' => $request->tanggal_pengembalian,
            'status' => 'PENDING',
        ]);
        foreach ($alatArr as $item) {
            PeminjamanItem::create([
                'id' => Str::uuid(),
                'peminjamanId' => $peminjaman->id,
                'alat_id' => $item['id'],
                'jumlah' => $item['jumlah'],
            ]);
        }
        return redirect()->route('equipment.loan')->with('success', 'Permohonan peminjaman berhasil dikirim! Kami akan menghubungi Anda dalam 1x24 jam.');
    }

    private function getEquipmentById($id)
    {
        $equipments = $this->getAllEquipments();
        return collect($equipments)->where('id', $id)->first();
    }

    private function getAllEquipments()
    {
        return [
            [
                'id' => 1,
                'name' => 'Oscilloscope Digital',
                'model' => 'Tektronix TBS1052B',
                'image' => 'oscilloscope.jpeg',
                'category' => 'Elektronika',
                'status' => 'available',
                'quantity_total' => 5,
                'quantity_available' => 3,
                'description' => 'Oscilloscope digital 50MHz dengan 2 channel untuk analisis sinyal elektronik dan pengukuran gelombang.',
                'specifications' => [
                    'Bandwidth: 50 MHz',
                    'Sample Rate: 1 GS/s',
                    'Channels: 2',
                    'Display: 7 inch Color TFT',
                    'Memory Depth: 2.5k points'
                ],
                'loan_duration' => '1-7 hari',
                'requirements' => [
                    'Mahasiswa semester 3 ke atas',
                    'Surat permohonan dari dosen',
                    'Deposit Rp 500.000'
                ],
                'icon' => 'fas fa-wave-square',
                'color' => 'blue'
            ],

            [
                'id' => 2,
                'name' => 'Multimeter Digital',
                'model' => 'Fluke 87V',
                'image' => 'multimeter.jpeg',
                'category' => 'Pengukuran',
                'status' => 'available',
                'quantity_total' => 10,
                'quantity_available' => 7,
                'description' => 'Multimeter digital presisi tinggi untuk pengukuran tegangan, arus, resistansi, dan parameter listrik lainnya.',
                'specifications' => [
                    'DC Voltage: 0.1 mV - 1000 V',
                    'AC Voltage: 0.1 mV - 750 V',
                    'DC Current: 0.01 mA - 10 A',
                    'Resistance: 0.1 Ω - 50 MΩ',
                    'Frequency: 0.5 Hz - 200 kHz'
                ],
                'loan_duration' => '1-14 hari',
                'requirements' => [
                    'Mahasiswa semester 2 ke atas',
                    'Kartu mahasiswa aktif',
                    'Deposit Rp 200.000'
                ],
                'icon' => 'fas fa-tachometer-alt',
                'color' => 'green'
            ],
            [
                'id' => 3,
                'name' => 'Function Generator',
                'model' => 'Rigol DG1032Z',
                'image' => 'function-generator.jpeg',
                'category' => 'Generator',
                'status' => 'available',
                'quantity_total' => 3,
                'quantity_available' => 2,
                'description' => 'Function generator 30MHz untuk menghasilkan berbagai bentuk gelombang sinusoidal, kotak, dan segitiga.',
                'specifications' => [
                    'Frequency Range: 1 μHz - 30 MHz',
                    'Waveforms: Sine, Square, Triangle, Pulse',
                    'Amplitude: 1 mVpp - 10 Vpp',
                    'Channels: 2',
                    'Arbitrary Waveform: 14-bit, 125 MSa/s'
                ],
                'loan_duration' => '1-7 hari',
                'requirements' => [
                    'Mahasiswa semester 3 ke atas',
                    'Surat permohonan dari dosen',
                    'Deposit Rp 300.000'
                ],
                'icon' => 'fas fa-broadcast-tower',
                'color' => 'purple'
            ],
            [
                'id' => 4,
                'name' => 'Power Supply DC',
                'model' => 'Keysight E3631A',
                'image' => 'power-supply.jpeg',
                'category' => 'Power',
                'status' => 'maintenance',
                'quantity_total' => 4,
                'quantity_available' => 0,
                'description' => 'Power supply DC triple output dengan regulasi tinggi untuk berbagai kebutuhan eksperimen elektronika.',
                'specifications' => [
                    'Output 1: 0-6V, 0-5A',
                    'Output 2: 0-25V, 0-1A',
                    'Output 3: 0-25V, 0-1A',
                    'Regulation: ±0.01%',
                    'Ripple: <1 mVrms'
                ],
                'loan_duration' => '1-7 hari',
                'requirements' => [
                    'Mahasiswa semester 3 ke atas',
                    'Surat permohonan dari dosen',
                    'Deposit Rp 400.000'
                ],
                'icon' => 'fas fa-plug',
                'color' => 'red'
            ],
            [
                'id' => 5,
                'name' => 'Spektrum Analyzer',
                'model' => 'Rohde & Schwarz FSW-B',
                'image' => 'spectrum-analyzer.jpg',
                'category' => 'Analisis',
                'status' => 'available',
                'quantity_total' => 2,
                'quantity_available' => 1,
                'description' => 'Spektrum analyzer untuk analisis frekuensi dan karakteristik sinyal RF dengan akurasi tinggi.',
                'specifications' => [
                    'Frequency Range: 2 Hz - 26.5 GHz',
                    'Resolution Bandwidth: 0.1 Hz - 50 MHz',
                    'Dynamic Range: >70 dB',
                    'Phase Noise: -136 dBc/Hz',
                    'Display: 12.1" Touchscreen'
                ],
                'loan_duration' => '1-5 hari',
                'requirements' => [
                    'Mahasiswa semester 5 ke atas',
                    'Surat permohonan dari dosen',
                    'Training penggunaan alat',
                    'Deposit Rp 1.000.000'
                ],
                'icon' => 'fas fa-chart-line',
                'color' => 'indigo'
            ],
            [
                'id' => 6,
                'name' => 'Digital Caliper',
                'model' => 'Mitutoyo 500-196-30',
                'image' => 'digital-caliper.png',
                'category' => 'Pengukuran',
                'status' => 'available',
                'quantity_total' => 15,
                'quantity_available' => 12,
                'description' => 'Jangka sorong digital presisi tinggi untuk pengukuran dimensi dengan akurasi 0.01mm.',
                'specifications' => [
                    'Range: 0-150 mm',
                    'Resolution: 0.01 mm',
                    'Accuracy: ±0.02 mm',
                    'Battery Life: 3.8 years',
                    'IP67 Protection'
                ],
                'loan_duration' => '1-30 hari',
                'requirements' => [
                    'Mahasiswa aktif',
                    'Kartu mahasiswa',
                    'Deposit Rp 50.000'
                ],
                'icon' => 'fas fa-ruler-combined',
                'color' => 'yellow'
            ]
        ];
    }
}
