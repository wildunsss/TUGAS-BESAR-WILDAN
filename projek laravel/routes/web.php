<?php

use App\Http\Controllers\LapanganController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Index routes (Daftar lapangan)
Route::get('/', [LapanganController::class, 'index'])->name('lapangan.index');
Route::get('/lapangan', [LapanganController::class, 'index']);
Route::get('/lapangan.php', [LapanganController::class, 'index']);

// Create routes (Tambah lapangan)
Route::get('/lapangan/create', [LapanganController::class, 'create'])->name('lapangan.create');
Route::get('/form-lapangan', [LapanganController::class, 'create']);
Route::get('/form-lapangan.php', function (Request $request) {
    if ($request->filled('id') && (int) $request->id > 0) {
        return app(LapanganController::class)->edit($request, $request->id);
    }
    return app(LapanganController::class)->create();
});

// Edit routes
Route::get('/lapangan/{id}/edit', [LapanganController::class, 'edit'])->name('lapangan.edit');

// Store & Update routes
Route::post('/lapangan', [LapanganController::class, 'store'])->name('lapangan.store');
Route::put('/lapangan/{id}', [LapanganController::class, 'update'])->name('lapangan.update');
Route::post('/form-lapangan', [LapanganController::class, 'storeOrUpdate'])->name('lapangan.save');
Route::post('/form-lapangan.php', [LapanganController::class, 'storeOrUpdate']);

// Delete routes
Route::delete('/lapangan/{id}', [LapanganController::class, 'destroy'])->name('lapangan.destroy');
Route::get('/hapus-lapangan.php', [LapanganController::class, 'destroy']);
Route::post('/hapus-lapangan.php', [LapanganController::class, 'destroy']);
Route::get('/lapangan/{id}/hapus', [LapanganController::class, 'destroy']);
