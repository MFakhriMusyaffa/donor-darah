<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use App\Http\Controllers\StokDarahController;
use App\Http\Controllers\BeritaController;

Route::inertia('/', 'Welcome', [
    'canRegister' => Features::enabled(Features::registration()),
])->name('home');

/* ROUTE AUTH PAGES */
Route::get('/login', function () {
    return inertia('auth/Login', [
        'canResetPassword' => true,
        'canRegister' => true,
    ]);
})->name('login');
Route::inertia('/register', 'auth/Register')->name('register');

Route::middleware(['auth','role:admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return inertia('admin/Dashboard');
    });
});

Route::get('/admin/berita/edit/{id}', function ($id) {
    return inertia('admin/EditBerita', [
        'id' => $id
    ]);
});

Route::get('/admin/berita', function () {
    return inertia('admin/ListBerita');
});

Route::get('/admin/berita/create', function () {
    return inertia('admin/CreateBerita');
});

Route::get('/admin/stok-darah', function () {
    return inertia('admin/ListStokDarah');
});

Route::get('/admin/stok-darah/create', function () {
    return inertia('admin/CreateStokDarah');
});

Route::get('/admin/stok-darah/edit/{id}', function ($id) {
    return inertia('admin/EditStokDarah', [
        'id' => $id
    ]);
});

Route::get('/admin/jadwal', function () {
    return inertia('admin/ListJadwalKegiatan');
});

Route::get('/admin/jadwal/create', function () {
    return inertia('admin/CreateJadwalKegiatan');
});

Route::get('/admin/jadwal/edit/{id}', function ($id) {
    return inertia('admin/EditJadwalKegiatan', [
        'id' => $id
    ]);
});

Route::middleware(['auth','role:masyarakat'])->group(function () {
    Route::get('/dashboard', function () {
        return inertia('masyarakat/Dashboard');
    });
});

require __DIR__.'/settings.php';

