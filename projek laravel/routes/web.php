<?php

use App\Http\Controllers\LapanganController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/lapangan');

Route::match(['get', 'post'], '/switch-role', [LapanganController::class, 'switchRole'])->name('switch.role');

Route::resource('lapangan', LapanganController::class);
