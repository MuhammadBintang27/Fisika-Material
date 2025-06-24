<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class GambarSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil artikel, alat, dan staff yang sudah di-seed
        $artikel = DB::table('artikel')->get();
        $alat = DB::table('alat')->get();
        $staff = DB::table('biodata_pengurus')->get();

        // Gambar untuk artikel
        if ($artikel->count() > 0) {
            // Artikel 1
            DB::table('gambar')->insert([
                'id' => Str::uuid(),
                'acaraId' => $artikel[0]->id,
                'url' => 'images/articles/1750654948.jpg',
                'kategori' => 'ACARA',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            // Artikel 2
            if ($artikel->count() > 1) {
                DB::table('gambar')->insert([
                    'id' => Str::uuid(),
                    'acaraId' => $artikel[1]->id,
                    'url' => 'images/articles/1750654948.jpg',
                    'kategori' => 'ACARA',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        // Gambar untuk alat
        $alatGambar = [
            'Oscilloscope Digital' => 'images/equipment/oscilloscope.jpeg',
            'Multimeter Digital' => 'images/equipment/multimeter.jpeg',
            'Function Generator' => 'images/equipment/function-generator.jpeg',
            'Power Supply DC' => 'images/equipment/power-supply.jpeg',
            'Spektrum Analyzer' => 'images/equipment/spectrum-analyzer.jpg',
            'Digital Caliper' => 'images/equipment/digital-caliper.png',
        ];
        foreach ($alat as $a) {
            if (isset($alatGambar[$a->nama])) {
                DB::table('gambar')->insert([
                    'id' => Str::uuid(),
                    'alatID' => $a->id,
                    'url' => $alatGambar[$a->nama],
                    'kategori' => 'ALAT',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        // Gambar untuk staff/pengurus
        $staffGambar = [
            'Dr. Nasrullah, S.Si, M.Si.,M.Sc' => 'images/staff/ketua-lab.jpg',
            'Intan Mulia Sari, S.Si., M.Si.' => 'images/staff/tenaga-pengajar-1.png',
            'Anla Fet Hardi, S.Si., M.Si.' => 'images/staff/tenaga-pengajar-2.jpg',
            'Vikah Suci Novianti, S.Si' => 'images/staff/laboran-1.jpg',
            'Dini Rizqi Dwi Kunti Siregar, S.Si., M.Si' => 'images/staff/laboran-2.jpg',
        ];
        foreach ($staff as $s) {
            if (isset($staffGambar[$s->nama])) {
                DB::table('gambar')->insert([
                    'id' => Str::uuid(),
                    'pengurusId' => $s->id,
                    'url' => $staffGambar[$s->nama],
                    'kategori' => 'PENGURUS',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
} 