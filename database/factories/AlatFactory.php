<?php

namespace Database\Factories;

use App\Models\Alat;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class AlatFactory extends Factory
{
    protected $model = Alat::class;

    public function definition(): array
    {
        $stokTotal = $this->faker->numberBetween(5, 15);
        $stokDipinjam = $this->faker->numberBetween(0, $stokTotal - 1);
        $stokRusak = $this->faker->numberBetween(0, 2);
        
        return [
            'id' => (string) Str::uuid(),
            'nama' => $this->faker->randomElement([
                'Oscilloscope Digital',
                'Multimeter Digital',
                'Function Generator',
                'Spectrometer',
                'Laser He-Ne',
                'Power Supply',
                'Signal Generator',
                'LCR Meter'
            ]) . ' ' . $this->faker->numberBetween(1, 100),
            'deskripsi' => $this->faker->sentence(10),
            'isBroken' => $this->faker->boolean(20), // 20% chance rusak
            'stok' => $stokTotal,
            'stok_dipinjam' => $stokDipinjam,
            'stok_rusak' => $stokRusak,
            'harga' => $this->faker->randomFloat(2, 1000000, 50000000), // 1 juta - 50 juta
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    public function tersedia(): static
    {
        return $this->state(fn (array $attributes) => [
            'isBroken' => false,
            'stok' => $this->faker->numberBetween(5, 15),
            'stok_dipinjam' => 0,
            'stok_rusak' => 0,
        ]);
    }

    public function tidakTersedia(): static
    {
        $stok = $this->faker->numberBetween(2, 5);
        return $this->state(fn (array $attributes) => [
            'stok' => $stok,
            'stok_dipinjam' => $stok, // semua dipinjam
        ]);
    }

    public function rusak(): static
    {
        return $this->state(fn (array $attributes) => [
            'isBroken' => true,
        ]);
    }
    
    public function baik(): static
    {
        return $this->state(fn (array $attributes) => [
            'isBroken' => false,
        ]);
    }
}
