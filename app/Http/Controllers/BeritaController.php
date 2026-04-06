<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Berita;

class BeritaController extends Controller
{
    // READ ALL
    public function index()
    {
        return response()->json(
            Berita::orderBy('publish_date','desc')->get()
        );
    }

    // READ ONE
    public function show($id)
    {
        return response()->json(
            Berita::findOrFail($id)
        );
    }

    // CREATE
    public function store(Request $request)
{
        $data = $request->only(['title', 'content', 'publish_date']);

        // Cek apakah ada file gambar yang diupload
        if ($request->hasFile('thumbnail')) {
            // Simpan gambar ke folder 'storage/app/public/berita'
            // dan simpan nama jalurnya (path) ke variabel data
            $path = $request->file('thumbnail')->store('berita', 'public');
            $data['thumbnail'] = $path;
        }

        $berita = Berita::create($data);

    return response()->json($berita, 201);
}

    // UPDATE
    public function update(Request $request, $id)
    {
        $berita = Berita::findOrFail($id);
        
        $data = $request->only(['title', 'content', 'publish_date']);

        // Cek apakah admin mengupload gambar baru
        if ($request->hasFile('thumbnail')) {
            $path = $request->file('thumbnail')->store('berita', 'public');
            $data['thumbnail'] = $path;
        }

        $berita->update($data);

        return response()->json($berita);
    }

    // DELETE
    public function destroy($id)
    {
        $berita = Berita::findOrFail($id);
        $berita->delete();

        return response()->json([
            'message' => 'Berita berhasil dihapus'
        ]);
    }
}