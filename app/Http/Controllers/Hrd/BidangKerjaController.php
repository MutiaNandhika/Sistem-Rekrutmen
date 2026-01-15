<?php

namespace App\Http\Controllers\Hrd;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BidangKerja;
use App\Models\Lowongan;

class BidangKerjaController extends Controller
{
    /* ===============================
       STORE
    =============================== */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|unique:bidang_kerja,nama'
        ]);

        $bidang = BidangKerja::create([
            'nama' => $request->nama
        ]);

        return response()->json($bidang);
    }

    /* ===============================
       UPDATE
    =============================== */
    public function update(Request $request, BidangKerja $bidangKerja)
    {
        $request->validate([
            'nama' => 'required|string|unique:bidang_kerja,nama,' . $bidangKerja->id
        ]);

        $bidangKerja->update([
            'nama' => $request->nama
        ]);

        return response()->json($bidangKerja);
    }

    /* ===============================
       DELETE
    =============================== */
    public function destroy(BidangKerja $bidangKerja)
    {
        // ❗ Cegah hapus jika dipakai lowongan
        if (Lowongan::where('bidang_kerja_id', $bidangKerja->id)->exists()) {
            return response()->json([
                'message' => 'Bidang kerja masih digunakan lowongan'
            ], 422);
        }

        $bidangKerja->delete();

        return response()->json([
            'message' => 'Bidang kerja berhasil dihapus'
        ]);
    }
}
