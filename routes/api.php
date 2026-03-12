<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JadwalKegiatanController;
use App\Http\Controllers\StokDarahController;
use App\Http\Controllers\BeritaController;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::apiResource('jadwal-kegiatan', JadwalKegiatanController::class);
Route::get('/stok-darah', [StokDarahController::class, 'index']);
Route::post('/stok-darah', [StokDarahController::class, 'store']);
Route::get('/stok-darah/{id}', [StokDarahController::class, 'show']);
Route::put('/stok-darah/{id}', [StokDarahController::class, 'update']);
Route::delete('/stok-darah/{id}', [StokDarahController::class, 'destroy']);
Route::get('/berita', [BeritaController::class, 'index']);
Route::post('/berita', [BeritaController::class, 'store']);
Route::get('/berita/{id}', [BeritaController::class, 'show']);
Route::put('/berita/{id}', [BeritaController::class, 'update']);
Route::delete('/berita/{id}', [BeritaController::class, 'destroy']);
