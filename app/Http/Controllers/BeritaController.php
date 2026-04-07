<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Berita;
use Illuminate\Support\Facades\Storage; // Tambahan untuk fitur hapus file lama (opsional)

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
        // 1. Validasi Input (Maksimal 5MB = 5120 KB)
        $request->validate([
            'title' => 'required|string',
            'content' => 'required|string',
            'publish_date' => 'required|date',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        $data = $request->only(['title', 'content', 'publish_date']);

        // Cek apakah ada file gambar yang diupload
        if ($request->hasFile('thumbnail')) {
            // Simpan gambar ke folder 'storage/app/public/berita'
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
        
        // 1. Validasi Input (Maksimal 5MB = 5120 KB)
        $request->validate([
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        $data = $request->only(['title', 'content', 'publish_date']);

        // Cek apakah admin mengupload gambar baru
        if ($request->hasFile('thumbnail')) {
            // (Opsional) Hapus gambar lama jika ada, agar memori server tidak penuh
            if ($berita->thumbnail) {
                Storage::disk('public')->delete($berita->thumbnail);
            }

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
        
        // (Opsional) Hapus juga file fisiknya dari storage saat berita dihapus
        if ($berita->thumbnail) {
            Storage::disk('public')->delete($berita->thumbnail);
        }

        $berita->delete();

        return response()->json([
            'message' => 'Berita berhasil dihapus'
        ]);
    }
}