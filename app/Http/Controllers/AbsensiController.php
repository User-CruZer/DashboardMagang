<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\DataMagang;
use Illuminate\Http\Request;

class AbsensiController extends Controller
{
    public function index(Request $request)
    {
        $tanggal = $request->get('tanggal', now()->toDateString());

        $absensi = Absensi::with('dataMagang')
            ->when($tanggal, fn ($q) => $q->whereDate('tanggal', $tanggal))
            ->orderBy('tanggal', 'desc')
            ->orderBy('id', 'desc')
            ->get();

        $dataMagang = DataMagang::orderBy('nama')->get();

        return view('dashboard.absensi.index', compact('absensi', 'dataMagang', 'tanggal'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'data_magang_id' => 'required|exists:data_magang,id',
            'tanggal' => 'required|date',
            'status' => 'required|in:hadir,izin,sakit,tanpa_keterangan',
            'keterangan' => 'nullable|string|max:255',
        ]);

        $validated['keterangan'] = $validated['keterangan'] ?? null;

        Absensi::create($validated);

        return back()->with('success', 'Absensi berhasil dicatat.');
    }

    public function destroy(Absensi $absensi)
    {
        $absensi->delete();

        return back()->with('success', 'Catatan absensi berhasil dihapus.');
    }
}