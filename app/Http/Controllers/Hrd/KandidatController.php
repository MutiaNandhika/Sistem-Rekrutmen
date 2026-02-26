<?php

namespace App\Http\Controllers\Hrd;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Lowongan;
use Illuminate\Http\Request;
use App\Mail\StatusLamaranMail;
use Illuminate\Support\Facades\Mail;

class KandidatController extends Controller
{
    public function index(Request $request, Lowongan $lowongan)
    {
        $isOwner = $lowongan->hrd_id === auth()->id();

        $query = Application::with([
                'user.pelamarProfile',
                'user.pelamarEducations',
                'user.pelamarExperiences',
                'user.pelamarSkills',
            ])
            ->where('lowongan_id', $lowongan->id)
            ->orderBy('created_at', 'asc');

        if ($request->filled('status')) {

            if ($request->status === 'ditolak') {
                $query->whereIn('status', [
                    'ditolak',
                    'tidak_lolos_saw',
                    'ditolak_administrasi',
                ]);
            } else {
                $query->where('status', $request->status);
            }
        }

        $kandidats = $query->get();

        return view('hrd.kandidat.index', [
            'lowongan'  => $lowongan,
            'kandidats' => $kandidats,
            'isOwner'   => $isOwner,
        ]);
    }

    public function show(Lowongan $lowongan, Application $application)
    {
        $isOwner = $lowongan->hrd_id === auth()->id();

        abort_if($application->lowongan_id !== $lowongan->id, 404);

        $application->load([
            'user.pelamarProfile',
            'user.pelamarEducations',
            'user.pelamarSkills',
            'user.pelamarExperiences',
            'user.pelamarAchievements',
            'user.pelamarCertificates',
            'user.pelamarResume',
        ]);

        return view('hrd.kandidat.detail', [
            'lowongan'    => $lowongan,
            'application' => $application,
            'isOwner'     => $isOwner,
        ]);
    }

    public function updateStatus(Request $request, Lowongan $lowongan, Application $application)
    {
        abort_if($lowongan->hrd_id !== auth()->id(), 403);
        abort_if($application->lowongan_id !== $lowongan->id, 404);

        $request->validate([
            'status' => 'required|in:diproses,screening,seleksi,interview,offer,diterima,ditolak'
        ]);

        $oldStatus = $application->status;

        if (
            in_array($oldStatus, ['interview','offer']) &&
            in_array($request->status, ['screening','seleksi'])
        ) {
            return back()->with('error', 'Perubahan status tidak valid.');
        }

        $application->update([
            'status' => $request->status
        ]);

        if ($oldStatus !== $request->status) {
            Mail::to($application->user->email)
                ->queue(
                    (new StatusLamaranMail($application))
                        ->delay(now()->addSeconds(5))
                );
        }

        return back()->with('success', 'Status lamaran diperbarui & email terkirim.');
    }

    public function setInterview(Request $request, Lowongan $lowongan, Application $application)
    {
        abort_if($lowongan->hrd_id !== auth()->id(), 403);
        abort_if($application->lowongan_id !== $lowongan->id, 404);

        if ($application->status !== 'interview') {
            return back()->with('error', 'Kandidat belum berada pada tahap interview.');
        }

        $data = $request->validate([
            'interview_method' => 'required|in:online,offline',
            'interview_at'     => 'required|date',
            'interview_link'   => 'nullable|string',
        ]);

        $application->update($data);

        return back()->with('success', 'Jadwal interview berhasil disimpan');
    }

    public function deleteInterview(Lowongan $lowongan, Application $application)
    {
        abort_if($lowongan->hrd_id !== auth()->id(), 403);
        abort_if($application->lowongan_id !== $lowongan->id, 404);

        $application->update([
            'interview_method' => null,
            'interview_at'     => null,
            'interview_link'   => null,
        ]);

        return back()->with('success', 'Jadwal interview berhasil dihapus');
    }

    public function uploadOffer(Request $request, Lowongan $lowongan, Application $application)
    {
        abort_if($lowongan->hrd_id !== auth()->id(), 403);
        abort_if($application->lowongan_id !== $lowongan->id, 404);
        abort_if($application->status !== 'interview', 403);

        $request->validate([
            'offer_file' => 'required|url',
        ]);

        $application->update([
            'offer_file' => $request->offer_file,
            'status'     => 'offer',
        ]);

        Mail::to($application->user->email)
            ->queue(
                (new StatusLamaranMail($application))
                    ->delay(now()->addSeconds(5))
            );

        return back()->with('success', 'Offer berhasil dikirim ke pelamar');
    }

    public function lolosAdministrasi(Lowongan $lowongan, Application $application)
    {
        abort_if($lowongan->hrd_id !== auth()->id(), 403);
        abort_if($application->lowongan_id !== $lowongan->id, 404);

        if ($application->status !== 'screening') {
            return back()->with('error', 'Kandidat tidak berada pada tahap screening.');
        }

        $oldStatus = $application->status;

        $application->update([
            'status' => 'seleksi',
        ]);

        if ($oldStatus !== 'seleksi') {
            Mail::to($application->user->email)
                ->queue(
                    (new StatusLamaranMail($application))
                        ->delay(now()->addSeconds(5))
                );
        }

        return back()->with('success', 'Kandidat berhasil lolos administrasi.');
    }

    public function tolakAdministrasi(Lowongan $lowongan, Application $application)
    {
        abort_if($lowongan->hrd_id !== auth()->id(), 403);
        abort_if($application->lowongan_id !== $lowongan->id, 404);

        if ($application->status !== 'screening') {
            return back()->with('error', 'Kandidat tidak berada pada tahap screening.');
        }

    $oldStatus = $application->status;

    $application->update([
        'status' => 'ditolak_administrasi',
    ]);

    if ($oldStatus !== 'ditolak_administrasi') {
        Mail::to($application->user->email)
            ->queue(
                (new StatusLamaranMail($application))
                    ->delay(now()->addSeconds(5))
            );
    }

        return back()->with('success', 'Kandidat ditolak pada tahap administrasi.');
    }
}
