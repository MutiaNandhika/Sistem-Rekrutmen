<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\KandidatController;
use App\Http\Controllers\Admin\AkunAdminController;
use App\Http\Controllers\HRD\AkunHrdController;
use App\Http\Controllers\AccountSettingsController;

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
| HRD ROUTES (FRONTEND MODE - TANPA DATABASE)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:hrd'])
    ->prefix('hrd')
    ->group(function () {

// Detail akun HRD
        Route::get('/akun/{id}', [AkunHrdController::class, 'show'])
            ->name('akun.detail');

        /*
        |-----------------------
        | DASHBOARD HRD
        |-----------------------
        */
        Route::get('/dashboard', function () {
            return view('hrd.dashboard');
        })->name('hrd.dashboard');


        /*
        |-----------------------
        | LOWONGAN (DUMMY DATA)
        |-----------------------
        */
        Route::get('/lowongan', function () {

            // ✅ DUMMY DATA (TANPA DATABASE)
            $lowongans = collect([
                (object) [
                    'id' => 1,
                    'judul' => 'Business Development - Duluin Gajian',
                    'perusahaan' => 'PT JNE',
                    'tipe_pekerjaan' => 'Penuh Waktu · Kerja di kantor',
                    'lokasi' => 'Jl. Merdeka no. 1945 Soedirman',
                    'status' => 'aktif',
                    'updated_at' => now()->subDays(1),
                ],
                (object) [
                    'id' => 2,
                    'judul' => 'Marketing Executive',
                    'perusahaan' => 'PT MDA Partner',
                    'tipe_pekerjaan' => 'Penuh Waktu · Hybrid',
                    'lokasi' => 'Jakarta Selatan',
                    'status' => 'nonaktif',
                    'updated_at' => now()->subDays(5),
                ],
            ]);

            /*
            |------------------------------------
            | HITUNG JUMLAH UNTUK TAB BADGE
            |------------------------------------
            */
            $total    = $lowongans->count();
            $aktif    = $lowongans->where('status', 'aktif')->count();
            $nonaktif = $lowongans->where('status', 'nonaktif')->count();
            $draft    = $lowongans->where('status', 'draft')->count();

            return view('hrd.lowongan.index', compact(
                'lowongans',
                'total',
                'aktif',
                'nonaktif',
                'draft'
            ));

        })->name('lowongan.index');

        /*
        |-------------------------------------------------
        | TOGGLE STATUS (FRONTEND ONLY / SIMULASI)
        |-------------------------------------------------
        */
        Route::post('/lowongan/{id}/toggle-status', function ($id) {

            // ❗ HANYA RESPONSE DUMMY
            return response()->json([
                'status' => 'ok'
            ]);

        })->name('lowongan.toggle-status');

        /*
        |-----------------------
        | LOWONGAN - CREATE (FORM)
        |-----------------------
        */
        Route::get('/lowongan/create', function () {
            return view('hrd.lowongan.create');
        })->name('lowongan.create');

        Route::get('/lowongan/create/deskripsi', function () {
            return view('hrd.lowongan.create-deskripsi');
        })->name('lowongan.create.deskripsi');  

        Route::get('/lowongan/{id}/edit', fn ($id) => view('hrd.lowongan.edit'))
            ->name('lowongan.edit');

        /*
        |-----------------------
        | LOWONGAN - STORE (DUMMY)
        |-----------------------
        */
        Route::post('/lowongan', function () {
            // ⛔ belum simpan database
            return redirect()
                ->route('lowongan.index')
                ->with('success', 'Lowongan berhasil ditambahkan (simulasi)');
        })->name('lowongan.store');

    Route::get('/lowongan/{lowongan}/kandidat', function ($lowongan) {

        $kandidats = collect([
            (object) [
                'id' => 1,
                'nama' => 'Joodiva',
                'status' => 'Diproses',
                'tanggal' => '2025-12-14',
                'pendidikan' => 'S1',
                'pengalaman' => 5,
                'keahlian' => 3,
                'skor' => 82,
                'ranking' => 2,
            ],
            (object) [
                'id' => 2,
                'nama' => 'Naruto',
                'status' => 'Diterima',
                'tanggal' => '2025-12-01',
                'pendidikan' => 'SMK',
                'pengalaman' => 2,
                'keahlian' => 6,
                'skor' => 90,
                'ranking' => 1,
            ],
        ]);

        return view('hrd.kandidat.index', compact('kandidats', 'lowongan'));
    })->name('hrd.kandidat.index');

    // =====================
// DETAIL PELAMAR
// =====================
Route::get('/lowongan/{lowongan}/kandidat/{pelamar}', function ($lowongan, $pelamar) {

    // dummy data pelamar
    $pelamarData = (object) [
        'id' => $pelamar,
        'nama' => 'Mutia Nandhika',
        'whatsapp' => '081234567890',
        'email' => 'mutianandhika@gmail.com',
        'lokasi' => 'Jakarta',
        'usia' => 21,
        'pendidikan' => 'SMA / SMK',
        'gender' => 'Perempuan',
    ];

    return view('hrd.kandidat.detail', [
        'lowongan' => $lowongan,
        'pelamar'  => $pelamarData,
    ]);

})->name('hrd.kandidat.detail');
    });
Route::get('/lowongan/{lowongan}/laporan', function ($lowongan) {
    return view('hrd.laporan.index', compact('lowongan'));
})->name('hrd.laporan.index');
/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('dashboard');

        Route::get('/manajemen-akun', function () {
            return view('admin.manajemen-akun');
        })->name('manajemen-akun');

        Route::get('/monitoring', function () {
            return view('admin.monitoring');
        })->name('monitoring');

        Route::get('/akun/{id}', [AkunAdminController::class, 'show'])
            ->name('akun.detail');

    });

/*
|--------------------------------------------------------------------------
| AUTH ROUTES (Laravel Breeze)
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';

/*
|--------------------------------------------------------------------------
| PENGATURAN AKUN (SEMUA ROLE)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    Route::get('/pengaturan-akun', [AccountSettingsController::class, 'index'])
        ->name('account.settings');

    Route::post('/pengaturan-akun/password', [AccountSettingsController::class, 'updatePassword'])
        ->name('account.password.update');

});
