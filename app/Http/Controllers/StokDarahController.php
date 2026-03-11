<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StokDarah;

class StokDarahController extends Controller
{
    public function index()
    {
        return StokDarah::all();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'golongan_darah' => 'required|in:A,B,AB,O',
            'rhesus' => 'required|in:+,-',
            'jumlah_kantong' => 'required|integer|min:0',
        ]);

        return StokDarah::create($data);

    }

    public function show(string $id)
    {
        return StokDarah::findOrFail($id);

    }

    public function update(Request $request, string $id)
    {
        $stok = StokDarah::findOrFail($id);
        $stok->update($request->all());
        return $stok;
    }

    public function destroy(string $id)
    {
        StokDarah::destroy($id);
        return response()->json(['message' => 'Stok darah berhasil dihapus']);
    }
}
