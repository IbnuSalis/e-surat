<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SuratController;
use App\Http\Controllers\AgendaController;
use App\Http\Controllers\BeritaAcaraController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LogAktivitasController;
use App\Http\Controllers\ProfileController;

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'login'])->middleware('guest');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/forgot-password', [LoginController::class, 'showForgotPassword'])->name('password.request')->middleware('guest');
Route::post('/forgot-password', [LoginController::class, 'sendResetLink'])->name('password.email')->middleware('guest');
Route::get('/reset-password/{token}', [LoginController::class, 'showResetForm'])->name('password.reset')->middleware('guest');
Route::post('/reset-password', [LoginController::class, 'resetPassword'])->name('password.update')->middleware('guest');

Route::middleware(['auth', 'active'])->group(function () {

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index']);

    Route::prefix('surat')->name('surat.')->group(function () {
        Route::get('/masuk', [SuratController::class, 'masuk'])->name('masuk');
        Route::get('/keluar', [SuratController::class, 'keluar'])->name('keluar');
        Route::get('/rahasia', [SuratController::class, 'rahasia'])->name('rahasia');
        Route::post('/rahasia/verify', [SuratController::class, 'verifyRahasia'])->name('rahasia.verify');
        Route::post('/rahasia/lock', [SuratController::class, 'lockRahasia'])->name('rahasia.lock');
        Route::get('/input', [SuratController::class, 'create'])->name('input');
        Route::post('/store', [SuratController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [SuratController::class, 'edit'])->name('edit')->whereNumber('id');
        Route::get('/{id}/download', [SuratController::class, 'download'])->name('download')->whereNumber('id');
        Route::get('/{id}', [SuratController::class, 'show'])->name('show')->whereNumber('id');
        Route::put('/{id}', [SuratController::class, 'update'])->name('update')->whereNumber('id');
        Route::delete('/{id}', [SuratController::class, 'destroy'])->name('destroy')->whereNumber('id')->middleware('role:admin');
    });

    Route::resource('agenda', AgendaController::class);

    Route::resource('berita-acara', BeritaAcaraController::class)->names([
        'index' => 'berita-acara.index', 'create' => 'berita-acara.create',
        'store' => 'berita-acara.store', 'show' => 'berita-acara.show',
        'edit'  => 'berita-acara.edit',  'update' => 'berita-acara.update',
        'destroy' => 'berita-acara.destroy',
    ]);

    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/photo', [ProfileController::class, 'updatePhoto'])->name('profile.photo');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');

    Route::middleware(['role:admin'])->group(function () {
        Route::resource('users', UserController::class)->except(['show']);
        Route::post('/users/{id}/reset-password', [UserController::class, 'resetPassword'])->name('users.reset-password');
        Route::post('/users/{id}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');
        Route::get('/log-aktivitas', [LogAktivitasController::class, 'index'])->name('log-aktivitas.index');
        Route::delete('/log-aktivitas/clear', [LogAktivitasController::class, 'clear'])->name('log-aktivitas.clear');
    });
});
