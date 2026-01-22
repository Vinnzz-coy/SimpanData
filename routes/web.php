<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\DashboardController;

Route::get('/', fn() => view('auth.auth'));
Route::get('/auth', fn() => view('auth.auth'))->name('auth');

Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/register', [AuthController::class, 'register'])->name('register');

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

Route::get('/peserta/dashboard', fn() => view('peserta.dashboard'))
    ->middleware(['auth', 'role:peserta'])
    ->name('peserta.dashboard');
