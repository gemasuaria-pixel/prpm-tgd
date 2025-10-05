<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewProposalController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'login'])->name('/');
Route::get('/login', [HomeController::class, 'login']);

Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('pending-users', [AdminController::class, 'pendingUsers'])->name('admin.pending-users');
    Route::post('approve-user/{id}', [AdminController::class, 'approveUser'])->name('admin.approve-user');
    Route::post('reject-user/{id}', [AdminController::class, 'rejectUser'])->name('admin.reject-user');
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

Route::middleware(['auth', 'role:dosen', 'check.status'])
    ->prefix('dosen')
    ->name('dosen.')
    ->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\Dosen\DashboardController::class, 'index'])
            ->name('dashboard');
        Route::get('/usulan-proposal-penelitian', [App\Http\Controllers\Penelitian\Proposal\CreateController::class, 'index'])
            ->name('ProposalPenelitian');
        Route::post('/usulan-proposal-penelitian', [App\Http\Controllers\Penelitian\Proposal\CreateController::class, 'store'])
            ->name('ProposalPenelitian.store');

        Route::get('/upload-Laporan', [App\Http\Controllers\Penelitian\Laporan\CreateController::class, 'index'])
            ->name('uploadLaporan');
        Route::get('/status-penelitian', [App\Http\Controllers\Penelitian\IndexController::class, 'index'])
            ->name('statusPenelitian');
        Route::get('/usulanProposal-pengabdian', [App\Http\Controllers\Pengabdian\Proposal\CreateController::class, 'index'])
            ->name('usulanProposal-pengabdian');
        Route::get('/uploadlaporan-pengabdian', [App\Http\Controllers\Pengabdian\Laporan\CreateController::class, 'index'])
            ->name('uploadLaporan-pengabdian');
        Route::get('/pengabdian', [App\Http\Controllers\Pengabdian\IndexController::class, 'index'])
            ->name('pengabdian');
    });
    
    Route::get('/review', [ReviewProposalController::class, 'index'])->name('review.index');
    Route::post('review/{proposal}', [ReviewProposalController::class, 'updateStatus'])->name('review.update');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/profile/photo', [ProfileController::class, 'updatePhoto'])->name('profile.photo.update');

});

require __DIR__.'/auth.php';
