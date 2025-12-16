<?php

namespace Database\Factories;

use App\Models\LayananPengujian;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class LayananPengujianFactory extends Factory
{
    protected $model = LayananPengujian::class;

    public function definition(): array
    {
        return [
            'namaLayanan' => $this->faker->randomElement([
                'Uji XRD (X-Ray Diffraction)',
                'Uji SEM (Scanning Electron Microscopy)',
                'Uji FTIR (Fourier Transform Infrared Spectroscopy)',
                'Uji UV-Vis Spectroscopy',
                'Uji Konduktivitas Material'
            ]),
            'deskripsi' => $this->faker->paragraph(),
            'harga' => $this->faker->numberBetween(100000, 1000000),
            'estimasiSelesaiHari' => $this->faker->numberBetween(1, 7),
            'isAktif' => $this->faker->boolean(80),
            'instruksiSampel' => $this->faker->optional()->paragraph(),
        ];
    }
}
