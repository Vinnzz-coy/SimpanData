<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Peserta;
use App\Models\Absensi;
use App\Models\Feedback;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class ParticipantSeeder extends Seeder
{
    public function run(): void
    {
        $currentMagang = Peserta::where('jenis_kegiatan', 'Magang')->count();
        $currentPKL = Peserta::where('jenis_kegiatan', 'PKL')->count();

        $neededMagang = max(0, 59 - $currentMagang);
        $neededPKL = max(0, 15 - $currentPKL);

        $this->command->info("Seeding $neededMagang Magang and $neededPKL PKL participants...");

        $this->seedParticipants('Magang', $neededMagang);
        $this->seedParticipants('PKL', $neededPKL);

        $this->command->info('Participant data seeding completed!');
    }

    private function seedParticipants(string $type, int $count): void
    {
        for ($i = 0; $i < $count; $i++) {

            $baseUsername = strtolower($type) . '_' . ($i + 1);
            $username = $baseUsername;

            while (User::where('username', $username)->exists()) {
                $username = $baseUsername . '_' . rand(1000, 9999);
            }

            $user = User::create([
                'username' => $username,
                'email' => $username . '@example.com',
                'password' => Hash::make('password123'),
                'role' => 'peserta',
            ]);

            $peserta = Peserta::create([
                'user_id' => $user->id,
                'nama' => fake()->name(),
                'asal_sekolah_universitas' => fake()->company() . ' ' .
                    fake()->randomElement(['University', 'School', 'College']),
                'jurusan' => fake()->randomElement([
                    'Teknik Informatika',
                    'Sistem Informasi',
                    'Desain Komunikasi Visual',
                    'Akuntansi'
                ]),
                'alamat' => fake()->address(),
                'no_telepon' => '08' . rand(1111111111, 9999999999),
                'jenis_kegiatan' => $type,
                'tanggal_mulai' => Carbon::now()->subMonths(4),
                'tanggal_selesai' => Carbon::now()->addMonths(2),
                'status' => 'Aktif',
            ]);

            $this->seedAttendance($peserta);
            $this->seedFeedback($peserta);
        }
    }

    private function seedAttendance(Peserta $peserta): void
    {
        $startDate = Carbon::now()->subMonths(3);
        $endDate = Carbon::now();
        $period = CarbonPeriod::create($startDate, $endDate);

        foreach ($period as $date) {

            if ($date->isWeekend()) continue;

            // 90% kemungkinan hadir
            if (rand(1, 100) > 10) {

                $status = rand(1, 100) <= 5
                    ? fake()->randomElement(['Izin', 'Sakit'])
                    : 'Hadir';

                $modeKerja = rand(1, 100) <= 75 ? 'WFO' : 'WFA';

                if ($status === 'Hadir') {

                    // Masuk 08:30–08:50
                    $jamMasuk = Carbon::createFromTime(8, 30)
                        ->addMinutes(rand(0, 20));

                    // Pulang 16:45–17:30
                    $jamPulang = Carbon::createFromTime(16, 45)
                        ->addMinutes(rand(0, 45));

                    Absensi::create([
                        'peserta_id' => $peserta->id,
                        'jenis_absen' => 'Masuk',
                        'waktu_absen' => $date->copy()->setTime(
                            $jamMasuk->hour,
                            $jamMasuk->minute
                        ),
                        'mode_kerja' => $modeKerja,
                        'status' => 'Hadir',
                        'wa_pengirim' => $peserta->no_telepon,
                    ]);

                    Absensi::create([
                        'peserta_id' => $peserta->id,
                        'jenis_absen' => 'Pulang',
                        'waktu_absen' => $date->copy()->setTime(
                            $jamPulang->hour,
                            $jamPulang->minute
                        ),
                        'mode_kerja' => $modeKerja,
                        'status' => 'Hadir',
                        'wa_pengirim' => $peserta->no_telepon,
                    ]);
                } else {
                    // Izin / Sakit (tanpa pulang)
                    Absensi::create([
                        'peserta_id' => $peserta->id,
                        'jenis_absen' => 'Masuk',
                        'waktu_absen' => $date->copy()->setTime(8, rand(30, 50)),
                        'mode_kerja' => $modeKerja,
                        'status' => $status,
                        'wa_pengirim' => $peserta->no_telepon,
                    ]);
                }
            }
        }
    }

    private function seedFeedback(Peserta $peserta): void
    {
        // Tidak semua peserta memberi feedback
        if (rand(1, 100) > 60) return;

        $count = rand(1, 2);

        for ($j = 0; $j < $count; $j++) {

            $pengirim = fake()->randomElement(['Peserta', 'Admin']);

            Feedback::create([
                'peserta_id' => $peserta->id,
                'pengirim' => $pengirim,

                'pesan' => $pengirim === 'Peserta'
                    ? fake()->randomElement([
                        'Terima kasih atas bimbingannya hari ini.',
                        'Materi yang diberikan sangat membantu.',
                        'Saya merasa progres saya meningkat minggu ini.',
                        'Mohon arahan tambahan untuk tugas berikutnya.'
                    ])
                    : fake()->randomElement([
                        'Kinerja cukup baik, pertahankan.',
                        'Perlu lebih disiplin dalam pengumpulan tugas.',
                        'Sudah menunjukkan peningkatan signifikan.',
                        'Komunikasi dengan tim perlu ditingkatkan.'
                    ]),

                'tampilkan' => rand(1, 100) <= 40,
                'rating' => $pengirim === 'Peserta' ? rand(3, 5) : null,
                'dibaca' => rand(1, 100) <= 70,
            ]);
        }
    }
}
