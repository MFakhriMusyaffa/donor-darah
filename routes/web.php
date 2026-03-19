<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;

Route::inertia('/', 'Welcome', [
    'canRegister' => Features::enabled(Features::registration()),
])->name('home');
    
Route::inertia('/dashboard', 'Dashboard')->name('dashboard');

/* ROUTE AUTH PAGES */
// Route::get('/login', function () {
//     return inertia('auth/Login', [
//         'canResetPassword' => true,
//         'canRegister' => true,
//     ]);
// })->name('login');
// Route::inertia('/register', 'auth/Register')->name('register');

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
    });
});

Route::middleware(['auth','role:masyarakat'])->group(function () {
    Route::get('/dashboard', function () {
        return inertia('masyarakat/Dashboard');
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

Route::get('/logout', function () {
    auth()->logout();
    return redirect('/login');
});

require __DIR__.'/settings.php';

