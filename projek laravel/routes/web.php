<?php

use App\Http\Controllers\LapanganController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/lapangan');

Route::resource('lapangan', LapanganController::class);
