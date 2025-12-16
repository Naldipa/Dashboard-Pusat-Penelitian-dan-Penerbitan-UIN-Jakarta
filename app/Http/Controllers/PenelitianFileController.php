<?php

namespace App\Http\Controllers;

use App\Models\Penelitian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PenelitianFileController extends Controller
{
    public function store(Request $request, Penelitian $penelitian)
    {
        $request->validate([
            'file_dokumen' => 'required|file|mimes:pdf,doc,docx|max:4096',
        ]);

        // Simpan file ke storage/app/public/penelitian
        $path = $request->file('file_dokumen')->store('penelitian', 'public');

        // Update kolom file_path di tabel penelitians
        $penelitian->update([
            'file_path' => $path,
        ]);

        return back()->with('success', 'File berhasil di-upload.');
    }
}
