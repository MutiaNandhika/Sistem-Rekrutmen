<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\JobController;

/*
|--------------------------------------------------------------------------
| PUBLIC / UMUM (GUEST BOLEH)
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('public.home');
})->name('public.home');

/* ===== LOWONGAN ===== */

// Halaman daftar lowongan (PUBLIC)
Route::get('/lowongan', function () {
    return view('public.jobs.index');
})->name('jobs.index');

// Halaman detail lowongan (WAJIB LOGIN)
Route::get('/lowongan/{id}', [JobController::class, 'show'])
    ->name('jobs.show');

Route::get('/tentang-kami', function () {
    return view('public.about');
})->name('about');


/*
|--------------------------------------------------------------------------
| REDIRECT SETELAH LOGIN (BERDASARKAN ROLE)
|--------------------------------------------------------------------------
*/

Route::get('/redirect-after-login', function (Request $request) {

    $user = $request->user();

    return match ($user->role) {
        'admin' => redirect('/admin/dashboard'),
        'hrd'   => redirect('/hrd/dashboard'),
        default => redirect('/pelamar/profile'),
    };

})->middleware('auth');


/*
|--------------------------------------------------------------------------
| PROFILE (SEMUA ROLE)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin,hrd'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



/*
|--------------------------------------------------------------------------
| PELAMAR
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:pelamar'])
    ->prefix('pelamar')
    ->name('pelamar.')
    ->group(function () {

        Route::get('/profile', [ProfileController::class, 'index'])
            ->name('profile');

        Route::post('/profile/update', [ProfileController::class, 'updateDataDiri'])
            ->name('profile.update');

        Route::get('/lamaran', function () {
            return view('pelamar.lamaran');
        })->name('lamaran');
    });

/*
|--------------------------------------------------------------------------
| HRD
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:hrd'])
    ->prefix('hrd')
    ->group(function () {
        Route::get('/dashboard', function () {
            return view('hrd.dashboard');
        });
    });


/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->group(function () {
        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        });
    });


/*
|--------------------------------------------------------------------------
| AUTH ROUTES (Laravel Breeze)
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';
