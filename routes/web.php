<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Public\JobController;
use App\Http\Controllers\KandidatController;
use App\Http\Controllers\Admin\AkunAdminController;
use App\Http\Controllers\HRD\AkunHrdController;
use App\Http\Controllers\AccountSettingsController;
use App\Http\Controllers\Hrd\LowonganController;
use App\Http\Controllers\Admin\ManajemenAkunController;
use App\Http\Controllers\Admin\UsersPdfController;
use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;

/*
|--------------------------------------------------------------------------
| PUBLIC / UMUM (GUEST BOLEH)
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('public.home');
})->name('public.home');

/* ===== LOWONGAN ===== */

Route::get('/lowongan', [JobController::class, 'index'])
    ->name('jobs.index');

Route::get('/lowongan/{lowongan}', [JobController::class, 'show'])
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

        Route::get('/lamaran', function () {
            return view('pelamar.lamaran');
        })->name('lamaran');
 /*
        |========================
        | DATA DIRI
        |========================
        */
        // ✅ DATA DIRI (AJAX)
        Route::post('/profile/data-diri', [ProfileController::class, 'updateDataDiri'])
            ->name('pelamar.profile.data-diri');

        // ✅ TENTANG SAYA
        Route::post('/profile/tentang-saya', [ProfileController::class, 'updateTentangSaya'])
            ->name('profile.tentang-saya');

        /*
        |========================
        | EXPERIENCE
        |========================
        */
        Route::post('/profile/experiences', [ProfileController::class, 'storeExperience']);
        Route::put('/profile/experiences/{id}', [ProfileController::class, 'updateExperience']);
        Route::delete('/profile/experiences/{id}', [ProfileController::class, 'deleteExperience']);

        /*
        |========================
        | EDUCATION
        |========================
        */
        Route::post('/profile/educations', [ProfileController::class, 'storeEducation']);
        Route::put('/profile/educations/{id}', [ProfileController::class, 'updateEducation']);
        Route::delete('/profile/educations/{id}', [ProfileController::class, 'deleteEducation']);

        /*
        |========================
        | SKILLS
        |========================
        */
        Route::post('/profile/skills', [ProfileController::class, 'storeSkill']);
        Route::delete('/profile/skills/{id}', [ProfileController::class, 'deleteSkill']);

        /*
        |========================
        | RESUME
        |========================
        */
        Route::post('/profile/resume', [ProfileController::class, 'uploadResume']);
        Route::delete('/profile/resume', [ProfileController::class, 'deleteResume']);

        /*
        |========================
        | CERTIFICATE
        |========================
        */
        Route::post('/profile/certificates', [ProfileController::class, 'storeCertificate']);
        Route::put('/profile/certificates/{id}', [ProfileController::class, 'updateCertificate']);
        Route::delete('/profile/certificates/{id}', [ProfileController::class, 'deleteCertificate']);

        /*
        |========================
        | ORGANIZATION
        |========================
        */
        Route::post('/profile/organizations', [ProfileController::class, 'storeOrganization']);
        Route::put('/profile/organizations/{id}', [ProfileController::class, 'updateOrganization']);
        Route::delete('/profile/organizations/{id}', [ProfileController::class, 'deleteOrganization']);

        /*
        |========================
        | ACHIEVEMENT
        |========================
        */
        Route::post('/profile/achievements', [ProfileController::class, 'storeAchievement']);
        Route::put('/profile/achievements/{id}', [ProfileController::class, 'updateAchievement']);
        Route::delete('/profile/achievements/{id}', [ProfileController::class, 'deleteAchievement']);
    });


/*
|--------------------------------------------------------------------------
| HRD ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:hrd'])
    ->prefix('hrd')
    ->group(function () {

    /*
    |--------------------------------------------------------------------------
    | AKUN HRD
    |--------------------------------------------------------------------------
    */
    Route::get('/akun/{id}', [AkunHrdController::class, 'show'])
        ->name('akun.detail');

    /*
    |--------------------------------------------------------------------------
    | DASHBOARD HRD
    |--------------------------------------------------------------------------
    */
    Route::get('/dashboard', function () {
        return view('hrd.dashboard');
    })->name('hrd.dashboard');

    /*
    |--------------------------------------------------------------------------
    | LOWONGAN (DATABASE READY)
    |--------------------------------------------------------------------------
    */

    Route::get('/lowongan', [LowonganController::class, 'index'])->name('lowongan.index');
    Route::get('/lowongan/create', [LowonganController::class, 'create'])->name('lowongan.create');
    Route::post('/lowongan', [LowonganController::class, 'store'])->name('lowongan.store');

    Route::get('/lowongan/{lowongan}/edit', [LowonganController::class, 'edit'])->name('lowongan.edit');
    Route::put('/lowongan/{lowongan}', [LowonganController::class, 'update'])->name('lowongan.update');

    Route::get('/lowongan/{lowongan}/deskripsi', [LowonganController::class, 'createDeskripsi'])
        ->name('lowongan.create.deskripsi');

    Route::put('/lowongan/{lowongan}/deskripsi', [LowonganController::class, 'updateDeskripsi'])
        ->name('lowongan.update.deskripsi');

    Route::delete('/lowongan/{lowongan}', [LowonganController::class, 'destroy'])
    ->name('lowongan.destroy');

    Route::post('/lowongan/{lowongan}/status', 
    [LowonganController::class, 'updateStatus']
)->name('lowongan.update-status');

Route::get('/lowongan/{lowongan}', 
    [LowonganController::class, 'show']
)->name('lowongan.show');

    /*
    |--------------------------------------------------------------------------
    | KANDIDAT (MASIH DUMMY – TIDAK DISENTUH DULU)
    |--------------------------------------------------------------------------
    */
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

    Route::get('/lowongan/{lowongan}/kandidat/{pelamar}', function ($lowongan, $pelamar) {

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

    /*
    |--------------------------------------------------------------------------
    | LAPORAN LOWONGAN
    |--------------------------------------------------------------------------
    */
    Route::get('/lowongan/{lowongan}/laporan', function ($lowongan) {
        return view('hrd.laporan.index', compact('lowongan'));
    })->name('hrd.laporan.index');

});

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

        Route::get('/manajemen-akun', [ManajemenAkunController::class, 'index'])
            ->name('akun.index');

        Route::post('/manajemen-akun', [ManajemenAkunController::class, 'store'])
            ->name('akun.store');

        Route::put('/manajemen-akun/{user}', [ManajemenAkunController::class, 'update'])
            ->name('akun.update');

        Route::delete('/manajemen-akun/{user}', [ManajemenAkunController::class, 'destroy'])
            ->name('akun.destroy');

    Route::get('/manajemen-akun/pdf', [UsersPdfController::class, 'preview']);
    Route::get('/manajemen-akun/excel', function () {
        return Excel::download(
            new UsersExport(request('role')),
            'akun.xlsx'
        );
    });

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
