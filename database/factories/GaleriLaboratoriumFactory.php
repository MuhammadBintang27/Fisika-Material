<?php

namespace Database\Factories;

use App\Models\GaleriLaboratorium;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class GaleriLaboratoriumFactory extends Factory
{
    protected $model = GaleriLaboratorium::class;

    public function definition(): array
    {
        return [
            'id' => (string) Str::uuid(),
            'judul' => $this->faker->sentence(4),
            'deskripsi' => $this->faker->paragraph(),
            'kategori' => $this->faker->randomElement(['Fasilitas', 'Kegiatan', 'Penelitian', 'Kunjungan']),
            'gambar' => 'gallery/default.jpg',
            'tanggal' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
