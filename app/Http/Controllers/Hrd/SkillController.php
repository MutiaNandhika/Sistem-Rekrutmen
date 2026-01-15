<?php 

namespace App\Http\Controllers\Hrd;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Skill;

class SkillController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'nama_skill' => 'required|string|max:100'
        ]);

        $skill = Skill::firstOrCreate(
            ['nama_skill' => trim($request->nama_skill)]
        );

        return response()->json($skill);
    }

public function update(Request $request, Skill $skill)
{
    if ($skill->lowongans()->count() > 0) {
        return response()->json([
            'message' => 'Skill sudah digunakan, tidak bisa diedit'
        ], 403);
    }

    $skill->update([
        'nama_skill' => $request->nama_skill
    ]);

    return response()->json($skill);
}


public function destroy(Skill $skill)
{
    if ($skill->lowongans()->exists()) {
        return response()->json([
            'message' => 'Skill sudah digunakan, tidak bisa dihapus'
        ], 403);
    }

    $skill->delete();
    return response()->json(['success' => true]);
}


}
