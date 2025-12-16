<?php

namespace Database\Factories;

use App\Models\Kunjungan;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class KunjunganFactory extends Factory
{
    protected $model = Kunjungan::class;

    public function definition(): array
    {
        return [
            'id' => (string) Str::uuid(),
            'tracking_code' => 'KUNJ-' . strtoupper(Str::random(6)),
            'namaPengunjung' => $this->faker->name(),
            'noHp' => $this->faker->numerify('08##########'),
            'namaInstansi' => $this->faker->company(),
            'tujuan' => $this->faker->randomElement(['Study Tour', 'Penelitian', 'Observasi', 'Kerjasama']),
            'jumlahPengunjung' => $this->faker->numberBetween(5, 50),
            'status' => 'PENDING',
            'suratPengajuan' => 'kunjungan/surat-' . Str::random(10) . '.pdf',
            'notes' => $this->faker->optional()->sentence(),
        ];
    }
}
