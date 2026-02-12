<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Application;
use Barryvdh\DomPDF\Facade\Pdf;

class CvController extends Controller
{
    public function download(User $user)
    {
        $auth = auth()->user();

        //Pelamar Download CV Live
        if ($auth->role === 'pelamar') {

            abort_if($auth->id !== $user->id, 403);

            $user->load([
                'pelamarProfile',
                'pelamarExperiences',
                'pelamarEducations',
                'pelamarSkills.skill',
                'pelamarCertificates',
                'pelamarOrganizations',
                'pelamarAchievements',
            ]);

            return Pdf::loadView('cv.template', compact('user'))
                ->setPaper('A4', 'portrait')
                ->stream('CV-'.$user->name.'.pdf');
        }

        //HRD Download CV Snapshot
        if ($auth->role === 'hrd') {

            $application = Application::where('user_id', $user->id)
                ->whereHas('lowongan', function ($q) use ($auth) {
                    $q->where('hrd_id', $auth->id);
                })
                ->latest()
                ->first();

            abort_if(!$application, 403);

            return Pdf::loadView('cv.template-snapshot', compact('application'))
                ->setPaper('A4', 'portrait')
                ->stream('CV-'.$application->snap_name.'.pdf');
        }

        abort(403);
    }
}
