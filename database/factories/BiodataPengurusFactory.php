<?php

namespace Database\Factories;

use App\Models\BiodataPengurus;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class BiodataPengurusFactory extends Factory
{
    protected $model = BiodataPengurus::class;

    public function definition(): array
    {
        return [
            'id' => (string) Str::uuid(),
            'nama' => $this->faker->name(),
            'jabatan' => $this->faker->randomElement(['Ketua Laboratorium', 'Tenaga Laboran']),
        ];
    }
}
