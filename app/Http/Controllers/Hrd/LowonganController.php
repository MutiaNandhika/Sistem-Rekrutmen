<?php

namespace App\Http\Controllers\Hrd;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lowongan;
use App\Models\Skill;
use App\Models\User;
use App\Models\BidangKerja;

class LowonganController extends Controller
{
    /* ======================================================
    | INDEX
    ====================================================== */
    public function index(Request $request)
    {
        // AUTO CLOSE
    Lowongan::where('status', 'aktif')
        ->whereNotNull('tanggal_selesai')
        ->whereDate('tanggal_selesai', '<', now())
        ->update(['status' => 'nonaktif']);

        $userId = auth()->id();

        // Ambil semua HRD untuk filter PIC
        $hrds = User::where('role', 'hrd')
            ->orderBy('name')
            ->get();

        // Query lowongan + relasi HRD & Bidang Kerja
        $lowongans = Lowongan::with(['hrd', 'bidangKerja'])
            ->when($request->pic, function ($q) use ($request) {
                $q->where('hrd_id', $request->pic);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('hrd.lowongan.index', [
            'lowongans' => $lowongans,
            'hrds'      => $hrds,
            'userId'    => $userId,
        ]);
    }

    /* ======================================================
    | CREATE (STEP 1)
    ====================================================== */
    public function create()
    {
        $skills = Skill::orderBy('nama_skill')->get();
        $bidangKerja = BidangKerja::orderBy('nama')->get();

        return view('hrd.lowongan.create', compact(
            'skills',
            'bidangKerja'
        ));
    }

    /* ======================================================
    | STORE (STEP 1)
    ====================================================== */
public function store(Request $request)
{
    $data = $request->validate([
        'nama_lowongan'      => 'required|string',
        'bidang_kerja_id'    => 'required|exists:bidang_kerja,id',
        'tipe_kerja'         => 'required|string',
        'sistem_kerja'       => 'required|string',
        'lokasi'             => 'required|string',
        'penempatan'         => 'nullable|string',
        'gaji_min'           => 'nullable|numeric',
        'gaji_max'           => 'nullable|numeric',
        'jenis_kelamin'      => 'nullable|in:laki-laki,perempuan,semua',
        'usia_min'           => 'nullable|numeric',
        'usia_max'           => 'nullable|numeric',
        'pendidikan_minimal' => 'nullable|string',
        'pengalaman_kerja'   => 'nullable|string',
        'tanggal_mulai'      => 'required|date',
        'tanggal_selesai'    => 'required|date|after_or_equal:tanggal_mulai',
        'jumlah_diterima'    => 'required|integer|min:1',
    ]);

    $lowongan = Lowongan::create([
        ...$data,
        'hrd_id'           => auth()->id(),
        'tanpa_batas_usia' => $request->has('tanpa_batas_usia'),
        'status'           => 'draft',
    ]);

    if ($request->filled('skills')) {
        $lowongan->skills()->sync($request->skills);
    }

    return redirect()
        ->route('hrd.lowongan.deskripsi.create', $lowongan->id);
}


    /* ======================================================
    | EDIT (STEP 1)
    ====================================================== */
    public function edit(Lowongan $lowongan)
    {
        $this->authorizeLowongan($lowongan);

        $skills = Skill::orderBy('nama_skill')->get();
        $bidangKerja = BidangKerja::orderBy('nama')->get();

        return view('hrd.lowongan.create', compact(
            'lowongan',
            'skills',
            'bidangKerja'
        ));
    }

    /* ======================================================
    | UPDATE (STEP 1)
    ====================================================== */
public function update(Request $request, Lowongan $lowongan)
{
    $this->authorizeLowongan($lowongan);

    $data = $request->validate([
        'nama_lowongan'      => 'required|string',
        'bidang_kerja_id'    => 'required|exists:bidang_kerja,id',
        'tipe_kerja'         => 'required|string',
        'sistem_kerja'       => 'required|string',
        'lokasi'             => 'required|string',
        'penempatan'         => 'nullable|string',
        'gaji_min'           => 'nullable|numeric',
        'gaji_max'           => 'nullable|numeric',
        'jenis_kelamin'      => 'nullable|in:laki-laki,perempuan,semua',
        'usia_min'           => 'nullable|numeric',
        'usia_max'           => 'nullable|numeric',
        'pendidikan_minimal' => 'nullable|string',
        'pengalaman_kerja'   => 'nullable|string',
        'tanggal_mulai'      => 'required|date',
        'tanggal_selesai'    => 'required|date|after_or_equal:tanggal_mulai',
        'jumlah_diterima'    => 'required|integer|min:1',
    ]);

    $lowongan->update([
        ...$data,
        'tanpa_batas_usia' => $request->has('tanpa_batas_usia'),
    ]);

    if ($request->filled('skills')) {
        $lowongan->skills()->sync($request->skills);
    }

    return redirect()
        ->route('hrd.lowongan.deskripsi.create', $lowongan->id);
}


    /* ======================================================
    | DELETE
    ====================================================== */
    public function destroy(Lowongan $lowongan)
    {
        $this->authorizeLowongan($lowongan);

        $lowongan->skills()->detach();
        $lowongan->delete();

        return response()->json([
            'message' => 'Lowongan berhasil dihapus'
        ]);
    }

    /* ======================================================
    | DESKRIPSI (STEP 2)
    ====================================================== */
    public function createDeskripsi(Lowongan $lowongan)
    {
        $this->authorizeLowongan($lowongan);

        return view('hrd.lowongan.create-deskripsi', compact('lowongan'));
    }

    public function updateDeskripsi(Request $request, Lowongan $lowongan)
    {
        $this->authorizeLowongan($lowongan);

        $request->validate([
            'deskripsi_pekerjaan' => 'required|string'
        ]);

        $lowongan->update([
            'deskripsi_pekerjaan' => $request->deskripsi_pekerjaan,
        ]);

        if ($request->action === 'back') {
            return redirect()
                ->route('hrd.lowongan.edit', $lowongan->id);
        }

        $lowongan->update([
            'status' => $request->action === 'publish'
                ? 'aktif'
                : 'draft'
        ]);

        return redirect()
            ->route('hrd.lowongan.index')
            ->with('success', 'Lowongan berhasil disimpan');
    }

    /* ======================================================
    | UPDATE STATUS (AJAX)
    ====================================================== */
    public function updateStatus(Request $request, Lowongan $lowongan)
    {
        $this->authorizeLowongan($lowongan);

        $request->validate([
            'status' => 'required|in:draft,aktif,nonaktif,arsip'
        ]);

        $lowongan->update([
            'status' => $request->status
        ]);

        return response()->json([
            'success' => true,
            'status'  => $lowongan->status
        ]);
    }

    /* ======================================================
    | SHOW
    ====================================================== */
    public function show(Lowongan $lowongan)
    {
        return view('hrd.lowongan.show', [
            'lowongan' => $lowongan,
            'isOwner'  => $lowongan->hrd_id === auth()->id()
        ]);
    }

    /* ======================================================
    | SECURITY HELPER
    ====================================================== */
    private function authorizeLowongan(Lowongan $lowongan)
    {
        if ($lowongan->hrd_id !== auth()->id()) {
            abort(403);
        }
    }
}
