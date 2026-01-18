<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Public\JobController;
use App\Http\Controllers\Admin\AkunAdminController;
use App\Http\Controllers\Admin\ManajemenAkunController;
use App\Http\Controllers\Admin\UsersPdfController;
use App\Http\Controllers\Admin\MonitoringController;
use App\Http\Controllers\Hrd\AkunHrdController;
use App\Http\Controllers\Hrd\LowonganController;
use App\Http\Controllers\Hrd\LamaranHrdController;
use App\Http\Controllers\Hrd\KandidatController;
use App\Http\Controllers\Hrd\SawController;
use App\Http\Controllers\Hrd\SkillController;
use App\Http\Controllers\Hrd\BidangKerjaController;
use App\Http\Controllers\Hrd\SeleksiController;
use App\Http\Controllers\AccountSettingsController;
use App\Models\Application;
use App\Http\Controllers\Pelamar\LamaranController;
use App\Exports\UsersExport;
use App\Http\Controllers\Hrd\DashboardController;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
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

            $application = Application::where('user_id', Auth::id())
                ->latest()
                ->first();

            return view('pelamar.lamaran', compact('application'));

        })->name('lamaran');

        Route::post('/lamar/{lowongan}', [LamaranController::class, 'store'])
        ->name('lamar.store');

        Route::post('/lamaran/{application}/offer-response',
            [LamaranController::class, 'offerResponse']
        )->name('offer.response');

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



Route::middleware(['auth', 'role:hrd'])
    ->prefix('hrd')
    ->name('hrd.')
    ->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('dashboard');

        // AJAX DATA
    Route::get('/dashboard/data', [DashboardController::class, 'data'])
            ->name('dashboard.data');

    /* ================= LAMARAN ================= */
    Route::get('/lamaran', [LamaranHrdController::class, 'index'])
        ->name('lamaran.index');

    Route::put('/lamaran/{application}', [LamaranHrdController::class, 'update'])
        ->name('lamaran.update');

    Route::put('/lamaran/{application}/interview',
        [LamaranHrdController::class, 'setInterview']
    )->name('lamaran.interview');

    Route::delete('/lamaran/{application}/interview',
        [LamaranHrdController::class, 'deleteInterview']
    )->name('lamaran.interview.delete');

    Route::post(
    '/lamaran/{application}/offer',
        [LamaranHrdController::class, 'uploadOffer']
    )->name('lamaran.offer.upload');


    /* ================= KANDIDAT ================= */
    Route::get('/lowongan/{lowongan}/kandidat',
        [KandidatController::class, 'index']
    )->name('kandidat.index');

    Route::get('/lowongan/{lowongan}/kandidat/{application}',
        [KandidatController::class, 'show']
    )->name('kandidat.detail');

    /* ================= LOWONGAN ================= */
    Route::get('/lowongan', [LowonganController::class, 'index'])
        ->name('lowongan.index');

    Route::get('/lowongan/create', [LowonganController::class, 'create'])
        ->name('lowongan.create');

    Route::post('/lowongan', [LowonganController::class, 'store'])
        ->name('lowongan.store');

    Route::get('/lowongan/{lowongan}', [LowonganController::class, 'show'])
        ->name('lowongan.show');

    Route::get('/lowongan/{lowongan}/edit', [LowonganController::class, 'edit'])
        ->name('lowongan.edit');

    Route::put('/lowongan/{lowongan}', [LowonganController::class, 'update'])
        ->name('lowongan.update');

    Route::post('/lowongan/{lowongan}/status', [LowonganController::class, 'updateStatus']
        )->name('lowongan.status');

    Route::delete('/lowongan/{lowongan}', [LowonganController::class, 'destroy'])
        ->name('lowongan.destroy');

    Route::get('/lowongan/{lowongan}/laporan', [SawController::class, 'laporan']
        )->name('laporan.index');

    Route::post('/lowongan/{lowongan}/screening', [SawController::class, 'hitung']
        )->name('kandidat.screening');

    Route::get('/lowongan/{lowongan}/laporan/pdf',[SawController::class, 'exportPdf']
        )->name('laporan.pdf');

    Route::get('/lowongan/{lowongan}/laporan/excel',[SawController::class, 'exportExcel']
        )->name('laporan.excel');

    /* ===== DESKRIPSI LOWONGAN ===== */
    Route::get('/lowongan/{lowongan}/deskripsi',
        [LowonganController::class, 'createDeskripsi']
    )->name('lowongan.deskripsi.create');

    Route::put('/lowongan/{lowongan}/deskripsi',
        [LowonganController::class, 'updateDeskripsi']
    )->name('lowongan.deskripsi.update');

    Route::post('/skills', [SkillController::class, 'store']);
    Route::put('/skills/{skill}', [SkillController::class, 'update']);
    Route::delete('/skills/{skill}', [SkillController::class, 'destroy']);

    Route::post('/bidang-kerja', [BidangKerjaController::class, 'store']);
    Route::put('/bidang-kerja/{bidangKerja}', [BidangKerjaController::class, 'update']);
    Route::delete('/bidang-kerja/{bidangKerja}', [BidangKerjaController::class, 'destroy']);

    Route::put('/hrd/lowongan/{lowongan}/kandidat/{application}/lolos-administrasi',[KandidatController::class, 'lolosAdministrasi']
    )->name('kandidat.lolos_administrasi');

    Route::get(
    '/hrd/lowongan/{lowongan}/seleksi',
    [SawController::class, 'index']
    )->name('seleksi.index');

    Route::post(
        '/hrd/lowongan/{lowongan}/seleksi/hitung',
        [SawController::class, 'hitung']
    )->name('seleksi.hitung');

    Route::put('/hrd/lowongan/{lowongan}/seleksi/reset',
    [SawController::class, 'reset']
)->name('seleksi.reset');


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

        Route::get('/monitoring', [MonitoringController::class, 'index'])
            ->name('monitoring');

        Route::get('/monitoring/data', [MonitoringController::class, 'data'])
            ->name('monitoring.data');
            
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

        Route::get('/monitoring', [MonitoringController::class, 'index'])
            ->name('admin.monitoring');

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

Route::get('/log-test', function () {
    Log::info('INI LOG TEST BARU DARI /log-test');
    return 'OK';
});