@extends('layouts.app')

@section('title', 'Absensi')
@section('subtitle', 'Catat kehadiran pegawai magang')

@section('content')
    <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
        <h3 class="font-semibold text-gray-800 mb-4">Catat Absensi</h3>
        <form method="POST" action="{{ route('absensi.store') }}" class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-5 gap-4">
            @csrf
            <div>
                <label for="data_magang_id" class="block text-sm font-medium text-gray-600 mb-1">Pegawai Magang</label>
                <select id="data_magang_id" name="data_magang_id" required
                        class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500 bg-white">
                    <option value="" disabled selected>Pilih pegawai</option>
                    @foreach ($dataMagang as $m)
                        <option value="{{ $m->id }}">{{ $m->nama }} ({{ $m->nim }})</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="tanggal" class="block text-sm font-medium text-gray-600 mb-1">Tanggal</label>
                <input type="date" id="tanggal" name="tanggal" value="{{ old('tanggal', now()->toDateString()) }}" required
                       class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500">
            </div>
            <div>
                <label for="status" class="block text-sm font-medium text-gray-600 mb-1">Status</label>
                <select id="status" name="status" required
                        class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500 bg-white">
                    <option value="hadir">Hadir</option>
                    <option value="izin">Izin</option>
                    <option value="sakit">Sakit</option>
                    <option value="tanpa_keterangan">Tanpa Keterangan</option>
                </select>
            </div>
            <div>
                <label for="keterangan" class="block text-sm font-medium text-gray-600 mb-1">Keterangan</label>
                <input type="text" id="keterangan" name="keterangan"
                       class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500" placeholder="Opsional">
            </div>
            <div class="flex items-end">
                <button type="submit"
                        class="w-full bg-brand-600 hover:bg-brand-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition flex items-center justify-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    Simpan
                </button>
            </div>
        </form>
    </div>

    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 flex flex-wrap items-center justify-between gap-4">
            <h3 class="font-semibold text-gray-800">Riwayat Absensi</h3>
            <form method="GET" action="{{ route('absensi.index') }}" class="flex items-center gap-2">
                <select name="tanggal" onchange="this.form.submit()"
                        class="border border-gray-200 rounded-lg px-3 py-2 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-brand-500">
                    <option value="">Semua tanggal</option>
                    @foreach ($tanggalList as $t)
                        <option value="{{ $t }}" @selected($tanggal == $t)>{{ \Illuminate\Support\Carbon::parse($t)->translatedFormat('d F Y') }}</option>
                    @endforeach
                </select>
                @if ($tanggal)
                    <a href="{{ route('absensi.index') }}" class="text-sm text-brand-600 hover:underline">Reset</a>
                @endif
            </form>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-gray-500 uppercase text-xs border-b border-gray-100">
                        <th class="px-6 py-3 font-medium">No</th>
                        <th class="px-6 py-3 font-medium">Nama</th>
                        <th class="px-6 py-3 font-medium">NIM</th>
                        <th class="px-6 py-3 font-medium">Tanggal</th>
                        <th class="px-6 py-3 font-medium">Status</th>
                        <th class="px-6 py-3 font-medium">Keterangan</th>
                        <th class="px-6 py-3 font-medium text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @forelse ($absensi as $index => $a)
                    <tr class="border-b border-gray-50 hover:bg-gray-50">
                        <td class="px-6 py-3 text-gray-500">{{ $index + 1 }}</td>
                        <td class="px-6 py-3 font-medium text-gray-800">{{ $a->dataMagang->nama }}</td>
                        <td class="px-6 py-3 text-gray-600">{{ $a->dataMagang->nim }}</td>
                        <td class="px-6 py-3 text-gray-600">{{ \Illuminate\Support\Carbon::parse($a->tanggal)->translatedFormat('d F Y') }}</td>
                        <td class="px-6 py-3">@include('partials.status-badge', ['status' => $a->status])</td>
                        <td class="px-6 py-3 text-gray-600">{{ $a->keterangan ?? '-' }}</td>
                        <td class="px-6 py-3 text-right">
                            <form method="POST" action="{{ route('absensi.destroy', $a) }}"
                                  onsubmit="return confirm('Hapus catatan absensi ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="inline-flex items-center gap-1 text-red-600 hover:text-red-800 font-medium text-xs">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                    </svg>
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-10 text-center text-gray-400">Belum ada catatan absensi.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection