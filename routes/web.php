<?php

use App\Http\Controllers\Admin\TargetController;
use App\Http\Controllers\Admin\UserRegistrationManagementController;
use App\Http\Controllers\Dashboard\AdminDashboardController;
use App\Http\Controllers\Dashboard\DosenDashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Reviews\Reviewer\ReviewerController;
use App\Http\Controllers\Admin\AssignRoleController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'login'])->name('/');
Route::get('/login', [HomeController::class, 'login']);

Route::middleware(['auth', 'role:admin', 'check.status'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])
            ->name('dashboard');
        Route::get('/pusatnotifikasi', [App\Http\Controllers\Admin\Notification\NotificationController::class, 'index'])->name('pusat-notifikasi');
        Route::get('/target', [TargetController::class, 'index'])->name('target');
        Route::get('/user-registration-management', [UserRegistrationManagementController::class, 'index'])
            ->name('user-registration.index');
        Route::post('/users-registration/approve-user/{id}', [UserRegistrationManagementController::class, 'approveUser'])
            ->name('user-registration.approve-user');
        Route::post('/users-registration/reject-user/{id}', [UserRegistrationManagementController::class, 'rejectUser'])
            ->name('user-registration.reject-user');
        Route::get('/assign-role', [AssignRoleController::class, 'index'])->name('assign-role.index');
        Route::put('/assign-role/{user}', [AssignRoleController::class, 'update'])->name('assign-role.update');

    });

Route::middleware(['auth', 'role:dosen', 'check.status'])
    ->prefix('dosen')
    ->name('dosen.')
    ->group(function () {
        Route::get('/usulan-proposal-penelitian', [App\Http\Controllers\Penelitian\Proposal\CreateController::class, 'index'])
            ->name('ProposalPenelitian');
        Route::post('/usulan-proposal-penelitian', [App\Http\Controllers\Penelitian\Proposal\CreateController::class, 'store'])
            ->name('ProposalPenelitian.store');

        Route::get('/upload-Laporan', [App\Http\Controllers\Penelitian\Laporan\CreateController::class, 'index'])
            ->name('uploadLaporan');
        Route::post('/upload-Laporan', [App\Http\Controllers\Penelitian\Laporan\CreateController::class, 'index'])
            ->name('uploadLaporan.store');
        Route::get('/status-penelitian', [App\Http\Controllers\Penelitian\IndexController::class, 'index'])
            ->name('statusPenelitian');
        Route::get('/usulanProposal-pengabdian', [App\Http\Controllers\Pengabdian\Proposal\CreateController::class, 'index'])
            ->name('usulanProposal-pengabdian');
        Route::get('/uploadlaporan-pengabdian', [App\Http\Controllers\Pengabdian\Laporan\CreateController::class, 'index'])
            ->name('uploadLaporan-pengabdian');
        Route::get('/pengabdian', [App\Http\Controllers\Pengabdian\IndexController::class, 'index'])
            ->name('pengabdian');
    });

Route::middleware('auth', 'role:ketua_prpm')
    ->prefix('ketua-prpm')
    ->name('ketua-prpm.')
    ->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\Dashboard\KetuaPRPMDashboardController::class, 'index'])->name('dashboard');
        Route::get('/review', [App\Http\Controllers\Reviews\PRPM\ReviewController::class, 'index'])->name('prpm.review.index');
        Route::post('/review/{proposal}/update-status', [App\Http\Controllers\Reviews\PRPM\ReviewController::class, 'updateStatus'])
            ->name('prpm.review.updateStatus');
    });

    
Route::middleware(['auth', 'role:reviewer|dosen'])
    ->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\Dashboard\DashboardController::class, 'index'])
            ->name('dashboard');
    });
Route::middleware('auth', 'role:reviewer')
    ->prefix('reviewer')
    ->name('reviewer.')
    ->group(function () {
        Route::get('/reviewer/review', [ReviewerController::class, 'index'])->name('index');
        Route::get('/reviewer/review/{review}', [ReviewerController::class, 'form'])->name('review-form');
        Route::post('/reviewer/review/submit/{review}', [ReviewerController::class, 'submit'])->name('review-submit');
    });

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/profile/photo', [ProfileController::class, 'updatePhoto'])->name('profile.photo.update');

});

require __DIR__.'/auth.php';
