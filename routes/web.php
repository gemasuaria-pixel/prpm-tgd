<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AdminController;
use App\Helpers\Breadcrumbs;



Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function() {
    Route::get('pending-users', [AdminController::class, 'pendingUsers'])->name('admin.pending-users');
    Route::post('approve-user/{id}', [AdminController::class, 'approveUser'])->name('admin.approve-user');
    
});


Route::middleware(['auth', 'role:admin', 'check.status'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])
            ->name('dashboard');
        Route::get('/pusatnotifikasi', [HomeController::class, 'notification'])->name('pusatnotifikasi');
        Route::get('/target', [HomeController::class, 'target'])->name('target');
    });

Route::middleware(['auth', 'role:user', 'check.status'])
    ->prefix('user')
    ->name('user.')
    ->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\User\DashboardController::class, 'index'])
            ->name('dashboard');
        Route::get('/usulan-proposal-penelitian', [App\Http\Controllers\ResearchController\UploadPenelitianController::class, 'index'])
            ->name('usulanProposal');
            
        Route::post('/usulan-proposal-penelitian', [App\Http\Controllers\ResearchController\UploadPenelitianController::class, 'store'])
            ->name('usulanProposal.store');
        Route::get('/upload-Laporan', [App\Http\Controllers\ResearchController\UploadLaporanController::class, 'index'])
            ->name('uploadLaporan');
        Route::get('/status-penelitian', [App\Http\Controllers\ResearchController\StatusPenelitianController::class, 'index'])
            ->name('statusPenelitian');
        Route::get('/usulanProposal-pengabdian', [App\Http\Controllers\PengabdianController\UploadProposalController::class, 'index'])
            ->name('usulanProposal-pengabdian');
        Route::get('/uploadlaporan-pengabdian', [App\Http\Controllers\PengabdianController\UploadLaporanController::class, 'index'])
            ->name('uploadLaporan-pengabdian');
        Route::get('/pengabdian', [App\Http\Controllers\PengabdianController\PengabdianController::class, 'index'])
            ->name('pengabdian');
    });

Route::get('/', [HomeController::class, 'login'])->name('/');
Route::get('/login', [HomeController::class, 'login']);


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/profile/photo', [ProfileController::class, 'updatePhoto'])->name('profile.photo.update');
    
});

require __DIR__.'/auth.php';
