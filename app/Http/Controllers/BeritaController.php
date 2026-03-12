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
    $berita = Berita::create(
        $request->only(['title','content','publish_date','thumbnail'])
    );

    return response()->json($berita, 201);
}

    // UPDATE
    public function update(Request $request, $id)
    {
        $berita = Berita::findOrFail($id);

        $berita->update(
    $request->only(['title','content','publish_date','thumbnail'])
);

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