<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use App\Http\Controllers\StokDarahController;
use App\Http\Controllers\BeritaController;

Route::get('/', function () {
    if (auth()->check()) {
        $user = auth()->user();
        if ($user->role === 'admin') {
            return redirect('/admin/dashboard');
        } elseif ($user->role === 'masyarakat') {
            return redirect('/dashboard');
        }
        return redirect('/dashboard'); // fallback
    }
    return redirect('/login');
})->name('home');

/* ROUTE AUTH PAGES */
Route::get('/login', function () {
    return inertia('auth/Login', [
        'canResetPassword' => true,
        'canRegister' => true,
    ]);
})->middleware('guest')->name('login');
Route::inertia('/register', 'auth/Register')->name('register');

Route::middleware(['auth','role:admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return inertia('admin/Dashboard');
    })->name('admin.dashboard');
});

// BERITA YEZZ 
    Route::get('/admin/berita', function () {
        return inertia('admin/berita/List');
    });

    Route::get('/admin/berita/create', function () {
        return inertia('admin/berita/Create');
    });

    Route::get('/admin/berita/edit/{id}', function ($id) {
        return inertia('admin/berita/Edit', ['id' => $id]);
    });

    // STOK DARAH YEZZ 
    Route::get('/admin/stok-darah', function () {
        return inertia('admin/stok-darah/List');
    });

    Route::get('/admin/stok-darah/create', function () {
        return inertia('admin/stok-darah/Create');
    });

    Route::get('/admin/stok-darah/edit/{id}', function ($id) {
        return inertia('admin/stok-darah/Edit', ['id' => $id]);
    });

    // JADWAL YEZZ 
    Route::get('/admin/jadwal', function () {
        return inertia('admin/jadwal/List');
    });

    Route::get('/admin/jadwal/create', function () {
        return inertia('admin/jadwal/Create');
    });

    Route::get('/admin/jadwal/edit/{id}', function ($id) {
        return inertia('admin/jadwal/Edit', ['id' => $id]);
    });


Route::middleware(['auth','role:masyarakat'])->group(function () {
    Route::get('/dashboard', function () {
        return inertia('Dashboard');
    })->name('dashboard');
});

require __DIR__.'/settings.php';

