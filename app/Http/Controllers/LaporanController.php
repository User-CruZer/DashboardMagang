<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $tanggalMulai = $request->get('tanggal_mulai');
        $tanggalAkhir = $request->get('tanggal_akhir');
        $status = $request->get('status');

        $absensi = Absensi::with('dataMagang')
            ->when($tanggalMulai && $tanggalAkhir, function ($q) use ($tanggalMulai, $tanggalAkhir) {
                $q->whereBetween('tanggal', [$tanggalMulai, $tanggalAkhir]);
            })
            ->when($status, fn ($q) => $q->where('status', $status))
            ->orderBy('tanggal', 'desc')
            ->orderBy('id', 'desc')
            ->get();

        return view('dashboard.laporan.index', compact('absensi', 'tanggalMulai', 'tanggalAkhir', 'status'));
    }

    public function pdf(Request $request)
    {
        $tanggalMulai = $request->get('tanggal_mulai');
        $tanggalAkhir = $request->get('tanggal_akhir');
        $status = $request->get('status');

        $absensi = Absensi::with('dataMagang')
            ->when($tanggalMulai && $tanggalAkhir, function ($q) use ($tanggalMulai, $tanggalAkhir) {
                $q->whereBetween('tanggal', [$tanggalMulai, $tanggalAkhir]);
            })
            ->when($status, fn ($q) => $q->where('status', $status))
            ->orderBy('tanggal', 'desc')
            ->orderBy('id', 'desc')
            ->get();

        $pdf = Pdf::loadView('dashboard.laporan.pdf', compact('absensi', 'tanggalMulai', 'tanggalAkhir', 'status'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('laporan-absensi-magang.pdf');
    }
}
