<?php

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
        Route::get('/assign-role', function () {
            return view('admin.users.assign-role');
        })->name('assign-role.index');

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

            Route::get('/', [App\Http\Controllers\Penelitian\IndexController::class, 'index'])
                ->name('index');
            // Usulan Proposal Penelitian
            // Upload Laporan Pengabdian
            Route::get('/proposal/create', function () {
                return view('penelitian.proposal.create');
            })->name('proposal.create');

            // Upload Laporan Penelitian
            Route::get('/lapoan/create/{proposalId}', function ($proposalId) {
                return view('penelitian.laporan.create', compact('proposalId'));
            })->name('laporan.create');
        });

        /**
         * PENGABDIAN
         */
        Route::prefix('pengabdian')->name('pengabdian.')->group(function () {
            Route::get('/', [App\Http\Controllers\Pengabdian\IndexController::class, 'index'])
                ->name('index');

            // Upload proposal Pengabdian
            Route::get('/proposal/create', function () {
                return view('pengabdian.proposal.create');
            })->name('proposal.create');
         
            // Upload Laporan Pengabdian
            Route::get('/laporan/create/{proposalId}', function ($proposalId) {
                return view('pengabdian.laporan.create',compact('proposalId'));
            })->name('laporan.create');

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
                Route::get('/', function () {
                    return view('reviews.prpm.penelitian.proposal.index');
                })->name('index');
                Route::get('/{proposalId}', function ($proposalId) {
                    return view('reviews.prpm.penelitian.proposal.form', compact('proposalId'));
                })->name('form');

            });

            // Laporan
            Route::prefix('laporan')->name('laporan.')->group(function () {

                Route::get('/', function () {
                    return view('reviews.prpm.penelitian.laporan.index');
                })->name('index');
                Route::get('/{laporanId}', function ($laporanId) {
                    return view('reviews.prpm.penelitian.laporan.form', compact('laporanId'));
                })->name('form');

            });
        });

        /**
         * REVIEW PENGABDIAN
         */
        Route::prefix('review/pengabdian')->name('review.pengabdian.')->group(function () {

            // Proposal
            Route::prefix('proposal')->name('proposal.')->group(function () {
                Route::get('/', function () {
                    return view('reviews.prpm.pengabdian.proposal.index');
                })->name('index');
                Route::get('/{proposalId}', function ($proposalId) {
                    return view('reviews.prpm.pengabdian.proposal.form', compact('proposalId'));
                })->name('form');

            });

            // Laporan
            Route::prefix('laporan')->name('laporan.')->group(function () {

                Route::get('/', function () {
                    return view('reviews.prpm.pengabdian.laporan.index');
                })->name('index');
                Route::get('/{laporanId}', function ($laporanId) {
                    return view('reviews.prpm.pengabdian.laporan.form', compact('laporanId'));
                })->name('form');

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
                Route::get('/', function () {
                    return view('reviews.reviewer.penelitian.proposal.index');
                })->name('index');
                Route::get('/{proposalId}', function ($proposalId) {
                    return view('reviews.reviewer.penelitian.proposal.form', compact('proposalId'));
                })->name('form');
            });

            // Laporan
            Route::prefix('laporan')->name('laporan.')->group(function () {
                Route::get('/', function () {
                    return view('reviews.reviewer.penelitian.laporan.index');
                })->name('index');
                Route::get('/{laporanId}', function ($laporanId) {
                    return view('reviews.reviewer.penelitian.laporan.form', compact('laporanId'));
                })->name('form');
            });
        });

        /**
         * REVIEW PENGABDIAN
         * (Jika reviewer juga menilai pengabdian, tinggal uncomment blok di bawah)
         */
        Route::prefix('review/pengabdian')->name('review.pengabdian.')->group(function () {

            // Proposal
            Route::prefix('proposal')->name('proposal.')->group(function () {
                Route::get('/', function () {
                    return view('reviews.reviewer.pengabdian.proposal.index');
                })->name('index');
                Route::get('/{proposalId}', function ($proposalId) {
                    return view('reviews.reviewer.pengabdian.proposal.form', compact('proposalId'));
                })->name('form');
            });

            // Laporan
            Route::prefix('laporan')->name('laporan.')->group(function () {
                Route::get('/', function () {
                    return view('reviews.reviewer.pengabdian.laporan.index');
                })->name('index');
                Route::get('/{laporanId}', function ($laporanId) {
                    return view('reviews.reviewer.pengabdian.laporan.form', compact('laporanId'));
                })->name('form');
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
