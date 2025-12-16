<?php

namespace Database\Factories;

use App\Models\Peminjaman;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PeminjamanFactory extends Factory
{
    protected $model = Peminjaman::class;

    public function definition(): array
    {
        return [
            'id' => (string) Str::uuid(),
            'tracking_code' => 'LOAN-' . strtoupper(Str::random(8)),
            'user_type' => $this->faker->randomElement(['dosen', 'mahasiswa', 'pihak-luar']),
            'namaPeminjam' => $this->faker->name(),
            'noHp' => $this->faker->numerify('08##########'),
            'email' => $this->faker->unique()->safeEmail(),
            'nip_nim' => $this->faker->numerify('##########'),
            'instansi' => $this->faker->company(),
            'jabatan' => $this->faker->optional()->jobTitle(),
            'judul_penelitian' => $this->faker->optional()->sentence(),
            'deskripsi_penelitian' => $this->faker->optional()->paragraph(),
            'tujuan_peminjaman' => $this->faker->optional()->paragraph(),
            'tanggal_pinjam' => $this->faker->dateTimeBetween('now', '+7 days'),
            'tanggal_pengembalian' => $this->faker->dateTimeBetween('+8 days', '+14 days'),
            'durasi_jam' => $this->faker->numberBetween(1, 8),
            'status' => 'PENDING',
            'notes' => $this->faker->optional()->sentence(),
            'supervisor_name' => $this->faker->optional()->name(),
            'supervisor_nip' => $this->faker->optional()->numerify('##########'),
        ];
    }
}
