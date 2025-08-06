<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\ArticleController;
use App\Http\Controllers\User\StaffController;
use App\Http\Controllers\User\FacilitiesController;
use App\Http\Controllers\User\EquipmentLoanController;
use App\Http\Controllers\User\TestingServicesController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\AboutController;
use App\Http\Controllers\Admin\ArticleController as AdminArticleController;
use App\Http\Controllers\Admin\EquipmentController;
use App\Http\Controllers\Admin\LoanController;
use App\Http\Controllers\Admin\StaffController as AdminStaffController;
use App\Http\Controllers\Admin\GaleriLaboratoriumController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/equipment', [HomeController::class, 'equipment'])->name('equipment');
Route::get('/services', [HomeController::class, 'services'])->name('services');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');

// Articles
Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index');
Route::get('/articles/{id}', [ArticleController::class, 'show'])->name('articles.show');

// Staff
Route::get('/staff', [StaffController::class, 'index'])->name('staff');

// Facilities
Route::get('/facilities', [FacilitiesController::class, 'index'])->name('facilities');

// Services - Equipment Loan
Route::prefix('services/equipment-loan')->name('equipment.')->group(function () {
    Route::get('/', [EquipmentLoanController::class, 'index'])->name('loan');           // Pilihan alat (langsung)
    Route::get('/tracking', [EquipmentLoanController::class, 'tracking'])->name('loan.tracking'); // Tracking
    Route::get('/form', [EquipmentLoanController::class, 'form'])->name('loan.form');   // Formulir
    Route::post('/submit', [EquipmentLoanController::class, 'submit'])->name('loan.submit'); // Submit
    Route::get('/letter/{id}', [EquipmentLoanController::class, 'letter'])->name('loan.letter'); // Surat
    Route::get('/download/{id}', [EquipmentLoanController::class, 'download'])->name('loan.download'); // Download
    // Route::get('/enhanced', [EquipmentLoanController::class, 'enhanced'])->name('loan.enhanced'); // Formulir lengkap
    Route::get('/{id}', [EquipmentLoanController::class, 'show'])->name('detail');      // Detail alat
    Route::post('/{id}/request', [EquipmentLoanController::class, 'requestLoan'])->name('request'); // Request lama
});

// Services - Testing Services
Route::prefix('services/testing')->name('testing.')->group(function () {
    Route::get('/', [TestingServicesController::class, 'index'])->name('services');
    Route::get('/{id}', [TestingServicesController::class, 'show'])->name('detail');
    Route::post('/{id}/request', [TestingServicesController::class, 'requestTest'])->name('request');
});

Route::post('/equipment-loan/request', [App\Http\Controllers\User\EquipmentLoanController::class, 'requestLoan'])->name('equipment.loan.request');
Route::get('/loans/tracking/{tracking_code?}', [\App\Http\Controllers\User\EquipmentLoanController::class, 'tracking'])->name('loans.tracking');

// Test route untuk debugging
Route::get('/test-db', function() {
    try {
        $alatCount = \App\Models\Alat::count();
        $jenisPengujianCount = \App\Models\JenisPengujian::count();
        $peminjamanCount = \App\Models\Peminjaman::count();
        return response()->json([
            'status' => 'success', 
            'alat_count' => $alatCount,
            'jenis_pengujian_count' => $jenisPengujianCount,
            'peminjaman_count' => $peminjamanCount
        ]);
    } catch (\Exception $e) {
        return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
    }
});

// Test route untuk membuat peminjaman
Route::get('/test-peminjaman', function() {
    try {
        $peminjaman = \App\Models\Peminjaman::create([
            'user_type' => 'mahasiswa',
            'namaPeminjam' => 'Test User',
            'noHp' => '08123456789',
            'tanggal_pinjam' => now(),
            'tanggal_pengembalian' => now()->addDays(1)
        ]);
        return response()->json(['status' => 'success', 'peminjaman_id' => $peminjaman->id]);
    } catch (\Exception $e) {
        return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
    }
});

// Layanan Pengujian (User)
Route::get('/services/testing', [App\Http\Controllers\User\TestingServicesController::class, 'index'])->name('pengujian.index');
Route::post('/services/testing', [App\Http\Controllers\User\TestingServicesController::class, 'store'])->name('pengujian.store');

// Layanan Kunjungan (User)
Route::get('/services/visit', [App\Http\Controllers\User\KunjunganController::class, 'index'])->name('kunjungan.index');
Route::post('/services/visit', [App\Http\Controllers\User\KunjunganController::class, 'store'])->name('kunjungan.store');
Route::get('/services/visit', [App\Http\Controllers\User\KunjunganController::class, 'form'])->name('kunjungan.form');

// Admin Routes
Route::prefix('admin')->name('admin.')->group(function () {
    // Login routes (no middleware)
    Route::get('/login', [AdminController::class, 'login'])->name('login');
    Route::post('/login', [AdminController::class, 'authenticate'])->name('authenticate');
    Route::post('/logout', [AdminController::class, 'logout'])->name('logout');

    // Protected admin routes
    Route::middleware('admin')->group(function () {
        // Dashboard
        Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');

        // About/Laboratory Profile Management
        Route::prefix('about')->name('about.')->group(function () {
            Route::get('/', [AboutController::class, 'index'])->name('index');
            Route::get('/edit', [AboutController::class, 'edit'])->name('edit');
            Route::put('/update', [AboutController::class, 'update'])->name('update');
        });

        // Article Management
        Route::prefix('articles')->name('articles.')->group(function () {
            Route::get('/', [AdminArticleController::class, 'index'])->name('index');
            Route::get('/create', [AdminArticleController::class, 'create'])->name('create');
            Route::post('/', [AdminArticleController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [AdminArticleController::class, 'edit'])->name('edit');
            Route::put('/{id}', [AdminArticleController::class, 'update'])->name('update');
            Route::delete('/{id}', [AdminArticleController::class, 'destroy'])->name('destroy');
        });

        // Equipment Management
        Route::prefix('equipment')->name('equipment.')->group(function () {
            Route::get('/', [EquipmentController::class, 'index'])->name('index');
            Route::get('/create', [EquipmentController::class, 'create'])->name('create');
            Route::post('/', [EquipmentController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [EquipmentController::class, 'edit'])->name('edit');
            Route::put('/{id}', [EquipmentController::class, 'update'])->name('update');
            Route::delete('/{id}', [EquipmentController::class, 'destroy'])->name('destroy');
        });

        // Loan Management
        Route::prefix('loans')->name('loans.')->group(function () {
            Route::get('/', [LoanController::class, 'index'])->name('index');
            Route::get('/pending', [LoanController::class, 'pending'])->name('pending');
            Route::get('/approved', [LoanController::class, 'approved'])->name('approved');
            Route::get('/completed', [LoanController::class, 'completed'])->name('completed');
            Route::get('/rejected', [LoanController::class, 'rejected'])->name('rejected');
            Route::get('/{id}', [LoanController::class, 'show'])->name('show');
            Route::get('/{id}/whatsapp-preview', [LoanController::class, 'whatsappPreview'])->name('whatsapp-preview');
            Route::put('/{id}/status', [LoanController::class, 'updateStatus'])->name('updateStatus');
            Route::post('/{id}/confirm-status', [LoanController::class, 'confirmStatusUpdate'])->name('confirmStatusUpdate');
            Route::delete('/{id}', [LoanController::class, 'destroy'])->name('destroy');
        });

        // Staff Management
        Route::prefix('staff')->name('staff.')->group(function () {
            Route::get('/', [AdminStaffController::class, 'index'])->name('index');
            Route::get('/create', [AdminStaffController::class, 'create'])->name('create');
            Route::post('/', [AdminStaffController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [AdminStaffController::class, 'edit'])->name('edit');
            Route::put('/{id}', [AdminStaffController::class, 'update'])->name('update');
            Route::delete('/{id}', [AdminStaffController::class, 'destroy'])->name('destroy');
        });

        // Jenis Pengujian Management
        Route::prefix('jenis-pengujian')->name('jenis-pengujian.')->group(function () {
            Route::get('/', [App\Http\Controllers\Admin\JenisPengujianController::class, 'index'])->name('index');
            Route::get('/create', [App\Http\Controllers\Admin\JenisPengujianController::class, 'create'])->name('create');
            Route::post('/', [App\Http\Controllers\Admin\JenisPengujianController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [App\Http\Controllers\Admin\JenisPengujianController::class, 'edit'])->name('edit');
            Route::put('/{id}', [App\Http\Controllers\Admin\JenisPengujianController::class, 'update'])->name('update');
            Route::delete('/{id}', [App\Http\Controllers\Admin\JenisPengujianController::class, 'destroy'])->name('destroy');
        });

        // Pengujian Management
        Route::prefix('pengujian')->name('pengujian.')->group(function () {
            Route::get('/', [App\Http\Controllers\Admin\PengujianController::class, 'index'])->name('index');
            Route::get('/create', [App\Http\Controllers\Admin\PengujianController::class, 'create'])->name('create');
            Route::post('/', [App\Http\Controllers\Admin\PengujianController::class, 'store'])->name('store');
            Route::get('/{id}', [App\Http\Controllers\Admin\PengujianController::class, 'show'])->name('show');
            Route::get('/{id}/edit', [App\Http\Controllers\Admin\PengujianController::class, 'edit'])->name('edit');
            Route::put('/{id}', [App\Http\Controllers\Admin\PengujianController::class, 'update'])->name('update');
            Route::delete('/{id}', [App\Http\Controllers\Admin\PengujianController::class, 'destroy'])->name('destroy');
            Route::post('/{id}/approve', [\App\Http\Controllers\Admin\PengujianController::class, 'approve'])->name('approve');
            Route::post('/{id}/reject', [\App\Http\Controllers\Admin\PengujianController::class, 'reject'])->name('reject');
        });

        // Kunjungan Management
        Route::prefix('kunjungan')->name('kunjungan.')->group(function () {
            Route::get('/', [App\Http\Controllers\Admin\KunjunganController::class, 'index'])->name('index');
            Route::get('/{id}', [App\Http\Controllers\Admin\KunjunganController::class, 'show'])->name('show');
            Route::put('/{id}/status', [App\Http\Controllers\Admin\KunjunganController::class, 'updateStatus'])->name('updateStatus');
            Route::delete('/{id}', [App\Http\Controllers\Admin\KunjunganController::class, 'destroy'])->name('destroy');
        });

        // Galeri Laboratorium Management
        Route::prefix('galeri')->name('galeri.')->group(function () {
            Route::get('/', [GaleriLaboratoriumController::class, 'index'])->name('index');
            Route::get('/create', [GaleriLaboratoriumController::class, 'create'])->name('create');
            Route::post('/', [GaleriLaboratoriumController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [GaleriLaboratoriumController::class, 'edit'])->name('edit');
            Route::put('/{id}', [GaleriLaboratoriumController::class, 'update'])->name('update');
            Route::delete('/{id}', [GaleriLaboratoriumController::class, 'destroy'])->name('destroy');
        });
    });
});

