<?php

namespace App\Http\Controllers;

use App\Models\Pendonor;
use Illuminate\Http\Request;

class PendonorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pendonors = Pendonor::with('masyarakat')->get();
        return response()->json($pendonors);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'masyarakat_id' => 'required|exists:masyarakat,id',
            'gol_darah' => 'required|in:A,B,AB,O',
            'rhesus' => 'required|in:+,-',
        ]);

        $pendonor = Pendonor::create($request->all());
        return response()->json($pendonor, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Pendonor $pendonor)
    {
        return response()->json($pendonor->load('masyarakat'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pendonor $pendonor)
    {
        $request->validate([
            'masyarakat_id' => 'sometimes|exists:masyarakat,id',
            'gol_darah' => 'sometimes|in:A,B,AB,O',
            'rhesus' => 'sometimes|in:+,-',
        ]);

        $pendonor->update($request->all());
        return response()->json($pendonor);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pendonor $pendonor)
    {
        $pendonor->delete();
        return response()->json(['message' => 'Pendonor deleted successfully']);
    }
}
