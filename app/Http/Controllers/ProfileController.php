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

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * =========================
     *  PELAMAR: PROFILE PAGE
     * =========================
     */
    public function index()
    {
        $user = Auth::user();

        // pastikan profile 1-1 selalu ada
        $user->pelamarProfile()->firstOrCreate([
            'user_id' => $user->id,
        ]);

        // eager load sesuai tabel
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
    /**
     * Update data diri utama (card atas)
     * route: pelamar.profile.update (POST /pelamar/profile/update)
     */

    public function updateDataDiri(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:30',
            'location' => 'nullable|string|max:255',
            'age' => 'nullable|integer',
            'gender' => 'nullable|in:Laki-laki,Perempuan',
            'last_education' => 'nullable|string|max:255',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'remove_photo' => 'nullable|boolean',
        ]);

        $user = Auth::user();

        // update nama di tabel users
        $user->update([
            'name' => $request->name,
        ]);

        // 🔑 AMBIL PROFILE (INI YANG KURANG DI KODE KAMU)
        $profile = $user->pelamarProfile()->firstOrCreate([
            'user_id' => $user->id,
        ]);

        $photoPath = $profile->photo;

        // =========================
        // JIKA HAPUS FOTO
        // =========================
        if ($request->remove_photo == 1) {
            if ($photoPath && Storage::disk('public')->exists($photoPath)) {
                Storage::disk('public')->delete($photoPath);
            }
            $photoPath = null;
        }

        // =========================
        // JIKA UPLOAD FOTO BARU
        // =========================
        if ($request->hasFile('photo')) {

            // hapus foto lama
            if ($photoPath && Storage::disk('public')->exists($photoPath)) {
                Storage::disk('public')->delete($photoPath);
            }

            // simpan foto baru
            $photoPath = $request->file('photo')
                ->store('avatars', 'public');
        }

        // =========================
        // SIMPAN PROFILE
        // =========================
        $profile->update([
            'phone' => $request->phone,
            'location' => $request->location,
            'age' => $request->age,
            'gender' => $request->gender,
            'last_education' => $request->last_education,
            'photo' => $photoPath,
        ]);

        return response()->json([
            'message' => 'Data diri berhasil disimpan',
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
    
    /**
     * =========================
     *  EXPERIENCE (CRUD)
     * =========================
     */
    public function storeExperience(Request $request)
    {
        $data = $request->validate([
            'posisi' => 'required|string|max:255',
            'perusahaan' => 'required|string|max:255',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'nullable|date',
            'masih_bekerja' => 'nullable|boolean',
            'deskripsi' => 'nullable|string',
        ]);

        $data['user_id'] = Auth::id();
        $data['masih_bekerja'] = $request->boolean('masih_bekerja');

        if ($data['masih_bekerja']) {
            $data['tanggal_selesai'] = null;
        }

        PelamarExperience::create($data);

        return back()->with('success', 'Pengalaman berhasil ditambahkan');
    }


    public function updateExperience(Request $request, $id)
    {
        $user = Auth::user();
        $exp = PelamarExperience::where('user_id', $user->id)->where('id', $id)->firstOrFail();

        $data = $request->validate([
            'posisi' => 'required|string|max:255',
            'perusahaan' => 'required|string|max:255',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'nullable|date',
            'masih_bekerja' => 'nullable|boolean',
            'deskripsi' => 'nullable|string',
        ]);

        $data['masih_bekerja'] = (bool)($data['masih_bekerja'] ?? false);
        if ($data['masih_bekerja']) {
            $data['tanggal_selesai'] = null;
        }

        $exp->update($data);

        return back()->with('success', 'Pengalaman kerja berhasil diperbarui.');
    }

    public function deleteExperience($id)
    {
        $user = Auth::user();
        PelamarExperience::where('user_id', $user->id)->where('id', $id)->delete();

        return back()->with('success', 'Pengalaman kerja berhasil dihapus.');
    }

    /**
     * =========================
     *  EDUCATION (CRUD)
     * =========================
     */
   public function storeEducation(Request $request)
    {
        $data = $request->validate([
            'tingkat' => 'required|string|max:255',
            'nama_sekolah' => 'required|string|max:255',
            'bidang_studi' => 'nullable|string|max:255',
            'mulai_tahun' => 'nullable|integer',
            'selesai_bulan' => 'nullable|integer|min:1|max:12',
            'selesai_tahun' => 'nullable|integer',
            'informasi_tambahan' => 'nullable|string',
        ]);

        $data['user_id'] = Auth::id();

        PelamarEducation::create($data);

        return back()->with('success', 'Pendidikan berhasil ditambahkan');
    }


    public function updateEducation(Request $request, $id)
    {
        $user = Auth::user();
        $edu = PelamarEducation::where('user_id', $user->id)->where('id', $id)->firstOrFail();

        $data = $request->validate([
            'tingkat' => 'required|string|max:255',
            'nama_sekolah' => 'required|string|max:255',
            'bidang_studi' => 'nullable|string|max:255',
            'mulai_tahun' => 'nullable|integer',
            'selesai_bulan' => 'nullable|integer|min:1|max:12',
            'selesai_tahun' => 'nullable|integer',
            'informasi_tambahan' => 'nullable|string',
        ]);

        $edu->update($data);

        return back()->with('success', 'Pendidikan berhasil diperbarui.');
    }

    public function deleteEducation($id)
    {
        $user = Auth::user();
        PelamarEducation::where('user_id', $user->id)->where('id', $id)->delete();

        return back()->with('success', 'Pendidikan berhasil dihapus.');
    }

    /**
     * =========================
     *  SKILLS
     * =========================
     */
    public function storeSkill(Request $request)
    {
        $request->validate([
            'nama_skill' => 'required|string|max:255',
        ]);

        PelamarSkill::firstOrCreate([
            'user_id' => Auth::id(),
            'nama_skill' => trim($request->nama_skill),
        ]);

        return back()->with('success', 'Skill berhasil ditambahkan');
    }


    public function deleteSkill($id)
    {
        $user = Auth::user();
        PelamarSkill::where('user_id', $user->id)->where('id', $id)->delete();

        return back()->with('success', 'Skill berhasil dihapus.');
    }

    /**
     * =========================
     *  RESUME (UPLOAD 1 FILE)
     * =========================
     */
    public function uploadResume(Request $request)
    {
        $request->validate([
            'resume' => 'required|file|mimes:pdf|max:5120',
        ]);

        $userId = Auth::id();
        $file = $request->file('resume');

        $old = PelamarResume::where('user_id', $userId)->first();
        if ($old && Storage::disk('public')->exists($old->file_path)) {
            Storage::disk('public')->delete($old->file_path);
        }

        $path = $file->store('resumes', 'public');

        PelamarResume::updateOrCreate(
            ['user_id' => $userId],
            [
                'file_path' => $path,
                'file_name' => $file->getClientOriginalName(),
                'file_size' => $file->getSize(),
                'uploaded_at' => now(),
            ]
        );

        return back()->with('success', 'Resume berhasil diupload');
    }


    public function deleteResume()
    {
        $user = Auth::user();
        $resume = PelamarResume::where('user_id', $user->id)->first();

        if ($resume) {
            if ($resume->file_path && Storage::disk('public')->exists($resume->file_path)) {
                Storage::disk('public')->delete($resume->file_path);
            }
            $resume->delete();
        }

        return back()->with('success', 'Resume berhasil dihapus.');
    }

    /**
     * =========================
     *  CERTIFICATE
     * =========================
     */
    public function storeCertificate(Request $request)
    {
        $data = $request->validate([
            'nama_sertifikat' => 'required|string|max:255',
            'organisasi_penerbit' => 'required|string|max:255',
            'bulan_terbit' => 'nullable|integer|min:1|max:12',
            'tahun_terbit' => 'nullable|integer',
            'tanpa_expired' => 'nullable|boolean',
            'bulan_expired' => 'nullable|integer|min:1|max:12',
            'tahun_expired' => 'nullable|integer',
            'informasi_tambahan' => 'nullable|string',
        ]);

        $data['user_id'] = Auth::id();
        $data['tanpa_expired'] = $request->boolean('tanpa_expired');

        if ($data['tanpa_expired']) {
            $data['bulan_expired'] = null;
            $data['tahun_expired'] = null;
        }

        PelamarCertificate::create($data);

        return back()->with('success', 'Sertifikat berhasil ditambahkan');
    }

    public function deleteCertificate($id)
    {
        $user = Auth::user();
        PelamarCertificate::where('user_id', $user->id)->where('id', $id)->delete();

        return back()->with('success', 'Sertifikat berhasil dihapus.');
    }

    /**
     * =========================
     *  ORGANIZATION
     * =========================
     */
    public function storeOrganization(Request $request)
    {
        $data = $request->validate([
            'nama_organisasi' => 'required|string|max:255',
            'posisi' => 'required|string|max:255',
            'mulai_bulan' => 'nullable|integer|min:1|max:12',
            'mulai_tahun' => 'nullable|integer',
            'masih_aktif' => 'nullable|boolean',
            'selesai_bulan' => 'nullable|integer|min:1|max:12',
            'selesai_tahun' => 'nullable|integer',
            'informasi_tambahan' => 'nullable|string',
        ]);

        $data['user_id'] = Auth::id();
        $data['masih_aktif'] = $request->boolean('masih_aktif');

        if ($data['masih_aktif']) {
            $data['selesai_bulan'] = null;
            $data['selesai_tahun'] = null;
        }

        PelamarOrganization::create($data);

        return back()->with('success', 'Organisasi berhasil ditambahkan');
    }


    public function deleteOrganization($id)
    {
        $user = Auth::user();
        PelamarOrganization::where('user_id', $user->id)->where('id', $id)->delete();

        return back()->with('success', 'Organisasi berhasil dihapus.');
    }

    /**
     * =========================
     *  ACHIEVEMENT
     * =========================
     */
    public function storeAchievement(Request $request)
    {
        $data = $request->validate([
            'judul' => 'required|string|max:255',
            'penyelenggara' => 'nullable|string|max:255',
            'tahun' => 'nullable|integer',
            'deskripsi' => 'nullable|string',
        ]);

        $data['user_id'] = Auth::id();

        PelamarAchievement::create($data);

        return back()->with('success', 'Penghargaan berhasil ditambahkan');
    }


    public function deleteAchievement($id)
    {
        $user = Auth::user();
        PelamarAchievement::where('user_id', $user->id)->where('id', $id)->delete();

        return back()->with('success', 'Penghargaan berhasil dihapus.');
    }

    /**
     * =========================
     *  PROFILE DEFAULT (BREEZE) untuk HRD/ADMIN
     * =========================
     */
    public function edit(Request $request)
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    public function update(Request $request)
    {
        $user = $request->user();

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
        ]);

        $user->fill($request->only('name', 'email'));
        $user->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'password' => ['required'],
        ]);

        $user = $request->user();

        if (! Hash::check($request->password, $user->password)) {
            return back()->withErrors(['password' => 'Password tidak sesuai.']);
        }

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
