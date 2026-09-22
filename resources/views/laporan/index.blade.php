@extends('layouts.app')

@section('title', 'Laporan')
@section('subtitle', 'Rekap absensi magang')

@section('content')
    @php
        $present = collect($absensi);
        $countHadir = $present->where('status', 'hadir')->count();
        $countIzin = $present->where('status', 'izin')->count();
        $countSakit = $present->where('status', 'sakit')->count();
        $countTanpa = $present->where('status', 'tanpa_keterangan')->count();
    @endphp

    <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
        <h3 class="font-semibold text-gray-800 mb-4">Filter Laporan</h3>
        <form method="GET" action="{{ route('laporan.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label for="tanggal_mulai" class="block text-sm font-medium text-gray-600 mb-1">Tanggal Mulai</label>
                <input type="date" id="tanggal_mulai" name="tanggal_mulai" value="{{ $tanggalMulai }}"
                       class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500">
            </div>
            <div>
                <label for="tanggal_akhir" class="block text-sm font-medium text-gray-600 mb-1">Tanggal Akhir</label>
                <input type="date" id="tanggal_akhir" name="tanggal_akhir" value="{{ $tanggalAkhir }}"
                       class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500">
            </div>
            <div>
                <label for="status" class="block text-sm font-medium text-gray-600 mb-1">Status</label>
                <select id="status" name="status"
                        class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500">
                    <option value="">Semua status</option>
                    <option value="hadir" @selected($status == 'hadir')>Hadir</option>
                    <option value="izin" @selected($status == 'izin')>Izin</option>
                    <option value="sakit" @selected($status == 'sakit')>Sakit</option>
                    <option value="tanpa_keterangan" @selected($status == 'tanpa_keterangan')>Tanpa Keterangan</option>
                </select>
            </div>
            <div class="flex items-end gap-2">
                <button type="submit"
                        class="bg-brand-600 hover:bg-brand-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition flex-1">
                    Tampilkan
                </button>
                <a href="{{ route('laporan.pdf', request()->query()) }}"
                   class="bg-red-600 hover:bg-red-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition flex items-center justify-center gap-2 flex-1 whitespace-nowrap">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                    </svg>
                    PDF
                </a>
            </div>
        </form>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6 mb-6">
        <div class="bg-green-50 border border-green-200 rounded-xl p-5">
            <p class="text-sm font-medium text-green-700">Hadir</p>
            <p class="mt-1 text-3xl font-bold text-green-700">{{ $countHadir }}</p>
        </div>
        <div class="bg-amber-50 border border-amber-200 rounded-xl p-5">
            <p class="text-sm font-medium text-amber-700">Izin</p>
            <p class="mt-1 text-3xl font-bold text-amber-700">{{ $countIzin }}</p>
        </div>
        <div class="bg-orange-50 border border-orange-200 rounded-xl p-5">
            <p class="text-sm font-medium text-orange-700">Sakit</p>
            <p class="mt-1 text-3xl font-bold text-orange-700">{{ $countSakit }}</p>
        </div>
        <div class="bg-red-50 border border-red-200 rounded-xl p-5">
            <p class="text-sm font-medium text-red-700">Tanpa Keterangan</p>
            <p class="mt-1 text-3xl font-bold text-red-700">{{ $countTanpa }}</p>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
            <h3 class="font-semibold text-gray-800">Ringkasan Absensi</h3>
            <span class="text-sm text-gray-500">{{ count($absensi) }} catatan</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-gray-500 uppercase text-xs border-b border-gray-100">
                        <th class="px-6 py-3 font-medium">No</th>
                        <th class="px-6 py-3 font-medium">Nama</th>
                        <th class="px-6 py-3 font-medium">NIM</th>
                        <th class="px-6 py-3 font-medium">Tempat Magang</th>
                        <th class="px-6 py-3 font-medium">Tanggal</th>
                        <th class="px-6 py-3 font-medium">Status</th>
                        <th class="px-6 py-3 font-medium">Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                @forelse ($absensi as $index => $a)
                    <tr class="border-b border-gray-50 hover:bg-gray-50">
                        <td class="px-6 py-3 text-gray-500">{{ $index + 1 }}</td>
                        <td class="px-6 py-3 font-medium text-gray-800">{{ $a->dataMagang->nama }}</td>
                        <td class="px-6 py-3 text-gray-600">{{ $a->dataMagang->nim }}</td>
                        <td class="px-6 py-3 text-gray-600">{{ $a->dataMagang->tempat_magang }}</td>
                        <td class="px-6 py-3 text-gray-600">{{ \Illuminate\Support\Carbon::parse($a->tanggal)->translatedFormat('d F Y') }}</td>
                        <td class="px-6 py-3">@include('partials.status-badge', ['status' => $a->status])</td>
                        <td class="px-6 py-3 text-gray-600">{{ $a->keterangan ?? '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-10 text-center text-gray-400">Tidak ada data yang cocok dengan filter.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection