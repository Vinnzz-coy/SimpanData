<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Peserta;
use App\Models\Absensi;
use App\Models\Laporan;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class KevinSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create/Update User Kevin
        $user = User::updateOrCreate(
            ['email' => 'kevinbatok8@gmail.com'],
            [
                'username' => 'kevin',
                'password' => Hash::make('password'),
                'role' => 'peserta',
            ]
        );

        // 2. Create/Update Peserta Data for Kevin
        $startDate = Carbon::now()->subMonths(3)->startOfMonth();
        $endDate = (clone $startDate)->addMonths(6);

        $peserta = Peserta::updateOrCreate(
            ['user_id' => $user->id],
            [
                'nama' => 'Kevin Nazar',
                'asal_sekolah_universitas' => 'Universitas Indonesia',
                'jurusan' => 'Teknik Informatika',
                'alamat' => 'Jl. Kebon Jeruk No. 12',
                'no_telepon' => '081299887766',
                'jenis_kegiatan' => 'PKL',
                'tanggal_mulai' => $startDate,
                'tanggal_selesai' => $endDate,
                'status' => 'Aktif',
            ]
        );

        // Clear existing attendance and reports for Kevin to avoid duplicates/mess
        $peserta->absensis()->delete();
        $peserta->laporans()->delete();

        // 3. Generate 3 Months of History
        $currentDate = clone $startDate;
        $today = Carbon::today();

        while ($currentDate <= $today) {
            // Skip weekends
            if (!$currentDate->isWeekend()) {
                $chance = rand(1, 100);
                
                // For 'Today', we force 100% presence to test the chart
                $isToday = $currentDate->isToday();

                if ($isToday || $chance <= 92) { 
                    // Clock In (07:00 - 08:30)
                    Absensi::create([
                        'peserta_id' => $peserta->id,
                        'jenis_absen' => 'Masuk',
                        'waktu_absen' => (clone $currentDate)->setTime(rand(7, 8), rand(0, 59)),
                        'mode_kerja' => 'WFO',
                        'status' => 'Hadir',
                    ]);

                    // Clock Out
                    // For logic testing: If it's today, set exactly 18:00
                    $hour = $isToday ? 18 : rand(16, 18);
                    $minute = $isToday ? 0 : rand(0, 59);
                    
                    Absensi::create([
                        'peserta_id' => $peserta->id,
                        'jenis_absen' => 'Pulang',
                        'waktu_absen' => (clone $currentDate)->setTime($hour, $minute),
                        'mode_kerja' => 'WFO',
                        'status' => 'Hadir',
                    ]);

                    // Report
                    if ($isToday || rand(1, 100) <= 85) {
                        Laporan::create([
                            'peserta_id' => $peserta->id,
                            'judul' => 'Monitoring & Evaluasi PKL - ' . $currentDate->format('d/m/Y'),
                            'deskripsi' => 'Melakukan pengujian fitur grafik dashboard dan verifikasi sinkronisasi data real-time pada pukul 18:00.',
                            'tanggal_laporan' => $currentDate->format('Y-m-d'),
                            'status' => 'Disetujui',
                        ]);
                    }
                } elseif ($chance <= 96) { // Sick
                    Absensi::create([
                        'peserta_id' => $peserta->id,
                        'jenis_absen' => 'Masuk',
                        'waktu_absen' => (clone $currentDate)->setTime(8, 0, 0),
                        'status' => 'Sakit',
                    ]);
                } else { // Permission/Izin
                    Absensi::create([
                        'peserta_id' => $peserta->id,
                        'jenis_absen' => 'Masuk',
                        'waktu_absen' => (clone $currentDate)->setTime(8, 0, 0),
                        'status' => 'Izin',
                    ]);
                }
            }
            $currentDate->addDay();
        }
    }
}
