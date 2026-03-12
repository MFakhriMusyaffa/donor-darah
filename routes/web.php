<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;

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

Route::middleware(['auth','role:masyarakat'])->group(function () {
    Route::get('/dashboard', function () {
        return inertia('masyarakat/Dashboard');
    });
});

require __DIR__.'/settings.php';
