<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\LapanganController;
use App\Models\Area;
use App\Models\Lapangan;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.proses');

    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.proses');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/', fn () => redirect()->route('dashboard'));
    Route::get('/dashboard', function () {
        $totalLapangan = Lapangan::count();
        $lapanganBaik = Lapangan::where('status_fisik', 'baik')->count();
        $lapanganPerbaikan = Lapangan::whereIn('status_fisik', ['perlu_perbaikan', 'rusak'])->count();
        $totalArea = Area::count();
        $areas = Area::withCount('lapangans')->get();
        $lapangansTerbaru = Lapangan::with('area')->latest('id')->take(5)->get();

        return view('dashboard', compact(
            'totalLapangan',
            'lapanganBaik',
            'lapanganPerbaikan',
            'totalArea',
            'areas',
            'lapangansTerbaru'
        ));
    })->name('dashboard');

    Route::resource('lapangan', LapanganController::class);
});
