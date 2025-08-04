<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ArtikelSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('artikel')->insert([
            [
                'id' => Str::uuid(),
                'namaAcara' => 'Seminar Nasional Fisika Kebumian 2025',
                'deskripsi' => 'Event tahunan yang mempertemukan para peneliti fisika kebumian dari seluruh Indonesia. Seminar ini akan membahas perkembangan terbaru dalam penelitian fisika kebumian dan aplikasinya dalam kehidupan sehari-hari.',
                'penulis' => 'Dr. Rina Kartika',
                'deskripsi_penulis' => 'Peneliti senior di Laboratorium Fisika Dasar dengan spesialisasi fisika kebumian. Memiliki pengalaman lebih dari 15 tahun dalam penelitian geofisika dan telah mempublikasikan lebih dari 50 paper di jurnal internasional.',
                'tanggalAcara' => '2025-05-25 09:00:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'namaAcara' => 'Workshop Kalibrasi Alat Ukur Geofisika',
                'deskripsi' => 'Pelatihan kalibrasi alat ukur geofisika untuk meningkatkan akurasi pengukuran dalam penelitian. Workshop ini akan memberikan pemahaman mendalam tentang teknik kalibrasi dan maintenance alat ukur geofisika.',
                'penulis' => 'Dr. Maya Sari',
                'deskripsi_penulis' => 'Dosen dan peneliti di Laboratorium Fisika Dasar dengan fokus pada instrumentasi dan kalibrasi alat ukur. Ahli dalam pengembangan teknologi pengukuran presisi untuk aplikasi geofisika.',
                'tanggalAcara' => '2025-06-05 13:00:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
} 