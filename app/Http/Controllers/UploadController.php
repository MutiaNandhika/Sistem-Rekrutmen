<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Upload;

class UploadController extends Controller
{
    public function create()
    {
        $uploads = Upload::latest()->get();
        return view('file-upload.create', compact('uploads'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'file' => 'required|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:10240',
        ]);

        $originalName = $request->file('file')->getClientOriginalName();
        $path = $request->file('file')->storeAs('uploads', time() . '_' . $originalName, 's3');

        \App\Models\Upload::create([
            'name' => $request->name,
            'file_path' => $path,
        ]);

        return back()->with('success', 'File dan nama berhasil diupload!');
    }
}
