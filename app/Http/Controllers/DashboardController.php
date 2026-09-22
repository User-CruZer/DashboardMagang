<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\DataMagang;

class DashboardController extends Controller
{
    public function index()
    {
        $today = now()->toDateString();

        $totalMagang = DataMagang::count();

        $hadirRecords = Absensi::with('dataMagang')->whereDate('tanggal', $today)->where('status', 'hadir')->get();
        $izinSakitRecords = Absensi::with('dataMagang')->whereDate('tanggal', $today)->whereIn('status', ['izin', 'sakit'])->get();
        $tanpaRecords = Absensi::with('dataMagang')->whereDate('tanggal', $today)->where('status', 'tanpa_keterangan')->get();

        $recordedToday = Absensi::whereDate('tanggal', $today)->pluck('data_magang_id');
        $belumTercatat = DataMagang::whereNotIn('id', $recordedToday)->get();

        $hadir = $hadirRecords->count();
        $izinSakit = $izinSakitRecords->count();
        $tanpaKeterangan = $tanpaRecords->count() + $belumTercatat->count();

        $hadirList = $hadirRecords->map->dataMagang->map->nama->values();
        $izinSakitList = $izinSakitRecords->map(fn ($a) => [
            'nama' => $a->dataMagang->nama,
            'status' => $a->status,
        ])->values();
        $tanpaKeteranganList = collect()
            ->merge($tanpaRecords->map->dataMagang->map->nama)
            ->merge($belumTercatat->map->nama)
            ->values();

        $recent = Absensi::with('dataMagang')->orderBy('tanggal', 'desc')->orderBy('id', 'desc')->take(8)->get();

        return view('dashboard.index', compact(
            'totalMagang',
            'hadir',
            'izinSakit',
            'tanpaKeterangan',
            'hadirList',
            'izinSakitList',
            'tanpaKeteranganList',
            'recent',
        ));
    }
}