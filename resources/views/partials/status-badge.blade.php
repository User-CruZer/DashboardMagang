@php
    $classes = [
        'hadir' => 'bg-green-100 text-green-700',
        'izin' => 'bg-amber-100 text-amber-700',
        'sakit' => 'bg-orange-100 text-orange-700',
        'tanpa_keterangan' => 'bg-red-100 text-red-700',
    ][$status] ?? 'bg-gray-100 text-gray-700';
    $labels = [
        'hadir' => 'Hadir',
        'izin' => 'Izin',
        'sakit' => 'Sakit',
        'tanpa_keterangan' => 'Tanpa Keterangan',
    ];
@endphp
<span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $classes }}">
    {{ $labels[$status] ?? ucfirst(str_replace('_', ' ', $status)) }}
</span>