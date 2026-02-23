<?php

namespace App\Http\Controllers;

use App\Models\PelamarProfile;
use App\Models\PelamarExperience;
use App\Models\PelamarEducation;
use App\Models\PelamarSkill;
use App\Models\PelamarResume;
use App\Models\PelamarCertificate;
use App\Models\PelamarOrganization;
use App\Models\PelamarAchievement;
use App\Models\User;
use App\Models\Skill;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $user->pelamarProfile()->firstOrCreate([
            'user_id' => $user->id,
        ]);

        $user->load([
            'pelamarProfile',
            'pelamarExperiences',
            'pelamarEducations',
            'pelamarSkills',
            'pelamarResume',
            'pelamarCertificates',
            'pelamarOrganizations',
            'pelamarAchievements',
        ]);

        return view('pelamar.profile', compact('user'));
    }

    public function updateDataDiri(Request $request)
    {
        $request->validate([
            'name'            => 'required|string|max:255',
            'phone'           => 'nullable|string|max:30',
            'location'        => 'nullable|string|max:255',
            'age'             => 'nullable|integer',
            'gender'          => 'nullable|in:Laki-laki,Perempuan',
            'last_education'  => 'nullable|string|max:255',
            'photo'           => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'remove_photo'    => 'nullable|boolean',
        ]);

        $user = Auth::user();

        $user->update([
            'name' => $request->name,
        ]);

        $profile = $user->pelamarProfile()->firstOrCreate([
            'user_id' => $user->id,
        ]);

        $photoPath = $profile->photo;

        if ($request->remove_photo == 1) {
            if ($photoPath && Storage::exists($photoPath)) {
                Storage::delete($photoPath);
            }
            $photoPath = null;
        }

        if ($request->hasFile('photo')) {

            $photoPath = $request->file('photo')
                ->storePublicly('avatars', 's3');

            $profile->photo = $photoPath;
        }

        $profile->update([
            'phone'          => $request->phone,
            'location'       => $request->location,
            'age'            => $request->age,
            'gender'         => $request->gender,
            'last_education' => $request->last_education,
            'photo'          => $photoPath,
        ]);

        return response()->json([
        'message'   => 'Data diri berhasil disimpan',
        'photo_url' => $photoPath
            ? Storage::disk('s3')->temporaryUrl($photoPath, now()->addMinutes(60))
            : asset('images/default-avatar.png'),
    ]);
    }

    public function updateTentangSaya(Request $request)
    {
        $request->validate([
            'tentang_saya' => 'nullable|string|max:2600',
        ]);

        $user = Auth::user();

        $profile = $user->pelamarProfile()->firstOrCreate([
            'user_id' => $user->id,
        ]);

        $profile->update([
            'tentang_saya' => $request->tentang_saya,
        ]);

        return response()->json([
            'message' => 'Tentang saya berhasil disimpan',
            'tentang_saya' => $profile->tentang_saya,
        ]);
    }

    // Experience
    public function storeExperience(Request $request)
    {
        $data = $request->validate([
            'posisi' => 'required|string|max:255',
            'perusahaan' => 'required|string|max:255',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'nullable|date',
            'masih_bekerja' => 'nullable|boolean',
            'deskripsi' => 'nullable|string',
            'file_bukti' => 'required|file|mimes:pdf,jpg,jpeg,png|max:4096',
        ]);

        $data['user_id'] = Auth::id();
        $data['masih_bekerja'] = $request->boolean('masih_bekerja');

        if ($data['masih_bekerja']) {
            $data['tanggal_selesai'] = null;
        }

        $data['file_bukti'] = $request->file('file_bukti')
            ->store('experience_files');

        PelamarExperience::create($data);

        return response()->json([
            'message' => 'Pengalaman berhasil ditambahkan'
        ]);
    }

    public function updateExperience(Request $request, $id)
    {
        $exp = PelamarExperience::where('user_id', Auth::id())
            ->where('id', $id)
            ->firstOrFail();

        $data = $request->validate([
            'posisi' => 'required|string|max:255',
            'perusahaan' => 'required|string|max:255',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'nullable|date',
            'masih_bekerja' => 'nullable|boolean',
            'deskripsi' => 'nullable|string',
            'file_bukti' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:4096',
        ]);

        $data['masih_bekerja'] = $request->boolean('masih_bekerja');

        if ($data['masih_bekerja']) {
            $data['tanggal_selesai'] = null;
        }

        if ($request->hasFile('file_bukti')) {
            if ($exp->file_bukti && Storage::exists($exp->file_bukti)) {
                Storage::delete($exp->file_bukti);
            }

            $data['file_bukti'] = $request->file('file_bukti')
                ->store('experience_files');
        }

        $exp->update($data);

        return response()->json([
            'message' => 'Pengalaman kerja berhasil diperbarui'
        ]);
    }

    public function deleteExperience($id)
    {
        $exp = PelamarExperience::where('user_id', Auth::id())
            ->where('id', $id)
            ->firstOrFail();

        if ($exp->file_bukti && Storage::exists($exp->file_bukti)) {
            Storage::delete($exp->file_bukti);
        }

        $exp->delete();

        return response()->json([
            'message' => 'Pengalaman kerja berhasil dihapus'
        ]);
    }

    //Education

    public function storeEducation(Request $request)
    {
        $data = $request->validate([
            'tingkat' => 'required',
            'nama_sekolah' => 'required',
            'bidang_studi' => 'required',
            'mulai_bulan' => 'required|integer|min:1|max:12',
            'mulai_tahun' => 'required|integer',
            'selesai_bulan' => 'required|integer|min:1|max:12',
            'selesai_tahun' => 'required|integer',
            'informasi_tambahan' => 'nullable|string',
            'file_bukti' => 'required|file|mimes:pdf,jpg,jpeg,png|max:4096',
        ]);

        $data['user_id'] = Auth::id();
        $data['file_bukti'] = $request->file('file_bukti')
            ->store('education_files');

        PelamarEducation::create($data);

        return response()->json([
            'message' => 'Pendidikan berhasil ditambahkan'
        ]);
    }

    public function updateEducation(Request $request, $id)
    {
        $edu = PelamarEducation::where('user_id', Auth::id())
            ->where('id', $id)
            ->firstOrFail();

        $data = $request->validate([
            'tingkat' => 'required',
            'nama_sekolah' => 'required',
            'bidang_studi' => 'required',
            'mulai_bulan' => 'required|integer|min:1|max:12',
            'mulai_tahun' => 'required|integer',
            'selesai_bulan' => 'required|integer|min:1|max:12',
            'selesai_tahun' => 'required|integer',
            'informasi_tambahan' => 'nullable|string',
            'file_bukti' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:4096',
        ]);

        if ($request->hasFile('file_bukti')) {
            if ($edu->file_bukti && Storage::exists($edu->file_bukti)) {
                Storage::delete($edu->file_bukti);
            }

            $data['file_bukti'] = $request->file('file_bukti')
                ->store('education_files');
        }

        $edu->update($data);

        return response()->json([
            'message' => 'Pendidikan berhasil diperbarui'
        ]);
    }

    public function deleteEducation($id)
    {
        $edu = PelamarEducation::where('user_id', Auth::id())
            ->where('id', $id)
            ->firstOrFail();

        if ($edu->file_bukti && Storage::exists($edu->file_bukti)) {
            Storage::delete($edu->file_bukti);
        }

        $edu->delete();

        return response()->json([
            'message' => 'Pendidikan berhasil dihapus'
        ]);
    }

    //Skills
    public function storeSkill(Request $request)
    {
        $request->validate([
            'skill_id'   => 'nullable|exists:skills,id',
            'nama_skill' => 'nullable|string|max:255',
        ]);

        if (!$request->skill_id && !$request->nama_skill) {
            return response()->json(['message' => 'Skill tidak valid'], 422);
        }

        $skill = $request->skill_id
            ? Skill::findOrFail($request->skill_id)
            : Skill::firstOrCreate(['nama_skill' => trim($request->nama_skill)]);

        $pelamarSkill = PelamarSkill::firstOrCreate([
            'user_id'  => Auth::id(),
            'skill_id' => $skill->id,
        ]);

        return response()->json([
            'message' => 'Skill berhasil disimpan',
            'data' => [
                'id' => $pelamarSkill->id,
                'nama_skill' => $skill->nama_skill
            ]
        ]);
    }

    public function deleteSkill($id)
    {
        $skill = PelamarSkill::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $skill->delete();

        return response()->json([
            'message' => 'Skill berhasil dihapus'
        ]);
    }

    //Resume
    public function uploadResume(Request $request)
    {
        $request->validate([
            'resume' => 'required|file|mimes:pdf|max:5120',
        ]);

        $userId = Auth::id();
        $file   = $request->file('resume');

        $old = PelamarResume::where('user_id', $userId)->first();

        if ($old && $old->file_path && Storage::exists($old->file_path)) {
            Storage::delete($old->file_path);
        }

        $path = $file->store('resumes');

        $resume = PelamarResume::updateOrCreate(
            ['user_id' => $userId],
            [
                'file_path'   => $path,
                'file_name'   => $file->getClientOriginalName(),
                'file_size'   => $file->getSize(),
                'uploaded_at' => now(),
            ]
        );

        return response()->json([
            'message'   => 'Resume berhasil diupload',
            'file_name' => $resume->file_name,
            'url' => Storage::disk('s3')->temporaryUrl(
                $resume->file_path,
                now()->addMinutes(60)
            ),
        ]);
    }

    public function deleteResume()
    {
        $userId = Auth::id();
        $resume = PelamarResume::where('user_id', $userId)->first();

        if ($resume) {
            if ($resume->file_path && Storage::exists($resume->file_path)) {
                Storage::delete($resume->file_path);
            }

            $resume->delete();
        }

        return response()->json([
            'message' => 'Resume berhasil dihapus'
        ]);
    }

    //Achievement

    public function storeAchievement(Request $request)
    {
        $data = $request->validate([
            'judul' => 'required|string|max:255',
            'penyelenggara' => 'required|string|max:255',
            'tahun' => 'required|integer',
            'deskripsi' => 'nullable|string',
            'file_bukti' => 'required|file|mimes:pdf,jpg,jpeg,png|max:4096',
        ]);

        $data['user_id'] = Auth::id();
        $data['file_bukti'] = $request->file('file_bukti')
            ->store('achievement_files');

        PelamarAchievement::create($data);

        return response()->json([
            'message' => 'Penghargaan berhasil ditambahkan'
        ]);
    }

    public function updateAchievement(Request $request, $id)
    {
        $award = PelamarAchievement::where('user_id', Auth::id())
            ->where('id', $id)
            ->firstOrFail();

        $data = $request->validate([
            'judul' => 'required|string|max:255',
            'penyelenggara' => 'required|string|max:255',
            'tahun' => 'required|integer',
            'deskripsi' => 'nullable|string',
            'file_bukti' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:4096',
        ]);

        if ($request->hasFile('file_bukti')) {
            if ($award->file_bukti && Storage::exists($award->file_bukti)) {
                Storage::delete($award->file_bukti);
            }

            $data['file_bukti'] = $request->file('file_bukti')
                ->store('achievement_files');
        }

        $award->update($data);

        return response()->json([
            'message' => 'Penghargaan berhasil diperbarui'
        ]);
    }

    public function deleteAchievement($id)
    {
        $award = PelamarAchievement::where('user_id', Auth::id())
            ->where('id', $id)
            ->firstOrFail();

        if ($award->file_bukti && Storage::exists($award->file_bukti)) {
            Storage::delete($award->file_bukti);
        }

        $award->delete();

        return response()->json([
            'message' => 'Penghargaan berhasil dihapus'
        ]);
    }

    //Certificate

    public function storeCertificate(Request $request)
    {
        $data = $request->validate([
            'nama_sertifikat' => 'required|string|max:255',
            'organisasi_penerbit' => 'required|string|max:255',
            'bulan_terbit' => 'required|integer|min:1|max:12',
            'tahun_terbit' => 'required|integer',
            'tanpa_expired' => 'nullable|boolean',
            'bulan_expired' => 'required_unless:tanpa_expired,1|nullable|integer|min:1|max:12',
            'tahun_expired' => 'required_unless:tanpa_expired,1|nullable|integer',
            'informasi_tambahan' => 'nullable|string',
            'file_bukti' => 'required|file|mimes:pdf,jpg,jpeg,png|max:4096',
        ]);

        $data['user_id'] = Auth::id();
        $data['tanpa_expired'] = $request->boolean('tanpa_expired');

        if ($data['tanpa_expired']) {
            $data['bulan_expired'] = null;
            $data['tahun_expired'] = null;
        }

        $data['file_bukti'] = $request->file('file_bukti')
            ->store('certificate_files');

        PelamarCertificate::create($data);

        return response()->json([
            'message' => 'Sertifikat berhasil ditambahkan'
        ]);
    }

    public function updateCertificate(Request $request, $id)
    {
        $cert = PelamarCertificate::where('user_id', Auth::id())
            ->where('id', $id)
            ->firstOrFail();

        $data = $request->validate([
            'nama_sertifikat' => 'required|string|max:255',
            'organisasi_penerbit' => 'required|string|max:255',
            'bulan_terbit' => 'required|integer|min:1|max:12',
            'tahun_terbit' => 'required|integer',
            'tanpa_expired' => 'nullable|boolean',
            'bulan_expired' => 'required_unless:tanpa_expired,1|nullable|integer|min:1|max:12',
            'tahun_expired' => 'required_unless:tanpa_expired,1|nullable|integer',
            'informasi_tambahan' => 'nullable|string',
            'file_bukti' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:4096',
        ]);

        $data['tanpa_expired'] = $request->boolean('tanpa_expired');

        if ($data['tanpa_expired']) {
            $data['bulan_expired'] = null;
            $data['tahun_expired'] = null;
        }

        if ($request->hasFile('file_bukti')) {
            if ($cert->file_bukti && Storage::exists($cert->file_bukti)) {
                Storage::delete($cert->file_bukti);
            }

            $data['file_bukti'] = $request->file('file_bukti')
                ->store('certificate_files');
        }

        $cert->update($data);

        return response()->json([
            'message' => 'Sertifikat berhasil diperbarui'
        ]);
    }

    public function deleteCertificate($id)
    {
        $user = Auth::user();

        $cert = PelamarCertificate::where('user_id', $user->id)
            ->where('id', $id)
            ->firstOrFail();

        $cert->delete();

        return response()->json([
            'message' => 'Sertifikat berhasil dihapus'
        ]);
    }

    //Organization

    public function storeOrganization(Request $request)
    {
        $data = $request->validate([
            'nama_organisasi' => 'required|string|max:255',
            'posisi'          => 'required|string|max:255',
            'mulai_bulan'     => 'required|integer|min:1|max:12',
            'mulai_tahun'     => 'required|integer',
            'masih_aktif'     => 'nullable|boolean',
            'selesai_bulan'   => 'required_unless:masih_aktif,1|nullable|integer|min:1|max:12',
            'selesai_tahun'   => 'required_unless:masih_aktif,1|nullable|integer',
            'informasi_tambahan' => 'nullable|string',
            'file_bukti'      => 'required|file|mimes:pdf,jpg,jpeg,png|max:4096',
        ]);

        $data['user_id'] = Auth::id();
        $data['masih_aktif'] = $request->boolean('masih_aktif');

        if ($data['masih_aktif']) {
            $data['selesai_bulan'] = null;
            $data['selesai_tahun'] = null;
        }

        $data['file_bukti'] = $request->file('file_bukti')
            ->store('organization_files');

        PelamarOrganization::create($data);

        return response()->json([
            'message' => 'Organisasi berhasil ditambahkan'
        ]);
    }

    public function updateOrganization(Request $request, $id)
    {
        $org = PelamarOrganization::where('user_id', Auth::id())
            ->where('id', $id)
            ->firstOrFail();

        $data = $request->validate([
            'nama_organisasi' => 'required|string|max:255',
            'posisi'          => 'required|string|max:255',
            'mulai_bulan'     => 'required|integer|min:1|max:12',
            'mulai_tahun'     => 'required|integer',
            'masih_aktif'     => 'nullable|boolean',
            'selesai_bulan'   => 'required_unless:masih_aktif,1|nullable|integer|min:1|max:12',
            'selesai_tahun'   => 'required_unless:masih_aktif,1|nullable|integer',
            'informasi_tambahan' => 'nullable|string',
            'file_bukti'      => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:4096',
        ]);

        $data['masih_aktif'] = $request->boolean('masih_aktif');

        if ($data['masih_aktif']) {
            $data['selesai_bulan'] = null;
            $data['selesai_tahun'] = null;
        }

        if ($request->hasFile('file_bukti')) {

            if ($org->file_bukti && Storage::exists($org->file_bukti)) {
                Storage::delete($org->file_bukti);
            }

            $data['file_bukti'] = $request->file('file_bukti')
                ->store('organization_files');
        }

        $org->update($data);

        return response()->json([
            'message' => 'Organisasi berhasil diperbarui'
        ]);
    }

    public function deleteOrganization($id)
    {
        $org = PelamarOrganization::where('user_id', Auth::id())
            ->where('id', $id)
            ->firstOrFail();

        if ($org->file_bukti && Storage::exists($org->file_bukti)) {
            Storage::delete($org->file_bukti);
        }

        $org->delete();

        return response()->json([
            'message' => 'Organisasi berhasil dihapus'
        ]);
    }
}
