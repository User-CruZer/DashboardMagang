<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Laporan Absensi Magang</title>
    <style>
        * { box-sizing: border-box; }
        body { font-family: 'DejaVu Sans', sans-serif; color: #1f2937; font-size: 12px; }
        h1 { font-size: 18px; text-align: center; margin: 0; }
        .subtitle { text-align: center; font-size: 12px; color: #6b7280; margin-top: 4px; }
        .meta { margin: 20px 0; font-size: 12px; }
        .meta strong { color: #374151; }
        table { width: 100%; border-collapse: collapse; font-size: 11px; }
        th, td { border: 1px solid #d1d5db; padding: 6px 8px; text-align: left; }
        th { background: #eff6ff; color: #1e3a8a; font-weight: 600; }
        tr:nth-child(even) { background: #f9fafb; }
        .footer { margin-top: 30px; font-size: 11px; color: #6b7280; }
        .badge { display: inline-block; padding: 1px 8px; border-radius: 10px; font-size: 10px; }
        .badge-hadir { background: #d1fae5; color: #065f46; }
        .badge-izin { background: #fef3c7; color: #92400e; }
        .badge-sakit { background: #ffedd5; color: #9a3412; }
        .badge-tanpa_keterangan { background: #fee2e2; color: #991b1b; }
    </style>
</head>
<body>
    <h1>LAPORAN ABSENSI MAGANG</h1>
    <p class="subtitle">Dibuat pada {{ now()->translatedFormat('d F Y H:i') }}</p>

    <div class="meta">
        Periode:
        @if ($tanggalMulai && $tanggalAkhir)
            {{ \Illuminate\Support\Carbon::parse($tanggalMulai)->translatedFormat('d F Y') }} &mdash; {{ \Illuminate\Support\Carbon::parse($tanggalAkhir)->translatedFormat('d F Y') }}
        @else
            Seluruh periode
        @endif
        @if ($status)
            &nbsp;|&nbsp; Filter status:
            @php
                $labels = ['hadir' => 'Hadir', 'izin' => 'Izin', 'sakit' => 'Sakit', 'tanpa_keterangan' => 'Tanpa Keterangan'];
            @endphp
            {{ $labels[$status] ?? $status }}
        @endif
        &nbsp;|&nbsp; Total catatan: {{ count($absensi) }}
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 30px;">No</th>
                <th>Nama</th>
                <th>NIM</th>
                <th>Tempat Magang</th>
                <th>Tanggal</th>
                <th>Status</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($absensi as $index => $a)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $a->dataMagang->nama }}</td>
                    <td>{{ $a->dataMagang->nim }}</td>
                    <td>{{ $a->dataMagang->tempat_magang }}</td>
                    <td>{{ \Illuminate\Support\Carbon::parse($a->tanggal)->translatedFormat('d F Y') }}</td>
                    <td>
                        <span class="badge badge-{{ $a->status }}">
                            {{ ['hadir' => 'Hadir', 'izin' => 'Izin', 'sakit' => 'Sakit', 'tanpa_keterangan' => 'Tanpa Keterangan'][$a->status] ?? $a->status }}
                        </span>
                    </td>
                    <td>{{ $a->keterangan ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align: center;">Tidak ada data yang cocok.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <p class="footer">Dokumen ini digenerate otomatis oleh sistem Absensi Magang pada {{ now()->translatedFormat('d F Y H:i') }}.</p>
</body>
</html>