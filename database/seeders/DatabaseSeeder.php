<?php

namespace Database\Seeders;

use App\Models\Absensi;
use App\Models\DataMagang;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $pegawai = [
            ['Ahmad Fauzi', '2101001', 'Teknik Informatika', 'PT Teknologi Nusantara', 'Budi Santoso'],
            ['Bella Kusuma', '2101002', 'Sistem Informasi', 'PT Teknologi Nusantara', 'Siti Rahayu'],
            ['Candra Wijaya', '2101003', 'Manajemen', 'PT Maju Bersama', 'Agus Susanto'],
            ['Dewi Lestari', '2101004', 'Akuntansi', 'PT Maju Bersama', 'Indah Pratiwi'],
            ['Eko Prasetyo', '2101005', 'Teknik Elektro', 'PT Listrik Indonesia', 'Hendra Gunawan'],
            ['Fitri Handayani', '2101006', 'Ilmu Komunikasi', 'PT Media Digital', 'Ratna Sari'],
            ['Gilang Ramadhan', '2101007', 'Manajemen Informatika', 'PT Teknologi Nusantara', 'Budi Santoso'],
            ['Hana Safitri', '2101008', 'Akuntansi', 'PT Maju Bersama', 'Indah Pratiwi'],
            ['Ibrahim Khalil', '2101009', 'Teknik Sipil', 'PT Konstruksi Utama', 'Joko Widodo'],
            ['Jasmine Putri', '2101010', 'Desain Komunikasi Visual', 'PT Kreatif Media', 'Rina Marlina'],
        ];

        $statuses = ['hadir', 'hadir', 'hadir', 'hadir', 'izin', 'sakit', 'tanpa_keterangan'];

        foreach ($pegawai as [$nama, $nim, $prodi, $tempat, $pembimbing]) {
            DataMagang::create([
                'nama' => $nama,
                'nim' => $nim,
                'program_studi' => $prodi,
                'tempat_magang' => $tempat,
                'pembimbing_lapangan' => $pembimbing,
            ]);
        }

        $magang = DataMagang::all();

        for ($i = 29; $i >= 0; $i--) {
            $tanggal = now()->subDays($i)->toDateString();
            $isWeekend = now()->parse($tanggal)->isWeekend();

            foreach ($magang as $m) {
                $status = $statuses[array_rand($statuses)];

                if ($isWeekend && $status === 'hadir') {
                    continue;
                }

                Absensi::create([
                    'data_magang_id' => $m->id,
                    'tanggal' => $tanggal,
                    'status' => $status,
                    'keterangan' => $status === 'hadir' ? null : collect([
                        'Ada urusan keluarga',
                        'Sakit demam',
                        'Pergi ke kampus',
                        'Tidak ada keterangan',
                        'Urusan pribadi',
                        'Ke dokter',
                    ])->random(),
                ]);
            }
        }
    }
}
