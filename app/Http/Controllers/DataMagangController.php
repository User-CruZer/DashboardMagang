<?php

namespace App\Http\Controllers;

use App\Models\DataMagang;
use Illuminate\Http\Request;

class DataMagangController extends Controller
{
    public function index()
    {
        $dataMagang = DataMagang::withCount('absensi')->orderBy('nama')->get();

        return view('dashboard.data-magang.index', compact('dataMagang'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nim' => 'required|string|max:50|unique:data_magang,nim',
            'program_studi' => 'required|string|max:255',
            'tempat_magang' => 'required|string|max:255',
            'pembimbing_lapangan' => 'required|string|max:255',
        ]);

        DataMagang::create($validated);

        return back()->with('success', 'Data magang berhasil ditambahkan.');
    }

    public function destroy(DataMagang $dataMagang)
    {
        $dataMagang->delete();

        return back()->with('success', 'Data magang berhasil dihapus.');
    }
}
