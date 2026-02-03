<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Peserta;
use App\Models\Absensi;
use App\Models\Laporan;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class PesertaDummySeeder extends Seeder
{
    public function run(): void
    {
        $kegiatan = ['PKL', 'Magang'];
        $instansi = ['PT Teknologi Maju', 'CV Digital Kreatif', 'Politeknik Negeri', 'Universitas Terbuka', 'SMK Negeri 1'];
        $jurusan = ['Teknik Informatika', 'Sistem Informasi', 'Multimedia', 'RPL', 'DKV'];

        for ($i = 1; $i <= 10; $i++) {
            $jenis = $i <= 5 ? 'PKL' : 'Magang';
            $username = strtolower($jenis) . $i;
            
            // 1. Create User
            $user = User::create([
                'username' => $username,
                'email' => $username . '@gmail.com',
                'password' => Hash::make('password'),
                'role' => 'peserta',
            ]);

            // 2. Create Peserta
            // Start date between 2 to 5 months ago
            $monthsAgo = rand(2, 5);
            $startDate = Carbon::now()->subMonths($monthsAgo)->startOfMonth();
            $endDate = (clone $startDate)->addMonths(6); // 6 months duration

            $peserta = Peserta::create([
                'user_id' => $user->id,
                'nama' => 'Peserta ' . $jenis . ' ' . $i,
                'asal_sekolah_universitas' => $instansi[array_rand($instansi)],
                'jurusan' => $jurusan[array_rand($jurusan)],
                'alamat' => 'Jl. Dummy No. ' . $i,
                'no_telepon' => '0812345678' . $i,
                'jenis_kegiatan' => $jenis,
                'tanggal_mulai' => $startDate,
                'tanggal_selesai' => $endDate,
                'status' => 'Aktif',
            ]);

            // 3. Generate Absensi and Laporan history
            $currentDate = clone $startDate;
            $today = Carbon::today();

            while ($currentDate <= $today) {
                // Skip weekends
                if (!$currentDate->isWeekend()) {
                    // Random attendance (90% chance of being present)
                    if (rand(1, 100) <= 90) {
                        // Absen Masuk
                        Absensi::create([
                            'peserta_id' => $peserta->id,
                            'jenis_absen' => 'Masuk',
                            'waktu_absen' => (clone $currentDate)->setTime(rand(7, 8), rand(0, 59)),
                            'mode_kerja' => 'WFO',
                            'status' => 'Hadir',
                        ]);

                        // Randomly create a report for this day (80% chance if present)
                        if (rand(1, 100) <= 80) {
                            Laporan::create([
                                'peserta_id' => $peserta->id,
                                'judul' => 'Kegiatan Hari ' . $currentDate->format('d M Y'),
                                'deskripsi' => 'Mengerjakan tugas harian dan melakukan koordinasi tim pada tanggal ' . $currentDate->format('d M Y'),
                                'tanggal_laporan' => $currentDate->format('Y-m-d'),
                                'status' => 'Disetujui',
                            ]);
                        }
                    } else {
                        // Occasional Sick or Permission
                        $status = rand(1, 2) == 1 ? 'Sakit' : 'Izin';
                        Absensi::create([
                            'peserta_id' => $peserta->id,
                            'jenis_absen' => 'Masuk',
                            'waktu_absen' => (clone $currentDate)->setTime(8, 0, 0),
                            'status' => $status,
                        ]);
                    }
                }
                $currentDate->addDay();
            }
        }
    }
}
