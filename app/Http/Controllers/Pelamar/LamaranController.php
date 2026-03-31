<?php

namespace App\Http\Controllers\Pelamar;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Lowongan;
use Illuminate\Http\Request;
use Carbon\Carbon;

class LamaranController extends Controller
{
    public function index()
    {
        $applications = Application::with('lowongan')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('pelamar.lamaran-index', compact('applications'));
    }

    //Menampilkan detail lamaran tertentu
    public function show(Application $application)
    {
        abort_if($application->user_id !== auth()->id(), 403);

        return view('pelamar.lamaran', compact('application'));
    }

    //Digunakan untuk melamar pekerjaan sekaligus menyimpan snapshot data pelamar
    public function store(Lowongan $lowongan)
    {
        $user = auth()->user();

        abort_if($lowongan->status !== 'aktif', 403);

        if (!$user->isProfileComplete()) {
            return redirect()
                ->route('pelamar.profile')
                ->with('error', 'Lengkapi profil terlebih dahulu');
        }

        $existing = Application::where('user_id', $user->id)
            ->whereIn('status', [
                'diproses',
                'screening',
                'seleksi',
                'interview',
                'offer',
            ])
            ->exists();

        if ($existing) {
            return back()->with(
                'error',
                'Kamu masih memiliki lamaran yang sedang diproses.'
            );
        }

        $user->load([
            'pelamarProfile',
            'pelamarExperiences',
            'pelamarEducations',
            'pelamarSkills.skill',
            'pelamarCertificates',
            'pelamarOrganizations',
            'pelamarAchievements',
            'pelamarResume',
        ]);

        $profile = $user->pelamarProfile;

        //SNAPSHOT DATA PELAMAR Digunakan agar data tidak berubah saat proses seleksi

        $snap_experiences = $user->pelamarExperiences->map(function ($exp) {
            return [
                'posisi' => $exp->posisi,
                'perusahaan' => $exp->perusahaan,
                'tanggal_mulai' => Carbon::parse($exp->tanggal_mulai)->translatedFormat('F Y'),
                'tanggal_selesai' => $exp->tanggal_selesai
                    ? Carbon::parse($exp->tanggal_selesai)->translatedFormat('F Y')
                    : null,
                'masih_bekerja' => $exp->masih_bekerja,
                'deskripsi' => $exp->deskripsi,
                'file_bukti' => $exp->file_bukti,
            ];
        })->toArray();

        $snap_educations = $user->pelamarEducations->map(function ($edu) {
            return [
                'nama_sekolah' => $edu->nama_sekolah,
                'tingkat' => $edu->tingkat,
                'bidang_studi' => $edu->bidang_studi,
                'periode' =>
                    Carbon::create()->month($edu->mulai_bulan)->translatedFormat('F')
                    .' '.$edu->mulai_tahun.' - '.
                    Carbon::create()->month($edu->selesai_bulan)->translatedFormat('F')
                    .' '.$edu->selesai_tahun,
                'informasi_tambahan' => $edu->informasi_tambahan,
                'file_bukti' => $edu->file_bukti,
            ];
        })->toArray();

        $snap_skills = $user->pelamarSkills
            ->map(fn($s) => $s->skill?->nama_skill)
            ->filter()
            ->values()
            ->toArray();

        $snap_certificates = $user->pelamarCertificates->map(function ($cert) {
            return [
                'nama_sertifikat' => $cert->nama_sertifikat,
                'organisasi_penerbit'  => $cert->organisasi_penerbit, 
                'terbit' =>
                    Carbon::create()->month($cert->bulan_terbit)->translatedFormat('F')
                    .' '.$cert->tahun_terbit,
                'expired' => $cert->tanpa_expired
                    ? 'Tidak ada batas waktu'
                    : Carbon::create()->month($cert->bulan_expired)->translatedFormat('F')
                        .' '.$cert->tahun_expired,
                'informasi_tambahan' => $cert->informasi_tambahan,
                'file_bukti' => $cert->file_bukti,
            ];
        })->toArray();

        $snap_organizations = $user->pelamarOrganizations->map(function ($org) {
            return [
                'nama_organisasi' => $org->nama_organisasi,
                'posisi' => $org->posisi,
                'periode' => 
                    Carbon::create()->month($org->mulai_bulan)->translatedFormat('F')
                    .' '.$org->mulai_tahun.' - '.
                    ($org->masih_aktif
                        ? 'Sekarang'
                        : Carbon::create()->month($org->selesai_bulan)->translatedFormat('F')
                            .' '.$org->selesai_tahun),
                'informasi_tambahan' => $org->informasi_tambahan,
                'file_bukti' => $org->file_bukti,
            ];
        })->toArray();

        $snap_achievements = $user->pelamarAchievements->map(function ($ach) {
            return [
                'judul' => $ach->judul,
                'penyelenggara' => $ach->penyelenggara, 
                'tahun' => $ach->tahun,
                'deskripsi' => $ach->deskripsi,
                'file_bukti' => $ach->file_bukti,
            ];
        })->toArray();

        $snap_resume = $user->pelamarResume
            ? [
                'file_path' => $user->pelamarResume->file_path,
                'file_name' => $user->pelamarResume->file_name,
                'file_size' => $user->pelamarResume->file_size,
            ]
            : null;

        Application::create([
            'user_id'     => $user->id,
            'lowongan_id' => $lowongan->id,
            'status'      => 'diproses',

            // SNAP IDENTITAS
            'snap_name'   => $user->name,
            'snap_email'  => $user->email,
            'snap_phone'  => $profile->phone,
            'snap_location'=> $profile->location,
            'snap_age'    => $profile->age,
            'snap_gender' => $profile->gender,
            'snap_last_education'=> $profile->last_education,
            'snap_photo'  => $profile->photo,
            'snap_about'  => $profile->tentang_saya,

            // SNAP SAW
            'snap_pendidikan_nilai' => $user->nilaiPendidikanTerakhir(),
            'snap_pengalaman_tahun' => $user->totalPengalamanTahun(),
            'snap_total_skill'      => count($snap_skills),

            // SNAP DETAIL
            'snap_experiences'   => $snap_experiences,
            'snap_educations'    => $snap_educations,
            'snap_skills'        => $snap_skills,
            'snap_certificates'  => $snap_certificates,
            'snap_organizations' => $snap_organizations,
            'snap_achievements'  => $snap_achievements,
            'snap_resume'        => $snap_resume,
        ]);

        return back()->with('success', 'Lamaran berhasil dikirim.');
    }

    //Digunakan untuk merespon offering (diterima / ditolak)
    public function offerResponse(Request $request, Application $application)
    {
        abort_if($application->user_id !== auth()->id(), 403);
        abort_if($application->status !== 'offer', 403);

        $request->validate([
            'response' => 'required|in:diterima,ditolak'
        ]);

        $status = match ($request->response) {
            'diterima' => 'diterima',
            'ditolak'  => 'offer_ditolak',
        };

        $application->update([
            'offer_response' => $request->response,
            'status'         => $status,
        ]);

        return back()->with('success', 'Keputusan berhasil dikirim.');
    }
}
