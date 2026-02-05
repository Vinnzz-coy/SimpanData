<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\Admin\PesertaController;
use App\Http\Controllers\Admin\AbsensiController;

Route::get('/', [IndexController::class, 'index'])->name('index');
Route::get('/auth', fn() => view('auth.auth'))->name('auth');

Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/register', [AuthController::class, 'register'])->name('register');

Route::get('/privacy-policy', function () {
    return view('legal.privacy-policy');
})->name('privacy.policy');

Route::get('/terms-of-service', function () {
    return view('legal.terms-of-service');
})->name('terms.of.service');

Route::post('/send-otp', [AuthController::class, 'sendOtp'])->name('send.otp');
Route::post('/verify-otp', [AuthController::class, 'verifyOtp'])->name('verify.otp');

Route::get('/forgot-password', fn() => view('auth.forgot-password'))
    ->name('forgot.password.form');

Route::post('/check-email', [AuthController::class, 'checkEmail'])
    ->name('check.email');

Route::post('/forgot-password', [AuthController::class, 'sendForgotPasswordOtp'])
    ->name('forgot.password.post');

Route::get('/verify-reset-otp', function () {
    if (!session('reset_email')) {
        return redirect()->route('forgot.password.form')
            ->with('error', 'Silakan masukkan email terlebih dahulu');
    }
    return view('auth.verify-reset-otp');
})->name('verify.reset.otp');

Route::post('/verify-reset-otp', [AuthController::class, 'verifyResetOtp'])
    ->name('verify.reset.otp.post');

Route::post('/send-reset-otp', [AuthController::class, 'sendResetOtp'])
    ->name('send.reset.otp');

Route::get('/reset-password', function () {
    if (!session('reset_verified')) {
        return redirect()->route('forgot.password.form')
            ->with('error', 'Silakan verifikasi OTP terlebih dahulu');
    }
    return view('auth.reset-password');
})->name('reset.password.form');

Route::post('/reset-password', [AuthController::class, 'resetPassword'])
    ->name('reset.password');

Route::get('/admin/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'role:admin'])
    ->name('admin.dashboard');

Route::middleware(['auth', 'role:peserta'])->group(function () {
    Route::get('/peserta/dashboard', [App\Http\Controllers\Peserta\DashboardController::class, 'index'])
        ->name('peserta.dashboard');

    Route::get('/peserta/profil', [App\Http\Controllers\Peserta\ProfilController::class, 'index'])
        ->name('peserta.profil');

    Route::post('/peserta/profil', [App\Http\Controllers\Peserta\ProfilController::class, 'update'])
        ->name('peserta.profil.update');

    Route::get('/peserta/absensi', [App\Http\Controllers\Peserta\AbsensiController::class, 'index'])
        ->name('peserta.absensi');

    Route::get('/peserta/laporan', [App\Http\Controllers\Peserta\LaporanController::class, 'index'])
        ->name('peserta.laporan');

    Route::get('/peserta/penilaian', [App\Http\Controllers\Peserta\PenilaianController::class, 'index'])
        ->name('peserta.penilaian');

    Route::get('/peserta/feedback', [App\Http\Controllers\Peserta\FeedbackController::class, 'index'])
        ->name('peserta.feedback');

    Route::get('/peserta/settings', [App\Http\Controllers\Peserta\SettingsController::class, 'index'])->name('peserta.settings.index');
    Route::post('/peserta/settings', [App\Http\Controllers\Peserta\SettingsController::class, 'update'])->name('peserta.settings.update');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('admin/peserta', PesertaController::class)->names([
        'index' => 'admin.peserta.index',
        'create' => 'admin.peserta.create',
        'store' => 'admin.peserta.store',
        'show' => 'admin.peserta.show',
        'edit' => 'admin.peserta.edit',
        'update' => 'admin.peserta.update',
        'destroy' => 'admin.peserta.destroy',
    ]);

    Route::get('/admin/absensi', [AbsensiController::class, 'index'])
        ->middleware(['auth', 'role:admin'])
        ->name('admin.absensi.index');

    Route::resource('admin/user', App\Http\Controllers\Admin\UserController::class)->only(['index', 'show'])->names([
        'index' => 'admin.user.index',
        'show' => 'admin.user.show',
    ]);

    Route::get('/admin/penilaian', function () {
        return view('admin.penilaian.index');
    })->name('admin.penilaian.index');

    Route::get('/admin/laporan', function () {
        return view('admin.laporan.index');
    })->name('admin.laporan.index');

    Route::get('/admin/profile', [App\Http\Controllers\Admin\ProfileController::class, 'index'])->name('admin.profile.index');
    Route::post('/admin/profile', [App\Http\Controllers\Admin\ProfileController::class, 'update'])->name('admin.profile.update');

    Route::get('/admin/settings', [App\Http\Controllers\Admin\SettingsController::class, 'index'])->name('admin.settings.index');
    Route::post('/admin/settings', [App\Http\Controllers\Admin\SettingsController::class, 'update'])->name('admin.settings.update');
});
