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

Route::middleware(['auth','role:masyarakat'])->group(function () {
    Route::get('/dashboard', function () {
        return inertia('Dashboard');
    })->name('dashboard');
});

require __DIR__.'/settings.php';

