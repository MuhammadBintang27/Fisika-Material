<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\LayananPengujian;

class LayananPengujianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $layananPengujian = [
            [
                'namaLayanan' => 'Analisis XRD (X-Ray Diffraction)',
                'deskripsi' => 'Karakterisasi struktur kristal material menggunakan difraksi sinar-X. Cocok untuk identifikasi fase mineral, analisis kualitatif dan kuantitatif kristal.',
                'harga' => 150000,
                'estimasiSelesaiHari' => 3,
                'isAktif' => true,
            ],
            [
                'namaLayanan' => 'Analisis SEM-EDS',
                'deskripsi' => 'Scanning Electron Microscopy dengan Energy Dispersive Spectroscopy untuk karakterisasi morfologi dan komposisi unsur material.',
                'harga' => 200000,
                'estimasiSelesaiHari' => 5,
                'isAktif' => true,
            ],
            [
                'namaLayanan' => 'Analisis FTIR',
                'deskripsi' => 'Fourier Transform Infrared Spectroscopy untuk identifikasi gugus fungsi dan karakterisasi ikatan kimia dalam material.',
                'harga' => 100000,
                'estimasiSelesaiHari' => 2,
                'isAktif' => true,
            ],
            [
                'namaLayanan' => 'Analisis TGA-DSC',
                'deskripsi' => 'Thermogravimetric Analysis dan Differential Scanning Calorimetry untuk analisis termal material.',
                'harga' => 175000,
                'estimasiSelesaiHari' => 4,
                'isAktif' => true,
            ],
            [
                'namaLayanan' => 'Pengujian Konduktivitas Listrik',
                'deskripsi' => 'Pengukuran sifat konduktivitas listrik material untuk aplikasi elektronik dan energi.',
                'harga' => null,
                'estimasiSelesaiHari' => 1,
                'isAktif' => true,
            ],
            [
                'namaLayanan' => 'Analisis UV-Vis Spectroscopy',
                'deskripsi' => 'Karakterisasi sifat optik material menggunakan spektroskopi UV-Visible untuk analisis band gap dan absorpsi.',
                'harga' => 75000,
                'estimasiSelesaiHari' => 2,
                'isAktif' => true,
            ],
            [
                'namaLayanan' => 'Pengujian Sifat Magnetik',
                'deskripsi' => 'Karakterisasi sifat magnetik material menggunakan Vibrating Sample Magnetometer (VSM).',
                'harga' => 250000,
                'estimasiSelesaiHari' => 7,
                'isAktif' => false,
            ],
        ];

        foreach ($layananPengujian as $layanan) {
            LayananPengujian::create($layanan);
        }
    }
}
