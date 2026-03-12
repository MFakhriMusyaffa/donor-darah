<?php

namespace App\Http\Controllers;

use App\Models\JadwalKegiatan;
use Illuminate\Http\Request;

class JadwalKegiatanController extends Controller
{
    public function index()
    {
        $jadwal = JadwalKegiatan::all();
        return response()->json(['success' => true, 'data' => $jadwal]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'event_name'  => 'required|string|max:150',
            'start_event' => 'required|date',
            'end_event'   => 'required|date|after_or_equal:start_event',
            'location'    => 'required|string|max:150',
            'detail'      => 'required|string',
        ]);

        $jadwal = JadwalKegiatan::create($validated);
        return response()->json(['success' => true, 'message' => 'Jadwal berhasil ditambahkan', 'data' => $jadwal], 201);
    }

    public function show($id)
    {
        $jadwal = JadwalKegiatan::find($id);
        
        if (!$jadwal) {
            return response()->json(['success' => false, 'message' => 'Jadwal tidak ditemukan'], 404);
        }

        return response()->json(['success' => true, 'data' => $jadwal]);
    }

    public function update(Request $request, $id)
    {
        $jadwal = JadwalKegiatan::find($id);

        if (!$jadwal) {
            return response()->json(['success' => false, 'message' => 'Jadwal tidak ditemukan'], 404);
        }

        $validated = $request->validate([
            'event_name'  => 'sometimes|required|string|max:150',
            'start_event' => 'sometimes|required|date',
            'end_event'   => 'sometimes|required|date|after_or_equal:start_event',
            'location'    => 'sometimes|required|string|max:150',
            'detail'      => 'sometimes|required|string',
        ]);

        $jadwal->update($validated);
        return response()->json(['success' => true, 'message' => 'Jadwal berhasil diperbarui', 'data' => $jadwal]);
    }

    public function destroy($id)
    {
        $jadwal = JadwalKegiatan::find($id);

        if (!$jadwal) {
            return response()->json(['success' => false, 'message' => 'Jadwal tidak ditemukan'], 404);
        }

        $jadwal->delete();
        return response()->json(['success' => true, 'message' => 'Jadwal berhasil dihapus']);
    }
}
