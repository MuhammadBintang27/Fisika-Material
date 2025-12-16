<?php

namespace Database\Factories;

use App\Models\Artikel;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ArtikelFactory extends Factory
{
    protected $model = Artikel::class;

    public function definition(): array
    {
        return [
            'id' => (string) Str::uuid(),
            'namaAcara' => $this->faker->sentence(5),
            'deskripsi' => $this->faker->paragraphs(3, true),
            'penulis' => $this->faker->name(),
            'tanggalAcara' => $this->faker->dateTimeBetween('-6 months', '+6 months'),
            'deskripsi_penulis' => $this->faker->sentence(10),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
