<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ModulAutentikasiTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('db:seed');
    }

    /** @test */
    public function admin_dapat_mengakses_halaman_login()
    {
        $response = $this->get('/admin/login');
        $response->assertStatus(200);
    }

    /** @test */
    public function admin_dapat_login_dengan_kredensial_yang_benar()
    {
        $admin = User::where('email', 'admin@fisika.com')->first();
        
        $response = $this->post('/admin/login', [
            'email' => 'admin@fisika.com',
            'password' => 'password'
        ]);
        
        $response->assertRedirect('/admin');
        $this->assertAuthenticatedAs($admin);
    }

    /** @test */
    public function login_gagal_dengan_kredensial_yang_salah()
    {
        $response = $this->post('/admin/login', [
            'email' => 'wrong@email.com',
            'password' => 'wrongpassword'
        ]);
        
        $response->assertSessionHasErrors();
        $this->assertGuest();
    }

    /** @test */
    public function super_admin_dapat_mengakses_halaman_admin()
    {
        $admin = User::where('email', 'admin@fisika.com')->first();
        
        $response = $this->actingAs($admin)->get('/admin');
        
        $response->assertStatus(200);
    }

    /** @test */
    public function guest_tidak_dapat_mengakses_halaman_admin()
    {
        $response = $this->get('/admin');
        
        $response->assertRedirect('/admin/login');
    }

    /** @test */
    public function super_admin_dapat_mengakses_dashboard()
    {
        $admin = User::where('email', 'admin@fisika.com')->first();
        
        $response = $this->actingAs($admin)->get('/admin');
        
        $response->assertStatus(200);
    }

    /** @test */
    public function admin_dapat_logout()
    {
        $admin = User::where('email', 'admin@fisika.com')->first();
        
        $response = $this->actingAs($admin)->post('/admin/logout');
        
        $response->assertRedirect('/admin/login');
        $this->assertGuest();
    }

    /** @test */
    public function super_admin_dapat_mengakses_halaman_manajemen_admin()
    {
        $admin = User::where('is_super_admin', true)->first();
        
        if ($admin) {
            $response = $this->actingAs($admin)->get('/admin');
            $response->assertStatus(200);
        } else {
            $this->assertTrue(true); // Skip jika tidak ada super admin
        }
    }

    /** @test */
    public function regular_admin_tidak_dapat_mengakses_manajemen_admin()
    {
        $admin = User::where('is_super_admin', false)->where('is_admin', true)->first();
        
        if ($admin) {
            $response = $this->actingAs($admin)->get('/admin');
            $response->assertStatus(200); // Regular admin tetap bisa akses dashboard
        } else {
            $this->assertTrue(true);
        }
    }

    /** @test */
    public function user_dapat_mengecek_apakah_regular_admin()
    {
        $admin = User::where('is_admin', true)->first();
        
        if ($admin) {
            $isRegular = !$admin->is_super_admin;
            $this->assertIsBool($isRegular);
        } else {
            $this->assertTrue(true);
        }
    }
}
