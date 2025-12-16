<?php

namespace Database\Factories;

use App\Models\Misi;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class MisiFactory extends Factory
{
    protected $model = Misi::class;

    public function definition(): array
    {
        return [
            'id' => (string) Str::uuid(),
            'deskripsi' => $this->faker->sentence(10),
            'urutan' => $this->faker->numberBetween(1, 10),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
