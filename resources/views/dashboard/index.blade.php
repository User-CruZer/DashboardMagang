@extends('dashboard.layouts.app')

@section('title', 'Dashboard')
@section('subtitle', 'Ringkasan absensi magang hari ini')

@section('content')
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-brand-600">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Total Pegawai Magang</p>
                    <p class="mt-2 text-4xl font-bold text-gray-900">{{ $totalMagang }}</p>
                </div>
                <div class="w-12 h-12 rounded-full bg-brand-100 text-brand-600 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                    </svg>
                </div>
            </div>
            <a href="{{ route('data-magang.index') }}" class="mt-4 inline-block text-xs text-brand-600 font-medium hover:underline">Lihat data &rarr;</a>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-green-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Hadir Hari Ini</p>
                    <p class="mt-2 text-4xl font-bold text-green-600">{{ $hadir }}</p>
                </div>
                <div class="w-12 h-12 rounded-full bg-green-100 text-green-600 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <p class="mt-4 text-xs text-gray-400">{{ now()->translatedFormat('l, d F Y') }}</p>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-amber-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Izin / Sakit Hari Ini</p>
                    <p class="mt-2 text-4xl font-bold text-amber-600">{{ $izinSakit }}</p>
                </div>
                <div class="w-12 h-12 rounded-full bg-amber-100 text-amber-600 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                    </svg>
                </div>
            </div>
            <a href="{{ route('absensi.index') }}" class="mt-4 inline-block text-xs text-amber-600 font-medium hover:underline">Detail &rarr;</a>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-red-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Tanpa Keterangan</p>
                    <p class="mt-2 text-4xl font-bold text-red-600">{{ $tanpaKeterangan }}</p>
                </div>
                <div class="w-12 h-12 rounded-full bg-red-100 text-red-600 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                    </svg>
                </div>
            </div>
            <a href="{{ route('absensi.index') }}" class="mt-4 inline-block text-xs text-red-600 font-medium hover:underline">Detail &rarr;</a>
        </div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
        <div class="xl:col-span-2 bg-white rounded-xl shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                <h3 class="font-semibold text-gray-800">Absensi Terbaru</h3>
                <a href="{{ route('absensi.index') }}" class="text-sm text-brand-600 font-medium hover:underline">Lihat semua &rarr;</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="text-left text-gray-500 uppercase text-xs border-b border-gray-100">
                            <th class="px-6 py-3 font-medium">Nama</th>
                            <th class="px-6 py-3 font-medium">Tanggal</th>
                            <th class="px-6 py-3 font-medium">Status</th>
                            <th class="px-6 py-3 font-medium">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse ($recent as $a)
                        <tr class="border-b border-gray-50 hover:bg-gray-50">
                            <td class="px-6 py-3 font-medium text-gray-800">{{ $a->dataMagang->nama }}</td>
                            <td class="px-6 py-3 text-gray-600">{{ \Illuminate\Support\Carbon::parse($a->tanggal)->translatedFormat('d F Y') }}</td>
                            <td class="px-6 py-3">@include('dashboard.partials.status-badge', ['status' => $a->status])</td>
                            <td class="px-6 py-3 text-gray-600">{{ $a->keterangan ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-gray-400">Belum ada catatan absensi.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="space-y-6">
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="font-semibold text-gray-800 mb-4">Hadir Hari Ini</h3>
                <ul class="space-y-2 text-sm">
                    @forelse ($hadirList as $nama)
                        <li class="flex items-center gap-3">
                            <span class="w-2 h-2 rounded-full bg-green-500"></span>
                            <span class="text-gray-700">{{ $nama }}</span>
                        </li>
                    @empty
                        <li class="text-gray-400">Tidak ada data.</li>
                    @endforelse
                </ul>
            </div>
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="font-semibold text-gray-800 mb-4">Izin / Sakit Hari Ini</h3>
                <ul class="space-y-2 text-sm">
                    @forelse ($izinSakitList as $item)
                        <li class="flex items-center gap-3">
                            <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                            <span class="text-gray-700">{{ $item['nama'] }}</span>
                            <span class="text-xs text-gray-400">({{ ucfirst($item['status']) }})</span>
                        </li>
                    @empty
                        <li class="text-gray-400">Tidak ada data.</li>
                    @endforelse
                </ul>
            </div>
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="font-semibold text-gray-800 mb-4">Tanpa Keterangan Hari Ini</h3>
                <ul class="space-y-2 text-sm">
                    @forelse ($tanpaKeteranganList as $nama)
                        <li class="flex items-center gap-3">
                            <span class="w-2 h-2 rounded-full bg-red-500"></span>
                            <span class="text-gray-700">{{ $nama }}</span>
                        </li>
                    @empty
                        <li class="text-gray-400">Tidak ada data.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
@endsection