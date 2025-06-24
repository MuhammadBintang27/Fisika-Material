<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\JenisPengujian;

class JenisPengujianSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'id' => Str::uuid(),
                'namaPengujian' => 'Analisis Spektroskopi UV-Vis',
                'hargaPerSampel' => 500000,
                'isAvailable' => true,
            ],
            [
                'id' => Str::uuid(),
                'namaPengujian' => 'Analisis FTIR',
                'hargaPerSampel' => 750000,
                'isAvailable' => true,
            ],
            [
                'id' => Str::uuid(),
                'namaPengujian' => 'Analisis XRD',
                'hargaPerSampel' => 1000000,
                'isAvailable' => true,
            ],
            [
                'id' => Str::uuid(),
                'namaPengujian' => 'Analisis Termal',
                'hargaPerSampel' => 600000,
                'isAvailable' => true,
            ],
            [
                'id' => Str::uuid(),
                'namaPengujian' => 'Pengujian Mekanik',
                'hargaPerSampel' => 400000,
                'isAvailable' => true,
            ],
            [
                'id' => Str::uuid(),
                'namaPengujian' => 'Pengujian Konduktivitas',
                'hargaPerSampel' => 300000,
                'isAvailable' => true,
            ],
        ];

        foreach ($data as $item) {
            JenisPengujian::create($item);
        }
    }
} 
 