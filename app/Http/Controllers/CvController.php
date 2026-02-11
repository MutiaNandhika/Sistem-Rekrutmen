<?php

namespace App\Http\Controllers;

use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;

class CvController extends Controller
{
    public function download(User $user)
    {
        $auth = auth()->user();

        if ($auth->role === 'pelamar' && $auth->id !== $user->id) {
            abort(403, 'Anda tidak diizinkan mengakses CV ini.');
        }

        if ($auth->role === 'hrd') {

            $boleh = $user->applications()
                ->whereHas('lowongan', function ($q) use ($auth) {
                    $q->where('hrd_id', $auth->id);
                })
                ->exists();

            if (! $boleh) {
                abort(403, 'CV tidak terkait dengan lowongan Anda.');
            }
        }

        $user->load([
            'pelamarProfile',
            'pelamarExperiences',
            'pelamarEducations',
            'pelamarSkills',
            'pelamarCertificates',
            'pelamarOrganizations',
        ]);

        return Pdf::loadView('cv.template', compact('user'))
            ->setPaper('A4', 'portrait')
            ->stream('CV-' . $user->name . '.pdf');
    }
}
