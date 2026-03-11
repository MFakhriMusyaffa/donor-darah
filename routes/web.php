<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use App\Http\Controllers\StokDarahController;

Route::inertia('/', 'Welcome', [
    'canRegister' => Features::enabled(Features::registration()),
])->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::inertia('dashboard', 'Dashboard')->name('dashboard');
});

require __DIR__.'/settings.php';

Route::prefix('api')->group(function () {
    Route::get('/stok-darah', [StokDarahController::class, 'index']);
    Route::post('/stok-darah', [StokDarahController::class, 'store']);
    Route::get('/stok-darah/{id}', [StokDarahController::class, 'show']);
    Route::put('/stok-darah/{id}', [StokDarahController::class, 'update']);
    Route::delete('/stok-darah/{id}', [StokDarahController::class, 'destroy']);
});