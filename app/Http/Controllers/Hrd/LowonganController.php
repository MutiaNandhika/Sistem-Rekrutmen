<?php

namespace App\Http\Controllers\Hrd;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lowongan;
use App\Models\Skill;

class LowonganController extends Controller
{
    public function index()
    {
        $lowongans = Lowongan::where('hrd_id', auth()->id())
            ->latest()
            ->get();

        return view('hrd.lowongan.index', compact('lowongans'));
    }

    public function create()
    {
        $skills = Skill::all();
        return view('hrd.lowongan.create', compact('skills'));
    }

    // =========================
    // STEP 1 - STORE
    // =========================
    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_lowongan' => 'required',
            'bidang_kerja' => 'required',
            'tipe_kerja' => 'required',
            'sistem_kerja' => 'required',
            'lokasi' => 'required',
            'penempatan' => 'nullable|string',
            'gaji_min' => 'nullable|numeric',
            'gaji_max' => 'nullable|numeric',
            'jenis_kelamin' => 'nullable',
            'usia_min' => 'nullable|numeric',
            'usia_max' => 'nullable|numeric',
            'pendidikan_minimal' => 'nullable',
            'pengalaman_kerja' => 'nullable',
        ]);

        $lowongan = Lowongan::create([
            ...$data,
            'hrd_id' => auth()->id(),
            'tanpa_batas_usia' => $request->has('tanpa_batas_usia') ? 1 : 0,
            'status' => 'draft',
        ]);

        if ($request->skills) {
            $lowongan->skills()->sync($request->skills);
        }

        return redirect()
            ->route('lowongan.create.deskripsi', $lowongan->id);
    }

    // =========================
    // STEP 1 - EDIT
    // =========================
    public function edit(Lowongan $lowongan)
    {
        $skills = Skill::all();
        return view('hrd.lowongan.create', compact('lowongan', 'skills'));
    }

    // =========================
    // STEP 1 - UPDATE (FIX ERROR)
    // =========================
    public function update(Request $request, Lowongan $lowongan)
    {
        $data = $request->validate([
            'nama_lowongan' => 'required',
            'bidang_kerja' => 'required',
            'tipe_kerja' => 'required',
            'sistem_kerja' => 'required',
            'lokasi' => 'required',
            'penempatan' => 'nullable|string',
            'gaji_min' => 'nullable|numeric',
            'gaji_max' => 'nullable|numeric',
            'jenis_kelamin' => 'nullable',
            'usia_min' => 'nullable|numeric',
            'usia_max' => 'nullable|numeric',
            'pendidikan_minimal' => 'nullable',
            'pengalaman_kerja' => 'nullable',
        ]);

        $lowongan->update([
            ...$data,
            'tanpa_batas_usia' => $request->has('tanpa_batas_usia') ? 1 : 0,
        ]);

        if ($request->skills) {
            $lowongan->skills()->sync($request->skills);
        }

        return redirect()
            ->route('lowongan.create.deskripsi', $lowongan->id);
    }

    public function destroy(Lowongan $lowongan)
{
    // hapus relasi skill dulu (pivot)
    $lowongan->skills()->detach();

    // hapus lowongan
    $lowongan->delete();

    return response()->json([
        'message' => 'Lowongan berhasil dihapus'
    ]);
}

    // =========================
    // STEP 2
    // =========================

    
    public function createDeskripsi(Lowongan $lowongan)
    {
        return view('hrd.lowongan.create-deskripsi', compact('lowongan'));
    }

    public function updateDeskripsi(Request $request, Lowongan $lowongan)
{
    $request->validate([
        'deskripsi_pekerjaan' => 'required'
    ]);

    // 🔥 SIMPAN SELALU (APAPUN TOMBOLNYA)
    $lowongan->update([
        'deskripsi_pekerjaan' => $request->deskripsi_pekerjaan
    ]);

    // 🔙 JIKA KLIK SEBELUMNYA
    if ($request->action === 'back') {
        return redirect()
            ->route('lowongan.edit', $lowongan->id);
    }

    // 🚀 PUBLISH
    if ($request->action === 'publish') {
        $lowongan->update(['status' => 'aktif']);
    } else {
        // 💾 DRAFT
        $lowongan->update(['status' => 'draft']);
    }

    return redirect()
        ->route('lowongan.index')
        ->with('success', 'Lowongan berhasil disimpan');
}
public function updateStatus(Request $request, Lowongan $lowongan)
{
    $request->validate([
        'status' => 'required|in:draft,aktif,nonaktif,arsip'
    ]);

    $lowongan->update([
        'status' => $request->status
    ]);

    return response()->json([
        'success' => true,
        'status' => $lowongan->status
    ]);
}

public function show(Lowongan $lowongan)
{
    // keamanan: hanya HRD pemilik
    if ($lowongan->hrd_id !== auth()->id()) {
        abort(403);
    }

    // eager load relasi
    $lowongan->load('skills');

    return view('hrd.lowongan.show', compact('lowongan'));
}


}
