<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\ArticleController;
use App\Http\Controllers\User\StaffController;
use App\Http\Controllers\User\FacilitiesController;
use App\Http\Controllers\User\EquipmentLoanController;
use App\Http\Controllers\User\TestingServicesController;
use App\Http\Controllers\Admin\KunjunganController;
use App\Http\Controllers\User\KunjunganUserController;
use App\Http\Controllers\User\TrackingController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\AboutController;
use App\Http\Controllers\Admin\ArticleController as AdminArticleController;
use App\Http\Controllers\Admin\EquipmentController;
use App\Http\Controllers\Admin\LoanController;
use App\Http\Controllers\Admin\StaffController as AdminStaffController;
use App\Http\Controllers\Admin\GaleriLaboratoriumController;
use App\Http\Controllers\Admin\JadwalController;
use App\Http\Controllers\Admin\LayananPengujianController;
use App\Http\Controllers\Admin\PengajuanPengujianController;
use App\Http\Controllers\User\PengujianController;
use App\Http\Controllers\Admin\AdminManagementController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/equipment', [HomeController::class, 'equipment'])->name('equipment');
Route::get('/services', [HomeController::class, 'services'])->name('services');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');

Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index');
Route::get('/articles/{id}', [ArticleController::class, 'show'])->name('articles.show');

Route::get('/staff', [StaffController::class, 'index'])->name('staff');

Route::get('/facilities', [FacilitiesController::class, 'index'])->name('facilities');

Route::prefix('services/equipment-loan')->name('equipment.')->group(function () {
    Route::get('/', [EquipmentLoanController::class, 'index'])->name('loan');
    Route::get('/form', [EquipmentLoanController::class, 'form'])->name('loan.form');
    Route::post('/submit', [EquipmentLoanController::class, 'submit'])->name('loan.submit');
    Route::get('/letter/{id}', [EquipmentLoanController::class, 'letter'])->name('loan.letter');
    Route::get('/download/{id}', [EquipmentLoanController::class, 'download'])->name('loan.download');
    Route::get('/{id}', [EquipmentLoanController::class, 'show'])->name('detail');
    Route::post('/{id}/request', [EquipmentLoanController::class, 'requestLoan'])->name('request');
});

Route::prefix('services/testing')->name('testing.')->group(function () {
    Route::get('/', [App\Http\Controllers\User\PengujianController::class, 'index'])->name('services');
    Route::post('/submit', [App\Http\Controllers\User\PengujianController::class, 'submit'])->name('submit');
    Route::get('/success', [App\Http\Controllers\User\PengujianController::class, 'success'])->name('success');
    Route::get('/tracking', [App\Http\Controllers\User\PengujianController::class, 'tracking'])->name('tracking');
    Route::get('/{id}', [App\Http\Controllers\User\PengujianController::class, 'show'])->name('detail');
    Route::get('/hasil/{pengajuanId}/download/{hasilId}', [App\Http\Controllers\User\PengujianController::class, 'downloadHasil'])->name('downloadHasil');
});


Route::prefix('services/visits')->name('user.kunjungan.')->group(function () {
    Route::get('/', [KunjunganUserController::class, 'form'])->name('form');
    Route::post('/', [KunjunganUserController::class, 'store'])->name('store');
    Route::get('/success', [KunjunganUserController::class, 'success'])->name('success');
    Route::put('/{kunjungan}/cancel', [KunjunganUserController::class, 'cancel'])->name('cancel');
});

Route::get('/jadwal/get-available-sessions', [JadwalController::class, 'getAvailableSessions'])->name('jadwal.available-sessions')->middleware(['web', 'throttle:60,1']);

Route::get('/tracking', [TrackingController::class, 'index'])->name('tracking');
Route::post('/tracking/cancel', [TrackingController::class, 'cancel'])->name('tracking.cancel');

// Template System Routes
Route::prefix('template')->name('template.')->group(function () {
    Route::get('/', [\App\Http\Controllers\User\TemplateController::class, 'index'])->name('index');
    Route::get('/download/{type}', [\App\Http\Controllers\User\TemplateController::class, 'download'])->name('download');
    Route::get('/preview/{type}', [\App\Http\Controllers\User\TemplateController::class, 'preview'])->name('preview');
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminController::class, 'login'])->name('login');
    Route::post('/login', [AdminController::class, 'authenticate'])->name('authenticate');
    Route::post('/logout', [AdminController::class, 'logout'])->name('logout');

    Route::middleware('admin')->group(function () {
        Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');

        Route::prefix('about')->name('about.')->group(function () {
            Route::get('/', [AboutController::class, 'index'])->name('index');
            Route::get('/edit', [AboutController::class, 'edit'])->name('edit');
            Route::put('/update', [AboutController::class, 'update'])->name('update');
        });

        Route::prefix('articles')->name('articles.')->group(function () {
            Route::get('/', [AdminArticleController::class, 'index'])->name('index');
            Route::get('/create', [AdminArticleController::class, 'create'])->name('create');
            Route::post('/', [AdminArticleController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [AdminArticleController::class, 'edit'])->name('edit');
            Route::put('/{id}', [AdminArticleController::class, 'update'])->name('update');
            Route::delete('/{id}', [AdminArticleController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('equipment')->name('equipment.')->group(function () {
            Route::get('/', [EquipmentController::class, 'index'])->name('index');
            Route::get('/create', [EquipmentController::class, 'create'])->name('create');
            Route::post('/', [EquipmentController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [EquipmentController::class, 'edit'])->name('edit');
            Route::put('/{id}', [EquipmentController::class, 'update'])->name('update');
            Route::delete('/{id}', [EquipmentController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('loans')->name('loans.')->group(function () {
            Route::get('/', [LoanController::class, 'index'])->name('index');
            Route::get('/pending', [LoanController::class, 'pending'])->name('pending');
            Route::get('/approved', [LoanController::class, 'approved'])->name('approved');
            Route::get('/completed', [LoanController::class, 'completed'])->name('completed');
            Route::get('/rejected', [LoanController::class, 'rejected'])->name('rejected');
            Route::get('/{id}', [LoanController::class, 'show'])->name('show');
            Route::put('/{id}/status', [LoanController::class, 'updateStatus'])->name('updateStatus');
            Route::get('/{id}/whatsapp-preview', [LoanController::class, 'whatsappPreview'])->name('whatsapp-preview');
            Route::post('/{id}/confirm', [LoanController::class, 'confirmStatusUpdate'])->name('confirmStatusUpdate');
            Route::delete('/{id}', [LoanController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('staff')->name('staff.')->group(function () {
            Route::get('/', [AdminStaffController::class, 'index'])->name('index');
            Route::get('/create', [AdminStaffController::class, 'create'])->name('create');
            Route::post('/', [AdminStaffController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [AdminStaffController::class, 'edit'])->name('edit');
            Route::put('/{id}', [AdminStaffController::class, 'update'])->name('update');
            Route::delete('/{id}', [AdminStaffController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('layanan-pengujian')->name('layanan-pengujian.')->group(function () {
            Route::get('/', [App\Http\Controllers\Admin\LayananPengujianController::class, 'index'])->name('index');
            Route::get('/create', [App\Http\Controllers\Admin\LayananPengujianController::class, 'create'])->name('create');
            Route::post('/', [App\Http\Controllers\Admin\LayananPengujianController::class, 'store'])->name('store');
            Route::get('/{id}', [App\Http\Controllers\Admin\LayananPengujianController::class, 'show'])->name('show');
            Route::get('/{id}/edit', [App\Http\Controllers\Admin\LayananPengujianController::class, 'edit'])->name('edit');
            Route::put('/{id}', [App\Http\Controllers\Admin\LayananPengujianController::class, 'update'])->name('update');
            Route::delete('/{id}', [App\Http\Controllers\Admin\LayananPengujianController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('pengajuan-pengujian')->name('pengajuan-pengujian.')->group(function () {
            Route::get('/', [App\Http\Controllers\Admin\PengajuanPengujianController::class, 'index'])->name('index');
            Route::get('/menunggu', [App\Http\Controllers\Admin\PengajuanPengujianController::class, 'menunggu'])->name('menunggu');
            Route::get('/disetujui', [App\Http\Controllers\Admin\PengajuanPengujianController::class, 'disetujui'])->name('disetujui');
            Route::get('/diproses', [App\Http\Controllers\Admin\PengajuanPengujianController::class, 'diproses'])->name('diproses');
            Route::get('/selesai', [App\Http\Controllers\Admin\PengajuanPengujianController::class, 'selesai'])->name('selesai');
            Route::get('/ditolak', [App\Http\Controllers\Admin\PengajuanPengujianController::class, 'ditolak'])->name('ditolak');
            Route::get('/{id}', [App\Http\Controllers\Admin\PengajuanPengujianController::class, 'show'])->name('show');
            Route::patch('/{id}/status', [App\Http\Controllers\Admin\PengajuanPengujianController::class, 'updateStatus'])->name('update-status');
            Route::post('/{id}/upload-hasil', [App\Http\Controllers\Admin\PengajuanPengujianController::class, 'uploadHasil'])->name('upload-hasil');
            Route::get('/{id}/whatsapp-preview', [App\Http\Controllers\Admin\PengajuanPengujianController::class, 'whatsappPreview'])->name('whatsapp-preview');
            Route::post('/{id}/confirm-status', [App\Http\Controllers\Admin\PengajuanPengujianController::class, 'confirmStatusUpdate'])->name('confirm-status');
        });

        Route::prefix('kunjungan')->name('kunjungan.')->group(function () {
            Route::get('/', [KunjunganController::class, 'index'])->name('index');
            Route::get('/pending', [KunjunganController::class, 'pending'])->name('pending');
            Route::get('/approved', [KunjunganController::class, 'approved'])->name('approved');
            Route::get('/completed', [KunjunganController::class, 'completed'])->name('completed');
            Route::get('/rejected', [KunjunganController::class, 'rejected'])->name('rejected');
            Route::get('/{id}', [KunjunganController::class, 'show'])->name('show');
            Route::put('/{id}/status', [KunjunganController::class, 'updateStatus'])->name('updateStatus');
            Route::delete('/{id}', [KunjunganController::class, 'destroy'])->name('destroy');
            Route::get('/{id}/whatsapp-preview', [App\Http\Controllers\Admin\KunjunganController::class, 'whatsappPreview'])->name('whatsapp-preview');
            Route::post('/{id}/confirm-status', [App\Http\Controllers\Admin\KunjunganController::class, 'confirmStatusUpdate'])->name('confirmStatusUpdate');
        });

        Route::prefix('galeri')->name('galeri.')->group(function () {
            Route::get('/', [GaleriLaboratoriumController::class, 'index'])->name('index');
            Route::get('/create', [GaleriLaboratoriumController::class, 'create'])->name('create');
            Route::post('/', [GaleriLaboratoriumController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [GaleriLaboratoriumController::class, 'edit'])->name('edit');
            Route::put('/{id}', [GaleriLaboratoriumController::class, 'update'])->name('update');
            Route::delete('/{id}', [GaleriLaboratoriumController::class, 'destroy'])->name('destroy');
            
            // Routes untuk fasilitas
            Route::post('/fasilitas', [GaleriLaboratoriumController::class, 'storeFasilitas'])->name('fasilitas.store');
            Route::put('/fasilitas/{id}', [GaleriLaboratoriumController::class, 'updateFasilitas'])->name('fasilitas.update');
            Route::delete('/fasilitas/{id}', [GaleriLaboratoriumController::class, 'destroyFasilitas'])->name('fasilitas.destroy');
            Route::patch('/fasilitas/{id}/toggle', [GaleriLaboratoriumController::class, 'toggleFasilitas'])->name('fasilitas.toggle');
        });

        Route::prefix('jadwal')->name('jadwal.')->group(function () {
            Route::get('/', [JadwalController::class, 'index'])->name('index');
            Route::get('/create', [JadwalController::class, 'create'])->name('create');
            Route::post('/', [JadwalController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [JadwalController::class, 'edit'])->name('edit');
            Route::put('/{id}', [JadwalController::class, 'update'])->name('update');
            Route::delete('/{id}', [JadwalController::class, 'destroy'])->name('destroy');
            Route::get('/calendar-data', [JadwalController::class, 'calendarData'])->name('calendar-data');
            Route::get('/schedule-settings', [JadwalController::class, 'scheduleSettings'])->name('schedule-settings');
            Route::post('/toggle-availability', [JadwalController::class, 'toggleAvailability'])->name('toggle-availability');
        });

        // Admin Management Routes (Super Admin Only)
        Route::middleware('super_admin')->prefix('admin-management')->name('admin-management.')->group(function () {
            Route::get('/', [AdminManagementController::class, 'index'])->name('index');
            Route::get('/create', [AdminManagementController::class, 'create'])->name('create');
            Route::post('/', [AdminManagementController::class, 'store'])->name('store');
            Route::get('/{id}', [AdminManagementController::class, 'show'])->name('show');
            Route::get('/{id}/edit', [AdminManagementController::class, 'edit'])->name('edit');
            Route::put('/{id}', [AdminManagementController::class, 'update'])->name('update');
            Route::delete('/{id}', [AdminManagementController::class, 'destroy'])->name('destroy');
        });
    });
});