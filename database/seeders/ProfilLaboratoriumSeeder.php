<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ProfilLaboratorium;
use App\Models\Misi;
use Illuminate\Support\Str;

class ProfilLaboratoriumSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Laboratory Profile
        $profilLab = ProfilLaboratorium::create([
            'id' => Str::uuid(),
            'namaLaboratorium' => 'Material dan Energi',
            'tentangLaboratorium' => 'Laboratorium Material dan Energi adalah fasilitas penelitian yang mengkhususkan diri dalam pengembangan material maju dan teknologi energi berkelanjutan. Dilengkapi dengan instrumentasi canggih untuk karakterisasi material dan analisis energi, laboratorium ini mendukung inovasi teknologi melalui penelitian berkualitas tinggi dan layanan pengujian profesional.',
            'visi' => 'Menjadi laboratorium material dan energi yang terdepan dalam penelitian, pengujian, dan pengembangan teknologi material serta energi berkelanjutan untuk mendukung kemajuan industri dan kesejahteraan masyarakat.',
        ]);

        // Create Mission Points
        $misiPoints = [
            'Melakukan penelitian dan pengembangan material maju untuk aplikasi teknologi masa depan dengan menggunakan metode karakterisasi yang komprehensif.',
            'Menyediakan layanan pengujian dan analisis material untuk mendukung kebutuhan industri, penelitian, dan pengembangan produk.',
            'Mengembangkan teknologi energi terbarukan dan sistem penyimpanan energi yang efisien dan ramah lingkungan.',
            'Memberikan layanan konsultasi teknis dan transfer teknologi kepada industri dalam bidang material dan energi.',
            'Menjalin kerjasama strategis dengan institusi penelitian, universitas, dan industri untuk mempercepat inovasi teknologi.',
            'Mengembangkan sumber daya manusia yang kompeten melalui program pelatihan, workshop, dan pendampingan riset.',
        ];

        foreach ($misiPoints as $point) {
            Misi::create([
                'id' => Str::uuid(),
                'profilLaboratoriumId' => $profilLab->id,
                'pointMisi' => $point,
            ]);
        }

        $this->command->info('Profil Laboratorium dan Misi berhasil dibuat!');
    }
}
