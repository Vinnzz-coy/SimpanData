<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Models\Absensi;
use App\Models\Peserta;
use App\Models\User;

class AbsensiDummySeeder extends Seeder
{
    public function run(): void
    {
        $pesertas = Peserta::all();

        if ($pesertas->isEmpty()) {
            return;
        }

        $startDate = Carbon::now()->subMonths(3);
        $endDate = Carbon::now();
        $period = \Carbon\CarbonPeriod::create($startDate, $endDate);

        foreach ($pesertas as $peserta) {
            // Skip Ipin if handled by IpinSeeder (optional, but safer to avoid duplicates if run together)
            if (strtolower($peserta->nama) === 'ipin') {
                continue;
            }

            foreach ($period as $date) {
                if ($date->isWeekend()) {
                    continue;
                }

                // Randomize attendance probability (90% present)
                if (rand(1, 100) > 90) {
                    continue; // Skip this day (Alpha/Sakit/Izin logic could be added here)
                }

                // Generate Masuk
                $jamMasuk = $date->copy()->setTime(rand(7, 8), rand(0, 59), rand(0, 59));
                if ($jamMasuk->hour == 7 && $jamMasuk->minute < 30) {
                    $jamMasuk->addMinutes(30);
                }

                $modeKerja = (rand(1, 10) > 3) ? 'WFO' : 'WFA';

                Absensi::firstOrCreate(
                    [
                        'peserta_id' => $peserta->id,
                        'jenis_absen' => 'Masuk',
                        'waktu_absen' => $jamMasuk->format('Y-m-d H:i:s'), // Use string format for comparison
                    ],
                    [
                        'mode_kerja' => $modeKerja,
                        'status' => 'Hadir',
                        'wa_pengirim' => $peserta->no_telepon,
                    ]
                );

                // Generate Pulang
                $jamPulang = $date->copy()->setTime(rand(16, 17), rand(0, 59), rand(0, 59));
                 if ($jamPulang->hour == 16 && $jamPulang->minute < 30) {
                    $jamPulang->addMinutes(30);
                }

                Absensi::firstOrCreate(
                    [
                        'peserta_id' => $peserta->id,
                        'jenis_absen' => 'Pulang',
                        'waktu_absen' => $jamPulang->format('Y-m-d H:i:s'),
                    ],
                    [
                        'mode_kerja' => $modeKerja,
                        'status' => 'Hadir',
                        'wa_pengirim' => $peserta->no_telepon,
                    ]
                );
            }
        }
    }
}
