<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Application;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AccountSettingsController;
use App\Http\Controllers\CvController;

use App\Http\Controllers\Public\JobController;

use App\Http\Controllers\Pelamar\LamaranController;

use App\Http\Controllers\Hrd\DashboardController;
use App\Http\Controllers\Hrd\LowonganController;
use App\Http\Controllers\Hrd\KandidatController;
use App\Http\Controllers\Hrd\SawController;
use App\Http\Controllers\Hrd\SkillController;
use App\Http\Controllers\Hrd\BidangKerjaController;
use App\Http\Controllers\Hrd\ReportController as HrdReportController;

use App\Http\Controllers\Admin\ManajemenAkunController;
use App\Http\Controllers\Admin\UsersPdfController;
use App\Http\Controllers\Admin\MonitoringController;
use App\Http\Controllers\Admin\LowonganMonitoringController;
use App\Http\Controllers\Admin\ReportController;

use App\Exports\UsersExport;

/* ================= PUBLIC ================= */

Route::get('/', fn () => view('public.home'))->name('public.home');

/* ===== LOWONGAN ===== */
Route::get('/lowongan', [JobController::class, 'index'])->name('jobs.index');
Route::get('/lowongan/{lowongan}', [JobController::class, 'show'])->name('jobs.show');

Route::get('/tentang-kami', fn () => view('public.about'))->name('about');

/* ===== FILE UPLOAD ===== */
Route::get('/file-upload', [App\Http\Controllers\UploadController::class, 'create'])->name('file-upload.create');
Route::post('/file-upload', [App\Http\Controllers\UploadController::class, 'store'])->name('file-upload.store');
/* ================= REDIRECT LOGIN ================= */

Route::get('/redirect-after-login', function (Request $request) {

    $user = $request->user();

    return match ($user->role) {
        'admin' => redirect('/admin/dashboard'),
        'hrd'   => redirect('/hrd/dashboard'),
        default => redirect('/pelamar/profile'),
    };

})->middleware('auth');

Route::middleware(['auth'])->group(function () {
    Route::get('/cv/{user}', [CvController::class, 'download'])
        ->name('cv.download');
});

/* ================= PELAMAR ================= */

Route::middleware(['auth', 'role:pelamar'])
    ->prefix('pelamar')
    ->name('pelamar.')
    ->group(function () {

        Route::get('/profile', [ProfileController::class, 'index'])
            ->name('profile');

        Route::get('/lamaran', [LamaranController::class, 'index'])
        ->name('lamaran.index');
        
        Route::get('/lamaran/{application}', [LamaranController::class, 'show'])
        ->name('lamaran.show');

        Route::post('/lamar/{lowongan}', [LamaranController::class, 'store'])
        ->name('lamar.store');

        Route::post('/lamaran/{application}/offer-response',
            [LamaranController::class, 'offerResponse']
        )->name('offer.response');

        // Data diri
        Route::post('/profile/data-diri', [ProfileController::class, 'updateDataDiri'])->name('pelamar.profile.data-diri');
        Route::post('/profile/tentang-saya', [ProfileController::class, 'updateTentangSaya'])->name('profile.tentang-saya');

        // Experience
        Route::post('/profile/experiences', [ProfileController::class, 'storeExperience']);
        Route::put('/profile/experiences/{id}', [ProfileController::class, 'updateExperience']);
        Route::delete('/profile/experiences/{id}', [ProfileController::class, 'deleteExperience']);

        // Education
        Route::post('/profile/educations', [ProfileController::class, 'storeEducation']);
        Route::put('/profile/educations/{id}', [ProfileController::class, 'updateEducation']);
        Route::delete('/profile/educations/{id}', [ProfileController::class, 'deleteEducation']);

        // Skills
        Route::post('/profile/skills', [ProfileController::class, 'storeSkill']);
        Route::delete('/profile/skills/{id}', [ProfileController::class, 'deleteSkill']);

        // Resume
        Route::post('/profile/resume', [ProfileController::class, 'uploadResume']);
        Route::delete('/profile/resume', [ProfileController::class, 'deleteResume']);

        // Certificate
        Route::post('/profile/certificates', [ProfileController::class, 'storeCertificate']);
        Route::put('/profile/certificates/{id}', [ProfileController::class, 'updateCertificate']);
        Route::delete('/profile/certificates/{id}', [ProfileController::class, 'deleteCertificate']);

        // Organization
        Route::post('/profile/organizations', [ProfileController::class, 'storeOrganization']);
        Route::put('/profile/organizations/{id}', [ProfileController::class, 'updateOrganization']);
        Route::delete('/profile/organizations/{id}', [ProfileController::class, 'deleteOrganization']);

        // Achievement
        Route::post('/profile/achievements', [ProfileController::class, 'storeAchievement']);
        Route::put('/profile/achievements/{id}', [ProfileController::class, 'updateAchievement']);
        Route::delete('/profile/achievements/{id}', [ProfileController::class, 'deleteAchievement']);

    });

/* ================= HRD ================= */

Route::middleware(['auth', 'role:hrd'])
    ->prefix('hrd')
    ->name('hrd.')
    ->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/data', [DashboardController::class, 'data'])->name('dashboard.data');

    // Kandidat
        Route::get('/lowongan/{lowongan}/kandidat', [KandidatController::class, 'index'])->name('kandidat.index');
        Route::get('/lowongan/{lowongan}/kandidat/{application}', [KandidatController::class, 'show'])->name('kandidat.detail');
        Route::put('/lowongan/{lowongan}/kandidat/{application}/status', [KandidatController::class, 'updateStatus'])->name('kandidat.status');
        Route::put('/lowongan/{lowongan}/kandidat/{application}/interview', [KandidatController::class, 'setInterview'])->name('kandidat.interview');
        Route::delete('/lowongan/{lowongan}/kandidat/{application}/interview', [KandidatController::class, 'deleteInterview'])->name('kandidat.interview.delete');
        Route::post('/lowongan/{lowongan}/kandidat/{application}/offer', [KandidatController::class, 'uploadOffer'])->name('kandidat.offer');
        Route::put('/lowongan/{lowongan}/kandidat/{application}/lolos-administrasi', [KandidatController::class, 'lolosAdministrasi'])->name('kandidat.lolos_administrasi');
        Route::put('/lowongan/{lowongan}/kandidat/{application}/tolak-administrasi', [KandidatController::class, 'tolakAdministrasi'])->name('kandidat.tolak_administrasi');

    // Lowongan
    Route::get('/lowongan', [LowonganController::class, 'index'])->name('lowongan.index');
    Route::get('/lowongan/create', [LowonganController::class, 'create'])->name('lowongan.create');
    Route::post('/lowongan', [LowonganController::class, 'store'])->name('lowongan.store');

    Route::get('/lowongan/{lowongan}', [LowonganController::class, 'show'])->name('lowongan.show');
    Route::get('/lowongan/{lowongan}/edit', [LowonganController::class, 'edit'])->name('lowongan.edit');
    Route::put('/lowongan/{lowongan}', [LowonganController::class, 'update'])->name('lowongan.update');
    Route::delete('/lowongan/{lowongan}', [LowonganController::class, 'destroy'])->name('lowongan.destroy');

    Route::post('/lowongan/{lowongan}/status', [LowonganController::class, 'updateStatus'])
        ->name('lowongan.status');

    // Deskripsi lowongan
    Route::get('/lowongan/{lowongan}/deskripsi', [LowonganController::class, 'createDeskripsi'])
        ->name('lowongan.deskripsi.create');

    Route::put('/lowongan/{lowongan}/deskripsi', [LowonganController::class, 'updateDeskripsi'])
        ->name('lowongan.deskripsi.update');

    // Laporan lowongan
    Route::get('/lowongan/{lowongan}/laporan', [SawController::class, 'laporan'])
        ->name('laporan.index');

    Route::get('/lowongan/{lowongan}/laporan/pdf', [SawController::class, 'exportPdf'])
        ->name('laporan.pdf');

    Route::get('/lowongan/{lowongan}/laporan/excel', [SawController::class, 'exportExcel'])
        ->name('laporan.excel');

    // Seleksi SAW
    Route::get('/lowongan/{lowongan}/seleksi', [SawController::class, 'index'])
        ->name('seleksi.index');

    Route::post('/lowongan/{lowongan}/seleksi/hitung', [SawController::class, 'hitung'])
        ->name('seleksi.hitung');

    Route::put('/lowongan/{lowongan}/seleksi/reset', [SawController::class, 'reset'])
        ->name('seleksi.reset');

    // Master data
    Route::post('/skills', [SkillController::class, 'store']);
    Route::put('/skills/{skill}', [SkillController::class, 'update']);
    Route::delete('/skills/{skill}', [SkillController::class, 'destroy']);

    Route::post('/bidang-kerja', [BidangKerjaController::class, 'store']);
    Route::put('/bidang-kerja/{bidangKerja}', [BidangKerjaController::class, 'update']);
    Route::delete('/bidang-kerja/{bidangKerja}', [BidangKerjaController::class, 'destroy']);

    // Report HRD
    Route::get('/report', [HrdReportController::class, 'index'])->name('report.index');
    Route::get('/report/pdf', [HrdReportController::class, 'exportPdf'])->name('report.pdf');
    Route::get('/report/excel', [HrdReportController::class, 'exportExcel'])->name('report.excel');

});

/* ================= ADMIN ================= */

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', fn () => view('admin.dashboard'))
            ->name('dashboard');

        // Monitoring
        Route::get('/monitoring', [MonitoringController::class, 'index'])
            ->name('monitoring');

        Route::get('/monitoring/data', [MonitoringController::class, 'data'])
            ->name('monitoring.data');

        Route::get('/monitoring/lowongan', [LowonganMonitoringController::class, 'index'])
            ->name('monitoring.lowongan');

        Route::get('/monitoring/lowongan/{lowongan}', [LowonganMonitoringController::class, 'show'])
            ->name('monitoring.lowongan.detail');

        // Manajemen akun
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

        // Report
        Route::get('/report', [ReportController::class, 'index'])
            ->name('report.index');

        Route::get('/report/pdf', [ReportController::class, 'exportPdf'])
            ->name('report.pdf');

        Route::get('/report/excel', [ReportController::class, 'exportExcel'])
            ->name('report.excel');
    });

/* ================= AUTH ================= */

require __DIR__.'/auth.php';

/* ================= ACCOUNT SETTINGS ================= */

Route::middleware('auth')->group(function () {
    Route::get('/pengaturan-akun', [AccountSettingsController::class, 'index'])->name('account.settings');
    Route::post('/pengaturan-akun/password', [AccountSettingsController::class, 'updatePassword'])->name('account.password.update');
});

/* ================= DEBUG ================= */

Route::get('/log-test', function () {
    Log::info('INI LOG TEST BARU DARI /log-test');
    return 'OK';
});

Route::middleware(['auth', 'role:hrd'])
    ->prefix('hrd')
    ->name('hrd.')
    ->group(function () {

        Route::get('/status-lamaran', function () {
            $applications = Application::with(['user','lowongan'])
                ->orderBy('created_at', 'desc')
                ->get();

            return view('hrd.status-lamaran', compact('applications'));
        })->name('status.lamaran');

        Route::put('/status-lamaran/{application}', function (Request $request, Application $application) {

            $request->validate([
                'status' => 'required|string'
            ]);

            $application->update([
                'status' => $request->status
            ]);

            return back()->with('success', 'Status berhasil diubah.');
        })->name('status.update');

    });