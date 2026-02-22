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
    public function index(Request $request)
    {
        $today = now()->toDateString();

        Lowongan::where('status', 'aktif')
            ->whereNotNull('tanggal_selesai')
            ->whereDate('tanggal_selesai', '<', $today)
            ->update(['status' => 'nonaktif']);

        Lowongan::where('status', 'aktif')
            ->whereDate('tanggal_mulai', '>', $today)
            ->update(['status' => 'nonaktif']);

        Lowongan::where('status', 'nonaktif')
            ->whereDate('tanggal_mulai', '<=', $today)
            ->whereDate('tanggal_selesai', '>=', $today)
            ->update(['status' => 'aktif']);

        $userId = auth()->id(); 

        $query = Lowongan::with(['hrd','bidangKerja']);

        if ($request->pic) {
            $query->where('hrd_id', $request->pic);
        }

        if ($request->search) {
            $search = $request->search;

            $query->where(function($q) use ($search){
                $q->where('nama_lowongan','like',"%$search%")
                ->orWhere('lokasi','like',"%$search%")
                ->orWhereHas('hrd', function($q2) use ($search){
                        $q2->where('name','like',"%$search%");
                });
            });
        }

        $lowongans = $query
            ->orderBy('created_at','desc')
            ->paginate(6);

        $hrds = User::where('role','hrd')->orderBy('name')->get();

        if ($request->ajax()) {
            return view('hrd.lowongan.partials.list', [
                'lowongans' => $lowongans,
                'userId' => auth()->id(),
            ])->render();
        }

        return view('hrd.lowongan.index', compact('lowongans','hrds','userId'));
    }

    // create step 1
    public function create()
    {
        $skills = Skill::orderBy('nama_skill')->get();
        $bidangKerja = BidangKerja::orderBy('nama')->get();

        return view('hrd.lowongan.create', compact(
            'skills',
            'bidangKerja'
        ));
    }

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

    public function destroy(Lowongan $lowongan)
    {
        $this->authorizeLowongan($lowongan);

        if ($lowongan->applications()->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Lowongan tidak dapat dihapus karena sudah memiliki pelamar.'
            ], 422);
        }

        $lowongan->skills()->detach();
        $lowongan->delete();

        return response()->json([
            'success' => true,
            'message' => 'Lowongan berhasil dihapus'
        ]);
    }

    // Deskripsi Step 2
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

    public function updateStatus(Request $request, Lowongan $lowongan)
    {
        $this->authorizeLowongan($lowongan);

        $request->validate([
            'status' => 'required|in:draft,aktif,nonaktif,arsip'
        ]);

        if (
            $request->status === 'aktif' &&
            $lowongan->isExpired()
        ) {
            return response()->json([
                'success' => false,
                'message' => 'Lowongan sudah melewati batas pendaftaran. Silakan perpanjang tanggal terlebih dahulu.'
            ], 422);
        }

        $lowongan->update([
            'status' => $request->status
        ]);

        return response()->json([
            'success' => true,
            'status'  => $lowongan->status
        ]);
    }

    public function show(Lowongan $lowongan)
    {
        return view('hrd.lowongan.show', [
            'lowongan' => $lowongan,
            'isOwner'  => $lowongan->hrd_id === auth()->id()
        ]);
    }

    private function authorizeLowongan(Lowongan $lowongan)
    {
        if ($lowongan->hrd_id !== auth()->id()) {
            abort(403);
        }
    }

}
