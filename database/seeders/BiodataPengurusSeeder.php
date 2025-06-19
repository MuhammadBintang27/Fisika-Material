<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class BiodataPengurusSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('biodata_pengurus')->insert([
            [
                'id' => Str::uuid(),
                'nama' => 'Dr. Nasrullah, S.Si, M.Si.,M.Sc',
                'jabatan' => 'Kepala Laboratorium',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'nama' => 'Intan Mulia Sari, S.Si., M.Si.',
                'jabatan' => 'Tenaga Pengajar',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'nama' => 'Anla Fet Hardi, S.Si., M.Si.',
                'jabatan' => 'Tenaga Pengajar',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'nama' => 'Vikah Suci Novianti, S.Si',
                'jabatan' => 'Laboran',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'nama' => 'Dini Rizqi Dwi Kunti Siregar, S.Si., M.Si',
                'jabatan' => 'Laboran',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
} 