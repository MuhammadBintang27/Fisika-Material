<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Alat;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ModulAlatLaboratoriumTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('db:seed');
    }

    /** @test */
    public function user_dapat_melihat_daftar_alat()
    {
        Alat::factory()->count(3)->create();
        
        $response = $this->get('/services/equipment-loan/');
        
        $response->assertStatus(200);
    }

    /** @test */
    public function user_dapat_melihat_detail_alat()
    {
        $alat = Alat::factory()->create([
            'nama' => 'Test Alat Detail'
        ]);
        
        $response = $this->get("/services/equipment-loan/{$alat->id}");
        
        $response->assertStatus(200);
    }

    /** @test */
    public function admin_dapat_melihat_daftar_alat_di_admin_panel()
    {
        $admin = User::where('is_admin', true)->first();
        
        $response = $this->actingAs($admin)->get('/admin/equipment');
        
        $response->assertStatus(200);
    }

    /** @test */
    public function admin_dapat_mengakses_form_tambah_alat()
    {
        $admin = User::where('is_admin', true)->first();
        
        $response = $this->actingAs($admin)->get('/admin/equipment/create');
        
        $response->assertStatus(200);
    }

    /** @test */
    public function admin_dapat_menambah_alat()
    {
        $admin = User::where('is_admin', true)->first();
        
        $data = [
            'nama' => 'Alat Test Baru',
            'deskripsi' => 'Test deskripsi alat',
            'isBroken' => '0',
            'stok' => '5',
            'stok_dipinjam' => '0',
            'stok_rusak' => '0',
            'harga' => '5000000'
        ];
        
        $response = $this->actingAs($admin)->post('/admin/equipment', $data);
        
        $response->assertStatus(302); // redirect
        $this->assertDatabaseHas('alat', ['nama' => 'Alat Test Baru']);
    }

    /** @test */
    public function admin_dapat_mengakses_form_edit_alat()
    {
        $admin = User::where('is_admin', true)->first();
        $alat = Alat::factory()->create();
        
        $response = $this->actingAs($admin)->get("/admin/equipment/{$alat->id}/edit");
        
        $response->assertStatus(200);
    }

    /** @test */
    public function admin_dapat_mengupdate_alat()
    {
        $admin = User::where('is_admin', true)->first();
        $alat = Alat::factory()->create();
        
        $response = $this->actingAs($admin)->put("/admin/equipment/{$alat->id}", [
            'nama' => 'Updated Alat',
            'deskripsi' => $alat->deskripsi,
            'isBroken' => '0',
            'stok' => (string)$alat->stok,
            'stok_dipinjam' => (string)$alat->stok_dipinjam,
            'stok_rusak' => (string)$alat->stok_rusak,
            'harga' => (string)$alat->harga
        ]);
        
        $response->assertStatus(302); // redirect
        $this->assertDatabaseHas('alat', ['nama' => 'Updated Alat']);
    }

    /** @test */
    public function admin_dapat_menghapus_alat()
    {
        $admin = User::where('is_admin', true)->first();
        $alat = Alat::factory()->create();
        
        $response = $this->actingAs($admin)->delete("/admin/equipment/{$alat->id}");
        
        $response->assertStatus(302); // redirect
        $this->assertDatabaseMissing('alat', ['id' => $alat->id]);
    }

    /** @test */
    public function validasi_form_alat_nama_wajib_diisi()
    {
        $admin = User::where('is_admin', true)->first();
        
        $response = $this->actingAs($admin)->post('/admin/equipment', [
            'deskripsi' => 'Test',
            'stok' => '1'
        ]);
        
        $response->assertSessionHasErrors('nama');
    }

    /** @test */
    public function alat_memiliki_stok_tersedia()
    {
        $alat = Alat::factory()->create([
            'stok' => 10,
            'stok_dipinjam' => 3,
            'stok_rusak' => 1
        ]);
        
        $stokTersedia = $alat->stok - $alat->stok_dipinjam - $alat->stok_rusak;
        
        $this->assertEquals(6, $stokTersedia);
    }
}
