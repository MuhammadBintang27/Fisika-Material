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
use App\Http\Controllers\Admin\JenisPengujianController;
use App\Http\Controllers\Admin\PengujianController;
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
    Route::get('/', [TestingServicesController::class, 'index'])->name('services');
    Route::get('/{id}', [TestingServicesController::class, 'show'])->name('detail');
    Route::post('/{id}/request', [TestingServicesController::class, 'requestTest'])->name('request');
});

Route::post('/equipment-loan/request', [EquipmentLoanController::class, 'requestLoan'])->name('equipment.loan.request');

Route::get('/services/testing', [TestingServicesController::class, 'index'])->name('pengujian.index');
Route::post('/services/testing', [TestingServicesController::class, 'store'])->name('pengujian.store');


Route::prefix('services/visits')->name('user.kunjungan.')->group(function () {
    Route::get('/', [KunjunganUserController::class, 'form'])->name('form');
    Route::post('/', [KunjunganUserController::class, 'store'])->name('store');
    Route::get('/success', [KunjunganUserController::class, 'success'])->name('success');
    Route::put('/{kunjungan}/cancel', [KunjunganUserController::class, 'cancel'])->name('cancel');
});

Route::get('/jadwal/get-available-sessions', [JadwalController::class, 'getAvailableSessions'])->name('jadwal.available-sessions')->middleware(['web', 'throttle:60,1']);

Route::get('/tracking', [TrackingController::class, 'index'])->name('tracking');
Route::post('/tracking/cancel', [TrackingController::class, 'cancel'])->name('tracking.cancel');

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

        Route::prefix('jenis-pengujian')->name('jenis-pengujian.')->group(function () {
            Route::get('/', [JenisPengujianController::class, 'index'])->name('index');
            Route::get('/create', [JenisPengujianController::class, 'create'])->name('create');
            Route::post('/', [JenisPengujianController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [JenisPengujianController::class, 'edit'])->name('edit');
            Route::put('/{id}', [JenisPengujianController::class, 'update'])->name('update');
            Route::delete('/{id}', [JenisPengujianController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('pengujian')->name('pengujian.')->group(function () {
            Route::get('/', [PengujianController::class, 'index'])->name('index');
            Route::get('/create', [PengujianController::class, 'create'])->name('create');
            Route::post('/', [PengujianController::class, 'store'])->name('store');
            Route::get('/{id}', [PengujianController::class, 'show'])->name('show');
            Route::get('/{id}/edit', [PengujianController::class, 'edit'])->name('edit');
            Route::put('/{id}', [PengujianController::class, 'update'])->name('update');
            Route::delete('/{id}', [PengujianController::class, 'destroy'])->name('destroy');
            Route::post('/{id}/approve', [PengujianController::class, 'approve'])->name('approve');
            Route::post('/{id}/reject', [PengujianController::class, 'reject'])->name('reject');
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
    Route::get('/{id}/whatsapp-preview', [App\Http\Controllers\Admin\KunjunganController::class, 'whatsappPreview'])->name('whatsapp-preview'); // Changed to kunjungan.whatsapp-preview
    Route::post('/{id}/confirm-status', [App\Http\Controllers\Admin\KunjunganController::class, 'confirmStatusUpdate'])->name('confirmStatusUpdate'); // Changed to kunjungan.confirmStatusUpdate
});

        Route::prefix('galeri')->name('galeri.')->group(function () {
            Route::get('/', [GaleriLaboratoriumController::class, 'index'])->name('index');
            Route::get('/create', [GaleriLaboratoriumController::class, 'create'])->name('create');
            Route::post('/', [GaleriLaboratoriumController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [GaleriLaboratoriumController::class, 'edit'])->name('edit');
            Route::put('/{id}', [GaleriLaboratoriumController::class, 'update'])->name('update');
            Route::delete('/{id}', [GaleriLaboratoriumController::class, 'destroy'])->name('destroy');
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