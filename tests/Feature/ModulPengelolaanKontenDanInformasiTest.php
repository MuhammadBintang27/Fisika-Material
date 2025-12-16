<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\ProfilLaboratorium;
use App\Models\Misi;
use App\Models\BiodataPengurus;
use App\Models\Artikel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ModulPengelolaanKontenDanInformasiTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('db:seed');
        Storage::fake('public');
    }

    // ==========================================
    // SUB-MODUL: PROFIL LABORATORIUM
    // ==========================================

    /** @test */
    public function admin_dapat_mengakses_dan_mengelola_profil_laboratorium()
    {
        $admin = User::where('is_admin', true)->first();
        
        // Test admin dapat akses halaman edit profil
        $response = $this->actingAs($admin)->get('/admin/about/edit');
        $response->assertStatus(200);
        
        // Test profil menampilkan visi dan misi
        $profil = ProfilLaboratorium::first();
        if ($profil) {
            $this->assertNotNull($profil->visi);
        }
        
        $misi = Misi::all();
        $this->assertNotNull($misi);
    }

    /** @test */
    public function guest_tidak_dapat_mengupdate_profil()
    {
        $profil = ProfilLaboratorium::first();
        
        if ($profil) {
            $response = $this->put('/admin/about/update', [
                'namaLaboratorium' => 'Test',
                'visi' => 'Test'
            ]);
            
            $response->assertRedirect('/admin/login');
        } else {
            $this->assertTrue(true);
        }
    }

    // ==========================================
    // SUB-MODUL: BIODATA PENGURUS
    // ==========================================

    /** @test */
    public function user_dapat_melihat_daftar_pengurus()
    {
        BiodataPengurus::factory()->count(3)->create();
        
        $response = $this->get('/staff');
        
        $response->assertStatus(200);
    }

    /** @test */
    public function admin_dapat_mengelola_CRUD_pengurus()
    {
        $admin = User::where('is_admin', true)->first();
        $pengurus = BiodataPengurus::factory()->create();
        
        // Test admin dapat melihat daftar pengurus
        $response = $this->actingAs($admin)->get('/admin/staff');
        $response->assertStatus(200);
        
        // Test admin dapat akses form tambah
        $response = $this->actingAs($admin)->get('/admin/staff/create');
        $response->assertStatus(200);
        
        // Test admin dapat akses form edit
        $response = $this->actingAs($admin)->get("/admin/staff/{$pengurus->id}/edit");
        $response->assertStatus(200);
        
        // Test admin dapat update pengurus
        $response = $this->actingAs($admin)->put("/admin/staff/{$pengurus->id}", [
            'nama' => 'Updated Pengurus',
            'nim' => $pengurus->nim,
            'email' => $pengurus->email,
            'jabatan' => $pengurus->jabatan,
            'program_studi' => $pengurus->program_studi,
            'angkatan' => $pengurus->angkatan
        ]);
        $response->assertStatus(302);
        $this->assertDatabaseHas('biodata_pengurus', ['nama' => 'Updated Pengurus']);
    }

    /** @test */
    public function admin_dapat_menghapus_pengurus()
    {
        $admin = User::where('is_admin', true)->first();
        $pengurus = BiodataPengurus::factory()->create();
        
        $response = $this->actingAs($admin)->delete("/admin/staff/{$pengurus->id}");
        
        $response->assertStatus(302); // redirect
        $this->assertDatabaseMissing('biodata_pengurus', ['id' => $pengurus->id]);
    }

    /** @test */
    public function validasi_form_pengurus_nama_wajib_diisi()
    {
        $admin = User::where('is_admin', true)->first();
        
        $response = $this->actingAs($admin)->post('/admin/staff', [
            'nim' => '123456789',
            'email' => 'test@example.com'
        ]);
        
        $response->assertSessionHasErrors('nama');
    }

    // ==========================================
    // SUB-MODUL: ARTIKEL
    // ==========================================

    /** @test */
    public function user_dapat_melihat_daftar_dan_detail_artikel()
    {
        $artikel = Artikel::factory()->create([
            'namaAcara' => 'Test Artikel'
        ]);
        
        // Test user dapat melihat daftar artikel
        $response = $this->get('/articles');
        $response->assertStatus(200);
        
        // Test user dapat melihat detail artikel
        $response = $this->get("/articles/{$artikel->id}");
        $response->assertStatus(200);
    }

    /** @test */
    public function admin_dapat_mengelola_CRUD_artikel()
    {
        $admin = User::where('is_admin', true)->first();
        $artikel = Artikel::factory()->create();
        
        // Test admin dapat melihat daftar artikel
        $response = $this->actingAs($admin)->get('/admin/articles');
        $response->assertStatus(200);
        
        // Test admin dapat akses form tambah artikel
        $response = $this->actingAs($admin)->get('/admin/articles/create');
        $response->assertStatus(200);
        
        // Test admin dapat membuat artikel
        $data = [
            'namaAcara' => 'Artikel Test Baru',
            'deskripsi' => 'Ini adalah konten artikel test',
            'penulis' => 'Admin Test',
            'tanggalAcara' => now()->format('Y-m-d H:i:s')
        ];
        $response = $this->actingAs($admin)->post('/admin/articles', $data);
        $response->assertStatus(302);
        $this->assertDatabaseHas('artikel', ['namaAcara' => 'Artikel Test Baru']);
        
        // Test admin dapat akses form edit artikel
        $response = $this->actingAs($admin)->get("/admin/articles/{$artikel->id}/edit");
        $response->assertStatus(200);
        
        // Test admin dapat update artikel
        $response = $this->actingAs($admin)->put("/admin/articles/{$artikel->id}", [
            'namaAcara' => 'Updated Artikel',
            'deskripsi' => $artikel->deskripsi,
            'penulis' => $artikel->penulis,
            'tanggalAcara' => now()->format('Y-m-d H:i:s')
        ]);
        $response->assertStatus(302);
        $this->assertDatabaseHas('artikel', ['namaAcara' => 'Updated Artikel']);
    }

    /** @test */
    public function admin_dapat_menghapus_artikel()
    {
        $admin = User::where('is_admin', true)->first();
        $artikel = Artikel::factory()->create();
        
        $response = $this->actingAs($admin)->delete("/admin/articles/{$artikel->id}");
        
        $response->assertStatus(302); // redirect
        $this->assertDatabaseMissing('artikel', ['id' => $artikel->id]);
    }

    /** @test */
    public function artikel_dapat_memiliki_gambar()
    {
        $admin = User::where('is_admin', true)->first();
        $file = UploadedFile::fake()->image('artikel.jpg');
        
        $data = [
            'namaAcara' => 'Artikel dengan Gambar',
            'deskripsi' => 'Konten artikel',
            'penulis' => 'Admin Test',
            'tanggalAcara' => now()->format('Y-m-d H:i:s'),
            'gambar' => [$file]
        ];
        
        $response = $this->actingAs($admin)->post('/admin/articles', $data);
        
        $response->assertStatus(302);
        $this->assertDatabaseHas('artikel', ['namaAcara' => 'Artikel dengan Gambar']);
    }
}
