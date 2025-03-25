<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WorkOrderController;
use App\Http\Controllers\WorkOrderStatusController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\WorkOrderExportController;
use App\Http\Controllers\WorkOrderDashboardController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;

// Halaman utama
Route::get('/', function () {
    return view('home');
});

// Grup route untuk Work Order
Route::prefix('workorder')->middleware('auth')->group(function () {
    Route::get('/create', [WorkOrderController::class, 'create'])->name('workorder.create')->middleware('role:user,executor,admin');
    Route::post('/store', [WorkOrderController::class, 'store'])->name('workorder.store')->middleware('role:user,executor,admin');
    Route::get('/update', [WorkOrderController::class, 'edit'])->name('workorder.edit')->middleware('role:executor,admin');
    Route::patch('/update', [WorkOrderController::class, 'update'])->name('workorder.update')->middleware('role:executor,admin');
    Route::post('/find', [WorkOrderController::class, 'find'])->name('workorder.find')->middleware('role:executor,admin');
    Route::post('/delete', [WorkOrderController::class, 'delete'])->name('workorder.delete')->middleware('role:admin');

    // Route untuk status Work Order
    Route::get('/status', [WorkOrderStatusController::class, 'index'])->name('workorder.status')->middleware('role:user,executor,admin');
    Route::get('/status/download/{nomor_wo}', [WorkOrderStatusController::class, 'download'])->name('workorder.download')->middleware('role:admin');
});

// Grup route untuk setting Work Order
Route::prefix('setting')->middleware('auth')->group(function () {
    Route::get('/profil', [SettingController::class, 'profil'])->name('setting.profil')->middleware('role:user,executor,admin');
    Route::post('/profil/update', [SettingController::class, 'updateProfil'])->name('setting.profil.update')->middleware('role:user,executor,admin');

    // CRUD akun (hanya admin)
    Route::get('/akun', [SettingController::class, 'akun'])->name('setting_akun')->middleware('role:admin');
    Route::get('/akun/create', [SettingController::class, 'create'])->name('setting_akun.create')->middleware('role:admin');
    Route::post('/akun', [SettingController::class, 'store'])->name('setting_akun.store')->middleware('role:admin');
    Route::get('/akun/{id}/edit', [SettingController::class, 'edit'])->name('setting_akun.edit')->middleware('role:admin');
    Route::put('/akun/{id}', [SettingController::class, 'update'])->name('setting_akun.update')->middleware('role:admin');
    Route::delete('/akun/{id}', [SettingController::class, 'destroy'])->name('setting_akun.destroy')->middleware('role:admin');
    Route::post('/akun/{id}/reset-password', [SettingController::class, 'resetPassword'])->name('setting_akun.reset_password')->middleware('role:admin');
});

// Export Work Orders (hanya admin)
Route::get('/export-work-orders', [WorkOrderExportController::class, 'export'])->name('export.work_orders')->middleware('role:admin');

// Dashboard Work Order
Route::prefix('dashboard')->group(function () {
    Route::get('/data', [WorkOrderDashboardController::class, 'getDashboardData']);
    Route::get('/chart', [WorkOrderDashboardController::class, 'getMonthlyWorkOrderData']);
    Route::get('/pie-chart', [WorkOrderDashboardController::class, 'getPieChartData']);
});

// Autentikasi Laravel
Auth::routes();

// Halaman setelah login
Route::get('/home', [HomeController::class, 'index'])->name('home');

// Grup middleware untuk halaman yang hanya bisa diakses setelah login
Route::middleware('auth')->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home')->middleware('role:user,executor,admin');
    Route::get('/workorder/create', [WorkOrderController::class, 'create'])->name('workorder.create')->middleware('role:user,executor,admin');
    Route::get('/workorder/update', [WorkOrderController::class, 'edit'])->name('workorder.edit')->middleware('role:executor,admin');
    Route::get('/workorder/status', [WorkOrderStatusController::class, 'index'])->name('workorder.status')->middleware('role:user,executor,admin');
    Route::get('/workorder/setting/akun', [SettingController::class, 'akun'])->name('setting.akun')->middleware('role:admin');
    Route::get('/workorder/setting/form', [SettingController::class, 'form'])->name('setting.form')->middleware('role:admin');
});