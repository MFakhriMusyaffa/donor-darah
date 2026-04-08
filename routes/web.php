<?php

use Illuminate\Support\Facades\Route;
use App\Models\Berita;
use App\Models\JadwalKegiatan;
use App\Models\StokDarah;
use App\Models\User;
use App\Http\Controllers\UserController;

// Route::inertia('/', 'Welcome', [
//     'canRegister' => Features::enabled(Features::registration()),
// ])->name('home');

Route::get('/login', function () {
    return inertia('auth/Login', [
        'canResetPassword' => true,
        'canRegister' => true,
    ]);
})->middleware('guest')->name('login');
Route::inertia('/register', 'auth/Register')->name('register');

Route::middleware(['auth','role:admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return inertia('admin/Dashboard', [
            'counts' => [
                'users' => User::count(),
                'stokDarah' => StokDarah::count(),
                'jadwal' => JadwalKegiatan::count(),
                'berita' => Berita::count(),
            ],
            'users' => User::select('id', 'name', 'email', 'role')
                ->orderByDesc('created_at')
                ->limit(5)
                ->get(),
            'stokDarah' => StokDarah::select('id', 'golongan_darah', 'rhesus', 'jumlah_kantong')
                ->orderByDesc('updated_at')
                ->limit(5)
                ->get(),
            'jadwal' => JadwalKegiatan::select('id', 'event_name', 'start_event', 'location')
                ->orderByDesc('start_event')
                ->limit(5)
                ->get(),
            'berita' => Berita::select('id', 'title', 'publish_date')
                ->orderByDesc('publish_date')
                ->limit(5)
                ->get(),
        ]);
    })->name('admin.dashboard');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return inertia('Dashboard');
    })->name('dashboard');
});

// Masyarakat Routes
Route::middleware(['auth', 'role:masyarakat'])->group(function () {
    Route::get('/stok-darah', function () {
        return inertia('masyarakat/StokDarah', [
            'stokDarah' => StokDarah::select('id', 'golongan_darah', 'rhesus', 'jumlah_kantong')
                ->orderBy('golongan_darah')
                ->get(),
        ]);
    })->name('stok-darah');

    Route::get('/jadwal', function () {
        return inertia('masyarakat/JadwalKegiatan', [
            'jadwal' => JadwalKegiatan::select('id', 'event_name', 'start_event', 'end_event', 'location', 'detail')
                ->orderBy('start_event', 'asc')
                ->get(),
        ]);
    })->name('jadwal');

    Route::get('/berita', function () {
        return inertia('masyarakat/berita/Berita', [
            'berita' => Berita::select('id', 'title', 'publish_date','thumbnail', 'content')
                ->orderByDesc('publish_date')
                ->get(),
        ]);
    })->name('berita');
    
    Route::get('/berita/{id}', function ($id) {
        $berita = Berita::findOrFail($id); 
        return inertia('masyarakat/berita/DetailBerita', [
            'berita' => $berita
        ]);
    })->name('berita.show');
});

Route::middleware(['auth','role:admin'])->group(function () {
    // USER
    Route::get('/admin/users', function () {
        return inertia('admin/users/List', [
            'users' => User::select('id', 'name', 'email', 'role', 'created_at')
                ->orderByDesc('created_at')
                ->get(),
        ]);
    })->name('admin.users');

    Route::get('/admin/users/create', function () {
        return inertia('admin/users/Create');
    })->name('admin.users.create');

    Route::post('/admin/users', [UserController::class, 'store'])->name('admin.users.store');

    Route::get('/admin/users/{id}/data', [UserController::class, 'show']);

    Route::get('/admin/users/edit/{id}', function ($id) {
        return inertia('admin/users/Edit', ['id' => $id]);
    })->name('admin.users.edit');

    // BERITA 
    Route::get('/admin/berita', function () {
        return inertia('admin/berita/List');
    })->name('admin.berita');

    Route::get('/admin/berita/create', function () {
        return inertia('admin/berita/Create');
    })->name('admin.berita.create');

    Route::get('/admin/berita/edit/{id}', function ($id) {
        return inertia('admin/berita/Edit', ['id' => $id]);
    })->name('admin.berita.edit');

    // STOK DARAH 
    Route::get('/admin/stok-darah', function () {
        return inertia('admin/stok-darah/List');
    })->name('admin.stok-darah');

    Route::get('/admin/stok-darah/create', function () {
        return inertia('admin/stok-darah/Create');
    })->name('admin.stok-darah.create');

    Route::get('/admin/stok-darah/edit/{id}', function ($id) {
        return inertia('admin/stok-darah/Edit', ['id' => $id]);
    })->name('admin.stok-darah.edit');

    // JADWAL 
    Route::get('/admin/jadwal', function () {
        return inertia('admin/jadwal/List');
    })->name('admin.jadwal');

    Route::get('/admin/jadwal/create', function () {
        return inertia('admin/jadwal/Create');
    })->name('admin.jadwal.create');

    Route::get('/admin/jadwal/edit/{id}', function ($id) {
        return inertia('admin/jadwal/Edit', ['id' => $id]);
    })->name('admin.jadwal.edit');
});

Route::get('/', function () {
    if (auth()->check()) {
        $user = auth()->user();
        if ($user->role === 'admin') {
            return redirect('/admin/dashboard');
        } elseif ($user->role === 'masyarakat') {
            return redirect('/dashboard');
        }
        return redirect('/dashboard'); 
    }
    return redirect('/login');
})->name('home');

// Route::get('/logout', function () {
//     auth()->logout();
//     return redirect('/login');
// });

Route::post('/logout', function () {
    auth()->logout();
    return redirect('/login');
});

require __DIR__.'/settings.php';

