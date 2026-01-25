<?php

namespace App\Http\Controllers\Hrd;

use App\Http\Controllers\Controller;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\OfferLetterMail;

class LamaranHrdController extends Controller
{
    public function index()
    {
        $applications = Application::with(['user','lowongan'])
            ->whereHas('lowongan', function ($q) {
                $q->where('hrd_id', auth()->id());
            })
            ->latest()
            ->get();

        return view('hrd.lamaran', compact('applications'));
    }

    public function update(Request $request, Application $application)
{
    abort_if($application->lowongan->hrd_id !== auth()->id(), 403);

    $request->validate([
        'status' => 'required|in:diproses,screening,diterima,ditolak'
    ]);

    // ❗ Cegah timpa hasil SAW / Interview
    if (in_array($application->status, ['interview', 'offer']) &&
        in_array($request->status, ['screening', 'seleksi'])) {
        return back()->with('error', 'Status tidak valid.');
    }

    $application->update([
        'status' => $request->status
    ]);

    return back()->with('success', 'Status lamaran diperbarui');
}

    public function setInterview(Request $request, Application $application)
{
    abort_if($application->lowongan->hrd_id !== auth()->id(), 403);

    // ❗ hanya boleh jika hasil SAW & status interview
    if ($application->status !== 'interview') {
        return back()->with('error', 'Kandidat belum berada pada tahap interview.');
    }

    $data = $request->validate([
        'interview_method' => 'required|in:online,offline',
        'interview_at'     => 'required|date',
        'interview_link'   => 'nullable|string',
    ]);

    $application->update([
        'interview_method' => $data['interview_method'],
        'interview_at'     => $data['interview_at'],
        'interview_link'   => $data['interview_link'],
    ]);

    return back()->with('success', 'Jadwal interview berhasil disimpan');
}


    public function deleteInterview(Application $application)
{
    // 🔐 pastikan HRD pemilik
    abort_if($application->lowongan->hrd_id !== auth()->id(), 403);

    // ❗ HANYA HAPUS JADWAL, JANGAN UBAH STATUS
    $application->update([
        'interview_method' => null,
        'interview_at'     => null,
        'interview_link'   => null,
        // ❌ JANGAN SENTUH STATUS
    ]);

    return back()->with('success', 'Jadwal interview berhasil dihapus');
}


    public function uploadOffer(Request $request, Application $application)
    {
        // 🧪 LOG MASUK CONTROLLER
    logger()->info('MASUK UPLOAD OFFER', [
        'application_id' => $application->id
    ]);
        // pastikan HRD pemilik lowongan
        abort_if($application->lowongan->hrd_id !== auth()->id(), 403);

        // hanya boleh dari interview
        abort_if($application->status !== 'interview', 403);

        $request->validate([
            'offer_file' => 'required|url',
        ]);

        $application->update([
            'offer_file' => $request->offer_file, // ISI LINK
            'status'     => 'offer',
        ]);

        // 📧 KIRIM EMAIL (LOG MODE)
    Mail::to($application->user->email)
        ->send(new OfferLetterMail($application));

    logger()->info('EMAIL OFFER DITULIS KE LOG');

        return back()->with('success', 'Offer berhasil dikirim ke pelamar');
    }

}
