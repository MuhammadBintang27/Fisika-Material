<?php

namespace Database\Factories;

use App\Models\PengajuanPengujian;
use App\Models\LayananPengujian;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PengajuanPengujianFactory extends Factory
{
    protected $model = PengajuanPengujian::class;

    public function definition(): array
    {
        return [
            'trackingCode' => 'TEST-' . strtoupper(Str::random(8)),
            'namaPengaju' => $this->faker->name(),
            'noHp' => $this->faker->numerify('08##########'),
            'email' => $this->faker->unique()->safeEmail(),
            'instansi' => $this->faker->company(),
            'alamat' => $this->faker->address(),
            'userType' => $this->faker->randomElement(['UMUM', 'MAHASISWA', 'DOSEN']),
            'nim' => $this->faker->optional()->numerify('##########'),
            'nip' => $this->faker->optional()->numerify('##########'),
            'prodi' => $this->faker->optional()->randomElement(['Fisika', 'Kimia', 'Biologi']),
            'layananId' => LayananPengujian::factory(),
            'tanggalPenyerahan' => $this->faker->dateTimeBetween('now', '+30 days'),
            'jumlahSampel' => $this->faker->numberBetween(1, 10),
            'deskripsiSampel' => $this->faker->paragraph(),
            'status' => 'MENUNGGU',
            'catatanAdmin' => $this->faker->optional()->sentence(),
        ];
    }
}
