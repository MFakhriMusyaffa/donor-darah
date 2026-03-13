<?php

namespace App\Http\Controllers;

use App\Models\Masyarakat;
use Illuminate\Http\Request;

class MasyarakatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $masyarakats = Masyarakat::with('user')->get();
        return response()->json($masyarakats);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'nama' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'tanggal_lahir' => 'required|date',
            'email' => 'required|email|unique:masyarakat,email',
            'no_hp' => 'required|string|max:15',
            'alamat' => 'required|string',
        ]);

        $masyarakat = Masyarakat::create($request->all());
        return response()->json($masyarakat, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Masyarakat $masyarakat)
    {
        return response()->json($masyarakat->load('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Masyarakat $masyarakat)
    {
        $request->validate([
            'user_id' => 'sometimes|exists:users,id',
            'nama' => 'sometimes|string|max:255',
            'jenis_kelamin' => 'sometimes|in:L,P',
            'tanggal_lahir' => 'sometimes|date',
            'email' => 'sometimes|email|unique:masyarakat,email,' . $masyarakat->id,
            'no_hp' => 'sometimes|string|max:15',
            'alamat' => 'sometimes|string',
        ]);

        $masyarakat->update($request->all());
        return response()->json($masyarakat);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Masyarakat $masyarakat)
    {
        $masyarakat->delete();
        return response()->json(['message' => 'Masyarakat deleted successfully']);
    }
}
