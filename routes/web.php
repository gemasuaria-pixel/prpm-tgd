<?php

use App\Http\Controllers\Admin\AssignRoleController;
use App\Http\Controllers\Admin\UserRegistrationManagementController;
use App\Http\Controllers\Dashboard\AdminDashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
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

        /**
         * DASHBOARD
         */
        Route::get('/dashboard', [App\Http\Controllers\Dashboard\DashboardController::class, 'index'])
            ->name('dashboard');

        /**
         * PENELITIAN
         */
        Route::prefix('penelitian')->name('penelitian.')->group(function () {

            Route::get('/proposal', [App\Http\Controllers\Penelitian\IndexController::class, 'index'])
                ->name('index');
            // Usulan Proposal Penelitian
            Route::get('/proposal/create', [App\Http\Controllers\Penelitian\Proposal\CreateController::class, 'index'])
                ->name('proposal.create');
            Route::post('/proposal', [App\Http\Controllers\Penelitian\Proposal\CreateController::class, 'store'])
                ->name('proposal.store');

            // Upload Laporan Penelitian
            Route::get('/laporan/{proposal}', [App\Http\Controllers\Penelitian\Laporan\CreateController::class, 'index'])
                ->name('laporan.create');
            Route::post('/laporan/{proposal}', [App\Http\Controllers\Penelitian\Laporan\CreateController::class, 'store'])
                ->name('laporan.store');

            // Status Penelitian
            Route::get('/status', [App\Http\Controllers\Penelitian\IndexController::class, 'index'])
                ->name('status');
        });

        /**
         * PENGABDIAN
         */
        Route::prefix('pengabdian')->name('pengabdian.')->group(function () {
            Route::get('/proposal', [App\Http\Controllers\Pengabdian\IndexController::class, 'index'])
                ->name('index');
            // Usulan Proposal Pengabdian
            Route::get('/proposal/create', [App\Http\Controllers\Pengabdian\Proposal\CreateController::class, 'index'])
                ->name('proposal.create');
            Route::post('/proposal', [App\Http\Controllers\Pengabdian\Proposal\CreateController::class, 'store'])
                ->name('proposal.store');

            // Upload Laporan Pengabdian
            Route::get('/laporan/create', [App\Http\Controllers\Pengabdian\Laporan\CreateController::class, 'index'])
                ->name('laporan.create');

            // Status Pengabdian (Index)
            Route::get('/', [App\Http\Controllers\Pengabdian\IndexController::class, 'index'])
                ->name('index');
        });

    });

    Route::middleware(['auth', 'role:ketua_prpm'])
    ->prefix('ketua-prpm')
    ->name('ketua-prpm.')
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [App\Http\Controllers\Dashboard\KetuaPRPMDashboardController::class, 'index'])
            ->name('dashboard');

        /**
         * REVIEW PENELITIAN
         */
        Route::prefix('review/penelitian')->name('review.penelitian.')->group(function () {

            // Proposal
            Route::prefix('proposal')->name('proposal.')->group(function () {
                Route::get('/', [App\Http\Controllers\Reviews\PRPM\Penelitian\ProposalReviewController::class, 'index'])->name('index');
                Route::get('/{proposal}', [App\Http\Controllers\Reviews\PRPM\Penelitian\ProposalReviewController::class, 'form'])->name('form');
                Route::post('/{proposal}/update-status', [App\Http\Controllers\Reviews\PRPM\Penelitian\ProposalReviewController::class, 'updateStatus'])->name('update-status');
            });

            // Laporan
            Route::prefix('laporan')->name('laporan.')->group(function () {
                Route::get('/', [App\Http\Controllers\Reviews\PRPM\Penelitian\LaporanReviewController::class, 'index'])->name('index');
                Route::get('/{laporan}', [App\Http\Controllers\Reviews\PRPM\Penelitian\LaporanReviewController::class, 'form'])->name('form');
                Route::post('/{laporan}/update-status', [App\Http\Controllers\Reviews\PRPM\Penelitian\LaporanReviewController::class, 'updateStatus'])->name('update-status');
            });
        });

        /**
         * REVIEW PENGABDIAN
         */
        Route::prefix('review/pengabdian')->name('review.pengabdian.')->group(function () {

            // Proposal
            Route::prefix('proposal')->name('proposal.')->group(function () {
                Route::get('/', [App\Http\Controllers\Reviews\PRPM\Pengabdian\ProposalReviewController::class, 'index'])->name('index');
                Route::get('/{proposal}', [App\Http\Controllers\Reviews\PRPM\Pengabdian\ProposalReviewController::class, 'form'])->name('form');
                Route::post('/{proposal}/update-status', [App\Http\Controllers\Reviews\PRPM\Pengabdian\ProposalReviewController::class, 'updateStatus'])->name('update-status');
            });

            // Laporan
            Route::prefix('laporan')->name('laporan.')->group(function () {
                Route::get('/', [App\Http\Controllers\Reviews\PRPM\Pengabdian\LaporanReviewController::class, 'index'])->name('index');
                Route::get('/{laporan}', [App\Http\Controllers\Reviews\PRPM\Pengabdian\LaporanReviewController::class, 'form'])->name('form');
                Route::post('/{laporan}/update-status', [App\Http\Controllers\Reviews\PRPM\Pengabdian\LaporanReviewController::class, 'updateStatus'])->name('update-status');
            });
        });
    });

Route::middleware(['auth', 'role:reviewer'])
    ->prefix('reviewer')
    ->name('reviewer.')
    ->group(function () {

        /**
         * REVIEW PENELITIAN
         */
        Route::prefix('review/penelitian')->name('review.penelitian.')->group(function () {

            // Proposal
            Route::prefix('proposal')->name('proposal.')->group(function () {
                Route::get('/', [App\Http\Controllers\Reviews\Reviewer\Penelitian\ProposalReviewController::class, 'index'])
                    ->name('index');
                Route::get('/{review}', [App\Http\Controllers\Reviews\Reviewer\Penelitian\ProposalReviewController::class, 'form'])
                    ->name('form');
                Route::post('/{review}/submit', [App\Http\Controllers\Reviews\Reviewer\Penelitian\ProposalReviewController::class, 'submit'])
                    ->name('submit');
            });

            // Laporan
            Route::prefix('laporan')->name('laporan.')->group(function () {
                Route::get('/', [App\Http\Controllers\Reviews\Reviewer\Penelitian\LaporanReviewController::class, 'index'])
                    ->name('index');
                Route::get('/{review}', [App\Http\Controllers\Reviews\Reviewer\Penelitian\LaporanReviewController::class, 'form'])
                    ->name('form');
                Route::post('/{review}/submit', [App\Http\Controllers\Reviews\Reviewer\Penelitian\LaporanReviewController::class, 'submit'])
                    ->name('submit');
            });
        });

        /**
         * REVIEW PENGABDIAN
         * (Jika reviewer juga menilai pengabdian, tinggal uncomment blok di bawah)
         */
        Route::prefix('review/pengabdian')->name('review.pengabdian.')->group(function () {

            // Proposal
            Route::prefix('proposal')->name('proposal.')->group(function () {
                Route::get('/', [App\Http\Controllers\Reviews\Reviewer\Pengabdian\ProposalReviewController::class, 'index'])
                    ->name('index');
                Route::get('/{review}', [App\Http\Controllers\Reviews\Reviewer\Pengabdian\ProposalReviewController::class, 'form'])
                    ->name('form');
                Route::post('/{review}/submit', [App\Http\Controllers\Reviews\Reviewer\Pengabdian\ProposalReviewController::class, 'submit'])
                    ->name('submit');
            });

            // Laporan
            Route::prefix('laporan')->name('laporan.')->group(function () {
                Route::get('/', [App\Http\Controllers\Reviews\Reviewer\Pengabdian\LaporanReviewController::class, 'index'])
                    ->name('index');
                Route::get('/{review}', [App\Http\Controllers\Reviews\Reviewer\Pengabdian\LaporanReviewController::class, 'form'])
                    ->name('form');
                Route::post('/{review}/submit', [App\Http\Controllers\Reviews\Reviewer\Pengabdian\LaporanReviewController::class, 'submit'])
                    ->name('submit');
            });
        });
    });

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/profile/photo', [ProfileController::class, 'updatePhoto'])->name('profile.photo.update');

});

require __DIR__.'/auth.php';
